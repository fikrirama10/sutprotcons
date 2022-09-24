<?php

switch($_GET[act]){

  default:

  echo "<h2>Laporan Rekap Rantor Kantor Perwakilan</h2> 
    <form method=POST action='./deplu.php?module=laprantorwakil&act=generate' enctype='multipart/form-data'>
          <table width=700>
          <tr><td width=150>Kantor Perwakilan</td>  <td > : 
          <select name='ID_KNT_PERWAKILAN' >
            <option value=1 selected>- ALL -</option>";
            $tampil=mysql_query("select ID_KNT_PERWAKILAN,NM_KNT_PERWAKILAN from m_kantor_perwakilan where ID_KNT_PERWAKILAN >1 order by NM_KNT_PERWAKILAN");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[ID_KNT_PERWAKILAN]>$r[NM_KNT_PERWAKILAN]</option>";
            }
    echo "</select></td></tr>
	      <tr><td  >Status Rantor</td>  <td > : 
          <select name='ID_ST_RANTOR' >
            <option value=0 selected>- ALL -</option>
			<option value=1 > Import </option>
			<option value=2 > Beli </option>
			<option value=3 > Jual </option>
		   </select></td></tr>
		  <tr ><th colspan = 2><div align=left>Periode</div></th></tr>
		  <tr><td>Dari</td><td><DIV id=\"tgl\"> <script>DateInput('TGL_AWAL', true, 'YYYY-MM-DD')</script></div></td></tr>
		  <tr><td>Sampai Dengan</td><td><DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR', true, 'YYYY-MM-DD')</script></div></td></tr>
		  
		  <tr><th colspan = 2><div align=right><input type=submit value=Generate> </div></th></tr>
		

		  </table></form>";



	break;
    case "generate":

session_start();

session_register("G_sql_lap");

$template = file("../template/canvasawal.htm");
$template = implode("",$template ); 

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){

	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";
	
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{

		
		$ID_KNT_PERWAKILAN = $_POST[ID_KNT_PERWAKILAN];   
		$ID_ST_RANTOR = $_POST[ID_ST_RANTOR]; 
	
		$TGL_AWAL = $_POST[TGL_AWAL]; 
		$TGL_AKHIR = $_POST[TGL_AKHIR]; 
		
		
		echo "<div align=center>
		<h2>LAPORAN REKAPITULASI RANTOR KANTOR PERWAKILAN</h2>
		 <input type=button value='Cetak' onclick=location.href='./aksi_test.php?' target=\"_blank\">";

	




//all
    	if ($ID_ST_RANTOR == '0'){ 
		$QWERYNYA = "select a.ID_KNT_PERWAKILAN,b.NM_KNT_PERWAKILAN,b.ALAMAT,a.NO_POLISI,  if(a.TGL_PERSETUJUAN is null,'IMPOR','BELI') as ST_ASAL,DATE_FORMAT(if(a.TGL_PERSETUJUAN is null,a.TGL_IZIN_IMPOR,a.TGL_PERSETUJUAN),'%d.%m.%Y') as TANGGAL_IZIN,if(a.TGL_PERSETUJUAN is null,a.NO_IZIN_IMPOR,a.NO_IZIN_BELI) as NO_IZIN ,if(a.TGL_IZIN_JUAL is null,'DIGUNAKAN','DIJUAL') as ST_KENDARAAN  from  penggunaan_fasilitas a  left join m_kantor_perwakilan b on a.ID_KNT_PERWAKILAN = b.ID_KNT_PERWAKILAN where a.ID_DIPLOMAT= 1 and a.ID_JNS_FASILITAS = 1  AND (a.ST_PERSETUJUAN = 2)  and ( (a.TGL_PERSETUJUAN  between '$TGL_AWAL' and '$TGL_AKHIR') or (a.TGL_IZIN_IMPOR between '$TGL_AWAL' and '$TGL_AKHIR') or (a.TGL_IZIN_JUAL between '$TGL_AWAL' and '$TGL_AKHIR')) AND";
		}

//import
		if ($ID_ST_RANTOR == '1'){
		
		 
		$QWERYNYA = "select a.ID_KNT_PERWAKILAN,b.NM_KNT_PERWAKILAN,b.ALAMAT,a.NO_POLISI,  if(a.TGL_PERSETUJUAN is null,'IMPOR','BELI') as ST_ASAL,DATE_FORMAT(if(a.TGL_PERSETUJUAN is null,a.TGL_IZIN_IMPOR,a.TGL_PERSETUJUAN),'%d.%m.%Y') as TANGGAL_IZIN,if(a.TGL_PERSETUJUAN is null,a.NO_IZIN_IMPOR,a.NO_IZIN_BELI) as NO_IZIN ,if(a.TGL_IZIN_JUAL is null,'DIGUNAKAN','DIJUAL') as ST_KENDARAAN  from  penggunaan_fasilitas a  left join m_kantor_perwakilan b on a.ID_KNT_PERWAKILAN = b.ID_KNT_PERWAKILAN where a.ID_DIPLOMAT= 1 and a.ID_JNS_FASILITAS = 1  AND (a.ST_PERSETUJUAN = 2)   and (a.TGL_PERSETUJUAN is null)  and ( (a.TGL_IZIN_IMPOR between '$TGL_AWAL' and '$TGL_AKHIR')) AND";
		}
	
//beli
    	if ($ID_ST_RANTOR == '2'){ 
		
		$QWERYNYA = "select a.ID_KNT_PERWAKILAN,b.NM_KNT_PERWAKILAN,b.ALAMAT,a.NO_POLISI,  if(a.TGL_PERSETUJUAN is null,'IMPOR','BELI') as ST_ASAL,DATE_FORMAT(if(a.TGL_PERSETUJUAN is null,a.TGL_IZIN_IMPOR,a.TGL_PERSETUJUAN),'%d.%m.%Y') as TANGGAL_IZIN,if(a.TGL_PERSETUJUAN is null,a.NO_IZIN_IMPOR,a.NO_IZIN_BELI) as NO_IZIN ,if(a.TGL_IZIN_JUAL is null,'DIGUNAKAN','DIJUAL') as ST_KENDARAAN  from  penggunaan_fasilitas a  left join m_kantor_perwakilan b on a.ID_KNT_PERWAKILAN = b.ID_KNT_PERWAKILAN where a.ID_DIPLOMAT= 1 and a.ID_JNS_FASILITAS = 1  AND (a.ST_PERSETUJUAN = 2) and (a.TGL_PERSETUJUAN is not null) and ( (a.TGL_PERSETUJUAN  between '$TGL_AWAL' and '$TGL_AKHIR')) AND";
	
		}

//jual
		if ($ID_ST_RANTOR == '3'){
		
		$QWERYNYA = "select a.ID_KNT_PERWAKILAN,b.NM_KNT_PERWAKILAN,b.ALAMAT,a.NO_POLISI,  if(a.TGL_PERSETUJUAN is null,'IMPOR','BELI') as ST_ASAL,DATE_FORMAT(if(a.TGL_PERSETUJUAN is null,a.TGL_IZIN_IMPOR,a.TGL_PERSETUJUAN),'%d.%m.%Y') as TANGGAL_IZIN,if(a.TGL_PERSETUJUAN is null,a.NO_IZIN_IMPOR,a.NO_IZIN_BELI) as NO_IZIN ,if(a.TGL_IZIN_JUAL is null,'DIGUNAKAN','DIJUAL') as ST_KENDARAAN,a.TGL_IZIN_JUAL,a.NO_IZIN_JUAL,a.NAMA_PEMBELI   from  penggunaan_fasilitas a  left join m_kantor_perwakilan b on a.ID_KNT_PERWAKILAN = b.ID_KNT_PERWAKILAN where a.ID_DIPLOMAT= 1 and a.ID_JNS_FASILITAS = 1  AND (a.ST_PERSETUJUAN = 2) and (a.TGL_IZIN_JUAL is not null)   and ( (a.TGL_PERSETUJUAN  between '$TGL_AWAL' and '$TGL_AKHIR') or (a.TGL_IZIN_IMPOR between '$TGL_AWAL' and '$TGL_AKHIR') or (a.TGL_IZIN_JUAL between '$TGL_AWAL' and '$TGL_AKHIR')) AND";
		
		  echo "<table width=100% >
          <tr><th width=30>no</th><th width=150 >Kantor Perwakilan</th><th  width=60>NOPOL</th><th  width=35>ASAL</th> <th  width=60>TGL IZIN JUAL</th><th  width=60>NO IZIN JUAL</th><th width=80>PEMBELI</th></tr>";
		}else
		{
		  echo "<table width=700 >
          <tr><th width=30>no</th><th width=150 >Kantor Perwakilan</th><th  width=60>NOPOL</th><th  width=35>ASAL</th> <th  width=50>TGL IZIN</th><th  width=40>NO IZIN</th><th width=60>STATUS</th></tr>";
		}
		

	if ($ID_KNT_PERWAKILAN == '1'){
		$QWERYNYA = $QWERYNYA." b.ID_KNT_PERWAKILAN <> 1 ";
		}else{
		$QWERYNYA = $QWERYNYA." b.ID_KNT_PERWAKILAN = $ID_KNT_PERWAKILAN ";
		}



    $QWERYNYA = $QWERYNYA." ORDER BY a.ID_KNT_PERWAKILAN ,TANGGAL_IZIN ";

   // echo $QWERYNYA;
   	
	$_SESSION[G_sql_lap] = $QWERYNYA;

    $tampil=mysql_query($QWERYNYA);
   
    $no = 1;
	$xxx= "9999999";
    while($r=mysql_fetch_array($tampil)){

      echo "<tr><td>$no</td>";
	  if ($xxx != $r[ID_KNT_PERWAKILAN]) {
	  echo "<td>$r[NM_KNT_PERWAKILAN]</td>";
	  	  }else {
	  echo "<td></td>";
	  }
	
	  $xxx = $r[ID_KNT_PERWAKILAN];
	  echo "    <td>$r[NO_POLISI]</td>	
				<td>$r[ST_ASAL]</td>";
				
		
	if ($ID_ST_RANTOR == '3'){
		echo "  <td>$r[TGL_IZIN_JUAL]</td>	
				<td>$r[NO_IZIN_JUAL]</td>		
				<td>$r[NAMA_PEMBELI]</td>	
		        </tr>";
	
	}else{
		echo "  <td>$r[TANGGAL_IZIN]</td>	
				<td>$r[NO_IZIN]</td>		
				<td>$r[ST_KENDARAAN]</td>	
		        </tr>";
		}

		$no++;  
    }
    echo "</table></div>";

    break;



}
		
}
?>
