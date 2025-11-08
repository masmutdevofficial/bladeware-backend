<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class APIController extends Controller
{
    public function login(Request $request)
    {
        if (!$request->has('phone_email') || !$request->has('password')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email/Phone and password are required',
            ], 400);
        }
    
        $phone_email = $request->input('phone_email');
        $password = $request->input('password');
    
        $user = DB::table('users')
            ->where('phone_email', $phone_email)
            ->orWhere('name', $phone_email)
            ->orWhere('email_only', $phone_email)
            ->first();
    
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials',
            ], 401);
        }
    
        // Simpan IP Address jika dikirim
        $ipAddress = $request->input('ip_address');
        if ($ipAddress) {
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'ip_address' => $ipAddress,
                    'updated_at' => now(),
                ]);
        }
    
    $payload = [
        'iss' => config('app.url'),   // jangan pakai env() di sini juga
        'sub' => $user->id,
        'uid' => $user->uid,
        'iat' => time(),
        'exp' => time() + (6 * 3600),
    ];

    $secretKey = config('jwt.secret');

    if (!is_string($secretKey) || $secretKey === '') {
        Log::error('JWT secret is missing or invalid type');
        return response()->json([
            'status' => 'error',
            'message' => 'Server misconfiguration: JWT secret missing',
        ], 500);
    }

    $jwt = JWT::encode($payload, $secretKey, 'HS256');
    
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $jwt,
        ]);
    }

    public function register(Request $request)
    {
        try {
            $errors = [];
            
            // Validasi username (optional): hanya cek jika diisi, boleh duplikat email/phone
            $reqUsername = trim((string) $request->username);
            if ($reqUsername !== '' && DB::table('users')->where('name', $reqUsername)->exists()) {
                $errors['username'] = 'Username is already taken.';
            }

            // Validasi password
            if (empty($request->password)) {
                $errors['password'] = 'Password is required.';
            } elseif (strlen($request->password) < 3) {
                $errors['password'] = 'Password must be at least 3 characters long.';
            }

            // Validasi withdrawal password
            if (empty($request->withdrawal_password)) {
                $errors['withdrawal_password'] = 'Withdrawal Password is required.';
            } elseif (strlen($request->withdrawal_password) < 3) {
                $errors['withdrawal_password'] = 'Withdrawal Password must be at least 3 characters long.';
            }

            // Validasi referral
            $referralUplineId = null;
            if (empty($request->referral)) {
                $errors['referral'] = 'Referral is required.';
            } else {
                $referrer = DB::table('users')->where('referral', $request->referral)->first();
                if (!$referrer) {
                    $errors['referral'] = 'Referral code not found.';
                } else {
                    $referralUplineId = $referrer->id;
                }
            }

            // Minimal salah satu identitas harus ada: username atau phone_email atau email_only
            $hasIdentity = ($reqUsername !== '') || (trim((string) $request->phone_email) !== '') || (trim((string) $request->email_only) !== '');
            if (!$hasIdentity) {
                $errors['identity'] = 'Fill at least one: username / phone number / email.';
            }

            if (!empty($errors)) {
                return response()->json([
                    'status'  => 'error',
                    'message' => collect($errors)->first()
                ], 422);
            }

            // ==== Mulai transaksi ====
            DB::beginTransaction();

            // Generate referral code (6 karakter acak alfanumerik)
            $generateReferral = strtoupper(Str::random(6));

            // Generate UID unik
            do {
                $uid = 'UID' . mt_rand(100000, 999999);
            } while (DB::table('users')->where('uid', $uid)->exists());

            // Simpan user
            // Tentukan nama login: pakai username jika ada, lalu phone/email, atau generate
            $loginName = $reqUsername;
            if ($loginName === '') {
                $pe = trim((string) $request->phone_email);
                $em = trim((string) $request->email_only);
                if ($pe !== '') {
                    $loginName = $pe;
                } elseif ($em !== '') {
                    $loginName = $em;
                } else {
                    $loginName = 'user_' . substr((string) Str::uuid(), 0, 8);
                }
            }

            $userId = DB::table('users')->insertGetId([
                'name'            => $loginName,
                'phone_email'     => $request->phone_email ?? '',
                'email_only'      => $request->email_only ?? '',
                'password'        => Hash::make($request->password),
                'referral'        => $generateReferral,
                'referral_upline' => $request->referral,   // simpan kode upline (atau $referralUplineId bila pakai id)
                'uid'             => $uid,
                'level'           => 1,
                'status'          => 1,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // Simpan ke finance_users (saldo awal 15)
            DB::table('finance_users')->insert([
                'id_users'            => $userId,
                'saldo'               => 15,
                'komisi'              => 0,
                'withdrawal_password' => $request->withdrawal_password,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            // === Tambahkan bonus pendaftaran ke registered_bonus (15) ===
            DB::table('registered_bonus')->insert([
                'id_users'   => $userId,
                'total_bonus'=> 15,           // DECIMAL(20,2) -> 15.00 juga boleh
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            // ==== Selesai transaksi ====

            return response()->json([
                'status'  => 'success',
                'message' => 'Registration successful',
            ]);
        } catch (\Exception $e) {
            // rollback jika sebelumnya sudah beginTransaction
            try { DB::rollBack(); } catch (\Throwable $t) {}

            return response()->json([
                'status'     => 'error',
                'message'    => 'An error occurred during registration',
                'errors_log' => $e->getMessage(),
            ], 500);
        }
    }

    public function uploadAvatar(Request $request)
    {
        // Ambil token JWT dari header
        $authHeader = $request->header('Authorization');
        if (!$authHeader) {
            return response()->json(['status' => 'error', 'message' => 'Token is missing'], 401);
        }

        try {
            $secretKey = config('jwt.secret');
            $token     = str_replace('Bearer ', '', $authHeader);
            $decoded   = JWT::decode($token, new Key($secretKey, 'HS256'));

            // Ambil user id dari claim 'sub' (fallback ke 'uid' jika perlu)
            $userId = $decoded->sub ?? null;
            if (!$userId) {
                return response()->json(['status' => 'error', 'message' => 'Invalid token payload'], 401);
            }
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => 'Invalid token or unauthorized'], 401);
        }

        // Validasi file
        $request->validate([
            'profile' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048', // max 2MB
        ]);

        // Pastikan user ada
        $user = DB::table('users')->where('id', $userId)->select('id','profile')->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        // Simpan file ke storage/app/public/profiles
        $path = $request->file('profile')->store('profiles', 'public');

        // Opsional: hapus file lama jika ada dan berada di disk public
        if (!empty($user->profile) && Storage::disk('public')->exists($user->profile)) {
            try {
                Storage::disk('public')->delete($user->profile);
            } catch (\Throwable $e) {
                // diamkan saja; tidak menghalangi proses update
            }
        }

        // Update DB
        DB::table('users')->where('id', $userId)->update([
            'profile'    => $path,
            'updated_at' => now(),
        ]);

        // URL publik (butuh "php artisan storage:link" sekali saja)
        $publicUrl = asset('storage/'.$path);

        return response()->json([
            'status'  => 'success',
            'message' => 'Avatar uploaded successfully',
            'data'    => [
                'profile'     => $path,
                'profile_url' => $publicUrl,
            ],
        ], 201);
    }

    public function getBannerData(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json([
                'message' => 'Token is missing',
            ], 401);
        }

        try {
            // Decode JWT
            $secretKey = config('jwt.secret');
            $jwt = str_replace('Bearer ', '', $token);
            $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));
            $userId  = $decoded->sub; // mengikuti pola sebelumnya

            // Ambil registered_banner dari tabel users
            $registeredBanner = DB::table('users')
                ->where('id', $userId)
                ->value('registered_banner');

            if ($registeredBanner === null) {
                // User tidak ditemukan atau kolom null
                return response()->json([
                    'message' => 'User not found or registered_banner is null',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data'   => [
                    'registered_banner' => $registeredBanner,
                ],
            ], 200);

        } catch (\Firebase\JWT\ExpiredException $e) {
            return response()->json([
                'message' => 'Token expired',
            ], 401);
        } catch (\UnexpectedValueException $e) {
            return response()->json([
                'message' => 'Invalid token',
            ], 401);
        } catch (\Exception $e) {
            Log::error('getBannerData error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Something went wrong',
            ], 500);
        }
    }

    public function setRegisteredBanner(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['message' => 'Token is missing'], 401);
        }

        try {
            // Decode JWT
            $secretKey = config('jwt.secret');
            $jwt = str_replace('Bearer ', '', $token);
            $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));
            $userId  = $decoded->sub;

            // Ambil user & nilai sekarang
            $user = DB::table('users')
                ->select('id', 'registered_banner')
                ->where('id', $userId)
                ->first();

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            // Jika sudah 1, kembalikan sukses idempotent
            if ((int) $user->registered_banner === 1) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'registered_banner already set to 1',
                    'data' => ['registered_banner' => 1],
                ], 200);
            }

            // Update hanya jika masih 0
            $affected = DB::table('users')
                ->where('id', $userId)
                ->where('registered_banner', 0)
                ->update([
                    'registered_banner' => 1,
                    'updated_at' => now(),
                ]);

            if ($affected === 0) {
                // Gagal update karena kondisi tidak terpenuhi
                return response()->json([
                    'message' => 'Update blocked or already updated',
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'registered_banner updated to 1',
                'data' => ['registered_banner' => 1],
            ], 200);

        } catch (\Firebase\JWT\ExpiredException $e) {
            return response()->json(['message' => 'Token expired'], 401);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['message' => 'Invalid token'], 401);
        } catch (\Exception $e) {
            Log::error('setRegisteredBanner error: '.$e->getMessage());
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    public function getProfileData(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['status'=>'error','message'=>'Token is missing'], 401);
        }

        try {
            $secretKey = config('jwt.secret');
            $decoded   = \Firebase\JWT\JWT::decode(str_replace('Bearer ', '', $token), new \Firebase\JWT\Key($secretKey, 'HS256'));
            $uid       = $decoded->uid;

            $user = DB::table('users')
                ->where('uid', $uid)
                ->select('id','uid','name','phone_email','email_only','referral','profile','level','credibility','membership','network_address','currency','wallet_address','created_at','updated_at')
                ->first();

            if (!$user) {
                return response()->json(['status'=>'error','message'=>'User not found'], 404);
            }

            // Bangun URL publik untuk avatar
            $profileUrl = null;
            if (!empty($user->profile)) {
                if (str_starts_with($user->profile, 'http://') || str_starts_with($user->profile, 'https://') || str_starts_with($user->profile, '//')) {
                    $profileUrl = $user->profile; // jika sudah URL penuh
                } else {
                    $profileUrl = asset('storage/' . ltrim($user->profile, '/'));
                }
            }
            $user->profile_url = $profileUrl;

            $infoUser = DB::table('finance_users')
                ->where('id_users', $user->id)
                ->select('saldo','saldo_misi','withdrawal_password')
                ->first();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data retrieved successfully',
                'data'    => [
                    'user'      => $user,
                    'info_user' => $infoUser,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error','message'=>'Invalid token or unauthorized'], 401);
        }
    }

    
public function getDataBoost(Request $request)
{
    $token = $request->header('Authorization');
    if (!$token) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Token is missing',
        ], 401);
    }

    try {
        $secretKey = config('jwt.secret');
        $decoded   = \Firebase\JWT\JWT::decode(
            str_replace('Bearer ', '', $token),
            new \Firebase\JWT\Key($secretKey, 'HS256')
        );
        $uid = $decoded->uid;

        // Ambil user
        $user = DB::table('users')
            ->where('uid', $uid)
            ->select('id','uid','name','phone_email','profile')
            ->first();

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'User not found',
            ], 404);
        }

        // Bangun URL publik untuk avatar
        $profileUrl = null;
        if (!empty($user->profile)) {
            $p = ltrim($user->profile, '/');
            // Jika sudah http(s), pakai apa adanya
            if (str_starts_with($p, 'http://') || str_starts_with($p, 'https://')) {
                $profileUrl = $p;
            } else {
                // profiles/... -> /storage/profiles/...
                $profileUrl = asset('storage/'.$p);
            }
        }
        // sisipkan ke objek
        $user->profile_url = $profileUrl;

        // Ambil info finance
        $infoUser = DB::table('finance_users')
            ->where('id_users', $user->id)
            ->select('saldo','saldo_beku','komisi','withdrawal_password','temp_balance','price_akhir','profit_akhir')
            ->first();

        if ($infoUser) {
            $priceAkhir  = (float)($infoUser->price_akhir  ?? 0);
            $profitAkhir = (float)($infoUser->profit_akhir ?? 0);
            $saldoDb     = (float)($infoUser->saldo        ?? 0);

            // Jika ada nilai > 0 pada price/profit akhir, pakai itu; selainnya pakai saldo DB
            if ($priceAkhir > 0 || $profitAkhir > 0) {
                $calculatedSaldo = round($priceAkhir + $profitAkhir, 2);
            } else {
                $calculatedSaldo = round($saldoDb, 2);
            }

            $infoUser->saldo = $calculatedSaldo;
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data retrieved successfully',
            'data'    => [
                'user'      => $user,
                'info_user' => $infoUser,
            ],
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Invalid token or unauthorized',
        ], 401);
    }
}


    public function getDataBoostApps(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is missing',
            ], 401);
        }

        try {
            $secretKey = config('jwt.secret');
            $decoded   = JWT::decode(str_replace('Bearer ', '', $token), new Key($secretKey, 'HS256'));
            $uid       = $decoded->uid;

            $user = DB::table('users')
                ->where('uid', $uid)
                ->select('id', 'uid', 'name', 'phone_email', 'profile')
                ->first();

            if (!$user) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'User not found',
                ], 404);
            }

            $infoUser = DB::table('finance_users')
                ->where('id_users', $user->id)
                ->select('saldo', 'saldo_beku', 'komisi', 'withdrawal_password', 'temp_balance', 'price_akhir', 'profit_akhir')
                ->first();

            // --- Tambahan: ambil akumulasi bonus terdaftar (registered_bonus) untuk user ini
            $registeredBonusTotal = (float) DB::table('registered_bonus')
                ->where('id_users', $user->id)
                ->sum('total_bonus');

            return response()->json([
                'status'  => 'success',
                'message' => 'Data retrieved successfully',
                'data'    => [
                    'user'                    => $user,
                    'info_user'               => $infoUser,
                    'registered_bonus_total'  => $registeredBonusTotal, // <- tambahan
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid token or unauthorized',
            ], 401);
        }
    }

    
    public function bindWallet(Request $request)
    {
        $wallet_address = $request->input('wallet_address');
        $network = $request->input('network');
        $currency = $request->input('currency');
    
        if (!$wallet_address || !is_string($wallet_address)) {
            return response()->json(['error' => 'Field Wallet Address Required'], 400);
        }
    
        if (!$network || !is_string($network)) {
            return response()->json(['error' => 'Network Address Required'], 400);
        }
    
        if (!$currency || !is_string($currency)) {
            return response()->json(['error' => 'Currency Required'], 400);
        }
    
        $jwtToken = $request->header('Authorization');
        if (!$jwtToken) {
            return response()->json(['error' => 'JWT Token tidak ditemukan'], 401);
        }
    
        try {
            $secretKey = config('jwt.secret');
            $decoded = JWT::decode(str_replace('Bearer ', '', $jwtToken), new Key($secretKey, 'HS256'));
            $userId = $decoded->sub;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token tidak valid'], 401);
        }
    
        $affected = DB::table('users')
            ->where('id', $userId)
            ->update([
                'wallet_address' => $wallet_address,
                'network_address' => $network,
                'currency' => $currency,
                'updated_at' => now(),
            ]);
    
        if ($affected === 0) {
            return response()->json(['error' => 'User tidak ditemukan atau tidak diupdate'], 404);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Wallet successfully bound!',
        ], 201);
    }
    
    public function getBindWallet(Request $request)
    {
        // Validasi token dalam header
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is missing',
            ], 401);
        }

        try {
            // Decode token
            $secretKey = config('jwt.secret');
            $decoded = JWT::decode(str_replace('Bearer ', '', $token), new Key($secretKey, 'HS256'));

            // Ambil uid dari payload
            $uid = $decoded->uid;

            // Ambil data user dari tabel users (kolom dasar)
            $user = DB::table('users')
                ->where('uid', $uid)
                ->select('id', 'uid', 'network_address', 'currency', 'wallet_address')
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found',
                ], 404);
            }

            // Jika kolom manual ada di schema dan terisi, gunakan sebagai nilai efektif
            $needManual = false;
            $manualCols = [];
            if (Schema::hasColumn('users', 'network_address_manual')) {
                $needManual = true;
                $manualCols[] = 'network_address_manual';
            }
            if (Schema::hasColumn('users', 'currency_manual')) {
                $needManual = true;
                $manualCols[] = 'currency_manual';
            }

            if ($needManual) {
                $manual = DB::table('users')
                    ->where('uid', $uid)
                    ->select($manualCols)
                    ->first();
                if ($manual) {
                    if (property_exists($manual, 'network_address_manual') && trim((string) $manual->network_address_manual) !== '') {
                        $user->network_address = $manual->network_address_manual;
                    }
                    if (property_exists($manual, 'currency_manual') && trim((string) $manual->currency_manual) !== '') {
                        $user->currency = $manual->currency_manual;
                    }
                }
            }

            // Kembalikan data dalam format JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'data' => [
                    'user' => $user,
                ],
            ]);
        } catch (\Exception $e) {
            // Tangkap error, misalnya token tidak valid
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token or unauthorized',
            ], 401);
        }
    }

    public function requestWithdrawal(Request $request)
{
    $wallet_address      = $request->input('wallet_address');
    $network             = $request->input('network');
    $currency            = $request->input('currency');
    $withdrawal_password = $request->input('withdrawal_password');
    $amount              = $request->input('amount');

    // Validasi awal
    if (!$wallet_address || !is_string($wallet_address)) { return response()->json(['error'=>'Wallet Address Required'],400); }
    if (!$network || !is_string($network))               { return response()->json(['error'=>'Network Address Required'],400); }
    if (!$currency || !is_string($currency))             { return response()->json(['error'=>'Currency Required'],400); }
    if (!$withdrawal_password || !is_string($withdrawal_password)) { return response()->json(['error'=>'Withdrawal Password Required'],400); }
    if (!is_numeric($amount) || $amount <= 0)            { return response()->json(['error'=>'Amount Required'],400); }

    // Jika hanya USDC yang minimal 1:
    // if (strtoupper($currency)==='USDC' && $amount<1) { return response()->json(['error'=>'Minimum withdrawal for USDC is 1'],400); }
    // Versi saat ini: semua currency non-empty minimal 1
    if (strtoupper($currency) && $amount < 1) { return response()->json(['error'=>'Minimum withdrawal for USDC is 1'],400); }

    // JWT
    $jwtToken = $request->header('Authorization');
    if(!$jwtToken){ return response()->json(['error'=>'JWT Token tidak ditemukan'],401); }
    try{
        $secretKey = config('jwt.secret');
        $decoded   = JWT::decode(str_replace('Bearer ','',$jwtToken), new Key($secretKey,'HS256'));
        $userId    = $decoded->sub ?? null;
        if(!$userId){ return response()->json(['error'=>'Token tidak valid'],401); }
    }catch(\Throwable $e){
        return response()->json(['error'=>'Token tidak valid'],401);
    }

    // Jam operasional (ET)
    // $nowET   = Carbon::now('America/New_York');
    // $startET = $nowET->copy()->setTime(10,0,0);
    // $endET   = $nowET->copy()->setTime(22,0,0);
    // if(!$nowET->betweenIncluded($startET,$endET)){
    //     return response()->json(['error'=>'Please Try Again During The Working Hours.'],403);
    // }

    // Limit 1x per hari
    $alreadyWithdrawn = DB::table('withdrawal_users')
        ->where('id_users',$userId)
        ->whereDate('created_at',now())
        ->exists();
    if($alreadyWithdrawn){
        return response()->json(['error'=>'You have already made a withdrawal request today. Please try again tomorrow.'],403);
    }

    try{
        $result = DB::transaction(function() use($userId,$wallet_address,$network,$currency,$withdrawal_password,$amount){
            // Lock finance_users
            $financeUser = DB::table('finance_users')
                ->where('id_users',$userId)
                ->lockForUpdate()
                ->first();
            if(!$financeUser){ throw new \RuntimeException('FINANCE_NOT_FOUND'); }

            // Password WD
            if($financeUser->withdrawal_password !== $withdrawal_password){
                throw new \RuntimeException('WD_PWD_NOT_MATCH');
            }

            // Saldo cukup?
            if((float)$financeUser->saldo < (float)$amount){
                throw new \RuntimeException('INSUFFICIENT_BALANCE');
            }

            // Validasi membership/posisi
            $userRow = DB::table('users')
                ->where('id',$userId)
                ->select('membership','position_set')
                ->first();
            if(!$userRow){ throw new \RuntimeException('USER_NOT_FOUND'); }

            $limitMap = ['Normal'=>40,'Gold'=>50,'Platinum'=>55,'Crown'=>55];
            $posisiSekarang = (int)($limitMap[$userRow->membership ?? 'Normal'] ?? 40);
            $posisiSetUser  = $userRow->position_set;

            $posisiTugasSekarang = (int) (DB::table('transactions_users')
                ->where('id_users',$userId)
                ->where('set',$posisiSetUser)
                ->orderByDesc('urutan')
                ->value('urutan') ?? 0);

            if($posisiSekarang !== $posisiTugasSekarang){
                throw new \RuntimeException('INCOMPLETE_SET');
            }

            // Insert WD
            $wdId = DB::table('withdrawal_users')->insertGetId([
                'id_users'        => $userId,
                'wallet_address'  => $wallet_address,
                'network_address' => $network,
                'currency'        => $currency,
                'amount'          => $amount,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // Kurangi saldo
            $newSaldo = (float)$financeUser->saldo - (float)$amount;
            DB::table('finance_users')
                ->where('id_users',$userId)
                ->update([
                    'saldo'      => $newSaldo,
                    'updated_at' => now(),
                ]);

            return ['wd_id'=>$wdId,'new_saldo'=>$newSaldo];
        });

        return response()->json([
            'status'=>'success',
            'message'=>'Withdrawal successfully!',
            'data'=>$result,
        ],201);

    }catch(\RuntimeException $re){
        $codeMap = [
            'FINANCE_NOT_FOUND'   => [404,'Finance User tidak ditemukan'],
            'WD_PWD_NOT_MATCH'    => [403,'Your Withdrawal Password Not Match'],
            'INSUFFICIENT_BALANCE'=> [400,'Insufficient Balance'],
            'USER_NOT_FOUND'      => [404,'User not found'],
            'INCOMPLETE_SET'      => [403,'Please Complete Your Ongoing Data Set'],
        ];
        $key = $re->getMessage();
        $http = $codeMap[$key][0] ?? 400;
        $msg  = $codeMap[$key][1] ?? $key;
        return response()->json(['error'=>$msg], $http);

    }catch(\Throwable $th){
        return response()->json(['error'=>'Withdrawal failed'],500);
    }
}


    public function changeLoginPassword(Request $request)
    {
        $old = $request->input('old_password');
        $new = $request->input('new_password');
        $retype = $request->input('retype_password');
    
        if (!$old || !$new || !$retype) {
            return response()->json(['error' => 'All fields are required.'], 400);
        }
    
        if ($new !== $retype) {
            return response()->json(['error' => 'New password does not match retype.'], 400);
        }
    
        $jwtToken = $request->header('Authorization');
        if (!$jwtToken) {
            return response()->json(['error' => 'JWT Token not found.'], 401);
        }
    
        try {
            $secretKey = config('jwt.secret');
            $decoded = JWT::decode(str_replace('Bearer ', '', $jwtToken), new Key($secretKey, 'HS256'));
            $userId = $decoded->sub;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }
    
        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
    
        if (!Hash::check($old, $user->password)) {
            return response()->json(['error' => 'Old password is incorrect.'], 403);
        }
    
        DB::table('users')->where('id', $userId)->update([
            'password' => bcrypt($new),
            'updated_at' => now(),
        ]);
    
        return response()->json(['status' => 'success', 'message' => 'Login password updated successfully.']);
    }
    
    public function changeWithdrawalPassword(Request $request)
    {
        $old = $request->input('old_password');
        $new = $request->input('new_password');
        $retype = $request->input('retype_password');
    
        if (!$old || !$new || !$retype) {
            return response()->json(['error' => 'All fields are required.'], 400);
        }
    
        if ($new !== $retype) {
            return response()->json(['error' => 'New password does not match retype.'], 400);
        }
    
        $jwtToken = $request->header('Authorization');
        if (!$jwtToken) {
            return response()->json(['error' => 'JWT Token not found.'], 401);
        }
    
        try {
            $secretKey = config('jwt.secret');
            $decoded = JWT::decode(str_replace('Bearer ', '', $jwtToken), new Key($secretKey, 'HS256'));
            $userId = $decoded->sub;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }
    
        $financeUser = DB::table('finance_users')->where('id_users', $userId)->first();
        if (!$financeUser) {
            return response()->json(['error' => 'Finance user not found.'], 404);
        }
    
        if ($old !== $financeUser->withdrawal_password) {
            return response()->json(['error' => 'Old withdrawal password is incorrect.'], 403);
        }
    
        DB::table('finance_users')->where('id_users', $userId)->update([
            'withdrawal_password' => $new,
            'updated_at' => now(),
        ]);
    
        return response()->json(['status' => 'success', 'message' => 'Withdrawal password updated successfully.']);
    }
    
    public function getAppsRecords(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Token is missing',
            ], 401);
        }

        try {
            $secretKey = config('jwt.secret');
            $decoded   = JWT::decode(str_replace('Bearer ', '', $token), new Key($secretKey, 'HS256'));
            $userId    = $decoded->sub;

            $userExists = DB::table('users')->where('id', $userId)->exists();
            if (!$userExists) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'User not found',
                ], 404);
            }

            $datatransaksi = DB::table('transactions_users')
                ->join('products', 'transactions_users.id_products', '=', 'products.id')
                ->where('transactions_users.id_users', $userId)
                ->orderBy('transactions_users.created_at', 'desc')
                ->select(
                    'transactions_users.id',
                    'transactions_users.id_users',
                    'transactions_users.id_products',
                    'transactions_users.price',
                    'transactions_users.profit',
                    'transactions_users.type',
                    'transactions_users.status',
                    'transactions_users.created_at',
                    'transactions_users.updated_at',
                    // ambil langsung dari kolom ratio_profit dan alias jadi boosted_ratio
                    'transactions_users.ratio_profit as boosted_ratio',
                    'products.product_name',
                    'products.product_image'
                )
                ->get();

            if ($datatransaksi->isEmpty()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Transaction not found',
                ], 404);
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Data retrieved successfully',
                'data'    => $datatransaksi,
            ]);
        } catch (\Firebase\JWT\ExpiredException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Token expired',
            ], 401);
        } catch (\UnexpectedValueException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid token',
            ], 401);
        } catch (\Exception $e) {
            Log::error('getAppsRecords error: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong',
            ], 500);
        }
    }


    public function getFinance(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Token is missing',
            ], 401);
        }

        try {
            $secretKey = config('jwt.secret');
            $decoded   = JWT::decode(str_replace('Bearer ', '', $token), new Key($secretKey, 'HS256'));
            $userId    = $decoded->sub;

            // Ambil semua data deposit untuk user ini
            $deposits = DB::table('deposit_users')
                ->where('id_users', $userId)
                ->orderByDesc('created_at')
                ->get();

            // Ambil semua data withdrawal untuk user ini
            $withdrawals = DB::table('withdrawal_users')
                ->where('id_users', $userId)
                ->orderByDesc('created_at')
                ->get();

            // === Tambahan: total Welcome Bonus dari registered_bonus ===
            $welcomeBonusTotal = (float) DB::table('registered_bonus')
                ->where('id_users', $userId)
                ->sum('total_bonus');

            // (opsional) tanggal bonus terakhir, jika mau ditampilkan
            $welcomeBonusLastAt = DB::table('registered_bonus')
                ->where('id_users', $userId)
                ->max('updated_at');

            return response()->json([
                'status'  => 'success',
                'message' => 'Finance data retrieved successfully',
                'data'    => [
                    'deposits'          => $deposits,
                    'withdrawals'       => $withdrawals,
                    'welcome_bonus'     => [
                        'label'           => 'Welcome Bonus',
                        'amount'          => $welcomeBonusTotal,
                        'last_awarded_at' => $welcomeBonusLastAt, // boleh diabaikan di FE jika tidak dipakai
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid token or unauthorized',
            ], 401);
        }
    }

public function getMembership(Request $request)
{
    $token = $request->header('Authorization');
    if (!$token) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Token is missing',
        ], 401);
    }

    try {
        $secretKey = config('jwt.secret');
        $jwt      = str_replace('Bearer ', '', $token);
        $decoded  = JWT::decode($jwt, new Key($secretKey, 'HS256'));

        // Ambil user berdasar token: utamakan sub (id), fallback ke uid
        $user = null;
        if (isset($decoded->sub)) {
            $user = DB::table('users')
                ->where('id', $decoded->sub)
                ->select('id', 'membership')
                ->first();
        } elseif (isset($decoded->uid)) {
            $user = DB::table('users')
                ->where('uid', $decoded->uid)
                ->select('id', 'membership')
                ->first();
        }

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'User not found',
            ], 404);
        }

        // Sanitasi nilai membership ke salah satu enum yang valid
        $allowed = ['Normal', 'Gold', 'Platinum', 'Crown'];
        $membership = $user->membership ?? 'Normal';
        if (!in_array($membership, $allowed, true)) {
            $membership = 'Normal';
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Membership retrieved successfully',
            'data'    => [
                'membership' => $membership,
            ],
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Invalid token or unauthorized',
        ], 401);
    }
}

        public function getProduk(Request $request)
    {
        // =========================
        // Tahap 1: Ambil & validasi token JWT dari header
        // =========================
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is missing',
            ], 401);
        }

        try {
            // Decode JWT (alg HS256) menggunakan secret dari config
            $secretKey = config('jwt.secret');
            $decoded = JWT::decode(str_replace('Bearer ', '', $token), new Key($secretKey, 'HS256'));

            // Ambil userId dari claim 'sub'
            $userId = $decoded->sub;

            // =========================
            // Tahap 2: Validasi keberadaan user
            // =========================
            $user = DB::table('users')->where('id', $userId)->first();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found',
                ], 404);
            }
            
            // =========================
            // Tahap 3: Validasi status website (settings)
            // =========================
            $setting = DB::table('settings')->first();

            // Jika website ditandai "closed" (libur), hentikan
            if ($setting && $setting->closed == 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Boosting is Unavailable. Please Return During Operational Hours',
                ], 400);
            }

            // Opsi: Validasi jam kerja (dinonaktifkan di kode Anda)
            // if ($setting && $setting->work_time) {
            //     [$startTime, $endTime] = array_map('trim', explode('-', $setting->work_time));
            //     $nowTime = now()->format('H:i');
            //     if (!($nowTime >= $startTime && $nowTime <= $endTime)) {
            //         return response()->json([
            //             'status' => 'error',
            //             'message' => "Please start between $setting->work_time.",
            //         ], 400);
            //     }
            // }

            // =========================
            // Tahap 4: Validasi data keuangan user ✅
            // =========================
            $finance = DB::table('finance_users')->where('id_users', $userId)->first();
            if (!$finance) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Finance data not found',
                ], 404);
            }

            $cekSaldo = $finance->saldo;
            $cekBeku  = $finance->saldo_beku;

            // Jika saldo < 50 dan saldo_beku == 0 → Minimum 50 USDC Required
            if (($cekSaldo < 50 && $cekBeku == 0)) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Minimum 50 USDC Required!',
                ], 400);
            }

            // Aturan baru: jika saldo < 50 DAN saldo_beku < 0 → tolak
            if (($cekSaldo < 50 && $cekBeku < 0)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please check on Apps Record to submit your Pending Data.',
                ], 400);
            }

            // =========================
            // Tahap 5: Tentukan batas tugas harian dari membership & hitung sisa ✅
            // =========================
            $today       = now()->toDateString();
            $positionSet = $user->position_set;
            $membership  = $user->membership;

            // Peta limit harian per membership
            $limitMap = [
                'Normal'   => 40,
                'Gold'     => 50,
                'Platinum' => 55,
                'Crown'    => 55,
            ];

            // === Tambahan: profit rate per membership ===
            $profitRateMap = [
                'Normal'   => ['normal' => 0.005, 'combo' => 0.05],  // 0.5% / 5%
                'Gold'     => ['normal' => 0.006, 'combo' => 0.06],  // 0.6% / 6%
                'Platinum' => ['normal' => 0.008, 'combo' => 0.08],  // 0.8% / 8%
                'Crown'    => ['normal' => 0.010, 'combo' => 0.10],  // 1.0% / 10%
            ];

            $profitRateNormal = $profitRateMap[$membership]['normal'] ?? 0.005; // default Normal
            $profitRateCombo  = $profitRateMap[$membership]['combo']  ?? 0.05;
            
            $formatPercent = function (float $rate): string {
                $pct = $rate * 100;
                // pakai presisi 3 lalu trim nol & titik
                $str = rtrim(rtrim(number_format($pct, 3, '.', ''), '0'), '.');
                return $str . '%';
            };// default Normal

            // Default 0 jika membership di luar peta
            $sisaTugas = $limitMap[$membership] ?? 0;

            // Ambil kelompok transaksi "belum selesai" (status=0) untuk hari ini berdasarkan urutan & type
            $groups = DB::table('transactions_users')
                ->where('id_users', $userId)
                ->where('set', $positionSet)
                ->where('status', 0)
                ->whereDate('created_at', $today)
                ->select('urutan', 'type')
                ->distinct()
                ->get();

            // Hitung total tugas yang sudah dibuat (status=0 hari ini dianggap "sudah dibuat")
            $tugasSelesai  = $groups->count();
            $tugasSekarang = $sisaTugas - $tugasSelesai;

            // Jika kuota habis → optionally absen (khusus position_set=2) lalu hentikan
            if ($tugasSekarang <= 0) {
                if ((int) $positionSet === 3) {
                    return response()->json([
                        'message' => "You’ve Reached Your Daily Limit of 3 Sets Data",
                    ], 422);
                }

                return response()->json([
                    'message' => 'Reset Required! Please Contact Customer Service',
                ], 422);
            }

            if ($tugasSekarang <= 1 && (int) $positionSet === 2) {
                    // Hitung total absen penyelesaian (tanpa filter tanggal)
                    $totalAbsen = DB::table('absen_users')
                        ->where('id_users', $userId)
                        ->count();

                    // Insert jika total belum mencapai 5
                    if ($totalAbsen < 5) {
                        DB::table('absen_users')->insert([
                            'id_users'   => $userId,
                            'created_at' => now(),
                        ]);
                    }
                }


            // =========================
            // Tahap 6: Jika ada transaksi aktif (status=1) hari ini → kembalikan agar "resume" ✅
            // =========================
            $existing = DB::table('transactions_users')
                ->where('id_users', $userId)
                ->where('status', 1)
                ->whereDate('created_at', $today)
                ->orderByDesc('created_at')
                ->first();

            if ($existing) {
                if ($existing->type === 'combination') {
                    // Ambil semua transaksi combination (status=1) hari ini
                    $combinationTransactions = DB::table('transactions_users')
                        ->where('id_users', $userId)
                        ->where('status', 1)
                        ->where('type', 'combination')
                        ->whereDate('created_at', $today)
                        ->get();

                    if ($combinationTransactions->isNotEmpty()) {
                        // Ambil produk terkait
                        $productIds = $combinationTransactions->pluck('id_products')->toArray();
                        $products = DB::table('products')
                            ->whereIn('id', $productIds)
                            ->select('id', 'product_name', 'product_image')
                            ->get()
                            ->keyBy('id');

                        // Pilih transaksi berharga terbesar sebagai "representatif"
                        $highestTransaction = $combinationTransactions->sortByDesc('price')->first();
                        $highestProduct = $products[$highestTransaction->id_products] ?? null;

                        // Hitung total price & profit seluruh combination hari ini
                        $totalPrice  = $combinationTransactions->sum('price');
                        $totalProfit = $combinationTransactions->sum('profit');

                        if ($highestProduct) {
                            return response()->json([
                                'status'  => 'success',
                                'message' => 'Boost combination data retrieved successfully',
                                'data'    => (object) [
                                    'id'            => $highestProduct->id,
                                    'product_name'  => $highestProduct->product_name,
                                    'product_image' => $highestProduct->product_image,
                                    'price'         => round($totalPrice, 2),
                                    'profit'        => round($totalProfit, 2),
                                ],
                            ]);
                        }
                    }
                } else {
                    // existing type normal → kembalikan produk tunggalnya
                    $product = DB::table('products')
                        ->where('id', $existing->id_products)
                        ->select('id', 'product_name', 'product_image')
                        ->first();

                    if ($product) {
                        return response()->json([
                            'status'  => 'success',
                            'message' => 'Boost data retrieved successfully',
                            'data'    => (object) [
                                'id'            => $product->id,
                                'product_name'  => $product->product_name,
                                'product_image' => $product->product_image,
                                'price'         => $existing->price,
                                'profit'        => $existing->profit,
                            ],
                        ]);
                    }
                }
            }

            // =========================
            // Tahap 7: Hitung ulang urutan (sequence) dengan mempertimbangkan combination yang sudah ada hari ini
            // =========================
            // Jumlah "kelompok combination" unik (berdasarkan urutan)
            $jumlahCombination = DB::table('transactions_users')
                ->where('id_users', $userId)
                ->where('set', $positionSet)
                ->whereDate('created_at', $today)
                ->distinct('urutan')
                ->where('type', 'combination')
                ->count();

            if ($jumlahCombination > 0) {
                // 1) urutan terbesar pada transactions_users untuk user+set (hari ini)
                $getUrutanSekarang = (int) (
                    DB::table('transactions_users')
                        ->where('id_users', $userId)
                        ->where('set', $positionSet)
                        ->max('urutan') ?? 0
                );

                // 2) sequence terkecil pada combination_users untuk user+set
                $getUrutanKombinasiSekarang = (int) (
                    DB::table('combination_users')
                        ->where('id_users', $userId)
                        ->where('set_boost', $positionSet)
                        ->min('sequence') ?? 0
                );

                // 3) selisih urutan (jika negatif jadikan positif)
                $selisihUrutan = abs($getUrutanSekarang - $getUrutanKombinasiSekarang);

                // 4) urutanTransaksi = urutan sekarang + 1
                $urutanTransaksi = $getUrutanSekarang + 1;

                // 5) nextUrutan = (urutanTransaksi - 1) + selisihUrutan
                $nextUrutan = $urutanTransaksi + 1;
                $targetSequence = (int)$urutanTransaksi; // ?
            } else {
                // Jika belum ada combination, ambil urutan maksimum saat ini
                $geturutanTransaksi = DB::table('transactions_users')
                    ->where('id_users', $userId)
                    ->where('set', $positionSet)
                    ->whereDate('created_at', $today)
                    ->max('urutan') ?? 0;

                $urutanTransaksi = $geturutanTransaksi + 1; // Dimulai dari 0 + 1
                $nextUrutan = $urutanTransaksi + 1; // Urutan pertama + 1

                $targetSequence = $urutanTransaksi;
            }

            // =========================
            // Tahap 8: Coba bentuk transaksi "combination" baru berdasarkan tabel combination_users
            // =========================
            $combinationData = DB::table('combination_users')
                ->where('id_users', $userId)
                ->get();

            $selectedProducts = [];
            $totalKombinasi   = count($combinationData);

            // Ambil saldo terbaru untuk perhitungan price/profit
            $userFinance = DB::table('finance_users')->where('id_users', $userId)->first();
            $saldo = $userFinance->saldo ?? 0;

            $comboIndex = 0; // index item dalam kombinasi yang sedang dibentuk

            foreach ($combinationData as $item) {
                // Filter baris config: harus sesuai set_boost dan sequence
                if ((int)$item->set_boost === (int)$positionSet && (int)$item->sequence === $targetSequence) {

                    // Ambil info produk
                    $product = DB::table('products')
                        ->where('id', $item->id_produk)
                        ->select('id', 'product_name', 'product_image')
                        ->first();

                    if ($product) {
                        // Skema persentase harga per urutan item di kombinasi
                        // (0) 60%, (1) 65%, (2) 75%, default 60%
                        $percentage = match ($comboIndex) {
                            0 => 0.75,
                            1 => 0.70,
                            2 => 0.65,
                            default => 0.75,
                        };

                        // Hitung price & profit item kombinasi
                        $unitPrice  = round($saldo * $percentage, 2);
                        $unitProfit = round($unitPrice * $profitRateCombo, 2);

                        // Kumpulkan item terpilih
                        $selectedProducts[] = (object) [
                            'id'            => $product->id,
                            'product_name'  => $product->product_name,
                            'product_image' => $product->product_image,
                            'price'         => $unitPrice,
                            'profit'        => $unitProfit,
                        ];

                        $comboIndex++;
                    }
                }
            }

            if (!empty($selectedProducts)) {
                foreach ($selectedProducts as $product) {
                    DB::table('transactions_users')->insert([
                        'id_users'    => $userId,
                        'id_products' => $product->id,
                        'set'         => $positionSet,
                        'type'        => 'combination',
                        'price'       => $product->price,
                        'profit'      => $product->profit,
                        'ratio_profit' => $formatPercent($profitRateCombo),
                        'status'      => 1,            // dianggap aktif/siap diproses
                        'urutan'      => $urutanTransaksi,  // semua item satu kelompok urutan yang sama
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }

                // Pilih item combination dengan price terbesar sebagai representatif
                $highestProduct = collect($selectedProducts)->sortByDesc('price')->first();

                // Total kumulatif price & profit dari semua item kombinasi
                $totalPrice  = collect($selectedProducts)->sum('price');
                $totalProfit = collect($selectedProducts)->sum('profit');

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Boost combination data retrieved successfully',
                    'data'    => (object) [
                        'id'                   => $highestProduct->id,
                        'product_name'         => $highestProduct->product_name,
                        'product_image'        => $highestProduct->product_image,
                        'price'                => round($totalPrice, 2),
                        'profit'               => round($totalProfit, 2),
                        'urutanSekarang'      => $urutanTransaksi, // ?
                        'nextUrutan'        => $nextUrutan, // ?
                        'targetSequence'       => $targetSequence, // ?
                    ],
                ]);
            }

            // =========================
            // Tahap 9: Fallback → pilih 1 produk "normal" acak (belum pernah dipakai hari ini)
            // =========================
            $usedProductIds = DB::table('transactions_users')
                ->where('id_users', $userId)
                ->whereDate('created_at', $today)
                ->pluck('id_products')
                ->toArray();

            // Pilih produk acak yang belum terpakai hari ini
            $randomProduct = DB::table('products')
                ->whereNotIn('id', $usedProductIds)
                ->inRandomOrder()
                ->select('id', 'product_name', 'product_image')
                ->first();

            if ($randomProduct) {
                // Skema pricing normal: 35% dari saldo, profit 0.5%
                $unitPrice  = round($saldo * 0.35, 2);
                $unitProfit = round($unitPrice * $profitRateNormal, 3);

                $product = (object) [
                    'id'            => $randomProduct->id,
                    'product_name'  => $randomProduct->product_name,
                    'product_image' => $randomProduct->product_image,
                    'price'         => round($unitPrice, 2),
                    'profit'        => round($unitProfit, 2),
                    'nextUrutan'   => $nextUrutan,
                    'targetSequence' => $targetSequence, // ?
                ];

                // Simpan transaksi normal (status=1)
                DB::table('transactions_users')->insert([
                    'id_users'    => $userId,
                    'id_products' => $product->id,
                    'set'         => $positionSet,
                    'type'        => 'normal',
                    'price'       => $product->price,
                    'profit'      => $product->profit,
                    'ratio_profit' => $formatPercent($profitRateNormal),
                    'status'      => 1,
                    'urutan'      => $urutanTransaksi,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Boost normal product retrieved successfully',
                    'data'    => $product,
                ]);
            }

            // Jika tidak ada produk sama sekali
            return response()->json([
                'status'  => 'error',
                'message' => 'No product found',
            ], 404);

        } catch (\Firebase\JWT\ExpiredException $e) {
            // Token kadaluarsa
            return response()->json([
                'status'  => 'error',
                'message' => 'Token expired',
            ], 401);
        } catch (\UnexpectedValueException $e) {
            // Token tidak valid (format/signature)
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid token',
            ], 401);
        } catch (\Exception $e) {
            // Guard fallback error umum
            Log::error('getProduk error: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong',
            ], 500);
        }
    }


    public function submitProduk(Request $request)
    {
        $request->validate([
            'id_products' => 'required|integer',
            'price' => 'required|numeric|min:0',
            'profit' => 'required|numeric|min:0',
        ]);
    
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is missing',
            ], 401);
        }
    
        try {
            $secretKey = config('jwt.secret');
            $decoded = JWT::decode(str_replace('Bearer ', '', $token), new Key($secretKey, 'HS256'));
            $userId = $decoded->sub;
    
            $price = $request->price;
            $profit = $request->profit;
            
            $user = DB::table('users')->where('id', $userId)->first();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found',
                ], 404);
            }
    
            $finance = DB::table('finance_users')->where('id_users', $userId)->first();
            if (!$finance) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Finance data not found',
                ], 404);
            }
    
            $saldo = $finance->saldo;
            $newBeku = $finance->saldo_beku;
    
            // CASE 1: saldo minus
            if (($saldo - $price) < 0 && $saldo < 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You need minimum 50 USDC balance to start boost',
                ], 400);
            }
    
            // CASE 2: Saldo lebih dari atau sama dengan price atau slado = 0 dan saldo beku lebih dari 0
            if (($saldo >= $price) || ($saldo == 0 && $newBeku > 0 )) {
                // Cek tipe transaksi berdasarkan id_products
                $transaction = DB::table('transactions_users')
                    ->where('id_users', $userId)
                    ->where('id_products', $request->id_products)
                    ->whereDate('created_at', now()->toDateString())
                    ->first();
                
                if ($transaction) {
                    if ($transaction->type === 'combination') {
                        // Jika combination, update semua yang status 1
                        DB::table('transactions_users')
                            ->where('id_users', $userId)
                            ->where('type', 'combination')
                            ->where('status', 1)
                            ->whereDate('created_at', now()->toDateString())
                            ->update([
                                'status' => 0,
                                'updated_at' => now(),
                            ]);
                        
                        // Jika kombinasi
                        DB::table('finance_users')->where('id_users', $userId)->update([
                            'saldo' => $newBeku + $profit,
                            'saldo_beku' => 0,
                            'saldo_misi' => $finance->saldo_misi + $profit,
                            'temp_balance' => 0,
                            'price_akhir' => 0,
                            'profit_akhir' => 0,
                            'updated_at' => now(),
                        ]);
                        
                        $combinationExists = DB::table('combination_users')
                            ->where('id_users', $userId)
                            ->exists();
                        
                        $positionSet = $user->position_set;
                        
                        if ($combinationExists) {
                            $productIds = is_array($request->id_products) ? $request->id_products : [$request->id_products];

                            DB::beginTransaction();
                            try {
                                foreach ($productIds as $pid) {
                                    // Cari baris acuan untuk tahu sequence & set_boost-nya
                                    $ref = DB::table('combination_users')
                                        ->where('id_users', $userId)
                                        ->where('id_produk', $pid)
                                        ->first();

                                    if ($ref) {
                                        // Hapus semua baris dengan user, set_boost, dan sequence yang sama
                                        DB::table('combination_users')
                                            ->where('id_users', $userId)
                                            ->where('set_boost', $ref->set_boost)
                                            ->where('sequence', $ref->sequence)
                                            ->delete();
                                    }
                                }

                                DB::commit();
                            } catch (\Throwable $e) {
                                DB::rollBack();
                                // Opsional: Log error
                                // Log::error('Delete combination group failed: '.$e->getMessage());
                                return back()->with('error', 'Gagal menghapus kombinasi.');
                            }
                        }

                    } else {
                        // Jika normal, update satu transaksi saja
                        DB::table('transactions_users')
                            ->where('id_users', $userId)
                            ->where('id_products', $request->id_products)
                            ->whereDate('created_at', now()->toDateString())
                            ->update([
                                'status' => 0,
                                'updated_at' => now(),
                            ]);
                        
                        DB::table('finance_users')->where('id_users', $userId)->update([
                            'saldo' => $saldo + $profit,
                            'saldo_misi' => $finance->saldo_misi + $profit,
                            'updated_at' => now(),
                        ]);
                    }
                }
    
                // Komisi referral (jika ada)
                // $user = DB::table('users')->where('id', $userId)->first();
                // if ($user && $user->referral_upline) {
                //     $upline = DB::table('users')->where('referral', $user->referral_upline)->first();
                //     if ($upline) {
                //         $komisiAmount = number_format($profit * 0.2, 2, '.', '');
                
                //         DB::table('finance_users')
                //             ->where('id_users', $upline->id)
                //             ->update([
                //                 'komisi' => DB::raw("komisi + {$komisiAmount}"),
                //                 'saldo' => DB::raw("saldo + {$komisiAmount}"),
                //                 'updated_at' => now(),
                //             ]);
                //     }
                // }
    
        
                return response()->json([
                    'status' => 'success',
                    'message' => 'Submitted Successfully',
                ]);
            }
            
            // CASE 3: saldo tidak cukup tapi masih > 0
            if ($saldo < $price && $saldo !== 0) {
                $updateData = [
                    'temp_balance' => $saldo,
                    'price_akhir' => $price,
                    'profit_akhir' => $profit,
                    'saldo' => $saldo - $price,
                    'saldo_beku' => $saldo,
                    'updated_at' => now(),
                ];
                
                // Komisi referral (jika ada)
                $user = DB::table('users')->where('id', $userId)->first();
                if ($user && $user->referral_upline) {
                    $upline = DB::table('users')->where('referral', $user->referral_upline)->first();
                    if ($upline) {
                        $komisiAmount = number_format($profit * 0.2, 2, '.', '');
                
                        DB::table('finance_users')
                            ->where('id_users', $upline->id)
                            ->update([
                                'komisi' => DB::raw("komisi + {$komisiAmount}"),
                                'saldo' => DB::raw("saldo + {$komisiAmount}"),
                                'updated_at' => now(),
                            ]);
                    }
                }
            
                DB::table('finance_users')->where('id_users', $userId)->update($updateData);
            
                return response()->json([
                    'status' => 'error',
                    'message' => 'Insufficient Balance',
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('submitProduk error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
            ], 500);
        }
    }

    public function financeBoost(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is missing',
            ], 401);
        }
    
        try {
            $secretKey = config('jwt.secret');
            $decoded = JWT::decode(str_replace('Bearer ', '', $token), new Key($secretKey, 'HS256'));
            $userId = $decoded->sub;
    
            $user = DB::table('users')->where('id', $userId)->first();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found',
                ], 404);
            }
    
            $today = now()->toDateString();
            $positionSet = $user->position_set;
            $membership = $user->membership;
    
            $limitMap = [
                'Normal' => 40,
                'Gold' => 50,
                'Platinum' => 55,
                'Crown' => 55,
            ];
    
            $sisaTugas = $limitMap[$membership] ?? 0;
    
            // Hitung tugas selesai: deret 'combination' berurutan dihitung 1
            $types = DB::table('transactions_users')
                ->where('id_users', $userId)
                ->where('set', $positionSet)
                ->where('status', 0)
                ->whereDate('created_at', $today)
                ->orderBy('urutan')       // jaga urutan grup
                ->orderBy('created_at')   // fallback urutan waktu
                ->orderBy('id')           // penentu terakhir agar stabil
                ->pluck('type');

            $tugasSelesai = 0;
            $prev = null;

            foreach ($types as $type) {
                if ($type === 'combination') {
                    // hanya tambah saat awal deret combination
                    if ($prev !== 'combination') {
                        $tugasSelesai++;
                    }
                } else {
                    // selain combination selalu dihitung 1
                    $tugasSelesai++;
                }
                $prev = $type;
            }
    
            $tugasSekarang = $sisaTugas - $tugasSelesai;
    
            $totalBalance = DB::table('finance_users')
                ->where('id_users', $userId)
                ->value('saldo');
            
            $totalFrozen = DB::table('finance_users')
                ->where('id_users', $userId)
                ->value('saldo_beku');
            
            $priceAkhir = DB::table('finance_users')
                ->where('id_users', $userId)
                ->value('price_akhir');
            
            $tempBalance = DB::table('finance_users')
                ->where('id_users', $userId)
                ->value('temp_balance');
                
            $profitAkhir = DB::table('finance_users')
                ->where('id_users', $userId)
                ->value('profit_akhir');
                
            $profitToday = DB::table('transactions_users')
                ->where('id_users', $userId)
                ->where('status', 0)
                ->whereDate('created_at', $today)
                ->sum('profit');
    
            return response()->json([
                'status' => 'success',
                'message' => 'Finance data retrieved',
                'data' => [
                    'total_balance' => $totalBalance,
                    'profit_today' => $profitToday,
                    'task_done' => $tugasSelesai,
                    'task_remaining' => $tugasSekarang,
                    'task_limit' => $sisaTugas,
                    'temp_balance' => $tempBalance ?? 0,
                    'price_akhir' => $priceAkhir ?? 0,
                    'profit_akhir' => $profitAkhir ?? 0,
                    'total_frozen' => $totalFrozen ?? 0,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('financeBoost error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
            ], 500);
        }
    }

    // API: get user's combinations grouped by set
    public function getUserCombinations(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Token is missing'], 401);
        }

        try {
            $secretKey = config('jwt.secret');
            $decoded = JWT::decode(str_replace('Bearer ', '', $token), new Key($secretKey, 'HS256'));
            $userId = $decoded->sub;

            $rows = DB::table('combination_users')
                ->where('id_users', $userId)
                ->orderBy('set_boost')
                ->orderBy('sequence')
                ->get();

            $result = [];
            foreach ($rows as $r) {
                $result[$r->set_boost][$r->sequence][] = $r->id_produk;
            }

            return response()->json(['status' => 'success', 'data' => $result]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Invalid token or unauthorized'], 401);
        }
    }

    // API: update user's combinations for a set (replace existing)
    public function updateUserCombinations(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Token is missing'], 401);
        }

        $request->validate([
            'set_boost' => 'required|integer|in:1,2,3',
            'combinations' => 'required|array|max:5',
            'combinations.*.products' => 'required|array|min:1|max:3',
            'combinations.*.sequence' => 'required|integer|min:0',
        ]);

        try {
            $secretKey = config('jwt.secret');
            $decoded = JWT::decode(str_replace('Bearer ', '', $token), new Key($secretKey, 'HS256'));
            $userId = $decoded->sub;

            // Delete existing combinations for this set
            DB::table('combination_users')
                ->where('id_users', $userId)
                ->where('set_boost', $request->set_boost)
                ->delete();

            foreach ($request->combinations as $combo) {
                $seq = max(0, (int)$combo['sequence']);
                foreach ($combo['products'] as $pid) {
                    DB::table('combination_users')->insert([
                        'id_users' => $userId,
                        'id_produk' => $pid,
                        'sequence' => $seq,
                        'set_boost' => $request->set_boost,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Combinations updated']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Invalid token or unauthorized'], 401);
        }
    }

}
