<?php
require_once "../config/koneksi.php";
		 $term = trim(strip_tags($_GET['term']));
	//	$term = $_GET['term'];
		// $term = $_GET['term'];
		//echo $term; exit;
		$sql_tp = "SELECT  * FROM  v_kantor_perwakilan where NM_KNT_PERWAKILAN like '%".$term."%'  order by ID_KNT_PERWAKILAN desc limit 0,10";
// echo $sql_tp; exit;
		// $sql_tp = "SELECT  * FROM  v_kantor_perwakilan where NM_KNT_PERWAKILAN LIKE '%". mysql_real_escape_string($term) ."%'  order by ID_KNT_PERWAKILAN desc limit 0,10";
		$query_tp= mysql_query($sql_tp);
	//	$diplomat = mysql_fetch_array($query_tp);
		// print_r($diplomat);
		// exit;
// var_dump($sql_tp);
 // console.log($sql_tp);
//sudah dibenerin untuk autocompletion nya
		while ($row = mysql_fetch_array($query_tp))
		{
			 $data['value']=htmlentities(stripslashes($row['NM_KNT_PERWAKILAN']));
			 $data['id']=(int)$row['ID_KNT_PERWAKILAN'];
			//$data['value']=stripslashes($row['NM_KNT_PERWAKILAN']);
			//$data['id']=$row['ID_KNT_PERWAKILAN'];
			$row_set[] = $data;
		}
 // print_r($row); exit;
		print_r(json_encode($row_set));

?>
