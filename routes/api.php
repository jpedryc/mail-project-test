<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Mailable
Route::middleware('auth:api')->group(function () {

    /**
     *  Mailable
     */

    // List all sent emails
    Route::get('list', [MailController::class, 'list'])->name('list');

    // Send emails
    Route::post('send', [MailController::class, 'send'])->name('send');

    /**
     *  Attachments
     */

    // Download attachment
    Route::get('download/{attachment}', [AttachmentController::class, 'download'])->name('download');

});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact some@mail.com'], 404);
});
