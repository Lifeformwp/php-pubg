<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG;

use GuzzleHttp\ClientInterface;
use Lifeformwp\PHPPUBG\DTO\DTOInterface;
use Lifeformwp\PHPPUBG\Provider\MatchDTOProvider;
use Lifeformwp\PHPPUBG\Provider\PlayerDTOProvider;
use Lifeformwp\PHPPUBG\Provider\PlayersDTOProvider;
use Lifeformwp\PHPPUBG\Provider\StatusDTOProvider;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PUBGManager
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG
 * @since 1.0.0
 */
class PUBGManager
{
    private const BASE_URL = 'https://api.playbattlegrounds.com/';
    public const HYDRATE_MATCH = MatchDTOProvider::class;
    public const HYDRATE_PLAYERS = PlayersDTOProvider::class;
    public const HYDRATE_PLAYER = PlayerDTOProvider::class;
    public const HYDRATE_STATUS = StatusDTOProvider::class;

    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var string
     */
    private $token;

    /**
     * PUBGManager constructor.
     *
     * @param ClientInterface $client
     * @param string $token
     */
    public function __construct(ClientInterface $client, string $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    /**
     * @param ClientInterface $client
     *
     * @return PUBGManager
     * @since 1.1.0
     */
    public function setClient(ClientInterface $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @param string $token
     *
     * @return PUBGManager
     * @since 1.1.0
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param string $shard
     * @param string $matchId
     *
     * @return array
     * @throws PUBGManagerException
     * @since 1.0.0
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
            throw new PUBGManagerException($throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * @param string $shard
     * @param array $matchesIds
     *
     * @return array
     * @since 1.0.0
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
     * @param string $matchId
     *
     * @return array
     * @since 1.1.0
     */
    public function getTelemetryByMatch(string $shard, string $matchId): array
    {
        $match = $this->getMatch($shard, $matchId);
        $telemetryLink = $this->getTelemetryLink($match);

        return $this->getTelemetry($telemetryLink);
    }

    /**
     * @param array $data
     *
     * @return string
     * @since 1.1.0
     */
    private function getTelemetryLink(array $data): string
    {
        $link = '';

        foreach ($data['included'] as $item) {
            if ($item['type'] === 'asset') {
                $link = $item['attributes']['URL'];
                break;
            }
        }

        return $link;
    }

    /**
     * @param string $shard
     * @param array|null $playerNames
     * @param array|null $playerIds
     *
     * @return array
     * @throws PUBGManagerException
     * @since 1.0.0
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
            throw new PUBGManagerException($throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * @param string $shard
     * @param string $player
     *
     * @return array
     * @throws PUBGManagerException
     * @since 1.1.0
     */
    public function getPlayer(string $shard, string $player): array
    {
        $url = self::BASE_URL . 'shards/' . $shard . '/players/' . $player;

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
            throw new PUBGManagerException($throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * @param string $telemetryUrl
     *
     * @return array
     * @throws PUBGManagerException
     * @since 1.0.0
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
            throw new PUBGManagerException($throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * @return array
     * @throws PUBGManagerException
     * @since 1.0.0
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
            throw new PUBGManagerException($throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * @param array $data
     * @param string $type
     *
     * @return DTOInterface
     * @since 1.1.0
     */
    public function hydrate(array $data, string $type): DTOInterface
    {
        $hydration = new $type;

        return $hydration->process($data);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     * @throws PUBGManagerException
     * @since 1.0.0
     */
    private function processResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() === 500) {
            throw new PUBGManagerException('PUBG Developer API returned 500 status code', 500);
        }

        if (\in_array($response->getStatusCode(), [401, 404, 415])) {
            $error = \json_decode($response->getBody()->getContents(), true);
            throw new PUBGManagerException($error['errors']);
        }

        if ($response->getStatusCode() === 429) {
            throw new PUBGManagerException('Too many requests, 429 status code', 429);
        }

        return \json_decode($response->getBody()->getContents(), true);
    }
}