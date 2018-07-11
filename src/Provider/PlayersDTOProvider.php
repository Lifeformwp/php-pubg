<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\Provider;

use Lifeformwp\PHPPUBG\DTO\Players;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Links\Links;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Meta\Meta;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Data;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\PlayerAttributes;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\PlayerLinks;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\PlayerRelationships;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Relationships\Assets;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Relationships\Match\MatchData;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Relationships\Matches;

/**
 * Class PlayersDTOProvider
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\Provider
 * @since   1.1.0
 */
class PlayersDTOProvider implements ProviderInterface
{
    /**
     * @param array $player
     *
     * @return Players
     */
    public function process(array $player): Players
    {
        $data = [];

        foreach ($player['data'] as $item) {
            $data[] = $this->processPlayerData($item);
        }

        $player = [
            'data'  => $data,
            'links' => $this->processPlayerLinks($player['links']),
            'meta'  => $this->processPlayerMeta($player['meta'])
        ];

        return Players::createFromResponse($player);
    }

    /**
     * @param array $data
     *
     * @return Data
     */
    private function processPlayerData(array $data): Data
    {
        $data['attributes']    = $this->processPlayerDataAttributes($data['attributes']);
        $data['relationships'] = $this->processPlayerDataRelationships($data['relationships']);
        $data['links']         = $this->processPlayerDataLinks($data['links']);

        return Data::createFromResponse($data);
    }

    /**
     * @param array $attributes
     *
     * @return PlayerAttributes
     */
    private function processPlayerDataAttributes(array $attributes): PlayerAttributes
    {
        return PlayerAttributes::createFromResponse($attributes);
    }

    /**
     * @param array $relationships
     *
     * @return PlayerRelationships
     */
    private function processPlayerDataRelationships(array $relationships): PlayerRelationships
    {
        $relationships['assets']  = $this->processPlayerDataRelationshipsAssets($relationships['assets']);
        $relationships['matches'] = $this->processPlayerDataRelationshipsMatches($relationships['matches']);

        return PlayerRelationships::createFromResponse($relationships);
    }

    /**
     * @param array $assets
     *
     * @return Assets
     */
    private function processPlayerDataRelationshipsAssets(array $assets): Assets
    {
        return new Assets();
    }

    /**
     * @param array $matches
     *
     * @return Matches
     */
    private function processPlayerDataRelationshipsMatches(array $matches): Matches
    {
        $data = [];

        foreach ($matches['data'] as $match) {
            $data['data'][] = $this->processPlayerDataRelationshipsMatchesObject($match);
        }

        return Matches::createFromResponse($data);
    }

    /**
     * @param array $match
     *
     * @return MatchData
     */
    private function processPlayerDataRelationshipsMatchesObject(array $match): MatchData
    {
        return MatchData::createFromResponse($match);
    }

    /**
     * @param array $links
     *
     * @return PlayerLinks
     */
    private function processPlayerDataLinks(array $links): PlayerLinks
    {
        return PlayerLinks::createFromResponse($links);
    }

    /**
     * @param array $links
     *
     * @return Links
     */
    private function processPlayerLinks(array $links): Links
    {
        return Links::createFromResponse($links);
    }

    /**
     * @param array $meta
     *
     * @return Meta
     */
    private function processPlayerMeta(array $meta): Meta
    {
        return new Meta();
    }
}