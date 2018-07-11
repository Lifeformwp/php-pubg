<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

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
     * LogSwimEnd constructor.
     *
     * @param Character|null          $character
     * @param float|null              $swimDistance
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?Character $character,
        ?float $swimDistance,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->character    = $character;
        $this->swimDistance = $swimDistance;
        $this->common       = $common;
        $this->date         = $date;
        $this->type         = $type;
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
            $data['swimDistance'] ?? null,
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}