<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Vehicle;

/**
 * Class LogVehicleLeave
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.3.0
 */
class LogVehicleLeave
{
    /**
     * @var Character|null
     */
    public $character;
    /**
     * @var Vehicle|null
     */
    public $vehicle;
    /**
     * @var float|null
     */
    public $rideDistance;
    /**
     * @var int|null
     */
    public $seatIndex;
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
     * LogVehicleLeave constructor.
     *
     * @param Character|null          $character
     * @param Vehicle|null            $vehicle
     * @param float|null              $rideDistance
     * @param int|null                $seatIndex
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?Character $character,
        ?Vehicle $vehicle,
        ?float $rideDistance,
        ?int $seatIndex,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->character    = $character;
        $this->vehicle      = $vehicle;
        $this->rideDistance = $rideDistance;
        $this->seatIndex    = $seatIndex;
        $this->common       = $common;
        $this->date         = $date;
        $this->type         = $type;
    }

    /**
     * @param array $data
     *
     * @return LogVehicleLeave
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            Character::createFromResponse($data['character']),
            Vehicle::createFromResponse($data['vehicle']),
            $data['rideDistance'],
            $data['seatIndex'],
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}