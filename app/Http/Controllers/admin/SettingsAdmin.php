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
            'work_time_start' => 'required|date_format:H:i',
            'work_time_end' => 'required|date_format:H:i',
            'timezone' => 'required|string',
            'closed' => 'required|in:0,1',
        ]);
    
        $workTime = $request->work_time_start . ' - ' . $request->work_time_end;
    
        $existing = DB::table('settings')->first();
    
        if ($existing) {
            DB::table('settings')->update([
                'work_time' => $workTime,
                'timezone' => $request->timezone,
                'closed' => $request->closed,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('settings')->insert([
                'work_time' => $workTime,
                'timezone' => $request->timezone,
                'closed' => $request->closed,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        return redirect()->back()->with('success', 'Settings saved successfully.');
    }

}