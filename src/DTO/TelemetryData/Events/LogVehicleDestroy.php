<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

class LogVehicleDestroy
{
    public $attackId;
    public $attacker;
    public $vehicle;
    public $damageTypeCategory;
    public $damageCauserName;
    public $distance;
    public $common;
    public $version;
    public $date;
    public $type;
}