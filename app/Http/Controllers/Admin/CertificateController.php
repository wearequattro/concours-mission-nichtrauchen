<?php
namespace App\Http\Controllers\Admin;

use App\Certificate;
use App\Http\Controllers\Controller;
use App\Http\Managers\SchoolClassManager;
use App\SchoolClass;

class CertificateController extends Controller {

    /**
     * @var SchoolClassManager
     */
    private $classManager;

    public function __construct(SchoolClassManager $classManager) {
        $this->classManager = $classManager;
    }

    public function index() {
        $classes = SchoolClass::all()->filter(function (SchoolClass $class) {
            return $class->isEligibleForCertificate();
        });
        return view('admin.certificates')->with(compact('classes'));
    }

    public function generate(SchoolClass $class) {
        $this->classManager->generateCertificate($class);
        \Session::flash('message', 'Certificat géneré avec succès');
        return redirect()->route('admin.certificates');
    }

    public function delete(Certificate $certificate) {
        $certificate->delete();
        \Session::flash('message', 'Certificat supprimé avec succès');
        return redirect()->route('admin.certificates');
    }

    public function download(Certificate $certificate) {
        return \Storage::download($certificate->url);
    }

    public function generateAll() {
        dd("todo");
    }

}