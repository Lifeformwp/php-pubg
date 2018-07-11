<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Vehicle;

/**
 * Class LogWheelDestroy
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.4.0
 */
class LogWheelDestroy
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
     * LogWheelDestroy constructor.
     *
     * @param int|null       $attackId
     * @param Character|null $attacker
     * @param Vehicle|null   $vehicle
     * @param null|string    $damageTypeCategory
     * @param null|string    $damageCauserName
     */
    public function __construct(
        ?int $attackId,
        ?Character $attacker,
        ?Vehicle $vehicle,
        ?string $damageTypeCategory,
        ?string $damageCauserName
    ) {
        $this->attackId           = $attackId;
        $this->attacker           = $attacker;
        $this->vehicle            = $vehicle;
        $this->damageTypeCategory = $damageTypeCategory;
        $this->damageCauserName   = $damageCauserName;
    }

    /**
     * @param array|null $data
     *
     * @return LogWheelDestroy
     */
    public static function createFromResponse(?array $data): self
    {
        return new self(
            $data['attackId'],
            Character::createFromResponse($data['attacker']),
            Vehicle::createFromResponse($data['vehicle']),
            $data['damageTypeCategory'],
            $data['damageCauserName']
        );
    }
}