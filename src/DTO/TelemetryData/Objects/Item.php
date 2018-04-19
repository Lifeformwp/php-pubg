<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects;

/**
 * Class Item
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects
 * @since 1.3.0
 */
class Item
{
    /**
     * @var null|string
     */
    public $itemId;
    /**
     * @var int|null
     */
    public $stackCount;
    /**
     * @var null|string
     */
    public $category;
    /**
     * @var null|string
     */
    public $subCategory;
    /**
     * @var array|null
     */
    public $attachedItems;

    /**
     * Item constructor.
     *
     * @param null|string $itemId
     * @param int|null $stackCount
     * @param null|string $category
     * @param null|string $subCategory
     * @param array|null $attachedItems
     */
    public function __construct(
        ?string $itemId,
        ?int $stackCount,
        ?string $category,
        ?string $subCategory,
        ?array $attachedItems
    ) {
        $this->itemId = $itemId;
        $this->stackCount = $stackCount;
        $this->category = $category;
        $this->subCategory = $subCategory;
        $this->attachedItems = $attachedItems;
    }

    /**
     * @param array $data
     *
     * @return Item
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['itemId'],
            $data['stackCount'],
            $data['category'],
            $data['subCategory'],
            $data['attachedItems']
        );
    }
}