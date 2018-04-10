<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Included\Participant;

/**
 * Class ParticipantStats
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Included\Participant
 * @since 1.1.0
 */
class ParticipantStats
{
    /**
     * @var int|null
     */
    public $DBNOs;
    /**
     * @var int|null
     */
    public $assists;
    /**
     * @var int|null
     */
    public $boosts;
    /**
     * @var int|null
     */
    public $damageDealt;
    /**
     * @var null|string
     */
    public $deathType;
    /**
     * @var int|null
     */
    public $headshotKills;
    /**
     * @var int|null
     */
    public $heals;
    /**
     * @var int|null
     */
    public $killPlace;
    /**
     * @var int|null
     */
    public $killPoints;
    /**
     * @var
     */
    public $killPointsDelta;
    /**
     * @var int|null
     */
    public $killStreaks;
    /**
     * @var int|null
     */
    public $kills;
    /**
     * @var int|null
     */
    public $lastKillPoints;
    /**
     * @var int|null
     */
    public $lastWinPoints;
    /**
     * @var int|null
     */
    public $longestKill;
    /**
     * @var int|null
     */
    public $mostDamage;
    /**
     * @var null|string
     */
    public $name;
    /**
     * @var null|string
     */
    public $playerId;
    /**
     * @var int|null
     */
    public $revives;
    /**
     * @var int|null
     */
    public $rideDistance;
    /**
     * @var int|null
     */
    public $roadKills;
    /**
     * @var int|null
     */
    public $teamKills;
    /**
     * @var int|null
     */
    public $timeSurvived;
    /**
     * @var int|null
     */
    public $vehicleDestroys;
    /**
     * @var float|null
     */
    public $walkDistance;
    /**
     * @var int|null
     */
    public $weaponsAcquired;
    /**
     * @var int|null
     */
    public $winPlace;
    /**
     * @var int|null
     */
    public $winPoints;
    /**
     * @var float|null
     */
    public $winPointsDelta;

    /**
     * ParticipantStats constructor.
     *
     * @param $DBNOs
     * @param $assists
     * @param $boosts
     * @param $damageDealt
     * @param $deathType
     * @param $headshotKills
     * @param $heals
     * @param $killPlace
     * @param $killPoints
     * @param $killPointsDelta
     * @param $killStreaks
     * @param $kills
     * @param $lastKillPoints
     * @param $lastWinPoints
     * @param $longestKill
     * @param $mostDamage
     * @param $name
     * @param $playerId
     * @param $revives
     * @param $rideDistance
     * @param $roadKills
     * @param $teamKills
     * @param $timeSurvived
     * @param $vehicleDestroys
     * @param $walkDistance
     * @param $weaponsAcquired
     * @param $winPlace
     * @param $winPoints
     * @param $winPointsDelta
     */
    public function __construct(
        ?int $DBNOs,
        ?int $assists,
        ?int $boosts,
        ?float $damageDealt,
        ?string $deathType,
        ?int $headshotKills,
        ?int $heals,
        ?int $killPlace,
        ?int $killPoints,
        ?float $killPointsDelta,
        ?int $killStreaks,
        ?int $kills,
        ?int $lastKillPoints,
        ?int $lastWinPoints,
        ?int $longestKill,
        ?int $mostDamage,
        ?string $name,
        ?string $playerId,
        ?int $revives,
        ?float $rideDistance,
        ?int $roadKills,
        ?int $teamKills,
        ?int $timeSurvived,
        ?int $vehicleDestroys,
        ?float $walkDistance,
        ?int $weaponsAcquired,
        ?int $winPlace,
        ?int $winPoints,
        ?float $winPointsDelta
    ) {
        $this->DBNOs = $DBNOs;
        $this->assists = $assists;
        $this->boosts = $boosts;
        $this->damageDealt = $damageDealt;
        $this->deathType = $deathType;
        $this->headshotKills = $headshotKills;
        $this->heals = $heals;
        $this->killPlace = $killPlace;
        $this->killPoints = $killPoints;
        $this->killPointsDelta = $killPointsDelta;
        $this->killStreaks = $killStreaks;
        $this->kills = $kills;
        $this->lastKillPoints = $lastKillPoints;
        $this->lastWinPoints = $lastWinPoints;
        $this->longestKill = $longestKill;
        $this->mostDamage = $mostDamage;
        $this->name = $name;
        $this->playerId = $playerId;
        $this->revives = $revives;
        $this->rideDistance = $rideDistance;
        $this->roadKills = $roadKills;
        $this->teamKills = $teamKills;
        $this->timeSurvived = $timeSurvived;
        $this->vehicleDestroys = $vehicleDestroys;
        $this->walkDistance = $walkDistance;
        $this->weaponsAcquired = $weaponsAcquired;
        $this->winPlace = $winPlace;
        $this->winPoints = $winPoints;
        $this->winPointsDelta = $winPointsDelta;
    }

    /**
     * @param array $data
     *
     * @return ParticipantStats
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['DBNOs'],
            $data['assists'],
            $data['boosts'],
            $data['damageDealt'],
            $data['deathType'],
            $data['headshotKills'],
            $data['heals'],
            $data['killPlace'],
            $data['killPoints'],
            $data['killPointsDelta'],
            $data['killStreaks'],
            $data['kills'],
            $data['lastKillPoints'],
            $data['lastWinPoints'],
            $data['longestKill'],
            $data['mostDamage'],
            $data['name'],
            $data['playerId'],
            $data['revives'],
            $data['rideDistance'],
            $data['roadKills'],
            $data['teamKills'],
            $data['timeSurvived'],
            $data['vehicleDestroys'],
            $data['walkDistance'],
            $data['weaponsAcquired'],
            $data['winPlace'],
            $data['winPoints'],
            $data['winPointsDelta']
        );
    }
}