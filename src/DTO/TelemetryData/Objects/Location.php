<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects;

/**
 * Class Location
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects
 * @since   1.3.0
 */
class Location
{
    /**
     * @var float|null
     */
    public $posX;
    /**
     * @var float|null
     */
    public $posY;
    /**
     * @var float|null
     */
    public $posZ;

    /**
     * Location constructor.
     *
     * @param float|null $posX
     * @param float|null $posY
     * @param float|null $posZ
     */
    public function __construct(
        ?float $posX,
        ?float $posY,
        ?float $posZ
    ) {
        $this->posX = $posX;
        $this->posY = $posY;
        $this->posZ = $posZ;
    }

    /**
     * @param array $data
     *
     * @return Location
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['x'],
            $data['y'],
            $data['z']
        );
    }
}