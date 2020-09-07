<?php

namespace App\Mail;

use App\Models\Support;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserSupportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $model;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Support $model)
    {
        $this->model = $model;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.user');
    }
}
