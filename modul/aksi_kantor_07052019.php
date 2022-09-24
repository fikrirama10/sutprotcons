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
		

if ($module=='kantor' AND $act=='hapus' AND isset($_GET[idt])){
	mysql_query("DELETE FROM m_kantor_perwakilan WHERE ID_KNT_PERWAKILAN = $_GET[idt]");
}else{
	$nm_knt_perwakilan = $_POST[nm_knt_perwakilan];
	$id_negara = $_POST[id_negara];
	$id_jns_perwakilan = $_POST[id_jns_perwakilan];
	$id_sub_jns = $_POST[id_sub_jns];
	$alamat= $_POST[alamat];
	$kota = $_POST[kota];
	$telp = $_POST[telp];
	$fax = $_POST[fax];
	$email = $_POST[email];
	$kdagenda = $_POST[kode_agenda];
	$website = $_POST[website];
	$offhours = $_POST[offhours];
	$nationalday = $_POST[nationalday];
	$ket = $_POST[ket];


	
	if  ($module=='kantor' AND $act=='input'){
		mysql_query("insert into m_kantor_perwakilan (NM_KNT_PERWAKILAN,ID_NEGARA,ID_JNS_PERWAKILAN,ID_SUB_JNS,ALAMAT,KOTA,TELP,FAX,EMAIL,KODE_AGENDA,WEB,OFFHOURS,NATIONALDAY,KET) 
		values ('$nm_knt_perwakilan', '$id_negara', '$id_jns_perwakilan', '$id_sub_jns','$alamat', '$kota', '$telp','$fax', '$email','$kdagenda','$website','$offhours','$nationalday','$ket')");
	
	}elseif ($module=='kantor' AND $act=='update' AND isset($_POST[idt])){
		mysql_query("update m_kantor_perwakilan set 
		NM_KNT_PERWAKILAN='$nm_knt_perwakilan',
		ID_NEGARA=$id_negara,
		ID_JNS_PERWAKILAN=$id_jns_perwakilan,
		ID_SUB_JNS=$id_sub_jns,
		ALAMAT='$alamat',
		KOTA='$kota',
		TELP='$telp',
		FAX='$fax',
		EMAIL='$email',
		KODE_AGENDA='$kdagenda',
		WEB='$website',
		OFFHOURS='$offhours',
		NATIONALDAY='$nationalday',
		KET='$ket'
		where ID_KNT_PERWAKILAN= $_POST[idt] ");
	}
}
	header('location: ./deplu.php?module='.$module);
}
?>
