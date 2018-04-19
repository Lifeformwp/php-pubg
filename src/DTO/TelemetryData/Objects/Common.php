<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects;

/**
 * Class Common
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects
 * @since 1.3.0
 */
class Common
{
    /**
     * @var null|string
     */
    public $matchId;
    /**
     * @var null|string
     */
    public $mapName;
    /**
     * @var float|null
     */
    public $isGame;

    /**
     * Common constructor.
     *
     * @param null|string $matchId
     * @param null|string $mapName
     * @param float|null $isGame
     */
    public function __construct(
        ?string $matchId,
        ?string $mapName,
        ?float $isGame
    ) {
        $this->matchId = $matchId;
        $this->mapName = $mapName;
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
            $data['matchId'],
            $data['mapName'],
            $data['isGame']
        );
    }
}