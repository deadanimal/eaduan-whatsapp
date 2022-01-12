<?php

namespace App\Repositories;

use App\User;
use Cache;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository
{
    /**
     * Configure the Model
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Get an item from the cache, or store the default value.
     * @return mixed
     */
    public static function getAll()
    {
        return Cache::remember('users:all', 1, function () {
            return User::all();
        });
    }

    /**
     * Form select list
     * @param string $user_cat User Category: 1 = Internal, 2 = Public
     * @param string $status Status: 1 = Active, 0 = Inactive
     * @param string $state State Code
     * @param string $branch Branch Code
     * @param bool $isLimitByState
     * @param bool $isLimitByBranch
     * @return \Illuminate\Support\Collection
     */
    public static function getList(
        $user_cat = '1', $status = '1', $state, $branch, $isLimitByState = false, $isLimitByBranch = false
    ) {
        $user = auth()->user();

        $users = self::getAll();

        $users = $users->where('user_cat', $user_cat)->where('status', $status);

        if(!empty($state)) {
            $users = $users->where('state_cd', $state);
        } else if(!empty($user->state_cd) && $isLimitByState) {
            $users = $users->where('state_cd', $user->state_cd);
        }

        if(!empty($branch)) {
            $users = $users->where('brn_cd', $branch);
        } else if(!empty($user->brn_cd) && $isLimitByBranch) {
            $users = $users->where('brn_cd', $user->brn_cd);
        }

        $list = $users->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        });

        return $list;
    }
}
