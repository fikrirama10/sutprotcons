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
$idt=$_GET[idt];
$neg=$_GET[negara];

if ($module=='upload_preseance' AND $act=='input'){
  $lokasi_file    = $_FILES['upload_preseance']['tmp_name'];
  $tipe_file      = $_FILES['upload_preseance']['type'];
  $nama_file      = $_FILES['upload_preseance']['name'];
  $acak           = rand(0000000,9999999);
	$nama_file_unik = $acak.".pdf";
	$TGL_UPLOAD 		= date('Y-m-d h:i:s');
	$AS_OF					= date('j F Y', strtotime($_POST['tanggal']));
	$nama_view			= "Order of Preseance as of ".$AS_OF.".pdf";

  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file != "application/pdf"){
  			$varname = "Gagal menyimpan data !!! <br>
              			Tipe file <b>$nama_file</b> : $tipe_file <br>
              			Tipe file yang diperbolehkan adalah : <b>PDF</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
  		//$template = eregi_replace("{isi}",$varname,$template);
				$template = preg_match("/{isi}/",$varname,$template);
  			echo $template;
  	  }else{
				$void = mysql_query("UPDATE tbl_data_preseance SET IS_AKTIF = 0 WHERE IS_AKTIF = 1");
				if ($void == 1){
	        move_uploaded_file($lokasi_file,"../diplist/$nama_file_unik");
	        $sql= "INSERT INTO tbl_data_preseance (NAMA,NAMA_FILE, TGl_UPLOAD, IS_AKTIF) VALUES ('$nama_view','$nama_file_unik','$TGL_UPLOAD','1')";

				 $input = mysql_query($sql);
			 }
     }
  }

	   header('location: ./deplu.php?module='.$module.'&negara='.$neg);


}
elseif ($module=='upload_preseance' AND $act=='hapus' AND isset($_GET[idt])){

  mysql_query("DELETE FROM tbl_data_preseance WHERE ID ='$_GET[idt]'");

  header('location: ./deplu.php?module='.$module.'&negara='.$neg);
}
elseif ($module=='preseance' AND $act=='update' AND isset($_POST[idt])){


}

  $lokasi_file    = $_FILES['upload_preseance']['tmp_name'];
  $tipe_file      = $_FILES['upload_preseance']['type'];
  $nama_file      = $_FILES['upload_preseance']['name'];
  $acak           = rand(000000,999999);
  $nama_file_unik = $acak.$nama_file;

	$TGL_UPLOAD = date('Y-m-d h:i:s');

	//Apabila file ganti
     if (!empty($lokasi_file)){

	 // Apabila tipe gambar 2 bukan pdf akan tampil peringatan
          if ($tipe_file != "pdf"){
            $varname =  "Gagal menyimpan data !!! <br>
                    		Tipe file <b>$nama_file</b> : $tipe_file <br>
                    		Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
        		$template = preg_match("/{isi}/",$varname,$template);
        		echo $template;
			}
			else {
            move_uploaded_file($lokasi_file,"../diplist/$nama_file_unik");
        	  mysql_query("update tbl_data_preseance set NAMA_FILE = $nama_file_unik,
        									TGl_UPLOAD = $TGL_UPLOAD,
        									IS_AKTIF = '1'
        									where ID ='$_POST[idt]'");

        	  header('location: ./deplu.php?module='.$module.'&negara='.$neg);
			}
	 }
	}
  //if session ok
?>
