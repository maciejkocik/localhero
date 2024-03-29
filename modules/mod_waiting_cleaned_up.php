<?php
$error = 1;

if($signed_in && $user_mod)
{
    $post = new Post();

    if($post -> resultConnection)
    {
        $post -> getCleanedUpMod('waiting');

        if($post -> resultGetCleanedUpMod)
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
        <div class="album py-5 bg-light">
        
        <h2 class="text-center display-4" id="gallery-heading">Oczekujące posprzątania</h2>
        <div class="container">
          <div class="row">';
        if($post -> cleanedUpMod[0]['id']!= NULL)
        {
            foreach($post -> cleanedUpMod as $row)
            {
                echo'
                <div class="col-md-4">
                  <div class="card mb-4 box-shadow">
                    <div class="embed-responsive embed-responsive-4by3">
                    <a href="index.php?page=view_post&post_id='.$row['id_post'].'">
                    <img class="card-img-top embed-responsive-item" src="';
                      $directory = 'img/photos_cleaned_up/'.$row['id'];
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
                      
                      <p class="card-text">'.$row['description'].'</p>
                      <div class="d-flex justify-content-between align-items-center">
                      <a href="index.php?page=view_post&post_id='.$row['id_post'].'" class="btn btn-sm btn-outline-secondary">Zobacz</a>
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