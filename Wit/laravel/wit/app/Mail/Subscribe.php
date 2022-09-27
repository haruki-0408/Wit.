<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class Subscribe extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('仮登録が完了しました')
            ->view('wit.Emails.subscribers')
            ->with(['token' => $this->user->email_verified_token,]);
    }
}
