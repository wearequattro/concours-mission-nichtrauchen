<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class EditableEmail
 * @package App
 *
 * @property int key
 * @property string title
 * @property string text
 * @property string subject
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @method static EditableEmail create(array $map)
 */
class EditableEmail extends Model {

    protected $fillable = ['key', 'title', 'text', 'subject'];

    public $incrementing = false;

    protected $primaryKey = "key";

    public static $MAIL_TEACHER_CONFIRMATION = ["teacher_confirmation", "Email de confirmation dès que l'enseignant s'inscris."];

    public static function getEmails() {
        return collect([
            static::$MAIL_TEACHER_CONFIRMATION,
        ]);
    }

    public static function getPlaceholders(): Collection {
        return collect([
            new PlaceHolder("TITRE_PROF", "M."),
            new PlaceHolder("TITRE_LONG_PROF", "Monsieur"),
            new PlaceHolder("PRENOM_PROF", "Max"),
            new PlaceHolder("NOM_PROF", "Mustermann"),
            new PlaceHolder("PROF", "Monsieur Max Mustermann"),
            new PlaceHolder("PROF_1", "M. Max Mustermann"),
            new PlaceHolder("DEBUT_CONCOURS", "6 novembre 2017 (Date début concours)"),
            new PlaceHolder("FIN_CONCOURS", "6 mai 2018 (Date fin concours)"),
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
    public $previewValue;

    public function __construct(string $key, string $previewValue) {
        $this->key = '%'.$key.'%';
        $this->previewValue = $previewValue;
    }

}
