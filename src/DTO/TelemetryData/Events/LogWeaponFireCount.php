<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogWeaponFireCount
 *
 * @author  Henrique Pulpor Muramoto <riquemuramoto@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.9.0
 */
class LogWeaponFireCount
{
    /**
     * @var Character|null
     */
    public $character;
    /**
     * @var string|null
     */
    public $weaponId;
    /**
     * @var int|null
     */
    public $fireCount;
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
        ?string $weaponId,
        ?int $fireCount,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->character = $character;
        $this->weaponId = $weaponId;
        $this->fireCount = $fireCount;
        $this->common = $common;
        $this->date = $date;
        $this->type = $type;
    }

    /**
     * @param array|null $data
     *
     * @return LogWeaponFireCount
     */
    public static function createFromResponse(?array $data): self
    {
        return new self(
            Character::createFromResponse($data['character']),
            $data['weaponId'],
            $data['fireCount'],
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}
