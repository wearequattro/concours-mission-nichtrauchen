<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminSchoolUpdateRequest;
use App\School;
use Illuminate\Support\Facades\Session;

class SchoolController {

    public function schools() {
        return view('admin.schools')->with([
            'schools' => School::all(),
        ]);
    }

    public function schoolsEdit(School $school) {
        return view('admin.schools-edit')->with([
            'school' => $school,
        ]);
    }

    public function schoolsEditPost(AdminSchoolUpdateRequest $request, School $school) {
        $data = $request->validated();
        $school->update([
            'name' => $data['school_name'],
            'address' => $data['school_address'],
            'postal_code' => $data['school_postal_code'],
            'city' => $data['school_city'],
        ]);
        Session::flash('message', 'Mise à jour réussie');
        return redirect()->route('admin.schools');
    }

}