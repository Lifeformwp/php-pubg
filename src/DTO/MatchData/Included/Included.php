<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Included;

/**
 * Class Included
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Included
 * @since 1.1.0
 */
class Included
{
    /**
     * @var Participant[]|[]
     */
    public $rosters;
    /**
     * @var Roster[]|[]
     */
    public $participants;
    /**
     * @var IncludedAsset|null
     */
    public $asset;

    /**
     * Included constructor.
     *
     * @param Participant[]|[] $rosters
     * @param Roster[]|[] $participants
     * @param IncludedAsset|null $asset
     */
    public function __construct(
        ?array $rosters,
        ?array $participants,
        IncludedAsset $asset
    ) {
        $this->rosters = $rosters;
        $this->participants = $participants;
        $this->asset = $asset;
    }

    /**
     * @param array $data
     *
     * @return Included
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['rosters'],
            $data['participants'],
            $data['asset']
        );
    }
}