<?php

switch($_GET[act]){

  default:

  echo "<h2>Laporan Visa </h2> 
    <form method=POST action='./deplu.php?module=lapjmlvisa&act=generate' enctype='multipart/form-data'>
          <table width=80%>";
		  echo "<tr><td width=150>Perwakilan RI &nbsp; <font color='red'>*</font></td>     
			<td> : <select name='pwk_otvis' id='pwk_otvis'>
			<option value='0'>- ALL -</option>
			"; 
				$sql_pwk="select a.id_perwakilan,a.perwakilan,a.negara,b.nm_regional from tbl_perwakilan a left join tbl_regional b on a.id_regional = b.id_regional";
				$tampil_pwk=mysql_query($sql_pwk);
				 while($val=mysql_fetch_array($tampil_pwk))
				 {
					echo "<option value='$val[id_perwakilan]'>$val[perwakilan]</option>";
				 }
		
		echo "</select></td></tr>"; 
         /*  echo"<tr><td  width=150>Negara</td>  <td > : 
          <select name='ID_NEGARA' >
            <option value=1 selected>- ALL -</option>";
            $tampil=mysql_query("SELECT * FROM m_negara where id_negara > 1 ORDER BY negara");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_NEGARA]>$r[NEGARA]</option>";
            }
    echo "</select></td></tr>"; */
	
	    /*  echo" <tr><td  >Jenis Permit</td>  <td > : 
          <select name='ID_JNS_PERMIT' >
            <option value=0 selected>- ALL -</option>";
            $tampil=mysql_query("SELECT * FROM m_jns_permit  ORDER BY NM_JNS_PERMIT");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_JNS_PERMIT]>$r[NM_JNS_PERMIT]</option>";
          }
    echo "</select></td></tr>"; */
	
	 echo" <tr><td  >Status</td>  <td > : 
          <select name='ID_JNS_PERMIT' >
            <option value=0 selected>- ALL -</option>";
            $sql_status1="select * from tbl_ref_status";
			$tampil_status1=mysql_query($sql_status1);
             while($val=mysql_fetch_array($tampil_status1))
				 {
					echo "<option value='$val[id]'>$val[status]</option>";
				 }
    echo "</select></td></tr>";
	
	echo "
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
	
		$TGL_AWAL = $_POST[TGL_AWAL]; 
		$TGL_AKHIR = $_POST[TGL_AKHIR]; 
		
		
		echo "<div align=center>
		<h2>LAPORAN REKAPITULASI PENGAJUAN VISA</h2>
			
		<input type=button value='Cetak' onclick=location.href='./aksi_test.php?' target=\"_blank\">
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
          <tr><th width=30>no</th><th >NEGARA</th><th width=130>JENIS PERMIT</th><th width=130>JENIS PERLAKUAN </th><th width=100>JUMLAH</th></tr>";



//    $p      = new Paging;
//   $batas  = 10;
//    $posisi = $p->cariPosisi($batas);

	$QWERYNYA = "SELECT a.BENDERA,a.ID_NEGARA, a.NEGARA, b.ID_JNS_PERMIT ,b.KD_JNS_PERMIT,c.NM_PERLAKUAN,(select count(d.ID_PERMIT) from v_approval_permit d where ((a.ID_NEGARA = d.ID_NEGARA) and (b.ID_JNS_PERMIT  = d.ID_JNS_PERMIT)  and (c.NM_PERLAKUAN = d.KET_LAY)) and (st_permit = 2 and st_permit_k = 2) and (TGL_AWAL_PERMIT between '$TGL_AWAL' and '$TGL_AKHIR')  ) as JUMLAH FROM m_negara a ,m_jns_permit b, perlakuan c where ";
    
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
	

    $QWERYNYA = $QWERYNYA." Group by a.ID_NEGARA,  b.ID_JNS_PERMIT ,c.NM_PERLAKUAN ";
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

	  $xxx = $r[NEGARA];
	  echo "     <td>$r[KD_JNS_PERMIT]</td>		
				<td>$r[NM_PERLAKUAN]</td>	
				<td>$r[JUMLAH]</td>	
					
			
		        </tr>";
      
    }
    echo "</table></div>";
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
