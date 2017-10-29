<?php
/**
 * Created by PhpStorm.
 * User: Ksenija
 * Date: 29.10.2017
 * Time: 0:47
 */
namespace Ksenia\Geocoding\Facade;
class GeocodingFacade extends \Illuminate\Support\Facades\Facade
{
 protected static function getFacadeAccessor() { return 'geocoding'; }
}