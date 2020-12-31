<?php

namespace App\Mail;

use App\Models\CodeVerify;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

class UserRegister extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    var $pass;


    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user=$user;
    }

    /**
     * Build the message.
     *
     * @return UserRegister
     * @throws \Exception
     */
    public function build()
    {
//        return response()->json($pass,200);
        return $this->view('emails.userRegister')->with(['code_verify' =>$this->user->codeVerifies()->pluck('code_verify_register')->first()]);
    }
}
