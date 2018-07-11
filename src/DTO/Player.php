<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO;

use Lifeformwp\PHPPUBG\DTO\PlayerData\Links\Links;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Meta\Meta;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Data;

/**
 * Class Player
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO
 * @since   1.1.0
 */
class Player implements DTOInterface
{
    /**
     * @var Data|null
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
     * Player constructor.
     *
     * @param Data|null  $data
     * @param Links|null $links
     * @param Meta|null  $meta
     */
    public function __construct(
        ?Data $data,
        ?Links $links,
        ?Meta $meta
    ) {
        $this->data  = $data;
        $this->links = $links;
        $this->meta  = $meta;
    }

    /**
     * @param array $data
     *
     * @return Player
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