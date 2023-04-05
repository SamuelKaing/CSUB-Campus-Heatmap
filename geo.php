<?php 
    error_reporting(E_ALL);
    ini_set("log_errors", 1);
    ini_set("display_errors", 1);

    $db = get_connection();

    function get_connection() {
        static $connection;
        
        if (!isset($connection)) {
            // Connect to the database
            $connection = mysqli_connect('localhost', 'vibeview', 
                'Dgum~7vayiw','vibeview') 
                or die(mysqli_connect_error());
        }
        if ($connection === false) {
            echo "Unable to connect to database<br/>";
            echo mysqli_connect_error();
        }
      
        return $connection;
    }

    if (isset($_POST) && !empty($_POST)) { 
        if (isset($_POST['myRange']) && !empty($_POST['myRange'])) {
            $time = $_POST['myRange'];
            echo "Selected Time: " . $time;
        }
    }
    // Hypothetical
    // Grab button clicked from user
    $Day = date('l');
    $select = "SELECT * FROM Classes WHERE ". $Day . "= 1";
    $query = $db->prepare($select);
    // get current date, add parameter
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/geo.css">
    <title>Home</title>
  </head>
  <body>
    <div id="map"></div>
    <span id ="f" style="font-weight:bold;color:red">1</span> 
    
    

    <script defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAa4pcAIYxHl4-P_fM-25lQMJIn9kSQkFU&libraries=visualization&callback=initMap">
    </script>
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAa4pcAIYxHl4-P_fM-25lQMJIn9kSQkFU&libraries=visualization"></script>-->
    <!--<button onclick="foo()">Test</button>
    <p id="coords"></p>
    -->


    <form method = "post" action="geo.php">
      <div class="slidecontainer">
        <input type="range" min="5" max="21" value="5" class="slider" id="myRange" name="myRange">
        </div>
      <button type="submit" value="Submit">Submit</button>
    </form>



    <script src="js/geo.js"></script>
  </body>
  
</html>