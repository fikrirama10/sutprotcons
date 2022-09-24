<?php
require_once "../config/koneksi.php";
		$term = trim(strip_tags($_GET['term']));
		//Tim DAM rubahh pencarian yg asalnya like ' %' jadi like '%%'
		$sql_diplomat = "SELECT  ID_DIPLOMAT,NM_DIPLOMAT,date_format(TGL_TIBA,'%d.%m.%Y') as TGL_TIBA FROM  v_diplomat where NM_DIPLOMAT like '%".$term."%' and (ID_DIPLOMAT > 1) order by ID_DIPLOMAT desc limit 0,10";
		$query_diplomat= mysql_query($sql_diplomat);
		//$diplomat = mysql_fetch_array($query_diplomat);
		
		while ($row = mysql_fetch_array($query_diplomat))
		{
		$row['value']=htmlentities(stripslashes($row['NM_DIPLOMAT']));
		$row['id']=(int)$row['ID_DIPLOMAT']; 
		$row_set[] = $row;
		}
		
		echo json_encode($row_set);

?>