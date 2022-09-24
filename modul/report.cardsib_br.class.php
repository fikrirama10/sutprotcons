<?php
include "../config/koneksi.php";

include_once ("../config/eng.php");
include_once ("../config/tcpdf.php");
// require_once(dirname(__FILE__)."/phpqrcode/qrlib.php");
require_once("phpqrcode/qrlib.php");

class MYPDF extends TCPDF {

	public function Header()
	{
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
	var $id_sib;
	var $id_permit;

	public function card($idsibling, $idpermit) 
	{
		$sql = "select a.NM_SIBLING,a.ID_CARD,date_format(a.TGL_AKHIR_CARD,'%d') as tgl,date_format(a.TGL_AKHIR_CARD,'%c') as bln,date_format(a.TGL_AKHIR_CARD,'%Y') as thn, a.ID_ROOT_KANTOR
		from v_id_card_s a where a.ID_SIBLING='$idsibling' and a.ID_CETAK_S = (select max(b.ID_CETAK_S) from cetak_kartu_sibling b where b.ID_CETAK_S= $idpermit )";

		$data = mysql_query($sql);
		$this->rdata = mysql_fetch_array($data);

		$sql = "select NM_KNT_PERWAKILAN,PEKERJAAN,NO_PASPOR,JNS_PASPOR,ID_KNT_PERWAKILAN,FOTO from v_sibling where ID_SIBLING = '$idsibling'";
		$data = mysql_query($sql);
		$this->rdata2 = mysql_fetch_array($data);

		$data = mysql_query("select FOTO_TTD from sibling where ID_SIBLING = $idsibling");
		$this->rdata3 = mysql_fetch_array($data);

		$this->root_kantor = '';
		if(!empty($this->rdata[ID_ROOT_KANTOR]) && $this->rdata[ID_ROOT_KANTOR] != '196' && $this->rdata[ID_ROOT_KANTOR] != '193'){
			$data = mysql_query ( "select NM_KNT_PERWAKILAN from m_kantor_perwakilan where ID_KNT_PERWAKILAN = " . $this->rdata[ID_ROOT_KANTOR]);
			$this->rdata4 = mysql_fetch_array($data);
			$this->root_kantor = $this->rdata4[NM_KNT_PERWAKILAN];
		}

		$this->id_sib = $idsibling;
		$this->id_permit = $idpermit;
		$this->formattingprint($_POST['TGL_CETAK']);
	}

	public function formattingprint($tgl2) 
	{
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

		$part = explode("-", $tgl2);
		$month = ltrim($part[1], "0" );
		$tanggal = $part[2] . " " . $nama_bln[$month] . " " . $part[0];
		$tanggal2 = $this->rdata[tgl] . " " . $nama_bln[$this->rdata[bln]] . " " . $this->rdata[thn];

		$space1 = "";
		$space2 = "";
		$space3 = "";

		if (strlen($this->rdata[NM_SIBLING]) <= 32) {
			$space1 = "<tr>
							<td></td>
							<td></td>
						</tr>";
		}
		if (strlen($this->rdata2[PEKERJAAN]) <= 32) {
			$space2 = "<tr>
							<td></td>
							<td></td>
						</tr>";
		}
		if (strlen($this->rdata2[NM_KNT_PERWAKILAN] ) <= 32 && $this->root_kantor == '') {
			$space3 = "<tr>
							<td></td>
							<td></td>
						</tr>";
		}
		if (strlen($this->rdata2[NM_KNT_PERWAKILAN]) >= 33) {
			$space2 = "";
		}

		$lingkaran = "";
		if(substr($this->rdata[ID_CARD],0,1) == 'D') {
			$lingkaran = 'red.png';
		} elseif (substr($this->rdata[ID_CARD],0,1) == 'C') {
			$lingkaran = 'orange.png';
		} elseif (substr($this->rdata[ID_CARD],0,1) == 'S') {
			$lingkaran = 'yellow.png';
		} elseif (substr($this->rdata[ID_CARD],0,1) == 'O') {
			$lingkaran = 'blue.png';
		} elseif (substr($this->rdata[ID_CARD],0,1) == 'K') {
			$lingkaran = 'green.png';
		} elseif (substr($this->rdata[ID_CARD],0,1) == 'P') {
			$lingkaran = 'black.png';
		} else {
			$lingkaran = 'blacksong.png';
		}

		$kode_id = "";
		if (substr($this->rdata[ID_CARD],0,1) == 'K') {
			$kode_id = 'HC';
		} else {
			$kode_id = substr($this->rdata[ID_CARD],0,1);
		}

		$tempDir = "temp/";
		$filename = "image.png";
		$pngFilePath = $tempDir . $filename;

		$qrContent = 'https://layanandiplomatik.kemlu.go.id/ck?id='.$this->id_sib.'&cetak='.$this->id_permit;
		QRcode::png($qrContent, $pngFilePath, QR_ECLEVEL_L, 10, 1);

		// QRCode::png($qrcode,"image.png","L",1.5,1);
		// QRCode::png($qrcode,"image.png",QR_ECLEVEL_L,10,1);

		$opsi_cetak = $_POST['opsi'];

		if ($opsi_cetak == 'kartu') 
		{
			$txt = '
				<br/><br/><br/><br/><br/><br/>
				<table style="font-family:Courier New; font-size:90%;" cellpadding="0" cellspacing="0" width="240px" border="0">
				<tr>
					<td height="9" colspan="3" align="center"></td>
				</tr>
				<tr>
					<td width="68px" align=right>
						<img src="../foto sibling/' . $this->rdata2 [FOTO] . '" border="0" height="72" width="56"/><br/>
						<img src="../foto sibling//ttd/' . $this->rdata3 [FOTO_TTD] . '" border="0" height="16" width="56"/>
					</td>
					<td width="3px" align="center"></td>
					<td width="127px" >
						<table cellpadding="0" cellspacing="0" border="0"  bordercolor="#000000" >
							<tr>
								<td width="70px" height="17">Nomor<br/><b>' . $this->rdata [ID_CARD] . '</b></td>
								<td width="3px"></td>
								<td width="75px" align=center ><img src="../images/'.$lingkaran.'" border="0" height="18" width="18"/></td>
							</tr>
							<tr>
								<td width="77px" height="17">Nama<br/><b>' . ucwords ( strtolower ( $this->rdata [NM_SIBLING] ) ) . '</b></td>
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
								<td height="28" width="27px"></td>
							</tr>
							<tr>
								<td height="19" width="27px" align="left"><img width="34" height="34" src="'.$pngFilePath.'" /></td>
							</tr>

						</table>
					</td>

		 		</tr>
				</table>';
		}
		if ($opsi_cetak == 'kartu_baru')
		{
			// Percobaan ke-4
			if ($this->rdata2[JNS_PASPOR] == "Laissez-Passer")
			{
				$font_size = "110";
			}
			else
			{
				$font_size = "120";
			}
			$txt = '
			<table cellpadding="0" cellspacing="0" width="236" border="0">
				<tr>
					<td height="32" colspan="7" align="center"></td>
				</tr>
				<tr>
					<td width="6.5"></td>
					<td width="52" align="center">
						<br/><br/>
						<img src="../foto sibling/' . $this->rdata2[FOTO] . '" border="0" height="72" width="52"/><br/>
						<img src="../foto sibling/ttd/' . $this->rdata3[FOTO_TTD] . '" border="0" height="16" width="52"/>
					</td>
					<td width="8"></td>
					<td width="83.5">
						<table cellpadding="0" cellspacing="0" border="0" width="83.5" style="font-size:80%;">
							<tr>
								<td>
									<br/>
									<i>Nomor / Number</i>
									<br/>
									<b style="font-size:140%;">' . $this->rdata[ID_CARD] . '</b>
									<br/><br/>
									<i>Nama / Name</i>
									<br/>
									<b style="font-size:140%;">' . ucwords(strtolower($this->rdata[NM_SIBLING])) . '</b>
									<br/><br/>
									<i>Gelar & Jabatan /</i>
									<br/>
									<i>Title & Rank</i>
									<br/>
									<b style="font-size:120%;">' . $this->rdata2[PEKERJAAN] . '</b>
									<br/><br/>
									<i>Perwakilan / Mission</i>
									<br/>
									<b style="font-size:110%;">';
									if($this->root_kantor == '' || $this->rdata[ID_ROOT_KANTOR] == $this->rdata2[ID_KNT_PERWAKILAN])
									{
										$txt .= '' . $this->rdata2[NM_KNT_PERWAKILAN] . '';
									}
									else
									{
										$txt .= '' . $this->root_kantor . ' - ' . $this->rdata2[NM_KNT_PERWAKILAN] . '';
									}
									$txt .= '</b>
								</td>
							</tr>
						</table>
					</td>
					<td width="4"></td>
					<td width="78">
						<table cellpadding="0" cellspacing="0" border="0" height="" width="78" style="font-size:80%;">
							<tr>
								<td height="74">
									<img src="../images/'.$lingkaran.'" border="0" height="18" width="18"/>
									<br/>
									<i>Nomor & Jenis Paspor</i>
									<br/>
									<i>Number & Type of Passport</i>
									<br/>
									<b style="font-size:'. $font_size .'%;">' . $this->rdata2[NO_PASPOR] . ' / ' . $this->rdata2[JNS_PASPOR] . '</b>
									<br/><br/>
									<i>Masa Berlaku / Expiry date</i>
									<br/>
									<b style="font-size:140%;">' . $tanggal2 . '</b>
									<br/><br/>
									<i>Dikeluarkan pada / issued</i>
									<br/>
									<b style="font-size:130%;">' . $tanggal . '</b>
								</td>
							</tr>
							<tr>
								<table cellspacing="3" cellpadding="3" border="0" width="78" style="font-size:80%;">
									<tr>
										<td width="37"></td>
										<td width="34" align="center">
											<img width="32" height="32" src="'.$pngFilePath.'" />
										</td>
									</tr>
								</table>
							</tr>
						</table>
					</td>
					<td width="4"></td>
				</tr>
			</table>
			';
		} 
		else 
		{
			$txt = '
				<br/><br/><br/><br/><br/><br/>
				<table style="font-family:Courier New; font-size:90%;" cellpadding="0" cellspacing="0" width="240px" border="0">
				<tr>
					<td height="9" colspan="3" align="center"></td>
				</tr>
				<tr>
					<td width="68px" align=right>
						<img src="../foto sibling/' . $this->rdata2 [FOTO] . '" border="0" height="72" width="56"/><br/>
						<img src="../foto sibling//ttd/' . $this->rdata3 [FOTO_TTD] . '" border="0" height="16" width="56"/>
					</td>
					<td width="3px" align="center"></td>
					<td width="127px" >
						<table cellpadding="0" cellspacing="0" border="0"  bordercolor="#000000" >
							<tr>
								<td width="70px" height="17">Nomor<br/><b>' . $this->rdata [ID_CARD] . '</b></td>
								<td width="3px"></td>
								<td width="75px" align=center ><img src="../images/'.$lingkaran.'" border="0" height="18" width="18"/></td>
							</tr>
							<tr>
								<td width="77px" height="17">Nama<br/><b>' . ucwords ( strtolower ( $this->rdata [NM_SIBLING] ) ) . '</b></td>
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
								<td height="28" width="27px"></td>
							</tr>
							<tr>
								<td height="19" width="27px" align="left"><img width="34" height="34" src="'.$pngFilePath.'" /></td>
							</tr>

						</table>
					</td>

		 		</tr>
				</table>';
		}

		$this->printpassport($txt, $opsi_cetak);
	}
	public function printpassport($txt, $opsi_cetak)
	{
		if ($opsi_cetak == 'kartu' || $opsi_cetak == 'kartu_baru') {
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

		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Kementerian Luar Negeri Republik Indonesia');
		$this->pdf->SetTitle('ID CARD PRINT');
		$this->pdf->SetSubject('KEMENLU RI');
		$this->pdf->SetKeywords('id card, nationality');

		$this->pdf->setHeaderFont(Array(
				PDF_FONT_NAME_MAIN,
				'',
				PDF_FONT_SIZE_MAIN
		) );

		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		// $this->pdf->SetMargins ( '0', '0', '0' );
		// $this->pdf->SetMargins ( '0.22', '0', '0' ); //setting printer baru WFH
		$this->pdf->SetMargins('0.08', '0.08', '0'); //printer setting baru WFH
		$this->pdf->SetHeaderMargin(0);
		$this->pdf->SetFooterMargin(0);

		$this->pdf->setPrintFooter(false);

		$this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		if ($opsi_cetak == 'kartu_baru') {
			$this->pdf->SetFont('helvetica', '', 6);
		} else {
			$this->pdf->SetFont('helvetica', '', 5.6);
		}

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
		$this->style['position'] = 'C';

		$this->pdf->writeHTML($txt, true, 0, true, 0);

		$this->pdf->Text(50, 50, 'test', $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false );
		
		$this->pdf->SetDisplayMode(150, 'SinglePage', 'UseNone');
		$this->pdf->Output('card.pdf', 'I');
	}
}
?>
