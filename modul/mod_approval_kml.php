<?php
session_start();

//session_register("G_sql_lap");
$template = file("../template/canvasawal.htm");
$template = implode("",$template );



function kirim_mail($email_to, $status, $data = array()) {
	if(!in_array($status, array('setuju', 'tolak'))) { return; }
	$bcc	 = 'BCC : sesdjprotkons@kemlu.go.id';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: NO REPLY - Layanan Protokol Konsuler Kementerian Luar Negeri RI <no-reply.sito@kemlu.go.id>' . "\r\n".$bcc;

	if($status == 'setuju') {
		$subject = 'Notifikasi persetujuan user Kementerian / Lembaga, '.$data['nama'].' telah Disetujui';
		$msg_box = 'Pendaftaran anda telah kami setujui. Anda dapat login menggunakan Username dan Password yang telah anda daftarkan pada situs layanandiplomatik.kemlu.go.id';
	}
	if($status == 'tolak') {
		$subject = 'Notifikasi persetujuan user Kementerian / Lembaga, '.$data['nama'].' telah Ditolak';
		$msg_box = 'Pendaftaran anda telah kami tolak.';
	}
	$msg = "
		<html>
			<body>
				<p>Halo ".$data['nama']."</p>
				
				<p>Terima kasih telah melakukan pendaftaran pada Website Diplomatic and Consular List Kementerian Luar Negeri RI.
				</p>
				<br>".$msg_box."
				<br><br>
				Pertanyaan lebih lanjut dapat disampaikan melalui email sesdjprotkons@kemlu.go.id atau nomor telepon (021) 381-3376 Ext 3007
				<br><br>
				Salam,<br><br>
				Sekretariat Direktorat Jenderal Protokol dan Konsuler<br>
				Kementerian Luar Negeri RI
			</body>
		</html>
	";

	return mail($email_to, $subject, $msg, $headers);

}

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){

	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";

	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

} else {

	/*
		1. pending -> baru register
		2. active -> diterima
		3. reject -> ditolak
		4. inactive -> dihapus (gak muncul di list app, tp di db masih ada)
	*/
	$status_arr = array(
		 1 => 'Pending'
		,2 => 'Active'
		,3 => 'Rejected'
		,4 => 'Deleted'
	);

	switch($_GET['act']) {

		default:

			echo "<h2>Daftar Permohonan Akses Kementerian / Lembaga</h2>

			<table width=100% id=cariStayPermit name=cariStayPermit class=display>
			<thead>
			<tr>
				<th width=10>No</th>
				<th width=200>Nama & Email</th>
				<th width=200>Kementerian / Lembaga</th>
				<th width=200>Document</th>
				<th width=100>Tanggal Sign Up</th>
				<th width=100>Status</th>
				<th width=100>ACTION</th>
			</tr></thead><tbody>";

			$sql = " SELECT * FROM `tbl_user_kml`
						WHERE `status` != 4
						ORDER BY `id` DESC";

			$tampil=mysql_query($sql);

			$no = $posisi+1;

			while($rr = mysql_fetch_array($tampil)) {
				if ($rr['status'] == 2 || $rr['status'] == 3) {
					$link = '<a href="?module=approval_kml&act=approval_form&id='.$rr['id'].'">Detail</a>';
				}
				if ($rr['status'] == 1) {
					$link = '<a href="?module=approval_kml&act=approval_form&id='.$rr['id'].'&">Verifikasi</a>';
				}
				//$link = '';
				$instansi = $rr['instansi'];
				if(empty($instansi)) {
					$instansi = $rr['instansi_lain'];
				}
				$status_txt = $status_arr[$rr['status']];
				$kol1_txt =  $rr['nama']. '<br>'. $rr['email_dinas'];
				$kol2_txt = $instansi;
				$dok_txt = '<a href="./view_file_kml.php?fn='.$rr['identitas_diri'].'" target="_blank">[Identitas]</a> &nbsp; <a href="./view_file_kml.php?fn='.$rr['surat_permohonan'].'" target="_blank">[SP]</a>
				';
				echo '<tr>
							<td>'.$no.'</td>
							<td>'.$kol1_txt.'</td>
							<td>'.$kol2_txt.'</td>
							<td>'.$dok_txt.'</td>
							<td>'.$rr['waktu_daftar'].'</td>
							<td>'.$status_txt.'</td>
							<td align=center>'.$link.'</td>
						</tr>';
				$no++;
			}
			echo "</tbody></table><br>";

		break;


		case "approval_form":
			$id = $_GET['id'];
			if(isset($_POST['user_id_kml'])) {
				$id = $_POST['user_id_kml'];
			}
			if (!empty($_POST['submit'])) {
				$sql_permohonan = "SELECT * FROM tbl_user_kml WHERE id='".$_POST['user_id_kml']."' LIMIT 1";
				$query = mysql_query($sql_permohonan);
				$row = mysql_fetch_array($query);
				if ($_POST['submit'] == 'Setujui') {
					$sql_update_approval = "UPDATE tbl_user_kml
						SET status=2, approval_by='".$_SESSION[G_namauser]."',  approval_date=NOW() 
						WHERE id='".$_POST['user_id_kml']."'";
	            // echo   $sql_update_approval; exit;
					mysql_query($sql_update_approval);

					$msg = "<div class='w3-container w3-pale-success w3-leftbar-success'>
					BERHASIL melakukan PERSETUJUAN permohonan Akses Kementerian / Lembaga. </div>";

					// kirim_email
					kirim_mail($row['email_dinas'], 'setuju', $row);
				} elseif ($_POST['submit'] == 'Tolak') {
					$sql_update_approval = "UPDATE tbl_user_kml
					SET status=3, reason='".$_POST['reason']."', approval_by='".$_SESSION[G_namauser]."', approval_date=NOW() WHERE id='".$_POST['user_id_kml']."'";
					mysql_query($sql_update_approval);
					$msg = "<div class='w3-container w3-pale-success w3-leftbar-success'>
					BERHASIL melakukan PENOLAKAN permohonan Akses Kementerian / Lembaga.
					</div>";
					// kirim_email
					kirim_mail($row['email_dinas'], 'tolak', $row);
				} elseif ($_POST['submit'] == 'Hapus') {
					$sql_update_approval = "UPDATE tbl_user_kml
					SET status=4, reason='".$_POST['reason']."', approval_by='".$_SESSION[G_namauser]."', approval_date=NOW() WHERE id='".$_POST['user_id_kml']."'";
					mysql_query($sql_update_approval);
					$msg = "<div class='w3-container w3-pale-success w3-leftbar-success'>
					BERHASIL melakukan PENGHAPUSAN permohonan Akses Kementerian / Lembaga.
					</div>";
				} else {
					$msg = "<div class='w3-container w3-pale-error w3-leftbar-error'>
					GAGAL melakukan proses Approval, Hubungi Administrator. </div>";
				}
			}
		$sql= "  SELECT *
					FROM tbl_user_kml
					WHERE `id` = '".$id."' ";
   // echo $sql; exit;
		$tampil = mysql_query($sql);
		$data = mysql_fetch_array($tampil);
		$button = "<input type=button value=Kembali onclick=self.history.back()>";
		if ($data['status'] == 1) {
			$button = "
				<input type=submit name=submit value=Setujui>
				<input type=submit name=submit value=Tolak>
				<input type=submit name=submit value=Hapus>
				<input type=button value=Batal onclick=self.history.back()>
			";
		}
		if ($data['status'] == 2 || $data['status'] == 3) {
			$button = "
				<input type=submit name=submit value=Hapus>
				<input type=button value=Batal onclick=self.history.back()>
			";
		}

		$instansi_txt = $data['instansi'];
		if(empty($instansi_txt)) {
			$instansi_txt = $data['instansi_lain'];
		}
		$dok_1 = '<a href="./view_file_kml.php?fn='.$data['identitas_diri'].'" target="_blank">[Identitas]</a>
				';
		$dok_2 = '<a href="./view_file_kml.php?fn='.$data['surat_permohonan'].'" target="_blank">[SP]</a>
				';
		echo '<h2>Formulir Approval Akses Kementerian / Lembaga</h2>
		'.$msg.'
		<form method=POST class="table-puz" action="./deplu.php?module=approval_kml&act=approval_form"  enctype="multipart/form-data">
		<table width=100%>
		<tr>
			<th colspan="2">Data User</th>
		</tr>
		<tr>
			<td width="170">Nama</td>	<td> : '.$data['nama'].'</td>
		</tr>
		<tr>
			<td>Nomor Induk Pegawai</td>	<td> : '.$data['no_induk'].'</td>
		</tr>
		<tr>
			<td>Jabatan</td>	<td> : '.$data['jabatan'].'</td>
		</tr>
		<tr>
			<td>Satuan Kerja</td>	<td> : '.$data['satuan_kerja'].'</td>
		</tr>
		<tr>
			<td>Instansi</td>	<td> : '.$instansi_txt.'</td>
		</tr>
		<tr>
			<td>Nomor Telepon Kantor</td>	<td> : '.$data['no_telp_kantor'].'</td>
		</tr>
		<tr>
			<td>Nomor Handphone</td>	<td> : '.$data['no_hp'].'</td>
		</tr>
		<tr>
			<td>Alamat Email Dinas</td>	<td> : '.$data['email_dinas'].'</td>
		</tr>
		<tr>
			<td>Username</td>	<td> : '.$data['username'].'</td>
		</tr>
		<tr>
			<td>Identitas Diri</td>	<td> : '.$dok_1.'</td>
		</tr>
		<tr>
			<td>Surat Permohonan Instansi</td>	<td> : '.$dok_2.'</td>
		</tr>




		<tr>
			<td>Sign Up Date</td>			<td> : '.$data['waktu_daftar'].'</td>
		</tr>
		<tr>
			<td>Approval Status</td>	<td> : '.$status_arr[$data['status']].'</td>
		</tr>
		<tr>
			<td>Approval Date</td>		<td> : '.$data['approval_date'].'</td>
		</tr>
		<tr>
			<td>Approval By</td>			<td> : '.$data['approval_by'].'</td>
		</tr>
		<tr>
			<td>Alasan penolakan, jika diperlukan:</td><td align=left colspan="2">
		<textarea cols="50" name="reason" rows="5">'.$data['reason'].'</textarea></td>
		</tr>
		<tr>
			<td align=left colspan="2">'.$button.'</td>
		</tr>
		</table>
		<input type="hidden" name="user_id_kml" value="'.$data['id'].'">
		</form>';

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
