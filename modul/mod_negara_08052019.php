<?php
switch($_GET[act]){
  // Tampil Berita
  default:
		
		echo "<h2>Master Kewarganegaraan/Negara </h2>
			 <br>
          <input type=button value='Tambah' onclick=location.href='?module=negara&act=tambahnegara'>
          <table width=650>
          <tr><th width=10 >no</th><th width=300 >Kewarganegaraan/Negara</th><th  width=150 >REGIONAL</th><th width=100>AKSI</th></tr>	";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

	 $tampil=mysql_query("select   ID_NEGARA,NEGARA,BENDERA,KET,NEG_RANTOR_K,NEG_RANTOR_I,KD_REGIONAL,NM_REGIONAL FROM m_negara where ID_NEGARA > 1 order by NEGARA limit $posisi,$batas");
	
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

		
      echo "<tr><td>$no</td>
				<td><img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" />  
				&nbsp $r[NEGARA] </td><td> $r[NM_REGIONAL] </td>
		            <td align=center><a href=?module=negara&act=editnegara&idt=$r[ID_NEGARA]>Edit</a> | 
		                <a href=./aksi_negara.php?module=negara&act=hapus&idt=$r[ID_NEGARA] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NEGARA] ?')\">Hapus</a></td>
		        </tr>";
      $no++;
    }
    echo "</table>";
  	$jmldata =mysql_num_rows(mysql_query("SELECT NEGARA FROM  m_negara where ID_NEGARA > 1"));
	
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   $ilink = "?module=negara"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;
  
  case "tambahnegara":
    echo "<h2>Tambah Kewarganegaraan/Negara</h2>
          <form method=POST action='./aksi_negara.php?module=negara&act=input' enctype='multipart/form-data'>
          <table width=90%>
          <tr><td width=120>Negara</td >  <td > : <input type=text name='negara' size=50></td></tr>
		  <tr><td>Bendera</td>     <td > : <input type=file size=40 name=fupload></td></tr>				  
		  <tr><td width=120>Kode Regional</td >  <td > : <input type=text name='KD_REGIONAL' size=50></td></tr>
		  <tr><td width=120>Regional</td >  <td > : <input type=text name='NM_REGIONAL' size=50></td></tr>
		  <tr><th colspan=2 height=30><div align=left >Jumlah fasilitas diberikan ke Indonesia</div></th></tr>
		  <tr><td width=120>Rantor Individu</td >  <td > : <input type=text name='NEG_RANTOR_I' size=50></td></tr>
		  <tr><td width=120>Eantor Kantor</td >  <td > : <input type=text name='NEG_RANTOR_K' size=50></td></tr>
		  
		  <tr><td></td><td align=right><input type=submit value=Simpan> <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
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
