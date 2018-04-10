<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\Attributes;

/**
 * Class RosterStats
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Included\Attributes
 * @since 1.1.0
 */
class RosterStats
{
    /**
     * @var int|null
     */
    public $rank;
    /**
     * @var int|null
     */
    public $teamId;

    /**
     * RosterStats constructor.
     *
     * @param int|null $rank
     * @param int|null $teamId
     */
    public function __construct(?int $rank, ?int $teamId)
    {
        $this->rank = $rank;
        $this->teamId = $teamId;
    }

    /**
     * @param array $data
     *
     * @return RosterStats
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['rank'],
            $data['teamId']
        );
    }
}