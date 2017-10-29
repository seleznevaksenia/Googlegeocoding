## Synopsis

# What is Geocoding?

Geocoding is the process of converting addresses (like "1600 Amphitheatre Parkway, Mountain View, CA") into geographic coordinates (like latitude 37.423021 and longitude -122.083739), which you can use to place markers on a map, or position the map.

Reverse geocoding is the process of converting geographic coordinates into a human-readable address.

## Installation
```
composer require selezneva/geocoding
```
```
php artisan vendor:publish
```
```
clear routes/web.php file to avoide routes conflicts
```
```
replace app.js from public/js with public/vendor/geocoding/app.js
```
```
the project is available by "your-domain-name" in your browser 
```
## How to use functional 
** Geocoding **
```http://your-domain-name.app/geo/?language=en&address=Paris&formatted=true
```
** Reverse geocoding **
``` http://your-domain-name.app/rev/?language=en&longitude=40.7155809802915&latitude=40.7155809802915&postalCode=true
```
## License

MIT
