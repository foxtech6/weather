<?php
require_once 'vendor/autoload.php';

use Src\{Weather, SmsSender};

const CITY = 'Thessaloniki';
const CHECK_TEMPERATURE = 293;

$temperature = (new Weather(CITY))->temperature();
$number = '+380631479363';//'+306948872100';
$message = 'Your name and Temperature less than 20C. %temperature%';

if ($temperature > CHECK_TEMPERATURE) {
    $number = '+380631479363';//'+306948872100';
    $message = 'Your name and Temperature more than 20C. %temperature%';
}

$message = str_replace(
    '%temperature%',
    $temperature - env('different_kelvin_celsius'),
    $message
);

(new SmsSender())->send($number, $message);
