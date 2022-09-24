<?php
	   //echo "<br><a href=?module=staypermitK&act=cari&huruf=A>A</A> |	<a href=?module=staypermitK&act=cari&huruf=B>B</A> |	<a href=?module=staypermitK&act=cari&huruf=C>C</A> |	<a href=?module=staypermitK&act=cari&huruf=D>D</A> |	<a href=?module=staypermitK&act=cari&huruf=E>E</A> |	<a href=?module=staypermitK&act=cari&huruf=F>F</A> |	<a href=?module=staypermitK&act=cari&huruf=G>G</A> |	<a href=?module=staypermitK&act=cari&huruf=H>H</A> |	<a href=?module=staypermitK&act=cari&huruf=I>I</A> |	<a href=?module=staypermitK&act=cari&huruf=J>J</A> |	<a href=?module=staypermitK&act=cari&huruf=K>K</A> |	<a href=?module=staypermitK&act=cari&huruf=L>L</A> |	<a href=?module=staypermitK&act=cari&huruf=M>M</A> |	<a href=?module=staypermitK&act=cari&huruf=N>N</A> |	<a href=?module=staypermitK&act=cari&huruf=O>O</A> |	<a href=?module=staypermitK&act=cari&huruf=P>P</A> |	<a href=?module=staypermitK&act=cari&huruf=Q>Q</A> |	<a href=?module=staypermitK&act=cari&huruf=R>R</A> |	<a href=?module=staypermitK&act=cari&huruf=S>S</A> |	<a href=?module=staypermitK&act=cari&huruf=T>T</A> |	<a href=?module=staypermitK&act=cari&huruf=U>U</A> |	<a href=?module=staypermitK&act=cari&huruf=V>V</A> |	<a href=?module=staypermitK&act=cari&huruf=W>W</A> |	<a href=?module=staypermitK&act=cari&huruf=X>X</A> |	<a href=?module=staypermitK&act=cari&huruf=Y>Y</A> |	<a href=?module=staypermitK&act=cari&huruf=Z>Z</A>";
		

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
		
		echo "<h2>Approval Permit Kasubdit <br>$negaranya</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='staypermitK'>
				 <input type=hidden name=negara value='$_GET[negara]'>
				Nama Diplomat : <input type=text name=\"namadiplomat\"> <input type=submit value=Cari>
			</form> <br>

<a href=?module=staypermitK>ALL</a> | <a href=?module=staypermitK&status=1 style=\"color : #B1BF19\">WAITING</a> | <a href=?module=staypermitK&status=2 style=\"color : green\">APPROVED</a> | 
	<a href=?module=staypermitK&status=0 style=\"color : #800000\">REJECTED</a> <BR>

		<form method=POST enctype='multipart/form-data' action='./aksi_approval_K.php?module=staypermitK&act=update'>
          <table width=100%>
          <tr><th width=30>no</th><th>NO PENDAFTARAN</th><th>NAMA LENGKAP</th><th colspan=2 >KANTOR PERWAKILAN</th><th width=100>JABATAN</th><th width=80>TGL BERLAKU</th><th width=40>JNS PERMIT</th><th width=80>TGL AGENDA</th><th width=90>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 5;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];

	if (isset($_GET[status])){

	if (isset($_GET[namadiplomat])){
	$tampil=mysql_query("select NO_DAFTAR, ID_PERMIT,ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,date_format(TGL_AGENDA,'%d.%m.%Y') as TGL_AGENDA,NO_IZIN_PERMIT,date_format(TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT,date_format(TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,
KET ,NM_JNS_PERMIT,KD_JNS_PERMIT,NM_DIPLOMAT,ST_PERMIT,ST_PERMIT_K,PEKERJAAN,NM_KNT_PERWAKILAN, BENDERA,NEGARA from v_approval_permit where  (negara like '".$neg."%' and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%') and  ST_PERMIT_K = ".$_GET[status]." order by id_permit desc limit $posisi,$batas ");	 
	
	}
	else
    {$tampil=mysql_query("select NO_DAFTAR, ID_PERMIT,ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,date_format(TGL_AGENDA,'%d.%m.%Y') as TGL_AGENDA,NO_IZIN_PERMIT,date_format(TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT,date_format(TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,
KET ,NM_JNS_PERMIT,KD_JNS_PERMIT,NM_DIPLOMAT,ST_PERMIT,ST_PERMIT_K,PEKERJAAN,NM_KNT_PERWAKILAN, BENDERA,NEGARA from v_approval_permit where  (negara like '".$neg."%')  and KD_WORKFLOW > '0' and  ST_PERMIT_K = $_GET[status] order by id_permit desc limit $posisi,$batas ");	
	}
	
	}
	ELSE
	{
		if (isset($_GET[namadiplomat])){
		$tampil=mysql_query("select NO_DAFTAR, ID_PERMIT,ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,date_format(TGL_AGENDA,'%d.%m.%Y') as TGL_AGENDA,NO_IZIN_PERMIT,date_format(TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT,date_format(TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,
	KET ,NM_JNS_PERMIT,KD_JNS_PERMIT,NM_DIPLOMAT,ST_PERMIT,ST_PERMIT_K,PEKERJAAN,NM_KNT_PERWAKILAN, BENDERA,NEGARA from v_approval_permit where  negara like '".$neg."%' and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%'  order by id_permit desc limit $posisi,$batas ");	 
	
	
		}
		else
		{$tampil=mysql_query("select NO_DAFTAR, ID_PERMIT,ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,date_format(TGL_AGENDA,'%d.%m.%Y') as TGL_AGENDA,NO_IZIN_PERMIT,date_format(TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT,date_format(TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,
	KET ,NM_JNS_PERMIT,KD_JNS_PERMIT,NM_DIPLOMAT,ST_PERMIT,ST_PERMIT_K,PEKERJAAN,NM_KNT_PERWAKILAN, BENDERA,NEGARA from v_approval_permit where  negara like '".$neg."%'  order by id_permit desc limit $posisi,$batas ");	
	
	
		}
	}

    $no = $posisi+1;
	$noP = 1;
	
    while($r=mysql_fetch_array($tampil)){

      echo "<tr><td>$no</td>
                <td width=120>$r[NO_DAFTAR]</td>
				<td><a href=?module=staypermit&act=lihat_stay_permit&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NM_DIPLOMAT]</a></td>
				<td width=20><img src=\"../images/bendera/".strtolower($r[BENDERA])."\" class=\"thumbborder\" width=\"22\" height=\"15\" /></td>  
				<td width=120>$r[NM_KNT_PERWAKILAN]</td>
                <td>$r[PEKERJAAN]</td>
                <td>$r[TGL_AWAL_PERMIT] - $r[TGL_AKHIR_PERMIT]</td>
				<td>$r[KD_JNS_PERMIT]</td>
				<td>$r[TGL_AGENDA]</td>
				<td>
				<div style=\"color : #B1BF19\"><input type=radio onClick='checkBox(this.value,$noP)' name='ST_PERMIT_K$noP' value=1 ";
					if ($r[ST_PERMIT_K]== 1){ echo "checked";}
				echo "> <b>waiting</b> </div><div style=\"color : green\"><input type=radio onClick='checkBox(this.value,$noP)' name='ST_PERMIT_K$noP' value=2 ";
					if ($r[ST_PERMIT_K]== 2){ echo "checked";}				
				echo "> <b>approve</b> </div> <div style=\"color : #800000\"> <input type=radio onClick='checkBox(this.value,$noP)' name='ST_PERMIT_K$noP' value=0 ";
					if ($r[ST_PERMIT_K]== 0){ echo "checked";}
				echo "> <b>reject</b> </div>";
				echo "<div id='popup_box$noP' class='popup_box'>
						<h2>Konfirmasi Status Persetujuan Pengajuan ID Card</h2>
						<div>
						<table width='100%'>
							<tr>
								<td width='40%'>Nama Lengkap</td><td width='6'>:</td><td>$r[NM_DIPLOMAT]</td>
							</tr>
							<tr>
								<td >Kantor Perwakilan / Mission</td><td>:</td><td>$r[NM_KNT_PERWAKILAN]</td>
							</tr>
							<tr>
								<td>Jabatan</td><td>:</td><td>$r[PEKERJAAN]</td>
							</tr>
							<tr>
								<td>Tanggal Berlaku</td><td>:</td><td>$r[TGL_AWAL_PERMIT] - $r[TGL_AKHIR_PERMIT]</td>
							</tr>
							<tr>
								<td>Jenis Permit</td><td>:</td><td>$r[KD_JNS_PERMIT]</td>
							</tr>";
				
						$tampil1=mysql_query("SELECT * FROM syarat_permit a inner join m_syarat b on  a.syarat_kd=b.syarat_kd where b.jenis_izin='1' and a.id_permit='".$r['ID_PERMIT']."'");
						echo "<tr><td>Persyaratan</td>    <td>:</td> <td> ";
				while ($data=mysql_fetch_array($tampil1)) {
					echo "<input type=checkbox disabled checked=checked name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <br>";
				}
					$tampil2=mysql_query("select * from m_syarat where jenis_izin='1' and syarat_kd not in ( SELECT b.syarat_kd FROM syarat_permit a inner join m_syarat b on  a.syarat_kd=b.syarat_kd where b.jenis_izin='1' and a.id_permit='".$r['ID_PERMIT']."')");
				
				while ($data2=mysql_fetch_array($tampil2)) {
					echo "<input type=checkbox name='syarat[]' value='$data2[syarat_kd]'> $data2[syarat_nama] <br>";
				}
				
				echo "<tr>
						<td>Perubahan Status Menjadi</td>
						<td>:</td>
						<td><b><div id='status$noP' ></div></b></td>
					  </tr>";

				echo "</td></tr>";
				echo "<tr>
						<td></td>
						<td></td>
						<td><input type='button' name='updateStatus' onClick=updateAction($r[ID_PERMIT],$noP,'K','1'); value='Submit'></td>
					  </tr>";

/*				if (mysql_num_rows($tampil2)==0){ 
				echo "<tr>
						<td></td>
						<td></td>
						<td><input type='button' name='updateStatus' onClick=updateAction($r[ID_PERMIT],$noP,'K','1'); value='Submit'></td>
					  </tr>";
				} else {
				echo "<tr>
						<td colspan='3'><i>Berkas Belum lengkap, tidak dapat di proses!</i></td>
					  </tr>";
				}
*/
				echo "  
					</table>
					</div>
						<a id='popupBoxClose' onClick='unloadPopupBox($noP);'>Batal</a>	
					</div>
					";
				
				echo "<br /><input type='button' name='button' onClick=loadPopupBox($noP); value='update'> 
							<input type='hidden' name='txt_box$noP' id='txt_box$noP' value='' >"; 				
				
				echo "</td>
					<input type=hidden name='ID_PERMIT$noP' value='$r[ID_PERMIT]'>     	  
		        </tr>";
      $no++;
	  $noP++;
    }
    echo "	<input type=hidden name='jumlahData' value= $noP>     	  
		     </table><div align=right> </div>
	</form>	";
	//<input type=submit value=Update>
	if (isset($_GET[status])){
		if (isset($_GET[namadiplomat]))
		{
			$jmldata =mysql_num_rows(mysql_query("select ID_PERMIT from v_approval_permit where negara like '".$neg."%' and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%'  and  ST_PERMIT_K = ".$_GET[status]));
		}else{
			$jmldata =mysql_num_rows(mysql_query("select ID_PERMIT from v_approval_permit where negara like '".$neg."%'  and  ST_PERMIT_K = ".$_GET[status]));
		}
	}else{
		if (isset($_GET[namadiplomat]))
		{
			$jmldata =mysql_num_rows(mysql_query("select ID_PERMIT from v_approval_permit where negara like '".$neg."%' and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' "));
		}else{
			$jmldata =mysql_num_rows(mysql_query("select ID_PERMIT from v_approval_permit where negara like '".$neg."%'"));
		}
	}
	
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

	if (isset($_GET[status])){
	$ilink = "?module=staypermitK&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]&status=$_GET[status]"; }
	else
	{$ilink = "?module=staypermitK&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]"; }

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


	echo " <input type=button value='Tambah' onclick=location.href='?module=staypermitK&act=tambah_stay_permit&idt=$idt&negara=$_GET[negara]'>
			<table width=100%>
          <tr><th  width=30>no</th><th width=50>Jenis Permit</th><th  width=70>No Agenda</th><th width=85>Tanggal Agenda</th><th width=70>No Izin Permit</th><th width=85>Tanggal Awal Permit</th><th width=85>Tanggal Akhir</th><th>Status Direksi</th><th>Status Kasubdit</th><th width=70>AKSI</th></tr>"; 

    $p      = new Paging;
    $batas  = 200;
    $posisi = $p->cariPosisi($batas);

    $tampil=mysql_query("select NO_DAFTAR, ID_PERMIT,ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,date_format(TGL_AGENDA,'%d.%m.%Y') as  TGL_AGENDA,NO_IZIN_PERMIT,date_format(TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT,date_format(TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,KET ,NM_JNS_PERMIT,KD_JNS_PERMIT,NM_DIPLOMAT,ST_PERMIT,ST_PERMIT_K from v_stay_permit where ID_DIPLOMAT = $idt order by  ID_PERMIT");

	$no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      echo "<tr><td>$no</td>
                <td><a href=?module=staypermitK&act=edit_stay_permit&idt=$r[ID_PERMIT]&idd=$idt&negara=$_GET[negara]> $r[KD_JNS_PERMIT]</a></td>
				<td>$r[NO_AGENDA]</td>
				<td>$r[TGL_AGENDA]</td>
				<td>$r[NO_IZIN_PERMIT]</td>
				<td>$r[TGL_AWAL_PERMIT]</td>
				<td>$r[TGL_AKHIR_PERMIT]</td>
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
		if ($r[ST_PERMIT_K] == 2){
			echo "<div style=\"color : green\"> <b>approved</b> </div>";
		}elseif ($r[ST_PERMIT_K] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>waiting</b> </div>";
		}elseif ($r[ST_PERMIT_K] == 0){		
			echo "<div style=\"color : #800000\"> <b>rejected</b> </div>";
		}
						
				echo "</td>
				<td><a href=./report.php?go=permit&idt=$r[ID_PERMIT] target=\"_blank\"
				>Cetak</a> | 
		            <a href=./aksi_stay_permit.php?module=staypermitK&act=hapus&idt=$r[ID_PERMIT]&idd=$idt&negara=$_GET[negara] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus permit $r[NO_IZIN_PERMIT]?')\">Hapus</a></td>
				</tr>";

      $no++;
    }
    echo "</table>";

				 
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
				&nbsp <a href=?module=staypermitK&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";
		
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
