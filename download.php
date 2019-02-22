<?php
include_once("php/auth.php");
if( !isset($_SESSION) ){session_start();}


if ( is_logged_in()  ) {
 
    $i = 1;
    $userPIN = $_SESSION['LogInPIN'];
    $folder = "uploads/" . $userPIN . "/*.*" ;
    $tempFolder = 'photographs-' . $userPIN;
    mkdir($tempFolder);
    $getPhotoList = glob($folder);


    foreach ($getPhotoList as $photoFile) {

        $extFrmOriginal = explode('.', $photoFile);
        $ext = end($extFrmOriginal);

        $target = $tempFolder . "/" . "photo" . $i . "." . $ext; 

        copy($photoFile, $target);
        $i++;
    }
    $zipFolder = $tempFolder . "/*.*";

    $zip = new ZipArchive;
    $download = "downloads/" . $userPIN . "/weddingphotos.zip";

    $zip->open($download, ZipArchive::CREATE);
    foreach (glob($zipFolder) as $file) {
        $zip->addFile($file);
    }
    $zip->close();

    foreach (glob($zipFolder) as $file) {

        unlink($file);
    }
    rmdir($tempFolder);

    if($zip) {
        header('Content-Type: application/zip');
        header("Content-Disposition: attachment; filename = $download");
        header('Content-Length: ' . filesize($download));
        header("Location: $download");
    } else {
        header("Location: errorpage.php");
    } 
    
} else {
    header("Location: error.html");
}

?>