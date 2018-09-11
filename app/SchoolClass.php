<?php

namespace App;

use Carbon\Carbon;
use function foo\func;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

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
 * @property Carbon updated_at
 * @property Carbon created_at
 * @property School school
 * @property Teacher teacher
 * @property PartyGroup partyGroups
 *
 * @method static SchoolClass create(array $values)
 */
class SchoolClass extends Model {

    protected $fillable = ['name', 'students', 'school_id', 'teacher_id', 'status_january', 'status_march',
        'status_may', 'status_party'];

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
        if($whichStatus === static::STATUS_JANUARY)
            $followupDate = env('FOLLOW_UP_1');
        if($whichStatus === static::STATUS_MARCH)
            $followupDate = env('FOLLOW_UP_2');
        if($whichStatus === static::STATUS_MAY)
            $followupDate = env('FOLLOW_UP_3');
        $sentAtName = $whichStatus . '_sent_at';
        /** @var Carbon $sentAt */
        $sentAt = $this->$sentAtName;
        return $sentAt === null && Carbon::now()->gte(Carbon::createFromFormat('Y-m-d', env($followupDate)));
    }

    /**
     * Checks if the follow up for the given status is sent, and it was at least some time ago (configurable in env).
     * @param string $whichStatus Which status to check, use constants: {@link STATUS_JANUARY}, {@link STATUS_MARCH}, {@link STATUS_MAY}
     * @return bool
     */
    public function shouldSendFollowUpReminder(string $whichStatus): bool {
        $sentAtName = $whichStatus . '_sent_at';
        $reminderSentAtName = $whichStatus . '_reminder_sent_at';
        /** @var Carbon $sentAt */
        $sentAt = $this->$sentAtName;
        /** @var Carbon $reminderSentAt */
        $reminderSentAt = $this->$reminderSentAtName;
        $followupReminderDate = $sentAt->copy()->addDays(env('FOLLOW_UP_MAIL_RESEND_DELAY_DAYS'));
        return $sentAt !== null && $reminderSentAt === null && Carbon::now()->gte($followupReminderDate);
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
        if(\Auth::user() === null || \Auth::user()->type !== User::TYPE_TEACHER || \Auth::user()->teacher === null)
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

}
