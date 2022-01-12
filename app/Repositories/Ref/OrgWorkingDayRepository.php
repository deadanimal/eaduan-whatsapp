<?php

namespace App\Repositories\Ref;

use App\Wd;
use Cache;

/**
 * Class OrgWorkingDayRepository
 * @package App\Repositories\Ref
 */
class OrgWorkingDayRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'work_day',
        'work_code',
        'state_code',
    ];

    /**
     * Configure the Model
     * @return string
     **/
    public function model()
    {
        return Wd::class;
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return Cache::remember('org_working_day:all', 1, function () {
            return Wd::all();
        });
    }

    /**
     * @param $workCode
     * @param $stateCode
     * @return mixed
     */
    public static function getData($workCode, $stateCode)
    {
        $datas = self::getAll();

        if ($workCode) {
            $datas = $datas->where('work_code', $workCode);
        }

        if ($stateCode) {
            $datas = $datas->where('state_code', $stateCode);
        }

        return $datas;
    }

    /**
     * @param $datas
     * @return array
     */
    public static function getDataAsArray($datas)
    {
        $array = [];

        foreach ($datas as $key => $data) {
            // dapatkan hari cuti dalam seminggu
            $day = $data->work_day;

            if ($day == 0) {
                // kalau hari cuti tiada, seminggu kerja 7 hari
                $workDay = 7;
            } else {
                // hari yang cuti
                $workDay = $day;
            }

            // array yang simpan cuti
            $array[] = $workDay;
        }

        return $array;
    }

    /**
     * @param string $workCode
     * @param string $stateCode
     * @return array
     */
    public static function getDayAsArray($workCode = '03', $stateCode = '16')
    {
        $datas = self::getData($workCode, $stateCode);

        $array = self::getDataAsArray($datas);

        return $array;
    }
}
