<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\SamplesData\Sample;

/**
 * Class SampleAttributes
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\SamplesData\Sample
 * @since 1.3.0
 */
class SampleAttributes
{
    /**
     * @var \DateTimeImmutable|null
     */
    public $createdAt;
    /**
     * @var null|string
     */
    public $shardId;
    /**
     * @var null|string
     */
    public $titleId;

    /**
     * SampleAttributes constructor.
     *
     * @param \DateTimeImmutable|null $createdAt
     * @param null|string $shardId
     * @param null|string $titleId
     */
    public function __construct(
        ?\DateTimeImmutable $createdAt,
        ?string $shardId,
        ?string $titleId
    ) {
        $this->createdAt = $createdAt;
        $this->shardId = $shardId;
        $this->titleId = $titleId;
    }

    /**
     * @param array $data
     *
     * @return SampleAttributes
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            new \DateTimeImmutable($data['createdAt']),
            $data['shardId'],
            $data['titleId']
        );
    }
}