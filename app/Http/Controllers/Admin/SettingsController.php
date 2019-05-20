<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Session;

class SettingsController extends Controller {

    public function index() {
        $settings = Setting::all();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request) {
        collect($request->all()['setting'])
            ->each(function ($val, $key) {
                Setting::findOrFail($key)->update(['value' => $val === 'on']);
            });
        return redirect()->route('admin.settings');
    }

}