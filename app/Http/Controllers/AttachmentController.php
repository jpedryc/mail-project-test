<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class AttachmentController
 * @package App\Http\Controllers
 */
class AttachmentController extends Controller
{
    /**
     * Stream download action of decoded file data
     *
     * @param Attachment $attachment
     * @return StreamedResponse
     */
    public function download(Attachment $attachment): StreamedResponse
    {
        /**
         * TEST-PROJECT-COMMENT
         *
         *  With more time, I would check if this actually will handle all different file types correctly etc.
         *  I'm assuming attachments are not only images but also pdfs etc.
         */

        $fileData = base64_decode($attachment->content);

        return response()->streamDownload(function () use ($fileData) {
            echo $fileData;
        }, $attachment->filename);
    }
}
