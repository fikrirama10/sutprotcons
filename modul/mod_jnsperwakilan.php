<?php
switch($_GET[act]){
  // Tampil Berita
  default:
		
		echo "<h2>Master Jenis Perwakilan </h2><br>
          <input type=button value='Tambah' onclick=location.href='?module=jnsperwakilan&act=tambahjnsperwakilan'>
          
		  <table width=90%>
          <tr>	<th width=30>no</th>
		  		<th width=160>Jenis Perwakilan</th>
				<th>Keterangan</th>
				<th width=60>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

	$tampil=mysql_query("select ID_JNS_PERWAKILAN, NM_JNS_PERWAKILAN,KET from m_jns_perwakilan where ID_JNS_PERWAKILAN > 0 order by NM_JNS_PERWAKILAN limit $posisi,$batas");
	
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

		
    echo "	<tr><td>$no</td>
			<td>$r[NM_JNS_PERWAKILAN]</td>
			<td>$r[KET]</td>
			<td><a href=?module=jnsperwakilan&act=editjnsperwakilan&idt=$r[ID_JNS_PERWAKILAN]>Edit</a> | 
				<a href=./aksi_jnsperwakilan.php?module=jnsperwakilan&act=hapus&idt=$r[ID_JNS_PERWAKILAN] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NM_JNS_PERWAKILAN] ?')\">Hapus</a></td></tr>";
      $no++;
    }
    echo "</table>";
  	$jmldata =mysql_num_rows(mysql_query("SELECT NM_JNS_PERWAKILAN FROM  m_jns_perwakilan where ID_JNS_PERWAKILAN > 0"));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
	$ilink = "?module=jnsperwakilan"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
    echo "<div id=paging>$linkHalaman</div><br>";
    break;
  
  case "tambahjnsperwakilan":
    echo "<h2>Tambah Master Jenis Perwakilan</h2>
          <form method=POST action='./aksi_jnsperwakilan.php?module=jnsperwakilan&act=input' enctype='multipart/form-data'>
          	<table width=90%>
          	<tr><td width=120>Jenis Perwakilan</td >  <td > : <input type=text name='nm_jns_perwakilan' size=50></td></tr>
		  	<tr><td>Keterangan </td>     <td > : <textarea name='ket' rows=2 cols=50 ></textarea></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Simpan> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;
   
  case "editjnsperwakilan":
    $idt = $_GET[idt];
    $edit = mysql_query("select ID_JNS_PERWAKILAN,NM_JNS_PERWAKILAN,KET from m_jns_perwakilan where ID_JNS_PERWAKILAN = $idt ");
    $r    = mysql_fetch_array($edit);
 	echo "<h2>Edit Jenis Perwakilan</h2>
         <form method=POST enctype='multipart/form-data' action='./aksi_jnsperwakilan.php?module=jnsperwakilan&act=update'>
         <input type=hidden name=idt value='$r[ID_JNS_PERWAKILAN]'>
         	<table width=90%>
		  	<tr><td width=120>Jenis Perwakilan</td >  <td > : <input type=text name='nm_jns_perwakilan' value='$r[NM_JNS_PERWAKILAN]' size=50></t</tr>
		  	<tr><td>Keterangan </td>     <td > : <textarea name='ket'  rows=2 cols=50 >$r[KET]</textarea></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Update> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;
   
}
?>
