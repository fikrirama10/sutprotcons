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
		$st_epox = 'ST_EPO_K'.$ii;
		$id_epox = 'ID_EPO'.$ii;
		echo $_POST[$st_epox];
		echo "<br>";
		$qwery = "update epo_diplomat set ST_EPO_K = ".$_POST[$st_epox]." where ID_EPO = ".$_POST[$id_epox];
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
