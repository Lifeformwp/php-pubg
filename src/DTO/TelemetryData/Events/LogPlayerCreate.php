<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogPlayerCreate
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.3.0
 */
class LogPlayerCreate
{
    /**
     * @var Character|null
     */
    public $character;
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
     * LogPlayerCreate constructor.
     *
     * @param Character|null          $character
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?Character $character,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->character = $character;
        $this->common    = $common;
        $this->date      = $date;
        $this->type      = $type;
    }

    /**
     * @param array $data
     *
     * @return LogPlayerCreate
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            Character::createFromResponse($data['character']),
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}