<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Item;

/**
 * Class LogArmorDestroy
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.5.0
 */
class LogArmorDestroy
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
    public $damageReason;
    /**
     * @var null|string
     */
    public $damageCauserName;
    /**
     * @var Item|null
     */
    public $item;
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
     * LogArmorDestroy constructor.
     *
     * @param int|null                $attackId
     * @param Character|null          $attacker
     * @param Character|null          $victim
     * @param null|string             $damageTypeCategory
     * @param null|string             $damageReason
     * @param null|string             $damageCauserName
     * @param Item|null               $item
     * @param float|null              $distance
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?int $attackId,
        ?Character $attacker,
        ?Character $victim,
        ?string $damageTypeCategory,
        ?string $damageReason,
        ?string $damageCauserName,
        ?Item $item,
        ?float $distance,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->attackId           = $attackId;
        $this->attacker           = $attacker;
        $this->victim             = $victim;
        $this->damageTypeCategory = $damageTypeCategory;
        $this->damageReason       = $damageReason;
        $this->damageCauserName   = $damageCauserName;
        $this->item               = $item;
        $this->distance           = $distance;
        $this->common             = $common;
        $this->date               = $date;
        $this->type               = $type;
    }

    /**
     * @param array|null $data
     *
     * @return LogArmorDestroy
     */
    public static function createFromResponse(?array $data): self
    {
        return new self(
            $data['attackId'],
            Character::createFromResponse($data['attacker']),
            Character::createFromResponse($data['victim']),
            $data['damageTypeCategory'],
            $data['damageReason'],
            $data['damageCauserName'],
            Item::createFromResponse($data['item']),
            $data['distance'],
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}