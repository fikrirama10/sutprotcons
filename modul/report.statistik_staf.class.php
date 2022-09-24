<?php
//include_once("../config/dataAccess.class.php");
include "../config/koneksi.php";

include_once("../config/eng.php");
include_once("../config/tcpdf.php");

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// Full background image
		//$auto_page_break = $this->AutoPageBreak;
		//$this->SetAutoPageBreak(TRUE, 0);		
		//$this->SetAutoPageBreak($auto_page_break);
	}
        public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-5.6);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');          
	}
}

class stk_staf
{	
	var $rdata;
	var $pdf;
	var $number;

public function stk_staf($negara,$perwakilan, $tglaju1, $tglaju2, $nmdiplomat, $setuju, $tolak){
        if (isset($_GET['tgl_cr_aju1']) && isset($_GET['tgl_cr_aju2']) && !empty($_GET['tgl_cr_aju1']) && !empty($_GET['tgl_cr_aju2'])){
            $w1="and (tgl_nota_pengajuan between '$_GET[tgl_cr_aju1]' and '$_GET[tgl_cr_aju2]') ";
            $tgl_pengajuan_rpt="Tanggal Pengajuan Periode <u>$_GET[tgl_cr_aju1]</u> s.d <u>$_GET[tgl_cr_aju2]</u>";
        }
         if (isset($_GET['negara'])&& !empty($_GET['negara'])){
            $w2="and NEGARA like '%$_GET[negara]%' ";
            $negara_rpt="|| Negara <u>$_GET[negara]</u>";
        }
        if (isset($_GET['perwakilan'])&& !empty($_GET['perwakilan'])){
            $w3="and NM_KNT_PERWAKILAN like '%$_GET[perwakilan]%'";
            $knt_perwakilan="|| Kantor Perwakilan <u>$_GET[perwakilan]</u>";
        }
     
        if (isset($_GET['nm_diplomat'])&& !empty($_GET['nm_diplomat'])){
            $w4="and NM_DIPLOMAT like '%$_GET[nm_diplomat]%'";
            $nm_diplomat_rpt ="|| Nama Diplomat <u>$_GET[nm_diplomat]</u>";
        }
        if (isset($_GET['setuju'])&& !empty($_GET['setuju']) && isset($_GET['tolak'])&& !empty($_GET['tolak']) && $_GET['setuju']!='undefined' && $_GET['tolak']!='undefined'){
            $w5="";
            $setuju_tolak ="|| Status Pengajuan <u>$_GET[setuju]</u> & <u>$_GET[tolak]</u>";
        }elseif ($_GET['setuju']=='undefined' && $_GET['tolak']=='undefined'){
            $w5="";
            $setuju_tolak ="";
        }elseif (isset($_GET['setuju']) && !empty($_GET['setuju']) && empty($_GET['tolak'])){
            $w5="and status_pengajuan = 'Setuju'";
            $setuju_tolak ="|| Status Pengajuan <u>$_GET[setuju]</u>";
        }elseif (empty($_GET['setuju']) && !empty($_GET['tolak']) && isset($_GET['tolak'])){
            $w5="and status_pengajuan = 'Tolak'";
            $setuju_tolak ="|| Status Pengajuan <u>$_GET[tolak]</u>";
        }
	
	/*$data = mysql_query("SELECT DISTINCT NO_PASPOR,NM_DIPLOMAT, NM_KNT_PERWAKILAN, NEGARA, CONCAT_WS('','Spirit : ', kuota_thn_spirit, ', ', 'Anggur : ', kuota_thn_anggur, ', ', 'Rokok : ',kuota_thn_rokok) as kuota_thn FROM v_report_miras_staf where status_pengajuan is not NULL $w1 $w2 $w3 $w4 $w5 order by NM_DIPLOMAT, NM_KNT_PERWAKILAN, NEGARA, tgl_nota_pengajuan DESC ");*/
$filename ="excelreport.xls";        
        	$sql="SELECT NM_DIPLOMAT,NM_KNT_PERWAKILAN, NEGARA, status_pengajuan, sum(jumlah_pengajuan_spirit) as spirit, sum(jumlah_pengajuan_anggur) as anggur, sum(jumlah_pengajuan_rokok) as rokok,sum(jumlah_pengajuan_spirit + jumlah_pengajuan_anggur) as jml_spr_angr,
SUM(jumlah_pengajuan_spirit + jumlah_pengajuan_anggur + jumlah_pengajuan_rokok) as total   
FROM v_report_miras_staf where status_pengajuan is not NULL $w1 $w2 $w3 $w4 $w5
GROUP BY NM_DIPLOMAT,NM_KNT_PERWAKILAN, NEGARA, status_pengajuan
order by total DESC";  
$tampil=mysql_query($sql);
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
$txt=' 
   			<table width="100%" border="1">
			  <tr>
				<td colspan="10" align="center">
					<u><strong>STATISTIK PENGAJUAN BEBAS BEA BAGI STAF PERWAKILAN ASING</strong></u><br />
					DIREKTORAT FASILITAS DIPLOMATIK<br/>
                                        DIREKTORAT JENDERAL PROTOKOL DAN KONSULER<br/>
                                        KEMETERIAN LUAR NEGERI REPUBLIK INDONESIA<br/><br/>
                                        
			</td>
                        
			  </tr>
                          <tr>
                          <td colspan="10">
                          <i>Data berdasarkan hasil pencarian : '.$tgl_pengajuan_rpt.''.$negara_rpt.''.$knt_perwakilan.''.$nm_diplomat_rpt.''.$setuju_tolak.'</i></td></tr>
			 
			  
          <tr><th width=1%>NO</th><th width=21%>Nama</th><th width=21%>KANTOR</th><th width=21%>NEGARA</th><th width=5%>STATUS</th><th width=5%>SPIRIT(1)</th><th width=5%>ANGGUR(2)</th><th width=5%>ROKOK(3)</th><th width=5%>1+2</th><th width=10%>JML (1+2+3)</th></tr>
			  ';
$no=1; 
While($r=mysql_fetch_array($tampil)){
                             
                        $txt.='<tr><td valign="top">'.$no++.'</td>'
               .'<td valign="top">'.$r[NM_DIPLOMAT].'</td>'
                .'<td valign="top">'.$r[NM_KNT_PERWAKILAN].'</td>'
                .'<td valign="top">'.$r[NEGARA].'</td>'
				.'<td valign="top">'.$r[status_pengajuan].'</td>'		
				.'<td valign="top">'.$r[spirit].'</td>'
                                .'<td valign="top">'.$r[anggur].'</td>'
                                .'<td valign="top">'.$r[rokok].'</td>'
                                .'<td valign="top">'.$r[jml_spr_angr].'</td>'
                                .'<td valign="top">'.$r[total].'</td>'
                                . '</tr>';
        }
                        $txt .='</table>';
echo $txt;

	}      
}
?>