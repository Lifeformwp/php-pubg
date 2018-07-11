<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

/**
 * Class LogMatchDefinition
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.3.0
 */
class LogMatchDefinition
{
    /**
     * @var null|string
     */
    public $matchId;
    /**
     * @var null|string
     */
    public $pingQuality;
    /**
     * @var \DateTimeImmutable|null
     */
    public $date;
    /**
     * @var null|string
     */
    public $type;

    /**
     * LogMatchDefinition constructor.
     *
     * @param null|string             $matchId
     * @param null|string             $pingQuality
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?string $matchId,
        ?string $pingQuality,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->matchId     = $matchId;
        $this->pingQuality = $pingQuality;
        $this->date        = $date;
        $this->type        = $type;
    }

    /**
     * @param array $data
     *
     * @return LogMatchDefinition
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['MatchId'],
            $data['PingQuality'],
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}