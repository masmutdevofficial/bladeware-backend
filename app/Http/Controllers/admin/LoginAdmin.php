<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginAdmin extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        // Cek user di database
        $user = DB::table('users')->where('phone_email', $request->email)->first();
    
        // Jika user ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Simpan sesi login menggunakan Auth
            Auth::loginUsingId($user->id);
    
            // Ambil IP address
            $ipAddress = $request->ip();
    
            // Update IP address di tabel users
            DB::table('users')
                ->where('id', $user->id)
                ->update(['ip_address' => $ipAddress]);
    
            // Simpan log ke log_admin
            DB::table('log_admin')->insert([
                'keterangan' => $user->name . ' has logged in.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin !');
        }
    
        return redirect()->back()->with('error', 'Incorrect email or password.');
    }

    public function logout()
    {
        $user = Auth::user(); // Ambil user sebelum logout

       // Simpan log ke log_admin
        if ($user) {
            DB::table('log_admin')->insert([
                'keterangan' => $user->name . ' has logged out.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        Auth::logout();
        Session::flush();
        return redirect()->route('admin.login')->with('success', 'Logout Successfully.');
    }
}