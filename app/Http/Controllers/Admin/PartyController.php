<?php
namespace App\Http\Controllers\Admin;


use App\PartyGroup;

class PartyController {

    public function party() {
        $groups = PartyGroup::all()->groupBy('school_class_id');

        return view('admin.party')->with([
            'groups' => $groups,
        ]);
    }

}