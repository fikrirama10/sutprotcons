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

if ($module=='sibling' AND $act=='input'){

	//tambahan PROVINSI DAN KABUPATEN/Kota
		$REGENCY_ID = $_POST[REGENCY_ID];
		$PROVINCE_ID = $_POST[PROVINCE_ID];

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
$ID_JNS_RELASI = $_POST[ID_JNS_RELASI];
$ID_DIPLOMAT = $_POST[ID_DIPLOMAT];
$ID_JNS_PASPOR = $_POST[ID_JNS_PASPOR];
$ID_JNS_VISA = $_POST[ID_JNS_VISA];
$NM_SIBLING= htmlspecialchars(strtoupper($_POST[NM_SIBLING]), ENT_QUOTES);
$TEMPAT_LAHIR = htmlspecialchars(strtoupper($_POST[TEMPAT_LAHIR]), ENT_QUOTES);
$TGL_LAHIR = $_POST[TGL_LAHIR];
$JK = $_POST[JK];
$PEKERJAAN = htmlspecialchars($_POST[PEKERJAAN], ENT_QUOTES);
$ALAMATLN = htmlspecialchars(strtoupper($_POST[ALAMATLN]), ENT_QUOTES);
$ST_SIPIL = $_POST[ST_SIPIL];
$NO_PASPOR = strtoupper($_POST[NO_PASPOR]);
$PASPOR_OLEH = strtoupper($_POST[PASPOR_OLEH]);
$PASPOR_TGL = $_POST[PASPOR_TGL];
$AKHIR_BERLAKU = $_POST[AKHIR_BERLAKU];
$NO_VISA = strtoupper($_POST[NO_VISA]);
$VISA_OLEH = strtoupper($_POST[VISA_OLEH]);

if (isset($_POST[LAMA_BERDIAM]) and $_POST[LAMA_BERDIAM] != ''){
$LAMA_BERDIAM = $_POST[LAMA_BERDIAM];}
else
{$LAMA_BERDIAM = '0';}



$TGL_TIBA = $_POST[TGL_TIBA];
$ALAMATIN = htmlspecialchars(strtoupper($_POST[ALAMATIN]), ENT_QUOTES);
$NO_SETKAB = strtoupper($_POST[NO_SETKAB]);
$BERLAKUSD = $_POST[BERLAKUSD];
$NO_SPONSOR = strtoupper($_POST[NO_SPONSOR]);
$ST_VISA = $_POST[ST_VISA];
$TELP = strtoupper($_POST[TELP]);
$NO_SR_SETNEG = strtoupper($_POST[NO_SR_SETNEG]);

if (isset($_POST[LAMA_BERDIAM_BLN]) and $_POST[LAMA_BERDIAM_BLN] != ''){
$LAMA_BERDIAM_BLN = $_POST[LAMA_BERDIAM_BLN];}
else
{$LAMA_BERDIAM_BLN = '0';}

  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
    // Apabila tipe gambar bukan jpeg akan tampil peringatan
          if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){

      		$varname =  "Gagal menyimpan data !!! <br>
                  Tipe file <b>$nama_file</b> : $tipe_file <br>
                  Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
      		$template = eregi_replace("{isi}",$varname,$template);
      		echo $template;


      	}
          else{
              if (!empty($lokasi_file_ttd)){
                  if ($tipe_file_ttd != "image/jpeg" AND $tipe_file_ttd != "image/pjpeg"){
                    $varname =  "Gagal menyimpan data !!! <br>
                          Tipe file <b>$nama_file_ttd</b> : $tipe_file_ttd <br>
                          Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
              		  $template = eregi_replace("{isi}",$varname,$template);
              		  echo $template;
              	  }
              	  else{
                     move_uploaded_file($lokasi_file,"../foto sibling/$nama_file_unik");
                  	 move_uploaded_file($lokasi_file_ttd,"../foto sibling/ttd/$nama_file_unik_ttd");
          	         $input = mysql_query("insert into sibling (ID_NEGARA,ID_JNS_RELASI,ID_DIPLOMAT,ID_JNS_PASPOR,ID_JNS_VISA,NM_SIBLING,TEMPAT_LAHIR,TGL_LAHIR,JK,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,PASPOR_TGL,AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,TGL_TIBA,ALAMATIN,NO_SETKAB,BERLAKUSD,NO_SPONSOR,LAMA_BERDIAM_BLN,ST_VISA,TELP,NO_SR_SETNEG,FOTO,FOTO_TTD,PROVINCE_ID, REGENCY_ID) values ($ID_NEGARA,$ID_JNS_RELASI,$ID_DIPLOMAT,$ID_JNS_PASPOR,$ID_JNS_VISA,'$NM_SIBLING','$TEMPAT_LAHIR','$TGL_LAHIR','$JK','$PEKERJAAN','$ALAMATLN','$ST_SIPIL','$NO_PASPOR','$PASPOR_OLEH','$PASPOR_TGL','$AKHIR_BERLAKU','$NO_VISA','$VISA_OLEH',$LAMA_BERDIAM,'$TGL_TIBA','$ALAMATIN','$NO_SETKAB','$BERLAKUSD','$NO_SPONSOR',$LAMA_BERDIAM_BLN,'$ST_VISA','$TELP','$NO_SR_SETNEG','$nama_file_unik','$nama_file_unik_ttd','$PROVINCE_ID', '$REGENCY_ID')");


                  }
              }else
              {
                 move_uploaded_file($lokasi_file,"../foto sibling/$nama_file_unik");
            	   $input = mysql_query("insert into sibling (ID_NEGARA,ID_JNS_RELASI,ID_DIPLOMAT,ID_JNS_PASPOR,ID_JNS_VISA,NM_SIBLING,TEMPAT_LAHIR,TGL_LAHIR,JK,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,PASPOR_TGL,AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,TGL_TIBA,ALAMATIN,NO_SETKAB,BERLAKUSD,NO_SPONSOR,LAMA_BERDIAM_BLN,ST_VISA,TELP,NO_SR_SETNEG,FOTO,FOTO_TTD,PROVINCE_ID, REGENCY_ID) values ($ID_NEGARA,$ID_JNS_RELASI,$ID_DIPLOMAT,$ID_JNS_PASPOR,$ID_JNS_VISA,'$NM_SIBLING','$TEMPAT_LAHIR','$TGL_LAHIR','$JK','$PEKERJAAN','$ALAMATLN','$ST_SIPIL','$NO_PASPOR','$PASPOR_OLEH','$PASPOR_TGL','$AKHIR_BERLAKU','$NO_VISA','$VISA_OLEH',$LAMA_BERDIAM,'$TGL_TIBA','$ALAMATIN','$NO_SETKAB','$BERLAKUSD','$NO_SPONSOR',$LAMA_BERDIAM_BLN,'$ST_VISA','$TELP','$NO_SR_SETNEG','$nama_file_unik','','$PROVINCE_ID', '$REGENCY_ID')");
              } //IF FILE 2 EMPTY


         }//IF NOT IMAGE

   }
   else{//IF IMAGE 1 EMPTY


	  if (!empty($lokasi_file_ttd)){
            if ($tipe_file_ttd != "image/jpeg" AND $tipe_file_ttd != "image/pjpeg"){
              $varname =  "Gagal menyimpan data !!! <br>
                    Tipe file <b>$nama_file_ttd</b> : $tipe_file_ttd <br>
                    Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
        		  $template = eregi_replace("{isi}",$varname,$template);
        		  echo $template;
        	  }
        	  else{
             move_uploaded_file($lokasi_file_ttd,"../foto sibling/ttd/$nama_file_unik_ttd");
  	         $input = mysql_query("insert into sibling (ID_NEGARA,ID_JNS_RELASI,ID_DIPLOMAT,ID_JNS_PASPOR,ID_JNS_VISA,NM_SIBLING,TEMPAT_LAHIR,TGL_LAHIR,JK,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,PASPOR_TGL,AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,TGL_TIBA,ALAMATIN,NO_SETKAB,BERLAKUSD,NO_SPONSOR,LAMA_BERDIAM_BLN,ST_VISA,TELP,NO_SR_SETNEG,FOTO,FOTO_TTD,PROVINCE_ID, REGENCY_ID) values ($ID_NEGARA,$ID_JNS_RELASI,$ID_DIPLOMAT,$ID_JNS_PASPOR,$ID_JNS_VISA,'$NM_SIBLING','$TEMPAT_LAHIR','$TGL_LAHIR','$JK','$PEKERJAAN','$ALAMATLN','$ST_SIPIL','$NO_PASPOR','$PASPOR_OLEH','$PASPOR_TGL','$AKHIR_BERLAKU','$NO_VISA','$VISA_OLEH',$LAMA_BERDIAM,'$TGL_TIBA','$ALAMATIN','$NO_SETKAB','$BERLAKUSD','$NO_SPONSOR',$LAMA_BERDIAM_BLN,'$ST_VISA','$TELP','$NO_SR_SETNEG','','$nama_file_unik_ttd','$PROVINCE_ID', '$REGENCY_ID')");
            }
        }else{
             $input = mysql_query("insert into sibling (ID_NEGARA,ID_JNS_RELASI,ID_DIPLOMAT,ID_JNS_PASPOR,ID_JNS_VISA,NM_SIBLING,TEMPAT_LAHIR,TGL_LAHIR,JK,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,PASPOR_TGL,AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,TGL_TIBA,ALAMATIN,NO_SETKAB,BERLAKUSD,NO_SPONSOR,LAMA_BERDIAM_BLN,ST_VISA,TELP,NO_SR_SETNEG,FOTO,FOTO_TTD,PROVINCE_ID, REGENCY_ID) values ($ID_NEGARA,$ID_JNS_RELASI,$ID_DIPLOMAT,$ID_JNS_PASPOR,$ID_JNS_VISA,'$NM_SIBLING','$TEMPAT_LAHIR','$TGL_LAHIR','$JK','$PEKERJAAN','$ALAMATLN','$ST_SIPIL','$NO_PASPOR','$PASPOR_OLEH','$PASPOR_TGL','$AKHIR_BERLAKU','$NO_VISA','$VISA_OLEH',$LAMA_BERDIAM,'$TGL_TIBA','$ALAMATIN','$NO_SETKAB','$BERLAKUSD','$NO_SPONSOR',$LAMA_BERDIAM_BLN,'$ST_VISA','$TELP','$NO_SR_SETNEG','','','$PROVINCE_ID', '$REGENCY_ID')");
        }
  }//IF IMAGE 1 EMPTY
	header('location: ./deplu.php?module='.$module.'&negara='.$neg.'&namadiplomat='.$_POST[NM_DIPLOMAT]);


}
elseif ($module=='sibling' AND $act=='hapus' AND isset($_GET[idt])){

  mysql_query("DELETE FROM sibling WHERE ID_SIBLING ='$_GET[idt]'");

  header('location: ./deplu.php?module='.$module.'&negara='.$neg);
}

elseif ($module=='sibling' AND $act=='update' AND isset($_POST[idt])){

	$PROVINCE_ID=$_POST[PROVINCE_ID];
	$REGENCY_ID=$_POST[REGENCY_ID];

$ID_NEGARA = $_POST[ID_NEGARA];
$ID_JNS_RELASI = $_POST[ID_JNS_RELASI];
$ID_DIPLOMAT = $_POST[ID_DIPLOMAT];
$ID_JNS_PASPOR = $_POST[ID_JNS_PASPOR];
$ID_JNS_VISA = $_POST[ID_JNS_VISA];
//$NM_SIBLING_= strtoupper($_POST[NM_SIBLING]);
//$NM_SIBLING = htmlspecialchars($NM_SIBLING_, ENT_QUOTES);
$NM_SIBLING= htmlspecialchars(strtoupper($_POST[NM_SIBLING]), ENT_QUOTES);
//$TEMPAT_LAHIR = strtoupper($_POST[TEMPAT_LAHIR]);
$TEMPAT_LAHIR = htmlspecialchars(strtoupper($_POST[TEMPAT_LAHIR]), ENT_QUOTES);
$TGL_LAHIR = $_POST[TGL_LAHIR];
$JK = $_POST[JK];
$PEKERJAAN = htmlspecialchars($_POST[PEKERJAAN], ENT_QUOTES);
//$ALAMATLN_ = strtoupper($_POST[ALAMATLN]);
//$ALAMATLN = htmlspecialchars($ALAMATLN_, ENT_QUOTES);
$ALAMATLN = htmlspecialchars(strtoupper($_POST[ALAMATLN]), ENT_QUOTES);
$ST_SIPIL = $_POST[ST_SIPIL];
$NO_PASPOR = strtoupper($_POST[NO_PASPOR]);
$PASPOR_OLEH = strtoupper($_POST[PASPOR_OLEH]);
$PASPOR_TGL = $_POST[PASPOR_TGL];
$AKHIR_BERLAKU = $_POST[AKHIR_BERLAKU];
$NO_VISA = strtoupper($_POST[NO_VISA]);
$VISA_OLEH = strtoupper($_POST[VISA_OLEH]);

if (isset($_POST[LAMA_BERDIAM]) and $_POST[LAMA_BERDIAM] != ''){
$LAMA_BERDIAM = $_POST[LAMA_BERDIAM];}
else
{$LAMA_BERDIAM = '0';}

$TGL_TIBA = $_POST[TGL_TIBA];
//$ALAMATIN_ = strtoupper($_POST[ALAMATIN]);
//$ALAMATIN = htmlspecialchars($ALAMATIN_, ENT_QUOTES);
$ALAMATIN = htmlspecialchars(strtoupper($_POST[ALAMATIN]), ENT_QUOTES);
$NO_SETKAB = strtoupper($_POST[NO_SETKAB]);
$BERLAKUSD = $_POST[BERLAKUSD];
$NO_SPONSOR = strtoupper($_POST[NO_SPONSOR]);
$ST_VISA = $_POST[ST_VISA];
$TELP = strtoupper($_POST[TELP]);
$NO_SR_SETNEG = strtoupper($_POST[NO_SR_SETNEG]);
if (isset($_POST[LAMA_BERDIAM_BLN]) and $_POST[LAMA_BERDIAM_BLN] != ''){
$LAMA_BERDIAM_BLN = $_POST[LAMA_BERDIAM_BLN];}
else
{$LAMA_BERDIAM_BLN = '0';}

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
  if (empty($lokasi_file)){
   if (empty($lokasi_file_ttd)){
		 	$sql ="update sibling set ID_NEGARA = $ID_NEGARA,
										 ID_JNS_RELASI = $ID_JNS_RELASI,
										 ID_DIPLOMAT = $ID_DIPLOMAT,
										 ID_JNS_PASPOR = $ID_JNS_PASPOR,
										 ID_JNS_VISA = $ID_JNS_VISA,
										 NM_SIBLING = '$NM_SIBLING',
										 TEMPAT_LAHIR = '$TEMPAT_LAHIR',
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
										 LAMA_BERDIAM_BLN = $LAMA_BERDIAM_BLN,
										 ST_VISA = $ST_VISA,
										 TELP = '$TELP',
										 NO_SR_SETNEG = '$NO_SR_SETNEG',
										 PROVINCE_ID = '$PROVINCE_ID',
										 REGENCY_ID = '$REGENCY_ID'
										 where ID_SIBLING = $_POST[idt]";
										  // echo $sql; exit;
				 mysql_query($sql);
		 // echo "here";
			// EXIT;
      	  header('location: ./deplu.php?module='.$module.'&negara='.$neg.'&namadiplomat='.$_POST[NM_DIPLOMAT]);

        }
        else{
      	// Apabila tipe gambar 2 bukan jpeg akan tampil peringatan
          if ($tipe_file_ttd != "image/jpeg" AND $tipe_file_ttd != "image/pjpeg"){
            $varname =  "Gagal menyimpan data !!! <br>
                    Tipe file <b>$nama_file_ttd</b> : $tipe_file_ttd <br>
                    Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
        		$template = eregi_replace("{isi}",$varname,$template);
        		echo $template;

          }
          else{
              move_uploaded_file($lokasi_file_ttd,"../foto sibling/ttd/$nama_file_unik_ttd");
              mysql_query("update sibling set ID_NEGARA = $ID_NEGARA,
      									ID_JNS_RELASI = $ID_JNS_RELASI,
      									ID_DIPLOMAT = $ID_DIPLOMAT,
      									ID_JNS_PASPOR = $ID_JNS_PASPOR,
      									ID_JNS_VISA = $ID_JNS_VISA,
      									NM_SIBLING = '$NM_SIBLING',
      									TEMPAT_LAHIR = '$TEMPAT_LAHIR',
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
      									LAMA_BERDIAM_BLN = $LAMA_BERDIAM_BLN,
                        ST_VISA = $ST_VISA,
                        TELP = '$TELP',
                        NO_SR_SETNEG = '$NO_SR_SETNEG',
  									    FOTO_TTD =  '$nama_file_unik_ttd',
                        PROVINCE_ID = '$PROVINCE_ID',
                        REGENCY_ID = '$REGENCY_ID'
      									where ID_SIBLING = $_POST[idt]");

      	     header('location: ./deplu.php?module='.$module.'&negara='.$neg.'&namadiplomat='.$_POST[NM_DIPLOMAT]);

      	   }
        } //if file 2 not empty


  }
  else{ //if file 1 not empty
	// Apabila tipe gambar bukan jpeg akan tampil peringatan
    if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
    	$varname =  "Gagal menyimpan data !!! <br>
            Tipe file <b>$nama_file</b> : $tipe_file <br>
            Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
		$template = eregi_replace("{isi}",$varname,$template);
		echo $template;

    }
    else{

              if (empty($lokasi_file_ttd)){
                   move_uploaded_file($lokasi_file,"../foto sibling/$nama_file_unik");
              	   mysql_query("update sibling set ID_NEGARA = $ID_NEGARA,
              									ID_JNS_RELASI = $ID_JNS_RELASI,
              									ID_DIPLOMAT = $ID_DIPLOMAT,
              									ID_JNS_PASPOR = $ID_JNS_PASPOR,
              									ID_JNS_VISA = $ID_JNS_VISA,
              									NM_SIBLING = '$NM_SIBLING',
              									TEMPAT_LAHIR = '$TEMPAT_LAHIR',
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
              									LAMA_BERDIAM_BLN = $LAMA_BERDIAM_BLN,
                                ST_VISA = $ST_VISA,
                                TELP = '$TELP',
                                NO_SR_SETNEG = '$NO_SR_SETNEG',
              									FOTO =  '$nama_file_unik',
				                        PROVINCE_ID = '$PROVINCE_ID',
				                        REGENCY_ID = '$REGENCY_ID'
              									where ID_SIBLING = $_POST[idt]");
              	  header('location: ./deplu.php?module='.$module.'&negara='.$neg.'&namadiplomat='.$_POST[NM_DIPLOMAT]);

              }
              else{
            	// Apabila tipe gambar 2 bukan jpeg akan tampil peringatan
                if ($tipe_file_ttd != "image/jpeg" AND $tipe_file_ttd != "image/pjpeg"){
                  $varname =  "Gagal menyimpan data !!! <br>
                          Tipe file <b>$nama_file_ttd</b> : $tipe_file_ttd <br>
                          Tipe file yang diperbolehkan adalah : <b>JPG/JPEG</b>.<br> <a href=javascript:history.go(-1)>Ulangi Lagi</a>";
              		$template = eregi_replace("{isi}",$varname,$template);
              		echo $template;

                }
                else{
                   move_uploaded_file($lokasi_file,"../foto sibling/$nama_file_unik");
                   move_uploaded_file($lokasi_file_ttd,"../foto sibling/ttd/$nama_file_unik_ttd");
              	   mysql_query("update sibling set ID_NEGARA = $ID_NEGARA,
              									ID_JNS_RELASI = $ID_JNS_RELASI,
              									ID_DIPLOMAT = $ID_DIPLOMAT,
              									ID_JNS_PASPOR = $ID_JNS_PASPOR,
              									ID_JNS_VISA = $ID_JNS_VISA,
              									NM_SIBLING = '$NM_SIBLING',
              									TEMPAT_LAHIR = '$TEMPAT_LAHIR',
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
              									LAMA_BERDIAM_BLN = $LAMA_BERDIAM_BLN,
                                ST_VISA = $ST_VISA,
                                TELP = '$TELP',
                                NO_SR_SETNEG = '$NO_SR_SETNEG',
              									FOTO =  '$nama_file_unik',
              									FOTO_TTD =  '$nama_file_unik_ttd',
				                        PROVINCE_ID = '$PROVINCE_ID',
				                        REGENCY_ID = '$REGENCY_ID'
              									where ID_SIBLING = $_POST[idt]");
              	  header('location: ./deplu.php?module='.$module.'&negara='.$neg.'&namadiplomat='.$_POST[NM_DIPLOMAT]);

            	   }
              } //if file 2 not empty

	 }//if file 1 image


  }
}




}
?>
