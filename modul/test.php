<?php
include "../config/koneksi.php";

function insert_parent($menu_id, $id_group)
{	
	//echo "select parent_menu from m_menu where id_menu=$menu_id";
	$parent = mysql_query("select parent_menu from m_menu where id_menu=$menu_id");
	while($r=mysql_fetch_array($parent)){
		if ($r['parent_menu']==0)
		{
			//echo "$menu_id<br>" ;
			insert_row($menu_id, $id_group );
		}else
		{
			//echo "$menu_id<br>";
			insert_row($menu_id, $id_group);
			insert_parent($r['parent_menu'], $id_group);
		}
	
	
	}
	
	

}


function insert_row($menu_id, $id_group)
{
	//echo "select * from m_grup_menu where id_menu=$menu_id and id_group='$id_group'";
	$checkrow =  mysql_query("select * from m_grup_menu where id_menu=$menu_id and id_group='$id_group'");
	$jmlrow = mysql_num_rows($checkrow);
	
	if ($jmlrow == 0)
	{
		echo "insert into m_grup_menu values ('$id_group', $menu_id)<br>";
		$insertQuery = mysql_query("insert into m_grup_menu values ('$id_group', $menu_id)");
	
	}
}

$menu_name = "Berdasarkan Diplomat";
$id_group = "10";
$arrIDMenu = array(1);
$arrIDGroup = array(1,2,3,4,5,6,7,8,9,10);
//$menu = mysql_query("SELECT ID_MENU FROM m_menu WHERE menu LIKE '%$menu_name%'");

foreach ($arrIDMenu as $value) {
    echo "Value: $value<br />\n";


//while($rmenu=mysql_fetch_array($menu))
//{
	//echo $rmenu['ID_MENU'];
	//$menu_Id=$rmenu['ID_MENU'];
	$menu_Id=$value;
	foreach ($arrIDGroup as $valueGroup) {
		$id_group = $valueGroup;
		$parent = mysql_query("select parent_menu from m_menu where id_menu=$menu_Id");
		insert_row($menu_Id,$id_group);
		while($r=mysql_fetch_array($parent))
		{
			//echo "$r[parent_menu]<br>" ;
			insert_parent($r['parent_menu'], $id_group);
		}
	}
//}

}




?>