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

if ($module=='rantorKjual' AND $act=='batal_rantorKjual' AND isset($_GET[idt])){

	$idd = $_GET[idd];



	mysql_query(" update penggunaan_fasilitas set NO_IZIN_JUAL = NULL,
											TGL_IZIN_JUAL = NULL,
											ALASAN_PENJUALAN = NULL,
											REKOMENDASI_BENGKEL = NULL,
											NAMA_PEMBELI = NULL,
											ALAMAT_PEMBELI = NULL,
											NO_KTP_PEMBELI = NULL
											where ID_PENGGUNAA_FAS =  $idt");

//  mysql_query("DELETE FROM penggunaan_fasilitas WHERE ID_PENGGUNAA_FAS  ='$_GET[idt]'");
header('location: ./deplu.php?module='.$module.'&act=lihat_rantorKjual&idt='.$idd.'&negara='.$neg);
 

}

elseif ($module=='rantorKjual' AND $act=='update' AND isset($_GET[idt])){
$idt = $_GET[idt];

$ID_PENGGUNAA_FAS= $_POST[ID_PENGGUNAA_FAS];
$ID_DIPLOMAT= $_POST[ID_DIPLOMAT];
$ID_KNT_PERWAKILAN= $_POST[ID_KNT_PERWAKILAN];

$NO_IZIN_JUAL= $_POST[NO_IZIN_JUAL];
$TGL_IZIN_JUAL= $_POST[TGL_IZIN_JUAL];
$ALASAN_PENJUALAN= $_POST[ALASAN_PENJUALAN];
$REKOMENDASI_BENGKEL= $_POST[REKOMENDASI_BENGKEL];
$NAMA_PEMBELI= $_POST[NAMA_PEMBELI];
$ALAMAT_PEMBELI= $_POST[ALAMAT_PEMBELI];
$NO_KTP_PEMBELI= $_POST[NO_KTP_PEMBELI];



	mysql_query(" update penggunaan_fasilitas set NO_IZIN_JUAL = '$NO_IZIN_JUAL',
											TGL_IZIN_JUAL = '$TGL_IZIN_JUAL',
											ALASAN_PENJUALAN = '$ALASAN_PENJUALAN',
											REKOMENDASI_BENGKEL = '$REKOMENDASI_BENGKEL',
											NAMA_PEMBELI = '$NAMA_PEMBELI',
											ALAMAT_PEMBELI = '$ALAMAT_PEMBELI',
											NO_KTP_PEMBELI = '$NO_KTP_PEMBELI'
											where ID_PENGGUNAA_FAS =  $idt");


	header('location: ./deplu.php?module='.$module.'&act=lihat_rantorKjual&idt='.$ID_KNT_PERWAKILAN.'&negara='.$neg);
 
  }

}
?>
