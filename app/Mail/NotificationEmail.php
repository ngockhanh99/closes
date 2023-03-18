<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class NotificationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $view, $subject, $data)
    {
        $this->user = $user;
        $this->view = $view;
        $this->subject = $subject;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->view)->with([['user', $this->user], ['data', $this->data], ['sender', Auth::user()]])->subject($this->subject);
    }
}
