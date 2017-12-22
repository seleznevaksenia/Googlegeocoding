<?php

namespace Ksenia\Geocoding;
use \GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Ksenia\Geocoding\Exception\EmptyArgumentsException;
use function MongoDB\BSON\toJSON;

class Geocoding
{
    protected $apiKey;
    protected $language;
    public function __construct()
    {
        $this->apiKey = config('geocoding.key');
        $this->language = config('geocoding.language');
    }
    

    public function Geocode($address,$language = null)
    {
        $params ['address'] =  $address;
        if (!empty($this->apiKey)) {
            $params['key'] = $this->apiKey;
        }
        if($language != null){
            $params['language'] = $language;
        }
        else if (!empty($this->language)) {
            $params['language'] = $this->language;
        }
        if (Redis::get(http_build_query($params)) != null) {
            $response = new GoogleResponse(json_decode(Redis::get(http_build_query($params))));
            return $response;
        }
        else{
            $client = new \GuzzleHttp\Client();
            $response = json_decode($client->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'query' => $params
            ])->getBody());
            # check for status in the response
            switch( $response->status )
            {
                case "ZERO_RESULTS": # indicates that the geocode was successful but returned no results. This may occur if the geocoder was passed a non-existent address.
                    return $response->status;
                case "OVER_QUERY_LIMIT": # indicates that you are over your quota.
                    return $response->status;
                case "REQUEST_DENIED": # indicates that your request was denied.
                    return $response->status;
                case "INVALID_REQUEST": # generally indicates that the query (address, components or latlng) is missing.
                    return $response->status;
                case "UNKNOWN_ERROR":
                    return $response->status;
                case "OK": # indicates that no errors occurred; the address was successfully parsed and at least one geocode was returned.
                   $responseForClient = new GoogleResponse($response);
                    Redis::set(http_build_query($params),json_encode($response));
                    return $responseForClient;
            }
        }


    }

    public function Reverse($lat, $lng, $language = null)
    {
        $params = ['latlng' => $lat . ',' . $lng];
        if (!empty($this->key)) {
            $params['key'] = $this->key;
        }
        if($language != null){
            $params['language'] = $language;
        }
        else if (!empty($this->language)) {
            $params['language'] = $this->language;
        }
        if (Redis::get(http_build_query($params)) != null) {
            $response = new GoogleResponse(json_decode(Redis::get(http_build_query($params))));
            return $response;
        }
        else{
            $client = new \GuzzleHttp\Client();
            $response = json_decode($client->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'query' => $params
            ])->getBody());
            # check for status in the response
            switch( $response->status )
            {

                case "ZERO_RESULTS": # indicates that the geocode was successful but returned no results. This may occur if the geocoder was passed a non-existent address.
                    return $response->status;
                case "OVER_QUERY_LIMIT": # indicates that you are over your quota.
                    return $response->status;
                case "REQUEST_DENIED": # indicates that your request was denied.
                    return $response->status;
                case "INVALID_REQUEST": # generally indicates that the query (address, components or latlng) is missing.
                    return $response->status;
                case "UNKNOWN_ERROR":
                    return $response->status;
                case "OK": # indicates that no errors occurred; the address was successfully parsed and at least one geocode was returned.
                    Redis::set(http_build_query($params),json_encode($response));
                    return new GoogleResponse($response);
            }
        }

    }





}
