<link href="../config/summernote/bootstrap.css" rel="stylesheet">
<link href="../config/summernote/summernote.css" rel="stylesheet">
<?php
function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);
        $output = '';
        $i      = 0;
        while (1) {
            $length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            }
            else {
                $output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    }
    else {
        $output = $text;
    }
    return $output;
}

switch($_GET[act]){
  // Tampil Berita
  default:
     $sql ="select * from tbl_pengumuman where pengumuman_status='1' order by pengumuman_id desc";
    $qry_pengumuman = mysql_query($sql);
    echo "<h2>PENGUMUMAN</h2>";
    if (mysql_num_rows($qry_pengumuman)==0){
      echo "<center>Belum ada Pengumuman</center>";
    } else {
      $i=0;
      while($data_pengumuman=mysql_fetch_array($qry_pengumuman)){
        $new_date = date('d M Y', strtotime($data_pengumuman['pengumuman_tanggal']));
        if ($i==2){
          echo "<br><br><div style='font-size:14px;margin-bottom:-20px;'><b><u>Pengumuman Lainnya</u></b></div>";
        }
        echo "<h2><A href='?module=pengumuman&act=detail&id=".$data_pengumuman['pengumuman_id']."'>".$data_pengumuman['pengumuman_judul']."</a></h2>";
        echo "<div style='margin-top:-12px; font-size:12px;'>".$new_date."</div><br>";
        if ($i<2){
          echo "<div style='text-align:justify; margin-right:25px; width:100%;'>".substrwords($data_pengumuman['pengumuman_konten'], 1000)."</div>";

        }
        $i++;
     }
   }
    echo "<br>";
 break;

   case "detail":
         $sql ="select * from tbl_pengumuman where pengumuman_status='1' and pengumuman_id=".$_GET['id']."";
        $qry_pengumuman = mysql_query($sql);
         $i=0;
        while($data_pengumuman=mysql_fetch_array($qry_pengumuman)){
           echo "<h2>".$data_pengumuman['pengumuman_judul']."</h2>
          <div style='margin-top:-12px; font-size:12px;'>".$data_pengumuman['pengumuman_tanggal']."</div>
          <div>".$data_pengumuman['pengumuman_konten']."</div>";
        }
          echo "<br>";
        break;

  case "tambah":
  // print_r($_SESSION);
   if ($_SESSION['G_leveluser']==14) {
          echo "<h2>Formulir Tambah Pengumuman</h2>";
          if (!empty($_POST['tambah_pengumuman'])) {
            if (!empty($_POST['pengumuman_judul']) AND !empty($_POST['pengumuman_konten'])){
              $konten = mysql_real_escape_string($_POST['pengumuman_konten']);
              $sql_insert_pengumuman = "
              INSERT
              INTO
              	tbl_pengumuman(
                pengumuman_judul,
              	pengumuman_konten,
              	pengumuman_tanggal,
              	pengumuman_status,
              	id_user)
              VALUES
              	(
              		'".$_POST['pengumuman_judul']."',
              		'".$konten."',
              		'".date('Y-m-d')."',
              		'1',
              		'".$_SESSION['G_iduser']."'
              	)";
                //echo $sql_insert_pengumuman; exit;
                $query_tambah_pengumuman = mysql_query($sql_insert_pengumuman);
                if (mysql_affected_rows() > 0){
                  echo '
                      <div class="alert alert-success" role="alert"><b>Penambahan Pengumuman Berhasil!</b><br> Anda telah berhasil menambah data pengumuman.</div>
                  ';
                } else {
                  echo '
                      <div class="alert alert-danger" role="alert"><b>Penambahan Pengumuman Gagal!</b><br> Silahkan coba beberapa saat lagi atau hubungi administrator.</div>
                  ';

                }
            } else {
              echo '
                  <div class="alert alert-danger" role="alert"><b>Penambahan Pengumuman Gagal!</b><br> Isian tidak boleh kosong.</div>
              ';
            }
          }
          else {
          }
          echo "
          <form method='POST' action='?module=pengumuman&act=tambah'>
          <table width=100%>
          <tr>
            <td  width=120>Judul *</td>
            <td > <input type='text' size='70' name='pengumuman_judul' required></td>
          </tr>
          <tr>
            <td  width=120>Isi Pengumuman *</td>
            <td > <textarea id='summernote' required name='pengumuman_konten'></textarea></td>
          </tr>
          <tr>
          <td></td>
          <td><input type='submit' name='tambah_pengumuman' value='Simpan'></td>
          </tr>
        		 </table>
        </form>";
    } else {
      echo "<br>Anda tidak memiliki akses.<br>";
    }
     break;
    case "list":
     $sql ="SELECT
              	pengumuman_id,
              	pengumuman_judul,
              	CASE
              		WHEN pengumuman_status = 1
              		THEN 'Aktif'
              		WHEN pengumuman_status = 0
              		THEN 'Tidak Aktif'
              	END AS status,
              	pengumuman_tanggal
              FROM
              	tbl_pengumuman
              ORDER BY
              	pengumuman_id DESC";
     $qry_pengumuman = mysql_query($sql);
     echo "<h1>List Pengumuman</h1><hr>";
     echo "<table width='100%'>
          <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
            </tr>";
     $i=0;
     while($data_pengumuman=mysql_fetch_array($qry_pengumuman)){ $i++;
       $new_date = date('d M Y', strtotime($data_pengumuman['pengumuman_tanggal']));
       echo "<tr>
               <td>$i</td>
               <td>".$data_pengumuman['pengumuman_judul']."</td>
               <td>".$new_date."</td>
               <td>".$data_pengumuman['status']."</td>
               <td><a href='?module=pengumuman&act=edit&id=".$data_pengumuman['pengumuman_id']."'>edit</a></td>
             </tr>";
     }
     echo "</table>";
     break;


    case "edit":
     // print_r($data_pengumuman); exit;
       if ($_SESSION['G_leveluser']==14) {
             echo "<h2>Formulir Edit Pengumuman</h2>";
             if (!empty($_POST['edit_pengumuman'])) {
               if (!empty($_POST['pengumuman_judul']) AND !empty($_POST['pengumuman_konten'])){
                 $konten = mysql_real_escape_string($_POST['pengumuman_konten']);
                 $sql_update_pengumuman = "
                 UPDATE
                  tbl_pengumuman SET
                   pengumuman_judul = '".$_POST['pengumuman_judul']."',
                  pengumuman_konten = '".$konten."',
                  pengumuman_tanggal = '".date('Y-m-d')."',
                  pengumuman_status = '".$_POST['pengumuman_status']."',
                  id_user = '".$_SESSION['G_iduser']."'
                   WHERE pengumuman_id='".$_POST['pengumuman_id']."'";
                   // echo $sql_update_pengumuman; exit;
                   $query_edit_pengumuman = mysql_query($sql_update_pengumuman);
                   if (mysql_affected_rows() > 0){
                     echo '
                         <div class="alert alert-success" role="alert"><b>Perubahan Pengumuman Berhasil!</b><br> Anda telah berhasil mengubah data pengumuman.</div>
                     ';
                   } else {
                     echo '
                         <div class="alert alert-danger" role="alert"><b>Perubahan Pengumuman Gagal!</b><br> Silahkan coba beberapa saat lagi atau hubungi administrator.</div>
                     ';

                   }
               } else {
                 echo '
                     <div class="alert alert-danger" role="alert"><b>Perubahan Pengumuman Gagal!</b><br> Isian tidak boleh kosong.</div>
                 ';
               }
             }
             else {
             }
             $sql ="select *, CASE
               WHEN pengumuman_status = 1
               THEN 'Aktif'
               WHEN pengumuman_status = 0
               THEN 'Tidak Aktif'
             END AS status from tbl_pengumuman where pengumuman_id=".$_GET['id']."";
             $qry_pengumuman = mysql_query($sql);
             $data_pengumuman=mysql_fetch_array($qry_pengumuman);

             echo "
             <form method='POST' action='?module=pengumuman&act=edit&id=".$_GET['id']."'>
             <table width=100%>
             <tr>
               <td  width=120>Judul *</td>
               <td >
               <input type='hidden' name='pengumuman_id' value='".$_GET['id']."'>
                <input type='text' size='70' name='pengumuman_judul' value='".$data_pengumuman['pengumuman_judul']."' required></td>
             </tr>
             <tr>
               <td  width=120>Isi Pengumuman *</td>
               <td > <textarea id='summernote' required name='pengumuman_konten'>".$data_pengumuman['pengumuman_konten']."</textarea></td>
             </tr>
             <tr>
               <td  width=120>Status</td>
               <td >
                <select name='pengumuman_status'>
                <option value='".$data_pengumuman['pengumuman_status']."' selected>".$data_pengumuman['status']."</option>
                <option value='1'>Aktif</option>
                <option value='0'>Tidak Aktif</option>
                </select>
               </td>
             </tr>
             <tr>
             <td></td>
             <td><input type='submit' name='edit_pengumuman' value='Simpan'></td>
             </tr>
               </table>
           </form>";
       } else {
         echo "<br>Anda tidak memiliki akses.<br>";
       }
        break;
 }
?>
<script src="../config/summernote/bootstrap.min.js"></script>
<script src="../config/summernote/summernote.js"></script>
<script>
$(document).ready(function () {
  $('#summernote').summernote();
});
</script>
