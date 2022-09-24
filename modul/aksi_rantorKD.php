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


	$jumlahData = $_POST[jumlahData]; 
    $ii = 1;
	 while ($ii < $jumlahData){
		$st_permitx = 'ST_PERSETUJUAN'.$ii;
		$id_permitx = 'ID_PENGGUNAA_FAS'.$ii;
		echo $_POST[$st_permitx];
		echo "<br>";
		$qwery = "update penggunaan_fasilitas set ST_PERSETUJUAN = ".$_POST[$st_permitx]." where ID_PENGGUNAA_FAS = ".$_POST[$id_permitx];
		mysql_query($qwery);
		$ii =$ii+1;
	}


//============

echo "<html>
		<head></head>
			<body onload= self.history.back()>
			</body>
	  </html>";       
}
?>
