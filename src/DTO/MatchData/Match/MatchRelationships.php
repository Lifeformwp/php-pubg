<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Match;

use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Assets;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Rosters;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Rounds;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Spectators;

/**
 * Class MatchRelationships
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Match
 * @since 1.1.0
 */
class MatchRelationships
{
    /**
     * @var Assets|null
     */
    public $assets;
    /**
     * @var Rosters|null
     */
    public $rosters;
    /**
     * @var Rounds|null
     */
    public $rounds;
    /**
     * @var Spectators|null
     */
    public $spectators;

    /**
     * MatchRelationships constructor.
     *
     * @param Assets|null $assets
     * @param Rosters|null $rosters
     * @param Rounds|null $rounds
     * @param Spectators|null $spectators
     */
    public function __construct(
        ?Assets $assets,
        ?Rosters $rosters,
        ?Rounds $rounds,
        ?Spectators $spectators
    ) {
        $this->assets = $assets;
        $this->rosters = $rosters;
        $this->rounds = $rounds;
        $this->spectators = $spectators;
    }

    /**
     * @param array $data
     *
     * @return MatchRelationships
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['assets'],
            $data['rosters'],
            $data['rounds'],
            $data['spectators']
        );
    }
}