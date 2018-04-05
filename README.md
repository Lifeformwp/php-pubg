PHPPUBG - facade for PUBG Developer API
=======================

This is just basic (for now) implementation of facade for PUBG API. There are numerous improvements planned in future, you can read about them in WIP section.

Requirements
============

* PHP >= 7.1

Basic usage
============

* getMatch([string, required]shard, [string, required]matchId) - returns array of data about match
* getMatches([string, required]shard, [array, required]matchesIds) - returns array of arrays about matches
* getPlayers([string, required]shard, [array, not required]playerNames, [array, not required]playerIds) - returns array of data about players
* getTelemetry([string, required]telemetryUrl) - returns array of data according to given telemetry url
* getStatus() - returns array of data about API status

WIP
============

* DTO
* Proper tests
* Documentation
* More flexible behaviour