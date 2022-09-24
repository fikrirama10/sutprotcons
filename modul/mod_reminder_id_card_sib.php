<?php
//echo "<a href=?module=resiprositas&huruf=A>A</A> |	<a href=?module=resiprositas&huruf=B>B</A> |	<a href=?module=resiprositas&huruf=C>C</A> |	<a href=?module=resiprositas&huruf=D>D</A> |	<a href=?module=resiprositas&huruf=E>E</A> |	<a href=?module=resiprositas&huruf=F>F</A> |	<a href=?module=resiprositas&huruf=G>G</A> |	<a href=?module=resiprositas&huruf=H>H</A> |	<a href=?module=resiprositas&huruf=I>I</A> |	<a href=?module=resiprositas&huruf=J>J</A> |	<a href=?module=resiprositas&huruf=K>K</A> |	<a href=?module=resiprositas&huruf=L>L</A> |	<a href=?module=resiprositas&huruf=M>M</A> |	<a href=?module=resiprositas&huruf=N>N</A> |	<a href=?module=resiprositas&huruf=O>O</A> |	<a href=?module=resiprositas&huruf=P>P</A> |	<a href=?module=resiprositas&huruf=Q>Q</A> |	<a href=?module=resiprositas&huruf=R>R</A> |	<a href=?module=resiprositas&huruf=S>S</A> |	<a href=?module=resiprositas&huruf=T>T</A> |	<a href=?module=resiprositas&huruf=U>U</A> |	<a href=?module=resiprositas&huruf=V>V</A> |	<a href=?module=resiprositas&huruf=W>W</A> |	<a href=?module=resiprositas&huruf=X>X</A> |	<a href=?module=resiprositas&huruf=Y>Y</A> |	<a href=?module=resiprositas&huruf=Z>Z</A>";

switch($_GET[act]){

  default:
		
	

		echo "<h2>Reminder ID CARD Family </h2>
			 <br>
			 <form action='?module=remindidcard' method=GET>
			 Pencarian : <input type=text name=key value=".$_GET['key']."> <input type='hidden' value='remindidcard' name='module'> <input type='submit' value='cari'>
			 </form>
          <table width=100%>
          <tr><th width=10>no</th>
		  	<th>NAMA SIBLING/FAMILY</th>
		  	<th>NAMA DIPLOMAT</th>
			<th >KANTOR PERWAKILAN</th>
			<th >NO ID CARD</th>
			<th  >AKHIR ID CARD</th><th  >BERLAKU</th><th>STATUS</th></tr>	 
			 ";

    $p      = new Paging;
    $batas  = 20;
    $posisi = $p->cariPosisi($batas);
	if(!empty($_GET['key'])) { $search="and d.NM_DIPLOMAT like '%".$_GET['key']."%'"; }

	$sql="select 
        s.ID_SIBLING, s.NM_SIBLING, d.ID_DIPLOMAT,d.NM_DIPLOMAT,c.TGL_AKHIR_CARD,n.NEGARA,m.NM_KNT_PERWAKILAN,c.ID_CARD, (TO_DAYS(C.TGL_AKHIR_CARD)) - TO_DAYS(NOW()) as DAYS
   from
        diplomat d
        inner join sibling s
        on d.ID_DIPLOMAT=s.ID_DIPLOMAT
        inner join cetak_kartu_sibling c
        on c.ID_SIBLING=s.ID_SIBLING
        inner join m_kantor_perwakilan m
        on d.ID_KNT_PERWAKILAN=m.ID_KNT_PERWAKILAN
        inner join m_negara n
        on m.ID_NEGARA=n.ID_NEGARA
where 
(TO_DAYS(NOW()) - TO_DAYS(C.TGL_AKHIR_CARD)) between -30 and 60 $search ORDER BY C.TGL_AKHIR_CARD DESC limit $posisi,$batas";
	//echo $sql; exit;
 $tampil=mysql_query($sql);


    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

		
      echo "<tr><td>$no</td>
	      <td><a href=?module=idcard&act=lihat_id_card_sib&idt=$r[ID_SIBLING]&negara=>$r[NM_SIBLING]</a></td>
		  <td><a href=?module=idcard&act=lihat_id_card&idt=$r[ID_DIPLOMAT]&negara=>$r[NM_DIPLOMAT]</a></td>
			  <td width=200><img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" />  &nbsp $r[NM_KNT_PERWAKILAN] </td>
			  <td width=80 align=right>$r[ID_CARD]</td>
			  <td width=100 align=center>$r[TGL_AKHIR_CARD]  </td>
			  <td width=100 align=center> <strong>$r[DAYS]</strong> Hari</td>
			  <td width=80 align=center>";
   if ($r[TGL_AKHIR_CARD] < date('Y-m-d')) {
	   echo "<div style=\"color : #800000\"> <b>EXPIRED</b> </div>";
   }else{
	   echo "<div style=\"color : green\"> <b>VALID</b> </div>";
   }


	ECHO "</td>
				 </tr>";
      $no++;
    }
    echo "</table>";
	 $jmldata =mysql_num_rows(mysql_query("select 
        s.ID_SIBLING, s.NM_SIBLING, d.ID_DIPLOMAT,d.NM_DIPLOMAT,c.TGL_AKHIR_CARD,n.NEGARA,m.NM_KNT_PERWAKILAN,c.ID_CARD 
   from
        diplomat d
        inner join sibling s
        on d.ID_DIPLOMAT=s.ID_DIPLOMAT
        inner join cetak_kartu_sibling c
        on c.ID_SIBLING=s.ID_SIBLING
        inner join m_kantor_perwakilan m
        on d.ID_KNT_PERWAKILAN=m.ID_KNT_PERWAKILAN
        inner join m_negara n
        on m.ID_NEGARA=n.ID_NEGARA
where 
(TO_DAYS(NOW()) - TO_DAYS(C.TGL_AKHIR_CARD)) between -30 and 60 $search"));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

   $ilink = "?module=remindidcard"; 
    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>";
    break;
  



      
}
?>
