<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" type = "text/css" href = "./script.css">
    <title>Document</title>
</head>
<body>

<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "protoii";

$conn = new mysqli($servername, $username, $password , $dbname);

// Error checking
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {

}
 else {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db($dbname);

// Create the table
$sql = "DROP TABLE IF EXISTS weather";
$conn->query($sql);

$sql = "CREATE TABLE weather (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cityName  VARCHAR (255) ,
    temperature FLOAT(6,2) ,
    pressure FLOAT(6,2) ,
    humidity FLOAT(6,2) ,
    wind FLOAT(6,2) ,
    `description` VARCHAR(255) ,
    `current_time` VARCHAR(255),
    full_date VARCHAR(255)
)";

if ($conn->query($sql) === TRUE) {
    // echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}




$cty_name = 'San Bernardino';
// Get the data from the request
$datas = json_decode(file_get_contents("https://history.openweathermap.org/data/2.5/history/city?q=".$cty_name."&type=hour&start=1682434889&cnt=140&appid=0997dc520ec4b21c2501f7d686b572f1"), true);


echo "<hr>";
echo "<hr>";
echo "<br>";


if (!empty($datas)) {
    foreach($datas['list'] as $data)
{
    $unix_timestamp = $data['dt'];
$date_time = date("Y-m-d H:i:s", $unix_timestamp);
$current_time = date("H:i:s", $unix_timestamp);
$full_date = date("Y-m-d", $unix_timestamp);

 
// Insert the data into the table


$sql = "INSERT INTO weather (temperature, pressure, humidity, wind, `description`, `current_time`, full_date, cityName) 
VALUES ('" . $data['main']['temp'] . "', '" . $data['main']['pressure'] . "', '" . $data['main']['humidity'] . "', '" . $data['wind']['speed'] . "', '" .$data['weather']['0']['description']. "', '" . $current_time . "', '" . $full_date . "', '" . $cty_name . "')"; 

if ($conn->query($sql) === TRUE) {
   
} else {
    echo "Error inserting data: " . $conn->error;
}

}
} else {
    echo "No data received";
}

            
$getdata_sql = "SELECT * FROM weather ORDER BY id ASC";



echo $getdata_sql . "<br>";
$req_all_data = $conn->query($getdata_sql); 
if ($req_all_data) {
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>City Name</th>';
    echo '<th>Temperature</th>';
    echo '<th>Pressure</th>';
    echo '<th>Humidity</th>';
    echo '<th>Wind</th>';
    echo '<th>Description</th>';
    echo '<th>Time</th>';
    echo '<th>Date</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($data = mysqli_fetch_assoc($req_all_data)) {
    echo '<tr>';
    echo '<td>' . $data['id'] . '</td>';
    echo '<td>' . $data['cityName'] . '</td>';
    echo '<td>' . $data['temperature'] . '</td>';
    echo '<td>' . $data['pressure'] . '</td>';
    echo '<td>' . $data['humidity'] . '</td>';
    echo '<td>' . $data['wind'] . '</td>';
    echo '<td>' . $data['description'] . '</td>';
    echo '<td>' . $data['current_time'] . '</td>';
    echo '<td>' . $data['full_date'] . '</td>';
    echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}
?>

</body>
</html>