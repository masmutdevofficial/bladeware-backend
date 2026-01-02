<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsAdmin extends Controller
{
    public function index()
    {
        $settings = DB::table('settings')->first();

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'closed' => 'required|in:0,1',
        ]);

        $existing = DB::table('settings')->first();

        if ($existing) {
            DB::table('settings')->update([
                'closed' => $request->closed,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('settings')->insert([
                'closed' => $request->closed,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Settings saved successfully.');
    }

}
