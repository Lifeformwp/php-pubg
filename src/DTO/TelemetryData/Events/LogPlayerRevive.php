<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;

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
     * LogPlayerRevive constructor.
     *
     * @param Character|null $reviver
     * @param Character|null $victim
     */
    public function __construct(?Character $reviver, ?Character $victim)
    {
        $this->reviver = $reviver;
        $this->victim  = $victim;
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
            Character::createFromResponse($data['victim'])
        );
    }
}