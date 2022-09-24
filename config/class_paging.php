<?php
class Paging
{
// Fungsi untuk mencek halaman dan posisi data
function cariPosisi($batas)
{
if(empty($_GET[halaman])){
	$posisi=0;
	$_GET[halaman]=1;
}
else{
	$posisi = ($_GET[halaman]-1) * $batas;
}
return $posisi;
}

// Fungsi untuk menghitung total halaman
function jumlahHalaman($jmldata, $batas)
{
$jmlhalaman = ceil($jmldata/$batas);
return $jmlhalaman;
}

// Fungsi untuk link halaman 1,2,3 ... Next, Prev, First, Last
function navHalaman($link,$halaman_aktif, $jmlhalaman)
{
$link_halaman = "";

// Link First dan Previous
/*
if ($halaman_aktif > 1)
{
$link_halaman .= " <a href=$_SERVER[PHP_SELF]".$link."&halaman=1><< First</a> | ";
}

if (($halaman_aktif-1) > 0)
{
$previous = $halaman_aktif-1;
$link_halaman .= "<a href=$_SERVER[PHP_SELF]".$link."&halaman=$previous>< Previous</a> | ";
}*/



if($halaman_aktif > 1)
{
	$previous=$halaman_aktif-1;
	$link_halaman .= "<A HREF=$_SERVER[PHP_SELF]".$link."&halaman=1><< First</A> | 
        <A HREF=$_SERVER[PHP_SELF]".$link."&halaman=$previous>< Previous</A> | ";
}
else
{ 
	$link_halaman .= "<< First | < Previous | ";
}

$link_halaman .= ($halaman_aktif > 3 ? " ... " : " ");
for($i=$halaman_aktif-2;$i<$halaman_aktif;$i++)
{
  if ($i < 1) 
      continue;
  $link_halaman .= "<a href=$_SERVER[PHP_SELF]".$link."&halaman=$i>$i</A> ";
}

$link_halaman .= " <b style=\"color:#CC0000\">$halaman_aktif</b> ";
for($i=$halaman_aktif+1;$i<($halaman_aktif+3);$i++)
{
  if ($i > $jmlhalaman) 
      break;
  $link_halaman .= "<a href=$_SERVER[PHP_SELF]".$link."&halaman=$i>$i</A> ";
}

$link_halaman .= ($halaman_aktif+2 <$jmlhalaman ? " ...  
          <a href=$_SERVER[PHP_SELF]".$link."&halaman=$jmlhalaman>$jmlhalaman</A> " : " ");



// Link Next dan Last

if($halaman_aktif  < $jmlhalaman)
{
	$next=$halaman_aktif +1;
	$link_halaman .= " | <A HREF=$_SERVER[PHP_SELF]".$link."&halaman=$next>Next ></A> | 
  <A HREF=$_SERVER[PHP_SELF]".$link."&halaman=$jmlhalaman>Last >></A> ";
}
else
{ 
	$link_halaman .= " | Next > | Last >>";
}
return $link_halaman;
}
}

?>
