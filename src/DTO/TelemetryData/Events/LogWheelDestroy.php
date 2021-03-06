<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Vehicle;

/**
 * Class LogWheelDestroy
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.5.0
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

    /**
     * LogWheelDestroy constructor.
     *
     * @param int|null                $attackId
     * @param Character|null          $attacker
     * @param Vehicle|null            $vehicle
     * @param null|string             $damageTypeCategory
     * @param null|string             $damageCauserName
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?int $attackId,
        ?Character $attacker,
        ?Vehicle $vehicle,
        ?string $damageTypeCategory,
        ?string $damageCauserName,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->attackId           = $attackId;
        $this->attacker           = $attacker;
        $this->vehicle            = $vehicle;
        $this->damageTypeCategory = $damageTypeCategory;
        $this->damageCauserName   = $damageCauserName;
        $this->common             = $common;
        $this->date               = $date;
        $this->type               = $type;
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
            $data['damageCauserName'],
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}