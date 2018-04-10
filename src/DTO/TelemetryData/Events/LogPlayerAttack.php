<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

class LogPlayerAttack
{
    public $attackId;
    public $attacker;
    public $attackType;
    public $weapon;
    public $vehicle;
    public $common;
    public $version;
    public $date;
    public $type;
}