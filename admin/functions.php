<?php

function need_to_sign_in_in_action()
{
    header('Location:index.html?page=sign_in&write_text=1');
    exit;
}

function delete_directory($dirname)
{
        if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                    unlink($dirname."/".$file);
            else
                    delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}


?>