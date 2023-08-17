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
    private $team;

    public function __construct($user, $token,$team)
    {
        $this->user = $user;
        $this->token = $token;
        $this->team = $team;
    }


    public function handle()
    {
        $u = $this->user;
        $team = $this->team;
        Mail::send('emails.invite', ['token' => $this->token, 'user' => $this->user,'team'=>$team], function ($message) use ($u) {
            $message->to($u->email);
            $message->subject('Email Invite Team');
        });
    }
}
