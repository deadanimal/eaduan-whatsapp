<?php

namespace App\Repositories;

use App\Repositories\Ref\OrgHolidayRepository;
use App\Repositories\Ref\OrgWorkingDayRepository;
use Carbon\Carbon;

/**
 * Class CalculateDurationRepository
 * @package App\Repositories
 */
class CalculateDurationRepository
{
    /**
     * @param $date
     * @param $stateCode
     * @return bool
     */
    public static function isOffDay($date, $stateCode)
    {
        $dateObject = Carbon::parse($date);
        $dateDayCode = $dateObject->format('N');
        $dateString = $dateObject->toDateString();

        $offDayArray = OrgWorkingDayRepository::getDayAsArray('03', $stateCode);
        if (in_array($dateDayCode, $offDayArray)) {
            return true;
        }

        $repeatedOffDays = OrgHolidayRepository::getDataCache($dateString, '03', '1', $stateCode);
        $repeatedOffDayCount = $repeatedOffDays->count();
        if ($repeatedOffDayCount > 0) {
            return true;
        }

        $currentOffDays = OrgHolidayRepository::getDataCache($dateString, '03', '2', $stateCode);
        $currentOffDayCount = $currentOffDays->count();
        if ($currentOffDayCount > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param bool $isWorkingDay
     * @param $stateCode
     * @return int
     */
    public static function calculate($startDate, $endDate, $isWorkingDay = false, $stateCode)
    {
        $startDateCarbon = Carbon::parse($startDate);
        $endDateCarbon = Carbon::parse($endDate);

        // if ($startDateCarbon->greaterThan($endDateCarbon)) {
        if ($startDateCarbon->greaterThanOrEqualTo($endDateCarbon)) {
            return 0;
        }

        if ($startDateCarbon->isSameDay($endDateCarbon)) {
            return 0;
        }

        if ($isWorkingDay === false) {
            return $startDateCarbon->diffInDays($endDateCarbon);
        }

        $startDateCarbonCopy = $startDateCarbon->copy();
        $count = 0;

        // while ($startDateCarbonCopy->lessThanOrEqualTo($endDateCarbon)) {
        while ($startDateCarbonCopy->lessThan($endDateCarbon)) {
            $startDateCarbonCopy->addDay();

            $isOffDay = static::isOffDay($startDateCarbonCopy->toDateString(), $stateCode);
            if ($isOffDay === false) {
                $count += 1;
            }
        }

        return $count;
    }
}