<?php
$filename = $_GET['fn'];
// live
$path = "/mnt/www/home/layanan_diplomatik/www/upload/kml/";
// dev
//$path = "/home/admin/domains/ccs.co.id/public_html/kml/upload/kml/";
$file = $path.$filename;
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: inline; filename="'.basename($filename).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}