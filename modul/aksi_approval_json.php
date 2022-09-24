<?php
//session_start();

session_start();
//$template = file("../template/canvasawal.htm");
//$template = implode("",$template ); 

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){
	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{
 
include "../config/koneksi.php";
include "../config/library.php";
	//Diplomat
	//$a = "select distinct NO_DAFTAR, NM_DIPLOMAT,TGL_AWAL_PERMIT, TGL_AKHIR_PERMIT,NO_IZIN_PERMIT, NM_JNS_PERMIT, EMAIL_EMBASSY from v_stay_permit where ID_PERMIT =  $_POST['id']";
	//$b = mysql_query($a);
	//$c = mysql_fetch_array($b);
	
	//Sibling
	//$d = "select distinct NO_DAFTAR, NM_DIPLOMAT,TGL_AWAL_PERMIT, TGL_AKHIR_PERMIT,NO_IZIN_PERMIT, NM_JNS_PERMIT, EMAIL_EMBASSY from v_stay_permit_sib where ID_PERMIT_S = $_POST['id']";
	//$e = mysql_query($d);
	//$f = mysql_fetch_array($e);
	
if ($_POST['jns_permit']==1) {
	if ($_POST['jns_approval']=='D'){
	$qwery = "update permit_diplomat set ST_PERMIT = ".$_POST['status']." where ID_PERMIT = ".$_POST['id'];
	} 
	if ($_POST['jns_approval']=='K'){
		if ($_POST['status']=='0') {
			//$inject=", ST_PERMIT=".$_POST['status'].", KD_WORKFLOW= 1";
			$inject=", ST_PERMIT=".$_POST['status'];
			//sendemail_Diplomat($c['NO_DAFTAR'],$c['NM_DIPLOMAT'],$c['TGL_AWAL_PERMIT'],$c['TGL_AKHIR_PERMIT'],$c['NO_IZIN_PERMIT'],$c['NM_JNS_PERMIT'],$c['EMAIL_EMBASSY'],1,0);
		}
		if ($_POST['status']=='2') {
			$arrRet= get_noijinagendatglawalakhir($_POST['id'], 1);
			//$inject=$inject.", KD_WORKFLOW= 5, NO_AGENDA='".$arrRet['NO_AGENDA']."', TGL_AGENDA='".$arrRet['TGL_AGENDA']."', NO_IZIN_PERMIT='".$arrRet['NO_IZIN_PERMIT']."', TGL_AWAL_PERMIT='".$arrRet['TGL_AWAL_PERMIT']."', TGL_AKHIR_PERMIT='".$arrRet['TGL_AKHIR_PERMIT']."'";
			$inject=$inject.", NO_AGENDA='".$arrRet['NO_AGENDA']."', TGL_AGENDA='".$arrRet['TGL_AGENDA']."', NO_IZIN_PERMIT='".$arrRet['NO_IZIN_PERMIT']."'";
			//sendemail_Diplomat($c['NO_DAFTAR'],$c['NM_DIPLOMAT'],$c['TGL_AWAL_PERMIT'],$c['TGL_AKHIR_PERMIT'],$c['NO_IZIN_PERMIT'],$c['NM_JNS_PERMIT'],$c['EMAIL_EMBASSY'],5,2);
		
		}
		
	$qwery = "update permit_diplomat set ST_PERMIT_K = ".$_POST['status']." $inject where ID_PERMIT = ".$_POST['id'];
	} 
	if ($_POST['jns_approval']=='Kas'){
		if ($_POST['status']=='0') {
			//$inject=",ST_PERMIT=".$_POST['status'].", ST_PERMIT_K=".$_POST['status'].", KD_WORKFLOW= 1";
			$inject=",ST_PERMIT=".$_POST['status'].", ST_PERMIT_K=".$_POST['status'];
			//sendemail_Diplomat($c['NO_DAFTAR'],$c['NM_DIPLOMAT'],$c['TGL_AWAL_PERMIT'],$c['TGL_AKHIR_PERMIT'],$c['NO_IZIN_PERMIT'],$c['NM_JNS_PERMIT'],$c['EMAIL_EMBASSY'],1,0);
		
		}
		
		if ($_POST['status']=='2') {
			//$inject=$inject.", KD_WORKFLOW= 4";
			//sendemail_Diplomat($c['NO_DAFTAR'],$c['NM_DIPLOMAT'],$c['TGL_AWAL_PERMIT'],$c['TGL_AKHIR_PERMIT'],$c['NO_IZIN_PERMIT'],$c['NM_JNS_PERMIT'],$c['EMAIL_EMBASSY'],4,2);
		
		}
		
	$qwery = "update permit_diplomat set ST_PERMIT_KAS = ".$_POST['status']." $inject where ID_PERMIT = ".$_POST['id'];
	}
}

if ($_POST['jns_permit']==2) {
	if ($_POST['jns_approval']=='D'){
	$qwery = "update permit_sibling set ST_PERMIT = ".$_POST['status']." where ID_PERMIT_S = ".$_POST['id'];
	} 
	if ($_POST['jns_approval']=='K'){
		if ($_POST['status']=='0') {
			//$inject=", ST_PERMIT=".$_POST['status'].", KD_WORKFLOW= 1";
			$inject=", ST_PERMIT=".$_POST['status'];
			//sendemail_Sibling($f['NO_DAFTAR'],$f['NM_DIPLOMAT'],$f['TGL_AWAL_PERMIT'],$f['TGL_AKHIR_PERMIT'],$f['NO_IZIN_PERMIT'],$f['NM_JNS_PERMIT'],$f['EMAIL_EMBASSY'],1,0);
		
		}
		
		if ($_POST['status']=='2') {
			$arrRet= get_noijinagendatglawalakhir($_POST['id'], 2);
			//$inject=$inject.", KD_WORKFLOW= 5, NO_AGENDA='".$arrRet['NO_AGENDA']."', TGL_AGENDA='".$arrRet['TGL_AGENDA']."', NO_IZIN_PERMIT='".$arrRet['NO_IZIN_PERMIT']."', TGL_AWAL_PERMIT='".$arrRet['TGL_AWAL_PERMIT']."', TGL_AKHIR_PERMIT='".$arrRet['TGL_AKHIR_PERMIT']."'";
			$inject=$inject.", NO_AGENDA='".$arrRet['NO_AGENDA']."', TGL_AGENDA='".$arrRet['TGL_AGENDA']."', NO_IZIN_PERMIT='".$arrRet['NO_IZIN_PERMIT']."'";
			//sendemail_Sibling($f['NO_DAFTAR'],$f['NM_DIPLOMAT'],$f['TGL_AWAL_PERMIT'],$f['TGL_AKHIR_PERMIT'],$f['NO_IZIN_PERMIT'],$f['NM_JNS_PERMIT'],$f['EMAIL_EMBASSY'],5,2);
		
		}	
		
	$qwery = "update permit_sibling set ST_PERMIT_K = ".$_POST['status']." $inject where ID_PERMIT_S = ".$_POST['id'];
	} 
	if ($_POST['jns_approval']=='Kas'){
		if ($_POST['status']=='0') {
			//$inject=",ST_PERMIT=".$_POST['status'].", ST_PERMIT_K=".$_POST['status'].", KD_WORKFLOW= 1";
			$inject=",ST_PERMIT=".$_POST['status'].", ST_PERMIT_K=".$_POST['status'];
			//sendemail_Sibling($f['NO_DAFTAR'],$f['NM_DIPLOMAT'],$f['TGL_AWAL_PERMIT'],$f['TGL_AKHIR_PERMIT'],$f['NO_IZIN_PERMIT'],$f['NM_JNS_PERMIT'],$f['EMAIL_EMBASSY'],1,0);
		
		}
		
		if ($_POST['status']=='2') {
			//$inject=$inject.", KD_WORKFLOW= 4";
			//sendemail_Sibling($f['NO_DAFTAR'],$f['NM_DIPLOMAT'],$f['TGL_AWAL_PERMIT'],$f['TGL_AKHIR_PERMIT'],$f['NO_IZIN_PERMIT'],$f['NM_JNS_PERMIT'],$f['EMAIL_EMBASSY'],4,2);
		
		}
		
		
	$qwery = "update permit_sibling set ST_PERMIT_KAS = ".$_POST['status']." $inject where ID_PERMIT_S = ".$_POST['id'];
	}
}

if ($_POST['jns_permit']==3) {
	if ($_POST['jns_approval']=='D'){
	$qwery = "update cetak_kartu_diplomat set ST_KARTU = ".$_POST['status']." where ID_CETAK = ".$_POST['id'];
	} 
	if ($_POST['jns_approval']=='K'){
		if ($_POST['status']=='0') {
			$inject=", ST_KARTU=".$_POST['status'];
			//sendemail_Diplomat($c['NO_DAFTAR'],$c['NM_DIPLOMAT'],$c['TGL_AWAL_PERMIT'],$c['TGL_AKHIR_PERMIT'],$c['NO_IZIN_PERMIT'],$c['NM_JNS_PERMIT'],$c['EMAIL_EMBASSY'],1,0);
		
		}
	$qwery = "update cetak_kartu_diplomat set ST_KARTU_K = ".$_POST['status']." $inject where ID_CETAK = ".$_POST['id'];
	} 
	if ($_POST['jns_approval']=='Kas'){
		if ($_POST['status']=='0') {
			$inject=",ST_KARTU=".$_POST['status'].", ST_KARTU_K=".$_POST['status'];
			//sendemail_Diplomat($c['NO_DAFTAR'],$c['NM_DIPLOMAT'],$c['TGL_AWAL_PERMIT'],$c['TGL_AKHIR_PERMIT'],$c['NO_IZIN_PERMIT'],$c['NM_JNS_PERMIT'],$c['EMAIL_EMBASSY'],1,0);
		
		}
	$qwery = "update cetak_kartu_diplomat set ST_KARTU_KAS = ".$_POST['status']." $inject where ID_CETAK = ".$_POST['id'];
	}
}

if ($_POST['jns_permit']==4) {
	if ($_POST['jns_approval']=='D'){
	$qwery = "update cetak_kartu_sibling set ST_KARTU = ".$_POST['status']." where ID_CETAK_S = ".$_POST['id'];
	} 
	if ($_POST['jns_approval']=='K'){
		if ($_POST['status']=='0') {
			$inject=", ST_KARTU=".$_POST['status'];
			//sendemail_Sibling($f['NO_DAFTAR'],$f['NM_DIPLOMAT'],$f['TGL_AWAL_PERMIT'],$f['TGL_AKHIR_PERMIT'],$f['NO_IZIN_PERMIT'],$f['NM_JNS_PERMIT'],$f['EMAIL_EMBASSY'],5,0);
		
		}
	$qwery = "update cetak_kartu_sibling set ST_KARTU_K = ".$_POST['status']." $inject where ID_CETAK_S = ".$_POST['id'];
	} 
	if ($_POST['jns_approval']=='Kas'){
		if ($_POST['status']=='0') {
			$inject=",ST_KARTU=".$_POST['status'].", ST_KARTU_K=".$_POST['status'];
			//sendemail_Sibling($f['NO_DAFTAR'],$f['NM_DIPLOMAT'],$f['TGL_AWAL_PERMIT'],$f['TGL_AKHIR_PERMIT'],$f['NO_IZIN_PERMIT'],$f['NM_JNS_PERMIT'],$f['EMAIL_EMBASSY'],5,0);
		
		}
	$qwery = "update cetak_kartu_sibling set ST_KARTU_KAS = ".$_POST['status']." $inject where ID_CETAK_S = ".$_POST['id'];
	}
}
 //echo $qwery;
mysql_query($qwery);
		
/*$module=$_GET[module];
$act=$_GET[act];
//$idt=$_GET[idt];
	
	$jumlahData = $_POST[jumlahData]; 
    $ii = 1;
	 while ($ii < $jumlahData){
		$st_permitx = 'ST_PERMIT'.$ii;
		$id_permitx = 'ID_PERMIT'.$ii;
		echo $_POST[$st_permitx];
		echo "<br>";
		$qwery = "update permit_diplomat set ST_PERMIT = ".$_POST[$st_permitx]." where ID_PERMIT = ".$_POST[$id_permitx];
		mysql_query($qwery);
		$ii =$ii+1;
	}
 //============
*/
/*echo "<html>
		<head></head>
			<body onload= self.history.back()>
			</body>
	  </html>";       
*/
}
?>
