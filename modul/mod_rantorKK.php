<?php
	   echo "<a href=?module=rantorKK&act=cari&huruf=A>A</A> |	<a href=?module=rantorKK&act=cari&huruf=B>B</A> |	<a href=?module=rantorKK&act=cari&huruf=C>C</A> |	<a href=?module=rantorKK&act=cari&huruf=D>D</A> |	<a href=?module=rantorKK&act=cari&huruf=E>E</A> |	<a href=?module=rantorKK&act=cari&huruf=F>F</A> |	<a href=?module=rantorKK&act=cari&huruf=G>G</A> |	<a href=?module=rantorKK&act=cari&huruf=H>H</A> |	<a href=?module=rantorKK&act=cari&huruf=I>I</A> |	<a href=?module=rantorKK&act=cari&huruf=J>J</A> |	<a href=?module=rantorKK&act=cari&huruf=K>K</A> |	<a href=?module=rantorKK&act=cari&huruf=L>L</A> |	<a href=?module=rantorKK&act=cari&huruf=M>M</A> |	<a href=?module=rantorKK&act=cari&huruf=N>N</A> |	<a href=?module=rantorKK&act=cari&huruf=O>O</A> |	<a href=?module=rantorKK&act=cari&huruf=P>P</A> |	<a href=?module=rantorKK&act=cari&huruf=Q>Q</A> |	<a href=?module=rantorKK&act=cari&huruf=R>R</A> |	<a href=?module=rantorKK&act=cari&huruf=S>S</A> |	<a href=?module=rantorKK&act=cari&huruf=T>T</A> |	<a href=?module=rantorKK&act=cari&huruf=U>U</A> |	<a href=?module=rantorKK&act=cari&huruf=V>V</A> |	<a href=?module=rantorKK&act=cari&huruf=W>W</A> |	<a href=?module=rantorKK&act=cari&huruf=X>X</A> |	<a href=?module=rantorKK&act=cari&huruf=Y>Y</A> |	<a href=?module=rantorKK&act=cari&huruf=Z>Z</A>";
		

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
		
		echo "<h2>Approval Rantor Kantor Perwakilan Kasubdit <br>$negaranya</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='rantorKK'>
				 <input type=hidden name=negara value='$_GET[negara]'>
				Nama  Kantor Perwakilan : <input type=text name=\"namakantor\"> <input type=submit value=Cari>
			</form> <br>

<a href=?module=rantorKK>ALL</a> | <a href=?module=rantorKK&status=1 style=\"color : #B1BF19\">WAITING</a> | <a href=?module=rantorKK&status=2 style=\"color : green\">APPROVED</a> | 
	<a href=?module=rantorKK&status=0 style=\"color : #800000\">REJECTED</a> <BR>

		<form method=POST enctype='multipart/form-data' action='./aksi_rantorKK.php?module=rantorKK&act=update'>
          <table width=100%>
         
		<tr><th width=30>no</th><th width=180 >NAMA KANTOR PERWAKILAN</th><th >NEGARA</th><th  width=80>NOPOL</th><th  width=35>ASAL</th> <th  width=50>TGL IZIN</th><th  width=80>NO IZIN</th><th width=90>AKSI</th></tr>	
		";

    $p      = new Paging;
    $batas  = 5;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];

	if (isset($_GET[status])){

	if (isset($_GET[namakantor])){
	
	$tampil=mysql_query("select ID_PENGGUNAA_FAS,ID_KNT_PERWAKILAN,NEGARA,NM_KNT_PERWAKILAN,ALAMAT,KOTA,NM_JNS_PERWAKILAN,NM_SUB_JNS,NO_POLISI,  ST_ASAL,TANGGAL_IZIN,NO_IZIN , ST_KENDARAAN,ST_PERSETUJUAN,ST_PERSETUJUAN_K,BENDERA from v_approval_rantork
 where  (negara like '".$neg."%' and NM_KNT_PERWAKILAN like '%".$_GET[namakantor]."%') and  ST_PERSETUJUAN_K =  ".$_GET[status]." ORDER BY TANGGAL_IZIN,NM_KNT_PERWAKILAN desc limit $posisi,$batas ");	
	
	}
	else
    {
	$tampil=mysql_query("select ID_PENGGUNAA_FAS,ID_DIPLOMAT,NM_DIPLOMAT,NM_RANK,NEGARA,NM_KNT_PERWAKILAN,NO_POLISI,  ST_ASAL,TANGGAL_IZIN,NO_IZIN , ST_KENDARAAN,ST_PERSETUJUAN,ST_PERSETUJUAN_K,BENDERA from v_approval_rantori 
 where  (negara like '".$neg."%' ) and  ST_PERSETUJUAN_K =  ".$_GET[status]." ORDER BY TANGGAL_IZIN,ID_KNT_PERWAKILAN , NM_DIPLOMAT, ID_RANK desc limit $posisi,$batas ");	

	$tampil=mysql_query("select ID_PENGGUNAA_FAS,ID_KNT_PERWAKILAN,NEGARA,NM_KNT_PERWAKILAN,ALAMAT,KOTA,NM_JNS_PERWAKILAN,NM_SUB_JNS,NO_POLISI,  ST_ASAL,TANGGAL_IZIN,NO_IZIN , ST_KENDARAAN,ST_PERSETUJUAN,ST_PERSETUJUAN_K,BENDERA from v_approval_rantork
 where  (negara like '".$neg."%') and  ST_PERSETUJUAN_K =  ".$_GET[status]." ORDER BY TANGGAL_IZIN,NM_KNT_PERWAKILAN desc limit $posisi,$batas ");

	
	}
	
	}
	ELSE
	{
		if (isset($_GET[namakantor])){
	
	
 	$tampil=mysql_query("select ID_PENGGUNAA_FAS,ID_KNT_PERWAKILAN,NEGARA,NM_KNT_PERWAKILAN,ALAMAT,KOTA,NM_JNS_PERWAKILAN,NM_SUB_JNS,NO_POLISI,  ST_ASAL,TANGGAL_IZIN,NO_IZIN , ST_KENDARAAN,ST_PERSETUJUAN,ST_PERSETUJUAN_K,BENDERA from v_approval_rantork
 where  (negara like '".$neg."%' and NM_KNT_PERWAKILAN like '%".$_GET[namakantor]."%') ORDER BY TANGGAL_IZIN,NM_KNT_PERWAKILAN desc limit $posisi,$batas ");
	
		}
		else
		{
		

	$tampil=mysql_query("select ID_PENGGUNAA_FAS,ID_KNT_PERWAKILAN,NEGARA,NM_KNT_PERWAKILAN,ALAMAT,KOTA,NM_JNS_PERWAKILAN,NM_SUB_JNS,NO_POLISI,  ST_ASAL,TANGGAL_IZIN,NO_IZIN , ST_KENDARAAN,ST_PERSETUJUAN,ST_PERSETUJUAN_K,BENDERA from v_approval_rantork
 where  (negara like '".$neg."%' )  ORDER BY TANGGAL_IZIN,NM_KNT_PERWAKILAN desc limit $posisi,$batas ");

		}
	}


		
    $no = $posisi+1;
	$noP = 1;
    while($r=mysql_fetch_array($tampil)){

      echo "<tr><td>$no</td>
                <td>";
			if ($r[ST_ASAL] == "IMPOR"){
			echo "	<a href=?module=rantorKimpor&act=lihat_rantorKimpor&idt=$r[ID_KNT_PERWAKILAN]&negara=$_GET[negara]>$r[NM_KNT_PERWAKILAN]</a>";
			}
			if ($r[ST_ASAL] == "BELI"){
			echo "	<a href=?module=rantorKbeli&act=lihat_rantorKbeli&idt=$r[ID_KNT_PERWAKILAN]&negara=$_GET[negara]>$r[NM_KNT_PERWAKILAN]</a>";
			}
			
		echo "</td>
				<td><img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" />  &nbsp $r[NEGARA]</td>
                <td>$r[NO_POLISI]</td>
                <td>$r[ST_ASAL]</td>
				<td>$r[TANGGAL_IZIN]</td>
				<td>$r[NO_IZIN]</td>
				<td>
				<div style=\"color : #B1BF19\"><input type=radio name='ST_PERSETUJUAN_K$noP' value=1 ";
					if ($r[ST_PERSETUJUAN_K]== 1){ echo "checked";}
				echo "> <b>waiting</b> </div><div style=\"color : green\"><input type=radio name='ST_PERSETUJUAN_K$noP' value=2 ";
					if ($r[ST_PERSETUJUAN_K]== 2){ echo "checked";}				
				echo "> <b>approve</b> </div> <div style=\"color : #800000\"> <input type=radio name='ST_PERSETUJUAN_K$noP' value=0 ";
					if ($r[ST_PERSETUJUAN_K]== 0){ echo "checked";}
				echo "> <b>reject</b> </div>					
				</td>
				<input type=hidden name='ID_PENGGUNAA_FAS$noP' value='$r[ID_PENGGUNAA_FAS]'>     	  
		        </tr>";
      $no++;
	  $noP++;
    }
    echo "	<input type=hidden name='jumlahData' value= $noP>     	  
		     </table><div align=right><input type=submit value=Update> </div>
	</form>	";
	
	

	if (isset($_GET[status])){
		if (isset($_GET[namakantor]))
		{
			$jmldata =mysql_num_rows(mysql_query("select ID_PENGGUNAA_FAS from v_approval_rantork where  (negara like '".$neg."%' and NM_KNT_PERWAKILAN like '%".$_GET[namakantor]."%') and  ST_PERSETUJUAN_K =  ".$_GET[status]));

 

		}else{

			$jmldata =mysql_num_rows(mysql_query("select ID_PENGGUNAA_FAS from v_approval_rantork where  (negara like '".$neg."%' ) and  ST_PERSETUJUAN_K =  ".$_GET[status]));
		}
	}else{
		if (isset($_GET[namakantor]))
		{

			$jmldata =mysql_num_rows(mysql_query("select ID_PENGGUNAA_FAS from v_approval_rantork where  (negara like '".$neg."%' and NM_KNT_PERWAKILAN like '%".$_GET[namakantor]."%')" ));
		
		}else{

			$jmldata =mysql_num_rows(mysql_query("select ID_PENGGUNAA_FAS from v_approval_rantork where  (negara like '".$neg."%' )"));
		}
	}
	
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

	if (isset($_GET[status])){
	$ilink = "?module=rantorKK&negara=$_GET[negara]&namakantor=$_GET[namakantor]&status=$_GET[status]"; }
	else
	{$ilink = "?module=rantorKK&negara=$_GET[negara]&namakantor=$_GET[namakantor]"; }

	$linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;

 
	

  case "cari":
    $alf = $_GET[huruf];
	  
    echo "<br><br><a style=\"font-size: 22pt;\">$alf</a>";
	echo "<h2>Rantor Kantor Approval Kasubdit - Pilih Negara</h2> 
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
				&nbsp <a href=?module=rantorKK&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";
		
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
