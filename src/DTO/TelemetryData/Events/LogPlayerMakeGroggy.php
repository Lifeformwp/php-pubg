<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogPlayerMakeGroggy
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.5.0
 */
class LogPlayerMakeGroggy
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
     * @var Character|null
     */
    public $victim;
    /**
     * @var null|string
     */
    public $damageTypeCategory;
    /**
     * @var null|string
     */
    public $damageCauserName;
    /**
     * @var float|null
     */
    public $distance;
    /**
     * @var bool|null
     */
    public $isAttackerInVehicle;
    /**
     * @var int|null
     */
    public $dBNOId;
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
     * LogPlayerMakeGroggy constructor.
     *
     * @param int|null                $attackId
     * @param Character|null          $attacker
     * @param Character|null          $victim
     * @param null|string             $damageTypeCategory
     * @param null|string             $damageCauserName
     * @param float|null              $distance
     * @param bool|null               $isAttackerInVehicle
     * @param int|null                $dBNOId
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?int $attackId,
        ?Character $attacker,
        ?Character $victim,
        ?string $damageTypeCategory,
        ?string $damageCauserName,
        ?float $distance,
        ?bool $isAttackerInVehicle,
        ?int $dBNOId,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->attackId            = $attackId;
        $this->attacker            = $attacker;
        $this->victim              = $victim;
        $this->damageTypeCategory  = $damageTypeCategory;
        $this->damageCauserName    = $damageCauserName;
        $this->distance            = $distance;
        $this->isAttackerInVehicle = $isAttackerInVehicle;
        $this->dBNOId              = $dBNOId;
        $this->common              = $common;
        $this->date                = $date;
        $this->type                = $type;
    }

    /**
     * @param array|null $data
     *
     * @return LogPlayerMakeGroggy
     */
    public static function createFromResponse(?array $data): self
    {
        return new self(
            $data['attackId'],
            Character::createFromResponse($data['attacker']),
            Character::createFromResponse($data['victim']),
            $data['damageTypeCategory'],
            $data['damageCauserName'],
            $data['distance'],
            $data['isAttackerInVehicle'],
            $data['dBNOId'],
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}