<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use App\Services\Mail\MailService;

class SupportController
{
    protected $mail;

    public function __constructor(MailService $mail)
    {
        $this->mail = $mail;
    }

    public function save(Request $request)
    {
        $support = Support::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        if (env('APP_ENV') !== 'testing') {
            $this->sendEmail($support);
            $this->sendUserMail($support);
        }

        return $support;
    }

    public function sendEmail($request)
    {
        return $this->mail->sendUserEmail($request);
    }

    public function sendUserMail($request)
    {
        return $this->mail->sendAdminContact($request);
    }
}