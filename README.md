PHPPUBG - wrapper for PUBG Developer API
=======================

Wrapper for PUBG API with DTO (Matches, Player/Players, Status), full test coverage, PHP 7.1, etc. There are numerous improvements planned in future, you can read about them in WIP section.

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
$class = new \Lifeformwp\PHPPUBG\Manager($client, 'token');

$data = $class->getMatch('pc-eu', 'abe08f7e-3add-4fd6-9bcd-4aff88fc7adf'); //return array
$matchObject = $class->hydrate($data, \Lifeformwp\PHPPUBG\Manager::HYDRATE_MATCH); //returns Lifeformwp\PHPPUBG\DTO\Match object
```

Available methods
============

* getMatch([string, required]shard, [string, required]matchId) - returns array of data about match
* getMatches([string, required]shard, [array, required]matchesIds) - returns array of arrays about matches
* getPlayers([string, required]shard, [array, not required]playerNames, [array, not required]playerIds) - returns array of data about players
* getPlayer([string, required]shard, [string, required]playerId) - returns array of data about player
* getTelemetry([string, required]shard, [string, required]matchId) - returns array of telemetry data from the match
* getTelemetryByMatch([string, required]telemetryUrl) - returns array of data according to given telemetry url
* getStatus() - returns array of data about API status
* setClient([ClientInterface, required]client)
* setToken([string, required]token)
* hydrate([array, required]data, [string, required]type) - returns object from given array, possible types are: HYDRATE_MATCH, HYDRATE_PLAYERS, HYDRATE_PLAYER and HYDRATE_STATUS

WIP
============

* DTO for Telemetry
* Proper tests
* Documentation
* More flexible behaviour