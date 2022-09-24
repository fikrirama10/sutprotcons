<?php

switch($_GET[act]){

  default:

  echo "<h2>Laporan ID Card </h2> 
    <form method=POST action='./deplu.php?module=lapjmlidcard&act=generate' enctype='multipart/form-data'>
          <table width=80%>
          <tr><td  width=150>Negara</td>  <td > : 
          <select name='ID_NEGARA' >
            <option value=1 selected>- ALL -</option>";
            $tampil=mysql_query("SELECT * FROM m_negara where id_negara > 1 ORDER BY negara");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_NEGARA]>$r[NEGARA]</option>";
            }
    /*echo "</select></td></tr>
	      <tr><td  >Jenis ID Card</td>  <td > : 
           <select name='ID_JNS_CETAK_KARTU'>
			<option value=0 selected>- Not Defined -</option>";
             $tampil=mysql_query("SELECT ID_JNS_CETAK_KARTU,NM_JNS_CETAK_KARTU FROM m_jns_cetak_kartu ORDER BY ID_JNS_CETAK_KARTU");
            while($w=mysql_fetch_array($tampil)){
				echo "<option value=$w[ID_JNS_CETAK_KARTU]>$w[NM_JNS_CETAK_KARTU]</option>";
			
			} */
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
		$ID_JNS_CETAK_KARTU = $_POST[ID_JNS_CETAK_KARTU]; 
	
		$TGL_AWAL = $_POST[TGL_AWAL]; 
		$TGL_AKHIR = $_POST[TGL_AKHIR]; 
		
		
		echo "<div align=center>
		<h2>LAPORAN REKAPITULASI PENERBITAN ID CARD</h2>
			
		
	<div align=left>
	    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Negara : ";

	 	if ($ID_NEGARA == 1){
	        echo "Semua Negara";
	}else{
		$r=mysql_fetch_array(mysql_query("SELECT NEGARA FROM m_negara where id_negara = $ID_NEGARA ORDER BY negara"));
            echo "$r[NEGARA]";
	}


	/*echo "<br>
		&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Jenis ID CARD : ";
	if ($ID_JNS_CETAK_KARTU == 0){
	        echo "Semua Permit";
	}else{
		$r=mysql_fetch_array(mysql_query("SELECT ID_JNS_CETAK_KARTU,NM_JNS_CETAK_KARTU FROM m_jns_cetak_kartu where ID_JNS_CETAK_KARTU = $ID_JNS_CETAK_KARTU"));
            echo "$r[NM_JNS_CETAK_KARTU]";
	}*/	
			
	echo "<br>
		&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Periode : $TGL_AWAL / $TGL_AKHIR  <br> 
	</div>

		<table width=700 >
          <tr><th width=30>no</th><th width=200 >NEGARA</th><th width=100>ID Card Baru</th><th width=100>Perpanjangan</th><th width=100>Berubah Status</th><th width=100>ID Card Hilang</th><th width=100>Jumlah</th></tr>";
 
//    $p      = new Paging;
//   $batas  = 10;
//    $posisi = $p->cariPosisi($batas);

	//$QWERYNYA = "SELECT a.BENDERA,a.ID_NEGARA, a.NEGARA, b.ID_JNS_CETAK_KARTU ,b.NM_JNS_CETAK_KARTU, (select count(d.ID_CETAK) from v_id_card2 d where ((a.ID_NEGARA = d.ID_NEGARA) and (b.ID_JNS_CETAK_KARTU = d.ID_JNS_CETAK_KARTU)) and (st_kartu= 2) and (TGL_AWAL_CARD between '$TGL_AWAL' and '$TGL_AKHIR')) as JUMLAH FROM m_negara a ,m_jns_cetak_kartu b, perlakuan c where ";
    $QWERYNYA = "SELECT  a.BENDERA,a.ID_NEGARA, a.NEGARA,
    COUNT(CASE WHEN b.ID_JNS_CETAK_KARTU = 1 then 1 ELSE NULL END) as 'baru',
    COUNT(CASE WHEN b.ID_JNS_CETAK_KARTU = 2 then 1 ELSE NULL END) as 'perpanjangan',
    COUNT(CASE WHEN b.ID_JNS_CETAK_KARTU = 3 then 1 ELSE NULL END) as 'berubah',
    COUNT(CASE WHEN b.ID_JNS_CETAK_KARTU = 4 then 1 ELSE NULL END) as 'hilang'
	from m_negara as a join v_id_card2 as b
	on a.id_negara = b.id_negara
	where TGL_AWAL_CARD between '$TGL_AWAL' and '$TGL_AKHIR' and st_kartu = 2 and st_kartu_k = 2
	";

	if ($ID_NEGARA == '1'){
		$QWERYNYA = $QWERYNYA." and  a.ID_NEGARA <> 1 ";
		}else{
		$QWERYNYA = $QWERYNYA." and a.ID_NEGARA = $ID_NEGARA ";
		}

	/*if ($ID_JNS_CETAK_KARTU == '0'){
		$QWERYNYA = $QWERYNYA;
		}else{
		$QWERYNYA = $QWERYNYA." and b.ID_JNS_CETAK_KARTU = $ID_JNS_CETAK_KARTU ";
		}*/
	

    $QWERYNYA = $QWERYNYA." Group by a.ID_NEGARA order by a.NEGARA";

   	  $_SESSION[G_sql_lap] = $QWERYNYA;

	 $tampil=mysql_query($QWERYNYA);
   
    $no = 1;
	$xxx= "..";
    while($r=mysql_fetch_array($tampil)){

      echo "<tr>";
	  if ($xxx != $r[NEGARA]) {
	  echo "<td>$no</td><td><img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" />  &nbsp $r[NEGARA]</td>";
	  $no++;
	  }else {
	  echo "<td></td><td></td>";
	  }

	  $xxx = $r[NEGARA];
	  
	 /* if ($ID_JNS_CETAK_KARTU == 0){
	        echo "<td>Semua Permit</td>";
	}else{
		$result=mysql_fetch_array(mysql_query("SELECT ID_JNS_CETAK_KARTU,NM_JNS_CETAK_KARTU FROM m_jns_cetak_kartu where ID_JNS_CETAK_KARTU = $ID_JNS_CETAK_KARTU"));
            echo "<td>$result[NM_JNS_CETAK_KARTU]</td>";
	}	*/
	$sum=$r[baru]+$r[perpanjangan]+$r[berubah]+$r[hilang];
	$sum_all += $sum;	
	  echo "     
				<td>$r[baru]</td>	
				<td>$r[perpanjangan]</td>	
				<td>$r[berubah]</td>	
				<td>$r[hilang]</td>		
				<td><b>$sum</b></td>	
		        </tr>";
      
    }
	
    echo "
	<tr><td width=200 colspan=6><h3 style=color:blue;><b>TOTAL</b></h3></td><td width=100><h3 style=color:blue;><b>$sum_all</b></h3></td></tr>
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
