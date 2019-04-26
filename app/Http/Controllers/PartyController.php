<?php

namespace App\Http\Controllers;

use App\Http\Managers\SchoolClassManager;
use App\Http\Repositories\SchoolClassRepository;

class PartyController extends Controller {

    /**
     * @var SchoolClassRepository
     */
    private $classRepository;
    /**
     * @var SchoolClassManager
     */
    private $classManager;

    public function __construct(SchoolClassRepository $classRepository, SchoolClassManager $classManager) {
        $this->classRepository = $classRepository;
        $this->classManager = $classManager;
    }

    public function handlePartyResponse(string $token, string $status) {
        $class = $this->classRepository->findByStatusToken($token);
        abort_if(!$class, 404, "Ce lien n'est plus valable.");

        $newStatus = $status === "true";
        $this->classManager->handlePartyResponse($class, $newStatus);

        if($newStatus)
            return redirect()->route('teacher.party');
        return redirect()->route('login.redirect');
    }

}