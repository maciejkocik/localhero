<?php
$error = 1;

if(isset($_REQUEST['post_id']) && is_numeric($_REQUEST['post_id'])
&& isset($_REQUEST['reaction']) && $_REQUEST['reaction'] == 1 or $_REQUEST['reaction'] == 0 or $_REQUEST['reaction'] == -1)
{
    $post_id = $_REQUEST['post_id'];
    $reaction = $_REQUEST['reaction'];
    $post = new Post();

    if($post -> resultConnection)
    {
        $post -> getOnlyPost($);
    }
}

header('Location:index.php?error='.$error);
exit;
?>