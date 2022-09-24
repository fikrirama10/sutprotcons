<style> #tombol {border: none;} </style>
<?php

	  // echo "<br><a href=?module=staypermit&act=cari&huruf=A>A</A> |	<a href=?module=staypermit&act=cari&huruf=B>B</A> |	<a href=?module=staypermit&act=cari&huruf=C>C</A> |	<a href=?module=staypermit&act=cari&huruf=D>D</A> |	<a href=?module=staypermit&act=cari&huruf=E>E</A> |	<a href=?module=staypermit&act=cari&huruf=F>F</A> |	<a href=?module=staypermit&act=cari&huruf=G>G</A> |	<a href=?module=staypermit&act=cari&huruf=H>H</A> |	<a href=?module=staypermit&act=cari&huruf=I>I</A> |	<a href=?module=staypermit&act=cari&huruf=J>J</A> |	<a href=?module=staypermit&act=cari&huruf=K>K</A> |	<a href=?module=staypermit&act=cari&huruf=L>L</A> |	<a href=?module=staypermit&act=cari&huruf=M>M</A> |	<a href=?module=staypermit&act=cari&huruf=N>N</A> |	<a href=?module=staypermit&act=cari&huruf=O>O</A> |	<a href=?module=staypermit&act=cari&huruf=P>P</A> |	<a href=?module=staypermit&act=cari&huruf=Q>Q</A> |	<a href=?module=staypermit&act=cari&huruf=R>R</A> |	<a href=?module=staypermit&act=cari&huruf=S>S</A> |	<a href=?module=staypermit&act=cari&huruf=T>T</A> |	<a href=?module=staypermit&act=cari&huruf=U>U</A> |	<a href=?module=staypermit&act=cari&huruf=V>V</A> |	<a href=?module=staypermit&act=cari&huruf=W>W</A> |	<a href=?module=staypermit&act=cari&huruf=X>X</A> |	<a href=?module=staypermit&act=cari&huruf=Y>Y</A> |	<a href=?module=staypermit&act=cari&huruf=Z>Z</A>";

		$sql_pwk="select a.id_perwakilan,a.perwakilan,a.negara,b.nm_regional from tbl_perwakilan a left join tbl_regional b on a.id_regional = b.id_regional order by a.perwakilan asc";
		$tampil_pwk=mysql_query($sql_pwk);

		$sql_visa="select * from m_jns_visa where ID_JNS_VISA = 2 OR ID_JNS_VISA = 3 OR ID_JNS_VISA = 4 OR ID_JNS_VISA = 5
		OR ID_JNS_VISA = 6 OR ID_JNS_VISA = 7 OR ID_JNS_VISA = 8 OR ID_JNS_VISA = 9 OR ID_JNS_VISA = 10 OR ID_JNS_VISA = 25
		OR ID_JNS_VISA = 26 OR ID_JNS_VISA= 27  OR ID_JNS_VISA= 28"; //yg 28 di update tim DAM

		$tampil_visa=mysql_query($sql_visa);

		$sql_tipevisa="select * from tbl_tipe_visa";
		$tampil_tipevisa=mysql_query($sql_tipevisa);

		$sql_paspor="select * from tbl_jns_paspor";
		$tampil_paspor=mysql_query($sql_paspor);

		$sql_posisi="select * from tbl_ref_posisi";
		$tampil_posisi=mysql_query($sql_posisi);

		$sql_kewarganegaraan="select * from m_negara";
		$tampil_kewarganegaraan=mysql_query($sql_kewarganegaraan);

		$sql_relasifam="select * from tbl_ref_relasi_fam";
		$tampil_relasifam=mysql_query($sql_relasifam);

		//$VSDFSDFSG = mysql_fetch_array($tampil_relasifam);
		//print_r($VSDFSDFSG);
		/* while($angh = mysql_fetch_array($tampil_relasifam))
		{
		echo $angh[id];echo $angh[relasi];
		} */
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




		echo "<h2>Daftar Pengajuan Visa</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>

			<table width='300' border='0px' cellspacing='0'>
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

			</form> <br>";
			if($_SESSION[G_leveluser] == 15)
			{
				$pwk8 = 'AND pwk_ri = '.$_SESSION[G_idpwk];
			}

			//print_r("select * from tbl_trans_otvis where status_permohonan = 3 $pwk8");

			$jml_tunggu = mysql_num_rows(mysql_query("select * from tbl_trans_otvis where status_permohonan = 3 $pwk8"));
			$jml_setuju = mysql_num_rows(mysql_query("select * from tbl_trans_otvis where status_permohonan = 1 $pwk8"));
			$jml_tolak = mysql_num_rows(mysql_query("select * from tbl_trans_otvis where status_permohonan = 2 $pwk8"));
		  echo "<table style='width:40%;text-align:center;float:right;'>
			<tr>
			<td width='30px' style='font-weight:bold;'>$jml_tunggu</td>
			<td><div style='background-color:yellow;'>Menunggu Persetujuan</div></td>


			<td width='30px' style='font-weight:bold;'>$jml_setuju</td>
			<td><div style='color:green;font-weight:bold;'>Disetujui</div></td>


			<td width='30px' style='font-weight:bold;'>$jml_tolak</td>
			<td><div style='color:red;font-weight:bold;'>DITOLAK</div></td>

		    </tr>
		  </table>
		  <table width=100%>
          <tr><th width=30>no</th><th width=80>NO KONSEP</th><th width=80>NO OTVIS</th>";
		   if ($_SESSION[G_leveluser]!=15)
		   {
			echo "<th width=80>PERWAKILAN RI</th>";
		   }
		   echo "<th width=80>NAMA</th><th width=40>NO PASPOR</th><th>JENIS PASPOR</th><th>TUJUAN</th>
			 <th width=>KEWARGANEGARAAN</th>
		   <th width=40>INDEKS VISA</th>
			 <th width=40>JML PERMOHONAN</th>
		   ";
		   echo "<th width=100>CATATAN PUSAT</th><th width=100>CATATAN PERWAKILAN</th>";

		   echo "<th width=80>TGL DIBUAT</th><th width=100>STATUS</th>";
		   if ($_SESSION[G_leveluser]!=12 ){
		   echo "<th width=70>AKSI</th>";
		   }
		 echo "</tr>";




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

	/* if($_GET['indeksvisa']!= '' && $_GET['stat']!= '')
	{
		//echo 'isi1';
		$ae = "OR pwk_ri = ".$_SESSION['G_idpwk']." AND indeks_visa = ".$_GET['indeksvisa']." AND status_permohonan = ".$_GET['stat'];
	}
	elseif($_GET['indeksvisa']== '' && $_GET['stat']!= '')
	{
		//echo 'kosong';
		$ae = "OR pwk_ri = ".$_SESSION['G_idpwk']." AND status_permohonan = ".$_GET['stat'];
	}
	elseif($_GET['indeksvisa']!= '' && $_GET['stat']== '')
	{
		//echo 'kosong';
		$ae = "OR pwk_ri = ".$_SESSION['G_idpwk']." AND indeks_visa = ".$_GET['indeksvisa'];
	} */

	if($_SESSION[G_leveluser] == 15)
	{
	$term_pwk = " AND pwk_ri = ".$_SESSION['G_idpwk'];
	}

	if($_GET['namapemohon']!= '')
	{
		/* if($_GET['indeksvisa']!= '' && $_GET['stat']!= '')
		{
		 $term = " AND ";
		} */

		if($_GET['indeksvisa']!= '')
		{
		 $term_iv = " AND indeks_visa = ".$_GET['indeksvisa'];
		}

		if($_GET['stat']!= '' )
		{
		 $term_st = " AND status_permohonan = ".$_GET['stat'];
		}

		$np = " nama like '%".$_GET['namapemohon']."%'".$term_pwk.$term_iv.$term_st;
	}
	elseif($_GET['indeksvisa']!= '')
	{
		if($_GET['namapemohon']!= '' && $_GET['stat']!= '')
		{
		 $term = " AND ";
		}

		if($_GET['namapemohon']!= '')
		{
		 $term_np = " AND nama like '%".$_GET['namapemohon'];
		}

		if($_GET['pwk']!= '' )
		{
		 $term_pwk_ri = " AND pwk_ri = ".$_GET['pwk'];
		}

		if($_GET['stat']!= '' )
		{
		 $term_st = " AND status_permohonan = ".$_GET['stat'];
		}

		 $iv = " $term indeks_visa = ".$_GET['indeksvisa'].$term_pwk.$term_np.$term_pwk_ri.$term_st;
	}
	elseif($_GET['pwk']!= '')
	{
		if($_GET['namapemohon']!= '' && $_GET['stat']!= '')
		{
		 $term = " AND ";
		}

		if($_GET['namapemohon']!= '')
		{
		 $term_np = " AND nama like '%".$_GET['namapemohon'];
		}

		if($_GET['indeksvisa']!= '' )
		{
		 $term_iv = " AND indeks_visa = ".$_GET['indeksvisa'];
		}

		if($_GET['stat']!= '' )
		{
		 $term_st = " AND status_permohonan = ".$_GET['stat'];
		}

		 $pwk = " $term pwk_ri = ".$_GET['pwk'].$term_pwk.$term_np.$term_iv.$term_st;
	}
	elseif($_GET['stat']!= '')
	{
		if($_GET['indeksvisa']!= '' && $_GET['stat']!= '')
		{
		 $term = " AND ";
		}
		$st = " $term status_permohonan = ".$_GET['stat'].$term_pwk;
	}


	if (isset($_GET['namapemohon']) || isset($_GET['indeksvisa']) || isset($_GET['pwk']) || isset($_GET['stat'])){

		if($pwk != '' || $np != '' || $iv != '' || $st != '')
		{
		$term_wh = ' where otvis.kewarganegaraan=negara.ID_NEGARA AND';
	} else {
		$term_wh = ' where otvis.kewarganegaraan=negara.ID_NEGARA';
	}


			// $sql="SELECT * FROM tbl_trans_otvis $term_wh $np $iv $pwk $st order by status_permohonan desc, created_date desc limit $posisi,$batas";
			$sql="SELECT
											*,
											(	SELECT
													COUNT(id)
												FROM
													tbl_anggota_fam
												WHERE
													id_otvis = otvis.id_otvis) AS jml
										FROM
											tbl_trans_otvis AS otvis, m_negara as negara $term_wh $np $iv $pwk $st order by status_permohonan desc, created_date desc limit $posisi,$batas";
			//script query hartarto tampil data
			//echo $sql;

		//echo $sql;
		$tampilbeda=mysql_query($sql);
		//}


		//echo $sql;
	}
	else
    {
			if ($_SESSION[G_leveluser]==10 ){
 		 $stmhn_baru = 'where otvis.kewarganegaraan=negara.ID_NEGARA and status_permohonan != 3';
 		 }
 		 else
 		 {
 		 $stmhn_baru = 'where otvis.kewarganegaraan=negara.ID_NEGARA';
 		 }

 		 if ($_SESSION[G_leveluser]==15)
 		 {
 			$id_pwk = 'where otvis.kewarganegaraan=negara.ID_NEGARA and pwk_ri = '.$_SESSION[G_idpwk];
			$stmhn_baru = '';
 		 }


		// print_r($_SESSION);
		if ($_SESSION[G_leveluser]==15)
		{
		// $sql = "SELECT * FROM tbl_trans_otvis $stmhn_baru $id_pwk order by no_konsep_pwk desc limit $posisi,$batas";
		$sql = "SELECT
										*,
										(	SELECT
												COUNT(id)
											FROM
												tbl_anggota_fam
											WHERE
												id_otvis = otvis.id_otvis) AS jml
									FROM
									tbl_trans_otvis AS otvis, m_negara as negara $stmhn_baru $id_pwk order by no_konsep_pwk desc limit $posisi,$batas";
								//	echo $sql;
		}
		else
		{
		// $sql = "SELECT * FROM tbl_trans_otvis $stmhn_baru $id_pwk order by status_permohonan desc, created_date desc limit $posisi,$batas";
		$sql = "SELECT
								*,
								(	SELECT
										COUNT(id)
									FROM
										tbl_anggota_fam
									WHERE
										id_otvis = otvis.id_otvis) AS jml
							FROM
								tbl_trans_otvis AS otvis, m_negara as negara $stmhn_baru $id_pwk order by status_permohonan desc, created_date desc limit $posisi,$batas";
		}
		//print_r($sql);
		$tampilbeda=mysql_query($sql);
		//$ra=mysql_fetch_array($tampilbeda);
		//print_r($sql);
	}

    $no = $posisi+1;
	//print_r($sql);
	//print_r(count($tampilbeda));
	if($tampilbeda != '' && isset($tampilbeda)){
		//print_r('ada');
		//print_r($tampilbeda);
		 //$tampilbeda=mysql_query("SELECT * FROM tbl_trans_otvis");
         //$pwkri=mysql_query("SELECT * FROM tbl_trans_otvis");

		while($r=mysql_fetch_array($tampilbeda)){
			//print_r($r);exit;
		//  echo "<tr bgcolor='$bgcolor'>";

				echo"<td>$no</td>
					<td>$r[no_konsep_pwk]</td>
					<td>$r[no_konsep_pusat]</td>
					";
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
					echo"<td><a href='#' class='cancel-action'>$r[nama]</a>";

					$sql23 = "select * from tbl_anggota_fam where no_konsep = '$r[no_konsep]' order by urutan asc";
					$tampil_fam=mysql_query($sql23);
					if($tampil_fam)
					{
						while($r_fam=mysql_fetch_array($tampil_fam))
						{
							echo "<hr>$r_fam[nama] <br>";
						}
					}
					echo"</td>
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

					<td>$r[tujuan]</td>";
					echo "<td>$r[NEGARA]</td>";

					echo "<td>";
					if($_SESSION[G_leveluser] == 15)
					{
				/* 	$sql_visa="select * from m_jns_visa where ID_JNS_VISA = 3 OR ID_JNS_VISA = 2 OR
					ID_JNS_VISA = 4 OR ID_JNS_VISA = 6 OR ID_JNS_VISA = 25 OR ID_JNS_VISA = 9"; */
					$sql_visa="select * from m_jns_visa where ID_JNS_VISA = 2 OR ID_JNS_VISA = 3 OR ID_JNS_VISA = 4 OR ID_JNS_VISA = 5
					OR ID_JNS_VISA = 6 OR ID_JNS_VISA = 7 OR ID_JNS_VISA = 8 OR ID_JNS_VISA = 9 OR ID_JNS_VISA = 10 OR ID_JNS_VISA = 25
					OR ID_JNS_VISA = 26 OR ID_JNS_VISA= 27 OR ID_JNS_VISA= 28"; //TIM DAM nambah ID_JNS_VISA= 28
					}
					else
					{
					$sql_visa="select * from m_jns_visa where ID_JNS_VISA = 2 OR ID_JNS_VISA = 3 OR ID_JNS_VISA = 4 OR ID_JNS_VISA = 5
					OR ID_JNS_VISA = 6 OR ID_JNS_VISA = 7 OR ID_JNS_VISA = 8 OR ID_JNS_VISA = 9 OR ID_JNS_VISA = 10 OR ID_JNS_VISA = 25
					OR ID_JNS_VISA = 26 OR ID_JNS_VISA= 27 OR ID_JNS_VISA= 28"; //TIM DAM nambah ID_JNS_VISA= 28
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
					echo "</td>";
					echo "<td align='center'>";
					if($r['jml'] == 0) { echo "1 orang"; } else { echo $r['jml']+1; echo " orang"; }
					echo "</td>";

					echo "<td align='center'>";
					 if($r[catatan])
					{
						if($r[status_permohonan] == 3)
						{
							echo "<div class='read-more'><div class='blink182' style='color : red;font-weight:bold;' >
							<a href=?module=indeksvisa&act=sunting_visa&idt=$r[id_otvis]>
							<img src='../images/warning_pusat.png' width=20 height=20><br>
							Pesan Pusat <br>[BACA]
							</a>
							</div></div>";
						}
						else
						{
							echo "<div class='read-more'>$r[catatan]</div>";
						}
					}
					echo "</td>
					<td align='center'>";
					if($r[catatan_pwk])
					{
						if($r[status_permohonan] == 3)
						{
							echo "<div class='read-more'><div class='blink182' style='color : green;font-weight:bold;' >
							<a href=?module=indeksvisa&act=sunting_visa&idt=$r[id_otvis]>
							<img src='../images/alert_pwk.png' width=20 height=20><br>
							Pesan Perwakilan <br>[BACA]
							</a>
							</div></div>";
						}
						else
						{
							echo "<div class='read-more'>$r[catatan_pwk]</div>";
						}
					}
					echo "</td>";

					//untuk menghitung perbedaan hari pengajuan dan tgl saat ini //yusuf puspa

					// Declare two dates
					$start_date = strtotime($r[created_date]);
					$end_date = strtotime(date('m/d/Y h:i:s a'));
					$perbedaan_hari = ($end_date - $start_date)/60/60/24;
 					if ($perbedaan_hari >=5){
						if($_SESSION[G_leveluser] != 15 and $_SESSION[G_leveluser] != 19) //tidak ditampilkan untuk pwk dan badora
						{
	 						$lebih_dari_lima_hari = "<div class='blink182' style='text-align:center;'><img src='../images/warning_pusat.png' width='20' height='20'>  <br>lebih dari 5 hari</div>";
						}
					} else { $lebih_dari_lima_hari=""; }
					echo "<td>".date('d-m-Y h:m:s',strtotime($r[created_date]))." <br> $lebih_dari_lima_hari</td>
					<td align='center'>";

					$sql_status2="select * from tbl_ref_status";
					$tampil_status2=mysql_query($sql_status2);
					while($val=mysql_fetch_array($tampil_status2))
					 {
						if($r['status_permohonan'] == $val['id'])
						{

							if ($r['status_permohonan'] == 1)
							{

							$sql28 = "select * from tbl_anggota_fam where id_otvis = '$r[id_otvis]' and status_permohonan = 2 order by urutan limit 1";
							$tampil_fam28=mysql_query($sql28);
							$apoll28 = mysql_num_rows($tampil_fam28);
							//print_r($apoll28);
							if($apoll28 == 1)
							{
							echo "<div style='color:green;'><b>Disetujui Sebagian</b></div>";
							}
							else
							{
							echo "<div style='color:green;'><b>$val[status]</b></div>";
							}

							}

							if($r['status_permohonan'] == 2)
							{
							echo "<div style='color:red;'><b>$val[status]</b></div>";
							}
							if($r['status_permohonan'] == 3)
							{
							echo "<div style='background-color:yellow;'>$val[status]</div>";
							}
							if($r['status_permohonan'] == 0)
							{
							echo "<div style='color:red;'>$val[status]</div>";
							}
						//echo "<div style='background-color:yellow;border-style: solid;border-color: #ff0000 #0000ff;'>$val[status]</div>";
						}

					 }


					/* $sql26 = "select * from tbl_anggota_fam where id_otvis = '$r[id_otvis]' order by urutan asc";
					$tampil_fam26=mysql_query($sql26);
					if($tampil_fam26)
					{
						while($r_fam26=mysql_fetch_array($tampil_fam26))
						{
							//echo "<hr> $r_fam26[status_permohonan]<br>";

							if ($r_fam26['status_permohonan'] == 1)
							{
							echo "<hr><div style='color:green;'><b>Disetujui</b></div>";
							}
							if($r_fam26['status_permohonan'] == 2)
							{
							echo "<hr><div style='color:red;'><b>DITOLAK</b></div>";
							}
							if($r_fam26['status_permohonan'] == 3)
							{
							echo "<hr><div style='background-color:yellow;'>Menunggu Persetujuan</div>";
							}
						}
					} */
					echo "</td>";
					if ($_SESSION[G_leveluser]==15 )
						{
							$link = 'legalisasi_otvis.php';
						}
						else
						{
							$link = 'legalisasi_otvis_pusat.php';
						}
					 if ($_SESSION[G_leveluser]!=10 ){
						if ($_SESSION[G_leveluser]!=12 ){
						echo "
						<td align=center>";
						if ($r['status_permohonan'] == 1 || $r['status_permohonan'] == 2 || $r['status_permohonan'] == 0)
							{
							echo "<a href=?module=indeksvisa&act=sunting_visa&idt=$r[id_otvis]>
							<img src='../images/magnifying-glass.png' width=20 height=20>
							</a>";
							}
							else
							{

							echo "<a href=?module=indeksvisa&act=sunting_visa&idt=$r[id_otvis]>
							<img src='../images/edit.png'>
							</a></br>";
                                                        //tim DAM
                                                        $as=$r['kewarganegaraan'];
                                                        $sql_resi = "SELECT * FROM tbl_resiprositas_visa where ID_NEGARA='$as' and STATUS=1 order by TGL_INPUT desc";
                                                        $bb=mysql_query($sql_resi);
                                                        $tampilresi=mysql_num_rows(mysql_query($sql_resi));
                                                        $idt = array();
                                                        $ids = array();
                                                         $tgl_input=array();
                                                         $usr_input=array();
                                                         $nm_negara=array();
                                                         $desk_info=array();
                                                         $sumber_info=array();
                                                         $no_dok=array();
                                                         $nm_file=array();
                                                         $tgl_edit=array();
                                                         $usr_edt=array();
                                                         $lokasi_dok=array();
                                                            if($tampilresi > 0){
                                                                while($res=mysql_fetch_assoc($bb)) {
                                                                $idt[] = json_encode($res['ID']);
                                                                $ids[] = json_encode($res['ID_NEGARA']);
                                                                $tgl_input[]=json_encode($res['TGL_INPUT']);
                                                                $usr_input[]=json_encode($res['USER_INPUT']);
                                                                $nm_negara[]=json_encode($res['NAMA_NEGARA']);
                                                                $desk_info[]=json_encode($res['DESKRIPSI_INFORMASI']);
                                                                $sumber_info[]=json_encode($res['SUMBER_INFORMASI']);
                                                                $no_dok[]=json_encode($res['NOMOR_DOK']);
                                                                $nm_file[]=json_encode($res['FILE']);
                                                                $tgl_edit[]=json_encode($res['TGL_EDIT']);
                                                                $usr_edt[]=json_encode($res['USER_EDIT']);
                                                                $lokasi_dok[]= json_encode('../files/otvis/resiprositas/'.$res['FILE']);
                                                                }
                                                                $idts = json_encode($idt);
                                                                $idss = json_encode($ids);
                                                                $tgl_inputs=json_encode($tgl_input);
                                                                $usr_inputs=json_encode($usr_input);
                                                                $nm_negaras =json_encode($nm_negara);
                                                                $desk_infos=json_encode($desk_info);
                                                                $sumber_infos=json_encode($sumber_info);
                                                                $no_doks=json_encode($no_dok);
                                                                $nm_files=json_encode($nm_file);
                                                                $tgl_edits=json_encode($tgl_edit);
                                                                $usr_edts=json_encode($usr_edt);
                                                                $lokasi_doks= json_encode($lokasi_dok);
                                                                echo"<div class='read-more'><div class='blink182' style='color : red;font-weight:bold;' >
                                                                <a href='#' onClick='loadPopupViewVisa(6,$idss,$tgl_inputs,$usr_inputs,$nm_negaras,$desk_infos,$sumber_infos,$no_doks,$nm_files,$tgl_edits,$usr_edts,$idts,$lokasi_doks);'>
							<img src='../images/warning_pusat.png' width=20 height=20><br>
							Resiprositas
							</a></div></div>";
                                                            }
								if ($_SESSION[G_leveluser]==15 )
								{
									?>
									<br>

									<a rel="tooltip"  title="batal" onclick="return confirm('Apakah yakin akan membatalkan pengajuan visa <?=$r[nama]?>?');" href="./aksi_visa_new.php?module=indeksvisa&act=batal&idt=<?=$r[id_otvis]?>">

									<img src='../images/delete.png' width=10 height=10><br>
									Batal
									</a><br>
									<?php
								}
							}
						echo"<br>
						<a href=$link?idt=$r[id_otvis] target=_blank>
						<img src='../images/print.png'>
						</a><br>";
						/* echo "<a href=/modul/email_otvis.php?nokonsep=$r[no_konsep] target=_blank>
						<img src='../images/mail.png'>
						</a><br>
						<a href=/modul/brafaks_otvis.php?nokonsep=$r[no_konsep] target=_blank>
						<img src='../images/brafaks1.png'>
						</a>"; */
						echo "</td>
						";
						}
					}
					else
					{
					echo "<td align='center'><input type='button'  name='detil' onClick=loadPopupBox2(2,'$r[id_otvis]'); value='detil'></td>";
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

echo "<!--Tim Dam View Info Resiprositas Visa-->

<div id='popup_box6' style='overflow-y:scroll;' class='popup_box6'>
						<h2>View Informasi Resiprositas Visa</h2>
						<div>
<table width='100%'>
<tr><td>Negara</td > <td width='6'>:</td><td > <input type=text name='negara_view' id='negara_view' size=50 maxlength=250 required></td></tr>
<tr><td>Deskripsi Informasi*</td > <td width='6'>:</td><td > <textarea name='deskripsi_view' id='deskripsi_view' rows=24 cols=65 maxlength=1000 required></textarea></td></tr>
<tr><td>File Pendukung</td > <td width='6'>:</td><td > <span name='fl_dok1' id='fl_dok1'></span></td></tr>
</table>

</div>

<a id='popupBoxClose' onClick='unloadPopupBox2Visa(6);'>[X]</a>
</div>

<!--Tim DAM Akhir View Info Resiprositas Visa-->
";


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
		//print_r('asfaf');
		$jmldata =mysql_num_rows(mysql_query("select a.id_permit from v_stay_permit a right join v_diplomat b on a.id_diplomat=b.id_diplomat where  b.negara like '".$neg."%' and b.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%'"));
	}else{
		if($_GET['stat']!= 0)
		{
		$status = 'AND status_permohonan = '.$_GET['stat'];
		$where_st = 'where status_permohonan = '.$_GET['stat'];
		$st_w = '&stat='.$_GET['stat'];


		}
		if($_SESSION[G_leveluser] == 15)
		{

			if($np == '' && $iv == '' && $st == '')
			{
				$wh = 'where pwk_ri = '.$_SESSION[G_idpwk];
			}
			else
			{
				$wh = ' where ';
			}
			$jmldata =mysql_num_rows(mysql_query("select * from tbl_trans_otvis $wh $np $iv $st"));
			//print_r("select * from tbl_trans_otvis $wh $np $iv $st");
		}
		else
		{
			$pwk_ri = '&pwk='.$_GET['pwk'];
			$iv_ri = '&indeksvisa='.$_GET['indeksvisa'];
			//$np_ri = '&namapemohon='.$_GET['indeksvisa'];
			if($pwk != '' || $np != '' || $iv != '' || $st != '')
			{
			$term_pusat = ' where ';
			}
			$jmldata =mysql_num_rows(mysql_query("select * from tbl_trans_otvis $term_pusat $np $pwk $iv $st"));
			//script query hartarto paging
			//print_r("select * from tbl_trans_otvis $term_pusat $np $pwk $iv $st");
		}

	}

	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   //$ilink = "?module=indeksvisa&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]";
   $ilink = "?module=indeksvisa".$st_w.$iv_ri.$pwk_ri;
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

	echo "
		<tr>
		<tr><td width=200><u>Tanggal</u> <br> <i>Date</i></td>  <td  colspan='2'> :
		";
		echo date('d-m-Y');
		echo "<input name='tgl_otvis' value='".date('d-m-Y')."' type='hidden'>";
		echo"
		</td>
		</tr>";
		//echo "<tr><td>No Brafaks &nbsp; <font color='red'>*</font></td>     <td  colspan='2'> : <input type=text name='nobrafaks_otvis' id='nobrafaks_otvis' size=50  ></td></tr>

		//";





	$tampil=mysql_query("SELECT * FROM m_syarat where jenis_izin='1'");

		echo"<tr><td><u>Nama</u>&nbsp; <font color='red'>*</font><br><i>Name</i> </td>     <td  colspan='2'> : <input type=text  name='nama_otvis' id='nama_otvis' size=50  ></td></tr>
		<tr><td><u>Kewarnegaraan</u>&nbsp; <font color='red'>*</font><br><i>Nationality</i> </td>     <td  colspan='2'> :
		<select name='kewarganegaraan_otvis' id='kewarganegaraan_otvis'>
			";
            while($val=mysql_fetch_array($tampil_kewarganegaraan))
				 {
					echo "<option value='$val[ID_NEGARA]'>$val[NEGARA]</option>";
				 }
		echo "</select>
		</td></tr>
		<tr><td><u>Foto</u> &nbsp; <font color='red'>*</font><br><i>Photo</i> </td>     <td > : <input type=file size=40 id='foto_upload' name='foto_upload' onchange='validate_photo(this)' />

		<ul>
		<li>Pas Photo terbaru (3 bulan terakhir).</li>
		<li>Warna latar pas photo berwarna putih.</li>
		<li>Wajah pada pas photo melihat lurus ke arah kamera.</li>
		<li>Pas photo merupakan close up dari kepala dan bahu sehingga memenuhi 80% dari seluruh photo.</li>
		<li>Mata harus terbuka dan terlihat jelas.</li>
		<li>Tidak ada bagian kepala yang terpotong dan wajah tidak boleh tertutupi ornamen.</li>
		<li>File foto yang diizinkan hanya dalam bentuk .jpg.</li>

		</ul>


		</td>
		<td>
		<img id='user_img'
                                 height='130'
                                 width='110'
                                  />
		</td>
		</tr>

		<tr><td><u>Paspor</u> &nbsp; <font color='red'>*</font><br><i>Passport</i></td>     <td> : <input type=text name='paspor_otvis' id='paspor_otvis' size=50  >
		<br><br>&nbsp;&nbsp;<input type=file size=40 id='foto_paspor_upload' name='foto_paspor_upload' onchange='validate_paspor(this)'></td><td>
		<img id='paspor_img'
                                 height='130'
                                 width='110'
                                  />
		</td></tr>
		<tr>
			<td>Nomor Handphone Pemohon</td>
			<td colspan='2'>: <input type='text' size='50' name='nomor_handphone'></td>
		</tr>
		</table>

		<table width=100% id='anggotaFamResultList'>
		<tr><td width=200><u>Anggota Keluarga</u> <br><i>Family/Sibling</i>&nbsp; </td>     <td colspan=3> : <input type='button' name='tambah_anggota_fam' value='+ Add'></td></tr>

		</table>
		<table width=100%>
		<tr><td width=200>Jenis Paspor &nbsp; <font color='red'>*</font></td>     <td> :
		<select name='id_tipe_paspor' id='id_tipe_paspor'>
			<option value=''>- Silahkan Pilih -</option>";
            while($val=mysql_fetch_array($tampil_paspor))
				 {
					echo "<option value='$val[id]'>$val[jns_paspor]</option>";
				 }
		echo "</select>
		</td></tr>
		<tr><td><u>Tujuan</u> &nbsp; <font color='red'>*</font><br><i>Purpose</i></td>     <td> :
		<!-- Update Tim DAM-->
		<textarea name='tujuan_otvis' id='tujuan_otvis' rows=2 cols=60 maxlength=500></textarea>
		</td></tr>";

       echo "
	   <tr><td><u>Posisi</u> &nbsp; <font color='red'>*</font><br><i>Position</i></td>
	   <td> :

		<select name='posisi' id='posisi'>
			<option value=''>- Silahkan Pilih -</option>";
            while($val=mysql_fetch_array($tampil_posisi))
				 {
					echo "<option value='$val[id]'>$val[posisi]</option>";
				 }
		echo "</select>

		<div id='replacement' style='display:none;'><br>&nbsp;&nbsp;<input type=text placeholder='masukan nama yang digantikan' id='pengganti' name='pengganti' size=50>
	   </div>
	   </td></tr>

	   <tr><td><u>Masa Penugasan </u>&nbsp; <font color='red'>*</font><br><i>Assignment Period</i></td>     <td> <div class=\"tgl_awal\" id=\"tgl\">";  if (empty($r[masa_awal_tugas])) {echo "<script>DateInput('masa_awal_tugas', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script></div>";} echo "s/d <div class=\"tgl_akhir\" id=\"tgl\">";if (empty($r[masa_akhir_tugas])) {echo "<script>DateInput('masa_akhir_tugas', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script>";} echo" </div></td></tr>
		<tr><td>Surat Setneg &nbsp;  </td>     <td > : <input type=file size=40 id='setneg_upload' name='setneg_upload' onchange='validate_docdll(this)'>
		<ul>
		<li>Satukan file bila unggahan lebih dari 1 halaman.</li>
		</ul>
		</td></tr>
		<tr><td><u>Tempat Penugasan </u>&nbsp; <font color='red'>*</font><br><i>Assignment Place</i></td>     <td> : <input type=text placeholder='masukkan tempat penugasan di Indonesia' id='tempattugas_otvis' name='tempattugas_otvis' size=50><input type=hidden id='kd_tempattugas_otvis' name='kd_tempattugas_otvis'></td></tr>
		<tr><td><u>Nota Diplomatik</u> &nbsp; <font color='red'>*</font> <br><i>Diplomatic Note</i></td>
		<td> : <input type=text  name='no_nota_diplomatik' id='no_nota_diplomatik' size=50  >

		<br><br>&nbsp;&nbsp;<input type=file size=40 id='nota_diplomatik_upload' name='nota_diplomatik_upload' onchange='validate_docdll(this)'>
		<ul>
		<li>Nota diplomatik dan terjemahan dalam 1 (Satu) berkas/file saat diunggah.</li>
		<li>File nota diplomatik dan terjemahan yang diizinkan hanya dalam bentuk .pdf dan .jpg .</li>
		</ul>
		</td>
		";

		echo "</table>";

						echo "<table width=100%>

							<tr><td width='200'>Kepala Perwakilan &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='keppri' value='' id='keppri' size=50  >
							</td></tr>
							<tr><td width='200'>Jabatan Kepala Perwakilan &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='jbt_keppri' value = '' id='jbt_keppri' size=50  >
							</td></tr>

							<tr><td width='200'>Pejabat Konsuler &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='pjbt_konsuler' value = '' id='pjbt_konsuler' size=50  >
							</td></tr>
							<tr><td width='200'>Jabatan Pejabat Konsuler &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='jbt_konsuler' value = '' id='jbt_konsuler' size=50  >
							</td></tr>
							</table>";
							//}

	    echo "
		<table width=100%>
		<tr><td colspan=2 align=right>
		<input type='submit'  name='simpan' value='Simpan' id='simpan_baru'>";

		//echo"<input type='button' id='preview' name='preview'  value='Pratinjau' >
		echo"<input type=button value=Batal onclick=self.history.back()></td></tr>
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
						echo"<input type='submit'  name='simpan' value='Simpan' onclick='return konfirmasi()'></form>
						</div>
						<a id='popupBoxClose' onClick='unloadPopupBox1(1);'>[X]</a>
					</div>
						";
 break;

 case "tambah_visa_pusat":
	$idt = $_GET[idt];
 // $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt  ");
	//$r    = mysql_fetch_array($input);

	 echo "<h2 >Pengajuan Visa oleh Pusat</h2>";


	echo "<u>Data Pemohon</u>
		<form method=POST enctype='multipart/form-data' action='./aksi_visa_new.php?module=indeksvisa&act=input_pusat'>

		  <table width=100%>";


	echo "
		<tr>
		<tr><td  width=120><u>Tanggal</u> <br> <i>Date</i></td>  <td > :
		";
		echo date('d-m-Y');
		echo "<input name='tgl_otvis' value='".date('d-m-Y')."' type='hidden'>";
		echo"
		</td>
		</tr>";

		/*echo"<tr><td>No Brafaks &nbsp; <font color='red'>*</font></td>     <td> : <input type=text name='nobrafaks_otvis' id='nobrafaks_otvis' size=50  ></td></tr>

		";
		*/




	$tampil=mysql_query("SELECT * FROM m_syarat where jenis_izin='1'");
	 /*echo "<tr><td>Perwakilan RI &nbsp; <font color='red'>*</font></td>
			<td> : <select name='pwk_otvis' id='pwk_otvis'>
			<option value=''>- Silahkan Pilih -</option>
			";

				 while($val=mysql_fetch_array($tampil_pwk))
				 {
					echo "<option value='$val[id_perwakilan]'>$val[perwakilan]</option>";
				 }

		echo "</select></td></tr>"; */
		echo"<tr><td><u>Nama</u>&nbsp; <font color='red'>*</font><br><i>Name</i> </td>     <td> : <input type=text  name='nama_otvis' id='nama_otvis' size=50  ></td></tr>
		<tr><td><u>Kewarnegaraan</u>&nbsp; <font color='red'>*</font><br><i>Nationality</i> </td>     <td  colspan='2'> :
		<select name='kewarganegaraan_otvis' id='kewarganegaraan_otvis'>
			";
            while($val=mysql_fetch_array($tampil_kewarganegaraan))
				 {
					echo "<option value='$val[ID_NEGARA]'>$val[NEGARA]</option>";
				 }
		echo "</select>
		</td></tr>
		<tr><td><u>Foto</u> &nbsp; <font color='red'>*</font><br><i>Photo</i> </td>     <td > : <input type=file size=40 id='foto_upload' name='foto_upload' onchange='validate_photo(this)' />
		<img id='user_img'
                                 height='130'
                                 width='130'
                                  />
		</td></tr>

		<tr><td><u>Paspor</u> &nbsp; <font color='red'>*</font><br><i>Passport</i></td>     <td> : <input type=text name='paspor_otvis' id='paspor_otvis' size=50  >
		<br><br>&nbsp;&nbsp;<input type=file size=40 id='foto_paspor_upload' name='foto_paspor_upload' onchange='validate_paspor(this)'>
		<img id='paspor_img'
                                 height='130'
                                 width='130'
                                  />
		</td></tr>
		<tr>
		<td>Nomor Handphone</td>
		<td>: <input type='text' name='nomor_handphone' size='50'></td>
		</tr>
		</table>

		<table width=100% id='anggotaFamResultList'>
		<tr><td width=120><u>Anggota Keluarga</u> <br><i>Family/Sibling</i>&nbsp; </td>     <td colspan=3> : <input type='button' name='tambah_anggota_fam' value='+ Add'></td></tr>

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
		<!--Update Tim DAM-->
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
			<option value=''>- Silahkan Pilih -</option>";
            while($val=mysql_fetch_array($tampil_posisi))
				 {
					echo "<option value='$val[id]'>$val[posisi]</option>";
				 }
		echo "</select>

		<div id='replacement' style='display:none;'><br>&nbsp;&nbsp;<input type=text placeholder='masukkan nama yang digantikan' id='pengganti' name='pengganti' size=50>
	   </div>
	   </td></tr>

	   <tr><td><u>Masa Penugasan </u>&nbsp; <font color='red'>*</font><br><i>Assignment Period</i></td>     <td> <div id=\"tgl\">";  if (empty($r[masa_awal_tugas])) {echo "<script>DateInput('masa_awal_tugas', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script>";} echo "s/d";if (empty($r[masa_akhir_tugas])) {echo "<script>DateInput('masa_akhir_tugas', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script>";} echo" </div></td></tr>
		<tr><td>Surat Setneg &nbsp;  </td>     <td > : <input type=file size=40 id='setneg_upload' name='setneg_upload' onchange='validate_docdll(this)'></td></tr>
		<tr><td><u>Tempat Penugasan </u>&nbsp; <font color='red'>*</font><br><i>Assignment Place</i></td>     <td> : <input type=text placeholder='masukkan tempat penugasan di Indonesia' id='tempattugas_otvis' name='tempattugas_otvis' size=50></td></tr>
		<tr><td><u>Nota Diplomatik</u> &nbsp; <font color='red'>*</font> <br><i>Diplomatic Note</i></td>
		<td> : <input type=text  name='no_nota_diplomatik' id='no_nota_diplomatik' size=50  ><br><br>&nbsp;&nbsp;<input type=file size=40 id='nota_diplomatik_upload' name='nota_diplomatik_upload' onchange='validate_docdll(this)'></td>
		";
		//<tr><td>Surat Nikah(Spouse)  </td>     <td > : <input type=file size=40 id='surat_nikah_upload' name='surat_nikah_upload'></td></tr>
		//echo "<td>Surat Legalisasi Keppri &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 id='keppri_legal_upload' name='keppri_legal_upload'></td>";

		/* echo "</table>
		<table width=100% id='dasarMintaVisaResultList'>
		<tr></tr>"; */

		//<td width=120>Dasar Permintaan Visa &nbsp; <font color='red'>*</font></td>     <td> : <input type='button' name='tambah_minta_visa' value='+ Tambah'></td>

		echo "</table>";

		 echo "<table width=100% id='dasarBeriVisaResultList'>
		<tr><td width=120>Dasar Pemberian Visa &nbsp;<font color='red'>*</font></td>     <td> : <input type='button' name='tambah_beri_visa' value='+ Tambah'></td></tr>

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
						/*echo "<table width=100%>

							<tr><td width='120'>Kepala Perwakilan &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='keppri' value='' id='keppri' size=50  >
							</td></tr>
							<tr><td width='120'>Jabatan Kepala Perwakilan &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='jbt_keppri' value = '' id='jbt_keppri' size=50  >
							</td></tr>

							<tr><td width='120'>Pejabat Konsuler &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='pjbt_konsuler' value = '' id='pjbt_konsuler' size=50  >
							</td></tr>
							<tr><td width='120'>Jabatan Pejabat Konsuler &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='jbt_konsuler' value = '' id='jbt_konsuler' size=50  >
							</td></tr>
							</table>";
							//}*/
		if($_SESSION[G_leveluser] != 15)
		{
		echo "<table width=100%>

							<tr><td width='120'>Verifikator &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='verifikator' id='verifikator' size=50  >
							</td></tr>
							<tr><td width='120'>Jabatan Verifikator &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='jbt_ver'  id='jbt_ver' size=50  >
							</td></tr>

							<tr><td width='120'>Legalisator &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='legalisator'  id='legalisator' size=50  >
							</td></tr>
							<tr><td width='120'>Jabatan Legalisator &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='jbt_legal' id='jbt_legal' size=50  >
							</td></tr>";
		if($_SESSION[G_leveluser]==14)
		{

		 echo "<tr><td>Tipe Visa &nbsp; <font color='red'>*</font></td>     <td> :
		<select name='tipevisa_otvis' id='tipevisa_otvis'>
		<option value=''>- Silahkan Pilih -</option>
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
		echo "</table>";
							}
							else
							{
								echo "<table width=100%>
								<tr><td width='120'>Keputusan </td> <td style='color:red;font-weight:bold;font-style:italic;'> : &nbsp; ";

								$sql_status="select * from tbl_ref_status where id != 3";
								$tampil_status=mysql_query($sql_status);
								 while($val3=mysql_fetch_array($tampil_status))
								 {

									if($r[status_permohonan] == $val3[id])
									{
										echo $val3[status];
									}

								 }
							echo"
							</td></tr></table>";
							}

	    echo "
		<table width=100%>
		<tr><td colspan=2 align=right>
		<input type='submit'  name='simpan' value='Simpan' id='simpan_baru'>";

		echo"<input type=button value=Batal onclick=self.history.back()></td></tr>
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

						echo"<input type='submit'  name='simpan' value='Simpan' onclick='return konfirmasi()'></form>
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
	$id_otvis = $_GET[idt];
	//print_r("select * from tbl_trans_otvis where no_konsep = '$idt' and pwk_ri = $_SESSION[G_idpwk]");
	if($_SESSION[G_leveluser]==15)
	{
		$where = "where id_otvis = '$id_otvis' and pwk_ri = $_SESSION[G_idpwk]";
	}

	$cek_sesi  = mysql_query("select * from tbl_trans_otvis $where ");
	$cek_sesi2 = mysql_num_rows($cek_sesi);
	//print_r($cek_sesi2);exit;
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
    $input = mysql_query("select * from tbl_trans_otvis where id_otvis = '$id_otvis'");
	$r    = mysql_fetch_array($input);

	 echo "<h2 >Edit Pengajuan Visa</h2>";


	echo "<u>Data Pemohon</u>
		<form method=POST enctype='multipart/form-data' action='./aksi_visa_new.php?module=indeksvisa&act=update&idt=$r[id_otvis]'>

		  <table width=100%>";
	if($_SESSION[G_leveluser]==14)
	{
		if($r[created_by] == '' || $r[created_by] == NULL)
		{
			if($r[status_permohonan] == 0){
				$read_link = 'readonly=readonly';
				$disab_link = 'disabled = disabled';

			} else {
			$read_link = '';
			$disab_link = '';
			}
		}
		else
		{
			$read_link = '';
			$disab_link = '';

		// $read_link = 'readonly=readonly';
		// $disab_link = 'disabled = disabled';
		}

	} else
	if($_SESSION[G_leveluser]==15) //<!-- Update Tim DAM-->
	{
		if($r[status_permohonan] == 1 || $r[status_permohonan] == 2 || $r[status_permohonan] == 0)
			{
			$read_link = 'readonly=readonly';
			$disab_link = 'disabled = disabled';

		}
		else
		{
			$read_link = '';
			$disab_link = '';
		}

	}

	else
	{
		$read_link = '';
		$disab_link = '';
	}
	echo"
		<tr>
		<tr><td  width=120>No Konsep</td>  <td colspan='4'> : $r[no_konsep_pwk]</td>
		<input type='hidden' value='$r[no_konsep_pwk]' name='no_konsep_pwk'>


		</tr>
		<tr><td  width=120>No Otvis</td>  <td colspan='4'> : ";if($r[no_konsep_pusat]) { echo $r[no_konsep_pusat];} else {echo "&nbsp;<i>belum diproses</i>";} echo "
		<input type='hidden' value='$r[no_konsep_pusat]' name='no_otvis_pusat'>
		</td></tr>
		<tr>
		<tr><td  width=120><u>Tanggal</u> <br> <i>Date</i></td>  <td colspan='4'> :
		";
		echo date('d-m-Y',strtotime($r[created_date]));
		echo "<input name='tgl_otvis' value='".date('d-m-Y')."' type='hidden'>";
		echo"
		</td>
		</tr>";
		//echo"<tr>
		//<td>No Brafaks &nbsp; <font color='red'>*</font></td>     <td> : <input type=text name='nobrafaks_otvis' value='$r[no_brafaks]' id='nobrafaks_otvis' size=50  $read_link></td></tr>
		//
		//";





	$tampil=mysql_query("SELECT * FROM m_syarat where jenis_izin='1'");
	if($_SESSION[G_leveluser]!=15)
	{
		if($r[pwk_ri] != null)
		{
	echo "<tr><td>Perwakilan RI &nbsp; <font color='red'>*</font></td>     <td colspan='4'> : <select $disab_link name='pwk_otvis' id='pwk_otvis'>
			<option>- Silahkan Pilih -</option>
			";

				 while($val=mysql_fetch_array($tampil_pwk))
				 {
					echo "<option value='$val[id_perwakilan]'";
					if($r[pwk_ri] == $val[id_perwakilan])
					{
						echo 'selected';
					}
					echo " >$val[perwakilan]</option>";
				 }

		echo "</select>

		</td></tr>";
		}
	}
		echo"<tr>
		<input type=hidden name='pwk_otvis3' id='pwk_otvis3' size=50  value='$r[pwk_ri]'>
		<input type=hidden name='pwk_otvis2' id='pwk_otvis2' size=50  value='$_SESSION[G_idpwk]'>
		<input type=hidden name='no_konsep' id='no_konsep' size=50  value='$r[no_konsep]'>
		<td><u>Nama</u>&nbsp; <font color='red'>*</font><br><i>Name</i> </td>     <td colspan='4'> :";
		?>
		<input type=text name='nama_otvis' value="<?php echo $r[nama]?>" id='nama_otvis' size=50 <?php echo $read_link?> >
		<?php
		echo"</td></tr>
		";

	echo "<tr><td>Kewarnegaraan &nbsp; <font color='red'>*</font></td>     <td colspan='4'> :
		<input type=hidden name='kewarganegaraan_otvis2' id='kewarganegaraan_otvis2' size=50  value='$r[kewarganegaraan]'>

		<select  name='kewarganegaraan_otvis' id='kewarganegaraan_otvis' $disab_link>
			<option>- Silahkan Pilih -</option>
			";

				 while($val=mysql_fetch_array($tampil_kewarganegaraan))
				 {
					echo "<option value='$val[ID_NEGARA]'";
					if($r[kewarganegaraan] == $val[ID_NEGARA])
					{
						echo 'selected';
					}
					echo " >$val[NEGARA]</option>";
				 }

		echo "</select>

		</td></tr>";

		echo"
		<tr><td><u>Foto</u> &nbsp; <font color='red'>*</font><br><i>Photo</i> </td>     <td> : <input type=file size=40 id='foto_upload' name='foto_upload' onchange='validate_photo(this)' $disab_link/>
		<ul>
		<li>Pas Photo terbaru (3 bulan terakhir).</li>
		<li>Warna latar pas photo berwarna putih.</li>
		<li>Wajah pada pas photo melihat lurus ke arah kamera.</li>
		<li>Pas photo merupakan close up dari kepala dan bahu sehingga memenuhi 80% dari seluruh photo.</li>
		<li>Mata harus terbuka dan terlihat jelas.</li>
		<li>Tidak ada bagian kepala yang terpotong dan wajah tidak boleh tertutupi ornamen.</li>
		<li>File foto yang diizinkan hanya dalam bentuk .jpg.</li>
		</ul></td><td>
		<img src=\"../files/otvis/foto/$r[foto]\" width=140 height=180 border=1>
		<!--<img id='user_img'
                                 height='130'
                                 width='130'
                                  />-->
		</td></tr>
		<tr><td><u>No Paspor</u> &nbsp; <font color='red'>*</font><br><i>Passport No.</i></td>     <td> : <input type=text name='paspor_otvis' value='$r[paspor]' id='paspor_otvis' size=50 $read_link>
		Lihat Paspor<a target='_blank' href=\"../files/otvis/paspor/$r[foto_paspor]\"> di <B>SINI</B></a>
		<br><br>&nbsp;&nbsp;<input type=file size=40 id='foto_paspor_upload' name='foto_paspor_upload' onchange='validate_paspor(this)' $disab_link>
		</td><td>
		<!--<img id='paspor_img'
                                 height='130'
                                 width='130'
                                  />-->
		<img src=\"../files/otvis/paspor/$r[foto_paspor]\" width=140 height=180 border=1>
		</td>
		</tr>
		<tr>
			<td>Nomor Handphone</td>
			<td colspan='2'>: <input type='text' name='nomor_handphone' value='$r[nomor_handphone]'></td>
		</tr>

		<table width=100% id='anggotaFamResultList'>
		<tr><td width=120><u>Anggota Keluarga</u> <br><i>Family / Sibling</i></td>     <td colspan='4'> : <input type='button' name='sunting_tambah_anggota_fam' value='+ Tambah' $disab_link></td></tr>
		";

		$sql_fam="select *, DATE_FORMAT(tgl_lahir,'%m/%d/%Y') as USIA,  DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR_SIBLING from tbl_anggota_fam where id_otvis = '$r[id_otvis]'";
		$tampil_fam=mysql_query($sql_fam);
		$jml_fam_exists = mysql_num_rows($tampil_fam);
		$h=1;
		 while($val=mysql_fetch_array($tampil_fam))
			{

				if($_SESSION[G_leveluser] == 15)
				{
					$rsp = 5;
				}
				else
				{
					$rsp = 6;
				}

			echo "<tr id='rowIdw$h'><td></td><td width='10px;'> $val[urutan]. </td>
				  <td width='10px'> Nama &nbsp;&nbsp;
				  </td><td>: &nbsp; <input size=25 class='inputIdw$h' type='text' value = '$val[nama]' id='inputanggotafam_nama' name='anggota_fam[$h][anggotafam_nama]' $read_link>";//<span id='$h' class='btn btn-danger remove-me4 w$h' value='$h' >  <input type='button' value='x'></span></td>

				if (!empty($val[USIA])){
					$birthDate = $val[USIA];
					$jenis_relasi = $val[relasi];
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

 					if ($jenis_relasi == 3){
						$batas_usia = 25;
						$beda_tahun = ($batas_usia-$age)-1;
							if ($age >= $batas_usia ){
								$warning = "<div style='font-size:15px;color:red;' >Usia telah melewati batas 25 Tahun.</div.";
							}
							elseif($beda_tahun <= 3) {
								$duapuluhlimatahun = date('Y') + $beda_tahun;
								$bulanduapuluhlimatahun = $month_text[1];
								$warning = "<div style='font-size:15px;color:orange;'>Usia mendekati 25 tahun.<br> Ybs. akan berusia 25 tahun pada $bulanduapuluhlimatahun $duapuluhlimatahun dalam waktu $beda_tahun Tahun $month_menuju Bulan</div>";
							} else {
								$warning = "<div style='font-size:15px;color:green; float:left;' >Usia Anak memenuhi perysaratan pemberian Otoriasai Visa.</div>";
							}

					}
				} else {
					$warning = "Tgl Lahir belum diisi";
				}
				 echo" <td rowspan='$rsp'><div align=center style='padding-top: 17px'><img src=\"../files/otvis/foto/$val[foto]\" width=140 height=180 border=1> </div></td>
				  </tr>
					<tr>
					<td></td>
					<td></td>
					<td>Tgl lahir</td>
					<td> <input type='text' class='TGL_LAHIR' name='anggota_fam[$h][anggotafam_tgllahir]' value='$val[tgl_lahir]'> $warning </td>
					</tr>
					<tr><td></td><td width='10px;'> </td>
				  <td width='10px'> Foto &nbsp;&nbsp;
				  </td>
				  <td>: &nbsp; <input type='file' name='userfile[$h][anggotafam_foto]' onchange='validate_fam(this)' $disab_link />
				  <ul>
					<li>Pas Photo terbaru (3 bulan terakhir).</li>
					<li>Warna latar pas photo berwarna putih.</li>
					<li>Wajah pada pas photo melihat lurus ke arah kamera.</li>
					<li>Pas photo merupakan close up dari kepala dan bahu sehingga memenuhi 80% dari seluruh photo.</li>
					<li>Mata harus terbuka dan terlihat jelas.</li>
					<li>Tidak ada bagian kepala yang terpotong dan wajah tidak boleh tertutupi ornamen.</li>
					<li>File foto yang diizinkan hanya dalam bentuk .jpg.</li>

					</ul>
				  </td>
				  </tr>
				  <tr><td></td><td width='10px;'> </td>
				  <td width='10px'> Relasi &nbsp;&nbsp;
				  </td>
				  <td>: &nbsp; <select class='inputIdw$h' name='anggota_fam[$h][anggotafam_relasi]' id='inputanggotafam_relasi' $disab_link><option>- Silahkan Pilih -</option>
				  ";
				  $tampil_relasifam3=mysql_query($sql_relasifam);
				   while($val2=mysql_fetch_array($tampil_relasifam3))
				 {
					echo "<option value='$val2[id]'";
					if($val[relasi] == $val2[id])
					{
						echo 'selected';
					}
					echo " >$val2[relasi]</option>";
				 }

				 echo" </select></td>
				  </tr>
				  <tr><td></td><td width='10px;'> </td>
				  <td width='10px'> Paspor &nbsp;&nbsp; <br>

				  </td>
				  <td>: &nbsp;
				  <input size=25 class='inputIdw$h' type='text'  id='inputanggotafam_nopaspor' value = '$val[nopaspor]' name='anggota_fam[$h][anggotafam_nopaspor]' $read_link>
				  <br><br>&nbsp;&nbsp;&nbsp;&nbsp;<input type='file' onchange='validate_fam(this)' name='userfile[$h][anggotafam_foto_paspor]' $disab_link/> Lihat Paspor<a target='_blank'  href=\"../files/otvis/paspor/$val[foto_paspor]\"> di <B>SINI</B></a>
				   <input size=25 class='inputIdw$h' type='hidden'  id='inputanggotafam_jml_fam_ex' value = '$jml_fam_exists' name='anggota_fam[$h][jml_fam_ex]'>
				   <input size=25 class='inputIdw$h' type='hidden'  id='inputanggotafam_filefoto_fam' value = '$val[foto]' name='anggota_fam[$h][filefoto_fam]'>
				   <input size=25 class='inputIdw$h' type='hidden'  id='inputanggotafam_filepaspor_fam' value = '$val[foto_paspor]' name='anggota_fam[$h][filepaspor_fam]'>
				  </td>

				  </tr>";
				  if($_SESSION[G_leveluser]!=15)
				  {
				  echo"<tr><td></td><td width='10px;'> </td>
				  <td width='10px'> Keputusan &nbsp;&nbsp;
				  </td>
				  <td>: &nbsp;
				  <select name='anggota_fam[$h][anggotafam_keputusan]' id='id_keputusan_fam'>
								<option value=''>- Silahkan Pilih -</option>";
								$sql_status17="select * from tbl_ref_status where id != 3";
								$tampil_status17=mysql_query($sql_status17);
								 while($val2=mysql_fetch_array($tampil_status17))
								 {

									echo "<option value='$val2[id]'
									";
									if($val[status_permohonan] == $val2[id])
									{
										echo 'selected';
									}
									echo">$val2[status]</option>";
								 }
							echo"></select>
				  </td>


				  </tr>
				  <div>
				 <tr><td></td><td width='10px;'> </td>
				  <td width='10px'> Alasan Penolakan &nbsp;&nbsp;
				  </td>
				  <td>: &nbsp;
				  <textarea id='id_alasantolak_fam' name='anggota_fam[$h][anggotafam_alasantolak]' placeholder='diisi bila keputusan ditolak' rows=2 cols=35>$val[alasan_tolak]</textarea>
				  </td>
				  </tr>
				  </div>
				  ";
				  }
				  else
				  {
					  echo"<tr><td></td><td width='10px;'> </td>
					  <td width='10px'> Keputusan &nbsp;&nbsp;
					  </td>
					  <td  style='color:red;font-weight:bold;'>: &nbsp; <i>";
					  $sql_status19="select * from tbl_ref_status where id != 3";
									$tampil_status19=mysql_query($sql_status19);
									 while($val29=mysql_fetch_array($tampil_status19))
									 {

										if($val[status_permohonan] == $val29[id])
										{
											echo $val29[status];
										}

									 }
					echo "
					  </i></td>


					  </tr>";
					  if($val[status_permohonan] == 2)
					  {
					  echo"<tr><td></td><td width='10px;'> </td>
					  <td width='10px'> Alasan Penolakan &nbsp;&nbsp;
					  </td>
					  <td>: &nbsp;
					  <textarea  placeholder='diisi bila keputusan ditolak' rows=2 cols=35>$val[alasan_tolak]</textarea>
					  </td>
					  </tr>
					  ";
					  }
				  }
			$h++;
			}
		echo"</table>

		<table width=100%>
		<tr><td width=120><u>Jenis Paspor</u> &nbsp; <font color='red'>*</font><br><i>Passport Type</i></td>     <td> :
		<input type=hidden name='id_tipe_paspor3' id='id_tipe_paspor3' size=50  value='$r[jns_paspor]'>
		<select name='id_tipe_paspor' id='id_tipe_paspor' $disab_link>
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

		<textarea name='tujuan_otvis' id='tujuan_otvis' rows=2 cols=35 $read_link>$r[tujuan]</textarea>

		</td></tr>";

        echo "
		<input type=hidden name='posisi3' id='posisi3' size=50  value='$r[posisi]'>

		 <tr><td><u>Posisi</u> &nbsp; <font color='red'>*</font><br><i>Position</i></td>
	   <td> :
		<select name='posisi' id='posisi' $disab_link>
		<option value=''>- Silahkan Pilih -</option>
		";
		 while($val=mysql_fetch_array($tampil_posisi))
				 {
					 echo "<option value='$val[id]'";
					if($r[posisi] == $val[id])
					{
						echo 'selected';
					}
		 echo ">$val[posisi]</option>";
				 }
		 echo"</select>";
		 if($r[posisi]==2 or $r[posisi]==5)
		 {
		 echo "
		<div id='replacement' style='";

		if($r[posisi] == 1) echo "display:none"; echo "'><br>&nbsp;&nbsp;<input type=text placeholder='masukkan nama yang digantikan' value='$r[pengganti]' id='pengganti' name='pengganti' size=50 $read_link>
	   </div>";
		 }
	   echo "</td></tr>
		 <tr><td><u>Masa Penugasan </u>&nbsp; <font color='red'>*</font><br><i>Assignment Period</i></td>     <td> <DIV id=\"tgl\">";  if (empty($r[masa_awal_tugas])) {echo "<script>DateInput('masa_awal_tugas', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script>";} else { echo "<script>DateInput('masa_awal_tugas', true, 'YYYY-MM-DD','$r[masa_awal_tugas]')</script>"; } echo"</DIV> <div style='padding-left:80px;'>s/d <i>(until)</i> </div><DIV id=\"tgl\">";  if (empty($r[masa_akhir_tugas])) {echo "<script>DateInput('masa_akhir_tugas', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script>";} else { echo "<script>DateInput('masa_akhir_tugas', true, 'YYYY-MM-DD','$r[masa_akhir_tugas]')</script>"; } echo"</div></td></tr>

		<tr><td>Surat Setneg &nbsp;  </td>     <td > : <input type=file size=40 id='setneg_upload' name='setneg_upload' $disab_link>";
		if($r[surat_setneg])
		{
		echo "Lihat file unggahan<a target='_blank' href='../files/otvis/setneg/$r[surat_setneg]'> di <B>SINI</B></a></td></tr>";
		}
		echo"<tr><td><u>Tempat Penugasan </u>&nbsp; <font color='red'>*</font><br><i>Assignment Place</i></td>     <td> : <input type=text placeholder='masukkan tempat penugasan di Indonesia' value='$r[tempat_tugas]' id='tempattugas_otvis' name='tempattugas_otvis' size=50 $read_link ></td></tr>

		<tr><td><u>Nota Diplomatik</u> &nbsp; <font color='red'>*</font><br><i>Diplomatic No.</i> </td>     <td > : <input type=text  name='no_nota_diplomatik' id='no_nota_diplomatik' value='$r[no_nota_diplomatik]' size=50 $read_link ><br>&nbsp;&nbsp;<input type=file size=40 id='nota_diplomatik_upload' name='nota_diplomatik_upload' $disab_link>Lihat file unggahan<a target='_blank' href='../files/otvis/notadinas/$r[nota_dinasdiplomatik]'> di <B>SINI</B></a> | alternatif link : <a target='_blank' href='get_file.php?fn=$r[nota_dinasdiplomatik]'> di <B>SINI</B></a></td>

		";



		/* echo "<tr><td>Surat Nikah(Spouse)  </td>     <td > : <input type=file size=40 id='surat_nikah_upload' name='surat_nikah_upload'>";
		if($r[surat_nikah])
		{
		echo "Lihat file unggahan<a href='../files/otvis/suratnikah/$r[surat_nikah]'> di <B>SINI</B></a>";
		}
		echo "</td></tr>
		<tr><td>Surat Legalisasi Keppri &nbsp; <font color='red'>*</font> </td>     <td > : <input type=file size=40 id='keppri_legal_upload' name='keppri_legal_upload'>Lihat file unggahan<a href='../files/otvis/legalitas/$r[kepri_legal]'> di <B>SINI</B></a></td>
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
		$sql_berivisa="select * from tbl_dasarberi_visa where id_otvis = '$r[id_otvis]'";
		$tampil_berivisa=mysql_query($sql_berivisa);
		$h=1;
		 while($val=mysql_fetch_array($tampil_berivisa))
			{
			echo "<tr id='rowIdy$h'><td width=14%>&nbsp;</td>     <td> $val[urutan]. <input size=50 class='inputIdy$h' id='inputberivisa' type='text' value = '$val[dasar_berivisa]' name='dasar_berivisa[$h][dasarberivisa]'><span id='$h' class='btn btn-danger remove-me2 y$h' value='$h' ><input type='button' value='x'></span></td></tr>";
			$h++;
			}
		echo "</table>";
		}
		if($r[pwk_ri] != null)
		{
		echo "<table width=100%>

							<tr><td width='120'>Kepala Perwakilan </td> <td> :
							<input type=text name='keppri' value='$r[kepala_pwk]' id='keppri' size=50 $read_link>
							</td></tr>
							<tr><td width='120'>Jabatan Kepala Perwakilan </td> <td> :
							<input type=text name='jbt_keppri' value = '$r[jabatan_kepala_pwk]' id='jbt_keppri' size=50 $read_link>
							</td></tr>

							<tr><td width='120'>Pejabat Konsuler</td> <td> :
							<input type=text name='pjbt_konsuler' value = '$r[pejabat_pwk]' id='pjbt_konsuler' size=50 $read_link >
							</td></tr>
							<tr><td width='120'>Jabatan Pejabat Konsuler </td> <td> :
							<input type=text name='jbt_konsuler' value = '$r[jabatan_pejabat_pwk]' id='jbt_konsuler' size=50 $read_link >
							</td></tr>
							</table>";
		}
		if($_SESSION[G_leveluser] != 15)
		{
		echo "<table width=100%>

							<tr><td width='120'>Verifikator &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='verifikator' value = '$r[verifikator]' id='verifikator' size=50  >
							</td></tr>
							<tr><td width='120'>Jabatan Verifikator &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='jbt_ver' value = '$r[jabatan_verifikator]' id='jbt_ver' size=50  >
							</td></tr>

							<tr><td width='120'>Legalisator &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='legalisator' value = '$r[legalisator]' id='legalisator' size=50  >
							</td></tr>
							<tr><td width='120'>Jabatan Legalisator &nbsp; <font color='red'>*</font></td> <td> :
							<input type=text name='jbt_legal' value = '$r[jabatan_legalisator]' id='jbt_legal' size=50  >
							</td></tr>";
		if($_SESSION[G_leveluser]==14)
		{

		 echo "<tr><td>Tipe Visa &nbsp; </td>     <td> :
		<select name='tipevisa_otvis' id='tipevisa_otvis'>
		<option value=''>- Silahkan Pilih -</option>
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


		<tr><td>Indeks Visa &nbsp; </td>     <td> :
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
		echo "					<tr><td width='120'>Keputusan </td> <td> :
							<select name='ID_JNS_KEPUTUSAN' id='ID_JNS_KEPUTUSAN'>
								<option value=''>- Silahkan Pilih -</option>";
								$sql_status="select * from tbl_ref_status where id != 3";
								$tampil_status=mysql_query($sql_status);
								 while($val3=mysql_fetch_array($tampil_status))
								 {
									//print_r($val3);
									echo "<option value='$val3[id]'
									";
									if($r[status_permohonan] == $val3[id])
									{
										echo 'selected';
									}
									echo">$val3[status]</option>";
								 }
							echo"></select>  Lama Tinggal (1-30 Hari) : <input type=number name='lama_tinggal' value = '$r[lama_tinggal]' id='lama_tinggal' min=1 max=30 size=5> Hari <!-- TIM DAM -->
							</td></tr>
                                                        <!-- TIM DAM -->
                                                        <tr><td>Tgl. Keputusan &nbsp;</td><td><DIV id=\"tgl\">";  if (empty($r[tgl_keputusan])) { echo "<script>DateInput('tgl_keputusan', true, 'YYYY-MM-DD')</script>";} else { echo "<script>DateInput('tgl_keputusan', true, 'YYYY-MM-DD','$r[tgl_keputusan]')</script>"; } echo"</div> </td></tr></table>
                                                        <!-- TIM DAM -->";
							}
							else
							{
								echo "<table width=100%>
								<tr><td width='120'>Keputusan </td> <td style='color:red;font-weight:bold;font-style:italic;'> : &nbsp; ";

								$sql_status="select * from tbl_ref_status where id != 3";
								$tampil_status=mysql_query($sql_status);
								 while($val3=mysql_fetch_array($tampil_status))
								 {

									if($r[status_permohonan] == $val3[id])
									{
										echo $val3[status];
									}

								 }
							echo"
							</td></tr></table>";
							}

							if($_SESSION[G_leveluser]==15)
							{
								$read_link1 = 'readonly=readonly';
							}
							echo "<table width=100% border='0' cellspacing='0' cellpadding='0'>";
							if($r[pwk_ri] != null)
							{
							echo "<tr><td width='120'>Catatan Perwakilan</td>  <td> :
							<textarea name='catatan_pwk' id='catatan_pwk' rows=2 cols=35 $read_link >$r[catatan_pwk]</textarea>
							</td></tr>";
							}
							echo"
							<tr><td width='120'>Catatan Pusat</td>  <td> :
							<textarea name='catatan_otvis' id='catatan_otvis' rows=2 cols=35 maxlength=1000 $read_link1 >$r[catatan]</textarea>
							</td></tr>
							";
							//Update Tim DAM, tambah jg di tablenya
                                                        if($_SESSION[G_leveluser]==14)
							{
							echo"
							<tr><td width='120'>Pemroses</td>  <td> :";
                                                        if($r[status_permohonan]==3){
                                                          echo"
                                                            <input type=text name='pemroses' value = '$_SESSION[G_namauser]' id='pemroses' size=50 maxlength=100 readonly=readonly >
                                                            </td></tr>
							";
                                                        }else{
                                                            echo"
                                                            <input type=text name='pemroses' value = '$r[pemroses]' id='pemroses' size=50 maxlength=100 readonly=readonly >
                                                            </td></tr>
							";
                                                        }

                                                        echo"
							<tr><td width='120'>Status Print</td>  <td> :
							<input type=text name='sts_print' value = '$r[sts_print]' id='sts_print' size=50 maxlength=100 >
							</td></tr></table>
							";
                                                        }
                                                        //
							echo "

							<table id='tombol' width=100% border='0' cellspacing='0' cellpadding='0'>
							<tr>  <td align='right'>";
							if($_SESSION[G_leveluser]==15)
							{
								if($r[status_permohonan] == 1 || $r[status_permohonan] == 2 || $r[status_permohonan] == 0)
								{
									echo "<input type=button value=Kembali onclick=self.history.back()>";
								}
								else
								{
									//<input type='submit'  name='simpan' id='simpan_otvis' value='Simpan' onclick='return konfirmasi()'>
								echo"
								<input type='submit'  name='simpan' id='simpan_otvis' value='Simpan'>
								<input type=button value=Batal onclick=self.history.back()>";
								}
							}
							else
							{
								if($r[status_permohonan] != 0){
									echo"<input type='submit'  name='simpan' id='simpan_otvis' value='Simpan'>";
								}
								echo '<input type=button value=Batal onclick=self.history.back()>';
							}
							echo "
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
				echo "
					<form id='datadukungForm' method='POST' enctype='multipart/form-data' action='./aksi_visa_new.php?module=indeksvisa&act=upload_data_dukung&idt=$r[id_otvis]'>
						<input type='hidden' name='id_otvis' value='$r[id]'>
						<table width='100%'>
						<tr>
						<td colspan='2'><u>Data Pendukung Lainnya</u></td></tr>
						<tr>
							<td rowspan='2'>Tambah Data dukung</td>
							<td>Nama Data Dukung * : <input type='text' size='50' name='nama'></td>
							<tr><td>
									Pilih File data dukung * : <input type='file' name='file_data_dukung'><br>
									<input type='submit' value='Upload Data Dukung' id='upload' name='upload'> <label id='status'></label>
									</td>
						</tr>
						<tr>
							<td>Data Dukung Saat ini:</td>
							<td valign='top' style='text-valign:top;'  id='list_data_dukung'>

							</td>
						</tr>
							</table>
						</form>";

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
<script>
$(".TGL_LAHIR").datepicker({dateFormat: 'yy-mm-dd'});
</script>
<script src="../config/jquery.form/jquery.form.js"></script>
<script>
$(document).ready(function () {

	get_data_dukung();

	$('#datadukungForm').ajaxForm({
         dataType:  'json',
				 beforeSend: function(){
					 $('#status').html('processing...');
					 $('#upload').prop('disabled', true);
				 },
         success:   processJson
    });
});

$('body').on("click", 'a.test', function() {
	var selector = $(this);
	var tanya = confirm("Apakah anda yakin ingin menghapus data ini ?");
	if (tanya) {
			var nilai = $(this).attr('nilai');
			$.ajax({
				url: "./aksi_visa_new.php?module=indeksvisa&act=del_data_dukung",
				data: { nilai:nilai },
				method: "POST",
				dataType: "json"
			})
			.done(function(msg){
				selector.closest("tr").remove();
				alert(msg.result);
			});
		}
	});

function get_data_dukung(){
	$.ajax({
		url: "./aksi_visa_new.php?module=indeksvisa&act=get_data_dukung&idt=<?php echo $r['id']; ?>",
		dataType : "text",
	}).done(function(msg){
		$('#list_data_dukung').html(msg);

	});
}

function processJson(data) {
		get_data_dukung();
		document.getElementById('datadukungForm').reset();
		$('#status').html('')
		$('#upload').prop('disabled', false);
		alert(data.result);
}
</script>
