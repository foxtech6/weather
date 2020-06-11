<?php

namespace Src\Exceptions;

use Exception;
use Src\RequestInterface;

/**
 * Class ApiWeatherException
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 10.06.2020
 */
class ApiWeatherException extends Exception
{
    /**
     * @var string
     */
    protected const MESSAGE = 'Api OpenWeatherMap not available';

    /**
     * @var int
     */
    protected const CODE = RequestInterface::SERVICE_UNAVAILABLE_CODE;

    /**
     * ApiWeatherException constructor
     *
     * @param string $message optional Exception message
     * @param int    $code    optional Exception code
     */
    public function __construct(string $message = null, int $code = null)
    {
        parent::__construct($message ?? static::MESSAGE, $code ?? static::CODE);
    }
}
