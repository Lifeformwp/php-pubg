<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Included;

use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Participant\IncludedParticipantAttributes;

/**
 * Class Participant
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Included
 * @since 1.1.0
 */
class Participant
{
    /**
     * @var null|string
     */
    public $type;
    /**
     * @var null|string
     */
    public $id;
    /**
     * @var IncludedParticipantAttributes|null
     */
    public $attributes;

    /**
     * Participant constructor.
     *
     * @param null|string $type
     * @param null|string $id
     * @param IncludedParticipantAttributes|null $attributes
     */
    public function __construct(
        ?string $type,
        ?string $id,
        ?IncludedParticipantAttributes $attributes
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->attributes = $attributes;
    }

    /**
     * @param array $data
     *
     * @return Participant
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['type'],
            $data['id'],
            $data['attributes']
        );
    }
}