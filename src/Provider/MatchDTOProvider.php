<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\Provider;

use Lifeformwp\PHPPUBG\DTO\Match;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Asset\AssetAttributes;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Included;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\IncludedAsset;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Participant;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Participant\IncludedParticipantAttributes;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Participant\ParticipantStats;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\IncludedRosterAttributes;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\IncludedRelationships;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\Attributes\RosterStats;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\Relationships\Participants;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\Relationships\Team;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster\Relationships\Type\ParticipantType;
use Lifeformwp\PHPPUBG\DTO\MatchData\Links\Links;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\MatchAttributes;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Data;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\MatchRelationships;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Assets;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Type\AssetType;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Rosters;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Rounds;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Spectators;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Type\RosterType;
use Lifeformwp\PHPPUBG\DTO\MatchData\Meta\Meta;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\MatchLinks;

/**
 * Class MatchDTOProvider
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\Provider
 * @since 1.1.0
 */
class MatchDTOProvider implements ProviderInterface
{
    /**
     * @param array $match
     *
     * @return Match
     */
    public function process(array $match): Match
    {
        $data = [
            'data' => $this->processMatchData($match['data']),
            'included' => $this->processMatchIncluded($match['included']),
            'links' => $this->processMatchLinks($match['links']),
            'meta' => $this->processMatchMeta()
        ];

        return Match::createFromResponse($data);
    }

    /**
     * @param array $matchData
     *
     * @return Data
     */
    private function processMatchData(array $matchData): Data
    {
        $matchData = [
            'type' => $matchData['type'],
            'id' => $matchData['id'],
            'attributes' => $this->processMatchDataAttributes($matchData['attributes']),
            'relationships' => $this->processMatchDataRelationships($matchData['relationships']),
            'links' => $this->processMatchDataLinks($matchData['links'])
        ];

        return Data::createFromResponse($matchData);
    }

    /**
     * @param array $attributes
     *
     * @return MatchAttributes
     */
    private function processMatchDataAttributes(array $attributes): MatchAttributes
    {
        return MatchAttributes::createFromResponse($attributes);
    }

    /**
     * @param array $relationships
     *
     * @return MatchRelationships
     */
    private function processMatchDataRelationships(array $relationships): MatchRelationships
    {
        $data = [
            'assets' => $this->processMatchDataRelationshipsAssets($relationships['assets']),
            'rosters' => $this->processMatchDataRelationshipsRosters($relationships['rosters']),
            'rounds' => $this->processMatchDataRelationshipsRounds(),
            'spectators' => $this->processMatchDataRelationshipsSpectators()
        ];

        return MatchRelationships::createFromResponse($data);
    }

    /**
     * @param array $assets
     *
     * @return Assets
     */
    private function processMatchDataRelationshipsAssets(array $assets): Assets
    {
        $data = [];

        foreach ($assets['data'] as $asset) {
            $data['data'][] = $this->processMatchDataRelationshipsAssetsObject($asset);

        }

        return Assets::createFromResponse($data);
    }

    /**
     * @param array $asset
     *
     * @return AssetType
     */
    private function processMatchDataRelationshipsAssetsObject(array $asset): AssetType
    {
        return AssetType::createFromResponse($asset);
    }

    /**
     * @param array $rosters
     *
     * @return Rosters
     */
    private function processMatchDataRelationshipsRosters(array $rosters): Rosters
    {
        $data = [];

        foreach ($rosters['data'] as $roster) {
            $data['data'][] = $this->processMatchDataRelationshipsRostersObject($roster);
        }

        return Rosters::createFromResponse($data);
    }

    /**
     * @param array $roster
     *
     * @return RosterType
     */
    private function processMatchDataRelationshipsRostersObject(array $roster): RosterType
    {
        return RosterType::createFromResponse($roster);
    }

    /**
     * @return Rounds
     */
    private function processMatchDataRelationshipsRounds(): Rounds
    {
        return new Rounds();
    }

    /**
     * @return Spectators
     */
    private function processMatchDataRelationshipsSpectators(): Spectators
    {
        return new Spectators();
    }

    /**
     * @param array $links
     *
     * @return MatchLinks
     */
    private function processMatchDataLinks(array $links): MatchLinks
    {
        return MatchLinks::createFromResponse($links);
    }

    /**
     * @param array $included
     *
     * @return Included
     */
    private function processMatchIncluded(array $included): Included
    {
        $data = [];

        foreach ($included as $item) {
            switch ($item['type']) {
                case 'participant':
                    $data['participants'][] = $this->processMatchIncludedParticipant($item);
                    break;
                case 'roster':
                    $data['rosters'][] = $this->processMatchIncludedRoster($item);
                    break;
                case 'asset':
                    $data['asset'] = $this->processMatchIncludedAsset($item);
                    break;
            }
        }

        return Included::createFromResponse($data);
    }

    /**
     * @param array $roster
     *
     * @return Roster
     */
    private function processMatchIncludedRoster(array $roster): Roster
    {
        $data = [
            'type' => $roster['type'],
            'id' => $roster['id'],
            'attributes' => $this->processMatchIncludedRosterAttributes($roster['attributes']),
            'relationships' => $this->processMatchIncludedRosterRelationships($roster['relationships'])
        ];

        return Roster::createFromResponse($data);
    }

    /**
     * @param array $attributes
     *
     * @return IncludedRosterAttributes
     */
    private function processMatchIncludedRosterAttributes(array $attributes): IncludedRosterAttributes
    {
        $attributes = [
            'shardId' => $attributes['shardId'],
            'stats' => $this->processMatchIncludedRosterAttributesStats($attributes['stats']),
            'won' => $attributes['won']
        ];

        return IncludedRosterAttributes::createFromResponse($attributes);
    }

    /**
     * @param array $stats
     *
     * @return RosterStats
     */
    private function processMatchIncludedRosterAttributesStats(array $stats): RosterStats
    {
        return RosterStats::createFromResponse($stats);
    }

    /**
     * @param array $relationships
     *
     * @return IncludedRelationships
     */
    private function processMatchIncludedRosterRelationships(array $relationships): IncludedRelationships
    {
        $relationships = [
            'participants' => $this->processMatchIncludedRosterRelationshipsParticipants($relationships['participants']),
            'team' => $this->processMatchIncludedRosterRelationshipsTeam()
        ];

        return IncludedRelationships::createFromResponse($relationships);
    }

    /**
     * @param array $participants
     *
     * @return Participants
     */
    private function processMatchIncludedRosterRelationshipsParticipants(array $participants): Participants
    {
        $data = [];

        foreach ($participants['data'] as $participant) {
            $data['data'][] = $this->processMatchIncludedRosterRelationshipsParticipantsObject($participant);
        }

        return Participants::createFromResponse($data);
    }

    /**
     * @param array $participant
     *
     * @return ParticipantType
     */
    private function processMatchIncludedRosterRelationshipsParticipantsObject(array $participant): ParticipantType
    {
        return ParticipantType::createFromResponse($participant);
    }

    /**
     * @return Team
     */
    private function processMatchIncludedRosterRelationshipsTeam(): Team
    {
        return new Team();
    }

    /**
     * @param array $participant
     *
     * @return Participant
     */
    private function processMatchIncludedParticipant(array $participant): Participant
    {
        $data = [
            'type' => $participant['type'],
            'id' => $participant['id'],
            'attributes' => $this->processMatchIncludedParticipantAttributes($participant['attributes'])
        ];

        return Participant::createFromResponse($data);

    }

    /**
     * @param array $attributes
     *
     * @return IncludedParticipantAttributes
     */
    private function processMatchIncludedParticipantAttributes(array $attributes): IncludedParticipantAttributes
    {
        $data = [
            'actor' => $attributes['actor'],
            'shardId' => $attributes['shardId'],
            'stats' => $this->processMatchIncludedParticipantAttributesStats($attributes['stats'])
        ];

        return IncludedParticipantAttributes::createFromResponse($data);
    }

    /**
     * @param array $stats
     *
     * @return ParticipantStats
     */
    private function processMatchIncludedParticipantAttributesStats(array $stats): ParticipantStats
    {
        return ParticipantStats::createFromResponse($stats);
    }

    /**
     * @param array $asset
     *
     * @return IncludedAsset
     */
    private function processMatchIncludedAsset(array $asset): IncludedAsset
    {
        $data = [
            'type' => $asset['type'],
            'id' => $asset['id'],
            'attributes' => $this->processMatchIncludedAssetAttributes($asset['attributes'])
        ];

        return IncludedAsset::createFromResponse($data);
    }

    /**
     * @param array $attributes
     *
     * @return AssetAttributes
     */
    private function processMatchIncludedAssetAttributes(array $attributes): AssetAttributes
    {
        return AssetAttributes::createFromResponse($attributes);
    }

    /**
     * @param array $links
     *
     * @return Links
     */
    private function processMatchLinks(array $links): Links
    {
        return Links::createFromResponse($links);
    }

    /**
     * @return Meta
     */
    private function processMatchMeta(): Meta
    {
        return new Meta();
    }
}