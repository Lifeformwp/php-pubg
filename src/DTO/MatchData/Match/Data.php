<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Match;

/**
 * Class Data
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Match
 * @since 1.1.0
 */
class Data
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
     * @var MatchAttributes|null
     */
    public $attributes;
    /**
     * @var MatchRelationships|null
     */
    public $relationships;
    /**
     * @var MatchLinks|null
     */
    public $links;

    /**
     * Data constructor.
     *
     * @param null|string $type
     * @param null|string $id
     * @param MatchAttributes|null $attributes
     * @param MatchRelationships|null $relationships
     * @param MatchLinks|null $links
     */
    public function __construct(
        ?string $type,
        ?string $id,
        ?MatchAttributes $attributes,
        ?MatchRelationships $relationships,
        ?MatchLinks $links
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->attributes = $attributes;
        $this->relationships = $relationships;
        $this->links = $links;
    }

    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['type'],
            $data['id'],
            $data['attributes'],
            $data['relationships'],
            $data['links']
        );
    }
}