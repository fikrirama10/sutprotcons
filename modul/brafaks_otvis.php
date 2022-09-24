<?php
include "../config/koneksi.php";
include "../config/library.php";
 // Define relative path from this script to mPDF
 $otvis='brafaks_otvis'; //Beri nama file PDF hasil.
define('_MPDF_PATH','../config/mpdf60/');
include(_MPDF_PATH . "mpdf.php");
$mpdf=new mPDF('utf-8', 'Legal'); // Create new mPDF Document
//$param 	= '"en-GB-x","A4","","",10,10,10,10,6,3';
//$mpdf 	= $this->mpdf->load($param);
$nokonsep=$_GET[nokonsep];
//print_r($nokonsep);exit;
//Beginning Buffer to save PHP variables and HTML tags
ob_start();
?>
<!--sekarang Tinggal Codeing seperti biasanya. HTML, CSS, PHP tidak masalah.-->
<!--CONTOH Code START-->
	
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p { font-family:"Calibri"; font-size:14px; }
		.titikdua
		{
		border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000;	
		}
		.titikduadua
		{
		border-top: 1px solid #000000;  border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000;	
		}
		
		.atas
		{
		valign:top;
		}
	</style>
 <?php $tampilbeda=mysql_query("SELECT * FROM tbl_trans_otvis where no_konsep = '$nokonsep'");
         //print_r("SELECT * FROM tbl_trans_otvis where no_konsep = '$nokonsep'");exit;
		$r=mysql_fetch_array($tampilbeda);
		
		
		//$s=mysql_fetch_array($anggota_fam);
		
		
		$sql_pwk="select a.id_perwakilan,a.perwakilan,a.negara,b.nm_regional from tbl_perwakilan a left join tbl_regional b on a.id_regional = b.id_regional";
		$tampil_pwk=mysql_query($sql_pwk);
		 while($val=mysql_fetch_array($tampil_pwk))
					{
						if($r['pwk_ri'] == $val['id_perwakilan'])
						{
						$pwk = $val[perwakilan];
						$pwk1 = explode (' ',$pwk);
						$pwk2 = $pwk1[1];
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
						$indexvisa = $val[KD_JNS_VISA];
						}
						
					 }	
					 
		$sql_tipevisa="select * from tbl_tipe_visa";
					$tampil_tipevisa=mysql_query($sql_tipevisa);					
					while($val=mysql_fetch_array($tampil_tipevisa))
					 {
						if($r['tipe_visa'] == $val['id'])
						{
						$tipevisa = $val[tipe_visa];
						}
						
					 }	
					 
		?>
<html>
				<div style='width:200px;float:right;'>
				<table border=0 cellspacing=0 width="100%">
				<tr>
				
				
				<td align='center' class='titikdua' style='font-size:15px;'>
				NK

				</td>
				
				<td width=20% class='titikdua'>
				B.63.
				</td>
				
				</tr>
				<tr>
				
				
				<td align='center' class='titikdua' style='font-size:15px;'>
				
				Tgl
				</td>
				
				<td width=20% class='titikdua' align='center'>
				<?php echo '    '.date('M Y');?>
				</td>
				
				</tr>
				
				<tr>
				
				<td align='center' style='font-size:15px;'>
				
				
				</td>
				
				<td width=70%  style='padding-left:15px;'>
				KILAT
				</td>
				
				</tr>
				</table>
				</div>
				<br><br><br><br><br><br><br>
				<table border= width=100%>
				<tr>
				<td width=20% align='center'>
				
				</td>
				
				<td align='center' style='font-size:11px;'>
				
				
				Jln. Pejambon No.6 , Jakarta Pusat, 10110 Indonesia Tlp (+62 21) 3848627<br> 
				Fax (+62 21) 3805511 E-mail : puskom@kemlu.go.id

				</td>
				
				<td width=20% align='center'>
				&nbsp;
				</td>
				
				</tr>
				</table>
				
				<hr>
				<table border=0 width=100%>
				<tr>
				<td  align='center' rowspan='2' width='20%' class='titikdua'>
				Plt. Direktur Konsuler<br><br><br><br>Ade Sukendar
				</td>
				
				<td align='center'  class='titikdua'>
				<h2>BERITA BIASA</h2>
				</td>
				<td width='30%'>
				
				</td>
				
				</tr>
				<tr>
				<td  align='center'  width='30%' >
				
				</td>
				
				<td width='30%'>
				
				</td>
				
				</tr>
				</table>
				
				<table border=0>
				<tr><td width=13%>Nomor</td><td width=3% >: </td><td><?php echo $r['no_brafaks']; ?></td></tr>
				<tr><td>Kepada</td><td >: </td><td>Yth. Dubes LBBP RI <?php echo $pwk2; ?></td></tr>
				<tr><td valign='top'>Info</td><td >: </td><td align='justify'>Yth. Menlu, Wamenlu, Dirjen Protkons, Dir. Erbar, Dir Sosbud OINB, Dir Fasdip, Plt. Dir Konsuler</td></tr>
				<tr><td>Dari</td><td >: </td><td>Plt. Direktur Konsuler</td></tr>
				<tr><td>Jumlah</td><td >: </td><td>1 (Satu) Halaman</td></tr>
				<tr><td>Perihal</td><td >: </td><td align='justify'>Otorisasi Pemberian Visa Dinas a.n <?php echo $r['nama']; ?> beserta keluarga, yang akan bertugas pada Kantor UNICEF di Jakarta</td></tr>
				</table>
				<hr>
				<table border=0 width=100%>
				<tr><td align='justify' colspan='2'>Merujuk berita <?php echo $pwk.' No. '.$r['no_brafaks'].' '; ?>perihal tersebut di atas, dengan hormat disampaikan hal-hal sebagai berikut:</td></tr>
				<tr><td width=4% valign='top' >1. </td><td align='justify'>Kementerian Luar Negeri RI c.q. Direktorat Konsuler memberikan otorisasi kepada KBRI <?php echo $pwk2; ?> untuk menerbitkan
				visa sesuai ketentuan yang berlaku bagi:</td></tr>
		
				</table>
				<table border=0 width=100% cellspacing=0>
				
				<tr><td width=4% valign='top'> </td><td width=23% class='titikdua ' valign='top' >Nama / Paspor</td><td align='center' width='3%' valign='top' class='titikdua'>:</td><td class='titikdua'> <?php echo $r['nama']; ?> / <?php echo $r['paspor']; ?>
				<?php 
				$anggota_fam=mysql_query("SELECT * FROM tbl_anggota_fam where no_konsep = '$nokonsep'");
				while($r3=mysql_fetch_array($anggota_fam)){ 
				  echo '<br>'.$r3['nama'].'('. $r3['relasi'].') / '. $r3['nopaspor']; 
				}
				
				?></td></tr>
				<tr><td width=4% valign='top'> </td><td width=23% class='titikdua ' valign='top'>Tujuan Kunjungan</td><td align='center' class='titikdua'>:</td><td class='titikdua'> <?php echo $r['tujuan']; ?></td></tr>
				<tr><td width=4% valign='top'> </td><td width=23% class='titikdua ' valign='top'>Tipe Visa</td><td align='center' class='titikdua'>:</td><td class='titikdua'> <?php echo $tipevisa.' untuk sekali perjalanan(<i>single visa</i>)'; ?></td></tr>
				<tr><td width=4% valign='top'> </td><td width=23% class='titikdua ' valign='top'>Indeks Visa</td><td align='center' class='titikdua'>:</td><td class='titikdua'> <?php echo $indexvisa; ?></td></tr>
				<tr><td width=4% valign='top'> </td><td width=23% align='justify' valign='top' class='titikdua'>Masa tinggal di Indonesia</td><td align='center' class='titikdua'>:</td><td class='titikdua'> <?php echo $r['masa_tugas']; ?> Hari</td></tr>
				<tr><td width=4% valign='top'> </td><td width=23% class='titikdua' valign='top'>Nota Permintaan Visa</td><td align='center' valign='top' class='titikdua'>:</td><td class='titikdua'> 
				<?php $tampilbeda1=mysql_query("SELECT * FROM tbl_dasarminta_visa where no_konsep = '$nokonsep'");
				$i=1;
				while($r1=mysql_fetch_array($tampilbeda1)){ 
				echo $i.'. '.$r1["dasar_mintavisa"].'<br>';
				$i++;
				}
				?>
				</td></tr>
				<tr><td width=4% valign='top'> </td><td width=23% class='titikdua' valign='top'>Dasar Pemberian Visa</td><td align='center' valign='top' class='titikdua'>:</td><td class='titikdua'> 
				<?php $tampilbeda2=mysql_query("SELECT * FROM tbl_dasarberi_visa where no_konsep = '$nokonsep'");
				$i=1;
				while($r2=mysql_fetch_array($tampilbeda2)){ 
				echo $i.'. '.$r2["dasar_berivisa"].'<br>';
				$i++;
				}
				?>
				</td></tr>
				</table>
				<br>
				<table border=0 width=100%>
				<tr><td width=4% valign='top'>2. </td><td align='justify'>
				<b>Perwakilan  RI</b>  agar  <b>mencantumkan  <u>Kode  Jenis dan  Indeks  Visa</u> </b><u> serta </u>  <b><u>Kode  Wilayah</u></b>  tempat 
				penerbitan  Visa  Diplomatik/Dinas,  secara  benar  sesuai  dengan  ketentuan  yang  berlaku  serta 
				<b>memberikan informasi kepada ybs</b>  agar <b><u>mengalihstatuskan Visa Diplomatik/Dinas nya menjadi Izin Tinggal 
				Diplomatik/Dinas </u></b> di Kementerian Luar Negeri RI c.q. Direktorat Konsuler <b><u> dalam jangka waktu kurang dari 
				30 (tiga puluh) hari sejak tanggal ketibaan di Indonesia</u></b>.
				<br><br>Demikian, atas perhatian dan kerjasamanya disampaikan terima kasih.
				</td></tr>
		
				</table>
				<hr>
				
				<table border=0 width=100%>
				<tr>
				<td width='40%' align='center'>
				Petugas Komunikasi<br><br><br><br><hr>
				</td>
				
				<td>
				
				</td>
				<td width='40%' align='center'>
				Pembuat Berita<br><br><br><br><u>Jimi Hardian</u><br>Kasi OI dan TAA
				</td>
				
				</tr>
				</table>

<?php
$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
ob_end_clean();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->showImageErrors = true;
$output = $mpdf->Output($otvis.".pdf" ,'I');
//exit;
?>