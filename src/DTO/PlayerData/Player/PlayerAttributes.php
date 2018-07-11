<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\PlayerData\Player;

/**
 * Class PlayerAttributes
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\PlayerData\Player
 * @since   1.1.0
 */
class PlayerAttributes
{
    /**
     * @var null|string
     */
    public $name;
    /**
     * @var null|string
     */
    public $patchVersion;
    /**
     * @var null|string
     */
    public $shardId;
    /**
     * @var array|[]
     */
    public $stats;
    /**
     * @var null|string
     */
    public $titleId;

    /**
     * PlayerAttributes constructor.
     *
     * @param null|string $name
     * @param null|string $patchVersion
     * @param null|string $shardId
     * @param array|[] $stats
     * @param null|string $titleId
     */
    public function __construct(
        ?string $name,
        ?string $patchVersion,
        ?string $shardId,
        ?array $stats,
        ?string $titleId
    ) {
        $this->name         = $name;
        $this->patchVersion = $patchVersion;
        $this->shardId      = $shardId;
        $this->stats        = $stats;
        $this->titleId      = $titleId;
    }

    /**
     * @param array $data
     *
     * @return PlayerAttributes
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['name'],
            $data['patchVersion'],
            $data['shardId'],
            $data['stats'],
            $data['titleId']
        );
    }
}