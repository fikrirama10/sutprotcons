<?php

include "../config/koneksi.php";
$usnm = mysqli_real_escape_string($link,$_POST['username']);
$pass = mysqli_real_escape_string($link,md5($_POST['password']));
$login = mysqli_query($link,"SELECT * FROM v_user WHERE id_user='$usnm' AND kt_sandi='$pass'");
$ketemu=mysqli_num_rows($link,$login);
$r=mysqli_fetch_array($login);


	$template = file("../template/canvasawal.htm");
	$template = implode("",$template );
// Apabila username dan password ditemukan
if ($ketemu > 0){


	if ($r[ST_USER] == 1){
	  session_start();
	  //session_register("G_iduser");
	  //session_register("G_namauser");
	  //session_register("G_leveluser");

	  $_SESSION[G_iduser] = $r[ID_USER];
	  $_SESSION[G_namauser] = $r[NM_USER];
	  $_SESSION[G_leveluser]= $r[ID_GRUP];
	  $_SESSION[G_idpwk]= $r[ID_PERWAKILAN];
	  $_SESSION[G_idnegara]= $r[id_negara];
	  //header('location:media.php?module=home');
		if ($r[ID_GRUP]==15){
			header('Location: ./deplu.php?module=pengumuman');
		} else {
			header('Location: ./deplu.php?module=home');
		}
  	}
	else{
	  	$varname =  "<link href=../config/adminstyle.css rel=stylesheet type=text/css>"."<center>Login gagal! username tidak aktif. Hubungi administrator sistem anda.<br><br>"."<a href=../index.php><b>ULANGI LAGI</b></a></center>";
		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_replace("/{isi}/i",$varname,$template);
		echo $template;
	}
}
else{

  	$varname =  "<link href=../config/adminstyle.css rel=stylesheet type=text/css>"."<center>Login gagal! username & password tidak benar<br><br>". "<a href=../index.php><b>ULANGI LAGI</b></a></center>";
	//$template = eregi_replace("{isi}",$varname,$template);
	$template = preg_replace("/{isi}/i",$varname,$template);
	echo $template;
}
?>
