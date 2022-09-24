<?php
echo "<a href=?module=resiprositas&huruf=A>A</A> |	<a href=?module=resiprositas&huruf=B>B</A> |	<a href=?module=resiprositas&huruf=C>C</A> |	<a href=?module=resiprositas&huruf=D>D</A> |	<a href=?module=resiprositas&huruf=E>E</A> |	<a href=?module=resiprositas&huruf=F>F</A> |	<a href=?module=resiprositas&huruf=G>G</A> |	<a href=?module=resiprositas&huruf=H>H</A> |	<a href=?module=resiprositas&huruf=I>I</A> |	<a href=?module=resiprositas&huruf=J>J</A> |	<a href=?module=resiprositas&huruf=K>K</A> |	<a href=?module=resiprositas&huruf=L>L</A> |	<a href=?module=resiprositas&huruf=M>M</A> |	<a href=?module=resiprositas&huruf=N>N</A> |	<a href=?module=resiprositas&huruf=O>O</A> |	<a href=?module=resiprositas&huruf=P>P</A> |	<a href=?module=resiprositas&huruf=Q>Q</A> |	<a href=?module=resiprositas&huruf=R>R</A> |	<a href=?module=resiprositas&huruf=S>S</A> |	<a href=?module=resiprositas&huruf=T>T</A> |	<a href=?module=resiprositas&huruf=U>U</A> |	<a href=?module=resiprositas&huruf=V>V</A> |	<a href=?module=resiprositas&huruf=W>W</A> |	<a href=?module=resiprositas&huruf=X>X</A> |	<a href=?module=resiprositas&huruf=Y>Y</A> |	<a href=?module=resiprositas&huruf=Z>Z</A>";

switch($_GET[act]){

  default:
		
	$alf = $_GET[huruf];
	  
   if (isset($_GET[huruf])){ echo "<br><a style=\"font-size: 22pt;\">$alf</a>";}
	

						

		echo "<h2>Tabel Resiprositas </h2>
		<table width=100%>
          <tr><th width=10 rowspan=2>no</th><th rowspan=2>Negara</th><th colspan=3>Fasilitas Diberikan oleh Indonesia</th><th colspan=3>Rantor Diberikan ke Indonesia</th><th rowspan=2>Aksi</th></tr >
			<tr><th  width=80 >JENIS FASILITAS</th><th  width=80 >JML RANTOR KANTOR</th><th width=80 >JML RANTOR INDIVIDU</th> <th  width=80 >JENIS FASILITAS</th><th  width=80 >JML RANTOR KANTOR</th><th width=80 >JML RANTOR INDIVIDU</th></tr>	 
			 ";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

	if (isset($_GET[huruf])){
	 $tampil=mysql_query("select ID_NEGARA,NEGARA,BENDERA,JML_RANTOR_K,JML_RANTOR_I,NEG_RANTOR_K,NEG_RANTOR_I from v_resiprositas where (ID_NEGARA > 1) and NEGARA like '$alf%' order by NEGARA limit $posisi,$batas");
	}else{
	 $tampil=mysql_query("select ID_NEGARA,NEGARA,BENDERA,JML_RANTOR_K,JML_RANTOR_I,NEG_RANTOR_K,NEG_RANTOR_I from v_resiprositas where ID_NEGARA > 1 order by NEGARA limit $posisi,$batas");
	}
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

		
		echo "<tr><td>$no</td>
				<td><img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" />  
				&nbsp <a href=?module=resiprositas&act=editresiprositas&idt=$r[ID_NEGARA]>$r[NEGARA] </a></td><td>";
		
	$tampilFas=mysql_query("select ID_JNS_FASILITAS from negara_jns_fas where ID_NEGARA = ".$r[ID_NEGARA]." and ST_FASILITAS_O = 1 order by ID_JNS_FASILITAS");
           			 	while($rFas=mysql_fetch_array($tampilFas)){
              				echo "$rFas[ID_JNS_FASILITAS], ";  
							}

		echo "</td><td align=right> $r[JML_RANTOR_K] </td><td align=right> $r[JML_RANTOR_I]</td> <td>";
	
	$tampilFas=mysql_query("select ID_JNS_FASILITAS from negara_jns_fas where ID_NEGARA = ".$r[ID_NEGARA]." and ST_FASILITAS_K = 1 order by ID_JNS_FASILITAS");
           			 	while($rFas=mysql_fetch_array($tampilFas)){
              				echo "$rFas[ID_JNS_FASILITAS], ";  
							}
		
		echo "</td>
					<td align=right> $r[NEG_RANTOR_K] </td><td align=right> $r[NEG_RANTOR_I]</td><td><a href=?module=resiprositas&act=editresiprositas&idt=$r[ID_NEGARA]>Edit</a></td>
		            </tr>";
      $no++;
    }
    echo "</table>";
  	if (isset($_GET[huruf])){
	$jmldata =mysql_num_rows(mysql_query("SELECT NEGARA FROM  v_resiprositas where ID_NEGARA > 1  and NEGARA like '$alf%' "));
	}else{
	 $jmldata =mysql_num_rows(mysql_query("SELECT NEGARA FROM  v_resiprositas where ID_NEGARA > 1"));
	}
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   $ilink = "?module=resiprositas"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
       echo "Keterangan <br>";  
			$tampilFas=mysql_query("select ID_JNS_FASILITAS,JNS_FASILITAS from m_jns_fasilitas order by ID_JNS_FASILITAS");
           			 	while($rFas=mysql_fetch_array($tampilFas)){
              				echo "$rFas[ID_JNS_FASILITAS] = $rFas[JNS_FASILITAS] <br>";  
							}
		
	break;
  

  case "editresiprositas":
    $idt = $_GET[idt];
    $edit = mysql_query("select ID_NEGARA,NEGARA,BENDERA,JML_RANTOR_K,JML_RANTOR_I,NEG_RANTOR_K,NEG_RANTOR_I from v_resiprositas where (ID_NEGARA  = $idt)");
    $r    = mysql_fetch_array($edit);
 
	     echo "<h2>Edit Resiprositas</h2>
          <form method=POST enctype='multipart/form-data' action='./aksi_resiprositas.php?module=resiprositas&act=update'>
         <input type=hidden name=idt value='$r[ID_NEGARA]'>
           <input type=hidden name=NEGARA value='$r[NEGARA]'>
		  <table width=700>
			  <tr><td width=120>Negara</td >  <td colspan=3 > : <img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" /> &nbsp $r[NEGARA]</td></tr>
		  ";
		echo "
		  <tr><th colspan=2 height=30>Fasilitas diberikan oleh Indonesia</th><th colspan=2 height=30>Fasilitas diberikan ke Indonesia</th></tr>
		  <tr><td width=120>Rantor Kantor</td >  <td  width=230> : $r[JML_RANTOR_K]</td><td width=120>Rantor Kantor</td >  <td  width=230> : <input type=text  value='$r[NEG_RANTOR_K]' name='NEG_RANTOR_K' size=30></td></tr>
		  <tr><td width=120>Rantor Individu</td width=230 >  <td > : $r[JML_RANTOR_I]</td><td width=120>Rantor Individu</td >  <td width=230 > : <input type=text  value='$r[NEG_RANTOR_I]' name='NEG_RANTOR_I' size=30></td></tr>	
		  <tr><th  colspan=4 ><div align=right><input type=submit value=Update> <input type=button value=Batal onclick=self.history.back()></div></th></tr>
		  <tr>	<td colspan=2>Fasilitas Lain <br><br>";
		
			$tampil=mysql_query("select * from m_jns_fasilitas  ORDER BY JNS_FASILITAS");
           			 	while($r=mysql_fetch_array($tampil)){
              				echo "<input type=\"checkbox\" ";  
							
						$cekFas = mysql_query("select ST_FASILITAS_O	from negara_jns_fas where ID_NEGARA = $idt  and ID_JNS_FASILITAS= $r[ID_JNS_FASILITAS] ");   
						$r1  = mysql_fetch_array($cekFas);
						if ($r1[ST_FASILITAS_O] == 1){ 
						echo "checked";
						}	

						echo " name=\"O$r[ID_JNS_FASILITAS]\">$r[JNS_FASILITAS]<br>";
              		   			}
				
		echo "</td><td colspan=2>Fasilitas Lain<br><br>";
		
			$tampil=mysql_query("select * from m_jns_fasilitas  ORDER BY JNS_FASILITAS");
           			 	while($r=mysql_fetch_array($tampil)){
              				echo "<input type=\"checkbox\" ";  
							
						$cekFas = mysql_query("select ST_FASILITAS_K	from negara_jns_fas where ID_NEGARA = $idt  and ID_JNS_FASILITAS= $r[ID_JNS_FASILITAS] ");   
						$r1  = mysql_fetch_array($cekFas);
						if ($r1[ST_FASILITAS_K] == 1){ 
						echo "checked";
						}	
						echo " name=\"K$r[ID_JNS_FASILITAS]\">$r[JNS_FASILITAS]<br>";
              		   			}
				
		echo "</td></tr>
          </table></form>";
     break;

      
}
?>
