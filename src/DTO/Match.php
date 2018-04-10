<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO;

use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Included;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Data;
use Lifeformwp\PHPPUBG\DTO\MatchData\Meta\Meta;
use Lifeformwp\PHPPUBG\DTO\MatchData\Links\Links;

/**
 * Class Match
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO
 * @since 1.1.0
 */
class Match implements DTOInterface
{
    /**
     * @var Data|null
     */
    public $data;
    /**
     * @var Included|[]
     */
    public $included;
    /**
     * @var Links|null
     */
    public $links;
    /**
     * @var Meta|null
     */
    public $meta;

    /**
     * Match constructor.
     *
     * @param Data|null $data
     * @param Included|null $included
     * @param Links|null $links
     * @param Meta|null $meta
     */
    public function __construct(
        ?Data $data,
        ?Included $included,
        ?Links $links,
        ?Meta $meta
    ) {
        $this->data = $data;
        $this->included = $included;
        $this->links = $links;
        $this->meta = $meta;
    }

    /**
     * @param array $data
     *
     * @return Match
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['data'],
            $data['included'],
            $data['links'],
            $data['meta']
        );
    }
}