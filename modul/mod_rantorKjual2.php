<?php
	   echo "<br><b><a href=?module=rantorKjual&act=cari&huruf=A>A</A> |	<a href=?module=rantorKjual&act=cari&huruf=B>B</A> |	<a href=?module=rantorKjual&act=cari&huruf=C>C</A> |	<a href=?module=rantorKjual&act=cari&huruf=D>D</A> |	<a href=?module=rantorKjual&act=cari&huruf=E>E</A> |	<a href=?module=rantorKjual&act=cari&huruf=F>F</A> |	<a href=?module=rantorKjual&act=cari&huruf=G>G</A> |	<a href=?module=rantorKjual&act=cari&huruf=H>H</A> |	<a href=?module=rantorKjual&act=cari&huruf=I>I</A> |	<a href=?module=rantorKjual&act=cari&huruf=J>J</A> |	<a href=?module=rantorKjual&act=cari&huruf=K>K</A> |	<a href=?module=rantorKjual&act=cari&huruf=L>L</A> |	<a href=?module=rantorKjual&act=cari&huruf=M>M</A> |	<a href=?module=rantorKjual&act=cari&huruf=N>N</A> |	<a href=?module=rantorKjual&act=cari&huruf=O>O</A> |	<a href=?module=rantorKjual&act=cari&huruf=P>P</A> |	<a href=?module=rantorKjual&act=cari&huruf=Q>Q</A> |	<a href=?module=rantorKjual&act=cari&huruf=R>R</A> |	<a href=?module=rantorKjual&act=cari&huruf=S>S</A> |	<a href=?module=rantorKjual&act=cari&huruf=T>T</A> |	<a href=?module=rantorKjual&act=cari&huruf=U>U</A> |	<a href=?module=rantorKjual&act=cari&huruf=V>V</A> |	<a href=?module=rantorKjual&act=cari&huruf=W>W</A> |	<a href=?module=rantorKjual&act=cari&huruf=X>X</A> |	<a href=?module=rantorKjual&act=cari&huruf=Y>Y</A> |	<a href=?module=rantorKjual&act=cari&huruf=Z>Z</A> </b>";
		

switch($_GET[act]){
  default:		    
		if (isset($_GET[negara])) {
			$negaranya = $_GET[negara];
			if ($_GET[negara] == ""){$negaranya = 'Semua negara';}		
		}
		else
		{
		$negaranya = 'Semua negara';
		}

		echo "<h2>Jual Rantor Individu<br>Pilih Kantor Perwakilan - $negaranya</h2>
			 <br>

		  <table width=100%>
          <tr><th width=30>no</th><th width=150>KANTOR PERWAKILAN</th><th width=200>ALAMAT</th><th>TELP</th><th width=90>KOTA</th><th width=150>NEGARA</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];

	$tampil=mysql_query("select ID_KNT_PERWAKILAN,ID_NEGARA,NM_KNT_PERWAKILAN,ALAMAT,KOTA,TELP,BENDERA,NM_JNS_PERWAKILAN,NEGARA FROM v_kantor_perwakilan  where negara like '".$neg."%' and (ID_KNT_PERWAKILAN >1 )  order by negara,NM_KNT_PERWAKILAN limit $posisi,$batas");
	
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

	   echo "<tr><td>$no</td>
                <td><a href=?module=rantorKjual&act=lihat_rantorKjual&idt=$r[ID_KNT_PERWAKILAN]&negara=$_GET[negara]> $r[NM_KNT_PERWAKILAN] </a></td>
                <td>$r[ALAMAT]</td>
				<td>$r[TELP]</td>		
				<td>$r[KOTA]</td>		
				<td><img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" />  &nbsp $r[NEGARA]</td>
		        </tr>";
      $no++;
    }
    echo "</table>";
	
		$jmldata =mysql_num_rows(mysql_query("select ID_KNT_PERWAKILAN FROM v_kantor_perwakilan  where negara like '".$neg."%' and (ID_KNT_PERWAKILAN >1 ) "));
	
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   $ilink = "?module=rantorKjual&negara=$_GET[negara]"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;


  case "lihat_rantorKjual":
	$idt = $_GET[idt];
    $input = mysql_query("select ID_KNT_PERWAKILAN,NEGARA,NM_KNT_PERWAKILAN,ALAMAT,KOTA,TELP,BENDERA,NM_JNS_PERWAKILAN,FAX,KET FROM v_kantor_perwakilan  where ID_KNT_PERWAKILAN  = $idt  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Jual Rantor Kantor - Lihat</h2>";
	 echo "<table width=100%>
			<tr><td  width=160>Asal Negara</td>  <td > : $r[NEGARA] &nbsp <img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" /></td></tr>
			<tr><td>Jenis Kantor</td>     <td> : $r[NM_JNS_PERWAKILAN]</td></tr> 
			<tr><td>Nama Kantor</td>     <td> : $r[NM_KNT_PERWAKILAN]</td></tr>
			<tr><td>Alamat di Luar Negeri </td>     <td > : <textarea name='ALAMAT' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMAT]</textarea></td></tr>
			<tr><td>Kota</td>     <td> : $r[KOTA]</td></tr> 
			<tr><td>Telepon / Fax</td>     <td> : $r[TELP] / $r[FAX]</td></tr>
		   	<tr><td>Keterangan </td>     <td > : <textarea name='KET' rows=4 cols=48 readonly=\"readonly\" >$r[KET]</textarea></td></tr>
		 </table> <br>";

	echo " <input type=button value='Tambah' onclick=location.href='?module=rantorKjual&act=tambah_rantorKjual&idt=$idt&negara=$_GET[negara]'>
			<table width=100%>
          <tr><th  width=30>no</th><th>Tanggal Izin Impor</th><th >No Izin</th><th width=90>Deskripsi</th><th width=90>No Polisi</th><th width=90>Status</th> <th width=60>AKSI</th></tr>"; 

    $p      = new Paging;
    $batas  = 200;
    $posisi = $p->cariPosisi($batas);

    $tampil=mysql_query("select ID_PENGGUNAA_FAS,ID_JNS_FASILITAS,ID_DIPLOMAT,ID_KNT_PERWAKILAN,NO_IZIN_JUAL,DATE_FORMAT(TGL_IZIN_JUAL,'%d %M %Y') AS TGL_IZIN_JUAL,ALASAN_PENJUALAN,REKOMENDASI_BENGKEL,NAMA_PEMBELI,ALAMAT_PEMBELI,NO_KTP_PEMBELI,DESKRIPSI,QTY,ST_PERSETUJUAN,NO_POLISI,TAHUN,MEREK,NO_MESIN from penggunaan_fasilitas  where ID_DIPLOMAT = 1 and ID_KNT_PERWAKILAN = $idt and (ID_JNS_FASILITAS=2) and (NO_IZIN_JUAL is not null) order by ID_PENGGUNAA_FAS ");



	$no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      echo "<tr><td>$no</td>
                <td>$r[TGL_IZIN_JUAL]</td>
				<td>$r[NO_IZIN_JUAL]</td>
				<td>$r[DESKRIPSI]</td>
				<td>$r[NO_POLISI]</td>
				<td align =center>";
		
		if ($r[ST_PERSETUJUAN] == 2){
			
			echo "<div style=\"color : green\"> <b>approved</b> </div>";
		}elseif ($r[ST_PERSETUJUAN] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>waiting</b> </div>";
		}elseif ($r[ST_PERSETUJUAN] == 0){
		
			echo "<div style=\"color : #800000\"> <b>rejected</b> </div>";
		}
		
		echo "</td>
				<td><a href=?module=rantorKjual&act=edit_rantorKjual&idt=$r[ID_PENGGUNAA_FAS]&idd=$idt&negara=$_GET[negara]>Edit</a> | 
		            <a href=./aksi_rantorKjual.php?module=rantorKjual&act=hapus&idt=$r[ID_PENGGUNAA_FAS]&idd=$idt&negara=$_GET[negara] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus Rantor $r[DESKRIPSI]?')\">Hapus</a></td>
				</tr>";

      $no++;
    }
    echo "</table>";

				 
	break;
	
 case "tambah_rantorKjual":
	$idt = $_GET[idt];
    $input = mysql_query("select ID_KNT_PERWAKILAN,NEGARA,NM_KNT_PERWAKILAN,ALAMAT,KOTA,TELP,BENDERA,NM_JNS_PERWAKILAN,FAX,KET FROM v_kantor_perwakilan  where ID_KNT_PERWAKILAN  = $idt  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Jual Rantor Kantor - Tambah</h2>";
	 echo "<table width=100%>
			<tr><td  width=160>Asal Negara</td>  <td > : $r[NEGARA] &nbsp <img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" /></td></tr>
			<tr><td>Jenis Kantor</td>     <td> : $r[NM_JNS_PERWAKILAN]</td></tr> 
			<tr><td>Nama Kantor</td>     <td> : $r[NM_KNT_PERWAKILAN]</td></tr>
			<tr><td>Alamat di Luar Negeri </td>     <td > : <textarea name='ALAMAT' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMAT]</textarea></td></tr>
			<tr><td>Kota</td>     <td> : $r[KOTA]</td></tr> 
			<tr><td>Telepon / Fax</td>     <td> : $r[TELP] / $r[FAX]</td></tr>
		   	<tr><td>Keterangan </td>     <td > : <textarea name='KET' rows=4 cols=48 readonly=\"readonly\" >$r[KET]</textarea></td></tr>
		 </table> <br>";



	echo "<form method=POST enctype='multipart/form-data' action='./aksi_rantorKjual.php?module=rantorKjual&act=input&negara=$_GET[negara]'>
          <input type=hidden name=ID_DIPLOMAT value='1'>
     	  <input type=hidden name=ID_KNT_PERWAKILAN value='$r[ID_KNT_PERWAKILAN]'>
		  <table width=100%>		  		 
		<th colspan=2 align = left>Jual Rantor</th>	  
		<tr><td  width=120>Tanggal Persetujuan</td>  <td > 
          <DIV id=\"tgl\"> <script>DateInput('TGL_PERSETUJUAN', true, 'YYYY-MM-DD')</script></div> </td></tr>
		<tr><td>No Izin Jual</td>     <td> : <input type=text name='NO_IZIN_BELI' size=50  ></td></tr>
		
        <tr><td>Deskripsi</td>     <td> : <input type=text name='DESKRIPSI' size=50  ></td></tr>
		<tr><td>Merek</td>     <td> : <input type=text name='MEREK' size=50  ></td></tr>
		<tr><td>Tahun</td>     <td> : <input type=text name='TAHUN' size=50  ></td></tr>
		<tr><td>No Polisi</td>     <td> : <input type=text name='NO_POLISI' size=50  ></td></tr>
		<tr><td>No Mesin</td>     <td> : <input type=text name='NO_MESIN' size=50  ></td></tr>
		<tr><td  width=120>Status permohonan</td>  <td > : 
          <select name='ST_PERSETUJUAN' >
			<option value=0 selected>rejected</option>
			<option value=1 >waiting</option>
			<option value=2 >approved</option>
		  </select></td></tr>
		<tr><td colspan=2 align=right><input type=submit value=Simpan>
              <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>			
		</form>";


 break;
 case "edit_rantorKjual":
	$idt = $_GET[idt];
	$idd = $_GET[idd];

   $input = mysql_query("select ID_KNT_PERWAKILAN,NEGARA,NM_KNT_PERWAKILAN,ALAMAT,KOTA,TELP,BENDERA,NM_JNS_PERWAKILAN,FAX,KET FROM v_kantor_perwakilan  where ID_KNT_PERWAKILAN  = $idd  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Jual Rantor Kantor - Edit</h2>";
	 echo "<table width=100%>
			<tr><td  width=160>Asal Negara</td>  <td > : $r[NEGARA] &nbsp <img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" /></td></tr>
			<tr><td>Jenis Kantor</td>     <td> : $r[NM_JNS_PERWAKILAN]</td></tr> 
			<tr><td>Nama Kantor</td>     <td> : $r[NM_KNT_PERWAKILAN]</td></tr>
			<tr><td>Alamat di Luar Negeri </td>     <td > : <textarea name='ALAMAT' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMAT]</textarea></td></tr>
			<tr><td>Kota</td>     <td> : $r[KOTA]</td></tr> 
			<tr><td>Telepon / Fax</td>     <td> : $r[TELP] / $r[FAX]</td></tr>
		   	<tr><td>Keterangan </td>     <td > : <textarea name='KET' rows=4 cols=48 readonly=\"readonly\" >$r[KET]</textarea></td></tr>
		 </table> <br>";



	$edit = mysql_query("select ID_PENGGUNAA_FAS,ID_JNS_FASILITAS,ID_DIPLOMAT,ID_KNT_PERWAKILAN,TGL_PERSETUJUAN,DESKRIPSI,NO_PERSETUJUAN,QTY,
ST_PERSETUJUAN,JNS_TRANS_FAS,NO_POLISI,TAHUN,MEREK,NO_MESIN,NO_IZIN_IMPOR,TGL_IZIN_IMPOR,NO_NOTE_IMPOR,PELABUHAN_IMPOR,KAPAL_IMPOR,TGL_TIBA_IMPOR,TGL_SURAT_IMPOR,PEMOHON_IMPOR,JABATAN_IMPOR,APPROVAL_IMPOR,NIP_APPROVAL_IMPOR,NO_IZIN_BELI,NO_IZIN_JUAL,TGL_IZIN_JUAL,ALASAN_PENJUALAN,REKOMENDASI_BENGKEL,NAMA_PEMBELI,ALAMAT_PEMBELI,NO_KTP_PEMBELI from penggunaan_fasilitas where ID_PENGGUNAA_FAS = $idt ");   
	
	$r    = mysql_fetch_array($edit);

	echo "<form method=POST enctype='multipart/form-data' action='./aksi_rantorKjual.php?module=rantorKjual&act=update&idt=$idt&negara=$_GET[negara]'>
          <input type=hidden name=ID_DIPLOMAT value='1'>
     	  <input type=hidden name=ID_KNT_PERWAKILAN value='$r[ID_KNT_PERWAKILAN]'>
		  <table width=100%>		  		 
		<th colspan=2 align = left>Jual Rantor</th>	  
		<tr><td  width=120>Tanggal Persetujuan</td>  <td > 
          <DIV id=\"tgl\"> <script>DateInput('TGL_PERSETUJUAN', true, 'YYYY-MM-DD','$r[TGL_PERSETUJUAN]')</script></div> </td></tr>
		<tr><td>No Izin Jual</td>     <td> : <input type=text name='NO_IZIN_BELI' size=50  value= '$r[NO_IZIN_BELI]' ></td></tr>
		
        <tr><td>Deskripsi</td>     <td> : <input type=text name='DESKRIPSI' size=50   value= '$r[DESKRIPSI]'  ></td></tr>
		<tr><td>Merek</td>     <td> : <input type=text name='MEREK' size=50   value= '$r[MEREK]'  ></td></tr>
		<tr><td>Tahun</td>     <td> : <input type=text name='TAHUN' size=50   value= '$r[TAHUN]'  ></td></tr>
		<tr><td>No Polisi</td>     <td> : <input type=text name='NO_POLISI' size=50   value= '$r[NO_POLISI]'  ></td></tr>
		<tr><td>No Mesin</td>     <td> : <input type=text name='NO_MESIN' size=50  value= '$r[NO_MESIN]'   ></td></tr>
		
		<tr><td  width=120>Status permohonan</td>  <td > : 
          <select name='ST_PERSETUJUAN' >
			<option value=0 ";
			if ($r[ST_PERSETUJUAN]==0){echo " selected ";}
	echo ">rejected</option>
			<option value=1 ";
			if ($r[ST_PERSETUJUAN]==1){echo " selected ";}
	echo ">waiting</option>
			<option value=2 ";
			if ($r[ST_PERSETUJUAN]==2){echo " selected ";}
	echo ">approved</option>
		  </select></td></tr>
		
		<tr><td colspan=2 align=right><input type=submit value=Simpan>
              <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>			
		</form>";


	
 break;
  case "cari":
    $alf = $_GET[huruf];
	  

	  echo "<br><br><a style=\"font-size: 22pt;\">$alf</a>";
	echo "<h2>Jual Rantor Individu - Pilih Negara</h2>
		 <table width=100%>
          <tr><th width=10 rowspan=2>no</th><th  rowspan=2>Negara</th><th colspan=2>Fasilitas Diberikan oleh Indonesia</th><th colspan=2>Fasilitas Diberikan ke Indonesia</th></tr>
			<tr><th  width=80 >RANTOR</th><th width=80 >FAS. LAIN</th> <th  width=80 >RANTOR</th><th width=80 >FAS. LAIN</th></tr>	 "; 

    $p      = new Paging;
    $batas  = 200;
    $posisi = $p->cariPosisi($batas);

    $tampil=mysql_query("SELECT  ID_NEGARA,NEGARA,BENDERA,JML_RANTOR,JML_FASILITAS,NEG_RANTOR,NEG_FASILITAS from v_resiprositas  where negara like '".$alf."%' and id_negara > 1 order by negara");
	$no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      echo "<tr><td>$no</td>
				<td><img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" />  
				&nbsp <a href=?module=rantorKjual&negara=$r[NEGARA]>$r[NEGARA]</a> </td><td align=right> $r[JML_RANTOR] </td><td align=right> $r[JML_FASILITAS]</td>
					<td align=right> $r[NEG_RANTOR] </td><td align=right> $r[NEG_FASILITAS]</td>
		            </tr>	
				";
      $no++;
    }
    echo "</table>";
    break;

}
?>
