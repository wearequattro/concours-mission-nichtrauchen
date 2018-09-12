<?php

namespace App\Mail;

use App\EditableEmail;
use App\SchoolClass;
use App\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomEmail extends Mailable {
    use Queueable, SerializesModels;
    /**
     * @var EditableEmail
     */
    private $editableEmail;
    /**
     * @var Teacher
     */
    private $teacher;
    /**
     * @var SchoolClass
     */
    private $schoolClass;

    /**
     * Create a new message instance.
     *
     * @param EditableEmail $editableEmail
     * @param Teacher $teacher
     * @param SchoolClass $schoolClass
     */
    public function __construct(EditableEmail $editableEmail, $teacher, $schoolClass) {
        $this->editableEmail = $editableEmail;
        $this->teacher = $teacher;
        $this->schoolClass = $schoolClass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this
            ->subject($this->editableEmail->subject)
            ->view('emails.custom')
            ->with([
                'text' => $this->editableEmail->replaceAll($this->teacher, $this->schoolClass),
            ]);
    }
}
