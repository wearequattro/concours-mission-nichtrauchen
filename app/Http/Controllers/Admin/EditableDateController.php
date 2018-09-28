<?php
namespace App\Http\Controllers\Admin;

use App\EditableDate;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminDateUpdateRequest;
use Illuminate\Http\Request;
use Session;

class EditableDateController extends Controller {

    public function index() {
        return view('admin.dates')->with([
            'dates' => EditableDate::query()->orderBy('value')->get(),
        ]);
    }

    public function update(AdminDateUpdateRequest $request) {
        foreach($request->all()['dates'] as $date) {
            $key = $date['key'];
            $value = $date['value'];
            EditableDate::query()->where('key', $key)->update(['value' => $value]);
        }
        Session::flash('message', 'Mise à jour réussie');
        // If posting from admin.emails then return there, otherwise return to admin.dates
        if(back()->getTargetUrl() == route('admin.emails'))
            return redirect()->route('admin.emails');
        return redirect()->route('admin.dates');
    }

}