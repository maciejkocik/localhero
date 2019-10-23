<?php

if($signed_in){
    if(isset($_GET['page'])) {
        if($_GET['page'] == "add_post") {
        echo "
        <script>
        $(document).ready(function(){
            $('#addPost').modal('show');
        });
        </script>"; 
        include_once("main_page.php");
        }
    }
?>   



<div class="modal fade" id="addPost" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form method="POST" action="action.php" enctype="multipart/form-data">
      <div class="modal-header">
        <h4 class="modal-title" id="modalLabel">Zgłoś problem</h4>
      </div>
      <div class="modal-body">
            <div class="form-group">
			<label>Tytuł</label>
			<input type="text" name="title" class="form-control" placeholder="Tytuł"
            <?php echo (isset($_GET['title']) ? 'value="'.$_GET['title'].'"':''); ?>
            maxlength=400 minlength=3 required>
            </div>
			<div class="form-group">
			<label>Opis</label>
			<textarea name="desc" class="form-control" placeholder="Opis"><?php echo (isset($_GET['description']) ? $_GET['description']:''); ?></textarea>
			</div>
			<div class="form-group">
			<label>Lokalizacja</label>
            <div id="map2"></div>

            <input id="latitude" name="latitude" type="hidden" value="" />
            <input id="longitude" name="longitude" type="hidden" value="" />
            
			</div>
			<div class="form-group">
			<label>Zdjęcia</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="8388608">
			<input name="imagename[]" id="image_upload" aria-busy=""type="file" class="form-control-file" multiple accept="image/png, image/jpeg">
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
        <button type="submit" class="submit btn btn-primary">Wyślij</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--
    echo '
    

   

    <FORM method="POST" action="action.php" enctype="multipart/form-data">
    




    <h1>Dodawanie wpisu</h1>';
    
    if(isset($_GET['error']))
    {
        if($_GET['error'] == 1)
        {
            echo '<p>Wystąpił błąd, spróbuj ponownie</p>';
        }
    }
    
    echo '
    Tytuł: <input type="text" name="title" '.(isset($_GET['title']) ? 'value="'.$_GET['title'].'"':'').' maxlength=400 minlength=3 required>

    Dodaj zdjęcia (jpg, png): <input type="file" id="image" name="imagename[]" '.(isset($_GET['image_name']) ? 'value="'.$_GET['image_name'].'"':'').' multiple accept="image/png, image/jpeg" &gt><br><br>
    
    '.(isset($_GET['photos_error']) ? '<p>Wystąpił błąd ze zdjęciami. Pamiętaj, że możesz załadować maksymalnie 10 zdjęć.</p>':'').' 

    Opis: <textarea name="description">'.(isset($_GET['description']) ? $_GET['description']:'').'</textarea>
    <input type="hidden" name="lat" value="'.(isset($_GET['lat']) ? $_GET['lat']:'0').'">
    <input type="hidden" name="lng" value="'.(isset($_GET['lng']) ? $_GET['lng']:'0').'">
    <input type="hidden" name="file" value="add_post">
    <input type="submit">
    ';
-->
<?php           
} else header("Location:index.php?page=sign_in");
?>