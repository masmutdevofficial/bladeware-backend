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
    protected $year, $month;

    public function __construct($year = null, $month = null)
    {
        $this->year = $year;
        $this->month = $month; // numeric 1-12
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
    // Filters: prioritize year -> month
    $filter_year = $this->year ?: now()->year;
    $filter_month = $this->month ? (int)$this->month : null; // 1..12

        // Query wrapper
        $userQuery = DB::table('users');
        $depositQuery = DB::table('deposit_users');
        $withdrawalQuery = DB::table('withdrawal_users');
        $transactionQuery = DB::table('transactions_users');

        // Apply filters
        // Always constrain by year
        if ($filter_year) {
            $userQuery->whereYear('created_at', $filter_year);
            $depositQuery->whereYear('created_at', $filter_year);
            $withdrawalQuery->whereYear('created_at', $filter_year);
            $transactionQuery->whereYear('created_at', $filter_year);
        }

        // Constrain by month if provided
        if ($filter_month) {
            $userQuery->whereMonth('created_at', $filter_month);
            $depositQuery->whereMonth('created_at', $filter_month);
            $withdrawalQuery->whereMonth('created_at', $filter_month);
            $transactionQuery->whereMonth('created_at', $filter_month);
        }

        // No week filter

        // Final counts/sums
        return view('admin.export-dashboard', [
            'totalUsers' => $userQuery->count(),
            'totalProducts' => DB::table('products')->count(), // tidak dipengaruhi waktu
            'totalDeposits' => (clone $depositQuery)->sum('amount'),
            'totalWithdrawals' => (clone $withdrawalQuery)->sum('amount'),
            'totalTransactions' => $transactionQuery->count(),

            // For export view informational labels
            'filter_year' => $filter_year,
            'filter_month' => $filter_month,
        ]);
    }
}