<?php

namespace Src;

/**
 * Class CurlManager
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 10.06.2020
 */
class CurlManager implements RequestInterface
{
    /**
     * Response from request
     *
     * @var string
     */
    private $response;

    /**
     * Response code
     *
     * @var int
     */
    private $code;

    /**
     * {@inheritDoc}
     * @see RequestInterface::send
     */
    public function send(string $url, string $fields = null, array $headers = null): RequestInterface
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($fields) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        }

        if ($headers) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        $this->response = curl_exec($curl);
        $this->code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return $this;
    }

    /**
     * Get response
     *
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * Get response code
     *
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }
}
