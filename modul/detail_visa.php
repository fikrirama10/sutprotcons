<?php
include "../config/koneksi.php";
include "../config/library.php";
				$j = $_POST[nk];
				$sql_otvis="select * from tbl_trans_otvis where no_konsep='$j'";
				$tampil_otvis=mysql_query($sql_otvis);
				
				$sql_fam="select * from tbl_anggota_fam where no_konsep='$j'";
				$tampil_fam=mysql_query($sql_fam);
				 
				 $val1=mysql_fetch_array($tampil_otvis);
				 $i=1;
				 while ($val_fam=mysql_fetch_array($tampil_fam))
				 {
					
				 $i++;
				 }
				 
				$sql_pwk="select a.id_perwakilan,a.perwakilan,a.negara,b.nm_regional from tbl_perwakilan a left join tbl_regional b on a.id_regional = b.id_regional";
				$tampil_pwk=mysql_query($sql_pwk);
		
			    while($val=mysql_fetch_array($tampil_pwk))
					{
						if($val1[pwk_ri] == $val[id_perwakilan])
						{
						$pwk =  $val[perwakilan];
						}
						
					}
				
				$sql_visa="select * from m_jns_visa where ID_JNS_VISA = 2 OR ID_JNS_VISA = 4 OR ID_JNS_VISA = 6 OR ID_JNS_VISA = 9";
					$tampil_visa=mysql_query($sql_visa);					
					while($val=mysql_fetch_array($tampil_visa))
					 {
						if($val1['indeks_visa'] == $val['ID_JNS_VISA'])
						{
						$indekvisa =  $val[NM_JNS_VISA];
						$iv = explode(' ',$indekvisa);
						}
						
					 }
					 
					 
					 $sql_status2="select * from tbl_ref_status";
					$tampil_status2=mysql_query($sql_status2);
					while($val=mysql_fetch_array($tampil_status2))
					 {
						if($val1['status_permohonan'] == $val['id'])
						{
						$st_mhn = $val[status];
						}
					}
					
					$sql_paspor4="select * from tbl_jns_paspor";
					$tampil_paspor4=mysql_query($sql_paspor4);
					while($val=mysql_fetch_array($tampil_paspor4))
					 {
						if($val1['jns_paspor'] == $val['id'])
						{
						$jns_paspor = $val[jns_paspor];
						}
						
					 }	
					 
					 $sql_tipevisa="select * from tbl_tipe_visa";
					$tampil_tipevisa=mysql_query($sql_tipevisa);
					while($val=mysql_fetch_array($tampil_tipevisa))
					 {
						if($val1['tipe_visa'] == $val['id'])
						{
						$tipe_visa = $val[tipe_visa];
						}
						
					 }	
					 
				// $data_array_fam = array(
				//	  'urutan' => $u; 
				//	  );
				 //echo json_encode($data_array_fam);
				  
				  
					 $data_array = array(
					'no_bra' => $val1[no_brafaks],
					'pwk_ri' => $pwk,
					'nama' => $val1[nama],
					//'nama_fam' => $val_fam[nama],
					'urutan' => $val_fam[urutan],
					'paspor' => $val1[paspor],
					'jns_paspor' => $jns_paspor,
					'tujuan' => $val1[tujuan],
					'tipe_visa' => $tipe_visa,
					'indeks_visa' => $iv[2],
					'masa_tugas' => $val1[masa_tugas],
					'ver' => $val1[verifikator],
					'jab_ver' => $val1[jabatan_verifikator],
					'legal' => $val1[legalisator],
					'jab_legal' => $val1[jabatan_legalisator],
					'catatan' => $val1[catatan],
					'st_mhn' => $st_mhn,
					'created_date' => $val1[created_date],
					'modified_date' => $val1[no_brafaks],
					 );
				 
				echo json_encode($data_array);
?>