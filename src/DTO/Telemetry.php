<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO;

/**
 * Class Telemetry
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO
 * @since   1.3.0
 */
class Telemetry implements DTOInterface
{
    /**
     * @var array|null
     */
    public $events;

    /**
     * Telemetry constructor.
     *
     * @param array|null $events
     */
    public function __construct(?array $events)
    {
        $this->events = $events;
    }

    /**
     * @param array $data
     *
     * @return Telemetry
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['events']
        );
    }
}