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
use Lifeformwp\PHPPUBG\DTO\Samples;
use Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\Relationships\Type\MatchType;
use Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\SampleAttributes;
use Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\SampleRelationships;
use Lifeformwp\PHPPUBG\DTO\Status;
use Lifeformwp\PHPPUBG\DTO\StatusData\Status\StatusAttributes;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogArmorDestroy;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogCarePackageLand;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogCarePackageSpawn;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogGameStatePeriodic;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogItemAttach;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogItemDetach;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogItemDrop;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogItemEquip;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogItemPickup;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogItemUnequip;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogItemUse;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogMatchDefinition;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogMatchEnd;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogMatchStart;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogPlayerAttack;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogPlayerCreate;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogPlayerKill;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogPlayerLogin;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogPlayerLogout;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogPlayerMakeGroggy;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogPlayerPosition;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogPlayerRevive;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogPlayerTakeDamage;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogSwimEnd;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogSwimStart;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogVehicleDestroy;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogVehicleLeave;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogVehicleRide;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Events\LogWheelDestroy;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Character;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Common;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\GameState;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Item;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\ItemPackage;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Location;
use Lifeformwp\PHPPUBG\DTO\TelemetryData\Objects\Vehicle;
use Lifeformwp\PHPPUBG\PUBGManager;
use PHPUnit\Framework\TestCase;

/**
 * Class PUBGManagerTest
 *
 * @author  Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\Tests
 * @since   1.0.0
 */
class PUBGManagerTest extends TestCase
{
    public function testGetMatchArray(): void
    {
        $token = 'token';
        $data  = $this->getTestData('tests/example/match.json');

        $client  = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $match   = $manager->getMatch('pc-eu', 'abe08f7e-3add-4fd6-9bcd-4aff88fc7adf');
        $this->assertEquals($this->jsonDecodeToArray($data), $match);
    }

    public function testGetPlayersArray(): void
    {
        $token = 'token';
        $data  = $this->getTestData('tests/example/players.json');

        $client  = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $match   = $manager->getPlayers('pc-eu', ['Lifeformwp', 'MrEddyGordo']);
        $this->assertEquals($this->jsonDecodeToArray($data), $match);
    }

    public function testGetTelemetryArray(): void
    {
        $token = 'token';
        $data  = $this->getTestData('tests/example/telemetry.json');

        $client  = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $match   = $manager->getTelemetry('link');
        $this->assertEquals($this->jsonDecodeToArray($data), $match);
    }

    public function testGetSeasons(): void
    {
        $token = 'token';
        $data  = $this->getTestData('tests/example/seasons.json');

        $client  = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $seasons = $manager->getSeasons('pc-eu');
        $this->assertEquals($this->jsonDecodeToArray($data), $seasons);
    }

    public function testGetSeasonDataForPlayer(): void
    {
        $token = 'token';
        $data  = $this->getTestData('tests/example/season_for_player.json');

        $client  = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $seasons = $manager->getSeasonDataForPlayer('pc-na', 'account.d50fdc18fcad49c691d38466bed6f8fd', 'division.bro.official.2017-pre7');
        $this->assertEquals($this->jsonDecodeToArray($data), $seasons);
    }

    public function testGetStatus(): void
    {
        $token = 'token';
        $data  = $this->getTestData('tests/example/status.json');

        $client  = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $match   = $manager->getStatus();
        $this->assertEquals($this->jsonDecodeToArray($data), $match);
    }

    public function testGetSamples(): void
    {
        $token = 'token';
        $data  = $this->getTestData('tests/example/samples.json');

        $client  = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $match   = $manager->getSamples('pc-na');
        $this->assertEquals($this->jsonDecodeToArray($data), $match);
    }

    public function testGetMatchDTO(): void
    {
        $token = 'token';
        $data  = $this->getTestData('tests/example/match.json');

        $client  = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $match   = $manager->getMatch('pc-eu', 'abe08f7e-3add-4fd6-9bcd-4aff88fc7adf');
        $obj     = $manager->hydrate($match, PUBGManager::HYDRATE_MATCH);
        $this->assertMatchObject($obj, $this->jsonDecodeToArray($data));
    }

    public function testGetPlayersDTO(): void
    {
        $token = 'token';
        $data  = $this->getTestData('tests/example/players.json');

        $client  = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $players = $manager->getPlayers('pc-eu', ['Lifeformwp', 'MrEddyGordo']);
        $obj     = $manager->hydrate($players, PUBGManager::HYDRATE_PLAYERS);
        $this->assertPlayersObject($obj, $this->jsonDecodeToArray($data));
    }

    public function testGetPlayerDTO(): void
    {
        $token = 'token';
        $data  = $this->getTestData('tests/example/player.json');

        $client  = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $player  = $manager->getPlayer('pc-eu', 'account.b3982540418d421f8cbf72705e49b1ad');
        $obj     = $manager->hydrate($player, PUBGManager::HYDRATE_PLAYER);
        $this->assertPlayerObject($obj, $this->jsonDecodeToArray($data));
    }

    public function testGetStatusDTO(): void
    {
        $token = 'token';
        $data  = $this->getTestData('tests/example/status.json');

        $client  = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $status  = $manager->getStatus();
        $obj     = $manager->hydrate($status, PUBGManager::HYDRATE_STATUS);
        $this->assertStatusObject($obj, $this->jsonDecodeToArray($data));
    }

    public function testGetTelemetryDTO(): void
    {
        $token = 'token';
        $data  = $this->getTestData('tests/example/telemetry.json');

        $client         = $this->mockClient($data, 200);
        $manager        = new PUBGManager($client, $token);
        $status         = $manager->getTelemetry('https://api.playbattlegrounds.com/shards/pc-eu/matches/abe08f7e-3add-4fd6-9bcd-4aff88fc7adf');
        $objArray       = $manager->hydrate($status, PUBGManager::HYDRATE_TELEMETRY);
        $telemetryArray = $this->jsonDecodeToArray($this->getTestData('tests/example/telemetry.json'));

        $counter = 0;
        foreach ($objArray->events as $obj) {
            switch ($obj->type) {
                case "LogArmorDestroy":
                    $this->assertEventLogArmorDestroy($obj, $telemetryArray[$counter]);
                    break;
                case "LogPlayerMakeGroggy":
                    $this->assertEventLogPlayerMakeGroggy($obj, $telemetryArray[$counter]);
                    break;
                case "LogPlayerRevive":
                    $this->assertEventLogPlayerRevive($obj, $telemetryArray[$counter]);
                    break;
                case "LogSwimEnd":
                    $this->assertEventLogSwimEnd($obj, $telemetryArray[$counter]);
                    break;
                case "LogSwimStart":
                    $this->assertEventLogSwimStart($obj, $telemetryArray[$counter]);
                    break;
                case "LogWheelDestroy":
                    $this->assertEventLogWheelDestroy($obj, $telemetryArray[$counter]);
                    break;
                case "LogCarePackageLand":
                    $this->assertEventLogCarePackageLand($obj, $telemetryArray[$counter]);
                    break;
                case "LogCarePackageSpawn":
                    $this->assertEventLogCarePackageSpawn($obj, $telemetryArray[$counter]);
                    break;
                case "LogGameStatePeriodic":
                    $this->assertEventLogGameStatePeriodic($obj, $telemetryArray[$counter]);
                    break;
                case "LogItemAttach":
                    $this->assertEventLogItemAttach($obj, $telemetryArray[$counter]);
                    break;
                case "LogItemDetach":
                    $this->assertEventLogItemDetach($obj, $telemetryArray[$counter]);
                    break;
                case "LogItemDrop":
                    $this->assertEventLogItemDrop($obj, $telemetryArray[$counter]);
                    break;
                case "LogItemEquip":
                    $this->assertEventLogItemEquip($obj, $telemetryArray[$counter]);
                    break;
                case "LogItemPickup":
                    $this->assertEventLogItemPickup($obj, $telemetryArray[$counter]);
                    break;
                case "LogItemUnequip":
                    $this->assertEventLogItemUnequip($obj, $telemetryArray[$counter]);
                    break;
                case "LogItemUse":
                    $this->assertEventLogItemUse($obj, $telemetryArray[$counter]);
                    break;
                case "LogMatchDefinition":
                    $this->assertEventLogMatchDefinition($obj, $telemetryArray[$counter]);
                    break;
                case "LogMatchEnd":
                    $this->assertEventLogMatchEnd($obj, $telemetryArray[$counter]);
                    break;
                case "LogMatchStart":
                    $this->assertEventLogMatchStart($obj, $telemetryArray[$counter]);
                    break;
                case "LogPlayerAttack":
                    $this->assertEventLogPlayerAttack($obj, $telemetryArray[$counter]);
                    break;
                case "LogPlayerCreate":
                    $this->assertEventLogPlayerCreate($obj, $telemetryArray[$counter]);
                    break;
                case "LogPlayerKill":
                    $this->assertEventLogPlayerKill($obj, $telemetryArray[$counter]);
                    break;
                case "LogPlayerLogin":
                    $this->assertEventLogPlayerLogin($obj, $telemetryArray[$counter]);
                    break;
                case "LogPlayerLogout":
                    $this->assertEventLogPlayerLogout($obj, $telemetryArray[$counter]);
                    break;
                case "LogPlayerPosition":
                    $this->assertEventLogPlayerPosition($obj, $telemetryArray[$counter]);
                    break;
                case "LogPlayerTakeDamage":
                    $this->assertEventLogPlayerTakeDamage($obj, $telemetryArray[$counter]);
                    break;
                case "LogVehicleDestroy":
                    $this->assertEventLogVehicleDestroy($obj, $telemetryArray[$counter]);
                    break;
                case "LogVehicleLeave":
                    $this->assertEventLogVehicleLeave($obj, $telemetryArray[$counter]);
                    break;
                case "LogVehicleRide":
                    $this->assertEventLogVehicleRide($obj, $telemetryArray[$counter]);
                    break;
            }

            ++$counter;
        }
    }

    public function testGetSamplesDTO(): void
    {
        $token = 'token';
        $data  = $this->getTestData('tests/example/samples.json');

        $client  = $this->mockClient($data, 200);
        $manager = new PUBGManager($client, $token);
        $status  = $manager->getSamples('pc-na');
        $obj     = $manager->hydrate($status, PUBGManager::HYDRATE_SAMPLES);
        $this->assertSample($obj, $this->jsonDecodeToArray($data));
    }

    public function testTelemetryDTO(): void
    {
        $data = $this->jsonDecodeToArray($this->getTestData('tests/example/telemetry.json'));
        foreach ($data as $item) {
            switch ($item["_T"]) {
                case "LogArmorDestroy":
                    $obj = LogArmorDestroy::createFromResponse($item);
                    $this->assertEventLogArmorDestroy($obj, $item);
                    break;
                case "LogPlayerMakeGroggy":
                    $obj = LogPlayerMakeGroggy::createFromResponse($item);
                    $this->assertEventLogPlayerMakeGroggy($obj, $item);
                    break;
                case "LogPlayerRevive":
                    $obj = LogPlayerRevive::createFromResponse($item);
                    $this->assertEventLogPlayerRevive($obj, $item);
                    break;
                case "LogSwimEnd":
                    $obj = LogSwimEnd::createFromResponse($item);
                    $this->assertEventLogSwimEnd($obj, $item);
                    break;
                case "LogSwimStart":
                    $obj = LogSwimStart::createFromResponse($item);
                    $this->assertEventLogSwimStart($obj, $item);
                    break;
                case "LogWheelDestroy":
                    $obj = LogWheelDestroy::createFromResponse($item);
                    $this->assertEventLogWheelDestroy($obj, $item);
                    break;
                case "LogCarePackageLand":
                    $obj = LogCarePackageLand::createFromResponse($item);
                    $this->assertEventLogCarePackageLand($obj, $item);
                    break;
                case "LogCarePackageSpawn":
                    $obj = LogCarePackageSpawn::createFromResponse($item);
                    $this->assertEventLogCarePackageSpawn($obj, $item);
                    break;
                case "LogGameStatePeriodic":
                    $obj = LogGameStatePeriodic::createFromResponse($item);
                    $this->assertEventLogGameStatePeriodic($obj, $item);
                    break;
                case "LogItemAttach":
                    $obj = LogItemAttach::createFromResponse($item);
                    $this->assertEventLogItemAttach($obj, $item);
                    break;
                case "LogItemDetach":
                    $obj = LogItemDetach::createFromResponse($item);
                    $this->assertEventLogItemDetach($obj, $item);
                    break;
                case "LogItemDrop":
                    $obj = LogItemDrop::createFromResponse($item);
                    $this->assertEventLogItemDrop($obj, $item);
                    break;
                case "LogItemEquip":
                    $obj = LogItemEquip::createFromResponse($item);
                    $this->assertEventLogItemEquip($obj, $item);
                    break;
                case "LogItemPickup":
                    $obj = LogItemPickup::createFromResponse($item);
                    $this->assertEventLogItemPickup($obj, $item);
                    break;
                case "LogItemUnequip":
                    $obj = LogItemUnequip::createFromResponse($item);
                    $this->assertEventLogItemUnequip($obj, $item);
                    break;
                case "LogItemUse":
                    $obj = LogItemUse::createFromResponse($item);
                    $this->assertEventLogItemUse($obj, $item);
                    break;
                case "LogMatchDefinition":
                    $obj = LogMatchDefinition::createFromResponse($item);
                    $this->assertEventLogMatchDefinition($obj, $item);
                    break;
                case "LogMatchEnd":
                    $obj = LogMatchEnd::createFromResponse($item);
                    $this->assertEventLogMatchEnd($obj, $item);
                    break;
                case "LogMatchStart":
                    $obj = LogMatchStart::createFromResponse($item);
                    $this->assertEventLogMatchStart($obj, $item);
                    break;
                case "LogPlayerAttack":
                    $obj = LogPlayerAttack::createFromResponse($item);
                    $this->assertEventLogPlayerAttack($obj, $item);
                    break;
                case "LogPlayerCreate":
                    $obj = LogPlayerCreate::createFromResponse($item);
                    $this->assertEventLogPlayerCreate($obj, $item);
                    break;
                case "LogPlayerKill":
                    $obj = LogPlayerKill::createFromResponse($item);
                    $this->assertEventLogPlayerKill($obj, $item);
                    break;
                case "LogPlayerLogin":
                    $obj = LogPlayerLogin::createFromResponse($item);
                    $this->assertEventLogPlayerLogin($obj, $item);
                    break;
                case "LogPlayerLogout":
                    $obj = LogPlayerLogout::createFromResponse($item);
                    $this->assertEventLogPlayerLogout($obj, $item);
                    break;
                case "LogPlayerPosition":
                    $obj = LogPlayerPosition::createFromResponse($item);
                    $this->assertEventLogPlayerPosition($obj, $item);
                    break;
                case "LogPlayerTakeDamage":
                    $obj = LogPlayerTakeDamage::createFromResponse($item);
                    $this->assertEventLogPlayerTakeDamage($obj, $item);
                    break;
                case "LogVehicleDestroy":
                    $obj = LogVehicleDestroy::createFromResponse($item);
                    $this->assertEventLogVehicleDestroy($obj, $item);
                    break;
                case "LogVehicleLeave":
                    $obj = LogVehicleLeave::createFromResponse($item);
                    $this->assertEventLogVehicleLeave($obj, $item);
                    break;
                case "LogVehicleRide":
                    $obj = LogVehicleRide::createFromResponse($item);
                    $this->assertEventLogVehicleRide($obj, $item);
                    break;
            }
        }
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
        $this->assertEquals($data['data']['attributes']['shardId'], $matchDataAttributes->shardId);
        $this->assertEquals($data['data']['attributes']['stats'], $matchDataAttributes->stats);
        $this->assertEquals($data['data']['attributes']['tags'], $matchDataAttributes->tags);
        $this->assertEquals($data['data']['attributes']['titleId'], $matchDataAttributes->titleId);
        $this->assertEquals($data['data']['attributes']['isCustomMatch'], $matchDataAttributes->isCustomMatch);

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

        $matchIncluded       = $match->included;
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
        $stats                                   = $data['included'][0]['attributes']['stats'];
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
        $this->assertEquals($stats['swimDistance'], $matchIncludedParticipantAttributesStats->swimDistance);
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
        $assetAttributes              = $data['included'][1]['attributes'];
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
     * @param array   $data
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
        $this->assertEquals($data['data'][0]['attributes']['name'], $playersDataAttributes->name);
        $this->assertEquals($data['data'][0]['attributes']['patchVersion'], $playersDataAttributes->patchVersion);
        $this->assertEquals($data['data'][0]['attributes']['shardId'], $playersDataAttributes->shardId);
        $this->assertEquals($data['data'][0]['attributes']['stats'], $playersDataAttributes->stats);
        $this->assertEquals($data['data'][0]['attributes']['titleId'], $playersDataAttributes->titleId);

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
     * @param array  $data
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
        $this->assertEquals($data['data']['attributes']['name'], $playersDataAttributes->name);
        $this->assertEquals($data['data']['attributes']['patchVersion'], $playersDataAttributes->patchVersion);
        $this->assertEquals($data['data']['attributes']['shardId'], $playersDataAttributes->shardId);
        $this->assertEquals($data['data']['attributes']['stats'], $playersDataAttributes->stats);
        $this->assertEquals($data['data']['attributes']['titleId'], $playersDataAttributes->titleId);

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
     * @param array  $data
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
     * @param LogCarePackageLand $event
     * @param array              $data
     *
     * @since 1.3.0
     */
    private function assertEventLogCarePackageLand(LogCarePackageLand $event, array $data): void
    {
        $itemPackage = $event->itemPackage;
        $this->assertInstanceOf(ItemPackage::class, $itemPackage);
        $this->assertEquals($data['itemPackage']['itemPackageId'], $itemPackage->itemPackageId);

        $itemPackageLocation = $itemPackage->location;
        $this->assertInstanceOf(Location::class, $itemPackageLocation);
        $this->assertEquals($data['itemPackage']['location']['x'], $itemPackageLocation->posX);
        $this->assertEquals($data['itemPackage']['location']['y'], $itemPackageLocation->posY);
        $this->assertEquals($data['itemPackage']['location']['z'], $itemPackageLocation->posZ);

        $counter = 0;
        foreach ($itemPackage->items as $item) {
            $this->assertEquals($data['itemPackage']['items'][$counter]['itemId'], $item->itemId);
            $this->assertEquals($data['itemPackage']['items'][$counter]['stackCount'], $item->stackCount);
            $this->assertEquals($data['itemPackage']['items'][$counter]['category'], $item->category);
            $this->assertEquals($data['itemPackage']['items'][$counter]['subCategory'], $item->subCategory);
            $this->assertEquals($data['itemPackage']['items'][$counter]['attachedItems'], $item->attachedItems);
            ++$counter;
        }

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogCarePackageSpawn $event
     * @param array               $data
     *
     * @since 1.3.0
     */
    private function assertEventLogCarePackageSpawn(LogCarePackageSpawn $event, array $data): void
    {
        $itemPackage = $event->itemPackage;
        $this->assertInstanceOf(ItemPackage::class, $itemPackage);
        $this->assertEquals($data['itemPackage']['itemPackageId'], $itemPackage->itemPackageId);

        $itemPackageLocation = $itemPackage->location;
        $this->assertInstanceOf(Location::class, $itemPackageLocation);
        $this->assertEquals($data['itemPackage']['location']['x'], $itemPackageLocation->posX);
        $this->assertEquals($data['itemPackage']['location']['y'], $itemPackageLocation->posY);
        $this->assertEquals($data['itemPackage']['location']['z'], $itemPackageLocation->posZ);

        $counter = 0;
        foreach ($itemPackage->items as $item) {
            $this->assertEquals($data['itemPackage']['items'][$counter]['itemId'], $item->itemId);
            $this->assertEquals($data['itemPackage']['items'][$counter]['stackCount'], $item->stackCount);
            $this->assertEquals($data['itemPackage']['items'][$counter]['category'], $item->category);
            $this->assertEquals($data['itemPackage']['items'][$counter]['subCategory'], $item->subCategory);
            $this->assertEquals($data['itemPackage']['items'][$counter]['attachedItems'], $item->attachedItems);
            ++$counter;
        }

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogGameStatePeriodic $event
     * @param array                $data
     *
     * @since 1.3.0
     */
    private function assertEventLogGameStatePeriodic(LogGameStatePeriodic $event, array $data): void
    {
        $gameState = $event->gameState;
        $this->assertInstanceOf(GameState::class, $gameState);
        $this->assertEquals($data['gameState']['elapsedTime'], $gameState->elapsedTime);
        $this->assertEquals($data['gameState']['numAliveTeams'], $gameState->numAlivePlayers);
        $this->assertEquals($data['gameState']['numJoinPlayers'], $gameState->numJoinPlayers);
        $this->assertEquals($data['gameState']['numStartPlayers'], $gameState->numStartPlayers);
        $this->assertEquals($data['gameState']['numAlivePlayers'], $gameState->numAlivePlayers);

        $safetyZonePosition = $gameState->safetyZonePosition;
        $this->assertInstanceOf(Location::class, $safetyZonePosition);
        $this->assertEquals($data['gameState']['safetyZonePosition']['x'], $safetyZonePosition->posX);
        $this->assertEquals($data['gameState']['safetyZonePosition']['y'], $safetyZonePosition->posY);
        $this->assertEquals($data['gameState']['safetyZonePosition']['z'], $safetyZonePosition->posZ);
        $this->assertEquals($data['gameState']['safetyZoneRadius'], $gameState->safetyZoneRadius);

        $poisonGasWarningPosition = $gameState->poisonGasWarningPosition;
        $this->assertInstanceOf(Location::class, $poisonGasWarningPosition);
        $this->assertEquals($data['gameState']['poisonGasWarningPosition']['x'], $poisonGasWarningPosition->posX);
        $this->assertEquals($data['gameState']['poisonGasWarningPosition']['y'], $poisonGasWarningPosition->posY);
        $this->assertEquals($data['gameState']['poisonGasWarningPosition']['z'], $poisonGasWarningPosition->posZ);
        $this->assertEquals($data['gameState']['poisonGasWarningRadius'], $gameState->poisonGasWarningRadius);

        $redZonePosition = $gameState->redZonePosition;
        $this->assertInstanceOf(Location::class, $redZonePosition);
        $this->assertEquals($data['gameState']['redZonePosition']['x'], $redZonePosition->posX);
        $this->assertEquals($data['gameState']['redZonePosition']['y'], $redZonePosition->posY);
        $this->assertEquals($data['gameState']['redZonePosition']['z'], $redZonePosition->posZ);
        $this->assertEquals($data['gameState']['redZoneRadius'], $gameState->redZoneRadius);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogItemAttach $event
     * @param array         $data
     *
     * @since 1.3.0
     */
    private function assertEventLogItemAttach(LogItemAttach $event, array $data): void
    {
        $character = $event->character;
        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals($data['character']['name'], $character->name);
        $this->assertEquals($data['character']['teamId'], $character->teamId);
        $this->assertEquals($data['character']['health'], $character->health);

        $characterLocation = $character->location;
        $this->assertInstanceOf(Location::class, $characterLocation);
        $this->assertEquals($data['character']['location']['x'], $characterLocation->posX);
        $this->assertEquals($data['character']['location']['y'], $characterLocation->posY);
        $this->assertEquals($data['character']['location']['z'], $characterLocation->posZ);
        $this->assertEquals($data['character']['ranking'], $character->ranking);
        $this->assertEquals($data['character']['accountId'], $character->accountId);

        $parentItem = $event->parentItem;
        $this->assertInstanceOf(Item::class, $parentItem);
        $this->assertEquals($data['parentItem']['itemId'], $parentItem->itemId);
        $this->assertEquals($data['parentItem']['stackCount'], $parentItem->stackCount);
        $this->assertEquals($data['parentItem']['category'], $parentItem->category);
        $this->assertEquals($data['parentItem']['subCategory'], $parentItem->subCategory);
        $this->assertEquals($data['parentItem']['attachedItems'], $parentItem->attachedItems);

        $childItem = $event->childItem;
        $this->assertInstanceOf(Item::class, $childItem);
        $this->assertEquals($data['childItem']['itemId'], $childItem->itemId);
        $this->assertEquals($data['childItem']['stackCount'], $childItem->stackCount);
        $this->assertEquals($data['childItem']['category'], $childItem->category);
        $this->assertEquals($data['childItem']['subCategory'], $childItem->subCategory);
        $this->assertEquals($data['childItem']['attachedItems'], $childItem->attachedItems);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogItemDetach $event
     * @param array         $data
     *
     * @since 1.3.0
     */
    private function assertEventLogItemDetach(LogItemDetach $event, array $data): void
    {
        $character = $event->character;
        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals($data['character']['name'], $character->name);
        $this->assertEquals($data['character']['teamId'], $character->teamId);
        $this->assertEquals($data['character']['health'], $character->health);

        $characterLocation = $character->location;
        $this->assertInstanceOf(Location::class, $characterLocation);
        $this->assertEquals($data['character']['location']['x'], $characterLocation->posX);
        $this->assertEquals($data['character']['location']['y'], $characterLocation->posY);
        $this->assertEquals($data['character']['location']['z'], $characterLocation->posZ);
        $this->assertEquals($data['character']['ranking'], $character->ranking);
        $this->assertEquals($data['character']['accountId'], $character->accountId);

        $parentItem = $event->parentItem;
        $this->assertInstanceOf(Item::class, $parentItem);
        $this->assertEquals($data['parentItem']['itemId'], $parentItem->itemId);
        $this->assertEquals($data['parentItem']['stackCount'], $parentItem->stackCount);
        $this->assertEquals($data['parentItem']['category'], $parentItem->category);
        $this->assertEquals($data['parentItem']['subCategory'], $parentItem->subCategory);
        $this->assertEquals($data['parentItem']['attachedItems'], $parentItem->attachedItems);

        $childItem = $event->childItem;
        $this->assertInstanceOf(Item::class, $childItem);
        $this->assertEquals($data['childItem']['itemId'], $childItem->itemId);
        $this->assertEquals($data['childItem']['stackCount'], $childItem->stackCount);
        $this->assertEquals($data['childItem']['category'], $childItem->category);
        $this->assertEquals($data['childItem']['subCategory'], $childItem->subCategory);
        $this->assertEquals($data['childItem']['attachedItems'], $childItem->attachedItems);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogItemDrop $event
     * @param array       $data
     *
     * @since 1.3.0
     */
    private function assertEventLogItemDrop(LogItemDrop $event, array $data): void
    {
        $character = $event->character;
        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals($data['character']['name'], $character->name);
        $this->assertEquals($data['character']['teamId'], $character->teamId);
        $this->assertEquals($data['character']['health'], $character->health);

        $characterLocation = $character->location;
        $this->assertInstanceOf(Location::class, $characterLocation);
        $this->assertEquals($data['character']['location']['x'], $characterLocation->posX);
        $this->assertEquals($data['character']['location']['y'], $characterLocation->posY);
        $this->assertEquals($data['character']['location']['z'], $characterLocation->posZ);
        $this->assertEquals($data['character']['ranking'], $character->ranking);
        $this->assertEquals($data['character']['accountId'], $character->accountId);

        $item = $event->item;
        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($data['item']['itemId'], $item->itemId);
        $this->assertEquals($data['item']['stackCount'], $item->stackCount);
        $this->assertEquals($data['item']['category'], $item->category);
        $this->assertEquals($data['item']['subCategory'], $item->subCategory);
        $this->assertEquals($data['item']['attachedItems'], $item->attachedItems);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogItemEquip $event
     * @param array        $data
     *
     * @since 1.3.0
     */
    private function assertEventLogItemEquip(LogItemEquip $event, array $data): void
    {
        $character = $event->character;
        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals($data['character']['name'], $character->name);
        $this->assertEquals($data['character']['teamId'], $character->teamId);
        $this->assertEquals($data['character']['health'], $character->health);

        $characterLocation = $character->location;
        $this->assertInstanceOf(Location::class, $characterLocation);
        $this->assertEquals($data['character']['location']['x'], $characterLocation->posX);
        $this->assertEquals($data['character']['location']['y'], $characterLocation->posY);
        $this->assertEquals($data['character']['location']['z'], $characterLocation->posZ);
        $this->assertEquals($data['character']['ranking'], $character->ranking);
        $this->assertEquals($data['character']['accountId'], $character->accountId);

        $item = $event->item;
        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($data['item']['itemId'], $item->itemId);
        $this->assertEquals($data['item']['stackCount'], $item->stackCount);
        $this->assertEquals($data['item']['category'], $item->category);
        $this->assertEquals($data['item']['subCategory'], $item->subCategory);
        $this->assertEquals($data['item']['attachedItems'], $item->attachedItems);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogItemPickup $event
     * @param array         $data
     *
     * @since 1.3.0
     */
    private function assertEventLogItemPickup(LogItemPickup $event, array $data): void
    {
        $character = $event->character;
        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals($data['character']['name'], $character->name);
        $this->assertEquals($data['character']['teamId'], $character->teamId);
        $this->assertEquals($data['character']['health'], $character->health);

        $characterLocation = $character->location;
        $this->assertInstanceOf(Location::class, $characterLocation);
        $this->assertEquals($data['character']['location']['x'], $characterLocation->posX);
        $this->assertEquals($data['character']['location']['y'], $characterLocation->posY);
        $this->assertEquals($data['character']['location']['z'], $characterLocation->posZ);
        $this->assertEquals($data['character']['ranking'], $character->ranking);
        $this->assertEquals($data['character']['accountId'], $character->accountId);

        $item = $event->item;
        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($data['item']['itemId'], $item->itemId);
        $this->assertEquals($data['item']['stackCount'], $item->stackCount);
        $this->assertEquals($data['item']['category'], $item->category);
        $this->assertEquals($data['item']['subCategory'], $item->subCategory);
        $this->assertEquals($data['item']['attachedItems'], $item->attachedItems);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogItemUnequip $event
     * @param array          $data
     *
     * @since 1.3.0
     */
    private function assertEventLogItemUnequip(LogItemUnequip $event, array $data): void
    {
        $character = $event->character;
        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals($data['character']['name'], $character->name);
        $this->assertEquals($data['character']['teamId'], $character->teamId);
        $this->assertEquals($data['character']['health'], $character->health);

        $characterLocation = $character->location;
        $this->assertInstanceOf(Location::class, $characterLocation);
        $this->assertEquals($data['character']['location']['x'], $characterLocation->posX);
        $this->assertEquals($data['character']['location']['y'], $characterLocation->posY);
        $this->assertEquals($data['character']['location']['z'], $characterLocation->posZ);
        $this->assertEquals($data['character']['ranking'], $character->ranking);
        $this->assertEquals($data['character']['accountId'], $character->accountId);

        $item = $event->item;
        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($data['item']['itemId'], $item->itemId);
        $this->assertEquals($data['item']['stackCount'], $item->stackCount);
        $this->assertEquals($data['item']['category'], $item->category);
        $this->assertEquals($data['item']['subCategory'], $item->subCategory);
        $this->assertEquals($data['item']['attachedItems'], $item->attachedItems);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogItemUse $event
     * @param array      $data
     *
     * @since 1.3.0
     */
    private function assertEventLogItemUse(LogItemUse $event, array $data): void
    {
        $character = $event->character;
        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals($data['character']['name'], $character->name);
        $this->assertEquals($data['character']['teamId'], $character->teamId);
        $this->assertEquals($data['character']['health'], $character->health);

        $characterLocation = $character->location;
        $this->assertInstanceOf(Location::class, $characterLocation);
        $this->assertEquals($data['character']['location']['x'], $characterLocation->posX);
        $this->assertEquals($data['character']['location']['y'], $characterLocation->posY);
        $this->assertEquals($data['character']['location']['z'], $characterLocation->posZ);
        $this->assertEquals($data['character']['ranking'], $character->ranking);
        $this->assertEquals($data['character']['accountId'], $character->accountId);

        $item = $event->item;
        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($data['item']['itemId'], $item->itemId);
        $this->assertEquals($data['item']['stackCount'], $item->stackCount);
        $this->assertEquals($data['item']['category'], $item->category);
        $this->assertEquals($data['item']['subCategory'], $item->subCategory);
        $this->assertEquals($data['item']['attachedItems'], $item->attachedItems);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogMatchDefinition $event
     * @param array              $data
     *
     * @since 1.3.0
     */
    private function assertEventLogMatchDefinition(LogMatchDefinition $event, array $data): void
    {
        $this->assertEquals($data['MatchId'], $event->matchId);
        $this->assertEquals($data['PingQuality'], $event->pingQuality);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogMatchEnd $event
     * @param array       $data
     *
     * @since 1.3.0
     */
    private function assertEventLogMatchEnd(LogMatchEnd $event, array $data): void
    {
        $counter = 0;
        foreach ($event->characters as $character) {
            $this->assertInstanceOf(Character::class, $character);
            $this->assertEquals($data['characters'][$counter]['name'], $character->name);
            $this->assertEquals($data['characters'][$counter]['teamId'], $character->teamId);
            $this->assertEquals($data['characters'][$counter]['health'], $character->health);
            $location = $character->location;
            $this->assertInstanceOf(Location::class, $location);
            $this->assertEquals($data['characters'][$counter]['location']['x'], $location->posX);
            $this->assertEquals($data['characters'][$counter]['location']['y'], $location->posY);
            $this->assertEquals($data['characters'][$counter]['location']['z'], $location->posZ);
            $this->assertEquals($data['characters'][$counter]['ranking'], $character->ranking);
            $this->assertEquals($data['characters'][$counter]['accountId'], $character->accountId);
            ++$counter;
        }

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogMatchStart $event
     * @param array         $data
     *
     * @since 1.3.0
     */
    private function assertEventLogMatchStart(LogMatchStart $event, array $data): void
    {
        $this->assertEquals($data['mapName'], $event->mapName);
        $this->assertEquals($data['weatherId'], $event->weatherId);
        $this->assertEquals($data['isCustomGame'], $event->isCustomGame);
        $this->assertEquals($data['isEventMode'], $event->isEventMode);
        $counter = 0;
        foreach ($event->characters as $character) {
            $this->assertInstanceOf(Character::class, $character);
            $this->assertEquals($data['characters'][$counter]['name'], $character->name);
            $this->assertEquals($data['characters'][$counter]['teamId'], $character->teamId);
            $this->assertEquals($data['characters'][$counter]['health'], $character->health);
            $location = $character->location;
            $this->assertInstanceOf(Location::class, $location);
            $this->assertEquals($data['characters'][$counter]['location']['x'], $location->posX);
            $this->assertEquals($data['characters'][$counter]['location']['y'], $location->posY);
            $this->assertEquals($data['characters'][$counter]['location']['z'], $location->posZ);
            $this->assertEquals($data['characters'][$counter]['ranking'], $character->ranking);
            $this->assertEquals($data['characters'][$counter]['accountId'], $character->accountId);
            ++$counter;
        }

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogPlayerAttack $event
     * @param array           $data
     *
     * @since 1.3.0
     */
    private function assertEventLogPlayerAttack(LogPlayerAttack $event, array $data): void
    {
        $this->assertEquals($data['attackId'], $event->attackId);

        $attacker = $event->attacker;
        $this->assertInstanceOf(Character::class, $attacker);
        $this->assertEquals($data['attacker']['name'], $attacker->name);
        $this->assertEquals($data['attacker']['teamId'], $attacker->teamId);
        $this->assertEquals($data['attacker']['health'], $attacker->health);

        $attackerLocation = $attacker->location;
        $this->assertInstanceOf(Location::class, $attackerLocation);
        $this->assertEquals($data['attacker']['location']['x'], $attackerLocation->posX);
        $this->assertEquals($data['attacker']['location']['y'], $attackerLocation->posY);
        $this->assertEquals($data['attacker']['location']['z'], $attackerLocation->posZ);
        $this->assertEquals($data['attacker']['ranking'], $attacker->ranking);
        $this->assertEquals($data['attacker']['accountId'], $attacker->accountId);

        $this->assertEquals($data['attackType'], $event->attackType);

        $attackerWeapon = $event->weapon;
        $this->assertInstanceOf(Item::class, $attackerWeapon);
        $this->assertEquals($data['weapon']['itemId'], $attackerWeapon->itemId);
        $this->assertEquals($data['weapon']['stackCount'], $attackerWeapon->stackCount);
        $this->assertEquals($data['weapon']['category'], $attackerWeapon->category);
        $this->assertEquals($data['weapon']['subCategory'], $attackerWeapon->subCategory);
        $this->assertEquals($data['weapon']['attachedItems'], $attackerWeapon->attachedItems);

        $attackerVehicle = $event->vehicle;
        $this->assertInstanceOf(Vehicle::class, $attackerVehicle);
        $this->assertEquals($data['vehicle']['vehicleType'], $attackerVehicle->vehicleType);
        $this->assertEquals($data['vehicle']['vehicleId'], $attackerVehicle->vehicleId);
        $this->assertEquals($data['vehicle']['healthPercent'], $attackerVehicle->healthPercent);
        $this->assertEquals($data['vehicle']['feulPercent'], $attackerVehicle->fuelPercent);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogPlayerCreate $event
     * @param array           $data
     *
     * @since 1.3.0
     */
    private function assertEventLogPlayerCreate(LogPlayerCreate $event, array $data): void
    {
        $character = $event->character;
        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals($data['character']['name'], $character->name);
        $this->assertEquals($data['character']['teamId'], $character->teamId);
        $this->assertEquals($data['character']['health'], $character->health);

        $characterLocation = $character->location;
        $this->assertInstanceOf(Location::class, $characterLocation);
        $this->assertEquals($data['character']['location']['x'], $characterLocation->posX);
        $this->assertEquals($data['character']['location']['y'], $characterLocation->posY);
        $this->assertEquals($data['character']['location']['z'], $characterLocation->posZ);
        $this->assertEquals($data['character']['ranking'], $character->ranking);
        $this->assertEquals($data['character']['accountId'], $character->accountId);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogPlayerKill $event
     * @param array         $data
     *
     * @since 1.3.0
     */
    private function assertEventLogPlayerKill(LogPlayerKill $event, array $data): void
    {
        $this->assertEquals($data['attackId'], $event->attackId);

        $killer = $event->killer;
        $this->assertInstanceOf(Character::class, $killer);
        $this->assertEquals($data['killer']['name'], $killer->name);
        $this->assertEquals($data['killer']['teamId'], $killer->teamId);
        $this->assertEquals($data['killer']['health'], $killer->health);

        $killerLocation = $killer->location;
        $this->assertInstanceOf(Location::class, $killerLocation);
        $this->assertEquals($data['killer']['location']['x'], $killerLocation->posX);
        $this->assertEquals($data['killer']['location']['y'], $killerLocation->posY);
        $this->assertEquals($data['killer']['location']['z'], $killerLocation->posZ);
        $this->assertEquals($data['killer']['ranking'], $killer->ranking);
        $this->assertEquals($data['killer']['accountId'], $killer->accountId);

        $victim = $event->victim;
        $this->assertInstanceOf(Character::class, $victim);
        $this->assertEquals($data['victim']['name'], $victim->name);
        $this->assertEquals($data['victim']['teamId'], $victim->teamId);
        $this->assertEquals($data['victim']['health'], $victim->health);

        $victimLocation = $victim->location;
        $this->assertInstanceOf(Location::class, $victimLocation);
        $this->assertEquals($data['victim']['location']['x'], $victimLocation->posX);
        $this->assertEquals($data['victim']['location']['y'], $victimLocation->posY);
        $this->assertEquals($data['victim']['location']['z'], $victimLocation->posZ);
        $this->assertEquals($data['victim']['ranking'], $victim->ranking);
        $this->assertEquals($data['victim']['accountId'], $victim->accountId);

        $this->assertEquals($data['damageTypeCategory'], $event->damageTypeCategory);
        $this->assertEquals($data['damageCauserName'], $event->damageCauserName);
        $this->assertEquals($data['distance'], $event->distance);
        $this->assertEquals($data['damageReason'], $event->damageReason);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogPlayerLogin $event
     * @param array          $data
     *
     * @since 1.3.0
     */
    private function assertEventLogPlayerLogin(LogPlayerLogin $event, array $data): void
    {
        $this->assertEquals($data['accountId'], $event->accountId);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogPlayerLogout $event
     * @param array           $data
     *
     * @since 1.3.0
     */
    private function assertEventLogPlayerLogout(LogPlayerLogout $event, array $data): void
    {
        $this->assertEquals($data['accountId'], $event->accountId);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogPlayerPosition $event
     * @param array             $data
     *
     * @since 1.3.0
     */
    private function assertEventLogPlayerPosition(LogPlayerPosition $event, array $data): void
    {
        $character = $event->character;
        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals($data['character']['name'], $character->name);
        $this->assertEquals($data['character']['teamId'], $character->teamId);
        $this->assertEquals($data['character']['health'], $character->health);

        $characterLocation = $character->location;
        $this->assertInstanceOf(Location::class, $characterLocation);
        $this->assertEquals($data['character']['location']['x'], $characterLocation->posX);
        $this->assertEquals($data['character']['location']['y'], $characterLocation->posY);
        $this->assertEquals($data['character']['location']['z'], $characterLocation->posZ);
        $this->assertEquals($data['character']['ranking'], $character->ranking);
        $this->assertEquals($data['character']['accountId'], $character->accountId);

        $this->assertEquals($data['elapsedTime'], $event->elapsedTime);
        $this->assertEquals($data['numAlivePlayers'], $event->numAlivePlayers);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogPlayerTakeDamage $event
     * @param array               $data
     *
     * @since 1.3.0
     */
    private function assertEventLogPlayerTakeDamage(LogPlayerTakeDamage $event, array $data): void
    {
        $this->assertEquals($data['attackId'], $event->attackId);

        $attacker = $event->attacker;
        $this->assertInstanceOf(Character::class, $attacker);
        $this->assertEquals($data['attacker']['name'], $attacker->name);
        $this->assertEquals($data['attacker']['teamId'], $attacker->teamId);
        $this->assertEquals($data['attacker']['health'], $attacker->health);

        $attackerLocation = $attacker->location;
        $this->assertInstanceOf(Location::class, $attackerLocation);
        $this->assertEquals($data['attacker']['location']['x'], $attackerLocation->posX);
        $this->assertEquals($data['attacker']['location']['y'], $attackerLocation->posY);
        $this->assertEquals($data['attacker']['location']['z'], $attackerLocation->posZ);
        $this->assertEquals($data['attacker']['ranking'], $attacker->ranking);
        $this->assertEquals($data['attacker']['accountId'], $attacker->accountId);

        $victim = $event->victim;
        $this->assertInstanceOf(Character::class, $victim);
        $this->assertEquals($data['victim']['name'], $victim->name);
        $this->assertEquals($data['victim']['teamId'], $victim->teamId);
        $this->assertEquals($data['victim']['health'], $victim->health);

        $victimLocation = $victim->location;
        $this->assertInstanceOf(Location::class, $victimLocation);
        $this->assertEquals($data['victim']['location']['x'], $victimLocation->posX);
        $this->assertEquals($data['victim']['location']['y'], $victimLocation->posY);
        $this->assertEquals($data['victim']['location']['z'], $victimLocation->posZ);
        $this->assertEquals($data['victim']['ranking'], $victim->ranking);
        $this->assertEquals($data['victim']['accountId'], $victim->accountId);

        $this->assertEquals($data['damageTypeCategory'], $event->damageTypeCategory);
        $this->assertEquals($data['damageReason'], $event->damageReason);
        $this->assertEquals($data['damage'], $event->damage);
        $this->assertEquals($data['damageCauserName'], $event->damageCauserName);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogVehicleDestroy $event
     * @param array             $data
     *
     * @since 1.3.0
     */
    private function assertEventLogVehicleDestroy(LogVehicleDestroy $event, array $data): void
    {
        $this->assertEquals($data['attackId'], $event->attackId);

        $attacker = $event->attacker;
        $this->assertInstanceOf(Character::class, $attacker);
        $this->assertEquals($data['attacker']['name'], $attacker->name);
        $this->assertEquals($data['attacker']['teamId'], $attacker->teamId);
        $this->assertEquals($data['attacker']['health'], $attacker->health);

        $attackerLocation = $attacker->location;
        $this->assertInstanceOf(Location::class, $attackerLocation);
        $this->assertEquals($data['attacker']['location']['x'], $attackerLocation->posX);
        $this->assertEquals($data['attacker']['location']['y'], $attackerLocation->posY);
        $this->assertEquals($data['attacker']['location']['z'], $attackerLocation->posZ);
        $this->assertEquals($data['attacker']['ranking'], $attacker->ranking);
        $this->assertEquals($data['attacker']['accountId'], $attacker->accountId);

        $attackerVehicle = $event->vehicle;
        $this->assertInstanceOf(Vehicle::class, $attackerVehicle);
        $this->assertEquals($data['vehicle']['vehicleType'], $attackerVehicle->vehicleType);
        $this->assertEquals($data['vehicle']['vehicleId'], $attackerVehicle->vehicleId);
        $this->assertEquals($data['vehicle']['healthPercent'], $attackerVehicle->healthPercent);
        $this->assertEquals($data['vehicle']['feulPercent'], $attackerVehicle->fuelPercent);

        $this->assertEquals($data['damageTypeCategory'], $event->damageTypeCategory);
        $this->assertEquals($data['damageCauserName'], $event->damageCauserName);
        $this->assertEquals($data['distance'], $event->distance);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogVehicleLeave $event
     * @param array           $data
     *
     * @since 1.3.0
     */
    private function assertEventLogVehicleLeave(LogVehicleLeave $event, array $data): void
    {
        $character = $event->character;
        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals($data['character']['name'], $character->name);
        $this->assertEquals($data['character']['teamId'], $character->teamId);
        $this->assertEquals($data['character']['health'], $character->health);

        $characterLocation = $character->location;
        $this->assertInstanceOf(Location::class, $characterLocation);
        $this->assertEquals($data['character']['location']['x'], $characterLocation->posX);
        $this->assertEquals($data['character']['location']['y'], $characterLocation->posY);
        $this->assertEquals($data['character']['location']['z'], $characterLocation->posZ);
        $this->assertEquals($data['character']['ranking'], $character->ranking);
        $this->assertEquals($data['character']['accountId'], $character->accountId);

        $attackerVehicle = $event->vehicle;
        $this->assertInstanceOf(Vehicle::class, $attackerVehicle);
        $this->assertEquals($data['vehicle']['vehicleType'], $attackerVehicle->vehicleType);
        $this->assertEquals($data['vehicle']['vehicleId'], $attackerVehicle->vehicleId);
        $this->assertEquals($data['vehicle']['healthPercent'], $attackerVehicle->healthPercent);
        $this->assertEquals($data['vehicle']['feulPercent'], $attackerVehicle->fuelPercent);

        $this->assertEquals($data['rideDistance'], $event->rideDistance);
        $this->assertEquals($data['seatIndex'], $event->seatIndex);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogVehicleRide $event
     * @param array          $data
     *
     * @since 1.3.0
     */
    private function assertEventLogVehicleRide(LogVehicleRide $event, array $data): void
    {
        $character = $event->character;
        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals($data['character']['name'], $character->name);
        $this->assertEquals($data['character']['teamId'], $character->teamId);
        $this->assertEquals($data['character']['health'], $character->health);

        $characterLocation = $character->location;
        $this->assertInstanceOf(Location::class, $characterLocation);
        $this->assertEquals($data['character']['location']['x'], $characterLocation->posX);
        $this->assertEquals($data['character']['location']['y'], $characterLocation->posY);
        $this->assertEquals($data['character']['location']['z'], $characterLocation->posZ);
        $this->assertEquals($data['character']['ranking'], $character->ranking);
        $this->assertEquals($data['character']['accountId'], $character->accountId);

        $attackerVehicle = $event->vehicle;
        $this->assertInstanceOf(Vehicle::class, $attackerVehicle);
        $this->assertEquals($data['vehicle']['vehicleType'], $attackerVehicle->vehicleType);
        $this->assertEquals($data['vehicle']['vehicleId'], $attackerVehicle->vehicleId);
        $this->assertEquals($data['vehicle']['healthPercent'], $attackerVehicle->healthPercent);
        $this->assertEquals($data['vehicle']['feulPercent'], $attackerVehicle->fuelPercent);

        $this->assertEquals($data['seatIndex'], $event->seatIndex);

        $common = $event->common;
        $this->assertInstanceOf(Common::class, $common);
        $this->assertEquals($data['common']['isGame'], $common->isGame);
        $this->assertInstanceOf(\DateTimeImmutable::class, $event->date);
        $this->assertEquals($data['_T'], $event->type);
    }

    /**
     * @param LogArmorDestroy $event
     * @param array           $data
     *
     * @since 1.5.0
     */
    private function assertEventLogArmorDestroy(LogArmorDestroy $event, array $data): void
    {
        $this->assertEquals($data['attackId'], $event->attackId);

        $attacker = $event->attacker;
        $this->assertInstanceOf(Character::class, $attacker);
        $this->assertEquals($data['attacker']['name'], $attacker->name);
        $this->assertEquals($data['attacker']['teamId'], $attacker->teamId);
        $this->assertEquals($data['attacker']['health'], $attacker->health);

        $attackerLocation = $attacker->location;
        $this->assertInstanceOf(Location::class, $attackerLocation);
        $this->assertEquals($data['attacker']['location']['x'], $attackerLocation->posX);
        $this->assertEquals($data['attacker']['location']['y'], $attackerLocation->posY);
        $this->assertEquals($data['attacker']['location']['z'], $attackerLocation->posZ);
        $this->assertEquals($data['attacker']['ranking'], $attacker->ranking);
        $this->assertEquals($data['attacker']['accountId'], $attacker->accountId);

        $victim = $event->victim;
        $this->assertInstanceOf(Character::class, $victim);
        $this->assertEquals($data['victim']['name'], $victim->name);
        $this->assertEquals($data['victim']['teamId'], $victim->teamId);
        $this->assertEquals($data['victim']['health'], $victim->health);

        $victimLocation = $victim->location;
        $this->assertInstanceOf(Location::class, $victimLocation);
        $this->assertEquals($data['victim']['location']['x'], $victimLocation->posX);
        $this->assertEquals($data['victim']['location']['y'], $victimLocation->posY);
        $this->assertEquals($data['victim']['location']['z'], $victimLocation->posZ);
        $this->assertEquals($data['victim']['ranking'], $victim->ranking);
        $this->assertEquals($data['victim']['accountId'], $victim->accountId);

        $this->assertEquals($data['damageTypeCategory'], $event->damageTypeCategory);
        $this->assertEquals($data['damageReason'], $event->damageReason);
        $this->assertEquals($data['damageCauserName'], $event->damageCauserName);

        $item = $event->item;
        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($data['item']['itemId'], $item->itemId);
        $this->assertEquals($data['item']['stackCount'], $item->stackCount);
        $this->assertEquals($data['item']['category'], $item->category);
        $this->assertEquals($data['item']['subCategory'], $item->subCategory);
        $this->assertEquals($data['item']['attachedItems'], $item->attachedItems);

        $this->assertEquals($data['distance'], $event->distance);
    }

    /**
     * @param LogPlayerMakeGroggy $event
     * @param array               $data
     *
     * @since 1.5.0
     */
    private function assertEventLogPlayerMakeGroggy(LogPlayerMakeGroggy $event, array $data): void
    {
        $this->assertEquals($data['attackId'], $event->attackId);

        $attacker = $event->attacker;
        $this->assertInstanceOf(Character::class, $attacker);
        $this->assertEquals($data['attacker']['name'], $attacker->name);
        $this->assertEquals($data['attacker']['teamId'], $attacker->teamId);
        $this->assertEquals($data['attacker']['health'], $attacker->health);

        $attackerLocation = $attacker->location;
        $this->assertInstanceOf(Location::class, $attackerLocation);
        $this->assertEquals($data['attacker']['location']['x'], $attackerLocation->posX);
        $this->assertEquals($data['attacker']['location']['y'], $attackerLocation->posY);
        $this->assertEquals($data['attacker']['location']['z'], $attackerLocation->posZ);
        $this->assertEquals($data['attacker']['ranking'], $attacker->ranking);
        $this->assertEquals($data['attacker']['accountId'], $attacker->accountId);

        $victim = $event->victim;
        $this->assertInstanceOf(Character::class, $victim);
        $this->assertEquals($data['victim']['name'], $victim->name);
        $this->assertEquals($data['victim']['teamId'], $victim->teamId);
        $this->assertEquals($data['victim']['health'], $victim->health);

        $victimLocation = $victim->location;
        $this->assertInstanceOf(Location::class, $victimLocation);
        $this->assertEquals($data['victim']['location']['x'], $victimLocation->posX);
        $this->assertEquals($data['victim']['location']['y'], $victimLocation->posY);
        $this->assertEquals($data['victim']['location']['z'], $victimLocation->posZ);
        $this->assertEquals($data['victim']['ranking'], $victim->ranking);
        $this->assertEquals($data['victim']['accountId'], $victim->accountId);

        $this->assertEquals($data['damageTypeCategory'], $event->damageTypeCategory);
        $this->assertEquals($data['damageCauserName'], $event->damageCauserName);
        $this->assertEquals($data['distance'], $event->distance);
        $this->assertEquals($data['isAttackerInVehicle'], $event->isAttackerInVehicle);
        $this->assertEquals($data['dBNOId'], $event->dBNOId);
    }

    /**
     * @param LogPlayerRevive $event
     * @param array           $data
     *
     * @since 1.5.0
     */
    private function assertEventLogPlayerRevive(LogPlayerRevive $event, array $data): void
    {
        $reviver = $event->reviver;
        $this->assertInstanceOf(Character::class, $reviver);
        $this->assertEquals($data['reviver']['name'], $reviver->name);
        $this->assertEquals($data['reviver']['teamId'], $reviver->teamId);
        $this->assertEquals($data['reviver']['health'], $reviver->health);

        $reviverLocation = $reviver->location;
        $this->assertInstanceOf(Location::class, $reviverLocation);
        $this->assertEquals($data['reviver']['location']['x'], $reviverLocation->posX);
        $this->assertEquals($data['reviver']['location']['y'], $reviverLocation->posY);
        $this->assertEquals($data['reviver']['location']['z'], $reviverLocation->posZ);
        $this->assertEquals($data['reviver']['ranking'], $reviver->ranking);
        $this->assertEquals($data['reviver']['accountId'], $reviver->accountId);

        $victim = $event->victim;
        $this->assertInstanceOf(Character::class, $victim);
        $this->assertEquals($data['victim']['name'], $victim->name);
        $this->assertEquals($data['victim']['teamId'], $victim->teamId);
        $this->assertEquals($data['victim']['health'], $victim->health);

        $victimLocation = $victim->location;
        $this->assertInstanceOf(Location::class, $victimLocation);
        $this->assertEquals($data['victim']['location']['x'], $victimLocation->posX);
        $this->assertEquals($data['victim']['location']['y'], $victimLocation->posY);
        $this->assertEquals($data['victim']['location']['z'], $victimLocation->posZ);
        $this->assertEquals($data['victim']['ranking'], $victim->ranking);
        $this->assertEquals($data['victim']['accountId'], $victim->accountId);
    }

    /**
     * @param LogSwimEnd $event
     * @param array      $data
     *
     * @since 1.5.0
     */
    private function assertEventLogSwimEnd(LogSwimEnd $event, array $data): void
    {
        $character = $event->character;
        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals($data['character']['name'], $character->name);
        $this->assertEquals($data['character']['teamId'], $character->teamId);
        $this->assertEquals($data['character']['health'], $character->health);

        $characterLocation = $character->location;
        $this->assertInstanceOf(Location::class, $characterLocation);
        $this->assertEquals($data['character']['location']['x'], $characterLocation->posX);
        $this->assertEquals($data['character']['location']['y'], $characterLocation->posY);
        $this->assertEquals($data['character']['location']['z'], $characterLocation->posZ);
        $this->assertEquals($data['character']['ranking'], $character->ranking);
        $this->assertEquals($data['character']['accountId'], $character->accountId);

        $this->assertEquals($data['swimDistance'], $event->swimDistance);
    }

    /**
     * @param LogSwimStart $event
     * @param array        $data
     *
     * @since 1.5.0
     */
    private function assertEventLogSwimStart(LogSwimStart $event, array $data): void
    {
        $character = $event->character;
        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals($data['character']['name'], $character->name);
        $this->assertEquals($data['character']['teamId'], $character->teamId);
        $this->assertEquals($data['character']['health'], $character->health);

        $characterLocation = $character->location;
        $this->assertInstanceOf(Location::class, $characterLocation);
        $this->assertEquals($data['character']['location']['x'], $characterLocation->posX);
        $this->assertEquals($data['character']['location']['y'], $characterLocation->posY);
        $this->assertEquals($data['character']['location']['z'], $characterLocation->posZ);
        $this->assertEquals($data['character']['ranking'], $character->ranking);
        $this->assertEquals($data['character']['accountId'], $character->accountId);
    }

    /**
     * @param LogWheelDestroy $event
     * @param array           $data
     *
     * @since 1.5.0
     */
    private function assertEventLogWheelDestroy(LogWheelDestroy $event, array $data): void
    {
        $this->assertEquals($data['attackId'], $event->attackId);

        $attacker = $event->attacker;
        $this->assertInstanceOf(Character::class, $attacker);
        $this->assertEquals($data['attacker']['name'], $attacker->name);
        $this->assertEquals($data['attacker']['teamId'], $attacker->teamId);
        $this->assertEquals($data['attacker']['health'], $attacker->health);

        $attackerLocation = $attacker->location;
        $this->assertInstanceOf(Location::class, $attackerLocation);
        $this->assertEquals($data['attacker']['location']['x'], $attackerLocation->posX);
        $this->assertEquals($data['attacker']['location']['y'], $attackerLocation->posY);
        $this->assertEquals($data['attacker']['location']['z'], $attackerLocation->posZ);
        $this->assertEquals($data['attacker']['ranking'], $attacker->ranking);
        $this->assertEquals($data['attacker']['accountId'], $attacker->accountId);

        $characterVehicle = $event->vehicle;
        $this->assertInstanceOf(Vehicle::class, $characterVehicle);
        $this->assertEquals($data['vehicle']['vehicleType'], $characterVehicle->vehicleType);
        $this->assertEquals($data['vehicle']['vehicleId'], $characterVehicle->vehicleId);
        $this->assertEquals($data['vehicle']['healthPercent'], $characterVehicle->healthPercent);
        $this->assertEquals($data['vehicle']['feulPercent'], $characterVehicle->fuelPercent);

        $this->assertEquals($data['damageTypeCategory'], $event->damageTypeCategory);
        $this->assertEquals($data['damageCauserName'], $event->damageCauserName);
    }

    /**
     * @param Samples $sample
     * @param array   $data
     *
     * @since 1.3.0
     */
    private function assertSample(Samples $sample, array $data): void
    {
        $this->assertInstanceOf(\Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\Data::class, $sample->data);

        $sampleData = $sample->data;
        $this->assertEquals($data['data']['type'], $sampleData->type);
        $this->assertEquals($data['data']['id'], $sampleData->id);
        $this->assertInstanceOf(SampleAttributes::class, $sampleData->attributes);
        $this->assertInstanceOf(SampleRelationships::class, $sampleData->relationships);

        $sampleDataAttributes = $sampleData->attributes;
        $this->assertInstanceOf(\DateTimeImmutable::class, $sampleDataAttributes->createdAt);
        $this->assertEquals($data['data']['attributes']['shardId'], $sampleDataAttributes->shardId);
        $this->assertEquals($data['data']['attributes']['titleId'], $sampleDataAttributes->titleId);

        $matchDataRelationships = $sampleData->relationships;
        $this->assertInstanceOf(\Lifeformwp\PHPPUBG\DTO\SamplesData\Sample\Relationships\Matches::class, $matchDataRelationships->matches);

        $match = $matchDataRelationships->matches->data[0];
        $this->assertInstanceOf(MatchType::class, $match);
        $this->assertEquals($data['data']['relationships']['matches']['data'][0]['type'], $match->type);
        $this->assertEquals($data['data']['relationships']['matches']['data'][0]['id'], $match->id);
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
     * @param int         $statusCode
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