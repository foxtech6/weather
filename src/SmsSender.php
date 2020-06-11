<?php

namespace Src;

use Throwable;
use Src\Exceptions\SmsSenderException;

/**
 * Class SmsSender
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 10.06.2020
 */
class SmsSender
{
    /**
     * @var int
     */
    private const SEND_ATTEMPTS_NUMBER = 3;

    /**
     * Request instance
     *
     * @var RequestInterface
     */
    private $request;

    /**
     * Token for send sms
     *
     * @var string
     */
    private $token;

    /**
     * SmsSender constructor
     *
     * @param RequestInterface $request Request instance
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Send sms to number
     *
     * @param string $number  Phone number
     * @param string $message Sms message
     * @param int    $attempt Count attempts for send
     *
     * @return string
     *
     * @throws SmsSenderException
     */
    public function send(string $number, string $message, int $attempt = 1): string
    {
        try {
            $request = $this->request->send(
                env('sms_url'),
                json_encode(['body' => $message, 'to' => $number, 'from' => env('from')]),
                [sprintf('authorization: Bearer %s', $this->token), 'content-type: application/json']
            );

            if (
                (null === $this->token || RequestInterface::UNAUTHORIZED_CODE === $request->getCode())
                && $attempt < static::SEND_ATTEMPTS_NUMBER
            ) {
                $this->token = $this->getToken();
                return $this->send($number, $message, $attempt + 1);
            }

            return $request->getResponse();
        } catch (Throwable $e) {
            throw new SmsSenderException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * Get token for send sms
     *
     * @return string
     */
    private function getToken(): ?string
    {
        $request = $this->request->send(
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
