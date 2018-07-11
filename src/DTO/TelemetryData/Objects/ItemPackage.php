<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects;

/**
 * Class ItemPackage
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects
 * @since   1.3.0
 */
class ItemPackage
{
    /**
     * @var null|string
     */
    public $itemPackageId;
    /**
     * @var Location|null
     */
    public $location;
    /**
     * @var array|null
     */
    public $items;

    /**
     * ItemPackage constructor.
     *
     * @param null|string   $itemPackageId
     * @param Location|null $location
     * @param array|null    $items
     */
    public function __construct(
        ?string $itemPackageId,
        ?Location $location,
        ?array $items
    ) {
        $this->itemPackageId = $itemPackageId;
        $this->location      = $location;
        $this->items         = $items;
    }

    /**
     * @param array $data
     *
     * @return ItemPackage
     */
    public static function createFromResponse(array $data): self
    {
        $items = [];

        foreach ($data['items'] as $item) {
            $items[] = Item::createFromResponse($item);
        }

        return new self(
            $data['itemPackageId'],
            Location::createFromResponse($data['location']),
            $items
        );
    }
}