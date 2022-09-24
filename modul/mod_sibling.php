<?php
	   echo "<br><a href=?module=sibling&act=cari&huruf=A>A</A> |	<a href=?module=sibling&act=cari&huruf=B>B</A> |	<a href=?module=sibling&act=cari&huruf=C>C</A> |	<a href=?module=sibling&act=cari&huruf=D>D</A> |	<a href=?module=sibling&act=cari&huruf=E>E</A> |	<a href=?module=sibling&act=cari&huruf=F>F</A> |	<a href=?module=sibling&act=cari&huruf=G>G</A> |	<a href=?module=sibling&act=cari&huruf=H>H</A> |	<a href=?module=sibling&act=cari&huruf=I>I</A> |	<a href=?module=sibling&act=cari&huruf=J>J</A> |	<a href=?module=sibling&act=cari&huruf=K>K</A> |	<a href=?module=sibling&act=cari&huruf=L>L</A> |	<a href=?module=sibling&act=cari&huruf=M>M</A> |	<a href=?module=sibling&act=cari&huruf=N>N</A> |	<a href=?module=sibling&act=cari&huruf=O>O</A> |	<a href=?module=sibling&act=cari&huruf=P>P</A> |	<a href=?module=sibling&act=cari&huruf=Q>Q</A> |	<a href=?module=sibling&act=cari&huruf=R>R</A> |	<a href=?module=sibling&act=cari&huruf=S>S</A> |	<a href=?module=sibling&act=cari&huruf=T>T</A> |	<a href=?module=sibling&act=cari&huruf=U>U</A> |	<a href=?module=sibling&act=cari&huruf=V>V</A> |	<a href=?module=sibling&act=cari&huruf=W>W</A> |	<a href=?module=sibling&act=cari&huruf=X>X</A> |	<a href=?module=sibling&act=cari&huruf=Y>Y</A> |	<a href=?module=sibling&act=cari&huruf=Z>Z</A>";


switch($_GET[act]){
  // Tampil Berita
  default:
		if (isset($_GET[negara])) {
			$negaranya = $_GET[negara];
			if ($_GET[negara] == ""){$negaranya = 'Semua negara';}

		}
		else
		{
		$negaranya = 'Semua negara';
		}
		echo "<h2>Family - $negaranya</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='sibling'>
				 <input type=hidden name=negara value='$_GET[negara]'>
			Nama Diplomat : <input type=text name=\"namadiplomat\" value='$_GET[namadiplomat]'> <input type=submit value=Cari>
			</form> <br>
          <input type=button value='Tambah' onclick=location.href='?module=sibling&act=tambahsiblingpilih&negara=$_GET[negara]'>
          <table width=100%>
          <tr><th width=30>no</th><th>NAMA FAMILY</th><th>NAMA DIPLOMAT</th><th width=80>RELASI</th><th width=170>KANTOR PERWAKILAN</th><th width=70>TGL TIBA</th><th width=60>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];

	if (isset($_GET[namadiplomat])){
	 $tampil=mysql_query("SELECT   ID_SIBLING,NM_SIBLING,NM_DIPLOMAT,NM_JNS_RELASI,NEGARA,NM_KNT_PERWAKILAN,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_sibling where negara like '".$neg."%' and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' order by NM_DIPLOMAT, ID_JNS_RELASI limit $posisi,$batas");
	}
	else
    {$tampil=mysql_query("SELECT  ID_SIBLING,NM_SIBLING,NM_DIPLOMAT,NM_JNS_RELASI,NEGARA,NM_KNT_PERWAKILAN,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_sibling where negara like '".$neg."%'  order by NM_DIPLOMAT, ID_JNS_RELASI limit $posisi,$batas");
	}
	$level = $_SESSION[G_leveluser];
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

      echo "<tr><td>$no</td>
                <td><a href=?module=sibling&act=viewsibling&idt=$r[ID_SIBLING]&negara=$_GET[negara]>$r[NM_SIBLING]</a></td>
                <td>$r[NM_DIPLOMAT]</td>
				<td>$r[NM_JNS_RELASI]</td>
				<td>$r[NM_KNT_PERWAKILAN]</td>
				<td>$r[TGL_TIBA]</td>";
				if($level != '99'){
				echo "<td><a href=?module=sibling&act=editsibling&idt=$r[ID_SIBLING]&negara=$_GET[negara]>Edit</a>
		         <!--|<a href=./aksi_sibling.php?module=sibling&act=hapus&idt=$r[ID_SIBLING]&negara=$_GET[negara] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NM_SIBLING]?')\">Hapus</a>--></td>";
				}
		        echo "</tr>";
      $no++;
    }
    echo "</table>";

	if (isset($_GET[namadiplomat]))
	{
		$jmldata =mysql_num_rows(mysql_query("SELECT   ID_SIBLING,NM_SIBLING,NM_DIPLOMAT,NM_JNS_RELASI,NEGARA,NM_KNT_PERWAKILAN,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_sibling where negara like '".$neg."%' and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%'"));
	}else{
		$jmldata =mysql_num_rows(mysql_query("SELECT  ID_SIBLING,NM_SIBLING,NM_DIPLOMAT,NM_JNS_RELASI,NEGARA,NM_KNT_PERWAKILAN,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_sibling where negara like '".$neg."%'"));
	}
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   $ilink = "?module=sibling&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]";
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;


   case "viewsibling":
    $idt = $_GET[idt];
	$sql="select  ID_SIBLING,ID_NEGARA,ID_JNS_PASPOR,ID_DIPLOMAT,ID_JNS_RELASI,NM_JNS_RELASI,ID_JNS_VISA,NM_SIBLING,NM_DIPLOMAT,NEGARA as country,NM_KNT_PERWAKILAN ,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d %M %Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA,LAMA_BERDIAM_BLN,TELP,NO_SR_SETNEG,FOTO_TTD, PROVINCE_ID, REGENCY_ID from v_sibling where ID_SIBLING = $idt ";
     $edit = mysql_query($sql);



	$r    = mysql_fetch_array($edit);

	     echo "<h2>View Family</h2>

		  <table width=100%>
		  <tr><td width=160>Nama Diplomat</td >  <td colspan=\"2\"> : $r[NM_DIPLOMAT] </td></tr>
		  <tr><td>Negara</td >  <td colspan=\"2\"> : $r[country] </td></tr>
		  <tr><td>Kantor Perwakilan</td >  <td colspan=\"2\"> : $r[NM_KNT_PERWAKILAN] </td></tr>
		  <tr><td bgcolor=\"#265180\" colspan=\"3\"> &nbsp; </td></tr>

		  <tr><td>Relasi</td>  <td>: $r[NM_JNS_RELASI]</td><td rowspan=\"22\"  width=200 align=center><img src=\"../foto sibling/$r[FOTO]\" width=110 height=150 border=1><img src=\"../foto sibling/ttd/$r[FOTO_TTD]\" width=110 height=100% border=1> </td>

      </tr>";
	   $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA='".$r['ID_NEGARA']."' ORDER BY ID_NEGARA");
       $w=mysql_fetch_array($tampil);
          echo "<tr><td  width=120>Asal Negara</td>  <td>: $w[NEGARA]</td></tr>";
		echo"<tr><td>Nama Family</td>     <td>: $r[NM_SIBLING]</td></tr>
 		<tr><td>Tempat Lahir</td>     <td>: $r[TEMPAT_LAHIR]</td></tr>
			<tr><td>Tanggal Lahir</td> <td>: $r[TGL_LAHIR]
		</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : ";
		if ($r[JK]=='l'){
		echo "Laki-laki";}else
		{echo "Perempuan";	}
		echo "</td>  </tr>
		<tr><td>Pekerjaan</td >     <td>: $r[PEKERJAAN]</td></tr>
		<tr><td>Alamat Luar Negeri </td>     <td>: $r[ALAMATLN]</td></tr>
		<tr><td>Status Sipil</td>     <td>: ";
		if ($r[ST_SIPIL]=='s'){
		echo "Belum Menikah";} else{
		echo "Sudah Menikah";}
		echo "</td></tr>
		<tr><td>Jenis / No. Paspor</td >     <td>:  ";
            $tampil=mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");

			$w=mysql_fetch_array($tampil);
    echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR]</td></tr>
		<tr><td>Diberikan oleh</td >     <td>: $r[PASPOR_OLEH] - $r[PASPOR_TGL]</td></tr>
		<tr><td>Berlaku s/d</td >     <td>: $r[AKHIR_BERLAKU]</td></tr>

			<tr><td>Jenis / No. Visa / Status</td >     <td > : ";
            $tampil=mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA = $r[ID_JNS_VISA]");
            $w=mysql_fetch_array($tampil);

    echo " $w[NM_JNS_VISA] / $r[NO_VISA] / ";

		if ($r[ST_VISA] == 2){

			echo " <b style=\"color : green\">approved</b>";
		}elseif ($r[ST_VISA] == 1){
			echo " <b  style=\"color : #B1BF19\">waiting</b>";
		}elseif ($r[ST_VISA] == 0){

			echo " <b  style=\"color : #800000\">rejected</b> ";
		}

	echo "</td></tr>
		<tr><td>Diberikan oleh</td >     <td>: $r[VISA_OLEH]</td></tr>
		<tr><td>Lama berdiam di Indonesia</td >     <td > : $r[LAMA_BERDIAM] tahun &nbsp $r[LAMA_BERDIAM_BLN] bulan </td></tr>
		<tr><td>Tanggal tiba</td >     <td>: $r[TGL_TIBA]</td></tr>
		<tr><td>Alamat di Indonesia</td >     <td>:$r[ALAMATIN]</td></tr>
			<tr><td>Telepon</td >     <td>: $r[TELP]</td></tr>";
			$sql_combo = "select a.id as kode_provinsi, a.name as nama_province, b.id as kode_kab_kota, b.name as nama_regency from provinces a, regencies b where a.id = b.province_id
			and b.id='".$r['REGENCY_ID']."'";
			$query = mysql_query($sql_combo);
			$selected = mysql_fetch_array($query);
				echo "<tr><td>Provinsi</td >
						<td colspan='2'> : ".$selected['nama_province']."</td> </tr>";

				echo "<tr><td>Kota / Kabupaten</td >
								<td colspan='2' id='kabupaten_kota'> :
								 ".$selected['nama_regency']."
								 </td> </tr>
				<tr><td>No SP SETNEG</td >     <td>: $r[NO_SETKAB]</td></tr>
		<tr><td>No SR SETNEG</td >     <td>: $r[NO_SR_SETNEG]</td></tr>

		<tr><td>Berlaku s/d</td >     <td>: $r[BERLAKUSD]</td></tr>
		<tr><td>No. Surat Sponsor</td >     <td> : $r[NO_SPONSOR]</tr>
        </table>";



	 break;

  case "tambahsiblingpilih":

		if (isset($_GET[negara])) {
			$negaranya = $_GET[negara];
			if ($_GET[negara] == ""){$negaranya = 'Semua negara';}

		}
		else
		{
		$negaranya = 'Semua negara';
		}
		echo "<h2>FAMILY <br>Pilih Diplomat - $negaranya</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='sibling'>
				 <input type=hidden name=negara value='$_GET[negara]'>
				  <input type=hidden name=act value='tambahsiblingpilih'>
			Nama Diplomat : <input type=text name=\"namadiplomat\"> <input type=submit value=Cari>
			</form> <br>

		  <table width=100%>
          <tr><th width=30>no</th><th width=130>NAMA LENGKAP</th><th width=160>KANTOR PERWAKILAN</th><th>JABATAN</th><th width=60>TGL TIBA</th><th width=85>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];

	if (isset($_GET[namadiplomat])){
	 $tampil=mysql_query("SELECT  ID_DIPLOMAT,NM_DIPLOMAT,NM_KNT_PERWAKILAN,PEKERJAAN,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_diplomat where negara like '".$neg."%' and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' and ID_DIPLOMAT>1 order by NM_DIPLOMAT limit $posisi,$batas");
	}
	else
    {$tampil=mysql_query("SELECT  ID_DIPLOMAT,NM_DIPLOMAT,NM_KNT_PERWAKILAN,PEKERJAAN,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_diplomat where negara like '".$neg."%' and ID_DIPLOMAT>1  order by  NM_DIPLOMAT limit $posisi,$batas");
	}

    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

      echo "<tr><td>$no</td>
                <td>$r[NM_DIPLOMAT]</td>
                <td>$r[NM_KNT_PERWAKILAN]</td>
				<td>$r[PEKERJAAN]</td>
				<td>$r[TGL_TIBA]</td>
				<td><a href=?module=sibling&act=tambahsibling&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>Tambah Family</a></td>
		        </tr>";
      $no++;
    }
    echo "</table>";

	if (isset($_GET[namadiplomat]))
	{
		$jmldata =mysql_num_rows(mysql_query("SELECT ID_DIPLOMAT,NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN,PEKERJAAN FROM  v_diplomat where negara like '".$neg."%' and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%'  and ID_DIPLOMAT>1 "));
	}else{
		$jmldata =mysql_num_rows(mysql_query("SELECT ID_DIPLOMAT,NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN,PEKERJAAN FROM  v_diplomat where negara like '".$neg."%' and ID_DIPLOMAT>1 "));
	}
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   $ilink = "?module=sibling&act=tambahsiblingpilih&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]";
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;
  case "tambahsibling":
      $idt = $_GET[idt];
    $input = mysql_query("select ID_DIPLOMAT, NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN,ID_NEGARA,ALAMATLN,LAMA_BERDIAM,LAMA_BERDIAM_BLN,ALAMATIN,NO_SETKAB,BERLAKUSD,NO_SPONSOR,TELP,NO_SR_SETNEG,ID_JNS_VISA  from v_diplomat where ID_DIPLOMAT = $idt ");


	$rd    = mysql_fetch_array($input);

	     echo "<h2>Tambah Family</h2>
          <form method=POST enctype='multipart/form-data' action='./aksi_sibling.php?module=sibling&act=input&negara=$_GET[negara]'>
          <input type=hidden name=ID_DIPLOMAT value='$rd[ID_DIPLOMAT]'>

		  <input type=hidden name=NM_DIPLOMAT value='$rd[NM_DIPLOMAT]'>

		  <table width=100%>
		  <tr><td>Nama Diplomat</td >  <td colspan=\"2\"> : $rd[NM_DIPLOMAT] </td></tr>
		  <tr><td>Negara</td >  <td colspan=\"2\"> : $rd[NEGARA] </td></tr>
		  <tr><td>Kantor Perwakilan</td >  <td colspan=\"2\"> : $rd[NM_KNT_PERWAKILAN] </td></tr>
		  <tr><td bgcolor=\"#265180\" colspan=\"3\"> &nbsp; </td></tr>
		  <tr><td  width=120>Relasi</td>  <td colspan=\"2\"> :
          <select name='ID_JNS_RELASI'>
			<option value=0 selected>- Not Defined -</option>";
             $tampil=mysql_query("SELECT ID_JNS_RELASI,NM_JNS_RELASI   FROM m_jns_relasi  where ID_JNS_RELASI > 1 ORDER BY ID_JNS_RELASI");
            while($w=mysql_fetch_array($tampil)){
				echo "<option value=$w[ID_JNS_RELASI]>$w[NM_JNS_RELASI]</option>";

			}

    echo "</select></td>
          <tr><td  width=120>Asal Negara</td>  <td colspan=\"2\"> :
          <select name='ID_NEGARA'>
             <option value=0 selected>- Not Defined -</option>";
            $tampil=mysql_query("SELECT * FROM m_negara where id_negara > 1 ORDER BY negara");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_NEGARA]";
              if ($rd[ID_NEGARA]==$r[ID_NEGARA]){echo " selected ";}
	             echo ">$r[NEGARA]</option>";
            }


    echo "</select></td>
		<tr><td>Nama Family</td>     <td> : <input type=text name='NM_SIBLING' size=50  ></td><td rowspan=\"5\"  width=120 align=center><img src=\"../foto sibling/$r[FOTO]\" width=110 height=150 border=1></td></tr>

		<tr><td>Tempat Lahir</td>     <td> : <input type=text name='TEMPAT_LAHIR' size=50  ></td></tr>
			<tr><td>Tanggal Lahir</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_LAHIR', true, 'YYYY-MM-DD')</script></div>
		</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : <input type=radio name='JK' value=l checked>L <input type=radio name='JK' value=p >P
		</td> </tr>
		<tr><td>Foto</td>     <td > : <input type=file size=40 name=fupload></td></tr>
    <tr><td>Tanda tangan</td>     <td > : <input type=file size=40 name=fuploadttd></td>
    <td rowspan=\"3\"  width=120 align=center><img src=\".\" width=110 height=100% border=1></td>
    </tr>
		<tr><td>Pekerjaan</td >     <td> : <input type=text name='PEKERJAAN' size=50 ></td></tr>
		<tr><td>Alamat Luar Negeri </td>     <td> : <textarea name='ALAMATLN' rows=2 cols=55 >$rd[ALAMATLN]</textarea></td></tr>
		<tr><td>Status Sipil</td>     <td colspan=\"2\"> : <input type=radio name='ST_SIPIL' value=s checked>Single <input type=radio name='ST_SIPIL' value=m >Married
		</td></tr>
		<tr><td>Jenis / No. Paspor</td >     <td colspan=\"2\"> :  <select name='ID_JNS_PASPOR' >
			<option value=0 selected>- Not Defined -</option>";
            $tampil=mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR > 1 ORDER BY JNS_PASPOR");
			while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_JNS_PASPOR]>$r[JNS_PASPOR]</option>";
            }

    echo "</select> <input type=text name='NO_PASPOR' size=50  ></td></tr>
		<tr><td>Diberikan oleh</td >     <td colspan=\"2\"> <DIV id=\"tgl\"> <script>DateInput('PASPOR_TGL', true, 'YYYY-MM-DD')</script></div> <input type=text name='PASPOR_OLEH' size=50 ></td></tr>
		<tr><td>Berlaku s/d</td >     <td colspan=\"2\"> <DIV id=\"tgl\"> <script>DateInput('AKHIR_BERLAKU', true, 'YYYY-MM-DD')</script></div></td></tr>

		<tr><td>Jenis / No. Visa</td >     <td colspan=\"2\"> : <select name='ID_JNS_VISA' >";
		         $tampil=mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA>1 ORDER BY NM_JNS_VISA");
           while($w=mysql_fetch_array($tampil)){
				echo "<option value=$w[ID_JNS_VISA]";
              if ($rd[ID_JNS_VISA]==$w[ID_JNS_VISA]){echo " selected ";}
	             echo ">$w[NM_JNS_VISA]</option>";
			}

    echo "</select> <input type=text name='NO_VISA' size=50 >
  <input type=radio name='ST_VISA' value=0 ><b style=\"color : #800000\">reject</b>
	<input type=radio name='ST_VISA' value=1 checked><b style=\"color : #B1BF19\">waiting</b>
	<input type=radio name='ST_VISA' value=2 ><b style=\"color : green\">approve</b>
    </td></tr>
		<tr><td>Diberikan oleh</td >     <td colspan=\"2\"> : <input type=text name='VISA_OLEH' size=50  ></td></tr>
		<tr><td>Lama berdiam di Indonesia</td >     <td colspan=\"2\"> :
    <select name='LAMA_BERDIAM' >
			<option value=0 ";
              if ($rd[LAMA_BERDIAM]==0){echo " selected ";}
	             echo ">0 tahun</option>
		  <option value=1 ";
              if ($rd[LAMA_BERDIAM]==1){echo " selected ";}
	             echo ">1 tahun</option>
			<option value=2 ";
              if ($rd[LAMA_BERDIAM]==2){echo " selected ";}
	             echo ">2 tahun</option>
			<option value=3 ";
              if ($rd[LAMA_BERDIAM]==3){echo " selected ";}
	             echo ">3 tahun</option>
		</select> &nbsp
    <select name='LAMA_BERDIAM_BLN' >
			<option value=0 ";
              if ($rd[LAMA_BERDIAM_BLN]==0){echo " selected ";}
	             echo ">0 bulan</option>
		  <option value=1 ";
              if ($rd[LAMA_BERDIAM_BLN]==1){echo " selected ";}
	             echo ">1 bulan</option>
			<option value=2 ";
              if ($rd[LAMA_BERDIAM_BLN]==2){echo " selected ";}
	             echo ">2 bulan</option>
			<option value=3 ";
              if ($rd[LAMA_BERDIAM_BLN]==3){echo " selected ";}
	             echo ">3 bulan</option>
      <option value=4 ";
              if ($rd[LAMA_BERDIAM_BLN]==4){echo " selected ";}
	             echo ">4 bulan</option>
			<option value=5 ";
              if ($rd[LAMA_BERDIAM_BLN]==5){echo " selected ";}
	             echo ">5 bulan</option>
			<option value=6 ";
              if ($rd[LAMA_BERDIAM_BLN]==6){echo " selected ";}
	             echo ">6 bulan</option>
      <option value=7 ";
              if ($rd[LAMA_BERDIAM_BLN]==7){echo " selected ";}
	             echo ">7 bulan</option>
			<option value=8 ";
              if ($rd[LAMA_BERDIAM_BLN]==8){echo " selected ";}
	             echo ">8 bulan</option>
			<option value=9 ";
              if ($rd[LAMA_BERDIAM_BLN]==9){echo " selected ";}
	             echo ">9 bulan</option>
      <option value=10 ";
              if ($rd[LAMA_BERDIAM_BLN]==10){echo " selected ";}
	             echo ">10 bulan</option>
			<option value=11 ";
              if ($rd[LAMA_BERDIAM_BLN]==11){echo " selected ";}
	             echo ">11 bulan</option>
		</select>
    </td></tr>



		<tr><td>Tanggal tiba</td >     <td colspan=\"2\"> <DIV id=\"tgl\"> <script>DateInput('TGL_TIBA', true, 'YYYY-MM-DD')</script></div></td></tr>
		<tr><td>Alamat di Indonesia</td >     <td colspan=\"2\"> : <textarea name='ALAMATIN' rows=2 cols=55 >$rd[ALAMATIN]</textarea></td></tr>";

    echo "<tr><td>Provinsi</td >
        <td colspan='2'> :
        <select name='PROVINCE_ID' id='PROVINCE_ID'>
        <option value='-'>-- Pilih --</option>";
        $sql="select * from provinces order by name asc";
        $query = mysql_query($sql);
        while($province = mysql_fetch_array($query)) {
              echo "<option value='".$province['id']."'>".$province['name']."</option>";
        }
        echo '</select> </td> </tr>';

    echo "<tr><td>Kota / Kabupaten</td >
            <td colspan='2' id='kabupaten_kota'> :
             </td> </tr>";
    echo "
		<tr><td>Telepon</td >     <td colspan=\"2\"> : <input type=text name='TELP' size=50  value=$rd[TELP]></td></tr>
		<tr><td>No SP SETNEG</td >     <td colspan=\"2\"> : <input type=text name='NO_SETKAB' size=50  value=$rd[NO_SETKAB]></td></tr>
		<tr><td>No SR SETNEG</td >     <td colspan=\"2\"> : <input type=text name='NO_SR_SETNEG' size=50   value=$rd[NO_SR_SETNEG]></td></tr>
		<tr><td>Berlaku s/d</td >     <td colspan=\"2\">  <DIV id=\"tgl\"> <script>DateInput('BERLAKUSD', true, 'YYYY-MM-DD','$rd[BERLAKUSD]')</script></div></td></tr>
		<tr><td>No. Surat Sponsor</td >     <td colspan=\"2\"> : <input type=text name='NO_SPONSOR' size=50  value=$rd[NO_SPONSOR] ></td></tr>


		<tr><td colspan=3 align=right><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table></form>";
	 break;


  case "editsibling":
    $idt = $_GET[idt];
    $edit = mysql_query("select   ID_SIBLING,ID_NEGARA,ID_JNS_PASPOR,ID_DIPLOMAT,ID_JNS_RELASI,ID_JNS_VISA,NM_SIBLING,NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN ,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%Y-%m-%d') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%Y-%m-%d') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%Y-%m-%d') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%Y-%m-%d') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%Y-%m-%d') AS BERLAKUSD,NO_SPONSOR,ST_VISA,LAMA_BERDIAM_BLN,TELP,NO_SR_SETNEG,FOTO_TTD, PROVINCE_ID, REGENCY_ID from v_sibling where ID_SIBLING = $idt ");


	$r    = mysql_fetch_array($edit);

	     echo "<h2>Edit Family</h2>
          <form method=POST enctype='multipart/form-data' action='./aksi_sibling.php?module=sibling&act=update&negara=$_GET[negara]'>
         <input type=hidden name=idt value='$r[ID_SIBLING]'>
         <input type=hidden name=ID_DIPLOMAT value='$r[ID_DIPLOMAT]'>
		<input type=hidden name=NM_DIPLOMAT value='$r[NM_DIPLOMAT]'>

		  <table width=100%>
		  <tr><td>Nama Diplomat</td >  <td colspan=\"2\"> : $r[NM_DIPLOMAT] </td></tr>
		  <tr><td>Negara</td >  <td colspan=\"2\"> : $r[NEGARA] </td></tr>
		  <tr><td>Kantor Perwakilan</td >  <td colspan=\"2\"> : $r[NM_KNT_PERWAKILAN] </td></tr>
		  <tr><td bgcolor=\"#265180\" colspan=\"3\"> &nbsp; </td></tr>

		  <tr><td  width=120>Relasi</td>  <td colspan=\"2\"> :
          <select name='ID_JNS_RELASI'>";
            $tampil=mysql_query("SELECT ID_JNS_RELASI,NM_JNS_RELASI   FROM m_jns_relasi ORDER BY ID_JNS_RELASI");
            while($w=mysql_fetch_array($tampil)){
			if ($r[ID_JNS_RELASI]==$w[ID_JNS_RELASI]){
				echo "<option value=$w[ID_JNS_RELASI] selected>$w[NM_JNS_RELASI]</option>";
			}
			else{
				echo "<option value=$w[ID_JNS_RELASI]>$w[NM_JNS_RELASI]</option>";
			}
			}

    echo "</select></td>
          <tr><td  width=120>Asal Negara</td>  <td colspan=\"2\"> :
          <select name='ID_NEGARA'>";
            $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara ORDER BY ID_NEGARA");
            while($w=mysql_fetch_array($tampil)){
			if ($r[ID_NEGARA]==$w[ID_NEGARA]){
				echo "<option value=$w[ID_NEGARA] selected>$w[NEGARA]</option>";
			}
			else{
				echo "<option value=$w[ID_NEGARA]>$w[NEGARA]</option>";
			}
			}
    echo "</select></td>
		<tr><td>Nama Family</td>     <td> : <input type=text name='NM_SIBLING' size=50 value= '$r[NM_SIBLING]' ></td><td rowspan=\"5\"  width=120 align=center><img src=\"../foto sibling/$r[FOTO]\" width=110 height=150 border=1></td></tr>

		<tr><td>Tempat Lahir</td>     <td> : <input type=text name='TEMPAT_LAHIR' size=50 value= '$r[TEMPAT_LAHIR]' ></td></tr>
			<tr><td>Tanggal Lahir</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_LAHIR', true, 'YYYY-MM-DD','$r[TGL_LAHIR]')</script></div>
		</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : ";

		if ($r[JK]=='l'){
		echo "<input type=radio name='JK' value=l checked>L <input type=radio name='JK' value=p >P ";}else
		{echo "<input type=radio name='JK' value=l >L <input type=radio name='JK' value=p checked>P ";	}

		echo "</td> </tr>
		<tr><td>Foto</td>     <td > : <input type=file size=40 name=fupload></td></tr>
    <tr><td>Tanda tangan</td>     <td > : <input type=file size=40 name=fuploadttd></td>
    <td rowspan=\"3\"  width=120 align=center><img src=\"../foto sibling/ttd/$r[FOTO_TTD]\" width=110 height=100% border=1></td>
    </tr>
		<tr><td>Pekerjaan</td >     <td> : <input type=text name='PEKERJAAN' size=50 value= '$r[PEKERJAAN]' ></td></tr>
		<tr><td>Alamat Luar Negeri </td>     <td> : <textarea name='ALAMATLN' rows=2 cols=55 >$r[ALAMATLN]</textarea></td></tr>
		<tr><td>Status Sipil</td>     <td colspan=\"2\"> : ";

		if ($r[ST_SIPIL]=='s'){
		echo "<input type=radio name='ST_SIPIL' value=s checked>Single <input type=radio name='ST_SIPIL' value=m >Married";} else{
		echo "<input type=radio name='ST_SIPIL' value=s>Single <input type=radio name='ST_SIPIL' value=m  checked>Married ";}


		echo "</td></tr>
		<tr><td>Jenis / No. Paspor</td >     <td colspan=\"2\"> :  <select name='ID_JNS_PASPOR' >";
            $tampil=mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR > 1 ORDER BY JNS_PASPOR");

			while($w=mysql_fetch_array($tampil)){
			if ($r[ID_JNS_PASPOR]==$w[ID_JNS_PASPOR]){
				echo "<option value=$w[ID_JNS_PASPOR] selected>$w[JNS_PASPOR]</option>";
			}
			else{
				echo "<option value=$w[ID_JNS_PASPOR]>$w[JNS_PASPOR]</option>";
			}
			}

    echo "</select> <input type=text name='NO_PASPOR' size=50 value= '$r[NO_PASPOR]' ></td></tr>
		<tr><td>Diberikan oleh</td >     <td colspan=\"2\"> <DIV id=\"tgl\"> <script>DateInput('PASPOR_TGL', true, 'YYYY-MM-DD','$r[PASPOR_TGL]')</script></div> <input type=text name='PASPOR_OLEH' size=50 value= '$r[PASPOR_OLEH]' ></td></tr>
		<tr><td>Berlaku s/d</td >     <td colspan=\"2\"> <DIV id=\"tgl\"> <script>DateInput('AKHIR_BERLAKU', true, 'YYYY-MM-DD','$r[AKHIR_BERLAKU]')</script></div></td></tr>

		<tr><td>Jenis / No. Visa</td >     <td colspan=\"2\"> : <select name='ID_JNS_VISA' >";
            $tampil=mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA > 1 ORDER BY NM_JNS_VISA");
           while($w=mysql_fetch_array($tampil)){
			if ($r[ID_JNS_VISA]==$w[ID_JNS_VISA]){
				echo "<option value=$w[ID_JNS_VISA] selected>$w[NM_JNS_VISA]</option>";
			}
			else{
				echo "<option value=$w[ID_JNS_VISA]>$w[NM_JNS_VISA]</option>";
			}
			}

    echo "</select> &nbsp<input type=text name='NO_VISA' size=50 value= '$r[NO_VISA]' >
     <input type=radio name='ST_VISA' value=0 ";
					if ($r[ST_VISA]== 0){ echo "checked";}
				echo "> <b style=\"color : #800000\">reject</b>	<input type=radio name='ST_VISA' value=1 ";
					if ($r[ST_VISA]== 1){ echo "checked";}
				echo "> <b style=\"color : #B1BF19\">waiting</b> <input type=radio name='ST_VISA' value=2 ";
					if ($r[ST_VISA]== 2){ echo "checked";}
				echo "> <b style=\"color : green\">approve</b>
    </td></tr>
		<tr><td>Diberikan oleh</td >     <td colspan=\"2\"> : <input type=text name='VISA_OLEH' size=50 value= '$r[VISA_OLEH]' ></td></tr>
		<tr><td>Lama berdiam di Indonesia</td >     <td colspan=\"2\"> :
    	<select name='LAMA_BERDIAM' >
			<option value=0 ";
      if ($r[LAMA_BERDIAM]==0){echo " selected ";}
	echo ">0 tahun</option>
			<option value=1 ";
		  if ($r[LAMA_BERDIAM]==1){echo " selected ";}
	echo ">1 tahun</option>
			<option value=2 ";
			if ($r[LAMA_BERDIAM]==2){echo " selected ";}
	echo ">2 tahun</option>
			<option value=3 ";
			if ($r[LAMA_BERDIAM]==3){echo " selected ";}
	echo ">3 tahun</option>
		  </select>		  &nbsp
    <select name='LAMA_BERDIAM_BLN' >
			<option value=0 ";
      if ($r[LAMA_BERDIAM_BLN]==0){echo " selected ";}
	echo ">0 bulan</option>
		  <option value=1 ";
      if ($r[LAMA_BERDIAM_BLN]==1){echo " selected ";}
	echo ">1 bulan</option>
			<option value=2 ";
      if ($r[LAMA_BERDIAM_BLN]==2){echo " selected ";}
	echo ">2 bulan</option>
			<option value=3 ";
      if ($r[LAMA_BERDIAM_BLN]==3){echo " selected ";}
	echo ">3 bulan</option>
      <option value=4 ";
      if ($r[LAMA_BERDIAM_BLN]==4){echo " selected ";}
	echo ">4 bulan</option>
			<option value=5 ";
      if ($r[LAMA_BERDIAM_BLN]==5){echo " selected ";}
	echo ">5 bulan</option>
			<option value=6 ";
      if ($r[LAMA_BERDIAM_BLN]==6){echo " selected ";}
	echo ">6 bulan</option>
      <option value=7 ";
      if ($r[LAMA_BERDIAM_BLN]==7){echo " selected ";}
	echo ">7 bulan</option>
			<option value=8 ";
      if ($r[LAMA_BERDIAM_BLN]==8){echo " selected ";}
	echo ">8 bulan</option>
			<option value=9 ";
      if ($r[LAMA_BERDIAM_BLN]==9){echo " selected ";}
	echo ">9 bulan</option>
      <option value=10 ";
      if ($r[LAMA_BERDIAM_BLN]==10){echo " selected ";}
	echo ">10 bulan</option>
			<option value=11 ";
      if ($r[LAMA_BERDIAM_BLN]==11){echo " selected ";}
	echo ">11 bulan</option>
		</select></td></tr>
		<tr><td>Tanggal tiba</td >     <td colspan=\"2\"> <DIV id=\"tgl\"> <script>DateInput('TGL_TIBA', true, 'YYYY-MM-DD','$r[TGL_TIBA]')</script></div></td></tr>

		<tr><td>Alamat di Indonesia</td >     <td colspan=\"2\"> : <textarea name='ALAMATIN' rows=2 cols=55 >$r[ALAMATIN]</textarea></td></tr>";

	$sql_combo = "select a.id as kode_provinsi, a.name as nama_province, b.id as kode_kab_kota, b.name as nama_regency from provinces a, regencies b where a.id = b.province_id
	and b.id='".$r['REGENCY_ID']."'";
	$query = mysql_query($sql_combo);
	$selected = mysql_fetch_array($query);
		echo "<tr><td>Provinsi</td >
				<td colspan='2'> :
				<select name='PROVINCE_ID' id='PROVINCE_ID'>
				<option value='".$selected['kode_provinsi']."' selected>".$selected['nama_province']."</option>";
				$sql="select * from provinces order by name asc";
				$query = mysql_query($sql);
				while($province = mysql_fetch_array($query)) {
							echo "<option value='".$province['id']."'>".$province['name']."</option>";
				}
				echo '</select> </td> </tr>';

		echo "<tr><td>Kota / Kabupaten</td >
						<td colspan='2' id='kabupaten_kota'> :
						<select name='REGENCY_ID' id='REGENCY_ID'>
						<option value='".$selected['kode_kab_kota']."' selected>".$selected['nama_regency']."</option>";
						$sql="select * from regencies where province_id='".$selected['kode_provinsi']."' order by name asc";
						$query = mysql_query($sql);
						while($regencies = mysql_fetch_array($query)) {
									echo "<option value='".$regencies['id']."'>".$regencies['name']."</option>";
						}
						echo '</select>
						 </td> </tr>';

						echo "
			<tr><td>Telepon</td >     <td colspan=\"2\"> : <input type=text name='TELP' size=50 value= '$r[TELP]' ></td></tr>
				<tr><td>No SP SETNEG</td >     <td colspan=\"2\"> : <input type=text name='NO_SETKAB' size=50 value= '$r[NO_SETKAB]' ></td></tr>
		<tr><td>No SR SETNEG</td >     <td colspan=\"2\"> : <input type=text name='NO_SR_SETNEG' size=50 value= '$r[NO_SR_SETNEG]'></td></tr>

		<tr><td>Berlaku s/d</td >     <td colspan=\"2\">  <DIV id=\"tgl\"> <script>DateInput('BERLAKUSD', true, 'YYYY-MM-DD','$r[BERLAKUSD]')</script></div></td></tr>
		<tr><td>No. Surat Sponsor</td >     <td colspan=\"2\"> : <input type=text name='NO_SPONSOR' size=50 value= '$r[NO_SPONSOR]' ></td></tr>



		<tr><td colspan=3 align=right><input type=submit value=Update>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table></form>";



	 break;


  case "cari":
    $alf = $_GET[huruf];

    echo "<br><br><a style=\"font-size: 22pt;\">$alf</a>";
	echo "<h2>Family</h2>
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
				&nbsp <a href=?module=sibling&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";

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
<script>
$(document).ready(function() {
      $( "#PROVINCE_ID" ).change(function() {
      var selectedProvince = $(this).children("option:selected").val();
      //       $('#kabupaten_kota').html(selectedProvince);
         $.ajax({
            method: "POST",
            url: "ajax/diplomat.php",
            data: { provinsi_kd: selectedProvince,  type: "combo_province" },
            dataType: 'html',
              beforeSend: function(){
                 $('#kabupaten_kota').html("loading ...");
               },
              success: function(output){
                $('#kabupaten_kota').html(output);
               }
            });

       });
    });
 </script>
