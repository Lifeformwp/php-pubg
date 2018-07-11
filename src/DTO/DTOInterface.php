<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\DTO;

/**
 * Interface DTOInterface
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\DTO
 * @since   1.1.0
 */
interface DTOInterface
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    public static function createFromResponse(array $data);
}