<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DepositsAdmin extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('deposit_users')
            ->join('users', 'deposit_users.id_users', '=', 'users.id')
            ->select('deposit_users.*', 'users.name')
            ->orderBy('deposit_users.created_at', 'desc');
        
        // Filter tanggal
        if ($request->has(['start_date', 'end_date']) && $request->start_date && $request->end_date) {
            $query->whereBetween('deposit_users.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }
    
        if ($request->has('search') && $request->search !== null) {
            $keyword = '%' . $request->search . '%';
            $query->where('users.name', 'like', $keyword);
        }
    
        $perPage = $request->input('per_page', 10); // default 10
        $deposits = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
        $dataUser = DB::table('users')->select('id', 'name')->get();
    
        return view('admin.deposit', compact('deposits', 'dataUser'));
    }


    public function addDeposits(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_users' => 'required|integer|exists:users,id', // Pastikan user valid
            'currency' => 'required|string|max:10',
            'network_address' => 'nullable|string|max:255',
            'wallet_address' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category_deposit' => 'required',
            'status' => 'required|integer',
            'deposit_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimum 2MB
        ]);

        // Simpan gambar deposit
        $depositImage = null;
        if ($request->hasFile('deposit_image')) {
            $file = $request->file('deposit_image');
            $filePath = 'deposit/' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put($filePath, file_get_contents($file));
            $depositImage = $filePath;
        }

        // Simpan data deposit ke database
        DB::table('deposit_users')->insert([
            'id_users' => $request->id_users, // Pastikan id_users disimpan
            'currency' => $request->currency,
            'network_address' => $request->network_address,
            'wallet_address' => $request->wallet_address,
            'amount' => $request->amount,
            'status' => $request->status,
            'category_deposit' => $request->category_deposit,
            'deposit_image' => $depositImage,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.deposits')->with('success', 'Deposit added successfully.');
    }

    // Update deposit
    public function editDeposits(Request $request, $id)
    {
        $request->validate([
            'currency' => 'required|string|max:10',
            'network_address' => 'nullable|string|max:255',
            'wallet_address' => 'nullable|string|max:255',
            'amount'=> 'required|numeric|min:0',
            'status' => 'required|integer',
            'category_deposit' => 'required',
            'deposit_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $deposit = DB::table('deposit_users')->where('id', $id)->first();
        $depositImage = $deposit->deposit_image;

        // Jika ada gambar baru, hapus gambar lama dan simpan yang baru
        if ($request->hasFile('deposit_image')) {
            if ($depositImage) {
                Storage::disk('public')->delete($depositImage);
            }

            $file = $request->file('deposit_image');
            $filePath = 'deposit/' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put($filePath, file_get_contents($file));
            $depositImage = $filePath;
        }

        DB::table('deposit_users')->where('id', $id)->update([
            'deposit_image' => $depositImage,
            'currency' => $request->currency,
            'network_address' => $request->network_address,
            'wallet_address' => $request->wallet_address,
            'amount' => $request->amount,
            'status' => $request->status,
            'category_deposit' => $request->category_deposit,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.deposits')->with('success', 'Deposit updated successfully.');
    }

    // Hapus deposit
    public function deleteDeposits($id)
    {
        $deposit = DB::table('deposit_users')->where('id', $id)->first();

        if (!$deposit) {
            return redirect()->route('admin.deposits')->with('error', 'Deposit not found.');
        }

        // Hapus deposit dari database
        DB::table('deposit_users')->where('id', $id)->delete();

        return redirect()->route('admin.deposits')->with('success', 'Deposit deleted successfully.');
    }
}
