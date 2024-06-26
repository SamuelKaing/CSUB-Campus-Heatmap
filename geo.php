<?php 
    error_reporting(E_ALL);
    ini_set("log_errors", 1);
    ini_set("display_errors", 1);

    $db = get_connection();

    // Establish connection to mySQL Database
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
    $day_selected = "";
    $slider_time = 5;

    if (isset($_POST) && !empty($_POST)) { 
      if (isset($_POST['my_range']) && !empty($_POST['my_range'])) {
        $time = $_POST['my_range'];
        $slider_time = $time;
        $time = strtotime($time . ':00:00');
        $time = date('H:i:s', $time);  // Date and Time are Different (can it be compared with date types instead of time types), putting single quotes solve it
      }
      if (isset($_POST['day']) && !empty($_POST['day'])) {
        // save day to variable
        $day_selected = $_POST['day'];
      }
    }
    
    // Gets today's date in string form like "Monday", "Tuesday".
    $day = date('l', strtotime($day_selected));
    $sums = [];
    $buildings = [];
    $max_day_pop = [];

    $query = $db->prepare("SELECT BuildingName FROM Buildings");
    $query->execute();
    $results = $query->get_result();
    
    // Creates an Array of all the buildings! (Dynamic Code!)
    while ($row = $results->fetch_assoc()) {
      array_push($buildings, $row['BuildingName']);
      array_push($max_day_pop, 0);
    }

    for($i = 0; $i < count($buildings); $i++) {
      $query = $db->prepare("DROP TEMPORARY TABLE IF EXISTS building_classes");
      $query->execute();
      // Temp table that holds all the classes in a building
      if ($db->query("CREATE TEMPORARY TABLE building_classes (select ClassNumber from Inside where BuildingID = (select BuildingID from Buildings where BuildingName = '$buildings[$i]'))") === TRUE) {
        // Grabs TotalEnrolled in the Building between a certain time
        $query = $db->prepare("SELECT SUM(TotalEnrolled) FROM Classes WHERE ($day = 1 ) AND (ClassNumber IN (SELECT * FROM building_classes)) AND ('$time' >= StartTime) AND ('$time' <= EndTime)");
        $query->execute();
        $result = $query->get_result();
        $row = mysqli_fetch_row($result);

        if ($row[0] == "") {
          array_push($sums, 0);
        }
        else {
          array_push($sums, $row[0]);
        }

        // Start of Day
        $counter = 5;
        $ctime = NULL;

        // Finds population at busiest hour
        while($counter <=  21) {
          $ctime = strtotime($counter . ':00:00');
          $ctime = date('H:i:s', $ctime);
          $query = $db->prepare("SELECT SUM(TotalEnrolled) FROM Classes WHERE ($day = 1 ) AND (ClassNumber IN (SELECT * FROM building_classes)) AND ('$ctime' >= StartTime) AND ('$ctime' <= EndTime)");
          $query->execute();
          $result = $query->get_result();
          $row = mysqli_fetch_row($result);

          if ($max_day_pop[$i] < $row[0]) {
            $max_day_pop[$i] = $row[0];
          }
          $counter++;
        }
        //echo "MaxPop: " . $max_day_pop[$i];
        //echo "Sum: " . $sums[$i];

      } else {
        echo "Error creating temporary table: " . $db->error;
      }
    }


    $json_sums = json_encode($sums);
    $json_max_day_pop = json_encode($max_day_pop);
    $json_buildings = json_encode($buildings);
  
  // Maintains correct slider time on page load
  function time_conversion($slider_time) {
    $std_time = NULL;
    if ($slider_time > 12) {
      $std_time = $slider_time - 12;
      echo $std_time . ":00 pm";
    } else {
      echo $slider_time . ":00 am";
    }
  }

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
    <div id="map" style="padding: 40px;" ></div>
    <div style="text-align:center; padding-top: 30px;">
      <span id ="time_display" style="font-weight:bold;color:red"><?php time_conversion($slider_time)?></span> 
    </div>

    <script defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAa4pcAIYxHl4-P_fM-25lQMJIn9kSQkFU&libraries=visualization&callback=initMap">
    </script>
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAa4pcAIYxHl4-P_fM-25lQMJIn9kSQkFU&libraries=visualization"></script>-->
    <!--<button onclick="foo()">Test</button>
    <p id="coords"></p>
    -->

    <form method = "post" action="geo.php">
      <div class="daycontainer" style="padding: 0 10%;">
      <label for="day">Choose a day:</label>
      <select id="day" name="day">
        <option value="Monday" <?php if ($day_selected == 'Monday') echo 'selected' ?>>Monday</option>
        <option value="Tuesday" <?php if ($day_selected == 'Tuesday') echo 'selected' ?>>Tuesday</option>
        <option value="Wednesday" <?php if ($day_selected == 'Wednesday') echo 'selected' ?>>Wednesday</option>
        <option value="Thursday" <?php if ($day_selected == 'Thursday') echo 'selected' ?>>Thursday</option>
        <option value="Friday" <?php if ($day_selected == 'Friday') echo 'selected' ?>>Friday</option>
      </select>
      </div>
      <div class="slidecontainer">
        <input type="range" min="5" max="21" value="<?php echo $slider_time?>" class="slider" id="my_range" name="my_range">
      </div>
      <div style="text-align:center; padding: 10px 0px;">
        <button type="submit" value="Submit">Submit</button>
      </div>
    </form>

    <!--<span id ="CurrentPop" data-value=<?php // echo $sums; ?>> -->
    <!--<span id ="MaxPop" data-value=<?php // echo $max_day_pop; ?>> -->
    
    <script src="js/geo.js"></script>
    <script> 
      var sums = <?php echo $json_sums; ?>;
      var max_day_pop = <?php echo $json_max_day_pop; ?>;
      var buildings = <?php echo $json_buildings; ?>;
      getArray(sums, max_day_pop, buildings);
    </script>

  </body>

  <div class="pop">
    <?php
      echo "<table border='1' width='400' cellspacing'1'>";
      for($i = 0; $i < count($buildings); $i++) {
        $query = $db->prepare("DROP TEMPORARY TABLE IF EXISTS building_classes");
        $query->execute();
        // Temp table that holds all the classes in a building
        if ($db->query("CREATE TEMPORARY TABLE building_classes (select ClassNumber from Inside where BuildingID = (select BuildingID from Buildings where BuildingName = '$buildings[$i]'))") === TRUE) {
          // Grabs TotalEnrolled in the Building between a certain time
          $query = $db->prepare("SELECT SUM(TotalEnrolled) FROM Classes WHERE ($day = 1 ) AND (ClassNumber IN (SELECT * FROM building_classes)) AND ('$time' >= StartTime) AND ('$time' <= EndTime)");
          $query->execute();
          $result = $query->get_result();
          $row = mysqli_fetch_row($result);
        
          if ($row[0] == "") {
            array_push($sums, 0);
          }
          else {
            array_push($sums, $row[0]);
          }
        
          // Start of Day
          $counter = 5;
          $ctime = NULL;
        
          // Finds population at busiest hour
          while($counter <=  21) {
            $ctime = strtotime($counter . ':00:00');
            $ctime = date('H:i:s', $ctime);
            $query = $db->prepare("SELECT SUM(TotalEnrolled) FROM Classes WHERE ($day = 1 ) AND (ClassNumber IN (SELECT * FROM building_classes)) AND ('$ctime' >= StartTime) AND ('$ctime' <= EndTime)");
            $query->execute();
            $result = $query->get_result();
            $row = mysqli_fetch_row($result);
          
            if ($max_day_pop[$i] < $row[0]) {
              $max_day_pop[$i] = $row[0];
            }
            $counter++;
          }
            echo "<tr>";
              echo "<td style'color: blue; margin: auto'>" . $buildings[$i] . "</td>";
              echo "<td>MaxPop: " . $max_day_pop[$i] . "</td>";
              echo "<td>Sum: " . $sums[$i] . "</td>";
              if ($max_day_pop[$i] != 0) {
                echo "<td>Percentage Full: " . round(($sums[$i]/$max_day_pop[$i])*100, 2) . "%</td>";  
              }
              else {
                echo "<td>Percentage Full: 0%";
              }
            echo "</tr>";
        
        } else {
          echo "Error creating temporary table: " . $db->error;
        }
      }
      echo "</table>";
    
    ?>
  </div>
  
</html>
