<?php

namespace App\Http\Controllers;

use App\SchoolClass;
use Illuminate\Http\Request;

class ExternalController extends Controller {

    public function classes() {
        return view('external.classes')->with([
            'classes' => SchoolClass::all()->sortBy(function (SchoolClass $class) {
                return $class->school->name . $class->teacher->last_name;
            }),
        ]);
    }

}
