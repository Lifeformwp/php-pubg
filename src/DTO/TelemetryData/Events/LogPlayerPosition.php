<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogPlayerPosition
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since 1.3.0
 */
class LogPlayerPosition
{
    /**
     * @var Character|null
     */
    public $character;
    /**
     * @var int|null
     */
    public $elapsedTime;
    /**
     * @var int|null
     */
    public $numAlivePlayers;
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
     * LogPlayerPosition constructor.
     *
     * @param Character|null $character
     * @param int|null $elapsedTime
     * @param int|null $numAlivePlayers
     * @param Common|null $common
     * @param int|null $version
     * @param \DateTimeImmutable|null $date
     * @param null|string $type
     */
    public function __construct(
        ?Character $character,
        ?int $elapsedTime,
        ?int $numAlivePlayers,
        ?Common $common,
        ?int $version,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->character = $character;
        $this->elapsedTime = $elapsedTime;
        $this->numAlivePlayers = $numAlivePlayers;
        $this->common = $common;
        $this->version = $version;
        $this->date = $date;
        $this->type = $type;
    }

    /**
     * @param array $data
     *
     * @return LogPlayerPosition
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            Character::createFromResponse($data['character']),
            $data['elapsedTime'],
            $data['numAlivePlayers'],
            Common::createFromResponse($data['common']),
            $data['_V'],
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}