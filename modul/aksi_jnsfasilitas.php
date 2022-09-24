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
		

if ($module=='jnsfasilitas' AND $act=='hapus' AND isset($_GET[idt])){
	mysql_query("DELETE FROM m_jns_fasilitas WHERE ID_JNS_FASILITAS = $_GET[idt]");
}else{
	$jns_fasilitas = $_POST[jns_fasilitas];
	$ket = $_POST[ket];
	
	if  ($module=='jnsfasilitas' AND $act=='input'){
		mysql_query("INSERT INTO m_jns_fasilitas  (	JNS_FASILITAS,
												KET) values 
												('$jns_fasilitas','$ket')");
	
	}elseif ($module=='jnsfasilitas' AND $act=='update' AND isset($_POST[idt])){
		mysql_query("update m_jns_fasilitas set 	JNS_FASILITAS = '$jns_fasilitas', 
											KET = '$ket'  where ID_JNS_FASILITAS= $_POST[idt] ");
	}
}
	header('location: ./deplu.php?module='.$module);
}
?>
