<?php
include "../config/koneksi.php";
include "../config/library.php";
 // Define relative path from this script to mPDF
 $otvis='Otvis_report'; //Beri nama file PDF hasil.
define('_MPDF_PATH','../config/mpdf60/');
include(_MPDF_PATH . "mpdf.php");
$mpdf=new mPDF('utf-8', 'A4'); // Create new mPDF Document
$nokonsep=$_GET[nokonsep];
//print_r($nokonsep);exit;
//Beginning Buffer to save PHP variables and HTML tags
ob_start();
?>
<!--sekarang Tinggal Codeing seperti biasanya. HTML, CSS, PHP tidak masalah.-->
<!--CONTOH Code START-->
	
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p { font-family:"Calibri"; font-size:13.5px; }
	</style>
 <?php $tampilbeda=mysql_query("SELECT * FROM tbl_trans_otvis where no_konsep = '$nokonsep'");
         //print_r("SELECT * FROM tbl_trans_otvis where no_konsep = '$nokonsep'");exit;
		$r=mysql_fetch_array($tampilbeda);
		
		$sql_pwk="select a.id_perwakilan,a.perwakilan,a.negara,b.nm_regional from tbl_perwakilan a left join tbl_regional b on a.id_regional = b.id_regional";
		$tampil_pwk=mysql_query($sql_pwk);
		 while($val=mysql_fetch_array($tampil_pwk))
					{
						if($r['pwk_ri'] == $val['id_perwakilan'])
						{
						$pwk = $val[perwakilan];
						}
						
					}
		
		$sql_visa="select * from m_jns_visa where ID_JNS_VISA = 2 OR ID_JNS_VISA = 4 OR ID_JNS_VISA = 6 OR ID_JNS_VISA = 9";
		$tampil_visa=mysql_query($sql_visa);
		
		
		$sql_paspor="select * from tbl_jns_paspor";
		$tampil_paspor=mysql_query($sql_paspor);
		while($val=mysql_fetch_array($tampil_paspor))
					 {
						if($r['jns_paspor'] == $val['id'])
						{
						$jns_paspor = $val[jns_paspor];
						}
						
					 }	
		
		$sql_visa="select * from m_jns_visa where ID_JNS_VISA = 2 OR ID_JNS_VISA = 4 OR ID_JNS_VISA = 6 OR ID_JNS_VISA = 9";
					$tampil_visa=mysql_query($sql_visa);					
					while($val=mysql_fetch_array($tampil_visa))
					 {
						if($r['indeks_visa'] == $val['ID_JNS_VISA'])
						{
						$indexvisa = $val[NM_JNS_VISA];
						}
						
					 }	
					 
		?>
<html>
				
				<table border= width=100%>
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
				<td  align='center' width='15%' style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000">
				<?php if($r[status_permohonan] == 1)
					{
						echo 'Setuju';
					}
					elseif($r[status_permohonan] == 2)
					{
						echo 'Tolak';
					}
					else
					{ 
						echo 'Menunggu Persetujuan';
					}
				?>
				</td>
				
				<td>
				&nbsp;
				</td>
				<td width='45%'>
				NO. KONSEP   : <?php echo $r[no_konsep]; ?><br>
				TANGGAL      : <?php echo date('d M Y', strtotime($r[created_date]));?>
				</td>
				
				</tr>
				</table>
				<br>
				<table border=0 width=100%>
				<tr><td valign='top' width=25%>Perwakilan RI di</td><td width=3%>: </td><td><?php echo $pwk; ?></td></tr>
				<tr><td valign='top'>Nama / Paspor</td><td>: </td><td><?php echo $r[nama]; ?> / <?php echo $r[paspor]; ?>
				<?php 
				$anggota_fam=mysql_query("SELECT * FROM tbl_anggota_fam where no_konsep = '$nokonsep'");
				while($r3=mysql_fetch_array($anggota_fam)){ 
				  echo '<br>'.$r3['nama'].'('. $r3['relasi'].') / '. $r3['nopaspor']; 
				}
				
				?>
				</td></tr>
				<tr><td valign='top'>Jenis Paspor</td><td>: </td><td><?php echo $jns_paspor; ?></td></tr>
				<tr><td valign='top'>Tujuan</td><td>: </td><td><?php echo $r[tujuan]; ?></td></tr>
				<tr><td valign='top'>Indeks Visa</td><td>: </td><td><?php echo $indexvisa; ?></td></tr>
				<tr><td valign='top'>Masa Penugasan di Indonesia</td><td>: </td><td><?php echo $r[masa_tugas].' '; ?> Hari</td></tr>
				<tr><td valign='top'>Dasar Permintaan Visa</td><td>: </td><td>
				<?php $tampilbeda1=mysql_query("SELECT * FROM tbl_dasarminta_visa where no_konsep = '$nokonsep'");
				$i=1;
				while($r1=mysql_fetch_array($tampilbeda1)){ 
				echo $i.'. '.$r1["dasar_mintavisa"].'<br>';
				$i++;
				}
				?>
				</td></tr>
				<tr><td valign='top'>Dasar Pemberian Visa</td><td>: </td><td>
				<?php $tampilbeda2=mysql_query("SELECT * FROM tbl_dasarberi_visa where no_konsep = '$nokonsep'");
				$i=1;
				while($r2=mysql_fetch_array($tampilbeda2)){ 
				echo $i.'. '.$r2["dasar_berivisa"].'<br>';
				$i++;
				}
				?>
				</td></tr>
				<tr><td valign='top'>Catatan</td><td>: </td><td><?php if($r[catatan]): echo $r[catatan]; else: echo '-'; endif; ?></td></tr>
				<tr><td colspan=2>&nbsp;</td><td>&nbsp;</td></tr>
				<tr><td colspan=3 align=justify>
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
	

<?php
$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
ob_end_clean();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->showImageErrors = true;
$output = $mpdf->Output($otvis.".pdf" ,'I');
//exit;
?>