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
		

if ($module=='subperwakilan' AND $act=='hapus' AND isset($_GET[idt])){
	mysql_query("DELETE FROM m_sub_jns_perwakilan WHERE ID_SUB_JNS = $_GET[idt]");
}else{
	$nm_sub_jns = $_POST[nm_sub_jns];
	$id_jns_perwakilan = $_POST[id_jns_perwakilan];
	$ket = $_POST[ket];


	
	if  ($module=='subperwakilan' AND $act=='input'){
		mysql_query("INSERT INTO m_sub_jns_perwakilan  (	NM_SUB_JNS,
															ID_JNS_PERWAKILAN,
															KET
															) values 
															('$nm_sub_jns','$id_jns_perwakilan','$ket')");
	
	}elseif ($module=='subperwakilan' AND $act=='update' AND isset($_POST[idt])){
		mysql_query("update m_sub_jns_perwakilan set 	NM_SUB_JNS = '$nm_sub_jns', 
														ID_JNS_PERWAKILAN='$id_jns_perwakilan',
														KET = '$ket'  where ID_SUB_JNS= $_POST[idt] ");
	}
}
	header('location: ./deplu.php?module='.$module);
}
?>
