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

if ($module=='nonresidence' AND $act=='input'){
  // $lokasi_file    = $_FILES['fupload']['tmp_name'];
  // $tipe_file      = $_FILES['fupload']['type'];
  // $nama_file      = $_FILES['fupload']['name'];
  // $acak           = rand(000000,999999);
  // $nama_file_unik = $acak.$nama_file;
	//
  // $lokasi_file_ttd    = $_FILES['fuploadttd']['tmp_name'];
  // $tipe_file_ttd       = $_FILES['fuploadttd']['type'];
  // $nama_file_ttd      = $_FILES['fuploadttd']['name'];
  // $nama_file_unik_ttd = $acak.$nama_file_ttd;

		// $KATEGORI_PEMOHON = $_POST[KATEGORI_PEMOHON];
		// $ID_JNS_PASPOR = $_POST[ID_JNS_PASPOR];
		// $ID_JNS_VISA = $_POST[ID_JNS_VISA];
		// $TEMPAT_LAHIR = strtoupper($_POST[TEMPAT_LAHIR]);
		// $TGL_LAHIR = $_POST[TGL_LAHIR];
		// $ALAMATLN = strtoupper($_POST[ALAMATLN]);
		// $ST_SIPIL = $_POST[ST_SIPIL];
		// $NO_PASPOR = strtoupper($_POST[NO_PASPOR]);
		// $PASPOR_OLEH = strtoupper($_POST[PASPOR_OLEH]);
		// $PASPOR_TGL = $_POST[PASPOR_TGL];
		// $AKHIR_BERLAKU = $_POST[AKHIR_BERLAKU];
		// $NO_VISA = strtoupper($_POST[NO_VISA]);
		// $VISA_OLEH = strtoupper($_POST[VISA_OLEH]);
		// $ST_VISA = $_POST[ST_VISA];
		// $TELP = strtoupper($_POST[TELP]);

		// if (isset($_POST[LAMA_BERDIAM]) and $_POST[LAMA_BERDIAM] != ''){
		// $LAMA_BERDIAM = $_POST[LAMA_BERDIAM];}
		// else
		// {$LAMA_BERDIAM = '0';}

		// if (isset($_POST[LAMA_BERDIAM_BLN]) and $_POST[LAMA_BERDIAM_BLN] != ''){
		// $LAMA_BERDIAM_BLN = $_POST[LAMA_BERDIAM_BLN];}
		// else
		// {$LAMA_BERDIAM_BLN = '0';}

		// $TGL_TIBA = $_POST[TGL_TIBA];
		// $ALAMATIN = strtoupper($_POST[ALAMATIN]);
		// $NO_SETKAB = strtoupper($_POST[NO_SETKAB]);
		// $BERLAKUSD = $_POST[BERLAKUSD];
		// $NO_SPONSOR = strtoupper($_POST[NO_SPONSOR]);
		// $NO_SR_SETNEG = strtoupper($_POST[NO_SR_SETNEG]);

	$INPUT_DATE = date('Y-m-d h:i:s');
	$TGLINI = date('Y-m-d');
	$ID_NEGARA = $_POST[ID_NEGARA];
	$ID_KNT_PERWAKILAN = $_POST[ID_KNT_PERWAKILAN];
	$NM_DIPLOMAT = $_POST[NM_DIPLOMAT];
	$JK = $_POST[JK];
	$TITLES = $_POST[TITLES];
	$PEKERJAAN = $_POST[PEKERJAAN];
	$ID_RANK = $_POST[ID_RANK];
	if($ID_RANK==''){ $ID_RANK = "NULL"; } else {
		$ID_RANK = "$ID_RANK";}
	$ST_SIPIL = $_POST[ST_SIPIL];
	$NM_SPOUSE = $_POST[NM_SPOUSE];
	$JK_SPOUSE = $_POST[JK_SPOUSE];
	$SPOUSE_TITLES = $_POST[SPOUSE_TITLES];
	$KET_DEAN = $_POST[DEAN];
	if($KET_DEAN==''){
		$KET_DEAN = 'NULL';
	}
	$TGL_TIBA = $_POST[TGL_TIBA];
	if($TGL_TIBA==$TGLINI){ $TIBA = "NULL"; } else {
		$TIBA = "'$TGL_TIBA'";}
	$TGL_CREDENTIAL = $_POST[TGL_CREDENTIAL];
	  if($TGL_CREDENTIAL==$TGLINI){ $CRE = "NULL"; } else {
			$CRE = "'$TGL_CREDENTIAL'";}
	$ID_JNS_RELASI = 3; //jenis relasi spouse


	$sql= "INSERT INTO nonresidence (ID_NEGARA, ID_RANK, ID_KNT_PERWAKILAN, NM_DIPLOMAT, JK, OFFICIAL_PEKERJAAN, TGL_TIBA, TGL_CREDENTIAL, KET_DEAN, ST_SIPIL, TGL_INPUT) VALUES ($ID_NEGARA, $ID_RANK, $ID_KNT_PERWAKILAN, '$NM_DIPLOMAT', '$JK', '$PEKERJAAN', $TIBA, $CRE, $KET_DEAN, '$ST_SIPIL', '$INPUT_DATE')";
	$input = mysql_query($sql);

	if ($input && $NM_SPOUSE!=''){
		$ID_DIPLOMAT = mysql_insert_id();
		$spouse = mysql_query("INSERT INTO nonresidence_sibling (ID_NEGARA, ID_DIPLOMAT, ID_JNS_RELASI, NM_SIBLING, JK, TGL_INPUT) VALUES ($ID_NEGARA, $ID_DIPLOMAT, $ID_JNS_RELASI, '$NM_SPOUSE', '$JK_SPOUSE', '$INPUT_DATE')");
	}

	header('location: ./deplu.php?module=diplist&negara='.$neg);


}elseif ($module=='nonresidence' AND $act=='hapus' AND isset($_GET[idt])){
  mysql_query("DELETE FROM nonresidence WHERE ID_DIPLOMAT ='$_GET[idt]'");

  header('location: ./deplu.php?module=diplist&negara='.$neg);


}elseif ($module=='nonresidence' AND $act=='update' AND isset($_POST[idt])){
	$INPUT_DATE = date('Y-m-d h:i:s');
	$ID_NEGARA = $_POST[ID_NEGARA];
	$ID_KNT_PERWAKILAN = $_POST[ID_KNT_PERWAKILAN];
	$NM_DIPLOMAT = $_POST[NM_DIPLOMAT];
	$JK = $_POST[JK];
	$TITLES = $_POST[TITLES];
	$PEKERJAAN = $_POST[PEKERJAAN];
	$ID_RANK = $_POST[ID_RANK];
	$ST_SIPIL = $_POST[ST_SIPIL];
	$NM_SPOUSE = $_POST[NM_SPOUSE];
	$JK_SPOUSE = $_POST[JK_SPOUSE];
	$SPOUSE_TITLES = $_POST[SPOUSE_TITLES];
	$KET_DEAN = $_POST[DEAN];
	if($KET_DEAN==''){
		$KET_DEAN = 'NULL';
	}
	$TGL_TIBA = $_POST[TGL_TIBA];
	if($TGL_TIBA=='1899-11-30'){ $TIBA = "NULL"; } else {
		$TIBA = "'$TGL_TIBA'"; }
	$TGL_CREDENTIAL = $_POST[TGL_CREDENTIAL];
	if($TGL_CREDENTIAL=='1899-11-30' OR $TGL_CREDENTIAL==NULL){ $CRE = "NULL"; }else{
		$CRE = "'$TGL_CREDENTIAL'"; }
	$ID_JNS_RELASI = 3; //jenis relasi spouse

	$update = "UPDATE nonresidence SET
								ID_NEGARA = '$ID_NEGARA',
								ID_KNT_PERWAKILAN = '$ID_KNT_PERWAKILAN',
								NM_DIPLOMAT = '$NM_DIPLOMAT',
								JK = '$JK',
								OFFICIAL_PEKERJAAN = '$PEKERJAAN',
								ID_RANK = '$ID_RANK',
								TGL_TIBA = $TIBA,
								TGL_CREDENTIAL = $CRE,
								KET_DEAN = $KET_DEAN,
								ST_SIPIL = '$ST_SIPIL'
								-- TITLES = '$TITLES',
								-- NM_SPOUSE = '$NM_SPOUSE',
								-- JK_SPOUSE = '$JK_SPOUSE',
								-- SPOUSE_TITLES = '$SPOUSE_TITLES'
								WHERE ID_DIPLOMAT ='$_POST[idt]'";
								// echo $update; exit;
	$updates = mysql_query($update);

	if ($updates){
		$check = mysql_num_rows ("SELECT * FROM nonresidence_sibling WHERE ID_DIPLOMAT = '$_POST[idt]'");
		if ($check > 0){
			$spouse = mysql_query ("UPDATE nonresidence_sibling SET
															ID_NEGARA = $ID_NEGARA,
															ID_JNS_RELASI = $ID_JNS_RELASI,
															NM_SIBLING = '$NM_SPOUSE',
															JK = '$JK_SPOUSE'
															WHERE ID_DIPLOMAT ='$_POST[idt]'");
		}else{
			$spouse = mysql_query("INSERT INTO nonresidence_sibling (ID_NEGARA, ID_DIPLOMAT, ID_JNS_RELASI, NM_SIBLING, JK, TGL_INPUT) VALUES ($ID_NEGARA, '$_POST[idt]', $ID_JNS_RELASI, '$NM_SPOUSE', '$JK_SPOUSE', '$INPUT_DATE')");
		}
	}

	$url='./deplu.php?module=diplist&act=viewnonreskantor&idt='.$ID_KNT_PERWAKILAN;
	if($updates == 1){

	 		echo "<script type='text/javascript'>
								alert('Update Berhasil!!');
								document.location.href='$url';
						</script>";
	 } else {
		 	echo"<script type='text/javascript'>
			 	       alert('Update GAGAL!!');
			 	 			 document.location.href='$url';
	 	       </script>";
	 	}
	}
 } //if session ok
?>
