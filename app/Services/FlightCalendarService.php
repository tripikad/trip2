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
     * @param string $startMonth
     * @param string $endMonth
     * @param string $startCode
     * @param string $endCode
     * @return JsonResponse
     */
    public function getMonthData(string $startMonth, string $endMonth, string $startCode, string $endCode) : JsonResponse
    {
        $url = self::ENDPOINT . 'browsequotes/v1.0/EE/EUR/ET/' . $startCode . '/' . $endCode . '/' . $startMonth . '/' . $endMonth;
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
                //$res = json_decode($response, true);

                return response()->json([
                    'activeDate' => '2021-02-07',
                    'data' => [
                        '2021-01-28' => [
                            'price' => 234,
                            'dates' => [
                                '2021-02-01' => 233,
                                '2021-02-05' => 245,
                                '2021-02-07' => 255,
                            ]
                        ],
                        '2021-02-04' => [
                            'price' => 223,
                            'dates' => [
                                '2021-02-06' => 233,
                                '2021-02-08' => 245,
                                '2021-02-12' => 223,
                            ]
                        ],
                        '2021-02-05' => [
                            'price' => 255,
                            'dates' => [
                                '2021-02-07' => 255,
                                '2021-02-08' => 245,
                                '2021-02-13' => 223,
                            ]
                        ],
                        '2021-02-07' => [
                            'price' => 212,
                            'dates' => [
                                '2021-02-11' => 278,
                                '2021-02-12' => 245,
                                '2021-02-21' => 212,
                                '2021-02-26' => 267,
                            ]
                        ],
                        '2021-02-19' => [
                            'price' => 321,
                            'dates' => [
                                '2021-02-24' => 278,
                                '2021-03-03' => 378,
                                '2021-03-08' => 345,
                                '2021-03-12' => 321,
                            ]
                        ],
                        '2021-04-14' => [
                            'price' => 223,
                            'dates' => [
                                '2021-04-17' => 233,
                                '2021-04-20' => 245,
                                '2021-04-29' => 223,
                            ]
                        ],
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