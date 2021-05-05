<?php

namespace App\Http\Controllers\Admin;

use App\Certificate;
use App\Http\Controllers\Controller;
use App\Http\Managers\SchoolClassManager;
use App\Http\Repositories\SchoolClassRepository;
use App\Jobs\GenerateAllCertificatesJob;
use App\Jobs\GenerateMissingCertificatesJob;
use App\Jobs\SendElegibleClassesCertificateMail;
use App\SchoolClass;
use Cache;

class CertificateController extends Controller
{

    /**
     * @var SchoolClassManager
     */
    private $classManager;

    /**
     * @var SchoolClassRepository
     */
    private $classRepository;

    public function __construct(SchoolClassManager $classManager, SchoolClassRepository $classRepository)
    {
        $this->classManager = $classManager;
        $this->classRepository = $classRepository;
    }

    public function index()
    {
        $classesEligible = $this->classRepository->findEligibleForCertificate();
        $classesHaving = $this->classRepository->findHavingCertificate();
        $eligibleHaving = $classesEligible->intersect($classesHaving);
        $eligibleMissing = $this->classRepository->findEligibleButMissingCertificate();
        $classes = $classesEligible->concat($classesHaving)->unique();
        return view('admin.certificates')->with(compact('classes', 'classesEligible', 'eligibleHaving', 'eligibleMissing'));
    }

    public function generate(SchoolClass $class)
    {
        $this->classManager->generateCertificate($class);
        \Session::flash('message', 'Certificat géneré avec succès');
        return redirect()->route('admin.certificates');
    }

    public function delete(Certificate $certificate)
    {
        $certificate->delete();
        \Session::flash('message', 'Certificat supprimé avec succès');
        return redirect()->route('admin.certificates');
    }

    public function download(Certificate $certificate)
    {
        return \Storage::download($certificate->url);
    }

    public function generateAll()
    {
        GenerateAllCertificatesJob::dispatch();
        $count = $this->classRepository->findEligibleForCertificate()->count();
        \Session::flash('message', "$count certificats sont maintenant générés. Veuillez patienter quelques minutes.");
        return redirect()->route('admin.certificates');
    }

    public function generateMissing()
    {
        GenerateMissingCertificatesJob::dispatch();
        $count = $this->classRepository->findEligibleButMissingCertificate()->count();
        \Session::flash('message', "$count certificats sont maintenant générés. Veuillez patienter quelques minutes.");
        return redirect()->route('admin.certificates');
    }


    public function sendEmail()
    {
        SendElegibleClassesCertificateMail::dispatch();
        \Session::flash('message', 'Emails envoyés avec succès');
        return redirect()->route('admin.certificates');

    }

}
