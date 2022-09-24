<?php
  // echo "<br><a href=?module=diplomat_miras&act=cari&huruf=A>A</A> |	<a href=?module=diplomat_miras&act=cari&huruf=B>B</A> |	<a href=?module=diplomat_miras&act=cari&huruf=C>C</A> |	<a href=?module=diplomat_miras&act=cari&huruf=D>D</A> |	<a href=?module=diplomat_miras&act=cari&huruf=E>E</A> |	<a href=?module=diplomat_miras&act=cari&huruf=F>F</A> |	<a href=?module=diplomat_miras&act=cari&huruf=G>G</A> |	<a href=?module=diplomat_miras&act=cari&huruf=H>H</A> |	<a href=?module=diplomat_miras&act=cari&huruf=I>I</A> |	<a href=?module=diplomat_miras&act=cari&huruf=J>J</A> |	<a href=?module=diplomat_miras&act=cari&huruf=K>K</A> |	<a href=?module=diplomat_miras&act=cari&huruf=L>L</A> |	<a href=?module=diplomat_miras&act=cari&huruf=M>M</A> |	<a href=?module=diplomat_miras&act=cari&huruf=N>N</A> |	<a href=?module=diplomat_miras&act=cari&huruf=O>O</A> |	<a href=?module=diplomat_miras&act=cari&huruf=P>P</A> |	<a href=?module=diplomat_miras&act=cari&huruf=Q>Q</A> |	<a href=?module=diplomat_miras&act=cari&huruf=R>R</A> |	<a href=?module=diplomat_miras&act=cari&huruf=S>S</A> |	<a href=?module=diplomat_miras&act=cari&huruf=T>T</A> |	<a href=?module=diplomat_miras&act=cari&huruf=U>U</A> |	<a href=?module=diplomat_miras&act=cari&huruf=V>V</A> |	<a href=?module=diplomat_miras&act=cari&huruf=W>W</A> |	<a href=?module=diplomat_miras&act=cari&huruf=X>X</A> |	<a href=?module=diplomat_miras&act=cari&huruf=Y>Y</A> |	<a href=?module=diplomat_miras&act=cari&huruf=Z>Z</A>";

switch($_GET['act']){
  // Tampil Berita
  default:
		if (isset($_GET['negara'])) {
			$negaranya = $_GET['negara'];
			if ($_GET['negara'] == ""){$negaranya = 'Semua negara';}
 		}
		else
		{
			$negaranya = 'Semua negara';
		}
    
		echo "<link rel='stylesheet' href='../config/jquery-ui-1.12.1.custom/themes/base/jquery-ui.css'"
                . "><script src='../config/jquery-ui-1.12.1.custom/jquery-1.12.4.js'></script>"
                        . "<script src='../config/jquery-ui-1.12.1.custom/jquery-ui.js'>"
                        . "</script><script type='text/javascript'>"
                        . "  $( function() { "
                        . "$( '#tgl_cr_aju1' ).datepicker({ dateFormat: 'yy-mm-dd' }); "
                        . "$( '#tgl_cr_aju2' ).datepicker({ dateFormat: 'yy-mm-dd' }); "
                        . "} );"
                        . "</script>"
                . "<h2>Pencarian Data Pengajuan Bebas Bea Bagi Kantor Perwakilan Asing</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='report_pwk'>
				 <!--<input type=hidden name=act value=cari>-->
                        <table width=54%>
                        <tr>
                        <td width=19%>Tgl. Pengajuan</td>
                        <td width=1%>:</td>
                        <td width=12%><input type=text name=\"tgl_cr_aju1\" id=tgl_cr_aju1 value=$_GET[tgl_cr_aju1]></td>
                        <td width=10% align=center>s.d</td>
                        <td width=12%><input type=text name=\"tgl_cr_aju2\" id=tgl_cr_aju2 value=$_GET[tgl_cr_aju2]></td>
                        </tr>
                        <tr>
                        <td>Kantor Perwakilan</td>
                        <td>:</td>
                        <td><input type=text name=\"perwakilan\" id=perwakilan value=$_GET[perwakilan]></td>
                        <td>Negara :</td>                        
                        <td><input type=text name=\"negara\" id=negara value=$_GET[negara]></td>
                        </tr>
                        <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td colspan=3>";
                        if (isset($_GET['setuju']) && !isset($_GET['tolak'])){
                            echo"<input type=checkbox name=setuju id=setuju value=Setuju checked>Setuju";
                            echo"<input type=checkbox name=tolak id=tolak value=Tolak unchecked>Tolak";
                        }
                        if (isset($_GET['tolak'])&& !isset($_GET['setuju'])){
                            echo"<input type=checkbox name=setuju id=setuju value=Setuju unchecked>Setuju";
                            echo"<input type=checkbox name=tolak id=tolak value=Tolak checked>Tolak";   
                        }
                        if (isset($_GET['tolak']) && isset($_GET['setuju'])){
                            echo"<input type=checkbox name=setuju id=setuju value=Setuju checked>Setuju";
                            echo"<input type=checkbox name=tolak id=tolak value=Tolak checked>Tolak";
                        }
                        if (!isset($_GET['tolak']) && !isset($_GET['setuju'])){
                            echo"<input type=checkbox name=setuju id=setuju value=Setuju unchecked>Setuju";
                            echo"<input type=checkbox name=tolak id=tolak value=Tolak unchecked>Tolak";
                        }  
                        echo"</td>
                        </tr>
                        <tr>
                        <td colspan=6><input type=submit value='Tampilkan Data' style='height:38px; width:90px'>
                         <button type=button onclick='rpt();' value='+' >                 
                            <img border='0' src=\"../images/pdf.png\" width=\"25\" height=\"30\" border=\"0\"  title='Click Me'/>
                        </button>
                        
                        </td>
                        </tr>        
                        </table>
			</form>  <br> "
. "<script>
 function rpt()
 {
 if(document.getElementById('negara').value == '' && document.getElementById('perwakilan').value == '' && document.getElementById('tgl_cr_aju1').value == '' && document.getElementById('tgl_cr_aju2').value == '' && document.getElementById('setuju').checked==false && document.getElementById('tolak').checked==false){
  alert('Field pencarian tidak boleh kosong semua');
 }else{
  var a=document.getElementById('negara').value;
  var b=document.getElementById('perwakilan').value;
  var c=document.getElementById('tgl_cr_aju1').value;
  var d=document.getElementById('tgl_cr_aju2').value;
  if(document.getElementById('setuju').checked==true && document.getElementById('tolak').checked==false){
  var f=document.getElementById('setuju').value;
  var g='';
  }
  if(document.getElementById('tolak').checked==true && document.getElementById('setuju').checked==false){
  var g=document.getElementById('tolak').value;
  var f='';
  }
  if(document.getElementById('tolak').checked==true && document.getElementById('setuju').checked==true){
  var f=document.getElementById('setuju').value;
  var g=document.getElementById('tolak').value;
  }
  window.location='report.php?go=miras_pwk&negara='+a+'&perwakilan='+b+'&tgl_cr_aju1='+c+'&tgl_cr_aju2='+d+'&setuju='+f+'&tolak='+g;
}
}
 </script>";
 //break;      
 
//case "cari";
    //echo"<script>alert('tes cari, $_GET[perwakilan]');</script>";
    

 echo"<table width=100%>
          <tr><th width=2%>no</th><th width=21%>KANTOR</th><th width=21%>NEGARA</th><th width=5%>TGL PENGAJUAN</th><th width=10%>NOTA PENGAJUAN</th><th width=10%>NOTA JAWABAN</th><th width=26%>PENGAJUAN PRODUK</th><th width=5%>STATUS</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);
   
    if (isset($_GET['tgl_cr_aju1']) && isset($_GET['tgl_cr_aju2']) && !empty($_GET['tgl_cr_aju1']) && !empty($_GET['tgl_cr_aju2'])){
        $w1="and (tgl_nota_pengajuan between '$_GET[tgl_cr_aju1]' and '$_GET[tgl_cr_aju2]') ";
        $tgl_pengajuan_rpt="Tanggal Pengajuan Periode <u>$_GET[tgl_cr_aju1]</u> s.d <u>$_GET[tgl_cr_aju2]</u>";
    }
    if (isset($_GET['negara'])&& !empty($_GET['negara'])){
        $w2="and NEGARA like '%$_GET[negara]%' ";
        $negara_rpt="|| Negara <u>$_GET[negara]</u>";
    }
     if (isset($_GET['perwakilan'])&& !empty($_GET['perwakilan'])){
        $w3="and NM_KNT_PERWAKILAN like '%$_GET[perwakilan]%'";
        $knt_perwakilan="|| Kantor Perwakilan <u>$_GET[perwakilan]</u>";
    }
    if (isset($_GET['setuju'])&& !empty($_GET['setuju']) && isset($_GET['tolak'])&& !empty($_GET['tolak'])){
        $w5="";
        $setuju_tolak ="|| Status Pengajuan <u>$_GET[setuju]</u> & <u>$_GET[tolak]</u>";
    }elseif (isset($_GET['setuju']) && !empty($_GET['setuju']) && empty($_GET['tolak'])){
        $w5="and status_pengajuan = 'Setuju'";
        $setuju_tolak ="|| Status Pengajuan <u>$_GET[setuju]</u>";
    }elseif (empty($_GET['setuju']) && !empty($_GET['tolak']) && isset($_GET['tolak'])){
        $w5="and status_pengajuan = 'Tolak'";
        $setuju_tolak ="|| Status Pengajuan <u>$_GET[tolak]</u>";
    }
    
    
    echo "Hasil pencarian berdasarkan : $tgl_pengajuan_rpt $negara_rpt $knt_perwakilan $setuju_tolak";
		$sql="SELECT kd_pengajuan_miras,id_pengajuan_miras,NM_KNT_PERWAKILAN, NEGARA, tgl_nota_pengajuan,no_nota_pengajuan, no_nota_jawaban, CONCAT_WS('','Spirit : ', jumlah_pengajuan_spirit, ', ', 'Anggur : ', jumlah_pengajuan_anggur, ', ', 'Rokok : ',jumlah_pengajuan_rokok) as pengajuan_produk, status_pengajuan, nama_file_aju,tipe_file_aju, lokasi_file_pengajuan,nama_file_jawab,tipe_file_jwb, lokasi_file_jawaban, keterangan, triwulan, tahun, tgl_nota_jawaban FROM v_report_miras_kantor where status_pengajuan is not NULL $w1 $w2 $w3 $w5 order by tgl_nota_pengajuan DESC limit $posisi,$batas";
            
//echo $sql;
		$tampil=mysql_query($sql);


   
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      $kd1= json_encode($r[kd_pengajuan_miras]);
      $pengajuan= json_encode($r[no_nota_pengajuan]);
      $jwb= json_encode($r[no_nota_jawaban]);
      $ket= json_encode($r['keterangan']);
      $sts= json_encode($r[status_pengajuan]);
      $tw= json_encode($r[triwulan]);
      $th= json_encode($r[tahun]);
      $tgl_aju= json_encode($r[tgl_nota_pengajuan]);
      $tgl_jb= json_encode($r[tgl_nota_jawaban]);
      $nm= json_encode($r[NM_KNT_PERWAKILAN]);
      $file_tipe_aju=$r[nama_file_aju].'.'.$r[tipe_file_aju];
      $file_tipe_jwb=$r[nama_file_jawab].'.'.$r[tipe_file_jwb];
      
      $produk=mysql_query("select id_produk, jumlah from tbl_detil_pengajuan_miras_kantor where id_pengajuan_miras = $r[id_pengajuan_miras]");
      while($prdk=mysql_fetch_array($produk)){
                                        if($prdk[id_produk]==1){
                                            $jml_spirit=json_encode($prdk[jumlah]);
                                        }
                                        if($prdk[id_produk]==2){
                                            $jml_anggur=json_encode($prdk[jumlah]);
                                        }                                       
                                        if($prdk[id_produk]==3){
                                        $jml_rkk=json_encode($prdk[jumlah]);
                                        }
                                    }
$file_staf_aju=mysql_query("select lokasi_file, nama_file, jenis, tipe_file from tbl_file_miras_kantor where id_pengajuan_miras = $r[id_pengajuan_miras] and jenis='file_pengajuan'");
                                 if(mysql_num_rows($file_staf_aju) > 0){
                                    while($fl_staf=mysql_fetch_array($file_staf_aju)){                                      
                                        if($fl_staf[jenis]=='file_pengajuan' && $fl_staf[lokasi_file] != ''){
                                            $lokasi_aju=json_encode($fl_staf[lokasi_file]);
                                            $nama_aju=json_encode($fl_staf[nama_file]);
                                            $tipe_fl_aju=json_encode($fl_staf[tipe_file]);
                                        }else if($fl_staf[jenis]=='file_pengajuan' && $fl_staf[lokasi_file] == ''){
                                            $lokasi_aju=json_encode('#');
                                            $nama_aju=json_encode('Tidak ada file');
                                            $tipe_fl_aju=json_encode('');
                                        }
                                    }
                                 }else{
                                     $lokasi_aju=json_encode('#');
                                     $nama_aju=json_encode('Tidak ada file');
                                     $tipe_fl_aju=json_encode('');
                                 }
$file_staf_jwb=mysql_query("select lokasi_file, nama_file, jenis, tipe_file from tbl_file_miras_kantor where id_pengajuan_miras = $r[id_pengajuan_miras] and jenis='file_jawaban'");
                                 if(mysql_num_rows($file_staf_jwb) > 0){
                                    while($fl_staf_jwb=mysql_fetch_array($file_staf_jwb)){
                                        if($fl_staf_jwb[jenis]=='file_jawaban' && $fl_staf_jwb[lokasi_file] != ''){
                                            $lokasi_jwb=json_encode($fl_staf_jwb[lokasi_file]);
                                            $nama_jwb=json_encode($fl_staf_jwb[nama_file]);
                                            $tipe_fl_jwb=json_encode($fl_staf_jwb[tipe_file]);
                                        }else if($fl_staf_jwb[jenis]=='file_jawaban' && $fl_staf_jwb[lokasi_file] == ''){
                                            $lokasi_jwb=json_encode('#');
                                            $nama_jwb=json_encode('Tidak ada file');
                                            $tipe_fl_jwb=json_encode('');
                                        }                                                                         
                                    }
                                 }else{
                                     $lokasi_jwb=json_encode('#');
                                     $nama_jwb=json_encode('Tidak ada file');
                                     $tipe_fl_jwb=json_encode('');
                                 }
                                 
      echo "<tr><td>$no</td>
                <td><a href='#' id='mylink' onClick='loadPopupBoxMiras(2,$kd1,$r[id_pengajuan_miras],$pengajuan,$jwb,$ket,$sts,$tw,$th,$tgl_aju,$tgl_jb,$jml_spirit,$jml_anggur,$jml_rkk,$lokasi_aju,$nama_aju,$tipe_fl_aju,$lokasi_jwb,$nama_jwb,$tipe_fl_jwb,$nm);'>$r[NM_KNT_PERWAKILAN]</a></td>
                <td>$r[NEGARA]</td>
				<td>$r[tgl_nota_pengajuan]</td>		
				<td>$r[no_nota_pengajuan]</br>";
              if($file_tipe_aju != '.'){
              echo"<a href='$r[lokasi_file_pengajuan]'>$file_tipe_aju</a>";
              }
                  echo"</td>
                                <td>$r[no_nota_jawaban]</br> ";
                  if($file_tipe_jwb != '.'){
                          echo"<a href='$r[lokasi_file_jawaban]'>$file_tipe_jwb</a>";
                    }
                                echo"</td>
                                <td>$r[pengajuan_produk]</td>
                                <td>$r[status_pengajuan]</td>";
                                //edit andri 14092016 tambah if user miras maka bisa tambah pengajuan miras
                  
		        echo"</tr>";
      $no++;
    }

    echo "</table>";

		$jmldata =mysql_num_rows(mysql_query("SELECT NM_KNT_PERWAKILAN, NEGARA, tgl_nota_pengajuan,no_nota_pengajuan, no_nota_jawaban, CONCAT_WS('','Spirit : ', jumlah_pengajuan_spirit, ', ', 'Anggur : ', jumlah_pengajuan_anggur, ', ', 'Rokok : ',jumlah_pengajuan_rokok) as pengajuan_produk, status_pengajuan FROM v_report_miras_kantor where status_pengajuan is not NULL $w1 $w2 $w3 order by tgl_nota_pengajuan DESC"));
	
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
        
   $ilink = "?module=report_pwk&tgl_cr_aju1=$_GET[tgl_cr_aju1]&tgl_cr_aju2=$_GET[tgl_cr_aju2]&perwakilan=$_GET[perwakilan]&negara=$_GET[negara]&setuju=$_GET[setuju]&tolak=$_GET[tolak]"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET['halaman'], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    
    //edit
    echo"
        <script type='text/javascript'>
function validasi_input_edt(form){
var decimal=  /^[-+]?[0-9]+\.[0-9]+$/;   
  if (form.nota_pengajuan.value == ''){
    alert('Nomor Nota Pengajuan Masih Kosong!');
    form.nota_pengajuan.focus();
    return (false);
  }
  if (form.spirit1.value == '' && form.anggur1.value == '' && form.rokok1.value == ''){
    alert('Ketiga Produk (Spirit, Anggur, Rokok) Tidak Boleh Semua Kosong!');
    form.spirit1.focus();
    return (false);
  }
}
</script>
        <form method=POST id='frm_edit' enctype='multipart/form-data' onsubmit='return validasi_input_edt(this)' action='./aksi_miras.php?module=kantor_miras&act=update_miras'>
        <div id='popup_box2' style='overflow-y:scroll;' class='popup_box2'>
						<h2>Edit Pengajuan Bebas Bea "; echo"<u><span id='nm_edt'></span></u>";
                                                        echo"</h2>
						<div>
						<table width='100%'>
<tr><td>KD Pengajuan</td ><td width='6'>:</td><td>"; echo "<input type=hidden id=kd name=kd size=5> <input type=text id=kd1 name=kd1 size=15 disabled>";
        echo"</td></tr>
							<tr>
                                                        <td  width='30%'>Tgl. Nota Pengajuan &nbsp;</td><td width='6'>:</td><td><input type=date id=tgl_pengajuan name=tgl_pengajuan size=10> </td>								
							</tr>";

echo"<tr><td>Triwulan/Tahun</td > <td width='6'>:<td >
<select id=trw name=trw>
  <option value=1>1</option>
  <option value=2>2</option>
  <option value=3>3</option>
  <option value=4>4</option>
</select>";   
$now=date(Y);
echo "<select id=thn name=thn>";
for ($a=2013;$a<=$now;$a++)

{

     echo "<option value=$a";if( $now == $a ) echo " selected"; echo">$a</option>";

}

echo "</select></td></tr>   
<tr><td>No. Nota Pengajuan,</br>File Nota</td ><td width='6'>:</td><td ><input type=text id=nota_pengajuan name=nota_pengajuan size=50 maxlength=100 required></br><span name='fl_aju' id='fl_aju'></span></br><input type=file name='file_pengajuan_update' id='file_pengajuan_update'><input type=hidden name='fl_aju_hd' id='fl_aju_hd'></td></tr>
<script>
$('#file_pengajuan_update').bind('change', function() {
var a = document.getElementById('file_pengajuan_update').value;
  var ext = a.split('.');
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ['jpg' ,'jpeg', 'pdf'];
    
  if(this.files[0].size > 8044070){
  alert('ERROR: File terlalu besar, maksimal 8 mb');
  document.getElementById('file_pengajuan_update').value=''
  }
  
    if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert('ERROR: Jenis file harus .pdf, .jpg, atau .jpeg');
        document.getElementById('file_pengajuan_update').value=''
    }
   
});
</script>
<tr><td>Pengajuan Spirit</td ><td width='6'>:</td><td > <input type=number id=spirit1 name=spirit1 step=any size=10 > Liter</td></tr>
<tr><td>Pengajuan Anggur</td ><td width='6'>:</td><td > <input <input type=number id=anggur1 name=anggur1 step=any size=10 > Liter</td></tr>
<tr><td>Pengajuan Rokok</td ><td width='6'>:</td><td > <input type=number id=rokok1 name=rokok1 step=any size=10 > Batang</td></tr>
<tr><td>Status Pengajuan</td > <td width='6'>:</td><td > <input type=radio id='st_aju' name=sts_pengajuan value=Setuju> Setuju  <input type=radio id='sts_pengajuan' name=sts_pengajuan value=Tolak> Tidak Setuju</td></tr>
<tr><td>No. Nota Persetujuan/Penolakan,</br>File Nota</td > <td width='6'>:</td><td > <input type=text id=not_jawaban name=not_jawaban size=50 maxlength=100></br><span name='fl_jwb' id='fl_jwb'></span></br><input type=file name='file_jawaban_update' id='file_jawaban_update'><input type=hidden name='fl_jwb_hd' id='fl_jwb_hd'></td></tr>
<script>
$('#file_jawaban_update').bind('change', function() {
var a = document.getElementById('file_jawaban_update').value;
  var ext = a.split('.');
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ['jpg' ,'jpeg', 'pdf'];
    
  if(this.files[0].size > 8044070){
  alert('ERROR: File terlalu besar, maksimal 8 mb');
  document.getElementById('file_jawaban_update').value=''
  }
  
    if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert('ERROR: Jenis file harus .pdf, .jpg, atau .jpeg');
        document.getElementById('file_jawaban_update').value=''
    }
   
});
</script>
<tr><td>Tgl. Nota Persetujuan/Penolakan &nbsp;</td><td width='6'>:</td><td> <input type=text id=datepicker1 name=datepicker1 size=10>  </td>
<tr><td>Keterangan</td > <td width='6'>:</td><td > <textarea id=keterangan name=keterangan rows=2 cols=50 maxlength=500></textarea></td></tr>
							
							<td colspan=3 align=right>
							<input type=submit  name='update_pengajuan' value='Update'>														
							</td>
							</tr>
						</table></form>
						</div>
						<a id='popupBoxClose' onClick='unloadPopupBox2(2);'>[X]</a>	
					</div>
 </form>                                       
";
    //end edit
    
    break; 

}
?>
