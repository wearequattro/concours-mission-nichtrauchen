<?php
namespace App\Http\Controllers\Admin;

use App\EditableDate;
use App\EditableEmail;
use App\Http\Requests\AdminDateUpdateRequest;
use App\Http\Requests\AdminEmailsUpdateRequest;
use App\PlaceHolder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class EmailController {

    public function emails() {
        return view('admin.emails')->with([
            // 'emails' => EditableEmail::all()->sortBy(function (EditableEmail $editableEmail) {
            //     if($editableEmail->dates()->first() == null)
            //         return Carbon::maxValue()->timestamp;
            //     return $editableEmail->dates()->first()->value->timestamp;
            // }),
            'emails' => EditableEmail::query()->orderBy('sort_order')->get(),
            // 'dates' => EditableDate::query()->orderBy('value')->get(),
            'dates' => EditableDate::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function emailsEdit(EditableEmail $email) {
        return view('admin.emails-edit')->with([
            'email' => $email,
            'placeholders' => self::getPlaceholdersForView(),
        ]);
    }

    public function emailsEditPost(AdminEmailsUpdateRequest $request, EditableEmail $email) {
        $email->update($request->validated());
        Session::flash('message', 'Mise à jour réussie');
        return redirect()->route('admin.emails');
    }

    public static function getPlaceholdersForView() {
        return PlaceHolder::getPlaceholders()->map(function (PlaceHolder $placeHolder) {
            return [
                'type' => 'choiceitem',
                'text' => !empty($placeHolder->description) ? $placeHolder->description : $placeHolder->previewValue,
                'preview' => $placeHolder->previewValue,
                'value' => $placeHolder->key,
            ];
        });
    }

}
