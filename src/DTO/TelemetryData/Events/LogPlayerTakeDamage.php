<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogPlayerTakeDamage
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.3.0
 */
class LogPlayerTakeDamage
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
     * @var float|null
     */
    public $damage;
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
     * LogPlayerTakeDamage constructor.
     *
     * @param int|null                $attackId
     * @param Character|null          $attacker
     * @param Character|null          $victim
     * @param null|string             $damageTypeCategory
     * @param null|string             $damageReason
     * @param float|null              $damage
     * @param null|string             $damageCauserName
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
        ?float $damage,
        ?string $damageCauserName,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->attackId           = $attackId;
        $this->attacker           = $attacker;
        $this->victim             = $victim;
        $this->damageTypeCategory = $damageTypeCategory;
        $this->damageReason       = $damageReason;
        $this->damage             = $damage;
        $this->damageCauserName   = $damageCauserName;
        $this->common             = $common;
        $this->date               = $date;
        $this->type               = $type;
    }

    /**
     * @param array $data
     *
     * @return LogPlayerTakeDamage
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['attackId'],
            Character::createFromResponse($data['attacker']),
            Character::createFromResponse($data['victim']),
            $data['damageTypeCategory'],
            $data['damageReason'],
            $data['damage'],
            $data['damageCauserName'],
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}