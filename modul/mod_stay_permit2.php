<?php
	   echo "<a href=?module=staypermit&act=cari&huruf=A>A</A> |	<a href=?module=staypermit&act=cari&huruf=B>B</A> |	<a href=?module=staypermit&act=cari&huruf=C>C</A> |	<a href=?module=staypermit&act=cari&huruf=D>D</A> |	<a href=?module=staypermit&act=cari&huruf=E>E</A> |	<a href=?module=staypermit&act=cari&huruf=F>F</A> |	<a href=?module=staypermit&act=cari&huruf=G>G</A> |	<a href=?module=staypermit&act=cari&huruf=H>H</A> |	<a href=?module=staypermit&act=cari&huruf=I>I</A> |	<a href=?module=staypermit&act=cari&huruf=J>J</A> |	<a href=?module=staypermit&act=cari&huruf=K>K</A> |	<a href=?module=staypermit&act=cari&huruf=L>L</A> |	<a href=?module=staypermit&act=cari&huruf=M>M</A> |	<a href=?module=staypermit&act=cari&huruf=N>N</A> |	<a href=?module=staypermit&act=cari&huruf=O>O</A> |	<a href=?module=staypermit&act=cari&huruf=P>P</A> |	<a href=?module=staypermit&act=cari&huruf=Q>Q</A> |	<a href=?module=staypermit&act=cari&huruf=R>R</A> |	<a href=?module=staypermit&act=cari&huruf=S>S</A> |	<a href=?module=staypermit&act=cari&huruf=T>T</A> |	<a href=?module=staypermit&act=cari&huruf=U>U</A> |	<a href=?module=staypermit&act=cari&huruf=V>V</A> |	<a href=?module=staypermit&act=cari&huruf=W>W</A> |	<a href=?module=staypermit&act=cari&huruf=X>X</A> |	<a href=?module=staypermit&act=cari&huruf=Y>Y</A> |	<a href=?module=staypermit&act=cari&huruf=Z>Z</A>";


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
		//echo "<h2>Stay Permit</h2>";
		echo "<h2>Stay Permit <br>Pilih Diplomat - $negaranya</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='staypermit'>
				 <input type=hidden name=negara value='$_GET[negara]'>
			Nama Diplomat : <input type=text name=\"namadiplomat\"> <input type=submit value=Cari>
			</form> <br>

		  <table width=100%>
          <tr><th width=30>no</th><th>NO PERMIT</th><th>JNS PERMIT</th><th width=130>NAMA LENGKAP</th><th width=160>KANTOR PERWAKILAN</th><th>JABATAN</th><th width=60>TGL BERLAKU</th><th width=85>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];

	if (isset($_GET[namadiplomat])){
	 $tampil=mysql_query("select a.id_permit,a.ID_DIPLOMAT,b.NM_DIPLOMAT,b.NM_KNT_PERWAKILAN,PEKERJAAN, a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a join v_diplomat b on a.id_diplomat=b.id_diplomat where b.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%'  order by id_permit limit $posisi,$batas ");
	}
	else
    {$tampil=mysql_query("select a.id_permit,a.ID_DIPLOMAT,b.NM_DIPLOMAT,b.NM_KNT_PERWAKILAN,PEKERJAAN, a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a join v_diplomat b on a.id_diplomat=b.id_diplomat   order by id_permit limit $posisi,$batas ");
	}

    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

      echo "<tr><td>$no</td>
	            <td><a href=?module=staypermit&act=lihat_stay_permit&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NO_IZIN_PERMIT]</a></td>
				<td>$r[KD_JNS_PERMIT]</td>
                <td><a href=?module=diplomat&act=viewdiplomat&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NM_DIPLOMAT]</a></td>
                <td>$r[NM_KNT_PERWAKILAN]</td>
				<td>$r[PEKERJAAN]</td>
				<td>$r[TGL_AKHIR_PERMIT]</td>
				<td><a href=?module=staypermit&act=edit_stay_permit&idt=$r[ID_PERMIT]&idd=$idt&negara=$_GET[negara]>Edit</a> |
		            <a href=./aksi_stay_permit.php?module=staypermit&act=hapus&idt=$r[ID_PERMIT]&idd=$idt&negara=$_GET[negara] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus permit $r[NO_IZIN_PERMIT]?')\">Hapus</a></td>		        </tr>";
      $no++;
    }
    echo "</table>";

	if (isset($_GET[namadiplomat]))
	{
		$jmldata =mysql_num_rows(mysql_query("SELECT ID_DIPLOMAT,NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN,PEKERJAAN FROM  v_diplomat where negara like '".$neg."%' and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' "));
	}else{
		$jmldata =mysql_num_rows(mysql_query("SELECT ID_DIPLOMAT,NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN,PEKERJAAN FROM  v_diplomat where negara like '".$neg."%'"));
	}
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   $ilink = "?module=staypermit&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]";
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;


 case "viewdiplomat":
	$idt = $_GET[idt];
    $edit = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt ");
    $r    = mysql_fetch_array($edit);

	     echo "<h2>View Diplomat</h2>
		  <table width=100%>
          <tr><td  width=160>Asal Negara</td>  <td > : ";
            $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
            $w=mysql_fetch_array($tampil);


	$detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idt)");
	$det    = mysql_fetch_array($detil);

    echo "$w[NEGARA] </td><td rowspan=\"19\"  width=200 ><div align=center><img src=\"../foto/$r[FOTO]\" width=110 height=150 border=1> </div>
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

	echo "<br>
	<b>Rantor </b><br><br>
	<b>Fasilitas Lainnya </b><br><br>
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
		<tr><td>Alamat di Luar Negeri </td>     <td > : <textarea name='ALAMATLN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATLN]</textarea></td></tr>

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
		<tr><td>Diberikan oleh</td >     <td > : $r[VISA_OLEH]</td></tr>
		<tr><td>Lama berdiam di Indonesia</td >     <td > : $r[LAMA_BERDIAM] hari</td></tr>
		<tr><td>Tanggal tiba</td >     <td > : $r[TGL_TIBA]</td></tr>

		<tr><td>Alamat di Indonesia</td >     <td > : <textarea name='ALAMATIN' rows=2 cols=48 readonly=\"readonly\">$r[ALAMATIN]</textarea></td></tr>
		<tr><td>Dipekerjakan pada</td >     <td >  : ";
            $tampil=mysql_query("SELECT ID_KNT_PERWAKILAN,NM_KNT_PERWAKILAN  FROM m_kantor_perwakilan where ID_KNT_PERWAKILAN = $r[ID_KNT_PERWAKILAN]");
            $w=mysql_fetch_array($tampil);

    echo "$w[NM_KNT_PERWAKILAN] </td></tr>
		<tr><td>No SETKAB</td >     <td > : $r[NO_SETKAB]</td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[BERLAKUSD]</td></tr>
		<tr><td>No. Surat Sponsor</td >     <td > : $r[NO_SPONSOR]</tr>
		<tr><td colspan=3 align=right>
        <input type=button value=Kembali onclick=self.history.back()></td></tr>
        </table></form>";



  case "lihat_stay_permit":
	$idt = $_GET[idt];
    $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt  ");
	$r    = mysql_fetch_array($input);

	 echo "<h2 >Stay Permit - Lihat </h2>";
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
		<tr><td>Alamat di Luar Negeri </td>     <td > : <textarea name='ALAMATLN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATLN]</textarea></td></tr>

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


	echo " <input type=button value='Tambah' onclick=location.href='?module=staypermit&act=tambah_stay_permit&idt=$idt&negara=$_GET[negara]'>
			<table width=100%>
          <tr><th  width=30>no</th><th>Jenis Permit</th><th  width=100>No Agenda</th><th width=90>Tanggal Agenda</th><th width=100>No Izin Permit</th><th width=90>Tanggal Awal Permit</th><th width=90>Tanggal Akhir</th><th width=60>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 200;
    $posisi = $p->cariPosisi($batas);

    $tampil=mysql_query("select ID_PERMIT,ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,date_format(TGL_AGENDA,'%d.%m.%Y') as  TGL_AGENDA,NO_IZIN_PERMIT,date_format(TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT,date_format(TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,KET ,NM_JNS_PERMIT,KD_JNS_PERMIT,NM_DIPLOMAT from v_stay_permit where ID_DIPLOMAT = $idt order by  ID_PERMIT");

	$no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      echo "<tr><td>$no</td>
                <td>$r[NM_JNS_PERMIT]</td>
				<td>$r[NO_AGENDA]</td>
				<td>$r[TGL_AGENDA]</td>
				<td>$r[NO_IZIN_PERMIT]</td>
				<td>$r[TGL_AWAL_PERMIT]</td>
				<td>$r[TGL_AKHIR_PERMIT]</td>
				<td><a href=?module=staypermit&act=edit_stay_permit&idt=$r[ID_PERMIT]&idd=$idt&negara=$_GET[negara]>Edit</a> |
		            <a href=./aksi_stay_permit.php?module=staypermit&act=hapus&idt=$r[ID_PERMIT]&idd=$idt&negara=$_GET[negara] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus permit $r[NO_IZIN_PERMIT]?')\">Hapus</a></td>
				</tr>";

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
		<tr><td>Alamat di Luar Negeri </td>     <td > : <textarea name='ALAMATLN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATLN]</textarea></td></tr>

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


	echo "<form method=POST enctype='multipart/form-data' action='./aksi_stay_permit.php?module=staypermit&act=input&negara=$_GET[negara]'>
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
		<tr><td>No Izin Permit</td>     <td> : <input type=text name='NO_IZIN_PERMIT' size=50  ></td></tr>
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

	 echo "<h2 >Stay Permit - Edita</h2>";
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
		<tr><td>Alamat di Luar Negeri </td>     <td > : <textarea name='ALAMATLN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATLN]</textarea></td></tr>

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



	$edit = mysql_query("select ID_PERMIT,ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,TGL_AGENDA,NO_IZIN_PERMIT,TGL_AWAL_PERMIT,TGL_AKHIR_PERMIT,KET from  v_stay_permit where ID_PERMIT = $idt ");

	$r    = mysql_fetch_array($edit);

	echo "<form method=POST enctype='multipart/form-data' action='./aksi_stay_permit.php?module=staypermit&act=update&idt=$idt&negara=$_GET[negara]'>
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
<tr><td>No Izin Permit</td>     <td> : <input type=text name='NO_IZIN_PERMIT' size=50  value='$r[NO_IZIN_PERMIT]' ></td></tr>
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
	<table width=90%>
          <tr><th  width=30>no</th><th>NAMA NEGARA</th></tr>";

    $p      = new Paging;
    $batas  = 200;
    $posisi = $p->cariPosisi($batas);

    $tampil=mysql_query("SELECT * FROM  m_negara where negara like '".$alf."%' and id_negara > 1 order by negara");
	$no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      echo "<tr><td>$no</td>
                <td><img src=\"../images/bendera/".$r[BENDERA].".gif\" class=\"thumbborder\" width=\"22\" height=\"15\" />  &nbsp <a href=?module=staypermit&negara=$r[NEGARA]>$r[NEGARA]</a></td>
				</tr>";
      $no++;
    }
    echo "</table>";
    break;
}
?>
