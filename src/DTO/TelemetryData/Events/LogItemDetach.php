<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

class LogItemDetach
{
    public $character;
    public $parentItem;
    public $childItem;
    public $common;
    public $version;
    public $date;
    public $type;
}