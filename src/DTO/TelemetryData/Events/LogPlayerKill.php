<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogPlayerKill
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.3.0
 */
class LogPlayerKill
{
    /**
     * @var int|null
     */
    public $attackId;
    /**
     * @var Character|null
     */
    public $killer;
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
     * @var null|string
     */
    public $damageReason;
    /**
     * @var float|null
     */
    public $distance;
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
     * LogPlayerKill constructor.
     *
     * @param int|null                $attackId
     * @param Character|null          $killer
     * @param Character|null          $victim
     * @param null|string             $damageTypeCategory
     * @param null|string             $damageCauserName
     * @param null|string             $damageReason
     * @param float|null              $distance
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?int $attackId,
        ?Character $killer,
        ?Character $victim,
        ?string $damageTypeCategory,
        ?string $damageCauserName,
        ?string $damageReason,
        ?float $distance,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->attackId           = $attackId;
        $this->killer             = $killer;
        $this->victim             = $victim;
        $this->damageTypeCategory = $damageTypeCategory;
        $this->damageCauserName   = $damageCauserName;
        $this->damageReason       = $damageReason;
        $this->distance           = $distance;
        $this->common             = $common;
        $this->date               = $date;
        $this->type               = $type;
    }

    /**
     * @param array $data
     *
     * @return LogPlayerKill
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['attackId'],
            Character::createFromResponse($data['killer']),
            Character::createFromResponse($data['victim']),
            $data['damageTypeCategory'],
            $data['damageCauserName'],
            $data['damageReason'] ?? null,
            $data['distance'],
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}