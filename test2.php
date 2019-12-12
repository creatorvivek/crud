<?php 
$pathdir="v";
$nameArchive="myfile.zip";
$zip=new zipArchive();
	if($zip->open($nameArchive,zipArchive::CREATE)===TRUE)
	{

		$dir=opendir($pathdir);
		while($file=readdir($dir))
		{
			if(is_file($pathdir.$file))
			{
				$zip->addFile($pathdir.$file,$file);
			}
		}
	}
   // print_r($zip);


// echo $_SERVER['PHP_SELF'];
	echo $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
die;
   ##for downloading file

$dfilep = 'http://localhost/file_handling/data.php';
$dfile = 'data.php';

if(!file_exists($dfile)){ // file does not exist
    die('file not found');
} else {
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$dfile");
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");

    // read the file from disk
    // readfile($dfilep);
}
?>