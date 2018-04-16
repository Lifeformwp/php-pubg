<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Lifeformwp\PHPPUBG\DTO\Match;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Asset\AssetAttributes;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Included;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\IncludedAsset;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Participant;
use Lifeformwp\PHPPUBG\DTO\MatchData\Included\Roster;
use Lifeformwp\PHPPUBG\DTO\MatchData\Links\Links;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Data;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\MatchAttributes;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\MatchLinks;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\MatchRelationships;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Assets;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Rosters;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Rounds;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Spectators;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Type\AssetType;
use Lifeformwp\PHPPUBG\DTO\MatchData\Match\Relationships\Type\RosterType;
use Lifeformwp\PHPPUBG\DTO\MatchData\Meta\Meta;
use Lifeformwp\PHPPUBG\DTO\Player;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\PlayerAttributes;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\PlayerLinks;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\PlayerRelationships;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Relationships\Match\MatchData;
use Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Relationships\Matches;
use Lifeformwp\PHPPUBG\DTO\Players;
use Lifeformwp\PHPPUBG\DTO\Status;
use Lifeformwp\PHPPUBG\DTO\StatusData\Status\StatusAttributes;
use Lifeformwp\PHPPUBG\PUBGManager;
use PHPUnit\Framework\TestCase;

/**
 * Class PUBGManagerTest
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\Tests
 * @since 1.0.0
 */
class PUBGManagerTest extends TestCase
{
    public function testGetMatchArray(): void
    {
        $token = 'token';
        $data = $this->getTestData('tests/match.json');

        $client = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $match = $manager->getMatch('pc-eu', 'abe08f7e-3add-4fd6-9bcd-4aff88fc7adf');
        $this->assertEquals($this->jsonDecodeToArray($data), $match);
    }

    public function testGetPlayersArray(): void
    {
        $token = 'token';
        $data = $this->getTestData('tests/players.json');

        $client = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $match = $manager->getPlayers('pc-eu', ['Lifeformwp', 'MrEddyGordo']);
        $this->assertEquals($this->jsonDecodeToArray($data), $match);
    }

    public function testGetTelemetryArray(): void
    {
        $token = 'token';
        $data = $this->getTestData('tests/telemetry.json');

        $client = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $match = $manager->getTelemetry('link');
        $this->assertEquals($this->jsonDecodeToArray($data), $match);
    }

    public function testGetStatus(): void
    {
        $token = 'token';
        $data = $this->getTestData('tests/status.json');

        $client = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $match = $manager->getStatus();
        $this->assertEquals($this->jsonDecodeToArray($data), $match);
    }

    public function testGetMatchDTO(): void
    {
        $token = 'token';
        $data = $this->getTestData('tests/match.json');

        $client = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $match = $manager->getMatch('pc-eu', 'abe08f7e-3add-4fd6-9bcd-4aff88fc7adf');
        $obj = $manager->hydrate($match, PUBGManager::HYDRATE_MATCH);
        $this->assertMatchObject($obj, $this->jsonDecodeToArray($data));
    }

    public function testGetPlayersDTO(): void
    {
        $token = 'token';
        $data = $this->getTestData('tests/players.json');

        $client = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $players = $manager->getPlayers('pc-eu', ['Lifeformwp', 'MrEddyGordo']);
        $obj = $manager->hydrate($players, PUBGManager::HYDRATE_PLAYERS);
        $this->assertPlayersObject($obj, $this->jsonDecodeToArray($data));
    }

    public function testGetPlayerDTO(): void
    {
        $token = 'token';
        $data = $this->getTestData('tests/player.json');

        $client = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $player = $manager->getPlayer('pc-eu', 'account.b3982540418d421f8cbf72705e49b1ad');
        $obj = $manager->hydrate($player, PUBGManager::HYDRATE_PLAYER);
        $this->assertPlayerObject($obj, $this->jsonDecodeToArray($data));
    }

    public function testGetStatusDTO(): void
    {
        $token = 'token';
        $data = $this->getTestData('tests/status.json');

        $client = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $status = $manager->getStatus();
        $obj = $manager->hydrate($status, PUBGManager::HYDRATE_STATUS);
        $this->assertStatusObject($obj, $this->jsonDecodeToArray($data));
    }

    /**
     * @param Match $match
     * @param array $data
     *
     * @since 1.2.0
     */
    private function assertMatchObject(Match $match, array $data): void
    {
        $this->assertInstanceOf(Data::class, $match->data);
        $this->assertInstanceOf(Included::class, $match->included);
        $this->assertInstanceOf(Links::class, $match->links);
        $this->assertInstanceOf(Meta::class, $match->meta);

        $matchData = $match->data;
        $this->assertEquals($data['data']['type'], $matchData->type);
        $this->assertEquals($data['data']['id'], $matchData->id);
        $this->assertInstanceOf(MatchAttributes::class, $matchData->attributes);
        $this->assertInstanceOf(MatchRelationships::class, $matchData->relationships);
        $this->assertInstanceOf(MatchLinks::class, $matchData->links);

        $matchDataAttributes = $matchData->attributes;
        $this->assertInstanceOf(\DateTimeImmutable::class, $matchDataAttributes->createdAt);
        $this->assertEquals($data['data']['attributes']['duration'], $matchDataAttributes->duration);
        $this->assertEquals($data['data']['attributes']['gameMode'], $matchDataAttributes->gameMode);
        $this->assertEquals($data['data']['attributes']['mapName'], $matchDataAttributes->mapName);
        $this->assertEquals($data['data']['attributes']['patchVersion'], $matchDataAttributes->patchVersion);
        $this->assertEquals($data['data']['attributes']['shardId'], $matchDataAttributes->shardId);
        $this->assertEquals($data['data']['attributes']['stats'], $matchDataAttributes->stats);
        $this->assertEquals($data['data']['attributes']['tags'], $matchDataAttributes->tags);
        $this->assertEquals($data['data']['attributes']['titleId'], $matchDataAttributes->titleId);

        $matchDataRelationships = $matchData->relationships;
        $this->assertInstanceOf(Assets::class, $matchDataRelationships->assets);
        $this->assertInstanceOf(Rosters::class, $matchDataRelationships->rosters);
        $this->assertInstanceOf(Rounds::class, $matchDataRelationships->rounds);
        $this->assertInstanceOf(Spectators::class, $matchDataRelationships->spectators);

        $asset = $matchDataRelationships->assets->data[0];
        $this->assertInstanceOf(Assets::class, $matchDataRelationships->assets);
        $this->assertInstanceOf(AssetType::class, $asset);
        $this->assertEquals($data['data']['relationships']['assets']['data'][0]['type'], $asset->type);
        $this->assertEquals($data['data']['relationships']['assets']['data'][0]['id'], $asset->id);

        $roster = $matchDataRelationships->rosters->data[0];
        $this->assertInstanceOf(Rosters::class, $matchDataRelationships->rosters);
        $this->assertInstanceOf(RosterType::class, $roster);
        $this->assertEquals($data['data']['relationships']['rosters']['data'][0]['type'], $roster->type);
        $this->assertEquals($data['data']['relationships']['rosters']['data'][0]['id'], $roster->id);

        $this->assertInstanceOf(Rounds::class, $matchDataRelationships->rounds);
        $this->assertInstanceOf(Spectators::class, $matchDataRelationships->spectators);

        $matchDataLinks = $matchData->links;
        $this->assertEquals($data['data']['links']['schema'], $matchDataLinks->schema);
        $this->assertEquals($data['data']['links']['self'], $matchDataLinks->self);

        $matchIncluded = $match->included;
        $matchIncludedRoster = $matchIncluded->rosters[0];
        $this->assertInstanceOf(Roster::class, $matchIncludedRoster);
        $this->assertEquals($data['included'][2]['type'], $matchIncludedRoster->type);
        $this->assertEquals($data['included'][2]['id'], $matchIncludedRoster->id);
        $this->assertInstanceOf(Roster\IncludedRosterAttributes::class, $matchIncludedRoster->attributes);
        $this->assertInstanceOf(Roster\IncludedRelationships::class, $matchIncludedRoster->relationships);

        $matchIncludedRosterAttributes = $matchIncludedRoster->attributes;
        $this->assertEquals($data['included'][2]['attributes']['shardId'], $matchIncludedRosterAttributes->shardId);
        $this->assertInstanceOf(Roster\Attributes\RosterStats::class, $matchIncludedRosterAttributes->stats);
        $this->assertEquals($data['included'][2]['attributes']['won'], $matchIncludedRosterAttributes->won);

        $matchIncludedRosterAttributesStats = $matchIncludedRosterAttributes->stats;
        $this->assertEquals($data['included'][2]['attributes']['stats']['rank'], $matchIncludedRosterAttributesStats->rank);
        $this->assertEquals($data['included'][2]['attributes']['stats']['teamId'], $matchIncludedRosterAttributesStats->teamId);

        $matchIncludedRosterRelationships = $matchIncludedRoster->relationships;
        $this->assertInstanceOf(Roster\Relationships\Participants::class, $matchIncludedRosterRelationships->participants);
        $this->assertInstanceOf(Roster\Relationships\Team::class, $matchIncludedRosterRelationships->team);

        $matchIncludedRosterRelationshipsParticipant = $matchIncludedRosterRelationships->participants->data[0];
        $this->assertEquals($data['included'][2]['relationships']['participants']['data'][0]['type'], $matchIncludedRosterRelationshipsParticipant->type);
        $this->assertEquals($data['included'][2]['relationships']['participants']['data'][0]['id'], $matchIncludedRosterRelationshipsParticipant->id);

        $matchIncludedParticipant = $matchIncluded->participants[0];
        $this->assertInstanceOf(Participant::class, $matchIncludedParticipant);
        $this->assertEquals($data['included'][0]['type'], $matchIncludedParticipant->type);
        $this->assertEquals($data['included'][0]['id'], $matchIncludedParticipant->id);
        $this->assertInstanceOf(Participant\IncludedParticipantAttributes::class, $matchIncludedParticipant->attributes);

        $matchIncludedParticipantAttributes = $matchIncludedParticipant->attributes;
        $this->assertEquals($data['included'][0]['attributes']['actor'], $matchIncludedParticipantAttributes->actor);
        $this->assertEquals($data['included'][0]['attributes']['shardId'], $matchIncludedParticipantAttributes->shardId);
        $this->assertInstanceOf(Participant\ParticipantStats::class, $matchIncludedParticipantAttributes->stats);

        $matchIncludedParticipantAttributesStats = $matchIncludedParticipantAttributes->stats;
        $stats = $data['included'][0]['attributes']['stats'];
        $this->assertEquals($stats['DBNOs'], $matchIncludedParticipantAttributesStats->DBNOs);
        $this->assertEquals($stats['assists'], $matchIncludedParticipantAttributesStats->assists);
        $this->assertEquals($stats['boosts'], $matchIncludedParticipantAttributesStats->boosts);
        $this->assertEquals($stats['damageDealt'], $matchIncludedParticipantAttributesStats->damageDealt);
        $this->assertEquals($stats['deathType'], $matchIncludedParticipantAttributesStats->deathType);
        $this->assertEquals($stats['headshotKills'], $matchIncludedParticipantAttributesStats->headshotKills);
        $this->assertEquals($stats['heals'], $matchIncludedParticipantAttributesStats->heals);
        $this->assertEquals($stats['killPlace'], $matchIncludedParticipantAttributesStats->killPlace);
        $this->assertEquals($stats['killPoints'], $matchIncludedParticipantAttributesStats->killPoints);
        $this->assertEquals($stats['killPointsDelta'], $matchIncludedParticipantAttributesStats->killPointsDelta);
        $this->assertEquals($stats['killStreaks'], $matchIncludedParticipantAttributesStats->killStreaks);
        $this->assertEquals($stats['kills'], $matchIncludedParticipantAttributesStats->kills);
        $this->assertEquals($stats['lastKillPoints'], $matchIncludedParticipantAttributesStats->lastKillPoints);
        $this->assertEquals($stats['lastWinPoints'], $matchIncludedParticipantAttributesStats->lastWinPoints);
        $this->assertEquals($stats['longestKill'], $matchIncludedParticipantAttributesStats->longestKill);
        $this->assertEquals($stats['mostDamage'], $matchIncludedParticipantAttributesStats->mostDamage);
        $this->assertEquals($stats['name'], $matchIncludedParticipantAttributesStats->name);
        $this->assertEquals($stats['playerId'], $matchIncludedParticipantAttributesStats->playerId);
        $this->assertEquals($stats['revives'], $matchIncludedParticipantAttributesStats->revives);
        $this->assertEquals($stats['rideDistance'], $matchIncludedParticipantAttributesStats->rideDistance);
        $this->assertEquals($stats['roadKills'], $matchIncludedParticipantAttributesStats->roadKills);
        $this->assertEquals($stats['teamKills'], $matchIncludedParticipantAttributesStats->teamKills);
        $this->assertEquals($stats['timeSurvived'], $matchIncludedParticipantAttributesStats->timeSurvived);
        $this->assertEquals($stats['vehicleDestroys'], $matchIncludedParticipantAttributesStats->vehicleDestroys);
        $this->assertEquals($stats['walkDistance'], $matchIncludedParticipantAttributesStats->walkDistance);
        $this->assertEquals($stats['weaponsAcquired'], $matchIncludedParticipantAttributesStats->weaponsAcquired);
        $this->assertEquals($stats['winPlace'], $matchIncludedParticipantAttributesStats->winPlace);
        $this->assertEquals($stats['winPoints'], $matchIncludedParticipantAttributesStats->winPoints);
        $this->assertEquals($stats['winPointsDelta'], $matchIncludedParticipantAttributesStats->winPointsDelta);

        $matchIncludedAsset = $matchIncluded->asset;
        $this->assertInstanceOf(IncludedAsset::class, $matchIncludedAsset);
        $this->assertEquals($data['included'][1]['type'], $matchIncludedAsset->type);
        $this->assertEquals($data['included'][1]['id'], $matchIncludedAsset->id);

        $matchIncludedAssetAttributes = $matchIncludedAsset->attributes;
        $assetAttributes = $data['included'][1]['attributes'];
        $this->assertInstanceOf(AssetAttributes::class, $matchIncludedAssetAttributes);
        $this->assertEquals($assetAttributes['URL'], $matchIncludedAssetAttributes->URL);
        $this->assertInstanceOf(\DateTimeImmutable::class, $matchIncludedAssetAttributes->createdAt);
        $this->assertEquals($assetAttributes['description'], $matchIncludedAssetAttributes->description);
        $this->assertEquals($assetAttributes['name'], $matchIncludedAssetAttributes->name);

        $matchLinks = $match->links;
        $this->assertEquals($data['links']['self'], $matchLinks->self);
    }

    /**
     * @param Players $players
     * @param array $data
     *
     * @since 1.2.0
     */
    private function assertPlayersObject(Players $players, array $data): void
    {
        $this->assertInstanceOf(\Lifeformwp\PHPPUBG\DTO\PlayerData\Links\Links::class, $players->links);
        $this->assertInstanceOf(\Lifeformwp\PHPPUBG\DTO\PlayerData\Meta\Meta::class, $players->meta);

        $playersData = $players->data[0];
        $this->assertInstanceOf(\Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Data::class, $playersData);
        $this->assertEquals($data['data'][0]['type'], $playersData->type);
        $this->assertEquals($data['data'][0]['id'], $playersData->id);
        $this->assertInstanceOf(PlayerAttributes::class, $playersData->attributes);
        $this->assertInstanceOf(PlayerRelationships::class, $playersData->relationships);
        $this->assertInstanceOf(PlayerLinks::class, $playersData->links);

        $playersDataAttributes = $playersData->attributes;
        $this->assertInstanceOf(\DateTimeImmutable::class, $playersDataAttributes->createdAt);
        $this->assertEquals($data['data'][0]['attributes']['name'], $playersDataAttributes->name);
        $this->assertEquals($data['data'][0]['attributes']['patchVersion'], $playersDataAttributes->patchVersion);
        $this->assertEquals($data['data'][0]['attributes']['shardId'], $playersDataAttributes->shardId);
        $this->assertEquals($data['data'][0]['attributes']['stats'], $playersDataAttributes->stats);
        $this->assertEquals($data['data'][0]['attributes']['titleId'], $playersDataAttributes->titleId);
        $this->assertInstanceOf(\DateTimeImmutable::class, $playersDataAttributes->updatedAt);

        $playersDataRelationships = $playersData->relationships;
        $this->assertInstanceOf(\Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Relationships\Assets::class, $playersDataRelationships->assets);
        $this->assertInstanceOf(Matches::class, $playersDataRelationships->matches);

        $playersDataRelationshipsMatch = $playersDataRelationships->matches->data[0];
        $this->assertInstanceOf(MatchData::class, $playersDataRelationshipsMatch);
        $this->assertEquals($data['data'][0]['relationships']['matches']['data'][0]['type'], $playersDataRelationshipsMatch->type);
        $this->assertEquals($data['data'][0]['relationships']['matches']['data'][0]['id'], $playersDataRelationshipsMatch->id);

        $playersDataLinks = $playersData->links;
        $this->assertInstanceOf(PlayerLinks::class, $playersDataLinks);
        $this->assertEquals($data['data'][0]['links']['schema'], $playersDataLinks->schema);
        $this->assertEquals($data['data'][0]['links']['self'], $playersDataLinks->self);

        $playersLinks = $players->links;
        $this->assertEquals($data['links']['self'], $playersLinks->self);
    }

    /**
     * @param Player $player
     * @param array $data
     *
     * @since 1.2.0
     */
    private function assertPlayerObject(Player $player, array $data): void
    {
        $this->assertInstanceOf(\Lifeformwp\PHPPUBG\DTO\PlayerData\Links\Links::class, $player->links);
        $this->assertInstanceOf(\Lifeformwp\PHPPUBG\DTO\PlayerData\Meta\Meta::class, $player->meta);

        $playersData = $player->data;
        $this->assertInstanceOf(\Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Data::class, $playersData);
        $this->assertEquals($data['data']['type'], $playersData->type);
        $this->assertEquals($data['data']['id'], $playersData->id);
        $this->assertInstanceOf(PlayerAttributes::class, $playersData->attributes);
        $this->assertInstanceOf(PlayerRelationships::class, $playersData->relationships);
        $this->assertInstanceOf(PlayerLinks::class, $playersData->links);

        $playersDataAttributes = $playersData->attributes;
        $this->assertInstanceOf(\DateTimeImmutable::class, $playersDataAttributes->createdAt);
        $this->assertEquals($data['data']['attributes']['name'], $playersDataAttributes->name);
        $this->assertEquals($data['data']['attributes']['patchVersion'], $playersDataAttributes->patchVersion);
        $this->assertEquals($data['data']['attributes']['shardId'], $playersDataAttributes->shardId);
        $this->assertEquals($data['data']['attributes']['stats'], $playersDataAttributes->stats);
        $this->assertEquals($data['data']['attributes']['titleId'], $playersDataAttributes->titleId);
        $this->assertInstanceOf(\DateTimeImmutable::class, $playersDataAttributes->updatedAt);

        $playersDataRelationships = $playersData->relationships;
        $this->assertInstanceOf(\Lifeformwp\PHPPUBG\DTO\PlayerData\Player\Relationships\Assets::class, $playersDataRelationships->assets);
        $this->assertInstanceOf(Matches::class, $playersDataRelationships->matches);

        $playersDataRelationshipsMatch = $playersDataRelationships->matches->data[0];
        $this->assertInstanceOf(MatchData::class, $playersDataRelationshipsMatch);
        $this->assertEquals($data['data']['relationships']['matches']['data'][0]['type'], $playersDataRelationshipsMatch->type);
        $this->assertEquals($data['data']['relationships']['matches']['data'][0]['id'], $playersDataRelationshipsMatch->id);

        $playersDataLinks = $playersData->links;
        $this->assertInstanceOf(PlayerLinks::class, $playersDataLinks);
        $this->assertEquals($data['data']['links']['schema'], $playersDataLinks->schema);
        $this->assertEquals($data['data']['links']['self'], $playersDataLinks->self);

        $playersLinks = $player->links;
        $this->assertEquals($data['links']['self'], $playersLinks->self);
    }

    /**
     * @param Status $status
     * @param array $data
     *
     * @since 1.2.0
     */
    private function assertStatusObject(Status $status, array $data): void
    {
        $statusData = $status->data;
        $this->assertInstanceOf(\Lifeformwp\PHPPUBG\DTO\StatusData\Status\Data::class, $statusData);
        $this->assertEquals($data['data']['type'], $statusData->type);
        $this->assertEquals($data['data']['id'], $statusData->id);

        $statusDataAttributes = $statusData->attributes;
        $this->assertInstanceOf(StatusAttributes::class, $statusDataAttributes);
        $this->assertInstanceOf(\DateTimeImmutable::class, $statusDataAttributes->releasedAt);
        $this->assertEquals($data['data']['attributes']['version'], $statusDataAttributes->version);
    }

    /**
     * @param string $link
     *
     * @return string
     * @since 1.2.0
     */
    private function getTestData(string $link): string
    {
        return \file_get_contents($link);
    }

    /**
     * @param string $data
     *
     * @return array
     * @since 1.2.0
     */
    private function jsonDecodeToArray(string $data): array
    {
        return \json_decode($data, true);
    }

    /**
     * @param string|null $responseBody
     * @param int $statusCode
     *
     * @return Client
     */
    private function mockClient(string $responseBody, int $statusCode): Client
    {
        $mock = new MockHandler(
            [
                new Response($statusCode, ['Content-Type' => 'application/json'],
                    $responseBody),
            ]
        );

        $handler = HandlerStack::create($mock);

        return new Client(['handler' => $handler]);
    }
}