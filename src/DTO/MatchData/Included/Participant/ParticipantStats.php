<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Included\Participant;

/**
 * Class ParticipantStats
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Included\Participant
 * @since   1.1.0
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
     * @var float|null
     */
    public $swimDistance;
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
    public $rankPoints;

    /**
     * ParticipantStats constructor.
     *
     * @param int|null    $DBNOs
     * @param int|null    $assists
     * @param int|null    $boosts
     * @param float|null  $damageDealt
     * @param null|string $deathType
     * @param int|null    $headshotKills
     * @param int|null    $heals
     * @param int|null    $killPlace
     * @param int|null    $killStreaks
     * @param int|null    $kills
     * @param int|null    $lastKillPoints
     * @param int|null    $lastWinPoints
     * @param float|null  $longestKill
     * @param int|null    $mostDamage
     * @param null|string $name
     * @param null|string $playerId
     * @param int|null    $revives
     * @param float|null  $rideDistance
     * @param int|null    $roadKills
     * @param float|null  $swimDistance
     * @param int|null    $teamKills
     * @param float|null  $timeSurvived
     * @param int|null    $vehicleDestroys
     * @param float|null  $walkDistance
     * @param int|null    $weaponsAcquired
     * @param int|null    $winPlace
     * @param int|null    $rankPoints
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
        ?int $killStreaks,
        ?int $kills,
        ?int $lastKillPoints,
        ?int $lastWinPoints,
        ?float $longestKill,
        ?int $mostDamage,
        ?string $name,
        ?string $playerId,
        ?int $revives,
        ?float $rideDistance,
        ?int $roadKills,
        ?float $swimDistance,
        ?int $teamKills,
        ?float $timeSurvived,
        ?int $vehicleDestroys,
        ?float $walkDistance,
        ?int $weaponsAcquired,
        ?int $winPlace,
        ?int $rankPoints
    ) {
        $this->DBNOs           = $DBNOs;
        $this->assists         = $assists;
        $this->boosts          = $boosts;
        $this->damageDealt     = $damageDealt;
        $this->deathType       = $deathType;
        $this->headshotKills   = $headshotKills;
        $this->heals           = $heals;
        $this->killPlace       = $killPlace;
        $this->killStreaks     = $killStreaks;
        $this->kills           = $kills;
        $this->lastKillPoints  = $lastKillPoints;
        $this->lastWinPoints   = $lastWinPoints;
        $this->longestKill     = $longestKill;
        $this->mostDamage      = $mostDamage;
        $this->name            = $name;
        $this->playerId        = $playerId;
        $this->revives         = $revives;
        $this->rideDistance    = $rideDistance;
        $this->roadKills       = $roadKills;
        $this->swimDistance    = $swimDistance;
        $this->teamKills       = $teamKills;
        $this->timeSurvived    = $timeSurvived;
        $this->vehicleDestroys = $vehicleDestroys;
        $this->walkDistance    = $walkDistance;
        $this->weaponsAcquired = $weaponsAcquired;
        $this->winPlace        = $winPlace;
        $this->rankPoints      = $rankPoints;
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
            $data['swimDistance'],
            $data['teamKills'],
            $data['timeSurvived'],
            $data['vehicleDestroys'],
            $data['walkDistance'],
            $data['weaponsAcquired'],
            $data['winPlace'],
            $data['rankPoints']
        );
    }
}