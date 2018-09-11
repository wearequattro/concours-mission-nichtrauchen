<?php
namespace App\Http\Controllers\Admin;

use App\Document;
use App\Http\Requests\AdminDocumentUploadRequest;
use Illuminate\Support\Facades\Storage;

class DocumentController {

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

    public function documentsToggleVisibility(Document $document) {
        $document->update([
            'visible' => !$document->visible
        ]);
        return redirect()->route('admin.documents');
    }

    public function documentsDownload(Document $document) {
        return Storage::download($document->filename);
    }

    public function documentsDelete(Document $document) {
        Storage::delete($document->filename);
        $document->delete();
        return redirect()->route('admin.documents');
    }

}