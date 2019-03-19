<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogVaultStart
 *
 * @author  Henrique Pulpor Muramoto <riquemuramoto@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.9.0
 */
class LogVaultStart
{
    /**
     * @var Character|null
     */
    public $character;
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

    public function __construct(
        ?Character $character,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->character = $character;
        $this->common = $common;
        $this->date = $date;
        $this->type = $type;
    }

    /**
     * @param array|null $data
     *
     * @return LogVaultStart
     */
    public static function createFromResponse(?array $data): self
    {
        return new self(
            Character::createFromResponse($data['character']),
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}
