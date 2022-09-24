<?php
switch($_GET[act]){
  // Tampil Berita
  default:
		
		echo "<h2>Detil Kuota Staff Perwakilan Asing </h2> 
			
		<!--Pencarian :--> <form method=get action='./aksi_quota.php?&act=editquotastaff?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='detil_quota_miras_pwk'>
				 <input type=hidden name=negara value='$_GET[negara]'>
			Nama Perwakilan Asing : <input type=text name=\"kantorperwakilan\"> <input type=submit value=Cari>
			</form> <br>";
                        
                        
                        
                        
                        //edit andri 14092016 tambah if user bukan miras maka tombol tambah jadi muncul
                       
                        
                        
                        if ($_SESSION[G_leveluser]!=13){
			echo"<input type=button value='Tambah' onclick=location.href='?module=detil_quota_miras_staff&act=tambahquota'>";
                        }
		  echo"<table width=100%>
                <th width=8>no</th>
		  		<th width=200>Kantor Perwakilan</th>
				<th width=120>Rank Diplomatik</th>
		  		<th width=120>Produk Miras</th>
				<th width=85>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

	$tampil1=("select *
from 
(
SELECT id_kuota_staff,
				a.ID_KNT_PERWAKILAN,
				b.NM_KNT_PERWAKILAN,
				a.id_negara,
				c.NEGARA,
				a.ID_RANK,
				d.NM_RANK,
				a.id_produk,
				e.nama_produk,
				a.tahun,
				a.kuota_tahun,
				a.kuota_triwulan1,
				a.kuota_triwulan2,
				a.kuota_triwulan3,
				a.kuota_triwulan4	

				from tbl_kuota_staff a INNER JOIN
				m_kantor_perwakilan b on a.id_knt_perwakilan=b.ID_KNT_PERWAKILAN INNER JOIN
				m_negara c on a.id_negara=c.ID_NEGARA inner JOIN
				rank d on a.id_rank=d.ID_RANK INNER JOIN
				tbl_produk_miras e on a.id_produk=e.id_produk


UNION

SELECT id_kuota_staff,
				'all' ID_KNT_PERWAKILAN,
				'all' NM_KNT_PERWAKILAN,
				a.id_negara,
				'' NEGARA,
				a.ID_RANK,
				 f.NM_RANK,
				a.id_produk,
				e.nama_produk,
				a.tahun,
				a.kuota_tahun,
				a.kuota_triwulan1,
				a.kuota_triwulan2,
				a.kuota_triwulan3,
				a.kuota_triwulan4	
from 		tbl_kuota_staff a INNER JOIN
				rank f on a.id_rank=f.ID_RANK inner join
				tbl_produk_miras e on a.id_produk=e.id_produk
where a.id_knt_perwakilan='all' and a.id_rank<>'staff'
UNION

SELECT id_kuota_staff,
				'all' ID_KNT_PERWAKILAN,
				'all' NM_KNT_PERWAKILAN,
				a.id_negara,
				'' NEGARA,
				a.ID_RANK,
				 'staff' NM_RANK,
				a.id_produk,
				e.nama_produk,
				a.tahun,
				a.kuota_tahun,
				a.kuota_triwulan1,
				a.kuota_triwulan2,
				a.kuota_triwulan3,
				a.kuota_triwulan4	
from 		tbl_kuota_staff a INNER JOIN
			
				tbl_produk_miras e on a.id_produk=e.id_produk
where a.id_knt_perwakilan='all' and a.id_rank ='staff'
)a					
			
			");
	
	$tampil=mysql_query($tampil1);
    $no = $posisi+1;  
    while($r=mysql_fetch_array($tampil)){

		
    echo "	<tr><td>$no</td>
			<td>$r[NM_KNT_PERWAKILAN]</td>
			<td>$r[NM_RANK]</td>
			<td>$r[nama_produk]</td>
			";
                         if ($_SESSION[G_leveluser]==13){
                            echo "<td> <a href=?module=detil_quota_miras_staff&act=editquotastaff&idt=$r[ID_KNT_PERWAKILAN]&idproduk=$r[id_produk]&idrank=$r[ID_RANK]>Edit Quota Tertentu</a>"; 
                        }else {
                            echo"<td><a href=?module=detil_quota_miras_staff&act=editquotastaff&idt=$r[ID_KNT_PERWAKILAN]>Edit</a> | 
                            <a href=./detil_quota_miras_staff.php?module=kantor&act=hapus&idt=$r[ID_KNT_PERWAKILAN] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NM_KNT_PERWAKILAN] ?')\">Hapus</a></td></tr>";
                        }
      $no++;
    }
    echo "</table>";
    $tampil1=("select *
from 
(
SELECT id_kuota_staff,
				a.ID_KNT_PERWAKILAN,
				b.NM_KNT_PERWAKILAN,
				a.id_negara,
				c.NEGARA,
				a.ID_RANK,
				d.NM_RANK,
				a.id_produk,
				e.nama_produk,
				a.tahun,
				a.kuota_tahun,
				a.kuota_triwulan1,
				a.kuota_triwulan2,
				a.kuota_triwulan3,
				a.kuota_triwulan4	

				from tbl_kuota_staff a INNER JOIN
				m_kantor_perwakilan b on a.id_knt_perwakilan=b.ID_KNT_PERWAKILAN INNER JOIN
				m_negara c on a.id_negara=c.ID_NEGARA inner JOIN
				rank d on a.id_rank=d.ID_RANK INNER JOIN
				tbl_produk_miras e on a.id_produk=e.id_produk


UNION

SELECT id_kuota_staff,
				'all' ID_KNT_PERWAKILAN,
				'all' NM_KNT_PERWAKILAN,
				a.id_negara,
				'' NEGARA,
				a.ID_RANK,
				 f.NM_RANK,
				a.id_produk,
				e.nama_produk,
				a.tahun,
				a.kuota_tahun,
				a.kuota_triwulan1,
				a.kuota_triwulan2,
				a.kuota_triwulan3,
				a.kuota_triwulan4	
from 		tbl_kuota_staff a INNER JOIN
				rank f on a.id_rank=f.ID_RANK inner join
				tbl_produk_miras e on a.id_produk=e.id_produk
where a.id_knt_perwakilan='all' and a.id_rank<>'staff'
UNION

SELECT id_kuota_staff,
				'all' ID_KNT_PERWAKILAN,
				'all' NM_KNT_PERWAKILAN,
				a.id_negara,
				'' NEGARA,
				a.ID_RANK,
				 'staff' NM_RANK,
				a.id_produk,
				e.nama_produk,
				a.tahun,
				a.kuota_tahun,
				a.kuota_triwulan1,
				a.kuota_triwulan2,
				a.kuota_triwulan3,
				a.kuota_triwulan4	
from 		tbl_kuota_staff a INNER JOIN
			
				tbl_produk_miras e on a.id_produk=e.id_produk
where a.id_knt_perwakilan='all' and a.id_rank ='staff'
)a					
			where NM_KNT_PERWAKILAN like '%" .$_GET[kantorperwakilan]."%'  and tahun=date('Y')
			
			");
  	$jmldata =mysql_num_rows(mysql_query($tampil1));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
	$ilink = "?module=detil_quota_miras_staff"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
    echo "<div id=paging>$linkHalaman</div><br>";
    break;
  
  case "tambahquota":
  	$idt = $_GET[idt];
  	$edit = mysql_query("select a.ID_KNT_PERWAKILAN,a.NM_KNT_PERWAKILAN,b.ID_NEGARA,b.NEGARA from m_kantor_perwakilan a
INNER JOIN m_negara b on a.ID_NEGARA=b.ID_NEGARA where ID_KNT_PERWAKILAN = $idt ");
  	
  	$r    = mysql_fetch_array($edit);
    echo "<h2>Tambah Quota Perwakilan Tertentu</h2>
          <form method=POST action='./aksi_quota.php?module=detil_quota_miras_staff&act=input' enctype='multipart/form-data'>
          	<input type=hidden name=idt value='$r[ID_KNT_PERWAKILAN]'>
          	<input type=hidden name=tahun value='$r[tahun]'>
          	<table width=90%>
			<tr><td width=120>Kantor Perwakilan</td >  <td > : <input type=text name='nm_knt_perwakilan' value='$r[NM_KNT_PERWAKILAN]' size=50></tr>
			<tr><td width=120>Negara</td >  <td > : <input type=text name='nm_negara' value='$r[NEGARA]' size=50></tr>
			<tr><td  width=120>Produk</td>  <td colspan=\"2\"> : 
         		<select name='id_produk' >
            	<option value=0 selected>- Pilih Jenis Produk -</option>";
            	$tampil=mysql_query("SELECT * FROM tbl_produk_miras ORDER BY id_produk");
           			 	while($r=mysql_fetch_array($tampil)){
              				echo "<option value=$r[id_produk]>$r[nama_produk]</option>";
            			}echo "</select></td></tr>
			<tr><td>Quota Per Tahun</td >  <td > : <input type=text name='email' size=10></td></tr>
			<tr><td>Triwulan I </td>     <td > : <input type=text name='kota' size=10></textarea></td></tr>
          	<tr><td>Triwulan II</td >  <td > : <input type=text name='kota' size=10></td></tr>
          	<tr><td>Triwulan III</td >  <td > : <input type=text name='telp' size=10></td></tr>
          	<tr><td>Triwulan IV</td >  <td > : <input type=text name='fax' size=10></td></tr>
            
		  	<tr><td></td><td align=right><input type=submit value=Simpan> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;   
   
  case "editquotastaff":
    $idt = $_GET[idt];
    $idproduk = $_GET[idproduk];
    $tahun_skr= date("Y");
    $idrank = $_GET[idrank];
  	$info= ("select  * from tbl_kuota_staff where id_knt_perwakilan= '$idt' and  id_produk = $idproduk order by tbl_kuota_staff.id_kuota_staff limit 1");
  	 
  	
  	$info2 =mysql_query($info);
  	$rs   =mysql_fetch_array($info2);
 	
   
 	  echo "<h2>Edit Quota Staff Tertentu</h2>
          <form method=POST action='./aksi_quota.php?module=detil_quota_miras_staff&act=editquotastaff' enctype='multipart/form-data'>";
          	if ($idt=='all') 
          	{
          		echo "<input type=hidden name=idt value='all'>
          			
          		     
          				<table width=90%>
			<tr><td width=120>Kantor Perwakilan</td >  <td > : <input type=text name=nm_knt_perwakilan value='all' size=50></tr>";
          	}
          	else 
          	{
          		$edit = mysql_query("select a.ID_KNT_PERWAKILAN,a.NM_KNT_PERWAKILAN,b.ID_NEGARA,b.NEGARA from m_kantor_perwakilan a
          				INNER JOIN m_negara b on a.ID_NEGARA=b.ID_NEGARA where ID_KNT_PERWAKILAN = $idt  ");
          		$r    = mysql_fetch_array($edit);
          	echo "<input type=hidden name='idt' value='$r[ID_KNT_PERWAKILAN]'>";
          	echo" <input type=hidden name='tahun_r' value='$tahun_r'>
          	          		
          	<table width=90%>
			<tr><td width=120>Kantor Perwakilan</td >  <td > : <input type=text name='nm_knt_perwakilan' value='$r[NM_KNT_PERWAKILAN]' size=50></tr>
          	";
          	}
          	echo "
          			<input type=hidden name=id_produk value='$r[id_produk]'>
          			
			<tr><td width=120>Negara</td >  <td > : <input type=text name='negara' value='$r[NEGARA]' size=50></tr>";
			
			if($rs[id_rank] == '1') {
			echo "
			
			<tr><td width=120>Rank</td >  <td > : <input type=text name='nm_rank' value='Duta Besar' size=50>
			";
			} else {
			echo "
			
			<tr><td width=120>Rank</td >  <td > : <input type=text name='nm_rank' value='Staff' size=50></tr>
			";
			}
			echo "<input type=hidden name='id_rank' value='$rs[id_rank]'>";
			echo "
			<tr><td  width=120>Produk</td>  <td colspan=\"2\"> : 
         		<select name='id_produk' >
            	<option value=0 >- Pilih Jenis Produk -</option>";
 	  			
            	$tampil=mysql_query("SELECT * FROM tbl_produk_miras where id_produk=$idproduk ");
           			 	while($r=mysql_fetch_array($tampil)){
              				echo "<option value=$r[id_produk] selected>$r[nama_produk] </option>";
            			}echo "</select></td></tr>";
            	
         	
 			
		echo "	<tr><td>Quota Per Tahun</td >  <td > : <input type=text name='quota_tahun' size=10  value='$rs[kuota_tahun]'></td></tr>
			<tr><td>Triwulan I </td>     <td > : <input type=text name='quota_tw1' size=10 value='$rs[kuota_triwulan1]'></textarea></td></tr>
          	<tr><td>Triwulan II</td >  <td > : <input type=text name='quota_tw2' size=10 value='$rs[kuota_triwulan2]'></td></tr>
          	<tr><td>Triwulan III</td >  <td > : <input type=text name='quota_tw3' size=10 value='$rs[kuota_triwulan3]'></td></tr>
          	<tr><td>Triwulan IV</td >  <td > : <input type=text name='quota_tw4' size=10 value='$rs[kuota_triwulan4]'></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Update> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;
   
}
?>
