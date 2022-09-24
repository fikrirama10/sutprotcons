<?php
switch($_GET[act]){
  // Tampil Berita
  default:
		
		echo "<h2>Master Relasi </h2><br>
          <input type=button value='Tambah' onclick=location.href='?module=relasi&act=tambahrelasi'>
          
		  <table width=90%>
          <tr>	<th width=30>no</th>
		  		<th width=160>Jenis Relasi</th>
				<th>Keterangan</th>
				<th width=60>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

	$tampil=mysql_query("select ID_JNS_RELASI, NM_JNS_RELASI,KET from m_jns_relasi where ID_JNS_RELASI > 0 order by NM_JNS_RELASI limit $posisi,$batas");
	
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

		
    echo "	<tr><td>$no</td>
			<td>$r[NM_JNS_RELASI]</td>
			<td>$r[KET]</td>
			<td><a href=?module=relasi&act=editrelasi&idt=$r[ID_JNS_RELASI]>Edit</a> | 
				<a href=./aksi_relasi.php?module=relasi&act=hapus&idt=$r[ID_JNS_RELASI] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NM_JNS_RELASI] ?')\">Hapus</a></td></tr>";
      $no++;
    }
    echo "</table>";
  	$jmldata =mysql_num_rows(mysql_query("SELECT NM_JNS_RELASI FROM  m_jns_relasi where ID_JNS_RELASI > 0"));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
	$ilink = "?module=relasi"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
    echo "<div id=paging>$linkHalaman</div><br>";
    break;
  
  case "tambahrelasi":
    echo "<h2>Tambah Master Relasi</h2>
          <form method=POST action='./aksi_relasi.php?module=relasi&act=input' enctype='multipart/form-data'>
          	<table width=90%>
          	<tr><td width=120>Jenis Relasi</td >  <td > : <input type=text name='nm_jns_relasi' size=50></td></tr>
		  	<tr><td>Keterangan </td>     <td > : <textarea name='ket' rows=2 cols=50 ></textarea></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Simpan> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;
   
  case "editrelasi":
    $idt = $_GET[idt];
    $edit = mysql_query("select ID_JNS_RELASI,NM_JNS_RELASI,KET from m_jns_relasi where ID_JNS_RELASI = $idt ");
    $r    = mysql_fetch_array($edit);
 	echo "<h2>Edit Relasi</h2>
         <form method=POST enctype='multipart/form-data' action='./aksi_relasi.php?module=relasi&act=update'>
         <input type=hidden name=idt value='$r[ID_JNS_RELASI]'>
         	<table width=90%>
		  	<tr><td width=120>Jenis Relasi</td >  <td > : <input type=text name='nm_jns_relasi' value='$r[NM_JNS_RELASI]' size=50></t</tr>
		  	<tr><td>Keterangan </td>     <td > : <textarea name='ket'  rows=2 cols=50 >$r[KET]</textarea></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Update> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;
   
}
?>
