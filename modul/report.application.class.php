<?php
include_once("../config/dataAccess.class.php");
include_once("../config/eng.php");
include_once("../config/tcpdf.php");
class application
{
	public function application(){
		$this->report();
	}
	public function report()
	{
			$this->formattingprint();
	}
	public function formattingprint()
	{
			$application='
			<table width="100%">
			<tr>
				<td colspan="5" align="right" width="60%">
				</td>
				<td colspan="1" width="40%">
				<table width="370px">
				<tr>
					<td width="60px">&nbsp;</td>
					<td>
					<table border="1" width="210px" cellpadding="2">
					<tr>
						<td align="left"><font size="8px">Diplomatik</font></td>
						<td align="center"><font size="8px" align="center">Dinas</font></td>
						<td align="center"><font size="8px" align="center">Konsul Kehormatan</font></td>
					</tr>
					<tr>
						<td align="left"><font size="8px">No.ID Card</font></td>
						<td colspan=2 align="center"></td>
					</tr>
					<tr>
						<td align="left"><font size="8px">Tanggal</font></td>
						<td colspan=2 align="center"></td>
					</tr>
					<tr>
						<td align="left"><font size="8px">Berlaku</font></td>
						<td colspan=2 align="center"></td>
					</tr>
					</table>
					<table width="210px"><tr>
					<td colspan="3" align="center">						
					<font size="8px"><i>Directorate For Diplomatic Facilities Use Only</font></i>
					</td></tr></table>
					</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" colspan="6"><b><h3><u>APPLICATION FORM FOR ID CARD</h3></u></b></td>
			</tr>
			<tr>
				<td align="center" colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="1" width="80px">&nbsp;
				</td>
				<td colspan="1">
					<table cellpadding="1" cellspacing="2" width="10px" border="1">
						<tr>
							<td width="15px">&nbsp;</td>
							<td width="60px">NEW ID CARD</td>
						</tr>
					</table>
				</td>
				<td colspan="1" width="80px">&nbsp;
				</td>
				<td colspan="1">
					<table cellpadding="1" cellspacing="2" width="10px" border="1">
						<tr>
							<td width="15px">&nbsp;</td>
							<td width="80px">RENEWAL ID CARD</td>
						</tr>
					</table>
				</td>
				<td colspan="1" width="80px">&nbsp;
				</td>
				<td colspan="1">
					<table cellpadding="1" cellspacing="2" width="10px" border="1">
						<tr>
							<td width="15px">&nbsp;</td>
							<td width="46px">OTHERS</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td>1.  FULL NAME</td>
				<td colspan="5">
	:&nbsp;___________________________________________________________________________________________________________
	<br/>
	&nbsp;&nbsp;___________________________________________________________________________________________________________<br/>
				</td>
			</tr>
			<tr>
				<td>2.  SEX</td>
				<td colspan="5" valign="top">
				:&nbsp;<table width="200px"><tr><td><img src="../images/square.jpg" width="10px"/>&nbsp;MALE </td><td>&nbsp;<img src="../images/square.jpg" width="10px"/> FEMALE</td></tr></table>
					</td>
			</tr>
			<tr>
				<td>3.  PLACE OF BIRTH</td>
				<td colspan="5">
	:&nbsp;___________________________________________________________________________________________________________
				</td>
			</tr>
			<tr>
				<td>4.  DATE OF BIRTH</td>
				<td colspan="5">
:&nbsp;<u><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(dd/mm/yyyy)</i></u>
				</td>
			</tr>
			<tr>
				<td>5.  NATIONALITY</td>
				<td colspan="5">
	:&nbsp;___________________________________________________________________________________________________________
				</td>
			</tr>
			<tr>
				<td align="center" colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td>6.  CURRENT <br/>&nbsp;&nbsp;&nbsp;&nbsp;OCCUPATION</td>
				<td colspan="5" align="center">
				TITLE
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/square.jpg" width="10px"/> MEMBERS OF THE DIPLOMATIC STAFF</td>
				<td colspan="3" align="left">
	:&nbsp;________________________________________________________________
				</td>
			</tr>
			<tr>
				<td colspan="3" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/square.jpg" width="10px"/> MEMBERS OF THE CONSULAR STAFF</td>
				<td colspan="3" align="left">
	:&nbsp;________________________________________________________________
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/square.jpg" width="10px"/> MEMBERS OF THE INTERNATIONAL ORGANIZATION</td>
				<td colspan="3" align="left">
	:&nbsp;________________________________________________________________
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/square.jpg" width="10px"/> MEMBERS OF THE ADMINISTRATIVE AND TECHNICAL STAFF</td>
				<td colspan="3" align="left">
	:&nbsp;________________________________________________________________
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/square.jpg" width="10px"/> MEMBERS OF THE SERVICE STAFF</td>
				<td colspan="3" align="left">
	:&nbsp;________________________________________________________________
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/square.jpg" width="10px"/> PRIVATE SERVANT</td>
				<td colspan="3" align="left">
	:&nbsp;________________________________________________________________
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/square.jpg" width="10px"/> HONORARY CONSUL</td>
				<td colspan="3" align="left">
	:&nbsp;________________________________________________________________
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/square.jpg" width="10px"/> OTHER</td>
				<td colspan="3" align="left">
	:&nbsp;________________________________________________________________
				</td>
			</tr>
			<tr>
				<td align="center" colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td>7.  DATE OF ARRIVAL <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IN INDONESIA</td>
				<td colspan="5">
:&nbsp;<u><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(dd/mm/yyyy)</i></u>
				</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PASSPORT</td>
				<td colspan="5">
				</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.  TYPE</td>
				<td colspan="5" valign="top" align="left">				
				:&nbsp;<table width="400px"><tr><td>&nbsp;<img src="../images/square.jpg" width="10px"/>&nbsp;DIPLOMATIC </td><td>&nbsp;<img src="../images/square.jpg" width="10px"/> OFFICIAL</td><td>&nbsp;<img src="../images/square.jpg" width="10px"/> LESSER PASSER</td><td>&nbsp;<img src="../images/square.jpg" width="10px"/> ORDINARY</td></tr><tr><td colspan="4">&nbsp;<img src="../images/square.jpg" width="10px"/>OTHER : ______________________________________________</td></tr></table>

				</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.  NUMBER</td>
				<td colspan="5">:&nbsp;_________________________________________
				</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.  PLACE OF ISSUE</td>
				<td colspan="5">:&nbsp;_________________________________________
				</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.  DATE OF ISSUE</td>
				<td colspan="5"> :&nbsp;<u><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(dd/mm/yyyy)</i></u>
				</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.  DATE OF EXPIRY</td>
				<td colspan="5"> :&nbsp;<u><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(dd/mm/yyyy)</i></u>
				</td>
			</tr>
			<tr>
				<td>8.  OFFICE ADDRESS</td>
				<td colspan="5"width="100%">
	:&nbsp;___________________________________________________________________________________________________________
	<br/>
	&nbsp;&nbsp;___________________________________________________________________________________________________________
	<br/>
	&nbsp;&nbsp;___________________________________________________________________________________________________________
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="5">
	:&nbsp;PHONE  : _________________________________<br/>
				</td>
			</tr>
			<tr>
				<td>9.  HOME ADDRESS </td>
				<td colspan="5">
	:&nbsp;___________________________________________________________________________________________________________
	<br/>
	&nbsp;&nbsp;___________________________________________________________________________________________________________
	<br/>
	&nbsp;&nbsp;___________________________________________________________________________________________________________
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="5">
	&nbsp;&nbsp;PHONE  : _________________________________<br/>
				</td>
			</tr>
			<tr>
				<td align="right" colspan="6">
				<br/><br/><br/><br/>
				Date, ________________________________________<br/>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
				AUTHORIZATION,<br/>
				HEAD OF MISSION<br/><br/><br/><br/><br/>_____________________________
				</td>
				<td align="center" colspan="4">
				APPLICANT<br/><br/><br/><br/><br/><br/>_____________________________
				</td>
			</tr>
			<tr>
				<td align="center" colspan="6">&nbsp;
			</td>
			</tr>
			<tr>
				<td align="center" colspan="6">
				________________________________________________________________________________________________________________________________
			</td>
			</tr>
			<tr>
				<td align="left" colspan="6"><i>Directorate for Diplomatic Facilities Use Only</i></td>
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

		// set default header data
		$this->pdf->SetHeaderData('', '', 'DEPARTEMEN LUAR NEGERI REPUBLIK INDONESIA', 'SUBDIT.DAFIZ DIT.FASILITAS DIPLOMATIK ');

		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
//		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->pdf->SetMargins('15', '24', '15');
		$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		//set auto page breaks
		$this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		//$this->pdf->setLanguageArray($l);

		// ---------------------------------------------------------

		// set font
		$this->pdf->SetFont('times', '', 8);

		// add a page
		$this->pdf->AddPage();

		$this->pdf->writeHTML($txt, true, 0, true, 0);
		$this->pdf->SetDrawColor(50, 50, 50, 50);
		$this->pdf->SetFillColor(0, 0, 0, 0);
//		$this->pdf->Rect(x, y, w, h, 'DF');
		$this->pdf->Rect(30, 290, 30, 40, 'DF');
		$this->pdf->Rect(115, 300, 45, 20, 'DF');
		$this->pdf->SetTextColor(50, 50, 50, 50);
		$this->pdf->Text(38, 310, 'Photo 3 X 4');
		$this->pdf->Text(112, 324, 'The Signature of bearer should be in the box');

		// ---------------------------------------------------------

		//Close and output PDF document
		$this->pdf->Output('example_001.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+
	}
}
?>