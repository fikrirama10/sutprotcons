<?php
    echo "<br><a href=?module=idcard&act=cari&huruf=A>A</A> |	<a href=?module=idcard&act=cari&huruf=B>B</A> |	<a href=?module=idcard&act=cari&huruf=C>C</A> |	<a href=?module=idcard&act=cari&huruf=D>D</A> |	<a href=?module=idcard&act=cari&huruf=E>E</A> |	<a href=?module=idcard&act=cari&huruf=F>F</A> |	<a href=?module=idcard&act=cari&huruf=G>G</A> |	<a href=?module=idcard&act=cari&huruf=H>H</A> |	<a href=?module=idcard&act=cari&huruf=I>I</A> |	<a href=?module=idcard&act=cari&huruf=J>J</A> |	<a href=?module=idcard&act=cari&huruf=K>K</A> |	<a href=?module=idcard&act=cari&huruf=L>L</A> |	<a href=?module=idcard&act=cari&huruf=M>M</A> |	<a href=?module=idcard&act=cari&huruf=N>N</A> |	<a href=?module=idcard&act=cari&huruf=O>O</A> |	<a href=?module=idcard&act=cari&huruf=P>P</A> |	<a href=?module=idcard&act=cari&huruf=Q>Q</A> |	<a href=?module=idcard&act=cari&huruf=R>R</A> |	<a href=?module=idcard&act=cari&huruf=S>S</A> |	<a href=?module=idcard&act=cari&huruf=T>T</A> |	<a href=?module=idcard&act=cari&huruf=U>U</A> |	<a href=?module=idcard&act=cari&huruf=V>V</A> |	<a href=?module=idcard&act=cari&huruf=W>W</A> |	<a href=?module=idcard&act=cari&huruf=X>X</A> |	<a href=?module=idcard&act=cari&huruf=Y>Y</A> |	<a href=?module=idcard&act=cari&huruf=Z>Z</A>";

switch ($_GET[act]) {
    default:

        if (isset($_GET[negara])) {
            $negaranya = $_GET[negara];
            if ($_GET[negara] == "") {$negaranya = 'Semua negara'; }

        } else {
            $negaranya = 'Semua negara';
        }
            echo "<h2>Pengajuan ID Card<br>Pilih Diplomat - $negaranya</h2>
                <form method=get action='./deplu.php?' enctype='multipart/form-data'>
                        <input type=hidden name=module value='idcard'>
                        <input type=hidden name=negara value='$_GET[negara]'>
                Nama Diplomat : <input type=text name=\"namadiplomat\"> <input type=submit value=Cari>
                </form> <br>

                <table width=100%>
                <tr><th width=30>no</th><th>NO PENDAFTARAN</th><th>Status</th><th>ID CARD</th><th width=130>NAMA LENGKAP</th><th width=160>KANTOR PERWAKILAN</th><th>JABATAN</th><th width=70>TGL BERLAKU</th><th>STATUS</th><th width=30>D</th><th width=30>K</th></th><th width=55>AKSI</th></tr>";

        $p      = new Paging;
        $batas  = 10;
        $posisi = $p->cariPosisi($batas);

        $neg = $_GET[negara];

        if (isset($_GET[namadiplomat])){

            $sql=("
            select a.ID_CARD,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.PEKERJAAN, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,
            date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD, a.ST_KARTU,a.ST_KARTU_K,a.ST_KARTU_KAS, a.STATUS_PENGEMBALIAN, NO_DAFTAR, STATUS_WORKFLOW  from v_diplomat c
            left join v_id_card a  on a.id_diplomat=c.id_diplomat and KD_WORKFLOW>=1 where c.NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' order by a.tgl_kirim desc, a.id_cetak desc limit $posisi,$batas");

            $tampil=mysql_query($sql);
        } else {
            $sql=("select a.ID_CARD,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.PEKERJAAN, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD, a.ST_KARTU,a.ST_KARTU_K,a.ST_KARTU_KAS  from v_id_card a right join v_diplomat c on a.id_diplomat=c.id_diplomat order by a.id_card desc limit $posisi,$batas");
            $sql = "select a.ID_CARD,c.ID_DIPLOMAT,c.NM_DIPLOMAT,c.NM_KNT_PERWAKILAN,c.PEKERJAAN, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as
            TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD, a.ST_KARTU,a.ST_KARTU_K,a.ST_KARTU_KAS,a.STATUS_PENGEMBALIAN, NO_DAFTAR, STATUS_WORKFLOW    from v_diplomat c
            left join v_id_card a  on a.id_diplomat=c.id_diplomat and KD_WORKFLOW>=1 order by a.tgl_kirim desc,  a.id_cetak desc limit $posisi,$batas";

            $tampil=mysql_query($sql);

        }

        $no = $posisi+1;
        while($r=mysql_fetch_array($tampil)) {

            echo "<tr><td>$no</td>
                <td><a href=?module=idcard&act=lihat_id_card&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NO_DAFTAR]</a></td>
                <td>$r[STATUS_WORKFLOW]</td>
                <td><a href=?module=idcard&act=lihat_id_card&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[ID_CARD]</a></td>
                <td><a href=?module=diplomat&act=viewdiplomat&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>$r[NM_DIPLOMAT]</a></td>
                <td>$r[NM_KNT_PERWAKILAN]</td>
                <td>$r[PEKERJAAN]</td>
                <td>$r[TGL_AKHIR_CARD] - $r[TGL_AWAL_CARD]</td>
                ";
            echo "<td>$r[STATUS_PENGEMBALIAN]</td>";

            echo"	<td align =center>";

            if (isset($r[ST_KARTU])) {
                if ($r[ST_KARTU] == 2) {
                    echo "<div style=\"color : green\"> <b>A</b> </div>";
                } elseif ($r[ST_KARTU] == 1) {
                    echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
                } elseif ($r[ST_KARTU] == 0) {
                    echo "<div style=\"color : #800000\"> <b>R</b> </div>";
                }
            } else {
                echo "-";
            }

            echo "</td><td align =center>";
            
            if (isset($r[ST_KARTU_K])) {
                if ($r[ST_KARTU_K] == 2) {
                    echo "<div style=\"color : green\"> <b>A</b> </div>";
                } elseif ($r[ST_KARTU_K] == 1) {
                    echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
                } elseif ($r[ST_KARTU_K] == 0) {
                    echo "<div style=\"color : #800000\"> <b>R</b> </div>";
                }
            } else {
                echo "-";
            }

            echo "</td>
                <td><a href=?module=idcard&act=lihat_id_card&idt=$r[ID_DIPLOMAT]&negara=$_GET[negara]>Lihat ID Card</a></td>
                </tr>";
            $no++;
        }

        echo "</table>";

        if (isset($_GET[namadiplomat])) {
            $jmldata =mysql_num_rows(mysql_query("SELECT ID_DIPLOMAT,NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN,PEKERJAAN FROM  v_diplomat where negara like '".$neg."%' and NM_DIPLOMAT like '%".$_GET[namadiplomat]."%' "));
        } else {
            $jmldata =mysql_num_rows(mysql_query("SELECT ID_DIPLOMAT,NM_DIPLOMAT,NEGARA,NM_KNT_PERWAKILAN,PEKERJAAN FROM  v_diplomat where negara like '".$neg."%'"));
        }

        $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);

        $ilink = "?module=idcard&negara=$_GET[negara]&namadiplomat=$_GET[namadiplomat]";

        $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);

        echo "<div id=paging>$linkHalaman</div><br>";
        break;

    case "viewdiplomat":
        $idt = $_GET[idt];

        $edit = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt ");

        $r = mysql_fetch_array($edit);

        echo "<h2>View Diplomat</h2>
            <table width=100%>
            <tr><td  width=160>Asal Negara</td>  <td > : ";

        $tampil = mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
        $w = mysql_fetch_array($tampil);


        $detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idt)");
        $det = mysql_fetch_array($detil);

        echo "$w[NEGARA] </td><td rowspan=\"19\"  width=200 ><div align=center><img src=\"../foto/$r[FOTO]\" width=110 height=150 border=1> </div><br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br><br>";

        $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");
        $det = mysql_fetch_array($detil);

        echo "<b>Stay Permit </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No Izin Permit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";

        $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");
        $det = mysql_fetch_array($detil);

        echo "<b>Sibling </b><br>";

        $nosib = 1;
        $detil=mysql_query("select  NM_SIBLING,NM_JNS_RELASI from v_sibling where ID_DIPLOMAT = $idt order by ID_JNS_RELASI");

        while ($det=mysql_fetch_array($detil)) {
            echo "$nosib. $det[NM_SIBLING] - $det[NM_JNS_RELASI] <br>";
            $nosib=$nosib+1;
        }

        echo "<br>
        <b>Rantor </b><br><br>
        <b>Fasilitas Lainnya </b><br><br>
        </td>
		<tr><td>Nama Diplomat</td>     <td> : $r[NM_DIPLOMAT]</td></tr>
		<tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : ";
		
        if ($r[JK] == 'l') {
            echo "Laki-laki";
        } else {
            echo "Perempuan";
        }
        
		echo "</td> </tr>
		<tr><td>Pekerjaan</td >  <td > : $r[PEKERJAAN]</td></tr>
		<tr><td>Status Sipil</td>     <td  > : ";

		if ($r[ST_SIPIL] == 's'){
            echo "Sudah Menikah";
        } else {
            echo "Belum Menikah";
        }
		echo "</td></tr>
		<tr><td>Alamat Indonesia </td>     <td > : <textarea name='ALAMATIN' rows=2 cols=48 readonly=\"readonly\" >$r[ALAMATIN]</textarea></td></tr>

		<tr><td>Jenis / No. Paspor</td >     <td > :  ";

        $tampil = mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");
        $w = mysql_fetch_array($tampil);

        echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR]</td></tr>
		<tr><td>Diberikan oleh</td >     <td > : $r[PASPOR_OLEH]  -  $r[PASPOR_TGL] </td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[AKHIR_BERLAKU]</td></tr>

		<tr><td>Jenis / No. Visa</td >     <td > : ";

        $tampil = mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA = $r[ID_JNS_VISA]");
        $w = mysql_fetch_array($tampil);

        echo " $w[NM_JNS_VISA] / $r[NO_VISA] </td></tr>
		<tr><td>Diberikan oleh</td >     <td > : $r[VISA_OLEH]</td></tr>
		<tr><td>Lama berdiam di Indonesia</td >     <td > : $r[LAMA_BERDIAM] hari</td></tr>
		<tr><td>Tanggal tiba</td >     <td > : $r[TGL_TIBA]</td></tr>

		<tr><td>Alamat di Indonesia</td >     <td > : <textarea name='ALAMATIN' rows=2 cols=48 readonly=\"readonly\">$r[ALAMATIN]</textarea></td></tr>
		<tr><td>Dipekerjakan pada</td >     <td >  : ";
        $tampil=mysql_query("SELECT ID_KNT_PERWAKILAN,NM_KNT_PERWAKILAN  FROM m_kantor_perwakilan where ID_KNT_PERWAKILAN = $r[ID_KNT_PERWAKILAN]");
        $w=mysql_fetch_array($tampil);

        echo "$w[NM_KNT_PERWAKILAN] </td></tr>
		<tr><td>No SETKAB</td >     <td > : $r[NO_SETKAB]</td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[BERLAKUSD]</td></tr>
		<tr><td>No. Surat Sponsor</td >     <td > : $r[NO_SPONSOR]</tr>
		<tr><td colspan=3 align=right>
        <input type=button value=Kembali onclick=self.history.back()></td></tr>
        </table></form>";



    case "lihat_id_card":

        if (!empty($_GET['stat'])) {
            if ($_GET['stat']=='1') {
                $status = "SUDAH";
                $tanggal = ", TGL_PENGEMBALIAN='".date('Y-m-d')."'";
            } else {
                $status = "BELUM";
                $tanggal = ", TGL_PENGEMBALIAN = NULL";
            }

            $sql = "update cetak_kartu_diplomat set STATUS_PENGEMBALIAN='".$status."' $tanggal where ID_CETAK='".$_GET[idd]."'";
            echo "<script>alert('Berhasil melakukan perubahan status Pengembalian Kartu Menjadi : $status.');</script>";
            mysql_query($sql);
        }

        $idt = $_GET[idt];
        $sql ="select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,FOTO_TTD, PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA,ID_RANK from diplomat where ID_DIPLOMAT = $idt";

        $input = mysql_query($sql);
        $r = mysql_fetch_array($input);
        $rangking = $r[ID_RANK];

        echo "<h2 >ID Card - Lihat</h2>";
        echo "	  <table width=100%>
        <tr><td  width=160>Kewarganegaraan</td>  <td > : ";
        $tampil = mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
        $w = mysql_fetch_array($tampil);

        $tampil28 = mysql_query("select * from cetak_kartu_diplomat where ID_DIPLOMAT = $idt");
        $get_dataidcard = mysql_num_rows($tampil28);

        if($get_dataidcard != 0) {
            $sql="select a.ID_CARD, a.COUNTER_CETAK, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idt)";

        } else {
            $sql="select a.ID_CARD, a.COUNTER_CETAK, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idt)";
        }

        $detil = mysql_query($sql);
        $det    = mysql_fetch_array($detil);
        $foto=$r[FOTO];
        $foto_ttd=$r[FOTO_TTD];

        $nomor_seri = $det[COUNTER_CETAK];

        echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto/$r[FOTO]\" width=110 height=150 border=1> <img src=\"../foto/ttd/$r[FOTO_TTD]\" width=110 height=40 border=1></div>
        <br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br> No. Seri : $nomor_seri<br><br>";

        $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");
        $det    = mysql_fetch_array($detil);

        echo "<b>Stay Permit </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No Izin Permit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";

        $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");
        $det    = mysql_fetch_array($detil);

        echo "<b>Sibling </b><br>";
        $nosib = 1;
        $detil=mysql_query("select  NM_SIBLING,NM_JNS_RELASI from v_sibling where ID_DIPLOMAT = $idt order by ID_JNS_RELASI");
            while($det=mysql_fetch_array($detil)) {
				echo "$nosib. $det[NM_SIBLING] - $det[NM_JNS_RELASI] <br>";
				$nosib=$nosib+1;
			}

        echo "
        </td>
		<tr><td>Nama Diplomat</td>     <td> : $r[NM_DIPLOMAT]</td></tr>
		<tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
		<tr><td>Jenis Kelamin</td>     <td> : ";
		if ($r[JK]=='l') {
            echo "Laki-laki";
        } else { 
            echo "Perempuan";
        }
		echo "</td> </tr>
		<tr><td>Pekerjaan</td >  <td > : $r[PEKERJAAN]</td></tr>
		<tr><td>Status Sipil</td>     <td  > : ";

		if ($r[ST_SIPIL]=='s') {
            echo "Belum Menikah";
        } else {
            echo "Sudah Menikah";
        }
		echo "</td></tr>
		<tr><td>Alamat Indonesia </td>     <td > : $r[ALAMATIN]</td></tr>
		<tr><td>Jenis / No. Paspor</td >     <td > :  ";
        
        $tampil = mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");
        $w = mysql_fetch_array($tampil);

        echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR]</td></tr>
		<tr><td>Diberikan oleh</td >     <td > : $r[PASPOR_OLEH]  -  $r[PASPOR_TGL] </td></tr>
		<tr><td>Berlaku s/d</td >     <td > : $r[AKHIR_BERLAKU]</td></tr>

		<tr><td>Jenis / No. Visa</td >     <td > : ";

        $tampil = mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA = $r[ID_JNS_VISA]");
        $w = mysql_fetch_array($tampil);

        echo " $w[NM_JNS_VISA] / $r[NO_VISA] </td></tr>
        </table> <br>";

        $tampil=mysql_query("select ID_PERMIT,ID_DIPLOMAT,ID_JNS_PERMIT,NO_AGENDA,date_format(TGL_AGENDA,'%d.%m.%Y') as  TGL_AGENDA,NO_IZIN_PERMIT,date_format(TGL_AWAL_PERMIT,'%d.%m.%Y') as TGL_AWAL_PERMIT,date_format(TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,KET ,NM_JNS_PERMIT,KD_JNS_PERMIT,NM_DIPLOMAT,ST_PERMIT,ST_PERMIT_K,ST_PERMIT_KAS from v_stay_permit where ID_DIPLOMAT = $idt and st_permit_k = 2 and st_permit_kas = 2 order by  TGL_AKHIR_PERMIT desc limit 0,1");

        $r = mysql_fetch_array($tampil);
        //jika konsul kehormatan tidak perlu ijin tinggal
        if ((($r[ST_PERMIT_K] == 2) and ($r[ST_PERMIT_KAS] == 2) or $rangking=='15')) { 

            $sql=("select ID_CETAK, ID_DIPLOMAT, ID_JNS_CETAK_KARTU, ID_CARD, TGL_AWAL_CARD, TGL_AKHIR_CARD, COUNTER_CETAK, NM_JNS_CETAK_KARTU, NM_DIPLOMAT, ST_KARTU, ST_KARTU_K, ST_KARTU_KAS, ID_PERMIT from v_id_card_w_permit where ID_DIPLOMAT = $idt and KD_WORKFLOW >= 1 order by  TGL_AKHIR_CARD desc limit 0,1 ");

            $tampil = mysql_query($sql);
            $r = mysql_fetch_array($tampil);
            if(($r[ST_KARTU] == 2) and ($r[ST_KARTU_K] == 2)) {
            ?>

            <div id="div_warna" style="display:none;">
            <!-- <div id="div_warna"> -->
            <input type=radio name="jns_id" value="1" ><font> <b>Tanpa Background</b> </font>
            <input type=radio name="jns_id" checked="checked" value="2" ><font> <b>Dengan Background</b> </font>
            </div>
            <script>
                $(document).ready(function() {
                    $('input:radio[name=jns_id]').change(function() {
                        if (this.value == '1') {
                            /* desain lama*/
                                // $('#form_id').attr('action', './report.php?go=card');
                                // $('#t1').attr('onclick', 'location.href=./report.php?go=card&idt=<?php echo $idt; ?>&warna=<?php echo $warna; ?>');
                                $('#form_id').attr('action', './report.php?go=card_barunobg');
                                $('#t1').attr('onclick', 'location.href=./report.php?go=card_barunobg&idt=<?php echo $idt; ?>&warna=<?php echo $warna; ?>');
                                $('#div_warna').show();
                        }
                        else if (this.value == '2') {
                            $('#form_id').attr('action', './report.php?go=card_baru');
                            $('#t1').attr('onclick', './location.href=./report.php?go=card_baru&idt=<?php echo $idt; ?>&warna=<?php echo $warna; ?>');
                            $('#div_warna').show();
                        }
                    });
                });
            </script>

            <form method=POST id="form_id" enctype="multipart/form-data" action="./report.php?go=card_baru">
                <div id="div_warna" style="display:none;">
                <input type=hidden name="idt" value="<?php echo $idt; ?>">
                <input type=radio name="warna" value="merah" checked><font color ="red"> <b>Merah</b> </font>
                <input type=radio name="warna" value="kuning" ><font color ="yellow"> <b>Kuning</b> </font>
                <input type=radio name="warna" value="hijau" ><font color ="Green"> <b>Hijau</b> </font>
                <input type=radio name="warna" value="biru" ><font color ="Blue"> <b>Biru</b> </font>
                <input type=radio name="warna" value="oranye" ><font color ="Orange"> <b>Oranye</b> </font>
                <input type=radio name="warna" value="putih" ><font color ="Black"> <b>Putih</b> </font>
                </div>
                <DIV id="tgl"> <script>DateInput('TGL_CETAK', true, 'YYYY-MM-DD')</script></div>
                <input type=radio name="opsi" checked="checked" value="A4" ><font> <b>A4</b> </font>
                <!-- <input type=radio name="opsi" value="kartu" ><font> <b>Kartu</b> </font> -->
                <input type=radio name="opsi" value="kartu_baru" ><font> <b>Kartu Cetakan Baru</b> </font>

                <?php if (!empty($foto) && !empty($foto_ttd)) { ?>
                    <input type="submit" id="t1" value="Cetak" onclick="location.href=./report.php?go=card&idt=<?php echo $idt; ?>&warna=<?php echo $warna; ?>" target="_blank">
                <?php } else { ?>
                    <input type=button value='Cetak' onclick="window.alert('Foto dan Tanda tangan tidak ada!, Cetak Kartu Gagal!');" target=\"_blank\">
                <?php } ?>
                <input type=button value='Tambah' onclick=location.href='?module=idcard&act=tambah_id_card&idt=<?php echo $idt; ?>&negara=<?php echo $_GET[negara];?>'>

            </form>
            <?php
            } else { ?>
                <input type=radio name="warna" value="merah" checked><font color ="red"> <b>Merah</b> </font>
                <input type=radio name="warna" value="kuning" ><font color ="yellow"> <b>Kuning</b> </font>
                <input type=radio name="warna" value="hijau" ><font color ="Green"> <b>Hijau</b> </font>
                <input type=radio name="warna" value="biru" ><font color ="Blue"> <b>Biru</b> </font>
                <input type=radio name="warna" value="oranye" ><font color ="Orange"> <b>Oranye</b> </font>
                <input type=radio name="warna" value="putih" ><font color ="Black"> <b>Putih</b> </font>

                <DIV id=\"tgl\"> <script>DateInput('TGL_CETAK', true, 'YYYY-MM-DD')</script></div>
                <input type=radio name='opsi' checked="checked" value="A4" ><font> <b>A4</b> </font>
                <!-- <input type=radio name='opsi' value="kartu" ><font> <b>Kartu</b> </font> -->
                <input type=radio name="opsi" value="kartu_baru" ><font> <b>Kartu Cetakan Baru</b> </font>

                <input type=submit value='Cetak' onClick="return alert('Cetak ID Card Gagal. Permit harus disetujui oleh DIREKTUR dan KASUBDIT')">
                <input type=button value='Tambah' onclick=location.href='?module=idcard&act=tambah_id_card&idt=<?php echo $idt; ?>&negara=<?php echo $_GET[negara];?>'>
            <?php
            }

            $noseri_sql = mysql_query("select ID_CETAK, COUNTER_CETAK from v_id_card_w_permit where ID_DIPLOMAT = $idt and KD_WORKFLOW>=1 order by ID_CETAK DESC LIMIT 1");
            $noseri = mysql_fetch_array($noseri_sql);
            $idc = $noseri[ID_CETAK];
            echo "
                <form method=POST action='./aksi_id_card.php?module=idcard&act=noseri&idt=$idt&idc=$idc&negara=$_GET[negara]'>
                <br/>
                Nomor Seri ID Card : <input type=text name='COUNTER_CETAK' size=20  value='$noseri[COUNTER_CETAK]'>&nbsp<input type=submit value='Update Nomor Seri'>
                </form>
            ";

            echo "
            <table width=100%>
            <tr><th  width=30>no</th><th>No Pendaftaran</th><th>Status</th><th>Alasan Cetak</th><th >ID Card</th><th width=70>Tanggal Awal</th><th width=70>Tanggal Akhir</th><th width=70>Status Pengembalian</th><!--<th width=70>Counter Cetak</th>--><th width=30>D</th><th width=30>K</th><th width=30>KAS</th><th width=60>AKSI</th></tr>";

            $p      = new Paging;
            $batas  = 200;
            $posisi = $p->cariPosisi($batas);

            $sql=("
            select ID_CETAK,ID_DIPLOMAT,ID_JNS_CETAK_KARTU,ID_CARD,TGL_AWAL_CARD,TGL_AKHIR_CARD,COUNTER_CETAK, NM_JNS_CETAK_KARTU,NM_DIPLOMAT,
            ST_KARTU,ST_KARTU_K,ST_KARTU_KAS,STATUS_PENGEMBALIAN, ID_PERMIT, NO_DAFTAR, STATUS_WORKFLOW  from  v_id_card_w_permit where ID_DIPLOMAT = $idt and KD_WORKFLOW>=1 order by  NO_DAFTAR ");
            $tampil = mysql_query($sql);

            $no = $posisi+1;
            while($r=mysql_fetch_array($tampil)) {
                if ($r['STATUS_PENGEMBALIAN']=='SUDAH') {
					$stat='2';
					$stat_txt = "SUDAH - PERPANJANGAN";
				} elseif ($r['STATUS_PENGEMBALIAN']=='SUDAH2') {
					$stat='2';
					$stat_txt = "SUDAH - SELESAI MASA TUGAS";
				} else {
					$stat='1';
					$stat_txt = "BELUM";
				}


                echo "<tr><td>$no</td>
                <td>$r[NO_DAFTAR]</td>
                <td>$r[STATUS_WORKFLOW]</td>
                <td>$r[NM_JNS_CETAK_KARTU]</td>
				<td>$r[ID_CARD]</td>
				<td>".date('d-m-Y' ,strtotime($r[TGL_AWAL_CARD]))."</td>
				<td>".date('d-m-Y' ,strtotime($r[TGL_AKHIR_CARD]))."</td>
				<td align='center'><b>$stat_txt</b></td>
				<!--<td align =center>$r[COUNTER_CETAK]</td>-->
                <td align =center>";

                if ($r[ST_KARTU] == 2) {
                    echo "<div style=\"color : green\"> <b>A</b> </div>";
                } elseif ($r[ST_KARTU] == 1) {
                    echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
                } elseif ($r[ST_KARTU] == 0) {
                    echo "<div style=\"color : #800000\"> <b>R</b> </div>";
                }

                echo "</td><td align =center>";

                if ($r[ST_KARTU_K] == 2) {
                    echo "<div style=\"color : green\"> <b>A</b> </div>";
                } elseif ($r[ST_KARTU_K] == 1) {
                    echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
                } elseif ($r[ST_KARTU_K] == 0) {
                    echo "<div style=\"color : #800000\"> <b>R</b> </div>";
                }
                
                echo "</td><td align =center>";

                if ($r[ST_KARTU_KAS] == 2) {
                    echo "<div style=\"color : green\"> <b>A</b> </div>";
                } elseif ($r[ST_KARTU_KAS] == 1) {
                    echo "<div style=\"color : #B1BF19\"> <b>W</b> </div>";
                } elseif ($r[ST_KARTU_KAS] == 0) {
                    echo "<div style=\"color : #800000\"> <b>R</b> </div>";
                }

                echo "</td>
                <td align='center'><a href=?module=idcard&act=edit_id_card&idt=$r[ID_PERMIT]&idc=$r[ID_CETAK]&idd=$idt&negara=$_GET[negara]>Edit</a>
				<!--|<a href=./aksi_id_card.php?module=idcard&act=hapus&idt=$r[ID_PERMIT]&idc=$r[ID_CETAK]&idd=$idt&negara=$_GET[negara] onClick=\"return confirm('Apakah Anda benar-benar akan menghapus ID Card $r[ID_CETAK]?')\">Hapus</a>--></td>
				</tr>";

                $no++;
            }
            echo "</table>";

        }
        break;

    case "tambah_id_card":
        $idt = $_GET[idt];
        $sql = "select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idt";
        $input = mysql_query($sql);
        $r = mysql_fetch_array($input);

        echo "<h2 >ID Card - Tambah</h2>";
        echo "	  <table width=100%>
        <tr><td  width=160>Kewarganegaraan</td>  <td > : ";

        $tampil = mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
        $w = mysql_fetch_array($tampil);


        $detil = mysql_query("select a.ID_CARD, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idt and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idt)");
        $det = mysql_fetch_array($detil);

        echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto/$r[FOTO]\" width=110 height=150 border=1> </div>
        <br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br><br>";

        $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");
        $det = mysql_fetch_array($detil);

        echo "<b>Stay Permit </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No Izin Permit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";

        $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idt and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idt) ");
        $det = mysql_fetch_array($detil);

        echo "<b>Sibling </b><br>";
        $nosib = 1;
        $detil=mysql_query("select  NM_SIBLING,NM_JNS_RELASI from v_sibling where ID_DIPLOMAT = $idt order by ID_JNS_RELASI");
            while($det=mysql_fetch_array($detil)) {
				echo "$nosib. $det[NM_SIBLING] - $det[NM_JNS_RELASI] <br>";
				$nosib=$nosib+1;
			}

        echo "
        </td>
        <tr><td>Nama Diplomat</td>     <td> : $r[NM_DIPLOMAT]</td></tr>
        <tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
        <tr><td>Jenis Kelamin</td>     <td> : ";
        if ($r[JK]=='l') {
            echo "Laki-laki";
        } else {
            echo "Perempuan";
        }
        echo "</td> </tr>
        <tr><td>Pekerjaan</td >  <td > : $r[PEKERJAAN]</td></tr>
        <tr><td>Status Sipil</td>     <td  > : ";

        if ($r[ST_SIPIL]=='s') {
            echo "Belum Menikah";
        } else {
            echo "Sudah Menikah";
        }
        echo "</td></tr>
        <tr><td>Alamat Indonesia </td>     <td > : $r[ALAMATIN]</td></tr>

        <tr><td>Jenis / No. Paspor</td >     <td > :  ";
        $tampil = mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");
        $w = mysql_fetch_array($tampil);

        echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR]</td></tr>
        <tr><td>Diberikan oleh</td >     <td > : $r[PASPOR_OLEH]  -  $r[PASPOR_TGL] </td></tr>
        <tr><td>Berlaku s/d</td >     <td > : $r[AKHIR_BERLAKU]</td></tr>

        <tr><td>Jenis / No. Visa</td >     <td > : ";

        $tampil = mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA = $r[ID_JNS_VISA]");
        $w = mysql_fetch_array($tampil);

        echo " $w[NM_JNS_VISA] / $r[NO_VISA] </td></tr>
        </table> <br>";


        echo "<form method=POST enctype='multipart/form-data' action='./aksi_id_card.php?module=idcard&act=input&negara=$_GET[negara]'>
        <input type=hidden name=ID_DIPLOMAT value='$r[ID_DIPLOMAT]'>
        <table width=100%>
        <tr><td  width=120>Jenis Cetak Kartu</td>  <td > :
        <select name='ID_JNS_CETAK_KARTU'>
			<option value=0 selected>- Not Defined -</option>";
            $tampil=mysql_query("SELECT ID_JNS_CETAK_KARTU,NM_JNS_CETAK_KARTU FROM m_jns_cetak_kartu ORDER BY ID_JNS_CETAK_KARTU");
            while($w=mysql_fetch_array($tampil)) {
				echo "<option value=$w[ID_JNS_CETAK_KARTU]>$w[NM_JNS_CETAK_KARTU]</option>";

			}

        echo "</select></td>";
		$tampil = mysql_query("SELECT * FROM m_syarat where jenis_izin='3'");
        echo "<tr><td>Persyaratan</td>     <td> ";
        while ($data=mysql_fetch_array($tampil)) {
            echo "<input type=checkbox name='syarat[]' value='$data[syarat_kd]'> $data[syarat_nama] <br>";
        }
        echo "</td></tr>";

        echo"
        <tr><td>No ID Card</td>     <td> : <input type=text name='ID_CARD' size=50  ></td></tr>
		<tr><td>Tanggal Awal Card</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AWAL_CARD', true, 'YYYY-MM-DD')</script></div></td></tr>
		<tr><td>Tanggal Akhir Card</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR_CARD', true, 'YYYY-MM-DD')</script></div></td></tr>
		<!--<tr><td>Counter Cetak</td>     <td> : <input type=text name='COUNTER_CETAK' size=100  ></td></tr>-->
		<tr><td colspan=2 align=right><input type=submit value=Simpan>
              <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table></form>";
        break;

    case "edit_id_card":
        $idt = $_GET[idt];
        $idc = $_GET[idc];
        $idd = $_GET[idd];

        $input = mysql_query("select ID_DIPLOMAT,ID_NEGARA,ID_KNT_PERWAKILAN,ID_JNS_PASPOR,ID_JNS_VISA,NM_DIPLOMAT,TEMPAT_LAHIR,DATE_FORMAT(TGL_LAHIR,'%d %M %Y') AS TGL_LAHIR,JK,FOTO,PEKERJAAN,ALAMATLN,ST_SIPIL,NO_PASPOR,PASPOR_OLEH,DATE_FORMAT(PASPOR_TGL,'%d %M %Y') AS PASPOR_TGL,DATE_FORMAT(AKHIR_BERLAKU,'%d %M %Y') AS AKHIR_BERLAKU,NO_VISA,VISA_OLEH,LAMA_BERDIAM,DATE_FORMAT(TGL_TIBA,'%d %M %Y') AS TGL_TIBA,ALAMATIN,NO_SETKAB,DATE_FORMAT(BERLAKUSD,'%d-%M-%Y') AS BERLAKUSD,NO_SPONSOR,ST_VISA from diplomat where ID_DIPLOMAT = $idd  ");
        $r    = mysql_fetch_array($input);
        if (!empty($r[TGL_PENGEMBALIAN])) {
            $date_kembali = $r[TGL_PENGEMBALIAN];
        } else {
            $date_kembali='1900-01-01';
        }
        echo "<h2 >ID Card - Edit</h2>";
        echo "	  <table width=100%>
        <tr><td  width=160>Kewarganegaraan</td>  <td > : ";
        $tampil = mysql_query("SELECT ID_NEGARA,NEGARA  FROM m_negara where ID_NEGARA = $r[ID_NEGARA]");
        $w = mysql_fetch_array($tampil);

        $tampil29 = mysql_query("select * from cetak_kartu_diplomat where ID_DIPLOMAT = $idd");
        $get_dataidcard29 = mysql_num_rows($tampil29);

        if ($get_dataidcard29 != 0) {
            $detil = mysql_query("select a.ID_CARD, a.COUNTER_CETAK, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idd and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idd)");

        } else {
            $detil = mysql_query("select a.ID_CARD, a.COUNTER_CETAK, date_format(a.TGL_AWAL_CARD,'%d.%m.%Y') as TGL_AWAL_CARD,  date_format(a.TGL_AKHIR_CARD,'%d.%m.%Y') as TGL_AKHIR_CARD from cetak_kartu_diplomat a where a.ID_DIPLOMAT = $idd and a.TGL_AKHIR_CARD = (select max(b.TGL_AKHIR_CARD) from cetak_kartu_diplomat b where b.ID_DIPLOMAT = $idd)");
        }

        $det = mysql_fetch_array($detil);

		$noseri_sql = mysql_query("SELECT COUNTER_CETAK FROM cetak_kartu_diplomat WHERE ID_DIPLOMAT = $idd AND ID_CETAK = $idc");
		$noseri_data = mysql_fetch_array($noseri_sql);

        $nomor_seri = $noseri_data[COUNTER_CETAK];

        echo "$w[NEGARA] </td><td rowspan=\"11\"  width=200 ><div align=center><img src=\"../foto/$r[FOTO]\" width=110 height=150 border=1> </div>
        <br><b>ID Card </b><br>No ID Card : $det[ID_CARD] <br> Berlaku Awal : $det[TGL_AWAL_CARD]<br> Berlaku Akhir : $det[TGL_AKHIR_CARD]<br>No Seri : $nomor_seri<br><br>";

        $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idd and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idd) ");
        $det = mysql_fetch_array($detil);

        echo "<b>Stay Permit </b><br>Jenis Permit : $det[KD_JNS_PERMIT] <br>No Izin Permit : $det[NO_IZIN_PERMIT]<br> Berlaku s/d  : $det[TGL_AKHIR_PERMIT] <br><br>";

        $detil = mysql_query("select a.NO_IZIN_PERMIT, date_format(a.TGL_AKHIR_PERMIT,'%d.%m.%Y') as TGL_AKHIR_PERMIT,a.KD_JNS_PERMIT from v_stay_permit a where a.id_diplomat = $idd and a.tgl_akhir_permit = (select max(b.tgl_akhir_permit) from permit_diplomat b where b.id_diplomat = $idd) ");
        $det = mysql_fetch_array($detil);

        echo "<b>Sibling </b><br>";
        $nosib = 1;
        $detil = mysql_query("select  NM_SIBLING,NM_JNS_RELASI from v_sibling where ID_DIPLOMAT = $idd order by ID_JNS_RELASI");
            while($det=mysql_fetch_array($detil)) {
				echo "$nosib. $det[NM_SIBLING] - $det[NM_JNS_RELASI] <br>";
				$nosib = $nosib+1;
			}

        echo "
        </td>
        <tr><td>Nama Diplomat</td>     <td> : $r[NM_DIPLOMAT]</td></tr>
        <tr><td>Tempat/Tanggal Lahir</td>     <td> : $r[TEMPAT_LAHIR] / $r[TGL_LAHIR]</td></tr>
        <tr><td>Jenis Kelamin</td>     <td> : ";
        if ($r[JK]=='l') {
            echo "Laki-laki";
        } else {
            echo "Perempuan";
        }
        echo "</td> </tr>
        <tr><td>Pekerjaan</td >  <td > : $r[PEKERJAAN]</td></tr>
        <tr><td>Status Sipil</td>     <td  > : ";

        if ($r[ST_SIPIL]=='s') {
            echo "Sudah Menikah";
        } else {
            echo "Belum Menikah";
        }
        echo "</td></tr>
        <tr><td>Alamat Indonesia </td>     <td > : $r[ALAMATIN]</td></tr>

        <tr><td>Jenis / No. Paspor</td >     <td > :  ";
        $tampil = mysql_query("SELECT ID_JNS_PASPOR,JNS_PASPOR FROM m_jns_paspor where ID_JNS_PASPOR = $r[ID_JNS_PASPOR]");

        $w = mysql_fetch_array($tampil);
        echo " $w[JNS_PASPOR]  /  $r[NO_PASPOR]</td></tr>
        <tr><td>Diberikan oleh</td >     <td > : $r[PASPOR_OLEH]  -  $r[PASPOR_TGL] </td></tr>
        <tr><td>Berlaku s/d</td >     <td > : $r[AKHIR_BERLAKU]</td></tr>

        <tr><td>Jenis / No. Visa</td >     <td > : ";
        $tampil = mysql_query("SELECT ID_JNS_VISA,NM_JNS_VISA FROM m_jns_visa where ID_JNS_VISA = $r[ID_JNS_VISA]");
        $w = mysql_fetch_array($tampil);

        echo " $w[NM_JNS_VISA] / $r[NO_VISA] </td></tr>
        </table> <br>";


        $sql = ("select  ID_CETAK,ID_DIPLOMAT,ID_JNS_CETAK_KARTU,ID_CARD,TGL_AWAL_CARD,TGL_AMBIL_BERKAS,TGL_AKHIR_CARD,COUNTER_CETAK,STATUS_PENGEMBALIAN,
        KETERANGAN, NO_DAFTAR, NM_KNT_PERWAKILAN, ID_KNT_PERWAKILAN, ID_ROOT_KANTOR from v_id_card_w_permit where ID_CETAK = $idc ");
        $edit = mysql_query($sql);
        $r = mysql_fetch_array($edit);

        echo "<form method=POST enctype='multipart/form-data' action='./aksi_id_card.php?module=idcard&act=update&idt=$idt&idc=$idc&negara=$_GET[negara]'>
        <input type=hidden name=ID_DIPLOMAT value='$r[ID_DIPLOMAT]'>
        <input type=hidden name=ID_CETAK value='$r[ID_CETAK]'>

        <table width=100%>";

        echo"<tr><td>Kedutaan/Perwakilan </br>(hanya tercetak di ID Card)</td > <td>  : <select name='ID_KNT_PERWAKILAN' required>";
        $tampil = mysql_query("SELECT ID_KNT_PERWAKILAN,NM_KNT_PERWAKILAN  FROM m_kantor_perwakilan where ID_KNT_PERWAKILAN > 1 and NM_KNT_PERWAKILAN != '-' and ID_KNT_PERWAKILAN != '196' and ID_KNT_PERWAKILAN != '193' ORDER BY NM_KNT_PERWAKILAN");
        echo "<option value='' selected>-</option>";

        while ($w = mysql_fetch_array($tampil)) {
            if ($r[ID_ROOT_KANTOR] == $w[ID_KNT_PERWAKILAN]) {
                echo "<option value = $w[ID_KNT_PERWAKILAN] selected> $w[NM_KNT_PERWAKILAN] </option>";
            } elseif (empty($r[ID_ROOT_KANTOR]) && $r[ID_KNT_PERWAKILAN] == $w[ID_KNT_PERWAKILAN]){
                    echo "<option value = $w[ID_KNT_PERWAKILAN] selected> $w[NM_KNT_PERWAKILAN] *(Blm disimpan)</option>";
            } else {
                echo "<option value=$w[ID_KNT_PERWAKILAN]>$w[NM_KNT_PERWAKILAN]</option>";
            }
        }

        echo"<tr><td  width=120>Kantor</td>  <td > : $r[NM_KNT_PERWAKILAN]</td></tr>
        <tr><td  width=120>No Pendaftaran</td>  <td > : $r[NO_DAFTAR]</td></tr>
        <tr><td  width=160>Jenis Cetak Kartu</td>  <td > :
        <select name='ID_JNS_CETAK_KARTU'>
        <option value=0 selected>- Not Defined -</option>";

        $tampil = mysql_query("SELECT ID_JNS_CETAK_KARTU,NM_JNS_CETAK_KARTU FROM m_jns_cetak_kartu ORDER BY ID_JNS_CETAK_KARTU");

        while($w = mysql_fetch_array($tampil)) {
            if ($r[ID_JNS_CETAK_KARTU] == $w[ID_JNS_CETAK_KARTU]) {
                echo "<option value = $w[ID_JNS_CETAK_KARTU] selected>$w[NM_JNS_CETAK_KARTU]</option>";
            } else {
                echo "<option value = $w[ID_JNS_CETAK_KARTU]>$w[NM_JNS_CETAK_KARTU]</option>";
            }
        }

        echo "</select></td>";
        echo "<tr><td>Persyaratan</td>     <td> ";

        $tampil = mysql_query("SELECT * FROM syarat_permit a right join m_syarat b on  a.syarat_kd=b.syarat_kd where b.jenis_izin = '3' and a.id_permit='".$_GET['idt']."'");
        while ($data = mysql_fetch_array($tampil)) {
            if ($data['file'] !="") {
                //echo "<input type=checkbox disabled checked=checked name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <a target='_blank' href='/foto/syarat/$data[file]'>Lihat Berkas</a><br>";
            } else {
                //echo "<input type=checkbox disabled name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <br>";
            }
        }

        $tampil = mysql_query("SELECT * FROM syarat_permit a right join m_syarat b on  a.syarat_kd = b.syarat_kd where b.jenis_izin = '3' and a.id_permit = '".$_GET['idc']."'");

        while ($data = mysql_fetch_array($tampil)) {
            if ($data['file'] !=" ") {
                echo "<input type=checkbox disabled checked=checked name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <a target='_blank' href='/foto/syarat/$data[file]'>Lihat Berkas</a><br>";
            } else {
                echo "<input type=checkbox disabled name='syarat_old[]' value='$data[syarat_kd]'> $data[syarat_nama] <br>";
            }
        }

        echo "</td></tr>";
        if ($r['STATUS_PENGEMBALIAN'] == 'SUDAH') {
            $status = "SUDAH - PERPANJANGAN";
        } elseif ($r['STATUS_PENGEMBALIAN'] == 'SUDAH2') {
            $status = "SUDAH - SELESAI MASA TUGAS";
        } else {
            $status = "BELUM";
        }
        echo "<tr><td>No ID Card</td>     <td> : <input type=text name='ID_CARD' size=50  value='$r[ID_CARD]'  ></td></tr>
        <tr><td>Tanggal Awal Card</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AWAL_CARD', true, 'YYYY-MM-DD'";

        if($r[TGL_AWAL_CARD]) {
            echo ",'$r[TGL_AWAL_CARD]'"; 
        }
        echo ")</script></div></td></tr>
        <tr><td>Tanggal Akhir Card</td> <td> <DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR_CARD', true, 'YYYY-MM-DD'";

        if($r[TGL_AKHIR_CARD]) {
            echo ",'$r[TGL_AKHIR_CARD]'";
        }
        echo ")</script></div></td></tr>";

        echo "<tr><td>Status Pengembalian</td> <td>
            <select name='STATUS_PENGEMBALIAN'>
                <option value='".$status."' selected>".$status."</option>
                <option value='SUDAH'>SUDAH - PERPANJANGAN</option>
                <option value='SUDAH2'>SUDAH - SELESAI MASA TUGAS</option>
                <option value='BELUM'>BELUM</option>
            </select>
        </td>
        </tr>
        <tr><td>Tgl Pengembalian ID card Lama</td>
        <td><DIV id=\"tgl\"><script>DateInput('TGL_PENGEMBALIAN', true, 'YYYY-MM-DD','$date_kembali')</script></div></td></tr>
        <tr><td>Tanggal Ambil ID Card Baru</td> <td> <DIV id=\"tgl\">"; if (empty($r[TGL_AMBIL_BERKAS])) { echo "<script>DateInput('TGL_AMBIL_BERKAS', true, 'YYYY-MM-DD','".date("Y-m-d")."')</script>";} else { echo "<script>DateInput('TGL_AMBIL_BERKAS', true, 'YYYY-MM-DD','$r[TGL_AMBIL_BERKAS]')</script>"; } echo"</div> <strong><div style='font-size:15px;color:red;'>&nbsp;Perhatikan saat pengisian Tanggal Ambil ID Card ('Jangan Sampai Salah')</div></strong></td></tr>

        <!--<tr><td>Counter Cetak</td>     <td> : <input type=text name='COUNTER_CETAK' size=100  value= '$r[COUNTER_CETAK]' ></td></tr>-->
        ";
		$get_kdwf = mysql_query("select * from cetak_kartu_diplomat where ID_CETAK = $idc");
		$r6    = mysql_fetch_array($get_kdwf);
			if ($r6['KD_WORKFLOW'] >= 3)
			{
			$lolosver =  'CHECKED';
			}
			else if($r6['KD_WORKFLOW'] == 1)
			{
			$gagalver = 'CHECKED';
			}
		echo "
		<tr><td>Verifikasi</td>
		<td> : <input type=radio id='statusverifikasi' name='statusverifikasi' value=2 $lolosver> Lolos
		<input type=radio id='statusverifikasi' name='statusverifikasi' value=1 $gagalver> Tidak Lolos</td></tr>
		<tr><td>Keterangan </td>     <td > : <textarea name='keterangan' rows=2 cols=48
			 >$r6[KETERANGAN]</textarea></td></tr>
		<tr><td colspan=2 align=right><input type=submit value=Simpan>
              <input type=button value=Batal onclick=self.history.back()></td></tr>
        </table></form>";


        break;

    case "cari":
        $alf = $_GET[huruf];




        echo "<br><br><a style=\"font-size: 22pt;\">$alf</a>";
        echo "<h2>ID Card - Pilih Negara</h2>
        <table width=100%>
          <tr><th width=10 rowspan=2>no</th><th rowspan=2>Negara</th><th colspan=3>Fasilitas Diberikan oleh Indonesia</th><th colspan=3>Rantor Diberikan ke Indonesia</th></tr>
			<tr><th  width=80 >JENIS FASILITAS</th><th  width=80 >JML RANTOR KANTOR</th><th width=80 >JML RANTOR INDIVIDU</th> <th  width=80 >JENIS FASILITAS</th><th  width=80 >JML RANTOR KANTOR</th><th width=80 >JML RANTOR INDIVIDU</th></tr>
			 ";


        $p      = new Paging;
        $batas  = 200;
        $posisi = $p->cariPosisi($batas);

        if (isset($_GET[huruf])) {
            $tampil=mysql_query("select ID_NEGARA,NEGARA,BENDERA,JML_RANTOR_K,JML_RANTOR_I,NEG_RANTOR_K,NEG_RANTOR_I from v_resiprositas where (ID_NEGARA > 1) and NEGARA like '$alf%' order by NEGARA limit $posisi,$batas");
        } else {
            $tampil=mysql_query("select ID_NEGARA,NEGARA,BENDERA,JML_RANTOR_K,JML_RANTOR_I,NEG_RANTOR_K,NEG_RANTOR_I from v_resiprositas where ID_NEGARA > 1 order by NEGARA limit $posisi,$batas");
        }
        $no = $posisi+1;
        while ($r = mysql_fetch_array($tampil)) {

            echo "<tr><td>$no</td>
            <td><img src=\"../images/bendera/".$r[BENDERA]."\" class=\"thumbborder\" width=\"22\" height=\"15\" />
            &nbsp <a href=?module=idcard=$r[NEGARA]>$r[NEGARA] </a></td><td>";

            $tampilFas = mysql_query("select ID_JNS_FASILITAS from negara_jns_fas where ID_NEGARA = ".$r[ID_NEGARA]." and ST_FASILITAS_O = 1 order by ID_JNS_FASILITAS");

            while ($rFas = mysql_fetch_array($tampilFas)) {
                echo "$rFas[ID_JNS_FASILITAS], ";
            }

            echo "</td><td align=right> $r[JML_RANTOR_K] </td><td align=right> $r[JML_RANTOR_I]</td> <td>";

            $tampilFas = mysql_query("select ID_JNS_FASILITAS from negara_jns_fas where ID_NEGARA = ".$r[ID_NEGARA]." and ST_FASILITAS_K = 1 order by ID_JNS_FASILITAS");

            while ($rFas = mysql_fetch_array($tampilFas)) {
                echo "$rFas[ID_JNS_FASILITAS], ";
            }

            echo "</td>
            <td align=right> $r[NEG_RANTOR_K] </td><td align=right> $r[NEG_RANTOR_I]</td>
            </tr>";
            $no++;
        }
        echo "</table>";
        echo "Keterangan <br>";
        $tampilFas = mysql_query("select ID_JNS_FASILITAS,JNS_FASILITAS from m_jns_fasilitas order by ID_JNS_FASILITAS");

        while ($rFas = mysql_fetch_array($tampilFas)) {
            echo "$rFas[ID_JNS_FASILITAS] = $rFas[JNS_FASILITAS] <br>";
        }

        break;

}
?>
