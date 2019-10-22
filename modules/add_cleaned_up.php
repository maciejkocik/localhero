<?php

if($signed_in)
{
  if(isset($_REQUEST['post_id']) && is_numeric($_REQUEST['post_id']))
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


    <h1>Dodawanie Posprzątania problemu</h1>';
    
    if(isset($_GET['error']))
    {
        if($_GET['error'] == 1)
        {
            echo '<p>Wystąpił błąd, spróbuj ponownie</p>';
        }
    }
    
    echo '

    Dodaj zdjęcia (jpg, png): <input type="file" id="image" name="imagename[]" '.(isset($_GET['image_name']) ? 'value="'.$_GET['image_name'].'"':'').' multiple accept="image/png, image/jpeg" &gt><br><br>
    
    '.(isset($_GET['photos_error']) ? '<p>Wystąpił błąd ze zdjęciami. Pamiętaj, że możesz załadować maksymalnie 10 zdjęć.</p>':'').' 

    Opis: <textarea name="description">'.(isset($_GET['description']) ? $_GET['description']:'').'</textarea>
    <input type="hidden" name="file" value="add_cleaned_up">
    <input type="hidden" name="post_id" value="'.$_REQUEST['post_id'].'">
    <input type="submit">
    ';
  }
  else
  {
    echo '<p>Wystąpił błąd.</p>';
  }
}
else
{
    include_once('modules/sign_in.php');
}
?>