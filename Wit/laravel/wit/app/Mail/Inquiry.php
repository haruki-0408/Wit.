<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Inquiry extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $inquiry_sentence;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $inquiry_sentence)
    {
        $this->user = $user;
        $this->inquiry_sentence = $inquiry_sentence;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('お問い合わせ内容')
            ->view('wit.Emails.inquiry')
            ->with([
                'name' => $this->user->name,
                'email' => $this->user->email,
                'created_at' => $this->user->created_at,
                'inquiry_sentence' => $this->inquiry_sentence
            ]);
    }
}
