<?php

//echo "<br><a href=?module=epoK&act=cari&huruf=A>A</A> |	<a href=?module=epoK&act=cari&huruf=B>B</A> |	<a href=?module=epoK&act=cari&huruf=C>C</A> |	<a href=?module=epoK&act=cari&huruf=D>D</A> |	<a href=?module=epoK&act=cari&huruf=E>E</A> |	<a href=?module=epoK&act=cari&huruf=F>F</A> |	<a href=?module=epoK&act=cari&huruf=G>G</A> |	<a href=?module=epoK&act=cari&huruf=H>H</A> |	<a href=?module=epoK&act=cari&huruf=I>I</A> |	<a href=?module=epoK&act=cari&huruf=J>J</A> |	<a href=?module=epoK&act=cari&huruf=K>K</A> |	<a href=?module=epoK&act=cari&huruf=L>L</A> |	<a href=?module=epoK&act=cari&huruf=M>M</A> |	<a href=?module=epoK&act=cari&huruf=N>N</A> |	<a href=?module=epoK&act=cari&huruf=O>O</A> |	<a href=?module=epoK&act=cari&huruf=P>P</A> |	<a href=?module=epoK&act=cari&huruf=Q>Q</A> |	<a href=?module=epoK&act=cari&huruf=R>R</A> |	<a href=?module=epoK&act=cari&huruf=S>S</A> |	<a href=?module=epoK&act=cari&huruf=T>T</A> |	<a href=?module=epoK&act=cari&huruf=U>U</A> |	<a href=?module=epoK&act=cari&huruf=V>V</A> |	<a href=?module=epoK&act=cari&huruf=W>W</A> |	<a href=?module=epoK&act=cari&huruf=X>X</A> |	<a href=?module=epoK&act=cari&huruf=Y>Y</A> |	<a href=?module=epoK&act=cari&huruf=Z>Z</A>";


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

    echo "<h2>Approval EPO Kasubdit</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='epoK'>
				 <input type=hidden name=negara value='$_GET[negara]'>
				 Nama Diplomat : <input type=text name=\"namadiplomat\"> <input type=submit value=Cari>
			</form> <br>

<a href=?module=epoK>ALL</a> | <a href=?module=epoK&status=1 style=\"color : #B1BF19\">WAITING</a> | <a href=?module=epoK&status=2 style=\"color : green\">APPROVED</a> | 
	<a href=?module=epoK&status=0 style=\"color : #800000\">REJECTED</a> <BR>

		<form method=POST enctype='multipart/form-data' action='./aksi_epoK.php?module=epoK&act=update'>
          <table width=100%>
         
		<tr><th width=30>no</th><th width=150 >NAMA</th><th  width=60>RANK</th><th width=150>KANTOR PERWAKILAN</th><th  width=80>NO EPO</th><th  width=70>TGL BERLAKU</th><th width=90>AKSI</th></tr>	
		";

    $p = new Paging;
    $batas = 5;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET[negara];

    if (isset($_GET[status])) {

      if (isset($_GET[namadiplomat])) {

        /*$tampil = mysql_query("select a.ID_EPO, a.NO_EPO,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.NM_RANK,c.PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K  from v_epo a left join v_diplomat c on a.id_diplomat=c.id_diplomat where  (c.negara like '" . $neg . "%' and c.NM_DIPLOMAT like '%" . $_GET[namadiplomat] . "%') and  a.ST_EPO_K =  " . $_GET[status] . " ORDER BY a.ID_EPO desc limit $posisi,$batas ");*/
        $tampil = mysql_query("(select a.ID_EPO, a.NO_EPO,c.ID_DIPLOMAT,a.ID_OTVIS,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.NM_RANK,c.PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO, date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K 
from v_epo a join v_diplomat c on a.id_diplomat=c.id_diplomat where c.NM_DIPLOMAT like '%" . $_GET[namadiplomat] . "%' and  a.ST_EPO_K =  " . $_GET[status] . ")
UNION ALL
(select a.ID_EPO, a.NO_EPO,a.ID_DIPLOMAT,a.ID_OTVIS,c.nama as NM_DIPLOMAT,c.tempat_tugas as NM_KNT_PERWAKILAN,'-' as NM_RANK,c.tujuan as PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO, date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K 
from v_epo a join tbl_trans_otvis c on a.ID_OTVIS=c.id where c.nama like '%" . $_GET[namadiplomat] . "%' and  a.ST_EPO_K =  " . $_GET[status] . ") ORDER BY ID_EPO desc limit $posisi,$batas");
        
      } else {

        /*$tampil = mysql_query("select a.ID_EPO, a.NO_EPO,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.NM_RANK,c.PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K from v_epo a left join v_diplomat c on a.id_diplomat=c.id_diplomat where  (c.negara like '" . $neg . "%' ) and  a.ST_EPO_K =  " . $_GET[status] . " ORDER BY a.ID_EPO desc limit $posisi,$batas ");*/
        $tampil = mysql_query("(select a.ID_EPO, a.NO_EPO,c.ID_DIPLOMAT,a.ID_OTVIS,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.NM_RANK,c.PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO, date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K 
from v_epo a join v_diplomat c on a.id_diplomat=c.id_diplomat where a.ST_EPO_K =  " . $_GET[status] . ")
UNION ALL
(select a.ID_EPO, a.NO_EPO,a.ID_DIPLOMAT,a.ID_OTVIS,c.nama as NM_DIPLOMAT,c.tempat_tugas as NM_KNT_PERWAKILAN,'-' as NM_RANK,c.tujuan as PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO, date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K 
from v_epo a join tbl_trans_otvis c on a.ID_OTVIS=c.id where a.ST_EPO_K =  " . $_GET[status] . ") ORDER BY ID_EPO desc limit $posisi,$batas");
        
      }
    } ELSE {
      if (isset($_GET[namadiplomat])) {

        /* $tampil = mysql_query("select a.ID_EPO, a.NO_EPO,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.NM_RANK,c.PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K  from v_epo a left join v_diplomat c on a.id_diplomat=c.id_diplomat where (c.negara like '" . $neg . "%' and c.NM_DIPLOMAT like '%" . $_GET[namadiplomat] . "%')  ORDER BY a.ID_EPO desc limit $posisi,$batas "); */
        $tampil = mysql_query("(select a.ID_EPO, a.NO_EPO,c.ID_DIPLOMAT,a.ID_OTVIS,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.NM_RANK,c.PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO, date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K 
from v_epo a join v_diplomat c on a.id_diplomat=c.id_diplomat where c.NM_DIPLOMAT like '%" . $_GET[namadiplomat] . "%')
UNION ALL
(select a.ID_EPO, a.NO_EPO,a.ID_DIPLOMAT,a.ID_OTVIS,c.nama as NM_DIPLOMAT,c.tempat_tugas as NM_KNT_PERWAKILAN,'-' as NM_RANK,c.tujuan as PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO, date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K 
from v_epo a join tbl_trans_otvis c on a.ID_OTVIS=c.id where c.nama like '%" . $_GET[namadiplomat] . "%') ORDER BY ID_EPO desc limit $posisi,$batas");
      } else {
        /* $tampil=mysql_query("select a.ID_EPO, a.NO_EPO,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.NM_RANK,c.PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO,  date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K from v_epo a left join v_diplomat c on a.id_diplomat=c.id_diplomat where  (c.negara like '".$neg."%' )  ORDER BY a.ID_EPO desc limit $posisi,$batas ");	 */

        $tampil = mysql_query("(select a.ID_EPO, a.NO_EPO,c.ID_DIPLOMAT,a.ID_OTVIS,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.NM_RANK,c.PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO, date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K 
from v_epo a join v_diplomat c on a.id_diplomat=c.id_diplomat)
UNION ALL
(select a.ID_EPO, a.NO_EPO,a.ID_DIPLOMAT,a.ID_OTVIS,c.nama as NM_DIPLOMAT,c.tempat_tugas as NM_KNT_PERWAKILAN,'-' as NM_RANK,c.tujuan as PEKERJAAN, date_format(a.TGL_AWAL_EPO,'%d.%m.%Y') as TGL_AWAL_EPO, date_format(a.TGL_AKHIR_EPO,'%d.%m.%Y') as TGL_AKHIR_EPO, a.ST_EPO,a.ST_EPO_K 
from v_epo a join tbl_trans_otvis c on a.ID_OTVIS=c.id) ORDER BY ID_EPO desc limit $posisi,$batas");
      }
    }



    $no = $posisi + 1;
    $noP = 1;
    while ($r = mysql_fetch_array($tampil)) {

      echo "<tr><td>$no</td>
                <td>";
                if($r[ID_OTVIS] != NULL){
                  echo"<a href=?module=epo&act=lihat_epo&idt=$r[ID_OTVIS]&negara=$_GET[negara]&jns=manual>$r[NM_DIPLOMAT]</a></td>";
                }ELSE{
                  echo"<a href=?module=epo&act=lihat_epo&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NM_DIPLOMAT]</a></td>";
                }
				echo"<td>$r[NM_RANK]</td>
				<td >$r[NM_KNT_PERWAKILAN]</td>
                <td>$r[NO_EPO]</td>
                <td>$r[TGL_AKHIR_EPO] - $r[TGL_AWAL_EPO]</td>
				<td>
				<div style=\"color : #B1BF19\"><input type=radio onClick='checkBox(this.value,$noP)' name='ST_EPO_K$noP' value=1 ";
      if ($r[ST_EPO_K] == 1) {
        echo "checked";
      }
      echo "> <b>waiting</b> </div><div style=\"color : green\"><input onClick='checkBox(this.value,$noP)' type=radio name='ST_EPO_K$noP' value=2 ";
      if ($r[ST_EPO_K] == 2) {
        echo "checked";
      }
      echo "> <b>approve</b> </div> <div style=\"color : #800000\"> <input onClick='checkBox(this.value,$noP)' type=radio name='ST_EPO_K$noP' value=0 ";
      if ($r[ST_EPO_K] == 0) {
        echo "checked";
      }
      echo "> <b>reject</b> </div>";
      echo "<div id='popup_box$noP' class='popup_box'>
						<h2>Konfirmasi Status Persetujuan Pengajuan EPO</h2>
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
								<td>NO EPO</td><td>:</td><td>$r[NO_EPO]</td>
							</tr>
							<tr>
								<td>Tanggal Berlaku</td><td>:</td><td>$r[TGL_AKHIR_EPO] - $r[TGL_AWAL_EPO]</td>
							</tr>
							";

      $tampil1 = mysql_query("SELECT * FROM syarat_epo a inner join m_syarat b on  a.syarat_kd=b.syarat_kd where b.jenis_izin='6' and a.ID_EPO='" . $r['ID_EPO'] . "'");
      echo "<tr><td>Persyaratan</td>    <td>:</td> <td> ";
      while ($data = mysql_fetch_array($tampil1)) {
        echo "<input type=checkbox disabled checked=checked name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <br>";
      }
      $tampil2 = mysql_query("select * from m_syarat where jenis_izin='6' and syarat_kd not in ( SELECT b.syarat_kd FROM syarat_epo a inner join m_syarat b on  a.syarat_kd=b.syarat_kd where b.jenis_izin='6' and a.ID_EPO='" . $r['ID_EPO'] . "')");

      while ($data2 = mysql_fetch_array($tampil2)) {
        echo "<input type=checkbox disabled name='syarat[]' value='$data2[syarat_kd]'> $data2[syarat_nama] <br>";
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
						<td><input type='button' name='updateStatus' onClick=updateEpo($r[ID_EPO],$noP,'K',4); value='Submit'></td>
					  </tr>";
      /* 				if (mysql_num_rows($tampil2)==0){ 
        echo "<tr>
        <td></td>
        <td></td>
        <td><input type='button' name='updateStatus' onClick=updateAction($r[ID_EPO],$noP,'K',3); value='Submit'></td>
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
				<input type='hidden' name='txt_box$noP' id='txt_box$noP' value='$r[ST_EPO_KAS]' > ";

      echo "		</td>
				<input type=hidden name='ID_EPO$noP' value='$r[ID_EPO]'>     	  
		        </tr>";

      echo "</td>
				<input type=hidden name='ID_EPO$noP' value='$r[ID_EPO]'>     	  
		        </tr>";
      echo "			
				</td>
				<input type=hidden name='ID_EPO$noP' value='$r[ID_EPO]'>     	  
		        </tr>";
      $no++;
      $noP++;
    }
    echo "	<input type=hidden name='jumlahData' value= $noP>     	  
		     </table><div align=right> </div>
	</form>	";
    //<input type=submit value=Update>


    if (isset($_GET[status])) {
      if (isset($_GET[namadiplomat])) {

        //$jmldata = mysql_num_rows(mysql_query("select a.ID_EPO from v_epo a left join v_diplomat c on a.id_diplomat=c.id_diplomat where  (c.negara like '" . $neg . "%' and c.NM_DIPLOMAT like '%" . $_GET[namadiplomat] . "%') and  a.ST_EPO_K =  " . $_GET[status]));
        
         $jmldata = mysql_num_rows(mysql_query("select a.ID_EPO from v_epo a join v_diplomat c on a.id_diplomat=c.id_diplomat where  c.NM_DIPLOMAT like '%" . $_GET[namadiplomat] . "%' and a.ST_EPO_K =  " . $_GET[status] ." union select a.ID_EPO from v_epo a join tbl_trans_otvis c on a.ID_OTVIS=c.id where c.nama like '%" . $_GET[namadiplomat] . "%' and a.ST_EPO_K =  " . $_GET[status]));
      
      } else {

        //$jmldata = mysql_num_rows(mysql_query("select a.ID_EPO from v_epo a left join v_diplomat c on a.id_diplomat=c.id_diplomat where  (c.negara like '" . $neg . "%') and  a.ST_EPO_K =  " . $_GET[status]));
         $jmldata = mysql_num_rows(mysql_query("select a.ID_EPO from v_epo a join v_diplomat c on a.id_diplomat=c.id_diplomat where a.ST_EPO_K =  " . $_GET[status] ." union select a.ID_EPO from v_epo a join tbl_trans_otvis c on a.ID_OTVIS=c.id where a.ST_EPO_K =  " . $_GET[status]));
      }
    } else {
      if (isset($_GET[namadiplomat])) {

        $jmldata = mysql_num_rows(mysql_query("select a.ID_EPO from v_epo a join v_diplomat c on a.id_diplomat=c.id_diplomat where  c.NM_DIPLOMAT like '%" . $_GET[namadiplomat] . "%' union select a.ID_EPO from v_epo a join tbl_trans_otvis c on a.ID_OTVIS=c.id where c.nama like '%" . $_GET[namadiplomat] . "%'"));
      } else {

        $jmldata = mysql_num_rows(mysql_query("select a.ID_EPO from v_epo a join v_diplomat c on a.id_diplomat=c.id_diplomat UNION select a.ID_EPO from v_epo a join tbl_trans_otvis c on a.ID_OTVIS=c.id "));
      }
    }

    $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);

    if (isset($_GET[status])) {
      $ilink = "?module=epoK&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]&status=$_GET[status]";
    } else {
      $ilink = "?module=epoK&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]";
    }

    $linkHalaman = $p->navHalaman($ilink, $_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;




  case "cari":
    $alf = $_GET[huruf];

    echo "<br><br><a style=\"font-size: 22pt;\">$alf</a>";
    echo "<h2>Rantor Individu - Pilih Negara</h2> 
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
				&nbsp <a href=?module=epoK&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";

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
