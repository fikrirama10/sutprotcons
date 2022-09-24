<?php
//include_once("../config/dataAccess.class.php");
include "../config/koneksi.php";

include_once("../config/eng.php");
include_once("../config/tcpdf.php");
session_start();

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// Full background image
		$auto_page_break = $this->AutoPageBreak;
		$this->SetAutoPageBreak(false, 0);
		//$img_file = K_PATH_IMAGES.'idcard.jpg';
		$this->Image($img_file, $x=0, $y=0, $w=12, $h=8, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0);
		$this->SetAutoPageBreak($auto_page_break);
	}
}



class lap_jmlpermit
{
	var $error;

	var $data;
	var $rdata;
	var $rdata2;

	var $data4;
	var $data5;
	var $type;
	var $iddiplomat;
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

	public function lap_jmlpermit(){
	
	$data = mysql_query($_SESSION[G_sql_lap]);	
	$this->rdata  = mysql_fetch_array($data);

	$this->formattingprint();
		
	}
	
	public function formattingprint()
	{	
		$txt='
		<p>&nbsp;</p>
		<br/><br/><br/><br/><br/>
		<table cellpadding="0" cellspacing="0" width="335px">
		<tr>
			<td colspan="3" align="center"></td>
		</tr>
		<tr>
			<td width="85px" style= "padding : 0;" align=center>
			<img src="../foto/'.$this->rdata2[FOTO].'" border="0" height="100" width="75"/>
			</td>
			<td width="10px" >
			</td>
			<td width="240px" >
			<table cellpadding="3" cellspacing="0" border="1"  bordercolor="#000000" >
				<tr>
					<td width="60px">No</td>
					<td width="180px">: '.$this->rdata[ID_CARD].'</td>
				</tr>
				<tr>
					<td width="60px">Nama</td>
					<td width="180px">: '. $this->rdata[NM_DIPLOMAT].'</td>
				</tr>
				<tr>
					<td width="60px">Gelar / Jabatan</td>
					<td width="180px">: '.$this->rdata2[PEKERJAAN].'</td>
				</tr>
				<tr>
					<td width="60px">No. / Jenis Passpor</td>
					<td width="180px">: '.$this->rdata2[NO_PASPOR].' / '.$this->rdata2[JNS_PASPOR].'</td>
				</tr>
				<tr>
					<td width="60px">Perwakilan</td>
					<td width="180px">: '.$this->rdata2[NM_KNT_PERWAKILAN].'</td>
				</tr>
				<tr>
					<td width="60px">Berlaku s.d</td>
					<td width="180px">: '.$this->rdata[TGL_AKHIR_CARD].'</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		';
		$this->printpassport($txt);
	
	}
	public function printpassport($txt)
	{
		$this->pdf = new MYPDF('L', 'cm',  array(8,12), true, 'UTF-8', false);
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('michaelbzone');
		$this->pdf->SetTitle('PASSPORT DOCUMENT PRINT');
		$this->pdf->SetSubject('deplu RI');
		$this->pdf->SetKeywords('passport, nationality, michaelbzone, michael, butar butar');
		// remove default header/footer
		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		$this->pdf->SetMargins('0', '0','0');
		$this->pdf->SetHeaderMargin(0);
		$this->pdf->SetFooterMargin(0);

		// remove default footer
		$this->pdf->setPrintFooter(false);

		//set auto page breaks
		$this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

		//set some language-dependent strings
		//$this->pdf->setLanguageArray($l); 

		// ---------------------------------------------------------

		// set font
		$this->pdf->SetFont('helvetica', '', 6);

		// add a page
		$this->pdf->AddPage();
		$this->pdf->Ln();
		$style = array(
			'position' => 'C',
			'border' => false,
			'padding' => 1,
			'fgcolor' => array(0,0,0),
			'bgcolor' => false
		);
		$this->style['position'] = 'C';

		$this->pdf->writeHTML($txt, true, 0, true, 0);

		// PRINT VARIOUS 1D BARCODES
		
		$this->pdf->write1DBarcode($this->number, 'C39', '', '', 80, 5, 0.4, $style, 'N');
		//Close and output PDF document
		$this->pdf->SetDisplayMode(150,'SinglePage', 'UseNone');
		$this->pdf->Output('lapjmlpermit.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+
	}
}
?>