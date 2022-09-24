<?php
session_start();
$template = file("../template/canvasawal.htm");
$template = implode("",$template ); 

if (empty($_SESSION['G_iduser']) AND empty($_SESSION['G_namauser']) AND empty($_SESSION['G_leveluser'])){

	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";
	
	//$template = eregi_replace("{isi}",$varname,$template);
	$template = preg_replace("/{isi}/i",$varname,$template);
	
	echo $template;

}
else{
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>KEMENTRIAN LUAR NEGERI REPUBLIK INDONESIA</title>
<link href="../config/adminstyle2.css" rel="stylesheet" type="text/css" />
<link href="../config/menu.css" rel="stylesheet" type="text/css" />
<style type="text/css">
/* popup_box DIV-Styles*/
.popup_box { 
	display:none; /* Hide the DIV */
	position:fixed;  
	_position:absolute; /* hack for internet explorer 6 */  
	height:500px;  
	width:470px;  
	background:#FFFFFF;  
	left: 300px;
	top: 150px;
	z-index:100; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
	margin-left: 15px;  
	
	/* additional features, can be omitted */
	border:2px solid #ff0000;  	
	padding:15px;  
	font-size:15px;  
	-moz-box-shadow: 0 0 5px #ff0000;
	-webkit-box-shadow: 0 0 5px #ff0000;
	box-shadow: 0 0 5px #ff0000;
 }

 
#container {
	background: #d2d2d2; /*Sample*/
	width:100%;
	height:100%;
}

a{  
cursor: pointer;  
text-decoration:none;  
} 

/* This is for the positioning of the Close Link */
#popupBoxClose {
	font-size:20px;  
	line-height:15px;  
	right:5px;  
	top:5px;  
	position:absolute;  
	color:#6fa5e2;  
	font-weight:500;  	
}
</style>

<script type="text/javascript" src="../config/calendarDateInput.js"></script>
<script type="text/javascript" src="../config/comboDinamis.js"></script>
<script type="text/javascript" src="../config/rollover.js"></script>
<script src="../config/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="../config/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
	$.validator.setDefaults({
		submitHandler: function() { alert("submitted!"); }
	});
	function verify(form){
  		 if (form["NO_IZIN_PERMIT"].value == '' || form["ID_JNS_PERMIT"].value == '0' || form["NO_NOTA"].value == '' || form["NO_AGENDA"].value == ''){
		 	//alert('No izin, Jenis izin, No Nota dan No Agenda tidak boleh kosong!');
			return true;
		 }
		// else {
		// 	return true;
		// }
		 
	}

	//$(document).ready( function() {
	
		// When site loaded, load the Popupbox First
		//$('#popup_button').click(function() {
		//  loadPopupBox();
		//})
		
	$(document).ready( function() {
	
/*		$('#updateStatus').click( function() {			
				$.post("aksi_approval_json.php", {
					  status:"donal duck",
					  city: "asdasd",
					},
					function (data, status){
						alert("Data: " + data + "\nStatus: " + status);
					});
				});
*/	
		$('#popupBoxClose').click( function() {			
			unloadPopupBox();
		});
		
		$('#container').click( function() {
			unloadPopupBox();
		});
	});
		
 
		function checkBox(kd,j){
 			$('#txt_box'+j).val(kd);
			if (kd==0) 
				txt="<div style='color:red;'>Reject</div>";
 			if (kd==1) 
				txt="<div style='color : #B1BF19;'>Waiting</div>";
 			if (kd==2) 
				txt="<div style='color:green;'>Approve</div>";
 			
			
			$('#status'+j).html(txt);
 		}
		
		function updateAction(kd,id,jns,kd_permit) {	
			$.post("aksi_approval_json.php", {
					  status:$("#txt_box"+id).val(),
					  id: kd,
					  jns_approval: jns,
					  jns_permit: kd_permit
					},
					function (data, status){
						if (status=='success'){
 							//alert (data);
							alert ('Berhasil memproses data!');
							document.location.reload(true);
 						}
 					}
				);
				//alert ('asdasdasd');
		}	
		
		function unloadPopupBox(i) {	// TO Unload the Popupbox
			$('#popup_box'+i).fadeOut("slow");
			$("#container").css({ // this is just for style		
				"opacity": "1"  
			}); 
		}	
		
		function loadPopupBox(i) {	// To Load the Popupbox
			$('#popup_box'+i).fadeIn("slow");
			//$('#txt_box'+i).val(j);
 			$("#container").css({ // this is just for style
				"opacity": "0.3"  
			}); 		
		}
		/**********************************************************/
		
	//});
</script>
</head>

<body onload="MM_preloadImages('../images/icon/Icon - Personal BLOCK.gif','../images/icon/Icon - Permit BLOCK.gif','../images/icon/Icon - ID Card BLOCK.gif','../images/icon/Icon - Rantor Individu BLOCK.gif','../images/icon/Icon - Rantor kantor BLOCK.gif','../images/icon/Icon - Fasilitas BLOCK.gif')">
<div id="container"> <!-- Main Page -->
 </div>
<table  width="980" align="center" cellpadding="0" cellspacing="0" id="frameutama"    >
  <tr>
   <!-- <td colspan="2"><img src="../images/header2.png" alt="head" width="980" height="80" /></td>-->
    <td colspan="2"><img src="../images/header_new.jpg" alt="head" width="980"  /></td>
  </tr>
  <tr>
	<td colspan="2">
	<?php
	function getChildMmenu($parentid)
	{
		$parent=mysql_query("SELECT * FROM m_menu WHERE PARENT_MENU=$parentid AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')");
		
		echo "<ul>";
		while($r=mysql_fetch_array($parent)){
			$child=mysql_query("SELECT * FROM m_menu WHERE PARENT_MENU=$r[ID_MENU] AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')");
			$jmlchild=mysql_num_rows($child);
			if ($jmlchild>0)
			{
				echo "<li ><a class='arrow' href='$r[MENU_LINK]'>$r[MENU]</a>";
				getChildMmenu($r['ID_MENU']);
				echo "</li>";
			}else
			{
				echo "<li ><a class='' href='$r[MENU_LINK]'>$r[MENU]</a></li>";
			}
			$jmlchild=0;
		
		}
		echo "</ul>";
	}
	
	include "../config/koneksi.php";
	$parent=mysql_query("SELECT * FROM m_menu WHERE PARENT_MENU=0 AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')");
    echo "<ul class='menuH decor1'> ";
	while($r=mysql_fetch_array($parent)){
		
		$child=mysql_query("SELECT * FROM m_menu WHERE PARENT_MENU=$r[ID_MENU] AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')");
		//echo "SELECT * FROM m_menu WHERE PARENT_MENU=$r[ID_MENU] AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')";
		$jmlchild=mysql_num_rows($child);
		if ($jmlchild>0)
		{
			echo "<li ><a class='arrow' href='$r[MENU_LINK]'>$r[MENU]</a>";
			getChildMmenu($r['ID_MENU']);
			echo "</li>";
		}else
		{
			echo "<li ><a class='' href='$r[MENU_LINK]'>$r[MENU]</a></li>";
		}
		
		$jmlchild=0;
		
	}
	
		echo "<li>            <a href='logout.php'>LOGOUT</a>          </li>";
	echo "</ul>";
	?>
	
  
    
  </tr>
  <tr>

<?php

}



?>

   
	
	 <td width="799" style="vertical-align: top" >
	<DIV id="content">
	<?php  
	   // echo "<a href=?module=diplomat&act=cari&huruf=A>A</A> |	<a href=?module=diplomat&act=cari&huruf=B>B</A> |	<a href=?module=diplomat&act=cari&huruf=C>C</A> |	<a href=?module=diplomat&act=cari&huruf=D>D</A> |	<a href=?module=diplomat&act=cari&huruf=E>E</A> |	<a href=?module=diplomat&act=cari&huruf=F>F</A> |	<a href=?module=diplomat&act=cari&huruf=G>G</A> |	<a href=?module=diplomat&act=cari&huruf=H>H</A> |	<a href=?module=diplomat&act=cari&huruf=I>I</A> |	<a href=?module=diplomat&act=cari&huruf=J>J</A> |	<a href=?module=diplomat&act=cari&huruf=K>K</A> |	<a href=?module=diplomat&act=cari&huruf=L>L</A> |	<a href=?module=diplomat&act=cari&huruf=M>M</A> |	<a href=?module=diplomat&act=cari&huruf=N>N</A> |	<a href=?module=diplomat&act=cari&huruf=O>O</A> |	<a href=?module=diplomat&act=cari&huruf=P>P</A> |	<a href=?module=diplomat&act=cari&huruf=Q>Q</A> |	<a href=?module=diplomat&act=cari&huruf=R>R</A> |	<a href=?module=diplomat&act=cari&huruf=S>S</A> |	<a href=?module=diplomat&act=cari&huruf=T>T</A> |	<a href=?module=diplomat&act=cari&huruf=U>U</A> |	<a href=?module=diplomat&act=cari&huruf=V>V</A> |	<a href=?module=diplomat&act=cari&huruf=W>W</A> |	<a href=?module=diplomat&act=cari&huruf=X>X</A> |	<a href=?module=diplomat&act=cari&huruf=Y>Y</A> |	<a href=?module=diplomat&act=cari&huruf=Z>Z</A>";
    
	 include "content.php"; 
	 ?>
	</div>
	</td>
	</tr>
  <tr>
    <td colspan="2">		<div  align="center" id="footer">
		Copyright &copy; 2013 by Pusat Komunikasi Kementerian Luar Negeri
	<!--echo $_SESSION[G_leveluser]; ?>	 -->
	 </div>	</td>
  </tr>
</table>

</body>
</html>

<?php
//}
?>
