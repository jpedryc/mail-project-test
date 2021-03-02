<?php

namespace Tests\Feature;

use App\Mail\GenericMail;
use App\Models\Mail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class SendTest extends TestCase
{
    /**
     * TEST-PROJECT-COMMENT
     *
     *  The easiest way while working with checking database changes would be to use the RefreshDatabase trait and hook
     *  up an additional test database. For simplicity now - testing on the "production" one.
     */
//    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Auth::setUser(User::first());
    }

    public function test_send_correctly()
    {
        $response = $this->post(route('send',  ['api_token' => Auth::user()->api_token ]), [
            'mails' => [
                [
                    'to' => 'example@example.com',
                    'subject' => 'A test subject',
                    'body' => 'A test body example',
                    'attachments' => [],
                ]
            ]
        ]);

        /**
         * TEST-PROJECT-COMMENT
         *
         *  Normally would plan out more to have one set of assertions in a single test.
         */

        $response->assertStatus(200)
            ->assertSeeText('Emails send for processing: 1');

        $this->assertTrue(Mail::orderBy('id', 'DESC')->first()->body == 'A test body example');
    }

    public function test_send_failed()
    {
        $response = $this->post(route('send',  ['api_token' => Auth::user()->api_token ]), [
            'mails' => [
                [
                    'subject' => 'A test subject',
                    'body' => 'A test body example',
                    'attachments' => [],
                ]
            ]
        ]);

        $response->assertStatus(422)
            ->assertSeeText('The mails.0.to field is required');
    }
}
