<?php

namespace Src\Exceptions;

use Exception;
use Src\CurlManager;

class ApiWeatherException extends Exception
{
    protected const MESSAGE = 'Api OpenWeatherMap not available';
    protected const CODE = CurlManager::SERVICE_UNAVAILABLE_CODE;

    public function __construct()
    {
        parent::__construct(static::MESSAGE, static::CODE);
    }
}