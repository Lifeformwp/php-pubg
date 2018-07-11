<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\GameState;

/**
 * Class LogGameStatePeriodic
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.3.0
 */
class LogGameStatePeriodic
{
    /**
     * @var GameState|null
     */
    public $gameState;
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
     * LogGameStatePeriodic constructor.
     *
     * @param GameState|null          $gameState
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?GameState $gameState,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->gameState = $gameState;
        $this->common    = $common;
        $this->date      = $date;
        $this->type      = $type;
    }

    /**
     * @param array $data
     *
     * @return LogGameStatePeriodic
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            GameState::createFromResponse($data['gameState']),
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}