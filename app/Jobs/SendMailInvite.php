<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendMailInvite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $token;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }


    public function handle()
    {
        $u = $this->user;
        Mail::send('emails.invite', ['token' => $this->token, 'user' => $this->user], function ($message) use ($u) {
            $message->to($u->email);
            $message->subject('Email Invite Team');
        });
    }
}
