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

if ($module=='indeksvisa' AND $act=='input'){

$pwk_ri 		= $_POST[pwk_otvis];	
$no_konsep 		= $_POST[no_konsep];
$tgl_otvis 		= $_POST[tgl_otvis];
$nobrafaks_otvis= $_POST[nobrafaks_otvis];
$nama_otvis 	= $_POST[nama_otvis];
$paspor_otvis 	= $_POST[paspor_otvis];
$anggota_family = $_POST[anggota_fam];
$jns_paspor 	= $_POST[id_tipe_paspor];
$tujuan_otvis 	= $_POST[tujuan_otvis];
$tipevisa_otvis = $_POST[tipevisa_otvis];
$indeksvisa_otvis = $_POST[indeksvisa_otvis];
$masatugas_otvis = $_POST[masatugas_otvis];
$dmv 			 = $_POST[dasar_mintavisa];
$dbv 			 = $_POST[dasar_berivisa];
$verifikator	 = $_POST[verifikator];
$jab_ver		 = $_POST[jbt_ver];
$legalisator	 = $_POST[legalisator];
$jab_legal		 = $_POST[jbt_legal];
$catatan		 = $_POST[catatan_otvis];
$created_date	 = date('Y-m-d h:m:s');
$TGL_AKHIR_PERMIT = '2016-05-05';
$TGL_AWAL_PERMIT  = '2016-05-01';
$status_mhn		 = 3;//$_POST[ID_JNS_KEPUTUSAN];
//$st_akhir		 = 3;
if ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT ){
	$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br>Tanggal awal harus lebih kecil dari tanggal berakhir. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;
}else{
	$sql="insert into tbl_trans_otvis (no_konsep,no_brafaks,pwk_ri,nama,paspor,jns_paspor,
	tujuan,tipe_visa,indeks_visa,masa_tugas,verifikator,jabatan_verifikator,legalisator,jabatan_legalisator
	,catatan,created_date,status_permohonan) 
	values 
	('$no_konsep','$nobrafaks_otvis',$pwk_ri,'$nama_otvis','$paspor_otvis',$jns_paspor,
	'$tujuan_otvis',$tipevisa_otvis,$indeksvisa_otvis,$masatugas_otvis,'$verifikator',
	'$jab_ver','$legalisator','$jab_legal','$catatan','$created_date',$status_mhn)";
	
	if(isset($_POST['simpan'])){
		 if(mysql_query($sql))
		 {
			echo '<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Berhasil.</b></p>';
			
			if (!empty($anggota_family)) {	
				//input persyaratan
				$h = 1;
				foreach ($anggota_family as $val) {
					$insert_anggota_family = mysql_query("INSERT INTO tbl_anggota_fam (urutan,no_konsep, nama,relasi,nopaspor,created_date) VALUES ('".$h."','".$no_konsep."','".$val['anggotafam_nama']."','".$val['anggotafam_relasi']."','".$val['anggotafam_nopaspor']."','".date('Y-m-d h:m:s')."')");
				$h++;
				}
			}
			
			if (!empty($dmv)) {	
				//input persyaratan
				$i = 1;
				foreach ($dmv as $val) {
					$insert_dmv = mysql_query("INSERT INTO tbl_dasarminta_visa (urutan,no_konsep, dasar_mintavisa,created_date) VALUES ('".$i."','".$no_konsep."','".$val['dasarmintavisa']."','".date('Y-m-d h:m:s')."')");
				$i++;
				}
			}
			if (!empty($dbv)) {	
				//input persyaratan
				$j = 1;
				foreach ($dbv as $val) {
					$insert_dbv = mysql_query("INSERT INTO tbl_dasarberi_visa (urutan,no_konsep, dasar_berivisa,created_date) VALUES ('".$j."','".$no_konsep."','".$val['dasarberivisa']."','".date('Y-m-d h:m:s')."')");
				$j++;
				}
			}	
		
		 }
		 else
		 {
			 echo '<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>';
		 }
	 
	}
	//print_r('ok');exit;
	
	
	header('location: ./deplu.php?module='.$module);

	} // if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
}	//if  ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT )
//}	//if ($b[TGL_MAX] <=  $TGL_AWAL_PERMIT)

	
elseif ($module=='indeksvisa' AND $act=='update' AND isset($_GET[idt])){
$idt = $_GET[idt];
  
$pwk_ri 		= $_POST[pwk_otvis];	
//$no_konsep 		= $_POST[no_konsep];
$tgl_otvis 		= $_POST[tgl_otvis];
$nobrafaks_otvis= $_POST[nobrafaks_otvis];
$nama_otvis 	= $_POST[nama_otvis];
$paspor_otvis 	= $_POST[paspor_otvis];
$anggota_family = $_POST[anggota_fam];
$jns_paspor 	= $_POST[id_tipe_paspor];
$tujuan_otvis 	= $_POST[tujuan_otvis];
$tipevisa_otvis = $_POST[tipevisa_otvis];
$indeksvisa_otvis = $_POST[indeksvisa_otvis];
$masatugas_otvis = $_POST[masatugas_otvis];
$dmv 			 = $_POST[dasar_mintavisa];
$dbv 			 = $_POST[dasar_berivisa];
$verifikator	 = $_POST[verifikator];
$jab_ver		 = $_POST[jbt_ver];
$legalisator	 = $_POST[legalisator];
$jab_legal		 = $_POST[jbt_legal];
$catatan		 = $_POST[catatan_otvis];
$created_date	 = date('d M Y',strtotime($_POST[created_date]));
$created_date1	 = date('Y-m-d h:m:s');
$modified_date	 = date('Y-m-d h:m:s');
$TGL_AKHIR_PERMIT = '2016-05-05';
$TGL_AWAL_PERMIT  = '2016-05-01';
$status_mhn		 = $_POST[ID_JNS_KEPUTUSAN];

//
if ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT ){
	$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Ubah Data Gagal.</b><br>Tanggal awal harus lebih kecil dari tanggal berakhir. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{

 
	//else{
		
		//print_r($status_mhn.'asd');exit;
	$a = "select * from tbl_trans_otvis where no_konsep = '$idt'";
	$b = mysql_query($a);
	$c = mysql_fetch_array($b);
	
	$d = "select * from tbl_dasarminta_visa where no_konsep = '$idt'";
	$e = mysql_query($d);
	$f = mysql_fetch_array($e);
	
	$g = "select * from tbl_dasarberi_visa where no_konsep = '$idt'";
	$h = mysql_query($g);
	$i = mysql_fetch_array($h);
	
	
	
	function sendemail($email,$idt,$pwk_ri,$nama_otvis,$paspor_otvis,
	$jns_paspor,$anggota_family,$tujuan_otvis,$indeksvisa_otvis,
	$masatugas_otvis,$catatan,$status_mhn,$created_date1)
	{
		$to      = $email;
		//$noreg   = $nodaftar;
		$bcc	 = 'BCC : no-reply.otvis@kemlu.go.id';
		//if 
		
		$messagelolos = 
		"
		<html>
				
				<table border=0 width=100%>
				<tr>
				<td width=20% align='center'>
				<img src='../images/logo_kemlu5.png' width=90 height=90>
				</td>
				
				<td align='center' style='font-size:15px;'>
				
				OTORISASI VISA DIPLOMATIK / DINAS<br>
				KEMENTERIAN LUAR NEGERI REPUBLIK INDONESIA<br> 
				Jln. Pejambon No.6 , Jakarta Pusat, 10110 Indonesia<br> 
				E-mail : otorisasi.visa@kemlu.go.id

				</td>
				
				<td width=20% align='center'>
				&nbsp;
				</td>
				
				</tr>
				</table>
				<hr>
				<table border=0 width=100%>
				<tr>
				<td  align='center' width='15%' style='border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000'>
				
				</td>
				
				<td>
				&nbsp;
				</td>
				<td width='45%'>
				NO. KONSEP   : $idt<br>
				TANGGAL      : $created_date1
				</td>
				
				</tr>
				</table>
				<br>
				<table border=0>
				<tr><td width=35%>Perwakilan RI di</td><td>:$pwk_ri</td></tr>
				<tr><td>Nama / Paspor</td><td>: $nama_otvis / $paspor_otvis</td></tr>
				<tr><td>Jenis Paspor</td><td>: $jns_paspor</td></tr>
				<tr><td>Anggota Keluarga</td><td>: $anggota_family</td></tr>
				
				<tr><td>Tujuan</td><td>: $tujuan_otvis</td></tr>
				<tr><td>Indeks Visa</td><td>: $indeksvisa_otvis</td></tr>
				<tr><td>Masa Penugasan di Indonesia</td><td>: $masatugas_otvis Hari</td></tr>
				<tr><td>Dasar Permintaan Visa</td><td>: 
				
				</td></tr>
				<tr><td>Dasar Pemberian Visa</td><td>: 
				
				</td></tr>
				<tr><td>Catatan</td><td>: $catatan</td></tr>
				<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
				<tr><td colspan=2 align=justify>
				Perwakilan  RI  agar  mencantumkan  Kode  Jenis dan  Indeks  Visa  serta  Kode  Wilayah  tempat 
				penerbitan  Visa  Diplomatik/Dinas,  secara  benar  sesuai  dengan  ketentuan  yang  berlaku  serta 
				memberikan informasi kepada ybs  agar mengalihstatuskan Visa Diplomatik/Dinas nya menjadi Izin Tinggal 
				Diplomatik/Dinas  di Kementerian Luar Negeri RI c.q. Direktorat Konsuler  dalam jangka waktu kurang dari 
				30 (tiga puluh) hari sejak tanggal ketibaan di Indonesia.
				<br><br>Demikian, atas perhatian dan kerjasamanya disampaikan terima kasih.
				</td><tr>
				</table>
				<br>
				<p>
				Salam Hormat,<br><br>
				Otorisasi Visa Kementerian Luar Negeri RI
				</p>
				<br>
				<br>
				<hr><br>
				<small>Email ini dikirim secara otomatis oleh sistem. Harap tidak membalas ke alamat email ini. Pertanyaan dapat dikirimkan ke konsuler@kemlu.go.id. Terima kasih.</small>
	
				</html>
		";
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: NO REPLY - Visa Kementerian Luar Negeri RI <no-reply.otvis@kemlu.go.id>' . "\r\n".$bcc;
	
		/* if($kd_flow == 2)
		{ */
			$message = $messagelolos;
			//print_r($message);exit;
			$noreg1  = $idt;
			$subject_temp = 'Konfirmasi Visa No. Daftar : '.$noreg1.' '.$status_mhn.'/ Visa Confirmation Reg. No : '.$noreg1.' Approved';
			$subject = $subject_temp;
		/* }
		elseif($kd_flow == 1)
		{
			$message = $messagetolak;
			$noreg1  = $nodaftar;
			$subject = 'Konfirmasi Ijin Tinggal Online No. Daftar : '.$noreg1.' (DIPLOMAT) Ditolak / Stay Permit Confirmation Reg. No : '.$noreg1.' (DIPLOMAT) Rejected';
		}	 */
		
		return mail($to, $subject, $message, $headers);
		
	}
	
	sendemail('hartarto.anugerah@kemlu.go.id',$idt,$pwk_ri,$nama_otvis,$paspor_otvis,$jns_paspor,$anggota_family,$tujuan_otvis
	,$indeksvisa_otvis,$masatugas_otvis,$catatan,$status_mhn,$created_date1);
	
	$sql_update = "
					update tbl_trans_otvis set 
											pwk_ri = $pwk_ri,
											nama = '$nama_otvis',
											paspor = '$paspor_otvis',
											jns_paspor = $jns_paspor,
											
											tujuan = '$tujuan_otvis',
											indeks_visa = $indeksvisa_otvis,
											masa_tugas = $masatugas_otvis,
											verifikator = '$verifikator',
											jabatan_verifikator = '$jab_ver',
											legalisator  = '$legalisator',
											jabatan_legalisator = '$jab_legal',
											catatan = '$catatan',
											modified_date = '$modified_date',
											status_permohonan = $status_mhn
											where no_konsep =  '$idt'";
	//print_r($sql_update);exit;
	if(isset($_POST['simpan'])){
		 if(mysql_query($sql_update))
		 {
			
			if (!empty($anggota_family)) {	
					//input persyaratan
					$h = 1;
					$delete_anggota_family = mysql_query("DELETE FROM tbl_anggota_fam where no_konsep = '$idt'");
					foreach ($anggota_family as $val) {
						$insert_anggota_family = mysql_query("INSERT INTO tbl_anggota_fam (urutan,no_konsep, nama,relasi,nopaspor,created_date) VALUES ('".$h."','".$idt."','".$val['anggotafam_nama']."','".$val['anggotafam_relasi']."','".$val['anggotafam_nopaspor']."','".date('Y-m-d h:m:s')."')");
					$h++;
					}
				}
				else
				{
					$delete_anggota_family = mysql_query("DELETE FROM tbl_anggota_fam where no_konsep = '$idt'");
				}
			
			if (!empty($dmv)) {	
					//input persyaratan
					$i = 1;
					$delete_dbv = mysql_query("DELETE FROM tbl_dasarminta_visa where no_konsep = '$idt'");
					foreach ($dmv as $val) {
						$insert_dmv = mysql_query("INSERT INTO tbl_dasarminta_visa (urutan,no_konsep, dasar_mintavisa,created_date) VALUES ('".$i."','".$idt."','".$val['dasarmintavisa']."','".date('Y-m-d h:m:s')."')");
					$i++;
					}
				}
				else
				{
					$delete_dmv = mysql_query("DELETE FROM tbl_dasarminta_visa where no_konsep = '$idt'");
				}
			if (!empty($dbv)) {	
					//input persyaratan
					$j = 1;
					$delete_dbv = mysql_query("DELETE FROM tbl_dasarberi_visa where no_konsep = '$idt'");
				
					foreach ($dbv as $val) {
						$insert_dbv = mysql_query("INSERT INTO tbl_dasarberi_visa (urutan,no_konsep, dasar_berivisa,created_date) VALUES ('".$j."','".$idt."','".$val['dasarberivisa']."','".date('Y-m-d h:m:s')."')");
					$j++;
					}
				}	
				else
				{
					$delete_dbv = mysql_query("DELETE FROM tbl_dasarberi_visa where no_konsep = '$idt'");
				}
		 
			echo '<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Update Data Berhasil.</b></p>';
		 
		 }
		 else
		 {
			 echo '<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Update Data Gagal.</b><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>';
		 }
	 
	}
	
 	
	
	header('location: ./deplu.php?module='.$module);
	//} // if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
}//if  ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT )
  
  }


  


elseif ($module=='staypermit' AND $act=='input'){

$ID_DIPLOMAT = $_POST[ID_DIPLOMAT];
$ID_JNS_PERMIT = $_POST[ID_JNS_PERMIT];
$NO_AGENDA = $_POST[NO_AGENDA];
$TGL_AGENDA = $_POST[TGL_AGENDA];
$NO_IZIN_PERMIT = $_POST[NO_IZIN_PERMIT];
$TGL_AWAL_PERMIT = $_POST[TGL_AWAL_PERMIT];
$TGL_AKHIR_PERMIT = $_POST[TGL_AKHIR_PERMIT];
$TGL_AMBIL = $_POST[TGL_AMBIL_BERKAS];
$KET = $_POST[KET];
$KETVER = $_POST[KET_VER];
$KETHOR = $_POST[KET_HOR];
$NO_NOTA = $_POST[NO_NOTA];
$TGL_NOTA = $_POST[TGL_NOTA];

//============

$qSelect1=mysql_query("select max(TGL_AKHIR_PERMIT) as TGL_MAX from permit_diplomat where  ST_PERMIT_KAS = 2 and ST_PERMIT_K = 2 and ID_JNS_PERMIT =$ID_JNS_PERMIT  and ID_DIPLOMAT = $ID_DIPLOMAT ");
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

/* $qSelect=mysql_query("select NM_DIPLOMAT,DATE_FORMAT(AKHIR_BERLAKU,'%d-%M-%Y') AS AKHIR_BERLAKU,date_add(AKHIR_BERLAKU, interval -180 day) as BATAS_PERMIT, DATE_FORMAT(date_add(AKHIR_BERLAKU, interval -180 day),'%d-%M-%Y') as BATAS_PERMIT_2 from diplomat where ID_DIPLOMAT = $ID_DIPLOMAT");
*/ $qSelect=mysql_query("select NM_DIPLOMAT,DATE_FORMAT(AKHIR_BERLAKU,'%d-%M-%Y') AS AKHIR_BERLAKU,date_add(AKHIR_BERLAKU, interval -30 day) as BATAS_PERMIT, DATE_FORMAT(date_add(AKHIR_BERLAKU, interval -180 day),'%d-%M-%Y') as BATAS_PERMIT_2 from diplomat where ID_DIPLOMAT = $ID_DIPLOMAT");
 $b=mysql_fetch_array($qSelect);
 if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
	{
	 $varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br>Tanggal akhir permit maksimal 30 hari sebelum masa berlaku paspor habis.<br>Masa Berlaku paspor milik <b>$b[NM_DIPLOMAT]</b> habis pada tanggal <b>$b[AKHIR_BERLAKU]</b> .<br>Batas Maksimal Tanggal akhir permit adalah <b>$b[BATAS_PERMIT_2]</b> .
	 <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	 $template = eregi_replace("{isi}",$varname,$template);
	 echo $template;

	}
	else{
	
	if  ($ID_JNS_PERMIT==1){

		$cmp1="SELECT COUNT(ID_PERMIT_S) as jml FROM v_stay_permit_sib WHERE NO_IZIN_PERMIT LIKE CONCAT('KAG/',date_format('2012-12-26','%y'),'/%')";
 		$res=mysql_query($cmp1);
		$jml1=mysql_fetch_array($res);
		
		$cmp2="SELECT COUNT(ID_PERMIT) as jml FROM v_stay_permit WHERE NO_IZIN_PERMIT LIKE CONCAT('KAG/',date_format('2012-12-26','%y'),'/%')";
		$res2=mysql_query($cmp2);
		$jml2=mysql_fetch_array($res2);
		
		$urut_permit=$jml1['jml']+$jml2['jml']+1;
 

		$sql="insert into permit_diplomat (ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,TGL_AGENDA,NO_IZIN_PERMIT,TGL_AWAL_PERMIT,TGL_AKHIR_PERMIT,KET,ST_PERMIT,ST_PERMIT_K,ST_PERMIT_KAS,NO_NOTA,TGL_NOTA) values ($ID_DIPLOMAT,$ID_JNS_PERMIT,'$NO_AGENDA','$TGL_AGENDA','$NO_IZIN_PERMIT','$TGL_AWAL_PERMIT','$TGL_AKHIR_PERMIT','$KET','$KETVER','$KETHOR',1,1,1,'$NO_NOTA','$TGL_NOTA')";
		//automatic generate code
		//(SELECT CONCAT('KAG/',date_format('$TGL_AGENDA','%y'),'/',(SELECT KD_JNS_PASPOR FROM v_diplomat WHERE ID_DIPLOMAT = $ID_DIPLOMAT),'/',$urut_permit))
   mysql_query($sql);
 	}else
	{
		$cmp1="SELECT COUNT(ID_PERMIT_S) as jml FROM v_stay_permit_sib WHERE NO_IZIN_PERMIT LIKE CONCAT('KAG/',date_format('2012-12-26','%y'),'/%')";

 		$res=mysql_query($cmp1);
		$jml1=mysql_fetch_array($res);
		
		$cmp2="SELECT COUNT(ID_PERMIT) as jml FROM v_stay_permit WHERE NO_IZIN_PERMIT LIKE CONCAT('KAG/',date_format('2012-12-26','%y'),'/%')";
		$res2=mysql_query($cmp2);
		$jml2=mysql_fetch_array($res2);
		
		$urut_permit=$jml1['jml']+$jml2['jml']+1;

		$sql="insert into permit_diplomat (ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,TGL_AGENDA,NO_IZIN_PERMIT,TGL_AWAL_PERMIT,TGL_AKHIR_PERMIT,KET,ST_PERMIT,ST_PERMIT_K,ST_PERMIT_KAS,NO_NOTA,TGL_NOTA) values ($ID_DIPLOMAT,$ID_JNS_PERMIT,'$NO_AGENDA','$TGL_AGENDA','$NO_IZIN_PERMIT','$TGL_AWAL_PERMIT','$TGL_AKHIR_PERMIT','$KET','$KETVER','$KETHOR',1,1,1,'$NO_NOTA','$TGL_NOTA')";
	//automatic generate code
	//(SELECT CONCAT('KAF/',date_format('$TGL_AGENDA','%y'),'/',(SELECT KD_JNS_PASPOR FROM v_diplomat WHERE ID_DIPLOMAT = $ID_DIPLOMAT),'/',$urut_permit))
	//   echo $sql; 
	mysql_query($sql);	
	}

	if (!empty($_POST['syarat'])) {	
			//input persyaratan
			$query_max_idpermit = mysql_query("SELECT MAX(id_permit) as max FROM PERMIT_DIPLOMAT"); 
			$max=mysql_fetch_array($query_max_idpermit);
			$max=$max['max'];
			
			foreach ($_POST['syarat'] as $syarat) {
				$insert_syarat = mysql_query("INSERT INTO syarat_permit (syarat_kd, id_permit) VALUES ('".$syarat."','".$max."')");
			}
		}
	header('location: ./deplu.php?module='.$module.'&act=lihat_stay_permit&idt='.$ID_DIPLOMAT.'&negara='.$neg);

	} // if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
}	//if  ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT )
}	//if ($b[TGL_MAX] <=  $TGL_AWAL_PERMIT)


}
elseif ($module=='staypermit' AND $act=='hapus' AND isset($_GET[idt])){
	$idd = $_GET[idd];
  mysql_query("DELETE FROM permit_diplomat WHERE ID_PERMIT ='$_GET[idt]'");
  	  $sql="select distinct(a.syarat_kd) from m_syarat a, syarat_permit b  WHERE a.jenis_izin='1' and b.id_permit='$_GET[idt]'";
 	  $query = mysql_query($sql);
	  while ($data=mysql_fetch_array($query)) {
 	 	 mysql_query("DELETE FROM syarat_permit WHERE syarat_kd='".$data['syarat_kd']."'");
  	  }

  
header('location: ./deplu.php?module='.$module.'&act=lihat_stay_permit&idt='.$idd.'&negara='.$neg);
 

}
elseif ($module=='staypermit' AND $act=='update' AND isset($_GET[idt])){
$idt = $_GET[idt];
  
$ID_PERMIT = $_POST[ID_PERMIT];
$ID_DIPLOMAT = $_POST[ID_DIPLOMAT];
$ID_JNS_PERMIT = $_POST[ID_JNS_PERMIT];
$NO_AGENDA = $_POST[NO_AGENDA];
$TGL_AGENDA = $_POST[TGL_AGENDA];
$VERIFIKASI = $_POST[statusverifikasi];
$JNS_IZIN_PERMIT = $_POST[JNS_IZIN_PERMIT];
$NO_IZIN_PERMIT = $_POST[NO_IZIN_PERMIT];
$TGL_AWAL_PERMIT = $_POST[TGL_AWAL_PERMIT];
$TGL_AMBIL = $_POST[TGL_AMBIL_BERKAS];
$TGL_AKHIR_PERMIT = $_POST[TGL_AKHIR_PERMIT];
$VERIFIKASI = $_POST[statusverifikasi];

//print_r($idt. ' sip');exit;
if ($VERIFIKASI == 2)
{
	$VERIFIKASI_AWAL = 3;
}
else
{
	$VERIFIKASI_AWAL = 1;
}
//print_r($VERIFIKASI_AWAL. ' sip');exit;
$KET = $_POST[KET];
$KETVER = $_POST[KET_VER];
$KETHOR = $_POST[KET_HOR];
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
		
		
		$a = "select distinct NO_DAFTAR,KD_WORKFLOW, NM_DIPLOMAT,TGL_AMBIL_BERKAS,TGL_AWAL_PERMIT, TGL_AKHIR_PERMIT,NO_IZIN_PERMIT, NM_JNS_PERMIT, EMAIL_EMBASSY from v_stay_permit where ID_PERMIT =  $idt";
	$b = mysql_query($a);
	$c = mysql_fetch_array($b);
	
	
	
	function sendemail($nodaftar,$nama,$tglawal,$tglakhir,$noizin,$jnspermit,$email,$kd_flow,$ket,$tglambil)
	{
		$to      = $email;
		//$noreg   = $nodaftar;
		$bcc	 = 'BCC : no-reply.sito@kemlu.go.id';
		//if 
		
		$messageapprove = "
		<html>
				<head>
				<title>Konfirmasi Ijin Tinggal Online</title>
				</head>
				<body>
				<p>Yth. $nama </p>
				
				<p>Ijin Tinggal anda telah di terima dengan data sebagai berikut :</p>
				
				No Permit : $noizin<br>
				Nama : $nama<br>
				Jenis : $jnspermit<br>	
				Masa Berlaku Izin : $tglawal s/d $tglakhir<br>				
				<br><br>
				
				<p>
				Atas perhatiannya kami ucapkan terima kasih.
				</p>
				
				<p>
				Salam Hormat,<br><br>
				Admin Ijin Tinggal Kementerian Luar Negeri RI
				</p>
				<br>
				<br>
				<hr><br>
				<small>Email ini dikirim secara otomatis oleh sistem. Harap tidak membalas ke alamat email ini. Pertanyaan dapat dikirimkan ke konsuler@kemlu.go.id. Terima kasih.</small>
				</body>
				</html>
		";
		$messagelolos = "
		<html>
				<head>
				<title>Konfirmasi Ijin Tinggal Online</title>
				</head>
				<body>
				<p>Yth. Pemohon </p>
				
				<p>Permohonan atas nama : <strong>$nama</strong> dengan nomor registrasi : <strong>$nodaftar</strong> telah disetujui, mohon agar dapat menyerahkan berkas sebagai berikut : <br>
				<br>
				<table>
				<tr>
				<td>- &nbsp;&nbsp;&nbsp;&nbsp;Kedutaan</td>
				<td>: </td>
				<td>nota diplomatik  dan paspor asli.</td>
				</tr>
				<tr>
				<td>- &nbsp;&nbsp;&nbsp;&nbsp;Organisasi Internasional</td>
				<td>: </td>
				<td>nota dinas setneg,surat sponsor, dan paspor asli.</td>
				</tr>
				<tr>
				<td>- &nbsp;&nbsp;&nbsp;&nbsp;Kementerian</td>
				<td>: </td>
				<td>nota dinas setneg, surat sponsor, dan paspor asli.</td>
				</tr>
				</table>
				ke loket konsuler pada tanggal $tglambil.</p>
				<br><br>Terima kasih
				<br>==========================================================<br>
				<p>To The Applicant</p>
				
				<p>Your application with the registration number : <strong>$nodaftar</strong> for <strong>$nama</strong> has been verified, kindly submit the original documents as followed : <br>
				<br>
				<table>
				<tr>
				<td>- &nbsp;&nbsp;&nbsp;&nbsp;Embassy</td>
				<td>: </td>
				<td>diplomatic note and passport.</td>
				</tr>
				<tr>
				<td>- &nbsp;&nbsp;&nbsp;&nbsp;International Organization</td>
				<td>: </td>
				<td>note from the state secretary, sponsorship letter, along with the original passport.</td>
				</tr>
				<tr>
				<td>- &nbsp;&nbsp;&nbsp;&nbsp;Ministry</td>
				<td>: </td>
				<td>original note from the state secretary, sponsorship letter, along with the original passport.</td>
				</tr>
				</table>
				to the consular counter  on this date $tglambil.</p>
				<br><br>Thank you.
				</body>
				</html>
		";
		
		$messagetolak = "
		<html>
				<head>
				<title>Konfirmasi Ijin Tinggal Online</title>
				</head>
				<body>
				<p>Yth. Pemohon </p>
				
				<p>
				Permohonan atas nama : <strong>$nama</strong> dengan nomor registrasi : <strong>$nodaftar</strong> belum disetujui,<br> dikarenakan $ket.<br> Terima Kasih
				</p>
				<br>=============================================================<br>
				<p>To The Applicant </p>
				
				<p>
				Your application with the registration number : <strong>$nodaftar</strong> for <strong>$nama</strong>  has not been approved,<br> because : $ket.<br> Thank you.
				</p>
				<br>
				</body>
				</html>
		";
		
		$messagelolosawal = "
		<html>
				<head>
				<title>Konfirmasi Ijin Tinggal Online</title>
				</head>
				<body>
				<p>Yth. $nama </p>
				
				<p>Permohonan anda dengan nomor registrasi : $nodaftar telah disetujui, mohon agar dapat mengambil berkas pada tanggal $tglambil.</p>
				<br>Silahkan datang ke Loket Konsuler Kementerian Luar Negeri Republik Indonesia
				<br>
				Jl. Pejambon 6 Jakarta Pusat 
				<br>
				
				<p>
				Atas perhatiannya kami ucapkan terima kasih.
				</p>
				
				<p>
				Salam Hormat,<br><br>
				Admin Ijin Tinggal Kementerian Luar Negeri RI
				</p>
				<br>
				<br>
				<hr><br>
				<small>Email ini dikirim secara otomatis oleh sistem. Harap tidak membalas ke alamat email ini. Pertanyaan dapat dikirimkan ke konsuler@kemlu.go.id. Terima kasih.</small>
				</body>
				</html>
		";
		$messagetolakawal = "
		<html>
				<head>
				<title>Konfirmasi Ijin Tinggal Online</title>
				</head>
				<body>
				<p>Yth. $nama </p>
				
				<p>
				Permohonan anda dengan nomor registrasi : $nodaftar belum disetujui.<br> keterangan : $ket.
				</p>
				
				<p>
				Atas perhatiannya kami ucapkan terima kasih.
				
				</p>
				
				<p>
				Salam Hormat,<br><br>
				Admin Ijin Tinggal Kementerian Luar Negeri RI
				</p>
				<br>
				<br>
				<hr><br>
				<small>Email ini dikirim secara otomatis oleh sistem. Harap tidak membalas ke alamat email ini. Pertanyaan dapat dikirimkan ke konsuler@kemlu.go.id. Terima kasih.</small>
				</body>
				</html>
		";
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: NO REPLY - Sistem Ijin Tinggal Online Kementerian Luar Negeri RI <no-reply.sito@kemlu.go.id>' . "\r\n".$bcc;
	
		if($kd_flow == 2)
		{
			$message = $messagelolos;
			$noreg1  = $nodaftar;
			$subject_temp = 'Konfirmasi Ijin Tinggal Online No. Daftar : '.$noreg1.' (DIPLOMAT) Disetujui / Stay Permit Confirmation Reg. No : '.$noreg1.' (DIPLOMAT) Approved';
			$subject = $subject_temp;
		}
		elseif($kd_flow == 1)
		{
			$message = $messagetolak;
			$noreg1  = $nodaftar;
			$subject = 'Konfirmasi Ijin Tinggal Online No. Daftar : '.$noreg1.' (DIPLOMAT) Ditolak / Stay Permit Confirmation Reg. No : '.$noreg1.' (DIPLOMAT) Rejected';
		}	
		
		return mail($to, $subject, $message, $headers);
		
	}
	
	if($VERIFIKASI == 1)
	{
		if($c['KD_WORKFLOW'] != 1)
		{	
		sendemail($c['NO_DAFTAR'],$c['NM_DIPLOMAT'],$c['TGL_AWAL_PERMIT'],$c['TGL_AKHIR_PERMIT'],$c['NO_IZIN_PERMIT'],$c['NM_JNS_PERMIT'],$c['EMAIL_EMBASSY'],$VERIFIKASI,$KET,$TGL_AMBIL);
		}
	}
	elseif($VERIFIKASI == 2)
	{
		if($c['KD_WORKFLOW'] != 3)
		{	
		sendemail($c['NO_DAFTAR'],$c['NM_DIPLOMAT'],$c['TGL_AWAL_PERMIT'],$c['TGL_AKHIR_PERMIT'],$c['NO_IZIN_PERMIT'],$c['NM_JNS_PERMIT'],$c['EMAIL_EMBASSY'],$VERIFIKASI,$KET,$TGL_AMBIL);
		}
	}
	
		mysql_query(" update permit_diplomat set ID_DIPLOMAT = $ID_DIPLOMAT,
											ID_JNS_PERMIT = $ID_JNS_PERMIT,
											NO_AGENDA = '$NO_AGENDA',
											TGL_AGENDA = '$TGL_AGENDA',
											NO_IZIN_PERMIT = '$NO_IZIN_PERMIT',
											JNS_IZIN_PERMIT = '$JNS_IZIN_PERMIT',
											TGL_AWAL_PERMIT = '$TGL_AWAL_PERMIT',
											TGL_AKHIR_PERMIT = '$TGL_AKHIR_PERMIT',
											TGL_AMBIL_BERKAS = '$TGL_AMBIL',
											KD_WORKFLOW = $VERIFIKASI_AWAL,
											KET  = '$KET',
											KETVER = '$KETVER',
											KETHOR = '$KETHOR',
											NO_NOTA = '$NO_NOTA',
											TGL_NOTA = '$TGL_NOTA'
											where ID_PERMIT =  $idt");
	//print_r($VERIFIKASI_AWAL. ' okeeee');exit;
	
	
 	if (!empty($_POST['syarat'])) {
			foreach ($_POST['syarat'] as $syarat) {
				$insert_syarat = mysql_query("INSERT INTO syarat_permit (syarat_kd, id_permit) VALUES ('".$syarat."','".$idt."')");
			}
	}
	
	header('location: ./deplu.php?module='.$module.'&act=lihat_stay_permit&idt='.$ID_DIPLOMAT.'&negara='.$neg);
	} // if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
}//if  ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT )
  
  }

}
?>
