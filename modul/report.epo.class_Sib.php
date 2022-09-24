<?php
// include_once("../config/dataAccess.class.php");
include "../config/koneksi.php";

include_once ("../config/eng.php");
include_once ("../config/tcpdf.php");

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	// Page header
	public function Header() {
		// Full background image
		$auto_page_break = $this->AutoPageBreak;
		$this->SetAutoPageBreak ( false, 0 );
		$this->SetAutoPageBreak ( $auto_page_break );
	}
}
class epo {
	var $error;
	var $data;
	var $rdata;
	var $rdata2;
	var $rdata3;
	var $data4;
	var $data5;
	var $type;
	var $iddiplomat;
	var $warna;
	var $query;
	var $pdf;
	var $profileid;
	var $passporttype;
	var $number;
	var $name;
	var $occupation;
	var $cardnumber;
	var $validcard;
	var $idimg;
	var $representative;


	public function epo($iddiplomat) {
		$sql = "select c.NM_DIPLOMAT,c.NM_SIBLING,a.NO_EPO,a.ID_EPO_S,a.TIPE_VISA,date_format(a.TGL_AKHIR_EPO,'%d') as tgl,date_format(a.TGL_AKHIR_EPO,'%c') as bln,date_format(a.TGL_AKHIR_EPO,'%Y') as thn,
		SUBSTR(a.NO_EPO,11,1) as KD_JNS_PASPOR from v_epo_sib a,v_sibling c where a.ID_SIBLING=c.ID_SIBLING and a.ID_SIBLING= $iddiplomat and a.ID_EPO_s = (select max(d.ID_EPO_S) from epo_sibling d where d.ID_SIBLING= $iddiplomat AND d.KD_WORKFLOW>=1)";
		$idt = $_GET[idt];


		//print_r($sql);exit;


		$result = mysql_query ( $sql );
		$data=mysql_fetch_array($result);
		//$kd_agenda=$data['KODE_AGENDA'];

		$kode_jenis 		= $data['KD_JNS_PASPOR'];
		$nomor_epo  		= $data['NO_EPO_S'];
		$nama_ok			= htmlspecialchars_decode($data['NM_SIBLING'], ENT_QUOTES);
		//$panjangNama =14;
		$nama 				= str_pad(strtoupper(substr($nama_ok,0,$panjangNama)),$panjangNama," ",STR_PAD_RIGHT);
		$tgl				= $data['tgl'];
		$bln				= $data['bln'];
		$thn				= $data['thn'];
		//print_r($nama_ok);
		//print_r($nama);exit;


		//$nomor_epo = mysql_result($result,0,"nomor_epo");


		/*$data = mysql_query ( "select NM_KNT_PERWAKILAN, PEKERJAAN,NO_PASPOR,JNS_PASPOR,NM_KNT_PERWAKILAN,FOTO from v_diplomat where ID_DIPLOMAT= $iddiplomat  " );
		$this->rdata2 = mysql_fetch_array ( $data ); */

		//$data = mysql_query ( "select FOTO_TTD from diplomat where ID_DIPLOMAT = $iddiplomat" );
		//$this->rdata3 = mysql_fetch_array ( $data );

		/* $data = mysql_query("select NM_KNT_PERWAKILAN, PEKERJAAN,NO_PASPOR,JNS_PASPOR,NM_KNT_PERWAKILAN,FOTO,FOTO_TTD from v_diplomat where ID_DIPLOMAT= $iddiplomat ");
		 $this->rdata2 = mysql_fetch_array($data); */

		//$nama = $this->rdata [NO_EPO];

		//print_r($data[1]);exit;

		$this->formattingprint ( $_POST ['TGL_CETAK'],$data['NO_EPO'],$nama_ok,$data['tgl'],$data['bln'],$data['thn'], $kode_jenis);
	}
	public function formattingprint($cetak,$nomor,$nm,$tgl,$bln,$thn,$kode_jenis) {

		$tempat 	= "Jakarta, ";
		$cetak  	= $cetak;
		$nomor_epo  = $nomor;
		$nama		= $nm;
		$tgl		= $tgl;
		$bln		= $bln;
		$thn		= $thn;
		$kode_jenis_indonesia = array("D"=>"DIPLOMATIK","S"=>"DINAS");
		$kode_jenis_english = array("D"=>"DIPLOMATIC","S"=>"SERVICE");

		$nama_bln = array (
				1 => "Januari",
				"Februari",
				"Maret",
				"April",
				"Mei",
				"Juni",
				"Juli",
				"Agustus",
				"September",
				"Oktober",
				"November",
				"Desember"
		);



		// $tanggal = date("j")." ".$nama_bln[date("n")]." ".date("Y");
		$part = explode ( "-", $cetak );
		$month = ltrim ( $part[1], "0" );
		$tanggal = $part[2] . " " . $nama_bln [$month] . " " . $part[0];
		$tanggal2 = $tgl . " " . $nama_bln [$bln] . " " . $thn;
		$tanggal3 = $nama_bln [$bln] . " " . $thn;
		// $tes = ucwords(strtolower($this->rdata[NM_DIPLOMAT]));

		// if (empty($this->rdata2[FOTO]) or empty($this->rdata2[FOTO_TTD])){
		// echo "<script language='javascript'>window.alert('Cetak Kartu gagal, Foto Belum tersedia!'); history.back(1); </script>";
		// }

		$teks_sampai_tanggal = $tanggal2;
		$teks_sejak_tanggal  = $tanggal;

		//print($teks_sejak_tanggal);exit;



		$satuan = "mm";

		$ukuran_jadi_lebar = 208;
		$ukuran_jadi_tinggi = 125;

		//$ukuran_jadi_lebar = 110;
		//$ukuran_jadi_tinggi = 70;

		$ukuran_die_cut_lebar = 60;
		$ukuran_die_cut_tinggi = 90;

		//$ukuran_die_cut_lebar = 100;
		//$ukuran_die_cut_tinggi = 60;

		$margin_kanan = ($ukuran_jadi_lebar-$ukuran_die_cut_lebar)/2;
		$margin_kiri = ($ukuran_jadi_lebar-$ukuran_die_cut_lebar)/2;
		$margin_atas = ($ukuran_jadi_tinggi-$ukuran_die_cut_tinggi)/2;
		$margin_bawah = ($ukuran_jadi_tinggi-$ukuran_die_cut_tinggi)/2;

		$padding_kanan = 4;
		$padding_kiri = 4;

		$koordinat_kiri_atas_x = $margin_kiri;
		$koordinat_kiri_atas_y = $margin_atas;

		$koordinat_kanan_atas_x = $koordinat_kiri_atas_x + $ukuran_die_cut_lebar;
		$koordinat_kanan_atas_y = $margin_atas;

		$koordinat_kiri_bawah_x = $margin_kiri;
		$koordinat_kiri_bawah_y = $margin_atas + $ukuran_die_cut_tinggi;

		$koordinat_kanan_bawah_x = $koordinat_kiri_bawah_x + $ukuran_die_cut_lebar;
		$koordinat_kanan_bawah_y = $koordinat_kiri_bawah_y;

		$lebar_area_tulis = $ukuran_die_cut_lebar - $padding_kanan - $padding_kiri;
		$lebar_slash_tengah = 1;
		$lebar_jenis = ($lebar_area_tulis-$lebar_slash_tengah)/2;

		$lebar_nama_1 = 9;
		$lebar_nama_2 = 18;
		$lebar_nama_3 = 10;

		$titik_dua = 2;

		$lebar_isian_1 = 40;
		$lebar_isian_2 = 10;

		$lebar_tempat_tanggal_kanan = 40;

		//$pdf = new FPDF('L',$satuan,array($ukuran_jadi_lebar,$ukuran_jadi_tinggi));
		$pdf = new TCPDF('P',$satuan,array($ukuran_jadi_lebar,$ukuran_jadi_tinggi), true, 'UTF-8', false);

		$pdf->AddPage();

		$pdf->SetLeftMargin($margin_kiri+$padding_kiri);
		$pdf->SetTopMargin($margin_atas);
		//$pdf->text_input_as_HTML = true;
		/* $pdf->Line($koordinat_kiri_atas_x,$koordinat_kiri_atas_y,$koordinat_kanan_atas_x,$koordinat_kanan_atas_y);
		$pdf->Line($koordinat_kiri_atas_x,$koordinat_kiri_atas_y,$koordinat_kiri_bawah_x,$koordinat_kiri_bawah_y);
		$pdf->Line($koordinat_kiri_bawah_x,$koordinat_kiri_bawah_y,$koordinat_kanan_bawah_x,$koordinat_kanan_bawah_y);
		$pdf->Line($koordinat_kanan_atas_x,$koordinat_kanan_atas_y,$koordinat_kanan_bawah_x,$koordinat_kanan_bawah_y); */

		if(!strcmp($kode_jenis,"S")){
			$lebar_jenis=$lebar_jenis-2;
		}

		/*if ($kode_jenis="D") {
		$pdf->Ln(28);
		$pdf->SetFont('helvetica','B',9);
		$pdf->Cell($lebar_jenis,4,"DIPLOMATIK",0,0,"R");
		$pdf->Cell($lebar_slash_tengah,4,"/",0,0,"C");
		$pdf->SetFont('helvetica','BI',9);
		$pdf->Cell($lebar_jenis,4,"DIPLOMATIC",0,1,"L");
		}
		else if ($kode_jenis="S") {
		$pdf->Ln(28);
		$pdf->SetFont('helvetica','B',9);
		$pdf->Cell($lebar_jenis,4,"DINAS",0,0,"R");
		$pdf->Cell($lebar_slash_tengah,4,"/",0,0,"C");
		$pdf->SetFont('helvetica','BI',9);
		$pdf->Cell($lebar_jenis,4,"SERVICE",0,1,"L");
		} */

		$pdf->Ln(20);
		$pdf->SetFont('helvetica','B',9);
		$pdf->Cell($lebar_jenis,4,$kode_jenis_indonesia[$kode_jenis],0,0,"R");
		$pdf->Cell($lebar_slash_tengah,4,"/",0,0,"C");
		$pdf->SetFont('helvetica','BI',9);
		$pdf->Cell($lebar_jenis,4,$kode_jenis_english[$kode_jenis],0,1,"L");

		$pdf->Ln(2);
		$pdf->SetFont('helvetica','B',8);
		$pdf->Cell($lebar_area_tulis,4,"REPUBLIK INDONESIA",0,1,"C");
		$panjang_garis=36;
		$pdf->Line($ukuran_jadi_lebar/2-$panjang_garis/2,$pdf->GetY(),$ukuran_jadi_lebar/2+$panjang_garis/2,$pdf->GetY());
		$pdf->SetFont('helvetica','IB',8);
		$pdf->Cell($lebar_area_tulis,4,"REPUBLIC OF INDONESIA",0,1,"C");

		$pdf->Ln(3);
		$pdf->SetFont('helvetica','',8);
		$pdf->Cell($lebar_nama_1,4,"No.",0,0,"L");
		$pdf->Cell($titik_dua,4,":",0,0,"L");
		$pdf->SetFont('helvetica','',8);
		$pdf->Cell($lebar_isian_1,4,"$nomor_epo",0,1,"L");
		$pdf->SetFont('helvetica','',8);
		$pdf->Cell($lebar_nama_1,4,"Nama",0,1,"L");
		$pdf->Line($pdf->GetX()+1,$pdf->GetY(),$pdf->GetX()+$lebar_nama_1,$pdf->GetY());
		$pdf->Cell($lebar_nama_1,4,"Name",0,0,"L");
		$pdf->SetY($pdf->GetY()-4);
		$pdf->SetX($pdf->GetX()+$lebar_nama_1);
		$pdf->Cell($titik_dua,8,":",0,0,"L");
		$pdf->SetFont('helvetica','',8);
		$pdf->MultiCell($lebar_isian_1,4,"$nama",0,"T");

		$pdf->Ln(3);
		$pdf->SetFont('helvetica','',7);
		$pdf->Cell($lebar_area_tulis,3,"Diizinkan meninggalkan Indonesia",0,1,"C");
		$panjang_garis=38;
		$pdf->Line($ukuran_jadi_lebar/2-$panjang_garis/2,$pdf->GetY(),$ukuran_jadi_lebar/2+$panjang_garis/2,$pdf->GetY());
		$pdf->SetFont('helvetica','I',7);
		$pdf->Cell($lebar_area_tulis,3,"Good for exit from Indonesia",0,1,"C");

		$pdf->Ln(1);
		$pdf->SetFont('helvetica','',7);
		$pdf->Cell($lebar_isian_1,3,"Dalam waktu s/d : $teks_sampai_tanggal",0,1,"L");
		$pdf->SetFont('helvetica','',8);
		$pdf->Line($pdf->GetX()+1,$pdf->GetY(),$pdf->GetX()+$lebar_nama_1+$titik_dua+$lebar_isian_1,$pdf->GetY());
		//$pdf->Line($pdf->GetX()+1,$pdf->GetY(),$pdf->GetX()+$lebar_nama_1+$titik_dua+$lebar_isian_1-2*$padding_kanan,$pdf->GetY());
		$pdf->SetFont('helvetica','I',7);
		$pdf->Cell($lebar_nama_2,3,"Within",0,1,"L");
		$pdf->SetX($pdf->GetX()+$lebar_isian_2+2);

		$pdf->Ln(1);
		$pdf->SetFont('helvetica','',7);
		$pdf->Cell($lebar_area_tulis,3,"Sejak tanggal tersebut di bawah",0,1,"L");
		$pdf->Line($pdf->GetX()+1,$pdf->GetY(),$pdf->GetX()+$lebar_nama_1+$titik_dua+$lebar_isian_1,$pdf->GetY());
		//$pdf->Line($pdf->GetX()+1,$pdf->GetY(),$pdf->GetX()+36,$pdf->GetY());
		$pdf->SetFont('helvetica','I',7);
		$pdf->Cell($lebar_area_tulis,3,"From date here of",0,1,"L");

		$pdf->Ln(2);
		$pdf->SetFont('helvetica','',7);
		$pdf->Cell($lebar_area_tulis,3,"$tempat $teks_sejak_tanggal",0,1,"R");

		//$pdf->Ln(8);
		//$pdf->Cell($lebar_area_tulis,3,"($penandatangan)",0,1,"R");

		$pdf->writeHTML($html, true, 0, true, 0);
		$pdf->SetDisplayMode ( 0, 'SinglePage', 'UseNone' );
		//ob_end_clean();
		$pdf->Output ( 'epo.pdf', 'I' );

		//$pdf->AutoPrint();
		//$pdf->Output();


		// ============================================================+
		// END OF FILE
		// ============================================================+
	}
}
?>
