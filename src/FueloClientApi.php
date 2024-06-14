<?php 

namespace Abaev\Fuelo;

use GuzzleHttp\Client;

class FueloClientApi
{
    const HTTp_API_BASE_URL = 'http://fuelo.net/api/';

    protected $client;

    public function __construct(protected $apiKey)
    {
        $this->client = new Client(['base_uri' => self::HTTp_API_BASE_URL]);
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    public function getPrice($fuel, $date)
    {
        $response = $this->client->get('price', [
            'query' => [
                'key' => $this->apiKey,
                'fuel' => $fuel,
                'date' => $date
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getGasStation($id)
    {
        $response = $this->client->get('gasstation', [
            'query' => [
                'key' => $this->apiKey,
                'id' => $id
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getGasStations($brandId, $fuel)
    {
        $response = $this->client->get('gasstations', [
            'query' => [
                'key' => $this->apiKey,
                'brand_id' => $brandId,
                'fuel' => $fuel
            ]

        ]);
        return json_decode($response->getBody(), true);
    }

    public function getNearbyGasStations($lat, $lon, $limit, $distance, $fuel)
    {
        $response = $this->client->get('near', [
            'query' => [
                'key' => $this->apiKey,
                'lat' => $lat,
                'lon' => $lon,
                'limit' => $limit,
                'distance' => $distance,
                'fuel' => $fuel
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getNews($count, $fuel)
    {
        $response = $this->client->get('news', [
            'query' => [
                'key' => $this->apiKey,
                'count' => $count,
                'fuel' => $fuel
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
