<?php
switch($_GET[act]){
  // Tampil Berita
  default:

		echo "<h2 align='center'>DIPLOMATIC LIST IN INDONESIA</h2>
			 <br>

          <table width=100% id=cariStayPermit name=cariStayPermit class=display>
          <thead>
          <tr><th width=10 >No</th>
		  <th  width=400 >States</th>
		  <th width=100>ACTION</th></tr></thead><tbody>	";

    // $p      = new Paging;
    // $batas  = 30;
    // $posisi = $p->cariPosisi($batas);
    //
	  // $sql= "SELECT DISTINCT `m_negara`.`ID_NEGARA`, `m_negara`.`NEGARA`, `m_kantor_perwakilan`.* FROM (`m_kantor_perwakilan`)
		// 		LEFT JOIN `m_negara` ON `m_kantor_perwakilan`.`ID_NEGARA` = `m_negara`.`ID_NEGARA` WHERE `m_kantor_perwakilan`.`ID_JNS_PERWAKILAN` = '2'
		// 		ORDER BY `NM_KNT_PERWAKILAN` asc limit $posisi, $batas";

  $sql= "SELECT DISTINCT `m_negara`.`ID_NEGARA`, `m_negara`.`NEGARA`, `m_kantor_perwakilan`.* FROM (`m_kantor_perwakilan`)
            LEFT JOIN `m_negara` ON `m_kantor_perwakilan`.`ID_NEGARA` = `m_negara`.`ID_NEGARA` WHERE `m_kantor_perwakilan`.`ID_JNS_PERWAKILAN` = '2' AND `m_negara`.`ID_NEGARA` IS NOT NULL AND `m_kantor_perwakilan`.`ID_NEGARA` !=('79' OR '1') AND `m_kantor_perwakilan`.`KODE_AGENDA`!='OI'  AND `m_kantor_perwakilan`.`NM_KNT_PERWAKILAN` NOT LIKE '%economic%'
            GROUP BY `m_negara`.`ID_NEGARA`
              ORDER BY `m_negara`.`NEGARA`";

	$tampil=mysql_query($sql);

  $no = $posisi+1;
    while($rr=mysql_fetch_array($tampil)){
      echo "<tr><td>$no</td>
				  <td><a href=?module=diplist&act=viewdiplist&idt=$rr[ID_KNT_PERWAKILAN]>$rr[NEGARA]</a></td>
				  <!--<td><a href=?module=diplist&act=viewdiplist&idt=$rr[ID_KNT_PERWAKILAN]>Edit</a></td>-->
		      <td align=center><a href=?module=kantor&act=editkantor&idt=$rr[ID_KNT_PERWAKILAN]>Edit</a> </td>
		    </tr>";
      $no++;
    }
      echo "</tbody></table>";
  // 	$jmldata =mysql_num_rows(mysql_query("SELECT DISTINCT `m_negara`.`ID_NEGARA`, `m_negara`.`NEGARA`, `m_kantor_perwakilan`.* FROM (`m_kantor_perwakilan`)
	// 		LEFT JOIN `m_negara` ON `m_kantor_perwakilan`.`ID_NEGARA` = `m_negara`.`ID_NEGARA` WHERE `m_kantor_perwakilan`.`ID_JNS_PERWAKILAN` = '2'
	// 		 ORDER BY `ID_ORDER`"));
  //
	// $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
  //
  //  $ilink = "?module=perutusan";
  //   $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
  //
  //   echo "<div id=paging>$linkHalaman</div><br>";
    break;


    case "viewdiplist":
    $idt = $_GET[idt];
    //$y = date('Y');

//Query untuk menampilkan daftar diplomat aktif
	// $sql = "SELECT `diplomat`.*, (select MAX(TGL_AKHIR_PERMIT) from permit_diplomat where permit_diplomat.`ID_DIPLOMAT` = diplomat.`ID_DIPLOMAT` and kd_workflow>=3 limit 1) as TGL_AKHIR_IZIN,
	// 	(select distinct NM_SIBLING from sibling where sibling.ID_DIPLOMAT=diplomat.ID_DIPLOMAT and ID_JNS_RELASI='3') as NM_SPOUSE,
	// 	(select distinct JK from sibling where sibling.ID_DIPLOMAT=diplomat.ID_DIPLOMAT and ID_JNS_RELASI='3') as JK_SPOUSE, `rank`.`OFFICIAL_NM`
	// 	FROM (`diplomat`) JOIN `rank` ON `diplomat`.`ID_RANK`=`rank`.`ID_RANK`
	// 	WHERE `diplomat`.`ID_KNT_PERWAKILAN` = '$idt' AND `MENGGANTIKAN_SIAPA` IS NOT NULL ORDER BY `RANK` asc";
    $sql = "SELECT `diplomat`.*, `permit_diplomat`.`TGL_AKHIR_PERMIT`,(select MAX(TGL_AKHIR_PERMIT) from `permit_diplomat` where `permit_diplomat`.`ID_DIPLOMAT` = `diplomat`.`ID_DIPLOMAT` and kd_workflow>=3 limit 1) as TGL_AKHIR_CARD,
      (select distinct NM_SIBLING from sibling where sibling.ID_DIPLOMAT=diplomat.ID_DIPLOMAT and ID_JNS_RELASI='3') as NM_SPOUSE,
      (select distinct JK from sibling where sibling.ID_DIPLOMAT=diplomat.ID_DIPLOMAT and ID_JNS_RELASI='3') as JK_SPOUSE, `rank`.`OFFICIAL_NM`
      FROM (`diplomat`)
      JOIN `rank` ON `diplomat`.`ID_RANK`=`rank`.`ID_RANK`
      JOIN `permit_diplomat` ON `permit_diplomat`.`ID_DIPLOMAT`=`diplomat`.`ID_DIPLOMAT`
      WHERE `diplomat`.`ID_KNT_PERWAKILAN` = '$idt' AND `MENGGANTIKAN_SIAPA` IS NOT NULL
      AND `permit_diplomat`.`TGL_AKHIR_PERMIT`>=CURDATE()
      ORDER BY `RANK` asc";

    $edit = mysql_query($sql);

    $dubes= "SELECT COUNT(ID_RANK) FROM ($sql) AS X WHERE ID_RANK='1'";
    $odubes = mysql_query($dubes);
    $adubes = mysql_fetch_array($odubes);

//Query untuk data perwkilan
    if ($adubes['0']>0){
    //Jika ada Keppri, munculkan tanggal credential
      $neg = "SELECT a.*,b.*, c.TGL_CREDENTIAL
        FROM m_kantor_perwakilan a, m_negara b, ($sql) c
        WHERE a.ID_NEGARA=b.ID_NEGARA AND a.ID_KNT_PERWAKILAN=c.ID_KNT_PERWAKILAN AND c.ID_RANK='1' AND a.ID_KNT_PERWAKILAN = '$idt' ";
    }else{
    //Tidak ada Keppri, tidak ada tanggal credential
     $neg = "SELECT a.*,b.*
      FROM m_kantor_perwakilan a, m_negara b
      WHERE a.ID_NEGARA=b.ID_NEGARA AND a.ID_KNT_PERWAKILAN = '$idt' ";
    }

  $dneg = mysql_query($neg);
  if($dneg === FALSE) {
		die(mysql_error()); // TODO: better error handling
	}
	while($rneg = mysql_fetch_array($dneg))
	{
    $negara = $rneg['ID_NEGARA'];
    if ($adubes['0']>0){
      $aDate0 = date("<\b>F j<\s\u\p>S</\s\u\p>, Y</\b>", strtotime($rneg['TGL_CREDENTIAL']));
      $cre = 'Credentials presented by the Ambassador <br>'.$aDate0;
    }
    if (isset($rneg['NATIONALDAY'])){
		$oDate1 = new DateTime($rneg['NATIONALDAY']);
		$aDate1 = $oDate1->format("F j<\s\u\p>S</\s\u\p>");
	}else{
		$aDate1="a";
	}

  if(!empty($rneg['WEB'])){
    echo "
        <h2 align='center'>Detail Diplomatic Missions</h2>
        <form method=POST action='./aksi_negara.php?module=perutusan&act=input' enctype='multipart/form-data'>
          <table width=90%>
          <tr><td colspan=3 align='center'>
              <b>$rneg[NM_NEGARA]</b> <br>
              $rneg[NM_KNT_PERWAKILAN] <br>
              $cre
          </td ></tr>
          <tr><td rowspan=5>Chancery</td >
              <td width=50 colspan=2>$rneg[ALAMAT]</td></tr>
              <td width=50>Phone</td><td >: $rneg[TELP] </td></tr>
              <td>Fax</td><td >: $rneg[FAX]</td></tr>
              <td>Email</td><td >: $rneg[EMAIL]</td></tr>
              <td>Website</td><td >: <a href='$rneg[WEB]' target='_blank'>$rneg[WEB]</a> </td></tr>
          <tr><td >Office Hours</td>     <td colspan=2> : $rneg[OFFHOURS]</td></tr>
          <tr><td width=120>National Day</td >  <td colspan=2> :   $rneg[KET_NATIONALDAY], $aDate1</td></tr>
          </table>
          <table width=90%>
    ";
  }else{
    echo "
        <h2 align='center'>Detail Diplomatic Missions</h2>
        <form method=POST action='./aksi_negara.php?module=perutusan&act=input' enctype='multipart/form-data'>
          <table width=90%>
          <tr><td colspan=3 align='center'>
              <b>$rneg[NM_NEGARA]</b> <br>
              $rneg[NM_KNT_PERWAKILAN] <br>
              $cre
          </td ></tr>
          <tr><td rowspan=4>Chancery</td >
              <td width=50 colspan=2>$rneg[ALAMAT]</td></tr>
              <td width=50>Phone</td><td >: $rneg[TELP] </td></tr>
              <td>Fax</td><td >: $rneg[FAX]</td></tr>
              <td>Email</td><td >: $rneg[EMAIL]</td></tr>
          <tr><td >Office Hours</td>     <td colspan=2> : $rneg[OFFHOURS]</td></tr>
          <tr><td width=120>National Day</td >  <td colspan=2> :   $rneg[KET_NATIONALDAY], $aDate1</td></tr>
          </table>
          <table width=90%>
          <tr>
            <th>NO.</th>
            <th>NAME</th>
            <th>POSITION/TITLE</th>
            <th>ARRIVAL DATE</th>
            <th>ACTION</th>
          </tr>
    ";
  }

	}


	if($edit === FALSE) {
		die(mysql_error()); // TODO: better error handling
	}

	$no = 0;
	while($data = mysql_fetch_array($edit))
	{
						$no++;
						$oDate = new DateTime($data['TGL_TIBA']);
						$aDate = $oDate->format("d.m.Y");

						//untuk HS
						$tHS = "";
						if($data['JK']=='p'){
							$tHS = 'Mrs.';
						}elseif($data['JK']=='l'){
							$tHS = 'Mr.';
						}

						//untuk spouse
						$tSP  = "";
						$nSP  = $data['NM_SPOUSE'];
						$jkSP = $data['JK_SPOUSE'];

						if($nSP <> null){

							if($jkSP=='p'){
								$tSP = 'Mrs.';
							}elseif($jkSP=='l'){
								$tSP = 'Mr. ';
							}
						}

		  echo "
		  <tr>
					<td width=5%>$no</td>
					<td width=30%><a href=?module=diplomat&act=viewdiplomat&idt=$data[ID_DIPLOMAT]&negara=$_GET[negara]> $tHS $data[NM_DIPLOMAT] </a>
              <br> $tSP $nSP</td>
					<td width=30%>$data[OFFICIAL_NM] <br />$data[PEKERJAAN]</td>
					<td width=20%> $aDate</td>
					<td width=15% align=center><a href=?module=diplomat&act=editdiplomat&idt=$data[ID_DIPLOMAT]&idb=$_GET[idt]&negara=$_GET[negara]>Edit</a> </td></tr>";
	}
	echo "</table>
  </form>
  ";

//Query check kalau ada Konjen
  $consulate = "SELECT * FROM m_kantor_perwakilan WHERE ID_JNS_PERWAKILAN='4' AND ID_NEGARA=$negara AND NM_KNT_PERWAKILAN like '%konsulat%'";
  $consuls = mysql_query($consulate);

  $c = mysql_fetch_array(mysql_query("SELECT COUNT(ID_NEGARA) AS JML FROM m_kantor_perwakilan WHERE ID_JNS_PERWAKILAN='4' AND ID_NEGARA=$negara AND NM_KNT_PERWAKILAN like '%konsulat%'"));

  if ($c['0']!=0){
      while($consul = mysql_fetch_array($consuls)){

        $kantor = $consul['ID_KNT_PERWAKILAN'];
        if (stripos($consul['NM_KNT_PERWAKILAN'], 'kehormatan')){
          $pconsuls = mysql_query("SELECT `diplomat`.*,
            (select distinct NM_SIBLING from sibling where sibling.ID_DIPLOMAT=diplomat.ID_DIPLOMAT and ID_JNS_RELASI='3') as NM_SPOUSE,
            (select distinct JK from sibling where sibling.ID_DIPLOMAT=diplomat.ID_DIPLOMAT and ID_JNS_RELASI='3') as JK_SPOUSE, `rank`.`OFFICIAL_NM`
            FROM (`diplomat`)
            JOIN `rank` ON `diplomat`.`ID_RANK`=`rank`.`ID_RANK`
            WHERE `diplomat`.`ID_KNT_PERWAKILAN` = '$kantor'
            ORDER BY `AKHIR_BERLAKU` desc LIMIT 1");
        }else{
            $pconsuls = mysql_query("SELECT `diplomat`.*, `permit_diplomat`.`TGL_AKHIR_PERMIT`,(select MAX(TGL_AKHIR_PERMIT) from `permit_diplomat` where `permit_diplomat`.`ID_DIPLOMAT` = `diplomat`.`ID_DIPLOMAT` and kd_workflow>=3 limit 1) as TGL_AKHIR_CARD,
              (select distinct NM_SIBLING from sibling where sibling.ID_DIPLOMAT=diplomat.ID_DIPLOMAT and ID_JNS_RELASI='3') as NM_SPOUSE,
              (select distinct JK from sibling where sibling.ID_DIPLOMAT=diplomat.ID_DIPLOMAT and ID_JNS_RELASI='3') as JK_SPOUSE, `rank`.`OFFICIAL_NM`
              FROM (`diplomat`)
              JOIN `rank` ON `diplomat`.`ID_RANK`=`rank`.`ID_RANK`
              JOIN `permit_diplomat` ON `permit_diplomat`.`ID_DIPLOMAT`=`diplomat`.`ID_DIPLOMAT`
              WHERE `diplomat`.`ID_KNT_PERWAKILAN` = '$kantor' AND `MENGGANTIKAN_SIAPA` IS NOT NULL
              AND `permit_diplomat`.`TGL_AKHIR_PERMIT`>=CURDATE()
              ORDER BY `RANK` asc");
        }
          echo" <br /><table width=90%>
          <tr><td colspan=3 align='center'>
              $consul[NM_KNT_PERWAKILAN]
          </td ></tr>
          <tr><td rowspan=5 width='20%'>Chancery</td >
              <td width=50 colspan=2>$consul[ALAMAT]</td></tr>
              <td width=50>Phone</td><td >: $consul[TELP] </td></tr>
              <td>Fax</td><td >: $consul[FAX]</td></tr>
              <td>Email</td><td >: $consul[EMAIL]</td></tr>
              <td>Website</td><td >: <a href='$consul[WEB]' target='_blank'>$consul[WEB]</a> </td></tr>
          <tr><td >Office Hours</td>     <td colspan=2> : $consul[OFFHOURS]</td></tr>
          <table width=90%>
          <tr>
            <th>NO.</th>
            <th>NAME</th>
            <th>POSITION/TITLE</th>
            <th>ARRIVAL DATE</th>
            <th>ACTION</th>
          </tr>";

            $no = 0;
          	while($pconsul = mysql_fetch_array($pconsuls))
          	{
          						$no++;
          						$oDate = new DateTime($pconsul['TGL_TIBA']);
          						$aDate = $oDate->format("d.m.Y");

          						//untuk HS
          						$tHS = "";
          						if($pconsul['JK']=='p'){
          							$tHS = 'Mrs.';
          						}elseif($pconsul['JK']=='l'){
          							$tHS = 'Mr.';
          						}

          						//untuk spouse
          						$tSP  = "";
          						$nSP  = $pconsul['NM_SPOUSE'];
          						$jkSP = $pconsul['JK_SPOUSE'];

          						if($nSP <> null){

          							if($jkSP=='p'){
          								$tSP = 'Mrs.';
          							}elseif($jkSP=='l'){
          								$tSP = 'Mr. ';
          							}
          						}

          		  echo "
          		  <tr>
          					<td width=5%>$no</td>
                    <td width=30%><a href=?module=diplomat&act=viewdiplomat&idt=$pconsul[ID_DIPLOMAT]&negara=$_GET[negara]> $tHS $pconsul[NM_DIPLOMAT] </a>
                        <br> $tSP $nSP</td>
          					<td width=30%>$pconsul[PEKERJAAN] <br /> $pconsul[OFFICIAL_NM]</td>
          					<td width=20%> $aDate</td>
          					<td width=15% align=center><a href=?module=diplomat&act=editdiplomat&idt=$pconsul[ID_DIPLOMAT]&negara=$_GET[negara]>Edit</a> </td></tr>";
          	}
          	echo "</table>";
      }
      echo "</table>";
  }

	break;

  case "editperutusan":
    $idt = $_GET[idt];
    $edit = mysql_query("select ID_NEGARA,NEGARA,BENDERA,KET,NEG_RANTOR_K,NEG_RANTOR_I,KD_REGIONAL,NM_REGIONAL,NM_RESMI,NM_STATES  from m_negara where ID_NEGARA = $idt ");
    if($edit === FALSE) {
		die(mysql_error()); // TODO: better error handling
	}

	while($r = mysql_fetch_array($edit))
	{
		echo "<h2>Edit Permanent Missions to ASEAN</h2>
          <form method=POST enctype='multipart/form-data' action='./aksi_negara.php?module=negara&act=update'>
         <input type=hidden name=idt value='$r[ID_NEGARA]'>

		  <table width=90%>
		  <tr><td width=120>Negara</td >  <td > : <input type=text name='negara' value='$r[NEGARA]' size=50></td></tr>";
		echo "<tr><td>Bendera</td>     <td > : <input type=file size=40 name=fupload></td></tr>

		<tr><td width=120>Kode Regional</td >  <td > : <input type=text name='KD_REGIONAL' value='$r[KD_REGIONAL]' size=50></td></tr>
		  <tr><td width=120>Regional</td >  <td > : <input type=text name='NM_REGIONAL'  value='$r[NM_REGIONAL]' size=50></td></tr>

		  <tr bgcolor='#ffcc00'><td width=120>Country Name</td >  <td > : <input type=text  value='$r[NM_STATES]' name='NM_STATES' size=50></td></tr>
		  <tr bgcolor='#ffcc00'><td width=120>Official Country Name</td >  <td > : <input type=text  value='$r[NM_RESMI]' name='NM_RESMI' size=50></td></tr>

		  <tr><th colspan=2 height=30><div align=left >Jumlah fasilitas diberikan ke Indonesia</div></th></tr>
		  <tr><td width=120>Rantor Individu</td >  <td > : <input type=text  value='$r[NEG_RANTOR_I]' name='NEG_RANTOR_I' size=50></td></tr>
		  <tr><td width=120>Rantor Kantor</td >  <td > : <input type=text  value='$r[NEG_RANTOR_K]' name='NEG_RANTOR_K' size=50></td></tr>



		  <tr><td></td><td align=right><input type=submit value=Update> <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
		break;
	}




}
?>
<style type="text/css">
thead input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>
<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
		$('#cariStayPermit tfoot th').each(function(){
				var title = $(this).text();
        $(this).html('<input type="text" placeholder="'+title+'" />');

				var r = $('#cariStayPermit tfoot tr');
				$('#cariStayPermit thead').append(r);
    });

    // DataTable
    var table = $('#cariStayPermit').DataTable();

    //Apply the search
    table.columns().every( function (){
        var that = this;

        $('input', this.header()).on('keyup change', function(){
            if (that.search() !== this.value){
                that
                    .search(this.value)
                    .draw();
            }
        });

				$('input', this.header()).on('click', function(d){
						d.stopPropagation();
				});
    });
});
</script>
