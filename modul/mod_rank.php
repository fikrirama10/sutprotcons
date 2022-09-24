<?php
switch($_GET[act]){
  // Tampil Berita
  default:

		echo "<h2>Master Rank </h2><br>
          <input type=button value='Tambah' onclick=location.href='?module=rank&act=tambahrank'>

		  <table width=100%>
          <tr>	<th width=30>no</th>
		  		<th width=180>Nama Rank</th>
				<th width=180>Official Name</th>
				<th width=30>Kode Layanan</th>
				<th >Keterangan</th>
				<th width=60>Aksi</th>
		  </tr>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

	$tampil=mysql_query("select * from `rank`order by NM_RANK limit $posisi,$batas");

    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

    echo "	<tr><td>$no</td>
			<td>$r[NM_RANK]</td>
			<td>$r[OFFICIAL_NM]</td>
			<td>$r[KODE_LAYANAN]</td>
			<td>$r[KET]</td>
			<td><a href=?module=rank&act=editrank&idt=$r[ID_RANK]>Edit</a> 
			<!--|<a href=./aksi_rank.php?module=rank&act=hapus&idt=$r[ID_RANK] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NM_RANK] ?')\">Hapus</a>-->
			</td></tr>";
      $no++;
    }
    echo "</table>";
  	$jmldata =mysql_num_rows(mysql_query("select * from `rank`"));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
	$ilink = "?module=rank";
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
    echo "<div id=paging>$linkHalaman</div><br>";
    break;

  case "tambahrank":
    echo "<h2>Tambah Master Rank</h2>
          <form method=POST action='./aksi_rank.php?module=rank&act=input' enctype='multipart/form-data'>
          	<table width=90%>
          	<tr><td width=120>Nama Rank</td >  <td > : <input type=text name='NM_RANK' size=50></td></tr>
		  	<tr><td >Official Name</td >  <td > : <input type=text name='OFFICIAL_NAME' size=50></td></tr>
			<tr><td >Kode Layanan</td >  <td > : <input type=text name='KODE_LAYANAN' size=50></td></tr>
		  	<tr><td >Keterangan</td >  <td > : <select name='KET' >
            <option value=Diplomatik selected>Diplomatik</option>
            <option value=Dinas>Dinas</option></select> </td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Simpan> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;

  case "editrank":
    $idt = $_GET[idt];
    $edit = mysql_query("select * from `rank` where ID_RANK = $idt ");
    $r    = mysql_fetch_array($edit);

    if($_SESSION[G_leveluser]=='20'){
        $r0 = 'readonly';
    }
 	echo "<h2>Edit Rank</h2>
         <form method=POST enctype='multipart/form-data' action='./aksi_rank.php?module=rank&act=update'>
         <input type=hidden name=idt value='$r[ID_RANK]'>
         	<table width=90%>
		  	<tr><td width=120>Nama Rank</td >  <td > : <input type=text name='NM_RANK' value='$r[NM_RANK]' size=50 $r0></td></tr>
			<tr  bgcolor='#ffcc00'><td >Official Name</td >  <td > : <input type=text name='OFFICIAL_NM' value='$r[OFFICIAL_NM]' size=50></td></tr>
		  	<tr><td >Kode Layanan</td >  <td > : <input type=text name='KODE_LAYANAN' value='$r[KODE_LAYANAN]' size=50 $r0></td></tr>
		  	<tr><td >Keterangan</td >  <td > : <select name='KET' >";

			if ($r[KET]== "Diplomatik") {
			echo "<option value=Diplomatik selected>Diplomatik</option>
            <option value=Dinas>Dinas</option></select> </td></tr>";
		  	}else{
			echo "<option value=Diplomatik >Diplomatik</option>
            <option value=Dinas selected>Dinas</option></select> </td></tr>";
			}

			echo "
			<tr><td></td><td align=right><input type=submit value=Update> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;

}
?>
