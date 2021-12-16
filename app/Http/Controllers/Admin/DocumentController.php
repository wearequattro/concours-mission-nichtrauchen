<?php
namespace App\Http\Controllers\Admin;

use App\Document;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminDocumentUpdateRequest;
use App\Http\Requests\AdminDocumentUploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller {

    public function documents() {
        return view('admin.documents')->with([
            'documents' => Document::all()->sortBy('sort'),
        ]);
    }

    public function documentsPost(AdminDocumentUploadRequest $request) {
        $data = $request->validated();
        $name = \Storage::putFile("documents", $request->file('file'));

        Document::createLast(
            $data['title'],
            $data['description'] ?? '',
            $name
        );
        return redirect()->route('admin.documents');
    }

    public function moveUp(Document $document) {
        $document->moveUp();
        return redirect()->route('admin.documents');
    }

    public function moveDown(Document $document) {
        $document->moveDown();
        return redirect()->route('admin.documents');
    }

    public function documentsToggleVisibility(Request $request, Document $document) {
        $document->update($this->validate($request, [
            'visible_party' => 'required|boolean',
            'visible' => 'required|boolean',
            'notification' => 'required|boolean',
        ]));
        return redirect()->route('admin.documents');
    }

    public function documentsDownload(Document $document) {
        return Storage::download($document->filename, $document->getSafeFileNameWithExtension());
    }

    public function documentsDelete(Document $document) {
        Storage::delete($document->filename);
        $document->delete();
        return redirect()->route('admin.documents');
    }

    public function edit(Document $document) {
        return view('admin.documents-edit')->with([
            'document' => $document,
        ]);
    }

    public function editUpdate(AdminDocumentUpdateRequest $request, Document $document) {
        $document->update($request->validated());
        Session::flash('message', 'Mise à jour réussie');
        return redirect()->route('admin.documents');
    }

}
