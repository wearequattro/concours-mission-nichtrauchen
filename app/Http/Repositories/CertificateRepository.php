<?php
namespace App\Http\Repositories;

use App\Certificate;
use App\Http\Controllers\Controller;

class CertificateRepository extends Controller {

    public function getByUid($uid): ?Certificate {
        return Certificate::query()
            ->where('uid', $uid)
            ->first();
    }

}