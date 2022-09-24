<?php
	include "../config/koneksi.php";
	include "../config/library.php";
	$a = "select distinct NM_DIPLOMAT,TGL_AWAL_PERMIT, TGL_AKHIR_PERMIT,NO_IZIN_PERMIT, NM_JNS_PERMIT, EMAIL_EMBASSY from v_stay_permit where ID_PERMIT =  2548";
	$b = mysql_query($a);
	$c = mysql_fetch_array($b);
	//print_r($c['NM_DIPLOMAT']);exit;
	sendemail($c['NM_DIPLOMAT'],$c['TGL_AWAL_PERMIT'],$c['TGL_AKHIR_PERMIT'],$c['NO_IZIN_PERMIT'],$c['NM_JNS_PERMIT'],$c['EMAIL_EMBASSY']);
	echo "email terkirim";
	//mysql_close;
	
	function sendemail($nama,$tglawal,$tglakhir,$noizin,$jnspermit,$email)
	{
		$to      = 'hartarto.anugerah@kemlu.go.id';
		$subject = 'Konfirmasi Ijin Tinggal Online';
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
		$headers .= 'From: Admin Ijin Tinggal Online' . "\r\n";
		
		if(status== 2)
		{
			$message = $messagelolos;
		}
		elseif(status== 1)
		{
			$message = $messagetolak;
		}	
		
		mail($to, $subject, $message, $headers);
		
	}
?>