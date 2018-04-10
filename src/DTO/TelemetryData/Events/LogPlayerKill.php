<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

class LogPlayerKill
{
    public $attackId;
    public $killer;
    public $victim;
    public $damageTypeCategory;
    public $damageCauserName;
    public $distance;
    public $common;
    public $version;
    public $date;
    public $type;
}