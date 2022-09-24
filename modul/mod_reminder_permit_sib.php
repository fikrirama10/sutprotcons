<?php
//echo "<a href=?module=resiprositas&huruf=A>A</A> |	<a href=?module=resiprositas&huruf=B>B</A> |	<a href=?module=resiprositas&huruf=C>C</A> |	<a href=?module=resiprositas&huruf=D>D</A> |	<a href=?module=resiprositas&huruf=E>E</A> |	<a href=?module=resiprositas&huruf=F>F</A> |	<a href=?module=resiprositas&huruf=G>G</A> |	<a href=?module=resiprositas&huruf=H>H</A> |	<a href=?module=resiprositas&huruf=I>I</A> |	<a href=?module=resiprositas&huruf=J>J</A> |	<a href=?module=resiprositas&huruf=K>K</A> |	<a href=?module=resiprositas&huruf=L>L</A> |	<a href=?module=resiprositas&huruf=M>M</A> |	<a href=?module=resiprositas&huruf=N>N</A> |	<a href=?module=resiprositas&huruf=O>O</A> |	<a href=?module=resiprositas&huruf=P>P</A> |	<a href=?module=resiprositas&huruf=Q>Q</A> |	<a href=?module=resiprositas&huruf=R>R</A> |	<a href=?module=resiprositas&huruf=S>S</A> |	<a href=?module=resiprositas&huruf=T>T</A> |	<a href=?module=resiprositas&huruf=U>U</A> |	<a href=?module=resiprositas&huruf=V>V</A> |	<a href=?module=resiprositas&huruf=W>W</A> |	<a href=?module=resiprositas&huruf=X>X</A> |	<a href=?module=resiprositas&huruf=Y>Y</A> |	<a href=?module=resiprositas&huruf=Z>Z</A>";

switch($_GET[act]){

  default:
		 	
	

		echo "<h2>Reminder Stay Permit Family </h2>
			 <br>
			 <form action='?module=remindpermit' method=GET>
			 Nama Family : <input type=text name=key value=".$_GET['key']."> <input type='hidden' value='remindpermitsib' name='module'> <input type='submit' value='cari'>
			 </form>
          <table width=100%>
          <tr><th width=10>no</th><th  >NAMA FAMILY</th><th  >NAMA DIPLOMAT</th><th  >Relasi</th><th >KANTOR PERWAKILAN</th><th >NO IZIN PERMIT</th><th  >AKHIR PERMIT</th><th>STATUS</th></tr>	 
			 ";

    $p      = new Paging;
    $batas  = 20;
    $posisi = $p->cariPosisi($batas);
	if(!empty($_GET['key'])) { $search="and C.NM_SIBLING like '%".$_GET['key']."%'"; }
	
	$sql="SELECT C.ID_SIBLING, C.NM_SIBLING, C.ID_DIPLOMAT, C.NM_JNS_RELASI, C.NM_KNT_PERWAKILAN,
		(SELECT AA.BENDERA FROM m_negara AA WHERE AA.ID_NEGARA =  C.ID_NEGARA) AS BENDERA,
		C.NM_DIPLOMAT,C.NO_AGENDA,C.TGL_AGENDA,C.NO_IZIN_PERMIT,C.TGL_AWAL_PERMIT,
		DATE_FORMAT(C.TGL_AKHIR_PERMIT,'%d %M %Y') AS TGL_AKHIR_PERMIT,C.KET,
		IF((TO_DAYS(NOW()) - TO_DAYS(C.TGL_AKHIR_PERMIT)) > 0,0,1) AS ST_BERLAKU
		FROM v_max_stay_permit_sib C WHERE (TO_DAYS(NOW()) - TO_DAYS(C.TGL_AKHIR_PERMIT)) 
		BETWEEN -30 AND 400 $search ORDER BY C.TGL_AKHIR_PERMIT DESC  limit $posisi,$batas";
	//echo $sql;
	 $tampil=mysql_query($sql);
	
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

		
      echo "<tr><td>$no</td>
			  <td><a href=?module=staypermitSib&act=lihat_stay_permit&idt=$r[ID_SIBLING]&negara=>$r[NM_SIBLING]</a></td>
			  <td><a href=?module=diplomat&act=viewdiplomat&idt=$r[ID_DIPLOMAT]&negara=>$r[NM_DIPLOMAT]</a></td>
			  <td width=80 align=right>$r[NM_JNS_RELASI]</td>	
			  <td width=200><img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" />  &nbsp $r[NM_KNT_PERWAKILAN] </td>
			  <td width=80 align=right>$r[NO_IZIN_PERMIT]</td>
			  <td width=100 align=center>$r[TGL_AKHIR_PERMIT]</td>
			  <td width=80 align=center>";
   if ($r[ST_BERLAKU] == 0) {
	   echo "<div style=\"color : #800000\"> <b>EXPIRED</b> </div>";
   }else{
	   echo "<div style=\"color : green\"> <b>VALID</b> </div>";
   }


	ECHO "</td>
				 </tr>";
      $no++;
    }
    echo "</table>";
	 $jmldata =mysql_num_rows(mysql_query("select C.ID_DIPLOMAT from v_max_stay_permit_new C where (TO_DAYS(NOW()) - TO_DAYS(C.TGL_AKHIR_PERMIT)) between -30 and 60"));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   $ilink = "?module=remindpermit"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;
  



      
}
?>
