<?php

if($signed_in)
{
    echo '
    

   

    <FORM method="POST" action="action.php" enctype="multipart/form-data">
    

    <script>
    $(function() {

        var // Define maximum number of files.
            max_file_number = 10,
            // Define your form id or class or just tag.
            $form = $(\'FORM\'), 
            // Define your upload field class or id or tag.
            $file_upload = $(\'#image\', $form), 
            // Define your submit class or id or tag.
            $button = $(\'.submit\', $form); 
      
        // Disable submit button on page ready.
        $button.prop(\'disabled\', \'disabled\');
      
        $file_upload.on(\'change\', function () {
          var number_of_images = $(this)[0].files.length;
          if (number_of_images > max_file_number) {
            alert(`You can upload maximum ${max_file_number} files.`);
            $(this).val(\'\');
            $button.prop(\'disabled\', \'disabled\');
          } else {
            $button.prop(\'disabled\', false);
          }
        });
      });
      </script>


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
}
else
{
    include_once('modules/sign_in.php');
}
?>