<?php 
//print_r($_POST); exit;
include "../../config/koneksi.php";
include('../../mpdf/mpdf.php');
$mpdf=new mPDF();
session_start();
//session_register("G_sql_lap"); 
$tanggal_awal = date("d M Y", strtotime($_POST['TGL_AWAL']));
$tanggal_akhir = date("d M Y", strtotime($_POST['TGL_AKHIR'])); 
if ($_POST['Jenis_ID_Card']=='1'){
$str_jenis ="Diplomat";
$sql ="select
				    b.ID_DIPLOMAT,
				    b.NM_DIPLOMAT,
				    b.NO_PASPOR,
				    c.NM_KNT_PERWAKILAN,
				    a.ID_CARD,
				    a.TGL_AWAL_CARD,
				    a.TGL_AKHIR_CARD,
				    a.STATUS_PENGEMBALIAN,
				    a.TGL_PENGEMBALIAN
				from
				    cetak_kartu_diplomat as a,
				    diplomat as b,
				    m_kantor_perwakilan as c
				where
				    a.ID_DIPLOMAT=b.ID_DIPLOMAT and
				    b.ID_KNT_PERWAKILAN=c.ID_KNT_PERWAKILAN and
					a.TGL_PENGEMBALIAN BETWEEN '".$_POST['TGL_AWAL']."' and '".$_POST['TGL_AKHIR']."' and
	 				a.STATUS_PENGEMBALIAN = 'SUDAH'
	 			order by
	 				b.NM_DIPLOMAT asc
				   "; 
$query = mysql_query($sql);
} 

if ($_POST['Jenis_ID_Card']=='2'){
	$str_jenis ="Family";
	$sql ="
				SELECT
					b.NM_SIBLING,
					b.NO_PASPOR,
					C.NM_JNS_RELASI,
					a.ID_CARD,
					a.TGL_AWAL_CARD,
					a.TGL_AKHIR_CARD,
					a.STATUS_PENGEMBALIAN,
					a.TGL_PENGEMBALIAN 
				FROM 
					cetak_kartu_sibling AS a,
					sibling             AS b,
					m_jns_relasi  AS C 
				WHERE
					a.ID_SIBLING=b.ID_SIBLING AND
					b.ID_JNS_RELASI=C.ID_JNS_RELASI  AND
					a.TGL_PENGEMBALIAN BETWEEN '".$_POST['TGL_AWAL']."' and '".$_POST['TGL_AKHIR']."' AND
					a.STATUS_PENGEMBALIAN = 'SUDAH' 
				ORDER BY
					b.NM_SIBLING ASC
				   ";
	$query = mysql_query($sql);
} 

$html ="<html>
<head>
<style>
body {
	font: normal 5px auto \"Trebuchet MS\", Verdana, Arial, Helvetica, sans-serif;
	color: #4f6b72;
	 
}

a {
	color: #c75f3e;
}
#tanda-tangan{
	width: 95%;
	padding: 0;
	margin: auto;
	font: 10px \"Trebuchet MS\", Verdana, Arial, Helvetica, sans-serif;
		
}
#tanda-tangan td {
	border:0px;
	font: 10px \"Trebuchet MS\", Verdana, Arial, Helvetica, sans-serif;		
}
#tanda-tangan .td1{
	border:0px;
	text-align:right;
	padding-right:135px;
	font: 10px \"Trebuchet MS\", Verdana, Arial, Helvetica, sans-serif;
		
}
#tanda-tangan .td2{
	border:0px;
		text-align:right;
		padding-right:90px;
	}
#tanda-tangan .td3{
	border:0px;
		text-align:right;
		padding-right:70px;
	}
		
#mytable {
	width: 95%;
	padding: 0;
	margin: auto;
	
	
}

caption {
	padding: 0 0 5px 0;
	width: 700px;	 
	font: italic 11px \"Trebuchet MS\", Verdana, Arial, Helvetica, sans-serif;
	text-align: right;
}

th {
	font: bold 6px \"Trebuchet MS\", Verdana, Arial, Helvetica, sans-serif;
	color: #4f6b72;
	border-right: 1px solid #C1DAD7;
	border-left: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	border-top: 1px solid #C1DAD7;
	letter-spacing: 2px;
	text-transform: uppercase;
	text-align: left;
	padding: 6px 6px 6px 12px;
	background: #CAE8EA url(../../images/bg_header.jpg) no-repeat;
}

th.nobg {
	border-top: 0;
	border-left: 0;
	border-right: 1px solid #C1DAD7;
	background: none;
}

td {
	border-right: 1px solid #C1DAD7;
	border-left: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	background: #fff;
	padding: 6px 6px 6px 12px;
	color: #4f6b72;
	font-size: 7px;
}


td.alt {
	background: #F5FAFA;
	color: #797268;
}

th.spec {
	border-left: 1px solid #C1DAD7;
	border-top: 0;
	background: #fff url(images/bullet1.gif) no-repeat;
	font: bold 10px \"Trebuchet MS\", Verdana, Arial, Helvetica, sans-serif;
}

th.specalt {
	border-left: 1px solid #C1DAD7;
	border-top: 0;
	background: #f5fafa url(images/bullet2.gif) no-repeat;
	font: bold 10px \"Trebuchet MS\", Verdana, Arial, Helvetica, sans-serif;
	color: #797268;
}
</style>
<title>Laporan Pemulangan Kartu</title></head>
<body>";
$html.= '<!--mpdf
<htmlpageheader name="myheader">
<table width="100%" ><tr>
<td  width="50%" style="border:0px; color:#797268;"><span style="font-weight: bold; font-size: 12pt;">Direktorat Fasilitas Diplomatik</span>
<br /><span style="font-weight: bold; font-size: 10pt;">Kementerian Luar Negeri</span>
<br /><span style="font-size: 8pt;">Jl. Pejambon No.6. Jakarta Pusat, 10110<br />Gedung Konsuler Lt.4</span><br />
<span style="font-size: 15pt;">&#9742;</span> &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 8pt;">(+62 21) 3441508 ex 3415</span></td>
<td width="50%" style="border:0px; font-size: 6pt;  text-align: right;">Tanggal Cetak<br />
<span style="font-size: 7pt;">'.date("d M Y", strtotime(date("d-m-Y"))).'</span></td>
</tr></table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->';
if ($_POST['Jenis_ID_Card']=='1'){
$html .= " <br/><br/><br/><h4 align='center'>Laporan Status Pengembalian ID Card $str_jenis<br>
		Periode $tanggal_awal s/d $tanggal_akhir</h4>
	 			<table id=\"mytable\" cellspacing='0' cellpadding='0' >
	 				<tr>
	 					<th>No</th>
 				 		<th>Nama</th>
 				 		<th>No Paspor</th>
 				 		<th>Berkerja</th>
 				 		<th>ID CARD</th>
 				 		<th>TGL ID</th>
 			 			<th>Status Kembali</th>
 			 			<th>Tgl Kembali</th>
 					</tr>";
$no=0;

if (mysql_num_rows($query)>0){
	while ($data=mysql_fetch_array($query)){ $no++;
	if ($data['STATUS_PENGEMBALIAN']=='SUDAH') {
		$status="SUDAH";
	} else{
		$status="BELUM";
	}
	$html.= "<tr>
		 					<td>".$no."</td> 
		 					<td>".$data['NM_DIPLOMAT']."</td>
		 					<td>".$data['NO_PASPOR']."</td>
		 					<td>".$data['NM_KNT_PERWAKILAN']."</td>
		 					<td>".$data['ID_CARD']."</td>
		 					<td>".date("d M Y", strtotime($data['TGL_AWAL_CARD']))." - ".date("d M Y", strtotime($data['TGL_AKHIR_CARD']))."</td>
		 					<td>".$status."</td>
		 					<td>".date("d M Y", strtotime($data['TGL_PENGEMBALIAN']))."</td>
		 			</tr>";
	}
}else{
	$html.= "<tr>
				<td colspan='8' align='center'>Tidak Ada Data!</td>
 			</tr>";	
}
$html .= "</table>";
$html .='<table id="tanda-tangan">
<tr>
	<td class="td1">Jakarta, </td>
</tr>
<tr>
	<td class="td2">Pembuat Laporan</td>
</tr>
<tr>
	<td></td>
</tr>
		<tr>
	<td></td>
</tr>
		<tr>
	<td class="td3">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;)</td>
</tr>
		</table> </body></html>';
} 
if ($_POST['Jenis_ID_Card']=='2'){
			$html .= " <br/><br/><br/><h4 align='center'>Laporan Status Pengembalian ID Card $str_jenis<br>
			Periode $tanggal_awal s/d $tanggal_akhir</h4>
			<table id=\"mytable\" cellspacing='0' cellpadding='0' >
			<tr>
			<th>No</th>
			<th>Nama</th>
			<th>No Paspor</th>
			<th>Relasi</th>
			<th>ID CARD</th>
			<th>TGL ID</th>
			<th>Status Kembali</th>
			<th>Tgl Kembali</th>
			</tr>";
			$no=0;
			
			if (mysql_num_rows($query)>0){
			while ($data=mysql_fetch_array($query)){ $no++;
			if ($data['STATUS_PENGEMBALIAN']=='SUDAH') {
			$status="SUDAH";
			} else{
			$status="BELUM";
			}
			$html.= "<tr>
					<td>".$no."</td>
					<td>".$data['NM_SIBLING']."</td>
			<td>".$data['NO_PASPOR']."</td>
				 					<td>".$data['NM_JNS_RELASI']."</td>
				 					<td>".$data['ID_CARD']."</td>
				 					<td>".date("d M Y", strtotime($data['TGL_AWAL_CARD']))." - ".date("d M Y", strtotime($data['TGL_AKHIR_CARD']))."</td>
					 					<td>".$status."</td>
					 					<td>".date("d M Y", strtotime($data['TGL_PENGEMBALIAN']))."</td>
					 							</tr>";
			}
		}else{
					 							$html.= "<tr>
					 							<td colspan='8' align='center'>Tidak Ada Data!</td>
					 							</tr>";
		}
		$html .= "</table>";
		$html .='<table id="tanda-tangan">
		<tr>
			<td class="td1">Jakarta, </td>
			</tr>
		<tr>
			<td class="td2">Pembuat Laporan</td>
		</tr>
		<tr>
			<td></td>
		</tr>
				<tr>
			<td></td>
		</tr>
				<tr>
			<td class="td3">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;)</td>
		</tr>
				</table> </body></html>';
		}
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

//echo $html;