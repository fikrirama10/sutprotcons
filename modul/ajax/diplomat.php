<?php
include "../../config/koneksi.php";
include "../../config/library.php";

switch($_POST['type']){
  // Tampil Berita
  case "combo_province":
      $sql="select * from regencies where province_id='".$_POST['provinsi_kd']."' order by name asc";
   // echo $sql;
      $query =mysql_query($sql);
      $option = ": <select name='REGENCY_ID'>";
      while($regencies = mysql_fetch_array($query)) {
          $option .= "<option value='".$regencies['id']."'>".$regencies['name']."</option>";
      }
      $option .= "</select>";
       echo $option;
      break;

  default:

      break;
}
 ?>
