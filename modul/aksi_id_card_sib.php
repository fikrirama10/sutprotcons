<?php
//session_start();

session_start();
$template = file("../template/canvasawal.htm");
$template = implode("",$template );

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])) {

	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";

	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

} else {

	include "../config/koneksi.php";
	include "../config/library.php";

	$module=$_GET[module];
	$act=$_GET[act];
	$idt=$_GET[idt];
	$neg=$_GET[negara];

	if ($module=='idcardSib' AND $act=='input') {

		$ID_SIBLING= $_POST[ID_SIBLING];
		$ID_JNS_CETAK_KARTU= $_POST[ID_JNS_CETAK_KARTU];
		$ID_CARD= $_POST[ID_CARD];
		$TGL_AWAL_CARD= $_POST[TGL_AWAL_CARD];
		$TGL_AKHIR_CARD= $_POST[TGL_AKHIR_CARD];

		// if (isset($_POST[COUNTER_CETAK]) and $_POST[COUNTER_CETAK] != '') {
		// 	$COUNTER_CETAK = $_POST[COUNTER_CETAK];
		// } else {
		// 	$COUNTER_CETAK = '0';
		// }

		mysql_query("insert into cetak_kartu_sibling (ID_SIBLING,ID_JNS_CETAK_KARTU,ID_CARD,TGL_AWAL_CARD,TGL_AKHIR_CARD,COUNTER_CETAK,ST_KARTU,ST_KARTU_K,ST_KARTU_KAS) values ($ID_SIBLING,$ID_JNS_CETAK_KARTU,'$ID_CARD','$TGL_AWAL_CARD','$TGL_AKHIR_CARD',0,2,2,2)");

		//input persyaratan
		$query_max_idpermit = mysql_query("SELECT MAX(id_cetak_s) as max FROM cetak_kartu_sibling");
		$max=mysql_fetch_array($query_max_idpermit);
		$max=$max['max'];

		foreach ($_POST['syarat'] as $syarat) {
			$insert_syarat = mysql_query("INSERT INTO syarat_permit (syarat_kd, id_permit) VALUES ('".$syarat."','".$max."')");
		}


		header('location: ./deplu.php?module='.$module.'&act=lihat_id_card&idt='.$ID_SIBLING.'&negara='.$neg);

	} elseif ($module == 'idcardSib' AND $act == 'hapus' AND isset($_GET[idt])) {
		$idd = $_GET[idd];

		mysql_query("DELETE FROM cetak_kartu_sibling WHERE ID_CETAK_S ='$_GET[idt]'");

		$sql = "select distinct(b.syarat_permit_kd) from syarat_permit b LEFT JOIN m_syarat a on a.syarat_kd=b.syarat_kd  WHERE a.jenis_izin = '4' and b.id_permit = '$_GET[idt]';";
		$query = mysql_query($sql);

		while ($data = mysql_fetch_array($query)) {
			mysql_query("DELETE FROM syarat_permit WHERE syarat_permit_kd='".$data['syarat_permit_kd']."'");
		}

		header('location: ./deplu.php?module='.$module.'&act=lihat_id_card&idt='.$idd.'&negara='.$neg);
	} elseif ($module == 'idcardSib' AND $act == 'update' AND isset($_GET[idt])) {
		$idt = $_GET[idt];

		$ID_CETAK_S = $_POST[ID_CETAK_S];
		$ID_SIBLING = $_POST[ID_SIBLING];
		$ID_ROOT_KANTOR = $_POST[ID_KNT_PERWAKILAN];
		$ID_JNS_CETAK_KARTU = $_POST[ID_JNS_CETAK_KARTU];
		$ID_CARD = $_POST[ID_CARD];
		$TGL_AWAL_CARD = $_POST[TGL_AWAL_CARD];
		$TGL_AKHIR_CARD = $_POST[TGL_AKHIR_CARD];
		$TGL_AMBIL_CARD = $_POST[TGL_AMBIL_BERKAS];
		$TGL_PENGEMBALIAN = $_POST[TGL_PENGEMBALIAN];
		$STATUS_PENGEMBALIAN = $_POST[STATUS_PENGEMBALIAN];
		$VERIFIKASI = $_POST[statusverifikasi];
		$KETERANGAN = $_POST[keterangan];

		if ($VERIFIKASI == 1) {
			$TGL_AWAL_CARD = "TGL_AWAL_CARD = null,";
			$TGL_AKHIR_CARD = "TGL_AKHIR_CARD = null,";
			$TGL_AMBIL_CARD1 = "TGL_AMBIL_BERKAS = null,";
			$kd_w = 'KD_WORKFLOW = 1';
		} elseif ($VERIFIKASI == 2) {
			$TGL_AWAL_CARD = "TGL_AWAL_CARD = '$TGL_AWAL_CARD',";
			$TGL_AKHIR_CARD = "TGL_AKHIR_CARD = '$TGL_AKHIR_CARD',";
			$TGL_AMBIL_CARD1 = "TGL_AMBIL_BERKAS = '$TGL_AMBIL_CARD',";
			$kd_w = 'KD_WORKFLOW = 3';
		} else {
			$TGL_AWAL_CARD = "TGL_AWAL_CARD = null,";
			$TGL_AKHIR_CARD = "TGL_AKHIR_CARD = null,";
			$TGL_AMBIL_CARD1 = "TGL_AMBIL_BERKAS = null,";
			$kd_w = 'KD_WORKFLOW = 2';
		}

		function sendemail($nodaftar,$nama,$email,$kd_flow,$ket,$tglambil)
		{
			$to      = $email;
			//$noreg   = $nodaftar;
			$bcc	 = 'BCC : no-reply.sito@kemlu.go.id';
			//if

			/*
			<p>Permohonan atas nama : <strong>$nama</strong> dengan nomor registrasi : <strong>$nodaftar</strong> telah disetujui, dengan keterangan $ket dan Kartu Identitas bisa diambil di loket Direktorat Fasilitas Diplomatik pada tanggal <b>$tglambil</b>.
			</p>
			<p>Your application with the registration number : <strong>$nodaftar</strong> for <strong>$nama</strong> has been verified, please kindly take attention on following note $ket and ID Card can be taken at the Directorate of Diplomatic Facilities counter on this date <b>$tglambil</b>.
			</p>
			*/
			$messagelolos = "
			<html>
					<head>
					<title>Konfirmasi Kartu Identitas</title>
					</head>
					<body>
					<p>Yth. Pemohon </p>

					<p>Permohonan atas nama : <strong>$nama</strong> dengan nomor registrasi : <strong>$nodaftar</strong> telah disetujui, dengan keterangan $ket  dan Kartu Identitas bisa diambil di loket Direktorat Fasilitas Diplomatik pada tanggal <b>$tglambil</b> berdasarkan perjanjian dengan membawa nota diplomatik, paspor, ID Card lama, dan surat keterangan kehilangan (untuk permohonan hilang) yang asli.
					</p>
					<br>Terima kasih
					<br>==========================================================<br>
					<p>To The Applicant</p>

					<p>Your application with the registration number : <strong>$nodaftar</strong> for <strong>$nama</strong> has been approved with following note $ket and the ID Card can be collected on <b>$tglambil</b> at the Directorate of Diplomatic Facilities counter based on appointment by bring out the original diplomatic note, passport, old ID Card, and lost report from Police (for lost application).
					</p>
					<br>Thank you.
					</body>
					</html>
			";

			$messagetolak = "
			<html>
					<head>
					<title>Konfirmasi Kartu Identitas</title>
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

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: NO REPLY - Layanan Protokol Konsuler Kementerian Luar Negeri RI <no-reply.sito@kemlu.go.id>' . "\r\n".$bcc;

			if($kd_flow == 2)
			{
				$message = $messagelolos;
				$noreg1  = $nodaftar;
				$subject_temp = 'Konfirmasi Kartu Identitas No. Daftar : '.$noreg1.' (SIBLING) Disetujui / ID Card Confirmation Reg. No : '.$noreg1.' (SIBLING) Approved';
				$subject = $subject_temp;
			}
			elseif($kd_flow == 1)
			{
				$message = $messagetolak;
				$noreg1  = $nodaftar;
				$subject = 'Konfirmasi Kartu Identitas No. Daftar : '.$noreg1.' (SIBLING) Ditolak / ID Card Confirmation Reg. No : '.$noreg1.' (SIBLING) Rejected';
			}

			return mail($to, $subject, $message, $headers);

		}

		$a17 = "
		select a.ID_CETAK_S,a.ID_SIBLING,d.USER_PERWAKILAN_EMAIL AS EMAIL_EMBASSY,
		a.ID_DIPLOMAT,a.ID_JNS_CETAK_KARTU,a.ID_CARD,
		a.TGL_AWAL_CARD,a.TGL_AKHIR_CARD,a.TGL_AMBIL_BERKAS,a.KD_WORKFLOW,a.NM_SIBLING,
		a.ST_KARTU,a.ST_KARTU_K,a.ST_KARTU_KAS,a.STATUS_PENGEMBALIAN, a.KETERANGAN,
		a.ID_PERMIT_S, a.NO_DAFTAR from  v_id_card_s_w_permit a
		RIGHT JOIN sibling b on b.ID_SIBLING = a.ID_SIBLING
		RIGHT JOIN diplomat c on b.ID_DIPLOMAT = c.ID_DIPLOMAT
		LEFT JOIN tbl_user_perwakilan d on d.ID_KNT_PERWAKILAN = c.ID_KNT_PERWAKILAN
		where a.ID_CETAK_S = $idt and a.KD_WORKFLOW>=1
		";
		$b17 = mysql_query($a17);
		$c17 = mysql_fetch_array($b17);

		if($VERIFIKASI == 1) {

			if($c17['KD_WORKFLOW'] != 1) {
				sendemail($c17['NO_DAFTAR'],$c17['NM_SIBLING'],$c17['EMAIL_EMBASSY'],$VERIFIKASI,$KETERANGAN,$TGL_AMBIL_CARD);
			}
		} elseif($VERIFIKASI == 2) {

			if($c17['KD_WORKFLOW'] != 3) {
				sendemail($c17['NO_DAFTAR'],$c17['NM_SIBLING'],$c17['EMAIL_EMBASSY'],$VERIFIKASI,$KETERANGAN,$TGL_AMBIL_CARD);
			}
		}

		$sql=" update cetak_kartu_sibling set ID_SIBLING = $ID_SIBLING,
			ID_JNS_CETAK_KARTU = $ID_JNS_CETAK_KARTU,
			ID_CARD = '$ID_CARD',
			TGL_PENGEMBALIAN = '$TGL_PENGEMBALIAN',
			STATUS_PENGEMBALIAN = '$STATUS_PENGEMBALIAN',
			KETERANGAN = '$KETERANGAN',
			ID_ROOT_KANTOR = '$ID_ROOT_KANTOR',
			$TGL_AWAL_CARD
			$TGL_AKHIR_CARD
			$TGL_AMBIL_CARD1
			$kd_w
			where ID_CETAK_S =  $idt";
		

		if (mysql_query($sql)) {
			if (!empty($_POST['syarat'])) {
				foreach ($_POST['syarat'] as $syarat) {
					$insert_syarat = mysql_query("INSERT INTO syarat_permit (syarat_kd, id_permit) VALUES ('".$syarat."','".$idt."')");
				}
			}

			echo "<script>
			alert ('Berhasil verifikasi ID Card Sibling');
			document.location.href='./deplu.php?module=$module&act=lihat_id_card&idt=$ID_SIBLING&negara=$neg';
			</script>";
		} else {
			echo "<script>
			alert ('Gagal verifikasi ID Card Sibling! mohon cek kembali pengisiannya.');
			document.location.href='./deplu.php?module=$module&act=lihat_id_card&idt=$ID_SIBLING&negara=$neg';
			</script>";
			echo '<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>';
		}

	} elseif ($module == 'idcardSib' AND $act == 'noseri' AND isset($_GET[idt])) {
		$idt = $_GET[idt];
		$idc = $_GET[idc];
		$COUNTER_CETAK = $_POST[COUNTER_CETAK];

		$sql = "update cetak_kartu_sibling set COUNTER_CETAK = '$COUNTER_CETAK' where ID_CETAK_S = $idc";

		if(mysql_query($sql)) {
			echo "<script>
			alert ('Berhasil Update Nomor Seri');
			document.location.href='./deplu.php?module=$module&act=lihat_id_card&idt=$idt&negara=$neg';
			</script>";
		} else  {
			echo "<script>
			alert ('Gagal Update Nomor Seri! mohon coba kembali.');
			document.location.href='./deplu.php?module=$module&act=lihat_id_card&idt=$idt&negara=$neg';
			</script>";
		}
	}
}
?>
