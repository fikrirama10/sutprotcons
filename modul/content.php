<?php
include "../config/koneksi.php";
include "../config/library.php";
include "../config/fungsi_indotgl.php";
include "../config/fungsi_combobox.php";
include "../config/class_paging.php";

// Bagian Home
//mrs
if ($_GET['module']=='home' && $_SESSION['G_leveluser'] == 13){

echo "<h2>Selamat Datang <u>$_SESSION[G_namauser]</u></h2>
          <p align=center> <img src=\"../images/logo_kemlu.png\" width=\"174\" height=\"151\" border=\"0\" id=\"log_kemlu\" /> </br>
          <font face=Bodoni MT Black size=3><i>
          Website Pengelolaan Pengajuan Bebas Masuk Minuman Keras dan Rokok </br > Bagi Staf dan Kantor Perwakilan Asing yang Berada di Indonesia </br> Direktorat Fasilitas Diplomatik </br> Direktorat Jenderal Protokol dan Konsuler </br> Kementerian Luar Negeri Republik Indonesia </i></font></p>
		  <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p align=right>Login Hari ini: ";
  echo tgl_indo(date("Y m d"));
  echo " | ";
  echo date("H:i:s");
  echo "</p>";
}
//mrs-
else if ($_GET['module']=='home' && $_SESSION['G_leveluser'] != 13){

echo "<h2>Selamat Datang</h2>
          <p>Selamat Datang <b>$_SESSION[G_namauser]</b></p>
		  <p>Silahkan klik menu pilihan yang berada
          di sebelah kiri. </p>

		  <p>&nbsp;</p>

<p align=\"center\">
<a href=\"?module=diplomat\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('iPersonal','','../images/icon/Icon - Personal BLOCK.gif',1)\"><img src=\"../images/icon/Icon - Personal.gif\" name=\"iPersonal\" width=\"174\" height=\"121\" border=\"0\" id=\"iPersonal\" /></a>&nbsp;&nbsp;<a href=\"?module=staypermit\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('iPermit','','../images/icon/Icon - Permit BLOCK.gif',1)\"><img src=\"../images/icon/Icon - Permit.gif\" name=\"iPermit\" width=\"174\" height=\"121\" border=\"0\" id=\"iPermit\" /></a>&nbsp;&nbsp;<a href=\"?module=idcard\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('iCard','','../images/icon/Icon - ID Card BLOCK.gif',1)\"><img src=\"../images/icon/Icon - ID Card.gif\" name=\"iCard\" width=\"174\" height=\"121\" border=\"0\" id=\"iCard\" /></a><br>
</p>
          <p>&nbsp;</p>
          <p align=right>Login Hari ini: ";
  echo tgl_indo(date("Y m d"));
  echo " | ";
  echo date("H:i:s");
  echo "</p>";
}


// Apabila modul tidak ditemukan
else{
   $sql="SELECT distinct module_file FROM m_menu m INNER JOIN m_grup_menu gm ON m.`ID_MENU` = gm.`ID_MENU` AND gm.`ID_GROUP`='$_SESSION[G_leveluser]' WHERE m.module = '$_GET[module]' ";
   //echo $sql;
   $modul = mysql_query($sql);
   $jmlrowmodul = mysql_num_rows($modul);

   if ($jmlrowmodul==0)
   {

	  echo "<h2>Selamat Datang</h2>
			  <p>Selamat Datang <b>$_SESSION[G_namauser]</b></p>
			  <p>Silahkan klik menu pilihan yang berada
			  di sebelah kiri. </p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p align=right>Login Hari ini: ";
	  echo tgl_indo(date("Y m d"));
	  echo " | ";
	  echo date("H:i:s");
	  echo "</p>";
  }else
  {
	while ($rmodul=mysql_fetch_array($modul))
	{
		include "$rmodul[module_file]";
	}
  }
}

?>
