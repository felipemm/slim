<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$target_dir = __DIR__;
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$filetype = pathinfo($target_file,PATHINFO_EXTENSION);
$download = $_POST['download'];

if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    //if($filetype == "pdf"){
        if ($download == 'yes'){
            header("Content-Disposition: attachment; filename=\"" . basename($target_file) . "\"");
            header("Content-Type: application/force-download");
            header("Content-Length: " . filesize($target_file));
            header("Connection: close");
        } else {
            header("Content-Type: text/plain");
        }
        
        
        $file = file_get_contents($target_file);
        
        $enc = base64_encode($file);
        
        //echo base64_decode($enc);
        
        $key = sha1("felipe");
        

    //}
} else {
    echo "Sorry, there was an error uploading your file.";
}

?>