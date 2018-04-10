<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO;

use Lifeformwp\PHPPUBG\DTO\PlayerData\Links\Links;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Meta\Meta;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Data;

/**
 * Class Players
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO
 * @since 1.1.0
 */
class Players implements DTOInterface
{
    /**
     * @var Data|[]
     */
    public $data;
    /**
     * @var Links|null
     */
    public $links;
    /**
     * @var Meta|null
     */
    public $meta;

    /**
     * Players constructor.
     *
     * @param Data|[] $data
     * @param Links|null $links
     * @param Meta|null $meta
     */
    public function __construct(
        ?array $data,
        ?Links $links,
        ?Meta $meta
    ) {
        $this->data = $data;
        $this->links = $links;
        $this->meta = $meta;
    }

    /**
     * @param array $data
     *
     * @return Players
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['data'],
            $data['links'],
            $data['meta']
        );
    }
}