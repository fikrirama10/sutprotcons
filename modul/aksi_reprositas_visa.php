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

function after ($this, $inthat)
    {
        if (!is_bool(strpos($inthat, $this)))
        return substr($inthat, strpos($inthat,$this)+strlen($this));
    };
    
function before ($this, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $this));
    };
    
include "../config/koneksi.php";
include "../config/library.php";
$nmuser=$_SESSION[G_namauser];
$module=$_GET[module];
$act=$_GET[act];
$idt=$_GET[idt];
$neg=$_GET[negara];

if ($module=='reprositas_visa' AND $act=='input'){
$tgl_input=$_POST[tgl_input];
$usr_input = $_POST[usr_input];
$NAMA_NEGARA = $_POST[NAMA_NEGARA2];
$NAMA_NEGARA2 = after('@@',$NAMA_NEGARA);
$id_negara = before('@@',$NAMA_NEGARA);
$sumber = htmlspecialchars($_POST[sumber], ENT_QUOTES);
$deskripsi = htmlspecialchars($_POST[deskripsi], ENT_QUOTES);
$dokumen = htmlspecialchars($_POST[dokumen], ENT_QUOTES);

//upload file pengajuan
$allowed_ext	= array('jpeg', 'jpg', 'pdf');
$file_name		= $_FILES['file_dokumen']['name'];
$file_size		= $_FILES['file_dokumen']['size'];
$file_tmp		= $_FILES['file_dokumen']['tmp_name'];
$tgl_file= date('m-d-Y-h-i-s'); 
 if(isset( $_FILES['file_dokumen'] ) && !empty( $_FILES['file_dokumen']['name'] ) ){
$file_ext		= strtolower(end(explode('.', $file_name)));
$str			= $dokumen . $tgl_file;
$nama = preg_replace( "/[^a-z0-9]/i", "-", $str );
$nama_file=$nama.'.'.$file_ext;
 }
$tgl			= date('Y-m-d H:i:s');
//


$input = mysql_query("insert into tbl_resiprositas_visa (ID_NEGARA, NAMA_NEGARA, SUMBER_INFORMASI, DESKRIPSI_INFORMASI, TGL_INPUT, USER_INPUT, NOMOR_DOK, FILE) values ('$id_negara','$NAMA_NEGARA2','$sumber','$deskripsi','$tgl_input','$usr_input','$dokumen','$nama_file')");

$maxid = mysql_insert_id();

    if(isset( $_FILES['file_dokumen'] ) && !empty( $_FILES['file_dokumen']['name'] ) ){
        $lokasi = '../files/otvis/resiprositas/'.$nama.'.'.$file_ext;
	move_uploaded_file($file_tmp, $lokasi);	
    }
            if( $maxid > 0){
		echo"<script type='text/javascript'>
                        alert('Data Berhasil Disimpan');  
                    </script>"; 
                }
                else{
		echo"<script type=text/javascript>"
                    . "alert('Data Gagal Ditambah');"
                  . "</script>";  
                    }           

echo "<html>
		<head></head>
			<body onload= self.history.back()>
			</body>
	  </html>";   

}

if ($module=='reprositas_visa' AND $act=='update_resiprositas'){
    $kd=$_POST[id];        
    $NAMA_NEGARA = $_POST[negara_edt];
    $NAMA_NEGARA2 = after('@@',$NAMA_NEGARA);
    $id_negara = before('@@',$NAMA_NEGARA);
    $sumber = htmlspecialchars($_POST[sumber_edt], ENT_QUOTES);
    $deskripsi = htmlspecialchars($_POST[deskripsi_edt], ENT_QUOTES) ;
    $dokumen = htmlspecialchars($_POST[dokumen_edt], ENT_QUOTES);
    $tgl_edit= date('Y-m-d h:i:s');
    $usr=$_SESSION['G_iduser'];
    $span_aju = $_POST[fl_aju_hd];
    $sts_aktif = $_POST[sts_aktif];
    
   //upload file pengajuan
$allowed_ext	= array('jpeg', 'jpg', 'pdf');
$file_name		= $_FILES['file_dokumen_edt']['name'];
$file_size		= $_FILES['file_dokumen_edt']['size'];
$file_tmp		= $_FILES['file_dokumen_edt']['tmp_name'];
$tgl_file= date('m-d-Y-h-i-s'); 
 if(isset( $_FILES['file_dokumen_edt'] ) && !empty( $_FILES['file_dokumen_edt']['name'] ) ){
$file_ext		= strtolower(end(explode('.', $file_name)));
$str			= $dokumen . $tgl_file;
$nama = preg_replace( "/[^a-z0-9]/i", "-", $str );
$nama_file=$nama.'.'.$file_ext;
 }
$tgl			= date('Y-m-d H:i:s');

//
if(isset( $_FILES['file_dokumen_edt'] ) && !empty( $_FILES['file_dokumen_edt']['name'] ) ){
$update_bea = mysql_query("update tbl_resiprositas_visa set ID_NEGARA='$id_negara', NAMA_NEGARA='$NAMA_NEGARA2', SUMBER_INFORMASI='$sumber', DESKRIPSI_INFORMASI='$deskripsi', TGL_EDIT='$tgl_edit', USER_EDIT='$usr', NOMOR_DOK='$dokumen', FILE='$nama_file', STATUS='$sts_aktif' where ID='$kd'");
}else{
$update_bea = mysql_query("update tbl_resiprositas_visa set ID_NEGARA='$id_negara', NAMA_NEGARA='$NAMA_NEGARA2', SUMBER_INFORMASI='$sumber', DESKRIPSI_INFORMASI='$deskripsi', TGL_EDIT='$tgl_edit', USER_EDIT='$usr', STATUS='$sts_aktif' where ID='$kd'"); 
}
    if(isset( $_FILES['file_dokumen_edt'] ) && !empty( $_FILES['file_dokumen_edt']['name'] ) ){
        $lokasi = '../files/otvis/resiprositas/'.$nama.'.'.$file_ext;
        if($span_aju == 'Tidak ada file'){
        move_uploaded_file($file_tmp, $lokasi);          
        }
        if($span_aju != 'Tidak ada file'){
        unlink('../files/otvis/resiprositas/'.$span_aju);
	move_uploaded_file($file_tmp, $lokasi);
        }
    }

                if($update_bea){
		echo"<script type='text/javascript'>
                        alert('Data Berhasil Diupdate');  
                    </script>"; 
                }
                else{
		echo"<script type=text/javascript>"
                    . "alert('Data Gagal Diupdate');"
                  . "</script>";  
                    }           
    
    
   /* if(! $update_bea) {
               //die('Tidak Bisa Update Data: ' . mysql_error());
                echo"<script type=text/javascript>alert('Update gagal, $kd_pengajuan, $nota_pengajuan_edt, $tgl_pengajuan_edt, $not_jawaban_edt, $tgl_nota_jawaban, $sts_pengajuan, $keterangan_edt, $tgl_edit, $usr, $trw, $thn, $spirit1, $anggur1, $rokok1');</script>";
            }
            echo"<script type=text/javascript>alert('Update Berhasil,');</script>";*/
           
}

 echo "<html>
		<head></head>
			<body onload= self.history.back()>
			</body>
	  </html>";       
 } //if session ok
?>
