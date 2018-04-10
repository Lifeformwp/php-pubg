<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster;

use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\Relationships\Participants;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\Relationships\Team;

/**
 * Class IncludedRelationships
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster
 * @since 1.1.0
 */
class IncludedRelationships
{
    /**
     * @var Participants|null
     */
    public $participants;
    /**
     * @var Team|null
     */
    public $team;

    /**
     * IncludedRelationships constructor.
     *
     * @param Participants|null $participants
     * @param Team|null $team
     */
    public function __construct(?Participants $participants, ?Team $team)
    {
        $this->participants = $participants;
        $this->team = $team;
    }

    /**
     * @param array $data
     *
     * @return IncludedRelationships
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['participants'],
            $data['team']
        );
    }
}