<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogPlayerKill
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since 1.3.0
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
     * @var float|null
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
     * LogPlayerKill constructor.
     *
     * @param int|null $attackId
     * @param Character|null $killer
     * @param Character|null $victim
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
        ?Character $killer,
        ?Character $victim,
        ?string $damageTypeCategory,
        ?string $damageCauserName,
        ?float $distance,
        ?Common $common,
        ?int $version,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->attackId = $attackId;
        $this->killer = $killer;
        $this->victim = $victim;
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
            $data['distance'],
            Common::createFromResponse($data['common']),
            $data['_V'],
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}