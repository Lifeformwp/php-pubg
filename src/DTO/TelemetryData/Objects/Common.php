<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects;

/**
 * Class Common
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects
 * @since   1.3.0
 */
class Common
{
    /**
     * @var float|null
     */
    public $isGame;

    /**
     * Common constructor.
     *
     * @param float|null $isGame
     */
    public function __construct(?float $isGame)
    {
        $this->isGame = $isGame;
    }

    /**
     * @param array $data
     *
     * @return Common
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['isGame']
        );
    }
}