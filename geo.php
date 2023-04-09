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

    $time = NULL;
    $sliderTime = 5;

    if (isset($_POST) && !empty($_POST)) { 
        if (isset($_POST['myRange']) && !empty($_POST['myRange'])) {
            $time = $_POST['myRange'];
            $sliderTime = $time;
            $time = strtotime($time . ':00:00');
            $time = date('H:i:s', $time);  // Date and Time are Different (can it be compared with date types instead of time types), putting single quotes solve it
            echo "Selected Time: " . $time;
        }
    }
    
    

    // Gets today's date in string form like "Monday", "Tuesday".
    $Day = date('l');

    $sum = NULL;
    $totalPop = NULL;


    if ($db->query("CREATE TEMPORARY TABLE SCI (select ClassNumber from Inside where BuildingID = (select BuildingID from Buildings where BuildingName = 'SCI III'))") === TRUE) {
      // Grabs TotalEnrolled in the Building between a certain time       //$Day goes here
      $query = $db->prepare("SELECT SUM(TotalEnrolled) FROM Classes WHERE (Monday = 1 ) AND (ClassNumber IN (SELECT * FROM SCI)) AND ('$time' >= StartTime) AND ('$time' <= EndTime)");
      $query->execute();
      $result = $query->get_result();
      $row = mysqli_fetch_row($result);
      $sum = $row[0];
      
      if ($row[0] == "") {
        $sum = 0;
      }

      // Query Grabs Total Enrolled in the Building                       //$Day goes here
      //$query = $db->prepare("SELECT SUM(TotalEnrolled) FROM Classes WHERE (Monday = 1 ) AND (ClassNumber IN (SELECT * FROM SCI))");
      //$query->execute();
      //$result = $query->get_result();
      //$row = mysqli_fetch_row($result);
      //$totalPop = $row[0];
      //echo "Sum: " . $sum;
      //echo "Total: " . $totalPop;

      // Start of Day
      $counter = 5;
      $max_day_pop = 0;
      $ctime = NULL;

      // Finds pop at busiest hour
      while($counter <=  21) {
        $ctime = strtotime($counter . ':00:00');
        $ctime = date('H:i:s', $ctime);                                     // $DAY GOES HERE LOL!!!
        $query = $db->prepare("SELECT SUM(TotalEnrolled) FROM Classes WHERE (Monday = 1 ) AND (ClassNumber IN (SELECT * FROM SCI)) AND ('$ctime' >= StartTime) AND ('$ctime' <= EndTime)");
        $query->execute();
        $result = $query->get_result();
        $row = mysqli_fetch_row($result);

        if ($max_day_pop < $row[0]) {
          $max_day_pop = $row[0];
        }
        $counter++;
      }
      echo "MaxPop: " . $max_day_pop;
      echo "Sum: " . $sum;
      
      
    } else {
      echo "Error creating temporary table: " . $db->error;
    }

    //$query = $db->query("CREATE TEMPORARY TABLE SCI (select ClassNumber from Inside where BuildingID = (select BuildingID from Buildings where BuildingName = 'SCI III'))");
    

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
    <div style="text-align:center; padding-top: 30px;">
      <span id ="f" style="font-weight:bold;color:red">5:00 am</span> 
    </div>
    
    

    <script defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAa4pcAIYxHl4-P_fM-25lQMJIn9kSQkFU&libraries=visualization&callback=initMap">
    </script>
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAa4pcAIYxHl4-P_fM-25lQMJIn9kSQkFU&libraries=visualization"></script>-->
    <!--<button onclick="foo()">Test</button>
    <p id="coords"></p>
    -->


    <form method = "post" action="geo.php">
      <div class="slidecontainer">
        <input type="range" min="5" max="21" value="<?php echo $sliderTime?>"  class="slider" id="myRange" name="myRange">
      </div>
      <div style="text-align:center; padding-top: 30px;">
        <button type="submit" value="Submit">Submit</button>
      </div>
    </form>

    <span id ="TotalEnrolled_SCI3" value=<?php echo $sum; ?>> 
    <span id ="TotalPop_SCI3" value=<?php echo $max_day_pop; ?>>
    

    <script src="js/geo.js"></script>

  </body>
  
</html>