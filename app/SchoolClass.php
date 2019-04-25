<?php

namespace App;

use App\Mail\CustomEmail;
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
 * @property string party_token
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
        'party_token'];

    protected $dates = ['january_sent_at', 'january_reminder_sent_at', 'march_sent_at', 'march_reminder_sent_at',
        'may_sent_at', 'may_reminder_sent_at'];

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

    /**
     * Determines if sent_at is not set and that "now" is after the followUp date in env.
     * @param string $whichStatus Which status to check, use constants: {@link STATUS_JANUARY}, {@link STATUS_MARCH}, {@link STATUS_MAY}
     * @return bool
     */
    public function shouldSendFollowUp(string $whichStatus): bool {
        $followupDate = null;
        if ($whichStatus === static::STATUS_JANUARY)
            $followupDate = EditableDate::find(EditableDate::FOLLOW_UP_1);
        if ($whichStatus === static::STATUS_MARCH)
            $followupDate = EditableDate::find(EditableDate::FOLLOW_UP_2);
        if ($whichStatus === static::STATUS_MAY)
            $followupDate = EditableDate::find(EditableDate::FOLLOW_UP_3);
        $sentAtName = $whichStatus . '_sent_at';
        $statusValue = $this->__get('status_' . $whichStatus);
        /** @var Carbon $sentAt */
        $sentAt = $this->$sentAtName;
        return $this->arePreviousStatusesPositive($whichStatus)
            && $sentAt === null
            && $statusValue === null
            && Carbon::now()->gte($followupDate);
    }

    /**
     * Checks if the follow up for the given status is sent, and it was at least some time ago (configurable in env).
     * @param string $whichStatus Which status to check, use constants: {@link STATUS_JANUARY}, {@link STATUS_MARCH}, {@link STATUS_MAY}
     * @param bool $checkIfAlreadySent Checks if the email reminder has already been sent.
     * @return bool
     */
    public function shouldSendFollowUpReminder(string $whichStatus, $checkIfAlreadySent = true): bool {
        $sentAtName = $whichStatus . '_sent_at';
        $reminderSentAtName = $whichStatus . '_reminder_sent_at';
        /** @var Carbon $sentAt */
        $sentAt = $this->$sentAtName;
        /** @var Carbon $reminderSentAt */
        $reminderSentAt = $this->$reminderSentAtName;
        if ($sentAt === null || !$this->arePreviousStatusesPositive($whichStatus))
            return false;
        $statusValue = $this->__get('status_' . $whichStatus);
        if ($statusValue !== null)
            return false;
        $followupReminderDate = $sentAt->copy()->addDays(env('FOLLOW_UP_MAIL_RESEND_DELAY_DAYS'));
        if(!$checkIfAlreadySent) {
            $followupReminderDate = Carbon::create(2000, 1, 1, 0, 0, 0);
            $reminderSentAt = null;
        }
        return $reminderSentAt === null && Carbon::now()->gte($followupReminderDate);
    }

    /**
     * Checks if the previous statuses have been answered positively by the teacher.
     * @param string $whichStatus Which status to check, use constants: {@link STATUS_JANUARY}, {@link STATUS_MARCH}, {@link STATUS_MAY}
     * @return bool
     */
    private function arePreviousStatusesPositive($whichStatus) {
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
        return $this->status_january === 1 && $this->status_march === 1 && $this->status_may === 1;
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
     * Finds all {@link SchoolClass} objects for the currently logged in Teacher. If user is not a teacher, an empty
     * collection is returned
     * @return Collection Collection of {@link SchoolClass} objects
     */
    public static function findForLoggedInUser(): Collection {
        if (\Auth::user() === null || \Auth::user()->type !== User::TYPE_TEACHER || \Auth::user()->teacher === null)
            return collect();
        return static::findForTeacher(\Auth::user()->teacher);
    }

    /**
     * Finds all {@link SchoolClass} objects for the given Teacher
     * @param Teacher $teacher
     * @return Collection Collection of {@link SchoolClass} objects
     */
    public static function findForTeacher(Teacher $teacher): Collection {
        return static::query()
            ->where('teacher_id', $teacher->id)
            ->get();
    }

    /**
     * Set the status of the follow to the given response. Which status to choose is automatically determined
     * through the token as it is unique.
     * @param string $token The token from the url in the email
     * @param bool $newStatus If the class is still not smoking
     * @return bool If the status was changed
     */
    public static function setFollowUpStatus(string $token, bool $newStatus): bool {
        $wasStatusChanged = false;
        $statuses = collect([static::STATUS_JANUARY, static::STATUS_MARCH, static::STATUS_MAY]);
        foreach ($statuses as $whichStatus) {
            $dbFieldToken = $whichStatus . '_token'; // january_token
            $dbFieldStatus = 'status_' . $whichStatus; // status_january
            $class = static::query()->where($dbFieldToken, $token)->first();
            if ($class != null) {
                \Log::info('Follow up response is for status: ' . $dbFieldStatus . ' and class ' . $class->toJson());
                $class->update([
                    $dbFieldToken => null,
                    $dbFieldStatus => $newStatus,
                ]);
                $wasStatusChanged = true;
                $class->sendFollowUpReplyToResponse($whichStatus, $newStatus);
                break;
            }
        }
        if(!$wasStatusChanged)
            \Log::warning('Status was not changed, token may not be correct. Token: ' . $token);
        return $wasStatusChanged;
    }

    /**
     * Sends the appropriate reply to the teacher's follow up response.
     * @param string $whichStatus Which status to check, use constants: {@link STATUS_JANUARY}, {@link STATUS_MARCH}, {@link STATUS_MAY}
     * @param bool $newStatus
     */
    function sendFollowUpReplyToResponse($whichStatus, bool $newStatus) {
        $mailToSend = null;
        if($newStatus === false) { // no
            if (in_array($whichStatus, [static::STATUS_JANUARY, static::STATUS_MARCH, static::STATUS_MAY])) {
                \Log::info('Sending negative response to follow up ' . $whichStatus);
                $mailToSend = EditableEmail::$MAIL_FOLLOW_UP_NO;
            }
        } else { // yes
            if (in_array($whichStatus, [static::STATUS_JANUARY, static::STATUS_MARCH])) {
                \Log::info('Sending positive response to follow up ' . $whichStatus);
                $mailToSend = EditableEmail::$MAIL_FOLLOW_UP_YES;
            } else if($whichStatus === static::STATUS_MAY) {
                \Log::info('Sending positive response and invite to party ');
                $mailToSend = EditableEmail::$MAIL_FOLLOW_UP_3_YES_INVITE_PARTY;
            }
        }
        if($mailToSend != null) {
            \Mail::to($this->teacher->user->email)
                ->queue(new CustomEmail(EditableEmail::find($mailToSend), $this->teacher, $this));
        }
    }

    /**
     * Converts this SchoolClass into multiple school classes grouped into equal parts based on the number of students.
     * 10 Students -> 1 group with 10, 11 students -> group with 5 and group with 6.
     * @param int $maxInGroup How many students per group
     * @return Collection Number of students per group
     */
    public function mapToGroups(int $maxInGroup = 10) {
        $numGroups = ceil($this->students / $maxInGroup);
        $groups = collect();
        for ($i = 0; $i < $numGroups; $i++) {
            if ($i < $numGroups - 1) {
                // Divide number of students into equal parts and add them
                $students = ceil($this->students / $numGroups);
            } else {
                // If it's the last group, just take the remaining number of students
                $students = $this->students - $groups->sum();
            }
            $groups->push(intval($students));
        }
        return $groups;
    }

    /**
     * Returns the current token to respond the follow up.
     * @return string
     */
    public function getCurrentToken() {
        if($this->january_token != null)
            return $this->january_token;
        if($this->march_token != null)
            return $this->march_token;
        if($this->may_token != null)
            return $this->may_token;
        \Log::error('SchoolClass has no token. ' . $this->toJson());
        return "";
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
        if($this->__get($status . '_reminder_sent_at') === null) {
            if($this->__get($status . '_token') == null) {
                $this->update([$status . '_token' => Uuid::uuid4()->toString()]);
            }
        }
        $this->update([
            $status . '_reminder_sent_at' => Carbon::now(),
        ]);
    }

}
