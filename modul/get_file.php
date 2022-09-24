<?php
$path = "../files/otvis/notadinas/";
$filename = $_GET['fn'];
$filename=$path.$filename; //<-- specify the image  file
  if(file_exists($filename)){
    $mime = mime_content_type($filename); //<-- detect file type
    header('Content-Length: '.filesize($filename)); //<-- sends filesize header
    header("Content-Type: $mime"); //<-- send mime-type header
    header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
    readfile($filename); //<--reads and outputs the file onto the output buffer
    die(); //<--cleanup
    exit; //and exit
  } else {
    echo "file not found!";
  }
?>
