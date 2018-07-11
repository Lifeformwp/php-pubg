<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\SamplesData\Sample;

/**
 * Class SampleLinks
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\SamplesData\Sample
 * @since   1.3.0
 */
class SampleLinks
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
     * SampleLinks constructor.
     *
     * @param null|string $schema
     * @param null|string $self
     */
    public function __construct(
        ?string $schema,
        ?string $self
    ) {
        $this->schema = $schema;
        $this->self   = $self;
    }

    /**
     * @param array $data
     *
     * @return SampleLinks
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['schema'],
            $data['self']
        );
    }
}