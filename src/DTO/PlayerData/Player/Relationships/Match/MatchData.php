<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Relationships\Match;

/**
 * Class MatchData
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Relationships\Match
 * @since   1.1.0
 */
class MatchData
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
     * MatchData constructor.
     *
     * @param null|string $type
     * @param null|string $id
     */
    public function __construct(
        ?string $type,
        ?string $id
    ) {
        $this->type = $type;
        $this->id   = $id;
    }

    /**
     * @param array $data
     *
     * @return MatchData
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['type'],
            $data['id']
        );
    }
}