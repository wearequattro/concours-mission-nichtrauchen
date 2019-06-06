<?php
namespace App\Http\Controllers;

use App\Http\Repositories\CertificateRepository;

class CertificateController extends Controller {

    /**
     * @var CertificateRepository
     */
    private $certificateRepository;

    public function __construct(CertificateRepository $certificateRepository) {
        $this->certificateRepository = $certificateRepository;
    }

    public function download($uid) {
        $cert = $this->certificateRepository->getByUid($uid);
        abort_if(!$cert, 404);
        return \Storage::download($cert->url);
    }

}