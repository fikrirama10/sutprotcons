<?php
switch($_GET[act]){
  // Tampil Berita
  default:
		
		echo "<h2>Masters Paspor </h2><br>
          <input type=button value='Tambah' onclick=location.href='?module=paspor&act=tambahpaspor'>
          
		  <table width=90%>
          <tr>	<th width=30>no</th>
		  		<th width=160>Jenis Paspor</th>
				<th width=80>Kode Paspor</th>
				<th>Keterangan</th>
				<th width=60>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

	$tampil=mysql_query("select ID_JNS_PASPOR, JNS_PASPOR, KD_JNS_PASPOR, KET from m_jns_paspor where ID_JNS_PASPOR > 0 order by JNS_PASPOR limit $posisi,$batas");
	
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

		
    echo "	<tr><td>$no</td>
			<td>$r[JNS_PASPOR]</td>
			<td>$r[KD_JNS_PASPOR]</td>
			<td>$r[KET]</td>
			<td><a href=?module=paspor&act=editpaspor&idt=$r[ID_JNS_PASPOR]>Edit</a> | 
				<a href=./aksi_paspor.php?module=paspor&act=hapus&idt=$r[ID_JNS_PASPOR] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[JNS_PASPOR] ?')\">Hapus</a></td></tr>";
      $no++;
    }
    echo "</table>";
  	$jmldata =mysql_num_rows(mysql_query("SELECT JNS_PASPOR FROM  m_jns_paspor where ID_JNS_PASPOR > 0"));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
	$ilink = "?module=paspor"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
    echo "<div id=paging>$linkHalaman</div><br>";
    break;
  
  case "tambahpaspor":
    echo "<h2>Tambah Data Master Paspor</h2>
          <form method=POST action='./aksi_paspor.php?module=paspor&act=input' enctype='multipart/form-data'>
          	<table width=90%>
          	<tr><td width=120>Jenis Paspor</td >  <td > : <input type=text name='jns_paspor' size=50></td></tr>
          	<tr><td >Kode Jenis Paspor</td >  <td > : <input type=text name='kd_jns_paspor' size=10></td></tr>
		  	<tr><td>Keterangan </td>     <td > : <textarea name='ket' rows=2 cols=50 ></textarea></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Simpan> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;
   
  case "editpaspor":
    $idt = $_GET[idt];
    $edit = mysql_query("select ID_JNS_PASPOR,JNS_PASPOR,KD_JNS_PASPOR,KET from m_jns_paspor where ID_JNS_PASPOR = $idt ");
    $r    = mysql_fetch_array($edit);
 	echo "<h2>Edit Paspor</h2>
         <form method=POST enctype='multipart/form-data' action='./aksi_paspor.php?module=paspor&act=update'>
         <input type=hidden name=idt value='$r[ID_JNS_PASPOR]'>
         	<table width=90%>
		  	<tr><td width=120>Jenis Paspor</td >  <td > : <input type=text name='jns_paspor' value='$r[JNS_PASPOR]' size=50></td></tr>
          	<tr><td>Kode Jenis Paspor</td >  <td > : <input type=text name='kd_jns_paspor' value='$r[KD_JNS_PASPOR]' size=10></td></tr>
		  	<tr><td>Keterangan </td>     <td > : <textarea name='ket'  rows=2 cols=50 >$r[KET]</textarea></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Update> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;
   
}
?>
