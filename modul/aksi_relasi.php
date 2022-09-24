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
		

if ($module=='relasi' AND $act=='hapus' AND isset($_GET[idt])){
	mysql_query("DELETE FROM m_jns_relasi WHERE ID_JNS_RELASI = $_GET[idt]");
}else{
	$nm_jns_relasi = $_POST[nm_jns_relasi];
	$ket = $_POST[ket];
	
	if  ($module=='relasi' AND $act=='input'){
		mysql_query("INSERT INTO m_jns_relasi  (	NM_JNS_RELASI,
												KET) values 
												('$nm_jns_relasi','$ket')");
	
	}elseif ($module=='relasi' AND $act=='update' AND isset($_POST[idt])){
		mysql_query("update m_jns_relasi set 	NM_JNS_RELASI = '$nm_jns_relasi', 
											KET = '$ket'  where ID_JNS_RELASI= $_POST[idt] ");
	}
}
	header('location: ./deplu.php?module='.$module);
}
?>
