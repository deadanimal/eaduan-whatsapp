<?php

namespace App\Repositories\Ref;

use App\Ref;
use Cache;

/**
 * Class RefRepository
 * @package App\Repositories\Ref
 */
class RefRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Ref::class;
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return Cache::remember('ref:all', 1, function () {
            return Ref::all();
        });
    }

    /**
     * @param string $cat category
     * @param string $sort sort
     * @param string $lang language
     * @return \Illuminate\Support\Collection
     */
    public static function getList($cat = '', $sort = 'sort', $lang = 'ms')
    {
        $data = self::getAll();

        $data = $data->where('status', '1')->where('cat', $cat)->sortBy($sort);

        $list = $data->mapWithKeys(function ($item) {
            return [$item['code'] => $item['descr']];
        });

        return $list;
    }

    /**
     * @param string $cat category
     * @param string $code code
     * @param string $lang language
     * @return string
     */
    public static function getDescr($cat, $code, $lang = 'ms')
    {
        $data = self::getAll();

        $data = $data->where('status', '1')
            ->where('cat', $cat)
            ->where('code', $code)
            ->first();

        if($data) {
            return $lang == 'ms' ? $data->descr : $data->descr_en;
        } else {
            return '';
        }
    }
}
