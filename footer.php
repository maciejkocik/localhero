
        <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.6/holder.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>  
    var map, map2, map3;
    var userLocation;
    var marker;

    function initMap() {
        var myOptions = {
            center: new google.maps.LatLng(51.9358379,16.8921266),
            zoom: 5
        }
  //map 1 - main_page   
        <?php if(!isset($_GET['page']) || $_GET['page'] == "add_post" || $_GET['page'] == "main_page"){ ?>
        map = new google.maps.Map(document.getElementById("map"), myOptions);
        
        function addMarker(lat, lng){
        var pt = new google.maps.LatLng(lat, lng);
        var marker = new google.maps.Marker({
            position: pt,
            map: map
        });
        }
        
        <?php if(isset($post)) {
                    $post -> getApprovedPostsForMap();
                    $approved_posts = $post -> approvedPosts;
                    for ($i = 0; $i < count($approved_posts); $i++){
                        echo "addMarker(".$approved_posts[$i]['lat'].",".$approved_posts[$i]['lng'].");";
                        //echo "console.log(".$approved_posts[$i]['lat'].");";
                    }
                }
        }
        ?>
  
  //map 2 - add_post
        <?php if($signed_in){ ?>
        map2 = new google.maps.Map(document.getElementById("map2"), myOptions);
        <?php } ?>
  
  //map 3 - add_cleaned_up
        <?php if(isset($_GET['page']) && ($_GET['page'] == "view_post" || $_GET['page'] == 'add_cleaned_up') && isset($post)){
    
        echo 'var postLocation = {
                lat: '.$post->getPost['p_lat'].',
                lng: '.$post->getPost['p_lng'].'
        };';   
    
        ?>
 
        map3 = new google.maps.Map(document.getElementById("map3"), myOptions);
        map3.setCenter(postLocation);
        map3.setZoom(15);
        
        var postMarker = new google.maps.Marker({
               position: postLocation,
               map: map3,
            });
        
        <?php } ?>
   
  //getting user location
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var userLocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            map2.setCenter(userLocation);
            map2.setZoom(10);
          });
       }
  //marker for map2      
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

      $("#latitude").val(location.lat);
      $("#longitude").val(location.lng);
    

    }


    </script>

    <script>
    //script for adding photos
$(function() {

  var
      max_file_number = 5,
      $form = $('form'), 
      $file_upload = $('#image_upload', $form), 
      $button = $('.submit', $form); 



  $file_upload.on('change', function () {
    var number_of_images = $(this)[0].files.length;
    if (number_of_images > max_file_number) {
      alert(`Możesz dodać maksymalnie ${max_file_number} zdjęć.`);
      $(this).val('');
    }
  });
});
    </script>

    </body>
    
</html>