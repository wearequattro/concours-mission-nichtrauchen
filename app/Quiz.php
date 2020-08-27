<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Quiz
 * @package App
 * @property int id
 * @property string name
 * @property string email_text
 * @property string state
 * @property int max_score
 * @property Carbon closes_at
 * @property Carbon sent_at
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property QuizInLanguage[]|Collection quizInLanguage
 * @property QuizAssignment[]|Collection assignments
 * @property QuizResponse[]|Collection responses
 *
 * @mixin \Eloquent
 */
class Quiz extends Model {

    public const STATE_NEW = 'new';
    public const STATE_RUNNING = 'running';
    public const STATE_CLOSED = 'closed';

    protected $fillable = [
        'name',
        'email_text',
        'max_score',
        'closes_at',
        'state',
        'sent_at',
    ];

    protected $dates = [
        'closes_at',
        'sent_at',
    ];

    public function quizInLanguage() {
        return $this->hasMany(QuizInLanguage::class);
    }

    public function assignments() {
        return $this->hasMany(QuizAssignment::class);
    }

    public function responses() {
        return $this->hasManyThrough(QuizResponse::class, QuizAssignment::class);
    }

    public function hasEnoughCodes(): bool
    {
        return $this
                ->quizInLanguage
                ->matchAll(fn ($ql) => $ql->hasEnoughCodes());
    }

    public function validate(string $requiredState = self::STATE_NEW): array
    {
        $errors = [];
        if ($this->closes_at->isBefore(now())) {
            $errors[] = 'La date de clôturation doit être dans le futur !';
        }
        if (!$this->hasEnoughCodes()) {
            $errors[] = 'Ce quiz n\'a pas assez de codes uniques enregistrés pour que tous les classes puissent avoir un.';
        }
        if ($this->state !== $requiredState) {
            $errors[] = sprintf('Ce quiz doit être dans le statut %s.', __("quiz.state.$requiredState"));
        }
        return $errors;
    }

    public function stateColor(): string
    {
        switch ($this->state) {
            case self::STATE_NEW:
                return 'success';
            case self::STATE_RUNNING:
                return 'primary';
            case self::STATE_CLOSED:
                return 'danger';
            default:
                throw new \InvalidArgumentException("$this->state is not a valid quiz state");
        }
    }

    public function remindableCount()
    {
        return $this->assignments()->whereDoesntHave('response')->count();
    }

}
