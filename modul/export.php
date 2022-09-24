<?php
session_start();
$filename="report.xls";

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

if (!empty($_SESSION['reportdata'])){
	echo $_SESSION['reportdata'];
	unset($_SESSION['reportdata']);
}

?>
