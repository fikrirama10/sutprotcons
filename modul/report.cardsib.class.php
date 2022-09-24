<?php
// include_once("../config/dataAccess.class.php");
include "../config/koneksi.php";

include_once ("../config/eng.php");
include_once ("../config/tcpdf.php");

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	// Page header
	public function Header() {
		// Full background image
		$auto_page_break = $this->AutoPageBreak;
		$this->SetAutoPageBreak ( false, 0 );
		// $img_file = K_PATH_IMAGES.'idcard.jpg';
		// $img_file = '../images/idhijau2.jpg';
		$warna = $_POST ['warna'];
		if ($warna == 'merah') {
			$img_file = '../images/idmerah.jpg';
		} else if ($warna == 'kuning') {
			$img_file = '../images/idkuning.jpg';
		} else if ($warna == 'hijau') {
			$img_file = '../images/idhijau.jpg';
		} else if ($warna == 'biru') {
			$img_file = '../images/idbiru.jpg';
		} else if ($warna == 'oranye') {
			$img_file = '../images/idoranye.jpg';
		} else if ($warna == 'putih') {
			$img_file = '../images/idputih.jpg';
		}
		// $img_file = '../images/idkuning.jpg';
		
		// $this->Image($img_file, $x=0, $y=0, $w=8.5, $h=5.4, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0);
		if ($_POST ['opsi'] == 'kartu') {
			$this->Image ( $img_file, $x = 0, $y = 0, $w = 8.5, $h = 5.4, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0 );
		} else {
			$this->Image ( $img_file, $x = 0.3, $y = 0.3, $w = 8.5, $h = 5.4, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0 );
		}
		$this->SetAutoPageBreak ( $auto_page_break );
	}
}
class card {
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
	public function card($idsibling, $idpermit) {
		$sql = "select a.NM_SIBLING,a.ID_CARD,date_format(a.TGL_AKHIR_CARD,'%d') as tgl,date_format(a.TGL_AKHIR_CARD,'%c') as bln,date_format(a.TGL_AKHIR_CARD,'%Y') as thn, a.ID_ROOT_KANTOR  from v_id_card_s a where a.ID_SIBLING='$idsibling' and a.ID_CETAK_S = (select max(b.ID_CETAK_S) from cetak_kartu_sibling b where b.ID_CETAK_S= $idpermit )";
		$data = mysql_query ( $sql );
		$this->rdata = mysql_fetch_array ( $data );
		
		$sql = "select NM_KNT_PERWAKILAN, PEKERJAAN,NO_PASPOR,JNS_PASPOR,ID_KNT_PERWAKILAN,FOTO from v_sibling where ID_SIBLING='$idsibling'";
		$data = mysql_query ( $sql );
		$this->rdata2 = mysql_fetch_array ( $data );
		
		$data = mysql_query ( "select FOTO_TTD from sibling where ID_SIBLING = $idsibling" );
		$this->rdata3 = mysql_fetch_array ( $data );
		
		$this->root_kantor = '';
		if(!empty($this->rdata[ID_ROOT_KANTOR]) && $this->rdata[ID_ROOT_KANTOR] != '196' && $this->rdata[ID_ROOT_KANTOR] != '193'){
		$data = mysql_query ( "select NM_KNT_PERWAKILAN from m_kantor_perwakilan where ID_KNT_PERWAKILAN = " . $this->rdata[ID_ROOT_KANTOR] );
		$this->rdata4 = mysql_fetch_array ( $data );
		$this->root_kantor = $this->rdata4 [NM_KNT_PERWAKILAN];	
		}
		
		// $data = mysql_query("select NM_KNT_PERWAKILAN, PEKERJAAN,NO_PASPOR,JNS_PASPOR,NM_KNT_PERWAKILAN,FOTO,FOTO_TTD from v_diplomat where ID_DIPLOMAT= $iddiplomat ");
		// $this->rdata2 = mysql_fetch_array($data);
		
		$this->formattingprint ( $_POST ['TGL_CETAK'] );
	}
	public function formattingprint($tgl2) {
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
		
		// $tanggal = date("j")." ".$nama_bln[date("n")]." ".date("Y");
		$part = explode ( "-", $tgl2 );
		$month = ltrim ( $part [1], "0" );
		$tanggal = $part [2] . " " . $nama_bln [$month] . " " . $part [0];
		$tanggal2 = $this->rdata [tgl] . " " . $nama_bln [$this->rdata [bln]] . " " . $this->rdata [thn];
		// $tes = ucwords(strtolower($this->rdata[NM_DIPLOMAT]));
		
		// if (empty($this->rdata2[FOTO]) or empty($this->rdata2[FOTO_TTD])){
		// echo "<script language='javascript'>window.alert('Cetak Kartu gagal, Foto Belum tersedia!'); history.back(1); </script>";
		// }
		$space1 = "";
		$space2 = "";
		$space3 = "";
		if (strlen ( $this->rdata [NM_SIBLING] ) <= 32) {
			$space1 = "<tr>
							<td></td>
							<td></td>
						</tr>";
		}
		if (strlen ( $this->rdata2 [PEKERJAAN] ) <= 32) {
			$space2 = "<tr>
							<td></td>
							<td></td>
						</tr>";
		}
		if (strlen ( $this->rdata2 [NM_KNT_PERWAKILAN] ) <= 32 && $this->root_kantor == '') {
			$space3 = "<tr>
							<td></td>
							<td></td>
						</tr>";
		}
		if (strlen ( $this->rdata2 [NM_KNT_PERWAKILAN] ) >= 33) {
			$space2 = "";
		}
		
		if ($_POST ['opsi'] == 'kartu') {
			$txt = '
				<p>&nbsp;</p>
				<br/><br/><br/>
				<table style="font-weight:bold;" cellpadding="0" cellspacing="0" width="240px" border="0" >
				<tr>
					<td colspan="3" align="center"></td>
				</tr>
		 	<tr>
					<td width="73px" style= "padding : 0;" align=center> 
					<img src="../foto sibling/' . $this->rdata2 [FOTO] . '" border="0" height="75" width="59"/>
					  <br/> <br/>
					&nbsp;
							<img src="../foto sibling//ttd/' . $this->rdata3 [FOTO_TTD] . '" border="0" height="17" width="50"/>
							</td>
					<td width="1px">
					</td>
					<td width="185px" > 
					<table cellpadding="0" cellspacing="0" border="0"  bordercolor="#000000" >
						<tr>
							<td width="52px">Nomor</td>
							<td width="5px">: </td>						
							<td width="110px"> ' . $this->rdata [ID_CARD] . '</td>
						</tr>
						<tr>
							<td width="52px">Nama</td>
							<td width="5px">: </td>
							<td width="110px">' . ucwords ( strtolower ( $this->rdata [NM_SIBLING] ) ) . '</td>
						</tr>
						<tr>
							<td width="52px">Gelar / Jabatan</td>
							<td width="5px">: </td>
							<td width="110px">' . $this->rdata2 [PEKERJAAN] . '</td>
						</tr>
						<tr>
							<td width="52px">No & Jenis Paspor</td>
							<td width="5px">: </td>
							<td width="110px">' . $this->rdata2 [NO_PASPOR] . ' / ' . $this->rdata2 [JNS_PASPOR] . '</td>
						</tr>
						<tr>
							<td width="52px">Perwakilan</td>
							<td width="5px">: </td>';
							
							if($this->root_kantor == '' || $this->rdata[ID_ROOT_KANTOR] == $this->rdata2[ID_KNT_PERWAKILAN]){								
								$txt .= '<td width="110px">' . $this->rdata2 [NM_KNT_PERWAKILAN] . '</td>';
							}else{								
								$txt .= '<td width="110px">' . $this->root_kantor . ' <br/> ' . $this->rdata2 [NM_KNT_PERWAKILAN] . '</td>';
							}		
							
							$txt .= '</tr>
						<tr>
							<td width="52px">Berlaku s/d</td>
							<td width="5px">: </td>
							<td width="110px">' . $tanggal2 . '</td>
						</tr>
		
					</table>
		
					<table cellpadding="0" cellspacing="0" border="0"  bordercolor="#000000" >
 						' . $space1 . '
						' . $space2 . '
						' . $space3 . '					 	
						<tr>
							<td width="96px" >  </td>						
							<td width="95px" align="left"><font size="5px"><b>Jakarta, ' . $tanggal . '</b></font></td>
						</tr>
					</table>
					
					</td>
		 		</tr> 
				</table>
				';
		} else {
			$txt = '
				<p>&nbsp;</p>
				<br/><br/><br/>
				<table style="font-weight:bold;" cellpadding="0" cellspacing="0" width="240px" border="0" >
				<tr>
					<td colspan="3" align="center"></td>
				</tr>
				<tr>
								<td colspan="3" align="center"></td>
				</tr>
				<tr>
					<td width="70px" style= "padding : 0;" align=center>&nbsp;
					<img src="../foto sibling/' . $this->rdata2 [FOTO] . '" border="0" height="75" width="59"/>
					  <br/> <br/>
					&nbsp;
							<img src="../foto sibling//ttd/' . $this->rdata3 [FOTO_TTD] . '" border="0" height="17" width="50"/>
							</td>
					<td width="7px">
					</td>
					<td width="185px" >
					<table cellpadding="0" cellspacing="0" border="0"  bordercolor="#000000" >
						<tr>
							<td width="52px"> Nomor</td>
							<td width="5px">: </td>						
							<td width="110px"> ' . $this->rdata [ID_CARD] . '</td>
						</tr>
						<tr>
							<td width="52px"> Nama</td>
							<td width="5px">: </td>
							<td width="110px">' . ucwords ( strtolower ( $this->rdata [NM_SIBLING] ) ) . '</td>
						</tr>
						<tr>
							<td width="52px"> Gelar / Jabatan</td>
							<td width="5px">: </td>
							<td width="110px">' .$this->rdata2 [PEKERJAAN]. '</td>
						</tr>
						<tr>
							<td width="52px"> No & Jenis Paspor</td>
							<td width="5px">: </td>
							<td width="110px">' . $this->rdata2 [NO_PASPOR] . ' / ' . $this->rdata2 [JNS_PASPOR] . '</td>
						</tr>
						<tr>
							<td width="52px"> Perwakilan</td>
							<td width="5px">: </td>';
							
							if($this->root_kantor == '' || $this->rdata[ID_ROOT_KANTOR] == $this->rdata2[ID_KNT_PERWAKILAN]){								
								$txt .= '<td width="110px">' . $this->rdata2 [NM_KNT_PERWAKILAN] . '</td>';
							}else{								
								$txt .= '<td width="110px">' . $this->root_kantor . ' <br/> ' . $this->rdata2 [NM_KNT_PERWAKILAN] . '</td>';
							}		
							
							$txt .= '</tr>
						<tr>
							<td width="52px"> Berlaku s/d</td>
							<td width="5px">:</td>
							<td width="110px">' . $tanggal2 . '</td>
						</tr>
		
					</table>
		
					<table cellpadding="0" cellspacing="0" border="0"  bordercolor="#000000" >
 						' . $space1 . '
						' . $space2 . '
						' . $space3 . '	
						 			 	
						<tr>
		
							<td width="105px" >  </td>						
							<td width="95px" align="left"><font size="5px"><b>Jakarta, &nbsp; &nbsp; ' . $nama_bln [$month] . " " . $part [0] . '</b></font></td>
						</tr>
						</table>
					
					</td>
		 		</tr> 
				</table>
				';
		}
		$this->printpassport ( $txt );
	}
	public function printpassport($txt) {
		if ($_POST ['opsi'] == 'kartu') {
			$this->pdf = new MYPDF ( 'L', 'cm', array (
					5.4,
					8.5 
			), true, 'UTF-8', false );
		} else {
			$this->pdf = new MYPDF ( 'L', 'cm', array (
					5.7,
					8.9 
			), true, 'UTF-8', false );
		}
		// set document information
		$this->pdf->SetCreator ( PDF_CREATOR );
		$this->pdf->SetAuthor ( 'Kementerian Luar Negeri Republik Indonesia' );
		$this->pdf->SetTitle ( 'ID CARD PRINT' );
		$this->pdf->SetSubject ( 'KEMENLU RI' );
		$this->pdf->SetKeywords ( 'id card, nationality' );
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
		$this->pdf->SetMargins ( '0', '0', '0' );
		$this->pdf->SetHeaderMargin ( 0 );
		$this->pdf->SetFooterMargin ( 0 );
		
		// remove default footer
		$this->pdf->setPrintFooter ( false );
		
		// set auto page breaks
		$this->pdf->SetAutoPageBreak ( TRUE, PDF_MARGIN_BOTTOM );
		
		// set image scale factor
		$this->pdf->setImageScale ( PDF_IMAGE_SCALE_RATIO );
		
		// set some language-dependent strings
		// $this->pdf->setLanguageArray($l);
		
		// ---------------------------------------------------------
		
		// set font
		$this->pdf->SetFont ( 'helvetica', '', 5.5 );
		
		// add a page
		$this->pdf->AddPage ();
		$this->pdf->Ln ();
		$style = array (
				'position' => 'C',
				'border' => false,
				'padding' => 1,
				'fgcolor' => array (
						0,
						0,
						0 
				),
				'bgcolor' => false 
		);
		$this->style ['position'] = 'C';
		
		$this->pdf->writeHTML ( $txt, true, 0, true, 0 );
		
		$this->pdf->SetFont ( 'helvetica', '', 5.5 );
		
		// define barcode style
		$style = array (
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
		);
		
		// PRINT VARIOUS 1D BARCODES
		
		// CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
		// $this->pdf->Cell(0, 0, 'CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9', 0, 1);
		// $this->pdf->write1DBarcode('39', 'C39', '', '', '', 18, 0.4, $style, 'N');
		$this->pdf->Text ( 50, 50, 'test', $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false );
		// $this->pdf->Ln();
		
		// $this->pdf->txt($this->rdata[ID_CARD], true, 0, true, 0);
		
		// PRINT VARIOUS 1D BARCODES
		
		// $this->pdf->write1DBarcode($this->rdata[ID_CARD], 'C39', '', '', 80, 5, 0.4, $style, 'N');
		// Close and output PDF document
		$this->pdf->SetDisplayMode ( 150, 'SinglePage', 'UseNone' );
		$this->pdf->Output ( 'card.pdf', 'I' );
		
		// ============================================================+
		// END OF FILE
		// ============================================================+
	}
}
?>