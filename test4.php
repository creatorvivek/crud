

<?php 
  define('ROOTPATH', __DIR__);
  $rp= ROOTPATH;
// echo $rp;
//   die;

// Get real path for our folder
$rootPath = realpath('teacher');

// Initialize archive object
$zip = new ZipArchive();
$zip->open('file.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);
// print_r($files);die;
foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}
$filename = 'file.zip';
$filepath="".$rp."/file.zip";
// $files_to_zip = ['demo1.jpg', 'demo2.jpg'];
// $result = createZip($files_to_zip, $fileName);

// header("Pragma: public");
// header("Expires: 0");
// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
// header("Cache-Control: public");
// header("Content-Description: File Transfer");
// header("Content-type: application/octet-stream");
// header('Content-Disposition: attachment; filename="'.$filename.'"');
// header("Content-Transfer-Encoding: binary");
// header("Content-Length: ".filesize($filepath));
// ob_end_flush();
// @readfile($filepath);
header("Content-type: application/zip"); 
header("Content-Disposition: attachment; filename=".$filename."");
header("Content-length: " . filesize($filepath));
header("Pragma: no-cache"); 
header("Expires: 0"); 
readfile($filename);




  die();
// Enter the name of directory 
$pathdir = "teacher/";  
// $pathdir = "teacher";  
  if(!file_exists("teacher"))
  {
  	echo "yes";
  }
// Enter the name to creating zipped directory 
$zipcreated = "teacher.zip"; 
  
// Create new zip class 
$zip = new ZipArchive; 
   
if($zip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) { 
      
    // Store the path into the variable 
    $dir = opendir($pathdir); 
       
    while($file = readdir($dir)) { 
        if(is_file($pathdir.$file)) { 
            $zip -> addFile($pathdir.$file, $file); 
        } 
    } 
    $zip ->close(); 
} 
  $zip = new ZipArchive; 
  
// Add zip filename which need 
// to unzip 
$zip->open('teacher.zip'); 
  
// Extracts to current directory 
$zip->extractTo('./'); 
  
$zip->close();  



?> 