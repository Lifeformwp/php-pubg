<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO\TelemetryData\Events;

use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;

/**
 * Class LogPlayerLogin
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO\TelemetryData\Events
 * @since 1.3.0
 */
class LogPlayerLogin
{
    /**
     * @var bool|null
     */
    public $result;
    /**
     * @var null|string
     */
    public $errorMessage;
    /**
     * @var null|string
     */
    public $accountId;
    /**
     * @var Common|null
     */
    public $common;
    /**
     * @var int|null
     */
    public $version;
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
     * @param bool|null $result
     * @param null|string $errorMessage
     * @param null|string $accountId
     * @param Common|null $common
     * @param int|null $version
     * @param \DateTimeImmutable|null $date
     * @param null|string $type
     */
    public function __construct(
        ?bool $result,
        ?string $errorMessage,
        ?string $accountId,
        ?Common $common,
        ?int $version,
        ?\DateTimeImmutable $date,
        ?string $type
    ) {
        $this->result = $result;
        $this->errorMessage = $errorMessage;
        $this->accountId = $accountId;
        $this->common = $common;
        $this->version = $version;
        $this->date = $date;
        $this->type = $type;
    }

    /**
     * @param array $data
     *
     * @return LogPlayerLogin
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['result'],
            $data['errorMessage'],
            $data['accountId'],
            Common::createFromResponse($data['common']),
            $data['_V'],
            new \DateTimeImmutable($data['_D']),
            $data['_T']
        );
    }
}