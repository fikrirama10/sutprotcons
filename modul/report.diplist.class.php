<?php
// include_once("../config/dataAccess.class.php");
//include "../config/koneksi.php";

//include_once ("../config/eng.php");
//include_once ("../config/tcpdf.php");
//require_once(dirname(__FILE__)."/phpqrcode/qrlib.php");

?>
<?php
include "../config/koneksi.php";
header("Content-Type: application/vnd.ms-word");
header("Expires: 0");
header("margin: 2cm 1cm 2cm 1cm;");
header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
header("Content-disposition: attachment; filename=diplist.doc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style>
            @page
            {
                size: 14.5cm 21cm;  /* A5 */
                margin: 2cm 1cm 2cm 2cm;
            }
            @page WordSection1
            {
                mso-title-page: no;
                mso-paper-source:0;
                mso-header-margin: 0;
                mso-footer-margin: 0;
				mso-footer: f1;
            }
            p.MsoFooter, li.MsoFooter, div.WordSection1 {
                page:WordSection1;
                mso-header-margin: 0;
                mso-footer-margin: 0;
				mso-pagination:widow-orphan;
				tab-stops:center 2.3in right 3.0in;
				font-size:11.0pt;
            }
			td.end{
				border-bottom:2px solid black;
			}
			
        </style>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Permohonan Pajak</title>    
    </head>
    <body>
        <?php 
		$kelompok = $_POST ['id_kelompok'];
		if($kelompok==1){
		$sql = "SELECT * from v_dipsib_list where (AKHIR_CARD_SIB IS NOT NULL AND ID_DIPSIB IS NOT NULL) OR (AKHIR_CARD_SIB IS NULL AND ID_DIPSIB IS NULL) AND ID_CARD !='' and ID_CARD is not null and ID_JNS_PERWAKILAN != 5 and ID_JNS_PERWAKILAN != 1
		AND ID_NEGARA != 1
		ORDER BY NM_STATES, ID_NEGARA, ID_KNT_PERWAKILAN, RANK,TGL_TIBA,NM_DIPLOMAT  ASC";
		}
		$data = mysql_query ( $sql );
		$negara='';
		$negara2='';
		$kantor='';
		?>
        <div class="WordSection1">
            
			<?php
			while($rr=mysql_fetch_array($data)){				
				if($rr[ID_KNT_PERWAKILAN] != $kantor){ ?>	
				<br style="page-break-after: always">				
				<table style="font-family:Times New Roman; font-size:11pt;" cellpadding="0" cellspacing="0" width="100%" border="0">
						<?php if(substr($rr[NM_KNT_PERWAKILAN],0,17) == 'Konsulat Jenderal'){ ?>
							<tr>
							<td colspan="3" align="left"><b/>
							<?php echo strtoupper($rr[KANTOR]); ?>
							</td>
							</tr>	
						<?php }else{ ?>
							<tr>
							<td colspan="3" align="center"><b/>
							<?php echo strtoupper($rr[NM_STATES]); ?>
							</td>
							</tr><br/>
							<tr>
							<td colspan="3" align="center"><b/>
							<?php echo strtoupper($rr[KANTOR]); ?>
							</td>
							</tr>	
						<?php } ?>
				<?php if($rr[ID_JNS_PERWAKILAN] == 2){ ?>
						<tr>
						<td colspan="3" align="center"><b/>
						Credentials presented by the Ambassador<br/><b/><?php echo $rr[TGL_CREDENTIAL]; ?>
						</td>						
						</tr>	
						<tr>
						<td colspan="3" align="center"><b/>
						</td>						
						</tr>
				<?php } ?>
						<br/>
						<tr>
						<?php if(substr($rr[NM_KNT_PERWAKILAN],0,17) == 'Konsulat Jenderal'){ ?>
						<td width="70" valign="top">Office</td>
						<?php }else{ ?>
						<td width="70" valign="top">Chancery</td>
						<?php } ?>
						<td width="5" valign="top">:</td>
						<td width="217" valign="top"><?php echo nl2br($rr[ALAMAT]); ?></td>
						</tr>
						<tr>
						<td width="70"></td>
						<td width="5"></td>
						<td width="217">Phone: <?php echo $rr[TELP]; ?><br/>Fax: <?php echo $rr[FAX]; ?></td>
						</tr>
						<tr>
						<td width="70" valign="top">Office Hours</td>
						<td width="5" valign="top">:</td>
						<td width="217" valign="top"><?php echo $rr[OFFHOURS]; ?></td>
						</tr>
						<?php if(substr($rr[NM_KNT_PERWAKILAN],0,17) != 'Konsulat Jenderal'){ ?>
						<tr>
						<td width="70" valign="top">National Day</td>
						<td width="5" valign="top">:</td>
						<td width="217" valign="top"><?php $nd = $rr[KET_NATIONALDAY].', '; if($rr[KET_NATIONALDAY]!=''){echo $nd.$rr[NATIONALDAY];}else{echo $rr[NATIONALDAY];} ?></td>
						</tr>	
						<?php } ?>
						<tr>
						<td height="10" style="border-bottom:1pt solid black;" colspan="3" ></td>						
						</tr>	
						<tr>
						<td height="10" colspan="3" ></td>						
						</tr>						
				</table>
			<?php $kantor = $rr[ID_KNT_PERWAKILAN];}
			 $he='';
				if($rr[ID_RANK] == 1){$he='His Excellency<br/>';} ?>	
						<table style="font-family:Times New Roman; font-size:11pt;" cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
						<td valign="top" width="140"><?php echo $he.ucwords(strtolower($rr[NM_DIPLOMAT])) ?><br/><?php echo ucwords(strtolower($rr[NM_SIBLING])) ?></td>
						<td valign="top" width="110"><b><?php echo ucwords(strtolower($rr[OFFICIAL_NM])) ?><br/><?php echo ucwords(strtolower($rr[OFFICIAL_PEKERJAAN])) ?></b></td>
						<td valign="top" width="50"><?php echo $rr[TGL_TIBA] ?></td>
						</tr>
						<tr>
						<td height="3" colspan="3" >&nbsp;<br/></td>						
						</tr>
						</table> 
			<?php } ?>
			
        </div>
		<div style='mso-element:footer' id=f1>

		<p class=MsoFooter>
		<span style='mso-tab-count:1'></span><span style='mso-field-code:" PAGE "'></span>
		</p>
		</div>
    </body>
</html>
