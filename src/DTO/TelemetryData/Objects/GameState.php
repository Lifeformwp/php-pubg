<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects;

/**
 * Class GameState
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects
 * @since   1.3.0
 */
class GameState
{
    /**
     * @var int|null
     */
    public $elapsedTime;
    /**
     * @var int|null
     */
    public $numAliveTeams;
    /**
     * @var int|null
     */
    public $numJoinPlayers;
    /**
     * @var int|null
     */
    public $numStartPlayers;
    /**
     * @var int|null
     */
    public $numAlivePlayers;
    /**
     * @var Location|null
     */
    public $safetyZonePosition;
    /**
     * @var float|null
     */
    public $safetyZoneRadius;
    /**
     * @var Location|null
     */
    public $poisonGasWarningPosition;
    /**
     * @var float|null
     */
    public $poisonGasWarningRadius;
    /**
     * @var Location|null
     */
    public $redZonePosition;
    /**
     * @var float|null
     */
    public $redZoneRadius;

    /**
     * GameState constructor.
     *
     * @param int|null      $elapsedTime
     * @param int|null      $numAliveTeams
     * @param int|null      $numJoinPlayers
     * @param int|null      $numStartPlayers
     * @param int|null      $numAlivePlayers
     * @param Location|null $safetyZonePosition
     * @param float|null    $safetyZoneRadius
     * @param Location|null $poisonGasWarningPosition
     * @param float|null    $poisonGasWarningRadius
     * @param Location|null $redZonePosition
     * @param float|null    $redZoneRadius
     */
    public function __construct(
        ?int $elapsedTime,
        ?int $numAliveTeams,
        ?int $numJoinPlayers,
        ?int $numStartPlayers,
        ?int $numAlivePlayers,
        ?Location $safetyZonePosition,
        ?float $safetyZoneRadius,
        ?Location $poisonGasWarningPosition,
        ?float $poisonGasWarningRadius,
        ?Location $redZonePosition,
        ?float $redZoneRadius
    ) {
        $this->elapsedTime              = $elapsedTime;
        $this->numAliveTeams            = $numAliveTeams;
        $this->numJoinPlayers           = $numJoinPlayers;
        $this->numStartPlayers          = $numStartPlayers;
        $this->numAlivePlayers          = $numAlivePlayers;
        $this->safetyZonePosition       = $safetyZonePosition;
        $this->safetyZoneRadius         = $safetyZoneRadius;
        $this->poisonGasWarningPosition = $poisonGasWarningPosition;
        $this->poisonGasWarningRadius   = $poisonGasWarningRadius;
        $this->redZonePosition          = $redZonePosition;
        $this->redZoneRadius            = $redZoneRadius;
    }

    /**
     * @param array $data
     *
     * @return GameState
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['elapsedTime'],
            $data['numAliveTeams'],
            $data['numJoinPlayers'],
            $data['numStartPlayers'],
            $data['numAlivePlayers'],
            Location::createFromResponse($data['safetyZonePosition']),
            $data['safetyZoneRadius'],
            Location::createFromResponse($data['poisonGasWarningPosition']),
            $data['poisonGasWarningRadius'],
            Location::createFromResponse($data['redZonePosition']),
            $data['redZoneRadius']
        );
    }
}