<?php
namespace App\Http\Controllers\Admin;

use App\EditableEmail;
use App\Http\Requests\AdminEmailsUpdateRequest;
use App\PlaceHolder;
use Illuminate\Support\Facades\Session;

class EmailController {

    public function emails() {
        return view('admin.emails')->with([
            'emails' => EditableEmail::all(),
        ]);
    }

    public function emailsEdit(EditableEmail $email) {
        $placeholders = EditableEmail::getPlaceholders()
            ->map(function (PlaceHolder $placeHolder) {
                return [
                    'text' => !empty($placeHolder->description) ? $placeHolder->description : $placeHolder->previewValue,
                    'preview' => $placeHolder->previewValue,
                    'value' => $placeHolder->key,
                ];
            });
        return view('admin.emails-edit')->with([
            'email' => $email,
            'placeholders' => $placeholders,
        ]);
    }

    public function emailsEditPost(AdminEmailsUpdateRequest $request, EditableEmail $email) {
        $email->update($request->validated());
        Session::flash('message', 'Mise à jour réussie');
        return redirect()->route('admin.emails');
    }

}