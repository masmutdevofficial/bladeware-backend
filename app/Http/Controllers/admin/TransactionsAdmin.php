<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TransactionsAdmin extends Controller
{
    public function index()
    {
        // Ambil data transaksi dengan JOIN ke tabel users dan products
        $transactions = DB::table('transactions_users')
            ->join('users', 'transactions_users.id_users', '=', 'users.id') // Join dengan users
            ->join('products', 'transactions_users.id_products', '=', 'products.id') // Join dengan products
            ->select(
                'transactions_users.*', // Semua kolom dari transactions_users
                'users.name as user_name', // Ambil name dari tabel users
                'products.product_name',
                'products.product_image',
                'products.price',
                'products.profit'
            )
            ->get();

        // Kirim data ke view
        return view('admin.transactions', compact('transactions'));
    }

    // Hapus deposit
    public function deleteDeposits($id)
    {
        $deposit = DB::table('transactions_users')->where('id', $id)->first();

        if (!$deposit) {
            return redirect()->route('admin.transactions')->with('error', 'Deposit not found.');
        }

        // Hapus deposit dari database
        DB::table('transactions_users')->where('id', $id)->delete();

        return redirect()->route('admin.transactions')->with('success', 'Deposit deleted successfully.');
    }
}
