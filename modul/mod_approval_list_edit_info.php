<?php
session_start();

//session_register("G_sql_lap");
$template = file("../template/canvasawal.htm");
$template = implode("",$template );

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){

$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";

$template = eregi_replace("{isi}",$varname,$template);
echo $template;

}else{

switch($_GET[act]){

  default:

	 echo "<h2>Daftar Permohonan Perubahan Data Informasi Kantor Perwakilan</h2>

   <table width=100% id=cariStayPermit name=cariStayPermit class=display>
   <thead>
   <tr><th width=10 >No</th>
   <th  width=400 >Kantor Perwakilan/Organisasi</th>
   <th  width=200 >Tanggal Pengajuan</th>
   <th  width=200 >Status</th>
<th width=100>ACTION</th></tr></thead><tbody>	";

$sql= "SELECT
          	*
          FROM
          	`tbl_update_basic_info` `tbl_update_basic_info`
          		INNER JOIN `m_kantor_perwakilan`
          		`m_kantor_perwakilan`
          		ON `tbl_update_basic_info`.`ID_KNT_PERWAKILAN` = `m_kantor_perwakilan`.
          		`ID_KNT_PERWAKILAN`
          			INNER JOIN `m_negara` `m_negara`
          			ON `m_kantor_perwakilan`.`ID_NEGARA` = `m_negara`.`ID_NEGARA`
                ORDER BY `tbl_update_basic_info`.`id_update_basic_info` DESC";

$tampil=mysql_query($sql);

$no = $posisi+1;
while($rr=mysql_fetch_array($tampil)){
  if ($rr['status']=='Approved' || $rr['status']=='Rejected'){
    $link = "<a href=?module=approval_list_edit_info&act=approval_form&idt=$rr[id_update_basic_info]>Detail</a>";
  } else {
    $link = "<a href=?module=approval_list_edit_info&act=approval_form&idt=$rr[id_update_basic_info]&>Verifikasi</a>";
  }
echo "<tr><td>$no</td>
<td>$rr[NEGARA]</td>
<td>$rr[submit_date]</td>
<td>$rr[status]</td>
    <td align=center>$link</td>
 </tr>";
$no++;
}
echo "</tbody></table><br>";

break;


case "approval_form":
  $idt = $_GET['idt'];
  if (!empty($_POST['submit'])) {
    if ($_POST['submit']=='Setujui') {
      $sql_permohonan = "SELECT * FROM tbl_update_basic_info WHERE id_update_basic_info='".$_POST['id_update_basic_info']."'";
      $query = mysql_query($sql_permohonan);
      $row = mysql_fetch_array($query);

      $sql_update_approval = "UPDATE tbl_update_basic_info
            	SET status='Approved', approval_by='".$_SESSION[G_namauser]."',   approval_date=NOW() WHERE id_update_basic_info='".$_POST['id_update_basic_info']."'";
            // echo   $sql_update_approval; exit;
      mysql_query($sql_update_approval);
      $sql_update_m_perwakilan = "UPDATE
                    	m_kantor_perwakilan
                    SET
                    	ALAMAT='".$row['ALAMAT']."',
                    	KOTA='".$row['KOTA']."',
                    	TELP='".$row['TELP']."',
                    	FAX='".$row['FAX']."',
                    	EMAIL='".$row['EMAIL']."',
                    	WEB='".$row['WEB']."',
                    	OFFHOURS='".$row['OFFHOURS']."',
                    	NATIONALDAY='".$row['NATIONALDAY']."',
                    	KET_NATIONALDAY='".$row['KET_NATIONALDAY']."'
                    WHERE
                        ID_KNT_PERWAKILAN='".$_POST['ID_KNT_PERWAKILAN']."' ";
      mysql_query($sql_update_m_perwakilan);
       $msg = "<div class='w3-container w3-pale-success w3-leftbar-success'>
              BERHASIL melakukan persetujuan permohonan perubahan info dasar Kantor Perwakilan/Organisasi Internasional. </div>";
    } elseif ($_POST['submit']=='Tolak') {
      $sql_update_approval = "UPDATE tbl_update_basic_info
            	SET status='Rejected', reason='".$_POST['reason']."', approval_by='".$_SESSION[G_namauser]."', approval_date=NOW() WHERE id_update_basic_info='".$_POST['id_update_basic_info']."'";
      mysql_query($sql_update_approval);
        $msg = "<div class='w3-container w3-pale-success w3-leftbar-success'>
                BERHASIL melakukan PENOLAKAN permohonan perubahan info dasar Kantor Perwakilan/Organisasi Internasional.
                </div>";
     }
     else {
        $msg = "<div class='w3-container w3-pale-error w3-leftbar-error'>
       GAGAL melakukan proses Approval, Hubungi Administrator. </div>";
     }
    $idt = $_POST['id_update_basic_info'];
  }

  $sql= "SELECT `m_negara`.*,
            	`m_kantor_perwakilan`.*,
              `tbl_update_basic_info`. `ALAMAT` as alamat2,
              `tbl_update_basic_info`. `TELP` as telp2,
              `tbl_update_basic_info`. `FAX` as fax2,
              `tbl_update_basic_info`. `EMAIL` as email2,
              `tbl_update_basic_info`. `web` as web2,
              `tbl_update_basic_info`. `OFFHOURS` as OFFHOURS2,
              `tbl_update_basic_info`. `KET_NATIONALDAY` as KET_NATIONALDAY2,
              `tbl_update_basic_info`. `NATIONALDAY` as NATIONALDAY2,
              `tbl_update_basic_info`. `NOTA_DIPLOMATIC_FILE` as NOTA_DIPLOMATIC_FILE,
              `tbl_update_basic_info`. `reason` as reason,
              `tbl_update_basic_info`. `OFFHOURS` as OFFHOURS2,
              `tbl_update_basic_info`. `id_update_basic_info` as id_update_basic_info,
              `tbl_update_basic_info`. `status` as status
            FROM
            	`tbl_update_basic_info` `tbl_update_basic_info`
            		INNER JOIN `m_kantor_perwakilan`
            		`m_kantor_perwakilan`
            		ON `tbl_update_basic_info`.`ID_KNT_PERWAKILAN` = `m_kantor_perwakilan`.
            		`ID_KNT_PERWAKILAN`
            			INNER JOIN `m_negara` `m_negara`
            			ON `m_kantor_perwakilan`.`ID_NEGARA` = `m_negara`.`ID_NEGARA`
                  WHERE `tbl_update_basic_info`.`id_update_basic_info` = '$idt'";
   // echo $sql; exit;
  $tampil=mysql_query($sql);
  $data=mysql_fetch_array($tampil);
  if ($data['status'] == 'pending'){
      $button ="<input type=submit name=submit value=Setujui>
      <input type=submit name=submit value=Tolak>
      <input type=button value=Batal onclick=self.history.back()>";
  }
  else
  {
      $button = "<input type=button value=Kembali onclick=self.history.back()>";
  }
  echo "<h2>Formulir Approval Perubahan Info Perwakilan/Organisasi</h2>
        $msg
        <form method=POST class='table-puz' action='./deplu.php?module=approval_list_edit_info&act=approval_form' enctype='multipart/form-data'>
        <table width=100% >
        <tr>
            <th colspan='2'>Data Saat Ini</th>
            <th colspan='2'>Permohonan Perubahan Menjadi</th>
        </tr>
        <tr>
            <td >Negara/Organisasi</td ><td> : $data[NEGARA]</td>
            <td>Negara/Organisasi</td><td >: $data[NEGARA]</td>
        </tr>
        <tr>
            <td>Alamat</td><td> : $data[ALAMAT]</td>
            <td>Alamat</td><td> : $data[alamat2]</td>
        </tr>
        <tr>
            <td>Telp</td><td> : $data[TELP]</td>
            <td>Telp</td><td > : $data[telp2]</td>
        </tr>
        <tr>
            <td>Fax</td><td > : $data[FAX]</td>
            <td>Fax</td><td > : $data[fax2]</td>
        </tr>
        <tr>
            <td>Email</td>     <td > : $data[EMAIL]</td>
            <td>Email</td>     <td > : $data[email2]</td>
        </tr>
        <tr>
            <td>Web</td>     <td > : $data[WEB]</td>
            <td>Web</td>     <td > : $data[web2]</td>
        </tr>
        <tr>
            <td>Official Hours</td>     <td > : $data[OFFHOURS]</td>
            <td>Official Hours</td>     <td > : $data[OFFHOURS2]</td>
        </tr>
        <tr>
            <td>National Day</td>     <td > : $data[KET_NATIONALDAY]</td>
            <td>National Day</td>     <td > : $data[KET_NATIONALDAY2]</td>
        </tr>
        <tr>
            <td>National Day Date</td>     <td > : $data[NATIONALDAY]</td>
            <td>National Day Date</td>     <td > : $data[NATIONALDAY2]</td>
        </tr>
        <tr>
            <td> </td>
            <td> </td><td>Nota Diplomatik</td>     <td > : <a target='blank' href='./view_file.php?fn=$data[NOTA_DIPLOMATIC_FILE]'>$data[NOTA_DIPLOMATIC_FILE]</a></td>
        </tr>
        <tr>
            <td></td>     <td > </td><td>Submit Date</td>     <td > : $data[submit_date]</td>
        </tr>
        <tr>
            <td></td>     <td > </td><td>Submit By</td>     <td > : $data[submit_by]</td>
        </tr>
        <tr>
            <td></td>     <td > </td><td>Approval Status</td>     <td > : $data[status]</td>
        </tr>
        <tr>
            <td></td>     <td > </td><td>Approval Date</td>     <td > : $data[approval_date]</td>
        </tr>
        <tr>
            <td></td>     <td > </td><td>Approval By</td>     <td > : $data[approval_by]</td>
        </tr>
        <tr>
            <td>Alasan penolakan, jika diperlukan:</td><td align=left colspan='3'>
            <textarea cols='50' name='reason' rows='5'>$data[reason]</textarea></td>
        </tr>
        <tr>
            <td align=left colspan='4'>$button</td>
        </tr>
        </table>
        <input type='hidden' name='id_update_basic_info' value='$data[id_update_basic_info]'>
        <input type='hidden' name='ID_KNT_PERWAKILAN' value='$data[ID_KNT_PERWAKILAN]'>
        </form>";

break;
  }
}
?>
<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
		$('#cariStayPermit tfoot th').each(function(){
				var title = $(this).text();
        $(this).html('<input type="text" placeholder="'+title+'" />');

				var r = $('#cariStayPermit tfoot tr');
				$('#cariStayPermit thead').append(r);
    });

    // DataTable
    var table = $('#cariStayPermit').DataTable();

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
