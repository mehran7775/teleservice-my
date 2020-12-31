<?php

namespace App\Mail;

use App\Models\CodeVerify;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLogin extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return UserLogin|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function build()
    {
        return response()->json([
            'message' => 'user new password',
            'code_verify' => $this->user->codeVerifies()->pluck('code_verify_login')->first(),

        ], 200);
    }
}
