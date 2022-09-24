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

if ($module=='diplomat' AND $act=='input'){


  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(000000,999999);
  $nama_file_unik = $acak.$nama_file;

  $lokasi_file_ttd    = $_FILES['fuploadttd']['tmp_name'];
  $tipe_file_ttd       = $_FILES['fuploadttd']['type'];
  $nama_file_ttd      = $_FILES['fuploadttd']['name'];
  $nama_file_unik_ttd = $acak.$nama_file_ttd;


$ID_NEGARA = $_POST[ID_NEGARA];
$ID_KNT_PERWAKILAN = $_POST[ID_KNT_PERWAKILAN];
$KATEGORI_PEMOHON = $_POST[KATEGORI_PEMOHON];
$INPUT_DATE = date('Y-m-d h:i:s');
$ID_JNS_PASPOR = $_POST[ID_JNS_PASPOR];
$ID_JNS_VISA = $_POST[ID_JNS_VISA];
$NM_DIPLOMAT = $_POST[NM_DIPLOMAT];
$TEMPAT_LAHIR = strtoupper($_POST[TEMPAT_LAHIR]);
$TGL_LAHIR = $_POST[TGL_LAHIR];
$JK = $_POST[JK];
//$PEKERJAAN = strtoupper($_POST[PEKERJAAN]);
$PEKERJAAN = $_POST[PEKERJAAN];
$GELAR = strtoupper($_POST[GELAR]);
$ALAMATLN = strtoupper($_POST[ALAMATLN]);
$ST_SIPIL = $_POST[ST_SIPIL];
$NO_PASPOR = strtoupper($_POST[NO_PASPOR]);
$PASPOR_OLEH = strtoupper($_POST[PASPOR_OLEH]);
$PASPOR_TGL = $_POST[PASPOR_TGL];
$AKHIR_BERLAKU = $_POST[AKHIR_BERLAKU];
$NO_VISA = strtoupper($_POST[NO_VISA]);
$VISA_OLEH = strtoupper($_POST[VISA_OLEH]);
$ST_VISA = $_POST[ST_VISA];
$ID_RANK = $_POST[ID_RANK];
$TELP = strtoupper($_POST[TELP]);

if (isset($_POST[LAMA_BERDIAM]) and $_POST[LAMA_BERDIAM] != ''){
$LAMA_BERDIAM = $_POST[LAMA_BERDIAM];}
else
{$LAMA_BERDIAM = '0';}

if (isset($_POST[LAMA_BERDIAM_BLN]) and $_POST[LAMA_BERDIAM_BLN] != ''){
$LAMA_BERDIAM_BLN = $_POST[LAMA_BERDIAM_BLN];}
else
{$LAMA_BERDIAM_BLN = '0';}

$TGL_TIBA = $_POST[TGL_TIBA];
$ALAMATIN = strtoupper($_POST[ALAMATIN]);
$NO_SETKAB = strtoupper($_POST[NO_SETKAB]);
$BERLAKUSD = $_POST[BERLAKUSD];
$NO_SPONSOR = strtoupper($_POST[NO_SPONSOR]);
$NO_SR_SETNEG = strtoupper($_POST[NO_SR_SETNEG]);

$TGL_CREDENTIAL = $_POST[TGL_CREDENTIAL];
if($TGL_CREDENTIAL=='1899-11-30'){
	$TGL_CREDENTIAL = null;
}

  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){

  		$varname =  "Gagal menyimpan data !!! <br>
              Tipe file <b>$nama_file</b> : $tipe_file <br>
              Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
  		//$template = eregi_replace("{isi}",$varname,$template);
		$template = preg_match("/{isi}/",$varname,$template);
  		echo $template;
  	  }
      else{
        if (!empty($lokasi_file_ttd)){
            if ($tipe_file_ttd != "image/jpeg" AND $tipe_file_ttd != "image/pjpeg"){
              $varname =  "Gagal menyimpan data !!! <br>
                    Tipe file <b>$nama_file_ttd</b> : $tipe_file_ttd <br>
                    Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
        		  $template = preg_match("/{isi}/",$varname,$template);
        		  echo $template;
        	  }
        	  else{
            move_uploaded_file($lokasi_file,"../foto/$nama_file_unik");
            move_uploaded_file($lokasi_file_ttd,"../foto/ttd/$nama_file_unik_ttd");
        	   $sql= "insert into diplomat (ID_NEGARA,ID_RANK,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,TGL_LAHIR,JK,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,PASPOR_TGL,AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,TGL_TIBA,ALAMATIN,NO_SETKAB,BERLAKUSD,NO_SPONSOR,ST_VISA,NO_SR_SETNEG,LAMA_BERDIAM_BLN,TELP,FOTO,FOTO_TTD,GELAR,KATEGORI_PEMOHON,INPUT_DATE,TGL_CREDENTIAL) values ($ID_NEGARA,$ID_RANK,$ID_KNT_PERWAKILAN,$ID_JNS_PASPOR,$ID_JNS_VISA,'$NM_DIPLOMAT','$TEMPAT_LAHIR','$TGL_LAHIR','$JK','$PEKERJAAN','$ALAMATLN','$ST_SIPIL','$NO_PASPOR','$PASPOR_OLEH','$PASPOR_TGL','$AKHIR_BERLAKU','$NO_VISA','$VISA_OLEH',$LAMA_BERDIAM,'$TGL_TIBA','$ALAMATIN','$NO_SETKAB','$BERLAKUSD','$NO_SPONSOR',$ST_VISA,'$NO_SR_SETNEG',$LAMA_BERDIAM_BLN,'$TELP','$nama_file_unik','$nama_file_unik_ttd','$GELAR','$KATEGORI_PEMOHON','$INPUT_DATE','$TGL_CREDENTIAL')";
		//	   echo $sql; exit;
			$input = mysql_query($sql);
     }
        }else{
             move_uploaded_file($lokasi_file,"../foto/$nama_file_unik");
        	   $input = mysql_query("insert into diplomat (ID_NEGARA,ID_RANK,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,TGL_LAHIR,JK,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,PASPOR_TGL,AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,TGL_TIBA,ALAMATIN,NO_SETKAB,BERLAKUSD,NO_SPONSOR,ST_VISA,NO_SR_SETNEG,LAMA_BERDIAM_BLN,TELP,FOTO,FOTO_TTD,GELAR,KATEGORI_PEMOHON,INPUT_DATE,TGL_CREDENTIAL) values ($ID_NEGARA,$ID_RANK,$ID_KNT_PERWAKILAN,$ID_JNS_PASPOR,$ID_JNS_VISA,'$NM_DIPLOMAT','$TEMPAT_LAHIR','$TGL_LAHIR','$JK','$PEKERJAAN','$ALAMATLN','$ST_SIPIL','$NO_PASPOR','$PASPOR_OLEH','$PASPOR_TGL','$AKHIR_BERLAKU','$NO_VISA','$VISA_OLEH',$LAMA_BERDIAM,'$TGL_TIBA','$ALAMATIN','$NO_SETKAB','$BERLAKUSD','$NO_SPONSOR',$ST_VISA,'$NO_SR_SETNEG',$LAMA_BERDIAM_BLN,'$TELP','$nama_file_unik','','$GELAR','$KATEGORI_PEMOHON','$INPUT_DATE','$TGL_CREDENTIAL')");
        }
     }
   }
   else{
        if (!empty($lokasi_file_ttd)){
            if ($tipe_file_ttd != "image/jpeg" AND $tipe_file_ttd != "image/pjpeg"){
              $varname =  "Gagal menyimpan data !!! <br>
                    Tipe file <b>$nama_file_ttd</b> : $tipe_file_ttd <br>
                    Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
        		  $template = preg_match("/{isi}/",$varname,$template);
        		  echo $template;
        	  }
        	  else{
            move_uploaded_file($lokasi_file_ttd,"../foto/ttd/$nama_file_unik_ttd");
        	   $input = mysql_query("insert into diplomat (ID_NEGARA,ID_RANK,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,TGL_LAHIR,JK,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,PASPOR_TGL,AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,TGL_TIBA,ALAMATIN,NO_SETKAB,BERLAKUSD,NO_SPONSOR,ST_VISA,NO_SR_SETNEG,LAMA_BERDIAM_BLN,TELP,FOTO,FOTO_TTD,GELAR,KATEGORI_PEMOHON,INPUT_DATE, TGL_CREDENTIAL) values ($ID_NEGARA,$ID_RANK,$ID_KNT_PERWAKILAN,$ID_JNS_PASPOR,$ID_JNS_VISA,'$NM_DIPLOMAT','$TEMPAT_LAHIR','$TGL_LAHIR','$JK','$PEKERJAAN','$ALAMATLN','$ST_SIPIL','$NO_PASPOR','$PASPOR_OLEH','$PASPOR_TGL','$AKHIR_BERLAKU','$NO_VISA','$VISA_OLEH',$LAMA_BERDIAM,'$TGL_TIBA','$ALAMATIN','$NO_SETKAB','$BERLAKUSD','$NO_SPONSOR',$ST_VISA,'$NO_SR_SETNEG',$LAMA_BERDIAM_BLN,'$TELP','','$nama_file_unik_ttd','$GELAR','$KATEGORI_PEMOHON','$INPUT_DATE','$TGL_CREDENTIAL')");

            }
        }else{
             $input = mysql_query("insert into diplomat (ID_NEGARA,ID_RANK,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,TGL_LAHIR,JK,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,PASPOR_TGL,AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,TGL_TIBA,ALAMATIN,NO_SETKAB,BERLAKUSD,NO_SPONSOR,ST_VISA,NO_SR_SETNEG,LAMA_BERDIAM_BLN,TELP,FOTO,FOTO_TTD,GELAR,KATEGORI_PEMOHON,INPUT_DATE, TGL_CREDENTIAL) values ($ID_NEGARA,$ID_RANK,$ID_KNT_PERWAKILAN,$ID_JNS_PASPOR,$ID_JNS_VISA,'$NM_DIPLOMAT','$TEMPAT_LAHIR','$TGL_LAHIR','$JK','$PEKERJAAN','$ALAMATLN','$ST_SIPIL','$NO_PASPOR','$PASPOR_OLEH','$PASPOR_TGL','$AKHIR_BERLAKU','$NO_VISA','$VISA_OLEH',$LAMA_BERDIAM,'$TGL_TIBA','$ALAMATIN','$NO_SETKAB','$BERLAKUSD','$NO_SPONSOR',$ST_VISA,'$NO_SR_SETNEG',$LAMA_BERDIAM_BLN,'$TELP','','','$GELAR','$KATEGORI_PEMOHON','$INPUT_DATE','$TGL_CREDENTIAL')");
        }
  }


	   header('location: ./deplu.php?module='.$module.'&negara='.$neg);


}
elseif ($module=='diplomat' AND $act=='hapus' AND isset($_GET[idt])){

  mysql_query("DELETE FROM diplomat WHERE ID_DIPLOMAT ='$_GET[idt]'");

  header('location: ./deplu.php?module='.$module.'&negara='.$neg);
}
elseif ($module=='diplomat' AND $act=='update' AND isset($_POST[idt])){

$ID_NEGARA = $_POST[ID_NEGARA];
$KATEGORI_PEMOHON = $_POST[KATEGORI_PEMOHON];
$ID_KNT_PERWAKILAN = $_POST[ID_KNT_PERWAKILAN];
$ID_JNS_PASPOR = $_POST[ID_JNS_PASPOR];
$ID_JNS_VISA = $_POST[ID_JNS_VISA];
//$NM_DIPLOMAT = $_POST[NM_DIPLOMAT];
$NM_DIPLOMAT = str_replace("'","''",$_POST[NM_DIPLOMAT]);
$TEMPAT_LAHIR = strtoupper($_POST[TEMPAT_LAHIR]);
$TGL_LAHIR = $_POST[TGL_LAHIR];
$GELAR = $_POST[GELAR];
$JK = $_POST[JK];
//$PEKERJAAN = strtoupper($_POST[PEKERJAAN]);
$PEKERJAAN = $_POST[PEKERJAAN];
$ALAMATLN = strtoupper($_POST[ALAMATLN]);
$ST_SIPIL = $_POST[ST_SIPIL];
$NO_PASPOR = strtoupper($_POST[NO_PASPOR]);
$PASPOR_OLEH = strtoupper($_POST[PASPOR_OLEH]);
$PASPOR_TGL = $_POST[PASPOR_TGL];
$AKHIR_BERLAKU = $_POST[AKHIR_BERLAKU];
$NO_VISA = strtoupper($_POST[NO_VISA]);
$VISA_OLEH = strtoupper($_POST[VISA_OLEH]);
$ST_VISA = $_POST[ST_VISA];
$ID_RANK = $_POST[ID_RANK];
$TELP = strtoupper($_POST[TELP]);

if (isset($_POST[LAMA_BERDIAM]) and $_POST[LAMA_BERDIAM] != ''){
$LAMA_BERDIAM = $_POST[LAMA_BERDIAM];}
else
{$LAMA_BERDIAM = '0';}

if (isset($_POST[LAMA_BERDIAM_BLN]) and $_POST[LAMA_BERDIAM_BLN] != ''){
$LAMA_BERDIAM_BLN = $_POST[LAMA_BERDIAM_BLN];}
else
{$LAMA_BERDIAM_BLN = '0';}

$TGL_TIBA = $_POST[TGL_TIBA];
$ALAMATIN = strtoupper($_POST[ALAMATIN]);
$NO_SETKAB = strtoupper($_POST[NO_SETKAB]);
$BERLAKUSD = $_POST[BERLAKUSD];
$NO_SPONSOR = strtoupper($_POST[NO_SPONSOR]);
$NO_SR_SETNEG = strtoupper($_POST[NO_SR_SETNEG]);

$KET_DEAN = $_POST[DEAN];
$TGL_CREDENTIAL = $_POST[TGL_CREDENTIAL];
if($TGL_CREDENTIAL=='1899-11-30'){
	$TGL_CREDENTIAL = null;
}



  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(000000,999999);
  $nama_file_unik = $acak.$nama_file;

  $lokasi_file_ttd    = $_FILES['fuploadttd']['tmp_name'];
  $tipe_file_ttd       = $_FILES['fuploadttd']['type'];
  $nama_file_ttd      = $_FILES['fuploadttd']['name'];
  $nama_file_unik_ttd = $acak.$nama_file_ttd;


  // Apabila gambar tidak diganti
    if (empty($lokasi_file) && empty($lokasi_file_ttd)){
		if($_SESSION[G_leveluser]=='20'){
			$a=$_GET[idb];
			$update_jbt = mysql_query("update diplomat set PEKERJAAN = '$PEKERJAAN',
																				TGL_CREDENTIAL = '$TGL_CREDENTIAL',
																				KET_DEAN='$KET_DEAN'

        												where ID_DIPLOMAT ='$_POST[idt]'");

				$pesan = "<script type='text/javascript'>
                        alert('Update Berhasil!!');
						document.location.href='./deplu.php?module=diplist&act=viewdiplist&idt='+$a;
                    </script>";
			 if($update_jbt == 1){
					echo $pesan;
			}else{
					echo"<script type='text/javascript'>
                        alert('Update GAGAL!!');
						document.location.href='./deplu.php?module=diplist&act=viewdiplist&idt='+$a;
                    </script>";
			}
		}else{

		mysql_query("update diplomat set ID_NEGARA = $ID_NEGARA,
        									ID_RANK = $ID_RANK,
        									ID_KNT_PERWAKILAN = $ID_KNT_PERWAKILAN,
        									ID_JNS_PASPOR = $ID_JNS_PASPOR,
        									ID_JNS_VISA = $ID_JNS_VISA,
        									NM_DIPLOMAT = '$NM_DIPLOMAT',
        									TEMPAT_LAHIR = '$TEMPAT_LAHIR',
        									TGL_LAHIR = '$TGL_LAHIR',
        									GELAR = '$GELAR',
        									JK = '$JK' ,
        									PEKERJAAN = '$PEKERJAAN',
        									ALAMATLN = '$ALAMATLN',
        									ST_SIPIL = '$ST_SIPIL',
        									NO_PASPOR = '$NO_PASPOR',
        									PASPOR_OLEH = '$PASPOR_OLEH',
        									PASPOR_TGL = '$PASPOR_TGL',
        									AKHIR_BERLAKU = '$AKHIR_BERLAKU',
        									NO_VISA = '$NO_VISA',
        									VISA_OLEH = '$VISA_OLEH' ,
        									LAMA_BERDIAM = $LAMA_BERDIAM,
        									TGL_TIBA = '$TGL_TIBA',
        									ALAMATIN = '$ALAMATIN',
        									NO_SETKAB = '$NO_SETKAB' ,
        									BERLAKUSD = '$BERLAKUSD',
        									NO_SPONSOR = '$NO_SPONSOR',
        									ST_VISA = $ST_VISA,
        									NO_SR_SETNEG = '$NO_SR_SETNEG',
        									LAMA_BERDIAM_BLN = $LAMA_BERDIAM_BLN,
        									TELP = '$TELP',
											KATEGORI_PEMOHON='$KATEGORI_PEMOHON'

        									where ID_DIPLOMAT ='$_POST[idt]'");
        	header('location: ./deplu.php?module='.$module.'&negara='.$neg);
		}

	}
	//apabila gambar foto di ganti tanda tangan tidak
     if (!empty($lokasi_file) && empty($lokasi_file_ttd)){

	 // Apabila tipe gambar 2 bukan jpeg akan tampil peringatan
          if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
            $varname =  "Gagal menyimpan data !!! <br>
                    Tipe file <b>$nama_file</b> : $tipe_file <br>
                    Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
        		$template = preg_match("/{isi}/",$varname,$template);
        		echo $template;
			}
			else {
            move_uploaded_file($lokasi_file,"../foto/$nama_file_unik");
        	  mysql_query("update diplomat set ID_NEGARA = $ID_NEGARA,
        									ID_RANK = $ID_RANK,
        									ID_KNT_PERWAKILAN = $ID_KNT_PERWAKILAN,
        									ID_JNS_PASPOR = $ID_JNS_PASPOR,
        									ID_JNS_VISA = $ID_JNS_VISA,
        									NM_DIPLOMAT = '$NM_DIPLOMAT',
        									TEMPAT_LAHIR = '$TEMPAT_LAHIR',
        									GELAR = '$GELAR',
        									TGL_LAHIR = '$TGL_LAHIR',
        									JK = '$JK' ,
        									PEKERJAAN = '$PEKERJAAN',
        									ALAMATLN = '$ALAMATLN',
        									ST_SIPIL = '$ST_SIPIL',
        									NO_PASPOR = '$NO_PASPOR',
        									PASPOR_OLEH = '$PASPOR_OLEH',
        									PASPOR_TGL = '$PASPOR_TGL',
        									AKHIR_BERLAKU = '$AKHIR_BERLAKU',
        									NO_VISA = '$NO_VISA',
        									VISA_OLEH = '$VISA_OLEH' ,
        									LAMA_BERDIAM = $LAMA_BERDIAM,
        									TGL_TIBA = '$TGL_TIBA',
        									ALAMATIN = '$ALAMATIN',
        									NO_SETKAB = '$NO_SETKAB' ,
        									BERLAKUSD = '$BERLAKUSD',
        									NO_SPONSOR = '$NO_SPONSOR',
        									ST_VISA = $ST_VISA,
        									FOTO =  '$nama_file_unik',
        									NO_SR_SETNEG = '$NO_SR_SETNEG',
        									LAMA_BERDIAM_BLN = $LAMA_BERDIAM_BLN,
        									TELP = '$TELP',
											KATEGORI_PEMOHON='$KATEGORI_PEMOHON',
											TGL_CREDENTIAL='$TGL_CREDENTIAL'
        									where ID_DIPLOMAT ='$_POST[idt]'");

        	  header('location: ./deplu.php?module='.$module.'&negara='.$neg);
			}
	 }
	 	//apabila gambar foto tidak tanda tangan di ganti
     if (empty($lokasi_file) && !empty($lokasi_file_ttd)){
		if ($tipe_file_ttd != "image/jpeg" AND $tipe_file_ttd != "image/pjpeg"){
		  $varname =  "Gagal menyimpan data !!! <br>
				  Tipe file <b>$nama_file_ttd</b> : $tipe_file_ttd <br>
				  Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
			$template = eregi_replace("/{isi}/",$varname,$template);
			echo $template;
 		}
		else{
             move_uploaded_file($lokasi_file_ttd,"../foto/ttd/$nama_file_unik_ttd");
        	  mysql_query("update diplomat set ID_NEGARA = $ID_NEGARA,
        									ID_RANK = $ID_RANK,
        									ID_KNT_PERWAKILAN = $ID_KNT_PERWAKILAN,
        									ID_JNS_PASPOR = $ID_JNS_PASPOR,
        									ID_JNS_VISA = $ID_JNS_VISA,
        									NM_DIPLOMAT = '$NM_DIPLOMAT',
        									TEMPAT_LAHIR = '$TEMPAT_LAHIR',
        									GELAR = '$GELAR',
        									TGL_LAHIR = '$TGL_LAHIR',
        									JK = '$JK' ,
        									PEKERJAAN = '$PEKERJAAN',
        									ALAMATLN = '$ALAMATLN',
        									ST_SIPIL = '$ST_SIPIL',
        									NO_PASPOR = '$NO_PASPOR',
        									PASPOR_OLEH = '$PASPOR_OLEH',
        									PASPOR_TGL = '$PASPOR_TGL',
        									AKHIR_BERLAKU = '$AKHIR_BERLAKU',
        									NO_VISA = '$NO_VISA',
        									VISA_OLEH = '$VISA_OLEH' ,
        									LAMA_BERDIAM = $LAMA_BERDIAM,
        									TGL_TIBA = '$TGL_TIBA',
        									ALAMATIN = '$ALAMATIN',
        									NO_SETKAB = '$NO_SETKAB' ,
        									BERLAKUSD = '$BERLAKUSD',
        									NO_SPONSOR = '$NO_SPONSOR',
        									ST_VISA = $ST_VISA,
        									FOTO_TTD =  '$nama_file_unik_ttd',
        									NO_SR_SETNEG = '$NO_SR_SETNEG',
        									LAMA_BERDIAM_BLN = $LAMA_BERDIAM_BLN,
        									TELP = '$TELP',
											KATEGORI_PEMOHON='$KATEGORI_PEMOHON',
											TGL_CREDENTIAL='$TGL_CREDENTIAL'
        									where ID_DIPLOMAT ='$_POST[idt]'");
        	  header('location: ./deplu.php?module='.$module.'&negara='.$neg);
			}

		}
   	 	//apabila gambar foto di ganti tanda tangan di ganti
      if (!empty($lokasi_file) && !empty($lokasi_file_ttd)){
		if (($tipe_file_ttd != "image/jpeg" AND $tipe_file_ttd != "image/pjpeg") AND ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg")){
		  $varname =  "Gagal menyimpan data !!! <br>
				  Tipe file yang diupload bukan JPG/JPEG <br>
				  Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
			$template = eregi_replace("/{isi}/",$varname,$template);
			echo $template;
 		}
		else{
             move_uploaded_file($lokasi_file_ttd,"../foto/ttd/$nama_file_unik_ttd");
             move_uploaded_file($lokasi_file_ttd,"../foto/ttd/$nama_file_unik");
        	  mysql_query("update diplomat set ID_NEGARA = $ID_NEGARA,
        									ID_RANK = $ID_RANK,
        									ID_KNT_PERWAKILAN = $ID_KNT_PERWAKILAN,
        									ID_JNS_PASPOR = $ID_JNS_PASPOR,
        									ID_JNS_VISA = $ID_JNS_VISA,
        									NM_DIPLOMAT = '$NM_DIPLOMAT',
        									TEMPAT_LAHIR = '$TEMPAT_LAHIR',
        									GELAR = '$GELAR',
        									TGL_LAHIR = '$TGL_LAHIR',
        									JK = '$JK' ,
        									PEKERJAAN = '$PEKERJAAN',
        									ALAMATLN = '$ALAMATLN',
        									ST_SIPIL = '$ST_SIPIL',
        									NO_PASPOR = '$NO_PASPOR',
        									PASPOR_OLEH = '$PASPOR_OLEH',
        									PASPOR_TGL = '$PASPOR_TGL',
        									AKHIR_BERLAKU = '$AKHIR_BERLAKU',
        									NO_VISA = '$NO_VISA',
        									VISA_OLEH = '$VISA_OLEH' ,
        									LAMA_BERDIAM = $LAMA_BERDIAM,
        									TGL_TIBA = '$TGL_TIBA',
        									ALAMATIN = '$ALAMATIN',
        									NO_SETKAB = '$NO_SETKAB' ,
        									BERLAKUSD = '$BERLAKUSD',
        									NO_SPONSOR = '$NO_SPONSOR',
        									ST_VISA = $ST_VISA,
        									FOTO =  '$nama_file_unik',
        									FOTO_TTD =  '$nama_file_unik_ttd',
        									NO_SR_SETNEG = '$NO_SR_SETNEG',
        									LAMA_BERDIAM_BLN = $LAMA_BERDIAM_BLN,
        									TELP = '$TELP',
											KATEGORI_PEMOHON='$KATEGORI_PEMOHON',
											TGL_CREDENTIAL='$TGL_CREDENTIAL'
        									where ID_DIPLOMAT ='$_POST[idt]'");
        	  header('location: ./deplu.php?module='.$module.'&negara='.$neg);
			}

		}
	}
 } //if session ok
?>
