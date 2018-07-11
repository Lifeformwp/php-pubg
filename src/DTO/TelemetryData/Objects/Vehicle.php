<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects;

/**
 * Class Vehicle
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects
 * @since   1.3.0
 */
class Vehicle
{
    /**
     * @var null|string
     */
    public $vehicleType;
    /**
     * @var null|string
     */
    public $vehicleId;
    /**
     * @var float|null
     */
    public $healthPercent;
    /**
     * @var float|null
     */
    public $fuelPercent;

    /**
     * Vehicle constructor.
     *
     * @param null|string $vehicleType
     * @param null|string $vehicleId
     * @param float|null  $healthPercent
     * @param float|null  $fuelPercent
     */
    public function __construct(
        ?string $vehicleType,
        ?string $vehicleId,
        ?float $healthPercent,
        ?float $fuelPercent
    ) {
        $this->vehicleType   = $vehicleType;
        $this->vehicleId     = $vehicleId;
        $this->healthPercent = $healthPercent;
        $this->fuelPercent   = $fuelPercent;
    }

    /**
     * @param array|null $data
     *
     * @return Vehicle|null
     */
    public static function createFromResponse(?array $data): ?self
    {
        return $data === null ? $data : new self(
            $data['vehicleType'],
            $data['vehicleId'],
            $data['healthPercent'],
            $data['feulPercent']
        );
    }
}