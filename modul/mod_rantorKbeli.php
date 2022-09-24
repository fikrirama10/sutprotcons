<?php
	   echo "<br><b><a href=?module=rantorKbeli&act=cari&huruf=A>A</A> |	<a href=?module=rantorKbeli&act=cari&huruf=B>B</A> |	<a href=?module=rantorKbeli&act=cari&huruf=C>C</A> |	<a href=?module=rantorKbeli&act=cari&huruf=D>D</A> |	<a href=?module=rantorKbeli&act=cari&huruf=E>E</A> |	<a href=?module=rantorKbeli&act=cari&huruf=F>F</A> |	<a href=?module=rantorKbeli&act=cari&huruf=G>G</A> |	<a href=?module=rantorKbeli&act=cari&huruf=H>H</A> |	<a href=?module=rantorKbeli&act=cari&huruf=I>I</A> |	<a href=?module=rantorKbeli&act=cari&huruf=J>J</A> |	<a href=?module=rantorKbeli&act=cari&huruf=K>K</A> |	<a href=?module=rantorKbeli&act=cari&huruf=L>L</A> |	<a href=?module=rantorKbeli&act=cari&huruf=M>M</A> |	<a href=?module=rantorKbeli&act=cari&huruf=N>N</A> |	<a href=?module=rantorKbeli&act=cari&huruf=O>O</A> |	<a href=?module=rantorKbeli&act=cari&huruf=P>P</A> |	<a href=?module=rantorKbeli&act=cari&huruf=Q>Q</A> |	<a href=?module=rantorKbeli&act=cari&huruf=R>R</A> |	<a href=?module=rantorKbeli&act=cari&huruf=S>S</A> |	<a href=?module=rantorKbeli&act=cari&huruf=T>T</A> |	<a href=?module=rantorKbeli&act=cari&huruf=U>U</A> |	<a href=?module=rantorKbeli&act=cari&huruf=V>V</A> |	<a href=?module=rantorKbeli&act=cari&huruf=W>W</A> |	<a href=?module=rantorKbeli&act=cari&huruf=X>X</A> |	<a href=?module=rantorKbeli&act=cari&huruf=Y>Y</A> |	<a href=?module=rantorKbeli&act=cari&huruf=Z>Z</A> </b>";
		

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
		echo "<h2>Beli Rantor Kantor<br>Pilih Kantor Perwakilan - $negaranya</h2>
							
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
                <td><a href=?module=rantorKbeli&act=lihat_rantorKbeli&idt=$r[ID_KNT_PERWAKILAN]&negara=$_GET[negara]> $r[NM_KNT_PERWAKILAN] </a></td>
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

   $ilink = "?module=rantorKbeli&negara=$_GET[negara]"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;

  case "lihat_rantorKbeli":
	$idt = $_GET[idt];
    $input = mysql_query("select ID_KNT_PERWAKILAN,NEGARA,NM_KNT_PERWAKILAN,ALAMAT,KOTA,TELP,BENDERA,NM_JNS_PERWAKILAN,FAX,KET FROM v_kantor_perwakilan  where ID_KNT_PERWAKILAN  = $idt  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Beli Rantor Kantor - Lihat</h2>";
	 echo "<table width=100%>
			<tr><td  width=160>Asal Negara</td>  <td > : $r[NEGARA] &nbsp <img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" /></td></tr>
			<tr><td>Jenis Kantor</td>     <td> : $r[NM_JNS_PERWAKILAN]</td></tr> 
			<tr><td>Nama Kantor</td>     <td> : $r[NM_KNT_PERWAKILAN]</td></tr>
			<tr><td>Alamat Indonesia </td>     <td > : <textarea name='ALAMAT' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMAT]</textarea></td></tr>
			<tr><td>Kota</td>     <td> : $r[KOTA]</td></tr> 
			<tr><td>Telepon / Fax</td>     <td> : $r[TELP] / $r[FAX]</td></tr>
		   	<tr><td>Keterangan </td>     <td > : <textarea name='KET' rows=4 cols=48 readonly=\"readonly\" >$r[KET]</textarea></td></tr>
		 </table> <br>";



	echo " <input type=button value='Tambah' onclick=location.href='?module=rantorKbeli&act=tambah_rantorKbeli&idt=$idt&negara=$_GET[negara]'>
			<table width=100%>
          <tr><th  width=30>no</th><th>Tanggal Izin Beli</th><th >No Izin</th><th width=90>Deskripsi</th><th width=90>No Polisi</th><th width=90>STATUS DIREKTUR</th><th width=90>STATUS KASUBDIT</th> <th width=60>AKSI</th></tr>"; 
    $p      = new Paging;
    $batas  = 200;
    $posisi = $p->cariPosisi($batas);

    $tampil=mysql_query("select ID_PENGGUNAA_FAS,ID_JNS_FASILITAS,ID_DIPLOMAT,ID_KNT_PERWAKILAN,DATE_FORMAT(TGL_PERSETUJUAN,'%d %M %Y') AS TGL_PERSETUJUAN,DESKRIPSI,NO_IZIN_BELI,QTY,ST_PERSETUJUAN,ST_PERSETUJUAN_K,NO_POLISI,TAHUN,MEREK,NO_MESIN from penggunaan_fasilitas  where ID_DIPLOMAT = 1 and ID_KNT_PERWAKILAN = $idt and (ID_JNS_FASILITAS=1) and (NO_IZIN_BELI is not null) order by ID_PENGGUNAA_FAS ");


	$no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      echo "<tr><td>$no</td>
                <td>$r[TGL_PERSETUJUAN]</td>
				<td>$r[NO_IZIN_BELI]</td>
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
		
		echo "</td><td align =center>";
		if ($r[ST_PERSETUJUAN_K] == 2){
			
			echo "<div style=\"color : green\"> <b>approved</b> </div>";
		}elseif ($r[ST_PERSETUJUAN_K] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>waiting</b> </div>";
		}elseif ($r[ST_PERSETUJUAN_K] == 0){
		
			echo "<div style=\"color : #800000\"> <b>rejected</b> </div>";
		}
		
		echo "</td>

				<td><a href=?module=rantorKbeli&act=edit_rantorKbeli&idt=$r[ID_PENGGUNAA_FAS]&idd=$idt&negara=$_GET[negara]>Edit</a> | 
		            <a href=./aksi_rantorKbeli.php?module=rantorKbeli&act=hapus&idt=$r[ID_PENGGUNAA_FAS]&idd=$idt&negara=$_GET[negara] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus Rantor $r[DESKRIPSI]?')\">Hapus</a></td>
				</tr>";

      $no++;
    }
    echo "</table>";

	break;
	
 case "tambah_rantorKbeli":
	$idt = $_GET[idt];
    $input = mysql_query("select ID_KNT_PERWAKILAN,NEGARA,NM_KNT_PERWAKILAN,ALAMAT,KOTA,TELP,BENDERA,NM_JNS_PERWAKILAN,FAX,KET FROM v_kantor_perwakilan  where ID_KNT_PERWAKILAN  = $idt  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Beli Rantor Kantor - Tambah</h2>";
	 echo "<table width=100%>
			<tr><td  width=160>Asal Negara</td>  <td > : $r[NEGARA] &nbsp <img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" /></td></tr>
			<tr><td>Jenis Kantor</td>     <td> : $r[NM_JNS_PERWAKILAN]</td></tr> 
			<tr><td>Nama Kantor</td>     <td> : $r[NM_KNT_PERWAKILAN]</td></tr>
			<tr><td>Alamat Indonesia </td>     <td > : <textarea name='ALAMAT' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMAT]</textarea></td></tr>
			<tr><td>Kota</td>     <td> : $r[KOTA]</td></tr> 
			<tr><td>Telepon / Fax</td>     <td> : $r[TELP] / $r[FAX]</td></tr>
		   	<tr><td>Keterangan </td>     <td > : <textarea name='KET' rows=4 cols=48 readonly=\"readonly\" >$r[KET]</textarea></td></tr>
		 </table> <br>";

	echo "<form method=POST enctype='multipart/form-data' action='./aksi_rantorKbeli.php?module=rantorKbeli&act=input&negara=$_GET[negara]'>
          <input type=hidden name=ID_DIPLOMAT value='1'>
     	  <input type=hidden name=ID_KNT_PERWAKILAN value='$r[ID_KNT_PERWAKILAN]'>
		  <table width=100%>		  		 
		<th colspan=2 align = left>Beli Rantor</th>	  
		<tr><td  width=120>Tanggal Persetujuan</td>  <td > 
          <DIV id=\"tgl\"> <script>DateInput('TGL_PERSETUJUAN', true, 'YYYY-MM-DD')</script></div> </td></tr>
		<tr><td>No Izin Beli</td>     <td> : <input type=text name='NO_IZIN_BELI' size=50  ></td></tr>
		
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
 case "edit_rantorKbeli":
	$idt = $_GET[idt];
	$idd = $_GET[idd];

   $input = mysql_query("select ID_KNT_PERWAKILAN,NEGARA,NM_KNT_PERWAKILAN,ALAMAT,KOTA,TELP,BENDERA,NM_JNS_PERWAKILAN,FAX,KET FROM v_kantor_perwakilan  where ID_KNT_PERWAKILAN  = $idd  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Beli Rantor Kantor - Edit</h2>";
	 echo "<table width=100%>
			<tr><td  width=160>Asal Negara</td>  <td > : $r[NEGARA] &nbsp <img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" /></td></tr>
			<tr><td>Jenis Kantor</td>     <td> : $r[NM_JNS_PERWAKILAN]</td></tr> 
			<tr><td>Nama Kantor</td>     <td> : $r[NM_KNT_PERWAKILAN]</td></tr>
			<tr><td>Alamat Indonesia </td>     <td > : <textarea name='ALAMAT' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMAT]</textarea></td></tr>
			<tr><td>Kota</td>     <td> : $r[KOTA]</td></tr> 
			<tr><td>Telepon / Fax</td>     <td> : $r[TELP] / $r[FAX]</td></tr>
		   	<tr><td>Keterangan </td>     <td > : <textarea name='KET' rows=4 cols=48 readonly=\"readonly\" >$r[KET]</textarea></td></tr>
		 </table> <br>";




	$edit = mysql_query("select ID_PENGGUNAA_FAS,ID_JNS_FASILITAS,ID_DIPLOMAT,ID_KNT_PERWAKILAN,TGL_PERSETUJUAN,DESKRIPSI,NO_PERSETUJUAN,QTY,
ST_PERSETUJUAN,JNS_TRANS_FAS,NO_POLISI,TAHUN,MEREK,NO_MESIN,NO_IZIN_IMPOR,TGL_IZIN_IMPOR,NO_NOTE_IMPOR,PELABUHAN_IMPOR,KAPAL_IMPOR,TGL_TIBA_IMPOR,TGL_SURAT_IMPOR,PEMOHON_IMPOR,JABATAN_IMPOR,APPROVAL_IMPOR,NIP_APPROVAL_IMPOR,NO_IZIN_BELI,NO_IZIN_JUAL,TGL_IZIN_JUAL,ALASAN_PENJUALAN,REKOMENDASI_BENGKEL,NAMA_PEMBELI,ALAMAT_PEMBELI,NO_KTP_PEMBELI from penggunaan_fasilitas where ID_PENGGUNAA_FAS = $idt ");   
	
	$r    = mysql_fetch_array($edit);




	echo "<form method=POST enctype='multipart/form-data' action='./aksi_rantorKbeli.php?module=rantorKbeli&act=update&idt=$idt&negara=$_GET[negara]'>
          <input type=hidden name=ID_DIPLOMAT value='1'>
     	  <input type=hidden name=ID_KNT_PERWAKILAN value='$r[ID_KNT_PERWAKILAN]'>
		  <table width=100%>		  		 
		<th colspan=2 align = left>Beli Rantor</th>	  
		<tr><td  width=120>Tanggal Persetujuan</td>  <td > 
          <DIV id=\"tgl\"> <script>DateInput('TGL_PERSETUJUAN', true, 'YYYY-MM-DD','$r[TGL_PERSETUJUAN]')</script></div> </td></tr>
		<tr><td>No Izin Beli</td>     <td> : <input type=text name='NO_IZIN_BELI' size=50  value= '$r[NO_IZIN_BELI]' ></td></tr>
		
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
	echo "<h2>Beli Rantor Individu - Pilih Negara</h2>
<table width=100%>
          <tr><th width=10 rowspan=2>no</th><th rowspan=2>Negara</th><th colspan=3>Fasilitas Diberikan oleh Indonesia</th><th colspan=3>Rantor Diberikan ke Indonesia</th></tr>
			<tr><th  width=80 >JENIS FASILITAS</th><th  width=80 >JML RANTOR KANTOR</th><th width=80 >JML RANTOR INDIVIDU</th> <th  width=80 >JENIS FASILITAS</th><th  width=80 >JML RANTOR KANTOR</th><th width=80 >JML RANTOR INDIVIDU</th></tr>	 
			 ";


    $p      = new Paging;
    $batas  = 200;
    $posisi = $p->cariPosisi($batas);

	if (isset($_GET[huruf])){
	 $tampil=mysql_query("select ID_NEGARA,NEGARA,BENDERA,JML_RANTOR_K,JML_RANTOR_I,NEG_RANTOR_K,NEG_RANTOR_I from v_resiprositas where (ID_NEGARA > 1) and NEGARA like '$alf%' order by NEGARA limit $posisi,$batas");
	}else{
	 $tampil=mysql_query("select ID_NEGARA,NEGARA,BENDERA,JML_RANTOR_K,JML_RANTOR_I,NEG_RANTOR_K,NEG_RANTOR_I from v_resiprositas where ID_NEGARA > 1 order by NEGARA limit $posisi,$batas");
	}
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

		
		echo "<tr><td>$no</td>
				<td><img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" />  
				&nbsp <a href=?module=rantorKbeli&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";
		
	$tampilFas=mysql_query("select ID_JNS_FASILITAS from negara_jns_fas where ID_NEGARA = ".$r[ID_NEGARA]." and ST_FASILITAS_O = 1 order by ID_JNS_FASILITAS");
           			 	while($rFas=mysql_fetch_array($tampilFas)){
              				echo "$rFas[ID_JNS_FASILITAS], ";  
							}

		echo "</td><td align=right> $r[JML_RANTOR_K] </td><td align=right> $r[JML_RANTOR_I]</td> <td>";
	
	$tampilFas=mysql_query("select ID_JNS_FASILITAS from negara_jns_fas where ID_NEGARA = ".$r[ID_NEGARA]." and ST_FASILITAS_K = 1 order by ID_JNS_FASILITAS");
           			 	while($rFas=mysql_fetch_array($tampilFas)){
              				echo "$rFas[ID_JNS_FASILITAS], ";  
							}
		
		echo "</td>
					<td align=right> $r[NEG_RANTOR_K] </td><td align=right> $r[NEG_RANTOR_I]</td>
		            </tr>";
      $no++;
    }
    echo "</table>";
        echo "Keterangan <br>";  
			$tampilFas=mysql_query("select ID_JNS_FASILITAS,JNS_FASILITAS from m_jns_fasilitas order by ID_JNS_FASILITAS");
           			 	while($rFas=mysql_fetch_array($tampilFas)){
              				echo "$rFas[ID_JNS_FASILITAS] = $rFas[JNS_FASILITAS] <br>";  
							}
	break;

}
?>
