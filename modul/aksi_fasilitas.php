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
$neg=$_GET[negara];

if ($module=='fasilitas' AND $act=='input'){

$ID_DIPLOMAT= $_POST[ID_DIPLOMAT];
$ID_KNT_PERWAKILAN= $_POST[ID_KNT_PERWAKILAN];
$TGL_PERMOHONAN= $_POST[TGL_PERMOHONAN];
$TGL_PERSETUJUAN= $_POST[TGL_PERSETUJUAN];
$NO_PERSETUJUAN= $_POST[NO_PERSETUJUAN];
$ID_JNS_FASILITAS= $_POST[ID_JNS_FASILITAS];
$DESKRIPSI= $_POST[DESKRIPSI];
$ST_PERSETUJUAN= $_POST[ST_PERSETUJUAN];
	if (isset($_POST[QTY]) and $_POST[QTY] != ''){
	$QTY = $_POST[QTY];} 
	else
	{$QTY = '0';}


mysql_query("insert into penggunaan_fasilitas(ID_JNS_FASILITAS,ID_DIPLOMAT,ID_KNT_PERWAKILAN,TGL_PERSETUJUAN,DESKRIPSI,NO_PERSETUJUAN,QTY,ST_PERSETUJUAN,TGL_PERMOHONAN) values ($ID_JNS_FASILITAS,$ID_DIPLOMAT,$ID_KNT_PERWAKILAN,'$TGL_PERSETUJUAN','$DESKRIPSI','$NO_PERSETUJUAN',$QTY ,$ST_PERSETUJUAN,'$TGL_PERMOHONAN')");
 
 header('location: ./deplu.php?module='.$module.'&act=lihat_fasilitas&idt='.$ID_DIPLOMAT.'&negara='.$neg);
 


}
elseif ($module=='fasilitas' AND $act=='hapus' AND isset($_GET[idt])){
	$idd = $_GET[idd];
  mysql_query("DELETE FROM penggunaan_fasilitas WHERE ID_PENGGUNAA_FAS  ='$_GET[idt]'");
header('location: ./deplu.php?module='.$module.'&act=lihat_fasilitas&idt='.$idd.'&negara='.$neg);
 

}

elseif ($module=='fasilitas' AND $act=='update' AND isset($_GET[idt])){
$idt = $_GET[idt];

$ID_PENGGUNAA_FAS= $_POST[ID_PENGGUNAA_FAS];
$ID_DIPLOMAT= $_POST[ID_DIPLOMAT];
$ID_KNT_PERWAKILAN= $_POST[ID_KNT_PERWAKILAN];
$TGL_PERMOHONAN= $_POST[TGL_PERMOHONAN];
$TGL_PERSETUJUAN= $_POST[TGL_PERSETUJUAN];
$NO_PERSETUJUAN= $_POST[NO_PERSETUJUAN];
$ID_JNS_FASILITAS= $_POST[ID_JNS_FASILITAS];
$DESKRIPSI= $_POST[DESKRIPSI];
$ST_PERSETUJUAN= $_POST[ST_PERSETUJUAN];
	if (isset($_POST[QTY]) and $_POST[QTY] != ''){
	$QTY = $_POST[QTY];} 
	else
	{$QTY = '0';}



	mysql_query(" update penggunaan_fasilitas set ID_DIPLOMAT = $ID_DIPLOMAT,
											TGL_PERSETUJUAN = '$TGL_PERSETUJUAN',
											NO_PERSETUJUAN = '$NO_PERSETUJUAN',
											DESKRIPSI = '$DESKRIPSI',
											TGL_PERMOHONAN = '$TGL_PERMOHONAN',
											ID_JNS_FASILITAS = $ID_JNS_FASILITAS,
											ST_PERSETUJUAN = '$ST_PERSETUJUAN',
											QTY = $QTY
											where ID_PENGGUNAA_FAS =  $idt");


	header('location: ./deplu.php?module='.$module.'&act=lihat_fasilitas&idt='.$ID_DIPLOMAT.'&negara='.$neg);
 
  }

}
?>
