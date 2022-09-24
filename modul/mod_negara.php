<?php
switch($_GET[act]){
  // Tampil Berita
  default:

		echo "<h2>Master Kewarganegaraan/Negara </h2>
			 <br>
          <input type=button value='Tambah' onclick=location.href='?module=negara&act=tambahnegara'><br /><br />
          <table style=width:100% name=tablenegara id=tablenegara class=display>
            <thead>
              <tr><th width=5%>no</th>
                <th width=20%>Kewarganegaraan/Negara</th>
                <th width=20%>REGIONAL</th>
                <th width=20%>Country Name</th>
                <th width=25%>Official Country Name</th>
                <th width=20%>AKSI</th></tr>
            </thead>
            <tbody>";

    // $p      = new Paging;  //untuk Paging
    // $batas  = 10;
    // $posisi = $p->cariPosisi($batas);

	 // $tampil=mysql_query("select ID_NEGARA,NEGARA,BENDERA,KET,NEG_RANTOR_K,NEG_RANTOR_I,KD_REGIONAL,NM_REGIONAL, NM_STATES, NM_RESMI FROM m_negara where ID_NEGARA > 1 order by NEGARA limit $posisi,$batas");

   $tampil=mysql_query("select ID_NEGARA,NEGARA,BENDERA,KET,NEG_RANTOR_K,NEG_RANTOR_I,KD_REGIONAL,NM_REGIONAL, NM_STATES, NM_RESMI FROM m_negara where ID_NEGARA > 1 order by NEGARA");

    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){


      echo "<tr><td>$no</td>
				<td><img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" />
				&nbsp $r[NEGARA] </td><td> $r[NM_REGIONAL] </td>
				<td>$r[NM_STATES]</td>
				<td>$r[NM_RESMI]</td>
		            <td align=center><a href=?module=negara&act=editnegara&idt=$r[ID_NEGARA]>Edit</a>
					<!--|<a href=./aksi_negara.php?module=negara&act=hapus&idt=$r[ID_NEGARA] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NEGARA] ?')\">Hapus</a>-->
					</td>
		        </tr>";
      $no++;
    }
    echo "</tbody>
          <tfoot>
          <tr><th></th>
            <th>Kewarganegaraan/Negara</th>
            <th>Regional</th>
            <th>Country Name</th>
            <th>Official Name</th>
            <th></th></tr>
          </tfoot></table>";

  // $jmldata =mysql_num_rows(mysql_query("SELECT NEGARA FROM  m_negara where ID_NEGARA > 1"));
	// $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
  // $ilink = "?module=negara";
  // $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
  //
  //   echo "<div id=paging>$linkHalaman</div><br>";
    break;

  case "tambahnegara":
    echo "<h2>Tambah Kewarganegaraan/Negara</h2>
          <form method=POST action='./aksi_negara.php?module=negara&act=input' enctype='multipart/form-data'>
          <table width=90%>
          <tr><td width=120>Negara</td >  <td > : <input type=text name='negara' size=50></td></tr>
		  <tr><td>Bendera</td>     <td > : <input type=file size=40 name=fupload></td></tr>
		  <tr><td width=120>Kode Regional</td >  <td > : <input type=text name='KD_REGIONAL' size=50></td></tr>
		  <tr><td width=120>Regional</td >  <td > : <input type=text name='NM_REGIONAL' size=50></td></tr>
		  <tr><th colspan=2 height=30><div align=left >Jumlah fasilitas diberikan ke Indonesia</div></th></tr>
		  <tr><td width=120>Rantor Individu</td >  <td > : <input type=text name='NEG_RANTOR_I' size=50></td></tr>
		  <tr><td width=120>Eantor Kantor</td >  <td > : <input type=text name='NEG_RANTOR_K' size=50></td></tr>

		  <tr><td></td><td align=right><input type=submit value=Simpan> <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;

  case "editnegara":
    $idt = $_GET[idt];
    $edit = mysql_query("select ID_NEGARA,NEGARA,BENDERA,KET,NEG_RANTOR_K,NEG_RANTOR_I,KD_REGIONAL,NM_REGIONAL,NM_RESMI,NM_STATES  from m_negara where ID_NEGARA = $idt ");
    if($edit === FALSE) {
		die(mysql_error()); // TODO: better error handling
	}

	while($r = mysql_fetch_array($edit))
	{

    if($_SESSION[G_leveluser]=='20'){
        $r0 = 'readonly';
    }

		echo "<h2>Edit Kewarganegaraan/Negara</h2>
          <form method=POST enctype='multipart/form-data' action='./aksi_negara.php?module=negara&act=update'>
         <input type=hidden name=idt value='$r[ID_NEGARA]'>

		  <table width=90%>
		  <tr><td width=120>Negara</td >  <td > : <input type=text name='negara' value='$r[NEGARA]' size=50 $r0></td></tr>";
		echo "<tr><td>Bendera</td>     <td > : <input type=file size=40 name=fupload></td></tr>

		<tr><td width=120>Kode Regional</td >  <td > : <input type=text name='KD_REGIONAL' value='$r[KD_REGIONAL]' size=50 $r0></td></tr>
		  <tr><td width=120>Regional</td >  <td > : <input type=text name='NM_REGIONAL'  value='$r[NM_REGIONAL]' size=50 $r0></td></tr>

		  <tr bgcolor='#ffcc00'><td width=120>Country Name</td >  <td > : <input type=text  value='$r[NM_STATES]' name='NM_STATES' size=50></td></tr>
		  <!--<tr bgcolor='#ffcc00'><td width=120>Official Country Name</td >  <td > : <input type=text  value=\"$r[NM_RESMI]\" name='NM_RESMI' size=50></td></tr>-->

		  <tr><th colspan=2 height=30><div align=left >Jumlah fasilitas diberikan ke Indonesia</div></th></tr>
		  <tr><td width=120>Rantor Individu</td >  <td > : <input type=text  value='$r[NEG_RANTOR_I]' name='NEG_RANTOR_I' size=50 $r0></td></tr>
		  <tr><td width=120>Rantor Kantor</td >  <td > : <input type=text  value='$r[NEG_RANTOR_K]' name='NEG_RANTOR_K' size=50 $r0></td></tr>
		  <tr><td></td><td align=right><input type=submit value=Update> <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>
        ";
		break;
	}




}
?>


<style type="text/css">
thead input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>

<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
		$('#tablenegara tfoot th').each(function(){
				var title = $(this).text();
        $(this).html('<input type="text" placeholder="'+title+'" />');

				var r = $('#tablenegara tfoot tr');
				$('#tablenegara thead').append(r);
    });

    // DataTable
    var table = $('#tablenegara').DataTable();

    //Apply the search
    table.columns().every( function (){
        var that = this;

        $('input', this.header()).on('keyup change', function(){
            if (that.search() !== this.value){
                that
                    .search(this.value)
                    .draw();
            }
        });

				$('input', this.header()).on('click', function(d){
						d.stopPropagation();
				});
    });
});
</script>
