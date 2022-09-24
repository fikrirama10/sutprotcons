<?php
//session_start();

session_start();
$template = file("../template/canvasawal.htm");
$template = implode("",$template ); 

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){
	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{


include "../config/koneksi.php";
include "../config/library.php";

$module=$_GET[module];
$act=$_GET[act];
//$idt=$_GET[idt];
//print_r('sipp');exit;	
	$jumlahData = $_POST[jumlahData]; 
    $ii = 1;
	 while ($ii < $jumlahData){
		$st_permitx = 'ST_PERMIT_K'.$ii;
		$id_permitx = 'ID_PERMIT'.$ii;
		echo $_POST[$st_permitx];
		echo "<br>";
		$qwery = "update permit_diplomat set ST_PERMIT_K = ".$_POST[$st_permitx]." where ID_PERMIT = ".$_POST[$id_permitx];
		mysql_query($qwery);
		$ii =$ii+1;
	}
	//$NEGARA = $_POST[NEGARA];
	//$NEG_RANTOR_K = $_POST[NEG_RANTOR_K];
	//$NEG_RANTOR_I = $_POST[NEG_RANTOR_I];

//============

echo "<html>
		<head></head>
			<body onload= self.history.back()>
			</body>
	  </html>";       
}
?>
