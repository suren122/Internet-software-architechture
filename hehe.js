//  Getting the id and classes from the HTML scripting.
const time1 = document.getElementById('time')
const date1 = document.getElementById('date')

const days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]  //   7 days declaring.
const months = ["Jan","Feb","Mar","Apr","May","Jun","July","Aug","Sep","Oct","Nov","Dec"]//  12  months   declaring.
// using Set interval Function to get the time event In the  DOM
setInterval(()=>{
  const time = new Date();           //  for the current time using the Date method.
  const month = time.getMonth();   // getting month
  const date = time.getDate();     //  getting date 
  const day = time.getDay();        //   getting day 
  let hour = time.getHours();     //  getting hours 
  const hoursIn12HrFormat = hour >= 13 ? hour %12:hour
  let minutes = time.getMinutes() 
  let second = time.getSeconds()
     //getting minutes
  const ampm =  hour >=12 ? 'PM' : "AM"

  if(hour < 10){
    hour = "0" + hour
  }

  if(minutes < 10 ){
    minutes = "0" + minutes
  }
  if(second < 10){
    second = "0" + second
  }


  time1.innerHTML = hoursIn12HrFormat + ':' + minutes+ ':' + second + `<span id="am-pm"> ${ampm}</span>`  //giivng the formatting of the time.
  date1.innerHTML = days[day] + ','  +  date+ '' + months[month]
  
},1000)



//  Fetching the API key and API Url using the async functions.
const APIkey=`37319963d2b12b0a17a3e282e71e2731`; 

async function getWeather(cityname){
  cityName.innerHTML = cityname
  fetch(`https://api.openweathermap.org/data/2.5/weather?q=${cityname}&appid=${APIkey}&units=metric`)
      .then(response => response.json())
      .then(response => {
//  storing  the weather data and info in the  use of response and Json 
          console.log(response)
          humidity2.innerHTML = response.main.humidity 
          temp2.innerHTML = response.main.temp
          wind_speed2.innerHTML = response.wind.speed
          pressure2.innerHTML = response.main.pressure
          home.src =`http://openweathermap.org/img/w/${response.weather[0].icon}.png`;
      })
      .catch(err => console.error(err));
}
getWeather("San Bernardino")  //calling the function by passing my city name  san bernanrdino..

let button = document.getElementById("submit");
let city=document.getElementById("city")
button.addEventListener("click",()=>{
  getWeather(city.value)
})