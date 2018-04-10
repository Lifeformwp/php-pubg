<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

class LogPlayerLogin
{
    public $result;
    public $errorMessage;
    public $accountId;
    public $common;
    public $version;
    public $date;
    public $type;
}