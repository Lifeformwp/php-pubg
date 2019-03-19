<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogRedZoneEnded
 *
 * @author  Henrique Pulpor Muramoto <riquemuramoto@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.9.0
 */
class LogRedZoneEnded
{
    /**
     * @var array|null
     */
    public $drivers;
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
     * LogRedZoneEnded constructor.
     *
     * @param array|null              $drivers
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?array $drivers,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->drivers = $drivers;
        $this->common = $common;
        $this->date = $date;
        $this->type = $type;
    }

    /**
     * @param array $data
     *
     * @return LogRedZoneEnded
     */
    public static function createFromResponse(array $data): self
    {
        $drivers = [];

        foreach ($data['drivers'] as $item) {
            $drivers[] = Character::createFromResponse($item);
        }

        return new self(
            $drivers,
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}
