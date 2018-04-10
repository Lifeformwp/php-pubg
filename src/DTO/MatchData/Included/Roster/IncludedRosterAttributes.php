<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster;

use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\Attributes\RosterStats;

/**
 * Class IncludedRosterAttributes
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster
 * @since 1.1.0
 */
class IncludedRosterAttributes
{
    /**
     * @var null|string
     */
    public $shardId;
    /**
     * @var RosterStats|null
     */
    public $stats;
    /**
     * @var null|string
     */
    public $won;

    /**
     * IncludedRosterAttributes constructor.
     *
     * @param null|string $shardId
     * @param RosterStats|null $stats
     * @param null|string $won
     */
    public function __construct(
        ?string $shardId,
        ?RosterStats $stats,
        ?string $won
    ) {
        $this->shardId = $shardId;
        $this->stats = $stats;
        $this->won = $won;
    }

    /**
     * @param array $data
     *
     * @return IncludedRosterAttributes
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['shardId'],
            $data['stats'],
            $data['won']
        );
    }
}