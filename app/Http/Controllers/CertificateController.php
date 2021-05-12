<?php
namespace App\Http\Controllers;

use App\Certificate;
use App\Http\Repositories\CertificateRepository;

class CertificateController extends Controller {

    /**
     * @var CertificateRepository
     */
    private $certificateRepository;

    public function __construct(CertificateRepository $certificateRepository) {
        $this->certificateRepository = $certificateRepository;
    }

    public function downloadPage(Certificate $certificate) {
        return view('external.certificate-download', ['certificate' => $certificate]);
        //return \Storage::download($certificate->url);
    }

    public function downloadCertificate(Certificate $certificate) {
        return \Storage::download($certificate->url);
    }

}
