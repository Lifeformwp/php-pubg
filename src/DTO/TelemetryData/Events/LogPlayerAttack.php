<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Item;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Vehicle;

/**
 * Class LogPlayerAttack
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.3.0
 */
class LogPlayerAttack
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
     * @var null|string
     */
    public $attackType;
    /**
     * @var Item|null
     */
    public $weapon;
    /**
     * @var Vehicle|null
     */
    public $vehicle;
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
     * LogPlayerAttack constructor.
     *
     * @param int|null                $attackId
     * @param Character|null          $attacker
     * @param null|string             $attackType
     * @param Item|null               $weapon
     * @param Vehicle|null            $vehicle
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?int $attackId,
        ?Character $attacker,
        ?string $attackType,
        ?Item $weapon,
        ?Vehicle $vehicle,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->attackId   = $attackId;
        $this->attacker   = $attacker;
        $this->attackType = $attackType;
        $this->weapon     = $weapon;
        $this->vehicle    = $vehicle;
        $this->common     = $common;
        $this->date       = $date;
        $this->type       = $type;
    }

    /**
     * @param array $data
     *
     * @return LogPlayerAttack
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['attackId'],
            Character::createFromResponse($data['attacker']),
            $data['attackType'],
            Item::createFromResponse($data['weapon']),
            Vehicle::createFromResponse($data['vehicle']),
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}