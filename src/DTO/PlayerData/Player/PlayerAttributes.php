<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\PlayerData\Player;

/**
 * Class PlayerAttributes
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\PlayerData\Player
 * @since 1.1.0
 */
class PlayerAttributes
{
    /**
     * @var \DateTimeImmutable|null
     */
    public $createdAt;
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
     * @var \DateTimeImmutable|null
     */
    public $updatedAt;

    /**
     * PlayerAttributes constructor.
     *
     * @param \DateTimeImmutable|null $createdAt
     * @param null|string $name
     * @param null|string $patchVersion
     * @param null|string $shardId
     * @param array|[] $stats
     * @param null|string $titleId
     * @param \DateTimeImmutable|null $updatedAt
     */
    public function __construct(
        ?\DateTimeImmutable $createdAt,
        ?string $name,
        ?string $patchVersion,
        ?string $shardId,
        ?array $stats,
        ?string $titleId,
        ?\DateTimeImmutable $updatedAt
    ) {
        $this->createdAt = $createdAt;
        $this->name = $name;
        $this->patchVersion = $patchVersion;
        $this->shardId = $shardId;
        $this->stats = $stats;
        $this->titleId = $titleId;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param array $data
     *
     * @return PlayerAttributes
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            new \DateTimeImmutable($data['createdAt']),
            $data['name'],
            $data['patchVersion'],
            $data['shardId'],
            $data['stats'],
            $data['titleId'],
            new \DateTimeImmutable($data['updatedAt'])
        );
    }
}