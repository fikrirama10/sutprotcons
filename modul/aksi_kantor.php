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
	$ketnationalday = mysql_real_escape_string($_POST[ketnationalday]);
	$official_nm = $_POST[official_nm];
	$ket = $_POST[ket];

//echo $ketnationalday; exit;

	if  ($module=='kantor' AND $act=='input'){
		mysql_query("insert into m_kantor_perwakilan (NM_KNT_PERWAKILAN,ID_NEGARA,ID_JNS_PERWAKILAN,ID_SUB_JNS,ALAMAT,KOTA,TELP,FAX,EMAIL,KODE_AGENDA,WEB,OFFHOURS,NATIONALDAY,KET,OFFICIAL_NM,KET_NATIONALDAY)
		values ('$nm_knt_perwakilan', '$id_negara', '$id_jns_perwakilan', '$id_sub_jns','$alamat', '$kota', '$telp','$fax', '$email','$kdagenda','$website','$offhours','$nationalday','$ket','$official_nm','$ketnationalday')");

	}elseif ($module=='kantor' AND $act=='update' AND isset($_POST[idt])){
		if($_SESSION[G_leveluser]=='20'){
			$update_kntr = mysql_query("update m_kantor_perwakilan set
			ALAMAT='$alamat',
			KOTA='$kota',
			ID_JNS_PERWAKILAN='$id_jns_perwakilan',
			TELP='$telp',
			FAX='$fax',
			EMAIL='$email',
			WEB='$website',
			OFFHOURS='$offhours',
			NATIONALDAY='$nationalday',
			KET_NATIONALDAY='$ketnationalday',
			OFFICIAL_NM='$official_nm'
			where ID_KNT_PERWAKILAN= $_POST[idt]");
		}else{
			$update_kntr = mysql_query("update m_kantor_perwakilan set
			NM_KNT_PERWAKILAN='$nm_knt_perwakilan',
			ID_NEGARA='$id_negara',
			ID_JNS_PERWAKILAN='$id_jns_perwakilan',
			ID_SUB_JNS='$id_sub_jns',
			ALAMAT='$alamat',
			KOTA='$kota',
			TELP='$telp',
			FAX='$fax',
			EMAIL='$email',
			KODE_AGENDA='$kdagenda',
			WEB='$website',
			OFFHOURS='$offhours',
			NATIONALDAY='$nationalday',
			KET_NATIONALDAY='$ketnationalday',
			KET='$ket',
			OFFICIAL_NM='$official_nm'
			where ID_KNT_PERWAKILAN= $_POST[idt]");
			//echo $update_kntr.' dd';die;
		}
		 if($update_kntr == 1){
			 //echo $update_kntr.' dd';
		echo"<script type='text/javascript'>
                        alert('Berhasil Update Data Kantor Perwakilan');
						document.location.href='./deplu.php?module=kantor';
                    </script>";
         }else{
			 echo"<script type='text/javascript'>
                        alert('GAGAL!! Update Data Kantor Perwakilan');
						document.location.href='./deplu.php?module=kantor';
                    </script>";
		 }

	}elseif  ($module=='kantor' AND $act=='add_kontak_protokol'){
	$date_input = date('Y-m-d H:i:s');
		$sqLadd_kontak="INSERT
										INTO
											tbl_kontak_protokol
												(
												id_knt_perwakilan,
												kontak_jabatan,
												kontak_nama,
												kontak_email,
												kontak_telp,
												kontak_modified,
												kontak_by)
										VALUES
												(
													'".$_POST['id_knt_perwakilan']."',
													'".$_POST['kontak_jabatan']."',
													'".$_POST['kontak_nama']."',
													'".$_POST['kontak_email']."',
													'".$_POST['kontak_telp']."',
													'".$date_input."',
													'".$_POST['kontak_by']."'
												)";
		$add = mysql_query($sqLadd_kontak);
		if($add == 1){
	 echo"<script type='text/javascript'>
											 alert('Berhasil Tambah Data Kontak Protokol');
					 document.location.href='./deplu.php?module=kantor&act=kelolakontakprotokol&idt=".$_POST['id_knt_perwakilan']."';
									 </script>";
				}else{
			echo"<script type='text/javascript'>
											 alert('GAGAL!! Tambah Data Kontak Protokol');
					 document.location.href='./deplu.php?module=kantor&act=kelolakontakprotokol&idt=".$_POST['id_knt_perwakilan']."';
									 </script>";
		}
	} elseif  ($module=='kantor' AND $act=='edit_kontak_protokol'){
	$date_input = date('Y-m-d H:i:s');
		$sqledit_kontak="UPDATE tbl_kontak_protokol
										SET
												kontak_jabatan = 	'".$_POST['kontak_jabatan']."',
												kontak_nama = 	'".$_POST['kontak_nama']."',
												kontak_email = '".$_POST['kontak_email']."',
												kontak_telp = '".$_POST['kontak_telp']."',
												kontak_modified = '".$date_input."',
												kontak_by = '".$_SESSION[G_namauser]."'
										WHERE
												kontak_id = '".$_POST['kontak_id']."'";
		$edit = mysql_query($sqledit_kontak);
		if($edit == 1){
	 echo"<script type='text/javascript'>
											 alert('Berhasil Edit Data Kontak Protokol');
					 document.location.href='./deplu.php?module=kantor&act=kelolakontakprotokol&idt=".$_POST['id_knt_perwakilan']."';
									 </script>";
				}else{
			echo"<script type='text/javascript'>
											 alert('GAGAL!! Update Data Kontak Protokol');
					 document.location.href='./deplu.php?module=kantor&act=kelolakontakprotokol&idt=".$_POST['id_knt_perwakilan']."';
									 </script>";
		}
	}
	elseif  ($module=='kantor' AND $act=='delete_kontak_protokol' AND isset($_GET[idk])){

		$sqlhapus_kontak="DELETE FROM tbl_kontak_protokol WHERE kontak_id = '".$_GET[idk]."'";
		$hapus = mysql_query($sqlhapus_kontak);
		// echo mysql_error(); exit;
		if($hapus){
	 echo"<script type='text/javascript'>
											 alert('Berhasil Hapus Data Kontak Protokol');
					 document.location.href='./deplu.php?module=kantor&act=kelolakontakprotokol&idt=".$_GET['idt']."';
									 </script>";
				}else{
			echo"<script type='text/javascript'>
											 alert('GAGAL!! Hapus Data Kontak Protokol');
					 document.location.href='./deplu.php?module=kantor&act=kelolakontakprotokol&idt=".$_GET['idt']."';
									 </script>";
		}
	}



}
	//header('location: ./deplu.php?module='.$module);
}
?>
