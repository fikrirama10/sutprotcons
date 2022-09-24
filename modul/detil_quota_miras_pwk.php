<?php
switch($_GET[act]){
  // Tampil Berita
  default:
		
		echo "<h2>Detil Kuota Kantor Perwakilan Asing </h2> 
			
		<!--Pencarian :--> <form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='detil_quota_miras_pwk'>
				 <input type=hidden name=negara value='$_GET[negara]'>
			Nama Perwakilan Asing : <input type=text name=\"kantorperwakilan\"> <input type=submit value=Cari>
			</form> <br>";
                        
                        
                        
                        
                        //edit andri 14092016 tambah if user bukan miras maka tombol tambah jadi muncul
                       
                        
                        
                        if ($_SESSION[G_leveluser]!=13){
			echo"<input type=button value='Tambah' onclick=location.href='?module=detil_quota_miras_pwk&act=tambahquota'>";
                        }
		  echo"<table width=100%>
                                <tr>	<th width=8>no</th>
		  		<th width=200>Kantor Perwakilan</th>
				<th width=120>Produk Miras</th>
				
				<th width=85>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);
$tahun_r=date("Y");
	$tampil1=("select * 
				from 
				(select a.ID_KNT_PERWAKILAN,a.NM_KNT_PERWAKILAN,b.NEGARA,a.ALAMAT,a.TELP, c.id_produk,c.tahun,d.nama_produk
				from m_kantor_perwakilan a inner join m_negara b on a.ID_NEGARA=b.ID_NEGARA 
				inner join tbl_kuota_kantor c on a.ID_KNT_PERWAKILAN=c.id_knt_perwakilan 
				INNER JOIN tbl_produk_miras d on c.id_produk=d.id_produk
				
				where a.ID_KNT_PERWAKILAN > 0 and a.NM_KNT_PERWAKILAN like '%%' 
				
				
				UNION

				select ID_KNT_PERWAKILAN,'all','all','all','all',id_produk,tahun,
				 CASE id_produk
				   when '1'  then 'Sprit'
				   when '2'  then 'Anggur'
				   when '3'  then 'Rokok'
				  end as produk
				FROM
				tbl_kuota_kantor 
				where id_knt_perwakilan='all'
				)b
				where NM_KNT_PERWAKILAN like '%" .$_GET[kantorperwakilan]."%' and tahun = '".$tahun_r."'
			");
		
	$tampil=mysql_query($tampil1);
    $no = $posisi+1;  
    while($r=mysql_fetch_array($tampil)){

		
    echo "	<tr><td>$no</td>
			<td>$r[NM_KNT_PERWAKILAN]</td>
			<td>$r[nama_produk]</td>
			";
                         if ($_SESSION[G_leveluser]==13){
                            echo "<td> <a href=?module=detil_quota_miras_pwk&act=editquota&idt=$r[ID_KNT_PERWAKILAN]&idproduk=$r[id_produk]>Edit Quota Tertentu</a>"; 
                        }else {
                            echo"<td><a href=?module=detil_quota_miras_pwk&act=editquota&idt=$r[ID_KNT_PERWAKILAN]>Edit</a> | 
                            <a href=./aksi_kantor.php?module=kantor&act=hapus&idt=$r[ID_KNT_PERWAKILAN] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NM_KNT_PERWAKILAN] ?')\">Hapus</a></td></tr>";
                        }
      $no++;
    }
    echo "</table>";
    $tampil1=("select *
				from
				(select a.ID_KNT_PERWAKILAN,a.NM_KNT_PERWAKILAN,b.NEGARA,a.ALAMAT,a.TELP, c.id_produk,c.tahun,d.nama_produk
				from m_kantor_perwakilan a inner join m_negara b on a.ID_NEGARA=b.ID_NEGARA
				inner join tbl_kuota_kantor c on a.ID_KNT_PERWAKILAN=c.id_knt_perwakilan
				INNER JOIN tbl_produk_miras d on c.id_produk=d.id_produk
    
				where a.ID_KNT_PERWAKILAN > 0 and a.NM_KNT_PERWAKILAN like '%%'
    
    
				UNION
    
				select ID_KNT_PERWAKILAN,'all','all','all','all',id_produk,tahun,
				 CASE id_produk
				   when '1'  then 'Sprit'
				   when '2'  then 'Anggur'
				   when '3'  then 'Rokok'
				  end as produk
				FROM
				tbl_kuota_kantor
				where id_knt_perwakilan='all'
				)b 
    		where NM_KNT_PERWAKILAN like '%" .$_GET[kantorperwakilan]."%' and tahun = '" .$tahun_r."'
				
			");
  	$jmldata =mysql_num_rows(mysql_query($tampil1));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
	$ilink = "?module=detil_quota_miras_pwk"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
    echo "<div id=paging>$linkHalaman</div><br>";
    break;
  
  case "tambahquota":
  	$idt = $_GET[idt];
  	$edit = mysql_query("select a.ID_KNT_PERWAKILAN,a.NM_KNT_PERWAKILAN,b.ID_NEGARA,b.NEGARA from m_kantor_perwakilan a
INNER JOIN m_negara b on a.ID_NEGARA=b.ID_NEGARA where ID_KNT_PERWAKILAN = $idt ");
  	
  	$r    = mysql_fetch_array($edit);
    echo "<h2>Tambah Quota Perwakilan Tertentu</h2>
          <form method=POST action='./aksi_quota.php?module=detil_quota_miras_pwk&act=input' enctype='multipart/form-data'>
          	<input type=hidden name=idt value='$r[ID_KNT_PERWAKILAN]'>
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
			<tr><td>Quota Per Tahun</td >  <td > : <input type=text name='quota_tahun' size=10></td></tr>
			<tr><td>Triwulan I </td>     <td > : <input type=text name='quota_tw1' size=10></textarea></td></tr>
          	<tr><td>Triwulan II</td >  <td > : <input type=text name='quota_tw2' size=10></td></tr>
          	<tr><td>Triwulan III</td >  <td > : <input type=text name='quota_tw3' size=10></td></tr>
          	<tr><td>Triwulan IV</td >  <td > : <input type=text name='quota_tw4' size=10></td></tr>
            
		  	<tr><td></td><td align=right><input type=submit value=Simpan> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;   
   
  case "editquota":
    $idt = $_GET[idt];
    $idproduk = $_GET[idproduk];
  
  	$info= ("select  * from tbl_kuota_kantor  where id_knt_perwakilan= '$idt' and  id_produk = $idproduk order by tbl_kuota_kantor.id_kuota_kantor limit 1");
  	 
  	
  	$info2 =mysql_query($info);
  	$rs   =mysql_fetch_array($info2);
 	
   
 	  echo "<h2>Edit Quota Perwakilan Tertentu</h2>
          <form method=POST action='./aksi_quota.php?module=detil_quota_miras_pwk&act=editquota' enctype='multipart/form-data'>";
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
          	echo "<input type=hidden name='idt' value='$r[ID_KNT_PERWAKILAN]'>
          	<table width=90%>
			<tr><td width=120>Kantor Perwakilan</td >  <td > : <input type=text name='nm_knt_perwakilan' value='$r[NM_KNT_PERWAKILAN]' size=50></tr>
          	";
          	}
          	echo "
          	<input type=hidden name=idt value='$r[ID_KNT_PERWAKILAN]'>
			<tr><td width=120>Negara</td >  <td > : <input type=text name='nm_negara' value='$r[NEGARA]' size=50></tr>
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
