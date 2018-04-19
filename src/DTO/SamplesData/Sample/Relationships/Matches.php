<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\Relationships;

/**
 * Class Matches
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\Relationships
 * @since 1.3.0
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
     * @param array|null $data
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
            $data['data']
        );
    }
}