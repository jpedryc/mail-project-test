<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendEmailsRequest;
use App\Http\Resources\MailResource;
use App\Mail\GenericMail;
use App\Models\Attachment;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function list()
    {
        return MailResource::collection(\App\Models\Mail::where('send_at', '!=', null)->paginate());
    }

    public function send(SendEmailsRequest $request)
    {
        foreach ($request->mails as $mailContent) {
            $mail = new \App\Models\Mail($mailContent);
            $mail->save();

            foreach ($mailContent['attachments'] as $attachment) {
                $mail->attachments()->save(new Attachment($attachment));
            }

            try {
                Mail::to($request->user())->queue(new GenericMail($mail));
            }
            catch (Exception $exception) {
                Log::error($exception);
            }
        }
    }
}
