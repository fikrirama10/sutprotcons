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
$nmuser=$_SESSION[G_namauser];
$module=$_GET[module];
$act=$_GET[act];
$idt=$_GET[idt];
$neg=$_GET[negara];

if ($module=='diplomat_miras' AND $act=='input'){
$id_diplomat=$_POST[id_diplomat_bea];
$tgl_pengajuan = $_POST[tgl_pengajuan];
$nota_pengajuan = $_POST[notapengajuan];
$spirit = $_POST[spirit];
$anggur = $_POST[anggur];
$rokok = $_POST[rokok];
$st_pengajuan = $_POST[st_pengajuan];
$nota_persetujuan = $_POST[notapersetujuan];
$tgl_persetujuan = $_POST[tgl_persetujuan];
$keterangan = $_POST[keterangan];
$tgl_input= date('Y-m-d H:i:s');
$triwulan=$_POST[triwulan];
$tahun=$_POST[tahun];
$id_rank=$_POST[id_rank_bea];
$id_negara=$_POST[id_negara_bea];
$id_knt_perwakilan=$_POST[id_knt_perwakilan_bea];
$id_kuota_spirit=$_POST[sprt];
$id_kuota_anggur=$_POST[angr];
$id_kuota_rokok=$_POST[rkk];

$msx_id_staf = "SELECT tahun_kd, nomor_kd from v_nomor_miras_staf where tahun_kd=$tahun order by nomor_kd desc limit 1";
$tampilmaxid= mysql_query($msx_id_staf);
$listmaxid  = mysql_fetch_array($tampilmaxid);
			
$n1 = $listmaxid[nomor_kd]+1;
$n2 = str_pad($n1, 5, 0, STR_PAD_LEFT);
$kd_pengajuan = "STF/".$triwulan."/".$tahun."/".$n2;

//upload file pengajuan
$allowed_ext	= array('jpeg', 'jpg', 'pdf');
$file_name		= $_FILES['file_pengajuan']['name'];
$file_ext		= strtolower(end(explode('.', $file_name)));
$file_size		= $_FILES['file_pengajuan']['size'];
$file_tmp		= $_FILES['file_pengajuan']['tmp_name'];
$tgl_file= date('m-d-Y-h-i-s'); 
$str			= $nota_pengajuan . $tgl_file . '-aju' . $n1;
$nama = preg_replace( "/[^a-z0-9]/i", "-", $str );
$tgl			= date('Y-m-d H:i:s');
//
//upload jawaban
$allowed_ext_jwb	= array('jpeg', 'jpg', 'pdf');
$file_name_jwb		= $_FILES['file_jawaban']['name'];
$file_ext_jwb		= strtolower(end(explode('.', $file_name_jwb)));
$file_size_jwb		= $_FILES['file_jawaban']['size'];
$file_tmp_jwb		= $_FILES['file_jawaban']['tmp_name'];
$tgl_file_jwb= date('m-d-Y-h-i-s'); 
$str_jwb			= $nota_persetujuan . $tgl_file_jwb . '-jwb' . $n1;
$nama_jwb = preg_replace( "/[^a-z0-9]/i", "-", $str_jwb );
$tgl_jwb			= date('Y-m-d H:i:s');
//
			
//if(isset( $_FILES['file_pengajuan'] ) && !empty( $_FILES['file_pengajuan']['name'] ) && isset( $_FILES['file_jawaban'] ) && !empty( $_FILES['file_jawaban']['name'] )){	
$input = mysql_query("insert into tbl_pengajuan_miras_staf (kd_pengajuan_miras, id_diplomat, no_nota_pengajuan, tgl_nota_pengajuan, no_nota_jawaban, tgl_nota_jawaban, status_pengajuan, keterangan, tgl_input, user_input) values ('$kd_pengajuan','$id_diplomat','$nota_pengajuan','$tgl_pengajuan','$nota_persetujuan','$tgl_persetujuan','$st_pengajuan','$keterangan','$tgl_input','$nmuser')");

$maxid = mysql_insert_id();

$inputspirit = mysql_query("insert into tbl_detil_pengajuan_miras_staf (id_pengajuan_miras,id_produk, id_kuota_staf, triwulan, jumlah, tahun) values('$maxid','1','$id_kuota_spirit','$triwulan','$spirit','$tahun')");

$inputanggur = mysql_query("insert into tbl_detil_pengajuan_miras_staf (id_pengajuan_miras,id_produk, id_kuota_staf, triwulan, jumlah, tahun) values('$maxid','2','$id_kuota_anggur','$triwulan','$anggur','$tahun')");

$inputrokok = mysql_query("insert into tbl_detil_pengajuan_miras_staf (id_pengajuan_miras,id_produk, id_kuota_staf, triwulan, jumlah, tahun) values('$maxid','3','$id_kuota_rokok','$triwulan','$rokok','$tahun')");

	
    if(isset( $_FILES['file_pengajuan'] ) && !empty( $_FILES['file_pengajuan']['name'] ) ){
        $lokasi = '../files/miras_staf/'.$nama.'.'.$file_ext;
	move_uploaded_file($file_tmp, $lokasi);
	$in = mysql_query("INSERT INTO tbl_file_miras_staf (id_pengajuan_miras, tgl_upload, jenis, nama_file, tipe_file, ukuran_file, lokasi_file) VALUES($maxid, '$tgl', 'file_pengajuan' ,'$nama', '$file_ext', '$file_size', '$lokasi')");
    }
    if(empty( $_FILES['file_pengajuan']['name'] ) ){
	$in = mysql_query("INSERT INTO tbl_file_miras_staf (id_pengajuan_miras, jenis) VALUES($maxid, 'file_pengajuan')");
    }
    
    if(isset( $_FILES['file_jawaban'] ) && !empty( $_FILES['file_jawaban']['name'] ) ){
        $lokasi_jwb = '../files/miras_staf/'.$nama_jwb.'.'.$file_ext_jwb;
        move_uploaded_file($file_tmp_jwb, $lokasi_jwb);
	$in_jwb = mysql_query("INSERT INTO tbl_file_miras_staf (id_pengajuan_miras, tgl_upload, jenis, nama_file, tipe_file, ukuran_file, lokasi_file) VALUES($maxid, '$tgl_jwb', 'file_jawaban' ,'$nama_jwb', '$file_ext_jwb', '$file_size_jwb', '$lokasi_jwb')");
    }
    if(empty( $_FILES['file_jawaban']['name'] ) ){
	$in_jwb = mysql_query("INSERT INTO tbl_file_miras_staf (id_pengajuan_miras, jenis) VALUES($maxid, 'file_jawaban')");
    }    
    
            if($in && $in_jwb && $maxid > 0){
		echo"<script type='text/javascript'>
                        alert('Data, File Pengajuan dan File Jawaban Berhasil Disimpan');  
                    </script>"; 
                }elseif($in && !$in_jwb && $maxid > 0){
                    echo"<script type='text/javascript'>
                        alert('Data dan File Pengajuan Berhasil Disimpan');  
                    </script>"; 
                }elseif(!$in && $in_jwb && $maxid > 0){
                    echo"<script type='text/javascript'>
                        alert('Data dan File Jawaban Berhasil Disimpan');  
                    </script>"; 
                }elseif(!$in && !$in_jwb && $maxid > 0){
                    echo"<script type='text/javascript'>
                        alert('Data Berhasil Disimpan');  
                    </script>"; 
                }
                else{
		echo"<script type=text/javascript>"
                    . "alert('Data / File Gagal Ditambah, $kd_pengajuan');"
                  . "</script>";  
                    }           

echo "<html>
		<head></head>
			<body onload= self.history.back()>
			</body>
	  </html>";   

}

if ($module=='diplomat_miras' AND $act=='update_miras'){
    $kd_pengajuan=$_POST[kd];
    $tgl_pengajuan_edt=$_POST[tgl_pengajuan];
    $trw=$_POST[trw];
    $thn=$_POST[thn];
    $nota_pengajuan_edt=$_POST[nota_pengajuan];
    $spirit1=$_POST[spirit1];
    $anggur1=$_POST[anggur1];
    $rokok1=$_POST[rokok1];
    $sts_pengajuan=$_POST[sts_pengajuan];
    $not_jawaban_edt=$_POST[not_jawaban];
    $tgl_nota_jawaban=$_POST[datepicker1];
    $keterangan_edt=$_POST[keterangan];
    $tgl_edit= date('Y-m-d H:i:s');
    $usr=$_SESSION[G_namauser];
    
    //update upload file pengajuan
$allowed_ext	= array('jpeg', 'jpg', 'pdf');
$file_name		= $_FILES['file_pengajuan_update']['name'];
$file_ext		= strtolower(end(explode('.', $file_name)));
$file_size		= $_FILES['file_pengajuan_update']['size'];
$file_tmp		= $_FILES['file_pengajuan_update']['tmp_name'];
$tgl_file= date('m-d-Y-h-i-s'); 
$str			= $nota_pengajuan_edt . $tgl_file . '-aju' . $kd_pengajuan;
$nama = preg_replace( "/[^a-z0-9]/i", "-", $str );
$tgl			= date('Y-m-d H:i:s');
$span_aju = $_POST['fl_aju_hd'];
//
//update upload jawaban
$allowed_ext_jwb	= array('jpeg', 'jpg', 'pdf');
$file_name_jwb		= $_FILES['file_jawaban_update']['name'];
$file_ext_jwb		= strtolower(end(explode('.', $file_name_jwb)));
$file_size_jwb		= $_FILES['file_jawaban_update']['size'];
$file_tmp_jwb		= $_FILES['file_jawaban_update']['tmp_name'];
$tgl_file_jwb= date('m-d-Y-h-i-s'); 
$str_jwb			= $not_jawaban_edt . $tgl_file_jwb . '-jwb' . $kd_pengajuan;
$nama_jwb = preg_replace( "/[^a-z0-9]/i", "-", $str_jwb );
$tgl_jwb			= date('Y-m-d H:i:s');
$span_jwb = $_POST['fl_jwb_hd'];
//


    $update_bea =  mysql_query("update tbl_pengajuan_miras_staf a, tbl_detil_pengajuan_miras_staf b set a.no_nota_pengajuan = '$nota_pengajuan_edt', a.tgl_nota_pengajuan = '$tgl_pengajuan_edt', a.no_nota_jawaban = '$not_jawaban_edt', a.tgl_nota_jawaban = '$tgl_nota_jawaban', a.status_pengajuan = '$sts_pengajuan', a.keterangan ='$keterangan_edt', a.tgl_edit = '$tgl_edit', a.user_edit = '$usr', b.triwulan=$trw, b.tahun=$thn, b.jumlah = case when b.id_produk=1 then $spirit1 when b.id_produk=2 then $anggur1 when b.id_produk=3 then $rokok1 else 0 end where a.id_pengajuan_miras = b.id_pengajuan_miras and a.id_pengajuan_miras=$kd_pengajuan");

    if(isset( $_FILES['file_pengajuan_update'] ) && !empty( $_FILES['file_pengajuan_update']['name'] ) ){
        $lokasi = '../files/miras_staf/'.$nama.'.'.$file_ext;
        if($span_aju == 'Tidak ada file.'){
        move_uploaded_file($file_tmp, $lokasi);
        $in_update_aju = mysql_query("INSERT INTO tbl_file_miras_staf (id_pengajuan_miras, tgl_upload, jenis, nama_file, tipe_file, ukuran_file, lokasi_file) VALUES($kd_pengajuan, '$tgl', 'file_pengajuan' ,'$nama', '$file_ext', '$file_size', '$lokasi')");      
        }
        if($span_aju != 'Tidak ada file.'){
        unlink('../files/miras_staf/'.$span_aju);
	move_uploaded_file($file_tmp, $lokasi);
	$in_update_aju = mysql_query("update tbl_file_miras_staf set tgl_upload = '$tgl', nama_file = '$nama', tipe_file = '$file_ext', ukuran_file = '$file_size', lokasi_file = '$lokasi' where id_pengajuan_miras = $kd_pengajuan and jenis = 'file_pengajuan' ");
        }
    }
    if(isset( $_FILES['file_jawaban_update'] ) && !empty( $_FILES['file_jawaban_update']['name'] ) ){
        $lokasi_jwb = '../files/miras_staf/'.$nama_jwb.'.'.$file_ext_jwb;      
        if($span_jwb != 'Tidak ada file.'){
        unlink('../files/miras_staf/'.$span_jwb);
        move_uploaded_file($file_tmp_jwb, $lokasi_jwb);
        $in_update_jwb = mysql_query("update tbl_file_miras_staf set tgl_upload = '$tgl_jwb', nama_file = '$nama_jwb', tipe_file = '$file_ext_jwb', ukuran_file = '$file_size_jwb', lokasi_file = '$lokasi_jwb' where id_pengajuan_miras = $kd_pengajuan and jenis = 'file_jawaban' ");
        }
        if($span_jwb == 'Tidak ada file.'){           
            move_uploaded_file($file_tmp_jwb, $lokasi_jwb);
            $in_update_jwb = mysql_query("INSERT INTO tbl_file_miras_staf (id_pengajuan_miras, tgl_upload, jenis, nama_file, tipe_file, ukuran_file, lokasi_file) VALUES($kd_pengajuan, '$tgl_jwb', 'file_jawaban' ,'$nama_jwb', '$file_ext_jwb', '$file_size_jwb', '$lokasi_jwb')");
        }
    }    
    
                if($in_update_jwb && $in_update_aju && $update_bea){
		echo"<script type='text/javascript'>
                        alert('Data, File Pengajuan dan File Jawaban Berhasil Diupdate');  
                    </script>"; 
                }elseif(!$in_update_jwb && $in_update_aju && $update_bea){
                    echo"<script type='text/javascript'>
                        alert('Data dan File Pengajuan Berhasil Diupdate');  
                    </script>"; 
                }elseif($in_update_jwb && !$in_update_aju && $update_bea){
                    echo"<script type='text/javascript'>
                        alert('Data dan File Jawaban Berhasil Diupdate');  
                    </script>"; 
                }elseif(!$in_update_jwb && !$in_update_aju && $update_bea){
                    echo"<script type='text/javascript'>
                        alert('Data Berhasil Diupdate');  
                    </script>"; 
                }
                else{
		echo"<script type=text/javascript>"
                    . "alert('Data / File Gagal Diupdate, $kd_pengajuan');"
                  . "</script>";  
                    }           
    
    
   /* if(! $update_bea) {
               //die('Tidak Bisa Update Data: ' . mysql_error());
                echo"<script type=text/javascript>alert('Update gagal, $kd_pengajuan, $nota_pengajuan_edt, $tgl_pengajuan_edt, $not_jawaban_edt, $tgl_nota_jawaban, $sts_pengajuan, $keterangan_edt, $tgl_edit, $usr, $trw, $thn, $spirit1, $anggur1, $rokok1');</script>";
            }
            echo"<script type=text/javascript>alert('Update Berhasil,');</script>";*/
           
}

if ($module=='kantor_miras' AND $act=='input'){
//$id_diplomat=$_POST[id_diplomat_bea];
$tgl_pengajuan = $_POST[tgl_pengajuan];
$nota_pengajuan = $_POST[notapengajuan];
$spirit = $_POST[spirit];
$anggur = $_POST[anggur];
$rokok = $_POST[rokok];
$st_pengajuan = $_POST[st_pengajuan];
$nota_persetujuan = $_POST[notapersetujuan];
$tgl_persetujuan = $_POST[tgl_persetujuan];
$keterangan = $_POST[keterangan];
$tgl_input= date('Y-m-d H:i:s');
$triwulan=$_POST[triwulan];
$tahun=$_POST[tahun];
//$id_rank=$_POST[id_rank_bea];
$id_negara=$_POST[id_negara_bea];
$id_knt_perwakilan=$_POST[id_knt_perwakilan_bea];
$id_kuota_spirit=$_POST[sprt];
$id_kuota_anggur=$_POST[angr];
$id_kuota_rokok=$_POST[rkk];

$msx_id_kantor = "SELECT tahun_kd, nomor_kd from v_nomor_miras_kantor where tahun_kd=$tahun order by nomor_kd desc limit 1";
			$tampilmaxid= mysql_query($msx_id_kantor);
			$listmaxid  = mysql_fetch_array($tampilmaxid);
			
			$n1 = $listmaxid[nomor_kd]+1;
			$n2 = str_pad($n1, 5, 0, STR_PAD_LEFT);
			$kd_pengajuan = "PWK/".$triwulan."/".$tahun."/".$n2;

//upload file pengajuan
$allowed_ext	= array('jpeg', 'jpg', 'pdf');
$file_name		= $_FILES['file_pengajuan']['name'];
$file_ext		= strtolower(end(explode('.', $file_name)));
$file_size		= $_FILES['file_pengajuan']['size'];
$file_tmp		= $_FILES['file_pengajuan']['tmp_name'];
$tgl_file= date('m-d-Y-h-i-s'); 
$str			= $nota_pengajuan . $tgl_file . '-aju' . $n1;
$nama = preg_replace( "/[^a-z0-9]/i", "-", $str );
$tgl			= date('Y-m-d H:i:s');
//
//upload jawaban
$allowed_ext_jwb	= array('jpeg', 'jpg', 'pdf');
$file_name_jwb		= $_FILES['file_jawaban']['name'];
$file_ext_jwb		= strtolower(end(explode('.', $file_name_jwb)));
$file_size_jwb		= $_FILES['file_jawaban']['size'];
$file_tmp_jwb		= $_FILES['file_jawaban']['tmp_name'];
$tgl_file_jwb= date('m-d-Y-h-i-s'); 
$str_jwb			= $nota_persetujuan . $tgl_file_jwb . '-jwb' . $n1;
$nama_jwb = preg_replace( "/[^a-z0-9]/i", "-", $str_jwb );
$tgl_jwb			= date('Y-m-d H:i:s');
//

$input = mysql_query("insert into tbl_pengajuan_miras_kantor (kd_pengajuan_miras, id_knt_perwakilan, no_nota_pengajuan, tgl_nota_pengajuan, no_nota_jawaban, tgl_nota_jawaban, status_pengajuan, keterangan, tgl_input, user_input) values ('$kd_pengajuan','$id_knt_perwakilan','$nota_pengajuan','$tgl_pengajuan','$nota_persetujuan','$tgl_persetujuan','$st_pengajuan','$keterangan','$tgl_input','$nmuser')");

$maxid = mysql_insert_id();

$inputspirit = mysql_query("insert into tbl_detil_pengajuan_miras_kantor (id_pengajuan_miras,id_produk, id_kuota_kantor, triwulan, jumlah, tahun) values('$maxid','1','$id_kuota_spirit','$triwulan','$spirit','$tahun')");

$inputanggur = mysql_query("insert into tbl_detil_pengajuan_miras_kantor (id_pengajuan_miras,id_produk, id_kuota_kantor, triwulan, jumlah, tahun) values('$maxid','2','$id_kuota_anggur','$triwulan','$anggur','$tahun')");

$inputrokok = mysql_query("insert into tbl_detil_pengajuan_miras_kantor (id_pengajuan_miras,id_produk, id_kuota_kantor, triwulan, jumlah, tahun) values('$maxid','3','$id_kuota_rokok','$triwulan','$rokok','$tahun')");

 if(isset( $_FILES['file_pengajuan'] ) && !empty( $_FILES['file_pengajuan']['name'] ) ){
        $lokasi = '../files/miras_kantor/'.$nama.'.'.$file_ext;
	move_uploaded_file($file_tmp, $lokasi);
	$in = mysql_query("INSERT INTO tbl_file_miras_kantor (id_pengajuan_miras, tgl_upload, jenis, nama_file, tipe_file, ukuran_file, lokasi_file) VALUES($maxid, '$tgl', 'file_pengajuan' ,'$nama', '$file_ext', '$file_size', '$lokasi')");
    }
    if(empty( $_FILES['file_pengajuan']['name'] ) ){
	$in = mysql_query("INSERT INTO tbl_file_miras_kantor (id_pengajuan_miras, jenis) VALUES($maxid, 'file_pengajuan')");
    }
    
    if(isset( $_FILES['file_jawaban'] ) && !empty( $_FILES['file_jawaban']['name'] ) ){
        $lokasi_jwb = '../files/miras_kantor/'.$nama_jwb.'.'.$file_ext_jwb;
        move_uploaded_file($file_tmp_jwb, $lokasi_jwb);
	$in_jwb = mysql_query("INSERT INTO tbl_file_miras_kantor (id_pengajuan_miras, tgl_upload, jenis, nama_file, tipe_file, ukuran_file, lokasi_file) VALUES($maxid, '$tgl_jwb', 'file_jawaban' ,'$nama_jwb', '$file_ext_jwb', '$file_size_jwb', '$lokasi_jwb')");
    }
if(empty( $_FILES['file_jawaban']['name'] ) ){
	$in_jwb = mysql_query("INSERT INTO tbl_file_miras_kantor (id_pengajuan_miras, jenis) VALUES($maxid, 'file_jawaban')");
    }    
            if($in && $in_jwb && $maxid > 0){
		echo"<script type='text/javascript'>
                        alert('Data, File Pengajuan dan File Jawaban Berhasil Disimpan');  
                    </script>"; 
                }elseif($in && !$in_jwb && $maxid > 0){
                    echo"<script type='text/javascript'>
                        alert('Data dan File Pengajuan Berhasil Disimpan');  
                    </script>"; 
                }elseif(!$in && $in_jwb && $maxid > 0){
                    echo"<script type='text/javascript'>
                        alert('Data dan File Jawaban Berhasil Disimpan');  
                    </script>"; 
                }elseif(!$in && !$in_jwb && $maxid > 0){
                    echo"<script type='text/javascript'>
                        alert('Data Berhasil Disimpan');  
                    </script>"; 
                }
                else{
		echo"<script type=text/javascript>"
                    . "alert('Data / File Gagal Ditambah, $kd_pengajuan');"
                  . "</script>";  
                    }           
echo "<html>
		<head></head>
			<body onload= self.history.back()>
			</body>
	  </html>";   

}
if ($module=='kantor_miras' AND $act=='update_miras'){
    $kd_pengajuan=$_POST[kd];
    $tgl_pengajuan_edt=$_POST[tgl_pengajuan];
    $trw=$_POST[trw];
    $thn=$_POST[thn];
    $nota_pengajuan_edt=$_POST[nota_pengajuan];
    $spirit1=$_POST[spirit1];
    $anggur1=$_POST[anggur1];
    $rokok1=$_POST[rokok1];
    $sts_pengajuan=$_POST[sts_pengajuan];
    $not_jawaban_edt=$_POST[not_jawaban];
    $tgl_nota_jawaban=$_POST[datepicker1];
    $keterangan_edt=$_POST[keterangan];
    $tgl_edit= date('Y-m-d H:i:s');
    $usr=$_SESSION[G_namauser];

//update upload file pengajuan
$allowed_ext	= array('jpeg', 'jpg', 'pdf');
$file_name		= $_FILES['file_pengajuan_update']['name'];
$file_ext		= strtolower(end(explode('.', $file_name)));
$file_size		= $_FILES['file_pengajuan_update']['size'];
$file_tmp		= $_FILES['file_pengajuan_update']['tmp_name'];
$tgl_file= date('m-d-Y-h-i-s'); 
$str			= $nota_pengajuan_edt . $tgl_file . '-aju' . $kd_pengajuan;
$nama = preg_replace( "/[^a-z0-9]/i", "-", $str );
$tgl			= date('Y-m-d H:i:s');
$span_aju = $_POST['fl_aju_hd'];
//
//update upload jawaban
$allowed_ext_jwb	= array('jpeg', 'jpg', 'pdf');
$file_name_jwb		= $_FILES['file_jawaban_update']['name'];
$file_ext_jwb		= strtolower(end(explode('.', $file_name_jwb)));
$file_size_jwb		= $_FILES['file_jawaban_update']['size'];
$file_tmp_jwb		= $_FILES['file_jawaban_update']['tmp_name'];
$tgl_file_jwb= date('m-d-Y-h-i-s'); 
$str_jwb			= $not_jawaban_edt . $tgl_file_jwb . '-jwb' . $kd_pengajuan;
$nama_jwb = preg_replace( "/[^a-z0-9]/i", "-", $str_jwb );
$tgl_jwb			= date('Y-m-d H:i:s');
$span_jwb = $_POST['fl_jwb_hd'];
//
    
    $update_bea =  mysql_query("update tbl_pengajuan_miras_kantor a, tbl_detil_pengajuan_miras_kantor b set a.no_nota_pengajuan = '$nota_pengajuan_edt', a.tgl_nota_pengajuan = '$tgl_pengajuan_edt', a.no_nota_jawaban = '$not_jawaban_edt', a.tgl_nota_jawaban = '$tgl_nota_jawaban', a.status_pengajuan = '$sts_pengajuan', a.keterangan ='$keterangan_edt', a.tgl_edit = '$tgl_edit', a.user_edit = '$usr', b.triwulan=$trw, b.tahun=$thn, b.jumlah = case when b.id_produk=1 then $spirit1 when b.id_produk=2 then $anggur1 when b.id_produk=3 then $rokok1 else 0 end where a.id_pengajuan_miras = b.id_pengajuan_miras and a.id_pengajuan_miras=$kd_pengajuan");
    
   if(isset( $_FILES['file_pengajuan_update'] ) && !empty( $_FILES['file_pengajuan_update']['name'] ) ){
        $lokasi = '../files/miras_kantor/'.$nama.'.'.$file_ext;
        if($span_aju == 'Tidak ada file.'){
        move_uploaded_file($file_tmp, $lokasi);
        $in_update_aju = mysql_query("INSERT INTO tbl_file_miras_kantor (id_pengajuan_miras, tgl_upload, jenis, nama_file, tipe_file, ukuran_file, lokasi_file) VALUES($kd_pengajuan, '$tgl', 'file_pengajuan' ,'$nama', '$file_ext', '$file_size', '$lokasi')");      
        }
        if($span_aju != 'Tidak ada file.'){
        unlink('../files/miras_kantor/'.$span_aju);
	move_uploaded_file($file_tmp, $lokasi);
	$in_update_aju = mysql_query("update tbl_file_miras_kantor set tgl_upload = '$tgl', nama_file = '$nama', tipe_file = '$file_ext', ukuran_file = '$file_size', lokasi_file = '$lokasi' where id_pengajuan_miras = $kd_pengajuan and jenis = 'file_pengajuan' ");
        }
    }
    if(isset( $_FILES['file_jawaban_update'] ) && !empty( $_FILES['file_jawaban_update']['name'] ) ){
        $lokasi_jwb = '../files/miras_kantor/'.$nama_jwb.'.'.$file_ext_jwb;
        if($span_jwb != 'Tidak ada file.'){
        unlink('../files/miras_kantor/'.$span_jwb);
        move_uploaded_file($file_tmp_jwb, $lokasi_jwb);
        $in_update_jwb = mysql_query("update tbl_file_miras_kantor set tgl_upload = '$tgl_jwb', nama_file = '$nama_jwb', tipe_file = '$file_ext_jwb', ukuran_file = '$file_size_jwb', lokasi_file = '$lokasi_jwb' where id_pengajuan_miras = $kd_pengajuan and jenis = 'file_jawaban' ");
        }
        if($span_jwb == 'Tidak ada file.'){           
            move_uploaded_file($file_tmp_jwb, $lokasi_jwb);
            $in_update_jwb = mysql_query("INSERT INTO tbl_file_miras_kantor (id_pengajuan_miras, tgl_upload, jenis, nama_file, tipe_file, ukuran_file, lokasi_file) VALUES($kd_pengajuan, '$tgl_jwb', 'file_jawaban' ,'$nama_jwb', '$file_ext_jwb', '$file_size_jwb', '$lokasi_jwb')");
        }
    }    
    
                if($in_update_jwb && $in_update_aju && $update_bea){
		echo"<script type='text/javascript'>
                        alert('Data, File Pengajuan dan File Jawaban Berhasil Diupdate');  
                    </script>"; 
                }elseif(!$in_update_jwb && $in_update_aju && $update_bea){
                    echo"<script type='text/javascript'>
                        alert('Data dan File Pengajuan Berhasil Diupdate');  
                    </script>"; 
                }elseif($in_update_jwb && !$in_update_aju && $update_bea){
                    echo"<script type='text/javascript'>
                        alert('Data dan File Jawaban Berhasil Diupdate');  
                    </script>"; 
                }elseif(!$in_update_jwb && !$in_update_aju && $update_bea){
                    echo"<script type='text/javascript'>
                        alert('Data Berhasil Diupdate');  
                    </script>"; 
                }
                else{
		echo"<script type=text/javascript>"
                    . "alert('Data / File Gagal Diupdate, $kd_pengajuan');"
                  . "</script>";  
                    }           
                    
}

 echo "<html>
		<head></head>
			<body onload= self.history.back()>
			</body>
	  </html>";       
 } //if session ok
?>
