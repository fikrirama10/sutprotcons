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

class rpt_staf
{	
	var $rdata;
	var $pdf;
	var $number;

public function rpt_staf($negara,$perwakilan, $tglaju1, $tglaju2, $nmdiplomat, $setuju, $tolak){
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
        
        	$data = mysql_query("SELECT DISTINCT NO_PASPOR,NM_DIPLOMAT, NM_KNT_PERWAKILAN, NEGARA, PEKERJAAN FROM v_report_miras_staf where status_pengajuan is not NULL $w1 $w2 $w3 $w4 $w5 order by NM_DIPLOMAT ASC ");
        
        
       
       
	//$this->rdata  = mysql_fetch_array($data);

		$txt=' 
   			<table width="100%"  border="0" >
			  <tr>
				<td colspan="3" align="center" width="790">
					<u><strong>LAPORAN PENGAJUAN BEBAS BEA BAGI STAF PERWAKILAN ASING</strong></u><br />
					DIREKTORAT FASILITAS DIPLOMATIK<br/>
                                        DIREKTORAT JENDERAL PROTOKOL DAN KONSULER<br/>
                                        KEMETERIAN LUAR NEGERI REPUBLIK INDONESIA<br/>
                                        
			</td>
                        
			  </tr>
                          <i>Data berdasarkan hasil pencarian : '.$tgl_pengajuan_rpt.''.$negara_rpt.''.$knt_perwakilan.''.$nm_diplomat_rpt.''.$setuju_tolak.'</i>
			  <hr/>
			  <tr>		
				<td width=165><b>Nama</b></td><td width=155><b>Jabatan</b></td><td width=130><b>No. Paspor</b></td><td width=190><b>Perwakilan</b></td><td width=148><b>Negara</b></td>
			  </tr>
                      <hr/>
			  <tr>';
                While($r=mysql_fetch_array($data)){
                              
                        $txt .='<td width=165><u/>'.$r[NM_DIPLOMAT].'</td>'
                        . '<td width=155><u/>'.$r[PEKERJAAN].'</td>'
                        . '<td width=130><u/>'.$r[NO_PASPOR].'</td>'
                        . '<td width=190><u/>'.$r[NM_KNT_PERWAKILAN].'</td>'
                        . '<td width=148><u/>'.$r[NEGARA].'</td>
                        
                          </tr>
                          
                          <tr>		
				<td width=20><u><b>No.</b></u></td><td width=145><u><b>Tgl. Nota Pengajuan</b></u></td><td width=155><u><b>No. Nota Pengajuan</b></u></td><td width=130><u><b>No. Nota Jawaban</b></u></td><td width=50><u><b>Spirit</b></u></td><td width=50><u><b>Anggur</b></u></td><td width=50><u><b>Rokok</b></u></td><td width=40><u><b>Status</b></u></td><td width=148><u><b>Keterangan</b></u></td>
                          </tr><tr>  ';
                        $no=1;
 $data_detil = mysql_query("SELECT NO_PASPOR,tgl_nota_pengajuan,no_nota_pengajuan, no_nota_jawaban, jumlah_pengajuan_spirit, jumlah_pengajuan_anggur, jumlah_pengajuan_rokok, status_pengajuan,keterangan,kuota_thn_spirit,kuota_thn_anggur, kuota_thn_rokok FROM v_report_miras_staf where status_pengajuan is not NULL $w1 $w2 $w3 $w4 $w5 order by tgl_nota_pengajuan DESC ");
                        $sprt=0;
                        $angr=0;
                        $rkk=0;
                        $sprt_tlk=0;
                        $angr_tlk=0;
                        $rkk_tlk=0;
                        While($p=mysql_fetch_array($data_detil)){
                            
                            if($r[NO_PASPOR]==$p[NO_PASPOR]){
                                
                         $txt .='<td width=20>'.$no++.'</td>'
                        .'<td width=145>'.$p[tgl_nota_pengajuan].'</td>'
                        . '<td width=155>'.$p[no_nota_pengajuan].'</td>'
                        . '<td width=130>'.$p[no_nota_jawaban].'</td>'
                        . '<td width=50>'.$p[jumlah_pengajuan_spirit].'</td>'
                        . '<td width=50>'.$p[jumlah_pengajuan_anggur].'</td>'
                        . '<td width=50>'.$p[jumlah_pengajuan_rokok].'</td>'
                        . '<td width=40>'.$p[status_pengajuan].'</td>'
                        . '<td width=148>'.$p[keterangan].'</td>
                          </tr>
                          <tr>';
                         if ($p[status_pengajuan] == 'Setuju'){
                         $sprt+=$p[jumlah_pengajuan_spirit];
                         $angr+=$p[jumlah_pengajuan_anggur];
                         $rkk+=$p[jumlah_pengajuan_rokok];
                         }elseif ($p[status_pengajuan] == 'Tolak'){
                         $sprt_tlk+=$p[jumlah_pengajuan_spirit];
                         $angr_tlk+=$p[jumlah_pengajuan_anggur];
                         $rkk_tlk+=$p[jumlah_pengajuan_rokok];
                         }
                         //$sp=$p[kuota_thn_spirit];
                         //$sag=$p[kuota_thn_anggur];
                         //$srk=$p[kuota_thn_rokok];
                            } 
                          }
                          //$sisa_spirit=$sp-$sprt;
                          //$sisa_anggur=$sag-$angr;
                          //$sisa_rkk=$srk-$rkk;
                          $txt.='<tr><td align="right" width=450><b/>Jumlah disetuji : &nbsp;</td><td width=50><b/>'.$sprt.'</td><td width=50><b/>'.$angr.'</td><td width=50><b/>'.$rkk.'</td></tr><tr><td align="right" width=450><b/>Jumlah ditolak : &nbsp;</td><td width=50><b/>'.$sprt_tlk.'</td><td width=50><b/>'.$angr_tlk.'</td><td width=50><b/>'.$rkk_tlk.'</td><!--<td width=250><b/>Sisa Kuota Spirit :'.$sisa_spirit.', Anggur : '.$sisa_anggur.', Rokok : '.$srk.'</td>--></tr>'
                                  . '<hr/>';
                }
                $txt .='</table>';
	              
                $pdf = new MYPDF('L', 'cm',  'A4', true, 'UTF-8', false);
		
		$pdf->SetTitle('Laporan Bea Masuk Staf');
	
		$pdf->SetMargins('1','1','1', TRUE);               
		
		$pdf->setPrintFooter(true);
                
		$pdf->SetAutoPageBreak(TRUE,1);
		
		$pdf->SetFont('Times', '', 11);
		
		$pdf->AddPage();
		$pdf->Ln();

		$pdf->writeHTML($txt, true, 0, true, 0);		
                ob_clean();
		$pdf->Output('bea_staf.pdf', 'I');

	}      
}
?>