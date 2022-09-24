<?php

switch($_GET[act]){

  default:

  echo "<h2>Laporan Status Pengembalian ID Card</h2> 
    <form method=POST action='./report/idcardaktif.php' target='_blank' enctype='multipart/form-data'>
          <table width=80%>
         <!-- <tr><td  width=150>Negara</td>  <td > : 
          <select name='ID_NEGARA' >
            <option value=1 selected>- ALL -</option>";
            $tampil=mysql_query("SELECT * FROM m_negara where id_negara > 1 ORDER BY negara");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_NEGARA]>$r[NEGARA]</option>";
            }
    echo "</select></td></tr>
	      <tr><td  >Jenis ID Card</td>  <td > : 
           <select name='ID_JNS_CETAK_KARTU'>
			<option value=0 selected>- Not Defined -</option>";
             $tampil=mysql_query("SELECT ID_JNS_CETAK_KARTU,NM_JNS_CETAK_KARTU FROM m_jns_cetak_kartu ORDER BY ID_JNS_CETAK_KARTU");
            while($w=mysql_fetch_array($tampil)){
				echo "<option value=$w[ID_JNS_CETAK_KARTU]>$w[NM_JNS_CETAK_KARTU]</option>";
			
			}
    echo "</select></td></tr>-->
		  <tr><td  width=150>Jenis ID Card</td>  <td > : 
          <select name='Jenis ID Card' >
            <option value=1 selected>Diplomat</option> 
            <option value=2 >Family</option> 
    		</select></td></tr><tr ><th colspan = 2 ><div align=left>Periode Pengembalian</div></th></tr>
		  <tr><td>Dari</td><td><DIV id=\"tgl\"> <script>DateInput('TGL_AWAL', true, 'YYYY-MM-DD')</script></div></td></tr>
		  <tr><td>Sampai Dengan</td><td><DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR', true, 'YYYY-MM-DD')</script></div></td></tr>
		  <!--<tr><td>Status Pengembalian</td><td><select name='STATUS'><option selected>SUDAH</option> <option>BELUM</option></select></td></tr>-->
    		
		  <tr><th colspan = 2><div align=right><input type=submit value=Generate> </div></th></tr>
		

		  </table></form>";



	break;
    case "generate_period":

session_start();

session_register("G_sql_lap");

$template = file("../template/canvasawal.htm");
$template = implode("",$template ); 

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){

	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";
	
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{
	echo "<h2>Laporan Status Pengembalian ID Card</h2>
    <form method=POST action='./deplu.php?module=idcardaktif&act=generate_period' enctype='multipart/form-data'>
          <table width=80%>
          <!--<tr><td  width=150>Negara</td>  <td > :
          <select name='ID_NEGARA' >
            <option value=1 selected>- ALL -</option>";
	$tampil=mysql_query("SELECT * FROM m_negara where id_negara > 1 ORDER BY negara");
	while($r=mysql_fetch_array($tampil)){
		echo "<option value=$r[ID_NEGARA]>$r[NEGARA]</option>";
	}
	echo "</select></td></tr>
		<tr><td  >Jenis ID Card</td>  <td > :
           <select name='ID_JNS_CETAK_KARTU'>
			<option value=0 selected>- Not Defined -</option>";
             $tampil=mysql_query("SELECT ID_JNS_CETAK_KARTU,NM_JNS_CETAK_KARTU FROM m_jns_cetak_kartu ORDER BY ID_JNS_CETAK_KARTU");
            while($w=mysql_fetch_array($tampil)){
	            echo "<option value=$w[ID_JNS_CETAK_KARTU]>$w[NM_JNS_CETAK_KARTU]</option>";
	            	
		}
		echo "</select></td></tr>-->
		  <tr ><th colspan = 2 ><div align=left>Periode Pengembalian</div></th></tr>
		  <tr><td>Dari</td><td><DIV id=\"tgl\"> <script>DateInput('TGL_AWAL', true, 'YYYY-MM-DD')</script></div></td></tr>
		  <tr><td>Sampai Dengan</td><td><DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR', true, 'YYYY-MM-DD')</script></div></td></tr>
		 <!-- <tr><td>Status Pengembalian</td><td><select name='STATUS'><option selected>SUDAH</option> <option>BELUM</option></select></td></tr>-->
	
		  <tr><th colspan = 2><div align=right><input type=submit value=Generate> </div></th></tr>
	
	
		  </table></form>";

		//print_r($_POST);
		//exit;
		//$ID_NEGARA = $_POST[ID_NEGARA];   
		//$ID_JNS_CETAK_KARTU = $_POST[ID_JNS_CETAK_KARTU]; 
	 	$sql ="select 
				    b.ID_DIPLOMAT, 
				    b.NM_DIPLOMAT,
				    b.NO_PASPOR,
				    c.NM_KNT_PERWAKILAN,
				    a.ID_CARD,
				    a.TGL_AWAL_CARD,
				    a.TGL_AKHIR_CARD,
				    a.STATUS_PENGEMBALIAN,
				    a.TGL_PENGEMBALIAN
				from 
				    cetak_kartu_diplomat as a, 
				    diplomat as b,
				    m_kantor_perwakilan as c
				where 
				    a.ID_DIPLOMAT=b.ID_DIPLOMAT and
				    b.ID_KNT_PERWAKILAN=c.ID_KNT_PERWAKILAN and
	 				a.STATUS_PENGEMBALIAN = 'SUDAH'
	 			order by 
	 				b.NM_DIPLOMAT asc
				   "; 
	 	$query = mysql_query($sql);

	 	echo "
	 			<table width='100%'>
	 				<tr>
	 					<th>No</th>
	 					<th>ID Diplomat</th>
 				 		<th>Nama</th>
 				 		<th>No Paspor</th>
 				 		<th>Berkerja</th>
 				 		<th>NO ID CARD</th>
 				 		<th>Tgl Berlaku Kartu</th>
 			 			<th>Status Kembali</th>
 			 			<th>Tgl Kembali</th>
 					</tr>	 			
	 			";
	 	$no=0;
	 	while ($data=mysql_fetch_array($query)){ $no++;
	 	if ($data['STATUS_PENGEMBALIAN']=='SUDAH') {
	 		$status="SUDAH";
	 	} else{
	 		$status="BELUM";
	 	}
	 		echo "<tr>
	 					<td>".$no."</td>
	 					<td>".$data['ID_DIPLOMAT']."</td>
	 					<td>".$data['NM_DIPLOMAT']."</td>
	 					<td>".$data['NO_PASPOR']."</td>
	 					<td>".$data['NM_KNT_PERWAKILAN']."</td>
	 					<td>".$data['ID_CARD']."</td>
	 					<td>".date("d M Y", strtotime($data['TGL_AWAL_CARD']))." - ".date("d M Y", strtotime($data['TGL_AKHIR_CARD']))."</td>
	 					<td>".$status."</td>
	 					<td>".date("d M Y", strtotime($data['TGL_PENGEMBALIAN']))."</td>
	 			</tr>";
	 	}
	 	echo "</table>"; 
    break;



}
		
}
?>
