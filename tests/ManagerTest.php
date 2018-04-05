<?php declare(strict_types=1);

namespace Lifeformwp\PHPPUBG\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Lifeformwp\PHPPUBG\Manager;
use PHPUnit\Framework\TestCase;

/**
 * Class ManagerTest
 *
 * @author Serhii Kondratiuk <vielon.indie@gmail.com>
 * @package Lifeformwp\PHPPUBG\Tests
 */
class ManagerTest extends TestCase
{
    public function testGetMatch(): void
    {
        $token = 'token';
        $data = [
            'some data'
        ];

        $client = $this->mockClient($data, 200);
        $manager = new Manager($client, $token);
        $match = $manager->getMatch('testShard', 'testMatchId');
        $this->assertEquals($data, $match);
    }

    public function testGetPlayers(): void
    {
        $token = 'token';
        $data = [
            'some data'
        ];

        $client = $this->mockClient($data, 200);
        $manager = new Manager($client, $token);
        $match = $manager->getPlayers('testShard');
        $this->assertEquals($data, $match);
    }

    public function testGetTelemetry(): void
    {
        $token = 'token';
        $data = [
            'some data'
        ];

        $client = $this->mockClient($data, 200);
        $manager = new Manager($client, $token);
        $match = $manager->getTelemetry('link');
        $this->assertEquals($data, $match);
    }

    /**
     * @param array|null $responseBody
     * @param int $statusCode
     * @return Client
     */
    private function mockClient(?array $responseBody, int $statusCode): Client
    {
        $mock = new MockHandler(
            [
                new Response($statusCode, ['Content-Type' => 'application/json'],
                    $responseBody ? \json_encode($responseBody) : $responseBody),
            ]
        );

        $handler = HandlerStack::create($mock);

        return new Client(['handler' => $handler]);
    }
}