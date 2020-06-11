<?php
require_once 'vendor/autoload.php';

use Src\{Weather, SmsSender, CurlManager};

const CHECK_TEMPERATURE = 293;

$curl = new CurlManager();
$temperature = (new Weather($curl, 'Thessaloniki'))->temperature();

$number = '+306948872100';
$message = 'Your name and Temperature less than 20C. %temperature%';

if ($temperature > CHECK_TEMPERATURE) {
    $number = '+306948872100';
    $message = 'Your name and Temperature more than 20C. %temperature%';
}

(new SmsSender($curl))->send(
    $number,
    str_replace(
        '%temperature%',
        $temperature - env('different_kelvin_celsius'),
        $message
    )
);
