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
		
	$NEGARA = $_POST[NEGARA];
	$NEG_RANTOR_K = $_POST[NEG_RANTOR_K];
	$NEG_RANTOR_I = $_POST[NEG_RANTOR_I];


    if ( $act=='update' AND isset($_POST[idt])){
		mysql_query("update m_negara set NEG_RANTOR_K = '$NEG_RANTOR_K', 
											NEG_RANTOR_I= '$NEG_RANTOR_I'
											where ID_NEGARA= $_POST[idt] ");
	

		$Fas=mysql_query("select * from m_jns_fasilitas  ORDER BY JNS_FASILITAS");
           			 	while($r=mysql_fetch_array($Fas)){
							mysql_query("delete from negara_jns_fas where ID_NEGARA = $_POST[idt] and ID_JNS_FASILITAS = $r[ID_JNS_FASILITAS] ");
	          				$QWERY = "insert into negara_jns_fas(ID_NEGARA,ID_JNS_FASILITAS,ST_FASILITAS_O,ST_FASILITAS_K) values($_POST[idt],$r[ID_JNS_FASILITAS],";
							$idjns = 'O'.$r[ID_JNS_FASILITAS];
							if ($_POST[$idjns] == 'on'){
								$QWERY = $QWERY.'1,';
							}else{
								 $QWERY = $QWERY.'0,';
							}
							
							$idjns = 'K'.$r[ID_JNS_FASILITAS];
							if ($_POST[$idjns] == 'on'){
								 $QWERY =  $QWERY.'1)';
							}else{
								 $QWERY =  $QWERY.'0)';
							}
							mysql_query($QWERY);

							}

		header('location: ./deplu.php?module='.$module.'&huruf='. substr($NEGARA,0,1));
	}
}
?>
