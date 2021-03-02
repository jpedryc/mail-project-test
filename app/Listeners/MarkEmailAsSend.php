<?php

namespace App\Listeners;

use App\Models\Mail;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class MarkEmailAsSend
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
        $mail->save();
    }
}
