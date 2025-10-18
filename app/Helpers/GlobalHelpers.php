<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getPendingWithdrawals')) {
    function getPendingWithdrawals()
    {
        return DB::table('withdrawal_users')
            ->join('users', 'withdrawal_users.id_users', '=', 'users.id')
            ->select(
                'withdrawal_users.*',
                'users.name as user_name',
                'withdrawal_users.created_at'
            )
            ->where('withdrawal_users.baca', 0)
            ->orderBy('withdrawal_users.created_at', 'desc')
            ->get();
    }
}

if (!function_exists('getPendingWithdrawalsCount')) {
    function getPendingWithdrawalsCount()
    {
        return DB::table('withdrawal_users')->where('baca', 0)->count();
    }
}