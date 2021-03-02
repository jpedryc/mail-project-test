<?php

namespace Tests\Feature;

use App\Models\Mail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ListTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Auth::setUser(User::first());
    }

    public function test_list()
    {
        $response = $this->get(route('list', ['api_token' => Auth::user()->api_token ]));

        $lastSendEmail = Mail::where('send_at', '!=', null)->first();

        // Depending on the current db state, check if send emails are empty or if it matches with the first record
        // pulled
        if ($lastSendEmail) {
            $response->assertStatus(200)
                ->assertJsonPath('data.0.subject', $lastSendEmail->subject);
        } else {
            $response->assertStatus(200)
                ->assertJsonCount(0, 'data');
        }
    }
}
