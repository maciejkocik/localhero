
 <main role="main">
     <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Album example</h1>
          <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
          <p>
            <a href="#" class="btn btn-primary my-2">Main call to action</a>
            <a href="#" class="btn btn-secondary my-2">Secondary action</a>
          </p>
        </div>
      </section>
     
    <div id="map"></div>
     
    <script>  
    var map, map2;
    var userLat, userLng;
    var marker;

    
    function initMap() {
        if (navigator.geolocation) { 
        navigator.geolocation.getCurrentPosition(function(position){
          userLat = parseFloat(position.coords.latitude);
          userLng = parseFloat(position.coords.longitude);
        console.log(userLat, userLng);
        });
        }
        var myOptions = {
            center: new google.maps.LatLng(51.9358379,16.8921266),
            zoom: 5
        }
     
        map = new google.maps.Map(document.getElementById("map"), myOptions);
        
        myOptions.center = new google.maps.LatLng(userLat, userLng);
        myOptions.zoom = 10;
        
        console.log(userLat);
        console.log(userLng);
        
        map2 = new google.maps.Map(document.getElementById("map2"), myOptions);
        
        google.maps.event.addListener(map2, 'click', function(event) {
            placeMarker(event.latLng);
        });
    };
    
    function placeMarker(location) {
      if (marker) {
        marker.setPosition(location);
      } else {
        marker = new google.maps.Marker({
          position: location,
          map: map2
        });
      }

      $("#latitude").val(location.lat());
      $("#longitude").val(location.lng());
    console.log(location.lat());
    console.log(location.lng());
    

    }


    </script>

      <div class="album py-5 bg-light">
        <h2 class="text-center display-3" id="gallery-heading">Aktualne problemy</h2>
        <div class="container">
          <div class="row">
            <?php for($i = 1; $i <= 9; $i++): ?>
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                      <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                    </div>
                    <small class="text-muted">9 mins</small>
                  </div>
                </div>
              </div>
            </div>
            <?php endfor; ?>
          </div>
        </div>
      </div>

    </main>