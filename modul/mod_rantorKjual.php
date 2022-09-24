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
		echo "<h2>Jual Rantor Kantor<br>Pilih Kantor Perwakilan - $negaranya</h2>
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
	
	 echo "<h2 >Impor Rantor Kantor - Lihat</h2>";
	 echo "<table width=100%>
			<tr><td  width=160>Asal Negara</td>  <td > : $r[NEGARA] &nbsp <img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" /></td></tr>
			<tr><td>Jenis Kantor</td>     <td> : $r[NM_JNS_PERWAKILAN]</td></tr> 
			<tr><td>Nama Kantor</td>     <td> : $r[NM_KNT_PERWAKILAN]</td></tr>
			<tr><td>Alamat Indonesia </td>     <td > : <textarea name='ALAMAT' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMAT]</textarea></td></tr>
			<tr><td>Kota</td>     <td> : $r[KOTA]</td></tr> 
			<tr><td>Telepon / Fax</td>     <td> : $r[TELP] / $r[FAX]</td></tr>
		   	<tr><td>Keterangan </td>     <td > : <textarea name='KET' rows=4 cols=48 readonly=\"readonly\" >$r[KET]</textarea></td></tr>
		 </table> <br>";




	echo " <table width=100%>
          <tr><th  width=30>no</th><th>Tgl Izin Impor / Beli</th><th >No Izin Impor / Beli</th><th width=90>Merk</th><th width=90>No Polisi</th><th width=90>Status Asal</th> <th width=90>Status Kendaraan</th><th width=60>AKSI</th></tr>"; 

    $p      = new Paging;
    $batas  = 200;
    $posisi = $p->cariPosisi($batas);

    $tampil=mysql_query("select ID_PENGGUNAA_FAS,ID_JNS_FASILITAS,ID_DIPLOMAT,ID_KNT_PERWAKILAN, DATE_FORMAT(if(TGL_PERSETUJUAN is null,TGL_IZIN_IMPOR,TGL_PERSETUJUAN),'%d.%m.%Y') as TANGGAL_IZIN,  if(TGL_PERSETUJUAN is null,NO_IZIN_IMPOR,NO_IZIN_BELI) as NO_IZIN , if(TGL_PERSETUJUAN is null,'IMPOR','BELI') as ST_ASAL,if(TGL_IZIN_JUAL is null,'DIGUNAKAN','DIJUAL') as ST_KENDARAAN,DESKRIPSI,NO_POLISI,TAHUN,MEREK,NO_MESIN from penggunaan_fasilitas  where ID_KNT_PERWAKILAN = $idt and (ID_JNS_FASILITAS=1) AND (ST_PERSETUJUAN = 2) order by ID_PENGGUNAA_FAS ");

	$no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      echo "<tr><td>$no</td>
                <td>$r[TANGGAL_IZIN]</td>
				<td>$r[NO_IZIN]</td>
				<td>$r[MEREK]</td>
				<td>$r[NO_POLISI]</td>
				<td>$r[ST_ASAL]</td>					
				<td>$r[ST_KENDARAAN]</td>
				<td align=center>
				<a href=?module=rantorKjual&act=edit_rantorKjual&idt=$r[ID_PENGGUNAA_FAS]&idd=$idt&negara=$_GET[negara]>Jual / Batal</a> 	
				</td>
				</tr>";
	

      $no++;
    }
    echo "</table>";

				 
	break;
	

 case "edit_rantorKjual":
	$idt = $_GET[idt];
	$idd = $_GET[idd];

     $input = mysql_query("select ID_KNT_PERWAKILAN,NEGARA,NM_KNT_PERWAKILAN,ALAMAT,KOTA,TELP,BENDERA,NM_JNS_PERWAKILAN,FAX,KET FROM v_kantor_perwakilan  where ID_KNT_PERWAKILAN  = $idd  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Impor Rantor Kantor - Lihat</h2>";
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




	echo "<form method=POST enctype='multipart/form-data' action='./aksi_rantorKjual.php?module=rantorKjual&act=update&idt=$idt&negara=$_GET[negara]'>
          <input type=hidden name=ID_DIPLOMAT value='$r[ID_DIPLOMAT]'>
     	  <input type=hidden name=ID_KNT_PERWAKILAN value='$r[ID_KNT_PERWAKILAN]'>
		  <table width=100%>		  		 
		<th colspan=2 align = left>Jual Rantor</th>	  
		<tr><td  width=120>Tanggal Izin Jual</td>  <td > ";

          if (($r[TGL_IZIN_JUAL] == null) or ($r[TGL_IZIN_JUAL] == '') or ($r[TGL_IZIN_JUAL] == '0000-00-00')  ){
		  echo "<DIV id=\"tgl\"> <script>DateInput('TGL_IZIN_JUAL', true, 'YYYY-MM-DD')</script></div>"; 
		  
		  }else{
		  echo "<DIV id=\"tgl\"> <script>DateInput('TGL_IZIN_JUAL', true, 'YYYY-MM-DD','$r[TGL_IZIN_JUAL]')</script></div>"; 
		  }

		 echo "</td></tr>
		<tr><td>No Izin Jual</td>     <td> : <input type=text name='NO_IZIN_JUAL' size=50  value= '$r[NO_IZIN_JUAL]' ></td></tr>
		
        <tr><td>Alasan Penjualan</td>     <td> : <input type=text name='ALASAN_PENJUALAN' size=50   value= '$r[ALASAN_PENJUALAN]'  ></td></tr>
		<tr><td>Rekomendasi Bengkel</td>     <td> : <input type=text name='REKOMENDASI_BENGKEL' size=50   value= '$r[REKOMENDASI_BENGKEL]'  ></td></tr>
		<tr><td>Nama Pembeli</td>     <td> : <input type=text name='NAMA_PEMBELI' size=50   value= '$r[NAMA_PEMBELI]'  ></td></tr>
		<tr><td>Alamat Pembeli </td>     <td colspan=\"2\"> : <textarea name='ALAMAT_PEMBELI' rows=2 cols=55 >$r[ALAMAT_PEMBELI]</textarea></td></tr>
		<tr><td>No KTP Pembeli</td>     <td> : <input type=text name='NO_KTP_PEMBELI' size=50  value= '$r[NO_KTP_PEMBELI]'   ></td></tr>
		
			
		<tr><td colspan=2 align=right>
			<input type=submit value=Simpan>
        <input type=button value='Batal Jual' onclick=location.href='./aksi_rantorKjual.php?module=rantorKjual&act=batal_rantorKjual&idt=$r[ID_PENGGUNAA_FAS]&idd=$r[ID_KNT_PERWAKILAN]&negara=$_GET[negara]'>
			    
		<input type=button value=Kembali onclick=self.history.back()>
			
		</td></tr>
        </table>			
		</form>";


	
 break;
  case "cari":
    $alf = $_GET[huruf];
	  

	  echo "<br><br><a style=\"font-size: 22pt;\">$alf</a>";
	echo "<h2>Jual Rantor Individu - Pilih Negara</h2>
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
				&nbsp <a href=?module=rantorKjual&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";
		
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
