<?php
namespace Ksenia\Geocoding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ksenia\Geocoding\Facade\GeocodingFacade;

class GeocodingController extends Controller
{
    public function coords()
    {
        $response = GeocodingFacade::Geocode(request()->input('address'), request()->input('language'));
        if (is_object($response)) {
            if (request()->input('formatted')) {
                return response([
                    'longitude' => $response->longitude(),
                    'latitude' => $response->latitude(),
                    'formattedAddress' => $response->formattedAddress()
                ]);
            } else {
                return response([
                    'longitude' => $response->longitude(),
                    'latitude' => $response->latitude(),
                    'formattedAddress' => null
                ]);
            }
        }
    }
    public function address()
    {
        $response = GeocodingFacade::Reverse(request()->input('latitude'), request()->input('longitude'),
            request()->input('language'));
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
        }
    }
}
