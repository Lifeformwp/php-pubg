<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;

/**
 * Class LogSwimEnd
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.4.0
 */
class LogSwimEnd
{
    /**
     * @var Character|null
     */
    public $character;
    /**
     * @var float|null
     */
    public $swimDistance;

    /**
     * LogSwimEnd constructor.
     *
     * @param Character|null $character
     * @param float|null     $swimDistance
     */
    public function __construct(?Character $character, ?float $swimDistance)
    {
        $this->character    = $character;
        $this->swimDistance = $swimDistance;
    }

    /**
     * @param array|null $data
     *
     * @return LogSwimEnd
     */
    public static function createFromResponse(?array $data): self
    {
        return new self(
            Character::createFromResponse($data['character']),
            $data['swimDistance'] ?? null
        );
    }
}