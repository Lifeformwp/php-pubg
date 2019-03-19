<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Item;

/**
 * Class LogItemPickupFromLootBox
 *
 * @author  Henrique Pulpor Muramoto <riquemuramoto@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.9.0
 */
class LogItemPickupFromLootBox
{
    /**
     * @var Character|null
     */
    public $character;
    /**
     * @var Item|null
     */
    public $item;
    /**
     * @var int|null
     */
    public $ownerTeamId;
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
     * LogItemPickupFromLootBox constructor.
     *
     * @param Character|null          $character
     * @param Item|null               $item
     * @param int|null                $ownerTeamId
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?Character $character,
        ?Item $item,
        ?int $ownerTeamId,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->character = $character;
        $this->item = $item;
        $this->ownerTeamId = $ownerTeamId;
        $this->common = $common;
        $this->date = $date;
        $this->type = $type;
    }

    /**
     * @param array $data
     *
     * @return LogItemPickupFromLootBox
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            Character::createFromResponse($data['character']),
            Item::createFromResponse($data['item']),
            $data['ownerTeamId'],
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}
