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
		$r=mysql_fetch_array($tampilbeda); ?>
<table cellspacing="0" border="0" width=100%>
	<colgroup span="2" width="60"></colgroup>
	<colgroup width="10"></colgroup>
	<colgroup width="27"></colgroup>
	<colgroup width="80"></colgroup>
	<colgroup width="76"></colgroup>
	<colgroup width="24"></colgroup>
	<colgroup width="14"></colgroup>
	<colgroup width="20"></colgroup>
	<colgroup width="33"></colgroup>
	<colgroup width="90"></colgroup>
	<colgroup width="12"></colgroup>
	<colgroup width="145"></colgroup>
	<tr>
		<td height="20" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000">No Konsep</font></td>
	
		<td align="left" width=20 valign=top><font face="Arial" color="#000000">:</font></td>
		<td align="left" valign=top ><font face="Arial" color="#000000"><?php echo $r['no_konsep']; ?></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000">Tanggal</font></td>
		<td align="left" valign=top><font face="Arial" color="#000000">:</font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><?php echo date('d M Y',strtotime($r['created_date'])); ?></font></td>
	</tr>
	
	<tr>
		<td height="20" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td colspan=12 height="20" align="LEFT" valign=top><b><font face="Arial" color="#000000"><h3><u>DATA PEMOHON</u></h3></font></b></td>
		</tr>
	<tr>
		<td height="20" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" width="200" align="left" valign=top><font face="Arial" color="#000000">Perwakilan RI di</font></td>
		
		<td align="left" width="20" valign=top><font face="Arial" color="#000000">:</font></td>
		<td align="left" colspan=10 valign=top><font face="Arial" color="#000000">
		<?php 
		$sql_pwk="select a.id_perwakilan,a.perwakilan,a.negara,b.nm_regional from tbl_perwakilan a left join tbl_regional b on a.id_regional = b.id_regional";
				$tampil_pwk=mysql_query($sql_pwk);
		
			    while($val=mysql_fetch_array($tampil_pwk))
					{
						if($r['pwk_ri'] == $val['id_perwakilan'])
						{
						echo "$val[perwakilan]";
						}
						
		}?>
		</font></td>
		
	</tr>
	<tr>
		<td height="20" width="120" align="left" valign=top><font face="Arial" color="#000000">Nama / Paspor</font></td>
		
		<td align="left" valign=top><font face="Arial" color="#000000">:</font></td>
		<td align="left" colspan=10 valign=top><font face="Arial" color="#000000"><?php echo $r[nama].' / '.$r[paspor];?></font></td>
		
	</tr>
	<tr>
		<td height="20" width="120" align="left" valign=top><font face="Arial" color="#000000">Anggota Keluarga</font></td>
		
		<td align="left" valign=top><font face="Arial" color="#000000">:</font></td>
		<td align="left" colspan=10 valign=top><font face="Arial" color="#000000">
		<?php 
				$anggota_fam=mysql_query("SELECT * FROM tbl_anggota_fam where no_konsep = '$nokonsep'");
				$i=1;
				while($r3=mysql_fetch_array($anggota_fam)){ 
				  echo $i.'. '.$r3['nama'].'('. $r3['relasi'].') / '. $r3['nopaspor'].'<br>'; 
				$i++;
				}
				
				?>
		</font></td>
		
	</tr>
	<tr>
		<td height="20" width="120" align="left" valign=top><font face="Arial" color="#000000">Jenis Paspor</font></td>
		
		<td align="left" valign=top><font face="Arial" color="#000000">:</font></td>
		<td align="left" colspan=10 valign=top><font face="Arial" color="#000000">
		<?php 
		if($r[jns_paspor] == 1)
					{
						echo 'Dinas';
					}
					else
					{
						echo 'Diplomatik';
					}
		?>
		
		</font></td>
		
	</tr>
	<tr>
		<td height="20" width="120" align="left" valign=top><font face="Arial" color="#000000">Masa Berlaku Paspor</font></td>
		
		<td align="left" valign=top><font face="Arial" color="#000000">:</font></td>
		<td align="left" colspan=10 valign=top><font face="Arial" color="#000000">xxxxxxxxxxxxxxxxxx</font></td>
		
	</tr>
	<tr>
		<td height="20" width="120" align="left" valign=top><font face="Arial" color="#000000">Tujuan</font></td>
		
		<td align="left" valign=top><font face="Arial" color="#000000">:</font></td>
		<td align="left" colspan=10 valign=top><font face="Arial" color="#000000"><?php echo $r[tujuan];?></font></td>
		
	</tr>
	<tr>
		<td height="20" width="120" align="left" valign=top><font face="Arial" color="#000000">Indeks Visa</font></td>
		
		<td align="left" valign=top><font face="Arial" color="#000000">:</font></td>
		<td align="left" colspan=10 valign=top><font face="Arial" color="#000000">
		
		<?php 
		$sql_visa="select * from m_jns_visa where ID_JNS_VISA = 2 OR ID_JNS_VISA = 4 OR ID_JNS_VISA = 6 OR ID_JNS_VISA = 9";
					$tampil_visa=mysql_query($sql_visa);					
					while($val=mysql_fetch_array($tampil_visa))
					 {
						if($r['indeks_visa'] == $val['ID_JNS_VISA'])
						{
						echo "$val[NM_JNS_VISA]";
						}
						
					 }	
		?>
		
		
		
		</font></td>
		
	</tr>
	<tr>
		<td height="20" width="120" align="left" valign=top><font face="Arial" color="#000000">Masa Penugasan di Indonesia</font></td>
		
		<td align="left" valign=top><font face="Arial" color="#000000">:</font></td>
		<td align="left" colspan=10 valign=top><font face="Arial" color="#000000"><?php echo $r[masa_tugas];?> Hari</font></td>
		
	</tr>
	<tr>
		<td height="20" width="120" align="left" valign=top><font face="Arial" color="#000000">Dasar Permintaan Visa</font></td>
		
		<td align="left" valign=top><font face="Arial" color="#000000">:</font></td>
		<td align="left" colspan=10 valign=top><font face="Arial" color="#000000">
		<?php $tampilbeda1=mysql_query("SELECT * FROM tbl_dasarminta_visa where no_konsep = '$nokonsep'");
        $i=1;
		while($r1=mysql_fetch_array($tampilbeda1)){ 
		echo $i.'. '.$r1["dasar_mintavisa"].'<br>';
		$i++;
		}
		?>
		
		</font></td>
		
	</tr>
	<tr>
		<td height="20" width="120" align="left" valign=top><font face="Arial" color="#000000">Dasar Pemberian Visa</font></td>
		
		<td align="left" valign=top><font face="Arial" color="#000000">:</font></td>
		<td align="left" colspan=10 valign=top><font face="Arial" color="#000000">
		<?php $tampilbeda2=mysql_query("SELECT * FROM tbl_dasarberi_visa where no_konsep = '$nokonsep'");
        $i=1;
		while($r2=mysql_fetch_array($tampilbeda2)){ 
		echo $i.'. '.$r2["dasar_berivisa"].'<br>';
		$i++;
		}
		?>
		
		</font></td>
		
	</tr>
	
	
	<tr>
		<td height="20" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
	</tr>
	
	<tr>
		<td height="20" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
	</tr>
	
	<tr>
		<td style="border-top: 1px solid #000000" height="20" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<br>
	<tr>
		<td colspan=4 height="20" align="center" valign=top><font face="Arial" color="#000000">Verifikator</font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"></font></td>
		<td colspan=6 align="center" valign=top><font face="Arial" color="#000000">Legalisasi</font></td>
		</tr>
	<tr>
		<td height="20" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td colspan=4 height="20" align="center" valign=top><u><font face="Arial" color="#000000"><?php if($r[verifikator]): echo '('.$r[verifikator].')'; else: echo '(Nama Lengkap)'; endif; ?></font></u></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td colspan=6 align="center" valign=top><u><font face="Arial" color="#000000"><?php if($r[legalisator]): echo '('.$r[legalisator].')'; else: echo '(Nama Lengkap)'; endif; ?></font></u></td>
		</tr>
	<tr>
		<td colspan=4 height="20" align="center" valign=top><font face="Arial" color="#000000"><?php if($r[jabatan_verifikator]): echo $r[jabatan_verifikator]; else: echo '(Jabatan)'; endif; ?></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td colspan=6 align="center" valign=top><font face="Arial" color="#000000"><?php if($r[jabatan_legalisator]): echo $r[jabatan_legalisator]; else: echo '(Jabatan)'; endif; ?></font></td>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000" height="20" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=top><font face="Arial" color="#000000"><br></font></td>
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