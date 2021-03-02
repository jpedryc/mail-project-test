<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendEmailsRequest;
use App\Http\Resources\MailResource;
use App\Mail\GenericMail;
use App\Models\Attachment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;

/**
 * Class MailController
 * @package App\Http\Controllers
 */
class MailController extends Controller
{
    /**
     * Lists all send emails
     *
     * @return AnonymousResourceCollection
     */
    public function list(): AnonymousResourceCollection
    {
        return MailResource::collection(\App\Models\Mail::where('send_at', '!=', null)->paginate());
    }

    /**
     * Sending generic emails to the default queue
     *
     * @param SendEmailsRequest $request
     * @return JsonResponse
     */
    public function send(SendEmailsRequest $request): JsonResponse
    {
        /**
         * TEST-PROJECT-COMMENT
         *
         *  Based on the companies policy & the feature itself (ie. if we're sending a big batch of emails and want to
         *  make sure the emails are send) there are two possibilities to handle this.
         *
         *  1. Easy approach (current) - we leave the exception handling to the framework itself. Because we are "touching" here
         *     the database layer and queues - any major errors here could potentially stop the whole process.
         *     Code validation is handled mainly through requests build-in validation.
         *
         *  2. More robust approach - we're sending the emails in big bulks and therefore expecting something bad will
         *     happen sooner or later. We could wrap the 1st level foreach loop with try/catch blocks and on exception -
         *     handle it appropriately and continue with sending the mailables to the queue.
         */

        // Loop through request mail data & create objects
        foreach ($request->mails as $mailContent) {
            $mail = \App\Models\Mail::create($mailContent);

            foreach ($mailContent['attachments'] as $attachment) {
                $mail->attachments()->save(new Attachment($attachment));
            }

            // Push mailable to default queue
            Mail::to($request->user())->queue(new GenericMail($mail));
        }

        return response()->json('Emails send for processing: ' . sizeof($request->mails));
    }
}
