<?php

namespace App\Repositories\Cases;

use App\Aduan\AdminCaseDetail;
use App\Branch;
use App\Repositories\CalculateDurationRepository;
use App\Repositories\ConsumerComplaint\CaseInfoRepository;
use Cache;
use Carbon\Carbon;

/**
 * Class CaseDetailRepository
 * @package App\Repositories\Cases
 */
class CaseDetailRepository
{
    /**
     * Configure the Model
     * @return string
     */
    public function model()
    {
        return AdminCaseDetail::class;
    }

    // /**
    //  * @return mixed
    //  */
    // public static function getAll()
    // {
    //     return Cache::remember('case_detail:all', 1, function () {
    //         return AdminCaseDetail::all();
    //     });
    // }

    /**
     * Get case detail data by case id.
     * @param $caseId
     * @return mixed
     */
    public static function getData($caseId)
    {
        return Cache::remember('case_detail:'.$caseId, 1, function () use ($caseId) {
            return AdminCaseDetail::where('CD_CASEID', $caseId)->get();
        });
    }

    /**
     * Get case detail current data by case id.
     * @param $caseId
     * @return mixed
     */
    public static function getDataCurrent($caseId)
    {
        $data = static::getData($caseId);

        $dataFiltered = $data->where('CD_CURSTS', '1');

        return $dataFiltered->first();
    }

    /**
     * Get case detail previous data by case id and datetime.
     * @param $caseId
     * @param $dateTime
     * @return mixed
     */
    public static function getDataPrevious($caseId, $dateTime)
    {
        $data = static::getData($caseId);

        $dateTimeCarbon = Carbon::parse($dateTime);
        $dateTimeString = $dateTimeCarbon->toDateTimeString();

        $dataFiltered = $data->where('CD_CREDT', '<', $dateTimeString);

        $dataSorted = $dataFiltered->sortByDesc('CD_CREDT');

        return $dataSorted->first();
    }

    /**
     * @param $caseId
     * @return int
     */
    public static function calculate($caseId)
    {
        $data = static::getData($caseId);

        $count = 0;

        $dataCaseInfo = CaseInfoRepository::getOne($caseId);
        $branch = Branch::where('BR_BRNCD', $dataCaseInfo->CA_BRNCD)->first();
        $state = $branch->BR_STATECD;

        foreach ($data as $key => $value) {
            if (in_array($value->CD_INVSTS, ['10','11','12'])) {
                continue;
            }

            if (in_array($value->CD_INVSTS, ['1'])) {
                $count = 0;
                // continue;
            }

            if (in_array($value->CD_INVSTS, ['0','2','3','4','5','6','7','8','9'])) {
                $dataPrevious = static::getDataPrevious($caseId, $value->CD_CREDT);
                if ($dataPrevious && in_array($dataPrevious->CD_INVSTS, ['0','1','2'])) {
                    $calculate = CalculateDurationRepository::calculate($dataPrevious->CD_CREDT, $value->CD_CREDT, $isWorkingDay = true, $state);
                    $count += $calculate;
                    // continue;
                }
            }

            if ($value->CD_CURSTS == '1' && in_array($value->CD_INVSTS, ['0','1','2'])) {
                $today = Carbon::today();
                $todayDateString = $today->toDateString();

                $calculate = CalculateDurationRepository::calculate($value->CD_CREDT, $todayDateString, $isWorkingDay = true, $state);
                $count += $calculate;
            }
        }

        return $count;
    }

    /**
     * @param $caseId
     * @return int
     */
    public static function calculateCurrentPeriod($caseId)
    {
        $count = 0;

        $dataCurrent = static::getDataCurrent($caseId);

        if (!$dataCurrent) {
            return $count;
        }

        if ($dataCurrent && in_array($dataCurrent->CD_INVSTS, ['0','1','2'])) {
            $today = Carbon::today();
            $todayDateString = $today->toDateString();

            $dataCaseInfo = CaseInfoRepository::getOne($caseId);
            $branch = Branch::where('BR_BRNCD', $dataCaseInfo->CA_BRNCD)->first();
            $state = $branch->BR_STATECD;

            $calculate = CalculateDurationRepository::calculate($dataCurrent->CD_CREDT, $todayDateString, $isWorkingDay = true, $state);
            $count += $calculate;
        }

        return $count;
    }
}