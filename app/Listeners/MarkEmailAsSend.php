<?php

namespace App\Listeners;

use App\Models\Mail;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class MarkEmailAsSend implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $mail = Mail::find($event->data['mail']['id']);
        $mail->send_at = Carbon::now();

        if (!$mail->save()) {
            Log::error("Mail {$mail->id} could not be marked as SNED");
        }
    }
}
