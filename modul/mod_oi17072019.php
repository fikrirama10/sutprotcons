<?php
switch($_GET[act]){
  // Tampil Berita
  default:

		echo "<h2 align='center'>INTERNATIONAL ORGANIZATIONS</h2>
			 <br>
          <input type=button value='Tambah' onclick=location.href='?module=kantor&act=tambahkantor'><p>
          <table width=100% id=cariStayPermit name=cariStayPermit class=display>
          <thead>
          <tr><th width=10 >No</th>
		  <th  width=400 >ORGANIZATIONS</th>
		  <th width=100>ACTION</th></tr></thead><tbody>	";

    // $p      = new Paging;
    // $batas  = 30;
    // $posisi = $p->cariPosisi($batas);

	  $sql= "SELECT DISTINCT `m_negara`.`ID_NEGARA`, `m_negara`.`NEGARA`, `m_kantor_perwakilan`.* FROM (`m_kantor_perwakilan`)
				LEFT JOIN `m_negara` ON `m_kantor_perwakilan`.`ID_NEGARA` = `m_negara`.`ID_NEGARA` WHERE `m_kantor_perwakilan`.`ID_JNS_PERWAKILAN` = '3'
				AND `m_kantor_perwakilan`.`ID_GROUP` = '1' ORDER BY `NM_KNT_PERWAKILAN` asc ";

	$tampil=mysql_query($sql);

    $no = $posisi+1;
    while($rr=mysql_fetch_array($tampil)){


      echo "<tr><td>$no</td>
				<td><a href=?module=oi&act=viewoi&idt=$rr[ID_KNT_PERWAKILAN]>$rr[NM_KNT_PERWAKILAN]</a></td>
		            <td align=center><a href=?module=kantor&act=editkantor&idt=$rr[ID_KNT_PERWAKILAN]>Edit</a> </td>
		        </tr>";
      $no++;
    }
    echo "</tbody></table>";
  // 	$jmldata =mysql_num_rows(mysql_query("SELECT DISTINCT `m_negara`.`ID_NEGARA`, `m_negara`.`NEGARA`, `m_kantor_perwakilan`.* FROM (`m_kantor_perwakilan`)
	// 		LEFT JOIN `m_negara` ON `m_kantor_perwakilan`.`ID_NEGARA` = `m_negara`.`ID_NEGARA` WHERE `m_kantor_perwakilan`.`ID_JNS_PERWAKILAN` = '3'
	// 		AND `m_kantor_perwakilan`.`ID_GROUP` = '2' OR `m_kantor_perwakilan`.`ID_GROUP` = '3' ORDER BY `ID_ORDER`"));
  //
	// $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
  //
  //  $ilink = "?module=perutusan";
  //   $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
  //
  //   echo "<div id=paging>$linkHalaman</div><br>";
    break;


  case "viewoi":
    $idt = $_GET[idt];
	$neg = "select * from m_kantor_perwakilan where ID_KNT_PERWAKILAN = '$idt' ";
	$dneg = mysql_query($neg);
    if($dneg === FALSE) {
		die(mysql_error()); // TODO: better error handling
	}
	while($rneg = mysql_fetch_array($dneg))
	{
		$oDate1 = new DateTime($data['NATIONALDAY']);
		$aDate1 = $oDate1->format("F j<\s\u\p>S</\s\u\p>");

    echo "<h2 align='center'>Detail Permanent Missions to ASEAN</h2>
          <form method=POST action='./aksi_negara.php?module=perutusan&act=input' enctype='multipart/form-data'>
          <table width=90%>
          <tr><td colspan=3 align='center'>$rneg[NM_KNT_PERWAKILAN]</td >  </tr>
		  <tr><td rowspan=5>Chancery</td >
		  		<td width=50 colspan=2>$rneg[ALAMAT]</td></tr>
				<td width=50>Phone</td><td >: $rneg[TELP] </td></tr>
				<td>Fax</td><td >: $rneg[FAX]</td></tr>
				<td>Email</td><td >: $rneg[EMAIL]</td></tr>
        <td>Website</td><td >: <a href='$rneg[WEB]' target='_blank'>$rneg[WEB]</a> </td></tr>
		  <tr><td >Office Hours</td>     <td colspan=2> : $rneg[OFFHOURS]</td></tr>
		  <tr><td width=120>National Day</td >  <td colspan=2> : $aDate1</td></tr>
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


	$sql = "SELECT `diplomat`.*, `permit_diplomat`.`TGL_AKHIR_PERMIT`, (select MAX(TGL_AKHIR_PERMIT) from permit_diplomat where permit_diplomat.`ID_DIPLOMAT` = diplomat.`ID_DIPLOMAT` and kd_workflow>=3 limit 1) as TGL_AKHIR_IZIN,
		(select distinct NM_SIBLING from sibling where sibling.ID_DIPLOMAT=diplomat.ID_DIPLOMAT and ID_JNS_RELASI='3') as NM_SPOUSE,
		(select distinct JK from sibling where sibling.ID_DIPLOMAT=diplomat.ID_DIPLOMAT and ID_JNS_RELASI='3') as JK_SPOUSE, `rank`.`OFFICIAL_NM`
		FROM (`diplomat`) JOIN `rank` ON `diplomat`.`ID_RANK`=`rank`.`ID_RANK`
    JOIN `permit_diplomat` ON `permit_diplomat`.`ID_DIPLOMAT`=`diplomat`.`ID_DIPLOMAT`
		WHERE `diplomat`.`ID_KNT_PERWAKILAN` = '$idt' AND `MENGGANTIKAN_SIAPA` IS NOT NULL AND `permit_diplomat`.`TGL_AKHIR_PERMIT`>=CURDATE() ORDER BY `RANK` asc";
	$edit = mysql_query($sql);
    //echo $sql;
	//exit;
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
		  <tr >
					<td width=5%>$no </td>
					<td width=30%> $tHS $data[NM_DIPLOMAT] <br> $tSP $nSP</td>
					<td width=30%>$data[OFFICIAL_NM] <br />$data[PEKERJAAN]</td>
					<td width=20%> $aDate </td>
					<td width=15% align=center> <a href=?module=diplomat&act=editdiplomat&idt=$data[ID_DIPLOMAT]&negara=$_GET[negara]>Edit</a> </td>
			</tr>
		  ";
	}
	echo"
          </table></form>";
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
