<?php
//addressbar query
$url = $_SERVER['QUERY_STRING'];
$query = substr($url,4);
$fileList = explode(",",$query);
//zip
$zip = new ZipArchive();
$time = time();
$md5 = md5($time);
$filename = "$md5.zip";

if ($zip->open("./cache/$filename", ZipArchive::CREATE)!==TRUE) {
	exit("cannot open <$filename>\n");
}

foreach ($fileList as $img_filename) {
    //img file url
    $preview = '../../images/ship_previews/'.$img_filename.'.png';
	$preview_ds = '../../images/ship_previews_ds/'.$img_filename.'.png';
    $shipname = substr($img_filename,0,7);
    //add file to zip
    $zip->addFile($preview,"/gui/ship_previews/$shipname.png");
    $zip->addFile($preview_ds,"/gui/ship_previews_ds/$shipname.png");
}

$zip->close();

//download as zip
header("Content-type: application/zip"); 
header("Content-Disposition: attachment; filename=res_mod.zip"); 
//prevent cache
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
//read files
readfile("./cache/$filename");
?>