<?php

namespace Ksenia\Geocoding;
use \GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Ksenia\Geocoding\Exception\EmptyArgumentsException;

class Geocoding
{
    protected $apiKey;
    protected $language;
    public function __construct()
    {
        $this->apiKey = config('geocoding.key');
        $this->language = config('geocoding.language');
    }
    

    public function Geocode($address,$language=null)
    {
        if (empty($address)) {
            throw new EmptyArgumentsException('Empty arguments.');
        }
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
        if (Cache::has(http_build_query($params))) {
            return new GoogleResponse(Cache::get(http_build_query($params)));
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
                    return "ZERO_RESULTS";
                case "OVER_QUERY_LIMIT": # indicates that you are over your quota.
                    return "OVER_QUERY_LIMIT";
                case "REQUEST_DENIED": # indicates that your request was denied.
                    return "REQUEST_DENIED";
                case "INVALID_REQUEST": # generally indicates that the query (address, components or latlng) is missing.
                    return "INVALID_REQUEST";
                case "UNKNOWN_ERROR":
                    return "UNKNOWN_ERROR";
                case "OK": # indicates that no errors occurred; the address was successfully parsed and at least one geocode was returned.
                    Cache::forever(http_build_query($params),$response);
                    return new GoogleResponse($response);
            }
        }


    }

    public function Reverse($lat, $lng, $language=null)
    {
        if (empty($lat) || empty($lng)) {
            throw new EmptyArgumentsException('Empty arguments.');
        }
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
        if (Cache::has(http_build_query($params))){
            return new GoogleResponse(Cache::get(http_build_query($params)));
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
                    return "ZERO_RESULTS";
                case "OVER_QUERY_LIMIT": # indicates that you are over your quota.
                    return "OVER_QUERY_LIMIT";
                case "REQUEST_DENIED": # indicates that your request was denied.
                    return "REQUEST_DENIED";
                case "INVALID_REQUEST": # generally indicates that the query (address, components or latlng) is missing.
                    return "INVALID_REQUEST";
                case "UNKNOWN_ERROR":
                    return "UNKNOWN_ERROR";

                case "OK": # indicates that no errors occurred; the address was successfully parsed and at least one geocode was returned.
                    Cache::forever(http_build_query($params), $response);
                    return new GoogleResponse($response);
            }
        }

    }





}
