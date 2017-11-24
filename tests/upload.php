<?php

require __DIR__ . '/vendor/autoload.php';

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$filetype = pathinfo($target_file,PATHINFO_EXTENSION);
$download = $_POST['download'];

if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    if($filetype == "pdf"){
        if ($download == 'yes'){
            header("Content-Disposition: attachment; filename=\"" . basename($target_file.".txt") . "\"");
            header("Content-Type: application/force-download");
            header("Content-Length: " . filesize($target_file.".txt"));
            header("Connection: close");
        } else {
            header("Content-Type: text/plain");
        }


        $log = new Monolog\Logger('pdf2txt');
        $log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::DEBUG));

        $transcoder = Ghostscript\Transcoder::create(array(
            'timeout' => 42,
            'gs.binaries' => '/usr/bin/gs',
        ), $log);
        $transcoder->toText($target_file, $target_file.".txt", 1, 1);
        
        
        $fp = fopen($target_file.".txt", "r");
        fpassthru($fp);
        fclose($fp);
            
        unlink($target_file); 
        unlink($target_file.".txt"); 
    }
} else {
    echo "Sorry, there was an error uploading your file.";
}

?>