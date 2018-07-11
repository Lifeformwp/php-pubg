<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO;

use Lifeformwp\PHPPUBG\DTO\StatusData\Status\Data;

/**
 * Class Status
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO
 * @since   1.2.0
 */
class Status implements DTOInterface
{
    /**
     * @var Data|null
     */
    public $data;

    /**
     * Status constructor.
     *
     * @param Data|null $data
     */
    public function __construct(?Data $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     *
     * @return Status
     */
    public static function createFromResponse(array $data): self
    {
        return new self(
            $data['data']
        );
    }
}