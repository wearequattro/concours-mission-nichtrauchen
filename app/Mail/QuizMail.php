<?php

namespace App\Mail;

use App\PlaceHolder;
use App\QuizAssignment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuizMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var QuizAssignment
     */
    protected $assignment;

    /**
     * Create a new message instance.
     *
     * @param QuizAssignment $assignment
     */
    public function __construct(QuizAssignment $assignment)
    {
        $this->assignment = $assignment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $class = $this->assignment->schoolClass;
        $text = PlaceHolder::replaceAll($this->assignment->quiz->email_text, $class->teacher, $class);
        return $this
            ->subject($this->assignment->quiz->name)
            ->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'))
            ->replyTo(env('MAIL_REPLY_TO'))
            ->view('emails.quiz', [
                'uuid' => $this->assignment->uuid,
                'text' => $text,
            ]);
    }
}
