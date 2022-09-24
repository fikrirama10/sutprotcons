<?php
echo "<br><a href=?module=epo&act=cari&huruf=A>A</A> |	<a href=?module=epo&act=cari&huruf=B>B</A> |
			     <a href=?module=epo&act=cari&huruf=C>C</A> |	<a href=?module=epo&act=cari&huruf=D>D</A> |
				 <a href=?module=epo&act=cari&huruf=E>E</A> |	<a href=?module=epo&act=cari&huruf=F>F</A> |
				 <a href=?module=epo&act=cari&huruf=G>G</A> |	<a href=?module=epo&act=cari&huruf=H>H</A> |
				 <a href=?module=epo&act=cari&huruf=I>I</A> |	<a href=?module=epo&act=cari&huruf=J>J</A> |
				 <a href=?module=epo&act=cari&huruf=K>K</A> |	<a href=?module=epo&act=cari&huruf=L>L</A> |
				 <a href=?module=epo&act=cari&huruf=M>M</A> |	<a href=?module=epo&act=cari&huruf=N>N</A> |
				 <a href=?module=epo&act=cari&huruf=O>O</A> |	<a href=?module=epo&act=cari&huruf=P>P</A> |
				 <a href=?module=epo&act=cari&huruf=Q>Q</A> |	<a href=?module=epo&act=cari&huruf=R>R</A> |
				 <a href=?module=epo&act=cari&huruf=S>S</A> |	<a href=?module=epo&act=cari&huruf=T>T</A> |
				 <a href=?module=epo&act=cari&huruf=U>U</A> |	<a href=?module=epo&act=cari&huruf=V>V</A> |
				 <a href=?module=epo&act=cari&huruf=W>W</A> |	<a href=?module=epo&act=cari&huruf=X>X</A> |
				 <a href=?module=epo&act=cari&huruf=Y>Y</A> |	<a href=?module=epo&act=cari&huruf=Z>Z</A>";

switch ($_GET[act]) {
  default:


    if (isset($_GET[negara])) {
      $negaranya = $_GET[negara];
      if ($_GET[negara] == "") {
        $negaranya = 'Semua negara';
      }
    } else {
      $negaranya = 'Semua negara';
    }
		if (!empty($_GET['opsi'])) {
			if ($_GET['opsi']=='nama_diplomat') {
				$selected_nama_diplomat = "selected";
				//$opsi_selected = "<option value='$_GET[value]' selected>Nama Diplomat</option>";
			} elseif ($_GET['opsi']=='nama_epo') {
				//$opsi_selected = "<option value='$_GET[value]' selected>No. Stiker/EPO</option>";
				$selected_no_EPO = "selected";
 			} else {
				//$opsi_selected = null;
			}
		}
    // echo "<h2>Pengajuan Exit Permit Only (EPO) <br>Pilih Diplomat - $negaranya</h2>
		// 	<form method=get action='./deplu.php?' enctype='multipart/form-data'>
		// 		 <input type=hidden name=module value='epo'>
		// 		 <input type=hidden name=negara value='$_GET[negara]'>
		// 	Nama Diplomat : <input type=text name=\"namadiplomat\"> <input type=submit value=Cari>
		// 	</form> <br>
		echo "<h2>Pengajuan Exit Permit Only (EPO) <br>Pilih Diplomat - $negaranya</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='epo'>
				 <input type=hidden name=negara value='$_GET[negara]'>
				 Pencarian Berdasarkan: <select name='opsi'>
					 <option value='nama_diplomat' $selected_nama_diplomat>Nama Diplomat</option>
					 <option value='nama_epo' $selected_no_EPO>No. Stiker/EPO</option>
				 </select>
				 <input type='text' name='value' value='$_GET[value]'>
				 <input type=submit value=Cari>
			</form> <br>

		  <table width=100%>
          <tr><th width=30>no</th><th>NO. PENDAFTARAN</th><th>Status</th><th width=100>NO EPO</th><th width=130>NAMA LENGKAP</th><th width=160>KANTOR PERWAKILAN</th><th>JABATAN</th><th width=70>TGL BERLAKU</th><!--<th>STATUS DIR</th>--><th width=30>STATUS KASUBDIT</th><th width=30>STATUS KASIE</th></th><th width=55>AKSI</th></tr>";

    $p = new Paging;
    $batas = 10;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];

    // if ((isset($_GET[namadiplomat])) && !(empty($_GET[namadiplomat]))) {
		if ((isset($_GET[value])) && !(empty($_GET[value]))) {
			if ($_GET['opsi']=='nama_diplomat') {
					$field = "AND c.NM_DIPLOMAT";
					$val = "'%".$_GET[value]."%'";
			}
			if ($_GET['opsi']=='nama_epo') {
					$field =  "AND a.NO_EPO";
					$val = "'%".$_GET[value]."%'";
			}

      // print_r($_GET[namadiplomat]);exit;
      /* $sql=("
        select a.ID_CARD,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.PEKERJAAN, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,
        date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD, a.ST_KARTU,a.ST_KARTU_K,a.ST_KARTU_KAS, NO_DAFTAR, STATUS_WORKFLOW  from v_diplomat c
        left join v_id_card a  on a.id_diplomat=c.id_diplomat and KD_WORKFLOW>=1 where c.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' order by a.tgl_kirim desc, a.id_cetak desc limit $posisi,$batas");
       */

      // $sql_epo = ("select a.ID_EPO,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO, date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K,a.ST_EPO_KAS, a.NO_DAFTAR, a.STATUS_WORKFLOW  from v_diplomat c, v_epo a  where a.id_diplomat=c.id_diplomat and KD_WORKFLOW>=1 and c.NM_DIPLOMAT like '%" . $_GET[namadiplomat] . "%' order by a.tgl_kirim desc, a.ID_EPO desc limit $posisi,$batas");
			$sql_epo = "SELECT
											a.ID_EPO,
											c.ID_DIPLOMAT,
											c.NM_DIPLOMAT,
											c.NM_KNT_PERWAKILAN,
											c.PEKERJAAN,
											date_format(a.TGL_AWAL_EPO,'%d.%m.%Y')  AS TGL_AWAL_EPO,
											date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') AS TGL_AKHIR_EPO,
											a.ST_EPO,
											a.ST_EPO_K,
											a.ST_EPO_KAS,
											a.NO_DAFTAR,
											a.STATUS_WORKFLOW,
											a.NO_EPO
								FROM
										v_diplomat c,
										v_epo a
								WHERE
										a.id_diplomat=c.id_diplomat AND
										KD_WORKFLOW>=1
										$field like $val

 								ORDER BY
										a.tgl_kirim DESC,
										a.ID_EPO DESC LIMIT $posisi, $batas";

      //echo $sql_epo;
      $tampil = mysql_query($sql_epo);
      //print_r($tampil2_sql);
    // } else if (empty($_GET[namadiplomat])) {
		} else if (empty($_GET[value])) {

      /* $sql=("select a.ID_CARD,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.PEKERJAAN, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD, a.ST_KARTU,a.ST_KARTU_K,a.ST_KARTU_KAS  from v_id_card a right join v_diplomat c on a.id_diplomat=c.id_diplomat order by a.id_card desc limit $posisi,$batas");
        $sql = "select a.ID_CARD,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.PEKERJAAN, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as
        TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD, a.ST_KARTU,a.ST_KARTU_K,a.ST_KARTU_KAS, NO_DAFTAR, STATUS_WORKFLOW    from v_diplomat c
        left join v_id_card a  on a.id_diplomat=c.id_diplomat and KD_WORKFLOW>=1 order by a.tgl_kirim desc,  a.id_cetak desc limit $posisi,$batas";
       */


      //$sql=("select a.ID_EPO,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K,a.ST_EPO_KAS  from v_epo a right join v_diplomat c on a.id_diplomat=c.id_diplomat order by a.ID_EPO desc limit $posisi,$batas");


      /* $sql_epo1 = "select a.ID_EPO,c.ID_DIPLOMAT,a.NO_EPO,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as
        TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K,a.ST_EPO_KAS, a.NO_DAFTAR, a.STATUS_WORKFLOW,a.KD_WORKFLOW    from v_diplomat c, v_epo a  where a.id_diplomat=c.id_diplomat and a.KD_WORKFLOW>=1 order by a.tgl_kirim desc,  a.ID_EPO desc limit $posisi,$batas"; */

      $sql_epo1 = "(select a.ID_EPO,c.ID_DIPLOMAT,a.ID_OTVIS,a.NO_EPO,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K,a.ST_EPO_KAS, a.NO_DAFTAR, a.STATUS_WORKFLOW,a.KD_WORKFLOW    from v_diplomat c, v_epo a  where a.id_diplomat=c.id_diplomat and a.KD_WORKFLOW>=1 )
union
(select a.ID_EPO,a.ID_DIPLOMAT,a.ID_OTVIS,a.NO_EPO,c.nama,c.tempat_tugas,c.tujuan, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as
		TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K,a.ST_EPO_KAS, a.NO_DAFTAR, a.STATUS_WORKFLOW,a.KD_WORKFLOW from tbl_trans_otvis c, v_epo a where a.ID_OTVIS=c.id and a.KD_WORKFLOW>=1 ) ORDER BY ID_EPO DESC  limit $posisi,$batas";

      $tampil = mysql_query($sql_epo1);
      //print_r($sql_epo1);exit;
    }

	$sql_jml_epo = ("select STATUS_WORKFLOW,count(*) as jml from v_epo where ID_EPO not in ('1','2') GROUP BY STATUS_WORKFLOW");
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
    $no = $posisi + 1;
    while ($r = mysql_fetch_array($tampil)) {

      echo "<tr><td>$no</td> ";
      if ($r[ID_OTVIS] != null) {
        echo"<td><a href=?module=epo&act=lihat_epo&idt=$r[ID_OTVIS]&negara=$_GET[negara]>$r[NO_DAFTAR]</a></td>";
      } else {
        echo"<td><a href=?module=epo&act=lihat_epo&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NO_DAFTAR]</a></td>";
      }
	  if($r[STATUS_WORKFLOW] == 'Menunggu Verifikasi'){
		  $warna =  "style='color: black;'";
	  }elseif($r[STATUS_WORKFLOW] == 'Lolos Verifikasi'){
		  $warna =  "style='color: green;'";
	  }elseif($r[STATUS_WORKFLOW] == 'Tidak Lolos Verifikasi'){
		  $warna =  "style='color: red;'";
	  }
      echo "<td $warna>$r[STATUS_WORKFLOW]</td>";

      if ($r[ID_OTVIS] != null) {
        echo "<td><a href=?module=epo&act=lihat_epo&idt=$r[ID_OTVIS]&negara=$_GET[negara]>$r[NO_EPO]</a></td>";
        echo "<td><a href=?module=diplomat&act=viewdiplomat&idt=$r[ID_OTVIS]&negara=$_GET[negara]>$r[NM_DIPLOMAT]</a></td>";
      } else {
        echo "<td><a href=?module=epo&act=lihat_epo&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NO_EPO]</a></td>";
        echo "<td><a href=?module=diplomat&act=viewdiplomat&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NM_DIPLOMAT]</a></td>";
      }
      echo "<td>$r[NM_KNT_PERWAKILAN]</td>
				<td>$r[PEKERJAAN]</td>
				<td>$r[TGL_AWAL_EPO] - $r[TGL_AKHIR_EPO]</td>
				";
      /* echo "<td>";
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
        echo "</td>"; */
      /* echo"	<td align =center>";

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
        } */
      echo "<!--</td>--><td align =center>";
      if (isset($r[ST_EPO_K])) {
        if ($r[ST_EPO_K] == 2) {
          echo "<div style=\"color : green\"> <b>Approved</b> </div>";
        } elseif ($r[ST_EPO_K] == 1) {
          echo "<div style=\"color : #B1BF19\"> <b>Waiting</b> </div>";
        } elseif ($r[ST_EPO_K] == 0) {
          echo "<div style=\"color : #800000\"> <b>Reject</b> </div>";
        }
      } else {
        echo "-";
      }
      echo "</td><td align =center>";
      if (isset($r[ST_EPO_KAS])) {
        if ($r[ST_EPO_KAS] == 2) {
          echo "<div style=\"color : green\"> <b>Approved</b> </div>";
        } elseif ($r[ST_EPO_KAS] == 1) {
          echo "<div style=\"color : #B1BF19\"> <b>Waiting</b> </div>";
        } elseif ($r[ST_EPO_KAS] == 0) {
          echo "<div style=\"color : #800000\"> <b>Reject</b> </div>";
        }
      } else {
        echo "-";
      }

      echo "</td>";
      if ($r[ID_OTVIS] != null) {
        echo "<td><a href=?module=epo&act=lihat_epo&idt=$r[ID_OTVIS]&negara=$_GET[negara]&jns=manual>Lihat EPO</a></td>";
      } else {
        echo "<td><a href=?module=epo&act=lihat_epo&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>Lihat EPO</a></td>";
      }

      echo "</tr>";
      $no++;
    }
    echo "</table>";

    if (isset($_GET[namadiplomat])) {
      //$jmldata =mysql_num_rows(mysql_query("SELECT ID_DIPLOMAT,NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN,PEKERJAAN FROM  v_diplomat where negara like '".$neg."%' and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' "));

      $jmldata = mysql_num_rows(mysql_query("select * from v_diplomat c, v_epo a  where a.id_diplomat=c.id_diplomat and c.negara like '" . $neg . "%' and c.NM_DIPLOMAT like '%" . $_GET[namadiplomat] . "%'"));
    } else {
      //$jmldata =mysql_num_rows(mysql_query("SELECT ID_DIPLOMAT,NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN,PEKERJAAN FROM  v_diplomat where negara like '".$neg."%'"));

      $jmldata = mysql_num_rows(mysql_query("select * from v_diplomat c, v_epo a  where a.id_diplomat=c.id_diplomat and c.negara like '" . $neg . "%'"));
    }
    $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);


    $ilink = "?module=epo&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]";

    $linkHalaman = $p->navHalaman($ilink, $_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;




  case "lihat_epo":
    /* if (!empty($_GET['stat'])){
      if ($_GET['stat']=='1'){
      $status="SUDAH";

      $tanggal = ", TGL_PENGEMBALIAN='".date('Y-m-d')."'";
      } else {
      $status="BELUM";
      $tanggal = ", TGL_PENGEMBALIAN = NULL";
      }
      $sql="update cetak_kartu_diplomat set STATUS_PENGEMBALIAN='".$status."' $tanggal where ID_CETAK='".$_GET[idd]."'";
      echo "<script>alert('Berhasil melakukan perubahan status Pengembalian Kartu Menjadi : $status.');</script>";
      mysql_query($sql);
      } */
    $jns = $_GET[jns];
    $idt = $_GET[idt];


    if ($jns !== 'manual') {

      $sql = "select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,FOTO_TTD, PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA,ID_RANK from diplomat where ID_DIPLOMAT = $idt";

      $input = mysql_query($sql);
      $r = mysql_fetch_array($input);
      $rangking = $r[ID_RANK];

      echo "<h2 >EPO - Lihat</h2>";
      echo "	  <table width=100%>
          <tr><td  width=160>Kewarganegaraan</td>  <td > : ";
      $tampil = mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
      $w = mysql_fetch_array($tampil);

      $tampil28 = mysql_query("select * from cetak_kartu_diplomat where ID_DIPLOMAT = $idt");
      $get_dataepo = mysql_num_rows($tampil28);

      if ($get_dataepo != 0) {
        $sql = "select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idt)";
      } else {
        $sql = "select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idt)";
      }
      //echo $sql;
      $detil = mysql_query($sql);
      $det = mysql_fetch_array($detil);
      $foto = $r[FOTO];
      $foto_ttd = $r[FOTO_TTD];

      echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto/$r[FOTO]\" width=110 height=150 border=1> <img src=\"../foto/ttd/$r[FOTO_TTD]\" width=110 height=40 border=1></div>
	<br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br><br>";

      $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");
      $det = mysql_fetch_array($detil);

      echo "<b>Stay Permit </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No Izin Permit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";

      $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");
      $det = mysql_fetch_array($detil);

      echo "<b>Sibling </b><br>";
      $nosib = 1;
      $detil = mysql_query("select  NM_SIBLING,NM_JNS_RELASI from v_sibling where ID_DIPLOMAT = $idt order by ID_JNS_RELASI");
      while ($det = mysql_fetch_array($detil)) {
        echo "$nosib. $det[NM_SIBLING] - $det[NM_JNS_RELASI] <br>";
        $nosib = $nosib + 1;
      }

      echo "
	</td>
		<tr><td>Nama Diplomat</td>     <td> : $r[NM_DIPLOMAT]</td></tr>
		<tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : ";
      if ($r[JK] == 'l') {
        echo "Laki-laki";
      } else {
        echo "Perempuan";
      }
      echo "</td> </tr>
		<tr><td>Pekerjaan</td >  <td > : $r[PEKERJAAN]</td></tr>
		<tr><td>Status Sipil</td>     <td  > : ";

      if ($r[ST_SIPIL] == 's') {
        echo "Belum Menikah";
      } else {
        echo "Sudah Menikah";
      }
      echo "</td></tr>
		<tr><td>Alamat Indonesia </td>     <td > : <textarea name='ALAMATIN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATIN]</textarea></td></tr>

		<tr><td>Jenis / No. Paspor</td >     <td > :  ";
      $tampil = mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");

      $w = mysql_fetch_array($tampil);
      echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR]</td></tr>
		<tr><td>Diberikan oleh</td >     <td > : $r[PASPOR_OLEH]  -  $r[PASPOR_TGL] </td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[AKHIR_BERLAKU]</td></tr>

		<tr><td>Jenis / No. Visa</td >     <td > : ";
      $tampil = mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA = $r[ID_JNS_VISA]");
      $w = mysql_fetch_array($tampil);

      echo " $w[NM_JNS_VISA] / $r[NO_VISA] </td></tr>
		  </table> <br>";
    } elseif ($jns == 'manual') {
//epo manual

      $sql = "select a.id,a.no_konsep_pusat, d.NEGARA,a.nama, a.paspor,e.jns_paspor,a.tempat_tugas,a.tujuan,date_format(a.masa_awal_tugas,'%d.%m.%Y') as TGL_TIBA, date_format(a.masa_akhir_tugas,'%d.%m.%Y') as tgl_akhir_tugas, concat(b.tipe_visa,' ',c.KD_JNS_VISA) as jns_visa, f.perwakilan as diberikan_oleh, a.foto, a.foto_paspor, g.KODE_AGENDA
FROM tbl_trans_otvis a LEFT JOIN tbl_tipe_visa b on a.tipe_visa = b.id LEFT JOIN m_jns_visa c on a.indeks_visa=c.ID_JNS_VISA LEFT JOIN m_negara d on a.kewarganegaraan = d.ID_NEGARA LEFT JOIN tbl_jns_paspor e on a.jns_paspor = e.id LEFT JOIN tbl_perwakilan f on a.pwk_ri=f.id_perwakilan LEFT JOIN m_kantor_perwakilan g on a.tempat_tugas = g.NM_KNT_PERWAKILAN where a.id = $idt";

      $input = mysql_query($sql);
      $r = mysql_fetch_array($input);

      echo "<h2 >EPO Manual - Lihat</h2>";
      echo "	  <table width=100%>
          <tr><td  width=160>Kewarganegaraan</td>  <td > : ";
      echo "$r[NEGARA] </td><td rowspan=\"8\"  width=200 ><div align=center><img src=\"../files/otvis/foto/$r[foto]\" width=110 height=150 border=1><img src=\"../files/otvis/paspor/$r[foto_paspor]\" width=110 height=150 border=1></div>
	<br>";

      echo "
	</td>
		<tr><td>Nama Diplomat</td>     <td> : $r[nama]</td></tr>
		<tr><td>No. Paspor</td>     <td> : $r[paspor]</td></tr>
		<tr><td>Jenis Paspor</td>     <td> : $r[jns_paspor]</td></tr>
    </td> </tr>
		<tr><td>Tempat Tugas</td >  <td > : $r[tempat_tugas] / $r[KODE_AGENDA]</td></tr>
		<tr><td>Tujuan</td>     <td  > : $r[tujuan]</td></tr>
          </td></tr>
          <tr><td>Jenis - No. Visa</td >     <td > : $r[jns_visa] -- $r[no_konsep_pusat]</td></tr>
		<tr><td>Visa oleh</td >     <td > : $r[diberikan_oleh] </td></tr>


          </td></tr>
		  </table> <br>";
    }
//end epo manual
    $tampil = mysql_query("select a.ID_EPO,a.ID_DIPLOMAT,a.NO_EPO,date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO,a.KET, a.ST_EPO,a.ST_EPO_K,a.ST_EPO_KAS,b.ID_RANK from epo_diplomat a, diplomat b where a.ID_DIPLOMAT=b.ID_DIPLOMAT and a.ID_DIPLOMAT = $idt order by  ID_EPO desc limit 0,1");

    //echo "select a.ID_EPO,a.ID_DIPLOMAT,a.NO_EPO,date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO,a.KET, a.ST_EPO,a.ST_EPO_K,a.ST_EPO_KAS,b.ID_RANK from epo_diplomat a, diplomat b where a.ID_DIPLOMAT=b.ID_DIPLOMAT and a.ID_DIPLOMAT = $idt order by  ID_EPO desc limit //0,1";exit;

    $r = mysql_fetch_array($tampil);

    //if ((($r[ST_EPO_K] == 2) and ($r[ST_EPO_KAS] == 2) or $r[ID_RANK]=='15')) { //jika konsul kehormatan tidak perlu ijin tinggal

	if ($jns == 'manual') {
    $sql = ("select a.ID_EPO,a.ID_DIPLOMAT,a.NO_EPO,a.TGL_AWAL_EPO,a.TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K,a.ST_EPO_KAS, a.KD_WORKFLOW from epo_diplomat a where a.ID_OTVIS = $idt and a.KD_WORKFLOW>=1 order by  a.TGL_AKHIR_EPO desc limit 0,1 ");
	}
	elseif($jns != 'manual') {
	$sql = ("select a.ID_EPO,a.ID_DIPLOMAT,a.NO_EPO,a.TGL_AWAL_EPO,a.TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K,a.ST_EPO_KAS, a.KD_WORKFLOW from epo_diplomat a where a.ID_DIPLOMAT = $idt and a.KD_WORKFLOW>=1 order by  a.TGL_AKHIR_EPO desc limit 0,1 ");

	}

    //echo $sql; exit;

    $tampil = mysql_query($sql);
    $r = mysql_fetch_array($tampil);

	//print_r($r);exit;
    if (($r[ST_EPO_K] == 2) and ( $r[ST_EPO_KAS] == 2) and ( $r[KD_WORKFLOW]) == 3) {
      ?>
      <form method=POST enctype="multipart/form-data" action="./report.php?go=epo">

        <input type=hidden name="idt" value="<?php echo $idt; ?>">
        <input type=hidden name="jns" value="<?php echo $jns; ?>">

        <div id="tgl" type="hidden"> Tanggal Cetak EPO<script>DateInput('TGL_CETAK', true, 'YYYY-MM-DD')</script></div>
        <!--<input type=radio name="opsi" checked="checked" value="A4" ><font> <b>A4</b> </font>-->
        <input type=radio name="opsi" checked="checked" value="kartu" ><font> <b>Kartu</b> </font>
        <input type="submit" value="Cetak" target="_blank" onclick="location.href = ./report.php?go=epo&idt=<?php echo $idt; ?>&jns=<?php echo $jns; ?>">
        <?php if ($jns == 'manual') { ?>
          <input type=button value='Tambah' id='btn_tambah' onclick="location.href = '?module=epo&act=tambah_epo&idt=<?php echo $idt; ?>&negara=<?php echo $_GET[negara]; ?>&jns=<?php echo $jns; ?>'">
        <?php } ?>
      </form>
      <?php
    } else {
      ?>

      <div id=\"tgl\" type="hidden"> Tanggal Cetak EPO<script>DateInput('TGL_CETAK', true, 'YYYY-MM-DD')</script></div>
      <!--<input type=radio name='opsi' checked="checked" value="A4" ><font> <b>A4</b> </font>-->
      <input type=radio name='opsi' value="kartu" checked="checked"><font> <b>Kartu</b> </font>

      <input type=submit value='Cetak' onClick="return alert('Cetak EPO Gagal. EPO harus disetujui oleh KASUBDIT, KASIE dan OPERATOR')">
      <?php if ($jns == 'manual') { ?>
        <input type=button value='Tambah' id='btn_tambah' onclick="location.href = '?module=epo&act=tambah_epo&idt=<?php echo $idt; ?>&negara=<?php echo $_GET[negara]; ?>&jns=<?php echo $jns; ?>'">
      <?php
      }
    }

    echo "
		 <table width=100%>
		   <tr><th  width=30>no</th><th>No Pendaftaran</th><th>Status</th><th>Verifikator</th><th >NO EPO</th><th width=70>Tanggal Awal</th><th width=70>Tanggal Akhir</th><!--<th width=30>DIREKTUR</th>--><th width=30>KASUBDIT</th><th width=30>KASIE</th><th width=60>AKSI</th></tr>";

    $p = new Paging;
    $batas = 200;
    $posisi = $p->cariPosisi($batas);

    /* $sql=("
      select ID_CETAK,ID_DIPLOMAT,ID_JNS_CETAK_KARTU,ID_CARD,TGL_AWAL_CARD,TGL_AKHIR_CARD,COUNTER_CETAK, NM_JNS_CETAK_KARTU,NM_DIPLOMAT,
      ST_KARTU,ST_KARTU_K,ST_KARTU_KAS,STATUS_PENGEMBALIAN, ID_PERMIT, NO_DAFTAR, STATUS_WORKFLOW  from  v_id_card_w_permit where ID_DIPLOMAT = $idt and KD_WORKFLOW>=1 order by  ID_CETAK "); */
    if ($jns == 'manual') {
      $wee = 'ID_OTVIS';
    } else {
      $wee = 'ID_DIPLOMAT';
    }
    $sql = ("
	select ID_EPO,ID_DIPLOMAT,NO_EPO,TGL_AWAL_EPO,TGL_AKHIR_EPO,NM_DIPLOMAT,
	ST_EPO,ST_EPO_K,ST_EPO_KAS,NO_DAFTAR, STATUS_WORKFLOW, ID_OTVIS, USER_VERIFIKASI, TGL_VERIFIKASI  from  v_epo where $wee = $idt and KD_WORKFLOW>=1 order by  ID_EPO ");

    //print_r($sql);exit;
    $tampil = mysql_query($sql);
    $no = $posisi + 1;
    $jmldata = mysql_num_rows($tampil);
    if($jmldata > 0){
      echo"<script> $('#btn_tambah').remove(); </script>";
    }
    while ($r = mysql_fetch_array($tampil)) {

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
      if ($r[TGL_AWAL_EPO] != NULL) {
        echo "<td>" . date('d-m-Y', strtotime($r[TGL_AWAL_EPO])) . "</td>";
      } else {
        echo "<td>-</td>";
      }
      if ($r[TGL_AKHIR_EPO] != NULL) {
        echo "<td>" . date('d-m-Y', strtotime($r[TGL_AKHIR_EPO])) . "</td>";
      } else {
        echo "<td>-</td>";
      }
      echo "<!--<td align='center'><b>$stat_txt</b></td>
				<td align =center>$r[COUNTER_CETAK]</td>-->";

      /* echo "<td align =center>";

        if ($r[ST_EPO] == 2){

        echo "<div style=\"color : green\"> <b>A</b> </div>";
        }elseif ($r[ST_EPO] == 1){
        echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
        }elseif ($r[ST_EPO] == 0){

        echo "<div style=\"color : #800000\"> <b>R</b> </div>";
        } */

      echo "<!--</td>--><td align =center>";

      if ($r[ST_EPO_K] == 2) {

        echo "<div style=\"color : green\"> <b>Approved</b> </div>";
      } elseif ($r[ST_EPO_K] == 1) {
        echo "<div style=\"color : #B1BF19\"> <b>Waiting</b> </div>";
      } elseif ($r[ST_EPO_K] == 0) {

        echo "<div style=\"color : #800000\"> <b>Rejected</b> </div>";
      }

      echo "</td>";
      echo "</td><td align =center>";

      if ($r[ST_EPO_KAS] == 2) {

        echo "<div style=\"color : green\"> <b>Approved</b> </div>";
      } elseif ($r[ST_EPO_KAS] == 1) {
        echo "<div style=\"color : #B1BF19\"> <b>Waiting</b> </div>";
      } elseif ($r[ST_EPO_KAS] == 0) {

        echo "<div style=\"color : #800000\"> <b>Rejected</b> </div>";
      }

      echo "</td>";

      /* echo "<td align =center>";

        if ($r[ST_KARTU_KAS] == 2){
        echo "<div style=\"color : green\"> <b>A</b> </div>";
        }elseif ($r[ST_KARTU_KAS] == 1){
        echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
        }elseif ($r[ST_KARTU_KAS] == 0){
        echo "<div style=\"color : #800000\"> <b>R</b> </div>";
        }
        echo "</td> */
      echo"
				<td>";
      if ($jns == 'manual') {
        echo"<a href=?module=epo&act=edit_epo&idc=$r[ID_EPO]&idd=$idt&&idt=$idt&jns=manual>Edit</a> | ";
      }else{
        echo"<a href=?module=epo&act=edit_epo&idt=$r[ID_PERMIT]&idc=$r[ID_EPO]&idd=$idt&negara=$_GET[negara]&jns=>Edit</a>";
      }
      echo"<!--  | <a href=./aksi_id_card.php?module=epo&act=hapus&idt=$r[ID_PERMIT]&idc=$r[ID_EPO]&idd=$idt&negara=$_GET[negara] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus ID Card $r[ID_EPO]?')\">Hapus</a>--></td>
				</tr>";

      $no++;
    }
    echo "</table>";

    //}
    break;

  case "tambah_epo":

    $jns = $_GET[jns];
    $idt = $_GET[idt];


    if ($jns !== 'manual') {
      $sql = "select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt";


      $input = mysql_query($sql);

      $r = mysql_fetch_array($input);

      echo "<h2 >EPO - Tambah</h2>";
      echo "	  <table width=100%>
          <tr><td  width=160>Kewarganegaraan</td>  <td > : ";
      $tampil = mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
      $w = mysql_fetch_array($tampil);


      $detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idt)");
      $det = mysql_fetch_array($detil);

      echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto/$r[FOTO]\" width=110 height=150 border=1> </div>
	<br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br><br>";

      $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");
      $det = mysql_fetch_array($detil);

      echo "<b>Stay Permit </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No Izin Permit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";

      $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");
      $det = mysql_fetch_array($detil);

      echo "<b>Sibling </b><br>";
      $nosib = 1;
      $detil = mysql_query("select  NM_SIBLING,NM_JNS_RELASI from v_sibling where ID_DIPLOMAT = $idt order by ID_JNS_RELASI");
      while ($det = mysql_fetch_array($detil)) {
        echo "$nosib. $det[NM_SIBLING] - $det[NM_JNS_RELASI] <br>";
        $nosib = $nosib + 1;
      }

      echo "
	</td>
		<tr><td>Nama Diplomat</td>     <td> : $r[NM_DIPLOMAT]</td></tr>
		<tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : ";
      if ($r[JK] == 'l') {
        echo "Laki-laki";
      } else {
        echo "Perempuan";
      }
      echo "</td> </tr>
		<tr><td>Pekerjaan</td >  <td > : $r[PEKERJAAN]</td></tr>
		<tr><td>Status Sipil</td>     <td  > : ";

      if ($r[ST_SIPIL] == 's') {
        echo "Belum Menikah";
      } else {
        echo "Sudah Menikah";
      }
      echo "</td></tr>
		<tr><td>Alamat Indonesia </td>     <td > : <textarea name='ALAMATIN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATIN]</textarea></td></tr>

		<tr><td>Jenis / No. Paspor</td >     <td > :  ";
      $tampil = mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");

      $w = mysql_fetch_array($tampil);
      echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR]</td></tr>
		<tr><td>Diberikan oleh</td >     <td > : $r[PASPOR_OLEH]  -  $r[PASPOR_TGL] </td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[AKHIR_BERLAKU]</td></tr>

		<tr><td>Jenis / No. Visa</td >     <td > : ";
      $tampil = mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA = $r[ID_JNS_VISA]");
      $w = mysql_fetch_array($tampil);

      echo " $w[NM_JNS_VISA] / $r[NO_VISA] </td></tr>
		  </table> <br>";
    } elseif ($jns == 'manual') {
      //epo manual tambah

      $sql = "select a.id,a.no_konsep_pusat, d.NEGARA,a.nama, a.paspor,e.jns_paspor,a.tempat_tugas,a.tujuan,date_format(a.masa_awal_tugas,'%d.%m.%Y') as TGL_TIBA, date_format(a.masa_akhir_tugas,'%d.%m.%Y') as tgl_akhir_tugas, concat(b.tipe_visa,' ',c.KD_JNS_VISA) as jns_visa, f.perwakilan as diberikan_oleh, a.foto, a.foto_paspor, g.KODE_AGENDA, a.tipe_visa
FROM tbl_trans_otvis a LEFT JOIN tbl_tipe_visa b on a.tipe_visa = b.id LEFT JOIN m_jns_visa c on a.indeks_visa=c.ID_JNS_VISA LEFT JOIN m_negara d on a.kewarganegaraan = d.ID_NEGARA LEFT JOIN tbl_jns_paspor e on a.jns_paspor = e.id LEFT JOIN tbl_perwakilan f on a.pwk_ri=f.id_perwakilan LEFT JOIN m_kantor_perwakilan g on a.tempat_tugas = g.NM_KNT_PERWAKILAN where a.id = $idt";

      $input = mysql_query($sql);
      $r = mysql_fetch_array($input);
      $kode_agenda = $r[KODE_AGENDA];
      echo "<h2 >EPO Manual - Tambah</h2>";
      echo "	  <table width=100%>
          <tr><td  width=160>Kewarganegaraan</td>  <td > : ";
      echo "$r[NEGARA] </td><td rowspan=\"8\"  width=200 ><div align=center><img src=\"../files/otvis/foto/$r[foto]\" width=110 height=150 border=1><img src=\"../files/otvis/paspor/$r[foto_paspor]\" width=110 height=150 border=1></div>
	<br>";

      echo "
	</td>
		<tr><td>Nama Diplomat</td>     <td> : $r[nama]</td></tr>
		<tr><td>No. Paspor</td>     <td> : $r[paspor]</td></tr>
		<tr><td>Jenis Paspor</td>     <td> : $r[jns_paspor]</td></tr>
    </td> </tr>
		<tr><td>Tempat Tugas</td >  <td > : $r[tempat_tugas] / $r[KODE_AGENDA]</td></tr>
		<tr><td>Tujuan</td>     <td  > : $r[tujuan]</td></tr>
          </td></tr>
          <tr><td>Jenis - No. Visa</td >     <td > : $r[jns_visa] -- $r[no_konsep_pusat]</td></tr>
		<tr><td>Visa oleh</td >     <td > : $r[diberikan_oleh] </td></tr>


          </td></tr>
		  </table> <br>";

      echo "<form method=POST enctype='multipart/form-data' action='./aksi_id_card.php?module=epo&act=input&negara=$_GET[negara]'>
          <input type=hidden name=ID_OTVIS value='$r[id]'>
          <input type=hidden name=KD_AGENDA value='$r[KODE_AGENDA]'>
          <input type=hidden name=TIPE_VISA value='$r[tipe_visa]'>
		  <table width=100%>

        ";
      $tampil = mysql_query("SELECT * FROM m_syarat where jenis_izin='6' and FIND_IN_SET('$r[KODE_AGENDA]', kode_agenda)");
      echo "<tr><td>Persyaratan</td>     <td> ";
      $no = 1;
      while ($data = mysql_fetch_array($tampil)) {
        echo "$no. $data[syarat_nama]   <input type=hidden name='SYARAT_KD[]' value='$data[syarat_kd]'><input type=file id='file_name$data[syarat_kd]' name='syarat_file[]' required><br>";
        echo"<script>
        $('#file_name$data[syarat_kd]').bind('change', function() {
        var a = document.getElementById('file_name$data[syarat_kd]').value;
          var ext = a.split('.');
            ext = ext[ext.length-1].toLowerCase();
            var arrayExtensions = ['jpg' ,'jpeg', 'pdf'];

          if(this.files[0].size > 10000000){
          alert('ERROR: File terlalu besar, maksimal 10 mb');
          document.getElementById('file_name$data[syarat_kd]').value='';

          }

            if (arrayExtensions.lastIndexOf(ext) == -1) {
                alert('ERROR: Jenis file harus .pdf, .jpg, atau .jpeg');
                    document.getElementById('file_name$data[syarat_kd]').value='';
            }
        });
</script>";
         $no++;
      }
      echo "</td></tr>";

      echo"
        <tr><td>Tanggal Keberangkatan</td><td><DIV id=\"tgl\"> <script>DateInput('TGL_BERANGKAT', true, 'YYYY-MM-DD')</script></div></td></tr>
		<tr><td colspan=2 align=right><input type=submit value=Simpan>
              <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table></form>";


      //end epo manual tambah
    }

    break;


  case "edit_epo":
    $jns = $_GET[jns];
    $idt = $_GET[idt];
    $idc = $_GET[idc];
    $idd = $_GET[idd];

    if ($jns !== 'manual') {
      $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idd  ");

      $r = mysql_fetch_array($input);
      if (!empty($r[TGL_PENGEMBALIAN])) {
        $date_kembali = $r[TGL_PENGEMBALIAN];
      } else {
        $date_kembali = '1900-01-01';
      }
      echo "<h2 >EPO - Edit</h2>";
      echo "	  <table width=100%>
          <tr><td  width=160>Kewarganegaraan</td>  <td > : ";
      $tampil = mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
      $w = mysql_fetch_array($tampil);

      $tampil29 = mysql_query("select * from cetak_kartu_diplomat where ID_DIPLOMAT = $idd");
      $get_dataepo29 = mysql_num_rows($tampil29);

      if ($get_dataepo29 != 0) {
        $detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idd and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idd)");
      } else {
        $detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idd and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idd)");
      }

      //$detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idd and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idd)");
      $det = mysql_fetch_array($detil);

      echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto/$r[FOTO]\" width=110 height=150 border=1> </div>
	<br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br><br>";

      $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idd and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idd) ");
      $det = mysql_fetch_array($detil);

      echo "<b>Stay Permit </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No Izin Permit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";

      $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idd and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idd) ");
      $det = mysql_fetch_array($detil);

      echo "<b>Sibling </b><br>";
      $nosib = 1;
      $detil = mysql_query("select  NM_SIBLING,NM_JNS_RELASI from v_sibling where ID_DIPLOMAT = $idd order by ID_JNS_RELASI");
      while ($det = mysql_fetch_array($detil)) {
        echo "$nosib. $det[NM_SIBLING] - $det[NM_JNS_RELASI] <br>";
        $nosib = $nosib + 1;
      }

      echo "
	</td>
		<tr><td>Nama Diplomat</td>     <td> : $r[NM_DIPLOMAT]</td></tr>
		<tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : ";
      if ($r[JK] == 'l') {
        echo "Laki-laki";
      } else {
        echo "Perempuan";
      }
      echo "</td> </tr>
		<tr><td>Pekerjaan</td >  <td > : $r[PEKERJAAN]</td></tr>
		<tr><td>Status Sipil</td>     <td  > : ";

      if ($r[ST_SIPIL] == 's') {
        echo "Sudah Menikah";
      } else {
        echo "Belum Menikah";
      }
      echo "</td></tr>
		<tr><td>Alamat Indonesia </td>     <td > : <textarea name='ALAMATIN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATIN]</textarea></td></tr>

		<tr><td>Jenis / No. Paspor</td >     <td > :  ";
      $tampil = mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");

      $w = mysql_fetch_array($tampil);
      echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR]</td></tr>
		<tr><td>Diberikan oleh</td >     <td > : $r[PASPOR_OLEH]  -  $r[PASPOR_TGL] </td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[AKHIR_BERLAKU]</td></tr>

		<tr><td>Jenis / No. Visa</td >     <td > : ";
      $tampil = mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA = $r[ID_JNS_VISA]");
      $w = mysql_fetch_array($tampil);

      echo " $w[NM_JNS_VISA] / $r[NO_VISA] </td></tr>
		  </table> <br>";
    }elseif($jns == 'manual'){
      $sql = "select a.id,a.no_konsep_pusat, d.NEGARA,a.nama, a.paspor,e.jns_paspor,a.tempat_tugas,a.tujuan,date_format(a.masa_awal_tugas,'%d.%m.%Y') as TGL_TIBA, date_format(a.masa_akhir_tugas,'%d.%m.%Y') as tgl_akhir_tugas, concat(b.tipe_visa,' ',c.KD_JNS_VISA) as jns_visa, f.perwakilan as diberikan_oleh, a.foto, a.foto_paspor, g.KODE_AGENDA
FROM tbl_trans_otvis a LEFT JOIN tbl_tipe_visa b on a.tipe_visa = b.id LEFT JOIN m_jns_visa c on a.indeks_visa=c.ID_JNS_VISA LEFT JOIN m_negara d on a.kewarganegaraan = d.ID_NEGARA LEFT JOIN tbl_jns_paspor e on a.jns_paspor = e.id LEFT JOIN tbl_perwakilan f on a.pwk_ri=f.id_perwakilan LEFT JOIN m_kantor_perwakilan g on a.tempat_tugas = g.NM_KNT_PERWAKILAN where a.id = $idd";

      $input = mysql_query($sql);
      $r = mysql_fetch_array($input);

      echo "<h2 >EPO Manual - Lihat</h2>";
      echo "	  <table width=100%>
          <tr><td  width=160>Kewarganegaraan</td>  <td > : ";
      echo "$r[NEGARA] </td><td rowspan=\"8\"  width=200 ><div align=center><img src=\"../files/otvis/foto/$r[foto]\" width=110 height=150 border=1><img src=\"../files/otvis/paspor/$r[foto_paspor]\" width=110 height=150 border=1></div>
	<br>";

      echo "
	</td>
		<tr><td>Nama Diplomat</td>     <td> : $r[nama]</td></tr>
		<tr><td>No. Paspor</td>     <td> : $r[paspor]</td></tr>
		<tr><td>Jenis Paspor</td>     <td> : $r[jns_paspor]</td></tr>
    </td> </tr>
		<tr><td>Tempat Tugas</td >  <td > : $r[tempat_tugas] / $r[KODE_AGENDA]</td></tr>
		<tr><td>Tujuan</td>     <td  > : $r[tujuan]</td></tr>
          </td></tr>
          <tr><td>Jenis - No. Visa</td >     <td > : $r[jns_visa] -- $r[no_konsep_pusat]</td></tr>
		<tr><td>Visa oleh</td >     <td > : $r[diberikan_oleh] </td></tr>


          </td></tr>
		  </table> <br>";
    }

    /* $sql = ("select  ID_CETAK,ID_DIPLOMAT,ID_JNS_CETAK_KARTU,ID_CARD,TGL_AWAL_CARD,TGL_AMBIL_BERKAS,TGL_AKHIR_CARD,COUNTER_CETAK,STATUS_PENGEMBALIAN,
      KETERANGAN, NO_DAFTAR from v_id_card_w_permit where ID_CETAK = $idc "); */

    $sql = ("select ID_EPO,ID_DIPLOMAT,NO_EPO,TGL_AWAL_EPO,TGL_AKHIR_EPO,TGL_AMBIL_EPO,KET, NO_DAFTAR, NO_SERI_STIKER, TGL_KEBERANGKATAN from v_epo where ID_EPO = $idc ");

    //echo "$sql";exit;
    $edit = mysql_query($sql);


    $r = mysql_fetch_array($edit);
    //print_r($r);
    echo "<form method=POST enctype='multipart/form-data' action='./aksi_epo.php?module=epo&act=update&idt=$idt&idc=$idc&negara=$_GET[negara]&jns=$jns'>
          <input type=hidden name=ID_DIPLOMAT value='$r[ID_DIPLOMAT]'>
			<input type=hidden name=ID_EPO value='$r[ID_EPO]'>

		  <table width=100%>
		   <tr><td  width=120>No Pendaftaran</td>  <td > : $r[NO_DAFTAR]</td></tr>
		  ";
    echo "<tr><td>Persyaratan</td>     <td> ";
    $tampil = mysql_query("SELECT * FROM syarat_epo a right join m_syarat b on  a.syarat_kd=b.syarat_kd where b.jenis_izin='6' and a.ID_EPO='" . $_GET['idc'] . "'");

    while ($data = mysql_fetch_array($tampil)) {
      if ($data['file'] != "") {
        //echo "<input type=checkbox disabled checked=checked name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <a target='_blank' href='/foto/syarat/$data[file]'>Lihat Berkas</a><br>";
      } else {
        //echo "<input type=checkbox disabled name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <br>";
      }
    }
    $tampil = mysql_query("SELECT * FROM syarat_epo a right join m_syarat b on  a.syarat_kd=b.syarat_kd where b.jenis_izin='6' and a.ID_EPO='" . $_GET['idc'] . "'");

    while ($data = mysql_fetch_array($tampil)) {
      if ($data['file'] != "") {
        echo "<input type=checkbox disabled checked=checked name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <a target='_blank' href='/upload/epo/$data[file]'>Lihat Berkas</a><br>";
      } else {
        echo "<input type=checkbox disabled name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <br>";
      }
    }


    /* } */
    echo "</td></tr> <tr><td  width=120>Tanggal Berangkat</td>  <td > : ";  echo date('d M Y',strtotime($r[TGL_KEBERANGKATAN])); echo "</td></tr>	";

   if (empty($r[NO_EPO])) {

      $jns = $_GET[jns];
      if($jns == 'manual'){
        $query = mysql_query("select a.THN_AGENDA as THN,a.KODE_AGENDA as KODE_AGENDA,c.KD_JNS_PASPOR as KD_PASPOR, b.jns_paspor as ID_JNS_PASPOR, a.TIPE_VISA from epo_diplomat a, tbl_trans_otvis b, tbl_jns_paspor c where a.ID_OTVIS=b.id and b.jns_paspor=c.id and a.ID_EPO='" . $_GET['idc'] . "'");
      }else{
        $query = mysql_query("select a.THN_AGENDA as THN,a.KODE_AGENDA as KODE_AGENDA,c.KD_JNS_PASPOR as KD_PASPOR, b.ID_JNS_PASPOR as ID_JNS_PASPOR, a.TIPE_VISA from epo_diplomat a, diplomat b, m_jns_paspor c where a.id_diplomat=b.id_diplomat and b.ID_JNS_PASPOR=c.ID_JNS_PASPOR and a.ID_EPO='" . $_GET['idc'] . "'");
      }

      $data = mysql_fetch_array($query);
      $kd_agenda = $data['KODE_AGENDA'];
      $kd_paspor = $data['KD_PASPOR'];
      $tipe_visa = $data['TIPE_VISA'];


      //print_r($nomor);exit;
      //echo "$kode";exit;
	  $pilih_visa='';
      echo "<tr><td>No EPO</td>     <td> : <input type=text name='NO_EPO' id='NO_EPO' size=50  readonly >";
    } else {
	  $pilih_visa='hidden';
      echo "<tr><td>No EPO</td>     <td> : <input type=text name='NO_EPO' size=50  value='$r[NO_EPO]' readonly>";
    }
	if ($tipe_visa=='D'){ $d_selected='selected';}else{$s_selected='selected';}
	echo "&nbsp;&nbsp;
	<div style='float:right;width=50px' $pilih_visa>Jenis Visa &nbsp;:&nbsp; <select name='tipe_visa' id='tipe_visa' ><option value='D' $d_selected>D</option><option value='S' $s_selected>S</option></select></div></td></tr>";


    echo "	  <tr><td>No Seri Stiker</td>     <td> : <input type=text name='NO_SERI_STIKER' size=50  value='$r[NO_SERI_STIKER]'></td></tr>
		  <tr><!--<td>Tanggal Awal EPO</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AWAL_EPO', true, 'YYYY-MM-DD'
	";
    if ($r[TGL_AWAL_EPO]) {
      echo ",'$r[TGL_AWAL_EPO]'";
    }
    echo ")</script></div></td></tr>-->

		<tr><td>Tanggal Akhir EPO</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR_EPO', true, 'YYYY-MM-DD'";
    if ($r[TGL_AKHIR_EPO]) {
      echo ",'$r[TGL_AKHIR_EPO]'";
    }
    echo ")</script></div></td></tr>";
    //echo "<tr><td>Tanggal Ambil epo</td> <td> <DIV id=\"tgl\">"; if (empty($r[TGL_AMBIL_EPO])) {echo "<script>DateInput('TGL_AMBIL_EPO', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script>";} else { echo "<script>DateInput('TGL_AMBIL_EPO', true, 'YYYY-MM-DD','$r[TGL_AMBIL_EPO]')</script>"; } echo"</div> <strong><div style='font-size:15px;color:red;'>&nbsp;Perhatikan saat pengisian Tanggal Ambil Berkas ('Jangan Sampai Salah')</div></strong></td></tr>";

    echo "
		<tr><td>Tanggal Ambil EPO</td> <td> <DIV id=\"tgl\">";
    if (empty($r[TGL_AMBIL_EPO])) {
      echo "<script>DateInput('TGL_AMBIL_EPO', true, 'YYYY-MM-DD')</script>";
    } else {
      echo "<script>DateInput('TGL_AMBIL_EPO', true, 'YYYY-MM-DD','$r[TGL_AMBIL_EPO]')</script>";
    } echo"</div> <strong><div style='font-size:15px;color:red;'>&nbsp;Perhatian: Isi Tanggal Pengambilan EPO dengan Benar!</div></strong></td></tr>

		<!--<tr><td>Counter Cetak</td>     <td> : <input type=text name='COUNTER_CETAK' size=100  value= '$r[COUNTER_CETAK]' ></td></tr>-->
		";
    $get_kdwf = mysql_query("select * from epo_diplomat where ID_EPO = $idc");
    $r6 = mysql_fetch_array($get_kdwf);
    if ($r6['KD_WORKFLOW'] >= 3) {
      $lolosver = 'CHECKED';
    } else if ($r6['KD_WORKFLOW'] == 1) {
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


    $p = new Paging;
    $batas = 200;
    $posisi = $p->cariPosisi($batas);

    if (isset($_GET[huruf])) {
      $tampil = mysql_query("select ID_NEGARA,NEGARA,BENDERA,JML_RANTOR_K,JML_RANTOR_I,NEG_RANTOR_K,NEG_RANTOR_I from v_resiprositas where (ID_NEGARA > 1) and NEGARA like '$alf%' order by NEGARA limit $posisi,$batas");
    } else {
      $tampil = mysql_query("select ID_NEGARA,NEGARA,BENDERA,JML_RANTOR_K,JML_RANTOR_I,NEG_RANTOR_K,NEG_RANTOR_I from v_resiprositas where ID_NEGARA > 1 order by NEGARA limit $posisi,$batas");
    }
    $no = $posisi + 1;
    while ($r = mysql_fetch_array($tampil)) {


      echo "<tr><td>$no</td>
				<td><img src=\"../images/bendera/" . $r[BENDERA] . "\" class=\"thumbborder\" width=\"22\" height=\"15\" />
				&nbsp <a href=?module=epo=$r[NEGARA]>$r[NEGARA] </a></td><td>";

      $tampilFas = mysql_query("select ID_JNS_FASILITAS from negara_jns_fas where ID_NEGARA = " . $r[ID_NEGARA] . " and ST_FASILITAS_O = 1 order by ID_JNS_FASILITAS");
      while ($rFas = mysql_fetch_array($tampilFas)) {
        echo "$rFas[ID_JNS_FASILITAS], ";
      }

      echo "</td><td align=right> $r[JML_RANTOR_K] </td><td align=right> $r[JML_RANTOR_I]</td> <td>";

      $tampilFas = mysql_query("select ID_JNS_FASILITAS from negara_jns_fas where ID_NEGARA = " . $r[ID_NEGARA] . " and ST_FASILITAS_K = 1 order by ID_JNS_FASILITAS");
      while ($rFas = mysql_fetch_array($tampilFas)) {
        echo "$rFas[ID_JNS_FASILITAS], ";
      }

      echo "</td>
					<td align=right> $r[NEG_RANTOR_K] </td><td align=right> $r[NEG_RANTOR_I]</td>
		            </tr>";
      $no++;
    }
    echo "</table>";
    echo "Keterangan <br>";
    $tampilFas = mysql_query("select ID_JNS_FASILITAS,JNS_FASILITAS from m_jns_fasilitas order by ID_JNS_FASILITAS");
    while ($rFas = mysql_fetch_array($tampilFas)) {
      echo "$rFas[ID_JNS_FASILITAS] = $rFas[JNS_FASILITAS] <br>";
    }
    break;
}
?>

<script>
$(document).ready(function(){
	var visa = $('#tipe_visa').val();
	var idc = <?php if($_GET['idc'] == ''){echo 'null';}else{echo $_GET['idc'];} ?>;
	var jns = <?=json_encode($_GET['jns'])?>;
	$.ajax({
            url     : "./aksi_epo.php?module=epo&act=check_no&visa="+visa+"&idc="+idc+"&jns="+jns,
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
            url     : "./aksi_epo.php?module=epo&act=check_no&visa="+visa+"&idc="+idc+"&jns="+jns,
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
