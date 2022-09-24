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
		$st_permitx = 'ST_KARTU'.$ii;
		$id_permitx = 'ID_CETAK_S'.$ii;
		echo $_POST[$st_permitx];
		echo "<br>";
		$qwery = "update cetak_kartu_sibling set ST_KARTU = ".$_POST[$st_permitx]." where ID_CETAK_S = ".$_POST[$id_permitx];
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
