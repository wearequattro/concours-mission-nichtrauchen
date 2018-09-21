<?php
namespace App\Http\Controllers\Admin;

use App\Document;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminDocumentUploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller {

    public function documents() {
        return view('admin.documents')->with([
            'documents' => Document::all(),
        ]);
    }

    public function documentsPost(AdminDocumentUploadRequest $request) {
        $data = $request->validated();
        $name = \Storage::putFile("documents", $request->file('file'));

        Document::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'filename' => $name,
        ]);
        return redirect()->route('admin.documents');
    }

    public function documentsToggleVisibility(Request $request, Document $document) {
        $document->update($this->validate($request, [
            'visible_party' => 'required|boolean',
            'visible' => 'required|boolean',
        ]));
        return redirect()->route('admin.documents');
    }

    public function documentsDownload(Document $document) {
        return Storage::download($document->filename, preg_replace('/[^a-z0-9]+/', '-', strtolower($document->title)));
    }

    public function documentsDelete(Document $document) {
        Storage::delete($document->filename);
        $document->delete();
        return redirect()->route('admin.documents');
    }

}