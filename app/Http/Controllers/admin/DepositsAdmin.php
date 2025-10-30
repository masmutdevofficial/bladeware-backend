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
    $hasDate   = $request->has(['start_date','end_date']) && $request->start_date && $request->end_date;
    $start     = $hasDate ? $request->start_date . ' 00:00:00' : null;
    $end       = $hasDate ? $request->end_date   . ' 23:59:59' : null;
    $hasSearch = $request->filled('search');
    $keyword   = $hasSearch ? ('%'.$request->search.'%') : null;
    $perPage   = (int) $request->input('per_page', 10);

    // Deposit asli
    $qDeposit = DB::table('deposit_users')
        ->join('users', 'deposit_users.id_users', '=', 'users.id')
        ->select([
            'deposit_users.id',
            'deposit_users.id_users',
            'users.name',
            'deposit_users.amount',
            'deposit_users.category_deposit',
            'deposit_users.created_at',
            'deposit_users.status', // <-- tambahkan
        ]);

    if ($hasDate)   $qDeposit->whereBetween('deposit_users.created_at', [$start, $end]);
    if ($hasSearch) $qDeposit->where('users.name', 'like', $keyword);

    // Welcome Bonus dari registered_bonus (status = 1)
    $qWelcome = DB::table('registered_bonus')
        ->join('users', 'registered_bonus.id_users', '=', 'users.id')
        ->select([
            DB::raw("CONCAT('wb_', registered_bonus.id) as id"),
            'registered_bonus.id_users',
            'users.name',
            DB::raw('15 as amount'),
            DB::raw("'Welcome Bonus' as category_deposit"),
            'registered_bonus.created_at',
            DB::raw('1 as status'), // <-- set 1 untuk welcome bonus
        ]);

    if ($hasDate)   $qWelcome->whereBetween('registered_bonus.created_at', [$start, $end]);
    if ($hasSearch) $qWelcome->where('users.name', 'like', $keyword);

    // UNION + paginate
    $union = $qDeposit->unionAll($qWelcome);

    $deposits = DB::query()
        ->fromSub($union, 't')
        ->orderBy('t.created_at', 'desc')
        ->paginate($perPage)
        ->withQueryString();

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
