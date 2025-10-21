<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TransactionsAdmin extends Controller
{
    public function index(Request $request)
    {
        // Ambil data transaksi dengan JOIN ke tabel users dan products
        $query = DB::table('transactions_users')
            ->join('users', 'transactions_users.id_users', '=', 'users.id') // Join dengan users
            ->join('products', 'transactions_users.id_products', '=', 'products.id') // Join dengan products
            ->select(
                'transactions_users.*', // Semua kolom dari transactions_users
                'users.name as user_name', // Ambil name dari tabel users
                'products.product_name',
                'products.product_image',
                'products.price',
                'products.profit'
            );

        // Search by user name or product name
        if ($request->has('search') && $request->search !== null) {
            $keyword = '%' . $request->search . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('users.name', 'like', $keyword)
                  ->orWhere('products.product_name', 'like', $keyword);
            });
        }

        // Date range filter
        if ($request->has(['start_date', 'end_date']) && $request->start_date && $request->end_date) {
            $query->whereBetween('transactions_users.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $perPage = $request->input('per_page', 10);
        $transactions = $query->orderBy('transactions_users.created_at', 'desc')->paginate($perPage)->withQueryString();

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
