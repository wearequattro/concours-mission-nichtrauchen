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
        Setting::all()->each(function (Setting $s) use ($request) {
            return $s->update([
                'value' => isset($request->get('setting')[$s->key]) && $request->get('setting')[$s->key] === "on",
            ]);
        });
        return redirect()->route('admin.settings');
    }

}