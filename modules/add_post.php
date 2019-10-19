<?php

if($signed_in)
{
    echo '
    <script>
    $("#image").on("change", function() {
        if ($("#image")[0].files.length > 10) {
            alert("Możesz dodać tylko 10 zdjęć");
        } else {
            $("#imageUploadForm").submit();
        }
    });
    </script>
    
    
    
    <FORM method="POST" action="action.php" enctype="multipart/form-data">
    
    <h1>Dodawanie wpisu</h1>
    
    Tytuł: <input type="text" name="title" maxlength=400 minlength=3 required>

    Dodaj zdjęcia (jpg, png, maksymalnie 10): <input type="file" name="imagename[]" multiple accept="image/png, image/jpeg"><br><br>
    
    Opis: <textarea name="description"></textarea>';
}
else
{
    need_to_sign_in();
}
?>