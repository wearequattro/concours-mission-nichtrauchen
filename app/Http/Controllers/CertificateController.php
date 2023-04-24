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

    public function downloadPage($certificate) {
        $cert = Certificate::where('uid', $certificate)->first();
        return view('external.certificate-download', ['certificate' => $cert]);
        //return \Storage::download($certificate->url);
    }

    public function downloadCertificate($certificate) {
        $cert = Certificate::where('uid', $certificate)->first();
        return \Storage::download($cert->url);
    }

}
