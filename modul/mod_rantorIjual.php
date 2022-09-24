<?php
	   echo "<br><b><a href=?module=rantorIjual&act=cari&huruf=A>A</A> |	<a href=?module=rantorIjual&act=cari&huruf=B>B</A> |	<a href=?module=rantorIjual&act=cari&huruf=C>C</A> |	<a href=?module=rantorIjual&act=cari&huruf=D>D</A> |	<a href=?module=rantorIjual&act=cari&huruf=E>E</A> |	<a href=?module=rantorIjual&act=cari&huruf=F>F</A> |	<a href=?module=rantorIjual&act=cari&huruf=G>G</A> |	<a href=?module=rantorIjual&act=cari&huruf=H>H</A> |	<a href=?module=rantorIjual&act=cari&huruf=I>I</A> |	<a href=?module=rantorIjual&act=cari&huruf=J>J</A> |	<a href=?module=rantorIjual&act=cari&huruf=K>K</A> |	<a href=?module=rantorIjual&act=cari&huruf=L>L</A> |	<a href=?module=rantorIjual&act=cari&huruf=M>M</A> |	<a href=?module=rantorIjual&act=cari&huruf=N>N</A> |	<a href=?module=rantorIjual&act=cari&huruf=O>O</A> |	<a href=?module=rantorIjual&act=cari&huruf=P>P</A> |	<a href=?module=rantorIjual&act=cari&huruf=Q>Q</A> |	<a href=?module=rantorIjual&act=cari&huruf=R>R</A> |	<a href=?module=rantorIjual&act=cari&huruf=S>S</A> |	<a href=?module=rantorIjual&act=cari&huruf=T>T</A> |	<a href=?module=rantorIjual&act=cari&huruf=U>U</A> |	<a href=?module=rantorIjual&act=cari&huruf=V>V</A> |	<a href=?module=rantorIjual&act=cari&huruf=W>W</A> |	<a href=?module=rantorIjual&act=cari&huruf=X>X</A> |	<a href=?module=rantorIjual&act=cari&huruf=Y>Y</A> |	<a href=?module=rantorIjual&act=cari&huruf=Z>Z</A> </b>";
		

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
		echo "<h2>Jual Rantor Individu<br>Pilih Diplomat - $negaranya</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='rantorIjual'>
				 <input type=hidden name=negara value='$_GET[negara]'>
			Nama Diplomat : <input type=text name=\"namadiplomat\"> <input type=submit value=Cari>
			</form> <br>

		  <table width=100%>
          <tr><th width=30>no</th><th width=130>NAMA LENGKAP</th><th width=160>KANTOR PERWAKILAN</th><th>JABATAN</th><th width=60>TGL TIBA</th><th width=85>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];

	if (isset($_GET[namadiplomat])){
	 $tampil=mysql_query("SELECT  ID_DIPLOMAT,NM_DIPLOMAT,NM_KNT_PERWAKILAN,PEKERJAAN,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_diplomat where negara like '".$neg."%' and (ID_DIPLOMAT > 1) and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' order by NM_KNT_PERWAKILAN, NM_DIPLOMAT limit $posisi,$batas");
	}
	else
    {$tampil=mysql_query("SELECT  ID_DIPLOMAT,NM_DIPLOMAT,NM_KNT_PERWAKILAN,PEKERJAAN,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_diplomat where negara like '".$neg."%' and (ID_DIPLOMAT > 1)  order by NM_KNT_PERWAKILAN, NM_DIPLOMAT limit $posisi,$batas");
	}
   
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

      echo "<tr><td>$no</td>
                <td>$r[NM_DIPLOMAT]</td>
                <td>$r[NM_KNT_PERWAKILAN]</td>
				<td>$r[PEKERJAAN]</td>		
				<td>$r[TGL_TIBA]</td>		
				<td><a href=?module=rantorIjual&act=lihat_rantorIjual&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>Jual Rantor</a></td>
		        </tr>";
      $no++;
    }
    echo "</table>";
	
	if (isset($_GET[namadiplomat]))
	{
		$jmldata =mysql_num_rows(mysql_query("SELECT ID_DIPLOMAT,NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN,PEKERJAAN FROM  v_diplomat where negara like '".$neg."%'  and (ID_DIPLOMAT > 1) and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' "));
	}else{
		$jmldata =mysql_num_rows(mysql_query("SELECT ID_DIPLOMAT,NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN,PEKERJAAN FROM  v_diplomat where negara like '".$neg."%'  and (ID_DIPLOMAT > 1)"));
	}
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   $ilink = "?module=rantorIjual&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;

  case "lihat_rantorIjual":
	$idt = $_GET[idt];
    $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Jual Rantor Individu - Lihat</h2>";
	 echo "	  <table width=100%>
          <tr><td  width=160>Asal Negara</td>  <td > : ";
            $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
            $w=mysql_fetch_array($tampil);
		
			
	$detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idt)");	
	$det    = mysql_fetch_array($detil);

    echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto/$r[FOTO]\" width=110 height=150 border=1> </div>
	<br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br><br>";

	$detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");	
	$det    = mysql_fetch_array($detil);

	echo "<b>Stay Permit </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No IzinPermit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";

	$detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");	
	$det    = mysql_fetch_array($detil);
	
	echo "<b>Sibling </b><br>";
	$nosib = 1;
	   $detil=mysql_query("select  NM_SIBLING,NM_JNS_RELASI from v_sibling where ID_DIPLOMAT = $idt order by ID_JNS_RELASI");
            while($det=mysql_fetch_array($detil)){
				echo "$nosib. $det[NM_SIBLING] - $det[NM_JNS_RELASI] <br>";
				$nosib=$nosib+1;
			}  
	
	echo "
	</td>
		<tr><td>Nama Diplomat</td>     <td> : $r[NM_DIPLOMAT]</td></tr> 
		<tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : ";
		if ($r[JK]=='l'){
		echo "Laki-laki";}else
		{echo "Perempuan";	}
		echo "</td> </tr>
		<tr><td>Pekerjaan</td >  <td > : $r[PEKERJAAN]</td></tr>
		<tr><td>Status Sipil</td>     <td  > : "; 
		
		if ($r[ST_SIPIL]=='s'){
		echo "Sudah Menikah";} else{
		echo "Belum Menikah";}
		echo "</td></tr>
		<tr><td>Alamat Indonesia </td>     <td > : <textarea name='ALAMATIN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATIN]</textarea></td></tr>
		
		<tr><td>Jenis / No. Paspor</td >     <td > :  ";
            $tampil=mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");
          
			$w=mysql_fetch_array($tampil);
    echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR]</td></tr>
		<tr><td>Diberikan oleh</td >     <td > : $r[PASPOR_OLEH]  -  $r[PASPOR_TGL] </td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[AKHIR_BERLAKU]</td></tr>
		
		<tr><td>Jenis / No. Visa</td >     <td > : ";
            $tampil=mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA = $r[ID_JNS_VISA]");
            $w=mysql_fetch_array($tampil);

    echo " $w[NM_JNS_VISA] / $r[NO_VISA] </td></tr>
		  </table> <br>";



	echo " <table width=100%>
          <tr><th  width=30>no</th><th>Tgl Izin Impor / Beli</th><th >No Izin Impor / Beli</th><th width=90>Merk</th><th width=90>No Polisi</th><th width=90>Status Asal</th> <th width=90>Status Kendaraan</th><th width=60>AKSI</th></tr>"; 

    $p      = new Paging;
    $batas  = 200;
    $posisi = $p->cariPosisi($batas);

    $tampil=mysql_query("select ID_PENGGUNAA_FAS,ID_JNS_FASILITAS,ID_DIPLOMAT,ID_KNT_PERWAKILAN, DATE_FORMAT(if(TGL_PERSETUJUAN is null,TGL_IZIN_IMPOR,TGL_PERSETUJUAN),'%d.%m.%Y') as TANGGAL_IZIN,  if(TGL_PERSETUJUAN is null,NO_IZIN_IMPOR,NO_IZIN_BELI) as NO_IZIN , if(TGL_PERSETUJUAN is null,'IMPOR','BELI') as ST_ASAL,if(TGL_IZIN_JUAL is null,'DIGUNAKAN','DIJUAL') as ST_KENDARAAN,DESKRIPSI,NO_POLISI,TAHUN,MEREK,NO_MESIN from penggunaan_fasilitas  where ID_DIPLOMAT = $idt and (ID_JNS_FASILITAS=2) AND (ST_PERSETUJUAN = 2) order by ID_PENGGUNAA_FAS ");

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
				<a href=?module=rantorIjual&act=edit_rantorIjual&idt=$r[ID_PENGGUNAA_FAS]&idd=$idt&negara=$_GET[negara]>Jual / Batal</a> 	
				</td>
				</tr>";
	

      $no++;
    }
    echo "</table>";

				 
	break;
	

 case "edit_rantorIjual":
	$idt = $_GET[idt];
	$idd = $_GET[idd];

   $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idd  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Jual Rantor Individu - Edit</h2>";
	echo "	  <table width=100%>
          <tr><td  width=160>Asal Negara</td>  <td > : ";
            $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
            $w=mysql_fetch_array($tampil);
		
			
	$detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idd and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idd)");	
	$det    = mysql_fetch_array($detil);

    echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto/$r[FOTO]\" width=110 height=150 border=1> </div>
	<br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br><br>";

	$detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idd and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idd) ");	
	$det    = mysql_fetch_array($detil);

	echo "<b>Stay Permit </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No IzinPermit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";

	$detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idd and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idd) ");	
	$det    = mysql_fetch_array($detil);
	
	echo "<b>Sibling </b><br>";
	$nosib = 1;
	   $detil=mysql_query("select  NM_SIBLING,NM_JNS_RELASI from v_sibling where ID_DIPLOMAT = $idd order by ID_JNS_RELASI");
            while($det=mysql_fetch_array($detil)){
				echo "$nosib. $det[NM_SIBLING] - $det[NM_JNS_RELASI] <br>";
				$nosib=$nosib+1;
			}  
	
	echo "
	</td>
		<tr><td>Nama Diplomat</td>     <td> : $r[NM_DIPLOMAT]</td></tr> 
		<tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : ";
		if ($r[JK]=='l'){
		echo "Laki-laki";}else
		{echo "Perempuan";	}
		echo "</td> </tr>
		<tr><td>Pekerjaan</td >  <td > : $r[PEKERJAAN]</td></tr>
		<tr><td>Status Sipil</td>     <td  > : "; 
		
		if ($r[ST_SIPIL]=='s'){
		echo "Sudah Menikah";} else{
		echo "Belum Menikah";}
		echo "</td></tr>
		<tr><td>Alamat Indonesia </td>     <td > : <textarea name='ALAMATIN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATIN]</textarea></td></tr>
		
		<tr><td>Jenis / No. Paspor</td >     <td > :  ";
            $tampil=mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");
          
			$w=mysql_fetch_array($tampil);
    echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR]</td></tr>
		<tr><td>Diberikan oleh</td >     <td > : $r[PASPOR_OLEH]  -  $r[PASPOR_TGL] </td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[AKHIR_BERLAKU]</td></tr>
		
		<tr><td>Jenis / No. Visa</td >     <td > : ";
            $tampil=mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA = $r[ID_JNS_VISA]");
            $w=mysql_fetch_array($tampil);

    echo " $w[NM_JNS_VISA] / $r[NO_VISA] </td></tr>
		  </table> <br>";



	$edit = mysql_query("select ID_PENGGUNAA_FAS,ID_JNS_FASILITAS,ID_DIPLOMAT,ID_KNT_PERWAKILAN,TGL_PERSETUJUAN,DESKRIPSI,NO_PERSETUJUAN,QTY,
ST_PERSETUJUAN,JNS_TRANS_FAS,NO_POLISI,TAHUN,MEREK,NO_MESIN,NO_IZIN_IMPOR,TGL_IZIN_IMPOR,NO_NOTE_IMPOR,PELABUHAN_IMPOR,KAPAL_IMPOR,TGL_TIBA_IMPOR,TGL_SURAT_IMPOR,PEMOHON_IMPOR,JABATAN_IMPOR,APPROVAL_IMPOR,NIP_APPROVAL_IMPOR,NO_IZIN_BELI,NO_IZIN_JUAL,TGL_IZIN_JUAL,ALASAN_PENJUALAN,REKOMENDASI_BENGKEL,NAMA_PEMBELI,ALAMAT_PEMBELI,NO_KTP_PEMBELI from penggunaan_fasilitas where ID_PENGGUNAA_FAS = $idt ");   
	
	$r    = mysql_fetch_array($edit);




	echo "<form method=POST enctype='multipart/form-data' action='./aksi_rantorIjual.php?module=rantorIjual&act=update&idt=$idt&negara=$_GET[negara]'>
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
        <input type=button value='Batal Jual' onclick=location.href='./aksi_rantorIjual.php?module=rantorIjual&act=batal_rantorIjual&idt=$r[ID_PENGGUNAA_FAS]&idd=$r[ID_DIPLOMAT]&negara=$_GET[negara]'>
			    
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
				&nbsp <a href=?module=rantorIjual&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";
		
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
