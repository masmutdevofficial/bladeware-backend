<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DashboardExport implements FromView, WithStyles, WithColumnWidths
{
    protected $date, $month, $year;

    public function __construct($date, $month, $year)
    {
        $this->date = $date;
        $this->month = $month;
        $this->year = $year;
    }
    
    public function styles(Worksheet $sheet)
    {
        $lastRow = 8; // total baris (judul + 6 data + 1 filter)
        $sheet->getStyle("A1:B{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                'wrapText' => true,
            ],
        ]);
    }
    
    public function columnWidths(): array
    {
        return [
            'A' => 25, // Label
            'B' => 40, // Nilai
        ];
    }

    public function view(): View
    {
        // Filter default
        $filter_date = $this->date ? Carbon::parse($this->date) : null;
        $filter_month = $this->month ? Carbon::parse($this->month) : null;
        $filter_year = $this->year;

        // Query wrapper
        $userQuery = DB::table('users');
        $depositQuery = DB::table('deposit_users');
        $withdrawalQuery = DB::table('withdrawal_users');
        $transactionQuery = DB::table('transactions_users');

        // Apply filters
        if ($filter_date) {
            $userQuery->whereDate('created_at', $filter_date);
            $depositQuery->whereDate('created_at', $filter_date);
            $withdrawalQuery->whereDate('created_at', $filter_date);
            $transactionQuery->whereDate('created_at', $filter_date);
        }

        if ($filter_month) {
            $userQuery->whereMonth('created_at', $filter_month->month)
                      ->whereYear('created_at', $filter_month->year);
            $depositQuery->whereMonth('created_at', $filter_month->month)
                         ->whereYear('created_at', $filter_month->year);
            $withdrawalQuery->whereMonth('created_at', $filter_month->month)
                            ->whereYear('created_at', $filter_month->year);
            $transactionQuery->whereMonth('created_at', $filter_month->month)
                             ->whereYear('created_at', $filter_month->year);
        }

        if ($filter_year) {
            $userQuery->whereYear('created_at', $filter_year);
            $depositQuery->whereYear('created_at', $filter_year);
            $withdrawalQuery->whereYear('created_at', $filter_year);
            $transactionQuery->whereYear('created_at', $filter_year);
        }

        // Final counts/sums
        return view('admin.export-dashboard', [
            'totalUsers' => $userQuery->count(),
            'totalProducts' => DB::table('products')->count(), // tidak dipengaruhi waktu
            'totalDeposits' => (clone $depositQuery)->sum('amount'),
            'totalWithdrawals' => (clone $withdrawalQuery)->sum('amount'),
            'totalTransactions' => $transactionQuery->count(),

            'todayUsers' => $filter_date ? DB::table('users')->whereDate('created_at', $filter_date)->count() : 0,
            'todayDeposits' => $filter_date ? DB::table('deposit_users')->whereDate('created_at', $filter_date)->sum('amount') : 0,
            'todayWithdrawals' => $filter_date ? DB::table('withdrawal_users')->whereDate('created_at', $filter_date)->sum('amount') : 0,
            'todayBonus' => $filter_date ? DB::table('deposit_users')->where('category_deposit', 'Bonus')->whereDate('created_at', $filter_date)->sum('amount') : 0,

            'monthlyUsers' => $filter_month ? DB::table('users')->whereMonth('created_at', $filter_month->month)->whereYear('created_at', $filter_month->year)->count() : 0,
            'monthlyDeposits' => $filter_month ? DB::table('deposit_users')->whereMonth('created_at', $filter_month->month)->whereYear('created_at', $filter_month->year)->sum('amount') : 0,
            'monthlyWithdrawals' => $filter_month ? DB::table('withdrawal_users')->whereMonth('created_at', $filter_month->month)->whereYear('created_at', $filter_month->year)->sum('amount') : 0,
            'monthlyBonus' => $filter_month ? DB::table('deposit_users')->where('category_deposit', 'Bonus')->whereMonth('created_at', $filter_month->month)->whereYear('created_at', $filter_month->year)->sum('amount') : 0,

            'filter_date' => $this->date,
            'filter_month' => $this->month,
            'filter_year' => $this->year,
        ]);
    }
}