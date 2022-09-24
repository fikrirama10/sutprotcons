<?php
switch($_GET[act]){
  // Tampil Berita
  default:
		
		echo "<h2>Master Visa </h2><br>
          <input type=button value='Tambah' onclick=location.href='?module=visa&act=tambahvisa'>
          
		  <table width=90%>
          <tr>	<th width=30>no</th>
		  		<th width=160>Jenis Visa</th>
				<th width=80>Kode Visa</th>
				<th>Keterangan</th>
				<th width=60>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

	$tampil=mysql_query("select ID_JNS_VISA, NM_JNS_VISA, KD_JNS_VISA, KET from m_jns_visa where ID_JNS_VISA > 0 order by NM_JNS_VISA limit $posisi,$batas");
	
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

		
    echo "	<tr><td>$no</td>
			<td>$r[NM_JNS_VISA]</td>
			<td>$r[KD_JNS_VISA]</td>
			<td>$r[KET]</td>
			<td><a href=?module=visa&act=editvisa&idt=$r[ID_JNS_VISA]>Edit</a> | 
				<a href=./aksi_visa.php?module=visa&act=hapus&idt=$r[ID_JNS_VISA] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NM_JNS_VISA] ?')\">Hapus</a></td></tr>";
      $no++;
    }
    echo "</table>";
  	$jmldata =mysql_num_rows(mysql_query("SELECT NM_JNS_VISA FROM  m_jns_visa where ID_JNS_VISA > 0"));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
	$ilink = "?module=visa"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
    echo "<div id=paging>$linkHalaman</div><br>";
    break;
  
  case "tambahvisa":
    echo "<h2>Tambah Master Visa</h2>
          <form method=POST action='./aksi_visa.php?module=visa&act=input' enctype='multipart/form-data'>
          	<table width=90%>
          	<tr><td width=120>Jenis Visa</td >  <td > : <input type=text name='nm_jns_visa' size=50></td></tr>
          	<tr><td >Kode Jenis Visa</td >  <td > : <input type=text name='kd_jns_visa' size=10></td></tr>
		  	<tr><td>Keterangan </td>     <td > : <textarea name='ket' rows=2 cols=50 ></textarea></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Simpan> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;
   
  case "editvisa":
    $idt = $_GET[idt];
    $edit = mysql_query("select ID_JNS_VISA,NM_JNS_VISA,KD_JNS_VISA,KET from m_jns_visa where ID_JNS_VISA = $idt ");
    $r    = mysql_fetch_array($edit);
 	echo "<h2>Edit Visa</h2>
         <form method=POST enctype='multipart/form-data' action='./aksi_visa.php?module=visa&act=update'>
         <input type=hidden name=idt value='$r[ID_JNS_VISA]'>
         	<table width=90%>
		  	<tr><td width=120>Jenis Visa</td >  <td > : <input type=text name='nm_jns_visa' value='$r[NM_JNS_VISA]' size=50></td></tr>
          	<tr><td>Kode Jenis Visa</td >  <td > : <input type=text name='kd_jns_visa' value='$r[KD_JNS_VISA]' size=10></td></tr>
		  	<tr><td>Keterangan </td>     <td > : <textarea name='ket'  rows=2 cols=50 >$r[KET]</textarea></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Update> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;
   
}
?>
