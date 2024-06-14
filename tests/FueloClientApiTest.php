<?php

use PHPUnit\Framework\TestCase;
use Abaev\Fuelo\FueloClientApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class FueloClientApiTest extends TestCase
{
    protected $apiKey = 'testApiKey';
    protected $mockClient;
    protected $fueloClientApi;

    protected function setUp(): void
    {
        $this->mockClient = $this->createMock(Client::class);
        $this->fueloClientApi = new FueloClientApi($this->apiKey);

        // Using reflection to set the client
        $reflection = new \ReflectionClass($this->fueloClientApi);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($this->fueloClientApi, $this->mockClient);
    }

    public function testGetPrice()
    {
        $expectedResponse = [
            'price' => 1.23,
            'date' => '2024-01-01'
        ];

        $this->mockClient->method('get')
            ->with('price', [
                'query' => [
                    'key' => $this->apiKey,
                    'fuel' => 'diesel',
                    'date' => '2024-01-01'
                ]
            ])
            ->willReturn(new Response(200, [], json_encode($expectedResponse)));

        $response = $this->fueloClientApi->getPrice('diesel', '2024-01-01');
        $this->assertEquals($expectedResponse, $response);

    }

    public function testGetGasStation()
    {
        $expectedResponse = [
            'id' => 1,
            'name' => 'Station 1'
        ];

        $this->mockClient->method('get')
            ->with('gasstation', [
                'query' => [
                    'key' => $this->apiKey,
                    'id' => 1
                ]
            ])
            ->willReturn(new Response(200, [], json_encode($expectedResponse)));

        $response = $this->fueloClientApi->getGasStation(1);
        $this->assertEquals($expectedResponse, $response);
    }

    public function testGetGasStations()
    {
        $expectedResponse = [
            ['id' => 1, 'name' => 'Station 1'],
            ['id' => 2, 'name' => 'Station 2']
        ];

        $this->mockClient->method('get')
            ->with('gasstations', [
                'query' => [
                    'key' => $this->apiKey,
                    'brand_id' => 1,
                    'fuel' => 'diesel'
                ]
            ])
            ->willReturn(new Response(200, [], json_encode($expectedResponse)));

        $response = $this->fueloClientApi->getGasStations(1, 'diesel');
        $this->assertEquals($expectedResponse, $response);
    }

    public function testGetNearbyGasStations()
    {
        $expectedResponse = [
            ['id' => 1, 'name' => 'Station 1'],
            ['id' => 2, 'name' => 'Station 2']
        ];

        $this->mockClient->method('get')
            ->with('near', [
                'query' => [
                    'key' => $this->apiKey,
                    'lat' => 42.0,
                    'lon' => 21.0,
                    'limit' => 5,
                    'distance' => 10,
                    'fuel' => 'diesel'
                ]
            ])
            ->willReturn(new Response(200, [], json_encode($expectedResponse)));

        $response = $this->fueloClientApi->getNearbyGasStations(42.0, 21.0, 5, 10, 'diesel');
        $this->assertEquals($expectedResponse, $response);
    }

    public function testGetNews()
    {
        $expectedResponse = [
            ['id' => 1, 'title' => 'News 1'],
            ['id' => 2, 'title' => 'News 2']
        ];

        $this->mockClient->method('get')
            ->with('news', [
                'query' => [
                    'key' => $this->apiKey,
                    'count' => 2,
                    'fuel' => 'diesel'
                ]
            ])
            ->willReturn(new Response(200, [], json_encode($expectedResponse)));

        $response = $this->fueloClientApi->getNews(2, 'diesel');
        $this->assertEquals($expectedResponse, $response);
    }
}    
