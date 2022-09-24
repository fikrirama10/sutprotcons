<?php
//include_once("../config/dataAccess.class.php");
include "../config/koneksi.php";

include_once("../config/eng.php");
include_once("../config/tcpdf.php");


function bulan()
{
	$bulan=date("m");
	Switch ($bulan){
		case 1 : $bulan="Januari";
		Break;
		case 2 : $bulan="Februari";
		Break;
		case 3 : $bulan="Maret";
		Break;
		case 4 : $bulan="April";
		Break;
		case 5 : $bulan="Mei";
		Break;
		case 6 : $bulan="Juni";
		Break;
		case 7 : $bulan="Juli";
		Break;
		case 8 : $bulan="Agustus";
		Break;
		case 9 : $bulan="September";
		Break;
		case 10 : $bulan="Oktober";
		Break;
		case 11 : $bulan="November";
		Break;
		case 12 : $bulan="Desember";
		Break;
		}
	return $bulan;
	}

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

class card
{
	var $error;

	var $data;
	var $rdata;
	var $rdata2;
	var $rdata3;
	var $data2;
	var $data3;
	var $data4;
	var $data5;
	var $type;
	var $idpermit;
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
	var $idimage;
	var $representative;
	
	//$idpermit = $_GET[ID_DIPLOMAT];

	public function card($iddiplomat,$idpermit){
		
	
	$data = mysql_query("select NO_AGENDA,date_format(TGL_AGENDA,'%d %M %Y') as TGL_AGENDA,NO_IZIN_PERMIT,date_format(TGL_AWAL_PERMIT,'%d %M %Y') as  TGL_AWAL_PERMIT,date_format(TGL_AKHIR_PERMIT,'%d %M %Y') as  TGL_AKHIR_PERMIT,KET,NM_JNS_PERMIT,KD_JNS_PERMIT,ID_DIPLOMAT,NM_DIPLOMAT  from v_stay_permit where ID_PERMIT = $idpermit ");	
	$this->rdata  = mysql_fetch_array($data);
	$data2 = mysql_query("select NO_PASPOR, NM_KNT_PERWAKILAN from v_diplomat where ID_DIPLOMAT = $iddiplomat");
	$this->rdata2 = mysql_fetch_array($data2);
	$data3 = mysql_query("select FOTO, NM_DIPLOMAT from diplomat where ID_DIPLOMAT = $iddiplomat");
	$this->rdata3 = mysql_fetch_array($data3);
	/**$sql = $this->rdata3[NM_DIPLOMAT];
	echo $sql;
	exit;**/
	//$data = mysql_query("select NM_KNT_PERWAKILAN, PEKERJAAN,NO_PASPOR,JNS_PASPOR,NM_KNT_PERWAKILAN,FOTO from v_diplomat where ID_DIPLOMAT= $idpermit  ");	
	//$this->rdata2  = mysql_fetch_array($data);

		$this->formattingprint();
		
	}
	
	public function formattingprint()
	{	
		$txt='
		<br/> <br/> <br/> <br/> <br/>
		<br/> <br/> <br/> <br/> <br/>
		<br/> <br/> <br/> <br/> 
   			&nbsp;&nbsp;&nbsp;&nbsp;
  			&nbsp;&nbsp;&nbsp;&nbsp;
  			&nbsp;&nbsp;&nbsp;&nbsp;
  			&nbsp;&nbsp;&nbsp;&nbsp;
  			&nbsp;&nbsp;&nbsp;&nbsp;
  			&nbsp;&nbsp; 
   			<table width="80%"  border="0" >
			  <tr>
				<td colspan="4" align="center" >
					<u>Izin Tinggal / Izin Keluar Masuk Beberapa Kali Perjalanan</u><br />
					Stay Permit / Multi and Re-Entry Permit
			</td>
			  </tr>
			  <tr><td colspan="4">&nbsp;</td></tr>
			  <tr>
				<td rowspan="5" valign="middle" align="right">
					<img src="../foto/'.$this->rdata3[FOTO].'" border="0" height="60" width="47"/>&nbsp;&nbsp;&nbsp;
				</td>
				<td width="75"><u>No</u><br />
				  Number</td>
				<td width="15">:</td>
				<td >'.$this->rdata[NO_IZIN_PERMIT].'</td>
			  </tr>
			  <tr>
				<td width="75"><u>Nama</u><br />
				  Name</td>
				<td width="15">:</td>
				<td>'.$this->rdata[NM_DIPLOMAT].'</td>
			  </tr>
			  <tr>
				<td width="75"><u>No Paspor</u><br />
				  Passport Number</td>
				<td width="15">:</td>
				<td>'.$this->rdata2[NO_PASPOR].'</td>
			  </tr>
			  <tr>
				<td width="75"><u>Perwakilan</u><br />
				  Mission</td>
				<td width="15">:</td>
				<td width="130">'.$this->rdata2[NM_KNT_PERWAKILAN].'</td>
			  </tr>
			  <tr>
				<td width="75"><u>Masa Berlaku</u><br />
				  Expired Date</td>
				<td width="15">:</td>
				<td>'.$this->rdata[TGL_AKHIR_PERMIT].'</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td width="150">&nbsp;</td>
				<td>Jakarta, '.date("j").' '.bulan().' '.date("Y").'</td>
				<td></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td width="150">&nbsp;</td>
				<td>Kasubdit Izin Tinggal</td>
				<td></td>
			  </tr>
			</table>
 		';

 		/*$txt='
		<table width="325">
		<tr>
		<td width="60" align="left"><img src="../foto/'.$this->rdata3[FOTO].'" border="0" height="55" width="42"/></td>
		<td width="205" align="center"> <strong><h3>Kementerian Luar Negeri RI aa	</h3></strong></td>
		<td width="60"></td>
		</tr>
		</table>
		<table width="325">
		<tr><td></td></tr>
		<tr>
		<td align="center"><u><strong>IZIN TINGGAL/<em>STAY PERMIT</em></strong></u></td>
		</tr>
		<tr>
		<td align="center"><font size="6"><strong>IZIN KELUAR MASUK BEBERAPA KALI PERJALANAN / <em>MULTIPLE EXIT AND RE-ENTRY PERMIT</em></strong></font></td>
		</tr>
		<tr>
		<td align="center"> No :'.$this->rdata[NO_IZIN_PERMIT].'</td>
		</tr>
		</table>
		<br/>
		<br/>
		<table width="325px">
		<tr>
		<td width="25"></td>
		<td width="115">Nama / Name		</td>
		<td width="190"> : '. $this->rdata[NM_DIPLOMAT].'</td>
		</tr>
		<tr>
		<td width="25"></td>
		<td width="115">No. Paspor / Passport Number	</td>
		<td width="190"> : '.$this->rdata2[NO_PASPOR].'</td>
		</tr>
		<tr>
		<td width="25"></td>
		<td width="115">Perwakilan / Mission	</td>
		<td width="190"> : '.$this->rdata2[NM_KNT_PERWAKILAN].'</td>
		</tr>
		<tr>
		<td width="25"></td>
		<td width="115">Masa Berlaku / Expired Date	</td>
		<td width="190"> : '.$this->rdata[TGL_AKHIR_PERMIT].'</td>
		</tr>
		</table>
		<br/>
		<br/>
		<table width="325">
		<tr>
		<td width="200"></td>
		<td width="125" align="center">Jakarta, '.date("j").' '.bulan().' '.date("Y").'</td>
		</tr>
		<tr><td></td></tr>
		<tr><td></td></tr>
		<tr><td></td></tr>
		<tr>
		<td width="200"></td>
		<td width="125" align="center">Kasubdit Izin Tinggal</td>
		</tr>
		</table>

		';
		*/
		/**$txt='	
		<p>&nbsp;</p>
		<br/><br/><br/><br/>
		<table  cellpadding="0" cellspacing="0" width="265px">
		<tr>
			<td colspan="2" align="center"></td>
		</tr>
		<tr>
		
			<td width="55px" >
			</td>
			<td width="210px" >

		

			<table cellpadding="4" cellspacing="0" border="1"  bordercolor="#000000" >
				<tr>
					<td width="60px">Jenis</td>
					<td width="150px">: '.$this->rdata[KD_JNS_PERMIT].' / '.$this->rdata[NM_JNS_PERMIT].'</td>
				</tr>
				<tr>
					<td width="60px">Nama Diplomat</td>
					<td width="150px">: '. $this->rdata[NM_DIPLOMAT].'</td>
				</tr>
				<tr>
					<td width="60px">No Agenda</td>
					<td width="150px">: '.$this->rdata[NO_AGENDA].'</td>
				</tr>
				<tr>
					<td width="60px">Tanggal Agenda</td>
					<td width="150px">: '.$this->rdata[TGL_AGENDA].'</td>
				</tr>
				<tr>
					<td width="60px">No Izin Permit</td>
					<td width="150px">: '.$this->rdata[NO_IZIN_PERMIT].'</td>
				</tr>
				<tr>
					<td width="60px">Tanggal Awal Permit</td>
					<td width="150px">: '.$this->rdata[TGL_AWAL_PERMIT].'</td>
				</tr>
				<tr>
					<td width="60px">Berlaku s.d</td>
					<td width="150px">: '.$this->rdata[TGL_AKHIR_PERMIT].'</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		';**/
		$this->printpassport($txt);
	
	}
	public function printpassport($txt)
	{
		$this->pdf = new MYPDF('P', 'pt','A4');
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('michaelbzone');
		$this->pdf->SetTitle('PASSPORT DOCUMENT PRINT');
		$this->pdf->SetSubject('deplu RI');
		$this->pdf->SetKeywords('passport, nationality, michaelbzone, michael, Kelana');
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
		$this->pdf->SetFont('helvetica', '', 7);

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
		$this->pdf->SetDisplayMode(125,'SinglePage', 'UseNone');
		$this->pdf->Output('card.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+
	}
}
?>