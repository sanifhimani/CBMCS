<?php
  include 'init.php';
  include 'connection.php';
  $con = mysqli_connect("localhost","sanif","sanifhimani","cbmcs");
?>
<!DOCTYPE html>
<html>
  <head>
    <title>CBMCS | Monitor</title>
    <meta name="viewport" content="initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        width:100%;
        height: 430px;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background-color:#222629;
      }
      #info_window
      {
        font-weight:bold;
        font-size: 17px;
        padding:5px;
        font-family: Nunito;
      }
      h1
      {
        font-family: Nunito;
        font-size: 30px;
        text-align: center;
        color:#E85A4F;
      }
      #footer
      {
        clear: both;
        position: relative;
        top:70px;
        bottom: 0;
        left:0;
        right:0;
        width: 100%;
        text-align: center;
        background: #fff;
        color:#222629;
        padding-top: 10px;
        padding-bottom: 10px;
        font-family: Nunito;
        font-size: 18px;
      }

    </style>
  </head>
  <body>
    <div id="map"></div>
    <div><h1><b>SELECT A MOTOR TO MONITOR</b></h1></div>
    <script>

        <?php
            $sql = "SELECT * FROM borewell_data WHERE borewell_id = (SELECT MAX(borewell_id) FROM borewell_data s1) AND update_time = (SELECT MAX(update_time) FROM borewell_data)";

            if ($result = mysqli_query($con, $sql)) {
  
              while ($row = mysqli_fetch_assoc($result)) {
              
                $borewell_id = $row["borewell_id"];
                $lat = $row["latitude"];
                $lng = $row["longitude"];
              
              }
            }
        ?>

        function initMap() {
          var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          var labelIndex = 0;
          var content = '<div id="info_window">Durga Nagar, Malkajgiri Secunderabad, Telangana</div>'

          var latlng = new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lng; ?>);
          var map = new google.maps.Map(document.getElementById('map'), {
          center: latlng,
          zoom: 13
        });
        var geocoder = new google.maps.Geocoder;
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('use_php_to_output_xml.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var borewell_id = markerElem.getAttribute('borewell_id');
              var user_id = markerElem.getAttribute('user_id');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('latitude')),
                  parseFloat(markerElem.getAttribute('longitude')));
              //imp stuff
              var latitude = parseFloat(markerElem.getAttribute('latitude'));
              var longitude = parseFloat(markerElem.getAttribute('longitude'));
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: {text: labels[labelIndex++ % labels.length], color: "white", fontSize: "15px", fontweight:"bold"}
              });
              var infowindow = new google.maps.InfoWindow({
                content: content
              });
              marker.addListener('click', function() {
                window.location.href = 'monitor.php?borewell_id='+borewell_id+'&lat='+latitude+'&lng='+longitude;
              });
              marker.addListener('mouseover', function() {
                infowindow.open(map, marker);
              });
              marker.addListener('mouseout', function() {
                infowindow.close();
            });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBg-hZxw4XKLsAoiI2cz1qgeSQQiqyKEbY&callback=initMap"
    async defer></script>

    <div id="footer">
      <p>Developed by Prototech</p>
    </div>

  </body>
</html>