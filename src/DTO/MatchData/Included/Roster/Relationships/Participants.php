<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\Relationships;

/**
 * Class Participants
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\Relationships
 * @since 1.1.0
 */
class Participants
{
    /**
     * @var array|[]
     */
    public $data;

    /**
     * Participants constructor.
     *
     * @param array|[] $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     *
     * @return Participants
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['data']
        );
    }
}