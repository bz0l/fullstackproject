// Check browser cache first, use if there and less than 10 seconds old
	if(localStorage.when != null
		&& parseInt(localStorage.when) + 10000 > Date.now()) {

			let freshness = Math.round((Date.now() - localStorage.when)/1000) + " second(s)";
			document.getElementById("myWeather").innerHTML = "Looks like " + localStorage.myWeather + " outside today";
			document.getElementById("myTemperature").innerHTML = "The current temperature is " + localStorage.myTemperature + "°C";
			document.getElementById("myWindSpeed").innerHTML = "Current wind speed is " + localStorage.myWindSpeed + " m/s";
			document.getElementById("myTime").innerHTML =  "This data is " + freshness + " outdated";
	
	// No local cache, access network
		} else {

	// Fetch Basildon weather data from API   2432878/1 Basildon Wind speed
	fetch('https://mi-linux.wlv.ac.uk/~2432878/my-api.php?city=basildon')
	    
	// Convert response string to json object
	.then(response => response.json()) 
	.then(response => {
	// download jquery to display weather icons 
    // Display whole API response in browser console - print command 
    console.log(response);
		
    // Copy elements of response to HTML from weather API 
    document.getElementById("myWeather").innerHTML = "Looks like "+ response.weather_description + " outside today";
	document.getElementById("myTemperature").innerHTML = "The current temperature is " + response.weather_temperature + "°C";
	document.getElementById("myWindSpeed").innerHTML = "Current wind speed is " + response.weather_wind + " m/s";
	document.getElementById("myTime").innerHTML = "Current time is " + response.weather_time;
	
	// Save new data to browser, with new timestamp
    localStorage.myWeather = response.weather_description;
    localStorage.myTemperature = response.weather_temperature + '°';
    localStorage.when = Date.now(); // milliseconds since January 1 1970
	
	
	// displays weather icon dependent on value myWeather
	//var icon = response.weather[0].icon;
	//var icon_url = "https://openweathermap.org/img/wn/10d@2x.png" + icon + "@2x.png"
	//document.getElementById("myWeather")
	
  })
  .catch(err => {
	
    // Display errors in console to help with fixing errors 
    console.log(err);
	});
}	