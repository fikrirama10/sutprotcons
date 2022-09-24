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
		$auto_page_break = $this->AutoPageBreak;
		$this->SetAutoPageBreak(false, 0);
		//$img_file = K_PATH_IMAGES.'idcard.jpg';
		//$img_file = '../images/permit2.jpg';
		//$this->Image($img_file, $x=0, $y=0, $w=115, $h=80, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0);
		$this->SetAutoPageBreak($auto_page_break);
	}
}

class visa
{
	// var $error;

	// var $data;
	// var $rdata;
	// var $rdata2;
	// var $rdata3;
	// var $data2;
	// var $data3;
	// var $data4;
	// var $data5;
	// var $type;
	// var $idpermit;
	// var $query;
	// var $pdf;
	// var $profileid;
	// var $passporttype;
	// var $number;
	// var $name;
	// var $occupation;
	// var $cardnumber;
	// var $validcard;
	// var $idimg;
	// var $idimage;
	// var $representative;

	//$idpermit = $_GET[ID_DIPLOMAT];

	public function visa($idotvis, $idsib, $app_no){
		

	// $data = mysql_query("select * from tbl_trans_otvis where id_otvis =".$idotvis);
	
	// $this->rdata  = mysql_fetch_array($data);
	
	$sql_update = "update tbl_anggota_fam set no_app='$app_no' where id=$idsib";
	
	$update_appno = mysql_query($sql_update);

	$sql = "select tbl_trans_otvis.no_konsep_pusat, tbl_trans_otvis.nama, tbl_trans_otvis.paspor, 
						tbl_trans_otvis.tgl_keputusan, ifnull(tbl_trans_otvis.masa_berlaku_visa, 90) as masa_berlaku_visa, date_add(tbl_trans_otvis.tgl_keputusan, INTERVAL ifnull(tbl_trans_otvis.masa_berlaku_visa, 90) DAY) as tgl_expired, 
						tbl_trans_otvis.pejabat_pwk, tbl_trans_otvis.jabatan_pejabat_pwk, tbl_trans_otvis.foto, tbl_trans_otvis.tgl_lahir, tbl_trans_otvis.sex,
						tbl_tipe_visa.tipe_visa_en, 
						tbl_perwakilan.perwakilan, 
						m_negara.nm_states,
						m_jns_visa.kd_jns_visa
						from tbl_trans_otvis 
						join tbl_tipe_visa on tbl_tipe_visa.id = tbl_trans_otvis.tipe_visa 
						join tbl_perwakilan on tbl_perwakilan.id_perwakilan = tbl_trans_otvis.pwk_ri
						join m_negara on m_negara.id_negara = tbl_trans_otvis.kewarganegaraan
						join m_jns_visa on m_jns_visa.id_jns_visa = tbl_trans_otvis.indeks_visa
						where id_otvis =$idotvis";
	
	// print_r($this->rdata); exit;
	$data = mysql_query($sql);
	$this->rdata = mysql_fetch_array($data);

	
	$sql2 = "select nama, foto, tgl_lahir, sex, nopaspor, no_app from tbl_anggota_fam where id=$idsib";
	
	// print_r($this->rdata); exit;
	$data2 = mysql_query($sql2);
	$this->rdata2 = mysql_fetch_array($data2);

	
		$this->formattingprint();

	}

	public function formattingprint()
	{
		$tgl_format = split(" ",$this->rdata[TGL_AKHIR_PERMIT]);
		$bln = $tgl_format[1];
		Switch ($bln){
		case "January" : $bln="Januari";
		Break;
		case "February" : $bln="Februari";
		Break;
		case "March" : $bln="Maret";
		Break;
		case "April" : $bln="April";
		Break;
		case "May" : $bln="Mei";
		Break;
		case "June" : $bln="Juni";
		Break;
		case "July" : $bln="Juli";
		Break;
		case "August" : $bln="Agustus";
		Break;
		case "September" : $bln="September";
		Break;
		case "October" : $bln="Oktober";
		Break;
		case "November" : $bln="November";
		Break;
		case "December" : $bln="Desember";
		Break;
		}

		// --Tim DAM--
				// $jns_permit = $this->rdata[KD_JNS_PERMIT];
				// Switch ($jns_permit){
				// 	case "SERP" : $jns_permit="Izin Masuk Satu Kali Perjalanan";
				// 	Break;
				// 	case "MERP" : $jns_permit="Izin Keluar Masuk Beberapa Kali Perjalanan";
				// 	Break;
				// }
		
		$tgl_lahir = "-";
		$sex = "-";
		$entries = "SINGLE";

		if ($this->rdata2[tgl_lahir])
			$tgl_lahir = strtoupper(date("d-M-Y",strtotime($this->rdata2[tgl_lahir])));



		if ($this->rdata2[sex])
			$sex = substr($this->rdata2[sex],0,1);

		if ($this->rdata[kd_jns_visa]=="Multiple")
			$entries = "MULTIPLE";

		$txt='

   			&nbsp;&nbsp;&nbsp;&nbsp;
  			&nbsp;&nbsp;&nbsp;&nbsp;
  			&nbsp;&nbsp;&nbsp;&nbsp;
  			&nbsp;&nbsp;&nbsp;&nbsp;
  			&nbsp;&nbsp;&nbsp;&nbsp;
  			&nbsp;&nbsp;
   			<table width="80%"  border="0" cellpadding="1">
				
			  <tr><td colspan="5">&nbsp;</td></tr>
			  <tr>
			  
			  <td width="40"></td>	
			  <td align="left" >
			  <h3>'.strtoupper($this->rdata[tipe_visa_en]).'</h3>
		</td>
			  </tr>
			  
			  <tr>
				<td rowspan="11" valign="middle" align="right" width="106.5" height="100">
					<br/><img src="../files/otvis/foto/'.$this->rdata2[foto].'" border="0" height="71" width="58"/>&nbsp;&nbsp;&nbsp;
				</td>
				<td width="170"><br/>Surname / Given Name<br />
				  '.strtoupper($this->rdata2[nama]).'</td>
				
				
			  </tr>
			  <tr>
				<td width="65" >Passport no. <br />
				  '.strtoupper($this->rdata2[nopaspor]).'</td>
				<td width="30" >Sex <br />
				  '.$sex.' &nbsp;</td>
				<td width="57" >Date of Birth<br />
				  '.$tgl_lahir.' &nbsp;</td>
				<td width="127" >Nationality<br />
				  '.strtoupper($this->rdata[nm_states]).'&nbsp;</td>
			  </tr>
			  
			  <tr>
			  	<td width="95">No. of Entries<br />
				'.$entries.'&nbsp;</td>
				<td width="57" >Length of stay<br />
				  '.strtoupper($this->rdata[masa_berlaku_visa]).' Day(s)</td>
				<td width="70">Index Visa<br />
				  '.strtoupper($this->rdata[kd_jns_visa]).'</td>    
				
			  </tr>
			  <tr>
				<td width="95">Place of Issue<br />
				'.strtoupper($this->rdata[perwakilan]).'</td>
				<td width="57" >Date of Issue<br />
				'.strtoupper(date("d-M-Y",strtotime($this->rdata[tgl_keputusan]))).'</td>
				<td width="70" >Date of Expiry<br />
				'.strtoupper(date("d-M-Y",strtotime($this->rdata[tgl_expired]))).'</td>
			  </tr>
			  <tr>
				
				<td width=152>Authorization No. <br />
				  '.strtoupper($this->rdata[no_konsep_pusat]).'</td>
				<td width="90" >Application no.<br />
				'.strtoupper($this->rdata2[no_app]).'&nbsp;</td>

				
			  </tr>
			  
			  <tr><td>&nbsp;</td></tr>
			  <tr>
			  	<td width=140>&nbsp;</td>
			  	<td align="center" width="100">For The Ambassador,</td>
			  </tr>
			  <tr><td>&nbsp;</td></tr>
			  <tr><td>&nbsp;</td></tr>
			  <tr>
			  	<td width=140>&nbsp;</td>
			  	<td align="center" width="100"><u>'.strtoupper($this->rdata[pejabat_pwk]).'</u><br/>'.strtoupper($this->rdata[jabatan_pejabat_pwk]).'</td>
			  </tr>
			</table>
 		';

 		//echo $txt;
		$this->printvisa($txt);

	}
	
	public function printvisa($txt)
	{
		
		//echo "$txt"; exit;
		
		$this->pdf = new MYPDF('P', 'pt','CARDVISA');
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('michaelbzone');
		$this->pdf->SetTitle('VISA DOCUMENT PRINT');
		$this->pdf->SetSubject('Kemlu RI');
		$this->pdf->SetKeywords('Visa');
		// remove default header/footer
		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		$this->pdf->SetMargins('0', '110','0');
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
		$this->pdf->SetFont('helvetica', '', 7);
		
		// add a page
		$this->pdf->AddPage();
		/*$this->pdf->StartTransform();
		$this->pdf->Rotate(90);
		$this->pdf->MultiCell(100, 10, "rotated text", 0, 'C', false, 0, "", "", true, 0, false, true, 0, "T", false, true);
		$this->pdf->StopTransform();*/
		$this->pdf->StartTransform();
		$this->pdf->Rotate(90, 40, 20);
		//$this->pdf->Text(-150, 435, $this->rdata[KETVER]);
		$this->pdf->StopTransform();
		$this->pdf->Ln();
		$style = array(
			'position' => 'C',
			'border' => false,
			'padding' => 1,
			'fgcolor' => array(0,0,0),
			'bgcolor' => false
		);
		$this->style['position'] = 'C';
		//echo "berhasil";exit;
		$this->pdf->writeHTML($txt, true, 0, true, 0);

		// PRINT VARIOUS 1D BARCODES


		$this->pdf->write1DBarcode($this->number, 'C39', '', '', 80, 5, 0.4, $style, 'N');
		//Close and output PDF document
		$this->pdf->SetDisplayMode(125,'SinglePage', 'UseNone');
		$this->pdf->Output('visa.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+
	}
}
?>
