<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\Provider;

use Lifeformwp\PHPPUBG\DTO\Samples;
use Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\Data;
use Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\Relationships\Matches;
use Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\Relationships\Type\MatchType;
use Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\SampleAttributes;
use Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\SampleRelationships;

/**
 * Class SamplesDTOProvider
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\Provider
 * @since   1.3.0
 */
class SamplesDTOProvider implements ProviderInterface
{
    /**
     * @param array $samples
     *
     * @return Samples
     */
    public function process(array $samples): Samples
    {
        $data = [
            'data' => $this->processSampleData($samples['data'])
        ];

        return Samples::createFromResponse($data);
    }

    /**
     * @param array $sampleData
     *
     * @return Data
     */
    private function processSampleData(array $sampleData): Data
    {
        $sampleData = [
            'type'          => $sampleData['type'],
            'id'            => $sampleData['id'],
            'attributes'    => $this->processSampleDataAttributes($sampleData['attributes']),
            'relationships' => $this->processSampleDataRelationships($sampleData['relationships'])
        ];

        return Data::createFromResponse($sampleData);
    }

    /**
     * @param array $attributes
     *
     * @return SampleAttributes
     */
    private function processSampleDataAttributes(array $attributes): SampleAttributes
    {
        return SampleAttributes::createFromResponse($attributes);
    }

    /**
     * @param array $relationships
     *
     * @return SampleRelationships
     */
    private function processSampleDataRelationships(array $relationships): SampleRelationships
    {
        $data = [
            'matches' => $this->processSampleDataRelationshipsMatches($relationships['matches'])
        ];

        return SampleRelationships::createFromResponse($data);
    }

    /**
     * @param array $matches
     *
     * @return Matches
     */
    private function processSampleDataRelationshipsMatches(array $matches): Matches
    {
        $data = [];

        foreach ($matches['data'] as $match) {
            $data['data'][] = $this->processSampleDataRelationshipsMatchesObject($match);

        }

        return Matches::createFromResponse($data);
    }

    /**
     * @param array $match
     *
     * @return MatchType
     */
    private function processSampleDataRelationshipsMatchesObject(array $match): MatchType
    {
        return MatchType::createFromResponse($match);
    }
}