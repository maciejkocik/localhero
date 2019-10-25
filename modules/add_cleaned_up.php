<?php

if($signed_in) {
    if(isset($_REQUEST['post_id']) && is_numeric($_REQUEST['post_id'])) {
?>
<script>
$(document).ready(function(){
    $('#addCleanedUp').modal('show');
});
</script>"; 
<?php include_once("view_post.php"); ?>

<div class="modal fade" id="addCleanedUp" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form method="POST" action="action.php" enctype="multipart/form-data">
      <div class="modal-header">
        <h4 class="modal-title" id="modalLabel">Dodaj posprzątanie</h4>
      </div>
      <div class="modal-body">
			<div class="form-group">
			<label>Opis</label>
			<textarea name="description" class="form-control" placeholder="Opis"><?php echo (isset($_GET['description']) ? $_GET['description']:''); ?></textarea>
			</div>
			<div class="form-group">
			<label>Zdjęcia</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="8388608">
			<input name="imagename[]" id="image_upload" aria-busy=""type="file" class="form-control-file" multiple accept="image/png, image/jpeg">
			</div>
          
            <input type="hidden" name="post_id" value="<?php echo $_REQUEST['post_id']; ?>">
            <input type="hidden" name="file" value="add_cleaned_up">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
        <button type="submit" class="submit btn btn-primary">Wyślij</button>
      </div>
      </form>
    </div>
  </div>
</div>   

<?php } 
} 
?>