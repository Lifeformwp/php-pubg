<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Manager
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG
 */
final class Manager
{
    public const BASE_URL = 'https://api.playbattlegrounds.com/';

    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var string
     */
    private $token;

    /**
     * Manager constructor.
     * @param ClientInterface $client
     * @param string $token
     */
    public function __construct(ClientInterface $client, string $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    /**
     * @param string $shard
     * @param string $matchId
     *
     * @return array
     * @throws ManagerException
     */
    public function getMatch(string $shard, string $matchId): array
    {
        $url = self::BASE_URL . 'shards/' . $shard . '/matches/' . $matchId;

        try {
            $response = $this->client
                ->request('get',
                    $url,
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $this->token,
                            'Accept' => 'application/vnd.api+json'
                        ]
                    ]);

            return $this->processResponse($response);
        } catch (\Throwable $throwable) {
            throw new ManagerException($throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * @param string $shard
     * @param array $matchesIds
     *
     * @return array
     */
    public function getMatches(string $shard, array $matchesIds): array
    {
        $matchesData = [];

        foreach ($matchesIds as $id) {
            $matchesData[$id] = $this->getMatch($shard, $id);
        }

        return $matchesData;
    }

    /**
     * @param string $shard
     * @param array|null $playerNames
     * @param array|null $playerIds
     *
     * @return array
     * @throws ManagerException
     */
    public function getPlayers(string $shard, ?array $playerNames = [], ?array $playerIds = []): array
    {
        $names = '';
        $ids = '';
        $url = self::BASE_URL . 'shards/' . $shard . '/players';

        if (!empty($playerNames)) {
            $names = \implode(',', $playerNames);
        }

        if (!empty($playerIds)) {
            $ids = \implode(',', $playerIds);
        }

        try {
            $response = $this->client
                ->request('get',
                    $url,
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $this->token,
                            'Accept' => 'application/vnd.api+json'
                        ],
                        'query' => [
                            'filter' => [
                                'playerNames' => $names,
                                'playerIds' => $ids
                            ]
                        ]
                    ]);

            return $this->processResponse($response);
        } catch (\Throwable $throwable) {
            throw new ManagerException($throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * @param string $telemetryUrl
     *
     * @return array
     * @throws ManagerException
     */
    public function getTelemetry(string $telemetryUrl): array
    {
        try {
            $response = $this->client
                ->request('get',
                    $telemetryUrl,
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $this->token,
                            'Accept' => 'application/vnd.api+json'
                        ]
                    ]);

            return $this->processResponse($response);
        } catch (\Throwable $throwable) {
            throw new ManagerException($throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * @return array
     * @throws ManagerException
     */
    public function getStatus(): array
    {
        $url = self::BASE_URL . 'status';

        try {
            $response = $this->client
                ->request('get',
                    $url,
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $this->token,
                            'Accept' => 'application/vnd.api+json'
                        ]
                    ]);

            return $this->processResponse($response);
        } catch (\Throwable $throwable) {
            throw new ManagerException($throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     * @throws ManagerException
     */
    private function processResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() === 500) {
            throw new ManagerException('PUBG Developer API returned 500 status code', 500);
        }

        if (\in_array($response->getStatusCode(), [401, 404, 415])) {
            $error = \json_decode($response->getBody()->getContents(), true);
            throw new ManagerException($error['errors']);
        }

        if ($response->getStatusCode() === 429) {
            throw new ManagerException('Too many requests, 429 status code', 429);
        }

        return \json_decode($response->getBody()->getContents(), true);
    }
}