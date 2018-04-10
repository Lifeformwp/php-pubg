<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

class LogPlayerTakeDamage
{
    public $attackId;
    public $attacker;
    public $victim;
    public $damageTypeCategory;
    public $damageReason;
    public $damage;
    public $damageCauserName;
    public $common;
    public $version;
    public $date;
    public $type;
}