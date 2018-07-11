<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\PlayerData\Player;

/**
 * Class Data
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\PlayerData\Player
 * @since   1.1.0
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
     * @var PlayerAttributes|null
     */
    public $attributes;
    /**
     * @var PlayerRelationships|null
     */
    public $relationships;
    /**
     * @var PlayerLinks|null
     */
    public $links;

    /**
     * Data constructor.
     *
     * @param null|string              $type
     * @param null|string              $id
     * @param PlayerAttributes|null    $attributes
     * @param PlayerRelationships|null $relationships
     * @param PlayerLinks|null         $links
     */
    public function __construct(
        ?string $type,
        ?string $id,
        ?PlayerAttributes $attributes,
        ?PlayerRelationships $relationships,
        ?PlayerLinks $links
    ) {
        $this->type          = $type;
        $this->id            = $id;
        $this->attributes    = $attributes;
        $this->relationships = $relationships;
        $this->links         = $links;
    }

    /**
     * @param array $data
     *
     * @return Data
     */
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