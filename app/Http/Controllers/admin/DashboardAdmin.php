<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DashboardExport;

class DashboardAdmin extends Controller
{

    public function index()
    {
        $today = Carbon::today();

        $totalUsers         = DB::table('users')->count();
        $totalDeposits      = DB::table('deposit_users')->sum('amount');
        $totalWithdrawals   = DB::table('withdrawal_users')->sum('amount');
        $totalProducts      = DB::table('products')->count();
        $totalTransactions  = DB::table('transactions_users')->count();

        $todayUsers = DB::table('users')
            ->whereDate('created_at', $today)
            ->count();

        $todayWithdrawals = DB::table('withdrawal_users')
            ->whereDate('created_at', $today)
            ->sum('amount');

        $todayDeposits = DB::table('deposit_users')
            ->whereDate('created_at', $today)
            ->sum('amount');

        // ===== Bonus (harian) dari deposit_users
        $todayBonus = DB::table('deposit_users')
            ->where('category_deposit', 'Bonus')
            ->whereDate('created_at', $today)
            ->sum('amount');

        // ===== Tambahkan akumulasi dari registered_bonus (harian)
        $todayRegisteredBonus = DB::table('registered_bonus')
            ->whereDate('created_at', $today)
            ->sum('total_bonus');

        $todayBonus += $todayRegisteredBonus;

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        $monthlyUsers = DB::table('users')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $monthlyWithdrawals = DB::table('withdrawal_users')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthlyDeposits = DB::table('deposit_users')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // ===== Bonus (bulanan) dari deposit_users
        $monthlyBonus = DB::table('deposit_users')
            ->where('category_deposit', 'Bonus')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // ===== Tambahkan akumulasi dari registered_bonus (bulanan)
        $monthlyRegisteredBonus = DB::table('registered_bonus')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total_bonus');

        $monthlyBonus += $monthlyRegisteredBonus;

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDeposits',
            'totalWithdrawals',
            'totalProducts',
            'totalTransactions',
            'todayUsers',
            'todayWithdrawals',
            'todayDeposits',
            'todayBonus',
            'monthlyUsers',
            'monthlyWithdrawals',
            'monthlyDeposits',
            'monthlyBonus'
        ));
    }

    
    public function exportDashboardExcel(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        return Excel::download(new DashboardExport($year, $month), 'dashboard-data.xlsx');
    }

}