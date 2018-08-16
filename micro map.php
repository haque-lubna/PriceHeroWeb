

<!DOCTYPE html>
<html>
<head>
  <title>Place Autocomplete</title>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
      /* Always set the map height explicitly to define the size of the div
      * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
    </style>
  </head>
  <body>

    <script>
      function goBack() {
        window.history.go(-2);
        return false;
      }
    </script>
    <?php 
    $con = mysqli_connect("localhost","root","","authentication");

    if(isset($_POST['submit']))
    {

      $lat=$_POST['lat'];
      $lng=$_POST['lng'];
      $location=$_POST['location'];
      $query="INSERT INTO map (place_Lat,place_Lng,location) 
      VALUES ('$lat','$lng','$location')";
      mysqli_query($con,$query);
        // if(mysqli_query($con,$query)){
        //     echo "<div class='alert alert-success'>Place inserted in Database</div>";
        // }

          // header("location:javascript:history.go(-3)");      
    }

    ?>
    <div class="container">
     <!-- <div class="row"><div class="col-lg-6 alert alert-info">Google Map autocomplete Example</div></div> -->
     <form method="post" action="">
       <div class="row">
         <div class="col col-lg-6">
          <input type="submit" name="back" value="Go Back" class="form-control btn btn-primary" onclick=" window.history.go(-2);
        return false;" style="height: 30px; width:80px;margin-bottom: 30px;margin-top: 40px; margin-right: 50px; ">

          <input type="submit" name="submit" value="Save" class="form-control btn btn-primary" style="height: 30px; width:80px;margin-bottom: 30px;margin-top: 40px; background: green;">
          <input type="hidden" name="lat" id="lat">
          <input type="hidden" name="lng" id="lng">
          <input type="hidden" name="location" id="location">

          <input id="pac-input" class="controls" type="text"placeholder="Enter a location" required>
          <div id="type-selector" class="controls">
           <input type="radio" name="type" id="changetype-all" checked="checked">
           <label for="changetype-all">All</label>


         </div>
         <div id="map" style="height: 500px;width: 230%"></div>


       </div>
     </div><!--End of row-->
   </form>
 </div><!--End of container-->
 <script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 24, lng: 91},
          zoom: 17
        });
        var input = /** @type {!HTMLInputElement} */(
          document.getElementById('pac-input'));

        var types = document.getElementById('type-selector');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setIcon(/** @type {google.maps.Icon} */({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
          }));
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);
          var item_Lat =place.geometry.location.lat();
          var item_Lng= place.geometry.location.lng();
          var item_Location = place.formatted_address;
//alert("Lat= "+item_Lat+"_____Lang="+item_Lng+"_____Location="+item_Location);
$("#lat").val(item_Lat);
$("#lng").val(item_Lng);
$("#location").val(item_Location);



var address = '';
if (place.address_components) {
  address = [
  (place.address_components[0] && place.address_components[0].short_name || ''),
  (place.address_components[1] && place.address_components[1].short_name || ''),
  (place.address_components[2] && place.address_components[2].short_name || '')
  ].join(' ');
}

infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
infowindow.open(map, marker);
});

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);
      }
    </script>
<!-- 
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqEbrdkhyUVIZunQsJTXVRMYi-Ns-MUJ4&libraries=places&callback=initMap"
    async defer></script> -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5YXg4v0vVkGKv0Erm_LsrHeGJW2qJeEM&libraries=places&callback=initMap"
    async defer></script>
    
    
   
  </body>
  </html>
