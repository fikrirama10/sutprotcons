<link rel="shortcut icon" type="image/x-icon" href="../images/kemlu.ico">
<?php
	$template = file("../template/canvasawal.htm");
	$template = implode("",$template );
	$varname = file("../template/formlogin.htm");
	$varname = implode("",$varname );
	
	//$template = eregi_replace("{isi}",$varname,$template);
  	$template = preg_replace("/{isi}/i",$varname,$template);

	echo $template;
?>