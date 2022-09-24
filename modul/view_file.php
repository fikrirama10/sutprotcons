<?php
$filename = $_GET['fn'];
$path = "/mnt/www/home/layanan_diplomatik/www/files/diplomatic_notes/";
$file = $path.$filename;
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: inline; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
  }
  ?>
