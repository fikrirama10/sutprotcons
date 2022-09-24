<?php

include_once("../config/dataAccess.class.php");
include_once("../config/eng.php");
include_once("../config/tcpdf.php");
class logizin
{
	public function logizin(){
		$this->report();
	}
	public function report()
	{
			$this->formattingprint();
	}
	public function formattingprint()
	{
			$application='
			<table width="100%" cellspacing="1">
			<tr>
				<td align="center">
					<b>DEPARTEMEN LUAR NEGERI<br/>
					<u>REPUBLIK INDONESIA</u> <br/></b>
				</td>
				<td width="230px">&nbsp;
				</td>
				<td align="left" valign="top">
					<b>SUBDIT. PERIZINAN DIT.KONSULER</b>
				</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
				<table width="400px">
				<tr>
					<td width="100px">NOMOR</td>
					<td width="300px">: ...............................................................................................................................................</td>
				</tr>
				<tr>
					<td width="100px">NAMA</td>
					<td width="300px">: ...............................................................................................................................................</td>
				</tr>
				<tr>
					<td width="100px">DITERIMA TANGGAL</td>
					<td width="300px">: ...............................................................................................................................................</td>
				</tr>
				</table>
				<br/>
			</td>
			<td>
			PARAF PETUGAS<br/>
			<br/>
			..................................................
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			<b><u>PENYELESAIAN</u></b>
			</td>
			<td>
			<b><u>CATATAN PETUGAS :</u></b>
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			1.&nbsp;&nbsp;SURAT PENGANTAR INSTANSI / PERWAKILAN 3 x ................................................................................................
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			2.&nbsp;&nbsp;SURAT SETKAB / STEMPEL dsb ....................................................................................................................................
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			3.&nbsp;&nbsp;SURAT DEP. TENAGA KERJA ........................................................................................................................................
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			4.&nbsp;&nbsp;FORMULIR PERMOHONAN IB / PIB 3 x .......................................................................................................................
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			5.&nbsp;&nbsp;FORMULIR PERMOHONAN M.E.R.P / SINGLE ERP 3 x .............................................................................................
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			6.&nbsp;&nbsp;DIKETAHUI DIT.FASDIP .................................................................................................................................................
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			7.&nbsp;&nbsp;SURAT - SURAT LAIN .....................................................................................................................................................
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			8.&nbsp;&nbsp;PAS FOTO PEMOHON (BAGI ORANG BARU) .............................................................................................................
			<br/></td>
			<td>
			&nbsp;<br/>
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			<b><u>PERMINTAAN</u></b>
			</td>
			<td>
			<b><u>PARAF KASI :</u></b>
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			1.&nbsp;&nbsp;STAY PERMIT UNTUK ...................................................................................................................................... bln / thn
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			2.&nbsp;&nbsp;PERPANJANGAN STAY PERMIT s/d ............................................................................................................... bln / thn
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			3.&nbsp;&nbsp;MULTIPLE / SINGLE EXIT REENTRY ............................................................................................................ bln / thn
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			4.&nbsp;&nbsp;EXIT PERMIT UNTUK ......................................................................................................................................................
			<br/></td>
			<td>
			&nbsp;<br/>
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			<b><u>PENELITIAN KASUBDIT</u></b>
			</td>
			<td>
			<b><u>PARAF KASUBDIT :</u></b>
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			1.&nbsp;&nbsp;UNTUK PERTIMBANGAN DIR. KONSULER ...............................................................................................................
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			2.&nbsp;&nbsp;UNTUK DILAKSANAKAN SEPERTI DIATAS .............................................................................................................
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			3.&nbsp;&nbsp;CATATAN LAIN-LAIN ....................................................................................................................................................<br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;..............................................................................................................................................................................................			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;..............................................................................................................................................................................................			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;..............................................................................................................................................................................................			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;..............................................................................................................................................................................................			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;..............................................................................................................................................................................................			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;..............................................................................................................................................................................................<br/>			
			</td>
			<td>
			&nbsp;<br/>	
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			<b><u>DISPOSISI DIREKTUR KONSULER :</u></b>
			</td>
			<td>
			<b><u>PARAF DIREKTUR :</u></b>
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			1.&nbsp;&nbsp;UNTUK DILAKSANAKAN SEPERTI DI ATAS ............................................................................................................
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			2.&nbsp;&nbsp;UNTUK DIMINTAKAN PENDAPAT DITJEN HUBSOSBUDPEN ...............................................................................
			</td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="2" width="405px">
			3.&nbsp;&nbsp;CATATAN LAIN-LAIN ....................................................................................................................................................<br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;..............................................................................................................................................................................................			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;..............................................................................................................................................................................................			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;..............................................................................................................................................................................................			
			<br/></td>
			<td>
			&nbsp;
			</td>
			</tr>
			<tr>
			<td colspan="3">
			<br/>
			</td>
			</tr>
			<tr>
			<td colspan="3" align="right">
			JAKARTA, ......................................................................................
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