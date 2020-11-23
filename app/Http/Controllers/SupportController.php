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
            $this->sendUserEmail($support);
            $this->sendAdminMail($support);
        }

        return response()->json($support);
    }

    public function sendUserEmail($request)
    {
        $mail = app(MailService::class);

        return $mail->sendUserEmail($request);
    }

    public function sendAdminMail($request)
    {
        $mail = app(MailService::class);
        
        return $mail->sendAdminContact($request);
    }
}