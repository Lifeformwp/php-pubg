<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Included\Participant;

/**
 * Class IncludedParticipantAttributes
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Included\Participant
 * @since 1.1.0
 */
class IncludedParticipantAttributes
{
    /**
     * @var null|string
     */
    public $actor;
    /**
     * @var null|string
     */
    public $shardId;
    /**
     * @var ParticipantStats|null
     */
    public $stats;

    /**
     * IncludedParticipantAttributes constructor.
     *
     * @param null|string $actor
     * @param null|string $shardId
     * @param ParticipantStats|null $stats
     */
    public function __construct(
        ?string $actor,
        ?string $shardId,
        ?ParticipantStats $stats
    ){
        $this->actor = $actor;
        $this->shardId = $shardId;
        $this->stats = $stats;
    }

    /**
     * @param array $data
     *
     * @return IncludedParticipantAttributes
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['actor'],
            $data['shardId'],
            $data['stats']
        );
    }
}