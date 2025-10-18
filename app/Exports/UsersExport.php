<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Events\AfterSheet;

class UsersExport implements FromView, WithStyles, WithEvents, WithColumnWidths
{
    public function view(): View
    {
        $this->users = $this->getExportUserData();
        return view('admin.export-excel', ['users' => $this->users]);
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->users) + 1;
        $range = "A1:G{$lastRow}";
    
        $sheet->getStyle($range)->getAlignment()->setWrapText(true);
        $sheet->getStyle($range)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = count($this->users) + 1; // +1 untuk header
                $range = "A1:G{$lastRow}";
    
                // Border untuk semua data + header
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle($range)->applyFromArray($styleArray);
    
                // Header style (baris 1 saja)
                $event->sheet->getDelegate()->getStyle("A1:G1")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'CCCCCC'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);
            },
        ];
    }


    public function columnWidths(): array
    {
        return [
            'A' => 8,    // No
            'B' => 35,   // Users Detail
            'C' => 35,   // Quality Info
            'D' => 35,   // Recharge Info
            'E' => 35,   // Boost Info
            'F' => 35,   // Register Info
            'G' => 35,   // Workdays
        ];
    }


    private function getExportUserData()
    {
        $users = DB::table('users')
            ->select('id', 'uid', 'name', 'phone_email', 'email_only', 'password', 'referral', 'referral_upline', 'profile', 'status', 'level', 'membership', 'credibility', 'network_address', 'currency', 'wallet_address', 'ip_address', 'position_set', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc')
            ->get();
    
        $today = now()->toDateString();
    
        $users->transform(function ($user) use ($today) {
            // Finance
            $user->finance = DB::table('finance_users')
                ->where('id_users', $user->id)
                ->select('saldo', 'saldo_beku', 'saldo_misi', 'komisi', 'withdrawal_password', 'updated_at')
                ->first();
    
            // Combination
            $user->combination = DB::table('combination_users')
                ->where('id_users', $user->id)
                ->select('id_produk', 'sequence', 'set_boost')
                ->get();
    
            $user->combination_product = DB::table('combination_users')
                ->where('id_users', $user->id)
                ->pluck('id_produk')
                ->toArray();
    
            $user->combination_data = DB::table('combination_users')
                ->where('id_users', $user->id)
                ->select('id_produk', 'sequence', 'set_boost')
                ->first();
    
            // Upline
            $user->upline_name = DB::table('users')
                ->where('referral', $user->referral_upline)
                ->value('name');
    
            // Downlines
            $user->downlines = DB::table('users')
                ->where('referral_upline', $user->referral)
                ->select('name')
                ->get();
    
            // Deposit & Withdraw
            $user->deposit_count = DB::table('deposit_users')
                ->where('id_users', $user->id)
                ->count();
    
            $user->deposit_total = DB::table('deposit_users')
                ->where('id_users', $user->id)
                ->sum('amount');
    
            $user->withdrawal_count = DB::table('withdrawal_users')
                ->where('id_users', $user->id)
                ->count();
    
            $user->withdrawal_total = DB::table('withdrawal_users')
                ->where('id_users', $user->id)
                ->sum('amount');
    
            // Product ID terakhir
            $user->latest_product_id = DB::table('transactions_users')
                ->where('id_users', $user->id)
                ->orderByDesc('created_at')
                ->value('id_products');
    
            // Status combination
            $user->has_combination = DB::table('combination_users')
                ->where('id_users', $user->id)
                ->exists();
    
            // Absensi
            $user->absen_user = DB::table('absen_users')
                ->where('id_users', $user->id)
                ->get();
    
            // Task Progress
            $limitMap = [
                'Normal' => 40,
                'Gold' => 50,
                'Platinum' => 55,
                'Crown' => 55,
            ];
    
            $membership = $user->membership;
            $positionSet = $user->position_set;
            $taskLimit = $limitMap[$membership] ?? 0;
    
            $taskDone = DB::table('transactions_users')
                ->where('id_users', $user->id)
                ->where('set', $positionSet)
                ->where('status', 0)
                ->whereDate('created_at', $today)
                ->count();
    
            $user->task_done = $taskDone;
            $user->task_remaining = $taskLimit - $taskDone;
            $user->task_limit = $taskLimit;
    
            return $user;
        });
    
        return $users;
    }

}
