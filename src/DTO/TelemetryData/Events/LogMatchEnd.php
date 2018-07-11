<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogMatchEnd
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.3.0
 */
class LogMatchEnd
{
    /**
     * @var array|null
     */
    public $characters;
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
     * LogMatchEnd constructor.
     *
     * @param array|null              $characters
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?array $characters,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->characters = $characters;
        $this->common     = $common;
        $this->date       = $date;
        $this->type       = $type;
    }

    /**
     * @param array $data
     *
     * @return LogMatchEnd
     */
    public static function createFromResponse(array $data): self
    {
        $characters = [];

        foreach ($data['characters'] as $item) {
            $characters[] = Character::createFromResponse($item);
        }

        return new self(
            $characters,
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}