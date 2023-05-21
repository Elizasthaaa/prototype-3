<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    //create the connection
    $conn = mysqli_connect("localhost","root","","isa");
    //fetch from api
    $json_data = file_get_contents("https://history.openweathermap.org/data/2.5/history/city?lat=41.85&lon=-87.65&appid=8835fbb9735bccc3f0ad9e6eecacd781");
    //convert into json format
    $data = json_decode($json_data,true);
    var_dump($data['list']);
    die;
    //access the data 
    $city = $data['name'];
    $temp = $data['main']['temp'];
    $humidity = $data['main']['humidity'];
    $wind_speed =$data['wind']['speed'];
    $pressure = $data['main']['pressure'];
    $timestamp = $data['dt'];
    $icon=$data['weather'][0]['icon'];
    $condition=$data['weather'][0]['description'];
    $date = gmdate("Y-m-d\TH:i:s\Z", $timestamp);
    //query 
    $sql = "INSERT INTO weather(city,temperature,humidity,pressure,wind_speed,datetime,icon,weather_condition) VALUES('$city','$temp','$humidity','$pressure','$wind_speed','$date','$icon','$condition')";
    //run the query
    mysqli_query($conn,$sql);
    ?>

</body>
</html>



<?php
// Create the connection
$conn = mysqli_connect("localhost", "root", "", "isa");

// Check if the connection was successful
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

$defaultCity = "Default City"; // Replace with your default city name
$searchedCity = "Searched City"; // Replace with the searched city name

// Function to insert city into the cities table if it doesn't exist
function insertCity($conn, $cityName)
{
    $cityName = mysqli_real_escape_string($conn, $cityName);
    $sql = "INSERT INTO cities (name) SELECT '$cityName' WHERE NOT EXISTS (SELECT * FROM cities WHERE name = '$cityName')";
    mysqli_query($conn, $sql);
    return mysqli_insert_id($conn);
}

// Function to insert weather data into the weather table
function insertWeatherData($conn, $cityId, $weatherData)
{
    $pressure = $weatherData['pressure'];
    $temp = $weatherData['temp'];
    $humidity = $weatherData['humidity'];
    $wind_speed = $weatherData['wind_speed'];
    $icon = $weatherData['weather'][0]['icon'];
    $date = gmdate("Y-m-d\TH:i:s\Z", $weatherData['dt']);
    $condition = $weatherData['weather'][0]['description'];

    $sql = "INSERT INTO weather (city_id, temperature, humidity, pressure, wind_speed, datetime, icon, weather_condition) VALUES ('$cityId', '$temp', '$humidity', '$pressure', '$wind_speed', '$date', '$icon', '$condition')";
    mysqli_query($conn, $sql);
}

// Function to fetch and insert weather data for a given city
function fetchWeatherData($conn, $cityName)
{
    $cityName = urlencode($cityName);
    $app_id = "YOUR_API_KEY"; // Replace with your actual API key
    $url = "https://api.openweathermap.org/data/2.5/weather?q=$cityName&appid=$app_id";

    // Fetch data from the API
    $json_data = file_get_contents($url);

    // Convert JSON data to an associative array
    $data = json_decode($json_data, true);

    if (isset($data['main'])) {
        // Insert the city into the cities table if it doesn't exist
        $cityId = insertCity($conn, $cityName);

        // Insert weather data into the weather table
        insertWeatherData($conn, $cityId, $data);
    }
}

// Fetch and insert weather data for the default city
fetchWeatherData($conn, $defaultCity);

// Fetch and insert weather data for the searched city
fetchWeatherData($conn, $searchedCity);

mysqli_close($conn);
?>














<?php

//create the connection
$conn = mysqli_connect("localhost","root","","isa");
$base_url = "https://history.openweathermap.org/data/2.5/history/city?";
$app_id = "8835fbb9735bccc3f0ad9e6eecacd781";
$lat = "41.85";
$lon = "87.65";
$start = "1683550566";
$end = "1683982566";
$url = $base_url."lat=".$lat."&lon=".$lon."&start=".$start."&end=".$end."&appid=".$app_id;

//fetch from api
// $json_data = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=long%20beach&appid=8835fbb9735bccc3f0ad9e6eecacd781");
$json_data = file_get_contents($url);
//convert into json format
$data = json_decode($json_data,true);

for ($x = 0; $x <= 119; $x++) {

    // var_dump($data['list'][1]['weather']['description']);
    // die;

//         $icon = $data['list'][$x]['weather'][0]['icon'];
// $condition = $data['list'][$x]['weather'][0]['description'];

    $pressure = $data['list'][$x]['main']['pressure'];
    $temp = $data['list'][$x]['main']['temp'];
    $humidity = $data['list'][$x]['main']['humidity'];
    $wind_speed = $data['list'][$x]['wind']['speed'];
    $icon = $data['list'][$x]['weather'][0]['icon'];
    $city_id = $data['city_id'];
    $timestamp = $data['list'][$x]['dt'];
    $date = gmdate("Y-m-d\TH:i:s\Z", $timestamp);
    $condition = $data['list'][$x]['weather'][0]['description'];

 
    //query
    $sql = "INSERT INTO weather(city_id,temperature,humidity,pressure,wind_speed,datetime,icon,weather_condition) VALUES('$city_id','$temp','$humidity','$pressure','$wind_speed','$date','$icon','$condition')";
    //run the query
    
    mysqli_query($conn,$sql);
    echo "data inserted";
}

var_dump('done');
die;


//access the data 
$city = $data['name'];
$temp = $data['main']['temp'];
$humidity = $data['main']['humidity'];
$wind_speed =$data['wind']['speed'];
$pressure = $data['main']['pressure'];
$timestamp = $data['dt'];
$icon=$data['weather'][0]['icon'];
$condition=$data['weather'][0]['description'];
$date = gmdate("Y-m-d\TH:i:s\Z", $timestamp);
//query 
$sql = "INSERT INTO weather(city,temperature,humidity,pressure,wind_speed,datetime,icon,weather_condition) VALUES('$city','$temp','$humidity','$pressure','$wind_speed','$date','$icon','$condition')";
//run the query

mysqli_query($conn,$sql);
echo "data inserted";
?>