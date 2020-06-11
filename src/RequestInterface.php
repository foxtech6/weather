<?php

namespace Src;

/**
 * Interface CurlInterface
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 11.06.2020
 */
interface RequestInterface
{
    /**
     * @var int
     */
    public const UNAUTHORIZED_CODE = 401;

    /**
     * @var int
     */
    public const SERVICE_UNAVAILABLE_CODE = 503;

    /**
     * Create and send request
     *
     * @param string $url     Url request
     * @param string $fields  optional Fields for request
     * @param array  $headers optional Headers for request
     *
     * @return RequestInterface
     */
    public function send(string $url, string $fields = null, array $headers = null): self;
}
