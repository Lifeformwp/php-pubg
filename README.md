PHPPUBG - wrapper for PUBG Developer API
=======================
[![Total Downloads](https://poser.pugx.org/lifeformwp/php-pubg/downloads)](https://packagist.org/packages/lifeformwp/php-pubg)

Wrapper for PUBG API with DTO (Matches, Player/Players, Status, Telemetry, Samples), full test coverage, PHP 7.1, etc.

Requirements
============

* PHP >= 7.1

Installation
============

* run `composer require lifeformwp/php-pubg`

Basic usage
============

```
$client = new GuzzleHttp\Client();
$class = new \Lifeformwp\PHPPUBG\PUBGManager($client, 'token');

$data = $class->getMatch('pc-eu', 'abe08f7e-3add-4fd6-9bcd-4aff88fc7adf'); //returns array
$matchObject = $class->hydrate($data, \Lifeformwp\PHPPUBG\PUBGManager::HYDRATE_MATCH); //returns Lifeformwp\PHPPUBG\DTO\Match object
```

Available methods
============

* getMatch([string, required]shard, [string, required]matchId) - returns array of data about match
* getPlayers([string, required]shard, [array, not required]playerNames, [array, not required]playerIds) - returns array of data about players
* getPlayer([string, required]shard, [string, required]playerId) - returns array of data about player
* getTelemetry([string, required]shard, [string, required]matchId) - returns array of telemetry data from the match
* getStatus() - returns array of data about API status
* getSamples([string, required]shard) - returns array of sample data
* getSeasons([string, required]shard) - returns array of seasons data
* getSeasonDataForPlayer([string, required]shard, [string, required]playerId, [string, required]seasonId) - returns array of season data for player
* getTournaments() - returns array of data about tournaments
* getTournament([string, required]tournamentId) - returns array of data about tournament

* getMatches([string, required]shard, [array, required]matchesIds) - returns array of arrays about matches
* getTelemetryByMatch([string, required]telemetryUrl) - returns array of data according to given telemetry url
* setClient([ClientInterface, required]client)
* setToken([string, required]token)

* hydrate([array, required]data, [string, required]type) - returns object from given array, possible values for type parameter are: HYDRATE_MATCH, HYDRATE_PLAYERS, HYDRATE_PLAYER, HYDRATE_STATUS, HYDRATE_TELEMETRY and HYDRATE_SAMPLES

WIP
============

* Documentation
* More flexible behaviour
