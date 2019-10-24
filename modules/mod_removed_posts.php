<?php
$error = 1;

if($signed_in && $user_mod)
{
    $post = new Post();

    if($post -> resultConnection)
    {
        $post -> getPostsMod('removed');

        if($post -> resultGetPostsMod)
        {
            $error = -1;
        }
    }
}

switch($error)
{
    case 1:
    {
        echo '<p>Wystąpił błąd.</p>';
        break;
    }
    case -1:
    {

        echo 
        '
        <style>
        .embed-responsive .card-img-top {
            object-fit: cover;
        }
                </style>





        <div class="album py-5 bg-light">
        
        <h2 class="text-center display-3" id="gallery-heading">Wpisy usunięte lub ustawione jako prywatne</h2>
        <div class="container">
          <div class="row">';
        if($post -> postsMod[0]['id']!= NULL)
        {
            foreach($post -> postsMod as $row)
            {
                echo'
                <div class="col-md-4">
                  <div class="card mb-4 box-shadow">
                    <div class="embed-responsive embed-responsive-4by3">
                    <a href="index.php?page=view_post&post_id='.$row['id'].'">
                    <img class="card-img-top embed-responsive-item" src="';
                      $directory = 'img/photos_posts/'.$row['id'];
                      if(is_dir($directory))
                      {
                        $files = scandir ($directory);
                        echo $directory . '/' . $files[2];
                      }
                      else
                      {
                        echo 'img/logo1.png';
                      }
                      
                      echo '" alt="Card image cap"></a>
                      </div>
                    <div class="card-body">
                      <h5 class="card-title">'.$row['title'].'</h5>
                      <p class="card-text">'.$row['description'].'</p>
                      <div class="d-flex justify-content-between align-items-center">
                      <a href="index.php?page=view_post&post_id='.$row['id'].'<button type="button" class="btn btn-sm btn-outline-secondary">Zobacz</button></a>
                        <small class="text-muted">'.$row['date'].'</small>
                      </div>
                    </div>
                    </div>
                  </div>';
            }
        }
        else
        {
            echo '<p>Brak treści do wyświetlenia.</p>';
        }
        break;
    }
}
?>