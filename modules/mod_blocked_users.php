<?php
$error = 1;

if($signed_in && $user_mod)
{
    $user = new User();

    if($user -> resultConnection)
    {
        $user -> getBlockedUsersMod();

        if($user -> resultGetBlockedUsersMod)
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
        
        <h2 class="text-center display-4" id="gallery-heading">Zablokowani użytkownicy</h2>
        <div class="container">
          <div class="row">';
        if($user -> blockedUsersMod[0]['id']!= NULL)
        {
            foreach($user -> blockedUsersMod as $row)
            {
                echo'
                <div class="col-md-4">
                  <div class="card mb-4 box-shadow">
                    
                    <div class="card-body">
                      <h5 class="card-title">'.$row['login'].'</h5>
                      <div class="d-flex justify-content-between align-items-center">
                      <a href="index.php?page=view_user&user_id='.$row['id'].'" class="btn btn-sm btn-outline-secondary">Zobacz</a>
                        <small class="text-muted">Dołączył: '.$row['date'].'</small>
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