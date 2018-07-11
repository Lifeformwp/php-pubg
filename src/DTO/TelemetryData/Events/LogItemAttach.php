<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Item;

/**
 * Class LogItemAttach
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.3.0
 */
class LogItemAttach
{
    /**
     * @var Character|null
     */
    public $character;
    /**
     * @var Item|null
     */
    public $parentItem;
    /**
     * @var Item|null
     */
    public $childItem;
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
     * LogItemAttach constructor.
     *
     * @param Character|null          $character
     * @param Item|null               $parentItem
     * @param Item|null               $childItem
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?Character $character,
        ?Item $parentItem,
        ?Item $childItem,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->character  = $character;
        $this->parentItem = $parentItem;
        $this->childItem  = $childItem;
        $this->common     = $common;
        $this->date       = $date;
        $this->type       = $type;
    }

    /**
     * @param array $data
     *
     * @return LogItemAttach
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            Character::createFromResponse($data['character']),
            Item::createFromResponse($data['parentItem']),
            Item::createFromResponse($data['childItem']),
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}