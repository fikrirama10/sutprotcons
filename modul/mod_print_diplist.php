<?php

switch($_GET[act]){

  default:
  session_start();

//session_register("G_sql_lap");
$template = file("../template/canvasawal.htm");
$template = implode("",$template ); 

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){

	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";
	
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{ ?>

	 <h2>Print Diplomatic & Consular List</h2> 
    <form method=POST action="./report.diplist.class.php" enctype='multipart/form-data'>
          <table width=100%>
          <tr><td  width=150>Pilih Pengelompokan</td>  <td > : 
          <select name='id_kelompok' >
            <option value=1 selected>ALL</option>
			<option value=2>Diplomatic and Consular</option>
			<option value=3>International Organizations</option>
			<option value=4>Missions To ASEAN</option>
			<option value=5>Order Of Preseance</option>
			<option value=6>Honorary Consul</option>
		  </select></td></tr>
		  <tr><th colspan = 2><div align=right><input type=submit value=Print onclick="location.href=./report.diplist.class.php?klp=<?php echo $id_kelompok; ?>"> </div></th></tr>
		  </table></form>	 


<?php 
}

	break;	
 
		
}
?>
