<?php

/*
 ---------------------
|
| Helper file for different functions
|
 ---------------------
 */

/**
 * Get parameters from parameters.yml
 *
 * @param string $parameterName
 *
 * @return string
 */
function env(string $parameterName): string
{
    static $parameters;

    if (empty($parameters)) {
        $parameters = yaml_parse_file('parameters.yml');
    }

    if (empty($parameters[$parameterName])) {
        throw new InvalidArgumentException('Parameter not found', 404);
    }

    return $parameters[$parameterName];
}
