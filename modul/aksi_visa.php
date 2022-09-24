<?php
//session_start();

session_start();
$template = file("../template/canvasawal.htm");
$template = implode("",$template ); 

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){
	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{


include "../config/koneksi.php";
include "../config/library.php";

$module=$_GET[module];
$act=$_GET[act];
$idt=$_GET[idt];
		

if ($module=='visa' AND $act=='hapus' AND isset($_GET[idt])){
	mysql_query("DELETE FROM m_jns_visa WHERE ID_JNS_VISA = $_GET[idt]");
}else{
	$nm_jns_visa = $_POST[nm_jns_visa];
	$kd_jns_visa = $_POST[kd_jns_visa];
	$ket = $_POST[ket];
	
	if  ($module=='visa' AND $act=='input'){
		mysql_query("INSERT INTO m_jns_visa  (	NM_JNS_VISA,
												KD_JNS_VISA,
												KET) values 
												('$nm_jns_visa','$kd_jns_visa','$ket')");
	
	}elseif ($module=='visa' AND $act=='update' AND isset($_POST[idt])){
		mysql_query("update m_jns_visa set 	NM_JNS_VISA = '$nm_jns_visa', 
											KD_JNS_VISA= '$kd_jns_visa', 
											KET = '$ket'  where ID_JNS_VISA= $_POST[idt] ");
	}
}
	header('location: ./deplu.php?module='.$module);
}
?>
