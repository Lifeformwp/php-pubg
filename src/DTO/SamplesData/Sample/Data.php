<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\SamplesData\Sample;

/**
 * Class Data
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\SamplesData\Sample
 * @since   1.3.0
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
     * @var SampleAttributes|null
     */
    public $attributes;
    /**
     * @var SampleRelationships|null
     */
    public $relationships;

    /**
     * Data constructor.
     *
     * @param null|string              $type
     * @param null|string              $id
     * @param SampleAttributes|null    $attributes
     * @param SampleRelationships|null $relationships
     */
    public function __construct(
        ?string $type,
        ?string $id,
        ?SampleAttributes $attributes,
        ?SampleRelationships $relationships
    ) {
        $this->type          = $type;
        $this->id            = $id;
        $this->attributes    = $attributes;
        $this->relationships = $relationships;
    }

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