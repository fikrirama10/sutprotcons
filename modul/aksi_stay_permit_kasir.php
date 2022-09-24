<?php
//session_start();

session_start();

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){
	$template = file("../template/canvasawal.htm");
	$template = implode("",$template ); 

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

$template = file("../template/canvasDeplu.htm");
$template = implode("",$template ); 

if ($module=='staypermitKasir' AND $act=='input'){

$ID_DIPLOMAT = $_POST[ID_DIPLOMAT];
$ID_JNS_PERMIT = $_POST[ID_JNS_PERMIT];
$NO_AGENDA = $_POST[NO_AGENDA];
$TGL_AGENDA = $_POST[TGL_AGENDA];
$NO_IZIN_PERMIT = $_POST[NO_IZIN_PERMIT];
$TGL_AWAL_PERMIT = $_POST[TGL_AWAL_PERMIT];
$TGL_AKHIR_PERMIT = $_POST[TGL_AKHIR_PERMIT];
$KET = $_POST[KET];
$NO_NOTA = $_POST[NO_NOTA];
$TGL_NOTA = $_POST[TGL_NOTA];

//============ add permit_kas

$qSelect1=mysql_query("select max(TGL_AKHIR_PERMIT) as TGL_MAX from permit_diplomat where  ST_PERMIT = 2 and ST_PERMIT_K = 2 and ST_PERMIT_KAS = 2 and ID_JNS_PERMIT =$ID_JNS_PERMIT  and ID_DIPLOMAT = $ID_DIPLOMAT ");
 $b1=mysql_fetch_array($qSelect1);
 if (!(is_null($b[TGL_MAX])) and ($b[TGL_MAX] <=  $TGL_AWAL_PERMIT)){
	$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br>Masih ada permit yang masih aktif. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{
//=======

if ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT ){
	$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br>Tanggal awal harus lebih kecil dari tanggal berakhir. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{

 $qSelect=mysql_query("select NM_DIPLOMAT,DATE_FORMAT(AKHIR_BERLAKU,'%d-%M-%Y') AS AKHIR_BERLAKU,date_add(AKHIR_BERLAKU, interval -180 day) as BATAS_PERMIT, DATE_FORMAT(date_add(AKHIR_BERLAKU, interval -180 day),'%d-%M-%Y') as BATAS_PERMIT_2 from diplomat where ID_DIPLOMAT = $ID_DIPLOMAT");
 $b=mysql_fetch_array($qSelect);
 if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
	{
	 $varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br>Tanggal akhir permit maksimal 180 hari sebelum masa berlaku paspor habis.<br>Masa Berlaku paspor milik <b>$b[NM_DIPLOMAT]</b> habis pada tanggal <b>$b[AKHIR_BERLAKU]</b> .<br>Batas Maksimal Tanggal akhir permit adalah <b>$b[BATAS_PERMIT_2]</b> .
	 <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	 $template = eregi_replace("{isi}",$varname,$template);
	 echo $template;

	}
	else{
	
	if  ($ID_JNS_PERMIT==1){
   mysql_query("insert into permit_diplomat (ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,TGL_AGENDA,NO_IZIN_PERMIT,TGL_AWAL_PERMIT,TGL_AKHIR_PERMIT,KET,ST_PERMIT,ST_PERMIT_K,NO_NOTA,TGL_NOTA) values ($ID_DIPLOMAT,$ID_JNS_PERMIT,'$NO_AGENDA','$TGL_AGENDA',(SELECT CONCAT('KAG/',date_format('$TGL_AGENDA','%y'),'/',(SELECT KD_JNS_PASPOR FROM v_diplomat WHERE ID_DIPLOMAT = $ID_DIPLOMAT),'/',( SELECT COUNT(ID_PERMIT)+1 FROM v_stay_permit WHERE NO_IZIN_PERMIT LIKE CONCAT('KAG/',date_format('$TGL_AGENDA','%y'),'/%')))),'$TGL_AWAL_PERMIT','$TGL_AKHIR_PERMIT','$KET',1,1,'$NO_NOTA','$TGL_NOTA')");
	}else
	{ /*tambah permit_kas */
	mysql_query("insert into permit_diplomat (ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,TGL_AGENDA,NO_IZIN_PERMIT,TGL_AWAL_PERMIT,TGL_AKHIR_PERMIT,KET,ST_PERMIT,ST_PERMIT_K,ST_PERMIT_KAS,NO_NOTA,TGL_NOTA) values ($ID_DIPLOMAT,$ID_JNS_PERMIT,'$NO_AGENDA','$TGL_AGENDA',(SELECT CONCAT('KAF/',date_format('$TGL_AGENDA','%y'),'/',(SELECT KD_JNS_PASPOR FROM v_diplomat WHERE ID_DIPLOMAT = $ID_DIPLOMAT),'/',( SELECT COUNT(ID_PERMIT)+1 FROM v_stay_permit WHERE NO_IZIN_PERMIT LIKE CONCAT('KAF/',date_format('$TGL_AGENDA','%y'),'/%')))),'$TGL_AWAL_PERMIT','$TGL_AKHIR_PERMIT','$KET',1,1,1,'$NO_NOTA','$TGL_NOTA')");	
	}
	header('location: ./deplu.php?module='.$module.'&act=lihat_stay_permit&idt='.$ID_DIPLOMAT.'&negara='.$neg);

	} // if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
}	//if  ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT )
}	//if ($b[TGL_MAX] <=  $TGL_AWAL_PERMIT)


}
elseif ($module=='staypermitKasir' AND $act=='hapus' AND isset($_GET[idt])){
	$idd = $_GET[idd];
  mysql_query("DELETE FROM permit_diplomat WHERE ID_PERMIT ='$_GET[idt]'");
header('location: ./deplu.php?module='.$module.'&act=lihat_stay_permit&idt='.$idd.'&negara='.$neg);
 

}elseif ($module=='staypermitKasir' AND $act=='update' AND isset($_GET[idt])){
$idt = $_GET[idt];
  
$ID_PERMIT = $_POST[ID_PERMIT];
$ID_DIPLOMAT = $_POST[ID_DIPLOMAT];
$ID_JNS_PERMIT = $_POST[ID_JNS_PERMIT];
$NO_AGENDA = $_POST[NO_AGENDA];
$TGL_AGENDA = $_POST[TGL_AGENDA];
$NO_IZIN_PERMIT = $_POST[NO_IZIN_PERMIT];
$TGL_AWAL_PERMIT = $_POST[TGL_AWAL_PERMIT];
$TGL_AKHIR_PERMIT = $_POST[TGL_AKHIR_PERMIT];
$KET = $_POST[KET];
$NO_NOTA = $_POST[NO_NOTA];
$TGL_NOTA = $_POST[TGL_NOTA];

if ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT ){
	$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Ubah Data Gagal.</b><br>Tanggal awal harus lebih kecil dari tanggal berakhir. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{

 $qSelect=mysql_query("select NM_DIPLOMAT,DATE_FORMAT(AKHIR_BERLAKU,'%d-%M-%Y') AS AKHIR_BERLAKU,date_add(AKHIR_BERLAKU, interval -180 day) as BATAS_PERMIT, DATE_FORMAT(date_add(AKHIR_BERLAKU, interval -180 day),'%d-%M-%Y') as BATAS_PERMIT_2 from diplomat where ID_DIPLOMAT = $ID_DIPLOMAT");
 $b=mysql_fetch_array($qSelect);
if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
	{
	 $varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Ubah Data Gagal.</b><br>Tanggal akhir permit maksimal 180 hari sebelum masa berlaku paspor habis.<br>Masa Berlaku paspor milik <b>$b[NM_DIPLOMAT]</b> habis pada tanggal <b>$b[AKHIR_BERLAKU]</b> .<br>Batas Maksimal Tanggal akhir permit adalah <b>$b[BATAS_PERMIT_2]</b> . 
	 <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	 $template = eregi_replace("{isi}",$varname,$template);
	 echo $template;

	}
	else{
		mysql_query(" update permit_diplomat set ID_DIPLOMAT = $ID_DIPLOMAT,
											ID_JNS_PERMIT = $ID_JNS_PERMIT,
											NO_AGENDA = '$NO_AGENDA',
											TGL_AGENDA = '$TGL_AGENDA',
											NO_IZIN_PERMIT = '$NO_IZIN_PERMIT',
											TGL_AWAL_PERMIT = '$TGL_AWAL_PERMIT',
											TGL_AKHIR_PERMIT = '$TGL_AKHIR_PERMIT',
											KET  = '$KET',
											NO_NOTA = '$NO_NOTA',
											TGL_NOTA = '$TGL_NOTA'
											where ID_PERMIT =  $idt");

	
    
		header('location: ./deplu.php?module='.$module.'&act=lihat_stay_permit&idt='.$ID_DIPLOMAT.'&negara='.$neg);
	} // if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
}//if  ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT )
  
  }

}
?>
