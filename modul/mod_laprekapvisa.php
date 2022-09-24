<?php

switch($_GET[act]){

  default:

  echo "<h2>Laporan Rekapitulasi Visa</h2> 
    <form method=POST action='./deplu.php?module=laprekapvisa&act=generate' enctype='multipart/form-data'>
          <table width=80%>
          
		  <tr ><th colspan = 2 ><div align=left>Periode</div></th></tr>
		  <tr><td>Dari</td><td><DIV id=\"tgl\"> <script>DateInput('TGL_AWAL', true, 'YYYY-MM-DD')</script></div></td></tr>
		  <tr><td>Sampai Dengan</td><td><DIV id=\"tgl\"> <script>DateInput('TGL_AKHIR', true, 'YYYY-MM-DD')</script></div></td></tr>
                  <tr><td>Status</td><td>
                      <select required name='sts_keputusan' id='sts_keputusan'>
								<option value=''>- Silahkan Pilih -</option>";
								$sql_status="select * from tbl_ref_status";
								$tampil_status=mysql_query($sql_status);
								 while($val3=mysql_fetch_array($tampil_status))
								 {
									//print_r($val3);
									echo "<option value='$val3[id]'
									";
									if($r[status_permohonan] == $val3[id])
									{
										echo 'selected';
									}
									echo">$val3[status]</option>";
								 }
							echo"></select>
                  </td></tr>
		  
		  <tr><th colspan = 2><div align=right><input type=submit value=Generate> </div></th></tr>
		

		  </table></form>";



	break;
    case "generate":

session_start();

//session_register("G_sql_lap");

$template = file("../template/canvasawal.htm");
$template = implode("",$template ); 

if (empty($_SESSION[G_iduser]) AND empty($_SESSION[G_namauser])){

	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";
	
	$template = eregi_replace("{isi}",$varname,$template);
	echo $template;

}else{

		
		$ID_NEGARA = $_POST[ID_NEGARA];   
		$ID_JNS_PERMIT = $_POST[ID_JNS_PERMIT]; 
	
		$TGL_AWAL = $_POST[TGL_AWAL]; 
		$TGL_AKHIR = $_POST[TGL_AKHIR]; 
                $status_keputusan = $_POST[sts_keputusan]; 
		//print_r('ini.... '.$status_keputusan);die;
		?>
		<div align=center>

                <h2>LAPORAN REKAPITULASI PENGAJUAN VISA NON SIBLING - PER INDEKS VISA</h2>
                <table width=700 >
                    <?php 
                        $sql_status_keputusan = "select * from tbl_ref_status where id = $status_keputusan";
                        $status_keputusan1 = mysql_query($sql_status_keputusan);
                        $oo = mysql_fetch_array($status_keputusan1);
                    ?>

                    <tr>
                        <th><?=$TGL_AWAL?> S/D <?=$TGL_AKHIR?>, <?=$oo['status']?></th>
                        <th>10-1</th>
                        <th>10-2</th>
                        <th>10-3</th>
                        <th>10-4</th>
                        <th>10-5</th>
                        <th>20-1</th>
                        <th>20-2</th>
                        <th>20-3</th>
                        <th>20-4</th>
                        <th>20-5</th>
                        <th>MULTIPLE</th>
                        <th width=100>TOTAL </th>
                    </tr>
                    <?php
                        $AAA = 0;
                        $AAB = 0;
                        $AAC = 0;
                        $AAD = 0;
                        $AAE = 0;
                        $ABA = 0;
                        $ABB = 0;
                        $ABC = 0;
                        $ABD = 0;
                        $ABE = 0;
                        $AMM = 0;

                        $sql = "SELECT kode_agenda, deskripsi FROM m_kode_agenda order by kode_agenda";
                        $tampil = mysql_query($sql);
                        while($r = mysql_fetch_array($tampil)) {
                            $totalA = 0; ?>

                            <tr>
                                <td><?=$r['deskripsi']?></td>
                                <td align=right>

                                <?php
                                    $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='2' and kode_agenda='".$r['kode_agenda']."' and status_permohonan='".$status_keputusan."'";
                            
                                    $tampil1 = mysql_query($sql1);
                                    $r1 = mysql_fetch_row($tampil1);
                                    
                                    echo $r1[0];
                                    $totalA = $totalA+$r1[0];
                                    $AAA = $AAA+$r1[0];
                            
                                ?>

                                </td>
                                <td  align=right>

                                <?php

                                    $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='3' and kode_agenda='".$r['kode_agenda']."' and status_permohonan='".$status_keputusan."'";
                        
                                    $tampil1 = mysql_query($sql1);
                                    $r1 = mysql_fetch_row($tampil1);
                                    
                                    echo $r1[0];
                                    $totalA = $totalA+$r1[0];
                                    $AAB = $AAB+$r1[0];
                                ?>

                                </td>
                                <td  align=right>

                                <?php

                                    $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id))
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='5' and kode_agenda='".$r['kode_agenda']."' and status_permohonan='".$status_keputusan."'";
                        
                                    $tampil1 = mysql_query($sql1);
                                    $r1 = mysql_fetch_row($tampil1);
                                    
                                    echo $r1[0];
                                    $totalA = $totalA+$r1[0];
                                    $AAC = $AAC+$r1[0];
                                ?>

                                </td>
                                <td  align=right>

                                <?php

                                    $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='4' and kode_agenda='".$r['kode_agenda']."' and status_permohonan='".$status_keputusan."'";
                        
                                    $tampil1 = mysql_query($sql1);
                                    $r1 = mysql_fetch_row($tampil1);
                                    
                                    echo $r1[0];
                                    $totalA = $totalA+$r1[0];
                                    $AAD = $AAD+$r1[0];
                                ?>

                                </td>
                                <td  align=right>

                                <?php

                                    $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='25' and kode_agenda='".$r['kode_agenda']."' and status_permohonan='".$status_keputusan."'";
                        
                                    $tampil1 = mysql_query($sql1);
                                    $r1 = mysql_fetch_row($tampil1);
                                    
                                    echo $r1[0];
                                    $totalA = $totalA+$r1[0];
                                    $AAE = $AAE+$r1[0];
                                ?>

                                </td>
                                <td align=right>

                                <?php
                                    $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='6' and kode_agenda='".$r['kode_agenda']."' and status_permohonan='".$status_keputusan."'";
                            
                                    $tampil1 = mysql_query($sql1);
                                    $r1 = mysql_fetch_row($tampil1);
                                    
                                    echo $r1[0];
                                    $totalA = $totalA+$r1[0];
                                    $ABA = $ABA+$r1[0];
                            
                                ?>

                                </td>
                                <td  align=right>

                                <?php

                                    $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='7' and kode_agenda='".$r['kode_agenda']."' and status_permohonan='".$status_keputusan."'";
                        
                                    $tampil1 = mysql_query($sql1);
                                    $r1 = mysql_fetch_row($tampil1);
                                    
                                    echo $r1[0];
                                    $totalA = $totalA+$r1[0];
                                    $ABB = $ABB+$r1[0];
                                ?>

                                </td>
                                <td  align=right>

                                <?php

                                    $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id))
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='8' and kode_agenda='".$r['kode_agenda']."' and status_permohonan='".$status_keputusan."'";
                        
                                    $tampil1 = mysql_query($sql1);
                                    $r1 = mysql_fetch_row($tampil1);
                                    
                                    echo $r1[0];
                                    $totalA = $totalA+$r1[0];
                                    $ABC = $ABC+$r1[0];
                                ?>

                                </td>
                                <td  align=right>

                                <?php

                                    $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='9' and kode_agenda='".$r['kode_agenda']."' and status_permohonan='".$status_keputusan."'";
                        
                                    $tampil1 = mysql_query($sql1);
                                    $r1 = mysql_fetch_row($tampil1);
                                    
                                    echo $r1[0];
                                    $totalA = $totalA+$r1[0];
                                    $ABD = $ABD+$r1[0];
                                ?>

                                </td>
                                <td  align=right>

                                <?php

                                    $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='10' and kode_agenda='".$r['kode_agenda']."' and status_permohonan='".$status_keputusan."'";
                        
                                    $tampil1 = mysql_query($sql1);
                                    $r1 = mysql_fetch_row($tampil1);
                                    
                                    echo $r1[0];
                                    $totalA = $totalA+$r1[0];
                                    $ABE = $ABE+$r1[0];
                                ?>

                                </td>
                                <td  align=right>

                                <?php

                                    $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='28' and kode_agenda='".$r['kode_agenda']."' and status_permohonan='".$status_keputusan."'";
                        
                                    $tampil1 = mysql_query($sql1);
                                    $r1 = mysql_fetch_row($tampil1);
                                    
                                    echo $r1[0];
                                    $totalA = $totalA+$r1[0];
                                    $AMM = $AMM+$r1[0];
                                ?>

                                </td>

                                <td align=right><?=$totalA?> </td>
                        
                            </tr>
                        <?php } ?>
                        <tr>
                        <td>LAINNYA</td>
                        <td align=right>

                            <?php
                            $totalA2 = 0;
                                $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                    FROM tbl_trans_otvis
                                    JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                    WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                    AND indeks_visa='2' and kode_agenda='' and status_permohonan='".$status_keputusan."'";
                        
                                $tampil1 = mysql_query($sql1);
                                $r1 = mysql_fetch_row($tampil1);
                                
                                echo $r1[0];
                                $totalA2 = $totalA2+$r1[0];
                                $AAA = $AAA+$r1[0];
                        
                            ?>

                        </td>
                        <td  align=right>

                            <?php

                            $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                FROM tbl_trans_otvis
                                JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                AND indeks_visa='3' and kode_agenda='' and status_permohonan='".$status_keputusan."'";
                
                            $tampil1 = mysql_query($sql1);
                            $r1 = mysql_fetch_row($tampil1);
                            
                            echo $r1[0];
                            $totalA2 = $totalA2+$r1[0];
                            $AAB = $AAB+$r1[0];
                            ?>

                        </td>
                        <td  align=right>

                            <?php

                            $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id))
                                FROM tbl_trans_otvis
                                JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                AND indeks_visa='5' and kode_agenda='' and status_permohonan='".$status_keputusan."'";
                
                            $tampil1 = mysql_query($sql1);
                            $r1 = mysql_fetch_row($tampil1);
                            
                            echo $r1[0];
                            $totalA2 = $totalA2+$r1[0];
                            $AAC = $AAC+$r1[0];
                            ?>

                        </td>
                        <td  align=right>

                            <?php

                            $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                FROM tbl_trans_otvis
                                JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                AND indeks_visa='4' and kode_agenda='' and status_permohonan='".$status_keputusan."'";
                
                            $tampil1 = mysql_query($sql1);
                            $r1 = mysql_fetch_row($tampil1);
                            
                            echo $r1[0];
                            $totalA2 = $totalA2+$r1[0];
                            $AAD = $AAD+$r1[0];
                            ?>

                        </td>
                        <td  align=right>

                            <?php

                            $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                FROM tbl_trans_otvis
                                JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                AND indeks_visa='25' and kode_agenda='' and status_permohonan='".$status_keputusan."'";
                
                            $tampil1 = mysql_query($sql1);
                            $r1 = mysql_fetch_row($tampil1);
                            
                            echo $r1[0];
                            $totalA2 = $totalA2+$r1[0];
                            $AAE = $AAE+$r1[0];
                            ?>

                        </td>
                        <td  align=right>

                            <?php

                            $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                FROM tbl_trans_otvis
                                JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                AND indeks_visa='6' and kode_agenda='' and status_permohonan='".$status_keputusan."'";
                
                            $tampil1 = mysql_query($sql1);
                            $r1 = mysql_fetch_row($tampil1);
                            
                            echo $r1[0];
                            $totalA2 = $totalA2+$r1[0];
                            $ABA = $ABA+$r1[0];
                            ?>

                        </td>
                        <td  align=right>

                            <?php

                            $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id))
                                FROM tbl_trans_otvis
                                JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                AND indeks_visa='7' and kode_agenda='' and status_permohonan='".$status_keputusan."'";
                
                            $tampil1 = mysql_query($sql1);
                            $r1 = mysql_fetch_row($tampil1);
                            
                            echo $r1[0];
                            $totalA2 = $totalA2+$r1[0];
                            $ABB = $ABB+$r1[0];
                            ?>

                        </td>
                        <td  align=right>

                            <?php

                            $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                FROM tbl_trans_otvis
                                JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                AND indeks_visa='8' and kode_agenda='' and status_permohonan='".$status_keputusan."'";
                
                            $tampil1 = mysql_query($sql1);
                            $r1 = mysql_fetch_row($tampil1);
                            
                            echo $r1[0];
                            $totalA2 = $totalA2+$r1[0];
                            $ABC = $ABC+$r1[0];
                            ?>

                        </td>
                        <td  align=right>

                            <?php

                            $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                FROM tbl_trans_otvis
                                JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                AND indeks_visa='9' and kode_agenda='' and status_permohonan='".$status_keputusan."'";
                
                            $tampil1 = mysql_query($sql1);
                            $r1 = mysql_fetch_row($tampil1);
                            
                            echo $r1[0];
                            $totalA2 = $totalA2+$r1[0];
                            $ABD = $ABD+$r1[0];
                            ?>

                        </td>
                        <td  align=right>

                            <?php

                            $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                FROM tbl_trans_otvis
                                JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                AND indeks_visa='10' and kode_agenda='' and status_permohonan='".$status_keputusan."'";
                
                            $tampil1 = mysql_query($sql1);
                            $r1 = mysql_fetch_row($tampil1);
                            
                            echo $r1[0];
                            $totalA2 = $totalA2+$r1[0];
                            $ABE = $ABE+$r1[0];
                            ?>

                        </td>
                        <td  align=right>

                            <?php

                            $sql1 = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                FROM tbl_trans_otvis
                                JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                AND indeks_visa='28' and kode_agenda='' and status_permohonan='".$status_keputusan."'";
                
                            $tampil1 = mysql_query($sql1);
                            $r1 = mysql_fetch_row($tampil1);
                            
                            echo $r1[0];
                            $totalA2 = $totalA2+$r1[0];
                            $AMM = $AMM+$r1[0];
                            ?>

                        </td>
                        <td align=right><?=$totalA2?> </td>
                
                    </tr>
                    <tr>
                        <td align=right>GRAND TOTAL</td>
                        <td align=right><?=$AAA?></td>
                        <td align=right><?=$AAB?></td>
                        <td align=right><?=$AAC?></td>
                        <td align=right><?=$AAD?></td>
                        <td align=right><?=$AAE?></td>
                        <td align=right><?=$ABA?></td>
                        <td align=right><?=$ABB?></td>
                        <td align=right><?=$ABC?></td>
                        <td align=right><?=$ABD?></td>
                        <td align=right><?=$ABE?></td>
                        <td align=right><?=$AMM?></td>
                        <td align=right style="color:red;"><strong><?=$AAA+$AAB+$AAC+$AAD+$AAE+$ABA+$ABB+$ABC+$ABD+$ABE+$AMM?></strong></td>
                    </tr>
                </table>

                <h2>BREAKDOWN REKAPITULASI PENGAJUAN VISA NON SIBLING - PER PERWAKILAN RI</h2>
                <table width=700 >
                    
                    <tr>
                        <th><?=$TGL_AWAL?> S/D <?=$TGL_AKHIR?>, <?=$oo['status']?></th>
                        <th>10-1</th>
                        <th>10-2</th>
                        <th>10-3</th>
                        <th>10-4</th>
                        <th>10-5</th>
                        <th>20-1</th>
                        <th>20-2</th>
                        <th>20-3</th>
                        <th>20-4</th>
                        <th>20-5</th>
                        <th>MULTIPLE</th>
                        <th width=100>TOTAL </th>
                    </tr>
                    <?php
                    
                        $GTBAA = 0; $GTBAB = 0; $GTBAC = 0; $GTBAD = 0; $GTBAE = 0;
                        $GTBBA = 0; $GTBBB = 0; $GTBBC = 0; $GTBBD = 0; $GTBBE = 0; $GTBMM = 0;
                        $totalB = 0; 

                        $sql = "SELECT id_perwakilan, perwakilan FROM tbl_perwakilan order by perwakilan";
                        $tampil = mysql_query($sql);
                        while($r = mysql_fetch_array($tampil)) {
                            $BAA = 0; $BAB = 0; $BAC = 0; $BAD = 0; $BAE = 0;
                            $BBA = 0; $BBB = 0; $BBC = 0; $BBD = 0; $BBE = 0; $BMM = 0; 
                            
                            $sqlBAA = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='2' AND pwk_ri='".$r['id_perwakilan']."' AND status_permohonan='".$status_keputusan."'";
                            
                            $tampilBAA = mysql_query($sqlBAA);
                            $rBAA = mysql_fetch_row($tampilBAA);                            
                            $BAA = $rBAA[0];

                            $sqlBAB = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='3' and pwk_ri='".$r['id_perwakilan']."' AND status_permohonan='".$status_keputusan."'";
                        
                            $tampilBAB = mysql_query($sqlBAB);
                            $rBAB = mysql_fetch_row($tampilBAB);
                            $BAB = $rBAB[0];

                            $sqlBAC = "SELECT count(DISTINCT(tbl_trans_otvis.id))
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='5' and pwk_ri='".$r['id_perwakilan']."' AND status_permohonan='".$status_keputusan."'";
                        
                            $tampilBAC = mysql_query($sqlBAC);
                            $rBAC = mysql_fetch_row($tampilBAC);
                            $BAC = $rBAC[0];

                            $sqlBAD = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='4' and pwk_ri='".$r['id_perwakilan']."' AND status_permohonan='".$status_keputusan."'";
                        
                            $tampilBAD = mysql_query($sqlBAD);
                            $rBAD = mysql_fetch_row($tampilBAD);
                            $BAD = $rBAD[0];

                            $sqlBAE = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='25' and pwk_ri='".$r['id_perwakilan']."' AND status_permohonan='".$status_keputusan."'";
                        
                            $tampilBAE = mysql_query($sqlBAE);
                            $rBAE = mysql_fetch_row($tampilBAE);
                            $BAE = $rBAE[0];

                            $sqlBBA = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='6' and pwk_ri='".$r['id_perwakilan']."' AND status_permohonan='".$status_keputusan."'";
                            
                            $tampilBBA = mysql_query($sqlBBA);
                            $rBBA = mysql_fetch_row($tampilBBA);
                            $BBA = $rBBA[0];

                            $sqlBBB = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='7' and pwk_ri='".$r['id_perwakilan']."' AND status_permohonan='".$status_keputusan."'";
                        
                            $tampilBBB = mysql_query($sqlBBB);
                            $rBBB = mysql_fetch_row($tampilBBB);
                            $BBB = $rBBB[0];

                            $sqlBBC = "SELECT count(DISTINCT(tbl_trans_otvis.id))
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='8' and pwk_ri='".$r['id_perwakilan']."' AND status_permohonan='".$status_keputusan."'";
                        
                            $tampilBBC = mysql_query($sqlBBC);
                            $rBBC = mysql_fetch_row($tampilBBC);
                            $BBC = $rBBC[0];

                            $sqlBBD = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='9' and pwk_ri='".$r['id_perwakilan']."' AND status_permohonan='".$status_keputusan."'";
                        
                            $tampilBBD = mysql_query($sqlBBD);
                            $rBBD = mysql_fetch_row($tampilBBD);
                            $BBD = $rBBD[0];

                            $sqlBBE = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='10' and pwk_ri='".$r['id_perwakilan']."' AND status_permohonan='".$status_keputusan."'";
                        
                            $tampilBBE = mysql_query($sqlBBE);
                            $rBBE = mysql_fetch_row($tampilBBE);
                            $BBE = $rBBE[0];

                            $sqlBMM = "SELECT count(DISTINCT(tbl_trans_otvis.id)) 
                                        FROM tbl_trans_otvis
                                        JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN=tbl_trans_otvis.kd_tempat_tugas
                                        WHERE posisi !='5' AND created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
                                        AND indeks_visa='28' and pwk_ri='".$r['id_perwakilan']."' AND status_permohonan='".$status_keputusan."'";
                        
                            $tampilBMM = mysql_query($sqlBMM);
                            $rBMM = mysql_fetch_row($tampilBMM);
                            $BMM = $rBMM[0];

                            $totalB = $BAA+$BAB+$BAC+$BAD+$BAE+$BBA+$BBB+$BBC+$BBD+$BBE+$BMM;
                            
                            if ($totalB > 0) { ?>

                                <tr>
                                    <td><?=$r['perwakilan']?></td>
                                    <td align=right<?= ($BAA>0) ? ' style="color:blue;"' : '' ; ?>><?= ($BAA>0) ? $BAA : '-' ; ?></td>
                                    <td align=right<?= ($BAB>0) ? ' style="color:blue;"' : '' ; ?>><?= ($BAB>0) ? $BAB : '-' ; ?></td>
                                    <td align=right<?= ($BAC>0) ? ' style="color:blue;"' : '' ; ?>><?= ($BAC>0) ? $BAC : '-' ; ?></td>
                                    <td align=right<?= ($BAD>0) ? ' style="color:blue;"' : '' ; ?>><?= ($BAD>0) ? $BAD : '-' ; ?></td>
                                    <td align=right<?= ($BAE>0) ? ' style="color:blue;"' : '' ; ?>><?= ($BAE>0) ? $BAE : '-' ; ?></td>
                                    <td align=right<?= ($BBA>0) ? ' style="color:blue;"' : '' ; ?>><?= ($BBA>0) ? $BBA : '-' ; ?></td>
                                    <td align=right<?= ($BBB>0) ? ' style="color:blue;"' : '' ; ?>><?= ($BBB>0) ? $BBB : '-' ; ?></td>
                                    <td align=right<?= ($BBC>0) ? ' style="color:blue;"' : '' ; ?>><?= ($BBC>0) ? $BBC : '-' ; ?></td>
                                    <td align=right<?= ($BBD>0) ? ' style="color:blue;"' : '' ; ?>><?= ($BBD>0) ? $BBD : '-' ; ?></td>
                                    <td align=right<?= ($BBE>0) ? ' style="color:blue;"' : '' ; ?>><?= ($BBE>0) ? $BBE : '-' ; ?></td>
                                    <td align=right<?= ($BMM>0) ? ' style="color:blue;"' : '' ; ?>><?= ($BMM>0) ? $BMM : '-' ; ?></td>
                                    <td align=right style="color:red;"><?=$totalB?> </td>
                            
                                </tr>
                            
                            <?php } 

                            $GTBAA = $GTBAA+$BAA;
                            $GTBAB = $GTBAB+$BAB;
                            $GTBAC = $GTBAC+$BAC;
                            $GTBAD = $GTBAD+$BAD;
                            $GTBAE = $GTBAE+$BAE;
                            $GTBBA = $GTBBA+$BBA;
                            $GTBBB = $GTBBB+$BBB;
                            $GTBBC = $GTBBC+$BBC;
                            $GTBBD = $GTBBD+$BBD;
                            $GTBBE = $GTBBE+$BBE;
                            $GTBMM = $GTBMM+$BMM;


                        } ?>
                    <tr>
                        <td align=right>GRAND TOTAL</td>
                        <td align=right<?= ($GTBAA>0) ? ' style="color:red;"' : '' ; ?>><?= ($GTBAA>0) ? $GTBAA : '-' ; ?></td>
                        <td align=right<?= ($GTBAB>0) ? ' style="color:red;"' : '' ; ?>><?= ($GTBAB>0) ? $GTBAB : '-' ; ?></td>
                        <td align=right<?= ($GTBAC>0) ? ' style="color:red;"' : '' ; ?>><?= ($GTBAC>0) ? $GTBAC : '-' ; ?></td>
                        <td align=right<?= ($GTBAD>0) ? ' style="color:red;"' : '' ; ?>><?= ($GTBAD>0) ? $GTBAD : '-' ; ?></td>
                        <td align=right<?= ($GTBAE>0) ? ' style="color:red;"' : '' ; ?>><?= ($GTBAE>0) ? $GTBAE : '-' ; ?></td>
                        <td align=right<?= ($GTBBA>0) ? ' style="color:red;"' : '' ; ?>><?= ($GTBBA>0) ? $GTBBA : '-' ; ?></td>
                        <td align=right<?= ($GTBBB>0) ? ' style="color:red;"' : '' ; ?>><?= ($GTBBB>0) ? $GTBBB : '-' ; ?></td>
                        <td align=right<?= ($GTBBC>0) ? ' style="color:red;"' : '' ; ?>><?= ($GTBBC>0) ? $GTBBC : '-' ; ?></td>
                        <td align=right<?= ($GTBBD>0) ? ' style="color:red;"' : '' ; ?>><?= ($GTBBD>0) ? $GTBBD : '-' ; ?></td>
                        <td align=right<?= ($GTBBE>0) ? ' style="color:red;"' : '' ; ?>><?= ($GTBBE>0) ? $GTBBE : '-' ; ?></td>
                        <td align=right<?= ($GTBMM>0) ? ' style="color:red;"' : '' ; ?>><?= ($GTBMM>0) ? $GTBMM : '-' ; ?></td>
                        <td align=right style="color:red;"><strong><?=$GTBAA+$GTBAB+$GTBAC+$GTBAD+$GTBAE+$GTBBA+$GTBBB+$GTBBC+$GTBBD+$GTBBE+$GTBMM?></strong></td>
                    </tr>
                </table>
                
			<h2>LAPORAN REKAPITULASI PENGAJUAN VISA SIBLING</h2>
			<table width=700 >
                             <?php 
                            $sql_status_keputusan = "select * from tbl_ref_status where id=$status_keputusan";
                            $status_keputusan1 = mysql_query($sql_status_keputusan);
                            $oo=mysql_fetch_array($status_keputusan1);
                            ?>
				<tr>
					<th><?=$TGL_AWAL?> S/D <?=$TGL_AKHIR?>, <?=$oo['status']?></th>
					<th >SUAMI</th>
					<th>ISTRI</th>
					<th>ANAK</th>
					<th>SAUDARA</th>
                                        <th>ORANG TUA</th>
					<th width=100>TOTAL </th>
					
				</tr>
				<?php
				$DD = 0;
				$DS = 0;
				$SD = 0;
				$SS = 0;
                                $ST = 0;
				$sql = "SELECT kode_agenda, deskripsi FROM m_kode_agenda order by kode_agenda";
				$tampil = mysql_query($sql);
				while($r=mysql_fetch_array($tampil)){
				$total = 0;
				?>
				<tr>
					<td><?=$r['deskripsi']?></td>
					<td align=right>
						<?php
//						$sql1 = "SELECT count(*) FROM permit_diplomat
//								JOIN diplomat ON diplomat.ID_DIPLOMAT = permit_diplomat.ID_DIPLOMAT
//								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.`ID_KNT_PERWAKILAN` = diplomat.`ID_KNT_PERWAKILAN`
//								WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."' 
//								AND jns_izin_permit='D' and kode_agenda='".$r['kode_agenda']."'";                                              
                                                
                                                          $sql1 = "SELECT count(DISTINCT(tbl_anggota_fam.id)) FROM tbl_anggota_fam
								JOIN tbl_trans_otvis ON tbl_trans_otvis.id_otvis = tbl_anggota_fam.id_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE tbl_trans_otvis.created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								and tbl_anggota_fam.relasi='1' AND kode_agenda='".$r['kode_agenda']."' and tbl_anggota_fam.status_permohonan='".$status_keputusan."'";
					
						$tampil1 = mysql_query($sql1);
						$r1 = mysql_fetch_row($tampil1);
						
						echo $r1[0];
						$total = $total+$r1[0];
						$DD = $DD+$r1[0];
						
						?>
					</td>
					<td  align=right>
						<?php
//						$sql1 = "SELECT count(*) FROM permit_diplomat
//								JOIN diplomat ON diplomat.ID_DIPLOMAT = permit_diplomat.ID_DIPLOMAT
//								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.`ID_KNT_PERWAKILAN` = diplomat.`ID_KNT_PERWAKILAN`
//								WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."' 
//								AND jns_izin_permit='S' and kode_agenda='".$r['kode_agenda']."'";
                                                 $sql1 = "SELECT count(DISTINCT(tbl_anggota_fam.id)) FROM tbl_anggota_fam
								JOIN tbl_trans_otvis ON tbl_trans_otvis.id_otvis = tbl_anggota_fam.id_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE tbl_trans_otvis.created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								and tbl_anggota_fam.relasi='2' AND kode_agenda='".$r['kode_agenda']."' and tbl_anggota_fam.status_permohonan='".$status_keputusan."'";
					
						$tampil1 = mysql_query($sql1);
						$r1 = mysql_fetch_row($tampil1);
						
						echo $r1[0];
						$total = $total+$r1[0];
						$DS = $DS+$r1[0];
						?>
					</td>
					<td  align=right>
						<?php
//						$sql1 = "SELECT count(*) FROM permit_sibling
//								JOIN sibling ON sibling.ID_SIBLING = permit_sibling.ID_SIBLING
//								JOIN diplomat ON diplomat.ID_DIPLOMAT = sibling.ID_DIPLOMAT
//								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.`ID_KNT_PERWAKILAN` = diplomat.`ID_KNT_PERWAKILAN`
//								WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."' 
//								AND jns_izin_permit='D' and kode_agenda='".$r['kode_agenda']."'";
                                                $sql1 = "SELECT count(DISTINCT(tbl_anggota_fam.id)) FROM tbl_anggota_fam
								JOIN tbl_trans_otvis ON tbl_trans_otvis.id_otvis = tbl_anggota_fam.id_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE tbl_trans_otvis.created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								and tbl_anggota_fam.relasi='3' AND kode_agenda='".$r['kode_agenda']."' and tbl_anggota_fam.status_permohonan='".$status_keputusan."'";
					
						$tampil1 = mysql_query($sql1);
						$r1 = mysql_fetch_row($tampil1);
						
						echo $r1[0];
						$total = $total+$r1[0];
						$SD = $SD+$r1[0];
						?>
					</td>
					<td  align=right>
						<?php
//						$sql1 = "SELECT count(*) FROM permit_sibling
//								JOIN sibling ON sibling.ID_SIBLING = permit_sibling.ID_SIBLING
//								JOIN diplomat ON diplomat.ID_DIPLOMAT = sibling.ID_DIPLOMAT
//								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.`ID_KNT_PERWAKILAN` = diplomat.`ID_KNT_PERWAKILAN`
//								WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."' 
//								AND jns_izin_permit='S' and kode_agenda='".$r['kode_agenda']."'";
                                                 $sql1 = "SELECT count(DISTINCT(tbl_anggota_fam.id)) FROM tbl_anggota_fam
								JOIN tbl_trans_otvis ON tbl_trans_otvis.id_otvis = tbl_anggota_fam.id_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE tbl_trans_otvis.created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								and tbl_anggota_fam.relasi='4' AND kode_agenda='".$r['kode_agenda']."' and tbl_anggota_fam.status_permohonan='".$status_keputusan."'";
					
						$tampil1 = mysql_query($sql1);
						$r1 = mysql_fetch_row($tampil1);
						
						echo $r1[0];
						$total = $total+$r1[0];
						$SS = $SS+$r1[0];
						?>
					</td>
                                        <td  align=right>
						<?php
//						$sql1 = "SELECT count(*) FROM permit_sibling
//								JOIN sibling ON sibling.ID_SIBLING = permit_sibling.ID_SIBLING
//								JOIN diplomat ON diplomat.ID_DIPLOMAT = sibling.ID_DIPLOMAT
//								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.`ID_KNT_PERWAKILAN` = diplomat.`ID_KNT_PERWAKILAN`
//								WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."' 
//								AND jns_izin_permit='S' and kode_agenda='".$r['kode_agenda']."'";
                                                 $sql1 = "SELECT count(DISTINCT(tbl_anggota_fam.id)) FROM tbl_anggota_fam
								JOIN tbl_trans_otvis ON tbl_trans_otvis.id_otvis = tbl_anggota_fam.id_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE tbl_trans_otvis.created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								and tbl_anggota_fam.relasi='5' AND kode_agenda='".$r['kode_agenda']."' and tbl_anggota_fam.status_permohonan='".$status_keputusan."'";
					
						$tampil1 = mysql_query($sql1);
						$r1 = mysql_fetch_row($tampil1);
						
						echo $r1[0];
						$total = $total+$r1[0];
						$ST = $ST+$r1[0];
						?>
					</td>
					<td align=right><?=$total?> </td>
					
				</tr>
				<?php
				}
				?>
				<tr>
					<td align=right>GRAND TOTAL</td>
					<td align=right><?=$DD?></td>
					<td align=right><?=$DS?></td>
					<td align=right><?=$SD?></td>
					<td align=right><?=$SS?></td>
                                        <td align=right><?=$ST?></td>
					<td align=right style="color:red;"><strong><?=$DD+$DS+$SD+$SS+$ST?></strong></td>
				</tr>
			</table>
                        
			<h2>BREAK DOWN REKAPITULASI PENGAJUAN VISA NON SIBLING</h2>
			<table width=700>
				<tr>
					<th><?=$TGL_AWAL?> S/D <?=$TGL_AKHIR?>, <?=$oo['status']?></th>
					<th >BIASA</th>
					<th>DINAS</th>
					<th>DIPLOMATIK</th>
					<th>UNLP</th>
                                        <th>EULP</th>
					<th>KAWASAN</th>
					
				</tr>
				<?php
				$sql = "SELECT ID_JNS_PERWAKILAN, NM_JNS_PERWAKILAN FROM m_jns_perwakilan ORDER BY ket";
				$tampil = mysql_query($sql);
				while($r=mysql_fetch_array($tampil)){
				$ddsub = 0;
				$dssub = 0;
				$sdsub = 0;
				$sssub = 0;
                                $sosub = 0;
				?>
				<tr>
					<td colspan=100><strong><?=$r['NM_JNS_PERWAKILAN']?></strong></td>
				</tr>
				<?php
				$sql1 = "SELECT ID_KNT_PERWAKILAN, m_kode_agenda.`deskripsi`, m_kode_agenda.`kode_agenda`, NM_KNT_PERWAKILAN FROM m_kantor_perwakilan 
					JOIN m_kode_agenda ON m_kantor_perwakilan.`KODE_AGENDA` = m_kode_agenda.`kode_agenda`
					WHERE ID_JNS_PERWAKILAN = ".$r['ID_JNS_PERWAKILAN']."
					ORDER BY m_kode_agenda.`deskripsi`,  NM_KNT_PERWAKILAN";
				$tampil1 = mysql_query($sql1);
				while($r1=mysql_fetch_array($tampil1)){
				
//				$sqldd = "SELECT COUNT(*) FROM permit_diplomat 
//						JOIN diplomat ON permit_diplomat.`ID_DIPLOMAT` = diplomat.`ID_DIPLOMAT`
//						JOIN m_kantor_perwakilan ON diplomat.`ID_KNT_PERWAKILAN` = m_kantor_perwakilan.`ID_KNT_PERWAKILAN`
//						WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'
//						AND jns_izin_permit='D' AND m_kantor_perwakilan.`ID_KNT_PERWAKILAN`=".$r1['ID_KNT_PERWAKILAN'];
                                
                                $sqldd = "SELECT count(DISTINCT(tbl_trans_otvis.id)) FROM tbl_trans_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								AND jns_paspor='1' and m_kantor_perwakilan.ID_KNT_PERWAKILAN='".$r1['ID_KNT_PERWAKILAN']."' and status_permohonan='".$status_keputusan."'";

				$tampildd = mysql_query($sqldd);
				
				$rdd = mysql_fetch_row($tampildd);
				$dd = $rdd[0];
				
//				$sqlds = "SELECT COUNT(*) FROM permit_diplomat 
//						JOIN diplomat ON permit_diplomat.`ID_DIPLOMAT` = diplomat.`ID_DIPLOMAT`
//						JOIN m_kantor_perwakilan ON diplomat.`ID_KNT_PERWAKILAN` = m_kantor_perwakilan.`ID_KNT_PERWAKILAN`
//						WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'
//						AND jns_izin_permit='S' AND m_kantor_perwakilan.`ID_KNT_PERWAKILAN`=".$r1['ID_KNT_PERWAKILAN'];
                                
                                 $sqlds = "SELECT count(DISTINCT(tbl_trans_otvis.id)) FROM tbl_trans_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								AND jns_paspor='2' and m_kantor_perwakilan.ID_KNT_PERWAKILAN='".$r1['ID_KNT_PERWAKILAN']."' and status_permohonan='".$status_keputusan."'";

				$tampilds = mysql_query($sqlds);
				
				$rds = mysql_fetch_row($tampilds);
				$ds = $rds[0];
				
//				$sqlsd = "SELECT COUNT(*) FROM permit_sibling 
//						JOIN sibling ON permit_sibling.`ID_SIBLING` = sibling.`ID_SIBLING`
//						JOIN diplomat ON sibling.`ID_DIPLOMAT` = diplomat.`ID_DIPLOMAT`
//						JOIN m_kantor_perwakilan ON diplomat.`ID_KNT_PERWAKILAN` = m_kantor_perwakilan.`ID_KNT_PERWAKILAN`
//						WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'
//						AND jns_izin_permit='D' AND m_kantor_perwakilan.`ID_KNT_PERWAKILAN`=".$r1['ID_KNT_PERWAKILAN'];
                                
                                $sqlsd = "SELECT count(DISTINCT(tbl_trans_otvis.id)) FROM tbl_trans_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								AND jns_paspor='3' and m_kantor_perwakilan.ID_KNT_PERWAKILAN='".$r1['ID_KNT_PERWAKILAN']."' and status_permohonan='".$status_keputusan."'";

				$tampilsd = mysql_query($sqlsd);
				
				$rsd = mysql_fetch_row($tampilsd);
				$sd = $rsd[0];
				
//				$sqlss = "SELECT COUNT(*) FROM permit_sibling 
//						JOIN sibling ON permit_sibling.`ID_SIBLING` = sibling.`ID_SIBLING`
//						JOIN diplomat ON sibling.`ID_DIPLOMAT` = diplomat.`ID_DIPLOMAT`
//						JOIN m_kantor_perwakilan ON diplomat.`ID_KNT_PERWAKILAN` = m_kantor_perwakilan.`ID_KNT_PERWAKILAN`
//						WHERE tgl_agenda BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'
//						AND jns_izin_permit='S' AND m_kantor_perwakilan.`ID_KNT_PERWAKILAN`=".$r1['ID_KNT_PERWAKILAN'];
                                
                                $sqlss = "SELECT count(DISTINCT(tbl_trans_otvis.id)) FROM tbl_trans_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								AND jns_paspor='4' and m_kantor_perwakilan.ID_KNT_PERWAKILAN='".$r1['ID_KNT_PERWAKILAN']."' and status_permohonan='".$status_keputusan."'";

				$tampilss = mysql_query($sqlss);
				
				$rss = mysql_fetch_row($tampilss);
				$ss = $rss[0];
                                
                                $sqlso = "SELECT count(DISTINCT(tbl_trans_otvis.id)) FROM tbl_trans_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								AND jns_paspor='5' and m_kantor_perwakilan.ID_KNT_PERWAKILAN='".$r1['ID_KNT_PERWAKILAN']."' and status_permohonan='".$status_keputusan."'";

				$tampilso = mysql_query($sqlso);
				
				$rso = mysql_fetch_row($tampilso);
				$so = $rso[0];
				
				if ($dd+$ds+$sd+$ss+$so>0)
				{
				?>
				<tr>
					<td><?=$r1['NM_KNT_PERWAKILAN']?></td>
					<td align=right><?=$dd?></td>
					<td align=right><?=$ds?></td>
					<td align=right><?=$sd?></td>
					<td align=right><?=$ss?></td>
                                        <td align=right><?=$so?></td>
					<td>
						<?php
							if ($r['ID_JNS_PERWAKILAN']=='5')
								echo "KEMENTERIAN";
							elseif ($r['ID_JNS_PERWAKILAN']=='3' && $r1['kode_agenda'] =='AP')
								echo "ORGANISASI INTERNASIONAL";
							else		
								echo $r1['deskripsi'];
						
						
						?>
					</td>
				</tr>
				<?php
				}
				$ddsub = $ddsub+$dd;
				$dssub = $dssub+$ds;
				$sdsub = $sdsub+$sd;
				$sssub = $sssub+$ss;
                                $sosub = $sosub+$so;
				}
				
				?>
				<tr>
					<td align=right><strong>SUBTOTAL</strong></td>
					<td align=right><strong><?=$ddsub?></strong></td>
					<td align=right><strong><?=$dssub?></strong></td>
					<td align=right><strong><?=$sdsub?></strong></td>
					<td align=right><strong><?=$sssub?></strong></td>
                                        <td align=right><strong><?=$sosub?></strong></td>
					<td><?=$ddsub+$dssub+$sdsub+$sssub+$sosub?></td>
				</tr>
				<?php
				$ddtotal = $ddtotal+$ddsub;
				$dstotal = $dstotal+$dssub;
				$sdtotal = $sdtotal+$sdsub;
				$sstotal = $sstotal+$sssub;
                                $sototal = $sototal+$sosub;
				}
				?>
				<tr>
					<td align=right><strong>GRANDTOTAL</strong></td>
					<td align=right><strong><?=$ddtotal?></strong></td>
					<td align=right><strong><?=$dstotal?></strong></td>
					<td align=right><strong><?=$sdtotal?></strong></td>
					<td align=right><strong><?=$sstotal?></strong></td>
                                        <td align=right><strong><?=$sototal?></strong></td>
					<td style="color:red;"><strong><?=$ddtotal+$dstotal+$sdtotal+$sstotal+$sototal?></strong></td>
				</tr>
				<?php
				?>	
			</table>
                        
                        <h2>BREAK DOWN REKAPITULASI PENGAJUAN VISA SIBLING</h2>
			<table width=700>
				<tr>
					<th><?=$TGL_AWAL?> S/D <?=$TGL_AKHIR?>, <?=$oo['status']?></th>
					<th >SUAMI</th>
					<th>ISTRI</th>
					<th>ANAK</th>
					<th>SAUDARA</th>
                                        <th>ORANG TUA</th>
					<th>KAWASAN</th>
					
				</tr>
				<?php
				$sql = "SELECT ID_JNS_PERWAKILAN, NM_JNS_PERWAKILAN FROM m_jns_perwakilan ORDER BY ket";
				$tampil = mysql_query($sql);
				while($r=mysql_fetch_array($tampil)){
				$ddsub = 0;
				$dssub = 0;
				$sdsub = 0;
				$sssub = 0;
                                $sosub = 0;
				?>
				<tr>
					<td colspan=100><strong><?=$r['NM_JNS_PERWAKILAN']?></strong></td>
				</tr>
				<?php
				$sql1 = "SELECT ID_KNT_PERWAKILAN, m_kode_agenda.`deskripsi`, m_kode_agenda.`kode_agenda`, NM_KNT_PERWAKILAN FROM m_kantor_perwakilan 
					JOIN m_kode_agenda ON m_kantor_perwakilan.`KODE_AGENDA` = m_kode_agenda.`kode_agenda`
					WHERE ID_JNS_PERWAKILAN = ".$r['ID_JNS_PERWAKILAN']."
					ORDER BY m_kode_agenda.`deskripsi`,  NM_KNT_PERWAKILAN";
				$tampil1 = mysql_query($sql1);
				while($r1=mysql_fetch_array($tampil1)){
				
                                
                                 $sqldd = "SELECT count(DISTINCT(tbl_anggota_fam.id)) FROM tbl_anggota_fam
								JOIN tbl_trans_otvis ON tbl_trans_otvis.id_otvis = tbl_anggota_fam.id_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE tbl_trans_otvis.created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								and tbl_anggota_fam.relasi='1' AND m_kantor_perwakilan.ID_KNT_PERWAKILAN='".$r1['ID_KNT_PERWAKILAN']."' and tbl_anggota_fam.status_permohonan='".$status_keputusan."'";

				$tampildd = mysql_query($sqldd);
				
				$rdd = mysql_fetch_row($tampildd);
				$dd = $rdd[0];
				
                                 $sqlds = "SELECT count(DISTINCT(tbl_anggota_fam.id)) FROM tbl_anggota_fam
								JOIN tbl_trans_otvis ON tbl_trans_otvis.id_otvis = tbl_anggota_fam.id_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE tbl_trans_otvis.created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								and tbl_anggota_fam.relasi='2' AND m_kantor_perwakilan.ID_KNT_PERWAKILAN='".$r1['ID_KNT_PERWAKILAN']."' and tbl_anggota_fam.status_permohonan='".$status_keputusan."'";

				$tampilds = mysql_query($sqlds);
				
				$rds = mysql_fetch_row($tampilds);
				$ds = $rds[0];
				
                               
                                 $sqlsd = "SELECT count(DISTINCT(tbl_anggota_fam.id)) FROM tbl_anggota_fam
								JOIN tbl_trans_otvis ON tbl_trans_otvis.id_otvis = tbl_anggota_fam.id_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE tbl_trans_otvis.created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								and tbl_anggota_fam.relasi='3' AND m_kantor_perwakilan.ID_KNT_PERWAKILAN='".$r1['ID_KNT_PERWAKILAN']."' and tbl_anggota_fam.status_permohonan='".$status_keputusan."'";


				$tampilsd = mysql_query($sqlsd);
				
				$rsd = mysql_fetch_row($tampilsd);
				$sd = $rsd[0];

                                
                                $sqlss = "SELECT count(DISTINCT(tbl_anggota_fam.id)) FROM tbl_anggota_fam
								JOIN tbl_trans_otvis ON tbl_trans_otvis.id_otvis = tbl_anggota_fam.id_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE tbl_trans_otvis.created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								and tbl_anggota_fam.relasi='4' AND m_kantor_perwakilan.ID_KNT_PERWAKILAN='".$r1['ID_KNT_PERWAKILAN']."' and tbl_anggota_fam.status_permohonan='".$status_keputusan."'";



				$tampilss = mysql_query($sqlss);
				
				$rss = mysql_fetch_row($tampilss);
				$ss = $rss[0];
                                
                                                          
                                $sqlso = "SELECT count(DISTINCT(tbl_anggota_fam.id)) FROM tbl_anggota_fam
								JOIN tbl_trans_otvis ON tbl_trans_otvis.id_otvis = tbl_anggota_fam.id_otvis
								JOIN tbl_user ON tbl_user.ID_PERWAKILAN = tbl_trans_otvis.created_by
								JOIN m_kantor_perwakilan ON m_kantor_perwakilan.ID_KNT_PERWAKILAN = tbl_user.ID_PERWAKILAN
								WHERE tbl_trans_otvis.created_date BETWEEN '".$TGL_AWAL."' AND '".$TGL_AKHIR."'  
								and tbl_anggota_fam.relasi='5' AND m_kantor_perwakilan.ID_KNT_PERWAKILAN='".$r1['ID_KNT_PERWAKILAN']."' and tbl_anggota_fam.status_permohonan='".$status_keputusan."'";



				$tampilso = mysql_query($sqlso);
				
				$rso = mysql_fetch_row($tampilso);
				$so = $rso[0];
				
				if ($dd+$ds+$sd+$ss+$so>0)
				{
				?>
				<tr>
					<td><?=$r1['NM_KNT_PERWAKILAN']?></td>
					<td align=right><?=$dd?></td>
					<td align=right><?=$ds?></td>
					<td align=right><?=$sd?></td>
					<td align=right><?=$ss?></td>
                                        <td align=right><?=$so?></td>
					<td>
						<?php
							if ($r['ID_JNS_PERWAKILAN']=='5')
								echo "KEMENTERIAN";
							elseif ($r['ID_JNS_PERWAKILAN']=='3' && $r1['kode_agenda'] =='AP')
								echo "ORGANISASI INTERNASIONAL";
							else		
								echo $r1['deskripsi'];
						
						
						?>
					</td>
				</tr>
				<?php
				}
				$ddsub = $ddsub+$dd;
				$dssub = $dssub+$ds;
				$sdsub = $sdsub+$sd;
				$sssub = $sssub+$ss;
                                $sosub = $sosub+$so;
				}
				
				?>
				<tr>
					<td align=right><strong>SUBTOTAL</strong></td>
					<td align=right><strong><?=$ddsub?></strong></td>
					<td align=right><strong><?=$dssub?></strong></td>
					<td align=right><strong><?=$sdsub?></strong></td>
					<td align=right><strong><?=$sssub?></strong></td>
                                        <td align=right><strong><?=$sosub?></strong></td>
					<td><?=$ddsub+$dssub+$sdsub+$sssub+$sosub?></td>
				</tr>
				<?php
				$ddtotal1 = $ddtotal1+$ddsub;
				$dstotal1 = $dstotal1+$dssub;
				$sdtotal1 = $sdtotal1+$sdsub;
				$sstotal1 = $sstotal1+$sssub;
                                $sototal1 = $sototal1+$sosub;
				}
				?>
				<tr>
					<td align=right><strong>GRANDTOTAL</strong></td>
					<td align=right><strong><?=$ddtotal1?></strong></td>
					<td align=right><strong><?=$dstotal1?></strong></td>
					<td align=right><strong><?=$sdtotal1?></strong></td>
					<td align=right><strong><?=$sstotal1?></strong></td>
                                        <td align=right><strong><?=$sototal1?></strong></td>
					<td style="color:red;"><strong><?=$ddtotal1+$dstotal1+$sdtotal1+$sstotal1+$sototal1?></strong></td>
				</tr>
			
			</table>
		</div>
		<?php
		
//	
//		$jmldata =mysql_num_rows(mysql_query($QWERYNYA));
//
//	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
//
//   $ilink = "?module=lapjmlpermit&act=generate"; 
//    $linkHalaman = $p->navHalaman($ilink,$_GET[halaman], $jmlhalaman);
//
//    echo "<div id=paging>$linkHalaman</div><br>";
    break;



}
		
}
?>
