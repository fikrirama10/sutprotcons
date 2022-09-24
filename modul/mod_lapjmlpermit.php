<?php

switch($_GET[act]){

  default:

  echo "<h2>Laporan Permit </h2> 
    <form method=POST action='./deplu.php?module=lapjmlpermit&act=generate' enctype='multipart/form-data'>
          <table width=100%>
          <tr><td  width=150>Negara *</td>  <td > : 
          <select name='ID_NEGARA' >
            <option value=1 selected>- ALL -</option>";
            $tampil=mysql_query("SELECT * FROM m_negara where id_negara > 1 ORDER BY negara");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_NEGARA]>$r[NEGARA]</option>";
            }
    echo "</select></td></tr>
		  <tr>	
			<td width='250'>Kantor Perwakilan Diplomat </td>
			<!--<td width='250'>:  <input type=hidden name=module value='staypermitc'>
				 <input type=hidden name=negara value='$_GET[negara]'> <input type=text name=\"kantordiplomat\"> </td>-->
				 
			<td width='250'> : 
			<select name='kantordiplomat' >
            <option value=1 selected>- ALL -</option>";
            $tampil=mysql_query("SELECT * FROM m_kantor_perwakilan where ID_KNT_PERWAKILAN != '196' AND ID_JNS_PERWAKILAN IN ('2','3','4') ORDER BY NM_KNT_PERWAKILAN ASC");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_KNT_PERWAKILAN]>$r[NM_KNT_PERWAKILAN]</option>";
            }
			echo "</select></td>				 
			</tr>
	      <tr><td  >Jenis Permit</td>  <td > : 
          <select name='ID_JNS_PERMIT' >
            <option value=0 selected>- ALL -</option>";
            $tampil=mysql_query("SELECT * FROM m_jns_permit  ORDER BY NM_JNS_PERMIT");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_JNS_PERMIT]>$r[NM_JNS_PERMIT]</option>";
          }
    echo "</select></td></tr>
		  <tr ><th colspan = 2 ><div align=left>Periode</div></th></tr>
		  <tr><td>Dari</td><td><DIV id=\"tgl\"> <script>DateInput('TGL_AWAL', true, 'YYYY-MM-DD')</script></div></td></tr>
		  <tr><td>Sampai Dengan</td><td><DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR', true, 'YYYY-MM-DD')</script></div></td></tr>
		  
		  <tr><th colspan = 2><div align=right><input type=submit value=Generate> </div></th></tr>
		

		  </table></form>";



	break;
    case "generate":

session_start();

//session_register("G_sql_lap");

$template = file("../template/canvasawal.htm");
$template = implode("",$template ); 

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){

	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";
	
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{

		
		$ID_NEGARA = $_POST[ID_NEGARA];   
		$ID_JNS_PERMIT = $_POST[ID_JNS_PERMIT]; 
		$kantordiplomat = $_POST[kantordiplomat];
	
		$TGL_AWAL = $_POST[TGL_AWAL]; 
		$TGL_AKHIR = $_POST[TGL_AKHIR]; 
		
		
		echo "<div align=center>
		<h2>LAPORAN REKAPITULASI PENERBITAN PERMIT</h2>
			
		<!-- <input type=button value='Cetak' onclick=location.href='./aksi_test.php?' target=\"_blank\"> -->
	<div align=left>
	    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Negara : ";

	 	if ($ID_NEGARA == 1){
	        echo "Semua Negara";
	}else{
		$r=mysql_fetch_array(mysql_query("SELECT NEGARA FROM m_negara where id_negara = $ID_NEGARA ORDER BY negara"));
            echo "$r[NEGARA]";
	}


	echo "<br>
		&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Jenis Permit : ";
	if ($ID_JNS_PERMIT == 0){
	        echo "Semua Permit";
	}else{
		$r=mysql_fetch_array(mysql_query("SELECT NM_JNS_PERMIT FROM m_jns_permit where ID_JNS_PERMIT = $ID_JNS_PERMIT"));
            echo "$r[NM_JNS_PERMIT]";
	}	
			
	echo "<br>
		&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Periode : $TGL_AWAL / $TGL_AKHIR  <br> 
	</div>

		<table width=700 >
          <tr><th width=30>no</th><th >NEGARA </th><th width=130>KANTOR PERWAKILAN</th><th width=130>JENIS PERMIT</th><th width=130>JENIS PERLAKUAN </th><th width=100>JUMLAH</th></tr>";



//    $p      = new Paging;
//   $batas  = 10;
//    $posisi = $p->cariPosisi($batas);

	$QWERYNYA = "SELECT a.BENDERA,a.ID_NEGARA, a.NEGARA, b.ID_JNS_PERMIT ,b.KD_JNS_PERMIT,c.NM_PERLAKUAN, e.ID_KNT_PERWAKILAN, e.NM_KNT_PERWAKILAN, (select count(d.ID_PERMIT) from v_approval_permit d where ((a.ID_NEGARA = d.ID_NEGARA) and (b.ID_JNS_PERMIT  = d.ID_JNS_PERMIT)  and (c.NM_PERLAKUAN = d.KET_LAY) and (e.ID_KNT_PERWAKILAN = d.ID_KNT_PERWAKILAN) ) and (st_permit_k = 2 and st_permit_kas = 2) and (TGL_AWAL_PERMIT between '$TGL_AWAL' and '$TGL_AKHIR')  ) as JUMLAH FROM m_negara a ,m_jns_permit b, perlakuan c, m_kantor_perwakilan e where ";
    
	if ($ID_NEGARA == '1'){
		$QWERYNYA = $QWERYNYA." a.ID_NEGARA <> 1 ";
		}else{
		$QWERYNYA = $QWERYNYA." a.ID_NEGARA = $ID_NEGARA ";
		}

	if ($ID_JNS_PERMIT == '0'){
		$QWERYNYA = $QWERYNYA;
		}else{
		$QWERYNYA = $QWERYNYA." and b.ID_JNS_PERMIT = $ID_JNS_PERMIT ";
		}
		
	if ($kantordiplomat == '1'){
		$QWERYNYA = $QWERYNYA." and e.ID_NEGARA = $ID_NEGARA ";
		}else{
		$QWERYNYA = $QWERYNYA." and e.ID_KNT_PERWAKILAN = $kantordiplomat";
		}
	

    $QWERYNYA = $QWERYNYA." Group by a.ID_NEGARA, e.ID_KNT_PERWAKILAN, b.ID_JNS_PERMIT ,c.NM_PERLAKUAN ";
   // echo $QWERYNYA;
   	  $_SESSION[G_sql_lap] = $QWERYNYA;

	 $tampil=mysql_query($QWERYNYA);
   
    $no = 1;
	$xxx= "..";
    while($r=mysql_fetch_array($tampil)){

      echo "<tr>";
	  if ($xxx != $r[NEGARA]) {
	  echo "<td>$no</td><td><img src=\"../images/bendera/".strtolower($r[BENDERA])."\" class=\"thumbborder\" width=\"22\" height=\"15\" />  &nbsp $r[NEGARA]</td>";
	  $no++;
	  }else {
	  echo "<td></td><td></td>";
	  }
	  $sum_all += $r[JUMLAH];
	  $xxx = $r[NEGARA];
	  
	  echo "    <td>$r[NM_KNT_PERWAKILAN]</td>	
				<td>$r[KD_JNS_PERMIT]</td>		
				<td>$r[NM_PERLAKUAN]</td>	
				<td>$r[JUMLAH]</td>	
					
			
		        </tr>";
      
    }
    echo "
	<tr><td width=200 colspan=5><h3 style=color:blue;><b>TOTAL</b></h3></td><td width=100><h3 style=color:blue;><b>$sum_all</b></h3></td></tr>
	</table></div>";
//	
//		$jmldata =mysql_num_rows(mysql_query($QWERYNYA));
//
//	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
//
//   $ilink = "?module=lapjmlpermit&act=generate"; 
//    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
//
//    echo "<div id=paging>$linkHalaman</div><br>";
    break;



}
		
}
?>
