<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO;
use Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\Data;

/**
 * Class Samples
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO
 * @since 1.3.0
 */
class Samples implements DTOInterface
{
    /**
     * @var Data|null
     */
    public $data;

    /**
     * Samples constructor.
     *
     * @param Data|null $data
     */
    public function __construct(?Data $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     *
     * @return Samples
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['data']
        );
    }
}