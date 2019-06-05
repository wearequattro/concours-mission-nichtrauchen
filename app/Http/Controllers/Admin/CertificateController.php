<?php
namespace App\Http\Controllers\Admin;

use App\Certificate;
use App\Http\Controllers\Controller;
use App\Http\Managers\SchoolClassManager;
use App\Http\Repositories\SchoolClassRepository;
use App\Jobs\GenerateCertificatesJob;
use App\SchoolClass;
use Cache;

class CertificateController extends Controller {

    /**
     * @var SchoolClassManager
     */
    private $classManager;

    /**
     * @var SchoolClassRepository
     */
    private $classRepository;

    public function __construct(SchoolClassManager $classManager, SchoolClassRepository $classRepository) {
        $this->classManager = $classManager;
        $this->classRepository = $classRepository;
    }

    public function index() {
        $classes = $this->classRepository->findEligibleForCertificate();
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
        GenerateCertificatesJob::dispatch();
        $count = $this->classRepository->findEligibleForCertificate()->count();
        \Session::flash('message', "$count certificats sont maintenant générés. Veuillez patienter quelques minutes.");
        return redirect()->route('admin.certificates');
    }

}