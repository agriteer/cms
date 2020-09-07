<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\SupportMail;
use App\Models\Support;
use Illuminate\Http\Request;
use App\Mail\UserSupportMail;

class SupportController
{
    public function save(Request $request)
    {
        $support = Support::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        $this->sendEmail($support);
        $this->sendUserMail($support);

        return $support;
    }

    public function sendEmail($request)
    {
        Mail::to('ibonly@yahoo.com')->send(new SupportMail($request));
    }

    public function sendUserMail($request)
    {
        Mail::to($request->email)->send(new UserSupportMail($request));
    }
}