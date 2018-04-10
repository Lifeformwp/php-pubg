<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Match;

/**
 * Class MatchLinks
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\MatchData\DTO\Match
 * @since 1.1.0
 */
class MatchLinks
{
    /**
     * @var null|string
     */
    public $schema;
    /**
     * @var null|string
     */
    public $self;

    /**
     * MatchLinks constructor.
     *
     * @param null|string $schema
     * @param null|string $self
     */
    public function __construct(
        ?string $schema,
        ?string $self
    ) {
        $this->schema = $schema;
        $this->self = $self;
    }

    /**
     * @param array $data
     *
     * @return MatchLinks
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['schema'],
            $data['self']
        );
    }
}