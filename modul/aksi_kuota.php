<?php
//session_start();

session_start();
$template = file("../template/canvasawal.htm");
$template = implode("",$template ); 



if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){
	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{


include "../config/koneksi.php";
include "../config/library.php";

$module=$_GET[module];
$act=$_GET[act];
$idt=$_POST[idt];

switch ($module)
{
	//tambah quota
	case "tambah_quota_miras":
	
	
		if ($module=='tambah_quota_miras' AND $act=='hapus' AND isset($_GET[idt])){
			mysql_query("DELETE FROM m_kantor_perwakilan WHERE ID_KNT_PERWAKILAN = $_GET[idt]");
		}elseif($module=='tambah_quota_miras' AND $act=='tambahquotastaff' AND isset($_POST[idt]))
		{
			
			$kuota_thn = $_POST['quota_tahun'];	
			$kuota_tw1 = $_POST['quota_tw1'];
			$kuota_tw2 = $_POST['quota_tw2'];
			$kuota_tw3 = $_POST['quota_tw3'];
			$kuota_tw4 = $_POST['quota_tw4'];
			$id_rank =$_POST['id_rank'];
			$id_produk=$_POST['id_produk'];
			$id_negara=$_POST['idnegara'];
			$tahun=date("Y");
			$idm=$_POST[idt];
			$strtampil="select * from tbl_kuota_staff 
					where id_knt_perwakilan= $idt and id_produk=$id_produk and id_rank=$id_rank and tahun=$tahun";
			//echo $strtampil;
			//die;
			$sqltampil=mysql_query($strtampil);
			if (mysql_num_rows($sqltampil)==0)
			{
			
				$strsql="insert into tbl_kuota_staff
				(
				id_knt_perwakilan,
				id_negara,
				id_produk,
				id_rank,
				kuota_tahun,
				kuota_triwulan1,
				kuota_triwulan2,
				kuota_triwulan3,
				kuota_triwulan4,
				tahun)			
				values(
				'$idt',
				'$id_negara',
				$id_produk,
				$id_rank,
				$kuota_thn,
				$kuota_tw1,
				$kuota_tw2,
				$kuota_tw3,
				$kuota_tw4,
				'$tahun'
				) ";
				echo $strsql;
				die;
				$sql=mysql_query($strsql);
						
				
					if($sql){
						echo"<script type='text/javascript'>
		                        alert('Kuota berhasil di Update');
								location.href='deplu.php?module=detil_quota_miras_staff';
		                    </script>";
					}else{
						echo"<script type='text/javascript'>
		                        alert('ERROR: Kuota gagal di Update');
		                    </script>";
			}} else {
				
					echo"<script type='text/javascript'>
	                        alert('ERROR: Kuota Staff sudah pernah di input!');
							location.href='deplu.php?module=detil_quota_miras_staff';
	                    </script>";
			}
		}
			elseif($module=='detil_quota_miras_pwk' AND $act=='tambahquotaktr' AND isset($_POST[idt]))
			{
				//mulai dari sini untuk update kuotaaaaaaa perwakilan
				$kuota_thn = $_POST['quota_tahun'];		
				$kuota_tw1 = $_POST['quota_tw1'];
				$kuota_tw2 = $_POST['quota_tw2'];    
				$kuota_tw3 = $_POST['quota_tw3'];
				$kuota_tw4 = $_POST['quota_tw4'];
				$id_rank =$_POST['id_rank'];
				$id_produk=$_POST['id_produk'];
				$id_negara=$_POST['idnegara'];
				$tahun=date("Y");
				$idm=$_POST[idt];
				
				$strtampil="select * from tbl_kuota_kantor
				where id_knt_perwakilan= $idt and id_produk=$id_produk  and tahun=$tahun";
				$sqltampil=mysql_query($strtampil);
				if (!$sqltampil)
				{
				$strsql="insert into tbl_kuota_kantor
				(ID_KNT_PERWAKILAN,
				id_negara,
				id_produk,
				kuota_tahun,
				kuota_triwulan1, 
				kuota_triwulan2,
				kuota_triwulan3,
				kuota_triwulan4,
				tahun)			
				values(
				$idt,
				$id_produk,
				$kuota_thn,
				$kuota_tw1,
				$kuota_tw2,
				$kuota_tw3,
				$kuota_tw4,
				$tahun )";
				
			//	echo $strsql;
				//die;
				
				$sql=mysql_query($strsql);			
			
				if($sql){
					echo"<script type='text/javascript'>
                        alert('Kuota berhasil di Update');
						location.href='deplu.php?module=detil_quota_miras_pwk';
                    </script>";
				}else{
					echo"<script type='text/javascript'>
                        alert('ERROR: Kuota gagal di Update');
                    </script>";
				}}else {
				
					echo"<script type='text/javascript'>
	                        alert('ERROR: Kuota Kantor sudah pernah di input!');
							location.href='deplu.php?module=detil_quota_miras_pwk';
	                    </script>";
			}
	
		}
		break;
	case "detil_quota_miras_pwk":
		if ($module=='detil_quota_miras_pwk' AND $act=='hapus' AND isset($_GET[idt])){
			mysql_query("DELETE FROM m_kantor_perwakilan WHERE ID_KNT_PERWAKILAN = $_GET[idt]");
		}elseif($module=='detil_quota_miras_pwk' AND $act=='editquota' AND isset($_POST[idt]))
		{
			//mulai dari sini untuk update kuotaaaaaaa perwakilan
			$kuota_thn = $_POST['quota_tahun'];		
			
			$kuota_tw1 = $_POST['quota_tw1'];
			$kuota_tw2 = $_POST['quota_tw2'];
			$kuota_tw3 = $_POST['quota_tw3'];
			$kuota_tw4 = $_POST['quota_tw4'];
			$id_rank =$_POST['id_rank'];
			$id_produk=$_POST['id_produk'];
			$tahun=date("Y"); 
			$idm=$_POST[idt];
			$strsql="update tbl_kuota_kantor set
			kuota_tahun=$kuota_thn,
			kuota_triwulan1=$kuota_tw1,
			kuota_triwulan2=$kuota_tw2,
			kuota_triwulan3=$kuota_tw3,
			kuota_triwulan4='$kuota_tw4'
			where  ID_KNT_PERWAKILAN=$idm and id_produk = $id_produk and tahun= '$tahun' ";
			////echo $strsql;
			//die;
			$sql=mysql_query($strsql);
				
			
			if($sql){
				echo"<script type='text/javascript'>
                        alert('Kuota berhasil di Update');
						location.href='deplu.php?module=detil_quota_miras_pwk';
                    </script>";
			}else{
				echo"<script type='text/javascript'>
                        alert('ERROR: Kuota gagal di Update');
                    </script>";
			}
		
		}
        break;
        //mulai dari sini untuk update kuotaaaaaaa stafffffffffff
	case "detil_quota_miras_staff":
		
		if ($module=='detil_quota_miras_staff' AND $act=='hapus' AND isset($_GET[idt])){
			mysql_query("DELETE FROM m_kantor_perwakilan WHERE ID_KNT_PERWAKILAN = $_GET[idt]");
		}elseif ($module=='detil_quota_miras_staff' AND $act=='editquotastaff')
			{
				
			//$nm_knt_perwakilan = $_GET[nm_knt_perwakilan];
			//$id_negara =$_GET[id_negara];
				 
			$kuota_thn = $_POST['quota_tahun'];		
			
			$kuota_tw1 = $_POST['quota_tw1'];
			$kuota_tw2 = $_POST['quota_tw2'];
			$kuota_tw3 = $_POST['quota_tw3'];
			$kuota_tw4 = $_POST['quota_tw4'];
			$id_rank =$_POST['id_rank'];
			$id_produk=$_POST['id_produk'];
			$tahun=date("Y"); 
			
			$strsql="update tbl_kuota_staff set
						kuota_tahun=$kuota_thn,
						kuota_triwulan1=$kuota_tw1,
						kuota_triwulan2=$kuota_tw2,
						kuota_triwulan3=$kuota_tw3,
						kuota_triwulan4='$kuota_tw4'
						where ID_KNT_PERWAKILAN= '$idt'  and id_rank = $id_rank and id_produk = $id_produk and tahun= '$tahun' ";
			
			$sql=mysql_query($strsql);	
			

			if($sql){
				echo"<script type='text/javascript'>
                        alert('Kuota berhasil di Update');
						location.href='deplu.php?module=detil_quota_miras_staff';
                    </script>";
			}else{
				echo"<script type='text/javascript'>
                        alert('ERROR: Kuota gagal di Update');
                    </script>";
			}
		}
		
		break;
	case "set_quota_miras_pwk":
		$tahun=$_GET[tahun_quota];
		$tahun_prev=$tahun-1;
		$data=mysql_query("select * from tbl_kuota_pwk
			where tahun =" .$tahun_prev);
		
		if ($result)
			
		{
			while ($row = mysql_fetch_array($result)) {
					
				$sql= "insert into tbl_kuota_staff (
					id_produk,
					
					id_knt_perwakilan,
					id_negara,
					kuota_tahun,
					kuota_triwulan1,
					kuota_triwulan2,
					kuota_triwulan3,
					kuota_triwulan4,
					tahun,
					keterangan
					)
					values (".$row['id_produk']. ",'"
							
							.$row['id_knt_perwakilan'] . "','"
							.$row['id_negara'] ."',"
							.$row['kuota_tahun'] .","
							.$row['kuota_triwulan1'] .","
							.$row['kuota_triwulan2'] .","
							.$row['kuota_triwulan3'] .","
							.$row['kuota_triwulan4'] .","
							.$tahun .",'"
							.$row['keterangan'] ."'
					)";
					mysql_query($sql);
			}
		
		} 
                break;
		
	case "set_quota_miras_staff":
		
		$tahun=$_GET[tahun_quota];
		$tahun_prev=$tahun-1;
		$sqli=mysql_query("select max(tahun) as tahun from tbl_kuota_staff");
                $hasil = mysql_fetch_array($sqli);
                $jml=$hasil[tahun]+1;
                if($hasil[tahun] < $tahun_prev || $hasil[tahun] > $tahun_prev){
                    echo"<script type='text/javascript'>
                        alert('ERROR: Tahun sebelumnya adalah $hasil[tahun], set tahun selanjutnya adalah : $jml');  
                    </script>"; 
                }elseif($hasil[tahun] == $tahun_prev){   
                $result=mysql_query("select * from tbl_kuota_staff
		where tahun=" .$tahun_prev);
		if ($result) 			
		{
		while ($row = mysql_fetch_array($result)) {			
			$sql= mysql_query("insert into tbl_kuota_staff (
					id_produk,
					id_rank,
					id_knt_perwakilan,
					id_negara,
					kuota_tahun, 
					kuota_triwulan1,
					kuota_triwulan2,
					kuota_triwulan3,
					kuota_triwulan4,
					tahun,
					keterangan
					)
					values (".$row['id_produk']. ",'"
							 .$row['id_rank'] ."','"
							 .$row['id_knt_perwakilan'] . "','"
							 .$row['id_negara'] ."',"
							 .$row['kuota_tahun'] .","
							 .$row['kuota_triwulan1'] .","
							 .$row['kuota_triwulan2'] .","
							 .$row['kuota_triwulan3'] .","
							 .$row['kuota_triwulan4'] .","	
							 .$tahun .",'" 
							 .$row['keterangan'] ."'
									)");			
		}
                if($sql){
                    echo"<script type='text/javascript'>
                        alert('Kuota berhasil di set');  
                    </script>"; 
                }else{
                    echo"<script type='text/javascript'>
                        alert('ERROR: Kuota gagal di set');  
                    </script>"; 
                }
		}
                }
                break;
			
}  

}
	//header('location: ./deplu.php?module='.$module);

?>
