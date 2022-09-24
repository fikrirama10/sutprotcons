<?php
$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];

$tgl_sekarang = date("Ymd");
$thn_sekarang = date("Y");
$jam_sekarang = date("H:i:s");

$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");
					
					
function get_noijinagendatglawalakhir($id_permit, $jns_permit)
{
	if ($jns_permit==1)
	{
		$sql = "SELECT m_kantor_perwakilan.`KODE_AGENDA`, m_counter_agenda.`LAST_AGENDA`+1 AS LAST_AGENDA, `TYPE` FROM permit_diplomat
				JOIN diplomat ON diplomat.`ID_DIPLOMAT` = permit_diplomat.`ID_DIPLOMAT`
				JOIN m_kantor_perwakilan ON m_kantor_perwakilan.`ID_KNT_PERWAKILAN` = diplomat.`ID_KNT_PERWAKILAN`
				JOIN m_counter_agenda ON m_counter_agenda.`KODE_AGENDA` = m_kantor_perwakilan.`KODE_AGENDA` AND `TYPE`= JNS_IZIN_PERMIT
	WHERE id_permit=$id_permit";
	
	}elseif ($jns_permit==2)
	{
		$sql = "SELECT m_kantor_perwakilan.`KODE_AGENDA`, m_counter_agenda.`LAST_AGENDA`+1 AS LAST_AGENDA, `TYPE` FROM permit_sibling
				JOIN sibling ON permit_sibling.id_sibling = sibling.`ID_SIBLING`
				JOIN diplomat ON diplomat.`ID_DIPLOMAT` = sibling.`ID_DIPLOMAT`
				JOIN m_kantor_perwakilan ON m_kantor_perwakilan.`ID_KNT_PERWAKILAN` = diplomat.`ID_KNT_PERWAKILAN`
				JOIN m_counter_agenda ON m_counter_agenda.`KODE_AGENDA` = m_kantor_perwakilan.`KODE_AGENDA` AND `TYPE`= JNS_IZIN_PERMIT
				WHERE id_permit_s=$id_permit";
	}
	
	//print_r($sql);exit;
	$query = mysql_query($sql);
	
	while($row = mysql_fetch_array($query)) {
        $KODE_AGENDA=$row['KODE_AGENDA'];
        $TYPE=$row['TYPE'];
		$arrRet['NO_AGENDA'] = str_pad($row['LAST_AGENDA'], 3, "0", STR_PAD_LEFT);
		$arrRet['TGL_AGENDA'] = date("Y-m-d");
		$arrRet['NO_IZIN_PERMIT'] = "KAG-KAF/".substr(date("Y"),2,2)."/".$row['KODE_AGENDA']."/".$row['TYPE']."/".str_pad($row['LAST_AGENDA'], 5, "0", STR_PAD_LEFT);;
		//$arrRet['NO_IZIN_PERMIT'] = $sqlUpdateCounter;
		$arrRet['TGL_AWAL_PERMIT'] = date("Y-m-d");
		$arrRet['TGL_AKHIR_PERMIT'] = date('Y-m-d', strtotime("+30 days"));
		
	
	
	}
	
	
	//$arrRet['NO_AGENDA'] = "1001";
	//$arrRet['TGL_AGENDA'] = date("Y-m-d");
	//$arrRet['NO_IZIN_PERMIT'] = "1001";
	//$arrRet['TGL_AWAL_PERMIT'] = date("Y-m-d");
	//$arrRet['TGL_AKHIR_PERMIT'] = date('Y-m-d', strtotime("+30 days"));
	mysql_query("UPDATE m_counter_agenda SET LAST_AGENDA=LAST_AGENDA+1 WHERE KODE_AGENDA='$KODE_AGENDA' AND TYPE='$TYPE'");
	return $arrRet;

}

function get_last_agenda($id_permit, $jns_permit)
{
	if ($jns_permit==1)
	{
	$sql = "SELECT m_kantor_perwakilan.`KODE_AGENDA`, m_counter_agenda.`LAST_AGENDA`+1, m_jns_paspor.`KD_JNS_PASPOR` FROM permit_diplomat
JOIN diplomat ON diplomat.`ID_DIPLOMAT` = permit_diplomat.`ID_DIPLOMAT`
JOIN m_kantor_perwakilan ON m_kantor_perwakilan.`ID_KNT_PERWAKILAN` = diplomat.`ID_KNT_PERWAKILAN`
JOIN m_counter_agenda ON m_counter_agenda.`KODE_WILAYAH` = m_kantor_perwakilan.`KODE_AGENDA`
JOIN m_jns_paspor ON m_jns_paspor.`ID_JNS_PASPOR` = diplomat.`ID_JNS_PASPOR`
WHERE id_permit=$id_permit";
	
	}elseif ($jns_permit==2)
	{
	$sql = "SELECT m_kantor_perwakilan.`KODE_AGENDA`, m_counter_agenda.`LAST_AGENDA`+1, m_jns_paspor.`KD_JNS_PASPOR` FROM permit_sibling
JOIN sibling ON permit_sibling.id_sibling = sibling.`ID_SIBLING`
JOIN diplomat ON diplomat.`ID_DIPLOMAT` = sibling.`ID_DIPLOMAT`
JOIN m_kantor_perwakilan ON m_kantor_perwakilan.`ID_KNT_PERWAKILAN` = diplomat.`ID_KNT_PERWAKILAN`
JOIN m_counter_agenda ON m_counter_agenda.`KODE_WILAYAH` = m_kantor_perwakilan.`KODE_AGENDA`
JOIN m_jns_paspor ON m_jns_paspor.`ID_JNS_PASPOR` = sibling.`ID_JNS_PASPOR`
WHERE id_permit_s=$id_permit";
	}
	$query = mysql_query($sql);
	//echo $query;
	//exit;
}


		
function sendemail_Diplomat($nodaftar,$nama,$tglawal,$tglakhir,$noizin,$jnspermit,$email,$kd_flow,$status)
{
	
		$to      = $email;
		$subject = 'Konfirmasi Ijin Tinggal Online Kementerian Luar Negeri Republik Indonesia';
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
				Admin Ijin Tinggal Online Kementerian Luar Negeri RI
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
				<p>Yth. $nama </p>
				
				<p>Ijin Tinggal anda telah di diverifikasi :</p>
				<br>
				Silahkan datang ke Loket Konsuler Kementerian Luar Negeri Republik Indonesia
				<br>
				No Pendaftaran : $nodaftar
					
				<br>
				Jl. Pejambon 6 Jakarta Pusat 
				<br>
				
				<p>
				Atas perhatiannya kami ucapkan terima kasih.
				</p>
				
				<p>
				Salam Hormat,<br><br>
				Admin Ijin Tinggal Online Kementerian Luar Negeri RI
				</p>
				<br>
				<br>
				<hr><br>
				<small>Email ini dikirim secara otomatis oleh sistem. Harap tidak membalas ke alamat email ini. Pertanyaan dapat dikirimkan ke konsuler@kemlu.go.id. Terima kasih.</small>
				</body>
				</html>
		";
		
		$messagetolak = "
		<html>
				<head>
				<title>Konfirmasi Ijin Tinggal Online</title>
				</head>
				<body>
				<p>Yth. $nama </p>
				
				<p>Ijin Tinggal anda telah di ditolak</p>
				
				<p>
				Atas perhatiannya kami ucapkan terima kasih.
				</p>
				
				<p>
				Salam Hormat,<br><br>
				Admin Ijin Tinggal Online Kementerian Luar Negeri RI
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
		$headers .= 'From: NO REPLY - Sistem Ijin Tinggal Online Kementerian Luar Negeri RI <no-reply.sitokonsuler@kemlu.go.id>' . "\r\n";
		
		if($status == 2)
		{
			$message = $messagelolos;
		}
		elseif($status == 0)
		{
			$message = $messagetolak;
		}	
		
		return mail($to, $subject, $message, $headers);
		
	
}

function sendemail_Sibling($nodaftar,$nama,$tglawal,$tglakhir,$noizin,$jnspermit,$email,$kd_flow,$status)
{
	
		$to      = $email;
		$subject = 'Konfirmasi Ijin Tinggal Online Kementerian Luar Negeri Republik Indonesia';
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
				Admin Ijin Tinggal Online Kementerian Luar Negeri RI
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
				<p>Yth. $nama </p>
				
				<p>Ijin Tinggal anda telah di diverifikasi :</p>
				<br>
				Silahkan datang ke Loket Konsuler Kementerian Luar Negeri Republik Indonesia
				<br>
				No Pendaftaran : $nodaftar
					
				<br>
				Jl. Pejambon 6 Jakarta Pusat 
				<br>
				
				<p>
				Atas perhatiannya kami ucapkan terima kasih.
				</p>
				
				<p>
				Salam Hormat,<br><br>
				Admin Ijin Tinggal Online Kementerian Luar Negeri RI
				</p>
				<br>
				<br>
				<hr><br>
				<small>Email ini dikirim secara otomatis oleh sistem. Harap tidak membalas ke alamat email ini. Pertanyaan dapat dikirimkan ke konsuler@kemlu.go.id. Terima kasih.</small>
				</body>
				</html>
		";
		
		$messagetolak = "
		<html>
				<head>
				<title>Konfirmasi Ijin Tinggal Online</title>
				</head>
				<body>
				<p>Yth. $nama </p>
				
				<p>Ijin Tinggal anda telah di ditolak</p>
				
				<p>
				Atas perhatiannya kami ucapkan terima kasih.
				</p>
				
				<p>
				Salam Hormat,<br><br>
				Admin Ijin Tinggal Online Kementerian Luar Negeri RI
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
		$headers .= 'From: NO REPLY - Sistem Ijin Tinggal Online Kementerian Luar Negeri RI <no-reply.sitokonsuler@kemlu.go.id>' . "\r\n";
		
		if($kd_flow == 2)
		{
			$message = $messagelolos;
		}
		elseif($kd_flow == 1)
		{
			$message = $messagetolak;
		}	
		
		return mail($to, $subject, $message, $headers);
		
	
}
					
					
?>
