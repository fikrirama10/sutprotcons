<?php
switch($_GET[act]){
  // Tampil Berita
  default:

		if($_SESSION[G_leveluser]=='20'){  //usergroup sesditjen hanya untuk edit
			echo "<h2>Master Kantor Perwakilan</h2><br>
  		  <table width=100% name=tablekantor id=tablekantor class=display>
          <thead>
              <tr><th width=30>no</th>
  		  		  <th width=160>Kantor Perwakilan</th>
  				    <th>Official Name</th>
  				    <th>Negara</th>
  				    <th>Alamat</th>
  				    <th>Telp</th>
  				    <th width=60>AKSI</th></tr>
          </thead>
          <tbody>";
		}else{
			echo "<h2>Master Kantor Perwakilan </h2>
		        Pencarian : <form method=get action='./deplu.php?' enctype='multipart/form-data'>
				        <input type=hidden name=module value='kantor'>
				        <input type=hidden name=negara value='$_GET[negara]'>
				        Nama Kantor : <input type=text name=\"kantorperwakilan\"> <input type=submit value=Cari>
			      </form> <br>

      			<input type=button value='Tambah' onclick=location.href='?module=kantor&act=tambahkantor'><br /><br />

      		  <table width=100% name=tablekantor id=tablekantor class=display>
              <thead>
                  <tr><th width=30>no</th>
      		  		  <th width=160>Kantor Perwakilan</th>
      				    <th>Official Name</th>
      				    <th>Negara</th>
      				    <th>Alamat</th>
      				    <th>Telp</th>
      				    <th width=60>AKSI</th></tr>
              </thead>
              <tbody>";
		}


    // $p      = new Paging;
    // $batas  = 10;
    // $posisi = $p->cariPosisi($batas);

	// $tampil=mysql_query("select  a.ID_KNT_PERWAKILAN,a.NM_KNT_PERWAKILAN,a.OFFICIAL_NM,b.NEGARA,a.ALAMAT,a.TELP
	// 		from m_kantor_perwakilan a left join m_negara b on a.ID_NEGARA=b.ID_NEGARA
	// 		where a.ID_KNT_PERWAKILAN > 0 and  a.NM_KNT_PERWAKILAN like '%".$_GET[kantorperwakilan]."%'
	// 		order by a.NM_KNT_PERWAKILAN limit $posisi,$batas");

  $tampil=mysql_query("select  a.ID_KNT_PERWAKILAN,a.NM_KNT_PERWAKILAN,a.OFFICIAL_NM,b.NEGARA,a.ALAMAT,a.TELP
			from m_kantor_perwakilan a left join m_negara b on a.ID_NEGARA=b.ID_NEGARA
  		where a.ID_KNT_PERWAKILAN > 0 and  a.NM_KNT_PERWAKILAN like '%".$_GET[kantorperwakilan]."%'
  		order by a.NM_KNT_PERWAKILAN");

    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

	if($_SESSION[G_leveluser]=='20'){	//usergroup sesditjen hanya untuk edit
		echo "	<tr><td>$no</td>
				<td>$r[NM_KNT_PERWAKILAN]</td>
				<td>$r[OFFICIAL_NM]</td>
				<td>$r[NEGARA]</td>
				<td>$r[ALAMAT]</td>
				<td>$r[TELP]</td>
				<td><a href=?module=kantor&act=editkantor&idt=$r[ID_KNT_PERWAKILAN]>Edit</a> </td></tr>";
	}else{
		echo "	<tr><td>$no</td>
				<td>$r[NM_KNT_PERWAKILAN]</td>
				<td>$r[OFFICIAL_NM]</td>
				<td>$r[NEGARA]</td>
				<td>$r[ALAMAT]</td>
				<td>$r[TELP]</td>
				<td><a href=?module=kantor&act=editkantor&idt=$r[ID_KNT_PERWAKILAN]>Edit</a> |
					<a href=./aksi_kantor.php?module=kantor&act=hapus&idt=$r[ID_KNT_PERWAKILAN] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NM_KNT_PERWAKILAN] ?')\">Hapus</a></td></tr>";
	}
      $no++;
    }
    echo "</tbody>
          <tfoot>
              <tr><th></th>
              <th>Kantor Perwakilan</th>
              <th>Official Name</th>
              <th>Negara</th>
              <th>Alamat</th>
              <th>Telp</th>
              <th></th></tr>
    </tfoot></table>";

  	// $jmldata =mysql_num_rows(mysql_query("SELECT NM_KNT_PERWAKILAN FROM  m_kantor_perwakilan where ID_KNT_PERWAKILAN > 0"));
	  // $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
	  // $ilink = "?module=kantor";
    // $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
    // echo "<div id=paging>$linkHalaman</div><br>";
    break;

  case "tambahkantor":
    echo "<h2>Tambah Master Kantor Perwakilan</h2>
          <form method=POST action='./aksi_kantor.php?module=kantor&act=input' enctype='multipart/form-data'>
          	<table width=90%>
          	<tr><td width=120>Kantor Perwakilan</td >  <td > : <input type=text name='nm_knt_perwakilan' size=50></td></tr>
			<tr bgcolor='#ffcc00'><td width=120>Official Name</td >  <td > : <input type=text name='official_nm'  size=50></tr>

			<tr><td  width=120>Negara</td>  <td colspan=\"2\"> :
         		<select name='id_negara' id='id_negara'>
            	<option value=0 selected>- Pilih Jenis Perwakilan -</option>";
            	$tampil=mysql_query("SELECT * FROM m_negara ORDER BY NEGARA");
           			 	while($r=mysql_fetch_array($tampil)){
              				echo "<option value=$r[ID_NEGARA]>$r[NEGARA]</option>";
            			}echo "</select></td></tr>

			<tr><td  width=120>Jenis Perwakilan</td>  <td colspan=\"2\"> :
         		<select name='id_jns_perwakilan' >
            	<option value=0 selected>- Pilih Jenis Perwakilan -</option>";
            	$tampil=mysql_query("SELECT * FROM m_jns_perwakilan ORDER BY ID_JNS_PERWAKILAN");
           			 	while($r=mysql_fetch_array($tampil)){
              				echo "<option value=$r[ID_JNS_PERWAKILAN]>$r[NM_JNS_PERWAKILAN]</option>";
            			}echo "</select></td></tr>

			<tr><td  width=120>Sub Jenis Perwakilan</td>  <td colspan=\"2\"> :
         		<select name='id_sub_jns_perwakilan' >
            	<option value=0 selected>- Pilih Sub Jenis Perwakilan -</option>";
            	$tampil=mysql_query("SELECT * FROM m_sub_jns_perwakilan ORDER BY ID_SUB_JNS");
           			 	while($r=mysql_fetch_array($tampil)){
              				echo "<option value=$r[ID_SUB_JNS]>$r[NM_SUB_JNS]</option>";
            			}echo "</select></td></tr>

			<tr><td>Alamat </td>     <td > : <textarea name='alamat' rows=2 cols=50 ></textarea></td></tr>
          	<tr><td>Kota</td >  <td > : <input type=text name='kota' size=50></td></tr>
          	<tr><td>Telp</td >  <td > : <input type=text name='telp' size=50></td></tr>
          	<tr><td>Fax</td >  <td > : <input type=text name='fax' size=50></td></tr>
          	<tr><td>Email</td >  <td > : <input type=text name='email' size=50></td></tr>
          	<tr><td>Website</td >  <td > : <input type=text name='website' size=50></td></tr>
          	<tr><td>Office Hours</td >  <td > : <input type=text name='offhours' size=50></td></tr>
			<tr><td>National Day</td> <td> <DIV id=\"tgl\"> <script>DateInput('nationalday', true, 'YYYY-MM-DD')</script></div></td></tr>
			<tr><td>Keterangan </td>     <td > : <textarea name='ket' rows=2 cols=50 ></textarea></td></tr>
			<tr><td>Kode Agenda </td>     <td > :  <input type=text name='kode_agenda' size=50></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Simpan> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>";
     break;

  case "editkantor":
    $idt = $_GET[idt];

    $edit = mysql_query("select a.OFFICIAL_NM,a.ID_NEGARA, b.NEGARA, a.ID_JNS_PERWAKILAN, c.NM_JNS_PERWAKILAN, a.KODE_AGENDA, a.ID_SUB_JNS, d.NM_SUB_JNS,
a.ID_KNT_PERWAKILAN, a.NM_KNT_PERWAKILAN,a.ALAMAT,a.KOTA,a.TELP,a.FAX,a.EMAIL,a.WEB,a.OFFHOURS,a.NATIONALDAY,a.KET, a.KET_NATIONALDAY
from ((m_kantor_perwakilan a left join m_negara b on a.ID_NEGARA=b.ID_NEGARA) left join m_sub_jns_perwakilan d on d.ID_SUB_JNS =  a.ID_SUB_JNS) left join m_jns_perwakilan c on a.ID_JNS_PERWAKILAN=c.ID_JNS_PERWAKILAN
 where a.ID_KNT_PERWAKILAN = $idt ");

    $r    = mysql_fetch_array($edit);

    if($_SESSION[G_leveluser]=='20'){
        $r0 = 'readonly';
        $r1 = 'disabled';
    }
 	echo "<h2>Edit Kantor Perwakilan</h2>
         <form method=POST enctype='multipart/form-data' action='./aksi_kantor.php?module=kantor&act=update'>
         <input type=hidden name=idt value='$r[ID_KNT_PERWAKILAN]'>
         <table width=90%>
		  	<tr><td width=120>Kantor Perwakilan</td >  <td > : <input type=text name='nm_knt_perwakilan' value='$r[NM_KNT_PERWAKILAN]' size='50'$r0></tr>
			<tr bgcolor='#ffcc00'><td width=120>Official Name</td >  <td > : <input type=text name='official_nm' value='$r[OFFICIAL_NM]' size=50></tr>




		<tr><td  width=120>Negara</td>  <td colspan=\"2\"> :
         		<select name='id_negara' id='id_negara'>";
            	$tampil=mysql_query("SELECT ID_NEGARA,NEGARA FROM m_negara ORDER BY NEGARA");
           		while($w=mysql_fetch_array($tampil)){
					if ($r[ID_NEGARA]==$w[ID_NEGARA]){
              			echo "<option value=$w[ID_NEGARA] selected>$w[NEGARA]</option>";
					}else{
						echo "<option value=$w[ID_NEGARA]>$w[NEGARA]</option>";
					}
            	}echo "</select></td></tr>




			 <tr><td  width=120>Jenis Perwakilan</td>  <td colspan=\"2\"> :
          <select name='id_jns_perwakilan' id='id_jns_perwakilan'>";
            $tampil=mysql_query("SELECT ID_JNS_PERWAKILAN,NM_JNS_PERWAKILAN FROM m_jns_perwakilan ORDER BY ID_JNS_PERWAKILAN");
            while($w=mysql_fetch_array($tampil)){
			if ($r[ID_JNS_PERWAKILAN]==$w[ID_JNS_PERWAKILAN]){
				echo "<option value=$w[ID_JNS_PERWAKILAN] selected>$w[NM_JNS_PERWAKILAN]</option>";
			}
			else{
				echo "<option value=$w[ID_JNS_PERWAKILAN]>$w[NM_JNS_PERWAKILAN]</option>";
			}
			}echo "</select></td>

			<tr><td  width=120>Sub Jenis Perwakilan</td>  <td colspan=\"2\"> :
          <select name='id_sub_jns' id='id_sub_jns'>";
          $tampil=mysql_query("SELECT ID_SUB_JNS,NM_SUB_JNS FROM m_sub_jns_perwakilan ORDER BY ID_SUB_JNS");
            while($w=mysql_fetch_array($tampil)){
			if ($r[ID_SUB_JNS]==$w[ID_SUB_JNS]){
				echo "<option value=$w[ID_SUB_JNS] selected>$w[NM_SUB_JNS]</option>";
			}
			else{
				echo "<option value=$w[ID_SUB_JNS]>$w[NM_SUB_JNS]</option>";
			}
			}echo "</select></td>



      <tr bgcolor='#ffefb2'><td>Alamat </td>    <td > : <textarea name='alamat' rows=3 cols=50 >$r[ALAMAT]</textarea></td></tr>
            <tr bgcolor='#ffefb2'><td>Kota</td >  <td > : <input type=text name='kota' value='$r[KOTA]' size=50></td></tr>
            <tr bgcolor='#ffefb2'><td>Telp</td >  <td > : <textarea name='telp' rows=3 cols=50 >$r[TELP]</textarea></td></tr>
            <tr bgcolor='#ffefb2'><td>Fax</td >  <td > : <input type=text name='fax'  value='$r[FAX]' size=50></td></tr>
            <tr bgcolor='#ffefb2'><td>Email</td >  <td > : <input type=text name='email' value='$r[EMAIL]' size=50></td></tr>
            <tr bgcolor='#ffefb2'><td>Website</td >  <td > : <input type=text name='website' value='$r[WEB]' size=50></td></tr>
            <tr bgcolor='#ffefb2'><td>Office Hours</td >  <td > : <textarea name='offhours' rows=3 cols=50 >$r[OFFHOURS]</textarea></td></tr>
			<tr bgcolor='#ffefb2'><td>National Day</td> <td> <DIV id=\"tgl\"> <script>DateInput('nationalday', true, 'YYYY-MM-DD','$r[NATIONALDAY]')</script></div>
            &nbsp;&nbsp;<input type=text name='ketnationalday' value=\"$r[KET_NATIONALDAY]\" size=50></td></tr>
			<tr><td>Keterangan </td>     <td > : <textarea name='ket'  rows=2 cols=50 $r0>$r[KET]</textarea></td></tr>
			<tr><td>Kode Agenda </td>     <td > :  <input type=text name='kode_agenda' value='$r[KODE_AGENDA]' size=50 $r0></td></tr>
		  	<tr><td></td><td align=right><input type=submit value=Update> <input type=button value=Batal onclick=self.history.back()></tr>
          </table></form>

		  ";
		   if($_SESSION[G_leveluser]=='20'){
				echo"
				<script>
          $('#id_negara').prop('disabled', true);          
          $('#id_sub_jns').prop('disabled', true);

		/*
		$('#id_jns_perwakilan').prop('disabled', true);
          $('#id_negara').focus(function(e) {
					   $(this).blur();
					});
          $('#id_jns_perwakilan').focus(function(e) {
					   $(this).blur();
					});
					$('#id_sub_jns').focus(function(e) {
					   $(this).blur();
          });
          */
				  </script>
				";
			}
     break;

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
		$('#tablekantor tfoot th').each(function(){
				var title = $(this).text();
        $(this).html('<input type="text" placeholder="'+title+'" />');

				var r = $('#tablekantor tfoot tr');
				$('#tablekantor thead').append(r);
    });

    // DataTable
    var table = $('#tablekantor').DataTable();

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
