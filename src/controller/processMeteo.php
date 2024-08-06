<?php
require __DIR__ . '/../vendor/autoload.php';

use Services\WeatherService;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cityName = htmlspecialchars($_POST['cityName']);
    $cityId = htmlspecialchars($_POST['cityId']);
    $latitude = htmlspecialchars($_POST['latitude']);
    $longitude = htmlspecialchars($_POST['longitude']);

    //instance du WeatherService
    $weatherService = new WeatherService();

    if (!empty($cityName)){
        $weatherAskedByName = $weatherService->getWeatherByCityName($cityName);
        echo $weatherAskedByName . "<p>degrés C*°</p>";
    }
    
    if (!empty($cityId)) {
        $weatherAskedById = $weatherService->getWeatherByCityId($cityId);
        echo($weatherAskedById) . "<p>degrés C°</p>";
    }
    
    // conversion de l'input text en float sinon cause des pb
    if (!empty($latitude) && !empty($longitude)) {
        $latitude = (float)$latitude;
        $longitude = (float)$longitude;

        $weatherByCoords = $weatherService->getWeatherByCoordinates($latitude, $longitude);
        echo($weatherByCoords) . "<p>degrés C°</p>";
    }

    echo '<a href="../index.php">Retour</a>';


}
?>
