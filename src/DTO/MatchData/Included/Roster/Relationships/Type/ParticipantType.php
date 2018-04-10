<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\Relationships\Type;

/**
 * Class ParticipantType
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\Relationships\Type
 * @since 1.1.0
 */
class ParticipantType
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
     * ParticipantType constructor.
     *
     * @param null|string $type
     * @param null|string $id
     */
    public function __construct(?string $type, ?string $id)
    {
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * @param array $data
     *
     * @return ParticipantType
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['type'],
            $data['id']
        );
    }
}