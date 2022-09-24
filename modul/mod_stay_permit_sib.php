<?php
	   //echo "<br><a href=?module=staypermitSib&act=cari&huruf=A>A</A> |	<a href=?module=staypermitSib&act=cari&huruf=B>B</A> |	<a href=?module=staypermitSib&act=cari&huruf=C>C</A> |	<a href=?module=staypermitSib&act=cari&huruf=D>D</A> |	<a href=?module=staypermitSib&act=cari&huruf=E>E</A> |	<a href=?module=staypermitSib&act=cari&huruf=F>F</A> |	<a href=?module=staypermitSib&act=cari&huruf=G>G</A> |	<a href=?module=staypermitSib&act=cari&huruf=H>H</A> |	<a href=?module=staypermitSib&act=cari&huruf=I>I</A> |	<a href=?module=staypermitSib&act=cari&huruf=J>J</A> |	<a href=?module=staypermitSib&act=cari&huruf=K>K</A> |	<a href=?module=staypermitSib&act=cari&huruf=L>L</A> |	<a href=?module=staypermitSib&act=cari&huruf=M>M</A> |	<a href=?module=staypermitSib&act=cari&huruf=N>N</A> |	<a href=?module=staypermitSib&act=cari&huruf=O>O</A> |	<a href=?module=staypermitSib&act=cari&huruf=P>P</A> |	<a href=?module=staypermitSib&act=cari&huruf=Q>Q</A> |	<a href=?module=staypermitSib&act=cari&huruf=R>R</A> |	<a href=?module=staypermitSib&act=cari&huruf=S>S</A> |	<a href=?module=staypermitSib&act=cari&huruf=T>T</A> |	<a href=?module=staypermitSib&act=cari&huruf=U>U</A> |	<a href=?module=staypermitSib&act=cari&huruf=V>V</A> |	<a href=?module=staypermitSib&act=cari&huruf=W>W</A> |	<a href=?module=staypermitSib&act=cari&huruf=X>X</A> |	<a href=?module=staypermitSib&act=cari&huruf=Y>Y</A> |	<a href=?module=staypermitSib&act=cari&huruf=Z>Z</A>";


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
 		echo "<h2>Stay Permit  Sibling<br>Pilih Sibling - $negaranya</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='staypermitSib'>
				 <input type=hidden name=negara value='$_GET[negara]'>

			Nama Sibling / No Pendaftaran : <input type=text name=\"namasibling\"> <input type=submit value=Cari>";
		if (!empty($_GET[namasibling]) || !empty($_GET[nopendaftaran])) { echo " &nbsp; &nbsp; &nbsp;<a href='?module=staypermitSib'>Hapus Pencarian</a>"; }
		echo "</form> <br>";

		  echo"<table width=100%>
          <tr><th width=30>no</th><th width=80>NO PENDAFTARAN</th><th width=80>STATUS</th><th width=80>NO PERMIT</th><th width=40>JNS PERMIT</th><th>NAMA LENGKAP FAMILY</th><th>NAMA DIPLOMAT</th><th width=120>KANTOR PERWAKILAN</th><th width=100>PEKERJAAN</th><th width=80>TGL BERLAKU</th><th width=70>AKSI</th></tr>";

		$p      = new Paging;
		$batas  = 10;
		$posisi = $p->cariPosisi($batas);

		$neg = $_GET[negara];

	if (isset($_GET[namasibling])){
		$sql="select distinct a.STATUS,a.NO_DAFTAR,a.id_permit_s,b.ID_SIBLING,b.NM_SIBLING,b.ID_DIPLOMAT,b.NM_DIPLOMAT,b.NM_KNT_PERWAKILAN,PEKERJAAN, a.NO_IZIN_PERMIT, date_format(a.TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT ,date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit_sib a right join v_sibling b on  a.id_sibling=b.id_sibling  where  b.negara like '".$neg."%' and (b.NM_SIBLING like '%".$_GET[namasibling]."%' or a.NO_DAFTAR like '%".$_GET[namasibling]."%') AND a.KD_WORKFLOW > '0' order by tgl_kirim desc,  id_permit_s desc limit $posisi,$batas";
		$tampil=mysql_query($sql);

	}
	else
		$sql="select distinct a.STATUS,a.NO_DAFTAR,a.id_permit_s,b.ID_SIBLING,b.NM_SIBLING,b.ID_DIPLOMAT,b.NM_DIPLOMAT,b.NM_KNT_PERWAKILAN,PEKERJAAN, a.NO_IZIN_PERMIT, date_format(a.TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT ,date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit_sib a right join v_sibling b on  a.id_sibling=b.id_sibling  where  b.negara like '".$neg."%'  AND a.KD_WORKFLOW > '0'  order by  tgl_kirim desc, id_permit_s desc limit $posisi,$batas";
   {
 	}
 		  $tampil=mysql_query($sql);
		//print_r($sql);
		$no = $posisi+1;
		while($r=mysql_fetch_array($tampil)){

		  echo "<tr><td>$no</td>
					<td>$r[NO_DAFTAR]</td>
					<td>$r[STATUS]</td>
					<td><a href=?module=staypermitSib&act=lihat_stay_permit&idt=$r[ID_SIBLING]&negara=$_GET[negara]>$r[NO_IZIN_PERMIT]</a></td>
					<td>$r[KD_JNS_PERMIT]</td>
					<td><a href=?module=sibling&act=viewsibling&idt=$r[ID_SIBLING]&negara=$_GET[negara]>$r[NM_SIBLING]</a></td>
					<td><a href=?module=diplomat&act=viewdiplomat&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NM_DIPLOMAT]</a></td>
					<td>$r[NM_KNT_PERWAKILAN]</td>
					<td>$r[PEKERJAAN]</td>
					<td>$r[TGL_AWAL_PERMIT] - $r[TGL_AKHIR_PERMIT]</td>
					<td><a href=?module=staypermitSib&act=lihat_stay_permit&idt=$r[ID_SIBLING]&negara=$_GET[negara]>Lihat Permit</a></td>
					</tr>";
		  $no++;
    }
    echo "</table>";

	if (isset($_GET[namasibling]))
	{
		$jmldata =mysql_num_rows(mysql_query("select distinct a.id_permit_s from v_stay_permit_sib a right join v_sibling b on a.id_sibling=b.id_sibling where  b.negara like '".$neg."%' and b.NM_DIPLOMAT like '%".$_GET[namasibling]."%' AND a.KD_WORKFLOW > '0'"));
	}else{
		$jmldata =mysql_num_rows(mysql_query("select distinct a.id_permit_s from v_stay_permit_sib a right join v_sibling b on a.id_sibling=b.id_sibling  where  b.negara like '".$neg."%' AND a.KD_WORKFLOW > '0'"));
	}
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   $ilink = "?module=staypermitSib&negara=$_GET[negara]&namasibling=$_GET[namasibling]";
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;

  case "lihat_stay_permit":
	$idt = $_GET[idt];
	$sql="select *, sibling.ID_JNS_VISA as ID_JNS_VISA_SIBLING, sibling.PEKERJAAN as PEKERJAAN_SIBLING, sibling.NO_PASPOR as NO_PASPOR_SIBLING, sibling.TEMPAT_LAHIR as TEMPAT_LAHIR_SIBLING, sibling.TGL_LAHIR as TGL_LAHIR_SIBLING, 	sibling.JK as JK_SIBLING,	sibling.FOTO as FOTO_SIBLING,  	sibling.ALAMATIN as ALAMATIN_SIBLING, sibling.ST_SIPIL as ST_SIPIL_SIBLING, sibling.PASPOR_OLEH as PASPOR_OLEH_SIBLING, sibling.PASPOR_TGL as PASPOR_TGL_SIBLING, sibling.AKHIR_BERLAKU as AKHIR_BERLAKU_SIBLING, DATE_FORMAT(sibling.TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR_SIBLING, DATE_FORMAT(sibling.PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL_SIBLING,DATE_FORMAT(sibling.AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU_SIBLING, DATE_FORMAT(sibling.TGL_TIBA,'%d %M %Y') AS TGL_TIBA, DATE_FORMAT(sibling.	BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD  from sibling inner join diplomat  where sibling.ID_DIPLOMAT=diplomat.ID_DIPLOMAT and ID_SIBLING = $idt";
     $input = mysql_query($sql);
	$r    = mysql_fetch_array($input);

	 echo "<h2 >Stay Permit Sibling - Lihat</h2>";
	 echo "	  <table width=100%>
          <tr><td  width=160>Asal Negara</td>  <td > : ";
            $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
            $w=mysql_fetch_array($tampil);


	$detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_sibling a where a.ID_SIBLING = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_sibling b where b.ID_SIBLING = $idt)");
	$det    = mysql_fetch_array($detil);

    echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto sibling/$r[FOTO_SIBLING]\" width=110 height=150 border=1> </div>
	<br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br><br>";

	$detil = mysql_query("select distinct a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit_sib a where a.id_sibling = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_sibling b where b.id_sibling = $idt) ");
	$det    = mysql_fetch_array($detil);

	echo "<b>Stay Permit Sibling </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No IzinPermit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";

	$detil = mysql_query("select distinct a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");
	$det    = mysql_fetch_array($detil);


	echo "
	</td>
		<tr><td>Nama Diplomat</td>     <td> : $r[NM_DIPLOMAT]</td></tr>
		<tr><th colspan=2></th></tr>
		<tr><td>Nama Family</td>     <td> : $r[NM_SIBLING]</td></tr>
		<tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR_SIBLING] / $r[TGL_LAHIR_SIBLING]</td></tr>
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
		<tr><td>Alamat di Indonesia </td>     <td > : <textarea name='ALAMATIN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATIN_SIBLING]</textarea></td></tr>

		<tr><td>Jenis / No. Paspor</td >     <td > :  ";
            $tampil=mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");

			$w=mysql_fetch_array($tampil);
    echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR_SIBLING]</td></tr>
		<tr><td>Diberikan oleh</td >     <td > : $r[PASPOR_OLEH_SIBLING]  -  $r[PASPOR_TGL_SIBLING] </td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[AKHIR_BERLAKU_SIBLING]</td></tr>

		<tr><td>Jenis / No. Visa</td >     <td > : ";
            $tampil=mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA = $r[ID_JNS_VISA_SIBLING]");
            $w=mysql_fetch_array($tampil);

    echo " $w[NM_JNS_VISA] / $r[NO_VISA] </td></tr>
		  </table> <br>";


	echo " <input type=button value='Tambah' onclick=location.href='?module=staypermitSib&act=tambah_stay_permit&idt=$idt&negara=$_GET[negara]'>
			<table width=100%>
          <tr><th  width=30>no</th><th width=50>No Pendaftaran</th><th width=50>Status</th><th width=50>Verifikator</th><th width=50>Jenis Permit</th><th  width=70>No Agenda</th><th width=85>Tanggal Agenda</th><th width=70>No Izin Permit</th><th width=85>Tanggal Awal Permit</th><th width=85>Tanggal Akhir</th>"./*<th>Status Direktur</th>*/"<th>Status Kasubdit</th><th>Status Kasie</th><th width=70>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 200;
    $posisi = $p->cariPosisi($batas);

$sql="select distinct STATUS,NO_DAFTAR,ID_PERMIT_S,ID_SIBLING,ID_JNS_PERMIT,NO_AGENDA,date_format(TGL_AGENDA,'%d.%m.%Y') as  TGL_AGENDA,NO_IZIN_PERMIT,date_format(TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT,date_format(TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,KET ,NM_JNS_PERMIT,KD_JNS_PERMIT,NM_SIBLING,ST_PERMIT,ST_PERMIT_K,ST_PERMIT_KAS,ID_VERIFIKATOR, NM_VERIFIKATOR, TGL_VERIFIKASI from v_stay_permit_sib where KD_WORKFLOW > 0 AND ID_SIBLING = $idt order by  ID_PERMIT_S";
      $tampil=mysql_query($sql);

	$no = $posisi+1;
	if (mysql_num_rows($tampil)==0){
		echo "<tr><td colspan=12 align=center>Tidak ada Data!</td>";
		}
    while($r=mysql_fetch_array($tampil)){
      echo "<tr><td>$no</td>
				<td><a href=?module=staypermitSib&act=edit_stay_permit&idt=$r[ID_PERMIT_S]&idd=$idt&negara=$_GET[negara]>$r[NO_DAFTAR]</a></td>
				<td>$r[STATUS]</td>
				<td>$r[NM_VERIFIKATOR] $r[TGL_VERIFIKASI]</td>
                <td><a href=?module=staypermitSib&act=edit_stay_permit&idt=$r[ID_PERMIT_S]&idd=$idt&negara=$_GET[negara]> $r[KD_JNS_PERMIT]</a></td>
				<td>$r[NO_AGENDA]</td>
				<td>$r[TGL_AGENDA]</td>
				<td>$r[NO_IZIN_PERMIT]</td>
				<td>$r[TGL_AWAL_PERMIT]</td>
				<td>$r[TGL_AKHIR_PERMIT]</td>
				";/*<td align =center>";
		if ($r[ST_PERMIT] == 2){
			echo "<div style=\"color : green\"> <b>approved</b> </div>";
		}elseif ($r[ST_PERMIT] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>waiting</b> </div>";
		}elseif ($r[ST_PERMIT] == 0){
			echo "<div style=\"color : #800000\"> <b>rejected</b> </div>";
		}*/

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

				echo "</td>
				<td>";
					if (($r[ST_PERMIT_K] == 2) and ($r[ST_PERMIT] == 2)){
					echo "<a href=./report.php?go=permitsib&idd=$r[ID_SIBLING]&idt=$r[ID_PERMIT_S] target=\"_blank\">";
					}
					if (($r[ST_PERMIT_K] == 2)){
					echo "<a href=./report.php?go=permitsib&idd=$r[ID_SIBLING]&idt=$r[ID_PERMIT_S] target=\"_blank\">";
					}
					else
					{
					echo "<a  onClick=\"return alert('Cetak Permit Gagal. Permit harus disetujui oleh DIREKTUR dan KASUBDIT')\"	>";
					}

				echo "Cetak</a> <!--|
		            <a href=./aksi_stay_permit_sib.php?module=staypermitSib&act=hapus&idt=$r[ID_PERMIT]&idd=$idt&negara=$_GET[negara] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus permit $r[NO_IZIN_PERMIT]?')\">Hapus</a>--></td>
				</tr>";

      $no++;
    }
    echo "</table>";


	break;

 case "tambah_stay_permit":
	$idt = $_GET[idt];
	$sql="select *, sibling.ID_JNS_VISA as ID_JNS_VISA_SIBLING, sibling.PEKERJAAN as PEKERJAAN_SIBLING, sibling.NO_PASPOR as NO_PASPOR_SIBLING, sibling.TEMPAT_LAHIR as TEMPAT_LAHIR_SIBLING, sibling.TGL_LAHIR as TGL_LAHIR_SIBLING, 	sibling.JK as JK_SIBLING,	sibling.FOTO as FOTO_SIBLING,  	sibling.ALAMATIN as ALAMATIN_SIBLING, sibling.ST_SIPIL as ST_SIPIL_SIBLING, sibling.PASPOR_OLEH as PASPOR_OLEH_SIBLING, sibling.PASPOR_TGL as PASPOR_TGL_SIBLING, sibling.AKHIR_BERLAKU as AKHIR_BERLAKU_SIBLING, DATE_FORMAT(sibling.TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR_SIBLING, DATE_FORMAT(sibling.PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL_SIBLING,DATE_FORMAT(sibling.AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU_SIBLING, DATE_FORMAT(sibling.TGL_TIBA,'%d %M %Y') AS TGL_TIBA, DATE_FORMAT(sibling.	BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD  from sibling inner join diplomat  where sibling.ID_DIPLOMAT=diplomat.ID_DIPLOMAT and ID_SIBLING = $idt";
	//$sql_old="select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt  ";
  $input = mysql_query($sql);
	$r    = mysql_fetch_array($input);

	 echo "<h2 >Stay Permit Sibling - Tambah</h2>";
	 echo "	  <table width=100%>
          <tr><td  width=160>Asal Negara</td>  <td > : ";
            $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
            $w=mysql_fetch_array($tampil);


	$detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idt)");
	$det    = mysql_fetch_array($detil);

    echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto sibling/$r[FOTO_SIBLING]\" width=110 height=150 border=1> </div>
	<br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br><br>";

	$detil = mysql_query("select distinct a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit_sib a where a.id_sibling = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_sibling b where b.id_sibling = $idt) ");
	$det    = mysql_fetch_array($detil);

	echo "<b>Stay Permit Sibling </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No IzinPermit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";


	echo "
	</td>
		<tr><td>Nama Diplomat</td>     <td> : $r[NM_DIPLOMAT]</td></tr>
		<tr><th colspan=2></th></tr>
		<tr><td>Nama Family</td>     <td> : $r[NM_SIBLING]</td></tr>
		<tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR_SIBLING] / $r[TGL_LAHIR_SIBLING]</td></tr>
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
		<tr><td>Alamat di Indonesia </td>     <td > : <textarea name='ALAMATIN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATIN_SIBLING]</textarea></td></tr>

		<tr><td>Jenis / No. Paspor</td >     <td > :  ";
            $tampil=mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");

			$w=mysql_fetch_array($tampil);
    echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR_SIBLING]</td></tr>
		<tr><td>Diberikan oleh</td >     <td > : $r[PASPOR_OLEH_SIBLING]  -  $r[PASPOR_TGL_SIBLING] </td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[AKHIR_BERLAKU_SIBLING]</td></tr>

		<tr><td>Jenis / No. Visa</td >     <td > : ";
            $tampil=mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA = $r[ID_JNS_VISA_SIBLING]");
            $w=mysql_fetch_array($tampil);

    echo " $w[NM_JNS_VISA] / $r[NO_VISA] </td></tr>
		  </table> <br>";


	echo "<form method=POST enctype='multipart/form-data' onSubmit='return verify(this);' action='./aksi_stay_permit_sib.php?module=staypermitSib&act=input&negara=$_GET[negara]'>
          <input type=hidden name=ID_SIBLING value='$r[ID_SIBLING]'>

		  <table width=100%>

		  <tr><td  width=120>Jenis Permit</td>  <td > :
          <select name='ID_JNS_PERMIT'>
			<option value=0 selected>- Not Defined -</option>";
             $tampil=mysql_query("SELECT ID_JNS_PERMIT,KD_JNS_PERMIT FROM m_jns_permit ORDER BY ID_JNS_PERMIT");
            while($w=mysql_fetch_array($tampil)){
				echo "<option value=$w[ID_JNS_PERMIT]>$w[KD_JNS_PERMIT]</option>";

			}
		$tampil=mysql_query("SELECT * FROM m_syarat where jenis_izin='2'");
	echo "<tr><td>Persyaratan</td>     <td> ";
	while ($data=mysql_fetch_array($tampil)) {
		echo "<input type=checkbox name='syarat[]' value='$data[syarat_kd]'> $data[syarat_nama] <br>";
	}
	echo "</td></tr>";

    echo "</select></td>
        <tr><td>No Agenda</td>     <td> : <input type=text name='NO_AGENDA' size=50  ></td></tr>
		<tr><td>Tanggal Agenda</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AGENDA', true, 'YYYY-MM-DD')</script></div></td></tr>

        <tr><td>No Nota</td>     <td> : <input type=text name='NO_NOTA' size=50  ></td></tr>
		<tr><td>Tanggal Nota</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_NOTA', true, 'YYYY-MM-DD')</script></div></td></tr>";

	echo "<tr><td>No Izin Permit</td>     <td> : <input type=text name='NO_IZIN_PERMIT' size=50></td></tr>";
//	echo "<tr><td>No Izin Permit</td>     <td> : <input type=text name='NO_IZIN_PERMIT' size=50   readonly=\"readonly\"> * di generate otomatis oleh sistem</td></tr>";
	echo "<tr><td>Tanggal Awal Permit</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AWAL_PERMIT', true, 'YYYY-MM-DD')</script></div></td></tr>
		<tr><td>Tanggal Akhir Permit</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR_PERMIT', true, 'YYYY-MM-DD')</script></div></td></tr>
		<tr><td>Keterangan</td>     <td> : <input type=text name='KET' size=100  ></td></tr>
		<tr><td colspan=2 align=right><input type=submit value=Simpan>
              <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table></form>";
 break;
  case "edit_stay_permit":
	$idt = $_GET[idt];
	$idd = $_GET[idd];
  $input = mysql_query("select *, sibling.ID_JNS_VISA as ID_JNS_VISA_SIBLING, sibling.PEKERJAAN as PEKERJAAN_SIBLING, sibling.NO_PASPOR as NO_PASPOR_SIBLING, sibling.TEMPAT_LAHIR as TEMPAT_LAHIR_SIBLING, sibling.TGL_LAHIR as TGL_LAHIR_SIBLING, 	sibling.JK as JK_SIBLING,	sibling.FOTO as FOTO_SIBLING,  	sibling.ALAMATIN as ALAMATIN_SIBLING, sibling.ST_SIPIL as ST_SIPIL_SIBLING, sibling.PASPOR_OLEH as PASPOR_OLEH_SIBLING, sibling.PASPOR_TGL as PASPOR_TGL_SIBLING, sibling.AKHIR_BERLAKU as AKHIR_BERLAKU_SIBLING, DATE_FORMAT(sibling.TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR_SIBLING, DATE_FORMAT(sibling.PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL_SIBLING,DATE_FORMAT(sibling.AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU_SIBLING, DATE_FORMAT(sibling.TGL_TIBA,'%d %M %Y') AS TGL_TIBA, DATE_FORMAT(sibling.	BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD, DATE_FORMAT(sibling.TGL_LAHIR,'%m/%d/%Y') AS USIA, sibling.ID_JNS_RELASI AS JENIS_RELASI  from sibling inner join diplomat  where sibling.ID_DIPLOMAT=diplomat.ID_DIPLOMAT and ID_SIBLING = $idd");
	$r    = mysql_fetch_array($input);

	 echo "<h2 >Stay Permit Sibling - Edit</h2>";
	 echo "	  <table width=100%>
          <tr><td  width=160>Asal Negara</td>  <td > : ";
            $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
            $w=mysql_fetch_array($tampil);


	$detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idd and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idd)");
	$det    = mysql_fetch_array($detil);

    echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto sibling/$r[FOTO_SIBLING]\" width=110 height=150 border=1> </div>
	<br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br><br>";

	$detil = mysql_query("select distinct a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit_sib a where a.id_sibling = $idd and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_sibling b where b.id_sibling = $idd) ");
	$det    = mysql_fetch_array($detil);

	echo "<b>Stay Permit Sibling </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No IzinPermit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";

	$birthDate = $r[USIA];
	$jenis_relasi = $r[JENIS_RELASI];
		//explode the date to get month, day and year
		$month_text = explode(" ", $r[TGL_LAHIR_SIBLING]);
		$birthDate = explode("/", $birthDate);
		$month_now = date('m');
		//get age from date or birthdate
		$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
			? ((date("Y") - $birthDate[2]) - 1)
			: (date("Y") - $birthDate[2]));

			if ($birthDate[0] < $month_now)
			{
				$month_menuju = (12 - $birthDate[0]) + $month_now;
				$month = ($month_now - $birthDate[0]);
			}
			elseif ($birthDate[0] > $month_now)
			{
				$month_menuju = $birthDate[0] - $month_now;
				$month = (12 - $birthDate[0]) + $month_now;
			}
      else
			{
				$month = 0;
			}

 	echo "
	</td>
		<tr><td>Nama Diplomat</td>     <td> : $r[NM_DIPLOMAT]</td></tr>
		<tr><th colspan=2></th></tr>
		<tr><td>Nama Family</td>     <td> : $r[NM_SIBLING]</td></tr>
		<tr><td>Tempat/Tanggal Lahir/Usia</td>     <td> : $r[TEMPAT_LAHIR_SIBLING] / $r[TGL_LAHIR_SIBLING] - $age tahun $month bulan</td></tr>
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
		<tr><td>Alamat di Indonesia </td>     <td > : <textarea name='ALAMATIN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATIN_SIBLING]</textarea></td></tr>

		<tr><td>Jenis / No. Paspor</td >     <td > :  ";
            $tampil=mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");

			$w=mysql_fetch_array($tampil);
    echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR_SIBLING]</td></tr>
		<tr><td>Diberikan oleh</td >     <td > : $r[PASPOR_OLEH_SIBLING]  -  $r[PASPOR_TGL_SIBLING] </td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[AKHIR_BERLAKU_SIBLING]</td></tr>

		<tr><td>Jenis / No. Visa</td >     <td > : ";
            $tampil=mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA = $r[ID_JNS_VISA_SIBLING]");
            $w=mysql_fetch_array($tampil);

    echo " $w[NM_JNS_VISA] / $r[NO_VISA] </td></tr>
		  </table> <br>";



	$edit = mysql_query("select distinct JNS_IZIN_PERMIT,KD_WORKFLOW,ID_PERMIT_S,ID_SIBLING,ID_JNS_PERMIT,NO_AGENDA,TGL_AGENDA,NO_IZIN_PERMIT,TGL_AWAL_PERMIT,TGL_AKHIR_PERMIT,KET,KETVER,KETHOR,NO_NOTA,TGL_NOTA, TGL_AMBIL_BERKAS from  v_stay_permit_sib where ID_PERMIT_S = $idt ");

	$r    = mysql_fetch_array($edit);

	echo "<form method=POST enctype='multipart/form-data' action='./aksi_stay_permit_sib.php?module=staypermitSib&act=update&idt=$idt&negara=$_GET[negara]'>
          <input type=hidden name=ID_SIBLING value='$r[ID_SIBLING]'>
			<input type=hidden name=ID_PERMIT_S value='$r[ID_PERMIT_S]'>

		  <table width=100%>";
			if ($jenis_relasi == '4'){
				$batas_usia = 25;
        // $beda_tahun = ($batas_usia-$age)-1;
        $beda_tahun = ($batas_usia-$age)-1;
					if ($age >= $batas_usia ){
						$warning = "<div style='font-size:15px;color:red;' >Usia telah melewati batas 25 Tahun.</div.";
					}
					elseif($beda_tahun <= 3) {
						$duapuluhlimatahun = date('Y') + $beda_tahun;
						$bulanduapuluhlimatahun = $month_text[1];
            $bulanduapuluhlimatgl = $month_text[0];
						$warning = "<div style='font-size:15px;color:orange;'>Usia mendekati 25 tahun.<br> Ybs. akan berusia 25 tahun pada $bulanduapuluhlimatgl $bulanduapuluhlimatahun $duapuluhlimatahun dalam waktu $beda_tahun Tahun $month_menuju Bulan</div>";
					} else {
						$warning = "<div style='font-size:15px;color:green; float:left;' >Usia Anak memenuhi perysaratan pemberian ijin tinggal.</div>";
					}
				echo "<tr><td width=120> Catatan Batas Usia Anak:</td>
							<td> $warning</td> <tr>";
			}

		  echo "<tr><td  width=120>Jenis Permit</td>  <td > :
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
    echo "</select></td>";
		$tampil=mysql_query("SELECT * FROM syarat_permit a right join m_syarat b on  a.syarat_kd=b.syarat_kd where b.jenis_izin='2' and a.id_permit='".$_GET['idt']."'");
	echo "<tr><td>Persyaratan</td>     <td> ";
	while ($data=mysql_fetch_array($tampil)) {
		echo "<input type=checkbox disabled checked=checked name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama]  <a href='/foto sibling/syarat/$data[file]' target='_blank'>Lihat Berkas</a> <br>";
	}
		$tampil=mysql_query("select * from m_syarat where jenis_izin='2' and syarat_kd not in ( SELECT b.syarat_kd FROM syarat_permit a inner join m_syarat b on  a.syarat_kd=b.syarat_kd where b.jenis_izin='2' and a.id_permit='".$_GET['idt']."')");

	while ($data=mysql_fetch_array($tampil)) {
		echo "<input type=checkbox name='syarat[]' value='$data[syarat_kd]'> $data[syarat_nama]<br>";
	}
	echo "</td></tr>";

	if ($r['KD_WORKFLOW'] == 3)
	{
	$lolosver =  'CHECKED';
	}
	else if($r['KD_WORKFLOW'] == 1)
	{
	$gagalver = 'CHECKED';
	}


	if ($r['JNS_IZIN_PERMIT'] == 'D')
	{
	$DiplomaticD =  'CHECKED';
	}
	else if($r['JNS_IZIN_PERMIT'] == 'S')
	{
	$ServicesS =  'CHECKED';
	}
	echo "
<tr><td>No Agenda</td>     <td> : <input type=text name='NO_AGENDA' size=50 value='$r[NO_AGENDA]' readonly='true'></td></tr>
<tr><td>Tanggal Agenda</td> <td>  <DIV id=\"tgl\">";  if (empty($r[TGL_AGENDA])) {echo "<script>DateInput('TGL_AGENDA', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script>";} else { echo "<script>DateInput('TGL_AGENDA', true, 'YYYY-MM-DD','$r[TGL_AGENDA]')</script>"; } echo"</div></td></tr>
<tr><td>No Nota</td>     <td> : <input type=text name='NO_NOTA' size=50 value='$r[NO_NOTA]' ></td></tr>
<tr><td>Tanggal Nota</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_NOTA', true, 'YYYY-MM-DD','$r[TGL_NOTA]')</script></div></td></tr>
<tr><td>Jenis Izin Permit</td>     <td> : <input type=radio id='JNS_IZIN_PERMIT' name='JNS_IZIN_PERMIT' value='D' $DiplomaticD> Diplomatic (D) <input type=radio id='JNS_IZIN_PERMIT' name='JNS_IZIN_PERMIT' value='S' $ServicesS> Service (S)<strong><div style='font-size:15px;color:red;'>&nbsp;Perhatikan saat pengisian Jenis Izin Permit ('Jangan Sampai Salah')</div></strong></td></tr>
<tr><td>No Izin Permit</td>     <td> : <input type=text name='NO_IZIN_PERMIT' size=50  value='$r[NO_IZIN_PERMIT]' readonly='true'></td></tr>
<tr><td>Tanggal Awal Permit</td> <td> <DIV id=\"tgl\">";  if (empty($r[TGL_AWAL_PERMIT])) {echo "<script>DateInput('TGL_AWAL_PERMIT', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script>";} else { echo "<script>DateInput('TGL_AWAL_PERMIT', true, 'YYYY-MM-DD','$r[TGL_AWAL_PERMIT]')</script>"; } echo"</div></td></tr>
<tr><td>Tanggal Akhir Permit</td> <td> <DIV id=\"tgl\">";  if (empty($r[TGL_AKHIR_PERMIT])) {echo "<script>DateInput('TGL_AKHIR_PERMIT', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script>";} else { echo "<script>DateInput('TGL_AKHIR_PERMIT', true, 'YYYY-MM-DD','$r[TGL_AKHIR_PERMIT]')</script>"; } echo"</div></td></tr>
<tr><td>Tanggal Ambil Berkas</td> <td> <DIV id=\"tgl\">"; if (empty($r[TGL_AMBIL_BERKAS])) {echo "<script>DateInput('TGL_AMBIL_BERKAS', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script>";} else { echo "<script>DateInput('TGL_AMBIL_BERKAS', true, 'YYYY-MM-DD','$r[TGL_AMBIL_BERKAS]')</script>"; } echo"</div><strong><div style='font-size:15px;color:red;'>&nbsp;Perhatikan saat pengisian Tanggal Ambil Berkas ('Jangan Sampai Salah')</div></strong></td></tr>
<tr><td>Verifikasi</td>     <td> : <input type=radio id='statusverifikasi' name='statusverifikasi' value=2 $lolosver> Lolos Verifikasi <input type=radio id='statusverifikasi' name='statusverifikasi' value=1 $gagalver> Tidak Lolos Verifikasi</td></tr>
<tr><td>Keterangan</td>     <td> : <input type=text name='KET' size=100   value='$r[KET]' ></td></tr>
<tr><td>Ket.Vertikal(IdCard)</td>     <td> : <input type=text name='KET_VER' size=100   value='$r[KETVER]' ></td></tr>
<tr><td>Ket.Horizontal(IdCard)</td>     <td> : <input type=text name='KET_HOR' size=100   value='$r[KETHOR]' ></td></tr>
<tr><td colspan=2 align=right><input type=submit value=Simpan>
	  <input type=button value=Batal onclick=self.history.back()></td></tr>
</table></form>";


 break;
  case "cari":
    $alf = $_GET[huruf];

    echo "<br><br><a style=\"font-size: 22pt;\">$alf</a>";
	echo "<h2>Stay Permit Sibling - Pilih Negara</h2>
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
				&nbsp <a href=?module=staypermitSib&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";

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
