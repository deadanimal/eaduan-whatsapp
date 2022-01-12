<?php

namespace App\Repositories;

use App\Branch;
use Cache;

/**
 * Class BranchRepository
 * @package App\Repositories
 */
class BranchRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Branch::class;
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return Cache::remember('branch:all', 1, function () {
            return Branch::all();
        });
    }

    /**
     * @param string $code branch code
     * @return string
     */
    public static function getName($code = null)
    {
        $data = self::getAll();

        $data = $data->first(function ($value, $key) use ($code) {
            return $value->BR_BRNCD === $code;
            // return str_contains($value->BR_BRNCD, $code);
        });

        return $data->BR_BRNNM ?? '';
    }
}
