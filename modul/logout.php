<link rel="shortcut icon" type="image/x-icon" href="../images/kemlu.ico">
<?php
  session_start();
  session_destroy();

  $template = file("../template/canvasawal.htm");
  $template = implode("",$template ); 

	$varname =  "<br> <center>Anda telah sukses keluar sistem <br> <a href=index.php><b>Login Kembali</b></a></center>";
	
	//$template = eregi_replace("{isi}",$varname,$template);
	$template = preg_replace("/{isi}/i",$varname,$template);
	echo $template;

// Apabila setelah logout langsung menuju halaman utama website, aktifkan baris di bawah ini:

//  header('location:http://www.alamatwebsite.com');
?>
