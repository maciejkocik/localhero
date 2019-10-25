
 <main role="main">
     <section class="jumbotron text-center">
        <div class="container">
        <img id="main-logo" src="img/logo1.png">
          <h1 class="jumbotron-heading">LocalHero</h1>
          <p class="lead text-muted">LocalHero to serwis pozwalający Ci zwrócić uwagę społeczeństwa na różne problemy pogarszające stan środowiska.</p>
          <!--
            <p class="lead text-muted">Możesz zgłosić nielegalne wysypiska śmieci, spalanie niedozwolonych przedmiotów lub jakąkolwiek inną formę zanieczysczania środowiska. W przypadku polepszenia sytuacji każdy użytkownik może o tym napisać.</p>
          -->
          <p class="lead text-muted">Globalne problemy zanieczyszczenia środowiska należy zacząć rozwiązywać od spraw lokalnych. Pamiętaj, przyszłość planety zależy od Ciebie!</p>
          <?php if(!$signed_in):?>
          <p>
            <a href="index.php?page=sign_in" class="btn btn-primary my-2">Zaloguj się</a>
            <a href="index.php?page=registration" class="btn btn-secondary my-2">Zarejestruj się</a>
          </p>
          <?php else:?>
          <p>
            <a class="btn btn-primary" data-toggle="modal" data-target="#addPost" style="cursor:pointer; color:#fff;">Dodaj problem</a>
          </p>
          <?php endif; ?>
            
        </div>
      </section>
     
    <div id="map"></div>
    

      <div class="album py-5 bg-light">
        <?php
        $error = 1;

        $post = new Post();

        if($post -> resultConnection)
        {
          $post -> getPopularPosts();
          $post -> getNewPosts();

          if($post -> resultGetPopularPosts && $post -> resultGetNewPosts)
          {
            $error = -1;
          }
        }


        if($error = -1):
        ?>
        <style>

.embed-responsive .card-img-top {
    object-fit: cover;
}

        </style>



        <h2 class="text-center display-4" id="gallery-heading">Wyróżnione problemy</h2>
        <div class="container">
          <div class="row">
            <?php for($i = 0; $i <= 2 && isset($post -> popularPosts[$i]['id']) && $post -> popularPosts[$i]['id'] != NULL; $i++): ?>
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <div class="embed-responsive embed-responsive-4by3">
                <a href="index.php?page=view_post&post_id=<?php echo $post -> popularPosts[$i]['id'];?>">
                <img class="card-img-top embed-responsive-item" src="<?php
                  $directory = 'img/photos_posts/'.$post -> popularPosts[$i]['id'];
                  if(is_dir($directory))
                  {
                    $files = scandir ($directory);
                    echo $directory . '/' . $files[2];
                  }
                  else
                  {
                    echo 'img/logo1.png';
                  }
                  ?>" alt="Card image cap"></a>
                  </div>
                <div class="card-body">
                  <h5 class="card-title"><?php echo $post -> popularPosts[$i]['title'];?></h5>
                  <p class="card-text"><?php echo $post -> popularPosts[$i]['description'];?></p>
                  <div class="d-flex justify-content-between align-items-center">
                  <a href="index.php?page=view_post&post_id=<?php echo $post -> popularPosts[$i]['id'];?>"><button type="button" class="btn btn-sm btn-outline-secondary">Zobacz</button></a>
                    <small class="text-muted"><?php echo $post -> popularPosts[$i]['date'];?></small>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="d-flex justify-content-between align-items-center">
                  <small class="text-muted"><i class="material-icons">thumb_up</i>  <?php echo $post -> popularPosts[$i]['likes'];?></small>
                  <small class="text-muted"><i class="material-icons">thumb_down</i>  <?php echo $post -> popularPosts[$i]['dislikes'];?></small>
                </div>
                </div>
              </div>
            </div>
            <?php endfor; ?>
          </div>
        </div>

        <h2 class="text-center display-4" id="gallery-heading">Najnowsze</h2>
        <div class="container">
          <div class="row">
          <?php for($i = 0; $i <= 2 && isset($post -> newPosts[$i]['id']) && $post -> newPosts[$i]['id'] != NULL; $i++): ?>
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <div class="embed-responsive embed-responsive-4by3">
                <a href="index.php?page=view_post&post_id=<?php echo $post -> newPosts[$i]['id'];?>">
                <img class="card-img-top embed-responsive-item" src="<?php
                  $directory = 'img/photos_posts/'.$post -> newPosts[$i]['id'];
                  if(is_dir($directory))
                  {
                    $files = scandir ($directory);
                    echo $directory . '/' . $files[2];
                  }
                  else
                  {
                    echo 'img/logo1.png';
                  }
                  ?>" alt="Card image cap"></a>
                  </div>
                <div class="card-body">
                  <h5 class="card-title"><?php echo $post -> newPosts[$i]['title'];?></h5>
                  <p class="card-text"><?php echo $post -> newPosts[$i]['description'];?></p>
                  <div class="d-flex justify-content-between align-items-center">
                  <a href="index.php?page=view_post&post_id=<?php echo $post -> newPosts[$i]['id'];?>"><button type="button" class="btn btn-sm btn-outline-secondary">Zobacz</button></a>
                    <small class="text-muted"><?php echo $post -> newPosts[$i]['date'];?></small>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="d-flex justify-content-between align-items-center">
                  <small class="text-muted"><i class="material-icons">thumb_up</i>  <?php echo $post -> newPosts[$i]['likes'];?></small>
                  <small class="text-muted"><i class="material-icons">thumb_down</i>  <?php echo $post -> newPosts[$i]['dislikes'];?></small>
                </div>
                </div>
              </div>
            </div>
            <?php endfor; ?>
          </div>
        </div>

        <?php endif;
        if($error != -1)
        {
          echo '<p>Wystąpił błąd;</p>';
        } ?>

      </div>

    </main>