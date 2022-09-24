<?php
include "../config/koneksi.php";

echo ": <select name=ID_KNT_PERWAKILAN>";
$sql2=mysql_query("SELECT ID_KNT_PERWAKILAN,NM_KNT_PERWAKILAN FROM m_kantor_perwakilan WHERE ID_NEGARA='$_GET[kode]'");
while ($row=mysql_fetch_array($sql2)){
    echo "<option selected='selected' value=$row[ID_KNT_PERWAKILAN]>$row[NM_KNT_PERWAKILAN]</option>";
}

$sql3=mysql_query("SELECT ID_KNT_PERWAKILAN,NM_KNT_PERWAKILAN FROM m_kantor_perwakilan");
while ($row=mysql_fetch_array($sql3)){
    echo "<option value=$row[ID_KNT_PERWAKILAN]>$row[NM_KNT_PERWAKILAN]</option>";
}


echo "</select>";
?>
