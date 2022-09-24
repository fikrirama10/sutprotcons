<?php
switch($_GET[act]){
  // Tampil Berita
  default:

		echo "<h2>Non Residence</h2>
			    <!--<form method=get action='./deplu.php?' enctype='multipart/form-data'>
  				  <input type=hidden name=module value='diplomat'>
  				  <input type=hidden name=negara value='$_GET[negara]'>
            Nama Diplomat : <input type=text name=\"namadiplomat\"> <input type=submit value=Cari>
          </form>--> <br>
          <input type=button value='Tambah' onclick=location.href='?module=nonresidence&act=tambahnonresidence&negara=$_GET[negara]'><br><br>

          <table style=width:100% id=tablenonresidence name=tablenonresidence class=display>
            <thead>
              <tr><th width=30>no</th>
                <th>STATES</th>
                <!--<th>NAMA LENGKAP</th>
                <th width=70>NEGARA</th>
                <th width=170>KANTOR PERWAKILAN</th>
                <th width=200>JABATAN</th>-->
                <th width=50>AKSI</th>
              </tr>
            </thead>
          <tbody>";

    $neg = $_GET[negara];

    $list = mysql_query("SELECT a.ID_NEGARA, ID_DIPLOMAT, ID_KNT_PERWAKILAN, b.NEGARA, b.NM_STATES, b.NM_RESMI FROM nonresidence a LEFT JOIN m_negara b ON a.ID_NEGARA = b.ID_NEGARA GROUP BY ID_NEGARA");

    $level = $_SESSION[G_leveluser];
    $no = $posisi+1;
    while($r=mysql_fetch_array($list)){

      echo "    <tr><td>$no</td>
                  <td><a href=?module=nonresidence&act=viewnonreskantor&idt=$r[ID_KNT_PERWAKILAN]>$r[NEGARA]</a></td>
                  <td align=center><a href=?module=kantor&act=editkantor&idt=$r[ID_KNT_PERWAKILAN]>Edit</a> </td>";
      echo "    </tr>";

      $no++;
    }

    echo "  </tbody>
            <tfoot>
              <tr><th></th>
                <th>STATES</th>
                <!--<th>NAMA LENGKAP</th>
                <th width=70>NEGARA</th>
                <th width=170>KANTOR PERWAKILAN</th>
                <th width=70>JABATAN</th>-->
                <th></th></tr>
            </tfoot>
          </table>";
  break;


  case "viewnonreskantor":
	$idt = $_GET[idt];

	$sql=mysql_query("SELECT a.*, b.* FROM m_kantor_perwakilan a LEFT JOIN m_negara b ON a.ID_NEGARA = b.ID_NEGARA WHERE ID_KNT_PERWAKILAN = $idt");
  $r = mysql_fetch_array($sql);

  $lists = "SELECT ID_DIPLOMAT,a.ID_RANK,NEGARA,TGL_CREDENTIAL,TGL_TIBA,d.OFFICIAL_NM as OFFICIAL_RANK,RANK, a.ID_KNT_PERWAKILAN,NM_DIPLOMAT,TITLES, b.OFFICIAL_NM,NM_KNT_PERWAKILAN,ALAMAT,PEKERJAAN,OFFICIAL_PEKERJAAN, NM_SPOUSE, SPOUSE_TITLES FROM nonresidence a
    LEFT JOIN m_kantor_perwakilan b ON a.ID_KNT_PERWAKILAN = b.ID_KNT_PERWAKILAN
    LEFT JOIN m_negara c on a.ID_NEGARA = c.ID_NEGARA
    LEFT JOIN rank d ON a.ID_RANK = d.ID_RANK
    WHERE a.ID_KNT_PERWAKILAN = $idt ORDER BY RANK ASC, TGL_TIBA ASC ";
  $list = mysql_query($lists);

  $dubes= "SELECT COUNT(ID_RANK) FROM ($lists) AS X WHERE ID_RANK='1'";
  $odubes = mysql_query($dubes);
  $adubes = mysql_fetch_array($odubes);

  if (isset($r['NATIONALDAY'])){
  	$oDate1 = new DateTime($r['NATIONALDAY']);
  	$aDate1 = $oDate1->format("F j<\s\u\p>S</\s\u\p>");
  }else{
  	$aDate1="";
  }

  //Jika ada Keppri, munculkan tanggal credential
  if ($adubes['0']>0){
    $neg = mysql_fetch_array(mysql_query("SELECT TGL_CREDENTIAL FROM ($lists) AS TGL_CREDENTIAL WHERE ID_RANK='1' AND ID_KNT_PERWAKILAN = '$idt' "));

    if (isset($neg['TGL_CREDENTIAL'])){
    	$oDate1 = new DateTime($neg['TGL_CREDENTIAL']);
    	$TGl_CRED = $oDate1->format("F j<\s\u\p>S</\s\u\p>, Y");
      $cre = 'Credentials presented by the Ambassador <br>'.$TGl_CRED;
    }else{
    	$cre="";
    }



  }

	echo "<h2>Detail Diplomatic Missions</h2>
  <table width=90%>
  <tr><td colspan=3 align='center'>
      <b>$r[NEGARA]</b> <br>
      $r[NM_KNT_PERWAKILAN] <br>
      $cre
  </td ></tr>
  <tr><td rowspan=5>Chancery</td >
      <td width=50 colspan=2>$r[ALAMAT]</td></tr>
      <td width=50>Phone</td><td >: $r[TELP] </td></tr>
      <td>Fax</td><td >: $r[FAX]</td></tr>
      <td>Email</td><td >: $r[EMAIL]</td></tr>
      <td>Website</td><td >: <a href='$r[WEB]' target='_blank'>$r[WEB]</a> </td></tr>
  <tr><td >Office Hours</td>     <td colspan=2> : $r[OFFHOURS]</td></tr>
  <tr><td width=120>National Day</td >  <td colspan=2> :   $r[KET_NATIONALDAY], $aDate1</td></tr>
  </table>
  <table width=90%>
  <tr>
    <th>NO.</th>
    <th>NAME</th>
    <th>POSITION/TITLE</th>
    <th>ARRIVAL DATE</th>
    <th>ACTION</th>
  </tr>";
// echo $list;exit;
  $level = $_SESSION[G_leveluser];
  $TGL_INI = date('Y-m-d');
  $no = $posisi+1;
  while($rr=mysql_fetch_array($list)){

    if (!isset($rr['OFFICIAL_NM'])){
      $KANTOR = $rr['NM_KNT_PERWAKILAN'];
    }else{
      $KANTOR = $rr['OFFICIAL_NM'];
    }


    if (!isset($rr['NM_STATES'])){
      $NEGARA = $rr['NEGARA'];
    }else{
      $NEGARA = $rr['NM_STATES'];
    }

    if ($rr['ID_RANK']==1){
      $DUBES = 'H.E. ';
    }else{
      $DUBES = '';
    }

    if ($rr['TGL_TIBA']==NULL){
      $aDate="-";
      "-";
    }else{
      $oDate = new DateTime($rr['TGL_TIBA']);
      $aDate = $oDate->format("d.m.Y");
    }

    echo "
    <tr>
        <td width=5%>$no</td>
        <td width=30%><a href=?module=nonresidence&act=viewnonresidence&idt=$rr[ID_DIPLOMAT]&negara=$_GET[negara]>$DUBES $rr[TITLES] $rr[NM_DIPLOMAT] </a>
            <br> $rr[SPOUSE_TITLES] $rr[NM_SPOUSE]</td>
        <td width=30%>$rr[OFFICIAL_PEKERJAAN]<br />$rr[OFFICIAL_RANK]</td>
        <td width=20% align=center> $aDate</td>
        <td width=15% align=center><a href=?module=nonresidence&act=editnonresidence&idt=$rr[ID_DIPLOMAT]&idb=$_GET[idt]&negara=$_GET[negara]>Edit</a> </td></tr>";

        $no++;
    }
  echo "</table>";

	  break;


  case "viewnonresidence":
	$idt = $_GET[idt];
	$sql="SELECT a.ID_NEGARA, b.NM_RESMI, b.NEGARA, a.ID_KNT_PERWAKILAN, c.OFFICIAL_NM, a.ID_DIPLOMAT, a.NM_DIPLOMAT, a.JK AS JK_DIPLOMAT, a.OFFICIAL_PEKERJAAN, a.ID_RANK, a.TGL_TIBA, a.ST_SIPIL, a.TGL_CREDENTIAL, a.KET_DEAN, d.NM_SIBLING, d.JK AS JK_SPOUSE FROM nonresidence a
    LEFT JOIN m_negara b ON a.ID_NEGARA=b.ID_NEGARA
    LEFT JOIN m_kantor_perwakilan c ON a.ID_KNT_PERWAKILAN = c.ID_KNT_PERWAKILAN
    LEFT JOIN nonresidence_sibling d ON a.ID_DIPLOMAT=d.ID_DIPLOMAT
  WHERE a.ID_DIPLOMAT = $idt";

  $edit = mysql_query($sql);
  $r = mysql_fetch_array($edit);

  if ($r['ID_RANK']==1){
    $DUBES = 'H.E. ';
  }else{
    $DUBES = '';
  }

  if ($r['TGL_TIBA']==NULL){
    $TIBA="-";
  }else{
    $oDate = new DateTime($rr['TGL_TIBA']);
    $TIBA = $oDate->format("d F Y");
  }

  if ($r['TGL_CREDENTIAL']==NULL){
    $CRE="-";
  }else{
    $oDate = new DateTime($rr['TGL_CREDENTIAL']);
    $CRE = $oDate->format("d F Y");
  }

	echo "<h2>View Diplomat</h2>
		    <table width=100%>
          <tr>
            <td width=100>Kewarganegaraan</td>
            <td> : ";
              if (!isset($r['NM_RESMI'])){ echo $r['NEGARA'];
              }else{ echo $r['NM_RESMI'];  }
          echo "</td></tr>
          <tr>
            <td>Dipekerjakan pada</td>
            <td>  : ";
                if (!isset($r['OFFICIAL_NM'])){ echo $r['NM_KNT_PERWAKILAN'];
                }else{  echo $r['OFFICIAL_NM'];  }
            echo "</td>
          </tr>
          <tr>
            <td>Nama Diplomat</td>
            <td> : $DUBES $r[TITLES] $r[NM_DIPLOMAT]</td>
          </tr>
		      <!--<tr>
            <td>Tempat/Tanggal Lahir</td>
            <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
		      <tr>-->
            <td>Jenis Kelamin</td>
            <td> : ";
		          if ($r[JK]=='l'){ echo "Laki-laki";
              } else { echo "Perempuan";	}
		        echo "</td> </tr>
		        <tr><td>Jabatan</td>
              <td > : ".ucfirst(strtolower($r['OFFICIAL_PEKERJAAN']))."</td>
            </tr>";

            $tampil=mysql_query("SELECT NM_RANK,KODE_LAYANAN,KET FROM rank where ID_RANK = $r[ID_RANK]");
			      $w=mysql_fetch_array($tampil);

            echo "<tr><td>Rank</td >  <td > : $w[NM_RANK] - $w[KODE_LAYANAN] - $w[KET]</td></tr>
            <tr><td>Tanggal Tiba</td >  <td > : $TIBA</td></tr>";

            if ($r['ID_RANK']==1){
            echo "<tr><td>Tanggal Credential</td><td > : $CRE</td></tr>"; }
	          echo "<tr>
              <td>Status Sipil</td>
              <td> : ";
                if ($r['ST_SIPIL']=='s'){
                  echo "Belum Menikah";
                } elseif ($r['ST_SIPIL']=='m') {
	                 echo "Sudah Menikah";
                }else{
                  echo "-";
                }
            echo "</td></tr>";

            if ($r['ST_SIPIL']==m){
              echo "<tr>
                <td>Nama Spouse</td>
                <td> : $r[SPOUSE_TITLES] $r[NM_SIBLING]</td>
              </tr>";
            }
		        echo "<tr><td colspan=3 align=right>
              <input type=button value=Kembali onclick=self.history.back()></td>
            </tr>
        </table>";


//data sibling
	  break;


  case "tambahnonresidence":
    echo "<h2>Tambah Non Residence</h2>
          <form method=POST action='./aksi_nonresidence.php?module=nonresidence&act=input&negara=$_GET[negara]' enctype='multipart/form-data'>
          <table width=100%>
            <tr>
              <td width=120>Kewarganegaraan &nbsp; <font color='red'>*</font></td>
              <td colspan=\"2\"> : <select name='ID_NEGARA' onChange='javascript:dinamisKantor(this)'>
                <option value=0 selected>- Not Defined -</option>";
                    $tampil=mysql_query("SELECT * FROM m_negara where id_negara > 1 ORDER BY negara");
                    while($r=mysql_fetch_array($tampil)){
                        echo "<option value=$r[ID_NEGARA]>$r[NEGARA]</option>";
                    }
    echo "    </select></td>
            <tr>
              <td>Dipekerjakan pada &nbsp; <font color='red'>*</font></td>
              <td colspan=\"2\">  : <select name='ID_KNT_PERWAKILAN' class='greyed'>";
                    $tampil=mysql_query("SELECT ID_KNT_PERWAKILAN,NM_KNT_PERWAKILAN  FROM m_kantor_perwakilan where ID_KNT_PERWAKILAN > 1 ORDER BY NM_KNT_PERWAKILAN");
                    while($w=mysql_fetch_array($tampil)){
			                   echo "<option value=$w[ID_KNT_PERWAKILAN]>$w[NM_KNT_PERWAKILAN]</option>";
			              }
    echo "    </select></td>
			      </tr>
			      <!--<tr>
              <td>Dipekerjakan pada Perwakilan / Mission &nbsp; <font color='red'>*</font></td>
              <td colspan=\"2\"> <div id='tampilkantor'></div></td>
            </tr>
            <tr>
              <td>Kategori Pemohon &nbsp; <font color='red'>*</font></td>
              <td colspan=\"2\"><select name='KATEGORI_PEMOHON'>
                <option value=0 selected>- Not Defined -</option>-->";
	                 // $tampil=mysql_query("SELECT * FROM m_kategori_pemohon  where ID_KATEGORI_PEMOHON !=3 order by ID_KATEGORI_PEMOHON asc");
                   //   while($r=mysql_fetch_array($tampil)){
                   //     echo "<option value=$r[ID_KATEGORI_PEMOHON]>$r[NAMA_KATEGORI]</option>";
                   //   }
		// echo "</select></td></tr>";

		echo "  <tr>
              <td>Nama Diplomat &nbsp; <font color='red'>*</font></td>
              <td colspan=\"2\"> : <input type=text name='NM_DIPLOMAT' size=50> &nbsp;&nbsp;*tanpa honorifik</td>
              <!--<td rowspan=\"5\"  width=120 align=center><img src=\"\" width=110 height=150 border=1></td>-->
            </tr>
		        <!--<tr><td>Tempat Lahir &nbsp; <font color='red'>*</font></td>
              <td> : <input type=text name='TEMPAT_LAHIR' size=50></td>
            </tr>
			      <tr>
              <td>Tanggal Lahir &nbsp; <font color='red'>*</font> </td>
              <td><DIV id=\"tgl\"> <script>DateInput('TGL_LAHIR', true, 'YYYY-MM-DD')</script></div></td>
            </tr>-->
		        <tr>
              <td>Jenis Kelamin &nbsp; <font color='red'>*</font></td>
              <td colspan=\"2\"> : <input type=radio name='JK' value=l checked>L <input type=radio name='JK' value=p >P </td>
            </tr>
            <!--<tr>
              <td>Titles &nbsp; <font color='red'>*</font> </td >
              <td colspan=\"2\"> : <select name='TITLES' >
            	    <option value ='' style=display:none>-</option>
                  <option value='Mr.'>Mr.</option>
            	    <option value='Mrs.'>Mrs.</option>
            	    <option value='Ms.'>Ms.</option>
              </select></td>
            </tr>
		        <tr>
              <td>Foto &nbsp; <font color='red'>*</font> </td>
              <td > : <input type=file size=40 name=fupload></td>
            </tr>
		        <tr>
              <td>Tanda tangan &nbsp; <font color='red'>*</font> </td>
              <td > : <input type=file size=40 name=fuploadttd></td>
              <td rowspan=\"3\"  width=120 align=center><img src=\".\" width=110 height=100% border=1></td>
           </tr>-->
		       <!--<tr><td>Gelar</td >     <td > : <input type=text name='GELAR' size=50></td></tr>-->
		       <tr><td>Rank / Gelar </td >
              <td > :  <select name='ID_RANK' id='ID_RANK'><option value=''>Pilih Gelar</option>";
                  $tampil=mysql_query("SELECT NM_RANK,KODE_LAYANAN,KET,ID_RANK FROM rank ORDER BY NM_RANK");
                  // $ai = 1;
			            while($r=mysql_fetch_array($tampil)){
                    // if ($ai==1){
			                   // echo "<option value=$r[ID_RANK] selected>$r[NM_RANK] - $r[KODE_LAYANAN] - $r[KET]</option>";
			              // }else{
			                   echo "<option value=$r[ID_RANK] >$r[NM_RANK] - $r[KODE_LAYANAN] - $r[KET]</option>";
			              }
			            // $ai=0;
                // }

    echo "    </select></td>
           </tr>
           <tr><td>Jabatan/Posisi di Kantor Perwakilan</td>
              <td> : <input type=text id='pekerjaan' name='PEKERJAAN' size=50> &nbsp;&nbsp;
              <select onchange='myFunction(event)'><option value=''>Pilih</option>";
                    $tampil=mysql_query("SELECT DISTINCT OFFICIAL_PEKERJAAN FROM nonresidence WHERE OFFICIAL_PEKERJAAN!=''");
                    while($r=mysql_fetch_array($tampil)){
               echo "<option value='$r[OFFICIAL_PEKERJAAN]'>$r[OFFICIAL_PEKERJAAN]</option>";
             }
              echo "</select> </td>
           </tr>
              <td>Tanggal tiba &nbsp; <font color='red'>*</font></td>
              <td colspan=\"2\">
                    <DIV id=\"tgl\"> <script>DateInput('TGL_TIBA', true, 'YYYY-MM-DD')</script></div></td>
            </tr>
            <!--<tr><td>Alamat di Luar Negeri </td>
              <td colspan=\"2\"> : </td>
            </tr>
            <tr>
              <td>Jenis / No. Paspor &nbsp; <font color='red'>*</font> </td >
              <td colspan=\"2\"> :  <select name='ID_JNS_PASPOR' >
                <option value=1 selected>- Not Defined -</option>-->";
                  // $tampil=mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR > 1 ORDER BY JNS_PASPOR");
                  // while($r=mysql_fetch_array($tampil)){
                  //   echo "<option value=$r[ID_JNS_PASPOR]>$r[JNS_PASPOR]</option>";
                  // }

    // echo "    </select> <input type=text name='NO_PASPOR' size=50></td>
    //         </tr>
		//         <tr>
    //           <td>Tanggal Mulai Berlaku</td >
    //           <td colspan=\"2\"> <DIV id=\"tgl\"> <script>DateInput('PASPOR_TGL', true, 'YYYY-MM-DD')</script></div> <input type=hidden name='PASPOR_OLEH' size=50></td>
    //         </tr>
		//         <tr><td>Berlaku s/d</td >
    //           <td colspan=\"2\"> <DIV id=\"tgl\"> <script>DateInput('AKHIR_BERLAKU', true, 'YYYY-MM-DD')</script></div></td>
    //         </tr>
    //         <tr>
    //           <td>Jenis / No. Visa / Status &nbsp; <font color='red'>*</font> </td >
    //           <td colspan=\"2\"> : <select name='ID_JNS_VISA' >
    //             <option value=1 selected>- Not Defined -</option>";
                  // $tampil=mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA > 1 ORDER BY NM_JNS_VISA");
                  // while($r=mysql_fetch_array($tampil)){
                  //   echo "<option value=$r[ID_JNS_VISA]>$r[NM_JNS_VISA]</option>";
                  // }

    // echo "       </select> &nbsp<input type=text name='NO_VISA' size=50>
	  //                <input type=radio name='ST_VISA' value=0 ><b style=\"color : #800000\">reject</b>
	  //                <input type=radio name='ST_VISA' value=1 checked><b style=\"color : #B1BF19\">waiting</b>
	  //                <input type=radio name='ST_VISA' value=2 ><b style=\"color : green\">approve</b>
	  //              </td>
    //            </tr>
		//            <tr>
    //              <td>Diberikan oleh</td>
    //              <td colspan=\"2\"> : <input type=text name='VISA_OLEH' size=50></td>
    //            </tr>
		//            <tr>
    //              <td>Lama berdiam di Indonesia &nbsp; <font color='red'>*</font> </td >
    //              <td colspan=\"2\"> : <select name='LAMA_BERDIAM' >
		// 	              <option value=0 selected >0 tahun</option>
		//                 <option value=1 >1 tahun</option>
		// 	              <option value=2 >2 tahun</option>
		// 	              <option value=3 >3 tahun</option>
		//              </select> &nbsp
    //              <select name='LAMA_BERDIAM_BLN' >
		// 	              <option value=0 selected >0 bulan</option>
		//                 <option value=1 >1 bulan</option>
		// 	              <option value=2 >2 bulan</option>
		// 	              <option value=3 >3 bulan</option>
    //                 <option value=4 >4 bulan</option>
		// 	              <option value=5 >5 bulan</option>
		// 	              <option value=6 >6 bulan</option>
    //                 <option value=7 >7 bulan</option>
		// 	              <option value=8 >8 bulan</option>
		// 	              <option value=9 >9 bulan</option>
    //                 <option value=10 >10 bulan</option>
		// 	              <option value=11 >11 bulan</option>
    //              </select></td>
    //            </tr>
		//            <tr>
    //              <td>Tanggal tiba</td >
    //              <td colspan=\"2\"> <DIV id=\"tgl\"> <script>DateInput('TGL_TIBA', true, 'YYYY-MM-DD')</script></div></td>
    //            </tr>
    //            <tr>
    //              <td>Alamat Indonesia</td >
    //              <td colspan=\"2\"> : <textarea name='ALAMATIN' rows=2 cols=55 ></textarea></td>
    //           </tr>
    //           <tr>
    //             <td>Telepon</td >
    //             <td colspan=\"2\"> : <input type=text name='TELP' size=50></td>
    //           </tr>
    //           <tr>
    //             <td>No SP SETNEG</td >
    //             <td colspan=\"2\"> : <input type=text name='NO_SETKAB' size=50></td>
    //           </tr>
    //           <tr>
    //             <td>No Nodin SETNEG</td >
    //             <td colspan=\"2\"> : <input type=text name='NO_SR_SETNEG' size=50></td>
    //           </tr>
		//           <tr>
    //             <td>Berlaku s/d</td >
    //             <td colspan=\"2\">  <DIV id=\"tgl\"> <script>DateInput('BERLAKUSD', true, 'YYYY-MM-DD')</script></div></td>
    //           </tr>
    //           <tr>
    //             <td>No. Surat Sponsor</td >
    //             <td colspan=\"2\"> : <input type=text name='NO_SPONSOR' size=50></td>
    //           </tr>";

		echo "
                <tr class='dubes' style='display:none'>
                  <td>Tanggal Credential</td>
                  <td colspan=\"2\">
                    <DIV id=\"tgl\"> <script>DateInput('TGL_CREDENTIAL', true, 'YYYY-MM-DD')</script></div></td>
                </tr>
                <tr class='dubes' style='display:none'>
                    <td>DEAN</td>
                    <td colspan=\"2\">:  <input type=radio name='DEAN' class='dean' value=l>Ya <input type=radio name='DEAN' value=0 class='dean'>Tidak </td>
                </tr>
                <tr>
                  <td>Status Sipil &nbsp;</td>
                  <td colspan=\"2\"> :
                      <input type=radio name='ST_SIPIL' value=s id=st_sipil_s class='status'>Single
                      <input type=radio name='ST_SIPIL' value=m id=st_sipil_m class='status'>Married </td>
                </tr>
                <tr class='spouse' >
                  <td>Nama Spouse &nbsp; <font color='red'></font></td>
                  <td colspan=\"2\"> : <input type=text name='NM_SPOUSE' size=50></td>
                </tr>
                <tr class='spouse' >
                  <td>Jenis Kelamin Spouse &nbsp; <font color='red'></font></td>
                  <td colspan=\"2\"> : <input type=radio name='JK_SPOUSE' value=l>L <input type=radio name='JK_SPOUSE' value=p >P </td>
                </tr>
                <tr>
                    <td colspan=3 align=right><input type=submit value=Simpan>
                      <input type=button value=Batal onclick=self.history.back()></td>
                 </tr>
              </table></form>

              <script>
              $('#ID_RANK').change(function(){
                if($('#ID_RANK').val() == 1){
                  $('.dubes').show();
                } if($('#ID_RANK').val() != 1){
                  $('.dubes').hide();
                }
              });

              function myFunction(e) {
                document.getElementById('pekerjaan').value = e.target.value
              }

              </script>";
     break;

  case "editnonresidence":
    $idt = $_GET[idt];
    $edit = mysql_query("SELECT a.ID_NEGARA, b.NM_RESMI, a.ID_KNT_PERWAKILAN, c.OFFICIAL_NM, a.ID_DIPLOMAT, a.NM_DIPLOMAT, a.JK AS JK_DIPLOMAT, a.OFFICIAL_PEKERJAAN, a.ID_RANK, a.TGL_TIBA, a.ST_SIPIL, a.TGL_CREDENTIAL, a.KET_DEAN, d.NM_SIBLING, d.JK AS JK_SPOUSE FROM nonresidence a
      LEFT JOIN m_negara b ON a.ID_NEGARA=b.ID_NEGARA
      LEFT JOIN m_kantor_perwakilan c ON a.ID_KNT_PERWAKILAN = c.ID_KNT_PERWAKILAN
      LEFT JOIN nonresidence_sibling d ON a.ID_DIPLOMAT=d.ID_DIPLOMAT
    WHERE a.ID_DIPLOMAT = $idt");
    $r = mysql_fetch_array($edit);

    echo "<h2>Edit Diplomat</h2>
         <form method=POST enctype='multipart/form-data' action='./aksi_nonresidence.php?module=nonresidence&act=update&idb=$_GET[idb]&negara=$_GET[negara]'>
         <input type=hidden name='idt' value='$r[ID_DIPLOMAT]'>

		     <table width=100%>
            <tr><td width=120>Kewarganegaraan &nbsp; <font color='red'>*</font></td>
                <td colspan=\"2\"> : <select name='ID_NEGARA'>";
                    $tampil=mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara ORDER BY ID_NEGARA");
                    while($w=mysql_fetch_array($tampil)){
                      if ($r[ID_NEGARA]==$w[ID_NEGARA]){
                          echo "<option value=$w[ID_NEGARA] selected>$w[NEGARA]</option>";
			                }else{
				                   echo "<option value=$w[ID_NEGARA]>$w[NEGARA]</option>";
  			              }
			              }
		               echo"</select></td>
            </tr>
            <tr><td>Dipekerjakan pada &nbsp; <font color='red'>*</font></td>
                <td colspan=\"2\">  : <select name='ID_KNT_PERWAKILAN'>";
                    $tampil=mysql_query("SELECT ID_KNT_PERWAKILAN,NM_KNT_PERWAKILAN  FROM m_kantor_perwakilan where ID_KNT_PERWAKILAN > 1 ORDER BY NM_KNT_PERWAKILAN");
                    while($w=mysql_fetch_array($tampil)){
                      if ($r[ID_KNT_PERWAKILAN]==$w[ID_KNT_PERWAKILAN]){
                          echo "<option value=$w[ID_KNT_PERWAKILAN] selected>$w[NM_KNT_PERWAKILAN]</option>";
                      }else{
                          echo "<option value=$w[ID_KNT_PERWAKILAN]>$w[NM_KNT_PERWAKILAN]</option>";
                      }
			              }
                echo "</select></td>
		        <tr>
		            <td>Nama Diplomat &nbsp; <font color='red'>*</font></td>
                <td>: <input type=text name='NM_DIPLOMAT' size=50 value= '$r[NM_DIPLOMAT]' > *tanpa honorifik </td>
		        </tr>
		        <!--<tr>
                <td>Tempat Lahir &nbsp; <font color='red'>*</font></td>
                <td> : <input type=text name='TEMPAT_LAHIR' size=50 value= '$r[TEMPAT_LAHIR]' class='greyed'></td>
            </tr>
			      <tr>
                <td>Tanggal Lahir &nbsp; <font color='red'>*</font></td>
                <td><DIV id=\"tgl\" > <script>DateInput('TGL_LAHIR', true, 'YYYY-MM-DD','$r[TGL_LAHIR]')</script></div></td>
            </tr>-->
		        <tr><td>Jenis Kelamin &nbsp; <font color='red'>*</font> </td>
                <td> : ";
                  if ($r[JK_DIPLOMAT]=='l'){
                    echo "<input type=radio name='JK' value=l checked>L <input type=radio name='JK' value=p>P ";
                  }elseif ($r[JK_DIPLOMAT]=='p'){
                    echo "<input type=radio name='JK' value=l >L <input type=radio name='JK' value=p checked>P ";
                  }
                echo "</td> </tr>
             <!--<tr>
                <td>Titles &nbsp; <font color='red'>*</font> </td >
                <td colspan=\"2\"> : <select name='TITLES' >
                    <option value".$r['TITLES'].">".$r['TITLES']."</option>
                    <option value='Mr.'>Mr.</option>
                    <option value='Mrs.'>Mrs.</option>
                    <option value='Ms.'>Ms.</option>
                </select></td>
             </tr>-->
	           <tr><td>Jabatan</td>
                 <td> : <input type=text name='PEKERJAAN' size=50 value= '$r[OFFICIAL_PEKERJAAN]'></td>
             </tr>
             <tr><td>Rank &nbsp; <font color='red'>*</font></td >
                <td> :  <input type=hidden name='GELAR' size=50 value= '$r[GELAR]' $r1>
		                <select name='ID_RANK'>";
                        $tampil=mysql_query("SELECT NM_RANK,KODE_LAYANAN,KET,ID_RANK FROM rank ORDER BY NM_RANK");
                        while($w=mysql_fetch_array($tampil)){
                            if ($r[ID_RANK]==$w[ID_RANK]){
			                          echo "<option value=$w[ID_RANK] selected>$w[NM_RANK] - $w[KODE_LAYANAN] - $w[KET]</option>";
			                      }else{
                                echo "<option value=$w[ID_RANK] >$w[NM_RANK] - $w[KODE_LAYANAN] - $w[KET]</option>";
			                      }
			                  }
            echo "</select></td></tr>
		        <tr><td>Tanggal tiba &nbsp; <font color='red'>*</font></td >
                <td colspan=\"2\">";
                if($r['TGL_TIBA']){
                    echo " <DIV id=\"tgl\"> <script>DateInput('TGL_TIBA', true, 'YYYY-MM-DD','$r[TGL_TIBA]')</script></div>";
                } else {
                    $TGL_TIBA = '0000-00-00';
                    echo "<DIV id=\"tgl\" > <script>DateInput('TGL_TIBA', true, 'YYYY-MM-DD','$TGL_TIBA')</script></div>";
                }
            echo "</td>
            </tr>";
        if($r[ID_RANK]==1){
            echo "<tr><td>Tanggal Credential</td>
                <td colspan=\"2\">";
            if($r['TGL_CREDENTIAL']){
                echo " <DIV id=\"tgl\" class=\"tgl_creden\"> <script>DateInput('TGL_CREDENTIAL', true, 'YYYY-MM-DD','$r[TGL_CREDENTIAL]')</script></div>";
            } else {
                $TGL_CREDENTIAL = '0000-00-00';
                echo "<DIV id=\"tgl\" class=\"tgl_creden\"> <script>DateInput('TGL_CREDENTIAL', true, 'YYYY-MM-DD','$TGL_CREDENTIAL')</script></div>";
            }
            echo "</td></tr>
            <tr><td>DEAN</td>
                <td colspan=\"2\">: ";
                if ($r['KET_DEAN']=='1'){
      		          echo "<input type=radio name='DEAN' class='dean' value=l checked>Ya <input type=radio name='DEAN' value=0 class='dean'>Tidak ";
                }else{
                    echo "<input type=radio name='DEAN' class='dean' value=l >Ya <input type=radio name='DEAN' class='dean' value=0 checked>Tidak </td> </tr>";
                }
           }

           echo "<tr>
                <td>Status Sipil &nbsp; <font color='red'>*</font> </td>
                <td colspan=\"2\"> :";
                if ($r[ST_SIPIL]=='s'){
                 echo "<input type=radio name='ST_SIPIL' value=s id=st_sipil_s class='status' checked>Single
                 <input type=radio name='ST_SIPIL' value=m id=st_sipil_m class='status'>Married";
               }elseif ($r[ST_SIPIL]=='m'){
                 echo "<input type=radio name='ST_SIPIL' value=s id=st_sipil_s class='status'>Single
                 <input type=radio name='ST_SIPIL' value=m id=st_sipil_m class='status' checked>Married";
               }else{
                 echo "<input type=radio name='ST_SIPIL' value=s id=st_sipil_s class='status'>Single
                 <input type=radio name='ST_SIPIL' value=m id=st_sipil_m class='status'>Married";
               }
           echo "</td></tr>
           <tr class='spouse' >
             <td>Nama Spouse &nbsp; <font color='red'></font></td>
             <td colspan=\"2\"> : <input type=text name='NM_SPOUSE' value= '$r[NM_SIBLING]' size=50></td>
           </tr>
           <tr class='spouse'><td>Jenis Kelamin Spouse&nbsp; <font color='red'>*</font> </td>
               <td> : ";
                 if ($r[JK_SPOUSE]=='l'){
                   echo "<input type=radio name='JK_SPOUSE' value=l checked>L <input type=radio name='JK_SPOUSE'  value=p>P ";
                 }elseif ($r[JK_SPOUSE]=='p'){
                   echo "<input type=radio name='JK_SPOUSE' value=l>L <input type=radio name='JK_SPOUSE' value=p  checked>P ";
                 }else{
                   echo "<input type=radio name='JK_SPOUSE' value=l >L <input type=radio name='JK_SPOUSE' value=p >P ";
                 }
               echo "</td> </tr>
           <!--<tr class='spouse'>
              <td>Titles Spouse &nbsp; <font color='red'>*</font> </td >
              <td colspan=\"2\"> : <select name='SPOUSE_TITLES' >
                  <option value".$r['SPOUSE_TITLES'].">".$r['SPOUSE_TITLES']."</option>
                  <option value='Mr.'>Mr.</option>
                  <option value='Mrs.'>Mrs.</option>
                  <option value='Ms.'>Ms.</option>
              </select></td>
           </tr>-->

		       <tr><td colspan=3 align=right><input type=submit value=Update>
              <input type=button value=Batal onclick=self.history.back()></td>
           </tr>
        </table>
        </form>";
	 break;


  case "cari":
    $alf = $_GET[huruf];

    echo "<br><br><a style=\"font-size: 22pt;\">$alf</a>";
	echo "<h2>Diplomat List</h2>
	<table width=100%>
          <tr><th width=10 rowspan=2>no</th><th rowspan=2>Negara</th><th colspan=3>Fasilitas Diberikan oleh Indonesia</th><th colspan=3>Rantor Diberikan ke Indonesia</th></tr>
			<tr><th  width=80 >JENIS FASILITAS</th><th  width=80 >JML RANTOR KANTOR</th><th width=80 >JML RANTOR INDIVIDU</th> <th  width=80 >JENIS FASILITAS</th><th  width=80 >JML RANTOR KANTOR</th><th width=80 >JML RANTOR INDIVIDU</th></tr>
			 ";


    $p      = new Paging;
    $batas  = 200;
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
				&nbsp <a href=?module=diplomat&negara=$r[NEGARA]>$r[NEGARA] </a></td><td>";

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
					<td align=right> $r[NEG_RANTOR_K] </td><td align=right> $r[NEG_RANTOR_I]</td>
		            </tr>";
      $no++;
    }
    echo "</table>";
        echo "Keterangan <br>";
			$tampilFas=mysql_query("select ID_JNS_FASILITAS,JNS_FASILITAS from m_jns_fasilitas order by ID_JNS_FASILITAS");
           			 	while($rFas=mysql_fetch_array($tampilFas)){
              				echo "$rFas[ID_JNS_FASILITAS] = $rFas[JNS_FASILITAS] <br>";
							}
	break;

}
?>

<style type="text/css">
thead input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>

<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
		$('#tablenonresidence tfoot th').each(function(){
				var title = $(this).text();
        $(this).html('<input type="text" placeholder="'+title+'" />');

				var r = $('#tablenonresidence tfoot tr');
				$('#tablenonresidence thead').append(r);
    });

    // DataTable
    var table = $('#tablenonresidence').DataTable();

    //Apply the search
    table.columns().every( function (){
        var that = this;

        $('input', this.header()).on('keyup change', function(){
            if (that.search() !== this.value){
                that
                    .search(this.value)
                    .draw();
            }
        });

				$('input', this.header()).on('click', function(d){
						d.stopPropagation();
				});
    });
});
</script>
