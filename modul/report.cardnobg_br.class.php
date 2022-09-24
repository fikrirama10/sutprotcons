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
		// Full background image
		// $auto_page_break = $this->AutoPageBreak;
		// $this->SetAutoPageBreak ( false, 0 );
		// $img_file = K_PATH_IMAGES.'idcard.jpg';
		// $img_file = '../images/idhijau2.jpg';
		// $img_file = '../images/idmerah_wfh.jpg';

		// /* ----- Uncomment this for showing ID Card's background (during WFH) ----- */
		$img_file = '../images/idmerah_wfh.jpg';
				$this->Image ( $img_file, $x = 0, $y = -0.1, $w = 8.5, $h = 5.4, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0 );
		/* ----- End of for showing ID Card's background ----- */

		/*$warna = $_POST ['warna'];
		if ($warna == 'merah') {
			$img_file = '../images/idmerah_br.jpg';
		} else if ($warna == 'kuning') {
			$img_file = '../images/idmerah_br.jpg';
		} else if ($warna == 'hijau') {
			$img_file = '../images/idmerah_br.jpg';
		} else if ($warna == 'biru') {
			$img_file = '../images/idmerah_br.jpg';
		} else if ($warna == 'oranye') {
			$img_file = '../images/idmerah_br.jpg';
		} else if ($warna == 'putih') {
			$img_file = '../images/idmerah_br.jpg';
		}*/
		// $img_file = '../images/idkuning.jpg';

		// $this->Image($img_file, $x=0, $y=0, $w=8.5, $h=5.4, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0);
		/*if ($_POST ['opsi'] == 'kartu') {
			$this->Image ( $img_file, $x = 0, $y = -0.1, $w = 8.5, $h = 5.4, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0 );
		} else {
			$this->Image ( $img_file, $x = 0, $y = -0.1, $w = 8.5, $h = 5.4, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0 );
		}*/
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
	var $id_dip;
	var $id_permit;
	public function card($iddiplomat) {
		$sql = "select a.NM_DIPLOMAT,a.ID_CARD,date_format(a.TGL_AKHIR_CARD,'%d') as tgl,date_format(a.TGL_AKHIR_CARD,'%c') as bln,date_format(a.TGL_AKHIR_CARD,'%Y') as thn, a.ID_ROOT_KANTOR
		from v_id_card_w_permit a where a.ID_DIPLOMAT= $iddiplomat and a.ID_CETAK = (select max(b.ID_CETAK) from cetak_kartu_diplomat b where b.ID_DIPLOMAT= $iddiplomat AND KD_WORKFLOW>=1)";

		//print_r($sql);


		$data = mysql_query ( $sql );
		$this->rdata = mysql_fetch_array ( $data );

		$data = mysql_query ( "select NM_KNT_PERWAKILAN,PEKERJAAN,NO_PASPOR,JNS_PASPOR,ID_KNT_PERWAKILAN,FOTO from v_diplomat where ID_DIPLOMAT= $iddiplomat  " );
		$this->rdata2 = mysql_fetch_array ( $data );

		$data = mysql_query ( "select FOTO_TTD from diplomat where ID_DIPLOMAT = $iddiplomat" );
		$this->rdata3 = mysql_fetch_array ( $data );
		//print_r($this->rdata[ID_ROOT_KANTOR]);die;

		$this->root_kantor = '';
		if(!empty($this->rdata[ID_ROOT_KANTOR]) && $this->rdata[ID_ROOT_KANTOR] != '196' && $this->rdata[ID_ROOT_KANTOR] != '193'){
		$data = mysql_query ( "select NM_KNT_PERWAKILAN from m_kantor_perwakilan where ID_KNT_PERWAKILAN = " . $this->rdata[ID_ROOT_KANTOR] );
		$this->rdata4 = mysql_fetch_array ( $data );
		$this->root_kantor = $this->rdata4 [NM_KNT_PERWAKILAN];
		}
		//print_r($root_kantor);die;
		// $data = mysql_query("select NM_KNT_PERWAKILAN, PEKERJAAN,NO_PASPOR,JNS_PASPOR,NM_KNT_PERWAKILAN,FOTO,FOTO_TTD from v_diplomat where ID_DIPLOMAT= $iddiplomat ");
		// $this->rdata2 = mysql_fetch_array($data);
		$this->id_dip = $iddiplomat;
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
		$tanggal3 = $nama_bln [$this->rdata [bln]] . " " . $this->rdata [thn];
		// $tes = ucwords(strtolower($this->rdata[NM_DIPLOMAT]));

		// if (empty($this->rdata2[FOTO]) or empty($this->rdata2[FOTO_TTD])){
		// echo "<script language='javascript'>window.alert('Cetak Kartu gagal, Foto Belum tersedia!'); history.back(1); </script>";
		// }
		$space1 = "";
		$space2 = "";
		$space3 = "";
	if (strlen ( $this->rdata [NM_DIPLOMAT] ) <= 32) {
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
			$lingkaran = "";
		if(substr($this->rdata [ID_CARD],0,1) == 'D'){
			$lingkaran = 'red.png';
		}elseif(substr($this->rdata [ID_CARD],0,1) == 'C'){
			$lingkaran = 'orange.png';
		}
		elseif(substr($this->rdata [ID_CARD],0,1) == 'S'){
			$lingkaran = 'yellow.png';
		}elseif(substr($this->rdata [ID_CARD],0,1) == 'O'){
			$lingkaran = 'blue.png';
		}elseif(substr($this->rdata [ID_CARD],0,1) == 'K'){
			$lingkaran = 'green.png';
		}elseif(substr($this->rdata [ID_CARD],0,1) == 'P'){
			$lingkaran = 'black.png';
		}else{
			$lingkaran = 'blacksong.png';
		}

		$kode_id = "";
		if(substr($this->rdata [ID_CARD],0,1) == 'K'){
			$kode_id = 'HC';
		}else{
			$kode_id = substr($this->rdata [ID_CARD],0,1);
		}

		//$qrcode= 'Nomor: '.$this->rdata [ID_CARD].'<br/>Nama: '.ucwords ( strtolower ( $this->rdata [NM_SIBLING] ) ).'<br/>Klik untuk verifikasi data: http://dev-layanandiplomatik.kemlu.go.id/cek_id_card_fam?id='.$this->id_sib.'&cetak='.$this->id_permit;
		$qrcode= 'https://layanandiplomatik.kemlu.go.id/cd?cr='.$this->id_dip;
		QRCode::png($qrcode,"image.png","L",1.5,1);

		if ($_POST ['opsi'] == 'kartu') {
			$txt = '
				<br/><br/><br/><br/><br/><br/>
				<table style="font-family:Courier New; font-size:90%;" cellpadding="0" cellspacing="0" width="240px" border="0">
				<tr>
					<td height="9" colspan="3" align="center"></td>
				</tr>
				<tr>
					<td width="68px" align=right>
						<img src="../foto/' . $this->rdata2 [FOTO] . '" border="0" height="72" width="56"/><br/>
						<img src="../foto/ttd/' . $this->rdata3 [FOTO_TTD] . '" border="0" height="16" width="56"/>
					</td>
					<td width="4.5px" align="center"></td>
					<td width="128.5px" >
						<table cellpadding="0" cellspacing="0" border="0"  bordercolor="#000000" >
							<tr>
								<td width="70px" height="17">Nomor<br/><b>' . $this->rdata [ID_CARD] . '</b></td>
								<td width="3px"></td>
								<td width="75px" align=center ><img src="../images/'.$lingkaran.'" border="0" height="18" width="18"/></td>
							</tr>
							<tr>
								<td width="77px" height="17">Nama<br/><b>' . ucwords ( strtolower ( $this->rdata [NM_DIPLOMAT] ) ) . '</b></td>
								<td width="3px"></td>
								<td width="75px">Nomor & Jenis Paspor<br/><b>' . $this->rdata2 [NO_PASPOR] . ' / ' . $this->rdata2 [JNS_PASPOR] . '</b></td>
							</tr>
							<tr>
								<td width="77px" height="20">Gelar / Jabatan<br/><b>' . $this->rdata2 [PEKERJAAN] . '</b></td>
								<td width="3px"></td>
								<td width="65px">Masa Berlaku<br/><b>' . $tanggal2 . '</b></td>
							</tr>
							<tr>
								<td width="77px">Perwakilan<br/><b>';
								if($this->root_kantor == '' || $this->rdata[ID_ROOT_KANTOR] == $this->rdata2[ID_KNT_PERWAKILAN]){
									$txt .= '' . $this->rdata2 [NM_KNT_PERWAKILAN] . '';
								}else{
									$txt .= '' . $this->root_kantor . ' <br/> ' . $this->rdata2 [NM_KNT_PERWAKILAN] . '';
								}
								$txt .= '</b></td>
								<td width="3px"></td>
								<td width="55px">Dikeluarkan pada<br/><b>' . $tanggal . '</b></td>
								</tr>
						</table>
					</td>
					<td width="20px">
						<table border="0">
							<tr>
								<td height="17" width="27px"></td>
							</tr>
							<tr>
								<td height="17" width="27px"></td>
							</tr>
							<tr>
								<td height="25.5" width="27px"></td>
							</tr>
							<tr>
								<td height="19" width="27px" align="left"><img width="34" height="34" src="image.png" /></td>
							</tr>

						</table>
					</td>

		 		</tr>
				</table>';
		} else {
			$txt = '
				<br/><br/><br/><br/><br/><br/>
				<table style="font-family:Courier New; font-size:90%;" cellpadding="0" cellspacing="0" width="240px" border="0">
				<tr>
					<td height="9" colspan="3" align="center"></td>
				</tr>
				<tr>
					<td width="68px" align=right>
						<img src="../foto/' . $this->rdata2 [FOTO] . '" border="0" height="72" width="56"/><br/>
						<img src="../foto/ttd/' . $this->rdata3 [FOTO_TTD] . '" border="0" height="16" width="56"/>
					</td>
					<td width="4.5px" align="center"></td>
					<td width="128.5px" >
						<table cellpadding="0" cellspacing="0" border="0"  bordercolor="#000000" >
							<tr>
								<td width="70px" height="17">Nomor<br/><b>' . $this->rdata [ID_CARD] . '</b></td>
								<td width="3px"></td>
								<td width="75px" align=center ><img src="../images/'.$lingkaran.'" border="0" height="18" width="18"/></td>
							</tr>
							<tr>
								<td width="77px" height="17">Nama<br/><b>' . ucwords ( strtolower ( $this->rdata [NM_DIPLOMAT] ) ) . '</b></td>
								<td width="3px"></td>
								<td width="75px">Nomor & Jenis Paspor<br/><b>' . $this->rdata2 [NO_PASPOR] . ' / ' . $this->rdata2 [JNS_PASPOR] . '</b></td>
							</tr>
							<tr>
								<td width="77px" height="20">Gelar / Jabatan<br/><b>' . $this->rdata2 [PEKERJAAN] . '</b></td>
								<td width="3px"></td>
								<td width="65px">Masa Berlaku<br/><b>' . $tanggal2 . '</b></td>
							</tr>
							<tr>
								<td width="77px">Perwakilan<br/><b>';
								if($this->root_kantor == '' || $this->rdata[ID_ROOT_KANTOR] == $this->rdata2[ID_KNT_PERWAKILAN]){
									$txt .= '' . $this->rdata2 [NM_KNT_PERWAKILAN] . '';
								}else{
									$txt .= '' . $this->root_kantor . ' <br/> ' . $this->rdata2 [NM_KNT_PERWAKILAN] . '';
								}
								$txt .= '</b></td>
								<td width="3px"></td>
								<td width="55px">Dikeluarkan pada<br/><b>' . $nama_bln [$month] . " " . $part [0] . '</b></td>
								</tr>
						</table>
					</td>
					<td width="20px">
						<table border="0">
							<tr>
								<td height="17" width="27px"></td>
							</tr>
							<tr>
								<td height="17" width="27px"></td>
							</tr>
							<tr>
								<td height="25.5" width="27px"></td>
							</tr>
							<tr>
								<td height="19" width="27px" align="left"><img width="34" height="34" src="image.png" /></td>
							</tr>

						</table>
					</td>

		 		</tr>
				</table>';
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
					5.4,
					8.5
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
		// $this->pdf->SetMargins ( '0', '0', '0' ); //printer lama
		$this->pdf->SetMargins ( '0.08', '0.08', '0' ); //printer setting baru WFH
		$this->pdf->SetHeaderMargin ( 0 );
		$this->pdf->SetFooterMargin ( 0 );

		// remove default footer
		$this->pdf->setPrintFooter ( false );

		// set auto page breaks
		$this->pdf->SetAutoPageBreak ( FALSE, PDF_MARGIN_BOTTOM );

		// set image scale factor
		$this->pdf->setImageScale ( PDF_IMAGE_SCALE_RATIO );

		// set some language-dependent strings
		// $this->pdf->setLanguageArray($l);

		// ---------------------------------------------------------

		// set font
		$this->pdf->SetFont ( 'helvetica', '', 5.6 );

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
