<?php

switch($_GET[act]){

  default:

  echo "<h2>Ubah Password </h2> 
    <form method=POST action='./deplu.php?module=ubah_password&act=submit' enctype='multipart/form-data'>
          <table width=80%> 
		  <tr><th colspan = 2 ><div align=left>SIlahkan Masukkan Password Lama dan Baru Anda</div></th></tr>
		  <tr><td width='40%'  >Password Lama</td><td><input size='40' type='password' name='paswd_lama' ></td></tr>
		  <tr><td>Password Baru</td><td><input type='password' size='40' name='paswd_baru' ></td></tr>
		  <tr><td>Konfirmasi Password Baru</td><td><input size='40' type='password' name='paswd_baru_confirm' ></td></tr>	  
		  <tr><td></td><td><div align=left><input type=submit value=Submit> </div></td></tr>
		  </table></form>";



	break;
    case "submit":

session_start();

session_register("G_sql_lap");

$template = file("../template/canvasawal.htm");
$template = implode("",$template ); 

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){

	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";
	
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{

		$PASWD_LAMA = $_POST[paswd_lama];   
		$PASWD_BARU = $_POST[paswd_baru]; 	
		$PASWD_BARU_CFM = $_POST[paswd_baru_confirm]; 		
		if (empty($PASWD_BARU) and empty($PASWD_LAMA) and empty($PASWD_BARU_CFM)){
			echo "<h2>Ubah Password</h2>
					Isian Tidak Boleh Kosong.<br> Perubahan Password Gagal! <br><a href='?module=ubah_password&act=form'> Coba Lagi </a>
					<br><br>";	
		} elseif ($PASWD_BARU != $PASWD_BARU_CFM) {
			echo "<h2>Ubah Password</h2>
					Password Baru yang anda masukkan tidak sama <br>Perubahan Password Gagal! <br><a href='?module=ubah_password&act=form'> Coba Lagi </a>
					<br><br>";
		}else {
			$sql_cek = "select NM_USER from  tbl_user where NM_USER='".$_SESSION[G_namauser]."' and KT_SANDI='".md5($PASWD_LAMA)."'";
			$query_cek = mysql_query($sql_cek);
			if (mysql_num_rows($query_cek) == 1){
				$sql_update = "update tbl_user SET KT_SANDI = '".md5($PASWD_BARU)."' where NM_USER='".$_SESSION[G_namauser]."' and KT_SANDI='".md5($PASWD_LAMA)."'";
				$query_cek = mysql_query($sql_update);
				echo "<h2>Ubah Password</h2>
					Password anda berhasil diubah.<br>Perubahan Password Berhasil!<br><a href='logout.php'> Klik disini untuk mencoba password baru Anda. </a>
					<br><br>";								
			} else {
				echo "<h2>Ubah Password</h2>
					Password lama yang Anda masukkan tidak terdaftar.<br>Perubahan Password Gagal! <br><a href='?module=ubah_password&act=form'> Coba Lagi </a>
					<br><br>";
			}
			
		}
		
		//echo "<script languange='javascript'>alert('$PASWD_BARU');</script>";
		
    break;



}
		
}
?>
