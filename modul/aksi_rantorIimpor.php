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

if ($module=='rantorIimpor' AND $act=='input'){

$ID_DIPLOMAT= $_POST[ID_DIPLOMAT];
$ID_KNT_PERWAKILAN= $_POST[ID_KNT_PERWAKILAN];
//$TGL_PERSETUJUAN= $_POST[TGL_PERSETUJUAN];
//$NO_PERSETUJUAN= $_POST[NO_PERSETUJUAN];
$DESKRIPSI= $_POST[DESKRIPSI];
$MEREK= $_POST[MEREK];
$TAHUN= $_POST[TAHUN];
$NO_POLISI= $_POST[NO_POLISI];
$NO_MESIN= $_POST[NO_MESIN];

$NO_IZIN_IMPOR= $_POST[NO_IZIN_IMPOR];
$TGL_IZIN_IMPOR= $_POST[TGL_IZIN_IMPOR];
$ST_PERSETUJUAN= $_POST[ST_PERSETUJUAN];
/*
$PELABUHAN_IMPOR= $_POST[PELABUHAN_IMPOR];
$KAPAL_IMPOR= $_POST[KAPAL_IMPOR];
$TGL_TIBA_IMPOR= $_POST[TGL_TIBA_IMPOR];
$TGL_SURAT_IMPOR= $_POST[TGL_SURAT_IMPOR];
$PEMOHON_IMPOR= $_POST[PEMOHON_IMPOR];
$JABATAN_IMPOR= $_POST[JABATAN_IMPOR];
$APPROVAL_IMPOR= $_POST[APPROVAL_IMPOR];
$NIP_APPROVAL_IMPOR= $_POST[NIP_APPROVAL_IMPOR];

$NO_IZIN_JUAL= $_POST[NO_IZIN_JUAL];
$TGL_IZIN_JUAL= $_POST[TGL_IZIN_JUAL];
$ALASAN_PENJUALAN= $_POST[ALASAN_PENJUALAN];
$REKOMENDASI_BENGKEL= $_POST[REKOMENDASI_BENGKEL];
$NAMA_PEMBELI= $_POST[NAMA_PEMBELI];
$ALAMAT_PEMBELI= $_POST[ALAMAT_PEMBELI];
$NO_KTP_PEMBELI= $_POST[NO_KTP_PEMBELI];
*/



//mysql_query("insert into penggunaan_fasilitas(ID_JNS_FASILITAS,ID_DIPLOMAT,ID_KNT_PERWAKILAN,TGL_PERSETUJUAN,DESKRIPSI,NO_PERSETUJUAN,QTY,ST_PERSETUJUAN,JNS_TRANS_FAS,MEREK,TAHUN,NO_POLISI,NO_MESIN,NO_IZIN_IMPOR,TGL_IZIN_IMPOR,NO_NOTE_IMPOR,PELABUHAN_IMPOR,KAPAL_IMPOR,TGL_TIBA_IMPOR,TGL_SURAT_IMPOR,PEMOHON_IMPOR,JABATAN_IMPOR,APPROVAL_IMPOR,NIP_APPROVAL_IMPOR,NO_IZIN_JUAL,TGL_IZIN_JUAL,ALASAN_PENJUALAN,REKOMENDASI_BENGKEL,NAMA_PEMBELI,ALAMAT_PEMBELI,NO_KTP_PEMBELI) values (2,$ID_DIPLOMAT,$ID_KNT_PERWAKILAN,'$TGL_PERSETUJUAN','$DESKRIPSI','$NO_PERSETUJUAN',1,0,0,'$MEREK','$TAHUN','$NO_POLISI','$NO_MESIN','$NO_IZIN_IMPOR','$TGL_IZIN_IMPOR','$NO_NOTE_IMPOR','$PELABUHAN_IMPOR','$KAPAL_IMPOR','$TGL_TIBA_IMPOR','$TGL_SURAT_IMPOR','$PEMOHON_IMPOR','$JABATAN_IMPOR','$APPROVAL_IMPOR','$NIP_APPROVAL_IMPOR','$NO_IZIN_JUAL','$TGL_IZIN_JUAL','$ALASAN_PENJUALAN','$REKOMENDASI_BENGKEL','$NAMA_PEMBELI','$ALAMAT_PEMBELI','$NO_KTP_PEMBELI')");

mysql_query("insert into penggunaan_fasilitas(ID_JNS_FASILITAS,ID_DIPLOMAT,ID_KNT_PERWAKILAN,DESKRIPSI,QTY,ST_PERSETUJUAN,MEREK,TAHUN,NO_POLISI,NO_MESIN,NO_IZIN_IMPOR,TGL_IZIN_IMPOR) values (2,$ID_DIPLOMAT,$ID_KNT_PERWAKILAN,'$DESKRIPSI',1,$ST_PERSETUJUAN,'$MEREK','$TAHUN','$NO_POLISI','$NO_MESIN','$NO_IZIN_IMPOR','$TGL_IZIN_IMPOR')");

	header('location: ./deplu.php?module='.$module.'&act=lihat_rantorIimpor&idt='.$ID_DIPLOMAT.'&negara='.$neg);
 


}
elseif ($module=='rantorIimpor' AND $act=='hapus' AND isset($_GET[idt])){
	$idd = $_GET[idd];
  mysql_query("DELETE FROM penggunaan_fasilitas WHERE ID_PENGGUNAA_FAS  ='$_GET[idt]'");
header('location: ./deplu.php?module='.$module.'&act=lihat_rantorIimpor&idt='.$idd.'&negara='.$neg);
 

}

elseif ($module=='rantorIimpor' AND $act=='update' AND isset($_GET[idt])){
$idt = $_GET[idt];

$ID_PENGGUNAA_FAS= $_POST[ID_PENGGUNAA_FAS];
$ID_DIPLOMAT= $_POST[ID_DIPLOMAT];
$ID_KNT_PERWAKILAN= $_POST[ID_KNT_PERWAKILAN];
$DESKRIPSI= $_POST[DESKRIPSI];
$MEREK= $_POST[MEREK];
$TAHUN= $_POST[TAHUN];
$NO_POLISI= $_POST[NO_POLISI];
$NO_MESIN= $_POST[NO_MESIN];

$NO_IZIN_IMPOR= $_POST[NO_IZIN_IMPOR];
$TGL_IZIN_IMPOR= $_POST[TGL_IZIN_IMPOR];
$ST_PERSETUJUAN= $_POST[ST_PERSETUJUAN];
/*$ID_DIPLOMAT= $_POST[ID_DIPLOMAT];
$TGL_PERSETUJUAN= $_POST[TGL_PERSETUJUAN];
$NO_PERSETUJUAN= $_POST[NO_PERSETUJUAN];
$DESKRIPSI= $_POST[DESKRIPSI];
$MEREK= $_POST[MEREK];
$TAHUN= $_POST[TAHUN];
$NO_POLISI= $_POST[NO_POLISI];
$NO_MESIN= $_POST[NO_MESIN];

$NO_IZIN_IMPOR= $_POST[NO_IZIN_IMPOR];
$TGL_IZIN_IMPOR= $_POST[TGL_IZIN_IMPOR];
$NO_NOTE_IMPOR= $_POST[NO_NOTE_IMPOR];
$PELABUHAN_IMPOR= $_POST[PELABUHAN_IMPOR];
$KAPAL_IMPOR= $_POST[KAPAL_IMPOR];
$TGL_TIBA_IMPOR= $_POST[TGL_TIBA_IMPOR];
$TGL_SURAT_IMPOR= $_POST[TGL_SURAT_IMPOR];
$PEMOHON_IMPOR= $_POST[PEMOHON_IMPOR];
$JABATAN_IMPOR= $_POST[JABATAN_IMPOR];
$APPROVAL_IMPOR= $_POST[APPROVAL_IMPOR];
$NIP_APPROVAL_IMPOR= $_POST[NIP_APPROVAL_IMPOR];

$NO_IZIN_JUAL= $_POST[NO_IZIN_JUAL];
$TGL_IZIN_JUAL= $_POST[TGL_IZIN_JUAL];
$ALASAN_PENJUALAN= $_POST[ALASAN_PENJUALAN];
$REKOMENDASI_BENGKEL= $_POST[REKOMENDASI_BENGKEL];
$NAMA_PEMBELI= $_POST[NAMA_PEMBELI];
$ALAMAT_PEMBELI= $_POST[ALAMAT_PEMBELI];
$NO_KTP_PEMBELI= $_POST[NO_KTP_PEMBELI];
*/



	mysql_query(" update penggunaan_fasilitas set DESKRIPSI = '$DESKRIPSI',
											MEREK = '$MEREK',
											TAHUN = '$TAHUN',
											NO_POLISI = '$NO_POLISI',
											NO_MESIN = '$NO_MESIN',
											NO_IZIN_IMPOR = '$NO_IZIN_IMPOR',
											TGL_IZIN_IMPOR = '$TGL_IZIN_IMPOR',
											ST_PERSETUJUAN = $ST_PERSETUJUAN
											where ID_PENGGUNAA_FAS =  $idt");


	header('location: ./deplu.php?module='.$module.'&act=lihat_rantorIimpor&idt='.$ID_DIPLOMAT.'&negara='.$neg);
 
  }

}
?>
