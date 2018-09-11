<?php

namespace App\Http\Controllers;

use App\PartyGroup;

class AdminController extends Controller {

    public function dashboard() {
        return view('admin.dashboard');
    }

}
