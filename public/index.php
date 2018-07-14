<?php
header("Content-Type: text/text");
 //the following code will delete images in the /i/ folder after 30 days, you can delete/comment it out if you want.
$days = 30;
$dir = "";
 
$nofiles = 0;
 
    if ($handle = opendir('./')) {
    while (( $file = readdir($handle)) !== false ) {
        if ( $file == '.' || $file == '..' || $file == '.htaccess'|| $file == 'index.php' || is_dir($dir.'/'.$file) ) {
            continue;
        }
 
        if ((time() - filemtime($dir.'/'.$file)) > ($days *84600)) {
            $nofiles++;
            unlink($dir.'/'.$file);
        }
    }
    closedir($handle);
}
 
$key = "PASSWORD_HERE";
$uploadhost = "https://i.your.tld";
$redirect = "http://your.tld";
  
if (isset($_POST['user'])) {
    if ($_POST['user'] == $key) {
        $target = getcwd() . "/" . basename($_FILES['form']['name']);
        if (move_uploaded_file($_FILES['form']['tmp_name'], $target)) {
            $md5 = md5_file(getcwd() . "/" . basename($_FILES['form']['name']));
            rename(getcwd() . "/" . basename($_FILES['form']['name']), getcwd() . "/" . $md5 . "." . end(explode(".", $_FILES["form"]["name"])));
            echo $uploadhost . "/" . $md5 . "." . end(explode(".", $_FILES["form"]["name"]));
        } else {
            echo "Sorry, there was a problem uploading your file.";
        }
    } else {
        header('Location: '.$redirect);
    }
} else {
    header('Location: '.$redirect);
}
?>