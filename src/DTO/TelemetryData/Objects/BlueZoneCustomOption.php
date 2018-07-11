<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects;

/**
 * Class BlueZoneCustomOption
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects
 * @since   1.4.0
 */
class BlueZoneCustomOption
{
    /**
     * @var int|null
     */
    public $phaseNum;
    /**
     * @var int|null
     */
    public $startDelay;
    /**
     * @var int|null
     */
    public $warningDuration;
    /**
     * @var int|null
     */
    public $releaseDuration;
    /**
     * @var float|null
     */
    public $poisonGasDamagePerSecond;
    /**
     * @var float|null
     */
    public $radiusRate;
    /**
     * @var float|null
     */
    public $spreadRatio;
    /**
     * @var float|null
     */
    public $landRatio;
    /**
     * @var int|null
     */
    public $circleAlgorithm;

    /**
     * BlueZoneCustomOption constructor.
     *
     * @param int|null   $phaseNum
     * @param int|null   $startDelay
     * @param int|null   $warningDuration
     * @param int|null   $releaseDuration
     * @param float|null $poisonGasDamagePerSecond
     * @param float|null $radiusRate
     * @param float|null $spreadRatio
     * @param float|null $landRatio
     * @param int|null   $circleAlgorithm
     */
    public function __construct(
        ?int $phaseNum,
        ?int $startDelay,
        ?int $warningDuration,
        ?int $releaseDuration,
        ?float $poisonGasDamagePerSecond,
        ?float $radiusRate,
        ?float $spreadRatio,
        ?float $landRatio,
        ?int $circleAlgorithm
    ) {
        $this->phaseNum                 = $phaseNum;
        $this->startDelay               = $startDelay;
        $this->warningDuration          = $warningDuration;
        $this->releaseDuration          = $releaseDuration;
        $this->poisonGasDamagePerSecond = $poisonGasDamagePerSecond;
        $this->radiusRate               = $radiusRate;
        $this->spreadRatio              = $spreadRatio;
        $this->landRatio                = $landRatio;
        $this->circleAlgorithm          = $circleAlgorithm;
    }

    /**
     * @param array|null $data
     *
     * @return BlueZoneCustomOption
     */
    public static function createFromResponse(?array $data): self
    {
        return new self(
            $data['phaseNum'],
            $data['startDelay'],
            $data['warningDuration'],
            $data['releaseDuration'],
            $data['poisonGasDamagePerSecond'],
            $data['radiusRate'],
            $data['spreadRatio'],
            $data['landRatio'],
            $data['circleAlgorithm']
        );
    }
}