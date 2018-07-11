<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects;

/**
 * Class Character
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects
 * @since   1.3.0
 */
class Character
{
    /**
     * @var null|string
     */
    public $name;
    /**
     * @var int|null
     */
    public $teamId;
    /**
     * @var float|null
     */
    public $health;
    /**
     * @var Location|null
     */
    public $location;
    /**
     * @var int|null
     */
    public $ranking;
    /**
     * @var null|string
     */
    public $accountId;

    /**
     * Character constructor.
     *
     * @param null|string   $name
     * @param int|null      $teamId
     * @param float|null    $health
     * @param Location|null $location
     * @param int|null      $ranking
     * @param null|string   $accountId
     */
    public function __construct(
        ?string $name,
        ?int $teamId,
        ?float $health,
        ?Location $location,
        ?int $ranking,
        ?string $accountId
    ) {
        $this->name      = $name;
        $this->teamId    = $teamId;
        $this->health    = $health;
        $this->location  = $location;
        $this->ranking   = $ranking;
        $this->accountId = $accountId;
    }

    /**
     * @param array|null $data
     *
     * @return Character|null
     */
    public static function createFromResponse(?array $data): ?self
    {
        return $data === null ? $data : new self(
            $data['name'],
            $data['teamId'],
            $data['health'],
            Location::createFromResponse($data['location']),
            $data['ranking'],
            $data['accountId']
        );
    }
}