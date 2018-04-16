<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\StatusData\Status;

/**
 * Class Data
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\StatusData\Status
 * @since 1.2.0
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
     * @var StatusAttributes
     */
    public $attributes;

    /**
     * Data constructor.
     *
     * @param null|string $type
     * @param null|string $id
     * @param StatusAttributes $attributes
     */
    public function __construct(
        ?string $type,
        ?string $id,
        StatusAttributes $attributes
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->attributes = $attributes;
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
            $data['attributes']
        );
    }
}