<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;

/**
 * Class LogSwimStart
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.4.0
 */
class LogSwimStart
{
    /**
     * @var Character|null
     */
    public $character;

    /**
     * LogSwimStart constructor.
     *
     * @param Character|null $character
     */
    public function __construct(?Character $character)
    {
        $this->character = $character;
    }

    /**
     * @param array|null $data
     *
     * @return LogSwimStart
     */
    public static function createFromResponse(?array $data): self
    {
        return new self(
            Character::createFromResponse($data['character'])
        );
    }
}