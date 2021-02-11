<?php

namespace App\Services;

use Carbon\Carbon;
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
            'content-type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json'
        ];
    }

    /**
     * @param array $responseDates
     * @param array $data
     */
    protected function parseResponse(array $responseDates, array &$data)
    {
        $allDates = $responseDates[0];
        for ($i = 1; $i < count($allDates); $i++) {
            $dates = [];
            for ($j = 1; $j < count($responseDates); $j++) {
                if (isset($responseDates[$j][$i]['MinPrice'])) {
                    $dates[$responseDates[$j][0]['DateString']] = $responseDates[$j][$i]['MinPrice'];
                }
            }

            if (count($dates)) {
                if (isset($data[$allDates[$i]['DateString']])) {
                    $data[$allDates[$i]['DateString']]['dates'] = array_merge_recursive($data[$allDates[$i]['DateString']]['dates'], $dates);
                } else {
                    $data[$allDates[$i]['DateString']]['dates'] = $dates;
                }
            }
        }
    }

    /**
     * @param Carbon $startMonth
     * @param Carbon $endMonth
     * @param string $originCode
     * @param string $destinationCode
     * @return JsonResponse
     */
    public function getMonthData(Carbon $startMonth, Carbon $endMonth, string $originCode, string $destinationCode) : JsonResponse
    {
        $data = [];
        $requests = [];
        while ($startMonth <= $endMonth) {
            $requests[] = [
                'start' => $startMonth->format('Y-m'),
                'end' => $startMonth->format('Y-m')
            ];

            $requests[] = [
                'start' => $startMonth->format('Y-m'),
                'end' => $startMonth->addMonth()->format('Y-m')
            ];
        }

        foreach ($requests as $request) {
            $url = self::ENDPOINT . 'browsegrid/v1.0/EE/EUR/et-EE/' . $originCode . '/' . $destinationCode . '/' . $request['start'] . '/' . $request['end'];
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
                    $res = json_decode($response, true);
                    $dates = $res['Dates'];
                    $this->parseResponse($dates, $data);
                }

            } catch (ClientException $e) {
                return response()->json(null, 403);
            } catch (\Exception $e) {
                return response()->json(null, 400);
            }
        }

        $response = [];
        if ($data) {
            foreach ($data as $dateString => $values) {
                $data[$dateString]['price'] = min($values['dates']);
            }

            $activeDate = array_key_first($data);
            /*$minPrice = (int) $data[$activeDate]['price'];
            foreach ($data as $dateString => $values) {
                if ($activeDate !== $dateString) {
                    if ($minPrice > (int) $data[$dateString]['price']) {
                        $minPrice = (int) $data[$dateString]['price'];
                        $activeDate = $dateString;
                    }
                }
            }*/

            $response['activeDate'] = $activeDate;
            $response['data'] = $data;
        }

        return response()->json($response);
    }

    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param string $originCode
     * @param string $destinationCode
     * @return bool|string
     */
    protected function createSessionRequest(Carbon $startDate, Carbon $endDate, string $originCode, string $destinationCode)
    {
        $params = [
            'cabinclass' => 'Economy',
            'country' => 'EE',
            'currency' => 'EUR',
            'locale' => 'et-EE',
            'locationSchema' => 'iata',
            'originplace' => $originCode,
            'destinationplace' => $destinationCode,
            'outbounddate' => $startDate->format('Y-m-d'),
            'inbounddate' => $endDate->format('Y-m-d'),
            'adults' => 1,
            'children' => 0,
            'infants' => 0,
            'apiKey' => env('FLIGHTCALENDAR_API_KEY')
        ];

        $url = self::ENDPOINT . 'pricing/v1.0';
        try {
            $request = $this->http->post($url, [
                'headers'         => $this->headers,
                'timeout'         => 30,
                'connect_timeout' => true,
                'http_errors'     => true,
                'form_params'     => $params
            ]);

            $header = $request ? $request->getHeader('Location') : null;
            $status = $request ? $request->getStatusCode() : 500;

            if ($header && isset($header[0]) && $status === 201) {
                return $header[0];
            }

        } catch (ClientException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }

    /**
     * @param string $locationUrl
     * @return array|false
     */
    private function _requestBookingDetailsData(string $locationUrl)
    {
        $url = $locationUrl . '?apiKey=' .env('FLIGHTCALENDAR_API_KEY') . '&sortType=price&sortOrder=asc';
        try {
            $request = $this->http->get($url, [
                'headers'         => $this->headers,
                'timeout'         => 30,
                'connect_timeout' => true,
                'http_errors'     => true
            ]);

            $response = $request ? $request->getBody()->getContents() : null;
            $status = $request ? $request->getStatusCode() : 500;

            if ($response && $status === 200) {
                $result = json_decode($response, true);
                if ($result['Status'] === 'UpdatesComplete') {
                    if (!isset($result['Itineraries'][0])) {
                        return false;
                    }

                    $itinerary = $result['Itineraries'][0];
                    return [
                        'url' => $itinerary['BookingDetailsLink']['Uri'],
                        'body' => $itinerary['BookingDetailsLink']['Body']
                    ];
                } else {
                    return $this->_requestBookingDetailsData($locationUrl);
                }
            } else return false;

        } catch (ClientException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param string $locationUrl
     * @return array|false
     */
    protected function getBookingDetailsData(string $locationUrl)
    {
        return $this->_requestBookingDetailsData($locationUrl);
    }

    /**
     * @param array $bookingDetailsData
     * @return false|string
     */
    protected function getBookingDetailsUrl(array $bookingDetailsData)
    {
        $url = str_replace('/apiservices/', '', self::ENDPOINT);
        $url = $url . $bookingDetailsData['url'];
        $url .= '?apiKey=' .env('FLIGHTCALENDAR_API_KEY');
        $body = $bookingDetailsData['body'];

        try {
            $request = $this->http->put($url, [
                'headers'         => $this->headers,
                'timeout'         => 30,
                'connect_timeout' => true,
                'http_errors'     => true,
                'body'            => $body
            ]);

            $header = $request ? $request->getHeader('Location') : null;
            $status = $request ? $request->getStatusCode() : 500;

            if ($header && $header[0] && $status === 201) {
                return $header[0];
            }

        } catch (ClientException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }

    /**
     * @param string $bookingDetailsUrl
     * @return false|string
     */
    protected function getBookingOptions(string $bookingDetailsUrl)
    {
        $url = $bookingDetailsUrl . '?apiKey=' .env('FLIGHTCALENDAR_API_KEY');
        try {
            $request = $this->http->get($url, [
                'headers'         => $this->headers,
                'timeout'         => 30,
                'connect_timeout' => true,
                'http_errors'     => true
            ]);

            $response = $request ? $request->getBody()->getContents() : null;
            $status = $request ? $request->getStatusCode() : 500;

            if ($response && $status === 200) {
                $result = json_decode($response, true);
                return $result['BookingOptions'][0]['BookingItems'][0]['Price'];
            }

        } catch (ClientException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }

    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param string $originCode
     * @param string $destinationCode
     * @return JsonResponse
     */
    public function getLivePrice(Carbon $startDate, Carbon $endDate, string $originCode, string $destinationCode): JsonResponse
    {
        $locationUrl = $this->createSessionRequest($startDate, $endDate, $originCode, $destinationCode);
        if ($locationUrl) {
            $bookingDetailsData = $this->getBookingDetailsData($locationUrl);
            if ($bookingDetailsData) {
                $url = $this->getBookingDetailsUrl($bookingDetailsData);
                if ($url) {
                    $price = $this->getBookingOptions($url);
                    if ($price) {
                        return response()->json($price);
                    }
                }
            }
        }

        return response()->json(false, 400);
    }
}