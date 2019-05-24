<?php
namespace App\Http\Controllers\Admin;


use App\Http\Managers\SchoolClassManager;
use App\Http\Requests\PartyGroupRegistrationRequest;
use App\PartyGroup;
use App\SchoolClass;
use App\User;
use Auth;
use Illuminate\Validation\ValidationException;

class PartyController {

    /**
     * @var SchoolClassManager
     */
    private $classManager;

    public function __construct(SchoolClassManager $classManager) {
        $this->classManager = $classManager;
    }

    public function party() {
        $groups = PartyGroup::all();
        $eligibleForParty = $this->classManager->findClassesMissingPartyGroups()->sortBy('name');

        return view('admin.party')->with([
            'groups' => $groups,
            'eligibleForParty' => $eligibleForParty,
        ]);
    }

    function partyClass(SchoolClass $class) {
        abort_if(Auth::user()->type !== User::TYPE_ADMIN, 403);

        return view('admin.party-edit')->with([
            'class' => $class,
            'groups' => $class->partyGroups,
        ]);
    }

    function partyClassPost(PartyGroupRegistrationRequest $request, SchoolClass $class) {
        abort_if(Auth::user()->type !== User::TYPE_ADMIN, 403);

        $data = $request->validated()['class'];
        if (collect($data)->sum('students') > $class->students) {
            $errors = [];
            for ($i = 0; $i < sizeof($data); $i++) {
                $errors['class.'.$i.'.students'] = ['La somme des élèves des groupes doit être égale ou inférieure au nombre d\'élèves de la classe'];
            }
            throw ValidationException::withMessages($errors);
        }
        $class->partyGroups()->delete();
        for ($i = 0; $i < sizeof($data); $i++) {
            $name = $data[$i]['name'];
            $language = $data[$i]['language'];
            $students = $data[$i]['students'];
            if($name == null || $language == null || $students == null)
                continue;
            if($i >= $class->getMaxGroups()) // dont add more than allowed
                continue;
            PartyGroup::create([
                'name' => $name,
                'students' => $students,
                'language' => $language,
                'school_class_id' => $class->id,
            ]);
        }
        \Log::info('Teacher ' . $class->teacher->full_name . ' registered ' . sizeof($data) . ' groups to the final party');
        return redirect()->route('admin.party');
    }

    public function deleteGroup(PartyGroup $group) {
        abort_if(Auth::user()->type !== User::TYPE_ADMIN, 403);
        $group->delete();
        return redirect()->route('admin.party');
    }

}