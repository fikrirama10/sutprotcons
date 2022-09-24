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


function generate_urutan($visa,$idc,$jns)
	{
      if($jns == 'manual'){
        $query = mysql_query("select a.THN_AGENDA as THN,a.KODE_AGENDA as KODE_AGENDA,c.KD_JNS_PASPOR as KD_PASPOR, b.jns_paspor as ID_JNS_PASPOR, a.TIPE_VISA from epo_diplomat a, tbl_trans_otvis b, tbl_jns_paspor c where a.ID_OTVIS=b.id and b.jns_paspor=c.id and a.ID_EPO='" . $idc . "'");
      }else{
        $query = mysql_query("select a.THN_AGENDA as THN,a.KODE_AGENDA as KODE_AGENDA,c.KD_JNS_PASPOR as KD_PASPOR, b.ID_JNS_PASPOR as ID_JNS_PASPOR, a.TIPE_VISA from epo_diplomat a, diplomat b, m_jns_paspor c where a.id_diplomat=b.id_diplomat and b.ID_JNS_PASPOR=c.ID_JNS_PASPOR and a.ID_EPO='" . $idc . "'");
      }
      
      $data = mysql_fetch_array($query);
      $kd_agenda = $data['KODE_AGENDA'];
      $kd_paspor = $data['KD_PASPOR'];
      $tipe_visa = $data['TIPE_VISA'];

        $urutan = mysql_query("SELECT x.NO_EPO from
				((select SUBSTRING( a.NO_EPO, 13, 5) AS no_urut, 'diplomat' as status, a.NO_EPO from epo_diplomat a where SUBSTRING( a.NO_EPO, 11, 1)='" . $visa ."' and a.NO_EPO IS NOT NULL AND YEAR(a.TGL_VERIFIKASI)=year(curdate()))
				UNION
				(select SUBSTRING( a.NO_EPO, 13, 5) AS no_urut , 'SIBLING' as status, a.NO_EPO from epo_sibling a where SUBSTRING( a.NO_EPO, 11, 1)='" . $visa ."' and a.NO_EPO IS NOT NULL AND YEAR(a.TGL_VERIFIKASI)=year(curdate())))
				as x
				order by x.no_urut DESC LIMIT 1");
      //}
      $data2['NO_EPO']="";
		if($urutan){
				$data2=mysql_fetch_array($urutan);
		}
      $tahun = substr($data2['NO_EPO'], 4, 2);
      $sekarang = substr(date("Y"), 2, 2);

      //print_r($sekarang);exit;
      if ($tahun == $sekarang) {
        $urut = substr($data2['NO_EPO'], -5, strlen($data2['NO_EPO']));
        $urut = $urut + 1;
      } else {
        $urut = 1;
      }
      switch (strlen($urut)) {
        case 1:
          $urutnya = '0000' . $urut;
          break;
        case 2:
          $urutnya = '000' . $urut;
          break;
        case 3:
          $urutnya = '00' . $urut;
          break;
        case 4:
          $urutnya = '0' . $urut;
          break;
        default:
          $urutnya = $urut;
      }

	  $NO_EPO="KAF/".$sekarang."/".$kd_agenda."/".$visa."/".$urutnya;
	  return $NO_EPO;
	}

if ($module=='epo' AND $act=='input'){

$ID_DIPLOMAT= $_POST[ID_DIPLOMAT];
$ID_EPO= $_POST[ID_EPO];
//$TGL_AWAL_EPO= $_POST[TGL_AWAL_EPO];
$TGL_AKHIR_EPO= $_POST[TGL_AKHIR_EPO];

   mysql_query("insert into epo_diplomat (ID_DIPLOMAT,ID_EPO,TGL_AWAL_EPO,TGL_AKHIR_EPO,ST_EPO,ST_EPO_K,ST_EPO_KAS, KD_WORKFLOW, NO_DAFTAR)
values ('$ID_DIPLOMAT','$ID_EPO','','$TGL_AKHIR_EPO',2,2,2,3,'OFFLINE')");
	//input persyaratan
	$query_max_idepo = mysql_query("SELECT MAX(ID_EPO) as max FROM epo_diplomat"); 
	$max=mysql_fetch_array($query_max_idepo);
	$max=$max['max'];
	
	foreach ($_POST['syarat'] as $syarat) {
		$insert_syarat = mysql_query("INSERT INTO syarat_epo (syarat_kd, id_permit, file) VALUES ('".$syarat."','".$max."','OFFLINE')");
	}

	header('location: ./deplu.php?module='.$module.'&act=lihat_epo&idt='.$ID_DIPLOMAT.'&negara='.$neg);
 }
elseif ($module=='epo' AND $act=='hapus' AND isset($_GET[idc])){
	  $idd = $_GET[idd];
	  mysql_query("DELETE FROM epo_diplomat WHERE ID_EPO ='$_GET[idc]'");
	  $sql="select distinct(a.syarat_kd) from m_syarat a, syarat_permit b  WHERE a.jenis_izin='6' and b.id_permit='$_GET[idc]'";
 	  $query = mysql_query($sql);
	  while ($data=mysql_fetch_array($query)) {
 	 	 //mysql_query("DELETE FROM syarat_permit WHERE syarat_kd='".$data['syarat_kd']."'");
  	  }	
header('location: ./deplu.php?module='.$module.'&act=lihat_epo&idt='.$idd.'&negara='.$neg);
 

}

elseif ($module=='epo' AND $act=='update' AND isset($_GET[idt])){
$jns = $_GET[jns];
$idt = $_GET[idt];
$idc = $_GET[idc];
$ID_EPO = $_POST[ID_EPO];
$ID_DIPLOMAT= $_POST[ID_DIPLOMAT];
$tipe_visa= $_POST[tipe_visa];
$NO_SERI_STIKER= $_POST[NO_SERI_STIKER];
//$TGL_AWAL_EPO= date('Y-m-d', strtotime($_POST[TGL_AWAL_EPO]));
$TGL_AKHIR_EPO= date('Ymd', strtotime($_POST[TGL_AKHIR_EPO]));
$TGL_AMBIL_EPO= date('Ymd', strtotime($_POST[TGL_AMBIL_EPO]));

$VERIFIKASI = $_POST[statusverifikasi];
$ket = $_POST[keterangan];
$tbl_baru_epo= $_POST[ada_tbl_baru_epo];
$MOD_BY = $_SESSION[G_namauser];
$TGL_VERIFIKASI= date('Ymd');


$sql = ("select ID_EPO,ID_DIPLOMAT,NO_EPO,TGL_AWAL_EPO,TGL_AKHIR_EPO,TGL_AMBIL_EPO,KET, NO_DAFTAR, NO_SERI_STIKER, TGL_KEBERANGKATAN from v_epo where ID_EPO = $idc ");
$edit = mysql_query($sql);
$data = mysql_fetch_array($edit);
if (empty($data['NO_EPO'])){
	$kd_agenda=$data['KODE_AGENDA'];
	$sekarang = substr(date("Y"),2,2);
	$NO_EPO= generate_urutan($tipe_visa,$idc,$jns);
} else {
	$NO_EPO= $data['NO_EPO'];
}



/* if($ID_CARD)
{
	$kd_w = 'KD_WORKFLOW = 3';
}
else
{
	$kd_w = 'KD_WORKFLOW = 2';
} */
if($VERIFIKASI == 1)
{
	$NO_EPO = '';
	//$TGL_AWAL_EPO = "TGL_AWAL_EPO = null,";
	$TGL_AKHIR_EPO = "TGL_AKHIR_EPO = null";
	$TGL_AMBIL_EPO = "TGL_AMBIL_EPO = null";
	$kd_w = 'KD_WORKFLOW = 1';
	//echo 'gagal'.$TGL_AMBIL_EPO;exit;
}
elseif($VERIFIKASI == 2)
{
	$kd_w = 'KD_WORKFLOW = 3';

	//$TGL_AWAL_EPO = "$TGL_AWAL_EPO";
	$TGL_AKHIR_EPO = "TGL_AKHIR_EPO = ".$TGL_AKHIR_EPO;
	$TGL_AMBIL_EPO = "TGL_AMBIL_EPO = ".$TGL_AMBIL_EPO;
	//echo 'approved'.$TGL_AMBIL_EPO;exit;
}
else
{
	//$TGL_AWAL_EPO = "TGL_AWAL_EPO = null,";
	$TGL_AKHIR_EPO = "TGL_AKHIR_EPO = null";
	$TGL_AMBIL_EPO = "TGL_AMBIL_EPO = null";
	$kd_w = 'KD_WORKFLOW = 2';
	//echo 'else'.$TGL_AMBIL_EPO;exit;
}
	
function sendemail($nodaftar,$nama,$email,$kd_flow,$ket,$tgl_ambil)
	{
		$to      = $email;
		//$noreg   = $nodaftar;
		$bcc	 = 'BCC : no-reply.sito@kemlu.go.id';
		//if 
		//echo 'disini'.$email;exit;
		//print_r('ini '.$tgl_ambil);die;
		$messagelolos = "
		<html>
				<head>
				<title>Konfirmasi Izin Keluar / Exit Permit Only (EPO)</title>
				</head>
				<body>
				<p>Yth. Pemohon </p>
				
				<p>Permohonan atas nama : <strong>$nama</strong> dengan nomor registrasi : <strong>$nodaftar</strong> telah disetujui, mohon untuk menyerahkan paspor asli, <i>copy</i> tiket, dan nota diplomatik ke loket Konsuler pada tanggal <b>$tgl_ambil</b> untuk dapat kami proses, terima kasih.
				</p>
				<br>Terima kasih
				<br>==========================================================<br>
				<p>To The Applicant</p>
				
				<p>Your application with the registration number : <strong>$nodaftar</strong> for <strong>$nama</strong> has been verified, and please bring the original passport to the Directorate of Consular Counter on this date <b>$tglambil</b> to be processed, thank you.
				</p>
				<br>Thank you.
				</body>
				</html>
		";
		
		$messagetolak = "
		<html>
				<head>
				<title>Konfirmasi Izin Keluar / Exit Permit Only (EPO)</title>
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
			$subject_temp = 'Konfirmasi Izin Keluar / Exit Permit Only (EPO) No. Daftar : '.$noreg1.' (DIPLOMAT) Disetujui / Exit Permit Only Confirmation Reg. No : '.$noreg1.' (DIPLOMAT) Approved';
			$subject = $subject_temp;
		}
		elseif($kd_flow == 1)
		{
			$message = $messagetolak;
			$noreg1  = $nodaftar;
			$subject = 'Konfirmasi Izin Keluar / Exit Permit Only (EPO) No. Daftar : '.$noreg1.' (DIPLOMAT) Ditolak / Exit Permit Only Reg. No : '.$noreg1.' (DIPLOMAT) Rejected';
		}	
		
		return mail($to, $subject, $message, $headers);
		
	}
	
	$kd_wf = mysql_query("select KD_WORKFLOW from  v_epo 
			where ID_EPO = $idc");
			//print_r($a17);exit;
	
	$kd_wf = mysql_fetch_array($kd_wf);
	$tgl_verif="";
	if($VERIFIKASI == 1)
			{
				if($kd_wf['KD_WORKFLOW'] != 1 && $kd_wf['KD_WORKFLOW'] != 3)
				{
					$tgl_verif="TGL_VERIFIKASI = ".$TGL_VERIFIKASI.",";
				}
				
			}
	if($VERIFIKASI == 2)
			{
				if($kd_wf['KD_WORKFLOW'] != 3 && $kd_wf['KD_WORKFLOW'] != 1)
				{	
					$tgl_verif="TGL_VERIFIKASI = ".$TGL_VERIFIKASI.",";
				}
				
			} 
	
	
	$sql="update  epo_diplomat set ID_DIPLOMAT = '$ID_DIPLOMAT',
											ID_EPO = '$ID_EPO',
											NO_EPO = '$NO_EPO',
											TIPE_VISA = '$tipe_visa',
											$TGL_AKHIR_EPO,
											$TGL_AMBIL_EPO,
											NO_SERI_STIKER = '$NO_SERI_STIKER',
											KET = '$ket',
											$tgl_verif
											USER_VERIFIKASI = '$MOD_BY',
											$kd_w
											where ID_EPO =  $idc"; //echo $sql; exit;
	if(mysql_query($sql))
		{
			
			$a17 = "
			select c.USER_PERWAKILAN_EMAIL AS EMAIL_EMBASSY,a.ID_EPO,a.ID_DIPLOMAT,
			a.TGL_AWAL_EPO,a.TGL_AKHIR_EPO,a.TGL_AMBIL_EPO,a.KD_WORKFLOW,a.NM_DIPLOMAT,
			a.ST_EPO,a.ST_EPO_K,a.ST_EPO_KAS,a.KET, a.NO_DAFTAR from  v_epo a
			RIGHT JOIN diplomat b on b.ID_DIPLOMAT=a.ID_DIPLOMAT
			left JOIN tbl_user_perwakilan c on c.ID_KNT_PERWAKILAN = b.ID_KNT_PERWAKILAN 
			where a.ID_EPO = $idc and a.KD_WORKFLOW>=1
			";
			//print_r($a17);exit;
			$b17 = mysql_query($a17);
			$c17 = mysql_fetch_array($b17);
			//print_r($c17);exit;
			
			if($VERIFIKASI == 1)
			{
				if($kd_wf['KD_WORKFLOW'] != 1)
				{	
				//print_r('111'.$c17['TGL_AMBIL_EPO'].' '.$c17['EMAIL_EMBASSY']);exit;
				sendemail($c17['NO_DAFTAR'],$c17['NM_DIPLOMAT'],$c17['EMAIL_EMBASSY'],$VERIFIKASI,$c17['KET'],$c17['TGL_AMBIL_EPO']);
				}
			}
			elseif($VERIFIKASI == 2)
			{
				//print_r($c17);exit;
				if($kd_wf['KD_WORKFLOW'] != 3)
				{	
				//print_r('2222'.$c17['TGL_AMBIL_EPO'].' '.$c17['EMAIL_EMBASSY']);exit;
				sendemail($c17['NO_DAFTAR'],$c17['NM_DIPLOMAT'],$c17['EMAIL_EMBASSY'],$VERIFIKASI,$c17['KET'],$c17['TGL_AMBIL_EPO']);
				}
			} 
			
			if (!empty($_POST['syarat'])){										
				foreach ($_POST['syarat'] as $syarat) {
					$insert_syarat = mysql_query("INSERT INTO syarat_permit (syarat_kd, id_permit) VALUES ('".$syarat."','".$idt."')");
				}
			}
			
			
			if($jns != 'manual'){
			echo "<script>
			 alert ('Berhasil verifikasi EPO Diplomat');
			 document.location.href='./deplu.php?module=$module&act=lihat_epo&idt=$ID_DIPLOMAT&negara=$neg';
			 </script>";
            }elseif($jns == 'manual'){
              echo "<script>
			 alert ('Berhasil verifikasi EPO Diplomat');
			 document.location.href='./deplu.php?module=$module&act=lihat_epo&idt=$idt&negara=$neg&jns=$jns';
			 </script>";
            }
		}
	 else
		 {
		 echo "<script>
		 alert ('Gagal verifikasi EPO Diplomat! mohon cek kembali pengisiannya.');
		  document.location.href='./deplu.php?module=$module&act=lihat_epo&idt=$ID_DIPLOMAT&negara=$neg';
		 </script>";
		  echo '<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>';
		 
		 } 
	
	
			
			
	
	//header('location: ./deplu.php?module='.$module.'&act=lihat_id_card&idt='.$ID_DIPLOMAT.'&negara='.$neg);
 
  }elseif($module=='epo' AND $act=='check_no' AND isset($_GET[visa])){
	  $visa = $_GET[visa];
	  $idc = $_GET[idc];
	  $jns = $_GET[jns];
	  $urutan= generate_urutan($visa,$idc,$jns);
	  echo $urutan;
	  
  }

}
?>
