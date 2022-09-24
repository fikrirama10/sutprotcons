<?php
switch($_GET[act]){
  // Tampil Berita
  default:
		
		echo "<h2>Master Fasilitas </h2><br>
          <input type=button value='Tambah' onclick=location.href='?module=jnsfasilitas&act=tambahjnsfasilitas'>
          
		  <table width=90%>
          <tr>	<th width=30>no</th>
		  		<th width=160>Jenis Fasilitas</th>
				<th>Keterangan</th>
				<th width=60>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

	$tampil=mysql_query("select ID_JNS_FASILITAS, JNS_FASILITAS,KET from m_jns_fasilitas where ID_JNS_FASILITAS > 0 order by JNS_FASILITAS limit $posisi,$batas");
	
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

		
    echo "	<tr><td>$no</td>
			<td>$r[JNS_FASILITAS]</td>
			<td>$r[KET]</td>
			<td><a href=?module=jnsfasilitas&act=editjnsfasilitas&idt=$r[ID_JNS_FASILITAS]>Edit</a> | 
				<a href=./aksi_jnsfasilitas.php?module=jnsfasilitas&act=hapus&idt=$r[ID_JNS_FASILITAS] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[JNS_FASILITAS] ?')\">Hapus</a></td></tr>";
      $no++;
    }
    echo "</table>";
  	$jmldata =mysql_num_rows(mysql_query("SELECT JNS_FASILITAS FROM  m_jns_fasilitas where ID_JNS_FASILITAS > 0"));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
	$ilink = "?module=jnsfasilitas"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
    echo "<div id=paging>$linkHalaman</div><br>";
    break;
  
  case "tambahjnsfasilitas":
    echo "<h2>Tambah Master Fasilitas</h2>
          <form method=POST action='./aksi_jnsfasilitas.php?module=jnsfasilitas&act=input' enctype='multipart/form-data'>
          	<table width=90%>
          	<tr><td width=120>Jenis Fasilitas</td >  <td > : <input type=text name='jns_fasilitas' size=50></td></tr>
		  	<tr><td>Keterangan </td>     <td > : <textarea name='ket' rows=2 cols=50 ></textarea></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Simpan> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;
   
  case "editjnsfasilitas":
    $idt = $_GET[idt];
    $edit = mysql_query("select ID_JNS_FASILITAS,JNS_FASILITAS,KET from m_jns_fasilitas where ID_JNS_FASILITAS = $idt ");
    $r    = mysql_fetch_array($edit);
 	echo "<h2>Edit Fasilitas</h2>
         <form method=POST enctype='multipart/form-data' action='./aksi_jnsfasilitas.php?module=jnsfasilitas&act=update'>
         <input type=hidden name=idt value='$r[ID_JNS_FASILITAS]'>
         	<table width=90%>
		  	<tr><td width=120>Jenis Fasilitas</td >  <td > : <input type=text name='jns_fasilitas' value='$r[JNS_FASILITAS]' size=50></t</tr>
		  	<tr><td>Keterangan </td>     <td > : <textarea name='ket'  rows=2 cols=50 >$r[KET]</textarea></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Update> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;
   
}
?>
