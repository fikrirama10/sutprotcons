<?php
session_start();

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])) {
	$template = file("../template/canvasawal.htm");
	$template = implode("",$template );

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

	$template = file("../template/canvasDeplu.htm");
	$template = implode("",$template );

	if ($module=='staypermit' AND $act=='input') {
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

		$qSelect1 = mysql_query("select max(TGL_AKHIR_PERMIT) as TGL_MAX from permit_diplomat where  ST_PERMIT_KAS = 2 and ST_PERMIT_K = 2 and ID_JNS_PERMIT =$ID_JNS_PERMIT  and ID_DIPLOMAT = $ID_DIPLOMAT ");
		$b1 = mysql_fetch_array($qSelect1);
		if (!(is_null($b[TGL_MAX])) and ($b[TGL_MAX] <=  $TGL_AWAL_PERMIT)) {
			$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br>Masih ada permit yang masih aktif. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
			$template = eregi_replace("{isi}",$varname,$template);
			echo $template;
		} else {
			if ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT ) {
				$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br>Tanggal awal harus lebih kecil dari tanggal berakhir. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
				$template = eregi_replace("{isi}",$varname,$template);
				echo $template;
			} else {
				$qSelect=mysql_query("select NM_DIPLOMAT,DATE_FORMAT(AKHIR_BERLAKU,'%d-%M-%Y') AS AKHIR_BERLAKU,date_add(AKHIR_BERLAKU, interval -30 day) as BATAS_PERMIT, DATE_FORMAT(date_add(AKHIR_BERLAKU, interval -180 day),'%d-%M-%Y') as BATAS_PERMIT_2 from diplomat where ID_DIPLOMAT = $ID_DIPLOMAT");
				$b=mysql_fetch_array($qSelect);
				if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT]) {
					$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br>Tanggal akhir permit maksimal 30 hari sebelum masa berlaku paspor habis.<br>Masa Berlaku paspor milik <b>$b[NM_DIPLOMAT]</b> habis pada tanggal <b>$b[AKHIR_BERLAKU]</b> .<br>Batas Maksimal Tanggal akhir permit adalah <b>$b[BATAS_PERMIT_2]</b> .
					<br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
					$template = eregi_replace("{isi}",$varname,$template);
					echo $template;
				} else {
					if  ($ID_JNS_PERMIT==1) {

						$cmp1="SELECT COUNT(ID_PERMIT_S) as jml FROM v_stay_permit_sib WHERE NO_IZIN_PERMIT LIKE CONCAT('KAG/',date_format('2012-12-26','%y'),'/%')";
						$res=mysql_query($cmp1);
						$jml1=mysql_fetch_array($res);

						$cmp2="SELECT COUNT(ID_PERMIT) as jml FROM v_stay_permit WHERE NO_IZIN_PERMIT LIKE CONCAT('KAG/',date_format('2012-12-26','%y'),'/%')";
						$res2=mysql_query($cmp2);
						$jml2=mysql_fetch_array($res2);

						$urut_permit=$jml1['jml']+$jml2['jml']+1;

						$sql="insert into permit_diplomat (ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,TGL_AGENDA,NO_IZIN_PERMIT,TGL_AWAL_PERMIT,TGL_AKHIR_PERMIT,KET,ST_PERMIT,ST_PERMIT_K,ST_PERMIT_KAS,NO_NOTA,TGL_NOTA) values ($ID_DIPLOMAT,$ID_JNS_PERMIT,'$NO_AGENDA','$TGL_AGENDA','$NO_IZIN_PERMIT','$TGL_AWAL_PERMIT','$TGL_AKHIR_PERMIT','$KET','$KETVER','$KETHOR',1,1,1,'$NO_NOTA','$TGL_NOTA')";
		
						mysql_query($sql);
					} else {
						$cmp1="SELECT COUNT(ID_PERMIT_S) as jml FROM v_stay_permit_sib WHERE NO_IZIN_PERMIT LIKE CONCAT('KAG/',date_format('2012-12-26','%y'),'/%')";

						$res=mysql_query($cmp1);
						$jml1=mysql_fetch_array($res);

						$cmp2="SELECT COUNT(ID_PERMIT) as jml FROM v_stay_permit WHERE NO_IZIN_PERMIT LIKE CONCAT('KAG/',date_format('2012-12-26','%y'),'/%')";
						$res2=mysql_query($cmp2);
						$jml2=mysql_fetch_array($res2);

						$urut_permit=$jml1['jml']+$jml2['jml']+1;

						$sql="insert into permit_diplomat (ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,TGL_AGENDA,NO_IZIN_PERMIT,TGL_AWAL_PERMIT,TGL_AKHIR_PERMIT,KET,ST_PERMIT,ST_PERMIT_K,ST_PERMIT_KAS,NO_NOTA,TGL_NOTA) values ($ID_DIPLOMAT,$ID_JNS_PERMIT,'$NO_AGENDA','$TGL_AGENDA','$NO_IZIN_PERMIT','$TGL_AWAL_PERMIT','$TGL_AKHIR_PERMIT','$KET','$KETVER','$KETHOR',1,1,1,'$NO_NOTA','$TGL_NOTA')";
	
						mysql_query($sql);
					}
					
					if (!empty($_POST['syarat'])) {
			
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
	} elseif ($module=='staypermit' AND $act=='hapus' AND isset($_GET[idt])) {
		$idd = $_GET[idd];
		mysql_query("DELETE FROM permit_diplomat WHERE ID_PERMIT ='$_GET[idt]'");
		$sql="select distinct(a.syarat_kd) from m_syarat a, syarat_permit b  WHERE a.jenis_izin='1' and b.id_permit='$_GET[idt]'";
		$query = mysql_query($sql);
		while ($data=mysql_fetch_array($query)) {
			mysql_query("DELETE FROM syarat_permit WHERE syarat_kd='".$data['syarat_kd']."'");
		}

		header('location: ./deplu.php?module='.$module.'&act=lihat_stay_permit&idt='.$idd.'&negara='.$neg);
	} elseif ($module=='staypermit' AND $act=='update' AND isset($_GET[idt])) {
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
		$NM_VERIFIKATOR = $_SESSION[G_namauser];
		$ID_VERIVIKATOR = $_SESSION[G_iduser];
		date_default_timezone_set('Asia/Jakarta');
		$TGL_VERIFIKASI = date("Y-m-d H:i:s");

		//print_r($idt. ' sip');exit;
		if ($VERIFIKASI == 2) {
			$VERIFIKASI_AWAL = 3;
		} else {
			$VERIFIKASI_AWAL = 1;
		}

		//print_r($VERIFIKASI_AWAL. ' sip');exit;
		$KET = $_POST[KET];
		$KETVER = $_POST[KET_VER];
		$KETHOR = $_POST[KET_HOR];
		$NO_NOTA = $_POST[NO_NOTA];
		$TGL_NOTA = $_POST[TGL_NOTA];

		if ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT ) {
			$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Ubah Data Gagal.</b><br>Tanggal awal harus lebih kecil dari tanggal berakhir. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
			$template = eregi_replace("{isi}",$varname,$template);
			echo $template;
		} else {
			$qSelect=mysql_query("select NM_DIPLOMAT,DATE_FORMAT(AKHIR_BERLAKU,'%d-%M-%Y') AS AKHIR_BERLAKU,date_add(AKHIR_BERLAKU, interval -180 day) as BATAS_PERMIT, DATE_FORMAT(date_add(AKHIR_BERLAKU, interval -180 day),'%d-%M-%Y') as BATAS_PERMIT_2 from diplomat where ID_DIPLOMAT = $ID_DIPLOMAT");
			$b=mysql_fetch_array($qSelect);
			if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT]) {
				$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Ubah Data Gagal.</b><br>Tanggal akhir permit maksimal 180 hari sebelum masa berlaku paspor habis.<br>Masa Berlaku paspor milik <b>$b[NM_DIPLOMAT]</b> habis pada tanggal <b>$b[AKHIR_BERLAKU]</b> .<br>Batas Maksimal Tanggal akhir permit adalah <b>$b[BATAS_PERMIT_2]</b> .
				<br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
				$template = eregi_replace("{isi}",$varname,$template);
				echo $template;
			} else {
				$a = "select distinct NO_DAFTAR,KD_WORKFLOW, NM_DIPLOMAT,TGL_AMBIL_BERKAS,TGL_AWAL_PERMIT, TGL_AKHIR_PERMIT,NO_IZIN_PERMIT, NM_JNS_PERMIT, EMAIL_EMBASSY from v_stay_permit where ID_PERMIT =  $idt";
				$b = mysql_query($a);
				$c = mysql_fetch_array($b);
				
				function sendemail($nodaftar, $nama, $tglawal, $tglakhir, $noizin, $jnspermit, $email, $kd_flow, $ket, $tglambil)
				{
					$to = $email;
					$bcc = 'BCC : yusuf.firmansyah@gmail.com';
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

					// Format berlaku mulai 2022-01-15
					$messagelolos = "
						<html>
							<head>
								<title>Konfirmasi Ijin Tinggal Online</title>
							</head>
							<body>
								<h3>
									<u>KEMENTERIAN LUAR NEGERI REPUBLIK INDONESIA</u>
									<br/>
									DIREKTORAT KONSULER
								</h3>
								<p>
									Yth. Pemohon,
									<br/>
									Permohonan atas nama : <strong>$nama</strong> dengan nomor registrasi : <strong>$nodaftar</strong> telah disetujui, mohon agar dapat menyerahkan berkas ke loket Konsuler pada tanggal $tglambil.
								</p>
								Terima kasih
								<br/>
								==============================================
								<p>
									To The Applicant,
									<br/>
									Your application with the registration number : <strong>$nodaftar</strong> for <strong>$nama</strong> has been verified, kindly submit the original documents to the consular counter on this date $tglambil.
								</p>
								Thank you.
								<br/>
								<p>
									<u><strong>KELENGKAPAN PEMOHON :</strong></u>
									<ul style='list-style-type:circle'>
										<li>Nota Diplomatik dari Perwakilan Negara Asing & Organisasi Internasional/Surat Pengantar Kementerian/Lembaga</li>
										<li>Paspor Asli (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) Paspor</li>
										<li>Nota Dinas Setneg untuk Organisasi Internasional & Kementerian/Lembaga</li>
									</ul>
								</p>
								<p>
									<u><strong>PERMOHONAN YANG DIAJUKAN :</strong></u>
									<ul style='list-style-type:circle'>
										<li>Permohonan Stay Permit sampai dengan :</li>
										<li>Perpanjangan Stay Permit sampai dengan :</li>
									</ul>
								</p>
								<p>
									<u><strong>CATATAN KASUBDIT :</strong></u>
                                    <br/>
									<p style='border-bottom-style:dotted'></p>
								</p>
								<p>
									<u><strong>DISPOSISI DIREKTUR KONSULER :</strong></u>
                                    <br/>
									<p style='border-bottom-style:dotted'></p>
								</p>
								<table border='1' cellspacing='0' style='width:100%'>
									<thead>
										<tr style='text-align:center'>
											<td style='width:33%'>PARAF KASI</td>
											<td style='width:33%'>PARAF KASUBDIT</td>
											<td style='width:34%'>PARAF DIREKTUR</td>
										</tr>
                                    </thead>
                                    <tbody>
										<tr style='height:30px'>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										</tr>
                                    </tbody>
								</table>
								<br/>
								<table border='1' cellspacing='0' style='width:100%'>
									<thead>
										<tr style='text-align:center'>
											<td style='width:33%'>TANGGAL DITERIMA</td>
											<td style='width:33%'>TANGGAL DICETAK</td>
											<td style='width:34%'>TANGGAL PENGAMBILAN</td>
										</tr>
                                    </thead>
                                    <tbody>
										<tr style='height:30px'>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										</tr>
                                    </tbody>
								</table>
								<p>
									<u><strong>CATATAN PETUGAS :</strong></u>
									<ul style='list-style-type:circle'>
										<li>Masa berlaku paspor tidak mencukupi</li>
										<li>Transfer</li>
										<br/>
										<p style='border-bottom-style:dotted'></p>
									</ul>
								</p>
								
							</body>
						</html>
					";

					// Format sebelum 2022-01-15
					$messagelolosold = "
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
									ke loket konsuler pada tanggal $tglambil.
								</p>
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
									to the consular counter  on this date $tglambil.
								</p>
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

					if ($kd_flow == 2) {
						$message = $messagelolos;
						$noreg1  = $nodaftar;
						$subject_temp = 'Konfirmasi Ijin Tinggal No. Daftar / Stay Permit Confirmation Reg. No : '.$noreg1.' (DIPLOMAT) Disetujui / Approved';
						$subject = $subject_temp;
					} elseif( $kd_flow == 1) {
						$message = $messagetolak;
						$noreg1  = $nodaftar;
						$subject = 'Konfirmasi Ijin Tinggal No. Daftar / Stay Permit Confirmation Reg. No : '.$noreg1.' (DIPLOMAT) Ditolak / Rejected';
					}

					return mail($to, $subject, $message, $headers);
				}

				if ($VERIFIKASI == 1) {
					if($c['KD_WORKFLOW'] != 1) {
						sendemail($c['NO_DAFTAR'], $c['NM_DIPLOMAT'], $c['TGL_AWAL_PERMIT'], $c['TGL_AKHIR_PERMIT'], $c['NO_IZIN_PERMIT'], $c['NM_JNS_PERMIT'], $c['EMAIL_EMBASSY'], $VERIFIKASI, $KET, $TGL_AMBIL);
					}
				} elseif ($VERIFIKASI == 2) {
					if($c['KD_WORKFLOW'] != 3) {
						sendemail($c['NO_DAFTAR'], $c['NM_DIPLOMAT'], $c['TGL_AWAL_PERMIT'], $c['TGL_AKHIR_PERMIT'], $c['NO_IZIN_PERMIT'], $c['NM_JNS_PERMIT'], $c['EMAIL_EMBASSY'], $VERIFIKASI, $KET, $TGL_AMBIL);
					}
				}

				$tgl_agenda_explode = explode("-", $TGL_AGENDA);
				if ($tgl_agenda_explode[0] != '1899') {
					$str_agenda = "TGL_AGENDA = '$TGL_AGENDA',";
				} else {
					$str_agenda = "";
				}

				// echo $str_agenda; exit;
				$sql ="update permit_diplomat set ID_DIPLOMAT = $ID_DIPLOMAT,
										ID_JNS_PERMIT = $ID_JNS_PERMIT,
										NO_AGENDA = '$NO_AGENDA',
										$str_agenda
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
										TGL_NOTA = '$TGL_NOTA',
										ID_VERIFIKATOR = '$ID_VERIVIKATOR',
										NM_VERIFIKATOR = '$NM_VERIFIKATOR',
										TGL_VERIFIKASI = '$TGL_VERIFIKASI'
										where ID_PERMIT =  $idt";
				mysql_query($sql);

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