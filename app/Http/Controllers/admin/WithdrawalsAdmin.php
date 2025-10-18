<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class WithdrawalsAdmin extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('withdrawal_users')
            ->join('users', 'withdrawal_users.id_users', '=', 'users.id')
            ->select('withdrawal_users.*', 'users.name')
            ->orderBy('withdrawal_users.created_at', 'desc');
            
        // Filter tanggal
        if ($request->has(['start_date', 'end_date']) && $request->start_date && $request->end_date) {
            $query->whereBetween('withdrawal_users.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }
    
        if ($request->has('search') && $request->search !== null) {
            $keyword = '%' . $request->search . '%';
            $query->where('users.name', 'like', $keyword);
        }
    
        $perPage = $request->input('per_page', 10); // default 10
        $withdrawals = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
        $dataUser = DB::table('users')->select('id', 'name')->get();
    
        return view('admin.withdrawals', compact('withdrawals', 'dataUser'));
    }

    public function addWithdrawals(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_users' => 'required|integer|exists:users,id', // Pastikan user valid
            'currency' => 'required|string|max:10',
            'network_address' => 'nullable|string|max:255',
            'wallet_address' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|integer'
        ]);

        // Simpan data deposit ke database
        DB::table('withdrawal_users')->insert([
            'id_users' => $request->id_users, // Pastikan id_users disimpan
            'currency' => $request->currency,
            'network_address' => $request->network_address,
            'wallet_address' => $request->wallet_address,
            'amount' => $request->amount,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.withdrawals')->with('success', 'Withdrawal added successfully.');
    }

    // Update deposit
    public function editWithdrawals(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|integer',
        ]);

        DB::table('withdrawal_users')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.withdrawals')->with('success', 'Withdrawal updated successfully.');
    }

    // Hapus deposit
    public function deleteWithdrawals($id)
    {
        $deposit = DB::table('withdrawal_users')->where('id', $id)->first();

        if (!$deposit) {
            return redirect()->route('admin.withdrawals')->with('error', 'Withdrawal not found.');
        }

        // Hapus deposit dari database
        DB::table('withdrawal_users')->where('id', $id)->delete();

        return redirect()->route('admin.withdrawals')->with('success', 'Withdrawal deleted successfully.');
    }

    public function readNotifications(Request $request)
    {
        // Update semua withdrawal_users yang belum dibaca (read = 0) menjadi 1
        DB::table('withdrawal_users')->where('baca', 0)->update(['baca' => 1]);

        return response()->json(['message' => 'All notifications marked as read']);
    }
}
