<?php
   echo "<br><a href=?module=diplomat&act=cari&huruf=A>A</A> |	<a href=?module=diplomat&act=cari&huruf=B>B</A> |	<a href=?module=diplomat&act=cari&huruf=C>C</A> |	<a href=?module=diplomat&act=cari&huruf=D>D</A> |	<a href=?module=diplomat&act=cari&huruf=E>E</A> |	<a href=?module=diplomat&act=cari&huruf=F>F</A> |	<a href=?module=diplomat&act=cari&huruf=G>G</A> |	<a href=?module=diplomat&act=cari&huruf=H>H</A> |	<a href=?module=diplomat&act=cari&huruf=I>I</A> |	<a href=?module=diplomat&act=cari&huruf=J>J</A> |	<a href=?module=diplomat&act=cari&huruf=K>K</A> |	<a href=?module=diplomat&act=cari&huruf=L>L</A> |	<a href=?module=diplomat&act=cari&huruf=M>M</A> |	<a href=?module=diplomat&act=cari&huruf=N>N</A> |	<a href=?module=diplomat&act=cari&huruf=O>O</A> |	<a href=?module=diplomat&act=cari&huruf=P>P</A> |	<a href=?module=diplomat&act=cari&huruf=Q>Q</A> |	<a href=?module=diplomat&act=cari&huruf=R>R</A> |	<a href=?module=diplomat&act=cari&huruf=S>S</A> |	<a href=?module=diplomat&act=cari&huruf=T>T</A> |	<a href=?module=diplomat&act=cari&huruf=U>U</A> |	<a href=?module=diplomat&act=cari&huruf=V>V</A> |	<a href=?module=diplomat&act=cari&huruf=W>W</A> |	<a href=?module=diplomat&act=cari&huruf=X>X</A> |	<a href=?module=diplomat&act=cari&huruf=Y>Y</A> |	<a href=?module=diplomat&act=cari&huruf=Z>Z</A>";
    

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
		echo "<h2>Diplomat - $negaranya</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='diplomat'>
				 <input type=hidden name=negara value='$_GET[negara]'>
			Nama Diplomat : <input type=text name=\"namadiplomat\"> <input type=submit value=Cari>
			</form> <br>
          <input type=button value='Tambah' onclick=location.href='?module=diplomat&act=tambahdiplomat&negara=$_GET[negara]'>
          <table width=100%>
          <tr><th width=30>no</th><th >NAMA LENGKAP</th><th width=170>KANTOR PERWAKILAN</th><th width=200>JABATAN</th><th width=70>TGL TIBA</th><th width=60>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];
	//if (!empty($neg)){
		//$conj = "and negara like '".$neg."%' ";
	//} else { $conj=""; }
	if (isset($_GET[namadiplomat])){
		$sql="SELECT  ID_DIPLOMAT,NM_DIPLOMAT,NM_KNT_PERWAKILAN,PEKERJAAN,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_diplomat where (ID_DIPLOMAT > 1) and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' and negara like '".$neg."%' order by ID_DIPLOMAT desc limit $posisi,$batas";
//echo $sql;
		$tampil=mysql_query($sql);
	 //$tampil=mysql_query("SELECT  ID_DIPLOMAT,NM_DIPLOMAT,NM_KNT_PERWAKILAN,PEKERJAAN,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_diplomat where negara like '".$neg."%' and (ID_DIPLOMAT > 1) and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' order by NM_KNT_PERWAKILAN, NM_DIPLOMAT limit $posisi,$batas");

	}
	else
    {
		//print_r('ok');
    //$tampil=mysql_query("SELECT  ID_DIPLOMAT,NM_DIPLOMAT,NM_KNT_PERWAKILAN,PEKERJAAN,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_diplomat where negara like '".$neg."%'   and (ID_DIPLOMAT > 1) order by NM_KNT_PERWAKILAN,NM_DIPLOMAT limit $posisi,$batas");
    $tampil=mysql_query("SELECT  ID_DIPLOMAT,NM_DIPLOMAT,NM_KNT_PERWAKILAN,PEKERJAAN,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_diplomat where negara like '".$neg."%' and (ID_DIPLOMAT > 1) order by ID_DIPLOMAT desc limit $posisi,$batas");
	$ko = "SELECT  ID_DIPLOMAT,NM_DIPLOMAT,NM_KNT_PERWAKILAN,PEKERJAAN,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_diplomat where negara like '".$neg."%'   and (ID_DIPLOMAT > 1) order by ID_DIPLOMAT desc limit $posisi,$batas";
	//print_r($ko);
	}
	$level = $_SESSION[G_leveluser];
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
	
      echo "<tr><td>$no</td>
                <td><a href=?module=diplomat&act=viewdiplomat&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NM_DIPLOMAT]</a></td>
                <td>$r[NM_KNT_PERWAKILAN]</td>
				<td>$r[PEKERJAAN]</td>		
				<td>$r[TGL_TIBA]</td>";
				if($level != '99'){
					echo "<td><a href=?module=diplomat&act=editdiplomat&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>Edit</a> 
					<!--|<a href=./aksi.php?module=diplomat&act=hapus&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NM_DIPLOMAT]?')\">Hapus</a>--></td>";
				}			
		        echo "</tr>";
      $no++;
    }
    echo "</table>";
	
	if (isset($_GET[namadiplomat]))
	{
		$jmldata =mysql_num_rows(mysql_query("SELECT ID_DIPLOMAT,NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN,PEKERJAAN FROM  v_diplomat where negara like '".$neg."%'  and (ID_DIPLOMAT > 1) and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' "));
	}else{
		$jmldata =mysql_num_rows(mysql_query("SELECT ID_DIPLOMAT,NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN,PEKERJAAN FROM  v_diplomat where negara like '".$neg."%' and (ID_DIPLOMAT > 1) "));
	}
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   $ilink = "?module=diplomat&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;


  case "viewdiplomat":
	$idt = $_GET[idt];
	$sql="select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA,NO_SR_SETNEG,ID_RANK,LAMA_BERDIAM_BLN,TELP,FOTO_TTD,GELAR, b.NAMA_KATEGORI  from diplomat a, m_kategori_pemohon b where a.KATEGORI_PEMOHON=b.ID_KATEGORI_PEMOHON and  ID_DIPLOMAT = $idt";
//  echo $sql;
  $edit = mysql_query($sql);
     $r    = mysql_fetch_array($edit);

	     echo "<h2>View Diplomat</h2>          
		  <table width=100%>
          <tr><td  width=70>Kewarganegaraan</td>  <td > : ";
            $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
            $w=mysql_fetch_array($tampil);		
			
	$detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idt)");	
	$det    = mysql_fetch_array($detil);

    echo "$w[NEGARA] </td><td rowspan=\"21\"  width=200 ><div align=center><img src=\"../foto/$r[FOTO]\" width=110 height=150 border=1><br/> <img src=\"../foto/ttd/$r[FOTO_TTD]\" width=110 height=100% border=1> </div>
	<br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku : $det[TGL_AWAL_CARD] / $det[TGL_AKHIR_CARD]<br><br>";

	//$detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");	
	$sql="select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT,date_format(a.TGL_AWAL_PERMIT,'%d.%m.%Y') as  TGL_AWAL_PERMIT from v_stay_permit a where a.id_diplomat = $idt  and ((a.TGL_AKHIR_PERMIT >= now()))"; // and (a.TGL_AWAL_PERMIT >= now())
	//echo $sql;
	$detil = mysql_query($sql);	

	echo "<b>Permit </b><br>";

	while($det=mysql_fetch_array($detil)){
				echo "No Permit :  $det[KD_JNS_PERMIT] / $det[NO_IZIN_PERMIT]  <br> Berlaku :  $det[TGL_AWAL_PERMIT] / $det[TGL_AKHIR_PERMIT]  <br><br> ";				
			}  


	$detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");	
	$det    = mysql_fetch_array($detil);
	
	echo "<br><b>Sibling </b><br>";
	$nosib = 1;
	   $detil=mysql_query("select  NM_SIBLING,NM_JNS_RELASI from v_sibling where ID_DIPLOMAT = $idt order by ID_JNS_RELASI");
            while($det=mysql_fetch_array($detil)){
				echo "$nosib. $det[NM_SIBLING] - $det[NM_JNS_RELASI] <br>";
				$nosib=$nosib+1;
			}  
	
	
	echo "<br/><b>Pengajuan Pajak</b><br>";
	$nopjk = 1;
	   $pajak = mysql_query("select a.id_pajak, a.kd_pajak, jenis_permohonan, status_pengambilan, b.status_dari_subdit, b.sum_jml_transaksi from v_r_permohonan_pajak_dan_atributnya_new_plus_tolak a LEFT JOIN v_r_jml_transaksi_per_pengajuan b on a.id_pajak = b.id_pajak
where a.id_diplomat = $idt and (b.status_dari_subdit = 'Setuju' or b.status_dari_subdit = 'Tolak') order by a.id_pajak desc;");	
            while($pjk=mysql_fetch_array($pajak)){
				$sts = '';
				if($pjk[status_dari_subdit] == 'Setuju'){
					$sts = 'Disetujui';
				}elseif ($pjk[status_dari_subdit] == 'Tolak'){
					$sts = 'Ditolak';
				}
				$uang = number_format($pjk[sum_jml_transaksi],2);
				echo "$nopjk. $pjk[jenis_permohonan] - $pjk[kd_pajak]<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rp. $uang - $sts <br>";
				$nopjk=$nopjk+1;
			}  	


	echo "<br><b>Rantor</b><br>";
	//$nosib = 1;
	  // $detil=mysql_query("select JNS_FASILITAS from v_fasilitas_lain where ID_DIPLOMAT= $idt and ST_PERSETUJUAN=2 order by JNS_FASILITAS ");
           // while($det=mysql_fetch_array($detil)){
				//echo "$nosib. $det[JNS_FASILITAS] <br>";
				//$nosib=$nosib+1;
			//}  
	echo "<br><b>Importasi Barang</b><br>";

	echo "</td>
		<tr><td>Kategori Pemohon</td>     <td width=400> : $r[NAMA_KATEGORI]</td></tr> 
		<tr><td>Nama Diplomat</td>     <td> : $r[NM_DIPLOMAT]</td></tr> 
		<tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : ";
		if ($r[JK]=='l'){
		echo "Laki-laki";}else
		{echo "Perempuan";	}
		echo "</td> </tr>
		<tr><td>Jabatan</td >  <td > : ".ucfirst(strtolower($r['PEKERJAAN']))."</td></tr>";
 $tampil=mysql_query("SELECT NM_RANK,KODE_LAYANAN,KET FROM rank where ID_RANK = $r[ID_RANK]");
	//echo "<tr><td>Gelar</td >  <td > : $r[GELAR] </td></tr>";
          
			$w=mysql_fetch_array($tampil);
	echo "<tr><td>Rank</td >  <td > : $w[NM_RANK] - $w[KODE_LAYANAN] - $w[KET]</td></tr>";
	echo"	<tr><td>Status Sipil</td>     <td  > : "; 
		
		if ($r[ST_SIPIL]=='s'){
		echo "Belum Menikah";} else{
		echo "Sudah Menikah";}
		echo "</td></tr>
		
		<tr><td>Jenis / No. Paspor</td >     <td > :  ";
            $tampil=mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");
          
			$w=mysql_fetch_array($tampil);
    echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR]</td></tr>
		<tr><td>Tanggal mulai berlaku </td >     <td > : <!-- $r[PASPOR_OLEH]  - -->   $r[PASPOR_TGL] </td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[AKHIR_BERLAKU]</td></tr>
		
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
		<tr><td>Diberikan oleh</td >     <td > : $r[VISA_OLEH]</td></tr>
		<tr><td>Lama berdiam di Indonesia</td >     <td > : $r[LAMA_BERDIAM] tahun &nbsp $r[LAMA_BERDIAM_BLN] bulan </td></tr>
		<tr><td>Tanggal tiba</td >     <td > : $r[TGL_TIBA]</td></tr>

		<tr><td>Alamat Indonesia</td >     <td > : $r[ALAMATIN]</textarea></td></tr>
			<tr><td>Telepon</td >     <td > : $r[TELP]</td></tr>
		<tr><td>Dipekerjakan pada</td >     <td >  : ";
            $tampil=mysql_query("SELECT ID_KNT_PERWAKILAN,NM_KNT_PERWAKILAN  FROM m_kantor_perwakilan where ID_KNT_PERWAKILAN = $r[ID_KNT_PERWAKILAN]");
            $w=mysql_fetch_array($tampil);

    echo "$w[NM_KNT_PERWAKILAN] </td></tr>
		<tr><td>No SP SETNEG</td >     <td > : $r[NO_SETKAB]</td></tr>
		<tr><td>No SR SETNEG</td >     <td > : $r[NO_SR_SETNEG]</td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[BERLAKUSD]</td></tr>
		<tr><td>No. Surat Sponsor</td >     <td > : $r[NO_SPONSOR]</tr>
		<tr><td colspan=3 align=right>
        <input type=button value=Kembali onclick=self.history.back()></td></tr>
        </table></form>";
     
	 
//data sibling
	  break;
  case "tambahdiplomat":
    echo "<h2>Tambah Diplomat</h2>
          <form method=POST action='./aksi.php?module=diplomat&act=input&negara=$_GET[negara]' enctype='multipart/form-data'>
          <table width=100%>
          <tr><td  width=120>Kewarganegaraan &nbsp; <font color='red'>*</font> </td>  <td colspan=\"2\"> : 
          <select name='ID_NEGARA' onChange='javascript:dinamisKantor(this)'>
            <option value=0 selected>- Not Defined -</option>";
            $tampil=mysql_query("SELECT * FROM m_negara where id_negara > 1 ORDER BY negara");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_NEGARA]>$r[NEGARA]</option>";
            }
    echo "</select></td>
			<tr><td>Dipekerjakan pada Perwakilan / Mission &nbsp; <font color='red'>*</font> </td >     <td colspan=\"2\"> <div id='tampilkantor'></div></td></tr>
			<tr><td>Kategori Pemohon &nbsp; <font color='red'>*</font> </td >     <td colspan=\"2\">
	          <select name='KATEGORI_PEMOHON'>
            <option value=0 selected>- Not Defined -</option>";		
	        $tampil=mysql_query("SELECT * FROM m_kategori_pemohon  where ID_KATEGORI_PEMOHON !=3 order by ID_KATEGORI_PEMOHON asc");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_KATEGORI_PEMOHON]>$r[NAMA_KATEGORI]</option>";
            }

			echo "</select></td></tr>";

		echo "<tr><td>Nama Diplomat &nbsp; <font color='red'>*</font> </td>     <td> : <input type=text name='NM_DIPLOMAT' size=50></td><td rowspan=\"5\"  width=120 align=center><img src=\"\" width=110 height=150 border=1></td></tr>
 
		<tr><td>Tempat Lahir &nbsp; <font color='red'>*</font> </td>     <td> : <input type=text name='TEMPAT_LAHIR' size=50></td></tr>
			<tr><td>Tanggal Lahir &nbsp; <font color='red'>*</font> </td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_LAHIR', true, 'YYYY-MM-DD')</script></div>
		</td></tr>
		<tr><td>Jenis Kelamin &nbsp; <font color='red'>*</font> </td>     <td> : <input type=radio name='JK' value=l checked>L <input type=radio name='JK' value=p >P </td> </tr>
		<tr><td>Foto &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 name=fupload></td></tr>		
		<tr><td>Tanda tangan &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 name=fuploadttd></td>
    <td rowspan=\"3\"  width=120 align=center><img src=\".\" width=110 height=100% border=1></td>
    </tr>
		<tr><td>Jabatan</td >     <td > : <input type=text name='PEKERJAAN' size=50><input type=hidden name='GELAR' size=50></td></tr>
		<!--<tr><td>Gelar</td >     <td > : <input type=text name='GELAR' size=50></td></tr>-->
		<tr><td>Rank / Gelar 	&nbsp; <font color='red'>*</font> </td >     <td > :  <select name='ID_RANK'>";

            $tampil=mysql_query("SELECT NM_RANK,KODE_LAYANAN,KET,ID_RANK FROM rank ORDER BY NM_RANK");
            $ai = 1;
			while($r=mysql_fetch_array($tampil)){
              if ($ai==1){
			  echo "<option value=$r[ID_RANK] selected>$r[NM_RANK] - $r[KODE_LAYANAN] - $r[KET]</option>";
			  }else{
			  echo "<option value=$r[ID_RANK] >$r[NM_RANK] - $r[KODE_LAYANAN] - $r[KET]</option>";
			  }
			  $ai=0;
			}

    echo "</select> </td></tr>

<!--		<tr><td>Alamat di Luar Negeri </td>     <td colspan=\"2\"> : </td></tr>-->
		<tr><td>Status Sipil &nbsp; <font color='red'>*</font> </td>     <td colspan=\"2\"> : <textarea name='ALAMATLN' style='display:none;' rows=2 cols=55 ></textarea> <input type=radio name='ST_SIPIL' value=s checked>Single <input type=radio name='ST_SIPIL' value=m >Married </td></tr>
		
		<tr><td>Jenis / No. Paspor &nbsp; <font color='red'>*</font> </td >     <td colspan=\"2\"> :  <select name='ID_JNS_PASPOR' >
            <option value=1 selected>- Not Defined -</option>";
            $tampil=mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR > 1 ORDER BY JNS_PASPOR");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_JNS_PASPOR]>$r[JNS_PASPOR]</option>";
            }

    echo "</select> <input type=text name='NO_PASPOR' size=50></td></tr>
		<tr><td>Tanggal Mulai Berlaku</td >     <td colspan=\"2\"> <DIV id=\"tgl\"> <script>DateInput('PASPOR_TGL', true, 'YYYY-MM-DD')</script></div> <input type=hidden name='PASPOR_OLEH' size=50></td></tr>
		<tr><td>Berlaku s/d</td >     <td colspan=\"2\"> <DIV id=\"tgl\"> <script>DateInput('AKHIR_BERLAKU', true, 'YYYY-MM-DD')</script></div></td></tr>
		
		<tr><td>Jenis / No. Visa / Status &nbsp; <font color='red'>*</font> </td >     <td colspan=\"2\"> : <select name='ID_JNS_VISA' >
            <option value=1 selected>- Not Defined -</option>";
            $tampil=mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA > 1 ORDER BY NM_JNS_VISA");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_JNS_VISA]>$r[NM_JNS_VISA]</option>";
            }

    echo "</select> &nbsp<input type=text name='NO_VISA' size=50> 
	<input type=radio name='ST_VISA' value=0 ><b style=\"color : #800000\">reject</b> 
	<input type=radio name='ST_VISA' value=1 checked><b style=\"color : #B1BF19\">waiting</b> 
	<input type=radio name='ST_VISA' value=2 ><b style=\"color : green\">approve</b> 
	</td></tr>
		<tr><td>Diberikan oleh</td >     <td colspan=\"2\"> : <input type=text name='VISA_OLEH' size=50></td></tr>
		<tr><td>Lama berdiam di Indonesia &nbsp; <font color='red'>*</font> </td >     <td colspan=\"2\"> : 
		<select name='LAMA_BERDIAM' >
			<option value=0 selected >0 tahun</option>
		  <option value=1 >1 tahun</option>
			<option value=2 >2 tahun</option>
			<option value=3 >3 tahun</option>		    
		</select> &nbsp 
    <select name='LAMA_BERDIAM_BLN' >
			<option value=0 selected >0 bulan</option>
		  <option value=1 >1 bulan</option>
			<option value=2 >2 bulan</option>
			<option value=3 >3 bulan</option>
      <option value=4 >4 bulan</option>
			<option value=5 >5 bulan</option>
			<option value=6 >6 bulan</option>
      <option value=7 >7 bulan</option>
			<option value=8 >8 bulan</option>
			<option value=9 >9 bulan</option>
      <option value=10 >10 bulan</option>
			<option value=11 >11 bulan</option>
		</select>
    </td></tr>
		<tr><td>Tanggal tiba</td >     <td colspan=\"2\"> <DIV id=\"tgl\"> <script>DateInput('TGL_TIBA', true, 'YYYY-MM-DD')</script></div></td></tr>

		<tr><td>Alamat Indonesia</td >     <td colspan=\"2\"> : <textarea name='ALAMATIN' rows=2 cols=55 ></textarea></td></tr>
		<tr><td>Telepon</td >     <td colspan=\"2\"> : <input type=text name='TELP' size=50></td></tr>
		
		<tr><td>No SP SETNEG</td >     <td colspan=\"2\"> : <input type=text name='NO_SETKAB' size=50></td></tr>
		<tr><td>No Nodin SETNEG</td >     <td colspan=\"2\"> : <input type=text name='NO_SR_SETNEG' size=50></td></tr>

		<tr><td>Berlaku s/d</td >     <td colspan=\"2\">  <DIV id=\"tgl\"> <script>DateInput('BERLAKUSD', true, 'YYYY-MM-DD')</script></div></td></tr>
		<tr><td>No. Surat Sponsor</td >     <td colspan=\"2\"> : <input type=text name='NO_SPONSOR' size=50></td></tr>

		<tr><td colspan=3 align=right><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
   
   case "editdiplomat":
    $idt = $_GET[idt];

	$edit = mysql_query("select TGL_CREDENTIAL,ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%Y-%m-%d') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%Y-%m-%d') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%Y-%m-%d') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%Y-%m-%d') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%Y-%m-%d') AS BERLAKUSD,NO_SPONSOR,ST_VISA,NO_SR_SETNEG,ID_RANK,LAMA_BERDIAM_BLN,TELP,FOTO_TTD,GELAR,b.* from diplomat a, m_kategori_pemohon b  where a.KATEGORI_PEMOHON=b.ID_KATEGORI_PEMOHON and ID_DIPLOMAT = $idt ");
    $r    = mysql_fetch_array($edit);

    if($_SESSION[G_leveluser]=='20'){
        $r1 = 'disabled';
		$warna = "bgcolor='ffcc00'";
    }
	     echo "<h2>Edit Diplomat</h2>
          <form method=POST enctype='multipart/form-data' action='./aksi.php?module=diplomat&act=update&idb=$_GET[idb]&negara=$_GET[negara]'>
         <input type=hidden name=idt value='$r[ID_DIPLOMAT]'>

		  <table width=100%>
          <tr><td  width=120>Kewarganegaraan &nbsp; <font color='red'>*</font> </td>  <td colspan=\"2\"> :
          <select name='ID_NEGARA' $r1>";
            $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara ORDER BY ID_NEGARA");
            while($w=mysql_fetch_array($tampil)){
			if ($r[ID_NEGARA]==$w[ID_NEGARA]){
				echo "<option value=$w[ID_NEGARA] selected>$w[NEGARA]</option>";
			}
			else{
				echo "<option value=$w[ID_NEGARA]>$w[NEGARA]</option>";
			}
			}
		echo"<tr><td>Dipekerjakan pada &nbsp; <font color='red'>*</font> </td>     <td colspan=\"2\">  : <select name='ID_KNT_PERWAKILAN' $r1>";
            $tampil=mysql_query("SELECT ID_KNT_PERWAKILAN,NM_KNT_PERWAKILAN  FROM m_kantor_perwakilan where ID_KNT_PERWAKILAN > 1 ORDER BY NM_KNT_PERWAKILAN");
           while($w=mysql_fetch_array($tampil)){
			if ($r[ID_KNT_PERWAKILAN]==$w[ID_KNT_PERWAKILAN]){
				echo "<option value=$w[ID_KNT_PERWAKILAN] selected>$w[NM_KNT_PERWAKILAN]</option>";
			}
			else{
				echo "<option value=$w[ID_KNT_PERWAKILAN]>$w[NM_KNT_PERWAKILAN]</option>";
			}
			}

    echo "</select></td>
			<tr><td>Kategori Pemohon &nbsp; <font color='red'>*</font> </td>     <td colspan=\"2\"> :
	          <select name='KATEGORI_PEMOHON' $r1>
            <option value=$r[ID_KATEGORI_PEMOHON] selected>$r[NAMA_KATEGORI]</option>";
	        $tampil=mysql_query("SELECT * FROM m_kategori_pemohon  where ID_KATEGORI_PEMOHON !=3 order by ID_KATEGORI_PEMOHON asc");
            while($z=mysql_fetch_array($tampil)){
              echo "<option value=$z[ID_KATEGORI_PEMOHON]>$z[NAMA_KATEGORI]</option>";
            }

			echo "</select></td></tr>
		<tr>";?>
		<td>Nama Diplomat &nbsp; <font color='red'>*</font> </td>     <td> :
		<input type=text name='NM_DIPLOMAT' size=50 value= "<?php echo $r[NM_DIPLOMAT];?>" <?php echo $r1; ?>></td>
		<?php
		echo "
		<td rowspan=\"5\"  width=120 align=center><img src=\"../foto/$r[FOTO]\" width=110 height=150 border=1></td></tr>

		<tr><td>Tempat Lahir &nbsp; <font color='red'>*</font> </td>     <td> : <input type=text name='TEMPAT_LAHIR' size=50 value= '$r[TEMPAT_LAHIR]' $r1></td></tr>
			<tr><td>Tanggal Lahir &nbsp; <font color='red'>*</font> </td> <td> <DIV id=\"tgl\" class=\"tgl\"> <script>DateInput('TGL_LAHIR', true, 'YYYY-MM-DD','$r[TGL_LAHIR]')</script></div>
		</td></tr>
		<tr><td>Jenis Kelamin &nbsp; <font color='red'>*</font> </td>     <td> : ";

		if ($r[JK]=='l'){
		echo "<input type=radio name='JK' value=l checked $r1>L <input type=radio name='JK' value=p $r1>P ";}else
		{echo "<input type=radio name='JK' value=l $r1>L <input type=radio name='JK' value=p checked $r1>P ";	}

		echo "</td> </tr>
		<tr><td>Foto &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 name=fupload $r1></td></tr>
		<tr><td>Tanda tangan &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 name=fuploadttd $r1></td>
    <td rowspan=\"3\"  width=120 align=center><img src=\"../foto/ttd/$r[FOTO_TTD]\" width=110 height=100% border=1></td>
    </tr>

		<tr $warna><td>Jabatan</td >     <td> : <input type=text name='PEKERJAAN' size=50 value= '$r[PEKERJAAN]'></td>		</tr>
		<!--<tr><td>Gelar</td >     <td> : <input type=text name='GELAR' size=50 value= '$r[GELAR]' ></td>		</tr>-->


		<tr><td>Rank &nbsp; <font color='red'>*</font> </td >     <td > :  <input type=hidden name='GELAR' size=50 value= '$r[GELAR]' $r1>
		<select name='ID_RANK' $r1>";

            $tampil=mysql_query("SELECT NM_RANK,KODE_LAYANAN,KET,ID_RANK FROM rank ORDER BY NM_RANK");

			while($w=mysql_fetch_array($tampil)){

			  if ($r[ID_RANK]==$w[ID_RANK]){
			  echo "<option value=$w[ID_RANK] selected>$w[NM_RANK] - $w[KODE_LAYANAN] - $w[KET]</option>";
			  }else{
			  echo "<option value=$w[ID_RANK] >$w[NM_RANK] - $w[KODE_LAYANAN] - $w[KET]</option>";
			  }
			}

    echo "</select> </td></tr>

<!--		<tr><td>Alamat di Luar Negeri </td>     <td colspan=\"2\"> : <textarea name='ALAMATLN' rows=2 cols=55 >$r[ALAMATLN]</textarea></td></tr> -->
		<tr><td>Status Sipil &nbsp; <font color='red'>*</font> </td>     <td colspan=\"2\"> : <textarea style='display:none;' name='ALAMATLN' rows=2 cols=55 >$r[ALAMATLN]</textarea> ";

		if ($r[ST_SIPIL]=='s'){
		echo "<input type=radio name='ST_SIPIL' value=s checked $r1>Single <input type=radio name='ST_SIPIL' value=m $r1>Married";} else{
		echo "<input type=radio name='ST_SIPIL' value=s $r1>Single <input type=radio name='ST_SIPIL' value=m  checked $r1>Married ";}


		echo "</td></tr>
		<tr><td>Jenis / No. Paspor &nbsp; <font color='red'>*</font> </td >     <td colspan=\"2\"> :  <select name='ID_JNS_PASPOR' $r1>";
            $tampil=mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR > 1 ORDER BY JNS_PASPOR");

			while($w=mysql_fetch_array($tampil)){
			if ($r[ID_JNS_PASPOR]==$w[ID_JNS_PASPOR]){
				echo "<option value=$w[ID_JNS_PASPOR] selected>$w[JNS_PASPOR]</option>";
			}
			else{
				echo "<option value=$w[ID_JNS_PASPOR]>$w[JNS_PASPOR]</option>";
			}
			}

    echo "</select> <input type=text name='NO_PASPOR' size=50 value= '$r[NO_PASPOR]' $r1></td></tr>
		<tr><td>Tanggal Mulai Berlaku</td >     <td colspan=\"2\"> <DIV id=\"tgl\" class=\"tgl\"> <script>DateInput('PASPOR_TGL', true, 'YYYY-MM-DD','$r[PASPOR_TGL]')</script></div> <input type=hidden name='PASPOR_OLEH' size=50 value= '$r[PASPOR_OLEH]' ></td></tr>
		<tr><td>Berlaku s/d &nbsp; <font color='red'>*</font> </td >     <td colspan=\"2\"> <DIV id=\"tgl\" class=\"tgl\"> <script>DateInput('AKHIR_BERLAKU', true, 'YYYY-MM-DD','$r[AKHIR_BERLAKU]')</script></div></td></tr>

		<tr><td>Jenis / No. Visa / Status</td >     <td colspan=\"2\"><div class=\"sts\"> : <select name='ID_JNS_VISA' $r1>";
            $tampil=mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA > 1 ORDER BY NM_JNS_VISA");
           while($w=mysql_fetch_array($tampil)){
			if ($r[ID_JNS_VISA]==$w[ID_JNS_VISA]){
				echo "<option value=$w[ID_JNS_VISA] selected>$w[NM_JNS_VISA]</option>";
			}
			else{
				echo "<option value=$w[ID_JNS_VISA]>$w[NM_JNS_VISA]</option>";
			}
			}

    echo "</select> &nbsp<input type=text name='NO_VISA' size=50 value= '$r[NO_VISA]' $r1>
	<input type=radio name='ST_VISA' class='ST_VISA' value=0 ";
					if ($r[ST_VISA]== 0){ echo "checked";}
				echo "> <b style=\"color : #800000\">reject</b>	<input type=radio name='ST_VISA' class='ST_VISA' value=1";
					if ($r[ST_VISA]== 1){ echo "checked";}
				echo "> <b style=\"color : #B1BF19\">waiting</b> <input type=radio name='ST_VISA' class='ST_VISA' value=2";
					if ($r[ST_VISA]== 2){ echo "checked";}
				echo "> <b style=\"color : green\">approve</b></div>
	</td></tr>
		<tr><td>Diberikan oleh</td >     <td colspan=\"2\"> : <input type=text name='VISA_OLEH' size=50 value= '$r[VISA_OLEH]' $r1>
	    </td></tr>
		<tr><td>Lama berdiam di Indonesia &nbsp; <font color='red'>*</font> </td >     <td colspan=\"2\"> : <select name='LAMA_BERDIAM' $r1>
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
    <select name='LAMA_BERDIAM_BLN' $r1>
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
		</select>
			  </td></tr>
		<tr><td>Tanggal tiba</td >     <td colspan=\"2\"> <DIV id=\"tgl\" class=\"tgl\"> <script>DateInput('TGL_TIBA', true, 'YYYY-MM-DD','$r[TGL_TIBA]')</script></div></td></tr>

		<tr><td>Alamat Indonesia</td >     <td colspan=\"2\"> : <textarea name='ALAMATIN' rows=2 cols=55 $r1>$r[ALAMATIN]</textarea></td></tr>
		<tr><td>Telepon</td >     <td colspan=\"2\"> : <input type=text name='TELP' size=50 value= '$r[TELP]' $r1></td></tr>";

	//$TGL_CREDENTIAL = $r[TGL_CREDENTIAL];
	if($r[TGL_CREDENTIAL]){

    echo "</select> </td></tr>
		<tr><td>No SP SETNEG</td >     <td colspan=\"2\"> : <input type=text name='NO_SETKAB' size=50 value= '$r[NO_SETKAB]' $r1></td></tr>
		<tr><td>No Nodin SETNEG</td >     <td colspan=\"2\"> : <input type=text name='NO_SR_SETNEG' size=50 value= '$r[NO_SR_SETNEG]' $r1></td></tr>

		<tr><td>Berlaku s/d</td >     <td colspan=\"2\">  <DIV id=\"tgl\"> <script>DateInput('BERLAKUSD', true, 'YYYY-MM-DD','$r[BERLAKUSD]')</script></div></td></tr>
		<tr><td>No. Surat Sponsor</td >     <td colspan=\"2\"> : <input type=text name='NO_SPONSOR' size=50 value= '$r[NO_SPONSOR]' $r1></td></tr>
		<tr $warna><td>Tanggal Credential</td >     <td colspan=\"2\"> <DIV id=\"tgl\" class=\"tgl_creden\"> <script>DateInput('TGL_CREDENTIAL', true, 'YYYY-MM-DD','$r[TGL_CREDENTIAL]')</script></div></td></tr>

		<tr><td colspan=3 align=right><input type=submit value=Update>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table></form>";
    }else{
		$TGL_CREDENTIAL = '0000-00-00';

		echo "</select></td></tr>
		<tr>
      <td>No SP SETNEG</td>
      <td colspan=\"2\"> : <input type=text name='NO_SETKAB' size=50 value= '$r[NO_SETKAB]' $r1></td>
    </tr>
		<tr>
      <td>No Nodin SETNEG</td>
      <td colspan=\"2\"> : <input type=text name='NO_SR_SETNEG' size=50 value= '$r[NO_SR_SETNEG]' $r1></td></tr>
		<tr>
      <td>Berlaku s/d</td>
      <td colspan=\"2\">  <DIV id=\"tgl\" class=\"tgl\"> <script>DateInput('BERLAKUSD', true, 'YYYY-MM-DD','$r[BERLAKUSD]')</script></div></td></tr>
		<tr>
      <td>No. Surat Sponsor</td>
      <td colspan=\"2\"> : <input type=text name='NO_SPONSOR' size=50 value= '$r[NO_SPONSOR]' $r1></td></tr>";
      if ($r['ID_RANK']=='1'){
      echo "<tr $warna>
      <td>Tanggal Credential</td>
      <td colspan=\"2\"> <DIV id=\"tgl\" class=\"tgl_creden\"> <script>DateInput('TGL_CREDENTIAL', true, 'YYYY-MM-DD','$TGL_CREDENTIAL')</script></div></td>
    </tr>
    <tr $warna><td>DEAN</td>
      <td colspan=\"2\">: ";
		      if ($r[KET_DEAN]=='l'){
		          echo "<input type=radio name='DEAN' class='DEAN' value=l checked>Ya <input type=radio name='DEAN' value=0 >Tidak ";
          }else{
              echo "<input type=radio name='DEAN' class='DEAN' value=l >Ya <input type=radio name='DEAN' value=0 checked>Tidak ";
          }
		  echo "</td> </tr>";
    }

		echo "<tr><td colspan=3 align=right><input type=submit value=Update>
        <input type=button value=Batal onclick=self.history.back()></td></tr>

        </table></form>";
	}
		if($_SESSION[G_leveluser]=='20'){
				echo"
				<script>
					$('.tgl a').click(function(e) {
						e.preventDefault();
					});
					$('.ST_VISA').attr('disabled', true);
					$('.tgl :input').attr('disabled', true);
					$('.tgl :select').attr('disabled', true);
					
				  </script>
				";
			}else{
				echo"
				<script>
					$('.tgl_creden a').click(function(e) {
						e.preventDefault();
					});
					$('.DEAN').attr('disabled', true);
					$('.tgl_creden :input').attr('disabled', true);
					$('.tgl_creden :select').attr('disabled', true);
					  </script>
				";
			}

	 break;  


  case "cari":
    $alf = $_GET[huruf];
	  
    echo "<br><br><a style=\"font-size: 22pt;\">$alf</a>";
	echo "<h2>Diplomat List</h2>
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
				&nbsp <a href=?module=diplomat&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";
		
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
