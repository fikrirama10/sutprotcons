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
		
if ($module=='rank' AND $act=='hapus' AND isset($_GET[idt])){
	mysql_query("DELETE FROM  rank WHERE ID_RANK = $_GET[idt]");
}else{
	$NM_RANK = $_POST[NM_RANK];
	$KODE_LAYANAN = $_POST[KODE_LAYANAN];
	$KET = $_POST[KET];
	$ID_RANK = $_POST[ID_RANK];

	if  ($module=='rank' AND $act=='input'){
		mysql_query("INSERT INTO rank  (	NM_RANK,KODE_LAYANAN,
												KET) values 
												('$NM_RANK','$KODE_LAYANAN','$KET')");
	
	}elseif ($module=='rank' AND $act=='update' AND isset($_POST[idt])){
		mysql_query("update rank set 	NM_RANK = '$NM_RANK', KODE_LAYANAN = '$KODE_LAYANAN',
											KET = '$KET'  where ID_RANK= $_POST[idt] ");
	}
}
	header('location: ./deplu.php?module='.$module);
}
?>
