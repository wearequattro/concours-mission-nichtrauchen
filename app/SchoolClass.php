<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

/**
 * Class SchoolClass
 * @package App
 *
 * @property int id
 * @property string name
 * @property int students
 * @property int school_id
 * @property int teacher_id
 * @property boolean status_january
 * @property boolean status_march
 * @property boolean status_may
 * @property boolean status_party
 * @property string january_token
 * @property Carbon january_sent_at
 * @property Carbon january_reminder_sent_at
 * @property string march_token
 * @property Carbon march_sent_at
 * @property Carbon march_reminder_sent_at
 * @property string may_token
 * @property Carbon may_sent_at
 * @property Carbon may_reminder_sent_at
 * @property Carbon party_sent_at
 * @property Carbon party_reminder_sent_at
 * @property string party_token
 * @property Carbon party_group_reminder_sent_at
 * @property Carbon updated_at
 * @property Carbon created_at
 * @property School school
 * @property Teacher teacher
 * @property Collection partyGroups
 *
 * @method static SchoolClass create(array $values)
 */
class SchoolClass extends Model {

    protected $fillable = ['name', 'students', 'school_id', 'teacher_id', 'status_january', 'status_march',
        'status_may', 'status_party', 'january_token', 'january_sent_at', 'january_reminder_sent_at', 'march_token',
        'march_sent_at', 'march_reminder_sent_at', 'may_token', 'may_sent_at', 'may_reminder_sent_at', 'status_party',
        'party_token', 'party_sent_at', 'party_reminder_sent_at', 'party_group_reminder_sent_at'];

    protected $dates = ['january_sent_at', 'january_reminder_sent_at', 'march_sent_at', 'march_reminder_sent_at',
        'may_sent_at', 'may_reminder_sent_at', 'party_sent_at', 'party_reminder_sent_at', 'party_group_reminder_sent_at'];

    public const STATUS_JANUARY = "january";
    public const STATUS_MARCH = "march";
    public const STATUS_MAY = "may";

    public function school(): BelongsTo {
        return $this->belongsTo(School::class);
    }

    public function teacher(): BelongsTo {
        return $this->belongsTo(Teacher::class);
    }

    public function partyGroups(): HasMany {
        return $this->hasMany(PartyGroup::class);
    }

    public function getStatusJanuary(): ?int {
        return $this->status_january;
    }

    public function getStatusMarch(): ?int {
        if($this->status_january === 0)
            return 0;
        return $this->status_march;
    }

    public function getStatusMay(): ?int {
        if($this->status_january === 0 || $this->status_march === 0)
            return 0;
        return $this->status_may;
    }

    public function getStatusParty(): ?int {
        if($this->status_january === 0 || $this->status_march === 0 || $this->status_may === 0)
            return 0;
        return $this->status_party;
    }

    public function getStatusPartyGroups(): ?int {
        if($this->status_january === 0 || $this->status_march === 0 || $this->status_may === 0 || $this->status_party === 0)
            return 0;
        return $this->partyGroups()->exists() ? 1 : null;
    }

    /**
     * @param bool $status
     */
    public function setPartyStatus(bool $status) {
        $this->status_party = $status;
        $this->save();
    }

    /**
     * Checks if the previous statuses have been answered positively by the teacher.
     * @param string $whichStatus Which status to check, use constants: {@link STATUS_JANUARY}, {@link STATUS_MARCH}, {@link STATUS_MAY}
     * @return bool
     */
    public function arePreviousStatusesPositive($whichStatus) {
        if ($whichStatus === static::STATUS_JANUARY)
            return true;
        if ($whichStatus === static::STATUS_MARCH)
            return $this->status_january === 1;
        if ($whichStatus === static::STATUS_MAY)
            return $this->status_january === 1 && $this->status_march === 1;

        return false;
    }

    /**
     * Checks if this class is eligible for the end party.
     * @return bool
     */
    public function isEligibleForParty() {
        return $this->status_january === 1
            && $this->status_march === 1
            && $this->status_may === 1
            && $this->status_party === 1;
    }

    /**
     * @param Teacher $teacher
     * @param string $name
     * @param int $students
     * @param School $school
     * @return SchoolClass The newly created SchoolClass
     */
    public static function createForTeacher(Teacher $teacher, $name, $students, School $school): SchoolClass {
        return SchoolClass::create([
            'name' => $name,
            'students' => $students,
            'school_id' => $school->id,
            'teacher_id' => $teacher->id,
        ]);
    }

    /**
     * Set the status of the follow to the given response. Which status to choose is automatically determined
     * through the token as it is unique.
     * @param string $status Which status to update
     * @param bool $newStatus If the class is still not smoking
     * @throws \Exception
     */
    public function setFollowUpStatus(string $status, bool $newStatus) {
        $dbFieldToken = $status . '_token'; // january_token
        $dbFieldStatus = 'status_' . $status; // status_january

        \Log::info('Follow up response is for status: ' . $dbFieldStatus . ' and class ' . $this->toJson());

        $this->update([
            $dbFieldToken => null,
            $dbFieldStatus => $newStatus,
        ]);
    }

    /**
     * Returns the current token to respond the follow up.
     * @return string
     * @throws \Exception
     */
    public function getCurrentToken() {
        if($this->january_token != null)
            return $this->january_token;
        if($this->march_token != null)
            return $this->march_token;
        if($this->may_token != null)
            return $this->may_token;
        throw new \Exception('SchoolClass has no token. ' . $this->toJson());
    }

    /**
     * @param $status
     * @throws \Exception
     */
    public function prepareSend($status) {
        $this->update([
            $status . '_sent_at' => Carbon::now(),
            $status . '_token' => Uuid::uuid4()->toString(),
        ]);
    }

    /**
     * @param $status
     * @throws \Exception
     */
    public function prepareSendReminder($status) {
        if($this->__get($status . '_token') == null) {
            $this->update([$status . '_token' => Uuid::uuid4()->toString()]);
        }
        $this->update([
            $status . '_reminder_sent_at' => Carbon::now(),
        ]);
    }

    /**
     * @throws \Exception
     */
    public function prepareSendParty() {
        $data = ['party_sent_at' => Carbon::now()];
        if($this->party_token === null)
            $data['party_token'] = Uuid::uuid4()->toString();

        $this->update($data);
    }

    /**
     * @throws \Exception
     */
    public function prepareSendPartyReminder() {
        $data = ['party_reminder_sent_at' => Carbon::now()];
        if($this->party_token === null)
            $data['party_token'] = Uuid::uuid4()->toString();

        $this->update($data);
    }

    public function clearPartyToken() {
        $this->party_token = null;
        $this->save();
    }

}
