<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogMatchStart
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since 1.3.0
 */
class LogMatchStart
{
    /**
     * @var null|string
     */
    public $mapName;
    /**
     * @var null|string
     */
    public $weatherId;
    /**
     * @var array|null
     */
    public $characters;
    /**
     * @var Common|null
     */
    public $common;
    /**
     * @var int|null
     */
    public $version;
    /**
     * @var \DateTimeImmutable|null
     */
    public $date;
    /**
     * @var null|string
     */
    public $type;

    /**
     * LogMatchStart constructor.
     *
     * @param null|string $mapName
     * @param null|string $weatherId
     * @param array|null $characters
     * @param Common|null $common
     * @param int|null $version
     * @param \DateTimeImmutable|null $date
     * @param null|string $type
     */
    public function __construct(
        ?string $mapName,
        ?string $weatherId,
        ?array $characters,
        ?Common $common,
        ?int $version,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->mapName = $mapName;
        $this->weatherId = $weatherId;
        $this->characters = $characters;
        $this->common = $common;
        $this->version = $version;
        $this->date = $date;
        $this->type = $type;
    }

    /**
     * @param array $data
     *
     * @return LogMatchStart
     */
    public static function createFromResponse(array $data): self
    {
        $characters = [];

        foreach ($data['characters'] as $item) {
            $characters[] = Character::createFromResponse($item);
        }

        return new self(
            $data['mapName'],
            $data['weatherId'],
            $characters,
            Common::createFromResponse($data['common']),
            $data['_V'],
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}