<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Vehicle;

/**
 * Class LogVehicleDestroy
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since 1.3.0
 */
class LogVehicleDestroy
{
    /**
     * @var int|null
     */
    public $attackId;
    /**
     * @var Character|null
     */
    public $attacker;
    /**
     * @var Vehicle|null
     */
    public $vehicle;
    /**
     * @var null|string
     */
    public $damageTypeCategory;
    /**
     * @var null|string
     */
    public $damageCauserName;
    /**
     * @var int|null
     */
    public $distance;
    /**
     * @var Common|null
     */
    public $common;
    /**
     * @var int|null
     */
    public $version;
    /**
     * @var \DateTimeImmutable|null
     */
    public $date;
    /**
     * @var null|string
     */
    public $type;

    /**
     * LogVehicleDestroy constructor.
     *
     * @param int|null $attackId
     * @param Character|null $attacker
     * @param Vehicle|null $vehicle
     * @param null|string $damageTypeCategory
     * @param null|string $damageCauserName
     * @param float|null $distance
     * @param Common|null $common
     * @param int|null $version
     * @param \DateTimeImmutable|null $date
     * @param null|string $type
     */
    public function __construct(
        ?int $attackId,
        ?Character $attacker,
        ?Vehicle $vehicle,
        ?string $damageTypeCategory,
        ?string $damageCauserName,
        ?float $distance,
        ?Common $common,
        ?int $version,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->attackId = $attackId;
        $this->attacker = $attacker;
        $this->vehicle = $vehicle;
        $this->damageTypeCategory = $damageTypeCategory;
        $this->damageCauserName = $damageCauserName;
        $this->distance = $distance;
        $this->common = $common;
        $this->version = $version;
        $this->date = $date;
        $this->type = $type;
    }

    /**
     * @param array $data
     *
     * @return LogVehicleDestroy
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['attackId'],
            Character::createFromResponse($data['attacker']),
            Vehicle::createFromResponse($data['vehicle']),
            $data['damageTypeCategory'],
            $data['damageCauserName'],
            $data['distance'],
            Common::createFromResponse($data['common']),
            $data['_V'],
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}