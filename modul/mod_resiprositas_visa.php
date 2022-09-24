<?php
switch($_GET[act]){
  // Tampil Berita
  default:
      if ($_SESSION[G_leveluser]==15 ){
      $sql_ngr="select DISTINCT ID_NEGARA, NAMA_NEGARA from tbl_resiprositas_visa where USER_INPUT='$_SESSION[G_iduser]' order by NAMA_NEGARA asc";
      }elseif ($_SESSION[G_leveluser]==14 ){
           $sql_ngr="select DISTINCT ID_NEGARA, NAMA_NEGARA from tbl_resiprositas_visa order by NAMA_NEGARA asc";
      }
      $tampil_ngr=mysql_query($sql_ngr);
      $sql_ngr2="select * from m_negara where ID_NEGARA > 1";
      $tampil_ngr2=mysql_query($sql_ngr2);
			echo "<h2>Informasi Kejadian yang Berpengaruh Terhadap Resiprositas Pemberian Visa</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				
			<table width='500' border='0px' cellspacing='0'>
			<tr>
			<td width='100'>Deskripsi Informasi</td>
			<td width='240'>:  <input placeholder='Deskripsi Informasi' size=50 type=text name=\"deskripsi_info\">
			<input type=hidden name=module value='reprositas_visa'>
			</td>
			</tr>
			<tr>	
			<td width='100'>Nama Negara</td>
			<td width='240'>:  
			<select name=\"nm_ngr\" id='nm_ngr'>
			<option value=''>- Silahkan Pilih -</option>
			"; 
			
				 while($val=mysql_fetch_array($tampil_ngr))
				 {
					echo "<option value='$val[ID_NEGARA]'>$val[NAMA_NEGARA]</option>";
				 }
		
			echo"</select>
			</td>
			
			</tr>
			</table>
			<input type=submit value=Cari>
			</form> <br>";
                        
		echo "
          <!--<input type=button value='Tambah Informasi' onclick=location.href='?module=negara&act=tambahnegara'>-->
<!--Tambah Info Resiprositas Visa-->
<script type='text/javascript'>
function validasi_input(form){
var decimal=  /^[-+]?[0-9]+\.[0-9]+$/;   
  if (form.file_dokumen.value != '' && form.dokumen.value == ''){
    alert('Gagal!!! Jika File Dokumen terisi maka Nomor/Judul Dokumen Pendukung harus terisi!');
    form.dokumen.focus();
    return (false);
  }
  if (form.file_dokumen.value == '' && form.dokumen.value != ''){
    alert('Gagal!!! Jika Nomor/Judul Dokumen Pendukung terisi maka File Dokumen harus terisi!');
    form.dokumen.focus();
    return (false);
  }
}

</script>
<form method=POST id='frm1' enctype='multipart/form-data' action='./aksi_reprositas_visa.php?module=reprositas_visa&act=input' onsubmit='return validasi_input(this)'>
<input type='button'  name='tambah_pengajuan' onClick=loadPopupBoxVisa(4); value='Tambah Pengajuan'> 	
<div id='popup_box4' style='overflow-y:scroll;' class='popup_box4'>
						<h2>Tambah Informasi untuk Resiprositas Visa</h2>
						<div>                                               
<table width='100%'>
<tr>
<td  width='180'>Tgl. Input</td><td width='6'>:</td><td>"; $tm= date('Y-m-d h:i:s'); echo"<input type=text name='tgl_input' id='tgl_input' value='$tm' required readonly></td>								
</tr>
<tr>
<td >User Input</td><td width='6'>:</td><td>"; $usr= $_SESSION['G_iduser']; echo"<input type=text name='usr_input' id='usr_input' size=20 value=$usr required readonly></td>								
</tr>  
<tr><td>Negara Subjek*</td ><td width='6'>:</td><td > 
<select required name='NAMA_NEGARA2' id='NAMA_NEGARA2'>
			<option value=''>- Silahkan Pilih -</option>
			"; 
			
				 while($val=mysql_fetch_array($tampil_ngr2))
				 {
					echo "<option value='$val[ID_NEGARA]@@$val[NEGARA]'>$val[NEGARA]</option>";
				 }
		
			echo"</select>
</td></tr>
<tr><td>Sumber Informasi*</td > <td width='6'>:</td><td > <input type=text name='sumber' id='sumber' size=50 maxlength=250 required></td></tr>
<tr><td>Deskripsi Informasi*</td > <td width='6'>:</td><td > <textarea name='deskripsi' id='deskripsi' rows=8 cols=50 maxlength=2000 required></textarea></td></tr>
<tr><td>Nomor/Judul Dokumen Pendukung </br>------------</br>File Dokumen</td ><td width='6'>:</td><td > <input type=text name='dokumen' id='dokumen' size=50 maxlength=200></br><input type=file name='file_dokumen' id='file_dokumen'></td></tr>
<script>
$('#file_dokumen').bind('change', function() {
var a = document.getElementById('file_dokumen').value;
  var ext = a.split('.');
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ['jpg' ,'jpeg', 'pdf'];
    
  if(this.files[0].size > 8044070){
  alert('ERROR: File terlalu besar, maksimal 8 mb');
  document.getElementById('file_dokumen').value=''
  }
  
    if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert('ERROR: Jenis file harus .pdf, .jpg, atau .jpeg');
        document.getElementById('file_dokumen').value=''
    }
   
});
</script>					
<td colspan=3 align=right>
<input type=submit  name='simpan_pengajuan' value='Simpan' id='simpan_pengajuan'>								
</td>
</tr>
<tr>
<td colspan=3 align=left>
Catatan : * harus diisi								
</td>
</tr>
</table></form>
</div>
<a id='popupBoxClose' onClick='unloadPopupBox2Visa(4);'>[X]</a>
</div>
</form>
<!--Akhir Tambah Info Resiprositas Visa-->

<!--Edit Info Resiprositas Visa-->
<script type='text/javascript'>
function validasi_input_edit(form){
var decimal=  /^[-+]?[0-9]+\.[0-9]+$/;   
  if (form.file_dokumen_edt.value != '' && form.dokumen_edt.value == ''){
    alert('Gagal!!! Jika File Dokumen terisi maka Nomor/Judul Dokumen Pendukung harus terisi!');
    form.dokumen_edt.focus();
    return (false);
  }
  if (form.file_dokumen_edt.value == '' && form.dokumen_edt.value != ''){
    alert('Gagal!!! Jika Nomor/Judul Dokumen Pendukung terisi maka File Dokumen harus terisi!');
    form.dokumen_edt.focus();
    return (false);
  }
}

</script>
<form method=POST id='frm1' enctype='multipart/form-data' action='./aksi_reprositas_visa.php?module=reprositas_visa&act=update_resiprositas' onsubmit='return validasi_input_edit(this)'>
<div id='popup_box5' style='overflow-y:scroll;' class='popup_box5'>
						<h2>Edit Informasi untuk Resiprositas Visa</h2>
						<div>                                               
<table width='100%'>
<tr><td>ID</td > <td width='6'>:</td><td > <input type=text name='id' id='id' required readonly></td></tr>
<tr>
<td  width='180'>Tgl. Edit</td><td width='6'>:</td><td>"; $tm1= date('Y-m-d h:i:s'); echo"<input type=text name='tgl_edt' id='tgl_edt' value='$tm1' required readonly></td>								
</tr>
<tr>
<td >User Edit</td><td width='6'>:</td><td>"; $usr1= $_SESSION['G_iduser']; echo"<input type=text name='usr_edt' id='usr_edt' size=20 value=$usr1 required readonly></td>								
</tr>
<tr><td>Negara Subjek*</td ><td width='6'>:</td><td > 
<select required name='negara_edt' id='negara_edt'>
			<option value=''>- Silahkan Pilih -</option>
			"; 
			$sql_ngr3="select * from m_negara where ID_NEGARA > 1";
                     $tampil_ngr3=mysql_query($sql_ngr3);
				 while($val=mysql_fetch_array($tampil_ngr3))
				 {
					echo "<option value='$val[ID_NEGARA]@@$val[NEGARA]'>$val[NEGARA]</option>";
				 }
		
			echo"</select>
</td></tr>
<tr><td>Sumber Informasi*</td > <td width='6'>:</td><td > <input type=text name='sumber_edt' id='sumber_edt' size=50 maxlength=250 required></td></tr>
<tr><td>Deskripsi Informasi*</td > <td width='6'>:</td><td > <textarea name='deskripsi_edt' id='deskripsi_edt' rows=8 cols=50 maxlength=2000 required></textarea></td></tr>
<tr><td>Nomor/Judul Dokumen Pendukung </br>------------</br>File Dokumen</td ><td width='6'>:</td><td > <input type=text name='dokumen_edt' id='dokumen_edt' size=50 maxlength=200></br><span name='fl_dok' id='fl_dok'></span><input type=hidden name='fl_aju_hd' id='fl_aju_hd'></br><input type=file name='file_dokumen_edt' id='file_dokumen_edt'></td></tr>
<tr><td>Status Aktif</td > <td width='6'>:</td><td > 
<select required name='sts_aktif' id='sts_aktif'>
			<option value='1'>Aktif</option>
                        <option value='0'>Tidak Aktif</option>
			</select>
                            </td></tr>
<script>
$('#file_dokumen').bind('change', function() {
var a = document.getElementById('file_dokumen').value;
  var ext = a.split('.');
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ['jpg' ,'jpeg', 'pdf'];
    
  if(this.files[0].size > 8044070){
  alert('ERROR: File terlalu besar, maksimal 8 mb');
  document.getElementById('file_dokumen').value=''
  }
  
    if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert('ERROR: Jenis file harus .pdf, .jpg, atau .jpeg');
        document.getElementById('file_dokumen').value=''
    }
   
});
</script>					
<td colspan=3 align=right>
<input type=submit  name='edit_resiprositas' value='Update' id='edit_resiprositas'>								
</td>
</tr>
<tr>
<td colspan=3 align=left>
Catatan : * harus diisi								
</td>
</tr>
</table></form>
</div>
<a id='popupBoxClose' onClick='unloadPopupBox2Visa(5);'>[X]</a>
</div>
</form>
<!--Akhir Edit Info Resiprositas Visa-->


          <table width=1000>
          <tr>
          <th width=10 >NO</th>
          <!--<th width=10 >ID</th>-->
          <th width=300 >NEGARA SUBJEK</th>
          <th  width=600 >DESKRIPSI INFORMASI</th>
          <th  width=150 >TANGGAL INPUT</th>
          <th  width=200 >USER INPUT</th>
          <th  width=200 >STATUS INFORMASI</th>
          <th width=80>AKSI</th></tr>	";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);
    
    if($_GET['deskripsi_info']!= '' && $_GET['nm_ngr']== '')
	{
		//echo 'isi';
                $aac = "and DESKRIPSI_INFORMASI like";
                $aad = "where DESKRIPSI_INFORMASI like";
		$ab = "'%".$_GET[deskripsi_info]."%'";
	}      
        elseif($_GET['deskripsi_info']== '' && $_GET['nm_ngr']!= '')
	{
		//echo 'isi';
               $aac = "or ID_NEGARA =";
                $aad = "where ID_NEGARA =";
		$ab = "'$_GET[nm_ngr]'";
	}
        elseif($_GET['nm_ngr']!= '' && $_GET['deskripsi_info']!= '')
	{
		//echo 'isi';
		$aac = "and ID_NEGARA ="."'$_GET[nm_ngr]'"."and DESKRIPSI_INFORMASI like"."'%".$_GET[deskripsi_info]."%'";
                $aad = "where ID_NEGARA ="."'$_GET[nm_ngr]'"."and DESKRIPSI_INFORMASI like"."'%".$_GET[deskripsi_info]."%'";
		$ab = "";
	}
        elseif($_GET['nm_ngr']== '' && $_GET['deskripsi_info']== '')
	{
		//echo 'isi';
		$aac = "or ID_NEGARA = '$_SESSION[G_idnegara]'";
        $aad = "";
		$ab = "";
	}
	
    
    if ($_SESSION[G_leveluser]==15 ){
	 $tampil=mysql_query("select * FROM tbl_resiprositas_visa where USER_INPUT='$_SESSION[G_iduser]' $aac $ab   order by NAMA_NEGARA limit $posisi,$batas");
         
    }elseif($_SESSION[G_leveluser]==14){
        $tampil=mysql_query("select * FROM tbl_resiprositas_visa $aad $ab  order by NAMA_NEGARA limit $posisi,$batas");
        
    }
    
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
        $panjang_text= strlen($r[DESKRIPSI_INFORMASI]);
        if($panjang_text >= 100){
	$desk = substr($r[DESKRIPSI_INFORMASI], 0,100).'......';
        }else{
            $desk = $r[DESKRIPSI_INFORMASI];
        }
        
        $kd= json_encode($r[ID]);
        $id_negara= json_encode($r[ID_NEGARA]);
        $nm_negara= json_encode($r[NAMA_NEGARA]);
        $deskripsi= json_encode($r[DESKRIPSI_INFORMASI]);
        $sumber= json_encode($r[SUMBER_INFORMASI]);
        $nomor_dok= json_encode($r[NOMOR_DOK]);
        $sts_aktif= json_encode($r[STATUS]);
        $lokasi_dok= json_encode('../files/otvis/resiprositas/'.$r[FILE]);
        $nm_file1= $r[FILE];
        if($nm_file1 == ''){
            $nm_file = json_encode('Tidak ada file');
        }else{
            $nm_file = json_encode($r[FILE]);
        }
        if($r[STATUS]==1){
            $sts="Aktif";
        }else{
             $sts="Tidak Aktif";
        }
      echo "<tr><td>$no</td>
				<!--<td>$r[ID]</td>-->
				<td>$r[NAMA_NEGARA] </td><td> $desk </td><td> $r[TGL_INPUT] </td><td> $r[USER_INPUT] </td><td> $sts </td>
                            <!-- <td align=center><a href=?module=negara&act=editnegara&idt=$r[ID]>Edit</a> | 
		                <a href=./aksi_negara.php?module=negara&act=hapus&idt=$r[ID] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NAMA_NEGARA] ?')\">Hapus</a></td>-->
                                    <td align=center>
                                        <input type='button' name='edit_resiprositas' id='edit_resiprositas' onClick='loadPopupBoxVisa(5,$kd,$id_negara,$nm_negara,$deskripsi,$sumber,$nomor_dok,$lokasi_dok, $nm_file,$sts_aktif);' value='Edit'></td>
		        </tr>";
      $no++;
    }
    echo "</table>";
  	$jmldata =mysql_num_rows(mysql_query("SELECT NAMA_NEGARA FROM  tbl_resiprositas_visa"));
	
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   $ilink = "?module=negara"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;
  
 
  case "editnegara":
    $idt = $_GET[idt];
    $edit = mysql_query("select ID_NEGARA,NEGARA,BENDERA,KET,NEG_RANTOR_K,NEG_RANTOR_I,KD_REGIONAL,NM_REGIONAL  from m_negara where ID_NEGARA = $idt ");
    $r    = mysql_fetch_array($edit);
 
	     echo "<h2>Edit Kewarganegaraan/Negara</h2>
          <form method=POST enctype='multipart/form-data' action='./aksi_negara.php?module=negara&act=update'>
         <input type=hidden name=idt value='$r[ID_NEGARA]'>
          
		  <table width=90%>
		  <tr><td width=120>Negara</td >  <td > : <input type=text name='negara' value='$r[NEGARA]' size=50></td></tr>";
		echo "<tr><td>Bendera</td>     <td > : <input type=file size=40 name=fupload></td></tr>		

		<tr><td width=120>Kode Regional</td >  <td > : <input type=text name='KD_REGIONAL' value='$r[KD_REGIONAL]' size=50></td></tr>
		  <tr><td width=120>Regional</td >  <td > : <input type=text name='NM_REGIONAL'  value='$r[NM_REGIONAL]' size=50></td></tr>

		  <tr><th colspan=2 height=30><div align=left >Jumlah fasilitas diberikan ke Indonesia</div></th></tr>
		  <tr><td width=120>Rantor Individu</td >  <td > : <input type=text  value='$r[NEG_RANTOR_I]' name='NEG_RANTOR_I' size=50></td></tr>
		  <tr><td width=120>Rantor Kantor</td >  <td > : <input type=text  value='$r[NEG_RANTOR_K]' name='NEG_RANTOR_K' size=50></td></tr>
		  
		  <tr><td></td><td align=right><input type=submit value=Update> <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
   
}
?>
