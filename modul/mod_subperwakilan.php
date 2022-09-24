<?php
switch($_GET[act]){
  // Tampil Berita
  default:
		
		echo "<h2>Master Sub Jenis Perwakilan </h2><br>
          <input type=button value='Tambah' onclick=location.href='?module=subperwakilan&act=tambahsubperwakilan'>
          
		  <table width=90%>
          <tr>	<th width=30>no</th>
		  		<th width=160>Sub Jenis Perwakilan</th>
				<th>Jenis Perwakilan</th>
				<th>Keterangan</th>
				<th width=60>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

	$tampil=mysql_query("select a.NM_SUB_JNS,a.ID_SUB_JNS,b.ID_JNS_PERWAKILAN,b.NM_JNS_PERWAKILAN,a.KET from m_sub_jns_perwakilan a left join m_jns_perwakilan b on a.ID_JNS_PERWAKILAN = b.ID_JNS_PERWAKILAN where ID_SUB_JNS > 0 order by NM_SUB_JNS limit $posisi,$batas");
	
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

		
    echo "	<tr><td>$no</td>
			<td>$r[NM_SUB_JNS]</td>
			<td>$r[NM_JNS_PERWAKILAN]</td>
			<td>$r[KET]</td>
			<td><a href=?module=subperwakilan&act=editsubperwakilan&idt=$r[ID_SUB_JNS]>Edit</a> | 
				<a href=./aksi_subperwakilan.php?module=subperwakilan&act=hapus&idt=$r[ID_SUB_JNS] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NM_SUB_JNS] ?')\">Hapus</a></td></tr>";
      $no++;
    }
    echo "</table>";
  	$jmldata =mysql_num_rows(mysql_query("SELECT NM_SUB_JNS FROM  m_sub_jns_perwakilan where ID_SUB_JNS > 0"));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
	$ilink = "?module=subperwakilan"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
    echo "<div id=paging>$linkHalaman</div><br>";
    break;
  
  case "tambahsubperwakilan":
    echo "<h2>Tambah Master Sub Jenis Perwakilan</h2>
          <form method=POST action='./aksi_subperwakilan.php?module=subperwakilan&act=input' enctype='multipart/form-data'>
          	<table width=90%>
          	<tr><td width=120>Sub Jenis Perwakilan</td >  <td > : <input type=text name='nm_sub_jns' size=50></td></tr>
			
			<tr><td  width=120>Jenis Perwakilan</td>  <td colspan=\"2\"> : 
         		<select name='id_jns_perwakilan' >
            	<option value=0 selected>- Pilih Jenis Perwakilan -</option>";
            	$tampil=mysql_query("SELECT * FROM m_jns_perwakilan ORDER BY ID_JNS_PERWAKILAN");
           			 	while($r=mysql_fetch_array($tampil)){
              				echo "<option value=$r[ID_JNS_PERWAKILAN]>$r[NM_JNS_PERWAKILAN]</option>";
            			}echo "</select></td></tr>
		  	<tr><td>Keterangan </td>     <td > : <textarea name='ket' rows=2 cols=50 ></textarea></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Simpan> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;
   
  case "editsubperwakilan":
    $idt = $_GET[idt];
    $edit = mysql_query("select a.NM_SUB_JNS,a.ID_SUB_JNS,b.ID_JNS_PERWAKILAN,b.NM_JNS_PERWAKILAN,a.KET from m_sub_jns_perwakilan a left join m_jns_perwakilan b on a.ID_JNS_PERWAKILAN = b.ID_JNS_PERWAKILAN where a.ID_SUB_JNS = $idt ");
    $r    = mysql_fetch_array($edit);
 	echo "<h2>Edit Sub Jenis Perwakilan</h2>
         <form method=POST enctype='multipart/form-data' action='./aksi_subperwakilan.php?module=subperwakilan&act=update'>
         <input type=hidden name=idt value='$r[ID_SUB_JNS]'>
         	<table width=90%>
		  	<tr><td width=120>Sub Jenis Perwakilan</td >  <td > : <input type=text name='nm_sub_jns' value='$r[NM_SUB_JNS]' size=50></tr>

          <tr><td  width=120>Jenis Perwakilan</td>  <td colspan=\"2\"> : 
          <select name='id_jns_perwakilan'>";
            $tampil=mysql_query("SELECT ID_JNS_PERWAKILAN,NM_JNS_PERWAKILAN FROM m_jns_perwakilan ORDER BY ID_JNS_PERWAKILAN");
            while($w=mysql_fetch_array($tampil)){
			if ($r[ID_JNS_PERWAKILAN]==$w[ID_JNS_PERWAKILAN]){
				echo "<option value=$w[ID_JNS_PERWAKILAN] selected>$w[NM_JNS_PERWAKILAN]</option>";
			}
			else{
				echo "<option value=$w[ID_JNS_PERWAKILAN]>$w[NM_JNS_PERWAKILAN]</option>";
			}
			}echo "</select></td>
		  	<tr><td>Keterangan </td>     <td > : <textarea name='ket'  rows=2 cols=50 >$r[KET]</textarea></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Update> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;
   
}
?>
