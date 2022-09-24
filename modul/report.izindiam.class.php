<?php
include_once("../config/dataAccess.class.php");
include_once("../config/eng.php");
include_once("../config/tcpdf.php");
class izindiam
{
	public function izindiam(){
		$this->report();
	}
	public function report()
	{
			$this->formattingprint();
	}
	public function formattingprint()
	{
			$application='
			<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td align="center">
					<b>DEPARTEMEN LUAR NEGERI<br/>
					<u>REPUBLIK INDONESIA</u> </b><br/><br/>
					DIREKTORAT KONSULER<br/>
					SEKSI PERIZINAN <br/><br/><br/>
					<p align="left">
					IZIN BERDIAM / PERPANJANGAN<br/>UNTUK WARGA NEGARA ASING
					</p><br/><br/>
				</td>
				<td width="100px">
				</td>
				<td align="left" valign="top" width="300px">
					DIPLOMATIK / DINAS<br/>
					<table width="260px">
					<tr><td>IZIN BERDIAM NO</td><td>: ................................................</td></tr>
					<tr><td>BERLAKU s/d.</td><td>: ................................................</td></tr>
					<tr><td>T A N G G A L</td><td>:................................................</td></tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="left"><font size="6px"><u>NAMA </u></font></td>
				<td align="left" valign="top" colspan="2" width="400px">:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left">
					<font size="6px">NAME OF APPLICANT (SURENAME - CHRISTIAN)</font><br/>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">&nbsp;</td>
			</tr>
			<tr>
				<td align="left"><font size="6px"><u>TEMPAT DAN TANGGAL LAHIR </u></font>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left"><font size="6px">NATIONALITY</font><br/>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">&nbsp;<br/></td>
			</tr>
			<tr>
				<td align="left"><font size="6px"><u>PEKERJAAN</u></font></td>
				<td align="left" valign="top" colspan="2" width="400px">
				:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left"><font size="6px">OCCUPATION</font><br/>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">&nbsp;<br/></td>
			</tr>
			<tr>
				<td align="left"><font size="6px"><u>PASSPOR DIPLOMATIK / DINAS / BIASA No.</u></font></td>
				<td align="left" valign="top" colspan="2" width="400px">
				:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left"><font size="6px">DIPLOMATIC / SERVICE / REGULAR PASSPORT No.</font><br/>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">&nbsp;<br/></td>
			</tr>
			<tr>
				<td align="left"><font size="6px"><u>DIBERIKAN OLEH , DIMANA DAN TANGGAL</u></font></td>
				<td align="left" valign="top" colspan="2" width="400px">
				:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left"><font size="6px">ISSUED BY, PLACE AND DATE</font><br/>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">&nbsp;<br/></td>
			</tr>
			<tr>
				<td align="left"><font size="6px"><u>BERLAKU SAMPAI</u></font></td>
				<td align="left" valign="top" colspan="2" width="400px">
				:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left"><font size="6px">VALID UNTIL</font><br/>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">&nbsp;<br/></td>
			</tr>
			<tr>
					<td align="left"><font size="6px"><u>ALAMAT DI LUAR NEGERI</u></font></td>
				<td align="left" valign="top" colspan="2" width="400px">
				:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left"><font size="6px">PERMANENT ADDRESS</font><br/>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">&nbsp;<br/></td>
			</tr>
			<tr>
				<td align="left"><font size="6px"><u>ALAMAT DI INDONESIA</u></font></td>
				<td align="left" valign="top" colspan="2" width="400px">
				:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left"><font size="6px">ADDRESS IN INDONESIA</font><br/>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">&nbsp;<br/></td>
			</tr>
			<tr>
				<td align="left"><font size="6px"><u>NEGERI YANG DITUJU</u></font></td>
				<td align="left" valign="top" colspan="2" width="400px">
				:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left"><font size="6px"><u>KELUARGA YANG DIBAWA</u></font></td>
				<td align="left" valign="top" colspan="2" width="400px">
				:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left"><font size="6px">ACCOMPANYING FAMILY</font><br/>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">&nbsp;<br/></td>
			</tr>
			<tr>
				<td align="left"><font size="6px"><u>VISA DIPLOMATIK / DINAS / KEHORMATAN NO.</u></font></td>
				<td align="left" valign="top" colspan="2" width="400px">
				:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left"><font size="6px">DIPLOMATIC / OFFICIAL / COURTESY VISA NO.</font><br/>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">&nbsp;<br/></td>
			</tr>
			<tr>
				<td align="left"><font size="6px"><u>VISA DIKELUARKAN OLEH, DIMANA DAN TGL.</u></font></td>
				<td align="left" valign="top" colspan="2" width="400px">
				:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left"><font size="6px">ENTRY VISA ISSUED BY , PLACE AND DATE</font><br/>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">&nbsp;<br/></td>
			</tr>
			<tr>
				<td align="left"><font size="6px"><u>LAMANYA BERDIAM DI INDONESIA MENURUT VISA.</u></font></td>
				<td align="left" valign="top" colspan="2" width="400px">
				:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left"><font size="6px">LENGTH OF STAY IN INDONESIA ACCORDING TO VISA</font><br/>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">&nbsp;<br/></td>
			</tr>
			<tr>
				<td align="left"><font size="6px"><u>KEDATANGAN DI INDONESIA DENGAN APA DAN TGL.</u></font></td>
				<td align="left" valign="top" colspan="2" width="400px">
				:&nbsp;................................................................................................................................................................................</td>
			</tr>
			<tr>
				<td align="left"><font size="6px">ARRIVAL IN INDONESIA BY AND DATE</font><br/>
				</td>
				<td align="left" valign="top" colspan="2" width="400px">&nbsp;<br/></td>
			</tr>
			<tr>
				<td align="left"><font size="6px">&nbsp;</font><br/>
				</td>
				<td align="center" valign="top" colspan="2" width="400px">&nbsp;<br/>
				<p align="left">Jakarta , _____________________________________________________</p>
				SIGNATURE<br/>
				<br/><br/><br/><br/><br/>
				( ......................................................... )
				</td>
			</tr>
			</table>
			';
		$this->printpassport($application);
	}
	public function printpassport($txt)
	{
		$this->pdf = new TCPDF('P', PDF_UNIT, 'LEGAL', true, 'UTF-8', false);
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('michaelbzone');
		$this->pdf->SetTitle('PASSPORT DOCUMENT PRINT');
		$this->pdf->SetSubject('deplu RI');
		$this->pdf->SetKeywords('passport, nationality, michaelbzone, michael, butar butar');
		// remove default header/footer
		$this->pdf->setPrintHeader(false);
		$this->pdf->setPrintFooter(false);

		$this->pdf->SetMargins('15', '24', '15');

		// set font
		$this->pdf->SetFont('times', '', 8);

		// add a page
		$this->pdf->AddPage();

		$this->pdf->writeHTML($txt, true, 0, true, 0);

		// ---------------------------------------------------------

		//Close and output PDF document
		$this->pdf->Output('example_001.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+
	}
}
?>