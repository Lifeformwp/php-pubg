<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\Provider;

use Lifeformwp\PHPPUBG\DTO\Telemetry;

/**
 * Class TelemetryDTOProvider
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\Provider
 * @since 1.3.0
 */
class TelemetryDTOProvider implements ProviderInterface
{
    /**
     * @param array $telemetries
     *
     * @return Telemetry
     */
    public function process(array $telemetries): Telemetry
    {
        $result = [];

        foreach ($telemetries as $telemetry) {
            $class = "Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\\" . $telemetry["_T"];
            $result['events'][] = $class::createFromResponse($telemetry);
        }

        return Telemetry::createFromResponse($result);
    }
}