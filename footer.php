
        <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.6/holder.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


        <script>
$(function() {

  var
      max_file_number = 5,
      $form = $('form'), 
      $file_upload = $('#image_upload', $form), 
      $button = $('.submit', $form); 

  $button.prop('disabled', 'disabled');

  $file_upload.on('change', function () {
    var number_of_images = $(this)[0].files.length;
    if (number_of_images > max_file_number) {
      alert(`Możesz dodać maksymalnie ${max_file_number} zdjęć.`);
      $(this).val('');
      $button.prop('disabled', 'disabled');
    } else {
      $button.prop('disabled', false);
    }
  });
});
    </script>

    </body>
    
</html>