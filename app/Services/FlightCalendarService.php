<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;

class FlightCalendarService
{
    const ENDPOINT = 'https://partners.api.skyscanner.net/apiservices/';

    protected Client $http;
    protected array $headers;

    public function __construct(Client $client)
    {
        $this->http = $client;
        $this->headers = [
            'cache-control' => 'no-cache',
            'content-type' => 'application/x-www-form-urlencoded'
        ];
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $startCode
     * @param string $endCode
     * @return JsonResponse
     */
    public function getMonthData(string $startDate, string $endDate, string $startCode, string $endCode) : JsonResponse
    {
        $url = self::ENDPOINT . 'browsequotes/v1.0/EE/EUR/ET/' . $startCode . '/' . $endCode . '/' . $startDate . '/' . $endDate;
        $url .= '/?apiKey=' .env('FLIGHTCALENDAR_API_KEY');

        try {
            $request = $this->http->get($url, [
                'headers'         => $this->headers,
                'timeout'         => 30,
                'connect_timeout' => true,
                'http_errors'     => true,
            ]);

            $response = $request ? $request->getBody()->getContents() : null;
            $status = $request ? $request->getStatusCode() : 500;

            if ($response && $status === 200) {
                //$res = json_decode($response);

                return response()->json([
                    'status' => 'success',
                    'items' => [
                        '2021-01-10' => 142,
                        '2021-01-11' => 455,
                        '2021-01-17' => 275,
                    ]
                ]);
            }

            return response()->json([], 400);
        } catch (ClientException $e) {
            return response()->json([], 403);
        } catch (\Exception $e) {
            return response()->json([], 400);
        }
    }
}