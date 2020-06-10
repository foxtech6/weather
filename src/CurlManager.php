<?php

namespace Src;

class CurlManager
{
    public const UNAUTHORIZED_CODE = 401;
    public const SERVICE_UNAVAILABLE_CODE = 401;
    private $response;
    private $code;
    public function request(string $url, $fields = null, array $headers = []): self
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if (!empty($fields)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        }

        if (!empty($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        $this->response = curl_exec($curl);
        $this->code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function getCode(): int
    {
        return $this->code;
    }
}