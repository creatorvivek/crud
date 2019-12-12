<?php 


   // Include and initialize ZipArchive class
require_once 'ZipArchiver.php';
$zipper = new ZipArchiver;

// Path of the directory to be zipped
$dirPath = 'http://localhost/file_handling/teacher';

// Path of output zip file
$zipPath = 'C:/'.time().'.zip';

// Create zip archive
$zip = $zipper->zipDir($dirPath, $zipPath);
echo $zip;
if($zip){
    echo 'ZIP archive created successfully.';
}else{
    echo 'Failed to create ZIP.';
}
   
?>