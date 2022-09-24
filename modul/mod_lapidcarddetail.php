<?php

switch($_GET[act]){

  default:

  echo "<h2>Laporan ID Card </h2> 
    <form method=POST action='./deplu.php?module=lapidcarddetail&act=generate' enctype='multipart/form-data'>
          <table width=80%>
          <tr><td  width=150>Negara</td>  <td > : 
          <select name='ID_NEGARA' >
            ";
            $tampil=mysql_query("SELECT * FROM m_negara where id_negara > 1 ORDER BY negara");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_NEGARA]>$r[NEGARA]</option>";
            }

	echo "
			
		  <tr><td  width=150>Jenis Perwakilan</td>  <td > : 
          <select name='JENIS_PWK' >";
            $tampil2=mysql_query("SELECT * FROM m_jns_perwakilan");
            while($r=mysql_fetch_array($tampil2)){
              echo "<option value=$r[ID_JNS_PERWAKILAN]>$r[NM_JNS_PERWAKILAN]</option>";
            }
    		echo "</td></tr>
			 <tr><td colspan=2></td> 
    		</tr> 
			";
			
    echo "</select></td></tr>
		  
		  
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

		
		$ID_NEGARA			 	= $_POST[ID_NEGARA];   
		$ID_JNS_CETAK_KARTU 	= $_POST[ID_JNS_CETAK_KARTU]; 
		$JENIS_PWK 				= $_POST[JENIS_PWK];
		
		
		
		$reportdata = "<div align=center>
		<h2>LAPORAN ID CARD </h2>";
		
		
	$reportdata .="<div align=left>
			<br>
		
		";
		
		$r = mysql_query("SELECT NEGARA FROM m_negara where id_negara = $ID_NEGARA ORDER BY negara");

		while($negara=mysql_fetch_array($r)){
            
	   $reportdata .= "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Negara : $negara[NEGARA] <br><br>
	   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href='export.php'><button>Export Data ke Excel</button></a>
			<br>
	   </div> <br>
	    
	   ";		

		$reportdata .= "<table width=700 >
          <tr><th width=30>no</th><th width=300 >NAMA</th><th width=100>POSISI</th>
		  <th width=100>TGL TIBA</th><th width=100>NO ID CARD</th><th width=100>TGL AWAL</th>
		  <th width=100>TGL AKHIR</th><th width=100>JENIS ID CARD</th>
		  <th width=100>MENGGANTIKAN SIAPA</th></tr>";
	

	
		$QWERYNYA = "
		
		SELECT  * from
		(		SELECT  a.ID_DIPLOMAT, a.NM_DIPLOMAT, a.NM_JNS_CETAK_KARTU, a.ID_CARD, b.TGL_TIBA, 
				a.TGL_AWAL_CARD, a.TGL_AKHIR_CARD, b.PEKERJAAN, b.MENGGANTIKAN_SIAPA, c.NEGARA, a.ID_NEGARA, d.NM_DIPLOMAT as NM_PENGGANTI,  e.`RANK` as `rank`
				from v_id_card2 as a left join diplomat as b on a.ID_DIPLOMAT = b.ID_DIPLOMAT
				LEFT JOIN m_negara as c on a.ID_NEGARA = c.ID_NEGARA
				left join diplomat as d on b.MENGGANTIKAN_SIAPA = d.ID_DIPLOMAT
				left join `rank` as e on b.ID_RANK = e.ID_RANK
				where st_kartu = 2 and st_kartu_k = 2 and ID_JNS_PERWAKILAN=$JENIS_PWK and DATE_FORMAT(a.TGL_AKHIR_CARD,'%Y%m%d') >= DATE_FORMAT(NOW(), '%Y%m%d')
				and a.ID_NEGARA = $ID_NEGARA order by a.NM_DIPLOMAT, DATE_FORMAT(a.TGL_AKHIR_CARD,'%Y%m%d') DESC
		) as datanya
		GROUP BY ID_DIPLOMAT
		ORDER BY `rank` ASC, NM_DIPLOMAT
		
		";


	/*if ($ID_NEGARA == '1'){
		$QWERYNYA = $QWERYNYA." and  a.ID_NEGARA <> 1 ";
		}else{
		$QWERYNYA = $QWERYNYA." and a.ID_NEGARA = $ID_NEGARA ";
		}

    $QWERYNYA = $QWERYNYA." order by a.NM_DIPLOMAT"; */

   	  $_SESSION[G_sql_lap] = $QWERYNYA;
	
	 $tampil=mysql_query($QWERYNYA);
	 if (!$tampil) { // add this check.
			die('Invalid query: ' . mysql_error());
		}
   
    $no = 1;
	$xxx= "..";
    while($result=mysql_fetch_array($tampil)){
	  $QWERY_SIB = "
		SELECT  * from
		( SELECT  a.ID_SIBLING, a.NM_SIBLING, a.ID_DIPLOMAT, a.NM_DIPLOMAT, 
				a.NM_JNS_CETAK_KARTU, a.ID_CARD, b.TGL_TIBA, 
				a.TGL_AWAL_CARD, a.TGL_AKHIR_CARD, b.PEKERJAAN,  c.NEGARA, b.ID_NEGARA
				from v_id_card_s as a left join sibling as b on a.ID_SIBLING = b.ID_SIBLING
				LEFT JOIN m_negara as c on b.ID_NEGARA = c.ID_NEGARA
				where a.ID_DIPLOMAT=$result[ID_DIPLOMAT] and DATE_FORMAT(a.TGL_AKHIR_CARD,'%Y%m%d') >= DATE_FORMAT(NOW(), '%Y%m%d')
		order by a.NM_SIBLING, DATE_FORMAT(a.TGL_AKHIR_CARD,'%Y%m%d') DESC
		) as datanya
		GROUP BY NM_SIBLING
		";
	 $tampil_sib=mysql_query($QWERY_SIB);
	 
	  $reportdata .= "    <tr> 
				<td>$no</td>	
				<td>$result[NM_DIPLOMAT]</td>
				<td>$result[PEKERJAAN]</td>	
				<td>$result[TGL_TIBA]</td>		
				<td>$result[ID_CARD]</td>
				<td>$result[TGL_AWAL_CARD]</td>
				<td>$result[TGL_AKHIR_CARD]</td>
				<td>$result[NM_JNS_CETAK_KARTU]</td>
				<td>$result[NM_PENGGANTI]</td>				
		        </tr>
				
				
				";

			while($result_sib=mysql_fetch_array($tampil_sib)){
				$reportdata .= "<tr> 
				<td></td><td>$result_sib[NM_SIBLING]</td>
					<td>$result_sib[PEKERJAAN]</td>	
					<td>$result_sib[TGL_TIBA]</td>		
					<td>$result_sib[ID_CARD]</td>
					<td>$result_sib[TGL_AWAL_CARD]</td>
					<td>$result_sib[TGL_AKHIR_CARD]</td>
					<td>$result_sib[NM_JNS_CETAK_KARTU]</td>
					<td>$result_sib[NM_PENGGANTI]</td>	</tr>		";	
			}
	
	$reportdata .=		"	
				</tr>
				";
      $no++;
    }
	
    $reportdata .= "</table></div><br>";
	echo $reportdata;
	$_SESSION['reportdata'] = $reportdata;
    break;
		
		
		}

		}
		
}
?>
