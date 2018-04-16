<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\Provider;

use Lifeformwp\PHPPUBG\DTO\Status;
use Lifeformwp\PHPPUBG\DTO\StatusData\Status\Data;
use Lifeformwp\PHPPUBG\DTO\StatusData\Status\StatusAttributes;

/**
 * Class StatusDTOProvider
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\Provider
 * @since 1.2.0
 */
class StatusDTOProvider implements ProviderInterface
{
    /**
     * @param array $status
     *
     * @return Status
     */
    public function process(array $status): Status
    {
        $data['data'] = $this->processStatusData($status['data']);

        return Status::createFromResponse($data);
    }

    /**
     * @param array $data
     *
     * @return Data
     */
    private function processStatusData(array $data): Data
    {
        $data['attributes'] = $this->processStatusDataAttributes($data['attributes']);

        return Data::createFromResponse($data);
    }

    /**
     * @param array $attributes
     *
     * @return StatusAttributes
     */
    private function processStatusDataAttributes(array $attributes): StatusAttributes
    {
        return StatusAttributes::createFromResponse($attributes);
    }
}