<?php

namespace App\Services\Mail;

use GuzzleHttp\Client;

class Mail
{
    public function __construct()
    {
        $this->setKey();
        $this->setBaseUrl();
        $this->setRequestOptions();
    }

    /**
     * Get secret key from Paystack config file.
     */
    public function setKey()
    {
        $this->secretKey = env('EMAIL_SERVICE_KEY');
    }

    /**
     * Get Base Url from Paystack config file.
     */
    public function setBaseUrl()
    {
        $this->baseUrl = env('EMAIL_SERVICE_URL');
    }

    /**
     * Set options for making the Client request.
     */
    private function setRequestOptions()
    {
        $authBearer = $this->secretKey;

        $this->client = new Client(
            [
                'base_uri' => $this->baseUrl,
                'headers' => [
                    'x-api-key' => $authBearer,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ]
        );
    }


    /**
     * @param string $relativeUrl
     * @param string $method
     * @param array  $body
     *
     * @return Paystack
     *
     * @throws IsNullException
     */
    private function setHttpResponse($relativeUrl, $method, $body = [])
    {
        if (is_null($method)) {
            throw new IsNullException('Empty method not allowed');
        }

        $this->response = $this->client->{strtolower($method)}(
            $this->baseUrl . $relativeUrl,
            ['body' => json_encode($body)]
        );

        return $this;
    }

    public function send($from, $to, $subject, $message)
    {
        $data = [
            'from' => [ 'email' =>  $from['email'], 'name' => $from['name']],
            'to' => ['email' => $to['email'], 'name' => $to['name']],
            'subject' => $subject,
            'message' => $message
        ];

        $this->setRequestOptions();

        return $this->setHttpResponse('/send', 'POST', $data);
    }
}

