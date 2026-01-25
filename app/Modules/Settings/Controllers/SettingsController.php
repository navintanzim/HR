<?php

namespace App\Modules\Settings\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Settings\Models\Settings;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::all()->pluck('value', 'key')->toArray();
        return view('settings::index', compact('settings'));
    }

    public function update(Request $request)
    {
        
        Settings::updateOrCreate(
            ['key' => 'Timezone'],
            ['value' => $request->input('timezone')]
        );

     
        Settings::updateOrCreate(
            ['key' => 'office_hours'],
            ['value' => ['start_time' => $request->input('office_start_time')]]
        );

     
        Settings::updateOrCreate(
            ['key' => 'attendance_windows'],
            ['value' => $request->input('attendance_windows')]
        );

    
        Settings::updateOrCreate(
            ['key' => 'leave_policy'],
            ['value' => $request->input('leave_policy')]
        );

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
