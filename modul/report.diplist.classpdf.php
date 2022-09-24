<?php
// include_once("../config/dataAccess.class.php");
include "../config/koneksi.php";

include_once ("../config/eng.php");
include_once ("../config/tcpdf.php");
require_once(dirname(__FILE__)."/phpqrcode/qrlib.php");

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	// Page header
	public function Header() {
		$auto_page_break = $this->AutoPageBreak;
		//$this->SetAutoPageBreak ( true, 20 );
		$this->SetAutoPageBreak ( $auto_page_break );
	}
	public function Footer() {
		//$auto_page_break = $this->AutoPageBreak;
		//$this->SetAutoPageBreak ( true, 20 );
		//$this->SetAutoPageBreak ( $auto_page_break );
		$this->SetAutoPageBreak ( True, 2 );
        // Position at 15 mm from bottom
        $this->SetY(-6);
        // Set font
        $this->SetFont('helvetica', 'I', 6);
        // Page number
        $this->Cell(0, 10, ''.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
class diplist {
	var $error;
	var $data;
	var $rdata;
	var $rdata2;
	var $rdata3;
	var $data4;
	var $data5;
	var $type;
	var $iddiplomat;
	var $warna;
	var $query;
	var $pdf;
	var $profileid;
	var $passporttype;
	var $number;
	var $name;
	var $occupation;
	var $cardnumber;
	var $validcard;
	var $idimg;
	var $representative;
	var $rdata4;
	var $root_kantor;
	var $id_dip;
	var $id_permit;
	public function diplist() {
		
					
		$this->formattingprint ($_POST ['id_kelompok']);
	}
	public function formattingprint($klp) {
		$nama_bln = array (
				1 => "Januari",
				"Februari",
				"Maret",
				"April",
				"Mei",
				"Juni",
				"Juli",
				"Agustus",
				"September",
				"Oktober",
				"November",
				"Desember" 
		);
	
		$kelompok = $_POST ['id_kelompok'];
		if($kelompok==1){
		$sql = "SELECT * from v_dipsib_list where (AKHIR_PERMIT_SIB IS NOT NULL AND ID_DIPSIB IS NOT NULL) OR (AKHIR_PERMIT_SIB IS NULL AND ID_DIPSIB IS NULL) AND NO_IZIN_PERMIT !='' and NO_IZIN_PERMIT is not null 
		ORDER BY NEGARA, ID_NEGARA, ID_KNT_PERWAKILAN, ID_RANK,NM_DIPLOMAT  ASC";
		}
		$data = mysql_query ( $sql );
		//$this->rdata = mysql_fetch_array ( $data );
	$negara='';
	$txt = '<table cellpadding="0" cellspacing="0" width="100%" border="0">';
				while($rr=mysql_fetch_array($data)){				
				if($rr[NEGARA] != $negara){
				$txt .='<tr>
						<td colspan="3" align="center"><b/>
						' . strtoupper($rr[NEGARA]) . '
						</td>
						</tr>
						<tr>
						<td colspan="3" align="center"><b/>
						' . strtoupper($rr[KANTOR]) . '
						</td>
						</tr>						
					';	
					if($rr[ID_JNS_PERWAKILAN] == 2){
						$txt .='<tr>
						<td colspan="3" align="center"><b/>
						Credentials presented by the Ambassador<br/><b/>'.$rr[TGL_CREDENTIAL].'
						</td>						
						</tr>						
					';	
					}
					$txt .= '
					<br/>
						<tr>
						<td width="70">Chancery</td>
						<td width="5">:</td>
						<td width="217">'.$rr[ALAMAT].'</td>
						</tr>
						<tr>
						<td width="70"></td>
						<td width="5"></td>
						<td width="217">Phone: '.$rr[TELP].'<br/>Fax: '.$rr[FAX].'</td>
						</tr>
						<tr>
						<td width="70">Office Hours</td>
						<td width="5">:</td>
						<td width="217">'.$rr[OFFHOURS].'</td>
						</tr>
						<tr>
						<td width="70">National Day</td>
						<td width="5">:</td>
						<td width="217">'.$rr[KET_NATIONALDAY].', '.$rr[NATIONALDAY].'</td>
						</tr>
						<hr/>
						';
				$negara = $rr[NEGARA];
				}
				$he='';
				if($rr[ID_RANK] == 1){$he='His Excellency<br/>';}
						$txt.='<tr style="page-break-inside: avoid;">
						<td width="140">'.$he.''.ucwords(strtolower($rr[NM_DIPLOMAT])).'<br/>'.ucwords(strtolower($rr[NM_SIBLING])).'</td>
						<td width="110"><b>'.ucwords(strtolower($rr[OFFICIAL_NM])).'<br/>'.ucwords(strtolower($rr[OFFICIAL_PEKERJAAN])).'</b></td>
						<td width="50">'.$rr[TGL_TIBA].'</td>
						</tr><br/>';
				}				
			$txt .='</table>';

		
		
		$this->printpassport ( $txt );
	}
	public function printpassport($txt) {
	 
			$this->pdf = new MYPDF ( 'L', 'cm', array (
					21,
					14.5 
			), true, 'UTF-8', false );
		
		// set document information
		$this->pdf->SetCreator ( PDF_CREATOR );
		$this->pdf->SetAuthor ( 'Kementerian Luar Negeri Republik Indonesia' );
		$this->pdf->SetTitle ( 'PRINT DIPLOMATIK LIST' );
		$this->pdf->SetSubject ( 'KEMENLU RI' );
		$this->pdf->SetKeywords ( 'diplist, nationality' );
		// remove default header/footer
		// set header and footer fonts
		$this->pdf->setHeaderFont ( Array (
				PDF_FONT_NAME_MAIN,
				'',
				PDF_FONT_SIZE_MAIN 
		) );
		
		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont ( PDF_FONT_MONOSPACED );
		
		// set margins
		$this->pdf->SetMargins(2, 2, 2);
		$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		//$this->pdf->SetPrintHeader(false);
		//$this->pdf->SetPrintFooter(false);
		// remove default footer
		//$this->pdf->setPrintFooter ( true );
		
		// set auto page breaks
		//$this->pdf->SetAutoPageBreak ( True, 20 );
		
		// set image scale factor
		//$this->pdf->setImageScale ( PDF_IMAGE_SCALE_RATIO );
		
		// set some language-dependent strings
		// $this->pdf->setLanguageArray($l);
		
		// ---------------------------------------------------------
		
		// set font
		$this->pdf->SetFont ( 'times', '', 9 );
		
		// add a page
		$this->pdf->AddPage ();
		$this->pdf->Ln ();
		
		$this->pdf->writeHTML ( $txt, true, 0, true, 0 );
		
		//$this->pdf->SetFont ( 'helvetica', '', 5.5 );
		
		// define barcode style
		/*$style = array (
				'position' => '',
				'align' => 'C',
				'stretch' => false,
				'fitwidth' => false,
				'cellfitalign' => '',
				'border' => true,
				'hpadding' => 'auto',
				'vpadding' => 'auto',
				'fgcolor' => array (
						0,
						0,
						0 
				),
				'bgcolor' => false, // array(255,255,255),
				'text' => true,
				'font' => 'helvetica',
				'fontsize' => 3,
				'stretchtext' => 4 
		);*/
		
		// PRINT VARIOUS 1D BARCODES
		
		// CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
		// $this->pdf->Cell(0, 0, 'CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9', 0, 1);
		// $this->pdf->write1DBarcode('39', 'C39', '', '', '', 18, 0.4, $style, 'N');
		//$this->pdf->Text ( 50, 50, 'test', $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false );
		// $this->pdf->Ln();
		
		// $this->pdf->txt($this->rdata[ID_CARD], true, 0, true, 0);
		
		// PRINT VARIOUS 1D BARCODES
		
		// $this->pdf->write1DBarcode($this->rdata[ID_CARD], 'C39', '', '', 80, 5, 0.4, $style, 'N');
		// Close and output PDF document
		//$this->pdf->SetDisplayMode ( 150, 'SinglePage', 'UseNone' );
		ob_end_clean();
		$this->pdf->Output ( 'diplist.pdf', 'I' );
		
		// ============================================================+
		// END OF FILE
		// ============================================================+
	}
}
?>