<?php

switch($_GET[act]){

  default:

  echo "<h2>Laporan Rekapitulasi Visa </h2> 
    <form method=POST action='./deplu.php?module=laprekapvisa&act=generate' enctype='multipart/form-data'>
          <table width=80%>
          
		  <tr ><th colspan = 2 ><div align=left>Periode</div></th></tr>
		  <tr><td>Dari</td><td><DIV id=\"tgl\"> <script>DateInput('TGL_AWAL', true, 'YYYY-MM-DD')</script></div></td></tr>
		  <tr><td>Sampai Dengan</td><td><DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR', true, 'YYYY-MM-DD')</script></div></td></tr>
		  
		  <tr><th colspan = 2><div align=right><input type=submit value=Generate> </div></th></tr>
		

		  </table></form>";



	break;
    case "generate":

session_start();

//session_register("G_sql_lap");

$template = file("../template/canvasawal.htm");
$template = implode("",$template ); 

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){

	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";
	
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{

		
		$ID_NEGARA = $_POST[ID_NEGARA];   
		$ID_JNS_PERMIT = $_POST[ID_JNS_PERMIT]; 
	
		$TGL_AWAL = $_POST[TGL_AWAL]; 
		$TGL_AKHIR = $_POST[TGL_AKHIR]; 
		
		?>
		<div align=center>
			<h2>LAPORAN REKAPITULASI PENGAJUAN VISA</h2>
			<table width=700 >
				<tr>
					<th><?=$TGL_AWAL?> S/D <?=$TGL_AKHIR?></th>
					<th >DIPLOMAT - <br/>DIPLOMATIK</th>
					<th>DIPLOMAT - <br/>DINAS</th>
					<th>SIBLING -  <br/>DIPLOMATIK </th>
					<th>SIBLING -<br/> DINAS </th>
					<th width=100>TOTAL </th>
					
				</tr>
				<?php
				$DD = 0;
				$DS = 0;
				$SD = 0;
				$SS = 0;
				$sql = "SELECT kode_agenda, deskripsi FROM m_kode_agenda order by kode_agenda";
				$tampil = mysql_query($sql);
				while($r=mysql_fetch_array($tampil)){
				$total = 0;
				?>
				<tr>
					<td><?=$r['deskripsi']?></td>
					<td align=right>
						<?php
						$sql1 = "SELECT count(*) FROM permit_diplomat
								JOIN diplomat ON diplomat.ID_DIPLOMAT = permit_diplomat.ID_DIPLOMAT
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.`ID_KNT_PERWAKILAN` = diplomat.`ID_KNT_PERWAKILAN`
								WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."' 
								AND jns_izin_permit='D' and kode_agenda='".$r['kode_agenda']."'";
					
						$tampil1 = mysql_query($sql1);
						$r1 = mysql_fetch_row($tampil1);
						
						echo $r1[0];
						$total = $total+$r1[0];
						$DD = $DD+$r1[0];
						
						?>
					</td>
					<td  align=right>
						<?php
						$sql1 = "SELECT count(*) FROM permit_diplomat
								JOIN diplomat ON diplomat.ID_DIPLOMAT = permit_diplomat.ID_DIPLOMAT
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.`ID_KNT_PERWAKILAN` = diplomat.`ID_KNT_PERWAKILAN`
								WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."' 
								AND jns_izin_permit='S' and kode_agenda='".$r['kode_agenda']."'";
					
						$tampil1 = mysql_query($sql1);
						$r1 = mysql_fetch_row($tampil1);
						
						echo $r1[0];
						$total = $total+$r1[0];
						$DS = $DS+$r1[0];
						?>
					</td>
					<td  align=right>
						<?php
						$sql1 = "SELECT count(*) FROM permit_sibling
								JOIN sibling ON sibling.ID_SIBLING = permit_sibling.ID_SIBLING
								JOIN diplomat ON diplomat.ID_DIPLOMAT = sibling.ID_DIPLOMAT
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.`ID_KNT_PERWAKILAN` = diplomat.`ID_KNT_PERWAKILAN`
								WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."' 
								AND jns_izin_permit='D' and kode_agenda='".$r['kode_agenda']."'";
					
						$tampil1 = mysql_query($sql1);
						$r1 = mysql_fetch_row($tampil1);
						
						echo $r1[0];
						$total = $total+$r1[0];
						$SD = $SD+$r1[0];
						?>
					</td>
					<td  align=right>
						<?php
						$sql1 = "SELECT count(*) FROM permit_sibling
								JOIN sibling ON sibling.ID_SIBLING = permit_sibling.ID_SIBLING
								JOIN diplomat ON diplomat.ID_DIPLOMAT = sibling.ID_DIPLOMAT
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.`ID_KNT_PERWAKILAN` = diplomat.`ID_KNT_PERWAKILAN`
								WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."' 
								AND jns_izin_permit='S' and kode_agenda='".$r['kode_agenda']."'";
					
						$tampil1 = mysql_query($sql1);
						$r1 = mysql_fetch_row($tampil1);
						
						echo $r1[0];
						$total = $total+$r1[0];
						$SS = $SS+$r1[0];
						?>
					</td>
					<td align=right><?=$total?> </td>
					
				</tr>
				<?php
				}
				?>
				<tr>
					<td align=right>GRAND TOTAL</td>
					<td align=right><?=$DD?></td>
					<td align=right><?=$DS?></td>
					<td align=right><?=$SD?></td>
					<td align=right><?=$SS?></td>
					<td align=right><strong><?=$DD+$DS+$SD+$SS?></strong></td>
				</tr>
			</table>	
			<h2>BREAK DOWN REKAPITULASI PENGAJUAN VISA</h2>
			<table>
				<tr>
					<th><?=$TGL_AWAL?> S/D <?=$TGL_AKHIR?></th>
					<th >DIPLOMAT - <br/>DINAS</th>
					<th>DIPLOMAT - <br/>DIPLOMATIK</th>
					<th>SIBLING -  <br/>DINAS </th>
					<th>SIBLING -<br/> DIPLOMATIK </th>
					<th>KAWASAN</th>
					
				</tr>
				<?php
				$sql = "SELECT ID_JNS_PERWAKILAN, NM_JNS_PERWAKILAN FROM m_jns_perwakilan ORDER BY ket";
				$tampil = mysql_query($sql);
				while($r=mysql_fetch_array($tampil)){
				$ddsub = 0;
				$dssub = 0;
				$sdsub = 0;
				$sssub = 0;
				?>
				<tr>
					<td colspan=100><strong><?=$r['NM_JNS_PERWAKILAN']?></strong></td>
				</tr>
				<?php
				$sql1 = "SELECT ID_KNT_PERWAKILAN, m_kode_agenda.`deskripsi`, m_kode_agenda.`kode_agenda`, NM_KNT_PERWAKILAN FROM m_kantor_perwakilan 
					JOIN m_kode_agenda ON m_kantor_perwakilan.`KODE_AGENDA` = m_kode_agenda.`kode_agenda`
					WHERE ID_JNS_PERWAKILAN = ".$r['ID_JNS_PERWAKILAN']."
					ORDER BY m_kode_agenda.`deskripsi`,  NM_KNT_PERWAKILAN";
				$tampil1 = mysql_query($sql1);
				while($r1=mysql_fetch_array($tampil1)){
				
				$sqldd = "SELECT COUNT(*) FROM permit_diplomat 
						JOIN diplomat ON permit_diplomat.`ID_DIPLOMAT` = diplomat.`ID_DIPLOMAT`
						JOIN m_kantor_perwakilan ON diplomat.`ID_KNT_PERWAKILAN` = m_kantor_perwakilan.`ID_KNT_PERWAKILAN`
						WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'
						AND jns_izin_permit='D' AND m_kantor_perwakilan.`ID_KNT_PERWAKILAN`=".$r1['ID_KNT_PERWAKILAN'];

				$tampildd = mysql_query($sqldd);
				
				$rdd = mysql_fetch_row($tampildd);
				$dd = $rdd[0];
				
				$sqlds = "SELECT COUNT(*) FROM permit_diplomat 
						JOIN diplomat ON permit_diplomat.`ID_DIPLOMAT` = diplomat.`ID_DIPLOMAT`
						JOIN m_kantor_perwakilan ON diplomat.`ID_KNT_PERWAKILAN` = m_kantor_perwakilan.`ID_KNT_PERWAKILAN`
						WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'
						AND jns_izin_permit='S' AND m_kantor_perwakilan.`ID_KNT_PERWAKILAN`=".$r1['ID_KNT_PERWAKILAN'];

				$tampilds = mysql_query($sqlds);
				
				$rds = mysql_fetch_row($tampilds);
				$ds = $rds[0];
				
				$sqlsd = "SELECT COUNT(*) FROM permit_sibling 
						JOIN sibling ON permit_sibling.`ID_SIBLING` = sibling.`ID_SIBLING`
						JOIN diplomat ON sibling.`ID_DIPLOMAT` = diplomat.`ID_DIPLOMAT`
						JOIN m_kantor_perwakilan ON diplomat.`ID_KNT_PERWAKILAN` = m_kantor_perwakilan.`ID_KNT_PERWAKILAN`
						WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'
						AND jns_izin_permit='D' AND m_kantor_perwakilan.`ID_KNT_PERWAKILAN`=".$r1['ID_KNT_PERWAKILAN'];

				$tampilsd = mysql_query($sqlsd);
				
				$rsd = mysql_fetch_row($tampilsd);
				$sd = $rsd[0];
				
				$sqlss = "SELECT COUNT(*) FROM permit_sibling 
						JOIN sibling ON permit_sibling.`ID_SIBLING` = sibling.`ID_SIBLING`
						JOIN diplomat ON sibling.`ID_DIPLOMAT` = diplomat.`ID_DIPLOMAT`
						JOIN m_kantor_perwakilan ON diplomat.`ID_KNT_PERWAKILAN` = m_kantor_perwakilan.`ID_KNT_PERWAKILAN`
						WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'
						AND jns_izin_permit='S' AND m_kantor_perwakilan.`ID_KNT_PERWAKILAN`=".$r1['ID_KNT_PERWAKILAN'];

				$tampilss = mysql_query($sqlss);
				
				$rss = mysql_fetch_row($tampilss);
				$ss = $rss[0];
				
				if ($dd+$ds+$sd+$ss>0)
				{
				?>
				<tr>
					<td><?=$r1['NM_KNT_PERWAKILAN']?></td>
					<td align=right><?=$dd?></td>
					<td align=right><?=$ds?></td>
					<td align=right><?=$sd?></td>
					<td align=right><?=$ss?></td>
					<td>
						<?php
							if ($r['ID_JNS_PERWAKILAN']=='5')
								echo "KEMENTERIAN";
							elseif ($r['ID_JNS_PERWAKILAN']=='3' && $r1['kode_agenda'] =='AP')
								echo "ORGANISASI INTERNASIONAL";
							else		
								echo $r1['deskripsi'];
						
						
						?>
					</td>
				</tr>
				<?php
				}
				$ddsub = $ddsub+$dd;
				$dssub = $dssub+$ds;
				$sdsub = $sdsub+$sd;
				$sssub = $sssub+$ss;
				}
				
				?>
				<tr>
					<td align=right><strong>SUBTOTAL</strong></td>
					<td align=right><strong><?=$ddsub?></strong></td>
					<td align=right><strong><?=$dssub?></strong></td>
					<td align=right><strong><?=$sdsub?></strong></td>
					<td align=right><strong><?=$sssub?></strong></td>
					<td>&nbsp;</td>
				</tr>
				<?php
				$ddtotal = $ddtotal+$ddsub;
				$dstotal = $dstotal+$dssub;
				$sdtotal = $sdtotal+$sdsub;
				$sstotal = $sstotal+$sssub;
				}
				?>
				<tr>
					<td align=right><strong>GRANDTOTAL</strong></td>
					<td align=right><strong><?=$ddtotal?></strong></td>
					<td align=right><strong><?=$dstotal?></strong></td>
					<td align=right><strong><?=$sdtotal?></strong></td>
					<td align=right><strong><?=$sstotal?></strong></td>
					<td>&nbsp;</td>
				</tr>
				<?php
				?>	
			</table>	
		</div>
		<?php
		
//	
//		$jmldata =mysql_num_rows(mysql_query($QWERYNYA));
//
//	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
//
//   $ilink = "?module=lapjmlpermit&act=generate"; 
//    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
//
//    echo "<div id=paging>$linkHalaman</div><br>";
    break;



}
		
}
?>
