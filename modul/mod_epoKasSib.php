<?php
	   echo "<br><a href=?module=epoKasSib&act=cari&huruf=A>A</A> |	<a href=?module=epoKasSib&act=cari&huruf=B>B</A> |	<a href=?module=epoKasSib&act=cari&huruf=C>C</A> |	<a href=?module=epoKasSib&act=cari&huruf=D>D</A> |	<a href=?module=epoKasSib&act=cari&huruf=E>E</A> |	<a href=?module=epoKasSib&act=cari&huruf=F>F</A> |	<a href=?module=epoKasSib&act=cari&huruf=G>G</A> |	<a href=?module=epoKasSib&act=cari&huruf=H>H</A> |	<a href=?module=epoKasSib&act=cari&huruf=I>I</A> |	<a href=?module=epoKasSib&act=cari&huruf=J>J</A> |	<a href=?module=epoKasSib&act=cari&huruf=K>K</A> |	<a href=?module=epoKasSib&act=cari&huruf=L>L</A> |	<a href=?module=epoKasSib&act=cari&huruf=M>M</A> |	<a href=?module=epoKasSib&act=cari&huruf=N>N</A> |	<a href=?module=epoKasSib&act=cari&huruf=O>O</A> |	<a href=?module=epoKasSib&act=cari&huruf=P>P</A> |	<a href=?module=epoKasSib&act=cari&huruf=Q>Q</A> |	<a href=?module=epoKasSib&act=cari&huruf=R>R</A> |	<a href=?module=epoKasSib&act=cari&huruf=S>S</A> |	<a href=?module=epoKasSib&act=cari&huruf=T>T</A> |	<a href=?module=epoKasSib&act=cari&huruf=U>U</A> |	<a href=?module=epoKasSib&act=cari&huruf=V>V</A> |	<a href=?module=epoKasSib&act=cari&huruf=W>W</A> |	<a href=?module=epoKasSib&act=cari&huruf=X>X</A> |	<a href=?module=epoKasSib&act=cari&huruf=Y>Y</A> |	<a href=?module=epoKasSib&act=cari&huruf=Z>Z</A>";
		

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
		
		echo "<h2>Approval EPO Sibling Kasie <br>$negaranya</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='epoKasSib'>
				 <input type=hidden name=negara value='$_GET[negara]'>
				 Nama Diplomat : <input type=text name=\"namadiplomat\"> <input type=submit value=Cari>
			</form> <br>

<a href=?module=epoKasSib>ALL</a> | <a href=?module=epoKasSib&status=1 style=\"color : #B1BF19\">WAITING</a> | <a href=?module=epoKasSib&status=2 style=\"color : green\">APPROVED</a> | 
	<a href=?module=epoKasSib&status=0 style=\"color : #800000\">REJECTED</a> <BR>

		<form method=POST enctype='multipart/form-data' action='./aksi_id_cardK_sib.php?module=epoKasSib&act=update'>
          <table width=100%>
         
	  
		<tr><th width=30>no</th><th width=110 >NAMA FAMILY (RELASI)</th><th >NAMA DIPLOMAT</th><th >KANTOR PERWAKILAN</th><th  width=30>NO EPO</th><th  width=70>TGL BERLAKU</th> <th width=90>AKSI</th></tr>		
		";


    $p      = new Paging;
    $batas  = 5;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];

	if (isset($_GET[status])){

	if (isset($_GET[namadiplomat])){
		
		$tampil=mysql_query("select a.*, c.PEKERJAAN,c.NM_KNT_PERWAKILAN, c.NM_JNS_RELASI,date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO from v_epo_sib a LEFT join v_sibling c on a.ID_SIBLING=c.ID_SIBLING   where c.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' and c.NEGARA like '%$neg%' and  a.ST_EPO_KAS =  ".$_GET[status]." ORDER BY a.ID_EPO_S desc limit $posisi,$batas");

	}
	else
    {

	$tampil=mysql_query("select a.*, c.PEKERJAAN,c.NM_KNT_PERWAKILAN, c.NM_JNS_RELASI,date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO from v_epo_sib a LEFT join v_sibling c on a.ID_SIBLING=c.ID_SIBLING   where c.NEGARA like '%$neg%' and  a.ST_EPO_KAS =  ".$_GET[status]." ORDER BY a.ID_EPO_S desc limit $posisi,$batas");


	}
	
	}
	ELSE
	{
		if (isset($_GET[namadiplomat])){
	
		$tampil=mysql_query("select a.*, c.PEKERJAAN,c.NM_KNT_PERWAKILAN, c.NM_JNS_RELASI,date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO from v_epo_sib a LEFT join v_sibling c on a.ID_SIBLING=c.ID_SIBLING   where c.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' and c.NEGARA like '%$neg%' ORDER BY a.ID_EPO_S desc limit $posisi,$batas");
	
		}
		else
		{
		$tampil=mysql_query("select a.*, c.PEKERJAAN,c.NM_KNT_PERWAKILAN, c.NM_JNS_RELASI,date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO from v_epo_sib a LEFT join v_sibling c on a.ID_SIBLING=c.ID_SIBLING   where c.NEGARA like '%$neg%' ORDER BY a.ID_EPO_S desc limit $posisi,$batas");
 

	
		}
	}


		
    $no = $posisi+1;
	  $noP = 1;
    while($r=mysql_fetch_array($tampil)){

      echo "<tr><td>$no</td>
                <td>
				<a href=?module=epoSib&act=lihat_epo&idt=$r[ID_SIBLING]&negara=$_GET[negara]>$r[NM_SIBLING] ($r[NM_JNS_RELASI]) </a></td>
				<td><a href=?module=epo&act=lihat_epo&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NM_DIPLOMAT]</a></td>
				<td >$r[NM_KNT_PERWAKILAN]</td>
                <td>$r[NO_EPO]</td>
                <td>$r[TGL_AKHIR_EPO] - $r[TGL_AWAL_EPO]</td>
				<td>
				<div style=\"color : #B1BF19\"><input type=radio onClick='checkBox(this.value,$noP)' name='ST_EPO_KAS$noP' value=1 ";
					if ($r[ST_EPO_KAS]== 1){ echo "checked";}
				echo "> <b>waiting</b> </div><div style=\"color : green\"><input type=radio onClick='checkBox(this.value,$noP)' name='ST_EPO_KAS$noP' value=2 ";
					if ($r[ST_EPO_KAS]== 2){ echo "checked";}				
				echo "> <b>approve</b> </div> <div style=\"color : #800000\"> <input type=radio onClick='checkBox(this.value,$noP)' name='ST_EPO_KAS$noP' value=0 ";
					if ($r[ST_EPO_KAS]== 0){ echo "checked";}
				echo "> <b>reject</b> </div>";					
								echo "<div id='popup_box$noP' class='popup_box'>
						<h2>Konfirmasi Status Persetujuan Pengajuan EPO Sibling</h2>
						<div>
						<table width='100%'>
							<tr>
								<td width='40%'>Nama Diplomat</td><td width='6'>:</td><td>$r[NM_DIPLOMAT]</td>
							</tr>
							<tr>
								<td >Kantor Perwakilan / Mission</td><td>:</td><td>$r[NM_KNT_PERWAKILAN]</td>
							</tr>
							<tr>
								<td colspan='3' height='3' bgcolor='blue' ></td>
							</tr>
							<tr>
								<td width='40%'>Nama Lengkap Sibling</td><td width='6'>:</td><td>$r[NM_SIBLING]</td>
							</tr>
							<tr>
								<td >Relasi</td><td>:</td><td>$r[NM_JNS_RELASI]</td>
							</tr>
							<tr>
								<td>Pekerjaan</td><td>:</td><td>$r[PEKERJAAN]</td>
							</tr>
							<tr>
								<td>NO EPO</td><td>:</td><td>$r[NO_EPO]</td>
							</tr>
							<tr>
								<td>Tanggal Berlaku</td><td>:</td><td>$r[TGL_AKHIR_EPO] - $r[TGL_AWAL_EPO]</td>
							</tr>
							";
				

				echo "<td >Persyaratan</td><td>:</td><td>";
				$tampil1=mysql_query("SELECT * FROM syarat_epo a right join m_syarat b on  a.syarat_kd=b.syarat_kd where b.jenis_izin='7' and a.ID_EPO='".$r['ID_EPO_S']."'");
	
				while ($data=mysql_fetch_array($tampil1)) {
					if ($data['file'] !="")
					{
						echo "<input type=checkbox disabled checked=checked name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <a target='_blank' href='/upload/epo/$data[file]'>Lihat Berkas</a><br>";
					}else
					{
						echo "<input type=checkbox disabled name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <br>";
					
					}
				}	
				
				echo "</td></tr>";
				echo "
					<tr>
						<td>Perubahan Status Menjadi</td>
						<td>:</td>
						<td><b><div id='status$noP' ></div></b></td>
					  </tr>";

				echo "</td></tr>";
				echo "<tr>
						<td></td>
						<td></td>
						<td><input type='button' name='updateStatus' onClick=updateEpo($r[ID_EPO_S],$noP,'Kas','5'); value='Submit'></td>
					  </tr>";
/*				if (mysql_num_rows($tampil2)==0){ 
				echo "<tr>
						<td></td>
						<td></td>
						<td><input type='button' name='updateStatus' onClick=updateAction($r[ID_CETAK_S],$noP,'K','4'); value='Submit'></td>
					  </tr>";
				} else {
				echo "<tr>
						<td colspan='3'><i>Berkas Belum lengkap, tidak dapat di proses!</i></td>
					  </tr>";
				}
*/				echo "  
					</table>
					</div>
						<a id='popupBoxClose' onClick='unloadPopupBox($noP);'>Batal</a>	
					</div>
					";
				echo "<br /><input type='button' name='button' onClick=loadPopupBox($noP); value='update'> 
				<input type='hidden' name='txt_box$noP' id='txt_box$noP' value='$r[ST_EPO_KASAS]' > "; 

				echo "		</td>
				<input type=hidden name='ID_PERMIT$noP' value='$r[ID_PERMIT]'>     	  
		        </tr>";
				
				echo "</td>
				<input type=hidden name='ID_CETAK$noP' value='$r[ID_CETAK_S]'>     	  
		        </tr>";
      $no++;
	  $noP++;
    }
    echo "	<input type=hidden name='jumlahData' value= $noP>     	  
		     </table><div align=right></div>
	</form>	";
	
	//<input type=submit value=Update> 

	if (isset($_GET[status])){
		if (isset($_GET[namadiplomat]))
		{
		
			$jmldata =mysql_num_rows(mysql_query("select a.*, c.PEKERJAAN,c.NM_KNT_PERWAKILAN, c.NM_JNS_RELASI,date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO from v_epo_sib a LEFT join v_sibling c on a.ID_SIBLING=c.ID_SIBLING   where c.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' and c.NEGARA like '%$neg%' and  a.ST_EPO_KAS =  ".$_GET[status]));

		
		}else{

			$jmldata =mysql_num_rows(mysql_query("select a.*, c.PEKERJAAN,c.NM_KNT_PERWAKILAN, c.NM_JNS_RELASI,date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO from v_epo_sib a LEFT join v_sibling c on a.ID_SIBLING=c.ID_SIBLING   where c.NEGARA like '%$neg%' and  a.ST_EPO_KAS =  ".$_GET[status]));

		}
	}else{
		if (isset($_GET[namadiplomat]))
		{

			$jmldata =mysql_num_rows(mysql_query("select a.*, c.PEKERJAAN,c.NM_KNT_PERWAKILAN, c.NM_JNS_RELASI,date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO from v_epo_sib a LEFT join v_sibling c on a.ID_SIBLING=c.ID_SIBLING   where c.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' and c.NEGARA like '%$neg%'"));
		
		}else{

			$jmldata =mysql_num_rows(mysql_query("select a.*, c.PEKERJAAN,c.NM_KNT_PERWAKILAN, c.NM_JNS_RELASI,date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO from v_epo_sib a LEFT join v_sibling c on a.ID_SIBLING=c.ID_SIBLING   where c.NEGARA like '%$neg%'"));

		}
	}
	
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

	if (isset($_GET[status])){
	$ilink = "?module=epoKasSib&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]&status=$_GET[status]"; }
	else
	{$ilink = "?module=epoKasSib&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]"; }

	$linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;

 
	

  case "cari":
    $alf = $_GET[huruf];
	  
    echo "<br><br><a style=\"font-size: 22pt;\">$alf</a>";
	echo "<h2>Approval ID CARD Sibling Kasubdit - Pilih Negara</h2> 
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
				&nbsp <a href=?module=epoKasSib&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";
		
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
