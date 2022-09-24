<?php
	   echo "<a href=?module=idcard&act=cari&huruf=A>A</A> |	<a href=?module=idcard&act=cari&huruf=B>B</A> |	<a href=?module=idcard&act=cari&huruf=C>C</A> |	<a href=?module=idcard&act=cari&huruf=D>D</A> |	<a href=?module=idcard&act=cari&huruf=E>E</A> |	<a href=?module=idcard&act=cari&huruf=F>F</A> |	<a href=?module=idcard&act=cari&huruf=G>G</A> |	<a href=?module=idcard&act=cari&huruf=H>H</A> |	<a href=?module=idcard&act=cari&huruf=I>I</A> |	<a href=?module=idcard&act=cari&huruf=J>J</A> |	<a href=?module=idcard&act=cari&huruf=K>K</A> |	<a href=?module=idcard&act=cari&huruf=L>L</A> |	<a href=?module=idcard&act=cari&huruf=M>M</A> |	<a href=?module=idcard&act=cari&huruf=N>N</A> |	<a href=?module=idcard&act=cari&huruf=O>O</A> |	<a href=?module=idcard&act=cari&huruf=P>P</A> |	<a href=?module=idcard&act=cari&huruf=Q>Q</A> |	<a href=?module=idcard&act=cari&huruf=R>R</A> |	<a href=?module=idcard&act=cari&huruf=S>S</A> |	<a href=?module=idcard&act=cari&huruf=T>T</A> |	<a href=?module=idcard&act=cari&huruf=U>U</A> |	<a href=?module=idcard&act=cari&huruf=V>V</A> |	<a href=?module=idcard&act=cari&huruf=W>W</A> |	<a href=?module=idcard&act=cari&huruf=X>X</A> |	<a href=?module=idcard&act=cari&huruf=Y>Y</A> |	<a href=?module=idcard&act=cari&huruf=Z>Z</A>";
		

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
		echo "<h2>ID Card <br>Pilih Diplomat - $negaranya</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='idcard'>
				 <input type=hidden name=negara value='$_GET[negara]'>
			Nama Diplomat : <input type=text name=\"namadiplomat\"> <input type=submit value=Cari>
			</form> <br>

		  <table width=100%>
          <tr><th width=30>no</th><th>ID CARD</th><th width=130>NAMA LENGKAP</th><th width=160>KANTOR PERWAKILAN</th><th>JABATAN</th><th width=70>TGL BERLAKU</th><th width=30>D</th><th width=30>K</th><th width=30>KSIE</th></th><th width=55>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];

	if (isset($_GET[namadiplomat])){
	 $tampil=mysql_query("select a.ID_CARD,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.PEKERJAAN, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD, a.ST_KARTU,a.ST_KARTU_K,a.ST_KARTU_KAS  from v_id_card a right join v_diplomat c on a.id_diplomat=c.id_diplomat where c.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' order by a.id_card desc limit $posisi,$batas");
	}
	else
    {$tampil=mysql_query("select a.ID_CARD,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.PEKERJAAN, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD, a.ST_KARTU,a.ST_KARTU_K,a.ST_KARTU_KAS  from v_id_card a right join v_diplomat c on a.id_diplomat=c.id_diplomat order by a.id_card desc limit $posisi,$batas");
	}
   
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

      echo "<tr><td>$no</td>
                <td><a href=?module=idcard&act=lihat_id_card&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[ID_CARD]</a></td>
				<td><a href=?module=diplomat&act=viewdiplomat&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NM_DIPLOMAT]</a></td>
                <td>$r[NM_KNT_PERWAKILAN]</td>
				<td>$r[PEKERJAAN]</td>		
				<td>$r[TGL_AKHIR_CARD] - $r[TGL_AWAL_CARD]</td>	
					<td align =center>";
		
		if(isset($r[ST_KARTU])){
			if ($r[ST_KARTU] == 2){
				
				echo "<div style=\"color : green\"> <b>A</b> </div>";
			}elseif ($r[ST_KARTU] == 1){
				echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
			}elseif ($r[ST_KARTU] == 0){
				echo "<div style=\"color : #800000\"> <b>R</b> </div>";
			}
		}else{
				echo "-";
		
		}
		
		echo "</td><td align =center>";

		if(isset($r[ST_KARTU_K])){
			if ($r[ST_KARTU_K] == 2){
				
				echo "<div style=\"color : green\"> <b>A</b> </div>";
			}elseif ($r[ST_KARTU_K] == 1){
				echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
			}elseif ($r[ST_KARTU_K] == 0){
				echo "<div style=\"color : #800000\"> <b>R</b> </div>";
			}
		}else{
				echo "-";
		
		}
		
		
		echo "</td><td align =center>";

		if(isset($r[ST_KARTU_KAS])){
			if ($r[ST_KARTU_KAS] == 2){
				
				echo "<div style=\"color : green\"> <b>A</b> </div>";
			}elseif ($r[ST_KARTU_KAS] == 1){
				echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
			}elseif ($r[ST_KARTU_KAS] == 0){
				echo "<div style=\"color : #800000\"> <b>R</b> </div>";
			}
		}else{
				echo "-";
		
		}
		
		
		echo "</td>
					
				<td><a href=?module=idcard&act=lihat_id_card&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>Lihat ID Card</a></td>
		        </tr>";
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

   $ilink = "?module=idcard&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]"; 
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
		/* dw dari sudah ke belum menikah @_@ */
		if ($r[ST_SIPIL]=='s'){
		echo "Belum Menikah";} else{
		echo "Sudah Menikah";}
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
     
	 

  case "lihat_id_card":
	$idt = $_GET[idt];
    $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >ID Card - Lihat</h2>";
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
		/* dw dari sudah ke belum menikah @_@ */
		if ($r[ST_SIPIL]=='s'){
		echo "Belum Menikah";} else{
		echo "Sudah Menikah";}
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

/* dw --
$tampil=mysql_query("select ID_PERMIT,ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,date_format(TGL_AGENDA,'%d.%m.%Y') as  TGL_AGENDA,NO_IZIN_PERMIT,date_format(TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT,date_format(TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,KET ,NM_JNS_PERMIT,KD_JNS_PERMIT,NM_DIPLOMAT,ST_PERMIT,ST_PERMIT_K,ST_PERMIT_KAS from v_stay_permit where ID_DIPLOMAT = $idt order by  TGL_AKHIR_PERMIT desc limit 0,1");

$r = mysql_fetch_array($tampil);


if (($r[ST_PERMIT_K] == 2) and ($r[ST_PERMIT_KAS] == 2)) {
	echo " <form method=POST enctype='multipart/form-data' action='./report.php?go=card' >
         
		 <input type=hidden name=idt value='$idt'>
        <input type=button value='Tambah' onclick=location.href='?module=idcard&act=tambah_id_card&idt=$idt&negara=$_GET[negara]'>";
*/

/* dw: nomor permit belum ada, tidak bisa mencetak dan menambah id card */
/*if ( $det[NO_IZIN_PERMIT]==NULL) { */

$tampil=mysql_query("select ID_CETAK,ID_DIPLOMAT,ID_JNS_CETAK_KARTU,ID_CARD,TGL_AWAL_CARD,TGL_AKHIR_CARD,COUNTER_CETAK, NM_JNS_CETAK_KARTU,NM_DIPLOMAT, ST_KARTU,ST_KARTU_K,ST_KARTU_KAS  from  v_id_card where ID_DIPLOMAT = $idt order by  TGL_AKHIR_CARD desc limit 0,1 ");

	$r=mysql_fetch_array($tampil);
		if(($r[ST_KARTU_KAS] == 2) and ($r[ST_KARTU_K] == 2)) {
			
		echo " <form method=POST enctype='multipart/form-data' action='./report.php?go=card' >
         
		 <input type=hidden name=idt value='$idt'>
        <input type=radio name='warna' value=merah checked><font color = \"red\"> <b>Merah</b> </font> <input type=radio name='warna' value=kuning ><font color = \"yellow\"> <b>Kuning</b> </font> <input type=radio name='warna' value=hijau ><font color = \"Green\"> <b>Hijau</b> </font>
		 <input type=radio name='warna' value=biru ><font color = \"Blue\"> <b>Biru</b> </font>
		 <input type=radio name='warna' value=oranye ><font color = \"Orange\"> <b>Oranye</b> </font>
		  <input type=radio name='warna' value=putih ><font color = \"Black\"> <b>Putih</b> </font>
		  
		  <DIV id=\"tgl\"> <script>DateInput('TGL_CETAK', true, 'YYYY-MM-DD')</script></div>
		  <input type=radio name='opsi' checked=checked value=A4 ><font> <b>A4</b> </font>
		  <input type=radio name='opsi' value=kartu ><font> <b>Kartu</b> </font>
		   
		  <input type=submit value='Cetak' onclick=location.href='./report.php?go=card&idt=$idt&warna=$warna' target=\"_blank\">
		  <input type=button value='Tambah' onclick=location.href='?module=idcard&act=tambah_id_card&idt=$idt&negara=$_GET[negara]'>";
		}
		else
		{
		echo "<input type=radio name='warna' value=merah checked><font color = \"red\"> <b>Merah</b> </font> <input type=radio name='warna' value=kuning ><font color = \"yellow\"> <b>Kuning</b> </font> <input type=radio name='warna' value=hijau ><font color = \"Green\"> <b>Hijau</b> </font>
		 <input type=radio name='warna' value=biru ><font color = \"Blue\"> <b>Biru</b> </font>
		 <input type=radio name='warna' value=oranye ><font color = \"Orange\"> <b>Oranye</b> </font>
		  <input type=radio name='warna' value=putih ><font color = \"Black\"> <b>Putih</b> </font>
		  
		  <DIV id=\"tgl\"> <script>DateInput('TGL_CETAK', true, 'YYYY-MM-DD')</script></div>
		  <input type=radio name='opsi' checked=checked value=A4 ><font> <b>A4</b> </font>
		  <input type=radio name='opsi' value=kartu ><font> <b>Kartu</b> </font>
		   
		  <input type=submit value='Cetak' onClick=\"return alert('Cetak ID Card Gagal. Permit harus disetujui oleh KASIE dan KASUBDIT')\">
		  <input type=button value='Tambah' onclick=location.href='?module=idcard&act=tambah_id_card&idt=$idt&negara=$_GET[negara]'>
		  
		
        
		 
		</form>";
		}
/* dw tutup no permit }  */
/* dw }*/
		echo "
		<table width=100%>
		   <tr><th  width=30>no</th><th>Alasan Cetak</th><th >ID Card</th><th width=70>Tanggal Awal</th><th width=70>Tanggal Akhir</th><th width=70>Counter Cetak</th><th width=30>D</th><th width=30>K</th><th width=30>KSIE</th><th width=60>AKSI</th></tr>"; 

    $p      = new Paging;
    $batas  = 200;
    $posisi = $p->cariPosisi($batas);

    $tampil=mysql_query("select ID_CETAK,ID_DIPLOMAT,ID_JNS_CETAK_KARTU,ID_CARD,TGL_AWAL_CARD,TGL_AKHIR_CARD,COUNTER_CETAK, NM_JNS_CETAK_KARTU,NM_DIPLOMAT, ST_KARTU,ST_KARTU_K,ST_KARTU_KAS  from  v_id_card where ID_DIPLOMAT = $idt order by  ID_CETAK ");

	$no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      echo "<tr><td>$no</td>
                <td>$r[NM_JNS_CETAK_KARTU]</td>
				<td>$r[ID_CARD]</td>
				<td>$r[TGL_AWAL_CARD]</td>
				<td>$r[TGL_AKHIR_CARD]</td>
				<td align =center>$r[COUNTER_CETAK]</td>
			<td align =center>";
		
		if ($r[ST_KARTU] == 2){
			
			echo "<div style=\"color : green\"> <b>A</b> </div>";
		}elseif ($r[ST_KARTU] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
		}elseif ($r[ST_KARTU] == 0){
		
			echo "<div style=\"color : #800000\"> <b>R</b> </div>";
		}
		
		echo "</td><td align =center>";

	if ($r[ST_KARTU_K] == 2){
			
			echo "<div style=\"color : green\"> <b>A</b> </div>";
		}elseif ($r[ST_KARTU_K] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
		}elseif ($r[ST_KARTU_K] == 0){
		
			echo "<div style=\"color : #800000\"> <b>R</b> </div>";
		}
		
		echo "</td><td align =center>";

	if ($r[ST_KARTU_KAS] == 2){
			
			echo "<div style=\"color : green\"> <b>A</b> </div>";
		}elseif ($r[ST_KARTU_KAS] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
		}elseif ($r[ST_KARTU_KAS] == 0){
		
			echo "<div style=\"color : #800000\"> <b>R</b> </div>";
		}
		
		echo "</td>
					
				<td><a href=?module=idcard&act=edit_id_card&idt=$r[ID_CETAK]&idd=$idt&negara=$_GET[negara]>Edit</a> | 
		            <a href=./aksi_id_card.php?module=idcard&act=hapus&idt=$r[ID_CETAK]&idd=$idt&negara=$_GET[negara] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus ID Card $r[ID_CETAK]?')\">Hapus</a></td>
				</tr>";

      $no++;
    }
    echo "</table>";

				 
	break;
	
 case "tambah_id_card":
	$idt = $_GET[idt];
 $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >ID Card - Tambah</h2>";
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
		/* dw dari sudah ke belum menikah @_@ */
		if ($r[ST_SIPIL]=='s'){
		echo "Belum Menikah";} else{
		echo "Sudah Menikah";}
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


	echo "<form method=POST enctype='multipart/form-data' action='./aksi_id_card.php?module=idcard&act=input&negara=$_GET[negara]'>
          <input type=hidden name=ID_DIPLOMAT value='$r[ID_DIPLOMAT]'>
		  <table width=100%>		  		 
		  <tr><td  width=120>Jenis Cetak Kartu</td>  <td > : 
          <select name='ID_JNS_CETAK_KARTU'>
			<option value=0 selected>- Not Defined -</option>";
             $tampil=mysql_query("SELECT ID_JNS_CETAK_KARTU,NM_JNS_CETAK_KARTU FROM m_jns_cetak_kartu ORDER BY ID_JNS_CETAK_KARTU");
            while($w=mysql_fetch_array($tampil)){
				echo "<option value=$w[ID_JNS_CETAK_KARTU]>$w[NM_JNS_CETAK_KARTU]</option>";
			
			}  

    echo "</select></td>
        <tr><td>No ID Card</td>     <td> : <input type=text name='ID_CARD' size=50  ></td></tr>
		<tr><td>Tanggal Awal Card</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AWAL_CARD', true, 'YYYY-MM-DD')</script></div></td></tr>
		<tr><td>Tanggal Akhir Card</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR_CARD', true, 'YYYY-MM-DD')</script></div></td></tr>
		<tr><td>Counter Cetak</td>     <td> : <input type=text name='COUNTER_CETAK' size=100  ></td></tr>
		<tr><td colspan=2 align=right><input type=submit value=Simpan>
              <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table></form>";
 break;
 case "edit_id_card":
	$idt = $_GET[idt];
	$idd = $_GET[idd];

   $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idd  ");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >ID Card - Edit</h2>";
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
		/* dw dari sudah ke belum menikah @_@ */
		if ($r[ST_SIPIL]=='s'){
		echo "Belum Menikah";} else{
		echo "Sudah Menikah";}
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


	$edit = mysql_query("select  ID_CETAK,ID_DIPLOMAT,ID_JNS_CETAK_KARTU,ID_CARD,TGL_AWAL_CARD,TGL_AKHIR_CARD,COUNTER_CETAK from cetak_kartu_diplomat where ID_CETAK = $idt ");   
	
	$r    = mysql_fetch_array($edit);

	echo "<form method=POST enctype='multipart/form-data' action='./aksi_id_card.php?module=idcard&act=update&idt=$idt&negara=$_GET[negara]'>
          <input type=hidden name=ID_DIPLOMAT value='$r[ID_DIPLOMAT]'>
			<input type=hidden name=ID_CETAK value='$r[ID_CETAK]'>

		  <table width=100%>
		  		 
		  <tr><td  width=120>Jenis Cetak Kartu</td>  <td > : 
          <select name='ID_JNS_CETAK_KARTU'>
			<option value=0 selected>- Not Defined -</option>";
           $tampil=mysql_query("SELECT ID_JNS_CETAK_KARTU,NM_JNS_CETAK_KARTU FROM m_jns_cetak_kartu ORDER BY ID_JNS_CETAK_KARTU");
            
			 while($w=mysql_fetch_array($tampil)){
			if ($r[ID_JNS_CETAK_KARTU]==$w[ID_JNS_CETAK_KARTU]){
				echo "<option value=$w[ID_JNS_CETAK_KARTU] selected>$w[NM_JNS_CETAK_KARTU]</option>";
			}
			else{
				echo "<option value=$w[ID_JNS_CETAK_KARTU]>$w[NM_JNS_CETAK_KARTU]</option>";
			}
			}  

    echo "</select></td>
        <tr><td>No ID Card</td>     <td> : <input type=text name='ID_CARD' size=50  value='$r[ID_CARD]'  ></td></tr>
		<tr><td>Tanggal Awal Card</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AWAL_CARD', true, 'YYYY-MM-DD','$r[TGL_AWAL_CARD]')</script></div></td></tr>
		<tr><td>Tanggal Akhir Card</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR_CARD', true, 'YYYY-MM-DD','$r[TGL_AKHIR_CARD]')</script></div></td></tr>
		<tr><td>Counter Cetak</td>     <td> : <input type=text name='COUNTER_CETAK' size=100  value= '$r[COUNTER_CETAK]' ></td></tr>
		<tr><td colspan=2 align=right><input type=submit value=Simpan>
              <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table></form>";

	
 break;
  case "cari":
    $alf = $_GET[huruf];
	  



	  echo "<br><br><a style=\"font-size: 22pt;\">$alf</a>";
	echo "<h2>ID Card - Pilih Negara</h2>
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
				&nbsp <a href=?module=idcard=$r[NEGARA]>$r[NEGARA] </a></td><td>";
		
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
