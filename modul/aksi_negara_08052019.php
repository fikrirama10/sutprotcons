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
		

if ($module=='negara' AND $act=='input'){


  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(000000,999999);
  $nama_file_unik = $acak.$nama_file; 

 

    $negara = $_POST[negara];
	$KD_REGIONAL = $_POST[KD_REGIONAL];	
	$NM_REGIONAL = $_POST[NM_REGIONAL];
	
	if (isset($_POST[NEG_RANTOR_I]) and $_POST[NEG_RANTOR_I] != ''){
	$NEG_RANTOR = $_POST[NEG_RANTOR_I];} 
	else
	{$NEG_RANTOR = '0';}

	if (isset($_POST[NEG_RANTOR_K]) and $_POST[NEG_RANTOR_K] != ''){
	$NEG_FASILITAS = $_POST[NEG_RANTOR_K];} 
	else
	{$NEG_FASILITAS = '0';}

//Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
    if ($tipe_file != "image/gif"){
      
		$varname =  "Gagal menyimpan data !!! <br>
            Tipe file <b>$nama_file</b> : $tipe_file <br>
            Tipe file yang diperbolehkan adalah : <b>GIF</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
		$template = eregi_replace("{isi}",$varname,$template);
		echo $template;	
	}
    else{
      move_uploaded_file($lokasi_file,"../images/bendera/$nama_file_unik");
	  mysql_query("INSERT INTO m_negara  (NEGARA,BENDERA,NEG_RANTOR_I,NEG_RANTOR_K,KD_REGIONAL,NM_REGIONAL) values ('$negara','$nama_file_unik',$NEG_RANTOR_I,$NEG_RANTOR_K,'$KD_REGIONAL','$NM_REGIONAL')");

     	header('location: ./deplu.php?module='.$module);
	 }
  }
  else{
	    mysql_query("INSERT INTO m_negara  (NEGARA,BENDERA,NEG_RANTOR_I,NEG_RANTOR_K,KD_REGIONAL,NM_REGIONAL) values	('$negara','$nama_file_unik',$NEG_RANTOR_I,$NEG_RANTOR_K,'$KD_REGIONAL','$NM_REGIONAL')");
     	header('location: ./deplu.php?module='.$module);
	}
 


  
}
elseif ($module=='negara' AND $act=='hapus' AND isset($_GET[idt])){

  mysql_query("DELETE FROM m_negara WHERE ID_NEGARA = $_GET[idt]");
  header('location: ./deplu.php?module='.$module);
}
elseif ($module=='negara' AND $act=='update' AND isset($_POST[idt])){

	
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(000000,999999);
  $nama_file_unik = $acak.$nama_file; 
  
   $negara = $_POST[negara];
	$bendera = $acak.$nama_file;
	$NEG_RANTOR_K = $_POST[NEG_RANTOR_K];
	$NEG_RANTOR_I = $_POST[NEG_RANTOR_I];
	$KD_REGIONAL = $_POST[KD_REGIONAL];	
	$NM_REGIONAL = $_POST[NM_REGIONAL];

  // Apabila gambar tidak diganti
  if (empty($lokasi_file)){
	

	mysql_query("update m_negara set NEGARA = '$negara', 
									NEG_RANTOR_I = $NEG_RANTOR_I,
									NEG_RANTOR_K = $NEG_RANTOR_K,
									KD_REGIONAL = '$KD_REGIONAL',
									NM_REGIONAL = '$NM_REGIONAL'
									where ID_NEGARA= $_POST[idt] ");

	header('location: ./deplu.php?module='.$module);
  }
  else{
	// Apabila tipe gambar bukan jpeg akan tampil peringatan
			if ($tipe_file != "image/gif"){
				$varname =  "Gagal menyimpan data !!! <br>
					Tipe file <b>$nama_file</b> : $tipe_file <br>
					Tipe file yang diperbolehkan adalah : <b>GIF</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
				$template = eregi_replace("{isi}",$varname,$template);
				echo $template;
			 
			}
			else{
			move_uploaded_file($lokasi_file,"../images/bendera/$nama_file_unik");
		
			mysql_query("update m_negara set NEGARA = '$negara', 
											BENDERA = '$nama_file_unik',  
											NEG_RANTOR_I = $NEG_RANTOR_I,
											NEG_RANTOR_K = $NEG_RANTOR_K,
											KD_REGIONAL = '$KD_REGIONAL',
											NM_REGIONAL = '$NM_REGIONAL'
											where ID_NEGARA= $_POST[idt] ");


			header('location: ./deplu.php?module='.$module);

			}    
		}//end else
	}//end update	
}//end session

?>
