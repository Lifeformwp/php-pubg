<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogPlayerLogin
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since   1.3.0
 */
class LogPlayerLogin
{
    /**
     * @var null|string
     */
    public $accountId;
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
     * LogPlayerLogin constructor.
     *
     * @param null|string             $accountId
     * @param Common|null             $common
     * @param \DateTimeImmutable|null $date
     * @param null|string             $type
     */
    public function __construct(
        ?string $accountId,
        ?Common $common,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->accountId = $accountId;
        $this->common    = $common;
        $this->date      = $date;
        $this->type      = $type;
    }

    /**
     * @param array $data
     *
     * @return LogPlayerLogin
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['accountId'],
            Common::createFromResponse($data['common']),
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}