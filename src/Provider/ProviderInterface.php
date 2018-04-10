<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\Provider;

/**
 * Interface ProviderInterface
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\Provider
 * @since 1.1.0
 */
interface ProviderInterface
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    public function process(array $data);
}