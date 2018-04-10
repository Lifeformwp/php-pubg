<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Included;

use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\IncludedRosterAttributes;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\IncludedRelationships;

/**
 * Class Roster
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Included
 * @since 1.1.0
 */
class Roster
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
     * @var IncludedRosterAttributes|null
     */
    public $attributes;
    /**
     * @var IncludedRelationships|null
     */
    public $relationships;

    /**
     * Roster constructor.
     *
     * @param null|string $type
     * @param null|string $id
     * @param IncludedRosterAttributes|null $attributes
     * @param IncludedRelationships|null $relationships
     */
    public function __construct(
        ?string $type,
        ?string $id,
        ?IncludedRosterAttributes $attributes,
        ?IncludedRelationships $relationships
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->attributes = $attributes;
        $this->relationships = $relationships;
    }

    /**
     * @param array $data
     *
     * @return Roster
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['type'],
            $data['id'],
            $data['attributes'],
            $data['relationships']
        );
    }
}