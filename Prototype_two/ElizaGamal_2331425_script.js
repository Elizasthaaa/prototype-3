const apiKey = "8b9f819cb07864ab84ea79aeb0db374c";
const weatherUrl = "https://api.openweathermap.org/data/2.5/weather?units=metric&q=";
const photoUrl = "https://api.unsplash.com/search/photos?query=";
const unsplashApiKey = "s7FVREMe7JH7-sqKmJ3hajIYAVFxAamVa35bSZ8CZE8";

const searchBox = document.querySelector(".search input");
const searchBtn = document.querySelector(".search button");
const weatherIcon = document.querySelector('.weatherIcon')
const cityEl = document.querySelector(".city");
const tempEl = document.querySelector(".temp");
const humidityEl = document.querySelector(".humidity");
const windEl = document.querySelector(".wind");
const pressureEl = document.querySelector(".pres");
const temperatureEl = document.querySelector(".temperature");
const errorEl = document.querySelector(".error");
const weatherEl = document.querySelector(".weather");
const card = document.querySelector('.card');
const bgImage = document.querySelector('.BackgroundImage');

function showWeather(data) {
  cityEl.textContent = data.name;
  tempEl.textContent = data.main.temp + "°C";
  humidityEl.textContent = data.main.humidity + "%";
  windEl.textContent = data.wind.speed + "km/h";
  pressureEl.textContent = data.main.pressure + "hPa";
  temperatureEl.textContent = data.main.temp + "°C";

  switch (data.weather[0].main) {
    case "Clouds":
      weatherIcon.src = "ElizaGamal_2331425_clouds.png";
      break;
    case "Clear":
      weatherIcon.src = "ElizaGamal_2331425_clear.png";
      break;
    case "Rain":
      weatherIcon.src = "ElizaGamal_2331425_rain.png";
      break;
    case "Drizzle":
      weatherIcon.src = "ElizaGamal_2331425_drizzle.png";
      break;
    case "Mist":
      weatherIcon.src = "ElizaGamal_2331425_mist.png";
      break;
  }
  errorEl.style.display = "none";
  weatherEl.style.display = "block";
}

function showError() {
  errorEl.style.display = "block";
  weatherEl.style.display = "none";
}

function setBackgroundImage(photoUrl) {
  bgImage.style.backgroundImage = `url(${photoUrl})`;
}

async function getWeather(city) {
  try {
    const response = await fetch(weatherUrl + city + '&appid=' + apiKey);
    if (response.status == 404) {
      showError();
    } else {
      const data = await response.json();
      showWeather(data);
    }
  } catch (error) {
    console.log(error);
  }
}

async function getCityPhoto(city) {
  try {
    const response = await fetch(`${photoUrl}${city}&client_id=${unsplashApiKey}`);
    if (response.status == 404) {
      setBackgroundImage('images/default-background.jpg'); // Set a default background image if no photo is found
    } else {
      const data = await response.json();
      const photoUrl = data.results[0].urls.regular;
      setBackgroundImage(photoUrl);
    }
  } catch (error) {
    console.log(error);
  }
}

getWeather("Long Beach"); // Show the weather for Long Beach by default
getCityPhoto("Long Beach"); // Show a photo of Long Beach by default

searchBtn.addEventListener("click", () => {
  const city = searchBox.value.trim();
  if (city.length > 0) {
    getWeather(city);
    getCityPhoto(city);
  }
});



searchBox.addEventListener("keydown", (event) => {
  if (event.key === "Enter") {
    const city = searchBox.value.trim();
    if (city.length > 0) {
      getWeather(city);
      getCityPhoto(city);
    }

}
});