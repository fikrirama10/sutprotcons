<?php
	   echo "<br><a href=?module=epoSib&act=cari&huruf=A>A</A> |	<a href=?module=epoSib&act=cari&huruf=B>B</A> |	
			     <a href=?module=epoSib&act=cari&huruf=C>C</A> |	<a href=?module=epoSib&act=cari&huruf=D>D</A> |	
				 <a href=?module=epoSib&act=cari&huruf=E>E</A> |	<a href=?module=epoSib&act=cari&huruf=F>F</A> |	
				 <a href=?module=epoSib&act=cari&huruf=G>G</A> |	<a href=?module=epoSib&act=cari&huruf=H>H</A> |	
				 <a href=?module=epoSib&act=cari&huruf=I>I</A> |	<a href=?module=epoSib&act=cari&huruf=J>J</A> |	
				 <a href=?module=epoSib&act=cari&huruf=K>K</A> |	<a href=?module=epoSib&act=cari&huruf=L>L</A> |	
				 <a href=?module=epoSib&act=cari&huruf=M>M</A> |	<a href=?module=epoSib&act=cari&huruf=N>N</A> |	
				 <a href=?module=epoSib&act=cari&huruf=O>O</A> |	<a href=?module=epoSib&act=cari&huruf=P>P</A> |	
				 <a href=?module=epoSib&act=cari&huruf=Q>Q</A> |	<a href=?module=epoSib&act=cari&huruf=R>R</A> |	
				 <a href=?module=epoSib&act=cari&huruf=S>S</A> |	<a href=?module=epoSib&act=cari&huruf=T>T</A> |	
				 <a href=?module=epoSib&act=cari&huruf=U>U</A> |	<a href=?module=epoSib&act=cari&huruf=V>V</A> |	
				 <a href=?module=epoSib&act=cari&huruf=W>W</A> |	<a href=?module=epoSib&act=cari&huruf=X>X</A> |	
				 <a href=?module=epoSib&act=cari&huruf=Y>Y</A> |	<a href=?module=epoSib&act=cari&huruf=Z>Z</A>";

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
		echo "<h2>Pengajuan Exit Permit Only (EPO) Sibling<br>Pilih Diplomat - $negaranya</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='epoSib'>
				 <input type=hidden name=negara value='$_GET[negara]'>
			Nama Diplomat : <input type=text name=\"namadiplomat\"> <input type=submit value=Cari>
			</form> <br>

		  <table width=100%>
          <tr><th width=30>no</th><th>NO PENDAFTARAN</th><th>Status</th><th width=100>NO EPO</th><th width=130>NAMA FAMILY</th><th width=130>NAMA DIPLOMAT</th><th width=160>KANTOR PERWAKILAN</th><th>RELASI</th><th width=70>TGL BERLAKU</th><!--<th>STATUS DIR</th>--><th width=30>STATUS KASUBDIT</th><th width=30>STATUS KASIE</th></th><th width=55>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];
	
	if ((isset($_GET[namadiplomat]))&& !(empty($_GET[namadiplomat])) ){

	$sql_epo="select a.*, b.ID_EPO_S, b.NO_DAFTAR, b.STATUS_WORKFLOW, b.KD_WORKFLOW, b.NO_EPO, date_format(b.TGL_AWAL_EPO,'%d.%m.%Y') as 
		TGL_AWAL_EPO,  date_format(b.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, b.ST_EPO_K, b.ST_EPO_KAS
				from (select a.ID_SIBLING, c.NM_DIPLOMAT, a.NM_SIBLING, b.NM_JNS_RELASI, d.NM_KNT_PERWAKILAN,  c.ID_DIPLOMAT, f.NEGARA
						from sibling a 
						inner join m_jns_relasi b 
						on a.ID_JNS_RELASI=b.ID_JNS_RELASI
						inner join diplomat c
						on a.ID_DIPLOMAT=c.ID_DIPLOMAT
						inner join m_kantor_perwakilan d
						on c.ID_KNT_PERWAKILAN=d.ID_KNT_PERWAKILAN 
						inner join m_negara f
						on f.ID_NEGARA=c.ID_NEGARA ) as a
						left join ( select ID_EPO_S, NO_DAFTAR, STATUS_WORKFLOW, ID_SIBLING, ST_EPO, ST_EPO_K, ST_EPO_KAS, NO_EPO , KD_WORKFLOW, TGL_KIRIM,TGL_AWAL_EPO,TGL_AKHIR_EPO from v_epo_sib) as b
						on a.ID_SIBLING=b.ID_SIBLING where KD_WORKFLOW>=1 and a.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%'
						and a.NEGARA like '%$neg%'
					order by  b.tgl_kirim desc, b.ID_EPO_S desc limit $posisi,$batas";	
	
		
		//echo $sql_epo;
		$tampil=mysql_query($sql_epo);
		//print_r($tampil2_sql);
	}
	else if(empty($_GET[namadiplomat]))
    {
		
		$sql="select a.*, b.ID_EPO_S, b.NO_DAFTAR, b.STATUS_WORKFLOW, b.KD_WORKFLOW, b.NO_EPO, date_format(b.TGL_AWAL_EPO,'%d.%m.%Y') as 
		TGL_AWAL_EPO,  date_format(b.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, b.ST_EPO_K, b.ST_EPO_KAS
				from (select a.ID_SIBLING, c.NM_DIPLOMAT, a.NM_SIBLING, b.NM_JNS_RELASI, d.NM_KNT_PERWAKILAN,  c.ID_DIPLOMAT, f.NEGARA
						from sibling a 
						inner join m_jns_relasi b 
						on a.ID_JNS_RELASI=b.ID_JNS_RELASI
						inner join diplomat c
						on a.ID_DIPLOMAT=c.ID_DIPLOMAT
						inner join m_kantor_perwakilan d
						on c.ID_KNT_PERWAKILAN=d.ID_KNT_PERWAKILAN 
						inner join m_negara f
						on f.ID_NEGARA=c.ID_NEGARA ) as a
						left join ( select ID_EPO_S, NO_DAFTAR, STATUS_WORKFLOW, ID_SIBLING, ST_EPO, ST_EPO_K, ST_EPO_KAS, NO_EPO , KD_WORKFLOW, TGL_KIRIM,TGL_AWAL_EPO,TGL_AKHIR_EPO from v_epo_sib) as b
						on a.ID_SIBLING=b.ID_SIBLING where KD_WORKFLOW>=1
						and a.NEGARA like '%$neg%'
					order by  b.tgl_kirim desc, b.ID_EPO_S desc limit $posisi,$batas";	
		
		$tampil=mysql_query($sql);
		//print_r($sql_epo1);exit;

	}
	
	$sql_jml_epo = ("select STATUS_WORKFLOW,count(*) as jml from v_epo_sib GROUP BY STATUS_WORKFLOW ");
    $tampil_jml = mysql_query($sql_jml_epo);	    
	while ($tmpl = mysql_fetch_array($tampil_jml)) {
		$sts = $tmpl[STATUS_WORKFLOW];
		if($sts == 'Menunggu Verifikasi'){
			$sts_menunggu = $tmpl[jml];
		}
		if($sts == 'Lolos Verifikasi'){
			$sts_lolos = $tmpl[jml];
		}
		if($sts == 'Tidak Lolos Verifikasi'){
			$sts_tdk_lolos = $tmpl[jml];
		}
	}	
	echo"<div align='right'><span>Menunggu Verifikasi : <b>$sts_menunggu</b>, <font color='green'>Lolos Verifikasi : <b>$sts_lolos</b></font>, <font color='red'>Tidak Lolos Verifikasi : <b>$sts_tdk_lolos</b></font></span></div>";
   
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
		
	  if($r[STATUS_WORKFLOW] == 'Menunggu Verifikasi'){
		  $warna =  "style='color: black;'";
	  }elseif($r[STATUS_WORKFLOW] == 'Lolos Verifikasi'){
		  $warna =  "style='color: green;'";
	  }elseif($r[STATUS_WORKFLOW] == 'Tidak Lolos Verifikasi'){
		  $warna =  "style='color: red;'";
	  }
		
      echo "<tr><td>$no</td>
                
				<td><a href=?module=epoSib&act=lihat_epo&idt=$r[ID_SIBLING]&negara=$_GET[negara]>$r[NO_DAFTAR]</a></td>
				<td $warna>$r[STATUS_WORKFLOW]</td>
				<td><a href=?module=epoSib&act=lihat_epo&idt=$r[ID_SIBLING]&negara=$_GET[negara]>$r[NO_EPO]</a></td>
				<td><a href=?module=sibling&act=viewsibling&idt=$r[ID_SIBLING]&negara=$_GET[negara]>$r[NM_SIBLING]</a></td>
				
				<td><a href=?module=diplomat&act=viewdiplomat&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NM_DIPLOMAT]</a></td>
                <td>$r[NM_KNT_PERWAKILAN]</td>
				<td>$r[NM_JNS_RELASI]</td>		
				<td>$r[TGL_AWAL_EPO] - $r[TGL_AKHIR_EPO]</td>	
				";
		/*echo "<td>";
		$get_wf = mysql_query("select * from m_workflow");
		//$r7=mysql_fetch_array($get_wf);	
		while($r7=mysql_fetch_array($get_wf))
		{
			if($r[KD_WORKFLOW] == $r7[kd_workflow])
			{
				$a = 'background-color : green';
				$b = 'background-color: yellow';
				$c = 'background-color : red';
				if($r[KD_WORKFLOW] == 1)
				{
					$d=$c;
				}
				elseif($r[KD_WORKFLOW] == 2)
				{
					$d=$b;
				}
				elseif($r[KD_WORKFLOW] == 3)
				{
					$d=$a;
				}
				echo "<div align='center' style=\"$d\">$r7[status]</div>";
				
			}
			
		}	
		echo "</td>";	*/	
				/*echo"	<td align =center>";
		
		if(isset($r[ST_EPO])){
			if ($r[ST_EPO] == 2){
				echo "<div style=\"color : green\"> <b>A</b> </div>";
			}elseif ($r[ST_EPO] == 1){
				echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
			}elseif ($r[ST_EPO] == 0){
				echo "<div style=\"color : #800000\"> <b>R</b> </div>";
			}
		}else{
				echo "-"; 
		}*/
		echo "<!--</td>--><td align =center>";
		if(isset($r[ST_EPO_K])){
			if ($r[ST_EPO_K] == 2){			
				echo "<div style=\"color : green\"> <b>Approved</b> </div>";
			}elseif ($r[ST_EPO_K] == 1){
				echo "<div style=\"color : #B1BF19\"> <b>Waiting</b> </div>";
			}elseif ($r[ST_EPO_K] == 0){
				echo "<div style=\"color : #800000\"> <b>Reject</b> </div>";
			}
		}else{
				echo "-";
		} 
		echo "</td><td align =center>";
		if(isset($r[ST_EPO_KAS])){
			if ($r[ST_EPO_KAS] == 2){
				echo "<div style=\"color : green\"> <b>Approved</b> </div>";
			}elseif ($r[ST_EPO_KAS] == 1){
				echo "<div style=\"color : #B1BF19\"> <b>Waiting</b> </div>";
			}elseif ($r[ST_EPO_KAS] == 0){
				echo "<div style=\"color : #800000\"> <b>Reject</b> </div>";
			}
		}else{
				echo "-";
		} 
		
		echo "</td>
					
				<td><a href=?module=epoSib&act=lihat_epo&idt=$r[ID_SIBLING]&negara=$_GET[negara]>Lihat EPO</a></td>
		        </tr>";
      $no++;
    }
    echo "</table>";
	
	if (isset($_GET[namadiplomat]))
	{
		
		$jmldata =mysql_num_rows(mysql_query("select * from v_sibling c, v_epo_sib a  where a.ID_SIBLING=c.ID_SIBLING and c.NEGARA like '".$neg."%' and c.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%'"));
				
	}else{
		
		$jmldata =mysql_num_rows(mysql_query("select * from v_sibling c, v_epo_sib a  where a.ID_SIBLING=c.ID_SIBLING and c.NEGARA like '".$neg."%' "));
		
	}
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
		
    $ilink = "?module=epoSib&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]"; 
   
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;

 
  case "lihat_epo":

	
	$idt = $_GET[idt];
	$sql="select ID_SIBLING,ID_DIPLOMAT,ID_NEGARA,ID_JNS_PASPOR,ID_JNS_VISA,NM_SIBLING,NM_DIPLOMAT,
TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,FOTO_TTD, PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR, NM_JNS_RELASI,
PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,
VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,
NO_SPONSOR,ST_VISA from v_sibling where ID_SIBLING = $idt";
	//ECHO $sql;
     $input = mysql_query($sql);
	$r    = mysql_fetch_array($input);
	 echo "<h2 >EPO Sibling- Lihat</h2>";
	 echo "	<table width=100%>
          <tr><td  width=160>Asal Negara</td>  <td > : ";
           
			
	$detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_sibling a where a.ID_SIBLING = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_sibling b where b.ID_SIBLING = $idt)");	
	$det    = mysql_fetch_array($detil);
	$foto=$r[FOTO];
	$foto_ttd=$r[FOTO_TTD];
	  
	   $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA='".$r['ID_NEGARA']."' ORDER BY ID_NEGARA");
       $w=mysql_fetch_array($tampil);

    echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto sibling/$r[FOTO]\" width=110 height=150 border=1><img src=\"../foto sibling/ttd/$r[FOTO_TTD]\" width=110 height=100% border=1> </div>
	<br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br><br>";

	$detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,b.KD_JNS_PERMIT from permit_sibling a left join m_jns_permit b on a.ID_JNS_PERMIT = b. ID_JNS_PERMIT where a.id_sibling= $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_sibling b where b.id_sibling = $idt) ");	
	$det    = mysql_fetch_array($detil);

	echo "<b>Stay Permit </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No IzinPermit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";


	
	echo "
	</td>
	  <tr><td>Nama Sibling / Relasi</td>     <td> : $r[NM_SIBLING] / $r[NM_JNS_RELASI]</td></tr>"; 
		if (!empty($r['NM_DIPLOMAT'])) { echo "<tr><td>Nama Diplomat </td>     <td> : $r[NM_DIPLOMAT]</td></tr>"; }
		echo "<tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : ";
		if ($r[JK]=='l'){
		echo "Laki-laki";}else
		{echo "Perempuan";	}
		echo "</td> </tr>
		<tr><td>Pekerjaan</td >  <td > : $r[PEKERJAAN]</td></tr>
		<tr><td>Status Sipil</td>     <td  > : "; 
		
		if ($r[ST_SIPIL]=='m'){
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

	$sql=("select a.ID_EPO_S,a.ID_SIBLING,a.NO_EPO,a.TGL_AWAL_EPO,a.TGL_AKHIR_EPO, b.NM_SIBLING, a.ST_EPO,a.ST_EPO_K,a.ST_EPO_KAS, a.KD_WORKFLOW from epo_sibling a, sibling b where a.ID_SIBLING = b.ID_SIBLING and b.ID_SIBLING = $idt and a.KD_WORKFLOW>=1 order by  a.TGL_AKHIR_EPO desc limit 0,1 ");
		
		//echo $sql; exit;
		
		$tampil=mysql_query($sql);
		$r=mysql_fetch_array($tampil);
		if(($r[ST_EPO_K] == 2) and ($r[ST_EPO_KAS] == 2) and ($r[KD_WORKFLOW]) == 3) {
 		?>
		<form method=POST enctype="multipart/form-data" action="./report.php?go=epoSib">
         
		<input type=hidden name="idt" value="<?php echo $idt; ?>">
       	  
		  <DIV id="tgl"> Tanggal Cetak EPO<script>DateInput('TGL_CETAK', true, 'YYYY-MM-DD')</script></div>
		  <!--<input type=radio name="opsi" checked="checked" value="A4" ><font> <b>A4</b> </font>-->
		  <input type=radio name="opsi" checked="checked" value="kartu" ><font> <b>Kartu</b> </font>
		  <input type="submit" value="Cetak" target="_blank" onclick="location.href=./report.php?go=epoSib&idt=<?php echo $idt; ?>">
		   <!--<input type=button value='Tambah' onclick=location.href='?module=epoSib&act=tambah_epo&idt=<?php echo $idt; ?>&negara=<?php echo $_GET[negara];?>'>-->
		  
		
        
		 
		</form>
		<?php
		} else {
		?>
		  
		  <DIV id=\"tgl\"> Tanggal Cetak EPO<script>DateInput('TGL_CETAK', true, 'YYYY-MM-DD')</script></div>
		  <!--<input type=radio name='opsi' checked="checked" value="A4" ><font> <b>A4</b> </font>-->
		  <input type=radio name='opsi' value="kartu" checked="checked"><font> <b>Kartu</b> </font>
		   
		  <input type=submit value='Cetak' onClick="return alert('Cetak EPO Gagal. EPO harus disetujui oleh KASUBDIT dan KASIE')">
		   <!--<input type=button value='Tambah' onclick=location.href='?module=epoSib&act=tambah_epo&idt=<?php echo $idt; ?>&negara=<?php echo $_GET[negara];?>'>-->
		<?php 
		}
		
      echo "
		 <table width=100%>
		   <tr><th  width=30>no</th><th>No Pendaftaran</th><th>Status</th><th>Verifikator</th><th >NO EPO</th><th width=70>Tanggal Awal</th><th width=70>Tanggal Akhir</th><!--<th width=30>DIREKTUR</th>--><th width=30>KASUBDIT</th><th width=30>KASIE</th><th width=60>AKSI</th></tr>"; 

    $p      = new Paging;
    $batas  = 200;
    $posisi = $p->cariPosisi($batas);

   /* $sql=("
	select ID_CETAK,ID_DIPLOMAT,ID_JNS_CETAK_KARTU,ID_CARD,TGL_AWAL_CARD,TGL_AKHIR_CARD,COUNTER_CETAK, NM_JNS_CETAK_KARTU,NM_DIPLOMAT,
	ST_KARTU,ST_KARTU_K,ST_KARTU_KAS,STATUS_PENGEMBALIAN, ID_PERMIT, NO_DAFTAR, STATUS_WORKFLOW  from  v_id_card_w_permit where ID_DIPLOMAT = $idt and KD_WORKFLOW>=1 order by  ID_CETAK "); */
	
	 $sql=("
	select ID_EPO_S,ID_SIBLING,NO_EPO,TGL_AWAL_EPO,TGL_AKHIR_EPO,NM_SIBLING,
	ST_EPO,ST_EPO_K,ST_EPO_KAS,NO_DAFTAR, STATUS_WORKFLOW,USER_VERIFIKASI,TGL_VERIFIKASI  from  v_epo_sib where ID_SIBLING = $idt and KD_WORKFLOW>=1 order by  ID_EPO_S ");
	
	//print_r($sql);exit;
		$tampil=mysql_query($sql);
	$no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
	
	/*  --- status pengembalian ID Card
	
	if ($r['STATUS_PENGEMBALIAN']=='SUDAH'){
		$stat='2';
		$stat_txt = "SUDAH";
	}else {
		$stat='1';
		$stat_txt = "BELUM";
	} */
	
	
      echo "<tr><td>$no</td>
                <td>$r[NO_DAFTAR]</td>
                <td>$r[STATUS_WORKFLOW]</td>
				<td>$r[USER_VERIFIKASI] $r[TGL_VERIFIKASI]</td>
                <!--<td>$r[NM_JNS_CETAK_KARTU]</td>-->
				<td>$r[NO_EPO]</td> ";
				if ($r[TGL_AWAL_EPO]!=NULL) { echo "<td>".date('d-m-Y' ,strtotime($r[TGL_AWAL_EPO]))."</td>";} else {echo "<td>-</td>";}
				if ($r[TGL_AKHIR_EPO]!=NULL) { echo "<td>".date('d-m-Y' ,strtotime($r[TGL_AKHIR_EPO]))."</td>"; } else {echo "<td>-</td>";}
	  echo      "<!--<td align='center'><b>$stat_txt</b></td>
				<td align =center>$r[COUNTER_CETAK]</td>-->";
			
		/*echo "<td align =center>";
		
		if ($r[ST_EPO] == 2){
			
			echo "<div style=\"color : green\"> <b>A</b> </div>";
		}elseif ($r[ST_EPO] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
		}elseif ($r[ST_EPO] == 0){
		
			echo "<div style=\"color : #800000\"> <b>R</b> </div>";
		} */
		
		echo "<!--</td>--><td align =center>";

	if ($r[ST_EPO_K] == 2){
			
			echo "<div style=\"color : green\"> <b>Approved</b> </div>";
		}elseif ($r[ST_EPO_K] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>Waiting</b> </div>";
		}elseif ($r[ST_EPO_K] == 0){
		
			echo "<div style=\"color : #800000\"> <b>Rejected</b> </div>";
		}
		
		echo "</td>";
		echo "</td><td align =center>";

	if ($r[ST_EPO_KAS] == 2){
			
			echo "<div style=\"color : green\"> <b>Approved</b> </div>";
		}elseif ($r[ST_EPO_KAS] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>Waiting</b> </div>";
		}elseif ($r[ST_EPO_KAS] == 0){
		
			echo "<div style=\"color : #800000\"> <b>Rejected</b> </div>";
		}
		
		echo "</td>";
		
		/*echo "<td align =center>";

	if ($r[ST_KARTU_KAS] == 2){
			echo "<div style=\"color : green\"> <b>A</b> </div>";
		}elseif ($r[ST_KARTU_KAS] == 1){
			echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
		}elseif ($r[ST_KARTU_KAS] == 0){
			echo "<div style=\"color : #800000\"> <b>R</b> </div>";
		}
		echo "</td>*/
					echo"
				<td><a href=?module=epoSib&act=edit_epo&idt=$r[ID_PERMIT]&idc=$r[ID_EPO_S]&idd=$idt&negara=$_GET[negara]>Edit</a>
		            <!-- | <a href=./aksi_epo_sib.php?module=epoSib&act=hapus&idt=$r[ID_PERMIT]&idc=$r[ID_EPO_S]&idd=$idt&negara=$_GET[negara] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus EPO $r[ID_EPO_S]?')\">Hapus</a>--></td>
				</tr>";

      $no++;
    }
    echo "</table>";

	break;
	
 case "tambah_epo":
	$idt = $_GET[idt];
	$sql="select ID_SIBLING,ID_DIPLOMAT,ID_NEGARA,ID_JNS_PASPOR,ID_JNS_VISA,NM_SIBLING,NM_DIPLOMAT,
TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,FOTO_TTD, PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR, NM_JNS_RELASI,
PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,
VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,
NO_SPONSOR,ST_VISA from v_sibling where ID_SIBLING = $idt";
	//ECHO $sql;
     $input = mysql_query($sql);
	$r    = mysql_fetch_array($input);
	 echo "<h2 >EPO Sibling- Lihat</h2>";
	 echo "	<table width=100%>
          <tr><td  width=160>Asal Negara</td>  <td > : ";
           
			
	$detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_sibling a where a.ID_SIBLING = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_sibling b where b.ID_SIBLING = $idt)");	
	$det    = mysql_fetch_array($detil);
	$foto=$r[FOTO];
	$foto_ttd=$r[FOTO_TTD];
	  
	   $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA='".$r['ID_NEGARA']."' ORDER BY ID_NEGARA");
       $w=mysql_fetch_array($tampil);

    echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto sibling/$r[FOTO]\" width=110 height=150 border=1><img src=\"../foto sibling/ttd/$r[FOTO_TTD]\" width=110 height=100% border=1> </div>
	<br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br><br>";

	$detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,b.KD_JNS_PERMIT from permit_sibling a left join m_jns_permit b on a.ID_JNS_PERMIT = b. ID_JNS_PERMIT where a.id_sibling= $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_sibling b where b.id_sibling = $idt) ");	
	$det    = mysql_fetch_array($detil);

	echo "<b>Stay Permit </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No IzinPermit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";


	
	echo "
	</td>
	  <tr><td>Nama Sibling / Relasi</td>     <td> : $r[NM_SIBLING] / $r[NM_JNS_RELASI]</td></tr>"; 
		if (!empty($r['NM_DIPLOMAT'])) { echo "<tr><td>Nama Diplomat </td>     <td> : $r[NM_DIPLOMAT]</td></tr>"; }
		echo "<tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : ";
		if ($r[JK]=='l'){
		echo "Laki-laki";}else
		{echo "Perempuan";	}
		echo "</td> </tr>
		<tr><td>Pekerjaan</td >  <td > : $r[PEKERJAAN]</td></tr>
		<tr><td>Status Sipil</td>     <td  > : "; 
		
		if ($r[ST_SIPIL]=='m'){
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


	echo "<form method=POST enctype='multipart/form-data' action='./aksi_epo_sib.php?module=epoSib&act=input&negara=$_GET[negara]'>
          <input type=hidden name=ID_SIBLING value='$r[ID_SIBLING]'>
		  <table width=100%>		  		 
		  
        "; 
		$tampil=mysql_query("SELECT * FROM m_syarat where jenis_izin='7'");
	echo "<tr><td>Persyaratan</td>     <td> ";
	while ($data=mysql_fetch_array($tampil)) {
		
		echo "<input type=checkbox name='syarat[]' value='$data[syarat_kd]'> $data[syarat_nama] <br>";
	}
	echo "</td></tr>";
	
	echo"
        <tr><td>No EPO</td>     <td> : <input type=text name='NO_EPO' size=50  ></td></tr>
		<tr><td>Tanggal Awal EPO</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AWAL_CARD', true, 'YYYY-MM-DD')</script></div></td></tr>
		<tr><td>Tanggal Akhir EPO</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR_CARD', true, 'YYYY-MM-DD')</script></div></td></tr>
		<!--<tr><td>Counter Cetak</td>     <td> : <input type=text name='COUNTER_CETAK' size=100  ></td></tr>-->
		<tr><td colspan=2 align=right><input type=submit value=Simpan>
              <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table></form>";
 break;
 case "edit_epo":
	$idt = $_GET[idt];
	$idc = $_GET[idc];
	$idd = $_GET[idd];
	/*
   $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idd  ");
   */
   $input=mysql_query("select ID_SIBLING,ID_DIPLOMAT,ID_NEGARA,ID_JNS_PASPOR,ID_JNS_VISA,NM_SIBLING,NM_DIPLOMAT,
	TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,FOTO_TTD, PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR, NM_JNS_RELASI,
	PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,
	VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,
	NO_SPONSOR,ST_VISA from v_sibling where ID_SIBLING = $idd");
	
   
   	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >EPO Sibling- Edit</h2>";
	 echo "	  <table width=100%>
          <tr><td  width=160>Kewarganegaraan</td>  <td > : ";
            $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
            $w=mysql_fetch_array($tampil);
			

	$detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_sibling a where a.ID_SIBLING = $idd and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_sibling b where b.ID_SIBLING = $idd)");	
	
	
	$det    = mysql_fetch_array($detil);

    echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto sibling/$r[FOTO]\" width=110 height=150 border=1> </div>
	<br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br><br>";

	$detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,b.KD_JNS_PERMIT from permit_sibling a left join m_jns_permit b on a.ID_JNS_PERMIT = b. ID_JNS_PERMIT where a.id_sibling= $idd and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_sibling b where b.id_sibling = $idd) ");	
	
	$det    = mysql_fetch_array($detil);

	echo "<b>Stay Permit </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No Izin Permit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";
	
	
	
	echo "
	</td>
	  <tr><td>Nama Sibling / Relasi</td>     <td> : $r[NM_SIBLING] / $r[NM_JNS_RELASI]</td></tr>"; 
		if (!empty($r['NM_DIPLOMAT'])) { echo "<tr><td>Nama Diplomat </td>     <td> : $r[NM_DIPLOMAT]</td></tr>"; }
		echo "<tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : ";
		if ($r[JK]=='l'){
		echo "Laki-laki";}else
		{echo "Perempuan";	}
		echo "</td> </tr>
		<tr><td>Pekerjaan</td >  <td > : $r[PEKERJAAN]</td></tr>
		<tr><td>Status Sipil</td>     <td  > : "; 
		
		if ($r[ST_SIPIL]=='m'){
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


	/*$sql = ("select  ID_CETAK,ID_DIPLOMAT,ID_JNS_CETAK_KARTU,ID_CARD,TGL_AWAL_CARD,TGL_AMBIL_BERKAS,TGL_AKHIR_CARD,COUNTER_CETAK,STATUS_PENGEMBALIAN,
	KETERANGAN, NO_DAFTAR from v_id_card_w_permit where ID_CETAK = $idc ");  */
	
	$sql = ("select ID_EPO_S,ID_SIBLING,NO_EPO,TGL_AWAL_EPO,TGL_AKHIR_EPO,TGL_AMBIL_EPO,KET, NO_DAFTAR, NO_SERI_STIKER, TGL_KEBERANGKATAN from v_epo_sib where ID_EPO_S = $idc ");
	
	//echo "$sql";exit;
	$edit = mysql_query($sql);  

	
	$r    = mysql_fetch_array($edit);
	//print_r($r);
	echo "<form method=POST enctype='multipart/form-data' action='./aksi_epo_sib.php?module=epoSib&act=update&idt=$idt&idc=$idc&negara=$_GET[negara]'>
          <input type=hidden name=ID_SIBLING value='$r[ID_SIBLING]'>
			<input type=hidden name=ID_EPO value='$r[ID_EPO_S]'>

		  <table width=100%>
		   <tr><td  width=120>No Pendaftaran</td>  <td > : $r[NO_DAFTAR]</td></tr>				 
		  ";
 		echo "<tr><td>Persyaratan</td>     <td> ";
		$tampil=mysql_query("SELECT * FROM syarat_epo a right join m_syarat b on  a.syarat_kd=b.syarat_kd where b.jenis_izin='7' and a.ID_EPO='".$_GET['idc']."'");
		
		while ($data=mysql_fetch_array($tampil)) {
			if ($data['file'] !="")
			{
				//echo "<input type=checkbox disabled checked=checked name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <a target='_blank' href='/foto/syarat/$data[file]'>Lihat Berkas</a><br>";
			}else
			{
				//echo "<input type=checkbox disabled name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <br>";
			
			}
		}
			$tampil=mysql_query("SELECT * FROM syarat_epo a right join m_syarat b on  a.syarat_kd=b.syarat_kd where b.jenis_izin='7' and a.ID_EPO='".$_GET['idc']."'");
	
		while ($data=mysql_fetch_array($tampil)) {
			if ($data['file'] !="")
			{
				echo "<input type=checkbox disabled checked=checked name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <a target='_blank' href='/upload/epo/$data[file]'>Lihat Berkas</a><br>";
			}else
			{
				echo "<input type=checkbox disabled name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <br>";
			
			}
		}	
		
		
	/* } */
	echo "</td></tr>";
	echo "</td></tr> <tr><td  width=120>Tanggal Berangkat</td>  <td > : ";  echo date('d M Y',strtotime($r[TGL_KEBERANGKATAN])); echo "</td></tr>	";
	if (empty($r[NO_EPO])) {
		$tahun = date ('y');
		
		$query=mysql_query("select a.THN_AGENDA as THN,a.KODE_AGENDA as KODE_AGENDA,c.KD_JNS_PASPOR as KD_PASPOR, b.ID_JNS_PASPOR as ID_JNS_PASPOR, a.TIPE_VISA as TIPE_VISA from epo_sibling a, sibling b, m_jns_paspor c where a.id_sibling=b.id_sibling and b.ID_JNS_PASPOR=c.ID_JNS_PASPOR and a.ID_EPO_S='".$_GET['idc']."'"); 
		$data=mysql_fetch_array($query);
		$kd_agenda=$data['KODE_AGENDA'];
		$kd_paspor=$data['KD_PASPOR'];
		$tipe_visa = $data['TIPE_VISA'];

		//$urutan=mysql_query("select a.NO_EPO from epo_sibling a, sibling b where b.ID_JNS_PASPOR=$data[ID_JNS_PASPOR] and a.NO_EPO IS NOT NULL order by a.ID_EPO_S DESC LIMIT 1");
		
		//print_r($nomor);exit;
		//echo "$kode";exit;
		$d_selected='';
		$s_selected='';
	
	$pilih_visa='';
	echo "<tr><td>No EPO</td>     <td> : <input type=text name='NO_EPO' id='NO_EPO' size=50  readonly>";
	
	}else {
	$pilih_visa='hidden';
	echo "<tr><td>No EPO</td>     <td> : <input type=text name='NO_EPO' size=50  value='$r[NO_EPO]' readonly >";
	}
	if ($tipe_visa=='D'){ $d_selected='selected';}else{$s_selected='selected';}
	echo "&nbsp;&nbsp;
	<div style='float:right;width=50px' $pilih_visa>Jenis Visa &nbsp;:&nbsp; <select name='tipe_visa' id='tipe_visa' ><option value='D' $d_selected>D</option><option value='S' $s_selected>S</option></select></div></td></tr>";
	
	
	echo "	  <tr><td>No Seri Stiker</td>     <td> : <input type=text name='NO_SERI_STIKER' size=50  value='$r[NO_SERI_STIKER]'  ></td></tr>";
	/*
	echo "	  <tr><td>Tanggal Awal EPO</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AWAL_EPO', true, 'YYYY-MM-DD'
	";	
	if($r[TGL_AWAL_EPO]){ echo ",'$r[TGL_AWAL_EPO]'"; }
	echo ")</script></div></td></tr>
	*/
	echo "	<tr><td>Tanggal Akhir EPO</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR_EPO', true, 'YYYY-MM-DD'
	";	
	if($r[TGL_AKHIR_EPO]){ echo ",'$r[TGL_AKHIR_EPO]'"; }
	echo  ")</script></div></td></tr>";
	//echo "<tr><td>Tanggal Ambil epo</td> <td> <DIV id=\"tgl\">"; if (empty($r[TGL_AMBIL_EPO])) {echo "<script>DateInput('TGL_AMBIL_EPO', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script>";} else { echo "<script>DateInput('TGL_AMBIL_EPO', true, 'YYYY-MM-DD','$r[TGL_AMBIL_EPO]')</script>"; } echo"</div> <strong><div style='font-size:15px;color:red;'>&nbsp;Perhatikan saat pengisian Tanggal Ambil Berkas ('Jangan Sampai Salah')</div></strong></td></tr>";

	echo  " 	
		<tr><td>Tanggal Ambil EPO</td> <td> <DIV id=\"tgl\">"; if (empty($r[TGL_AMBIL_EPO])) {echo "<script>DateInput('TGL_AMBIL_EPO', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script>";} else { echo "<script>DateInput('TGL_AMBIL_EPO', true, 'YYYY-MM-DD','$r[TGL_AMBIL_EPO]')</script>"; } echo"</div> <strong><div style='font-size:15px;color:red;'>&nbsp;Perhatian: Isi Tanggal Pengambilan EPO dengan Benar!</div></strong></td></tr>

		<!--<tr><td>Counter Cetak</td>     <td> : <input type=text name='COUNTER_CETAK' size=100  value= '$r[COUNTER_CETAK]' ></td></tr>-->
		";
		$get_kdwf = mysql_query("select * from epo_sibling where ID_EPO_S = $idc");
		$r6    = mysql_fetch_array($get_kdwf);
			if ($r6['KD_WORKFLOW'] >= 3)
			{
			$lolosver =  'CHECKED';	
			}
			else if($r6['KD_WORKFLOW'] == 1)
			{
			$gagalver = 'CHECKED';
			}
		echo "
		<tr><td>Verifikasi</td>     
		<td> : <input type=radio id='statusverifikasi' name='statusverifikasi' value=2 $lolosver> Lolos  
		<input type=radio id='statusverifikasi' name='statusverifikasi' value=1 $gagalver> Tidak Lolos</td></tr>
		<tr><td>Keterangan </td>     <td > : <textarea name='keterangan' rows=2 cols=48 
			 >$r6[KET]</textarea></td></tr>
		<tr><td colspan=2 align=right><input type=submit value=Simpan>
              <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table></form>";

	
 break;
  case "cari":
    $alf = $_GET[huruf];
	  



	  echo "<br><br><a style=\"font-size: 22pt;\">$alf</a>";
	echo "<h2>EPO - Pilih Negara</h2>
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
				&nbsp <a href=?module=epoSib&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";
		
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
$(document).ready(function(){
	var visa = $('#tipe_visa').val();
	var idc = <?=$_GET['idc']?>;
	
	$.ajax({
            url     : "./aksi_epo_sib.php?module=epoSib&act=check_no&visa="+visa+"&idc="+idc,
            data    : { visa : visa },
            type    : 'POST',
            success : function(data){
				
				$('#NO_EPO').val(data)
				
                
            }
        });
	
	$('#tipe_visa').change(function() {
		var visa = $('#tipe_visa').val();
		var NO_EPO = $('#NO_EPO').val();
        $.ajax({
            url     : "./aksi_epo_sib.php?module=epoSib&act=check_no&visa="+visa+"&idc="+idc,
            data    : { visa : visa },
            type    : 'POST',
            success : function(data){
				
				//var nomor = "KAF/"+<?=json_encode($sekarang); ?>+"/"+<?=json_encode($kd_agenda); ?>+"/"+visa+"/"+data;
				$('#NO_EPO').val(data)
				
                
            }
        });
	});
	
});

</script>