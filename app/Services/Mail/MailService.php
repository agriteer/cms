<?php

namespace App\Services\Mail;

class MailService extends Mail
{
    protected $supportEmail = 'support@agriteer.com';

    public function sendUserEmail($email)
    {
        try {
            $from = ['email' => $this->supportEmail, 'name' => 'Agriteer Support'];
            $to = ['email' => $email->email, 'name' => $email->name];
            $subject = 'Thank you for contacting agriteer';
            $message = "<div><p>Thanks for contacting Agriteer!</p><p>Due to an increase in support volume, it may take longer than usual for our team to reply. We apologize for any inconvenience, and will get back to you as soon as we can.</p><p>If you'd like send more information, kindly reply to this email.</p><p>Agriteer Team</p></div>";

            return $this->send($from, $to, $subject, $message);
        } catch (\Exception $e) {
            return ['message' => 'Error sending email'];
        }
    }

    public function sendAdminContact($email)
    {
        try {
            $to = ['email' => $this->supportEmail, 'name' => 'Agriteer Support'];
            $from = ['email' => $email->email, 'name' => $email->name];
            $subject = $email->subject;
            $message = "<div><p><strong>Name: </strong>{{ $email->name }}</p><p><strong>Email: </strong>{{ $email->email }}</p><p><strong>Subject: </strong>{{ $email->subject }}</p><p><strong>Message: </strong>{{ $email->message }}</p></div>";

            
            return $this->send($from, $to, $subject, $message);
        } catch (\Exception $e) {
            return ['message' => 'Error sending email'];
        }
    }
}
