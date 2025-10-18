<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UsersAdmin extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('users')
            ->select('id', 'uid', 'name', 'phone_email', 'email_only', 'password', 'referral', 'referral_upline', 'profile', 'status', 'level','membership', 'credibility', 'network_address', 'currency', 'wallet_address', 'ip_address', 'position_set', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc');
        
        if ($request->has('search') && $request->search !== null) {
            $keyword = '%' . $request->search . '%';
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', $keyword)
                  ->orWhere('phone_email', 'like', $keyword)
                  ->orWhere('email_only', 'like', $keyword)
                  ->orWhere('ip_address', 'like', $keyword)
                  ->orWhere('referral', 'like', $keyword)
                  ->orWhere('referral_upline', 'like', $keyword);
            });
        }
    
        $perPage = $request->input('per_page', 5); // default 5
        $users = $query->paginate($perPage)->withQueryString();
    
        $users->getCollection()->transform(function ($user) {
            $today = now()->toDateString();
        
            // Finance
            $user->finance = DB::table('finance_users')
                ->where('id_users', $user->id)
                ->select('saldo', 'saldo_beku', 'saldo_misi', 'komisi', 'withdrawal_password', 'updated_at')
                ->first();
        
            // Combination data
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
                ->first(); // <-- ubah get() jadi first()
                
            // Upline
            $user->upline_name = DB::table('users')
                ->where('referral', $user->referral_upline)
                ->value('name');
        
            // Downlines
            $user->downlines = DB::table('users')
                ->where('referral_upline', $user->referral)
                ->select('name')
                ->get();
        
            // Deposit Summary
            $user->deposit_count = DB::table('deposit_users')
                ->where('id_users', $user->id)
                ->count();
        
            $user->deposit_total = DB::table('deposit_users')
                ->where('id_users', $user->id)
                ->sum('amount');
        
            // Withdrawal Summary
            $user->withdrawal_count = DB::table('withdrawal_users')
                ->where('id_users', $user->id)
                ->count();
        
            $user->withdrawal_total = DB::table('withdrawal_users')
                ->where('id_users', $user->id)
                ->sum('amount');
                
            // Product ID terbaru
            $user->latest_product_id = DB::table('transactions_users')
                ->where('id_users', $user->id)
                ->orderByDesc('created_at')
                ->value('id_products');
                
            // Cek apakah user pernah transaksi type 'combination'
            $user->has_combination = DB::table('combination_users')
                ->where('id_users', $user->id)
                ->exists();
                
            $user->absen_user = DB::table('absen_users')
                ->where('id_users', $user->id)
                ->get();
        
            // Task Progress (Tugas)
            $limitMap = [
                'Normal' => 40,
                'Gold' => 50,
                'Platinum' => 55,
                'Crown' => 55,
            ];
        
            $positionSet = $user->position_set;
            $membership = $user->membership;
            $sisaTugas = $limitMap[$membership] ?? 0;
        
            $tugasSelesai = DB::table('transactions_users')
                ->where('id_users', $user->id)
                ->where('set', $positionSet)
                ->where('status', 0)
                ->whereDate('created_at', $today)
                ->count();
        
            $tugasSekarang = $sisaTugas - $tugasSelesai;
            $user->task_done = $tugasSelesai;
            $user->task_remaining = $tugasSekarang;
            $user->task_limit = $sisaTugas;
            return $user;
        });


    
        $referrals = DB::table('users')
            ->select('referral', 'name')
            ->get();
        
        $products = DB::table('products')
            ->select('id', 'product_name')
            ->get();

        return view('admin.users', compact('users', 'referrals', 'products'));
    }
    
    public function exportPDF()
    {
        $today = now()->toDateString();
    
        $users = DB::table('users')
            ->select('id', 'uid', 'name', 'phone_email', 'email_only', 'password', 'referral', 'referral_upline', 'profile', 'status', 'level', 'membership', 'credibility', 'network_address', 'currency', 'wallet_address', 'ip_address', 'position_set', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc')
            ->get();
    
        $limitMap = [
            'Normal' => 40,
            'Gold' => 50,
            'Platinum' => 55,
            'Crown' => 55,
        ];
    
        $users->transform(function ($user) use ($today, $limitMap) {
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
    
            // Deposit / Withdraw
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
    
            // Transaksi kombinasi
            $user->has_combination = DB::table('combination_users')
                ->where('id_users', $user->id)
                ->exists();
    
            $user->latest_product_id = DB::table('transactions_users')
                ->where('id_users', $user->id)
                ->orderByDesc('created_at')
                ->value('id_products');
    
            // Absen
            $user->absen_user = DB::table('absen_users')
                ->where('id_users', $user->id)
                ->select('created_at')
                ->limit(5)
                ->get();
    
            // Task
            $positionSet = $user->position_set;
            $membership = $user->membership;
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
    
        dd($users->first());
    }

    public function exportUsersExcel()
    {
        $user = Auth::user();
    
        if ($user) {
            DB::table('log_admin')->insert([
                'keterangan' => '' . $user->name . ' has exported user data to Excel.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return Excel::download(new UsersExport, 'users-data.xlsx');
    }
    
    public function exportUsersPdf()
    {
        $user = Auth::user();
    
        if ($user) {
            DB::table('log_admin')->insert([
                'keterangan' => '' . $user->name . ' has exported user data to PDF.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $users = $this->getExportUserData(); // sesuai yang sudah kita buat sebelumnya
        $pdf = Pdf::loadView('admin.export-pdf', compact('users'))->setPaper('a4', 'landscape');
        return $pdf->download('users-data.pdf');
    }
    
    private function getExportUserData()
    {
        $today = now()->toDateString();
        $limitMap = [
            'Normal' => 40,
            'Gold' => 50,
            'Platinum' => 55,
            'Crown' => 55,
        ];
    
        $users = DB::table('users')
            ->select('id', 'uid', 'name', 'phone_email', 'email_only', 'password', 'referral', 'referral_upline', 'profile', 'status', 'level', 'membership', 'credibility', 'network_address', 'currency', 'wallet_address', 'ip_address', 'position_set', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc')
            ->get();
    
        return $users->transform(function ($user) use ($today, $limitMap) {
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
    
            $user->has_combination = DB::table('combination_users')
                ->where('id_users', $user->id)
                ->exists();
    
            // Upline
            $user->upline_name = DB::table('users')
                ->where('referral', $user->referral_upline)
                ->value('name');
    
            // Downlines
            $user->downlines = DB::table('users')
                ->where('referral_upline', $user->referral)
                ->select('name')
                ->get();
    
            // Deposit / Withdraw
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
    
            // Latest product ID
            $user->latest_product_id = DB::table('transactions_users')
                ->where('id_users', $user->id)
                ->orderByDesc('created_at')
                ->value('id_products');
    
            // Absen 5 hari terakhir
            $user->absen_user = DB::table('absen_users')
                ->where('id_users', $user->id)
                ->select('created_at')
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();
    
            // Task
            $positionSet = $user->position_set;
            $membership = $user->membership;
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
    }

    public function detail(Request $request)
    {
        // Tangkap ID dari query parameter (?id=1)
        $id = $request->query('id');

        // Pastikan ID ada dan valid
        if (!$id) {
            return redirect()->route('admin.users')->with('error', 'Invalid ID!');
        }

        // Ambil detail user berdasarkan ID
        $user = DB::table('users')->where('id', $id)->first();

        // Jika user not found, redirect dengan pesan error
        if (!$user) {
            return redirect()->route('admin.users')->with('error', 'User not found!');
        }

        // Ambil data finance dari tabel finance_users dan gabungkan dengan users
        $finance = DB::table('finance_users')
            ->join('users', 'finance_users.id_users', '=', 'users.id')
            ->where('finance_users.id_users', $id)
            ->select(
                'finance_users.saldo',
                'finance_users.komisi',
                'finance_users.withdrawal_password',
                'finance_users.updated_at',
                'users.currency',
                'users.network_address',
                'users.wallet_address'
            )
            ->first();

        // Ambil referral_upline user
        $referralUpline = $user->referral_upline;

        $referrals = DB::table('users')
            ->select('referral', 'name')
            ->get();

        // Cari semua user dengan referral_upline yang sama
        $dataUpline = DB::table('users')
        ->where('referral', $referralUpline)
        ->value('name'); // Mengambil hanya satu nama

        // Kirim data ke view
        return view('admin.users-detail', compact('user', 'finance', 'dataUpline', 'referrals'));
    }

    public function addUsers(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'referral' => 'required|string|max:255|unique:users,referral',
            'name' => 'required|string|max:255',
            'phone_email' => 'required|string|max:255|unique:users,phone_email',
            'email_only' => 'required|string|max:255|unique:users,email_only',
            'password' => 'required|string|min:3',
            'withdrawal_password' => 'required|string|min:3',
            'referral_upline' => 'nullable|string|max:255',
            'status' => 'required|in:0,1,2,3',
            'level' => 'required|in:0,1,2,3',
            'membership' => 'required|in:Normal,Gold,Platinum,Crown',
        ]);
        
        if (!empty($request->referral_upline)) {
            $uplineExists = DB::table('users')
                ->where('referral', $request->referral_upline)
                ->exists();
        
            if (!$uplineExists) {
                return redirect()->back()->with('error', 'Referral Code Superior Not Found.');
            }
        }
        
        // Handle file upload dengan Storage
        $profile = null;
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $filePath = 'profiles/' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put($filePath, file_get_contents($file)); // Simpan ke storage/app/public/profiles
            $profile = $filePath;
        }

        // Generate UID unik
        $uid = Str::uuid()->toString();

        // Insert data ke dalam tabel users
        $user_id = DB::table('users')->insertGetId([
            'uid' => $uid, // Simpan UID unik
            'profile' => $profile, // Simpan path gambar di database
            'referral' => $request->referral,
            'name' => $request->name,
            'phone_email' => $request->phone_email,
            'email_only' => $request->email_only,
            'password' => Hash::make($request->password), // Hash password
            'referral_upline' => $request->referral_upline,
            'status' => $request->status,
            'level' => $request->level,
            'membership' => $request->membership,
            'currency' => 'USDC',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Ambil admin yang sedang login
        $admin = Auth::user();
    
        // Simpan log ke log_admin
        if ($admin) {
            DB::table('log_admin')->insert([
                'keterangan' => '' . $admin->name . ' has added a new user named "' . $request->name . '".',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        if ($user_id) {
            // Simpan ke tabel finance_users
            DB::table('finance_users')->insert([
                'id_users' => $user_id,
                'saldo' => 0,
                'komisi' => 0,
                'withdrawal_password' => null, // Kosongkan
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'User added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add user.');
        }
    }

    public function deleteUser(Request $request)
    {
        $user_id = $request->id;

        // Cari user berdasarkan ID
        $user = DB::table('users')->where('id', $user_id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Hapus file profil jika ada
        if ($user->profile) {
            Storage::disk('public')->delete($user->profile);
        }
        
        // Ambil admin yang sedang login
        $admin = Auth::user();
    
        // Simpan log ke log_admin
        if ($admin) {
            DB::table('log_admin')->insert([
                'keterangan' => '' . $admin->name . ' has deleted a user named "' . $user->name . '".',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        

        // Hapus data dari tabel users dan finance_users
        DB::table('finance_users')->where('id_users', $user_id)->delete();
        DB::table('users')->where('id', $user_id)->delete();

        return redirect()->back()->with('success', 'User successfully deleted.');
    }

    public function editInfoUser(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:3',
            'referral_upline' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
            'level' => 'required|in:0,1,2,3',
            'membership' => 'required|in:Normal,Gold,Platinum,Crown',
            'credibility' => 'required|int',
            'wallet_address' => 'nullable|string|max:255',
            'withdrawal_password' => 'nullable|string|max:255',
            'network_address' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:255',
        ]);
    
        // Cari user
        $user = DB::table('users')->where('id', $id)->first();
    
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
    
        // Cek apakah ada file gambar baru
        if ($request->hasFile('profile')) {
            if ($user->profile) {
                Storage::disk('public')->delete($user->profile);
            }
    
            $file = $request->file('profile');
            $filePath = 'profiles/' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put($filePath, file_get_contents($file));
            $profile = $filePath;
        } else {
            $profile = $user->profile;
        }
    
        // Update ke tabel users
        DB::table('users')->where('id', $id)->update([
            'profile' => $profile,
            'name' => $request->name,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'referral_upline' => $request->referral_upline,
            'status' => $request->status,
            'level' => $request->level,
            'membership' => $request->membership,
            'credibility' => $request->credibility,
            'wallet_address' => $request->wallet_address,
            'network_address' => $request->network_address,
            'currency' => $request->currency,
            'updated_at' => now(),
        ]);
    
        // Ambil admin yang sedang login
        $admin = Auth::user();
        
        // Deteksi perubahan
        $changedFields = [];
        
        if ($request->name !== $user->name) $changedFields[] = 'Name';
        if ($request->password) $changedFields[] = 'Password';
        if ($request->referral_upline !== $user->referral_upline) $changedFields[] = 'Superior Username';
        if ((int)$request->status !== (int)$user->status) $changedFields[] = 'Status';
        if ((int)$request->level !== (int)$user->level) $changedFields[] = 'Level';
        if ($request->membership !== $user->membership) $changedFields[] = 'Membership';
        if ((int)$request->credibility !== (int)$user->credibility) $changedFields[] = 'Credibility';
        if ($request->wallet_address !== $user->wallet_address) $changedFields[] = 'Wallet address';
        if ($request->network_address !== $user->network_address) $changedFields[] = 'Network Address';
        if ($request->currency !== $user->currency) $changedFields[] = 'Currency';
        if ($request->hasFile('profile')) $changedFields[] = 'Profile';
        if ($request->withdrawal_password !== DB::table('finance_users')->where('id_users', $id)->value('withdrawal_password')) {
            $changedFields[] = 'Withdrawal Password';
        }
        
        // Simpan log jika admin login
        if ($admin) {
            DB::table('log_admin')->insert([
                'keterangan' => '' . $admin->name . ' has edited user "' . $user->name . '" (Changed: ' . implode(', ', $changedFields) . ').',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Update withdrawal_password di finance_users
        DB::table('finance_users')->where('id_users', $id)->update([
            'withdrawal_password' => $request->withdrawal_password,
            'updated_at' => now(),
        ]);
    
        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function editFinanceUser(Request $request, $id)
    {
        // Validasi input (hapus min:0 agar bisa negatif)
        $request->validate([
            'saldo' => 'nullable|numeric',
            'saldo_bonus' => 'nullable|numeric',
        ]);
    
        // Ambil data finance lama
        $financeUser = DB::table('finance_users')->where('id_users', $id)->first();
        if (!$financeUser) {
            return redirect()->back()->with('error', 'Finance user data not found.');
        }
    
        // Ambil data user untuk validasi lanjutan (opsional)
        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User data not found.');
        }
        
        if ($request->saldo < 0 && $financeUser->saldo != $request->saldo) {
            // Cek apakah user sudah mengisi data withdrawal
            if (!$user->network_address || !$user->currency || !$user->wallet_address) {
                return redirect()->back()->with('error', 'User has not bound a withdrawal account.');
            }
            
            // Cek apakah saldo berubah
            $saldoLama = (float) $financeUser->saldo;
            $saldoBaru = (float) $request->saldo;
            $selisihSaldo = $saldoBaru + $saldoLama;
        
            // Update finance_users
            DB::table('finance_users')->where('id_users', $id)->update([
                'saldo' => $selisihSaldo,
                'saldo_beku' => $financeUser->saldo_beku,
                'komisi' => $financeUser->komisi,
                'updated_at' => now(),
            ]);
        
            // Simpan ke withdrawal_users
            DB::table('withdrawal_users')->insert([
                'id_users' => $id,
                'network_address' => $user->network_address,
                'currency' => $user->currency,
                'wallet_address' => $user->wallet_address,
                'amount' =>abs($saldoBaru), // nilai positif
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Ambil admin yang sedang login
            $admin = Auth::user();
        
            // Siapkan log perubahan
            $updatedFields = [];
            if ($request->saldo != $financeUser->saldo) {
                $updatedFields[] = 'Withdrawal';
            }
            
            // Simpan log ke log_admin
            if ($admin && count($updatedFields) > 0) {
                $fieldList = implode(', ', $updatedFields);
                DB::table('log_admin')->insert([
                    'keterangan' => $admin->name . ' updated user "' . $user->name . '" ' . $fieldList . '.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
        }
        
        if ($request->saldo > 0 && $financeUser->saldo != $request->saldo) {
            // Cek apakah saldo berubah
            $saldoLama = (float) $financeUser->saldo;
            $saldoBaru = (float) $request->saldo;
            $selisihSaldo = $saldoLama + $saldoBaru;
            // if ($saldoLama >= 0) {
            //     $selisihSaldo = $saldoLama + $saldoBaru;
            // }
            
            DB::table('deposit_users')->insert([
                'id_users' => $id,
                'currency' => '-',
                'network_address' => '-',
                'wallet_address' => '-',
                'amount' => $saldoBaru, // nilai bisa negatif/positif
                'status' => 1,
                'category_deposit' => 'Deposit',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Cek apakah ada price_akhir
            if ($financeUser->price_akhir > 0) {
                $newSaldo = $financeUser->saldo;
                $newBeku = $financeUser->saldo_beku;
                
                if ($financeUser->saldo < 0) {
                    $newSaldo = $financeUser->saldo + $request->saldo;

                    if ($newSaldo >= 0) {
                        // Jika saldo sudah positif setelah ditambah
                        $newBeku += $newSaldo; // Tambahkan sisa saldo positif ke saldo_beku
                        $newSaldo = 0; // Reset saldo ke 0
                    } else {
                       $newBeku = $financeUser->saldo_beku + $request->saldo;
                    }
                } else {
                    $newSaldo = $financeUser->saldo - $request->saldo;
                    $newBeku = $financeUser->saldo_beku;
                }
            
                // Hitung price_akhir baru
                $newPriceAkhir = $financeUser->price_akhir - $request->saldo;
                if ($newPriceAkhir < 0) {
                    $newPriceAkhir = 0; // Tidak boleh minus
                }
            
                $updateData = [
                    'saldo' => $newSaldo,
                    'saldo_beku' => $financeUser->saldo_beku + $request->saldo,
                    'price_akhir' => $newBeku,
                    'updated_at' => now(),
                ];
            
                // Kalau saldo sudah positif atau nol
                if ($newSaldo >= 0) {
                    $updateData['price_akhir'] = 0;
                    $updateData['temp_balance'] = 0;
                }
            
                DB::table('finance_users')->where('id_users', $id)->update($updateData);
            } else {
                // Update finance_users jika tidak ada price_akhir
                DB::table('finance_users')->where('id_users', $id)->update([
                    'saldo' => $selisihSaldo,
                    'komisi' => $financeUser->komisi,
                    'updated_at' => now(),
                ]);
            }
            
            // Ambil admin yang sedang login
            $admin = Auth::user();
            
            // Siapkan log perubahan
            $updatedFieldsW = [];
            if ($request->saldo != $financeUser->saldo) {
                $updatedFieldsW[] = 'Deposit';
            }
            
            // Simpan log ke log_admin
            if ($admin && count($updatedFieldsW) > 0) {
                $fieldListW = implode(', ', $updatedFieldsW);
                DB::table('log_admin')->insert([
                    'keterangan' => $admin->name . ' updated user "' . $user->name . '" ' . $fieldListW . '.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        if ($request->saldo_bonus > 0 ) {
            
            DB::table('deposit_users')->insert([
                'id_users' => $id,
                'currency' => '-',
                'network_address' => '-',
                'wallet_address' => '-',
                'amount' => $request->saldo_bonus, // nilai bisa negatif/positif
                'status' => 1,
                'category_deposit' => 'Bonus',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Cek apakah ada price_akhir
            if ($financeUser->price_akhir > 0) {
                $newSaldo = $financeUser->saldo;
                $newBeku = $financeUser->saldo_beku;
                
                if ($financeUser->saldo < 0) {
                    $newSaldo = $financeUser->saldo + $request->saldo_bonus;
                    
                    if ($newSaldo >= 0) {
                        // Jika saldo sudah positif setelah ditambah
                        $newBeku += $newSaldo; // Tambahkan sisa saldo positif ke saldo_beku
                        $newSaldo = 0; // Reset saldo ke 0
                    } else {
                       $newBeku = $financeUser->saldo_beku + $request->saldo_bonus;
                    }
                    
                } else {
                    $newSaldo = $financeUser->saldo - $request->saldo_bonus;
                    $newBeku = $financeUser->saldo_beku;
                }
            
                // Hitung price_akhir baru
                $newPriceAkhir = $financeUser->price_akhir - $request->saldo_bonus;
                if ($newPriceAkhir < 0) {
                    $newPriceAkhir = 0; // Tidak boleh minus
                }
            
                $updateData = [
                    'saldo' => $newSaldo,
                    'saldo_beku' => $financeUser->saldo_beku + $request->saldo_bonus,
                    'price_akhir' => $newPriceAkhir,
                    'updated_at' => now(),
                ];
            
                // Kalau saldo sudah positif atau nol
                if ($newSaldo >= 0) {
                    $updateData['price_akhir'] = 0;
                    $updateData['temp_balance'] = 0;
                }       
            
                DB::table('finance_users')->where('id_users', $id)->update($updateData);
            } else {
                // Update finance_users jika tidak ada price_akhir
                DB::table('finance_users')->where('id_users', $id)->update([
                    'saldo' => $financeUser->saldo + $request->saldo_bonus,
                    'updated_at' => now(),
                ]);
            }
            
            // Ambil admin yang sedang login
            $admin = Auth::user();
            
            // Siapkan log perubahan
            $updatedFieldsW = [];
            if ($request->saldo != $financeUser->saldo) {
                $updatedFieldsW[] = 'Bonus';
            }
            
            // Simpan log ke log_admin
            if ($admin && count($updatedFieldsW) > 0) {
                $fieldListW = implode(', ', $updatedFieldsW);
                DB::table('log_admin')->insert([
                    'keterangan' => $admin->name . ' updated user "' . $user->name . '" ' . $fieldListW . '.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        return redirect()->back()->with('success', 'Finance user data updated successfully!');
    }

    public function editWalletUser(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'withdrawal_password' => 'nullable|string|min:3',
            'currency' => 'required|string|max:10',
            'network_address' => 'nullable|string|max:255',
            'wallet_address' => 'nullable|string|max:255',
        ]);

        // Cari data finance_users berdasarkan id_users
        $financeUser = DB::table('finance_users')->where('id_users', $id)->first();

        if (!$financeUser) {
            return redirect()->back()->with('error', 'Wallet user data not found.');
        }

        // Cari data user berdasarkan ID
        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User data not found.');
        }

        // Update finance_users
        DB::table('finance_users')->where('id_users', $id)->update([
            'withdrawal_password' => $request->withdrawal_password ? $request->withdrawal_password : $financeUser->withdrawal_password,
            'updated_at' => now(),
        ]);

        // Update users (gunakan data lama jika tidak diisi)
        DB::table('users')->where('id', $id)->update([
            'currency' => $request->currency ?: $user->currency,
            'network_address' => $request->network_address ?: $user->network_address,
            'wallet_address' => $request->wallet_address ?: $user->wallet_address,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Wallet user data updated successfully!');
    }
    
    public function editBoostUser(Request $request, $id)
    {
        if ($request->status === 'inactive') {
            // Hapus semua data kombinasi user ini
            DB::table('combination_users')->where('id_users', $id)->delete();
    
            return redirect()->back()->with('success', 'User combination deactivated successfully!');
        }
    
        // Validasi jika status active
        $request->validate([
            'products' => 'required|array|max:3',
            'sequence' => 'required|integer',
            'set_boost' => 'required|integer',
        ]);
    
        // Hapus data lama
        DB::table('combination_users')->where('id_users', $id)->delete();
    
        // Insert ulang
        foreach ($request->products as $product_id) {
            DB::table('combination_users')->insert([
                'id_users'   => $id,
                'id_produk'  => $product_id,
                'sequence'   => $request->sequence > 0 ? $request->sequence - 1 : 0,
                'set_boost'  => $request->set_boost,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        return redirect()->back()->with('success', 'Combination Products updated successfully!');
    }

    
    public function resetJob(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
    
        $user = DB::table('users')->where('id', $request->id)->first();
    
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
    
        if ($user->position_set == 1) {
            DB::table('users')->where('id', $user->id)->update([
                'position_set' => 2,
                'updated_at' => now(),
            ]);
        } elseif ($user->position_set == 2) {
            DB::table('users')->where('id', $user->id)->update([
                'position_set' => 3,
                'updated_at' => now(),
            ]);
        } elseif ($user->position_set == 3) {
            return redirect()->back()->with('error', 'Max Set For Today.');
        }
    
        return redirect()->back()->with('success', 'Job reset successfully.');
    }

}