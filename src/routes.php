
<?php

\Illuminate\Support\Facades\Route::get('/', function () {
    return view('geocoding::index');
});
\Illuminate\Support\Facades\Route::get('/geo', '\Ksenia\Geocoding\GeocodingController@coords')->name('coords');
\Illuminate\Support\Facades\Route::get('/rev', '\Ksenia\Geocoding\GeocodingController@address')->name('address');
\Illuminate\Support\Facades\Route::any('{all}', function () {
    return view('geocoding::index');
})->where(['all' => '.*']);
