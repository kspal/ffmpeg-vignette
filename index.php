<?php
if ( (count($argv)==1)||(count($argv)>3) ) {
	echo "usage: index.php dir [file]\n";
	exit();
}
/**
 * [process_file description]
 * @param  [type] $thumb_dir [description]
 * @param  [type] $file      [description]
 * @return [type]            [description]
 */
function process_file($thumb_dir,$file) {
  if ( ($file->isFile())&&(strtolower($file->getExtension())=="mp4") ) {
    //
    $str_command= '"C:\Program Files (x86)\FFmpeg for Audacity\ffmpeg.exe" -ss 0 -i "'.$file->getPathname().'" -qscale:v 2 -vframes 1 "'.$file->getPath()."\\".$thumb_dir."\\".$file->getBasename('.'.$file->getExtension()).'.jpg"';
    echo $str_command."\n";
		shell_exec($str_command);
  }
}

$thumb_dir="thumbnails";
$dir_src = $argv[1];

//process for one file in one directory 
if (array_key_exists(2, $argv)) {
	$file = new SplFileInfo($dir_src.DIRECTORY_SEPARATOR.$argv[2]);
	echo $file->getPathname()."\n";
	process_file($thumb_dir,$file);
	exit();
}

//process for files in one directory
$dir_iterator = new RecursiveDirectoryIterator($dir_src);
$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
foreach ($iterator as $file) {
	echo $file->getPathname()."\n";
	process_file($thumb_dir,$file);
}



 
?>