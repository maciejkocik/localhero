  <html>

    <head>
        <title>LocalHero</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>

    <body> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyD1mr6qboXBYoK6wqGPUShXB99Jw0_JGmE&callback=initMap"></script>

    <script>  
    var map, map2;
    var userLocation;
    var marker;

    function initMap() {
        var myOptions = {
            center: new google.maps.LatLng(51.9358379,16.8921266),
            zoom: 5
        }
     
        <?php if(!isset($_GET['page'])){ ?>
        map = new google.maps.Map(document.getElementById("map"), myOptions);
        <?php } ?>
        
        map2 = new google.maps.Map(document.getElementById("map2"), myOptions);
        
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            console.log(pos);
            map2.setCenter(pos);
            map2.setZoom(10);
          });
       }
        
        google.maps.event.addListener(map2, 'click', function(event) {
            placeMarker(event.latLng, map2);
        });
    }; 
    
    function placeMarker(location, map) {
      if (marker) {
        marker.setPosition(location);
      } else {
        marker = new google.maps.Marker({
          position: location,
          map: map
        });
      }

      $("#latitude").val(location.lat());
      $("#longitude").val(location.lng());
    

    }


    </script>
