<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class EditableEmail
 * @package App
 *
 * @property int key
 * @property string title
 * @property string text
 * @property string subject
 * @property Collection sentEmails
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @method static EditableEmail create(array $map)
 */
class EditableEmail extends Model {

    protected $fillable = ['key', 'title', 'text', 'subject'];

    public $incrementing = false;

    protected $primaryKey = "key";
    protected $keyType = 'string';

    public static $MAIL_TEACHER_CONFIRMATION = ["teacher_confirmation", "Email de confirmation dès que l'enseignant s'inscris"];
    public static $MAIL_CONTEST_START = ["contest_start", "Message pour le début du concours"];
    public static $MAIL_FOLLOW_UP = ["follow_up", "Message de suivi et rappel aux professeurs"];
    public static $MAIL_FOLLOW_UP_YES = ["follow_up_yes", "Réponse positive du suivi"];
    public static $MAIL_FOLLOW_UP_NO = ["follow_up_no", "Réponse négative du suivi"];
    public static $MAIL_FOLLOW_UP_YES_INVITE_PARTY = ["follow_up_yes_invite_party", "Réponse positive du suivi et invitation au fête de clôture"];
    public static $MAIL_PARTY_CONFIRMATION = ["party_confirmation", "Confirmation de participation à la fête de clôture"];
    public static $MAIL_FINAL = ["final", "Mail final"];
    public static $MAIL_NEWSLETTER_START = ["newsletter_start", "Newsletter début"];
    public static $MAIL_NEWSLETTER_ENCOURAGEMENT = ["newsletter_encouragement", "Newsletter d'encouragement"];

    public static function getEmails() {
        return collect([
            static::$MAIL_TEACHER_CONFIRMATION,
            static::$MAIL_CONTEST_START,
            static::$MAIL_FOLLOW_UP,
            static::$MAIL_FOLLOW_UP_YES,
            static::$MAIL_FOLLOW_UP_NO,
            static::$MAIL_FOLLOW_UP_YES_INVITE_PARTY,
            static::$MAIL_PARTY_CONFIRMATION,
            static::$MAIL_FINAL,
            static::$MAIL_NEWSLETTER_START,
            static::$MAIL_NEWSLETTER_ENCOURAGEMENT,
        ]);
    }

    public function sentEmails() {
        return $this->hasMany(SentEmail::class);
    }

    /**
     * Returns all users that have received this email
     * @return Collection Collection of user objects
     */
    public function sentUsers(): Collection {
        return $this->sentEmails->map(function (SentEmail $sentEmail) {
            return $sentEmail->user;
        });
    }

    /**
     * Saves the information that the email is sent to the given user
     * @param User $user
     */
    public function setSent(User $user) {
        SentEmail::create([
            'editable_email_key' => $this->key,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Checks if this email has already been sent to the given user
     * @param User $user
     * @return bool
     */
    public function isSentToUser(User $user): bool {
        return $this->sentEmails->pluck('user_id')->containsStrict($user->id);
    }

    /**
     * Returns the text from this email where all placeholders have been replaced
     * @param Teacher $teacher
     * @param SchoolClass $class
     * @return string The complete email, with placeholders having been replaced.
     */
    public function replaceAll($teacher, $class): string {
        $text = $this->text;
        foreach (static::getPlaceholders() as $placeholder) {
            /** @var PlaceHolder $placeholder */
            if(Str::contains($text, $placeholder->key)) {
                $text = str_replace(
                    $placeholder->key,
                    $this->getReplacement($placeholder->key, $teacher, $class),
                    $text);
            }
        }
        return $text;
    }

    /**
     * Finds an editable email by the key.
     * @param array $key One of the constants declared in {@link EditableEmail} class.
     * @return EditableEmail
     */
    public static function find(array $key) {
        return static::query()->where('key', $key[0])->first();
    }

    /**
     * Replaces the subject with the proper value. Subject should not contain the placeholder delimiter (%).
     * @param string $subject
     * @param Teacher $teacher
     * @param SchoolClass $class
     * @return string Replaced text
     */
    public function getReplacement(string $subject, $teacher, $class) {
        $subject = str_replace('%', '', $subject);
        if($subject === "PROF")
            return $teacher->salutation->long_form . ' ' . $teacher->first_name . ' ' . $teacher->last_name;
        if($subject === "PROF_1")
            return $teacher->salutation->short_form . ' ' . $teacher->first_name . ' ' . $teacher->last_name;
        if($subject === "TITRE_LONG")
            return $teacher->salutation->long_form;
        if($subject === "TITRE")
            return $teacher->salutation->short_form;
        if($subject === "PROF_PRENOM")
            return $teacher->first_name;
        if($subject === "PROF_NOM")
            return $teacher->last_name;
        if($subject === "NOM_CLASSE")
            return $class->name;
        if($subject === "LIEN_LOGIN")
            return route('login');
        if($subject === "LIEN_FETE_INVITE")
            return route('teacher.party');
        if($subject === "SUIVI_OUI")
            return route('follow-up', ['token' => $class->getCurrentToken(), 'status' => 'true']);
        if($subject === "SUIVI_NON")
            return route('follow-up', ['token' => $class->getCurrentToken(), 'status' => 'false']);
        return "";
    }

    public static function getPlaceholders(): Collection {
        return collect([
            new PlaceHolder("PROF", "Monsieur Max Mustermann"),
            new PlaceHolder("PROF_1", "M. Max Mustermann"),
            new PlaceHolder("TITRE_LONG", "Monsieur"),
            new PlaceHolder("TITRE", "M."),
            new PlaceHolder("PROF_PRENOM", "Max"),
            new PlaceHolder("PROF_NOM", "Mustermann"),
            new PlaceHolder("NOM_CLASSE", "7ST1", "Nom de la classe"),
            new PlaceHolder("LIEN_LOGIN", "https://app.link/login", "Lien login"),
            new PlaceHolder("LIEN_FETE_INVITE", "https://invite.link/fete", "Lien invitaion fête"),
            new PlaceHolder("SUIVI_OUI", "https://suivi.link/oui", "Lien réponse suivi oui"),
            new PlaceHolder("SUIVI_NON", "https://suivi.link/non", "Lien réponse suivi non"),
        ]);
    }

    public static function addEmailsToDb() {
        foreach (static::getEmails() as $mail) {
            $key = $mail[0];
            $title = $mail[1];
            if(static::query()->where('key', $key)->exists())
                continue;

            static::create([
                'key' => $key,
                'title' => $title,
                'text' => '',
            ]);
        }

    }

}

class PlaceHolder {

    /**
     * @var string
     */
    public $key;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $previewValue;

    public function __construct(string $key, string $previewValue, string $description = "") {
        $this->key = '%'.$key.'%';
        $this->previewValue = $previewValue;
        $this->description = $description;
    }

}
