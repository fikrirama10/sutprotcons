<?php
session_start();

//session_register("G_sql_lap");
$template = file("../template/canvasawal.htm");
$template = implode("",$template );
?>
<style type="text/css">
.tgl_filter {
	margin-left: 0px;
	margin-right: 0px;
	font-family: Tahoma;
	font-size: 10pt;
}	
</style>
<?php

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){

	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";

	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

} else {

	switch($_GET['act']) {

		default:
			// table width total 910
			echo '<h2>Log Activity User Kementerian / Lembaga</h2>';
			echo '
			<form method=POST action="./deplu.php?module=log_kml">
				<table width="100%">
				<tr>
					<td width="150">Instansi</td>  <td > : 
						<select name="instansi">
							<option value="" selected>- ALL -</option>';
			/*							
			$sql_pil = " SELECT 
						CONCAT(COALESCE(`tbl_user_kml`.`instansi`,''), COALESCE(`tbl_user_kml`.`instansi_lain`,'')) AS `instansi_txt` 
						FROM `tbl_user_kml`
						GROUP BY `instansi_txt`
						ORDER BY `instansi_txt`
					";
			*/
			$sql_pil = " SELECT 
						`tbl_user_kml`.`instansi` AS `instansi_txt` 
						FROM `tbl_user_kml`
						WHERE `tbl_user_kml`.`instansi` IS NOT NULL
						GROUP BY `instansi`
						ORDER BY `instansi`
					";
			$tampil_pil = mysql_query($sql_pil);
			$fil_instansi = '';
			$selected_lain = '';
			if(isset($_POST['instansi'])) {
				if($_POST['instansi'] == 'Lainnya') {
					$selected_lain = 'selected';
					$fil_instansi = $_POST['instansi'];
				}
			}
			while($r_pil=mysql_fetch_array($tampil_pil)) {
				if(empty($r_pil['instansi_txt'])) { continue; }
				$selected = '';
				if(isset($_POST['instansi'])) {
					if($_POST['instansi'] == $r_pil['instansi_txt']) {
						$selected = 'selected';
						$fil_instansi = $_POST['instansi'];
					}
				}
				echo '<option value="'.$r_pil['instansi_txt'].'" '.$selected.'>'.$r_pil['instansi_txt'].'</option>';
			} ?>
							<option value="Lainnya" <?php echo $selected_lain; ?>>- Lainnya -</option>
    					</select>
    				</td></tr>
    				<?php
    					// tgl default
    					$tgl_dari = date('Y-m-d', strtotime('-30 days'));
    					$tgl_samp = date('Y-m-d');
    					if(isset($_POST['instansi'])) {
    						$tgl_dari = $_POST['tgl_dari'];
    						$tgl_samp = $_POST['tgl_samp'];
    					}
    				?>
					<tr><th colspan="2"><div align="left">Tanggal</div></th></tr>
					<tr>
						<td>Dari</td>
						<td><div id="tgl"><script>DateInput('tgl_dari', true, 'YYYY-MM-DD', '<?php echo $tgl_dari; ?>')</script></div></td>
					</tr>
					<tr>
						<td>Sampai Dengan</td>
						<td><div id="tgl"><script>DateInput('tgl_samp', true, 'YYYY-MM-DD', '<?php echo $tgl_samp; ?>')</script></div></td>
					</tr>

					<tr>
						<th colspan="2"><div align="left"><input type="submit" value="Filter"> </div></th>
					</tr>
		

		  </table></form>

			<table width="100%" id="list_data_table1" class="display">
			<thead>
			<tr>
				<th width="80">Login Time</th>
				<th width="150">User Kementerian / Lembaga</th>
				<th width="150">Reason for Login</th>
				<th>Page View</th>
			</tr></thead><tbody>
			<?php 
			$where = "";
			$where .= " AND DATE(`tbl_log_user_kml`.`login_time`) >= '".$tgl_dari."' ";
			$where .= " AND DATE(`tbl_log_user_kml`.`login_time`) <= '".$tgl_samp."' ";
			if(!empty($fil_instansi)) {
				if($fil_instansi == 'Lainnya') {
					$where .= " AND (`tbl_user_kml`.`instansi_lain` IS NOT NULL 
											OR 
											`tbl_user_kml`.`instansi_lain` != ''
										) ";
				} else {
					$where .= " AND (
										`tbl_user_kml`.`instansi` LIKE '".$fil_instansi."'
									)
								";
								/* 										OR
										`tbl_user_kml`.`instansi_lain` LIKE '".$fil_instansi."'
								*/
				}
			}
			$sql = " SELECT `tbl_log_user_kml`.*
							, `tbl_user_kml`.`id` AS `user_id` 
							, `tbl_user_kml`.`nama` AS `nama` 
							, `tbl_user_kml`.`instansi` AS `instansi` 
							, `tbl_user_kml`.`instansi_lain` AS `instansi_lain` 
						FROM `tbl_log_user_kml`
						LEFT JOIN `tbl_user_kml` ON `tbl_user_kml`.`id` = `tbl_log_user_kml`.`user_id`
						WHERE 1=1 ".$where."
						ORDER BY `tbl_log_user_kml`.`login_time` DESC, `tbl_log_user_kml`.`id` DESC";
			//echo $sql;
			$tampil = mysql_query($sql);

			$list = array();
			while($rr = mysql_fetch_array($tampil)) {
				$login_time_solid = str_replace(array(' ', ':', '-'), '', $rr['login_time']);
				if(!isset($list[$login_time_solid])) {
					$list[$login_time_solid] = array();
				}
				// group utama
				if(empty($rr['activity_time']) || empty($rr['page_view'])) {
					$instansi_txt = $rr['instansi'];
					if(empty($instansi_txt)) {
						$instansi_txt = $rr['instansi_lain'];
					}
					$list[$login_time_solid]['list_utama'] = array(
						  'login_time' 	=> $rr['login_time']
						, 'user_id' 		=> $rr['user_id']
						, 'nama' 			=> $rr['nama']
						, 'instansi_txt' 	=> $instansi_txt
						, 'reason_login' 	=> $rr['reason_login']
					);
				}

				// baris page view
				if(!empty($rr['activity_time'])) {
					$list[$login_time_solid]['list_page_view'][] = array(
				  		  'activity_time' => $rr['activity_time']
				  		, 'page_view' 		=> $rr['page_view']
					);
				}
			}

			$no = 1;
			$list_lt = '';


			//echo '<pre>';
			foreach ($list as $row) {
				//print_r($row);
				$login_time = '';
				$nama_txt = '';
				$reason_login = '';
				$list_pv = '';

				if(isset($row['list_page_view'])) {
					$list_pv .= '<table>';
					$page_view_arr = $row['list_page_view'];
					foreach ($page_view_arr as $row_pv) {
						$list_pv .= '<tr>';
						$list_pv .= ' <td>'.$row_pv['activity_time'].'</td>';
						$list_pv .= ' <td>'.$row_pv['page_view'].'</td>';
						$list_pv .= '</tr>';
					}
					$list_pv .= '</table>';
				}

				$login_time = $row['list_utama']['login_time'];
				$nama_txt = $row['list_utama']['nama'].'<br>'.$row['list_utama']['instansi_txt'];
				$nama_txt .= '<br><a href="?module=approval_kml&act=approval_form&id='.$row['list_utama']['user_id'].'" target="_blank">Detail</a>';
				$reason_login = $row['list_utama']['reason_login'];
				$list_lt .= '<tr>
							<td style="text-align: center;">'.$login_time.'</td>
							<td>'.$nama_txt.'</td>
							<td>'.$reason_login.'</td>
							<td>'.$list_pv.'</td>
						</tr>';
				$no++;
			}
			echo $list_lt;
			echo "</tbody></table><br>";
		break;
	}
}
?>
<script>
	$(document).ready(function() {
		<?php /*
		// Setup - add a text input to each footer cell
		$('#cariStayPermit tfoot th').each(function(){
			var title = $(this).text();
			$(this).html('<input type="text" placeholder="'+title+'" />');

			var r = $('#cariStayPermit tfoot tr');
			$('#cariStayPermit thead').append(r);
		});
		*/ ?>

		// DataTable
		var table1 = $('#list_data_table1').DataTable({
			"order": [[ 0, "desc" ]]
		});

		//Apply the search
		table1.columns().every( function (){
			var that = this;

			$('input', this.header()).on('keyup change', function(){
				if (that.search() !== this.value) {
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
