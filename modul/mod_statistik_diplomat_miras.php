<?php
  // echo "<br><a href=?module=diplomat_miras&act=cari&huruf=A>A</A> |	<a href=?module=diplomat_miras&act=cari&huruf=B>B</A> |	<a href=?module=diplomat_miras&act=cari&huruf=C>C</A> |	<a href=?module=diplomat_miras&act=cari&huruf=D>D</A> |	<a href=?module=diplomat_miras&act=cari&huruf=E>E</A> |	<a href=?module=diplomat_miras&act=cari&huruf=F>F</A> |	<a href=?module=diplomat_miras&act=cari&huruf=G>G</A> |	<a href=?module=diplomat_miras&act=cari&huruf=H>H</A> |	<a href=?module=diplomat_miras&act=cari&huruf=I>I</A> |	<a href=?module=diplomat_miras&act=cari&huruf=J>J</A> |	<a href=?module=diplomat_miras&act=cari&huruf=K>K</A> |	<a href=?module=diplomat_miras&act=cari&huruf=L>L</A> |	<a href=?module=diplomat_miras&act=cari&huruf=M>M</A> |	<a href=?module=diplomat_miras&act=cari&huruf=N>N</A> |	<a href=?module=diplomat_miras&act=cari&huruf=O>O</A> |	<a href=?module=diplomat_miras&act=cari&huruf=P>P</A> |	<a href=?module=diplomat_miras&act=cari&huruf=Q>Q</A> |	<a href=?module=diplomat_miras&act=cari&huruf=R>R</A> |	<a href=?module=diplomat_miras&act=cari&huruf=S>S</A> |	<a href=?module=diplomat_miras&act=cari&huruf=T>T</A> |	<a href=?module=diplomat_miras&act=cari&huruf=U>U</A> |	<a href=?module=diplomat_miras&act=cari&huruf=V>V</A> |	<a href=?module=diplomat_miras&act=cari&huruf=W>W</A> |	<a href=?module=diplomat_miras&act=cari&huruf=X>X</A> |	<a href=?module=diplomat_miras&act=cari&huruf=Y>Y</A> |	<a href=?module=diplomat_miras&act=cari&huruf=Z>Z</A>";

switch($_GET['act']){
  // Tampil Berita
  default:
		if (isset($_GET['negara'])) {
			$negaranya = $_GET['negara'];
			if ($_GET['negara'] == ""){$negaranya = 'Semua negara';}
 		}
		else
		{
			$negaranya = 'Semua negara';
		}
    
		echo "<link rel='stylesheet' href='../config/jquery-ui-1.12.1.custom/themes/base/jquery-ui.css'"
                . "><script src='../config/jquery-ui-1.12.1.custom/jquery-1.12.4.js'></script>"
                        . "<script src='../config/jquery-ui-1.12.1.custom/jquery-ui.js'>"
                        . "</script><script type='text/javascript'>"
                        . "  $( function() { "
                        . "$( '#tgl_cr_aju1' ).datepicker({ dateFormat: 'yy-mm-dd' }); "
                        . "$( '#tgl_cr_aju2' ).datepicker({ dateFormat: 'yy-mm-dd' }); "
                        . "} );"
                        . "</script>"
                . "<h2>Pencarian Data Pengajuan Bebas Bea Bagi Staf Perwakilan Asing</h2>
			<form method=get action='./deplu.php?' enctype='multipart/form-data'>
				 <input type=hidden name=module value='statistik_staf'>
				 <!--<input type=hidden name=act value=cari>-->
                        <table width=54%>
                        <tr>                        
                        <td width=19%>Nama Diplomat</td>
                        <td width=1%>:</td>
                        <td width=12% colspan=3><input type=text size=50 name=\"nm_diplomat\" id=nm_diplomat value=$_GET[nm_diplomat]></td>                        
                        </tr>
                        <tr>                        
                        <td width=19%>Tgl. Pengajuan</td>
                        <td width=1%>:</td>
                        <td width=12% colspan=3><input type=text name=\"tgl_cr_aju1\" id=tgl_cr_aju1 value=$_GET[tgl_cr_aju1]> s.d <input type=text name=\"tgl_cr_aju2\" id=tgl_cr_aju2 value=$_GET[tgl_cr_aju2]></td>                       
                        </tr>
                        <tr>
                        <td>Kantor Perwakilan</td>
                        <td>:</td>
                        <td colspan=3><input type=text name=\"perwakilan\" id=perwakilan value=$_GET[perwakilan]></td>
                        </tr>
                        <tr>
                        <td>Negara</td>
                        <td>:</td>
                        <td colspan=3><input type=text name=\"negara\" id=negara value=$_GET[negara]></td>
                        </tr>
                        <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td colspan=3>";
                        if (isset($_GET['setuju']) && !isset($_GET['tolak'])){
                            echo"<input type=checkbox name=setuju id=setuju value=Setuju checked>Setuju";
                            echo"<input type=checkbox name=tolak id=tolak value=Tolak unchecked>Tolak";
                        }
                        if (isset($_GET['tolak'])&& !isset($_GET['setuju'])){
                            echo"<input type=checkbox name=setuju id=setuju value=Setuju unchecked>Setuju";
                            echo"<input type=checkbox name=tolak id=tolak value=Tolak checked>Tolak";   
                        }
                        if (isset($_GET['tolak']) && isset($_GET['setuju'])){
                            echo"<input type=checkbox name=setuju id=setuju value=Setuju checked>Setuju";
                            echo"<input type=checkbox name=tolak id=tolak value=Tolak checked>Tolak";
                        }
                        if (!isset($_GET['tolak']) && !isset($_GET['setuju'])){
                            echo"<input type=checkbox name=setuju id=setuju value=Setuju unchecked>Setuju";
                            echo"<input type=checkbox name=tolak id=tolak value=Tolak unchecked>Tolak";
                        }  
                        echo"</td>
                        </tr>
                        <tr>
                        <td colspan=6><input type=submit value='Tampilkan Data' style='height:38px; width:90px'>                      
                        <button type=button onclick='rpt();' value='+' >                 
                            <img border='0' src=\"../images/Excel.png\" width=\"25\" height=\"30\" border=\"0\" title='Click Me'/>
                        </button>                        
                        </td>
                        </tr>        
                        </table>
			</form>  <br> "
                        
                         
. "<script>
 function rpt()
 {
 if(document.getElementById('negara').value == '' && document.getElementById('perwakilan').value == '' && document.getElementById('tgl_cr_aju1').value == '' && document.getElementById('tgl_cr_aju2').value == '' && document.getElementById('nm_diplomat').value == '' && document.getElementById('setuju').checked==false && document.getElementById('tolak').checked==false){
  alert('Field pencarian tidak boleh kosong semua');
 }else{
  var a=document.getElementById('negara').value;
  var b=document.getElementById('perwakilan').value;
  var c=document.getElementById('tgl_cr_aju1').value;
  var d=document.getElementById('tgl_cr_aju2').value;
  var e=document.getElementById('nm_diplomat').value;
  if(document.getElementById('setuju').checked==true && document.getElementById('tolak').checked==false){
  var f=document.getElementById('setuju').value;
  var g='';
  }
  if(document.getElementById('tolak').checked==true && document.getElementById('setuju').checked==false){
  var g=document.getElementById('tolak').value;
  var f='';
  }
  if(document.getElementById('tolak').checked==true && document.getElementById('setuju').checked==true){
  var f=document.getElementById('setuju').value;
  var g=document.getElementById('tolak').value;
  }
  window.location='report.php?go=statistik_staf&negara='+a+'&perwakilan='+b+'&tgl_cr_aju1='+c+'&tgl_cr_aju2='+d+'&nm_diplomat='+e+'&setuju='+f+'&tolak='+g;
}
}
 </script>";
 //break;      
 
//case "cari";
    //echo"<script>alert('tes cari, $_GET[perwakilan]');</script>";
    

 echo"<table width=100%>
          <tr><th width=2%>no</th><th width=21%>Nama</th><th width=21%>KANTOR</th><th width=21%>NEGARA</th><th width=5%>STATUS</th><th width=5%>SPIRIT(1)</th><th width=5%>ANGGUR(2)</th><th width=5%>ROKOK(3)</th><th width=5%>1+2</th><th width=10%>JML (1+2+3)</th></tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);
   
    if (isset($_GET['tgl_cr_aju1']) && isset($_GET['tgl_cr_aju2']) && !empty($_GET['tgl_cr_aju1']) && !empty($_GET['tgl_cr_aju2'])){
        $w1="and (tgl_nota_pengajuan between '$_GET[tgl_cr_aju1]' and '$_GET[tgl_cr_aju2]') ";
        $tgl_pengajuan_rpt="Tanggal Pengajuan Periode <u>$_GET[tgl_cr_aju1]</u> s.d <u>$_GET[tgl_cr_aju2]</u>";
    }
    if (isset($_GET['negara'])&& !empty($_GET['negara'])){
        $w2="and NEGARA like '%$_GET[negara]%' ";
        $negara_rpt="|| Negara <u>$_GET[negara]</u>";
    }
     if (isset($_GET['perwakilan'])&& !empty($_GET['perwakilan'])){
        $w3="and NM_KNT_PERWAKILAN like '%$_GET[perwakilan]%'";
        $knt_perwakilan="|| Kantor Perwakilan <u>$_GET[perwakilan]</u>";
    }
     
     if (isset($_GET['nm_diplomat'])&& !empty($_GET['nm_diplomat'])){
        $w4="and NM_DIPLOMAT like '%$_GET[nm_diplomat]%'";
        $nm_diplomat_rpt ="|| Nama Diplomat <u>$_GET[nm_diplomat]</u>";
    }
    
    if (isset($_GET['setuju'])&& !empty($_GET['setuju']) && isset($_GET['tolak'])&& !empty($_GET['tolak']) && $_GET['setuju']!='undefined' && $_GET['tolak']!='undefined'){
            $w5="";
            $setuju_tolak ="|| Status Pengajuan <u>$_GET[setuju]</u> & <u>$_GET[tolak]</u>";
        }elseif ($_GET['setuju']=='undefined' && $_GET['tolak']=='undefined'){
            $w5="";
            $setuju_tolak ="";
        }elseif (isset($_GET['setuju']) && !empty($_GET['setuju']) && empty($_GET['tolak'])){
            $w5="and status_pengajuan = 'Setuju'";
            $setuju_tolak ="|| Status Pengajuan <u>$_GET[setuju]</u>";
        }elseif (empty($_GET['setuju']) && !empty($_GET['tolak']) && isset($_GET['tolak'])){
            $w5="and status_pengajuan = 'Tolak'";
            $setuju_tolak ="|| Status Pengajuan <u>$_GET[tolak]</u>";
        }
        
    
    echo"Hasil pencarian berdasarkan : $tgl_pengajuan_rpt $negara_rpt $knt_perwakilan $nm_diplomat_rpt $setuju_tolak";
		$sql="SELECT NM_DIPLOMAT,NM_KNT_PERWAKILAN, NEGARA, status_pengajuan, sum(jumlah_pengajuan_spirit) as spirit, sum(jumlah_pengajuan_anggur) as anggur, sum(jumlah_pengajuan_rokok) as rokok,sum(jumlah_pengajuan_spirit + jumlah_pengajuan_anggur) as jml_spr_angr,
SUM(jumlah_pengajuan_spirit + jumlah_pengajuan_anggur + jumlah_pengajuan_rokok) as total   
FROM v_report_miras_staf where status_pengajuan is not NULL $w1 $w2 $w3 $w4 $w5
GROUP BY NM_DIPLOMAT,NM_KNT_PERWAKILAN, NEGARA, status_pengajuan
order by total DESC limit $posisi,$batas";
            
//echo $sql;
		$tampil=mysql_query($sql);


   
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

      echo "<tr><td>$no</td>
                <td>$r[NM_DIPLOMAT]</td>
                <td>$r[NM_KNT_PERWAKILAN]</td>
                <td>$r[NEGARA]</td>
				<td>$r[status_pengajuan]</td>		
				<td>$r[spirit]</td>
                                <td>$r[anggur]</td>
                                <td>$r[rokok]</td>
                                <td>$r[jml_spr_angr]</td>
                                <td>$r[total]</td>";
                                //edit andri 14092016 tambah if user miras maka bisa tambah pengajuan miras
                  
		        echo"</tr>";
      $no++;
    }

    echo "</table>";

		$jmldata =mysql_num_rows(mysql_query("SELECT NM_DIPLOMAT,NM_KNT_PERWAKILAN, NEGARA, status_pengajuan, sum(jumlah_pengajuan_spirit) as spirit, sum(jumlah_pengajuan_anggur) as anggur, sum(jumlah_pengajuan_rokok) as rokok,sum(jumlah_pengajuan_spirit + jumlah_pengajuan_anggur) as jml_spr_angr,
SUM(jumlah_pengajuan_spirit + jumlah_pengajuan_anggur + jumlah_pengajuan_rokok) as total   
FROM v_report_miras_staf where status_pengajuan is not NULL $w1 $w2 $w3 $w4
GROUP BY NM_DIPLOMAT,NM_KNT_PERWAKILAN, NEGARA, status_pengajuan
order by total DESC"));
	
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
   $ilink = "?module=statistik_staf&nm_diplomat=$_GET[nm_diplomat]&tgl_cr_aju1=$_GET[tgl_cr_aju1]&tgl_cr_aju2=$_GET[tgl_cr_aju2]&perwakilan=$_GET[perwakilan]&negara=$_GET[negara]&setuju=$_GET[setuju]&tolak=$_GET[tolak]"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET['halaman'], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break; 

}
?>
