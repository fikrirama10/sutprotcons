<?php
//session_start();

session_start();

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){
	$template = file("../template/canvasawal.htm");
	$template = implode("",$template ); 

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
$template = file("../template/canvasDeplu.htm");
$template = implode("",$template ); 

if ($module=='indeksvisa' AND $act=='input'){

$pwk_ri 		= $_SESSION[G_idpwk];	
//$no_konsep 		= $_POST[no_konsep];
$tgl_otvis 		= $_POST[tgl_otvis];
//$nobrafaks_otvis= $_POST[nobrafaks_otvis];
//$nama_otvis 	= $_POST[nama_otvis];
$nama_otvis 	= str_replace("'","''",$_POST[nama_otvis]);
//$foto_otvis 	= $_POST[foto_upload];
$paspor_otvis 	= $_POST[paspor_otvis];
//$fotopaspor_otvis 	= $_POST[foto_paspor_upload];
$anggota_family = $_POST[anggota_fam];
//print_r($anggota_family);exit;
$wn_otvis = $_POST[kewarganegaraan_otvis];
$jns_paspor 	= $_POST[id_tipe_paspor];
$tujuan_otvis 	= $_POST[tujuan_otvis];
$posisi_otvis 	= $_POST[posisi];
$pengganti_otvis= $_POST[pengganti];
$tipevisa_otvis = $_POST[tipevisa_otvis];
$indeksvisa_otvis = $_POST[indeksvisa_otvis];
$masa_awal_tugas = $_POST[masa_awal_tugas];
$masa_akhir_tugas = $_POST[masa_akhir_tugas];
$tempattugas_otvis = $_POST[tempattugas_otvis];
$dmv 			 = $_POST[dasar_mintavisa];
$dbv 			 = $_POST[dasar_berivisa];
$verifikator	 = $_POST[verifikator];
$jab_ver		 = $_POST[jbt_ver];
$legalisator	 = $_POST[legalisator];
$jab_legal		 = $_POST[jbt_legal];

$keppri	 		 = $_POST[keppri];
$jbt_keppri		 = $_POST[jbt_keppri];
$pjbt_konsuler	 = $_POST[pjbt_konsuler];
$jbt_konsuler	 = $_POST[jbt_konsuler];

$catatan		 = $_POST[catatan_otvis];
$no_notadiplo	 = $_POST[no_nota_diplomatik];

$created_date	 = date('Y-m-d h:m:s');
$created_by	 	 = $_SESSION[G_idpwk];
$TGL_AKHIR_PERMIT = '2016-05-05';
$TGL_AWAL_PERMIT  = '2016-05-01';
$status_mhn		 = 3;//$_POST[ID_JNS_KEPUTUSAN];
//$st_akhir		 = 3;

		/* $tampilbaru=mysql_query("SELECT * FROM tbl_trans_otvis");
         $apes = mysql_fetch_array($tampilbaru);  
		if($apes)
		{
			$sql_listvisa1 = "SELECT * from tbl_trans_otvis order by id desc limit 1";
			$tampilvisa1= mysql_query($sql_listvisa1);
			$listvisa1  = mysql_fetch_array($tampilvisa1);
			//print_r($listvisa1);exit;
			$n1 = $listvisa1[id]+1;
			$n2 = str_pad($n1, 7, 0, STR_PAD_LEFT);
			//echo "OTVIS/$n2/KEMLU/".date('m')."/".date('Y');
			$no_konsep = "OTVIS/$n2/KEMLU/".date('m')."/".date('Y');
			//echo "<input name='no_konsep' value='$n3' type='hidden'>";
			
		}
		else
		{
			$n2 = str_pad(1, 7, 0, STR_PAD_LEFT);
			$no_konsep = "OTVIS/$n2/KEMLU/".date('m')."/".date('Y');
			//echo "<input name='no_konsep' value='OTVIS/$n2/KEMLU/".date('m')."/".date('Y')."' type='hidden'>";
		}

		else */
		
			$pwk_s = $_SESSION['G_idpwk'];
			$sql_pwk=mysql_query("SELECT * FROM tbl_trans_otvis where pwk_ri = $pwk_s");
			 $query_pwk = mysql_fetch_array($sql_pwk);
			 if($query_pwk)
			 {
				$sql_getlastid = "SELECT a.*,b.trigram from tbl_trans_otvis a left join tbl_perwakilan b on a.pwk_ri = b.id_perwakilan where a.pwk_ri=$pwk_s order by id desc limit 1";
				$tampillastid= mysql_query($sql_getlastid);
				$listlastid  = mysql_fetch_array($tampillastid);
				//print_r($listvisa1);exit;
				//$n1 = $listlastid[id]+1;
				$n1 = explode("/", $listlastid[no_konsep_pwk]);
				$n1_1 = $n1[0]+1;
				//$n1_2 = $n1[1];
				$n2 = str_pad($n1_1, 7, 0, STR_PAD_LEFT);
				
				$no_konsep = "$n2/R/$listlastid[trigram]/".date('m')."/".date('Y');
				//print_r($no_konsep);exit;
			 }
			 else
			 {
				$sql_getlastid = "SELECT * from tbl_perwakilan where id_perwakilan = $pwk_s";
				$tampillastid= mysql_query($sql_getlastid);
				$listlastid  = mysql_fetch_array($tampillastid);
				$n2 = str_pad(1, 7, 0, STR_PAD_LEFT);
				$no_konsep = "$n2/R/$listlastid[trigram]/".date('m')."/".date('Y');
				
			 }
	$acak_id = rand(00000000,99999999);
	$id_otvis = $acak_id.date('YmdHis');
	//print_r($id_otvis);exit;
	$lokasi_file_foto   = $_FILES['foto_upload']['tmp_name'];
    $tipe_file_foto      = $_FILES['foto_upload']['type'];
    $nama_file_foto      = $_FILES['foto_upload']['name'];
    $acak          = rand(000000,999999);
    //$nama_file_unik_foto = $acak.'_'.$nama_file_foto; 
	$ext = explode(".", $nama_file_foto);
	$nama_file_unik_foto = $acak.date('YmdHis').'.'.$ext[1];
	
	$lokasi_file_foto_paspor   = $_FILES['foto_paspor_upload']['tmp_name'];
    $tipe_file_foto_paspor     = $_FILES['foto_paspor_upload']['type'];
    $nama_file_foto_paspor      = $_FILES['foto_paspor_upload']['name'];
    $acak          = rand(000000,999999);
   // $nama_file_unik_foto_paspor = $acak.'_'.$nama_file_foto_paspor; 
	$ext = explode(".", $nama_file_foto_paspor);
	$nama_file_unik_foto_paspor = $acak.date('YmdHis').'.'.$ext[1];
	
	$lokasi_file_setneg   = $_FILES['setneg_upload']['tmp_name'];
    $tipe_file_setneg      = $_FILES['setneg_upload']['type'];
    $nama_file_setneg      = $_FILES['setneg_upload']['name'];
    $acak          			= rand(000000,999999);
    //$nama_file_unik_setneg = $acak.'_'.$nama_file_setneg; 
	$ext = explode(".", $nama_file_setneg);
	$nama_file_unik_setneg = $acak.date('YmdHis').'.'.$ext[1];

    $lokasi_file_nota_diplomatik    = $_FILES['nota_diplomatik_upload']['tmp_name'];
    $tipe_file_nota_diplomatik      = $_FILES['nota_diplomatik_upload']['type'];
    $nama_file_nota_diplomatik      = $_FILES['nota_diplomatik_upload']['name'];
	$acak          = rand(000000,999999);
    //$nama_file_unik_nota_diplomatik = $acak.'_'.$nama_file_nota_diplomatik; 
	$ext = explode(".", $nama_file_nota_diplomatik);
	$nama_file_unik_nota_diplomatik = $acak.date('YmdHis').'.'.$ext[1];
	/* $lokasi_file_nikah    = $_FILES['surat_nikah_upload']['tmp_name'];
    $tipe_file_nikah      = $_FILES['surat_nikah_upload']['type'];
    $nama_file_nikah      = $_FILES['surat_nikah_upload']['name'];
	$acak          = rand(000000,999999);
    $nama_file_unik_nikah = $acak.'_'.$nama_file_nikah;  */
	
	/* $lokasi_file_surat_nikah   = $_FILES['surat_nikah_upload']['tmp_name'];
    $tipe_file_surat_nikah     = $_FILES['surat_nikah_upload']['type'];
    $nama_file_surat_nikah      = $_FILES['surat_nikah_upload']['name'];
    $acak           = rand(000000,999999);
    $nama_file_unik_surat_nikah = $acak.'_'.$nama_file_surat_nikah;  */

   /*  $lokasi_file_keppri_legal     = $_FILES['keppri_legal_upload']['tmp_name'];
    $tipe_file_keppri_legal       = $_FILES['keppri_legal_upload']['type'];
    $nama_file_keppri_legal       = $_FILES['keppri_legal_upload']['name'];
	$acak          = rand(000000,999999);
    $nama_file_unik_keppri_legal  = $acak.'_'.$nama_file_keppri_legal;  */
	//print_r($nama_file_unik_keppri_legal);exit;
if ($masa_akhir_tugas < $masa_awal_tugas ){
	$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br>Tanggal awal harus lebih kecil dari tanggal berakhir. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;
}else{
	
	
			// Apabila ada gambar yang diupload
  if (!empty($lokasi_file_foto)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_foto != "image/jpeg" AND $tipe_file_foto != "image/pjpeg" AND $tipe_file_foto != "image/png"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_foto</b> : $tipe_file_foto <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		//echo $template;		
		echo $varname;		exit;
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_foto,"../files/otvis/foto/$nama_file_unik_foto");
          $field_foto =  ',foto'; 
		  $file_foto  =  ','."'".$nama_file_unik_foto."'";   
	  }
  }
  
  
			// Apabila ada gambar yang diupload
  if (!empty($lokasi_file_foto_paspor)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_foto_paspor != "image/jpeg" AND $tipe_file_foto_paspor != "image/pjpeg"  AND $tipe_file_foto_paspor != "image/png"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_foto_paspor</b> : $tipe_file_foto_paspor <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		//echo $template;
		echo $varname;		exit;
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_foto_paspor,"../files/otvis/paspor/$nama_file_unik_foto_paspor");
          $field_foto_paspor =  ',foto_paspor'; 
		  $file_foto_paspor  =  ','."'".$nama_file_unik_foto_paspor."'";   
	  }
  }
			// Apabila ada gambar yang diupload
  if (!empty($lokasi_file_setneg)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_setneg != "image/jpeg" AND $tipe_file_setneg != "image/pjpeg" AND $tipe_file_setneg != "image/png" AND $tipe_file_setneg != "application/pdf"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_setneg</b> : $tipe_file_setneg <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		//echo $template;		
		echo $varname;		exit;
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_setneg,"../files/otvis/setneg/$nama_file_unik_setneg");
          $field_setneg =  ',surat_setneg'; 
		  $file_setneg  =  ','."'".$nama_file_unik_setneg."'";   
	  }
  }
  
  if (!empty($lokasi_file_nota_diplomatik)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_nota_diplomatik != "image/jpeg" AND $tipe_file_nota_diplomatik != "image/pjpeg" AND $tipe_file_nota_diplomatik != "image/png" AND $tipe_file_nota_diplomatik != "application/pdf"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_nota_diplomatik</b> : $tipe_file_nota_diplomatik <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		//echo $template;		
		echo $varname;		exit;
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_nota_diplomatik,"../files/otvis/notadinas/$nama_file_unik_nota_diplomatik");
         $field_notadinas =  ',nota_dinasdiplomatik'; 
		  $file_notadinas  =  ','."'".$nama_file_unik_nota_diplomatik."'";   
	  }
  }
  
  /* if (!empty($lokasi_file_nikah)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_nikah != "image/jpeg" AND $tipe_file_nikah != "image/pjpeg"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_nikah</b> : $tipe_file_nikah <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		echo $template;		
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_nikah,"../files/otvis/suratnikah/$nama_file_unik_nikah");
         $field_nikah =  ',surat_nikah'; 
		  $file_nikah  =  ','."'".$nama_file_unik_nikah."'";   
	  }
  }
  
  if (!empty($lokasi_file_keppri_legal)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_keppri_legal != "image/jpeg" AND $tipe_file_keppri_legal != "image/pjpeg"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_keppri_legal</b> : $tipe_file_keppri_legal <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		echo $template;		
  	  }
	  else
	  {
		 if(!move_uploaded_file($lokasi_file_keppri_legal,"../files/otvis/legalitas/$nama_file_unik_keppri_legal")){
			 print_r('GAGAL UNGGAH');
			 exit;
		 }
		 else
		 {
			 print_r('berhasil unggah');
		 }
         
		 $field_keppri_legal =  ',kepri_legal'; 
		  $file_keppri_legal  =  ','."'".$nama_file_unik_keppri_legal."'";   
	  }
  } */
    if($pengganti_otvis != '' || $pengganti_otvis)
	{
	//$menggantikan_otvis =  ',pengganti = '."'".$pengganti_otvis ."'"; 
	$field_pengganti =  ',pengganti'; 
	$isi_pengganti  =  ','."'".$pengganti_otvis."'";   
	} 
	
	$sql="insert into tbl_trans_otvis (id_otvis,no_konsep_pwk,pwk_ri,nama,kewarganegaraan,paspor,jns_paspor,
	tujuan,masa_awal_tugas,masa_akhir_tugas,tempat_tugas,verifikator,jabatan_verifikator,posisi,
	legalisator,jabatan_legalisator,
	kepala_pwk,
	jabatan_kepala_pwk,
	pejabat_pwk,
	jabatan_pejabat_pwk,no_nota_diplomatik
	$field_foto $field_foto_paspor $field_setneg $field_notadinas $field_pengganti
	,catatan,created_date,created_by,status_permohonan) 
	values 
	('$id_otvis','$no_konsep',$pwk_ri,'$nama_otvis',$wn_otvis,'$paspor_otvis',$jns_paspor,
	'$tujuan_otvis','$masa_awal_tugas','$masa_akhir_tugas','$tempattugas_otvis','$verifikator',
	'$jab_ver',$posisi_otvis,'$legalisator','$jab_legal',
	'$keppri',	 	
	'$jbt_keppri',	
	'$pjbt_konsuler',	
	'$jbt_konsuler',
	'$no_notadiplo'
	$file_foto $file_foto_paspor $file_setneg $file_notadinas $isi_pengganti
	,'$catatan','$created_date','$created_by',$status_mhn)";
	//print_r($sql);exit;
	if(isset($_POST['simpan'])){
		//print_r('askasd');exit;
		 if(mysql_query($sql))
		 { 
			$files = $_FILES; // deklarasi variabel untuk menampung file upload
				$cpt = count ( $_FILES ['userfile'] ['name'] ); // mendaptkan jumlah file yang di unggah
				//print_r(count ( $_FILES ['userfile']));exit;
				$h=1;
				foreach($_FILES ['userfile']['name'] as $val)
				{
					//print_r($val);exit;
					$lokasi_file   	= $_FILES['userfile']['tmp_name'][$h];
					$tipe_file      = $_FILES['userfile']['type'][$h];
					$nama_file      = $_FILES['userfile']['name'][$h];
					$acak          	= rand(000000,999999);
					$acak2          = rand(000000,999999);
					$datenow 		= date('Ymdhms');
					$nama_file_unik = $acak.'_'.$val[$h]['anggotafam_foto']; 
					$nama_file_unik2 = $acak2.'_'.$datenow; 
					$ext = explode(".", $val['anggotafam_foto']);
					$ext2 = explode(".", $val['anggotafam_foto_paspor']);
					$nama_files = $acak.date('YmdHis').$h.'.'.$ext[1];
					$nama_files2 = $acak2.date('YmdHis').$h.'.'.$ext2[1];
					//print_r($nama_files);exit;
					
					if($val['anggotafam_foto'])
					{
					//print_r('foto');exit;
					 move_uploaded_file($lokasi_file['anggotafam_foto'],"../files/otvis/foto/$nama_files");
					}
					if($val['anggotafam_foto_paspor'])
					{
						//print_r('paspor');exit;
					 move_uploaded_file($lokasi_file['anggotafam_foto_paspor'],"../files/otvis/paspor/$nama_files2");
					
					}
					
					$field_foto =  ',foto'; 
					$file_foto  =  $nama_files;  
					//print('lewat nih');exit;
					$field_foto_paspor =  ',foto_paspor'; 
					$file_foto_paspor  =  $nama_files2;  
					
					$insert_anggota_family = mysql_query("INSERT INTO tbl_anggota_fam (urutan,id_otvis,no_konsep,foto,foto_paspor,status_permohonan,created_date) VALUES ('".$h."',".$id_otvis.",'".$no_konsep."','".$file_foto."','".$file_foto_paspor."',3,'".date('Y-m-d h:m:s')."')");
				
					 
					$h++;
				}
		
			 if (!empty($anggota_family)) {	
				//input persyaratan
				$h = 1;
				foreach ($anggota_family as $val) {
				
  					$update_anggota_family = mysql_query("UPDATE tbl_anggota_fam set
					nama = '".$val['anggotafam_nama']."',
					relasi= '".$val['anggotafam_relasi']."', 
					kewarganegaraan= '".$val['anggotafam_kewarganegaraan']."', 
					nopaspor = '".$val['anggotafam_nopaspor']."' 
					where id_otvis = ".$id_otvis." 
					AND urutan = '".$h."'");
					$h++;
				}
			} 
			
		 if (!empty($dbv)) {	
				//input persyaratan
				$j = 1;
				foreach ($dbv as $val) {
					$insert_dbv = mysql_query("INSERT INTO tbl_dasarberi_visa (urutan,id_otvis,no_konsep, dasar_berivisa,created_date) VALUES ('".$j."',".$id_otvis.",'".$no_konsep."','".$val['dasarberivisa']."','".date('Y-m-d h:m:s')."')");
				$j++;
				}
			}
			
		echo "<script>
		 alert ('Berhasil mengajukan permohonan visa!');
		 document.location.href='./deplu.php?module=$module';
		 </script>";
		 }
		 else
		 {
		 echo "<script>
		 alert ('Gagal mengajukan permohonan visa! mohon cek kembali pengisiannya.');
		  document.location.href='./deplu.php?module=$module';
		 </script>";
		  echo '<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>';
		 
		 } 
			
	 
	}
	
	//header('location: ./deplu.php?module='.$module);

	} // if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
}	//if  ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT )
//}	//if ($b[TGL_MAX] <=  $TGL_AWAL_PERMIT)

elseif ($module=='indeksvisa' AND $act=='input_pusat'){

//$pwk_ri 		= $_POST[pwk_otvis];	
//print_r($pwk_ri);exit;
$tgl_otvis 		= $_POST[tgl_otvis];
//$nobrafaks_otvis= $_POST[nobrafaks_otvis];
//$nama_otvis 	= $_POST[nama_otvis];
$nama_otvis 	= str_replace("'","''",$_POST[nama_otvis]);
//$foto_otvis 	= $_POST[foto_upload];
$paspor_otvis 	= $_POST[paspor_otvis];
//$fotopaspor_otvis 	= $_POST[foto_paspor_upload];
$anggota_family = $_POST[anggota_fam];
$wn_otvis = $_POST[kewarganegaraan_otvis];
//print_r($anggota_family);exit;
$jns_paspor 	= $_POST[id_tipe_paspor];
$tujuan_otvis 	= $_POST[tujuan_otvis];
$posisi_otvis 	= $_POST[posisi];
$pengganti_otvis= $_POST[pengganti];
$tipevisa_otvis = $_POST[tipevisa_otvis];
$indeksvisa_otvis = $_POST[indeksvisa_otvis];
//$masatugas_otvis = $_POST[masatugas_otvis];
$masa_awal_tugas = $_POST[masa_awal_tugas];
$masa_akhir_tugas = $_POST[masa_akhir_tugas];
$tempattugas_otvis = $_POST[tempattugas_otvis];
$dmv 			 = $_POST[dasar_mintavisa];
$dbv 			 = $_POST[dasar_berivisa];
$verifikator	 = $_POST[verifikator];

//print_r($verifikator);exit;
$jab_ver		 = $_POST[jbt_ver];
$legalisator	 = $_POST[legalisator];
$jab_legal		 = $_POST[jbt_legal];

$keppri	 		 = $_POST[keppri];
$jbt_keppri		 = $_POST[jbt_keppri];
$pjbt_konsuler	 = $_POST[pjbt_konsuler];
$jbt_konsuler	 = $_POST[jbt_konsuler];

$catatan		 = $_POST[catatan_otvis];
$no_notadiplo	 = $_POST[no_nota_diplomatik];
$tipevisa_otvis = $_POST[tipevisa_otvis];
$indeksvisa_otvis = $_POST[indeksvisa_otvis];
$created_date	 = date('Y-m-d h:m:s');
$created_by	 	 = $_SESSION[G_idpwk];
$TGL_AKHIR_PERMIT = '2016-05-05';
$TGL_AWAL_PERMIT  = '2016-05-01';
$status_mhn		 = 3;//$_POST[ID_JNS_KEPUTUSAN];
//$st_akhir		 = 3;
		
		if($_SESSION[G_leveluser] != 15)
		{
			//$pwk_s = $_SESSION['G_idpwk'];
			$sql_pusat=mysql_query("SELECT * FROM tbl_trans_otvis where pwk_ri is null");
			 $query_pusat = mysql_fetch_array($sql_pusat);
			 if($query_pusat)
			 {
				$sql_getlastid = "SELECT * from tbl_trans_otvis where pwk_ri is null order by id desc limit 1";
				$tampillastid= mysql_query($sql_getlastid);
				$listlastid  = mysql_fetch_array($tampillastid);
				//print_r($listvisa1);exit;
				//$n1 = $listlastid[id]+1;
				$n1 = explode("/", $listlastid[no_konsep_pwk]);
				$n1_1 = $n1[0]+1;
				//$n1_2 = $n1[1];
				$n2 = str_pad($n1_1, 7, 0, STR_PAD_LEFT);
				
				$no_konsep = "$n2/R/PUSAT/".date('m')."/".date('Y');
				
			}
			else
			{
				
				$n2 = str_pad(1, 7, 0, STR_PAD_LEFT);
				$no_konsep = "$n2/R/PUSAT/".date('m')."/".date('Y');
				//echo "<input name='no_konsep' value='OTVIS/$n2/KEMLU/".date('m')."/".date('Y')."' type='hidden'>";
			}	
		}
	$acak_id = rand(00000000,99999999);
	$id_otvis = $acak_id.date('YmdHis');
	
	$lokasi_file_foto   = $_FILES['foto_upload']['tmp_name'];
    $tipe_file_foto      = $_FILES['foto_upload']['type'];
    $nama_file_foto      = $_FILES['foto_upload']['name'];
    $acak          = rand(000000,999999);
    //$nama_file_unik_foto = $acak.'_'.$nama_file_foto; 
	$ext = explode(".", $nama_file_foto);
	$nama_file_unik_foto = $acak.date('YmdHis').'.'.$ext[1];
	
	$lokasi_file_foto_paspor   = $_FILES['foto_paspor_upload']['tmp_name'];
    $tipe_file_foto_paspor     = $_FILES['foto_paspor_upload']['type'];
    $nama_file_foto_paspor      = $_FILES['foto_paspor_upload']['name'];
    $acak          = rand(000000,999999);
   // $nama_file_unik_foto_paspor = $acak.'_'.$nama_file_foto_paspor; 
	$ext = explode(".", $nama_file_foto_paspor);
	$nama_file_unik_foto_paspor = $acak.date('YmdHis').'.'.$ext[1];
	
	$lokasi_file_setneg   = $_FILES['setneg_upload']['tmp_name'];
    $tipe_file_setneg      = $_FILES['setneg_upload']['type'];
    $nama_file_setneg      = $_FILES['setneg_upload']['name'];
    $acak          			= rand(000000,999999);
    //$nama_file_unik_setneg = $acak.'_'.$nama_file_setneg; 
	$ext = explode(".", $nama_file_setneg);
	$nama_file_unik_setneg = $acak.date('YmdHis').'.'.$ext[1];

    $lokasi_file_nota_diplomatik    = $_FILES['nota_diplomatik_upload']['tmp_name'];
    $tipe_file_nota_diplomatik      = $_FILES['nota_diplomatik_upload']['type'];
    $nama_file_nota_diplomatik      = $_FILES['nota_diplomatik_upload']['name'];
	$acak          = rand(000000,999999);
    //$nama_file_unik_nota_diplomatik = $acak.'_'.$nama_file_nota_diplomatik; 
	$ext = explode(".", $nama_file_nota_diplomatik);
	$nama_file_unik_nota_diplomatik = $acak.date('YmdHis').'.'.$ext[1]; 
	
	/* $lokasi_file_nikah    = $_FILES['surat_nikah_upload']['tmp_name'];
    $tipe_file_nikah      = $_FILES['surat_nikah_upload']['type'];
    $nama_file_nikah      = $_FILES['surat_nikah_upload']['name'];
	$acak          = rand(000000,999999);
    $nama_file_unik_nikah = $acak.'_'.$nama_file_nikah;  */
	
	/* $lokasi_file_surat_nikah   = $_FILES['surat_nikah_upload']['tmp_name'];
    $tipe_file_surat_nikah     = $_FILES['surat_nikah_upload']['type'];
    $nama_file_surat_nikah      = $_FILES['surat_nikah_upload']['name'];
    $acak           = rand(000000,999999);
    $nama_file_unik_surat_nikah = $acak.'_'.$nama_file_surat_nikah;  */

   /*  $lokasi_file_keppri_legal     = $_FILES['keppri_legal_upload']['tmp_name'];
    $tipe_file_keppri_legal       = $_FILES['keppri_legal_upload']['type'];
    $nama_file_keppri_legal       = $_FILES['keppri_legal_upload']['name'];
	$acak          = rand(000000,999999);
    $nama_file_unik_keppri_legal  = $acak.'_'.$nama_file_keppri_legal;  */
	//print_r($nama_file_unik_keppri_legal);exit;
if ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT ){
	$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br>Tanggal awal harus lebih kecil dari tanggal berakhir. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;
}else{
	
	
			// Apabila ada gambar yang diupload
  if (!empty($lokasi_file_foto)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_foto != "image/jpeg" AND $tipe_file_foto != "image/pjpeg" AND $tipe_file_foto != "image/png"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_foto</b> : $tipe_file_foto <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		//echo $template;	
		echo $varname;		exit;
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_foto,"../files/otvis/foto/$nama_file_unik_foto");
          $field_foto =  ',foto'; 
		  $file_foto  =  ','."'".$nama_file_unik_foto."'";   
	  }
  }
  
  
			// Apabila ada gambar yang diupload
  if (!empty($lokasi_file_foto_paspor)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_foto_paspor != "image/jpeg" AND $tipe_file_foto_paspor != "image/pjpeg"  AND $tipe_file_foto_paspor != "image/png"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_foto_paspor</b> : $tipe_file_foto_paspor <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		//echo $template;		
		echo $varname;		exit;
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_foto_paspor,"../files/otvis/paspor/$nama_file_unik_foto_paspor");
          $field_foto_paspor =  ',foto_paspor'; 
		  $file_foto_paspor  =  ','."'".$nama_file_unik_foto_paspor."'";   
	  }
  }
			// Apabila ada gambar yang diupload
  if (!empty($lokasi_file_setneg)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_setneg != "image/jpeg" AND $tipe_file_setneg != "image/pjpeg" AND $tipe_file_setneg != "image/png" AND $tipe_file_setneg != "application/pdf"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_setneg</b> : $tipe_file_setneg <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		//echo $template;
		echo $varname;		exit;		
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_setneg,"../files/otvis/setneg/$nama_file_unik_setneg");
          $field_setneg =  ',surat_setneg'; 
		  $file_setneg  =  ','."'".$nama_file_unik_setneg."'";   
	  }
  }
  
  if (!empty($lokasi_file_nota_diplomatik)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_nota_diplomatik != "image/jpeg" AND $tipe_file_nota_diplomatik != "image/pjpeg" AND $tipe_file_nota_diplomatik != "image/png" AND $tipe_file_nota_diplomatik != "application/pdf" ){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_nota_diplomatik</b> : $tipe_file_nota_diplomatik <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		//echo $template;
		echo $varname;		exit;
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_nota_diplomatik,"../files/otvis/notadinas/$nama_file_unik_nota_diplomatik");
         $field_notadinas =  ',nota_dinasdiplomatik'; 
		  $file_notadinas  =  ','."'".$nama_file_unik_nota_diplomatik."'";   
	  }
  }
  
  /* if (!empty($lokasi_file_nikah)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_nikah != "image/jpeg" AND $tipe_file_nikah != "image/pjpeg"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_nikah</b> : $tipe_file_nikah <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		echo $template;		
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_nikah,"../files/otvis/suratnikah/$nama_file_unik_nikah");
         $field_nikah =  ',surat_nikah'; 
		  $file_nikah  =  ','."'".$nama_file_unik_nikah."'";   
	  }
  }
  
  if (!empty($lokasi_file_keppri_legal)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_keppri_legal != "image/jpeg" AND $tipe_file_keppri_legal != "image/pjpeg"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_keppri_legal</b> : $tipe_file_keppri_legal <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		echo $template;		
  	  }
	  else
	  {
		 if(!move_uploaded_file($lokasi_file_keppri_legal,"../files/otvis/legalitas/$nama_file_unik_keppri_legal")){
			 print_r('GAGAL UNGGAH');
			 exit;
		 }
		 else
		 {
			 print_r('berhasil unggah');
		 }
         
		 $field_keppri_legal =  ',kepri_legal'; 
		  $file_keppri_legal  =  ','."'".$nama_file_unik_keppri_legal."'";   
	  }
  } */
    if($pengganti_otvis != '' || $pengganti_otvis)
	{
	//$menggantikan_otvis =  ',pengganti = '."'".$pengganti_otvis ."'"; 
	$field_pengganti =  ',pengganti'; 
	$isi_pengganti  =  ','."'".$pengganti_otvis."'";   
	} 
	
	
	
	$sql="insert into tbl_trans_otvis (id_otvis,no_konsep_pwk,nama,kewarganegaraan,paspor,jns_paspor,
	tujuan,masa_awal_tugas,masa_akhir_tugas,tempat_tugas,verifikator,jabatan_verifikator,posisi,
	legalisator,jabatan_legalisator,
	no_nota_diplomatik
	$field_foto $field_foto_paspor $field_setneg $field_notadinas $field_pengganti
	,catatan,created_date,created_by,indeks_visa,tipe_visa,status_permohonan) 
	values 
	($id_otvis,'$no_konsep','$nama_otvis',$wn_otvis,'$paspor_otvis',$jns_paspor,
	'$tujuan_otvis','$masa_awal_tugas','$masa_akhir_tugas','$tempattugas_otvis','$verifikator',
	'$jab_ver',$posisi_otvis,'$legalisator','$jab_legal',
	'$no_notadiplo'
	$file_foto $file_foto_paspor $file_setneg $file_notadinas $isi_pengganti
	,'$catatan','$created_date','$created_by',$indeksvisa_otvis,$tipevisa_otvis,$status_mhn)";
	//print_r($sql);exit;
	if(isset($_POST['simpan'])){
		//print_r('askasd');exit;
		 if(mysql_query($sql))
		 { 
			$files = $_FILES; // deklarasi variabel untuk menampung file upload
				$cpt = count ( $_FILES ['userfile'] ['name'] ); // mendaptkan jumlah file yang di unggah
				//print_r(count ( $_FILES ['userfile']));exit;
				$h=1;
				foreach($_FILES ['userfile']['name'] as $val)
				{
					//print_r($val);exit;
					$lokasi_file   	= $_FILES['userfile']['tmp_name'][$h];
					$tipe_file      = $_FILES['userfile']['type'][$h];
					$nama_file      = $_FILES['userfile']['name'][$h];
					$acak          	= rand(000000,999999);
					$acak2          = rand(000000,999999);
					$datenow 		= date('Ymdhms');
					$nama_file_unik = $acak.'_'.$val[$h]['anggotafam_foto']; 
					$nama_file_unik2 = $acak2.'_'.$datenow; 
					$ext = explode(".", $val['anggotafam_foto']);
					$ext2 = explode(".", $val['anggotafam_foto_paspor']);
					$nama_files = $acak.date('YmdHis').$h.'.'.$ext[1];
					$nama_files2 = $acak2.date('YmdHis').$h.'.'.$ext2[1];
					//print_r($nama_files);exit;
					
					if($val['anggotafam_foto'])
					{
					//print_r('foto');exit;
					 move_uploaded_file($lokasi_file['anggotafam_foto'],"../files/otvis/foto/$nama_files");
					}
					if($val['anggotafam_foto_paspor'])
					{
						//print_r('paspor');exit;
					 move_uploaded_file($lokasi_file['anggotafam_foto_paspor'],"../files/otvis/paspor/$nama_files2");
					
					}
					
					$field_foto =  ',foto'; 
					$file_foto  =  $nama_files;  
					//print('lewat nih');exit;
					$field_foto_paspor =  ',foto_paspor'; 
					$file_foto_paspor  =  $nama_files2;  
					
					$insert_anggota_family = mysql_query("INSERT INTO tbl_anggota_fam (urutan,id_otvis,no_konsep,foto,foto_paspor,status_permohonan,created_date) VALUES ('".$h."',".$id_otvis.",'".$no_konsep."','".$file_foto."','".$file_foto_paspor."',3,'".date('Y-m-d h:m:s')."')");
				
					 
					$h++;
				}
		
			 if (!empty($anggota_family)) {	
				//input persyaratan
				$h = 1;
				foreach ($anggota_family as $val) {
				
  					$update_anggota_family = mysql_query("UPDATE tbl_anggota_fam set
					nama = '".$val['anggotafam_nama']."',
					relasi= '".$val['anggotafam_relasi']."', 
					kewarganegaraan= '".$val['anggotafam_kewarganegaraan']."', 
					nopaspor = '".$val['anggotafam_nopaspor']."' 
					where id_otvis = ".$id_otvis."
					AND urutan = '".$h."'");
					$h++;
				}
			} 
			
		 if (!empty($dbv)) {	
				//input persyaratan
				$j = 1;
				foreach ($dbv as $val) {
					$insert_dbv = mysql_query("INSERT INTO tbl_dasarberi_visa (urutan,id_otvis,no_konsep, dasar_berivisa,created_date) VALUES ('".$j."',".$id_otvis.",'".$no_konsep."','".$val['dasarberivisa']."','".date('Y-m-d h:m:s')."')");
				$j++;
				}
			}
			
		echo "<script>
		 alert ('Berhasil mengajukan permohonan visa!');
		 document.location.href='./deplu.php?module=$module';
		 </script>";
		 }
		 else
		 {
		 echo "<script>
		 alert ('Gagal mengajukan permohonan visa! mohon cek kembali pengisiannya.');
		  document.location.href='./deplu.php?module=$module';
		 </script>";
		  echo '<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>';
		 
		 } 
			
	 
	}
	
	//header('location: ./deplu.php?module='.$module);

	} // if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
}

	
elseif ($module=='indeksvisa' AND $act=='update' AND isset($_GET[idt])){
$id_otvis = $_GET[idt];
  
 if($_SESSION[G_leveluser] == 15)
 {
	
	 if($_POST[pwk_otvis3] != $_POST[pwk_otvis2])
	 {
		$pwk_ri 		= $_POST[pwk_otvis3];
	 }
	 else
	 {
	     $pwk_ri 		= $_POST[pwk_otvis2];
	 }
	 $posisi_otvis 	= $_POST[posisi];
	 $jns_paspor 	= $_POST[id_tipe_paspor];
	 $wn_otvis 		= $_POST[kewarganegaraan_otvis];
	 //print_r($pwk_ri);exit;
 }
 else
 {
	 if($_POST['pwk_otvis3'])
	 {
		$pwk_ri 		= $_POST['pwk_otvis3'];	 
	 }
	 else
	 {
		 $pwk_ri 		= 'null';	 
	 }
 
 $posisi_otvis 	= $_POST[posisi3]; 
 $jns_paspor 	= $_POST[id_tipe_paspor3];
 $wn_otvis 		= $_POST[kewarganegaraan_otvis2];
 $status_mhn	= $_POST[ID_JNS_KEPUTUSAN];
 $status_mhn_fam = $_POST[ID_JNS_KEPUTUSAN_FAM];
 $catatan		 = $_POST[catatan_otvis];
 //update tim DAM dan di query updatenya jg
 $pemroses = $_POST[pemroses];
 $sts_print = $_POST[sts_print];
 //
 }
 //print_r($pwk_ri);exit;
$no_konsep 		= $_POST[no_konsep_pwk];
//print_r($no_konsep);exit;
$tgl_otvis 		= $_POST[tgl_otvis];
//$nobrafaks_otvis= $_POST[nobrafaks_otvis];
//$nama_otvis 	= $_POST[nama_otvis];
$nama_otvis 	= str_replace("'","''",$_POST[nama_otvis]);
$paspor_otvis 	= $_POST[paspor_otvis];
$anggota_family = $_POST[anggota_fam];
//print_r($anggota_family);exit;


$tujuan_otvis 	= $_POST[tujuan_otvis];

$pengganti_otvis= $_POST[pengganti];
$tipevisa_otvis = $_POST[tipevisa_otvis];
$indeksvisa_otvis = $_POST[indeksvisa_otvis];

//$masatugas_otvis = $_POST[masatugas_otvis];
$masa_awal_tugas = $_POST[masa_awal_tugas];
$masa_akhir_tugas = $_POST[masa_akhir_tugas];
$tempattugas_otvis = $_POST[tempattugas_otvis];
$dmv 			 = $_POST[dasar_mintavisa];
$dbv 			 = $_POST[dasar_berivisa];
$verifikator	 = $_POST[verifikator];
$jab_ver		 = $_POST[jbt_ver];
$legalisator	 = $_POST[legalisator];
$jab_legal		 = $_POST[jbt_legal];

$catatan_pwk	 = $_POST[catatan_pwk];

$verifikator	 = $_POST[verifikator];
$jab_ver		 = $_POST[jbt_ver];
$legalisator	 = $_POST[legalisator];
$jab_legal		 = $_POST[jbt_legal];

$created_date	 = date('d M Y',strtotime($_POST[created_date]));
$created_date1	 = date('Y-m-d h:m:s');
$modified_date	 = date('Y-m-d h:m:s');
$tgl_otvis	 	 = date('Y-m-d');
$no_otvis_pusat  = $_POST[no_otvis_pusat];
$TGL_AKHIR_PERMIT = '2016-05-05';
$TGL_AWAL_PERMIT  = '2016-05-01';

$no_notadiplo	 = $_POST[no_nota_diplomatik];
//TIM DAM
$tgl_keputusan		 = $_POST[tgl_keputusan];
$lama_tinggal		 = $_POST[lama_tinggal];
//END TIM DAM

//print_r($nama_otvis);exit;
	
	
	$lokasi_file_foto   = $_FILES['foto_upload']['tmp_name'];
    $tipe_file_foto      = $_FILES['foto_upload']['type'];
    $nama_file_foto      = $_FILES['foto_upload']['name'];
    $acak          = rand(000000,999999);
    //$nama_file_unik_foto = $acak.'_'.$nama_file_foto; 
	$ext = explode(".", $nama_file_foto);
	$nama_file_unik_foto = $acak.date('YmdHis').'.'.$ext[1];
	
	$lokasi_file_foto_paspor   = $_FILES['foto_paspor_upload']['tmp_name'];
    $tipe_file_foto_paspor     = $_FILES['foto_paspor_upload']['type'];
    $nama_file_foto_paspor      = $_FILES['foto_paspor_upload']['name'];
    $acak          = rand(000000,999999);
   // $nama_file_unik_foto_paspor = $acak.'_'.$nama_file_foto_paspor; 
	$ext = explode(".", $nama_file_foto_paspor);
	$nama_file_unik_foto_paspor = $acak.date('YmdHis').'.'.$ext[1];
	
	$lokasi_file_setneg   = $_FILES['setneg_upload']['tmp_name'];
    $tipe_file_setneg      = $_FILES['setneg_upload']['type'];
    $nama_file_setneg      = $_FILES['setneg_upload']['name'];
    $acak          			= rand(000000,999999);
    //$nama_file_unik_setneg = $acak.'_'.$nama_file_setneg; 
	$ext = explode(".", $nama_file_setneg);
	$nama_file_unik_setneg = $acak.date('YmdHis').'.'.$ext[1];

    $lokasi_file_nota_diplomatik    = $_FILES['nota_diplomatik_upload']['tmp_name'];
    $tipe_file_nota_diplomatik      = $_FILES['nota_diplomatik_upload']['type'];
    $nama_file_nota_diplomatik      = $_FILES['nota_diplomatik_upload']['name'];
	$acak          = rand(000000,999999);
    //$nama_file_unik_nota_diplomatik = $acak.'_'.$nama_file_nota_diplomatik; 
	$ext = explode(".", $nama_file_nota_diplomatik);
	$nama_file_unik_nota_diplomatik = $acak.date('YmdHis').'.'.$ext[1];
	
	/* $lokasi_file_nikah    = $_FILES['surat_nikah_upload']['tmp_name'];
    $tipe_file_nikah      = $_FILES['surat_nikah_upload']['type'];
    $nama_file_nikah      = $_FILES['surat_nikah_upload']['name'];
	 $acak          = rand(000000,999999);
    $nama_file_unik_nikah = $acak.'_'.$nama_file_nikah; 
	
	$lokasi_file_surat_nikah   = $_FILES['surat_nikah_upload']['tmp_name'];
    $tipe_file_surat_nikah     = $_FILES['surat_nikah_upload']['type'];
    $nama_file_surat_nikah      = $_FILES['surat_nikah_upload']['name'];
    $acak           = rand(000000,999999);
    $nama_file_unik_surat_nikah = $acak.'_'.$nama_file_surat_nikah; 

    $lokasi_file_keppri_legal     = $_FILES['keppri_legal_upload']['tmp_name'];
    $tipe_file_keppri_legal       = $_FILES['keppri_legal_upload']['type'];
    $nama_file_keppri_legal       = $_FILES['keppri_legal_upload']['name'];
	 $acak          = rand(000000,999999);
    $nama_file_unik_keppri_legal  = $acak.'_'.$nama_file_keppri_legal; 
// */
if ($masa_akhir_tugas < $masa_awal_tugas ){
	$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Ubah Data Gagal.</b><br>Tanggal awal harus lebih kecil dari tanggal berakhir. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{

 
	//else{
	
		//print_r($status_mhn.'asd');exit;
	$a = "select * from tbl_trans_otvis where id_otvis = '$id_otvis'";
	$b = mysql_query($a);
	$c = mysql_fetch_array($b);
	
	$d = "select * from tbl_dasarminta_visa where id_otvis = '$id_otvis'";
	$e = mysql_query($d);
	$f = mysql_fetch_array($e);
	
	$g = "select * from tbl_dasarberi_visa where id_otvis = '$id_otvis'";
	$h = mysql_query($g);
	$i = mysql_fetch_array($h);
	
	
	
	function sendemail5($email,$idt,$pwk_ri,$nama_otvis,$paspor_otvis,
	$jns_paspor,$anggota_family,$tujuan_otvis,$indeksvisa_otvis,
	$masatugas_otvis,$catatan,$status_mhn,$created_date1)
	{
		$to      = $email;
		//$noreg   = $nodaftar;
		$bcc	 = 'BCC : no-reply.otvis@kemlu.go.id';
		//if 
		
		$messagelolos = 
		"
		<html>
				
				<table border=0 width=100%>
				<tr>
				<td width=20% align='center'>
				<img src='../images/logo_kemlu5.png' width=90 height=90>
				</td>
				
				<td align='center' style='font-size:15px;'>
				
				OTORISASI VISA DIPLOMATIK / DINAS<br>
				KEMENTERIAN LUAR NEGERI REPUBLIK INDONESIA<br> 
				Jln. Pejambon No.6 , Jakarta Pusat, 10110 Indonesia<br> 
				E-mail : otorisasi.visa@kemlu.go.id

				</td>
				
				<td width=20% align='center'>
				&nbsp;
				</td>
				
				</tr>
				</table>
				<hr>
				<table border=0 width=100%>
				<tr>
				<td  align='center' width='15%' style='border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000'>
				
				</td>
				
				<td>
				&nbsp;
				</td>
				<td width='45%'>
				NO. KONSEP   : $idt<br>
				TANGGAL      : $created_date1
				</td>
				
				</tr>
				</table>
				<br>
				<table border=0>
				<tr><td width=35%>Perwakilan RI di</td><td>:$pwk_ri</td></tr>
				<tr><td>Nama / Paspor</td><td>: $nama_otvis / $paspor_otvis</td></tr>
				<tr><td>Jenis Paspor</td><td>: $jns_paspor</td></tr>
				<tr><td>Anggota Keluarga</td><td>: $anggota_family</td></tr>
				
				<tr><td>Tujuan</td><td>: $tujuan_otvis</td></tr>
				<tr><td>Indeks Visa</td><td>: $indeksvisa_otvis</td></tr>
				<tr><td>Masa Penugasan di Indonesia</td><td>: $masatugas_otvis Hari</td></tr>
				<tr><td>Dasar Permintaan Visa</td><td>: 
				
				</td></tr>
				<tr><td>Dasar Pemberian Visa</td><td>: 
				
				</td></tr>
				<tr><td>Catatan</td><td>: $catatan</td></tr>
				<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
				<tr><td colspan=2 align=justify>
				Perwakilan  RI  agar  mencantumkan  Kode  Jenis dan  Indeks  Visa  serta  Kode  Wilayah  tempat 
				penerbitan  Visa  Diplomatik/Dinas,  secara  benar  sesuai  dengan  ketentuan  yang  berlaku  serta 
				memberikan informasi kepada ybs  agar mengalihstatuskan Visa Diplomatik/Dinas nya menjadi Izin Tinggal 
				Diplomatik/Dinas  di Kementerian Luar Negeri RI c.q. Direktorat Konsuler  dalam jangka waktu kurang dari 
				30 (tiga puluh) hari sejak tanggal ketibaan di Indonesia.
				<br><br>Demikian, atas perhatian dan kerjasamanya disampaikan terima kasih.
				</td><tr>
				</table>
				<br>
				<p>
				Salam Hormat,<br><br>
				Otorisasi Visa Kementerian Luar Negeri RI
				</p>
				<br>
				<br>
				<hr><br>
				<small>Email ini dikirim secara otomatis oleh sistem. Harap tidak membalas ke alamat email ini. Pertanyaan dapat dikirimkan ke konsuler@kemlu.go.id. Terima kasih.</small>
	
				</html>
		";
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: NO REPLY - Visa Kementerian Luar Negeri RI <no-reply.otvis@kemlu.go.id>' . "\r\n".$bcc;
	
		/* if($kd_flow == 2)
		{ */
			$message = $messagelolos;
			//print_r($message);exit;
			$noreg1  = $idt;
			$subject_temp = 'Konfirmasi Visa No. Daftar : '.$noreg1.' '.$status_mhn.'/ Visa Confirmation Reg. No : '.$noreg1.' Approved';
			$subject = $subject_temp;
		/* }
		elseif($kd_flow == 1)
		{
			$message = $messagetolak;
			$noreg1  = $nodaftar;
			$subject = 'Konfirmasi Ijin Tinggal Online No. Daftar : '.$noreg1.' (DIPLOMAT) Ditolak / Stay Permit Confirmation Reg. No : '.$noreg1.' (DIPLOMAT) Rejected';
		}	 */
		
		return mail($to, $subject, $message, $headers);
		
	}
	
	//if($_SESSION['G_leveluser'] == 14)
	//{
	/* sendemail('hartarto.anugerah@kemlu.go.id',$idt,$pwk_ri,$nama_otvis,$paspor_otvis,$jns_paspor,$anggota_family,$tujuan_otvis
	,$indeksvisa_otvis,$masatugas_otvis,$catatan,$status_mhn,$created_date1); */
	//}
	//ELSE
	//{
	/* sendemail('hartarto.anugerah@kemlu.go.id',$idt,$pwk_ri,$nama_otvis,$paspor_otvis,$jns_paspor,$anggota_family,$tujuan_otvis
	,$indeksvisa_otvis,$masatugas_otvis,$catatan,$status_mhn,$created_date1); */
	//}
	
				// Apabila ada gambar yang diupload
  if (!empty($lokasi_file_foto)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_foto != "image/jpeg" AND $tipe_file_foto != "image/pjpeg" AND $tipe_file_foto != "image/png"){
       // print_r('gagal masuk');exit;
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_foto</b> : $tipe_file_foto <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		echo $varname;		exit;
  	  }
	  else
	  {
		 // print_r('masuk');exit;
		 move_uploaded_file($lokasi_file_foto,"../files/otvis/foto/$nama_file_unik_foto");
         
		  $field_foto =  ',foto = '."'".$nama_file_unik_foto."'"; 
	  }
  }
  
  
			// Apabila ada gambar yang diupload
  if (!empty($lokasi_file_foto_paspor)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_foto_paspor != "image/jpeg" AND $tipe_file_foto_paspor != "image/pjpeg"  AND $tipe_file_foto_paspor != "image/png"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_foto_paspor</b> : $tipe_file_foto_paspor <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		//echo $template;	
		echo $varname;		exit;		
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_foto_paspor,"../files/otvis/paspor/$nama_file_unik_foto_paspor");
        
		  $field_foto_paspor =  ',foto_paspor = '."'".$nama_file_unik_foto_paspor."'"; 
		 
	  }
  }
  
			// Apabila ada gambar yang diupload
  if (!empty($lokasi_file_setneg)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_setneg != "image/jpeg" AND $tipe_file_setneg != "image/pjpeg" AND $tipe_file_setneg != "image/png" AND $tipe_file_setneg != "application/pdf"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_setneg</b> : $tipe_file_setneg <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		//echo $template;	
		echo $varname;		exit;
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_setneg,"../files/otvis/setneg/$nama_file_unik_setneg");
          $field_setneg =  ',surat_setneg = '."'".$nama_file_unik_setneg."'"; 
		  //$file_setneg  =  ',';   
	  }
  }
  
  if (!empty($lokasi_file_nota_diplomatik)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_nota_diplomatik != "image/jpeg" AND $tipe_file_nota_diplomatik != "image/pjpeg" AND $tipe_file_nota_diplomatik != "image/png" AND $tipe_file_nota_diplomatik != "application/pdf" ){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_nota_diplomatik</b> : $tipe_file_nota_diplomatik <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		//echo $template;	
		echo $varname;		exit;
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_nota_diplomatik,"../files/otvis/notadinas/$nama_file_unik_nota_diplomatik");
         $field_notadinas =  ',nota_dinasdiplomatik = '."'".$nama_file_unik_nota_diplomatik."'"; 
		  //$file_notadinas  =  ',';   
	  }
  }
  
 /*  if (!empty($lokasi_file_nikah)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_nikah != "image/jpeg" AND $tipe_file_nikah != "image/pjpeg"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_nikah</b> : $tipe_file_nikah <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		echo $template;		
  	  }
	  else
	  {
		 move_uploaded_file($lokasi_file_nikah,"../files/otvis/suratnikah/$nama_file_unik_nikah");
         $field_nikah =  ',surat_nikah = '."'".$nama_file_unik_nikah."'"; 
		  //$file_nikah  =  ',';   
	  }
  }
  
  if (!empty($lokasi_file_keppri_legal)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file_keppri_legal != "image/jpeg" AND $tipe_file_keppri_legal != "image/pjpeg"){
        
  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file_keppri_legal</b> : $tipe_file_keppri_legal <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";	 		  
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		echo $template;		
  	  }
	  else
	  {
		 if(!move_uploaded_file($lokasi_file_keppri_legal,"../files/otvis/legalitas/$nama_file_unik_keppri_legal")){
			 print_r('GAGAL UNGGAH');
			 //exit;
		 }
		 else
		 {
			 print_r('berhasil unggah');
		 }
         
		 $field_keppri_legal =  ',kepri_legal = '."'".$nama_file_unik_keppri_legal."'"; 
		  //$file_keppri_legal  =  ','."'".$nama_file_unik_keppri_legal."'";   
	  }
  } */
  
	/* $sql_update = "
					update tbl_trans_otvis set 
											pwk_ri = $pwk_ri,
											nama = '$nama_otvis',
											paspor = '$paspor_otvis',
											jns_paspor = $jns_paspor,
											no_brafaks = '$nobrafaks_otvis',
											tujuan = '$tujuan_otvis',
											indeks_visa = $indeksvisa_otvis,
											masa_tugas = $masatugas_otvis,
											verifikator = '$verifikator',
											jabatan_verifikator = '$jab_ver',
											legalisator  = '$legalisator',
											jabatan_legalisator = '$jab_legal',
											
											catatan = '$catatan',
											modified_date = '$modified_date',
											status_permohonan = $status_mhn
											$field_setneg
											$field_notadinas
											$field_keppri_legal
											where no_konsep =  '$idt'"; */
	if($status_mhn != '' || $status_mhn)
	{
	
	$stmhn = ',status_permohonan = '.$status_mhn;
	
	if(!$no_otvis_pusat)
	{	
	if($status_mhn == 1)
		{
			$tglotvis = ',tgl_otvis = '."'".$tgl_otvis."'";
			$tampilbaru1=mysql_query("SELECT * FROM tbl_trans_otvis where no_konsep_pusat <> ''");
			 $apes1 = mysql_num_rows($tampilbaru1);  
			if($apes1 != 0)
			{
				//print_r("sdh ada");exit;
				$sql_listvisa1 = "SELECT * from tbl_trans_otvis where no_konsep_pusat <> '' order by no_konsep_pusat desc limit 1";
				$tampilvisa1= mysql_query($sql_listvisa1);
				$listvisa1  = mysql_fetch_array($tampilvisa1);
				//print_r($listvisa1);exit;
				$n1x = explode('/',$listvisa1[no_konsep_pusat]);
				$n1 = $n1x[1]+1;
				$n2 = str_pad($n1, 7, 0, STR_PAD_LEFT);
				//echo "OTVIS/$n2/KEMLU/".date('m')."/".date('Y');
				$no_konsep = "OTVIS/$n2/KEMLU/".date('m')."/".date('Y');
				//echo "<input name='no_konsep' value='$n3' type='hidden'>";
				$no_konsep_pusat = ',no_konsep_pusat = '."'".$no_konsep."'";
				//print_r($no_konsep_pusat);exit;
			}
			else
			{
				//print_r("kosong");exit;
				$n2 = str_pad(1, 7, 0, STR_PAD_LEFT);
				$no_konsep = "OTVIS/$n2/KEMLU/".date('m')."/".date('Y');
				
				$no_konsep_pusat = ',no_konsep_pusat = '."'".$no_konsep."'";
				//echo "<input name='no_konsep' value='OTVIS/$n2/KEMLU/".date('m')."/".date('Y')."' type='hidden'>";
			}
		}
		
	}
	}
	
	if($status_mhn_fam != '' || $status_mhn_fam)
	{
	
	$stmhn_fam = ',status_permohonan = '.$status_mhn_fam;
	//print_r($stmhn_fam);exit;
		

	}
	
	if($pengganti_otvis != '' || $pengganti_otvis)
	{
	
	$menggantikan_otvis =  ',pengganti = '."'".$pengganti_otvis ."'"; 
	}
	
	if($indeksvisa_otvis || $indeksvisa_otvis != '')
	{
	$field_indeks_visa = ',indeks_visa = '.$indeksvisa_otvis;	
	//$stmhn = ',status_permohonan = '.$status_mhn;
	}
	
	if($tipevisa_otvis || $tipevisa_otvis != '')
	{
	$field_tipevisa_otvis = ',tipe_visa = '.$tipevisa_otvis;	
	//$stmhn = ',status_permohonan = '.$status_mhn;
	}
	
	if($_SESSION[G_leveluser] == 14)
	{
	$field_catatan_pusat = ",catatan = '$catatan'";	
	}
	else
	{
	$field_catatan_pwk = ",catatan_pwk = '$catatan_pwk'";	
	$field_m_awal_t = "masa_awal_tugas = '$masa_awal_tugas',";
	$field_m_akhir_t = "masa_akhir_tugas = '$masa_akhir_tugas',";
	}

	$sql_update = "
					update tbl_trans_otvis set 
											pwk_ri = $pwk_ri,
											nama = '$nama_otvis',
											kewarganegaraan = $wn_otvis,
											paspor = '$paspor_otvis',
											jns_paspor = $jns_paspor,
											pemroses = '$pemroses',
                                            sts_print = '$sts_print',
											tgl_keputusan = '$tgl_keputusan',
											lama_tinggal = '$lama_tinggal',
											tujuan = '$tujuan_otvis'
											$field_indeks_visa
											$field_tipevisa_otvis
											,posisi = $posisi_otvis,
											$field_m_awal_t
											$field_m_akhir_t
											tempat_tugas = '$tempattugas_otvis',
											no_nota_diplomatik = '$no_notadiplo',
											verifikator = '$verifikator',
											jabatan_verifikator = '$jab_ver',
											legalisator  = '$legalisator',
											jabatan_legalisator = '$jab_legal'
											
											$field_catatan_pusat
											$field_catatan_pwk
											,modified_date = '$modified_date'
											$menggantikan_otvis
											$field_foto
											$field_foto_paspor
											$field_setneg
											$field_notadinas
											
											$stmhn
											$tglotvis
											$no_konsep_pusat
											where id_otvis =  '$id_otvis'";
	
	if(isset($_POST['simpan'])){
		$cpt = count ( $_FILES ['userfile'] ['name'] ); 
		//print_r($_FILES ['userfile'] ['name']);exit;
		 if(mysql_query($sql_update))
		 {
			//print_r('berhasil');exit;
			
				$files = $_FILES; // deklarasi variabel untuk menampung file upload
				$cpt = count ( $_FILES ['userfile'] ['name'] ); // mendaptkan jumlah file yang di unggah
				//print_r($cpt);exit;
				//$h=1;
				/* if(count($anggota_family) > 1)
				{ */
					//print_r('lbih dari 1 nih');exit;
					if($cpt != 0)
					{
					$del_anggota_family = mysql_query("delete from tbl_anggota_fam where id_otvis =  '$id_otvis'"); 
					}
					$h=1;
					if($cpt != 0)
							{
					foreach($_FILES ['userfile']['name'] as $val8)
						{
							
							$lokasi_file   	= $_FILES['userfile']['tmp_name'][$h];
							$tipe_file      = $_FILES['userfile']['type'][$h];
							$nama_file      = $_FILES['userfile']['name'][$h];
							$acak          	= rand(000000,999999);
							$acak2          = rand(000000,999999);
							$datenow 		= date('Ymdhms');
							$nama_file_unik = $acak.'_'.$val8[$h]['anggotafam_foto']; 
							$nama_file_unik2 = $acak2.'_'.$datenow; 
							$ext = explode(".", $val8['anggotafam_foto']);
							$ext2 = explode(".", $val8['anggotafam_foto_paspor']);
							if($anggota_family[$h]['filefoto_fam'])
							{
								//print_r($h);
								$nama_files = $anggota_family[$h]['filefoto_fam'];
								//$nama_files2 = $anggota_family[$h]['filepaspor_fam'];
							}
							else
							{
								//print_r($val8);exit;
								$nama_files = $acak.date('YmdHis').$h.'.'.$ext[1];
								//$nama_files2 = $acak2.date('YmdHis').$h.'.'.$ext2[1];
							}
							
							if($anggota_family[$h]['filepaspor_fam'])
							{
								//print_r($h);
								//$nama_files = $anggota_family[$h]['filefoto_fam'];
								$nama_files2 = $anggota_family[$h]['filepaspor_fam'];
							}
							else
							{
								//print_r($val8);exit;
								//$nama_files = $acak.date('YmdHis').$h.'.'.$ext[1];
								$nama_files2 = $acak2.date('YmdHis').$h.'.'.$ext2[1];
							}
							
							//print_r($nama_files);exit;
							
							if($val8['anggotafam_foto'])
							{
							//print_r('foto');exit;
							 move_uploaded_file($lokasi_file['anggotafam_foto'],"../files/otvis/foto/$nama_files");
							}
							if($val8['anggotafam_foto_paspor'])
							{
								//print_r('paspor');exit;
							 move_uploaded_file($lokasi_file['anggotafam_foto_paspor'],"../files/otvis/paspor/$nama_files2");
							
							}
							
							$field_foto =  ',foto'; 
							$file_foto  =  $nama_files;  
							//print('lewat nih');exit;
							$field_foto_paspor =  ',foto_paspor'; 
							$file_foto_paspor  =  $nama_files2;  
							
							$insert_anggota_family = mysql_query("
							INSERT INTO tbl_anggota_fam 
							(urutan,id_otvis,no_konsep,foto,foto_paspor,created_date) 
							VALUES ('".$h."','".$id_otvis."','".$no_konsep."','".$file_foto."','".$file_foto_paspor."','".date('Y-m-d h:m:s')."')");
							
							 
							$h++;
						}
							}
						 if (!empty($anggota_family)) {	
							
							
							//input persyaratan
							$h = 1;
							foreach ($anggota_family as $val) {
								
								if($_SESSION[G_leveluser]!=15)
								{
									$st = "status_permohonan = ".$val['anggotafam_keputusan'].",";
									if($val['anggotafam_keputusan'] == 2)
									{
									$at = "alasan_tolak = '".$val['anggotafam_alasantolak']."',";
									}
									else
									{
									$at = "alasan_tolak = null,";
									}
								}
								
								else
								{
									if(!$val['anggotafam_keputusan'])
									{
									$st="status_permohonan = 3,";
									}
									else
									{
									$st = "";
									}
								}
								/* print_r("UPDATE tbl_anggota_fam set
								nama = '".$val['anggotafam_nama']."',
								relasi= '".$val['anggotafam_relasi']."',
								$st	
								nopaspor = '".$val['anggotafam_nopaspor']."' 
								
								where no_konsep = '".$idt."' 
								AND urutan = '".$h."'");exit; */
								$update_anggota_family = mysql_query("UPDATE tbl_anggota_fam set
								nama = '".$val['anggotafam_nama']."',
								relasi= '".$val['anggotafam_relasi']."',
								kewarganegaraan= '".$val['anggotafam_kewarganegaraan']."', 
								$st	
								$at
								nopaspor = '".$val['anggotafam_nopaspor']."' 
								
								where id_otvis = '".$id_otvis."'
								AND urutan = '".$h."'");
								$h++;
							}
						}
					
			/* if (!empty($anggota_family)) {	
					//input persyaratan
					$h = 1;
					$delete_anggota_family = mysql_query("DELETE FROM tbl_anggota_fam where no_konsep = '$idt'");
					foreach ($anggota_family as $val) {
						$insert_anggota_family = mysql_query("INSERT INTO tbl_anggota_fam (urutan,no_konsep, nama,foto,relasi,nopaspor,foto_paspor,created_date) VALUES ('".$h."','".$idt."','".$val['anggotafam_nama']."','".$val['anggotafam_foto']."','".$val['anggotafam_relasi']."','".$val['anggotafam_nopaspor']."','".$val['anggotafam_foto_paspor']."','".date('Y-m-d h:m:s')."')");
					$h++;
					}
				} */
				/* else
				{
					$delete_anggota_family = mysql_query("DELETE FROM tbl_anggota_fam where no_konsep = '$idt'");
				} */
			
			/* if (!empty($dmv)) {	
					//input persyaratan
					$i = 1;
					$delete_dbv = mysql_query("DELETE FROM tbl_dasarminta_visa where no_konsep = '$idt'");
					foreach ($dmv as $val) {
						$insert_dmv = mysql_query("INSERT INTO tbl_dasarminta_visa (urutan,no_konsep, dasar_mintavisa,created_date) VALUES ('".$i."','".$idt."','".$val['dasarmintavisa']."','".date('Y-m-d h:m:s')."')");
					$i++;
					}
				}
				else
				{
					$delete_dmv = mysql_query("DELETE FROM tbl_dasarminta_visa where no_konsep = '$idt'");
				} */
			if (!empty($dbv)) {	
					//input persyaratan
					$j = 1;
					$delete_dbv = mysql_query("DELETE FROM tbl_dasarberi_visa where id_otvis = '$id_otvis'");
				
					foreach ($dbv as $val) {
						$insert_dbv = mysql_query("INSERT INTO tbl_dasarberi_visa (urutan,id_otvis,no_konsep, dasar_berivisa,created_date) VALUES ('".$j."','".$id_otvis."','".$no_konsep."','".$val['dasarberivisa']."','".date('Y-m-d h:m:s')."')");
					$j++;
					}
				}	
				else
				{
					$delete_dbv = mysql_query("DELETE FROM tbl_dasarberi_visa where id_otvis = '$id_otvis'");
				}
		 
			//echo '<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Update Data Berhasil.</b></p>';
			echo "
			<script>
		 alert ('Berhasil update permohonan visa!');
		  document.location.href='./deplu.php?module=$module';
		 </script>
		";
		 }
		 else
		 {
		echo"
		 <script>
		 alert ('Gagal update permohonan visa!');
		  document.location.href='./deplu.php?module=$module';
		 </script>
		";
			 //echo '<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Update Data Gagal.</b><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>';
		 }
	 
	}
	
 	
	
	//header('location: ./deplu.php?module='.$module);
	//} // if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
}//if  ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT )
  
  }


  


elseif ($module=='staypermit' AND $act=='input'){

$ID_DIPLOMAT = $_POST[ID_DIPLOMAT];
$ID_JNS_PERMIT = $_POST[ID_JNS_PERMIT];
$NO_AGENDA = $_POST[NO_AGENDA];
$TGL_AGENDA = $_POST[TGL_AGENDA];
$NO_IZIN_PERMIT = $_POST[NO_IZIN_PERMIT];
$TGL_AWAL_PERMIT = $_POST[TGL_AWAL_PERMIT];
$TGL_AKHIR_PERMIT = $_POST[TGL_AKHIR_PERMIT];
$TGL_AMBIL = $_POST[TGL_AMBIL_BERKAS];
$KET = $_POST[KET];
$KETVER = $_POST[KET_VER];
$KETHOR = $_POST[KET_HOR];
$NO_NOTA = $_POST[NO_NOTA];
$TGL_NOTA = $_POST[TGL_NOTA];

//============

$qSelect1=mysql_query("select max(TGL_AKHIR_PERMIT) as TGL_MAX from permit_diplomat where  ST_PERMIT_KAS = 2 and ST_PERMIT_K = 2 and ID_JNS_PERMIT =$ID_JNS_PERMIT  and ID_DIPLOMAT = $ID_DIPLOMAT ");
 $b1=mysql_fetch_array($qSelect1);
 if (!(is_null($b[TGL_MAX])) and ($b[TGL_MAX] <=  $TGL_AWAL_PERMIT)){
	$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br>Masih ada permit yang masih aktif. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{
//=======

if ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT ){
	$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br>Tanggal awal harus lebih kecil dari tanggal berakhir. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{

/* $qSelect=mysql_query("select NM_DIPLOMAT,DATE_FORMAT(AKHIR_BERLAKU,'%d-%M-%Y') AS AKHIR_BERLAKU,date_add(AKHIR_BERLAKU, interval -180 day) as BATAS_PERMIT, DATE_FORMAT(date_add(AKHIR_BERLAKU, interval -180 day),'%d-%M-%Y') as BATAS_PERMIT_2 from diplomat where ID_DIPLOMAT = $ID_DIPLOMAT");
*/ $qSelect=mysql_query("select NM_DIPLOMAT,DATE_FORMAT(AKHIR_BERLAKU,'%d-%M-%Y') AS AKHIR_BERLAKU,date_add(AKHIR_BERLAKU, interval -30 day) as BATAS_PERMIT, DATE_FORMAT(date_add(AKHIR_BERLAKU, interval -180 day),'%d-%M-%Y') as BATAS_PERMIT_2 from diplomat where ID_DIPLOMAT = $ID_DIPLOMAT");
 $b=mysql_fetch_array($qSelect);
 if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
	{
	 $varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Tambah Data Gagal.</b><br>Tanggal akhir permit maksimal 30 hari sebelum masa berlaku paspor habis.<br>Masa Berlaku paspor milik <b>$b[NM_DIPLOMAT]</b> habis pada tanggal <b>$b[AKHIR_BERLAKU]</b> .<br>Batas Maksimal Tanggal akhir permit adalah <b>$b[BATAS_PERMIT_2]</b> .
	 <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	 $template = eregi_replace("{isi}",$varname,$template);
	 echo $template;

	}
	else{
	
	if  ($ID_JNS_PERMIT==1){

		$cmp1="SELECT COUNT(ID_PERMIT_S) as jml FROM v_stay_permit_sib WHERE NO_IZIN_PERMIT LIKE CONCAT('KAG/',date_format('2012-12-26','%y'),'/%')";
 		$res=mysql_query($cmp1);
		$jml1=mysql_fetch_array($res);
		
		$cmp2="SELECT COUNT(ID_PERMIT) as jml FROM v_stay_permit WHERE NO_IZIN_PERMIT LIKE CONCAT('KAG/',date_format('2012-12-26','%y'),'/%')";
		$res2=mysql_query($cmp2);
		$jml2=mysql_fetch_array($res2);
		
		$urut_permit=$jml1['jml']+$jml2['jml']+1;
 

		$sql="insert into permit_diplomat (ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,TGL_AGENDA,NO_IZIN_PERMIT,TGL_AWAL_PERMIT,TGL_AKHIR_PERMIT,KET,ST_PERMIT,ST_PERMIT_K,ST_PERMIT_KAS,NO_NOTA,TGL_NOTA) values ($ID_DIPLOMAT,$ID_JNS_PERMIT,'$NO_AGENDA','$TGL_AGENDA','$NO_IZIN_PERMIT','$TGL_AWAL_PERMIT','$TGL_AKHIR_PERMIT','$KET','$KETVER','$KETHOR',1,1,1,'$NO_NOTA','$TGL_NOTA')";
		//automatic generate code
		//(SELECT CONCAT('KAG/',date_format('$TGL_AGENDA','%y'),'/',(SELECT KD_JNS_PASPOR FROM v_diplomat WHERE ID_DIPLOMAT = $ID_DIPLOMAT),'/',$urut_permit))
   mysql_query($sql);
 	}else
	{
		$cmp1="SELECT COUNT(ID_PERMIT_S) as jml FROM v_stay_permit_sib WHERE NO_IZIN_PERMIT LIKE CONCAT('KAG/',date_format('2012-12-26','%y'),'/%')";

 		$res=mysql_query($cmp1);
		$jml1=mysql_fetch_array($res);
		
		$cmp2="SELECT COUNT(ID_PERMIT) as jml FROM v_stay_permit WHERE NO_IZIN_PERMIT LIKE CONCAT('KAG/',date_format('2012-12-26','%y'),'/%')";
		$res2=mysql_query($cmp2);
		$jml2=mysql_fetch_array($res2);
		
		$urut_permit=$jml1['jml']+$jml2['jml']+1;

		$sql="insert into permit_diplomat (ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,TGL_AGENDA,NO_IZIN_PERMIT,TGL_AWAL_PERMIT,TGL_AKHIR_PERMIT,KET,ST_PERMIT,ST_PERMIT_K,ST_PERMIT_KAS,NO_NOTA,TGL_NOTA) values ($ID_DIPLOMAT,$ID_JNS_PERMIT,'$NO_AGENDA','$TGL_AGENDA','$NO_IZIN_PERMIT','$TGL_AWAL_PERMIT','$TGL_AKHIR_PERMIT','$KET','$KETVER','$KETHOR',1,1,1,'$NO_NOTA','$TGL_NOTA')";
	//automatic generate code
	//(SELECT CONCAT('KAF/',date_format('$TGL_AGENDA','%y'),'/',(SELECT KD_JNS_PASPOR FROM v_diplomat WHERE ID_DIPLOMAT = $ID_DIPLOMAT),'/',$urut_permit))
	//   echo $sql; 
	mysql_query($sql);	
	}

	if (!empty($_POST['syarat'])) {	
			//input persyaratan
			$query_max_idpermit = mysql_query("SELECT MAX(id_permit) as max FROM PERMIT_DIPLOMAT"); 
			$max=mysql_fetch_array($query_max_idpermit);
			$max=$max['max'];
			
			foreach ($_POST['syarat'] as $syarat) {
				$insert_syarat = mysql_query("INSERT INTO syarat_permit (syarat_kd, id_permit) VALUES ('".$syarat."','".$max."')");
			}
		}
	header('location: ./deplu.php?module='.$module.'&act=lihat_stay_permit&idt='.$ID_DIPLOMAT.'&negara='.$neg);

	} // if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
}	//if  ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT )
}	//if ($b[TGL_MAX] <=  $TGL_AWAL_PERMIT)


}
elseif ($module=='staypermit' AND $act=='hapus' AND isset($_GET[idt])){
	$idd = $_GET[idd];
  mysql_query("DELETE FROM permit_diplomat WHERE ID_PERMIT ='$_GET[idt]'");
  	  $sql="select distinct(a.syarat_kd) from m_syarat a, syarat_permit b  WHERE a.jenis_izin='1' and b.id_permit='$_GET[idt]'";
 	  $query = mysql_query($sql);
	  while ($data=mysql_fetch_array($query)) {
 	 	 mysql_query("DELETE FROM syarat_permit WHERE syarat_kd='".$data['syarat_kd']."'");
  	  }

  
header('location: ./deplu.php?module='.$module.'&act=lihat_stay_permit&idt='.$idd.'&negara='.$neg);
 

}
elseif ($module=='staypermit' AND $act=='update' AND isset($_GET[idt])){
$idt = $_GET[idt];
  
$ID_PERMIT = $_POST[ID_PERMIT];
$ID_DIPLOMAT = $_POST[ID_DIPLOMAT];
$ID_JNS_PERMIT = $_POST[ID_JNS_PERMIT];
$NO_AGENDA = $_POST[NO_AGENDA];
$TGL_AGENDA = $_POST[TGL_AGENDA];
$VERIFIKASI = $_POST[statusverifikasi];
$JNS_IZIN_PERMIT = $_POST[JNS_IZIN_PERMIT];
$NO_IZIN_PERMIT = $_POST[NO_IZIN_PERMIT];
$TGL_AWAL_PERMIT = $_POST[TGL_AWAL_PERMIT];
$TGL_AMBIL = $_POST[TGL_AMBIL_BERKAS];
$TGL_AKHIR_PERMIT = $_POST[TGL_AKHIR_PERMIT];
$VERIFIKASI = $_POST[statusverifikasi];

//print_r($idt. ' sip');exit;
if ($VERIFIKASI == 2)
{
	$VERIFIKASI_AWAL = 3;
}
else
{
	$VERIFIKASI_AWAL = 1;
}
//print_r($VERIFIKASI_AWAL. ' sip');exit;
$KET = $_POST[KET];
$KETVER = $_POST[KET_VER];
$KETHOR = $_POST[KET_HOR];
$NO_NOTA = $_POST[NO_NOTA];
$TGL_NOTA = $_POST[TGL_NOTA];

if ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT ){
	$varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Ubah Data Gagal.</b><br>Tanggal awal harus lebih kecil dari tanggal berakhir. <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{

 $qSelect=mysql_query("select NM_DIPLOMAT,DATE_FORMAT(AKHIR_BERLAKU,'%d-%M-%Y') AS AKHIR_BERLAKU,date_add(AKHIR_BERLAKU, interval -180 day) as BATAS_PERMIT, DATE_FORMAT(date_add(AKHIR_BERLAKU, interval -180 day),'%d-%M-%Y') as BATAS_PERMIT_2 from diplomat where ID_DIPLOMAT = $ID_DIPLOMAT");
 $b=mysql_fetch_array($qSelect);
if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
	{
	 $varname =  "<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Ubah Data Gagal.</b><br>Tanggal akhir permit maksimal 180 hari sebelum masa berlaku paspor habis.<br>Masa Berlaku paspor milik <b>$b[NM_DIPLOMAT]</b> habis pada tanggal <b>$b[AKHIR_BERLAKU]</b> .<br>Batas Maksimal Tanggal akhir permit adalah <b>$b[BATAS_PERMIT_2]</b> . 
	 <br><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>";
	 $template = eregi_replace("{isi}",$varname,$template);
	 echo $template;

	}
	else{
		
		
		$a = "select distinct NO_DAFTAR,KD_WORKFLOW, NM_DIPLOMAT,TGL_AMBIL_BERKAS,TGL_AWAL_PERMIT, TGL_AKHIR_PERMIT,NO_IZIN_PERMIT, NM_JNS_PERMIT, EMAIL_EMBASSY from v_stay_permit where ID_PERMIT =  $idt";
	$b = mysql_query($a);
	$c = mysql_fetch_array($b);
	
	
	
	function sendemail($nodaftar,$nama,$tglawal,$tglakhir,$noizin,$jnspermit,$email,$kd_flow,$ket,$tglambil)
	{
		$to      = $email;
		//$noreg   = $nodaftar;
		$bcc	 = 'BCC : no-reply.sito@kemlu.go.id';
		//if 
		
		$messageapprove = "
		<html>
				<head>
				<title>Konfirmasi Ijin Tinggal Online</title>
				</head>
				<body>
				<p>Yth. $nama </p>
				
				<p>Ijin Tinggal anda telah di terima dengan data sebagai berikut :</p>
				
				No Permit : $noizin<br>
				Nama : $nama<br>
				Jenis : $jnspermit<br>	
				Masa Berlaku Izin : $tglawal s/d $tglakhir<br>				
				<br><br>
				
				<p>
				Atas perhatiannya kami ucapkan terima kasih.
				</p>
				
				<p>
				Salam Hormat,<br><br>
				Admin Ijin Tinggal Kementerian Luar Negeri RI
				</p>
				<br>
				<br>
				<hr><br>
				<small>Email ini dikirim secara otomatis oleh sistem. Harap tidak membalas ke alamat email ini. Pertanyaan dapat dikirimkan ke konsuler@kemlu.go.id. Terima kasih.</small>
				</body>
				</html>
		";
		$messagelolos = "
		<html>
				<head>
				<title>Konfirmasi Ijin Tinggal Online</title>
				</head>
				<body>
				<p>Yth. Pemohon </p>
				
				<p>Permohonan atas nama : <strong>$nama</strong> dengan nomor registrasi : <strong>$nodaftar</strong> telah disetujui, mohon agar dapat menyerahkan berkas sebagai berikut : <br>
				<br>
				<table>
				<tr>
				<td>- &nbsp;&nbsp;&nbsp;&nbsp;Kedutaan</td>
				<td>: </td>
				<td>nota diplomatik  dan paspor asli.</td>
				</tr>
				<tr>
				<td>- &nbsp;&nbsp;&nbsp;&nbsp;Organisasi Internasional</td>
				<td>: </td>
				<td>nota dinas setneg,surat sponsor, dan paspor asli.</td>
				</tr>
				<tr>
				<td>- &nbsp;&nbsp;&nbsp;&nbsp;Kementerian</td>
				<td>: </td>
				<td>nota dinas setneg, surat sponsor, dan paspor asli.</td>
				</tr>
				</table>
				ke loket konsuler pada tanggal $tglambil.</p>
				<br><br>Terima kasih
				<br>==========================================================<br>
				<p>To The Applicant</p>
				
				<p>Your application with the registration number : <strong>$nodaftar</strong> for <strong>$nama</strong> has been verified, kindly submit the original documents as followed : <br>
				<br>
				<table>
				<tr>
				<td>- &nbsp;&nbsp;&nbsp;&nbsp;Embassy</td>
				<td>: </td>
				<td>diplomatic note and passport.</td>
				</tr>
				<tr>
				<td>- &nbsp;&nbsp;&nbsp;&nbsp;International Organization</td>
				<td>: </td>
				<td>note from the state secretary, sponsorship letter, along with the original passport.</td>
				</tr>
				<tr>
				<td>- &nbsp;&nbsp;&nbsp;&nbsp;Ministry</td>
				<td>: </td>
				<td>original note from the state secretary, sponsorship letter, along with the original passport.</td>
				</tr>
				</table>
				to the consular counter  on this date $tglambil.</p>
				<br><br>Thank you.
				</body>
				</html>
		";
		
		$messagetolak = "
		<html>
				<head>
				<title>Konfirmasi Ijin Tinggal Online</title>
				</head>
				<body>
				<p>Yth. Pemohon </p>
				
				<p>
				Permohonan atas nama : <strong>$nama</strong> dengan nomor registrasi : <strong>$nodaftar</strong> belum disetujui,<br> dikarenakan $ket.<br> Terima Kasih
				</p>
				<br>=============================================================<br>
				<p>To The Applicant </p>
				
				<p>
				Your application with the registration number : <strong>$nodaftar</strong> for <strong>$nama</strong>  has not been approved,<br> because : $ket.<br> Thank you.
				</p>
				<br>
				</body>
				</html>
		";
		
		$messagelolosawal = "
		<html>
				<head>
				<title>Konfirmasi Ijin Tinggal Online</title>
				</head>
				<body>
				<p>Yth. $nama </p>
				
				<p>Permohonan anda dengan nomor registrasi : $nodaftar telah disetujui, mohon agar dapat mengambil berkas pada tanggal $tglambil.</p>
				<br>Silahkan datang ke Loket Konsuler Kementerian Luar Negeri Republik Indonesia
				<br>
				Jl. Pejambon 6 Jakarta Pusat 
				<br>
				
				<p>
				Atas perhatiannya kami ucapkan terima kasih.
				</p>
				
				<p>
				Salam Hormat,<br><br>
				Admin Ijin Tinggal Kementerian Luar Negeri RI
				</p>
				<br>
				<br>
				<hr><br>
				<small>Email ini dikirim secara otomatis oleh sistem. Harap tidak membalas ke alamat email ini. Pertanyaan dapat dikirimkan ke konsuler@kemlu.go.id. Terima kasih.</small>
				</body>
				</html>
		";
		$messagetolakawal = "
		<html>
				<head>
				<title>Konfirmasi Ijin Tinggal Online</title>
				</head>
				<body>
				<p>Yth. $nama </p>
				
				<p>
				Permohonan anda dengan nomor registrasi : $nodaftar belum disetujui.<br> keterangan : $ket.
				</p>
				
				<p>
				Atas perhatiannya kami ucapkan terima kasih.
				
				</p>
				
				<p>
				Salam Hormat,<br><br>
				Admin Ijin Tinggal Kementerian Luar Negeri RI
				</p>
				<br>
				<br>
				<hr><br>
				<small>Email ini dikirim secara otomatis oleh sistem. Harap tidak membalas ke alamat email ini. Pertanyaan dapat dikirimkan ke konsuler@kemlu.go.id. Terima kasih.</small>
				</body>
				</html>
		";
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: NO REPLY - Sistem Ijin Tinggal Online Kementerian Luar Negeri RI <no-reply.sito@kemlu.go.id>' . "\r\n".$bcc;
	
		if($kd_flow == 2)
		{
			$message = $messagelolos;
			$noreg1  = $nodaftar;
			$subject_temp = 'Konfirmasi Ijin Tinggal Online No. Daftar : '.$noreg1.' (DIPLOMAT) Disetujui / Stay Permit Confirmation Reg. No : '.$noreg1.' (DIPLOMAT) Approved';
			$subject = $subject_temp;
		}
		elseif($kd_flow == 1)
		{
			$message = $messagetolak;
			$noreg1  = $nodaftar;
			$subject = 'Konfirmasi Ijin Tinggal Online No. Daftar : '.$noreg1.' (DIPLOMAT) Ditolak / Stay Permit Confirmation Reg. No : '.$noreg1.' (DIPLOMAT) Rejected';
		}	
		
		return mail($to, $subject, $message, $headers);
		
	}
	
	if($VERIFIKASI == 1)
	{
		if($c['KD_WORKFLOW'] != 1)
		{	
		sendemail($c['NO_DAFTAR'],$c['NM_DIPLOMAT'],$c['TGL_AWAL_PERMIT'],$c['TGL_AKHIR_PERMIT'],$c['NO_IZIN_PERMIT'],$c['NM_JNS_PERMIT'],$c['EMAIL_EMBASSY'],$VERIFIKASI,$KET,$TGL_AMBIL);
		}
	}
	elseif($VERIFIKASI == 2)
	{
		if($c['KD_WORKFLOW'] != 3)
		{	
		sendemail($c['NO_DAFTAR'],$c['NM_DIPLOMAT'],$c['TGL_AWAL_PERMIT'],$c['TGL_AKHIR_PERMIT'],$c['NO_IZIN_PERMIT'],$c['NM_JNS_PERMIT'],$c['EMAIL_EMBASSY'],$VERIFIKASI,$KET,$TGL_AMBIL);
		}
	}
	
		mysql_query(" update permit_diplomat set ID_DIPLOMAT = $ID_DIPLOMAT,
											ID_JNS_PERMIT = $ID_JNS_PERMIT,
											NO_AGENDA = '$NO_AGENDA',
											TGL_AGENDA = '$TGL_AGENDA',
											NO_IZIN_PERMIT = '$NO_IZIN_PERMIT',
											JNS_IZIN_PERMIT = '$JNS_IZIN_PERMIT',
											TGL_AWAL_PERMIT = '$TGL_AWAL_PERMIT',
											TGL_AKHIR_PERMIT = '$TGL_AKHIR_PERMIT',
											TGL_AMBIL_BERKAS = '$TGL_AMBIL',
											KD_WORKFLOW = $VERIFIKASI_AWAL,
											KET  = '$KET',
											KETVER = '$KETVER',
											KETHOR = '$KETHOR',
											NO_NOTA = '$NO_NOTA',
											TGL_NOTA = '$TGL_NOTA'
											where ID_PERMIT =  $idt");
	//print_r($VERIFIKASI_AWAL. ' okeeee');exit;
	
	
 	if (!empty($_POST['syarat'])) {
			foreach ($_POST['syarat'] as $syarat) {
				$insert_syarat = mysql_query("INSERT INTO syarat_permit (syarat_kd, id_permit) VALUES ('".$syarat."','".$idt."')");
			}
	}
	
	header('location: ./deplu.php?module='.$module.'&act=lihat_stay_permit&idt='.$ID_DIPLOMAT.'&negara='.$neg);
	} // if  ($TGL_AKHIR_PERMIT > $b[BATAS_PERMIT])
}//if  ($TGL_AKHIR_PERMIT < $TGL_AWAL_PERMIT )
  
  }

}
?>
