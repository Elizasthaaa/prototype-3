<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "isa";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the selected date from the form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["selected_date"])) {
  $selected_date = $_POST["selected_date"];
} else {
  $selected_date = "1"; // Setting a default day
}

// Query the database for the weather information for the selected date
$sql = "SELECT * FROM weather WHERE id = '$selected_date'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Store the database data in respective variables
  $row = $result->fetch_assoc();
  $location = $row["city"];
  $icon = $row["icon"];
  $temp = $row["temperature"];
  $pressure = $row['pressure'];
  $wind_speed = $row["wind_speed"];
  $humidity = $row["humidity"];
  $condition = $row["weather_condition"];
  $date = $row["datetime"];
} else {
  echo "No results";
}

// Close the database connection
$conn->close();
?>



<!-- -------------------------------------------------------------------------------------------------------------- -->



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Weather App</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>

<style>
body {
  background: linear-gradient(to bottom, #2980b9, #6dd5fa);
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
  color: #fff;
}

/* Center the content vertically */
html,
body {
  display: flex;
  flex-direction: column; /* Update to column */
  align-items: center;
  justify-content: center; /* Add justify-content */
  height: 100vh; /* Use viewport height */
}

/* Apply a background image to the page */
.background-image {
  background-image: url("https://images.pexels.com/photos/209831/pexels-photo-209831.jpeg?cs=srgb&dl=pexels-pixabay-209831.jpg&fm=jpg");
  background-size: cover;
  background-position: center;
  opacity: 0.5;
  filter: grayscale(100%);
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
}

/* Style the weekly buttons */
.weekly-buttons {
  display: flex;
  flex-direction: row;
  align-items: justify;
  margin-bottom: 20px;
}

.weekly-buttons button {
  font-size: 16px;
  padding: 10px 20px;
  margin-bottom: 10px;
  border: none;
  background-color: #f5f5f5;
  color: #333;
  cursor: pointer;
  transition: all 0.3s ease;
}

.weekly-buttons button:hover {
  background-color: #F6C6EA;
  color: #fff;
}

.weekly-buttons button:active {
  transform: scale(0.95);
}



.container {
  max-width: 900px;
  margin: 20px; /* Adjust margin */
  padding: 20px;
  text-align: center;
  background-color: rgba(228, 158, 210, 0.4);
  border-radius:30px;

}

.location {
  font-size: 42px;
  margin-bottom: 10px;
  text-align: center;
}

.weather {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
}

.weather .temp {
  font-size: 48px;
  font-weight: bold;
  text-align: center;
}

.weather .condition {
  font-size: 24px;
  text-align: center;
}

/* Style the wind, humidity, and pressure information displays */
.details {
  display: flex;
  justify-content: center;
  margin-bottom: 20px; /* Add margin-bottom */
  background-color: rgba(250, 124, 173, 0.4);
padding:40px 50px;

}

.col {
  margin: 0 10px;
  text-align: center;
}

.col img {
  width: 60px;
  margin-bottom: 10px;
}

.col p {
  margin: 0;
}

.speed,
.humi,
.press {
  font-size: 20px;
  font-weight: bold;
}

.small {
  font-size: 14px;
  font-weight: normal;
}



</style>

  <div class="background-image" data-weather=""></div>

  <form method="post">
    <div class="weekly-buttons">
      <button id="sunday" name="selected_date" value="1">Sunday</button>
      <button id="monday" name="selected_date" value="2">Monday</button>
      <button id="tuesday" name="selected_date" value="3">Tuesday</button>
      <button id="wednesday" name="selected_date" value="4">Wednesday</button>
      <button id="thursday" name="selected_date" value="5">Thursday</button>
      <button id="friday" name="selected_date" value="6">Friday</button>
      <button id="saturday" name="selected_date" value="7">Saturday</button>
    </div>
  </form>

  <div class="container">
    <h1 class="location"><?php echo $location; ?></h1>
    <div class="weather">
      <div class="temp"><?php echo round($temp - 273.15); ?>&deg;C</div>
      <div class="condition"><?php echo $condition; ?></div>
    </div>
    <p id="date"><?php echo $date; ?></p>
  </div>

  <div class="details">
    <div class="col">
    <i class="fas fa-wind"></i>
      <div class="wind">
        <p>Wind Speed:</p>
        <p class="speed"><?php echo $wind_speed; ?></p>
        <p class="small">m/s</p>
      </div>
    </div>
    
    <div class="col">
    <i class="fas fa-tint"></i>

      <div class="humidity">
        <p>Humidity:</p>
        <p class="humi"><?php echo $humidity; ?></p>
        <p class="small">%</p>
      </div>
    </div>
    <div class="col">
    <i class="fas fa-compress-arrows-alt"></i>
      <div class="pressure">
        <p>Pressure:</p>
        <p class="press"><?php echo $pressure; ?></p>
        <p class="small">hPa</p>
      </div>
    </div>
  </div>

</body>

</html>
