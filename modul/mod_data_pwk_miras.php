<?php
switch($_GET[act]){
  // Tampil Berita
  default:
		
		echo "<h2>Master Kantor Perwakilan </h2> 
		<!--Pencarian :--> <form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='kantor_miras'>
				 <input type=hidden name=negara value='$_GET[negara]'>
			Nama Perwakilan : <input type=text name=\"kantorperwakilan\"> <input type=submit value=Cari>
			</form> <br>";
                        //edit andri 14092016 tambah if user bukan miras maka tombol tambah jadi muncul
                        //if ($_SESSION[G_leveluser]!=13){
			//echo"<input type=button value='Tambah' onclick=location.href='?module=kantor_miras&act=tambahkantor'>";
                        //}
		  echo"<table width=100%>
                                <tr>	<th width=8>no</th>
		  		<th width=200>Kantor Perwakilan</th>
				<th width=120>Negara</th>
				<th width=150>Alamat</th>
				<th width=50>Telp</th>
				<th width=85>AKSI</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

	$tampil=mysql_query("select  a.ID_KNT_PERWAKILAN,a.NM_KNT_PERWAKILAN,b.NEGARA,a.ALAMAT,a.TELP
			from m_kantor_perwakilan a left join m_negara b on a.ID_NEGARA=b.ID_NEGARA 
			where a.ID_KNT_PERWAKILAN > 0 and  a.NM_KNT_PERWAKILAN like '%".$_GET[kantorperwakilan]."%' 
			order by a.NM_KNT_PERWAKILAN ASC limit $posisi,$batas");
	
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

		
    echo "	<tr><td>$no</td>
			<td>$r[NM_KNT_PERWAKILAN]</td>
			<td>$r[NEGARA]</td>
			<td>$r[ALAMAT]</td>
			<td>$r[TELP]</td>";
                         if ($_SESSION[G_leveluser]==13){
                            echo "<td><a href=?module=kantor_miras&act=kelola_pengajuan&idt=$r[ID_KNT_PERWAKILAN]&negara=$_GET[negara]>Kelola Pengajuan</a>"; 
                        }
      $no++;
    }
    echo "</table>";
  	$jmldata =mysql_num_rows(mysql_query("SELECT NM_KNT_PERWAKILAN FROM  m_kantor_perwakilan where ID_KNT_PERWAKILAN > 0"));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
	$ilink = "?module=kantor_miras"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
    echo "<div id=paging>$linkHalaman</div><br>";
    break;
 //--------------------------------------------------------------------------------- 
case "kelola_pengajuan":
    $idt = $_GET[idt];
    $id_pengajuan[id_pengajuan];
    $cr = $_POST[cr];

    $edit = mysql_query("select  a.ID_KNT_PERWAKILAN,a.ID_NEGARA,a.ID_JNS_PERWAKILAN,a.NM_KNT_PERWAKILAN,b.NEGARA,a.ALAMAT,a.KOTA,a.TELP,a.FAX,a.EMAIL,a.WEB,a.KET,a.KODE_AGENDA, c.NM_JNS_PERWAKILAN from m_kantor_perwakilan a left join m_negara b on a.ID_NEGARA=b.ID_NEGARA left join m_jns_perwakilan c on a.ID_JNS_PERWAKILAN = c.ID_JNS_PERWAKILAN where a.ID_KNT_PERWAKILAN = $idt");
       
    $r    = mysql_fetch_array($edit);
echo "<h2>Bebas Bea Bagi <u>$r[NM_KNT_PERWAKILAN]</u></h2>
<form id='kelola_pengajuan' method=POST enctype='multipart/form-data' action='./deplu.php?module=kantor_miras&act=kelola_pengajuan&idt=$idt'></form>
    <input type=hidden name=idt value='$r[ID_KNT_PERWAKILAN]'>                  
    <table width=100%>
        <tr><td  width=15%><b/>Negara &nbsp;</td>  <td colspan=\"2\"> : $r[NEGARA]</td>"
        . "<td><b/>Telp/Fax &nbsp; </td><td>: $r[TELP] / $r[FAX]</td>"
        . "</tr><tr><td><b/>Nama Perwakilan &nbsp; </td >     "
        . "<td colspan=\"2\">  : $r[NM_KNT_PERWAKILAN]</td>"
        . "<td><b/>Website</td><td> : $r[WEB]</td>"
        . "<tr><td><b/>Jenis Perwakilan &nbsp;  </td >     <td colspan=\"2\"> : $r[NM_JNS_PERWAKILAN]</td>"
        . "<td><b/>Email &nbsp; </td >     <td > : $r[EMAIL]</tr>"
        . "<tr><td><b/>Alamat &nbsp;</td><td colspan=\"2\" width=38%> : $r[ALAMAT]</td>"
        . "<td width=9%><b/>Keterangan &nbsp; </td><td width=38%> : $r[KET]</td></tr>"
        . "<tr><td><b/>Kota &nbsp; </td>     <td colspan=\"2\"> : $r[KOTA]</td>"
        . "<td><b/>Kode Agenda &nbsp;</td >     <td> : $r[KODE_AGENDA]</td></tr>"
  . "</table>"
  . "<hr>";

$thn=  date(Y); 

$carispirit = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=1");

WHILE ($cr=mysql_fetch_array($carispirit)){
        if ($r[ID_NEGARA] == $cr[id_negara] && $r[ID_KNT_PERWAKILAN] == $cr[id_knt_perwakilan]){
        $id = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=1 and id_negara=$r[ID_NEGARA] and id_knt_perwakilan=$r[ID_KNT_PERWAKILAN]");
        $ar=mysql_fetch_array($id);        
        $id_kuota_spirit=$ar[id_kuota_kantor];         
    }
}
if ($id_kuota_spirit == Null){
        $carispirit = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=1");
        WHILE ($cr=mysql_fetch_array($carispirit)){
            if ($r[ID_NEGARA] == $cr[id_negara] && $r[ID_KNT_PERWAKILAN] != $cr[id_knt_perwakilan]){
            $id = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=1 and id_negara=$r[ID_NEGARA] and id_knt_perwakilan='all'");
            $ar=mysql_fetch_array($id);        
            $id_kuota_spirit=$ar[id_kuota_kantor]; 
            }
        }
    }
if ($id_kuota_spirit == Null){
        $carispirit = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=1");
        WHILE ($cr=mysql_fetch_array($carispirit)){
            if ($r[ID_NEGARA] != $cr[id_negara] && $r[ID_KNT_PERWAKILAN] != $cr[id_knt_perwakilan]){
            $id = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=1 and id_negara='all' and id_knt_perwakilan='all'");
            $ar=mysql_fetch_array($id);        
            $id_kuota_spirit=$ar[id_kuota_kantor]; 
            }
        }
    }

$carianggur = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=2");
while($dr=mysql_fetch_array($carianggur)){
    if ($r[ID_NEGARA] == $dr[id_negara] && $r[ID_KNT_PERWAKILAN] == $dr[id_knt_perwakilan]){
        $idr = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=2 and id_negara=$r[ID_NEGARA] and id_knt_perwakilan=$r[ID_KNT_PERWAKILAN]");
        $arr=mysql_fetch_array($idr);        
        $id_kuota_anggur=$arr[id_kuota_kantor];         
    }
}
if ($id_kuota_anggur == Null){
        $carianggur = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=2");
        while($dr=mysql_fetch_array($carianggur)){
            if ($r[ID_NEGARA] == $dr[id_negara] && $r[ID_KNT_PERWAKILAN] != $dr[id_knt_perwakilan]){
            $idr = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=2 and id_negara=$r[ID_NEGARA] and id_knt_perwakilan='all'");
            $arr=mysql_fetch_array($idr);        
            $id_kuota_anggur=$arr[id_kuota_kantor];
            }
        }
    }
if ($id_kuota_anggur == Null){
        $carianggur = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=2");
        while($dr=mysql_fetch_array($carianggur)){
            if ($r[ID_NEGARA] != $dr[id_negara] && $r[ID_KNT_PERWAKILAN] != $dr[id_knt_perwakilan]){
            $idr = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=2 and id_negara='all' and id_knt_perwakilan='all'");
            $arr=mysql_fetch_array($idr);        
            $id_kuota_anggur=$arr[id_kuota_kantor];
            }
        }
    }
    
$carirokok = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=3");
while($rk=mysql_fetch_array($carirokok)){
    if ($r[ID_NEGARA] == $rk[id_negara] && $r[ID_KNT_PERWAKILAN] == $rk[id_knt_perwakilan]){
        $idk = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=3 and id_negara=$r[ID_NEGARA] and id_knt_perwakilan=$r[ID_KNT_PERWAKILAN]");
        $ark=mysql_fetch_array($idk);        
        $id_kuota_rokok=$ark[id_kuota_kantor];         
    }
}
if ($id_kuota_rokok == Null){
    $carirokok = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=3");
    while($rk=mysql_fetch_array($carirokok)){
         if ($r[ID_NEGARA] == $rk[id_negara] && $r[ID_KNT_PERWAKILAN] != $rk[id_knt_perwakilan]){
         $idk = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=3 and id_negara=$r[ID_NEGARA] and id_knt_perwakilan='all'");
         $ark=mysql_fetch_array($idk);        
         $id_kuota_rokok=$ark[id_kuota_kantor];
            }
        }
    }
if ($id_kuota_rokok == Null){
    $carirokok = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=3");
    while($rk=mysql_fetch_array($carirokok)){
         if ($r[ID_NEGARA] != $rk[id_negara] && $r[ID_KNT_PERWAKILAN] != $rk[id_knt_perwakilan]){
         $idk = mysql_query("select * from tbl_kuota_kantor where tahun=$thn and id_produk=3 and id_negara='all' and id_knt_perwakilan='all'");
         $ark=mysql_fetch_array($idk);        
         $id_kuota_rokok=$ark[id_kuota_kantor];
            }
        }
    }
//$r[ID_NEGARA], $r[ID_KNT_PERWAKILAN], $id_kuota_spirit, $id_kuota_anggur, $id_kuota_rokok
echo "<table width=100%>
<tr>
<td colspan=5><b>Kuota Per Triwulan Pada Tahun : $thn</b></td>
</tr>
<tr>
<td align=left>
Triwulan I <br/>";
if ($id_kuota_spirit==''){
    $hasil_tw=0;
    echo"<b><font color='red'>Peringatan!!</font> : Kuota tahun ini belum di set</b><br/>";
    echo"<script type='text/javascript'>
                        alert('Peringatan!! : Kuota tahun ini belum di set, silahkan lakukan setting di menu Set Kuota');  
                    </script>"; 
}else{
$twl=mysql_query("select * from tbl_kuota_kantor where id_kuota_kantor=$id_kuota_spirit");
$hasil_tw    = mysql_fetch_array($twl);
}
$spirit1=$hasil_tw[kuota_triwulan1];

if ($id_kuota_anggur==''){
    $hasil_twn=0;
}else{
$twln=mysql_query("select * from tbl_kuota_kantor where id_kuota_kantor=$id_kuota_anggur");
$hasil_twn    = mysql_fetch_array($twln);
}
$ang1=$hasil_twn [kuota_triwulan1];

if ($id_kuota_rokok==''){
    $hasil_twk=0;
}else{
$twlk=mysql_query("select * from tbl_kuota_kantor where id_kuota_kantor=$id_kuota_rokok");
$hasil_twk    = mysql_fetch_array($twlk);
}
$rkk1=$hasil_twk[kuota_triwulan1];

$kuota_sp_terpakai1 =  mysql_query("select sum(jumlah) as jumlah from v_total_pengajuan_miras_kantor where id_knt_perwakilan=$idt and id_produk=1 and triwulan=1 and tahun=$thn");
$hsl_kuota_sp_terpakai1    = mysql_fetch_array($kuota_sp_terpakai1);
if($hsl_kuota_sp_terpakai1[jumlah] == Null){
    $hsl_kuota_sp_terpakai1[jumlah]=0;
}
$sisakuota_s1=$spirit1-$hsl_kuota_sp_terpakai1[jumlah];
echo"Batas Spirit : $spirit1 | terpakai : $hsl_kuota_sp_terpakai1[jumlah] | sisa $sisakuota_s1  <br/>";


$kuota_ag_terpakai1 =  mysql_query("select sum(jumlah) as jumlah from v_total_pengajuan_miras_kantor where id_knt_perwakilan=$idt and id_produk=2 and triwulan=1 and tahun=$thn");
$hsl_kuota_ag_terpakai1    = mysql_fetch_array($kuota_ag_terpakai1);
if($hsl_kuota_ag_terpakai1[jumlah] == Null){
    $hsl_kuota_ag_terpakai1[jumlah]=0;
}
$sisakuota_a1=$ang1-$hsl_kuota_ag_terpakai1[jumlah];
echo"Batas Anggur : $ang1 | terpakai : $hsl_kuota_ag_terpakai1[jumlah] | sisa $sisakuota_a1  <br/>";


$kuota_rk_terpakai1 =  mysql_query("select sum(jumlah) as jumlah from v_total_pengajuan_miras_kantor where id_knt_perwakilan=$idt and id_produk=3 and triwulan=1 and tahun=$thn");
$hsl_kuota_rk_terpakai1    = mysql_fetch_array($kuota_rk_terpakai1);
if($hsl_kuota_rk_terpakai1[jumlah] == Null){
    $hsl_kuota_rk_terpakai1[jumlah]=0;
}
$sisakuota_r1=$rkk1-$hsl_kuota_rk_terpakai1[jumlah];
echo"Batas Rokok : $rkk1 | terpakai : $hsl_kuota_rk_terpakai1[jumlah] | sisa $sisakuota_r1  <br/>";

echo"</td>
<td align=left>
Triwulan II <br/>";

$spirit2=$hasil_tw[kuota_triwulan2];
$ang2=$hasil_twn [kuota_triwulan2];
$rkk2=$hasil_twk[kuota_triwulan2];

$kuota_sp_terpakai2 =  mysql_query("select sum(jumlah) as jumlah from v_total_pengajuan_miras_kantor where id_knt_perwakilan=$idt and id_produk=1 and triwulan=2 and tahun=$thn");
$hsl_kuota_sp_terpakai2    = mysql_fetch_array($kuota_sp_terpakai2);
if($hsl_kuota_sp_terpakai2[jumlah] == Null){
    $hsl_kuota_sp_terpakai2[jumlah]=0;
}
$sisakuota_s2=$spirit2-$hsl_kuota_sp_terpakai2[jumlah];
echo"Batas Spirit : $spirit2 | terpakai : $hsl_kuota_sp_terpakai2[jumlah] | sisa $sisakuota_s2  <br/>";

$kuota_ag_terpakai2 =  mysql_query("select sum(jumlah) as jumlah from v_total_pengajuan_miras_kantor where id_knt_perwakilan=$idt and id_produk=2 and triwulan=2 and tahun=$thn");
$hsl_kuota_ag_terpakai2    = mysql_fetch_array($kuota_ag_terpakai2);
if($hsl_kuota_ag_terpakai2[jumlah] == Null){
    $hsl_kuota_ag_terpakai2[jumlah]=0;
}
$sisakuota_a2=$ang2-$hsl_kuota_ag_terpakai2[jumlah];
echo"Batas Anggur : $ang2 | terpakai : $hsl_kuota_ag_terpakai2[jumlah] | sisa $sisakuota_a2  <br/>";

$kuota_rk_terpakai2 =  mysql_query("select sum(jumlah) as jumlah from v_total_pengajuan_miras_kantor where id_knt_perwakilan=$idt and id_produk=3 and triwulan=2 and tahun=$thn");
$hsl_kuota_rk_terpakai2    = mysql_fetch_array($kuota_rk_terpakai2);
if($hsl_kuota_rk_terpakai2[jumlah] == Null){
    $hsl_kuota_rk_terpakai2[jumlah]=0;
}
$sisakuota_r2=$rkk2-$hsl_kuota_rk_terpakai2[jumlah];
echo"Batas Rokok : $rkk2 | terpakai : $hsl_kuota_rk_terpakai2[jumlah] | sisa $sisakuota_r2  <br/>";

echo"</td>
<td align=left>
Triwulan III <br/>";
$spirit3=$hasil_tw[kuota_triwulan3];
$ang3=$hasil_twn [kuota_triwulan3];
$rkk3=$hasil_twk[kuota_triwulan3];

$kuota_sp_terpakai3 =  mysql_query("select sum(jumlah) as jumlah from v_total_pengajuan_miras_kantor where id_knt_perwakilan=$idt and id_produk=1 and triwulan=3 and tahun=$thn");
$hsl_kuota_sp_terpakai3    = mysql_fetch_array($kuota_sp_terpakai3);
if($hsl_kuota_sp_terpakai3[jumlah] == Null){
    $hsl_kuota_sp_terpakai3[jumlah]=0;
}
$sisakuota_s3=$spirit3-$hsl_kuota_sp_terpakai3[jumlah];
echo"Batas Spirit : $spirit3 | terpakai : $hsl_kuota_sp_terpakai3[jumlah] | sisa $sisakuota_s3  <br/>";

$kuota_ag_terpakai3 =  mysql_query("select sum(jumlah) as jumlah from v_total_pengajuan_miras_kantor where id_knt_perwakilan=$idt and id_produk=2 and triwulan=3 and tahun=$thn");
$hsl_kuota_ag_terpakai3    = mysql_fetch_array($kuota_ag_terpakai3);
if($hsl_kuota_ag_terpakai3[jumlah] == Null){
    $hsl_kuota_ag_terpakai3[jumlah]=0;
}
$sisakuota_a3=$ang3-$hsl_kuota_ag_terpakai3[jumlah];
echo"Batas Anggur : $ang3 | terpakai : $hsl_kuota_ag_terpakai3[jumlah] | sisa $sisakuota_a3  <br/>";

$kuota_rk_terpakai3 =  mysql_query("select sum(jumlah) as jumlah from v_total_pengajuan_miras_kantor where id_knt_perwakilan=$idt and id_produk=3 and triwulan=2 and tahun=$thn");
$hsl_kuota_rk_terpakai3    = mysql_fetch_array($kuota_rk_terpakai3);
if($hsl_kuota_rk_terpakai3[jumlah] == Null){
    $hsl_kuota_rk_terpakai3[jumlah]=0;
}
$sisakuota_r3=$rkk3-$hsl_kuota_rk_terpakai3[jumlah];
echo"Batas Rokok : $rkk3 | terpakai : $hsl_kuota_rk_terpakai3[jumlah] | sisa $sisakuota_r3  <br/>";

echo"</td>
<td align=left>
Triwulan IV <br/>";
$spirit4=$hasil_tw[kuota_triwulan4];
$ang4=$hasil_twn [kuota_triwulan4];
$rkk4=$hasil_twk[kuota_triwulan4];

$kuota_sp_terpakai4 =  mysql_query("select sum(jumlah) as jumlah from v_total_pengajuan_miras_kantor where id_knt_perwakilan=$idt and id_produk=1 and triwulan=4 and tahun=$thn");
$hsl_kuota_sp_terpakai4    = mysql_fetch_array($kuota_sp_terpakai4);
if($hsl_kuota_sp_terpakai4[jumlah] == Null){
    $hsl_kuota_sp_terpakai4[jumlah]=0;
}
$sisakuota_s4=$spirit4-$hsl_kuota_sp_terpakai4[jumlah];
echo"Batas Spirit : $spirit4 | terpakai : $hsl_kuota_sp_terpakai4[jumlah] | sisa $sisakuota_s4  <br/>";

$kuota_ag_terpakai4 =  mysql_query("select sum(jumlah) as jumlah from v_total_pengajuan_miras_kantor where id_knt_perwakilan=$idt and id_produk=2 and triwulan=4 and tahun=$thn");
$hsl_kuota_ag_terpakai4    = mysql_fetch_array($kuota_ag_terpakai4);
if($hsl_kuota_ag_terpakai4[jumlah] == Null){
    $hsl_kuota_ag_terpakai4[jumlah]=0;
}
$sisakuota_a4=$ang4-$hsl_kuota_ag_terpakai4[jumlah];
echo"Batas Anggur : $ang4 | terpakai : $hsl_kuota_ag_terpakai4[jumlah] | sisa $sisakuota_a4  <br/>";

$kuota_rk_terpakai4 =  mysql_query("select sum(jumlah) as jumlah from v_total_pengajuan_miras_kantor where id_knt_perwakilan=$idt and id_produk=3 and triwulan=4 and tahun=$thn");
$hsl_kuota_rk_terpakai4    = mysql_fetch_array($kuota_rk_terpakai4);
if($hsl_kuota_rk_terpakai4[jumlah] == Null){
    $hsl_kuota_rk_terpakai4[jumlah]=0;
}
$sisakuota_r4=$rkk4-$hsl_kuota_rk_terpakai4[jumlah];
echo"Batas Rokok : $rkk4 | terpakai : $hsl_kuota_rk_terpakai4[jumlah] | sisa $sisakuota_r4  <br/>";

echo"</td>
</tr>
<tr>";
$spiritthn=$hasil_tw[kuota_tahun];
$anggurthn=$hasil_twn [kuota_tahun];
$rokokthn=$hasil_twk[kuota_tahun];

$spiritterpakai=$hsl_kuota_sp_terpakai1[jumlah] + $hsl_kuota_sp_terpakai2[jumlah] + $hsl_kuota_sp_terpakai3[jumlah] + $hsl_kuota_sp_terpakai4[jumlah];
$anggurterpakai=$hsl_kuota_ag_terpakai1[jumlah] + $hsl_kuota_ag_terpakai2[jumlah] + $hsl_kuota_ag_terpakai3[jumlah] + $hsl_kuota_ag_terpakai4[jumlah];
$rokokterpakai=$hsl_kuota_rk_terpakai1[jumlah] + $hsl_kuota_rk_terpakai2[jumlah] + $hsl_kuota_rk_terpakai3[jumlah] + $hsl_kuota_rk_terpakai4[jumlah];
$sisaspirit=$spiritthn-$spiritterpakai;
$sisaanggur=$anggurthn-$anggurterpakai;
$sisarokok=$rokokthn-$rokokterpakai;
echo "
<td colspan=5><b>Total Kuota $thn </b>: Spirit $spiritthn | Anggur $anggurthn | Rokok $rokokthn,<b> Total Terpakai </b>: Spirit $spiritterpakai | Anggur $anggurterpakai | Rokok $rokokterpakai,<b> Sisa Total Kuota </b>: Spirit $sisaspirit | Anggur $sisaanggur | Rokok $sisarokok</td>
</tr>
</table>
<table width=100%>
<tr>
<td colspan=3>

<!--Tambah Pengajuan Bebas Bea-->
<script type='text/javascript'>
function validasi_input(form){
var decimal=  /^[-+]?[0-9]+\.[0-9]+$/;   
  if (form.notapengajuan.value == ''){
    alert('Nomor Nota Pengajuan Masih Kosong!');
    form.notapengajuan.focus();
    return (false);
  }
  if (form.spirit.value == '' && form.anggur.value == '' && form.rokok.value == ''){
    alert('Ketiga Produk (Spirit, Anggur, Rokok) Tidak Boleh Semua Kosong!');
    form.spirit.focus();
    return (false);
  }
}
</script>
<form method=POST id='frm1' enctype='multipart/form-data' action='./aksi_miras.php?module=kantor_miras&act=input' onsubmit='return validasi_input(this)'>
<input type='button'  name='tambah_pengajuan' onClick=loadPopupBoxMiras(3); value='Tambah Pengajuan'> 
	
<div id='popup_box3' style='overflow-y:scroll;' class='popup_box3'>
						<h2>Tambah Pengajuan Bebas Bea "; echo"<u>$r[NM_KNT_PERWAKILAN]</u>"
                                                         . "<input type=hidden name=sprt value='$id_kuota_spirit'>"
                                                        . "<input type=hidden name=angr value='$id_kuota_anggur'>"
                                                        . "<input type=hidden name=rkk value='$id_kuota_rokok'>";
                                                        echo"</h2>
						<div>
						<table width='100%'>
							<tr>
                                                        <td  width='30%'>Tgl. Nota Pengajuan &nbsp;</td><td width='6'>:</td><td><DIV id=\"tgl\"> <script>DateInput('tgl_pengajuan', true, 'YYYY-MM-DD')</script></div>  </td>								
							</tr>";
$bln=date(m);
if($bln >=1 and $bln <=3){
    $tw=1;
}elseif($bln >=4 and $bln <=6){
    $tw=2;
}elseif($bln >=7 and $bln <=9){
   $tw=3; 
}elseif($bln >=10 and $bln <=12){
   $tw=4; 
}
echo"<tr><td>Triwulan/Tahun</td > <td width='6'>:<td > 
<select name='triwulan' id='triwulan'>";
for ($a=1;$a<=4;$a++)

{

     echo "<option value=$a";if( $tw == $a ) echo " selected"; echo">$a</option>";

}
echo"</select>";   
$now=date(Y);
echo "<select name=tahun id=tahun>";
for ($a=2013;$a<=$now;$a++)

{

     echo "<option value=$a";if( $now == $a ) echo " selected"; echo">$a</option>";

}

echo "</select></td></tr>
    
<script type='text/javascript'>
function cekKuotaSpirit() {  
if (document.getElementById('triwulan').value == 1 && document.getElementById('tahun').value == $thn){
    if (document.getElementById('spirit').value != '' && $sisakuota_s1 !=''){
     if(document.getElementById('spirit').value > $sisakuota_s1){
         var r = confirm('Pengajuan Spirit sudah melebihi batas kuota triwulan I tahun $thn, sisa kuota = $sisakuota_s1');                 
         if (r == true) {         
         document.getElementById('anggur').focus();
        }else {
            document.getElementById('spirit').value='';
            document.getElementById('spirit').focus();
        } 
     }
    }
  }    

if (document.getElementById('triwulan').value == 2 && document.getElementById('tahun').value == $thn){
    if (document.getElementById('spirit').value != '' && $sisakuota_s2 !=''){
     if(document.getElementById('spirit').value > $sisakuota_s2){
         var r = confirm('Pengajuan Spirit sudah melebihi batas kuota triwulan II tahun $thn, sisa kuota = $sisakuota_s2');                 
         if (r == true) {         
         document.getElementById('anggur').focus();
        }else {
            document.getElementById('spirit').value='';
            document.getElementById('spirit').focus();
        } 
     }
    }
  }
  
   if (document.getElementById('triwulan').value == 3 && document.getElementById('tahun').value == $thn){
    if (document.getElementById('spirit').value != '' && $sisakuota_s3 !=''){
     if(document.getElementById('spirit').value > $sisakuota_s3){
         var r = confirm('Pengajuan Spirit sudah melebihi batas kuota triwulan III tahun $thn, sisa kuota = $sisakuota_s3');                 
         if (r == true) {         
         document.getElementById('anggur').focus();
        }else {
            document.getElementById('spirit').value='';
            document.getElementById('spirit').focus();
        } 
     }
    }
  }
  
   if (document.getElementById('triwulan').value == 4 && document.getElementById('tahun').value == $thn){
    if (document.getElementById('spirit').value != '' && $sisakuota_s4 !=''){
     if(document.getElementById('spirit').value > $sisakuota_s4){
         var r = confirm('Pengajuan Spirit sudah melebihi batas kuota triwulan IV tahun $thn, sisa kuota = $sisakuota_s4');                 
         if (r == true) {         
         document.getElementById('anggur').focus();
        }else {
            document.getElementById('spirit').value='';
            document.getElementById('spirit').focus();
        } 
     }
    }
  }
    
}

function cekKuotaAnggur() {  
if (document.getElementById('triwulan').value == 1 && document.getElementById('tahun').value == $thn){
    if (document.getElementById('anggur').value != '' && $sisakuota_a1 !=''){
     if(document.getElementById('anggur').value > $sisakuota_a1){
         var r = confirm('Pengajuan Anggur sudah melebihi batas kuota triwulan I tahun $thn, sisa kuota = $sisakuota_a1');                 
         if (r == true) {         
         document.getElementById('rokok').focus();
        }else {
            document.getElementById('anggur').value='';
            document.getElementById('anggur').focus();
        } 
     }
    }
  }    

if (document.getElementById('triwulan').value == 2 && document.getElementById('tahun').value == $thn){
    if (document.getElementById('anggur').value != '' && $sisakuota_a2 !=''){
     if(document.getElementById('anggur').value > $sisakuota_a2){
         var r = confirm('Pengajuan Anggur sudah melebihi batas kuota triwulan II tahun $thn, sisa kuota = $sisakuota_a2');                 
         if (r == true) {         
         document.getElementById('rokok').focus();
        }else {
            document.getElementById('anggur').value='';
            document.getElementById('anggur').focus();
        } 
     }
    }
  }    
  
   if (document.getElementById('triwulan').value == 3 && document.getElementById('tahun').value == $thn){
    if (document.getElementById('anggur').value != '' && $sisakuota_a3 !=''){
     if(document.getElementById('anggur').value > $sisakuota_a3){
         var r = confirm('Pengajuan Anggur sudah melebihi batas kuota triwulan III tahun $thn, sisa kuota = $sisakuota_a3');                 
         if (r == true) {         
         document.getElementById('rokok').focus();
        }else {
            document.getElementById('anggur').value='';
            document.getElementById('anggur').focus();
        } 
     }
    }
  }    
  
   if (document.getElementById('triwulan').value == 4 && document.getElementById('tahun').value == $thn){
    if (document.getElementById('anggur').value != '' && $sisakuota_a4 !=''){
     if(document.getElementById('anggur').value > $sisakuota_a4){
         var r = confirm('Pengajuan Anggur sudah melebihi batas kuota triwulan IV tahun $thn, sisa kuota = $sisakuota_a4');                 
         if (r == true) {         
         document.getElementById('rokok').focus();
        }else {
            document.getElementById('anggur').value='';
            document.getElementById('anggur').focus();
        } 
     }
    }
  } 
}

function cekKuotaRokok() {  
if (document.getElementById('triwulan').value == 1 && document.getElementById('tahun').value == $thn){
    if (document.getElementById('rokok').value != '' && $sisakuota_r1 !=''){
     if(document.getElementById('rokok').value > $sisakuota_r1){
         var r = confirm('Pengajuan Rokok sudah melebihi batas kuota triwulan I tahun $thn, sisa kuota = $sisakuota_r1');                 
         if (r == true) {         
         document.getElementById('notapersetujuan').focus();
        }else {
            document.getElementById('rokok').value='';
            document.getElementById('rokok').focus();
        } 
     }
    }
  } 
 if (document.getElementById('triwulan').value == 2 && document.getElementById('tahun').value == $thn){
    if (document.getElementById('rokok').value != '' && $sisakuota_r2 !=''){
     if(document.getElementById('rokok').value > $sisakuota_r2){
         var r = confirm('Pengajuan Rokok sudah melebihi batas kuota triwulan II tahun $thn, sisa kuota = $sisakuota_r2');                 
         if (r == true) {         
         document.getElementById('notapersetujuan').focus();
        }else {
            document.getElementById('rokok').value='';
            document.getElementById('rokok').focus();
        } 
     }
    }
  }
if (document.getElementById('triwulan').value == 3 && document.getElementById('tahun').value == $thn){
    if (document.getElementById('rokok').value != '' && $sisakuota_r3 !=''){
     if(document.getElementById('rokok').value > $sisakuota_r3){
         var r = confirm('Pengajuan Rokok sudah melebihi batas kuota triwulan III tahun $thn, sisa kuota = $sisakuota_r3');                 
         if (r == true) {         
         document.getElementById('notapersetujuan').focus();
        }else {
            document.getElementById('rokok').value='';
            document.getElementById('rokok').focus();
        } 
     }
    }
  }
if (document.getElementById('triwulan').value == 4 && document.getElementById('tahun').value == $thn){
    if (document.getElementById('rokok').value != '' && $sisakuota_r4 !=''){
     if(document.getElementById('rokok').value > $sisakuota_r4){
         var r = confirm('Pengajuan Rokok sudah melebihi batas kuota triwulan IV tahun $thn, sisa kuota = $sisakuota_r4');                 
         if (r == true) {         
         document.getElementById('notapersetujuan').focus();
        }else {
            document.getElementById('rokok').value='';
            document.getElementById('rokok').focus();
        } 
     }
    }
  } 
 }
</script> 

<tr><td>No. Nota Pengajuan</td ><td width='6'>:</td><td > <input type=text name='notapengajuan' id='notapengajuan' size=50 maxlength=100 required></br><input type=file name='file_pengajuan' id='file_pengajuan'></td></tr>
<script>
$('#file_pengajuan').bind('change', function() {
var a = document.getElementById('file_pengajuan').value;
  var ext = a.split('.');
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ['jpg' ,'jpeg', 'pdf'];
    
  if(this.files[0].size > 8044070){
  alert('ERROR: File terlalu besar, maksimal 8 mb');
  document.getElementById('file_pengajuan').value=''
  }
  
    if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert('ERROR: Jenis file harus .pdf, .jpg, atau .jpeg');
        document.getElementById('file_pengajuan').value=''
    }
   
});
</script>
<tr><td>Pengajuan Spirit</td ><td width='6'>:</td><td > <input type=number step=any placeholder=Enter_number id='spirit' name='spirit' size=10 onblur='cekKuotaSpirit();'> Liter</td></tr>
<tr><td>Pengajuan Anggur</td ><td width='6'>:</td><td > <input type=number step=any placeholder=Enter_number id='anggur' name='anggur' size=10 onblur='cekKuotaAnggur();'> Liter</td></tr>
<tr><td>Pengajuan Rokok</td ><td width='6'>:</td><td > <input type=number step=any placeholder=Enter_number id='rokok' name='rokok' size=10 onblur='cekKuotaRokok();'> Batang</td></tr>
<tr><td>Status Pengajuan</td > <td width='6'>:</td><td > <input type=radio name='st_pengajuan' value=Setuju> Setuju  <input type=radio name='st_pengajuan' value=Tolak> Tidak Setuju</td></tr>
<tr><td>No. Nota Persetujuan/Penolakan</td > <td width='6'>:</td><td > <input type=text name='notapersetujuan' id='notapersetujuan' size=50 maxlength=100></br><input type=file name=file_jawaban id=file_jawaban></td></tr>
<script>
$('#file_jawaban').bind('change', function() {
var a = document.getElementById('file_jawaban').value;
  var ext = a.split('.');
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ['jpg' ,'jpeg', 'pdf'];
    
  if(this.files[0].size > 8044070){
  alert('ERROR: File terlalu besar, maksimal 8 mb');
  document.getElementById('file_jawaban').value=''
  }
  
    if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert('ERROR: Jenis file harus .pdf, .jpg, atau .jpeg');
        document.getElementById('file_jawaban').value=''
    }
   
});
</script>
<tr><td>Tgl. Nota Persetujuan/Penolakan &nbsp;</td><td width='6'>:</td><td><DIV id=\"tgl\"> <script>DateInput('tgl_persetujuan', true, 'YYYY-MM-DD')</script></div>  </td>
<tr><td>Keterangan</td > <td width='6'>:</td><td > <textarea name='keterangan' rows=2 cols=50 maxlength=500></textarea></td></tr>
<input type=hidden name='id_negara_bea' value= '$r[ID_NEGARA]' >
<input type=hidden name='id_knt_perwakilan_bea' value= '$r[ID_KNT_PERWAKILAN]' >
						
							<td colspan=3 align=right>
							<input type=submit  name='simpan_pengajuan' value='Simpan'>								
							</td>
							</tr>
						</table></form>
						</div>
						<a id='popupBoxClose' onClick='unloadPopupBox2(3);'>[X]</a>	
					</div>
</form>
<!--Akhir Tambah Pengajuan Bebas Bea-->

</td>
<td colspan=8 align=right>

<form id=cari1 name=form1 action='./deplu.php?module=kantor_miras&act=kelola_pengajuan&idt=$idt' method=POST>
Pencarian Data Pengajuan <u>$r[NM_KNT_PERWAKILAN]</u>  :  
<input type=text name=cr_pengajuan id=cr_pengajuan placeholder='KD, Nota, Status, Tahun' />
<input type=hidden id=cr name=cr>
  <input type=submit name=btncari id=btncari value=Cari onClick=tmp_cari(); />
</form>
</td>
</tr>
          <tr><th width=8>no</th><th width=85>KD</th><th width=105>Nota Pengajuan</th><th width=50>Tgl. Nota</th><th width=105>Nota Jawaban</th><th width=50>Tgl. Nota</th><th width=30>Status</th><th width=120>Nama Produk</th><th width=5>TW</th><th width=15>Tahun</th><th width=15>AKSI</th>
</tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $neg = $_GET['negara'];
	
    if (isset($_POST[cr])){
		$sql="select a.id_pengajuan_miras, a.kd_pengajuan_miras, a.no_nota_pengajuan, DATE_FORMAT(a.tgl_nota_pengajuan,'%d %b %Y') as tgl_nota_pengajuan, a.status_pengajuan,a.no_nota_jawaban, DATE_FORMAT(a.tgl_nota_jawaban,'%d %b %Y') as tgl_nota_jawaban, 
group_concat(e.nama_produk,' ','(', jumlah,')' separator ', ') as nama_produk,c.triwulan, c.tahun from tbl_pengajuan_miras_kantor as a 
join m_kantor_perwakilan as b on b.ID_KNT_PERWAKILAN=a.id_knt_perwakilan
join tbl_detil_pengajuan_miras_kantor as c on c.id_pengajuan_miras=a.id_pengajuan_miras
join tbl_produk_miras as e on e.id_produk=c.id_produk where (a.kd_pengajuan_miras like '%".$_POST[cr]."%' or a.no_nota_pengajuan like '%".$_POST[cr]."%' or a.status_pengajuan like '%".$_POST[cr]."%' or a.no_nota_jawaban like '%".$_POST[cr]."%' or c.tahun like '%".$_POST[cr]."%') AND a.id_knt_perwakilan = $idt
GROUP BY a.id_pengajuan_miras
order by a.id_pengajuan_miras desc limit $posisi,$batas";
//echo $sql;
		$tampil=mysql_query($sql);

	}
	else
    {
    
            
            
    $tampil=mysql_query("select a.id_pengajuan_miras, a.kd_pengajuan_miras, a.no_nota_pengajuan, DATE_FORMAT(a.tgl_nota_pengajuan,'%d %b %Y') as tgl_nota_pengajuan, a.status_pengajuan,a.no_nota_jawaban, DATE_FORMAT(a.tgl_nota_jawaban,'%d %b %Y') as tgl_nota_jawaban, 
group_concat(e.nama_produk,' ','(', jumlah,')' separator ', ') as nama_produk,c.triwulan, c.tahun, a.keterangan,a.tgl_nota_pengajuan as tgl_aju, tgl_nota_jawaban as tgl_jb from tbl_pengajuan_miras_kantor as a 
join m_kantor_perwakilan as b on b.ID_KNT_PERWAKILAN=a.id_knt_perwakilan
join tbl_detil_pengajuan_miras_kantor as c on c.id_pengajuan_miras=a.id_pengajuan_miras
join tbl_produk_miras as e on e.id_produk=c.id_produk where a.id_knt_perwakilan = $idt
GROUP BY a.id_pengajuan_miras
order by a.id_pengajuan_miras desc limit $posisi,$batas");

	}
   
    $no = $posisi+1;
    
    while($b=mysql_fetch_array($tampil)){

      echo "<tr><td>$no</td>
                <td>$b[kd_pengajuan_miras]</td>
                <td>$b[no_nota_pengajuan]</td>
				<td>$b[tgl_nota_pengajuan]</td>	
                                <td>$b[no_nota_jawaban]</td>"
              . "<td>$b[tgl_nota_jawaban]</td>"
              . "<td>$b[status_pengajuan]</td>"
              . "<td>$b[nama_produk]</td>"
              . "<td align=center>$b[triwulan]</td>"
              . "<td align=center>$b[tahun]</td>";
                                //edit andri 14092016 tambah if user miras maka bisa tambah pengajuan miras
                                //if ($_SESSION[G_leveluser]==13){
                                    $produk=mysql_query("select id_produk, jumlah from tbl_detil_pengajuan_miras_kantor where id_pengajuan_miras = $b[id_pengajuan_miras]");

                                    $ket= json_encode($b['keterangan']);
                                    $jwb= json_encode($b[no_nota_jawaban]);
                                    $pengajuan= json_encode($b[no_nota_pengajuan]);
                                    $tw= json_encode($b[triwulan]);
                                    $sts= json_encode($b[status_pengajuan]);
                                    $th= json_encode($b[tahun]);
                                    $tgl_aju= json_encode($b[tgl_aju]);
                                    $tgl_jb= json_encode($b[tgl_jb]);
                                    $kd1= json_encode($b[kd_pengajuan_miras]);
                                    
                                    while($prdk=mysql_fetch_array($produk)){
                                        if($prdk[id_produk]==1){
                                            $jml_spirit=json_encode($prdk[jumlah]);
                                        }
                                        if($prdk[id_produk]==2){
                                            $jml_anggur=json_encode($prdk[jumlah]);
                                        }                                       
                                        if($prdk[id_produk]==3){
                                        $jml_rkk=json_encode($prdk[jumlah]);
                                        }
                                    }
                                    
$file_staf_aju=mysql_query("select lokasi_file, nama_file, jenis, tipe_file from tbl_file_miras_kantor where id_pengajuan_miras = $b[id_pengajuan_miras] and jenis='file_pengajuan'");
                                 if(mysql_num_rows($file_staf_aju) > 0){
                                    while($fl_staf=mysql_fetch_array($file_staf_aju)){                                      
                                        if($fl_staf[jenis]=='file_pengajuan' && $fl_staf[lokasi_file] != ''){
                                            $lokasi_aju=json_encode($fl_staf[lokasi_file]);
                                            $nama_aju=json_encode($fl_staf[nama_file]);
                                            $tipe_fl_aju=json_encode($fl_staf[tipe_file]);
                                        }else if($fl_staf[jenis]=='file_pengajuan' && $fl_staf[lokasi_file] == ''){
                                            $lokasi_aju=json_encode('#');
                                            $nama_aju=json_encode('Tidak ada file');
                                            $tipe_fl_aju=json_encode('');
                                        }
                                    }
                                 }else{
                                     $lokasi_aju=json_encode('#');
                                     $nama_aju=json_encode('Tidak ada file');
                                     $tipe_fl_aju=json_encode('');
                                 }
$file_staf_jwb=mysql_query("select lokasi_file, nama_file, jenis, tipe_file from tbl_file_miras_kantor where id_pengajuan_miras = $b[id_pengajuan_miras] and jenis='file_jawaban'");
                                 if(mysql_num_rows($file_staf_jwb) > 0){
                                    while($fl_staf_jwb=mysql_fetch_array($file_staf_jwb)){
                                        if($fl_staf_jwb[jenis]=='file_jawaban' && $fl_staf_jwb[lokasi_file] != ''){
                                            $lokasi_jwb=json_encode($fl_staf_jwb[lokasi_file]);
                                            $nama_jwb=json_encode($fl_staf_jwb[nama_file]);
                                            $tipe_fl_jwb=json_encode($fl_staf_jwb[tipe_file]);
                                        }else if($fl_staf_jwb[jenis]=='file_jawaban' && $fl_staf_jwb[lokasi_file] == ''){
                                            $lokasi_jwb=json_encode('#');
                                            $nama_jwb=json_encode('Tidak ada file');
                                            $tipe_fl_jwb=json_encode('');
                                        }                                                                         
                                    }
                                 }else{
                                     $lokasi_jwb=json_encode('#');
                                     $nama_jwb=json_encode('Tidak ada file');
                                     $tipe_fl_jwb=json_encode('');
                                 }
                                    
                                    echo "<td><input type='button'  name='edit_pengajuan' "
. "onClick='loadPopupBoxMiras(2,$kd1,$b[id_pengajuan_miras],$pengajuan,$jwb,$ket,$sts,$tw,$th,$tgl_aju,$tgl_jb,$jml_spirit,$jml_anggur,$jml_rkk,$lokasi_aju,$nama_aju,$tipe_fl_aju,$lokasi_jwb,$nama_jwb,$tipe_fl_jwb);' value='Edit Pengajuan'>";                                  
                               // }
		        echo"</tr>";
      $no++;
    }
    echo "</table>";

if (isset($_POST[cr]))
	{
		$jmldata =mysql_num_rows(mysql_query("select a.id_pengajuan_miras, a.no_nota_pengajuan, DATE_FORMAT(a.tgl_nota_pengajuan,'%d %b %Y') as tgl_nota_pengajuan, a.status_pengajuan,a.no_nota_jawaban, DATE_FORMAT(a.tgl_nota_jawaban,'%d %b %Y') as tgl_nota_jawaban, 
group_concat(e.nama_produk,' ','(', jumlah,')' separator ', ') as nama_produk,c.triwulan, c.tahun from tbl_pengajuan_miras_kantor as a 
join m_kantor_perwakilan as b on b.ID_KNT_PERWAKILAN=a.id_knt_perwakilan
join tbl_detil_pengajuan_miras_kantor as c on c.id_pengajuan_miras=a.id_pengajuan_miras
join tbl_produk_miras as e on e.id_produk=c.id_produk where (a.kd_pengajuan_miras like '%".$_POST[cr]."%' or a.no_nota_pengajuan like '%".$_POST[cr]."%' or a.status_pengajuan like '%".$_POST[cr]."%' or a.no_nota_jawaban like '%".$_POST[cr]."%' or c.tahun like '%".$_POST[cr]."%') AND a.id_knt_perwakilan = $idt
GROUP BY a.id_pengajuan_miras
order by a.id_pengajuan_miras desc"));
        }else{
		$jmldata =mysql_num_rows(mysql_query("select a.id_pengajuan_miras, a.no_nota_pengajuan, DATE_FORMAT(a.tgl_nota_pengajuan,'%d %b %Y') as tgl_nota_pengajuan, a.status_pengajuan,a.no_nota_jawaban, DATE_FORMAT(a.tgl_nota_jawaban,'%d %b %Y') as tgl_nota_jawaban, 
group_concat(e.nama_produk,' ','(', jumlah,')' separator ', ') as nama_produk,c.triwulan, c.tahun, a.keterangan,a.tgl_nota_pengajuan as tgl_aju, tgl_nota_jawaban as tgl_jb from tbl_pengajuan_miras_kantor as a 
join m_kantor_perwakilan as b on b.ID_KNT_PERWAKILAN=a.id_knt_perwakilan
join tbl_detil_pengajuan_miras_kantor as c on c.id_pengajuan_miras=a.id_pengajuan_miras
join tbl_produk_miras as e on e.id_produk=c.id_produk where a.id_knt_perwakilan = $idt
GROUP BY a.id_pengajuan_miras
order by a.id_pengajuan_miras desc"));
	}
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
   
            $ilink = "?module=kantor_miras&act=kelola_pengajuan&idt=$_GET[idt]&cr=$_POST[cr]"; 
            $linkHalaman = $p->navHalaman($ilink,$_GET['halaman'], $jmlhalaman);
            echo "<div id=paging>$linkHalaman</div><br>";
    
echo"<script type='text/javascript'>
function validasi_input_edt(form){
var decimal=  /^[-+]?[0-9]+\.[0-9]+$/;   
  if (form.nota_pengajuan.value == ''){
    alert('Nomor Nota Pengajuan Masih Kosong!');
    form.nota_pengajuan.focus();
    return (false);
  }
  if (form.spirit1.value == '' && form.anggur1.value == '' && form.rokok1.value == ''){
    alert('Ketiga Produk (Spirit, Anggur, Rokok) Tidak Boleh Semua Kosong!');
    form.spirit1.focus();
    return (false);
  }
}

function cekKuotaSpiritEdt() {  
if (document.getElementById('trw').value == 1 && document.getElementById('thn').value == $thn){
    if (document.getElementById('spirit1').value != '' && $sisakuota_s1 !=''){
     if(document.getElementById('spirit1').value > $sisakuota_s1){
         var r = confirm('Pengajuan Spirit sudah melebihi batas kuota triwulan I tahun $thn, sisa kuota = $sisakuota_s1');                 
         if (r == true) {         
         document.getElementById('anggur1').focus();
        }else {
            document.getElementById('spirit1').value='';
            document.getElementById('spirit1').focus();
        } 
     }
    }
  }    

if (document.getElementById('trw').value == 2 && document.getElementById('thn').value == $thn){
    if (document.getElementById('spirit1').value != '' && $sisakuota_s2 !=''){
     if(document.getElementById('spirit1').value > $sisakuota_s2){
         var r = confirm('Pengajuan Spirit sudah melebihi batas kuota triwulan II tahun $thn, sisa kuota = $sisakuota_s2');                 
         if (r == true) {         
         document.getElementById('anggur1').focus();
        }else {
            document.getElementById('spirit1').value='';
            document.getElementById('spirit1').focus();
        } 
     }
    }
  }
  
   if (document.getElementById('trw').value == 3 && document.getElementById('thn').value == $thn){
    if (document.getElementById('spirit1').value != '' && $sisakuota_s3 !=''){
     if(document.getElementById('spirit1').value > $sisakuota_s3){
         var r = confirm('Pengajuan Spirit sudah melebihi batas kuota triwulan III tahun $thn, sisa kuota = $sisakuota_s3');                 
         if (r == true) {         
         document.getElementById('anggur1').focus();
        }else {
            document.getElementById('spirit1').value='';
            document.getElementById('spirit1').focus();
        } 
     }
    }
  }
  
   if (document.getElementById('trw').value == 4 && document.getElementById('thn').value == $thn){
    if (document.getElementById('spirit1').value != '' && $sisakuota_s4 !=''){
     if(document.getElementById('spirit1').value > $sisakuota_s4){
         var r = confirm('Pengajuan Spirit sudah melebihi batas kuota triwulan IV tahun $thn, sisa kuota = $sisakuota_s4');                 
         if (r == true) {         
         document.getElementById('anggur1').focus();
        }else {
            document.getElementById('spirit1').value='';
            document.getElementById('spirit1').focus();
        } 
     }
    }
  }
    
}

function cekKuotaAnggurEdt() {  
if (document.getElementById('trw').value == 1 && document.getElementById('thn').value == $thn){
    if (document.getElementById('anggur1').value != '' && $sisakuota_a1 !=''){
     if(document.getElementById('anggur1').value > $sisakuota_a1){
         var r = confirm('Pengajuan Anggur sudah melebihi batas kuota triwulan I tahun $thn, sisa kuota = $sisakuota_a1');                 
         if (r == true) {         
         document.getElementById('rokok1').focus();
        }else {
            document.getElementById('anggur1').value='';
            document.getElementById('anggur1').focus();
        } 
     }
    }
  }    

if (document.getElementById('trw').value == 2 && document.getElementById('thn').value == $thn){
    if (document.getElementById('anggur1').value != '' && $sisakuota_a2 !=''){
     if(document.getElementById('anggur1').value > $sisakuota_a2){
         var r = confirm('Pengajuan Anggur sudah melebihi batas kuota triwulan II tahun $thn, sisa kuota = $sisakuota_a2');                 
         if (r == true) {         
         document.getElementById('rokok1').focus();
        }else {
            document.getElementById('anggur1').value='';
            document.getElementById('anggur1').focus();
        } 
     }
    }
  }    
  
   if (document.getElementById('trw').value == 3 && document.getElementById('thn').value == $thn){
    if (document.getElementById('anggur1').value != '' && $sisakuota_a3 !=''){
     if(document.getElementById('anggur1').value > $sisakuota_a3){
         var r = confirm('Pengajuan Anggur sudah melebihi batas kuota triwulan III tahun $thn, sisa kuota = $sisakuota_a3');                 
         if (r == true) {         
         document.getElementById('rokok1').focus();
        }else {
            document.getElementById('anggur1').value='';
            document.getElementById('anggur1').focus();
        } 
     }
    }
  }    
  
   if (document.getElementById('trw').value == 4 && document.getElementById('thn').value == $thn){
    if (document.getElementById('anggur1').value != '' && $sisakuota_a4 !=''){
     if(document.getElementById('anggur1').value > $sisakuota_a4){
         var r = confirm('Pengajuan Anggur sudah melebihi batas kuota triwulan IV tahun $thn, sisa kuota = $sisakuota_a4');                 
         if (r == true) {         
         document.getElementById('rokok1').focus();
        }else {
            document.getElementById('anggur1').value='';
            document.getElementById('anggur1').focus();
        } 
     }
    }
  } 
}

function cekKuotaRokokEdt() {  
if (document.getElementById('trw').value == 1 && document.getElementById('thn').value == $thn){
    if (document.getElementById('rokok1').value != '' && $sisakuota_r1 !=''){
     if(document.getElementById('rokok1').value > $sisakuota_r1){
         var r = confirm('Pengajuan Rokok sudah melebihi batas kuota triwulan I tahun $thn, sisa kuota = $sisakuota_r1');                 
         if (r == true) {         
         document.getElementById('not_jawaban').focus();
        }else {
            document.getElementById('rokok1').value='';
            document.getElementById('rokok1').focus();
        } 
     }
    }
  } 
 if (document.getElementById('trw').value == 2 && document.getElementById('thn').value == $thn){
    if (document.getElementById('rokok1').value != '' && $sisakuota_r2 !=''){
     if(document.getElementById('rokok1').value > $sisakuota_r2){
         var r = confirm('Pengajuan Rokok sudah melebihi batas kuota triwulan II tahun $thn, sisa kuota = $sisakuota_r2');                 
         if (r == true) {         
         document.getElementById('not_jawaban').focus();
        }else {
            document.getElementById('rokok1').value='';
            document.getElementById('rokok1').focus();
        } 
     }
    }
  }
if (document.getElementById('trw').value == 3 && document.getElementById('thn').value == $thn){
    if (document.getElementById('rokok1').value != '' && $sisakuota_r3 !=''){
     if(document.getElementById('rokok1').value > $sisakuota_r3){
         var r = confirm('Pengajuan Rokok sudah melebihi batas kuota triwulan III tahun $thn, sisa kuota = $sisakuota_r3');                 
         if (r == true) {         
         document.getElementById('not_jawaban').focus();
        }else {
            document.getElementById('rokok1').value='';
            document.getElementById('rokok1').focus();
        } 
     }
    }
  }
if (document.getElementById('trw').value == 4 && document.getElementById('thn').value == $thn){
    if (document.getElementById('rokok1').value != '' && $sisakuota_r4 !=''){
     if(document.getElementById('rokok1').value > $sisakuota_r4){
         var r = confirm('Pengajuan Rokok sudah melebihi batas kuota triwulan IV tahun $thn, sisa kuota = $sisakuota_r4');                 
         if (r == true) {         
         document.getElementById('not_jawaban').focus();
        }else {
            document.getElementById('rokok1').value='';
            document.getElementById('rokok1').focus();
        } 
     }
    }
  } 
 }

</script> 



<form method=POST id='frm_edit' enctype='multipart/form-data' onsubmit='return validasi_input_edt(this)' action='./aksi_miras.php?module=kantor_miras&act=update_miras'>
        <div id='popup_box2' style='overflow-y:scroll;' class='popup_box2'>
						<h2>Edit Pengajuan Bebas Bea "; echo"<u>$r[NM_KNT_PERWAKILAN]</u>";
                                                        echo"</h2>
						<div>
						<table width='100%'>
<tr><td>KD Pengajuan</td ><td width='6'>:</td><td>"; echo "<input type=hidden id=kd name=kd size=5> <input type=text id=kd1 name=kd1 size=15 disabled>";
        echo"</td></tr>
							<tr>
                                                        <td  width='30%'>Tgl. Nota Pengajuan &nbsp;</td><td width='6'>:</td><td><input type=date id=tgl_pengajuan name=tgl_pengajuan size=10> </td>								
							</tr>";

echo"<tr><td>Triwulan/Tahun</td > <td width='6'>:<td >
<select id=trw name=trw>
  <option value=1>1</option>
  <option value=2>2</option>
  <option value=3>3</option>
  <option value=4>4</option>
</select>";   
$now=date(Y);
echo "<select id=thn name=thn>";
for ($a=2013;$a<=$now;$a++)

{

     echo "<option value=$a";if( $now == $a ) echo " selected"; echo">$a</option>";

}

echo "</select></td></tr>   
<tr><td>No. Nota Pengajuan,</br>File Nota</td ><td width='6'>:</td><td ><input type=text id=nota_pengajuan name=nota_pengajuan size=50 maxlength=100 required></br><span name='fl_aju' id='fl_aju'></span></br><input type=file name='file_pengajuan_update' id='file_pengajuan_update'><input type=hidden name='fl_aju_hd' id='fl_aju_hd'></td></tr>
<script>
$('#file_pengajuan_update').bind('change', function() {
var a = document.getElementById('file_pengajuan_update').value;
  var ext = a.split('.');
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ['jpg' ,'jpeg', 'pdf'];
    
  if(this.files[0].size > 8044070){
  alert('ERROR: File terlalu besar, maksimal 8 mb');
  document.getElementById('file_pengajuan_update').value=''
  }
  
    if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert('ERROR: Jenis file harus .pdf, .jpg, atau .jpeg');
        document.getElementById('file_pengajuan_update').value=''
    }
   
});
</script>
<tr><td>Pengajuan Spirit</td ><td width='6'>:</td><td > <input type=number id=spirit1 name=spirit1 step=any size=10 onblur='cekKuotaSpiritEdt();'> Liter</td></tr>
<tr><td>Pengajuan Anggur</td ><td width='6'>:</td><td > <input <input type=number id=anggur1 name=anggur1 step=any size=10 onblur='cekKuotaAnggurEdt();'> Liter</td></tr>
<tr><td>Pengajuan Rokok</td ><td width='6'>:</td><td > <input type=number id=rokok1 name=rokok1 step=any size=10 onblur='cekKuotaRokokEdt();'> Batang</td></tr>
<tr><td>Status Pengajuan</td > <td width='6'>:</td><td > <input type=radio id='st_aju' name=sts_pengajuan value=Setuju> Setuju  <input type=radio id='sts_pengajuan' name=sts_pengajuan value=Tolak> Tidak Setuju</td></tr>
<tr><td>No. Nota Persetujuan/Penolakan,</br>File Nota</td > <td width='6'>:</td><td > <input type=text id=not_jawaban name=not_jawaban size=50 maxlength=100></br><span name='fl_jwb' id='fl_jwb'></span></br><input type=file name='file_jawaban_update' id='file_jawaban_update'><input type=hidden name='fl_jwb_hd' id='fl_jwb_hd'></td></tr>
<script>
$('#file_jawaban_update').bind('change', function() {
var a = document.getElementById('file_jawaban_update').value;
  var ext = a.split('.');
    ext = ext[ext.length-1].toLowerCase();      
    var arrayExtensions = ['jpg' ,'jpeg', 'pdf'];
    
  if(this.files[0].size > 8044070){
  alert('ERROR: File terlalu besar, maksimal 8 mb');
  document.getElementById('file_jawaban_update').value=''
  }
  
    if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert('ERROR: Jenis file harus .pdf, .jpg, atau .jpeg');
        document.getElementById('file_jawaban_update').value=''
    }
   
});
</script>
<tr><td>Tgl. Nota Persetujuan/Penolakan &nbsp;</td><td width='6'>:</td><td> <input type=text id=datepicker1 name=datepicker1 size=10>  </td>
<tr><td>Keterangan</td > <td width='6'>:</td><td > <textarea id=keterangan name=keterangan rows=2 cols=50 maxlength=500></textarea></td></tr>
							
							<td colspan=3 align=right>
							<input type=submit  name='update_pengajuan' value='Update'>														
							</td>
							</tr>
						</table></form>
						</div>
						<a id='popupBoxClose' onClick='unloadPopupBox2(2);'>[X]</a>	
					</div>
 </form>                                       
"; 
	
  
    break;
   

}
?>
