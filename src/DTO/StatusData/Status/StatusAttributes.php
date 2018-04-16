<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\StatusData\Status;

/**
 * Class StatusAttributes
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\StatusData\Status
 * @since 1.2.0
 */
class StatusAttributes
{
    /**
     * @var \DateTimeImmutable|null
     */
    public $releasedAt;
    /**
     * @var null|string
     */
    public $version;

    /**
     * StatusAttributes constructor.
     *
     * @param \DateTimeImmutable|null $releasedAt
     * @param null|string $version
     */
    public function __construct(
        ?\DateTimeImmutable $releasedAt,
        ?string $version
    ) {
        $this->releasedAt = $releasedAt;
        $this->version = $version;
    }

    /**
     * @param array $data
     *
     * @return StatusAttributes
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            new \DateTimeImmutable($data['releasedAt']),
            $data['version']
        );
    }
}