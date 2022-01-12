<?php

namespace App\Repositories\Ref;

use App\Holiday;
use Cache;

/**
 * Class OrgHolidayRepository
 * @package App\Repositories\Ref
 */
class OrgHolidayRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'holiday_name',
        'holiday_date',
        'work_code',
        'repeat_yearly',
        'state_code',
    ];

    /**
     * Configure the Model
     * @return string
     **/
    public function model()
    {
        return Holiday::class;
    }

    // /**
    //  * @return mixed
    //  */
    // public static function getAll()
    // {
    //     return Cache::remember('org_holiday:all', 1, function () {
    //         return Holiday::all();
    //     });
    // }

    /**
     * @param $holidayDate
     * @param $workCode
     * @param $repeatYearly
     * @param $stateCode
     * @return Holiday[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function getDataModel($holidayDate, $workCode, $repeatYearly, $stateCode)
    {
        $datas = new Holiday;

        if ($workCode) {
            $datas = $datas->where('work_code', $workCode);
        }

        switch ($repeatYearly) {
            case '1':
                $datas = $datas->where('repeat_yearly', $repeatYearly);

                if ($holidayDate) {
                    $datas = $datas->whereRaw('(DATE_FORMAT(holiday_date,"%m-%d")) = "' . date('m-d', strtotime($holidayDate)) . '"');
                }

                break;

            default:
                $datas = $datas->where('repeat_yearly', $repeatYearly);

                if ($holidayDate) {
                    $datas = $datas->whereDate('holiday_date', date('Y-m-d', strtotime($holidayDate)));
                }

                break;
        }

        if ($stateCode) {
            $datas = $datas->where('state_code', $stateCode);
        }

        $datas = $datas->get();

        return $datas;
    }

    /**
     * @param $holidayDate
     * @param $workCode
     * @param $repeatYearly
     * @param $stateCode
     * @return mixed
     */
    public static function getDataCache($holidayDate, $workCode, $repeatYearly, $stateCode)
    {
        return Cache::remember(
            'org_holiday:holiday_date:' . $holidayDate . ',work_code:' . $workCode . ',repeat_yearly:' . $repeatYearly . ',state_code:' . $stateCode,
            1,
            function () use ($holidayDate, $workCode, $repeatYearly, $stateCode) {
                return static::getDataModel($holidayDate, $workCode, $repeatYearly, $stateCode);
            }
        );
    }
}