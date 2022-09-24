<?php
	   echo "<a href=?module=staypermitKasir&act=cari&huruf=A>A</A> |	<a href=?module=staypermitKasir&act=cari&huruf=B>B</A> |	<a href=?module=staypermitKasir&act=cari&huruf=C>C</A> |	<a href=?module=staypermitKasir&act=cari&huruf=D>D</A> |	<a href=?module=staypermitKasir&act=cari&huruf=E>E</A> |	<a href=?module=staypermitKasir&act=cari&huruf=F>F</A> |	<a href=?module=staypermitKasir&act=cari&huruf=G>G</A> |	<a href=?module=staypermitKasir&act=cari&huruf=H>H</A> |	<a href=?module=staypermitKasir&act=cari&huruf=I>I</A> |	<a href=?module=staypermitKasir&act=cari&huruf=J>J</A> |	<a href=?module=staypermitKasir&act=cari&huruf=K>K</A> |	<a href=?module=staypermitKasir&act=cari&huruf=L>L</A> |	<a href=?module=staypermitKasir&act=cari&huruf=M>M</A> |	<a href=?module=staypermitKasir&act=cari&huruf=N>N</A> |	<a href=?module=staypermitKasir&act=cari&huruf=O>O</A> |	<a href=?module=staypermitKasir&act=cari&huruf=P>P</A> |	<a href=?module=staypermitKasir&act=cari&huruf=Q>Q</A> |	<a href=?module=staypermitKasir&act=cari&huruf=R>R</A> |	<a href=?module=staypermitKasir&act=cari&huruf=S>S</A> |	<a href=?module=staypermitKasir&act=cari&huruf=T>T</A> |	<a href=?module=staypermitKasir&act=cari&huruf=U>U</A> |	<a href=?module=staypermitKasir&act=cari&huruf=V>V</A> |	<a href=?module=staypermitKasir&act=cari&huruf=W>W</A> |	<a href=?module=staypermitKasir&act=cari&huruf=X>X</A> |	<a href=?module=staypermitKasir&act=cari&huruf=Y>Y</A> |	<a href=?module=staypermitKasir&act=cari&huruf=Z>Z</A>";
		

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
		//echo "<h2>Stay Permit - Kasir</h2>";		
		echo "<h2>Stay Permit <br>Pilih Diplomat - $negaranya</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='staypermitKasir'>
				 <input type=hidden name=negara value='$_GET[negara]'>
			Nama Diplomat : <input type=text name=\"namadiplomat\"> <input type=submit value=Cari>
			</form> <br>

			<a href=?module=staypermitKasir>ALL</a> | <a href=?module=staypermitKasir&status=1 style=\"color : #B1BF19\">WAITING</a> | <a href=?module=staypermitKasir&status=2 style=\"color : green\">APPROVED</a> | 
	<a href=?module=staypermitKasir&status=0 style=\"color : #800000\">REJECTED</a> <BR>

		<table width=100%>
          <tr><th width=30>no</th><th>NAMA LENGKAP</th><th colspan=2 >KANTOR PERWAKILAN</th><th width=100>JABATAN</th><th width=80>TGL BERLAKU</th><th width=40>JNS PERMIT</th><th width=80>TGL AGENDA</th><th width=45>D</th><th width=45>K</th><th width=45>KSIE</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];

	if (isset($_GET[status])){
	
	 if (isset($_GET[namadiplomat])){
	$tampil=mysql_query("select a.id_permit,b.ID_DIPLOMAT,b.NM_DIPLOMAT,b.NM_KNT_PERWAKILAN,b.PEKERJAAN, a.NO_IZIN_PERMIT, date_format(a.TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT ,date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT,a.NM_JNS_PERMIT,a.ST_PERMIT,a.ST_PERMIT_K,a.ST_PERMIT_KAS,a.BENDERA,a.NEGARA,a.TGL_AGENDA  from v_approval_permit a right join v_diplomat b on a.id_diplomat=b.id_diplomat where  b.negara like '".$neg."%' and b.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' and  (a.ST_PERMIT_K = ".$_GET[status]."  or a.ST_PERMIT = ".$_GET[status]." or a.ST_PERMIT_KAS = ".$_GET[status].") order by id_permit desc limit $posisi,$batas ");	

	}
	else
    {	
		$tampil=mysql_query("select a.id_permit,b.ID_DIPLOMAT,b.NM_DIPLOMAT,b.NM_KNT_PERWAKILAN,b.PEKERJAAN, a.NO_IZIN_PERMIT, date_format(a.TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT ,date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT,a.NM_JNS_PERMIT,a.ST_PERMIT,a.ST_PERMIT_K,a.ST_PERMIT_KAS,a.BENDERA,a.NEGARA,a.TGL_AGENDA from v_approval_permit a right join v_diplomat b on a.id_diplomat=b.id_diplomat  where  b.negara like '".$neg."%'  and  (a.ST_PERMIT_K = ".$_GET[status]."  or a.ST_PERMIT = ".$_GET[status]." or a.ST_PERMIT_KAS = ".$_GET[status].")  order by id_permit desc limit $posisi,$batas ");
	
	}//if (isset($_GET[namadiplomat]))

	}else{
	if (isset($_GET[namadiplomat])){
	$tampil=mysql_query("select a.id_permit,b.ID_DIPLOMAT,b.NM_DIPLOMAT,b.NM_KNT_PERWAKILAN,b.PEKERJAAN, a.NO_IZIN_PERMIT, date_format(a.TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT ,date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT,a.NM_JNS_PERMIT,a.ST_PERMIT,a.ST_PERMIT_K,a.ST_PERMIT_KAS,,a.BENDERA,a.NEGARA,a.TGL_AGENDA  from v_approval_permit a right join v_diplomat b on a.id_diplomat=b.id_diplomat where  b.negara like '".$neg."%' and b.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%'  order by id_permit desc limit $posisi,$batas ");	 	
	
	}
	else
    {	
		$tampil=mysql_query("select a.id_permit,b.ID_DIPLOMAT,b.NM_DIPLOMAT,b.NM_KNT_PERWAKILAN,b.PEKERJAAN, a.NO_IZIN_PERMIT, date_format(a.TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT ,date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT,a.NM_JNS_PERMIT,a.ST_PERMIT,a.ST_PERMIT_K,a.ST_PERMIT_KAS,a.BENDERA,a.NEGARA,a.TGL_AGENDA from v_approval_permit a right join v_diplomat b on a.id_diplomat=b.id_diplomat  where  b.negara like '".$neg."%'  order by id_permit desc limit $posisi,$batas ");
	
	}//if (isset($_GET[namadiplomat]))
	}//if (isset($_GET[status]))

    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      echo "<tr><td>$no</td>
                <td><a href=?module=staypermitKasir&act=lihat_stay_permit&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NM_DIPLOMAT]</a></td>
				<td width=20><img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" /></td>  
				<td width=120>$r[NM_KNT_PERWAKILAN]</td>
                <td>$r[PEKERJAAN]</td>
                <td>$r[TGL_AWAL_PERMIT] - $r[TGL_AKHIR_PERMIT]</td>
				<td>$r[KD_JNS_PERMIT]</td>
				<td>$r[TGL_AGENDA]</td>
				<td align=center>";
				if (is_null($r[ST_PERMIT])){
				echo "-";
				}else{
					if ($r[ST_PERMIT]== 0){ echo "<b style=\"color : #800000\">R</b>";}
					if ($r[ST_PERMIT]== 1){ echo "<b style=\"color : #B1BF19\">W</b>";}
					if ($r[ST_PERMIT]== 2){ echo "<b style=\"color : green\">A</b>";}
	}
			echo "</td><td align=center>";
				if (is_null($r[ST_PERMIT_K])){
				echo "-";
				}else{
					if ($r[ST_PERMIT_K]== 0){ echo "<b style=\"color : #800000\">R</b>";}
					if ($r[ST_PERMIT_K]== 1){ echo "<b style=\"color : #B1BF19\">W</b>";}
					if ($r[ST_PERMIT_K]== 2){ echo "<b style=\"color : green\">A</b>";}
				}
			echo "</td><td align=center>";
				if (is_null($r[ST_PERMIT_KAS])){
				echo "-";
				}else{
					if ($r[ST_PERMIT_KAS]== 0){ echo "<b style=\"color : #800000\">R</b>";}
					if ($r[ST_PERMIT_KAS]== 1){ echo "<b style=\"color : #B1BF19\">W</b>";}
					if ($r[ST_PERMIT_KAS]== 2){ echo "<b style=\"color : green\">A</b>";}
				}
			echo "				
				</td>
				<input type=hidden name='ID_PERMIT$noP' value='$r[ID_PERMIT]'>     	  
		        </tr>";
      $no++;
    }
      echo "</table>";
/* ST_PEMIT_KAS?? */
	if (isset($_GET[status])){
	if (isset($_GET[namadiplomat]))
	{
		$jmldata =mysql_num_rows(mysql_query("select a.id_permit from v_approval_permit a right join v_diplomat b on a.id_diplomat=b.id_diplomat where  b.negara like '".$neg."%' and b.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' and  a.ST_PERMIT_K = ".$_GET[status]));
	}else{
		$jmldata =mysql_num_rows(mysql_query("select a.id_permit from v_approval_permit a right join v_diplomat b on a.id_diplomat=b.id_diplomat  where  b.negara like '".$neg."%' and  a.ST_PERMIT_K = ".$_GET[status]));
	}
	}else{
	if (isset($_GET[namadiplomat]))
	{
		$jmldata =mysql_num_rows(mysql_query("select a.id_permit from v_approval_permit a right join v_diplomat b on a.id_diplomat=b.id_diplomat where  b.negara like '".$neg."%' and b.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%'"));
	}else{
		$jmldata =mysql_num_rows(mysql_query("select a.id_permit from v_approval_permit a right join v_diplomat b on a.id_diplomat=b.id_diplomat  where  b.negara like '".$neg."%'"));
	}
	}//if (isset($_GET[status]))
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

	if (isset($_GET[status])){
	$ilink = "?module=staypermitKasir&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]&status=$_GET[status]"; }
	else
	{$ilink = "?module=staypermitKasir&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]"; }

    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;

  case "lihat_stay_permit":
	$idt = $_GET[idt];
    $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Stay Permit - Lihat</h2>";
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

	echo "<b>Stay Permit </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No Izin Permit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";

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


	echo " <input type=button value='Tambah' onclick=location.href='?module=staypermitKasir&act=tambah_stay_permit&idt=$idt&negara=$_GET[negara]'>
			<table width=100%>
          <tr><th  width=30>no</th><th width=50>Jenis Permit</th><th  width=70>No Agenda</th><th width=85>Tanggal Agenda</th><th width=70>No Izin Permit</th><th width=85>Tanggal Awal Permit</th><th width=85>Tanggal Akhir</th><th>D</th><th>K</th><th>KSIE</th></tr>"; 

    $p      = new Paging;
    $batas  = 200;
    $posisi = $p->cariPosisi($batas);

    $tampil=mysql_query("select ID_PERMIT,ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,date_format(TGL_AGENDA,'%d.%m.%Y') as  TGL_AGENDA,NO_IZIN_PERMIT,date_format(TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT,date_format(TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,KET ,NM_JNS_PERMIT,KD_JNS_PERMIT,NM_DIPLOMAT,ST_PERMIT,ST_PERMIT_K,ST_PERMIT_KAS from v_stay_permit where ID_DIPLOMAT = $idt order by  ID_PERMIT");

	$no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      echo "<tr><td>$no</td>
                <td><a href=?module=staypermitKasir&act=edit_stay_permit&idt=$r[ID_PERMIT]&idd=$idt&negara=$_GET[negara]> $r[KD_JNS_PERMIT]</a></td>
				<td>$r[NO_AGENDA]</td>
				<td>$r[TGL_AGENDA]</td>
				<td>$r[NO_IZIN_PERMIT]</td>
				<td>$r[TGL_AWAL_PERMIT]</td>
				<td>$r[TGL_AKHIR_PERMIT]</td>
				<td align =center>";
		if ($r[ST_PERMIT] == 2){
			echo "<div style=\"color : green\"> <b>approved</b> </div>";
		}elseif ($r[ST_PERMIT] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>waiting</b> </div>";
		}elseif ($r[ST_PERMIT] == 0){		
			echo "<div style=\"color : #800000\"> <b>rejected</b> </div>";
		}
					
				echo "</td>
				<td align =center>";
		if ($r[ST_PERMIT_K] == 2){
			echo "<div style=\"color : green\"> <b>approved</b> </div>";
		}elseif ($r[ST_PERMIT_K] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>waiting</b> </div>";
		}elseif ($r[ST_PERMIT_K] == 0){		
			echo "<div style=\"color : #800000\"> <b>rejected</b> </div>";
		}
			
				echo "</td>
				<td align =center>";
		if ($r[ST_PERMIT_KAS] == 2){
			echo "<div style=\"color : green\"> <b>approved</b> </div>";
		}elseif ($r[ST_PERMIT_KAS] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>waiting</b> </div>";
		}elseif ($r[ST_PERMIT_KAS] == 0){		
			echo "<div style=\"color : #800000\"> <b>rejected</b> </div>";
		}
						
				echo "</td>	</tr>";

      $no++;
    }
    echo "</table>";

				 
	break;
	
 case "tambah_stay_permit":
	$idt = $_GET[idt];
  $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Stay Permit - Tambah</h2>";
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
		<tr><td>Alamat di Luar Negeri </td>     <td > : <textarea name='ALAMATIN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATIN]</textarea></td></tr>
		
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


	echo "<form method=POST enctype='multipart/form-data' action='./aksi_stay_permit_kasir.php?module=staypermitKasir&act=input&negara=$_GET[negara]'>
          <input type=hidden name=ID_DIPLOMAT value='$r[ID_DIPLOMAT]'>

		  <table width=100%>
		  		 
		  <tr><td  width=120>Jenis Permit</td>  <td > : 
          <select name='ID_JNS_PERMIT'>
			<option value=0 selected>- Not Defined -</option>";
             $tampil=mysql_query("SELECT ID_JNS_PERMIT,KD_JNS_PERMIT FROM m_jns_permit ORDER BY ID_JNS_PERMIT");
            while($w=mysql_fetch_array($tampil)){
				echo "<option value=$w[ID_JNS_PERMIT]>$w[KD_JNS_PERMIT]</option>";
			
			}  

    echo "</select></td>
        <tr><td>No Agenda</td>     <td> : <input type=text name='NO_AGENDA' size=50  ></td></tr>
		<tr><td>Tanggal Agenda</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AGENDA', true, 'YYYY-MM-DD')</script></div></td></tr>
		
        <tr><td>No Nota</td>     <td> : <input type=text name='NO_NOTA' size=50  ></td></tr>
		<tr><td>Tanggal Nota</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_NOTA', true, 'YYYY-MM-DD')</script></div></td></tr>

		<tr><td>No Izin Permit</td>     <td> : <input type=text name='NO_IZIN_PERMIT' size=50   readonly=\"readonly\"> * di generate otomatis oleh sistem</td></tr>
		<tr><td>Tanggal Awal Permit</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AWAL_PERMIT', true, 'YYYY-MM-DD')</script></div></td></tr>
		<tr><td>Tanggal Akhir Permit</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR_PERMIT', true, 'YYYY-MM-DD')</script></div></td></tr>
		<tr><td>Keterangan</td>     <td> : <input type=text name='KET' size=100  ></td></tr>
		<tr><td colspan=2 align=right><input type=submit value=Simpan>
              <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table></form>";
 break;
 case "edit_stay_permit":
	$idt = $_GET[idt];
	$idd = $_GET[idd];
  $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idd  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Stay Permit - Edit</h2>";
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



	$edit = mysql_query("select ID_PERMIT,ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,TGL_AGENDA,NO_IZIN_PERMIT,TGL_AWAL_PERMIT,TGL_AKHIR_PERMIT,KET,NO_NOTA,TGL_NOTA from  v_stay_permit where ID_PERMIT = $idt ");   
	
	$r    = mysql_fetch_array($edit);

	echo "<form method=POST enctype='multipart/form-data' action='./aksi_stay_permit_kasir.php?module=staypermitKasir&act=update&idt=$idt&negara=$_GET[negara]'>
          <input type=hidden name=ID_DIPLOMAT value='$r[ID_DIPLOMAT]'>
			<input type=hidden name=ID_PERMIT value='$r[ID_PERMIT]'>

		  <table width=100%>
		  		 
		  <tr><td  width=120>Jenis Permit</td>  <td > : 
          <select name='ID_JNS_PERMIT'>
			<option value=0 selected>- Not Defined -</option>";
             $tampil=mysql_query("SELECT ID_JNS_PERMIT,KD_JNS_PERMIT FROM m_jns_permit ORDER BY ID_JNS_PERMIT");
          
			 while($w=mysql_fetch_array($tampil)){
			if ($r[ID_JNS_PERMIT]==$w[ID_JNS_PERMIT]){
				echo "<option value=$w[ID_JNS_PERMIT] selected>$w[KD_JNS_PERMIT]</option>";
			}
			else{
				echo "<option value=$w[ID_JNS_PERMIT]>$w[KD_JNS_PERMIT]</option>";
			}
			}  

    echo "</select></td>
<tr><td>No Agenda</td>     <td> : <input type=text name='NO_AGENDA' size=50 value='$r[NO_AGENDA]' ></td></tr>
<tr><td>Tanggal Agenda</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AGENDA', true, 'YYYY-MM-DD','$r[TGL_AGENDA]')</script></div></td></tr>
<tr><td>No Nota</td>     <td> : <input type=text name='NO_NOTA' size=50 value='$r[NO_NOTA]' ></td></tr>
<tr><td>Tanggal Nota</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_NOTA', true, 'YYYY-MM-DD','$r[TGL_NOTA]')</script></div></td></tr>

<tr><td>No Izin Permit</td>     <td> : <input type=text name='NO_IZIN_PERMIT' size=50  value='$r[NO_IZIN_PERMIT]'  readonly=\"readonly\"></td></tr>
<tr><td>Tanggal Awal Permit</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AWAL_PERMIT', true, 'YYYY-MM-DD','$r[TGL_AWAL_PERMIT]')</script></div></td></tr>
<tr><td>Tanggal Akhir Permit</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR_PERMIT', true, 'YYYY-MM-DD','$r[TGL_AKHIR_PERMIT]')</script></div></td></tr>
<tr><td>Keterangan</td>     <td> : <input type=text name='KET' size=100   value='$r[KET]' ></td></tr>
<tr><td colspan=2 align=right><input type=submit value=Simpan>
	  <input type=button value=Batal onclick=self.history.back()></td></tr>
</table></form>";


 break;
  case "cari":
    $alf = $_GET[huruf];
	  
    echo "<br><br><a style=\"font-size: 22pt;\">$alf</a>";
	echo "<h2>Stay Permit - Pilih Negara</h2> 
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
				&nbsp <a href=?module=staypermitKasir&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";
		
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
