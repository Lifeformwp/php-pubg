<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects;

class GameState
{
    public $elapsedTime;
    public $numAliveTeams;
    public $numJoinPlayers;
    public $numAlivePlayers;
    public $safetyZonePosition;
    public $safetyZoneRadius;
    public $poisonGasWarningPosition;
    public $poisonGasWarningRadius;
    public $redZonePosition;
    public $redZoneRadius;
}