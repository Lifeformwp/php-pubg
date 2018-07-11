<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\ItemPackage;

/**
 * Class LogCarePackageLand
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.3.0
 */
class LogCarePackageLand
{
    /**
     * @var ItemPackage|null
     */
    public $itemPackage;
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
     * LogCarePackageLand constructor.
     *
     * @param ItemPackage|null        $itemPackage
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?ItemPackage $itemPackage,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->itemPackage = $itemPackage;
        $this->common      = $common;
        $this->date        = $date;
        $this->type        = $type;
    }

    /**
     * @param array $data
     *
     * @return LogCarePackageLand
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            ItemPackage::createFromResponse($data['itemPackage']),
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}