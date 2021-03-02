<?php

namespace App\Mail;

use App\Models\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $mail;

    /**
     * Create a new message instance.
     *
     * @param Mail $mail
     */
    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Configure initial mailable
        $mailBuildable = $this
            ->subject($this->mail->subject);

        // Append all attachments
        foreach ($this->mail->attachments as $attachment) {
            $mailBuildable = $mailBuildable->attachData(
                base64_decode($attachment->content), $attachment->filename
            );
        }

        return $mailBuildable->view('emails.generic-mail');
    }
}
