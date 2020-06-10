<?php

namespace Src;

use Src\Exceptions\SmsSenderException;
use stdClass;

class SmsSender
{
    private const SEND_ATTEMPTS_NUMBER = 3;

    private $token;

    public function send(string $number, string $message, int $attempt = 1): string
    {
        try {
            $request = (new CurlManager())->request(
                env('sms_url'),
                json_encode(['body' => $message, 'to' => $number, 'from' => env('from')]),
                [sprintf('authorization: Bearer %s', $this->token), 'content-type: application/json']
            );

            if (
                (null === $this->token || CurlManager::UNAUTHORIZED_CODE === $request->getCode())
                && $attempt < static::SEND_ATTEMPTS_NUMBER
            ) {
                $this->token = $this->getToken();
                return $this->send($number, $message, $attempt + 1);
            }

            return $request->getResponse();
        } catch (\Throwable $e) {
            throw new SmsSenderException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    private function getToken(): string
    {
        $request = (new CurlManager())->request(
            env('token_url'),
            'grant_type=client_credentials',
            [
                sprintf('authorization: Basic %s', env('token_key')),
                'content-type: application/x-www-form-urlencoded',
            ]
        );

        return json_decode($request->getResponse())->access_token;
    }
}
