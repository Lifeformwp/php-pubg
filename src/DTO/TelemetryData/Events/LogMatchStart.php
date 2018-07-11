<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\BlueZoneCustomOption;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogMatchStart
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.3.0
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
     * @var null|string
     */
    public $cameraViewBehaviour;
    /**
     * @var int|null
     */
    public $teamSize;
    /**
     * @var bool|null
     */
    public $isCustomGame;
    /**
     * @var bool|null
     */
    public $isEventMode;
    /**
     * @var array|[]
     */
    public $blueZoneCustomOptions;
    /**
     * @var Common|null
     */
    public $common;
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
     * @param null|string             $mapName
     * @param null|string             $weatherId
     * @param array|null              $characters
     * @param null|string             $cameraViewBehaviour
     * @param int|null                $teamSize
     * @param bool|null               $isCustomGame
     * @param bool|null               $isEventMode
     * @param array|[]                $blueZoneCustomOptions
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?string $mapName,
        ?string $weatherId,
        ?array $characters,
        ?string $cameraViewBehaviour,
        ?int $teamSize,
        ?bool $isCustomGame,
        ?bool $isEventMode,
        ?array $blueZoneCustomOptions,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->mapName               = $mapName;
        $this->weatherId             = $weatherId;
        $this->characters            = $characters;
        $this->cameraViewBehaviour   = $cameraViewBehaviour;
        $this->teamSize              = $teamSize;
        $this->isCustomGame          = $isCustomGame;
        $this->isEventMode           = $isEventMode;
        $this->blueZoneCustomOptions = $blueZoneCustomOptions;
        $this->common                = $common;
        $this->date                  = $date;
        $this->type                  = $type;
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

        $blueZoneCustomOptions = [];

        $options = \json_decode($data['blueZoneCustomOptions'], true);

        foreach ($options as $option) {
            $blueZoneCustomOptions[] = BlueZoneCustomOption::createFromResponse($option);
        }

        return new self(
            $data['mapName'],
            $data['weatherId'],
            $characters,
            $data['cameraViewBehaviour'],
            $data['teamSize'],
            $data['isCustomGame'] ?? null,
            $data['isEventMode'] ?? null,
            $blueZoneCustomOptions,
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}