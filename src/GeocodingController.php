<?php

namespace Ksenia\Geocoding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ksenia\Geocoding\Facade\GeocodingFacade;

class GeocodingController extends Controller
{
    public function coords(Request $request)
    {
        $validatedData = $request->validate([
            'address' => 'required',
            'language' => 'nullable|string',
        ]);
        $response = GeocodingFacade::Geocode($request->input('address'), $request->input('language'));
        if (is_object($response)) {
            if ($request->input('formatted')) {
                return response([
                    'longitude' => $response->longitude(),
                    'latitude' => $response->latitude(),
                    'formattedAddress' => $response->formattedAddress()
                ], 200);
            } else {
                return response([
                    'longitude' => $response->longitude(),
                    'latitude' => $response->latitude(),
                    'formattedAddress' => null
                ], 200);
            }
        } elseif (is_string($response)) {
            return response()->json(["message" => [$response], "errors" => ["Error 1" => [$response]]], 500);
        };
    }

    public function address(Request $request)
    {
        $validatedData = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'language' => 'nullable|string',
        ]);
        $response = GeocodingFacade::Reverse($request->input('latitude'), $request->input('longitude'),
            $request->input('language'));
        if (is_object($response)) {
            if (request()->input('postalCode')) {
                return response([
                    'postalCode' => $response->postalCode(),
                    'formattedAddress' => $response->formattedAddress()
                ]);
            } else {
                return response([
                    'formattedAddress' => $response->formattedAddress()
                ]);
            }
        } elseif (is_string($response)) {
            return response()->json(["message" => [$response], "errors" => ["Error 1" => [$response]]], 500);
        }
    }
}
