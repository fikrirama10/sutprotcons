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
		

if ($module=='paspor' AND $act=='hapus' AND isset($_GET[idt])){
	mysql_query("DELETE FROM m_jns_paspor WHERE ID_JNS_PASPOR = $_GET[idt]");
}else{
	$jns_paspor = $_POST[jns_paspor];
	$kd_jns_paspor = $_POST[kd_jns_paspor];
	$ket = $_POST[ket];
	
	if  ($module=='paspor' AND $act=='input'){
		mysql_query("INSERT INTO m_jns_paspor  (	JNS_PASPOR,
												KD_JNS_PASPOR,
												KET) values 
												('$jns_paspor','$kd_jns_paspor','$ket')");
	
	}elseif ($module=='paspor' AND $act=='update' AND isset($_POST[idt])){
		mysql_query("update m_jns_paspor set 	JNS_PASPOR = '$jns_paspor', 
											KD_JNS_PASPOR= '$kd_jns_paspor', 
											KET = '$ket'  where ID_JNS_PASPOR= $_POST[idt] ");
	}
}
	header('location: ./deplu.php?module='.$module);
}
?>
