<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\MatchData\Included\Asset;

/**
 * Class AssetAttributes
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\MatchData\Included\Asset
 * @since   1.1.0
 */
class AssetAttributes
{
    /**
     * @var null|string
     */
    public $URL;
    /**
     * @var \DateTimeImmutable|null
     */
    public $createdAt;
    /**
     * @var null|string
     */
    public $description;
    /**
     * @var null|string
     */
    public $name;

    /**
     * AssetAttributes constructor.
     *
     * @param null|string             $URL
     * @param \DateTimeImmutable|null $createdAt
     * @param null|string             $description
     * @param null|string             $name
     */
    public function __construct(
        ?string $URL,
        ?\DateTimeImmutable $createdAt,
        ?string $description,
        ?string $name
    ) {
        $this->URL         = $URL;
        $this->createdAt   = $createdAt;
        $this->description = $description;
        $this->name        = $name;
    }

    /**
     * @param array $data
     *
     * @return AssetAttributes
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['URL'],
            new \DateTimeImmutable($data['createdAt']),
            $data['description'],
            $data['name']
        );
    }
}