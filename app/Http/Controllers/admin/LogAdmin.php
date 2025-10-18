<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LogAdmin extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('log_admin')
            ->select('id', 'keterangan', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc');

        // Filter tanggal
        if ($request->has(['start_date', 'end_date']) && $request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $perPage = $request->input('per_page', 10); // default 10
        $logs = $query->paginate($perPage)->withQueryString();

        return view('admin.log-admin', compact('logs'));
    }
}