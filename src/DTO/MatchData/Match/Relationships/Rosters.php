<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships;

/**
 * Class Rosters
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships
 * @since   1.1.0
 */
class Rosters
{
    /**
     * @var array|[]
     */
    public $data;

    /**
     * Rosters constructor.
     *
     * @param array|null $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     *
     * @return Rosters
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['data']
        );
    }
}