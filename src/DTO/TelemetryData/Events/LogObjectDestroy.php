<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Location;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogObjectDestroy
 *
 * @author  Henrique Pulpor Muramoto <riquemuramoto@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.9.0
 */
class LogObjectDestroy
{
    /**
     * @var Character|null
     */
    public $character;
    /**
     * @var string|null
     */
    public $objectType;
    /**
     * @var Location|null
     */
    public $objectLocation;
    /**
     * @var Common|null
     */
    public $common;
    /**
     * @var \DateTimeImmutable|null
     */
    public $date;
    /**
     * @var null|string
     */
    public $type;

    public function __construct(
        ?Character $character,
        ?string $objectType,
        ?Location $objectLocation,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->character = $character;
        $this->objectType = $objectType;
        $this->objectLocation = $objectLocation;
        $this->common = $common;
        $this->date = $date;
        $this->type = $type;
    }

    /**
     * @param array|null $data
     *
     * @return LogObjectDestroy
     */
    public static function createFromResponse(?array $data): self
    {
        return new self(
            Character::createFromResponse($data['character']),
            $data['objectType'],
            Location::createFromResponse($data['objectLocation']),
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}
