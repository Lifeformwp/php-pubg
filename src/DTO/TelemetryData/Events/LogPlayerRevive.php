<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogPlayerRevive
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.4.0
 */
class LogPlayerRevive
{
    /**
     * @var Character|null
     */
    public $reviver;
    /**
     * @var Character|null
     */
    public $victim;
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
     * LogPlayerRevive constructor.
     *
     * @param Character|null          $reviver
     * @param Character|null          $victim
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?Character $reviver,
        ?Character $victim,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->reviver = $reviver;
        $this->victim  = $victim;
        $this->common  = $common;
        $this->date    = $date;
        $this->type    = $type;
    }

    /**
     * @param array|null $data
     *
     * @return LogPlayerRevive
     */
    public static function createFromResponse(?array $data): self
    {
        return new self(
            Character::createFromResponse($data['reviver']),
            Character::createFromResponse($data['victim']),
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}