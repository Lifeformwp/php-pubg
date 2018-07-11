<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Relationships;

/**
 * Class Matches
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Relationships
 * @since   1.1.0
 */
class Matches
{
    /**
     * @var array|[]
     */
    public $data;

    /**
     * Matches constructor.
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
     * @return Matches
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['data'] ?? []
        );
    }
}