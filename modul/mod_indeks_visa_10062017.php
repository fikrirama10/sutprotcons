<style> #tombol {border: none;} </style>
<?php
	  // echo "<br><a href=?module=staypermit&act=cari&huruf=A>A</A> |	<a href=?module=staypermit&act=cari&huruf=B>B</A> |	<a href=?module=staypermit&act=cari&huruf=C>C</A> |	<a href=?module=staypermit&act=cari&huruf=D>D</A> |	<a href=?module=staypermit&act=cari&huruf=E>E</A> |	<a href=?module=staypermit&act=cari&huruf=F>F</A> |	<a href=?module=staypermit&act=cari&huruf=G>G</A> |	<a href=?module=staypermit&act=cari&huruf=H>H</A> |	<a href=?module=staypermit&act=cari&huruf=I>I</A> |	<a href=?module=staypermit&act=cari&huruf=J>J</A> |	<a href=?module=staypermit&act=cari&huruf=K>K</A> |	<a href=?module=staypermit&act=cari&huruf=L>L</A> |	<a href=?module=staypermit&act=cari&huruf=M>M</A> |	<a href=?module=staypermit&act=cari&huruf=N>N</A> |	<a href=?module=staypermit&act=cari&huruf=O>O</A> |	<a href=?module=staypermit&act=cari&huruf=P>P</A> |	<a href=?module=staypermit&act=cari&huruf=Q>Q</A> |	<a href=?module=staypermit&act=cari&huruf=R>R</A> |	<a href=?module=staypermit&act=cari&huruf=S>S</A> |	<a href=?module=staypermit&act=cari&huruf=T>T</A> |	<a href=?module=staypermit&act=cari&huruf=U>U</A> |	<a href=?module=staypermit&act=cari&huruf=V>V</A> |	<a href=?module=staypermit&act=cari&huruf=W>W</A> |	<a href=?module=staypermit&act=cari&huruf=X>X</A> |	<a href=?module=staypermit&act=cari&huruf=Y>Y</A> |	<a href=?module=staypermit&act=cari&huruf=Z>Z</A>";
		
		$sql_pwk="select a.id_perwakilan,a.perwakilan,a.negara,b.nm_regional from tbl_perwakilan a left join tbl_regional b on a.id_regional = b.id_regional";
		$tampil_pwk=mysql_query($sql_pwk);
		
		$sql_visa="select * from m_jns_visa where ID_JNS_VISA = 2 OR ID_JNS_VISA = 3 OR ID_JNS_VISA = 4 OR ID_JNS_VISA = 5 
		OR ID_JNS_VISA = 6 OR ID_JNS_VISA = 7 OR ID_JNS_VISA = 8 OR ID_JNS_VISA = 9 OR ID_JNS_VISA = 10 OR ID_JNS_VISA = 25 
		OR ID_JNS_VISA = 26 OR ID_JNS_VISA= 27";
		
		$tampil_visa=mysql_query($sql_visa);
		
		$sql_tipevisa="select * from tbl_tipe_visa";
		$tampil_tipevisa=mysql_query($sql_tipevisa);
		
		$sql_paspor="select * from tbl_jns_paspor";
		$tampil_paspor=mysql_query($sql_paspor);
		
		$sql_status="select * from tbl_ref_status where id != 3";
		$tampil_status=mysql_query($sql_status);
		
		$sql_status1="select * from tbl_ref_status";
		$tampil_status1=mysql_query($sql_status1);
		
		
		
		
		$sql_listvisa = "select * from tbl_trans_otvis";
		$tampilvisa= mysql_query($sql_listvisa);
		$listvisa = mysql_fetch_array($tampilvisa);
switch($_GET[act]){
  default:		    
		if (isset($_GET['negara'])) {
			$negaranya = $_GET['negara'];
			if ($_GET['negara'] == ""){$negaranya = 'Semua negara';}
		
		}
		else
		{
		$negaranya = 'Semua negara';
		}
		//echo "<h2>Stay Permit</h2>";	
		
		
		
				
		echo "<h2>Daftar Pengajuan Visa </h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				
			<table width='300'>
			<tr>
			<td width='100'>Nama</td>
			<td width='240'>:  <input placeholder='Masukkan nama pemohon' size=25 type=text name=\"namapemohon\">
			<input type=hidden name=module value='indeksvisa'>
			
			</td>
			</tr>
			<tr>	
			<td width='100'>Indeks Visa </td>
			<td width='240'>:  
			<select name=\"indeksvisa\" id='indeksvisa'>
			<option value=''>- Silahkan Pilih -</option>
			"; 
			
				 while($val=mysql_fetch_array($tampil_visa))
				 {
					echo "<option value='$val[ID_JNS_VISA]'>$val[KD_JNS_VISA]</option>";
				 }
		
			echo"</select>
			</td>
			
			</tr>";
			
			 if ($_SESSION[G_leveluser]!=15 ){
			echo "<tr>	
			<td width='100'>Perwakilan RI </td>
			<td width='240'>:
			<select name=\"pwk\" id='pwk'>
			<option value=''>- Silahkan Pilih -</option>
			"; 
			
				 while($val=mysql_fetch_array($tampil_pwk))
				 {
					echo "<option value='$val[id_perwakilan]'>$val[perwakilan]</option>";
				 }
		
			echo"</select></td>
			</tr>";
			}
			echo "
			<tr>	
			<td width='100'>Status </td>
			<td width='240'>:  
			<select name=\"stat\" id='stat'>
			<option value=''>- Silahkan Pilih -</option>
			"; 
			
				 while($val=mysql_fetch_array($tampil_status1))
				 {
					echo "<option value='$val[id]'>$val[status]</option>";
				 }
		
			echo"</select>
			</td>
			
			</tr>
			</table>
			<input type=submit value=Cari>
			<input type=submit value=Cetak>
			</form> <br>

		  <table width=100%>
          <tr><th width=30>no</th><th width=80>NO KONSEP</th>";
		   if ($_SESSION[G_leveluser]!=15)
		   {
			echo "<th width=80>PERWAKILAN RI</th>";
		   }
		   echo "<th width=80>NAMA</th><th width=40>NO PASPOR</th><th>JENIS PASPOR</th><th>TUJUAN</th>
		   <th width=170>INDEKS VISA</th><th>CATATAN PUSAT</th><th width=80>TGL DIBUAT</th><th width=100>STATUS</th>
		   <th width=70>AKSI</th>
		  
		 </tr>";
		   
		   
		 
						
//<tr><th width=30>no</th><th width=80>NO PENDAFTARAN</th><th width=80>STATUS</th><th width=80>NO PERMIT</th><th width=40>JNS PERMIT</th><th>NAMA LENGKAP</th><th width=170>KANTOR PERWAKILAN</th><th width=170>JABATAN</th><th width=80>TGL BERLAKU</th><th width=70>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 5;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET['negara'];
   // if (!empty($neg)){
    //	$conj = " and b.negara like '".$neg."%' ";
    //} else { $conj=""; }
	if($_GET['namapemohon']!= '')
	{
		//echo 'isi';
		$ab = "'%".$_GET[namapemohon]."%'";
	}
	else
	{
		//echo 'kosong';	
		$ab = "''";
	}
	
	if($_GET['indeksvisa']!= '' && $_GET['namapemohon']!= '')
	{
		//echo 'isi';
		$ac = "AND";
	}
	else
	{
		//echo 'kosong';	
		$ac = "OR";
	}
	
	if($_GET['indeksvisa']!= '' && $_GET['pwk']!= '')
	{
		//echo 'isi1';
		$ad = "AND";
	}
	else
	{
		//echo 'kosong';	
		$ad = "OR";
	}
	if($_GET['indeksvisa']!= '' && $_GET['stat']!= '')
	{
		//echo 'isi1';
		$ae = "AND";
	}
	else
	{
		//echo 'kosong';	
		$ae = "OR";
	}
	
	
	
	
	
	
	if (isset($_GET['namapemohon']) || isset($_GET['indeksvisa']) || isset($_GET['pwk']) || isset($_GET['stat'])){
		
		if($_GET['namapemohon']!= '' && $_GET['pwk']!= '')
		{
		$sql="SELECT * FROM tbl_trans_otvis where (nama like $ab AND pwk_ri = '".$_GET[pwk]."') order by id desc limit $posisi,$batas";
		//echo $sql;
		$tampilbeda=mysql_query($sql);	
		}
		elseif($_GET['namapemohon']!= '' && $_GET['pwk']!= '' && $_GET['indeksvisa']!= '' && $_GET['stat']!= '')
		{
		$sql="SELECT * FROM tbl_trans_otvis where (nama like $ab $ac indeks_visa = '".$_GET[indeksvisa]."' $ad pwk_ri = '".$_GET[pwk]."') order by id desc limit $posisi,$batas";
		//echo $sql;
		$tampilbeda=mysql_query($sql);		
		}
		else
		{
		if($_SESSION[G_leveluser]==15 && $_GET['namapemohon']== '' && $_GET['indeksvisa']== '' && $_GET['stat']== '')
		{
			$sql="SELECT * FROM tbl_trans_otvis where pwk_ri = '".$_SESSION[G_idpwk]."' order by id desc limit $posisi,$batas";
		}
		else
		{
			$sql="SELECT * FROM tbl_trans_otvis where (nama like $ab $ac indeks_visa = '".$_GET[indeksvisa]."' $ad pwk_ri = '".$_GET[G_idpwk]."' $ae status_permohonan = '".$_GET[stat]."') order by created_date desc limit $posisi,$batas";
		}
		//echo $sql;
		$tampilbeda=mysql_query($sql);	 
		}
	
		
		//echo $sql;
	}
	else
    {
		 if ($_SESSION[G_leveluser]==10 ){
		 $stmhn_baru = 'where status_permohonan != 3';
		 }
		 else
		 {	 
		 $stmhn_baru = '';
		 }
		 
		 if ($_SESSION[G_leveluser]==15)
		 {
			$id_pwk = 'where pwk_ri = '.$_SESSION[G_idpwk]; 
		 }
		 
		// print_r($_SESSION);
		if ($_SESSION[G_leveluser]==15)
		{
		$sql = "SELECT * FROM tbl_trans_otvis $stmhn_baru $id_pwk order by no_konsep desc limit $posisi,$batas";
		}
		else
		{
		$sql = "SELECT * FROM tbl_trans_otvis $stmhn_baru $id_pwk order by created_date desc limit $posisi,$batas";
		}
		//print_r($sql);
		$tampilbeda=mysql_query($sql);
		//$ra=mysql_fetch_array($tampilbeda);
		//print_r($sql);
	}

    $no = $posisi+1;
	
	if($tampilbeda != ''){
		//print_r('ada');
		//print_r($listvisa);exit;
		 //$tampilbeda=mysql_query("SELECT * FROM tbl_trans_otvis");
         //$pwkri=mysql_query("SELECT * FROM tbl_trans_otvis");  
		while($r=mysql_fetch_array($tampilbeda)){
			
		//  echo "<tr bgcolor='$bgcolor'>";
			
				echo"<td>$no</td>
					<td>$r[no_konsep]</td>";
					if ($_SESSION[G_leveluser]!=15)
					{
						echo "<td>";
				 $sql_pwk="select a.id_perwakilan,a.perwakilan,a.negara,b.nm_regional from tbl_perwakilan a left join tbl_regional b on a.id_regional = b.id_regional";
				$tampil_pwk=mysql_query($sql_pwk);
		
			    while($val=mysql_fetch_array($tampil_pwk))
					{
						if($r['pwk_ri'] == $val['id_perwakilan'])
						{
						echo "$val[perwakilan]";
						}
						
					} 
					}
					echo"</td>";
					echo"<td><a href='#' class='cancel-action'>$r[nama]</a></td>
					<td>$r[paspor]</td>
					
					<td>";
					$sql_paspor4="select * from tbl_jns_paspor";
					$tampil_paspor4=mysql_query($sql_paspor4);
					while($val=mysql_fetch_array($tampil_paspor4))
					 {
						if($r['jns_paspor'] == $val['id'])
						{
						echo "$val[jns_paspor]";
						}
						
					 }	
					
					echo"</td>
					
					<td>$r[tujuan]</td><td>";
					if($_SESSION[G_leveluser] == 15)
					{
					$sql_visa="select * from m_jns_visa where ID_JNS_VISA = 3 OR ID_JNS_VISA = 2 OR 
					ID_JNS_VISA = 4 OR ID_JNS_VISA = 6 OR ID_JNS_VISA = 25 OR ID_JNS_VISA = 9";
					}
					else
					{
					$sql_visa="select * from m_jns_visa where ID_JNS_VISA = 2 OR ID_JNS_VISA = 3 OR ID_JNS_VISA = 4 OR ID_JNS_VISA = 5 
					OR ID_JNS_VISA = 6 OR ID_JNS_VISA = 7 OR ID_JNS_VISA = 8 OR ID_JNS_VISA = 9 OR ID_JNS_VISA = 10 OR ID_JNS_VISA = 25 
					OR ID_JNS_VISA = 26 OR ID_JNS_VISA= 27";
					}
					$tampil_visa=mysql_query($sql_visa);					
					while($val=mysql_fetch_array($tampil_visa))
					 {
						if($r['indeks_visa'] == $val['ID_JNS_VISA'])
						{
						echo "$val[NM_JNS_VISA]";
						}
						
					 }	
					// <a href=?module=staypermit&act=lihat_stay_permit&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>Kirim</a></td>";
					echo "</td>
					<td>";
					if($r[catatan])
					{
						if($r[status_permohonan] == 3)
						{
							echo "<div class='blink182' style='color : red;font-weight:bold;' >$r[catatan]</div>";
						}
						else
						{
							echo "$r[catatan]";
						}
					}
					echo "</td>
					<td>$r[created_date]</td>
					<td align='center'>";
					
					$sql_status2="select * from tbl_ref_status";
					$tampil_status2=mysql_query($sql_status2);
					while($val=mysql_fetch_array($tampil_status2))
					 {
						if($r['status_permohonan'] == $val['id'])
						{
							
							if ($r['status_permohonan'] == 1)
							{
							echo "<div style='color:green;'><b>$val[status]</b></div>";
							}
							if($r['status_permohonan'] == 2)
							{
							echo "<div style='color:red;'><b>$val[status]</b></div>";
							}
							if($r['status_permohonan'] == 3)
							{
							echo "<div style='background-color:yellow;'>$val[status]</div>";
							}
						//echo "<div style='background-color:yellow;border-style: solid;border-color: #ff0000 #0000ff;'>$val[status]</div>";
						}
						
					 }	
					
					echo "</td>";
					 if ($_SESSION[G_leveluser]!=10 ){
			
					echo "
					<td align=center>
					<a href=?module=indeksvisa&act=sunting_visa&idt=$r[no_konsep]>
					<img src='../images/edit.png'>
					</a><br>
					<a href=report.otvis.php?nokonsep=$r[no_konsep] target=_blank>
					<img src='../images/print.png'>
					</a><br>
					<a href=/modul/email_otvis.php?nokonsep=$r[no_konsep] target=_blank>
					<img src='../images/mail.png'>
					</a><br>
					<a href=/modul/brafaks_otvis.php?nokonsep=$r[no_konsep] target=_blank>
					<img src='../images/brafaks1.png'>
					</a></td>
					";
					}
					else
					{
					echo "<td align='center'><input type='button'  name='detil' onClick=loadPopupBox2(2,'$r[no_konsep]'); value='detil'></td>";
					}
			echo	"</tr>";
		  $no++;
		}
		echo "<div id=paging>$linkHalaman</div><br>";
			}
			else
			{
			//print_r('tdkada');
			echo "<tr><td colspan=12 align='center'>Tidak Ada Data</td></tr>";
			}
    echo "</table>";
	
	echo "<div id='popup_box2' style='overflow-y:scroll;' class='popup_box1'>
	";
					
	
						echo "<h2>Detil Permohonan Visa</h2>
						
						<table width='100%'>
							<tr>
								<td width='30%'>No Brafaks</td><td width='6'>:</td>
								
								<td><div id='nobra_pre'></td>
							</tr>
							<tr>
								<td width='30%'>Perwakilan RI</td><td width='6'>:</td>
								
								<td><div id='pwkri_pre'></td>
							</tr>
							<tr>
								<td width='30%'>Nama</td><td width='6'>:</td><td><div id='nama_pre'></div></td>
							</tr>
							
							<tr>
								<td width='30%'>No Paspor</td><td width='6'>:</td><td><div id='nopaspor_pre'></div></td>
							</tr>
							
							
							<tr>
								<td width='30%'>Jenis Paspor</td><td width='6'>:</td><td><div id='jns_paspor_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Tujuan</td><td width='6'>:</td><td><div id='tujuan_pre'></div></td>
							</tr>
							
							<tr>
								<td width='30%'>Tipe Visa</td><td width='6'>:</td><td><div id='tpvisa_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Indeks Visa</td><td width='6'>:</td><td><div id='indeksvisa_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Masa Penugasan</td><td width='6'>:</td><td><div id='masa_tugas_pre'></div></td>
							</tr>
							
							<tr><td width='30%'>Verifikator </td> <td> :</td><td> 
							<div id='ver_pre'></div>
							</td></tr>
							<tr><td width='30%'>Jabatan Verifikator </td> <td> :</td><td> 
							<div id='jabver_pre'></div>
							</td></tr>
							
							<tr><td width='30%'>Legalisator </td> <td> :</td><td> 
							<div id='leg_pre'></div>
							</td></tr>
							<tr><td width='30%'>Jabatan Legalisator </td> <td> :</td><td> 
							<div id='jableg_pre'></div>
							</td></tr>
							
							<tr><td width='30%'>Catatan </td> <td> :</td><td> 
							<div id='cat_pre'></div>
							</td></tr>
							<tr><td width='30%'>Status </td> <td> :</td><td> 
							<div id='stmhn_pre'></div>
							</td></tr>
							
							</tr></table>
						
						<a id='popupBoxClose' onClick='unloadPopupBox1(2);'>[X]</a>	
					</div>
						";
					
	if (isset($_GET[namadiplomat]))
	{
		$jmldata =mysql_num_rows(mysql_query("select a.id_permit from v_stay_permit a right join v_diplomat b on a.id_diplomat=b.id_diplomat where  b.negara like '".$neg."%' and b.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%'"));
	}else{
		$jmldata =mysql_num_rows(mysql_query("select a.id_permit from v_stay_permit a right join v_diplomat b on a.id_diplomat=b.id_diplomat  where  b.negara like '".$neg."%'"));
	}
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   $ilink = "?module=indeksvisa&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;

 
case "tambah_visa_old":
	$idt = $_GET[idt];
 // $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt  ");
	//$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Pengajuan Baru - Visa</h2>";
	
	
	echo "<u>Data Pemohon</u><form method=POST  onSubmit='return verify(this);' enctype='multipart/form-data' action='./aksi_stay_permit.php?module=staypermit&act=input&negara=$_GET[negara]'>
          <input type=hidden name=ID_DIPLOMAT value='$r[ID_DIPLOMAT]'>

		  <table width=100%>";
   
	echo" 
		<tr>
		<input type=hidden name='no_konsep' size=50>
		<tr>
		<tr><td  width=120>Tanggal</td>  <td > : ".date('d-m-Y')."</td>
		</tr>
		<tr><td  width=120>Sifat Berita</td>  <td > : 
		
		<select name='ID_SIFAT_BERITA'>
			<option>- Silahkan Pilih -</option>
            <option value=1 >Biasa</option>
			<option value=2 >Rahasia</option>;
		</select>
		</td>
		</tr>";
	
		  

    
	$tampil=mysql_query("SELECT * FROM m_syarat where jenis_izin='1'");
	echo "<tr><td>Perwakilan RI</td>     <td> : <select name='pwk_otvis'>
			<option>- Silahkan Pilih -</option>
			"; 
				
				 while($val=mysql_fetch_array($tampil_pwk))
				 {
					echo "<option value='$val[id_perwakilan]'>$val[perwakilan]</option>";
				 }
		
		echo "</select></td></tr>
		<tr><td>Nama Pemohon</td>     <td> : <input type=text name='nama_otvis' size=50  ></td></tr>
		<tr><td>Jenis Paspor</td>     <td> : 
		<select name='ID_JNS_PASPOR'>
			<option>- Silahkan Pilih -</option>
            <option value=1 >Dinas</option>
			<option value=2 >Diplomatik</option>;
		</select>
		</td></tr>
		
		<tr><td>No Paspor</td>     <td> : <input type=text name='nopaspor_otvis' size=50  ></td></tr>
		<tr><td>Status</td>     <td> : <input type=text name='status_otvis' placeholder='cth: Pejabat Diplomatik' size=50  ></td></tr>
		<tr><td>Gelar & Jabatan</td>     <td> : <input type=text name='gelarjabatan_otvis' size=50  ></td></tr>
		<tr><td>Posisi</td>     <td> : <input type=text name='posisi_otvis' size=50  ></td></tr>
		<tr><td>Tujuan</td>     <td> : <input type=text name='tujuan_otvis' size=50  ></td></tr>
		<tr><td>Lamanya Penugasan/Kunjungan </td>     <td> : <input type=text name='tujuan_otvis' size=10  >Tahun</td></tr>
		<tr><td>Dokumen Pendukung</td>     <td>";
		$tampil=mysql_query("SELECT * FROM m_syarat where jenis_izin='5'");
		$i=1;
		while ($data=mysql_fetch_array($tampil)) {
		echo "$data[syarat_nama] <br>";
		echo "<input type=file size=40 name=$data[syarat_kd]><hr>";
		$i++;
		}
		echo"</td></tr>
		
		
		<tr><td>Catatan</td>     <td> : 
		<textarea name='catatan_otvis' rows=2 cols=48 ></textarea>
		</td></tr>
	    <tr><td colspan=2 align=right><input type=submit value=Simpan >
   			<input type=button value=Batal onclick=self.history.back()></td></tr>
        </table></form>";
 break;

 case "tambah_visa":
	$idt = $_GET[idt];
 // $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt  ");
	//$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Pengajuan Visa</h2>";
	
	
	echo "<u>Data Pemohon</u>
		<form method=POST enctype='multipart/form-data' action='./aksi_visa_new.php?module=indeksvisa&act=input'>
         
		  <table width=100%>";
   
	echo" 
		<tr>
		<tr><td  width=120>No Konsep</td>  <td > : ";
		
		//print_r($listvisa1);
		//$n1		    = $listvisa1['id']+1;
		 $tampilbaru=mysql_query("SELECT * FROM tbl_trans_otvis");
         $apes = mysql_fetch_array($tampilbaru);  
		if($apes)
		{
			$sql_listvisa1 = "SELECT * from tbl_trans_otvis order by id desc limit 1";
			$tampilvisa1= mysql_query($sql_listvisa1);
			$listvisa1  = mysql_fetch_array($tampilvisa1);
			//print_r($listvisa1);exit;
			$n1 = $listvisa1[id]+1;
			$n2 = str_pad($n1, 7, 0, STR_PAD_LEFT);
			echo "OTVIS/$n2/KEMLU/".date('m')."/".date('Y');
			$n3 = "OTVIS/$n2/KEMLU/".date('m')."/".date('Y');
			echo "<input name='no_konsep' value='$n3' type='hidden'>";
			
		}
		else
		{
			$n2 = str_pad(1, 7, 0, STR_PAD_LEFT);
			echo "OTVIS/$n2/KEMLU/".date('m')."/".date('Y');
			echo "<input name='no_konsep' value='OTVIS/$n2/KEMLU/".date('m')."/".date('Y')."' type='hidden'>";
		}	
		
	echo "</td>
		</tr>
		<tr>
		<tr><td  width=120><u>Tanggal</u> <br> <i>Date</i></td>  <td > : 
		";
		echo date('d-m-Y');
		echo "<input name='tgl_otvis' value='".date('d-m-Y')."' type='hidden'>";
		echo"
		</td>
		</tr>
		<tr><td>No Brafaks &nbsp; <font color='red'>*</font></td>     <td> : <input type=text name='nobrafaks_otvis' id='nobrafaks_otvis' size=50  ></td></tr>
		
		";
		
	
		  

    
	$tampil=mysql_query("SELECT * FROM m_syarat where jenis_izin='1'");
	/* echo "<tr><td>Perwakilan RI &nbsp; <font color='red'>*</font></td>     
			<td> : <select name='pwk_otvis' id='pwk_otvis'>
			<option value='0'>- Silahkan Pilih -</option>
			"; 
				
				 while($val=mysql_fetch_array($tampil_pwk))
				 {
					echo "<option value='$val[id_perwakilan]'>$val[perwakilan]</option>";
				 }
		
		echo "</select></td></tr>"; */
		echo"<tr><td><u>Nama</u>&nbsp; <font color='red'>*</font><br><i>Name</i> </td>     <td> : <input type=text  name='nama_otvis' id='nama_otvis' size=50  ></td></tr>
		<tr><td><u>No Paspor</u> &nbsp; <font color='red'>*</font><br><i>Passport No.</i></td>     <td> : <input type=text name='paspor_otvis' id='paspor_otvis' size=50  ></td></tr>
		</table>
		
		<table width=100% id='anggotaFamResultList'>
		<tr><td width=120><u>Anggota Keluarga</u> <br><i>Family/Sibling</i>&nbsp; </td>     <td colspan=2> : <input type='button' name='tambah_anggota_fam' value='+ Tambah'></td></tr>
		
		</table>
		<table width=100%>
		<tr><td width=120>Jenis Paspor &nbsp; <font color='red'>*</font></td>     <td> : 
		<select name='id_tipe_paspor' id='id_tipe_paspor'>
			<option value=''>- Silahkan Pilih -</option>";
            while($val=mysql_fetch_array($tampil_paspor))
				 {
					echo "<option value='$val[id]'>$val[jns_paspor]</option>";
				 }
		echo "</select>
		</td></tr>
		<tr><td><u>Tujuan</u> &nbsp; <font color='red'>*</font><br><i>Purpose</i></td>     <td> : 
		
		<textarea name='tujuan_otvis' id='tujuan_otvis' rows=2 cols=35 ></textarea>
		</td></tr>";
		/* echo "<tr><td>Tipe Visa &nbsp; <font color='red'>*</font></td>     <td> : 
		<select name='tipevisa_otvis' id='tipevisa_otvis'>
		<option>- Silahkan Pilih -</option>
			"; 
			
				 while($val=mysql_fetch_array($tampil_tipevisa))
				 {
					echo "<option value='$val[id]'>$val[tipe_visa]</option>";
				 }
		
			echo"</select>
		</td></tr>
		<tr><td>Indeks Visa &nbsp; <font color='red'>*</font></td>     <td> : 
		<select name='indeksvisa_otvis' id='indeksvisa_otvis'>
		<option>- Silahkan Pilih -</option>
			"; 
			
				 while($val=mysql_fetch_array($tampil_visa))
				 {
					echo "<option value='$val[ID_JNS_VISA]'>$val[KD_JNS_VISA]</option>";
				 }
		
			echo"</select>
		</td>
		
		</tr>"; */
       echo "
	   <tr><td><u>Posisi</u> &nbsp; <font color='red'>*</font><br><i>Position</i></td>     
	   <td> : 
		<select name='posisi' id='posisi'>
		<option value=''>- Silahkan Pilih -</option>
		<option value='1'>Baru / New</option>
		<option value='2'>Pengganti / Replacement</option>
		</select>
		
		<div id='replacement' style='display:none;'><br>&nbsp;&nbsp;<input type=text placeholder='masukkan nama yang digantikan' id='pengganti' name='pengganti' size=50>
	   </div>
	   </td></tr>
		
	   <tr><td><u>Masa Penugasan </u>&nbsp; <font color='red'>*</font><br><i>Assignment Period</i></td>     <td> : <input type=text placeholder='masukkan dengan angka' id='masatugas_otvis' name='masatugas_otvis' size=50> Hari</td></tr>
		<tr><td>Surat Setneg &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 id='setneg_upload' name='setneg_upload'></td></tr>		
		<tr><td><u>Nota Diplomatik</u> &nbsp; <font color='red'>*</font> <br><i>Diplomatic No.</i></td>    
		<td> : <input type=text  name='no_nota_diplomatik' id='no_nota_diplomatik' size=50  ><br><br>&nbsp;&nbsp;<input type=file size=40 id='nota_diplomatik_upload' name='nota_diplomatik_upload'></td>
		";
		//<tr><td>Surat Nikah(Spouse)  </td>     <td > : <input type=file size=40 id='surat_nikah_upload' name='surat_nikah_upload'></td></tr>		
		//echo "<td>Surat Legalisasi Keppri &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 id='keppri_legal_upload' name='keppri_legal_upload'></td>";
   
		/* echo "</table>
		<table width=100% id='dasarMintaVisaResultList'>
		<tr></tr>"; */
		
		//<td width=120>Dasar Permintaan Visa &nbsp; <font color='red'>*</font></td>     <td> : <input type='button' name='tambah_minta_visa' value='+ Tambah'></td>
		
		echo "</table>";
		
		/* echo "<table width=100% id='dasarBeriVisaResultList'>
		<tr><td width=120>Dasar Pemberian Visa &nbsp; <font color='red'>*</font></td>     <td> : <input type='button' name='tambah_beri_visa' value='+ Tambah'></td></tr>
		
		</table>";	
		 */
		/*<tr><td>Dokumen Pendukung</td>     <td>";
		$tampil=mysql_query("SELECT * FROM m_syarat where jenis_izin='5'");
		$i=1;
		while ($data=mysql_fetch_array($tampil)) {
		echo "<input type=checkbox name='syarat[]' value='$data[syarat_kd]' checked>$data[syarat_nama] <br>";
		echo " Click<a><b> Here</b></a> to view<hr>";
		$i++;</td></tr>
		}*/
		/* echo"
		<table width=100%>
		<tr><td width=14%>Keputusan </td><td> :
		<select name='ID_JNS_KEPUTUSAN'>
			<option>- Silahkan Pilih -</option>
            <option value=1 >Disetujui</option>
			<option value=2 >Ditolak</option>;
		</select>
		</td></tr>
		<tr><td>Catatan</td>     <td> : 
		<textarea name='catatan_otvis' rows=2 cols=48 ></textarea>
		</td></tr>"; 
		<input type=submit value=Simpan >
		*/
	/* 	<a href='./report2.otvis.php?module=indeksvisa&act=cetak' target=_blank>
							<img src='../images/print.png'>Cetak
							</a>
							<input type='button'  name='print' id='print' value='Cetak'>
							<input type='button'  name='brafaks' value='Brafaks'> 
							
							
							<tr>
								<td width='30%'>Anggota Keluarga</td><td width='6'>:</td><td><div id='anggota_fam_pre'></div></td>
							</tr>
							
							
							<table width=100% id='dasarMintaVisaResultList1'>
							<tr><td width=30%>Dasar Permintaan Visa</td>     <td width='6'> : </td><td></td></tr>
							
							</table>
							
							<table width=100% id='dasarBeriVisaResultList1'>
							<tr></tr>
							
							</table>
							
							*/
	    echo "
		<table width=100%>
		<tr><td colspan=2 align=right>
			   		
		<input type='button' id='preview' name='preview'  value='Preview' >
		<input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>";
		
		echo "<div id='popup_box1' style='overflow-y:scroll;' class='popup_box1'>
						<h2>Preview Pengajuan Visa</h2>
						<div>
						<table width='100%'>
							
							<tr>
								<td width='30%'>Nama</td><td width='6'>:</td><td><div id='nama_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>No Paspor</td><td width='6'>:</td><td><div id='nopaspor_pre'></div></td>
							</tr>
							
							
							<tr>
								<td width='30%'>Jenis Paspor</td><td width='6'>:</td><td><div id='jns_paspor_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Tujuan</td><td width='6'>:</td><td><div id='tujuan_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Indeks Visa</td><td width='6'>:</td><td><div id='indeksvisa_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Masa Penugasan</td><td width='6'>:</td><td><div id='masa_tugas_pre'></div></td>
							</tr>
							</table>";
							if($_SESSION['G_leveluser']==14){
							echo "<table width=100%>
							
							<tr><td width='30%'>Verifikator </td> <td> :</td><td> 
							<input type=text name='verifikator' id='verifikator' size=50  >
							</td></tr>
							<tr><td width='30%'>Jabatan Verifikator </td> <td> :</td><td> 
							<input type=text name='jbt_ver' id='jbt_ver' size=50  >
							</td></tr>
							
							<tr><td width='30%'>Legalisator </td> <td> :</td><td> 
							<input type=text name='legalisator' id='legalisator' size=50  >
							</td></tr>
							<tr><td width='30%'>Jabatan Legalisator </td> <td> :</td><td> 
							<input type=text name='jbt_legal' id='jbt_legal' size=50  >
							</td></tr>
							
							<td colspan=3 align=right>
							
							
							</td>
							</tr>
						</table>";
							}
						echo"<input type='submit'  name='simpan' value='Simpan'></form>
						</div>
						<a id='popupBoxClose' onClick='unloadPopupBox1(1);'>[X]</a>	
					</div>
						";
 break;
 
 case "otorisasi_visa":
	$idt = $_GET[idt];
 // $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt  ");
	//$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Pengajuan Visa</h2>";
	
	
	echo "<u>Data Pemohon</u>
		<form method=POST  onSubmit='return verify(this);' enctype='multipart/form-data' action='./aksi_stay_permit_new.php?module=indeksvisa&act=input'>
         
		  <table width=100%>";
   
	echo" 
		<tr>
		<tr><td  width=120>No Konsep</td>  <td > : ";
		
		//print_r($listvisa1);
		//$n1		    = $listvisa1['id']+1;
		 $tampilbaru=mysql_query("SELECT * FROM tbl_trans_otvis");
         $apes = mysql_fetch_array($tampilbaru);  
		if($apes)
		{
			$sql_listvisa1 = "SELECT * from tbl_trans_otvis order by id desc limit 1";
			$tampilvisa1= mysql_query($sql_listvisa1);
			$listvisa1  = mysql_fetch_array($tampilvisa1);
			//print_r($listvisa1);exit;
			$n1 = $listvisa1[id]+1;
			$n2 = str_pad($n1, 7, 0, STR_PAD_LEFT);
			echo "OTVIS/$n2/KEMLU/".date('m')."/".date('Y');
			$n3 = "OTVIS/$n2/KEMLU/".date('m')."/".date('Y');
			echo "<input name='no_konsep' value='$n3' type='hidden'>";
			
		}
		else
		{
			$n2 = str_pad(1, 7, 0, STR_PAD_LEFT);
			echo "OTVIS/$n2/KEMLU/".date('m')."/".date('Y');
			echo "<input name='no_konsep' value='OTVIS/$n2/KEMLU/".date('m')."/".date('Y')."' type='hidden'>";
		}	
		
	echo "</td>
		</tr>
		<tr>
		<tr><td  width=120>Tanggal</td>  <td > : 
		";
		echo date('d-m-Y');
		echo "<input name='tgl_otvis' value='".date('d-m-Y')."' type='hidden'>";
		echo"
		</td>
		</tr>
		<tr><td>No Brafaks &nbsp; <font color='red'>*</font></td>     <td> : <input type=text name='nobrafaks_otvis' id='nobrafaks_otvis' size=50  ></td></tr>
		
		";
		
	
		  

    
	$tampil=mysql_query("SELECT * FROM m_syarat where jenis_izin='1'");
	echo "<tr><td>Perwakilan RI &nbsp; <font color='red'>*</font></td>     
			<td> : <select name='pwk_otvis' id='pwk_otvis'>
			<option value='0'>- Silahkan Pilih -</option>
			"; 
				
				 while($val=mysql_fetch_array($tampil_pwk))
				 {
					echo "<option value='$val[id_perwakilan]'>$val[perwakilan]</option>";
				 }
		
		echo "</select></td></tr>
		<tr><td>Nama &nbsp; <font color='red'>*</font></td>     <td> : <input type=text name='nama_otvis' id='nama_otvis' size=50  ></td></tr>
		<tr><td>No Paspor &nbsp; <font color='red'>*</font></td>     <td> : <input type=text name='paspor_otvis' id='paspor_otvis' size=50  ></td></tr>
		</table>
		
		<table width=100% id='anggotaFamResultList'>
		<tr><td width=120>Anggota Keluarga &nbsp; </td>     <td colspan=2> : <input type='button' name='tambah_anggota_fam' value='+ Tambah'></td></tr>
		
		</table>
		<table width=100%>
		<tr><td width=120>Jenis Paspor &nbsp; <font color='red'>*</font></td>     <td> : 
		<select name='id_tipe_paspor' id='id_tipe_paspor'>
			<option>- Silahkan Pilih -</option>";
            while($val=mysql_fetch_array($tampil_paspor))
				 {
					echo "<option value='$val[id]'>$val[jns_paspor]</option>";
				 }
		echo "</select>
		</td></tr>
		<tr><td>Tujuan &nbsp; <font color='red'>*</font></td>     <td> : 
		
		<textarea name='tujuan_otvis' id='tujuan_otvis' rows=2 cols=35 ></textarea>
		</td></tr>
		<tr><td>Tipe Visa &nbsp; <font color='red'>*</font></td>     <td> : 
		<select name='tipevisa_otvis' id='tipevisa_otvis'>
		<option>- Silahkan Pilih -</option>
			"; 
			
				 while($val=mysql_fetch_array($tampil_tipevisa))
				 {
					echo "<option value='$val[id]'>$val[tipe_visa]</option>";
				 }
		
			echo"</select>
		</td></tr>
		<tr><td>Indeks Visa &nbsp; <font color='red'>*</font></td>     <td> : 
		<select name='indeksvisa_otvis' id='indeksvisa_otvis'>
		<option>- Silahkan Pilih -</option>
			"; 
			
				 while($val=mysql_fetch_array($tampil_visa))
				 {
					echo "<option value='$val[ID_JNS_VISA]'>$val[KD_JNS_VISA]</option>";
				 }
		
			echo"</select>
		</td>
		
		</tr>
        <tr><td>Masa Penugasan &nbsp; <font color='red'>*</font></td>     <td> : <input type=text placeholder='masukkan dengan angka' id='masatugas_otvis' name='masatugas_otvis' size=50> Hari</td></tr>
		<tr><td>Surat Setneg &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 name=setneg_upload></td></tr>		
		<tr><td>Nota Diplomatik &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 name=nota_diplomatik_upload></td>
		<tr><td>Surat Nikah(Spouse) &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 name=surat_nikah_upload></td></tr>		
		<tr><td>Surat Legalisasi Keppri &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 name=keppri_legal_upload></td>
   
		</table>
		<table width=100% id='dasarMintaVisaResultList'>
		<tr><td width=120>Dasar Permintaan Visa &nbsp; <font color='red'>*</font></td>     <td> : <input type='button' name='tambah_minta_visa' value='+ Tambah'></td></tr>
		
		</table>
		
		<table width=100% id='dasarBeriVisaResultList'>
		<tr><td width=120>Dasar Pemberian Visa &nbsp; <font color='red'>*</font></td>     <td> : <input type='button' name='tambah_beri_visa' value='+ Tambah'></td></tr>
		
		</table>";	
		
		/*<tr><td>Dokumen Pendukung</td>     <td>";
		$tampil=mysql_query("SELECT * FROM m_syarat where jenis_izin='5'");
		$i=1;
		while ($data=mysql_fetch_array($tampil)) {
		echo "<input type=checkbox name='syarat[]' value='$data[syarat_kd]' checked>$data[syarat_nama] <br>";
		echo " Click<a><b> Here</b></a> to view<hr>";
		$i++;</td></tr>
		}*/
		/* echo"
		<table width=100%>
		<tr><td width=14%>Keputusan </td><td> :
		<select name='ID_JNS_KEPUTUSAN'>
			<option>- Silahkan Pilih -</option>
            <option value=1 >Disetujui</option>
			<option value=2 >Ditolak</option>;
		</select>
		</td></tr>
		<tr><td>Catatan</td>     <td> : 
		<textarea name='catatan_otvis' rows=2 cols=48 ></textarea>
		</td></tr>"; 
		<input type=submit value=Simpan >
		*/
	/* 	<a href='./report2.otvis.php?module=indeksvisa&act=cetak' target=_blank>
							<img src='../images/print.png'>Cetak
							</a>
							<input type='button'  name='print' id='print' value='Cetak'>
							<input type='button'  name='brafaks' value='Brafaks'> 
							
							
							<tr>
								<td width='30%'>Anggota Keluarga</td><td width='6'>:</td><td><div id='anggota_fam_pre'></div></td>
							</tr>
							
							
							<table width=100% id='dasarMintaVisaResultList1'>
							<tr><td width=30%>Dasar Permintaan Visa</td>     <td width='6'> : </td><td></td></tr>
							
							</table>
							
							<table width=100% id='dasarBeriVisaResultList1'>
							<tr></tr>
							
							</table>
							
							*/
	    echo "
		<table width=100%>
		<tr><td colspan=2 align=right>
			   		
		<input type='button'  name='preview' onClick=loadPopupBox1(1); value='Preview'>
		<input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>";
		
		echo "<div id='popup_box1' style='overflow-y:scroll;' class='popup_box1'>
						<h2>Preview Otorisasi Visa</h2>
						<div>
						<table width='100%'>
							<tr>
								<td width='30%'>Perwakilan RI</td><td width='6'>:</td><td><div id='pwkri_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Nama</td><td width='6'>:</td><td><div id='nama_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>No Paspor</td><td width='6'>:</td><td><div id='nopaspor_pre'></div></td>
							</tr>
							
							
							<tr>
								<td width='30%'>Jenis Paspor</td><td width='6'>:</td><td><div id='jns_paspor_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Tujuan</td><td width='6'>:</td><td><div id='tujuan_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Indeks Visa</td><td width='6'>:</td><td><div id='indeksvisa_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Masa Penugasan</td><td width='6'>:</td><td><div id='masa_tugas_pre'></div></td>
							</tr>
							</table>
							
							<table width=100%>
							
							<tr><td width='30%'>Verifikator </td> <td> :</td><td> 
							<input type=text name='verifikator' id='verifikator' size=50  >
							</td></tr>
							<tr><td width='30%'>Jabatan Verifikator </td> <td> :</td><td> 
							<input type=text name='jbt_ver' id='jbt_ver' size=50  >
							</td></tr>
							
							<tr><td width='30%'>Legalisator </td> <td> :</td><td> 
							<input type=text name='legalisator' id='legalisator' size=50  >
							</td></tr>
							<tr><td width='30%'>Jabatan Legalisator </td> <td> :</td><td> 
							<input type=text name='jbt_legal' id='jbt_legal' size=50  >
							</td></tr>
							
							<td colspan=3 align=right>
							
							<input type='submit'  name='simpan' value='Simpan'>
							</td>
							</tr>
						</table></form>
						</div>
						<a id='popupBoxClose' onClick='unloadPopupBox1(1);'>[X]</a>	
					</div>
						";
 break;

 
 
 
 
 case "sunting_visa":
	$idt = $_GET[idt];
	//print_r("select * from tbl_trans_otvis where no_konsep = '$idt' and pwk_ri = $_SESSION[G_idpwk]");
	if($_SESSION[G_leveluser]==15)
	{
		$where = "where no_konsep = '$idt' and pwk_ri = $_SESSION[G_idpwk]";
	}
	
	$cek_sesi  = mysql_query("select * from tbl_trans_otvis $where ");
	$cek_sesi2 = mysql_num_rows($cek_sesi);
	//print_r($cek_sesi2);
	if($cek_sesi2 == 0)
	{
		
		?>
		<script>
		alert('Anda tidak bisa mengakses pengajuan visa ini');
		</script>
		
		
	<?php 
	if($_SESSION[G_leveluser]!=14 || $_SESSION[G_leveluser]!=15)
	{
	 echo '<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Anda tidak diperbolehkan mengakses halaman ini (Akses Terbatas).</b><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>';
	}
		//exit;
		//header('location: ./deplu.php?module=indeksvisa');
		//redirect('https://sitprotkons.kemlu.go.id/modul/deplu.php?module=indeksvisa');
		//header('Location: ' . '/deplu.php?module=indeksvisa');
		//die;
	 if($_POST['simpan']=='Simpan')
	 {
	 echo '<p style=\"font-size: 10pt\"><br> <b style=\"color : #800000\">Update Data Gagal ( Akses Terbatas).</b><br><a  onclick=self.history.back()><b><u>Kembali</u></b></a></p>';
	 }
	}
	else if($_SESSION[G_leveluser]==14 || $_SESSION[G_leveluser]==15)
	{
    $input = mysql_query("select * from tbl_trans_otvis where no_konsep = '$idt'");
	$r    = mysql_fetch_array($input);
	
	 echo "<h2 >Edit Pengajuan Visa</h2>";
	
	
	echo "<u>Data Pemohon</u>
		<form method=POST enctype='multipart/form-data' action='./aksi_visa_new.php?module=indeksvisa&act=update&idt=$r[no_konsep]'>
         
		  <table width=100%>";
   
	echo" 
		<tr>
		<tr><td  width=120>No Konsep</td>  <td > : $r[no_konsep]</td>
		</tr>
		<tr>
		<tr><td  width=120><u>Tanggal</u> <br> <i>Date</i></td>  <td > : 
		";
		echo date('d-m-Y',strtotime($r[created_date]));
		echo "<input name='tgl_otvis' value='".date('d-m-Y')."' type='hidden'>";
		echo"
		</td>
		</tr>
		<tr><td>No Brafaks &nbsp; <font color='red'>*</font></td>     <td> : <input type=text name='nobrafaks_otvis' value='$r[no_brafaks]' id='nobrafaks_otvis' size=50  ></td></tr>
		
		";
		
	
		  

    
	$tampil=mysql_query("SELECT * FROM m_syarat where jenis_izin='1'");
	if($_SESSION[G_leveluser]!=15)
	{
	echo "<tr><td>Perwakilan RI &nbsp; <font color='red'>*</font></td>     <td> : <select name='pwk_otvis' id='pwk_otvis'>
			<option>- Silahkan Pilih -</option>
			"; 
				
				 while($val=mysql_fetch_array($tampil_pwk))
				 {
					echo "<option value='$val[id_perwakilan]'";
					if($r[pwk_ri] == $val[id_perwakilan])
					{
						echo 'selected';
					}
					echo ">$val[perwakilan]</option>";
				 }
		
		echo "</select>
		
		</td></tr>";
	}
		echo"<tr>
		<input type=hidden name='pwk_otvis3' id='pwk_otvis3' size=50  value='$r[pwk_ri]'>
		<input type=hidden name='pwk_otvis2' id='pwk_otvis2' size=50  value='$_SESSION[G_idpwk]'>
		<td><u>Nama</u>&nbsp; <font color='red'>*</font><br><i>Name</i> </td>     <td> : <input type=text name='nama_otvis' value='$r[nama]' id='nama_otvis' size=50  ></td></tr>
		<tr><td><u>No Paspor</u> &nbsp; <font color='red'>*</font><br><i>Passport No.</i></td>     <td> : <input type=text name='paspor_otvis' value='$r[paspor]' id='paspor_otvis' size=50  ></td></tr>
		
		<table width=100% id='anggotaFamResultList'>
		<tr><td width=120><u>Anggota Keluarga</u> <br><i>Family / Sibling</i></td>     <td colspan='2'> : <input type='button' name='tambah_anggota_fam' value='+ Tambah'></td></tr>
		";
		
		$sql_fam="select * from tbl_anggota_fam where no_konsep = '$r[no_konsep]'";
		$tampil_fam=mysql_query($sql_fam);
		$h=1;
		 while($val=mysql_fetch_array($tampil_fam))
			{
				if($val[relasi] == 'suami')
				{
					$a = 'selected';
				}
				if($val[relasi] == 'istri')
				{
					$b = 'selected';
				}
				if($val[relasi] == 'anak')
				{
					$c = 'selected';
				}
			echo "<tr id='rowIdw$h'><td></td><td width='10px;'> $val[urutan]. </td><td> Nama &nbsp;&nbsp;: <input size=25 class='inputIdw$h' type='text' value = '$val[nama]' id='inputanggotafam_nama' name='anggota_fam[$h][anggotafam_nama]'><span id='$h' class='btn btn-danger remove-me4 w$h' value='$h' >  <input type='button' value='x'></span> <br> Relasi &nbsp;&nbsp;: 
				  <select class='inputIdw$h' name='anggota_fam[$h][anggotafam_relasi]' id='inputanggotafam_relasi'><option>- Silahkan Pilih -</option><option value='suami' $a>Suami</option><option value='istri' $b>Istri</option><option value='anak' $c>Anak</option></select>  <br> Paspor : <input size=25 class='inputIdw$h' type='text'  id='inputanggotafam_nopaspor' value = '$val[nopaspor]' name='anggota_fam[$h][anggotafam_nopaspor]'></td></tr>";
			$h++;
			}
		echo"</table>
		
		<table width=100%>
		<tr><td width=120><u>Jenis Paspor</u> &nbsp; <font color='red'>*</font><br><i>Passport Type</i></td>     <td> : 
		<select name='id_tipe_paspor' id='id_tipe_paspor'>
			<option>- Silahkan Pilih -</option>";
            while($val=mysql_fetch_array($tampil_paspor))
				 {
					echo "<option value='$val[id]'";
					if($r[jns_paspor] == $val[id])
					{
						echo 'selected';
					}
					echo ">$val[jns_paspor]</option>";
				 }
		echo "</select>
		</td></tr>
		<tr><td><u>Tujuan</u> &nbsp; <font color='red'>*</font><br><i>Purpose</i></td>     <td> : 
		
		<textarea name='tujuan_otvis' id='tujuan_otvis' rows=2 cols=35 >$r[tujuan]</textarea>
							
		</td></tr>";
		if($_SESSION[G_leveluser]==14)
		{
			
		 echo "<tr><td>Tipe Visa &nbsp; <font color='red'>*</font></td>     <td> : 
		<select name='tipevisa_otvis' id='tipevisa_otvis'>
		<option>- Silahkan Pilih -</option>
			"; 
			
				 while($val=mysql_fetch_array($tampil_tipevisa))
				 {
					echo "<option value='$val[id]'";
					if($r[tipe_visa] == $val[id])
					{
						echo 'selected';
					}
					
					
					echo ">$val[tipe_visa]</option>";
				 }
		
			echo"</select>
		</td></tr>
		
		
		<tr><td>Indeks Visa &nbsp; <font color='red'>*</font></td>     <td> : 
		<select name='indeksvisa_otvis' id='indeksvisa_otvis'>
		<option value=''>- Silahkan Pilih -</option>
			"; 
			
				 while($val=mysql_fetch_array($tampil_visa))
				 {
					echo "<option value='$val[ID_JNS_VISA]'";
					if($r[indeks_visa] == $val[ID_JNS_VISA])
					{
						echo 'selected';
					}
					
					
					echo ">$val[KD_JNS_VISA]</option>";
				 }
		
			echo"</select>
		</td></tr>"; 
		}
        echo "
		 <tr><td><u>Posisi</u> &nbsp; <font color='red'>*</font><br><i>Position</i></td>     
	   <td> : 
		<select name='posisi' id='posisi'>
		<option value=''>- Silahkan Pilih -</option>
		<option value='1'"; if($r[posisi] == '1') { echo 'selected'; } echo ">Baru / New</option>
		<option value='2'"; if($r[posisi] == '2') { echo 'selected'; } echo ">Pengganti / Replacement</option>
		</select>
		<div id='replacement' style='";
		
		if($r[posisi] == 1) echo "display:none"; echo "'><br>&nbsp;&nbsp;<input type=text placeholder='masukkan nama yang digantikan' value='$r[pengganti]' id='pengganti' name='pengganti' size=50>
	   </div>
	   </td></tr>
		<tr><td><u>Masa Penugasan </u>&nbsp; <font color='red'>*</font><br><i>Assignment Period</i></td>     <td> : <input type=text placeholder='masukkan dengan angka' id='masatugas_otvis' value='$r[masa_tugas]' name='masatugas_otvis' size=50> Hari</td></tr>
		<tr><td>Surat Setneg &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 id='setneg_upload' name='setneg_upload'>Lihat file unggahan<a href='/../files/otvis/setneg/$r[surat_setneg]'> di <B>SINI</B></a></td></tr>		
		<tr><td><u>Nota Diplomatik</u> &nbsp; <font color='red'>*</font><br><i>Diplomatic No.</i> </td>     <td > : <input type=text  name='no_nota_diplomatik' id='no_nota_diplomatik' value='$r[no_nota_diplomatik]' size=50  ><br>&nbsp;&nbsp;<input type=file size=40 id='nota_diplomatik_upload' name='nota_diplomatik_upload'>Lihat file unggahan<a href='/../files/otvis/notadinas/$r[nota_dinasdiplomatik]'> di <B>SINI</B></a></td>
		";
		/* echo "<tr><td>Surat Nikah(Spouse)  </td>     <td > : <input type=file size=40 id='surat_nikah_upload' name='surat_nikah_upload'>";
		if($r[surat_nikah])
		{
		echo "Lihat file unggahan<a href='/../files/otvis/suratnikah/$r[surat_nikah]'> di <B>SINI</B></a>";
		}
		echo "</td></tr>		
		<tr><td>Surat Legalisasi Keppri &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 id='keppri_legal_upload' name='keppri_legal_upload'>Lihat file unggahan<a href='/../files/otvis/legalitas/$r[kepri_legal]'> di <B>SINI</B></a></td>
		"; */
		echo "</table>";
		/* echo "<table width=100% id='dasarMintaVisaResultList'>
		<tr><td width=120>Dasar Permintaan Visa &nbsp; <font color='red'>*</font></td>     <td> : <input type='button' name='tambah_minta_visa' value='+ Tambah'></td></tr>
		";
		
		$sql_mintavisa="select * from tbl_dasarminta_visa where no_konsep = '$r[no_konsep]'";
		$tampil_mintavisa=mysql_query($sql_mintavisa);
		$h=1;
		 while($val=mysql_fetch_array($tampil_mintavisa))
			{
			echo "<tr id='rowIdx$h'><td width=14%>&nbsp;</td>     <td> $val[urutan]. <input size=50 class='inputIdx$h' id='inputmintavisa' type='text' value = '$val[dasar_mintavisa]' name='dasar_mintavisa[$h][dasarmintavisa]'><span id='$h' class='btn btn-danger remove-me1 x$h' value='$h' ><input type='button' value='x'></span></td></tr>";
			$h++;
			}
		echo"</table>"; */
		if($_SESSION[G_leveluser] == 14)
		{
		echo "<table width=100% id='dasarBeriVisaResultList'>
		<tr><td width=120>Dasar Pemberian Visa &nbsp; <font color='red'>*</font></td>     <td> : <input type='button' name='tambah_beri_visa' value='+ Tambah'></td></tr>
		";
		$sql_berivisa="select * from tbl_dasarberi_visa where no_konsep = '$r[no_konsep]'";
		$tampil_berivisa=mysql_query($sql_berivisa);
		$h=1;
		 while($val=mysql_fetch_array($tampil_berivisa))
			{
			echo "<tr id='rowIdy$h'><td width=14%>&nbsp;</td>     <td> $val[urutan]. <input size=50 class='inputIdy$h' id='inputberivisa' type='text' value = '$val[dasar_berivisa]' name='dasar_berivisa[$h][dasarberivisa]'><span id='$h' class='btn btn-danger remove-me2 y$h' value='$h' ><input type='button' value='x'></span></td></tr>";
			$h++;
			}
		echo "</table>";
		}
		if($_SESSION[G_leveluser] != 15)
		{
		echo "<table width=100%>
							
							<tr><td width='120'>Verifikator </td> <td> : 
							<input type=text name='verifikator' value = '$r[verifikator]' id='verifikator' size=50  >
							</td></tr>
							<tr><td width='120'>Jabatan Verifikator </td> <td> :
							<input type=text name='jbt_ver' value = '$r[jabatan_verifikator]' id='jbt_ver' size=50  >
							</td></tr>
							
							<tr><td width='120'>Legalisator </td> <td> :
							<input type=text name='legalisator' value = '$r[legalisator]' id='legalisator' size=50  >
							</td></tr>
							<tr><td width='120'>Jabatan Legalisator </td> <td> :
							<input type=text name='jbt_legal' value = '$r[jabatan_legalisator]' id='jbt_legal' size=50  >
							</td></tr>
							
							<tr><td width='120'>Keputusan </td> <td> :
							<select name='ID_JNS_KEPUTUSAN' id='ID_JNS_KEPUTUSAN'>
								<option value=''>- Silahkan Pilih -</option>";
								 while($val=mysql_fetch_array($tampil_status))
								 {
									
									echo "<option value='$val[id]'
									";
									if($r[status_permohonan] == $val[id])
									{
										echo 'selected';
									}
									echo">$val[status]</option>";
								 }
							echo"></select>
							</td></tr>
							<tr><td width='120'>Catatan</td>  <td> :
							<textarea name='catatan_otvis' id='catatan_otvis' rows=2 cols=35 >$r[catatan]</textarea>
							</td></tr></table>";
							}
							
							echo "
							
							<table id='tombol' width=100% border='0' cellspacing='0' cellpadding='0'>
							<tr>  <td align='right'>
							<input type='submit'  name='simpan' id='simpan_otvis' value='Simpan'>
							<input type=button value=Batal onclick=self.history.back()>
							</td></tr>
							
						</table>";	
		
		/* <input type='button'  name='cetak' value='Cetak'>
							<input type='button'  name='brafaks' value='Brafaks'> */
		
		/*<tr><td>Dokumen Pendukung</td>     <td>";
		$tampil=mysql_query("SELECT * FROM m_syarat where jenis_izin='5'");
		$i=1;
		while ($data=mysql_fetch_array($tampil)) {
		echo "<input type=checkbox name='syarat[]' value='$data[syarat_kd]' checked>$data[syarat_nama] <br>";
		echo " Click<a><b> Here</b></a> to view<hr>";
		$i++;</td></tr>
		}*/
		/* echo"
		<table width=100%>
		<tr><td width=14%>Keputusan </td><td> :
		<select name='ID_JNS_KEPUTUSAN'>
			<option>- Silahkan Pilih -</option>
            <option value=1 >Disetujui</option>
			<option value=2 >Ditolak</option>;
		</select>
		</td></tr>
		<tr><td>Catatan</td>     <td> : 
		<textarea name='catatan_otvis' rows=2 cols=48 ></textarea>
		</td></tr>"; 
		<input type=submit value=Simpan >
		*/
	   /*  echo "
		<table width=100%>
		<tr><td colspan=2 align=right>
			   		
		<input type='button'  name='preview' onClick=loadPopupBox1(1); value='Preview'>
		<input type=button value=Batal onclick=self.history.back()></td></tr>
        </table>"; */
		
		echo "<div id='popup_box1' style='overflow-y:scroll;' class='popup_box1'>
						<h2>Preview Otorisasi Visa</h2>
						<div>
						<table width='100%'>
							<tr>
								<td width='30%'>Perwakilan RI</td><td width='6'>:</td><td><div id='pwkri_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Nama</td><td width='6'>:</td><td><div id='nama_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>No Paspor</td><td width='6'>:</td><td><div id='nopaspor_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Anggota Keluarga</td><td width='6'>:</td><td><div id='anggota_fam_pre'></div></td>
							</tr>
							
							<tr>
								<td width='30%'>Jenis Paspor</td><td width='6'>:</td><td><div id='jns_paspor_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Tujuan</td><td width='6'>:</td><td><div id='tujuan_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Indeks Visa</td><td width='6'>:</td><td><div id='indeksvisa_pre'></div></td>
							</tr>
							<tr>
								<td width='30%'>Masa Penugasan</td><td width='6'>:</td><td><div id='masa_tugas_pre'></div></td>
							</tr>
							</table>
							<table width=100% id='dasarMintaVisaResultList1'>
							<tr><td width=30%>Dasar Permintaan Visa</td>     <td width='6'> : </td><td></td></tr>
							
							</table>
							
							<table width=100% id='dasarBeriVisaResultList1'>
							<tr></tr>
							
							</table>
							</form>
						</div>
						<a id='popupBoxClose' onClick='unloadPopupBox1(1);'>[X]</a>	
					</div>
						";
	}
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
				<td><img src=\"../images/bendaera/".strtolower($r[BENDERA])."\" class=\"thumbborder\" width=\"22\" height=\"15\" />  
				&nbsp <a href=?module=staypermit&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";
		
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
