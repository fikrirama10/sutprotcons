<?php
session_start();
$template = file("../template/canvasawal.htm");
$template = implode("",$template ); 

if (empty($_SESSION['G_iduser']) AND empty($_SESSION['G_namauser']) AND empty($_SESSION['G_leveluser'])){

	$varname =  "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";
	
	//$template = eregi_replace("{isi}",$varname,$template);
	$template = preg_replace("/{isi}/i",$varname,$template);
	
	echo $template;

}
else{
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>KEMENTRIAN LUAR NEGERI REPUBLIK INDONESIA</title>
<link href="../config/adminstyle2.css" rel="stylesheet" type="text/css" />
<link href="../config/menu.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="../images/kemlu.ico">
<style type="text/css">
/* popup_box DIV-Styles*/
.popup_box { 
	display:none; /* Hide the DIV */
	position:fixed;  
	_position:absolute; /* hack for internet explorer 6 */  
	height:500px;  
	width:470px;  
	background:#FFFFFF;  
	left: 300px;
	top: 150px;
	z-index:100; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
	margin-left: 15px;  
	
	/* additional features, can be omitted */
	border:2px solid #ff0000;  	
	padding:15px;  
	font-size:15px;  
	-moz-box-shadow: 0 0 5px #ff0000;
	-webkit-box-shadow: 0 0 5px #ff0000;
	box-shadow: 0 0 5px #ff0000;
 }
 
 .popup_box1 { 
	display:none; /* Hide the DIV */
	position:fixed;  
	_position:absolute; /* hack for internet explorer 6 */  
	height:550px;  
	width:580px;  
	background:#FFFFFF;  
	left: 300px;
	top: 10px;
	z-index:100; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
	margin-left: 15px;  
	
	/* additional features, can be omitted */
	border:2px solid #ff0000;  	
	padding:15px;  
	font-size:15px;  
	-moz-box-shadow: 0 0 5px #ff0000;
	-webkit-box-shadow: 0 0 5px #ff0000;
	box-shadow: 0 0 5px #ff0000;
 }
 
 /*mrs*/
 .popup_box2 { 
	display:none; /* Hide the DIV */
	position:fixed;  
	_position:absolute; /* hack for internet explorer 6 */  
	height:550px;  
	width:580px;  
	background:#FFFFFF;  
	left: 300px;
	top: 10px;
	z-index:100; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
	margin-left: 15px;  
	
	/* additional features, can be omitted */
	border:2px solid #5ab7f4;  	
	padding:15px;  
	font-size:15px;  
	-moz-box-shadow: 0 0 5px #5ab7f4;
	/*-webkit-box-shadow: 0 0 5px #5ab7f4;*/
	/*box-shadow: 0 0 5px #5ab7f4;*/
 }
 .popup_box3 { 
	display:none; /* Hide the DIV */
	position:fixed;  
	_position:absolute; /* hack for internet explorer 6 */  
	height:550px;  
	width:580px;  
	background:#FFFFFF;  
	left: 300px;
	top: 10px;
	z-index:100; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
	margin-left: 15px;  
	
	/* additional features, can be omitted */
	border:2px solid #5ab7f4;  	
	padding:15px;  
	font-size:15px;  
	-moz-box-shadow: 0 0 5px #5ab7f4;
	/*-webkit-box-shadow: 0 0 5px #5ab7f4;*/
	/*box-shadow: 0 0 5px #5ab7f4;*/
 }
 /*mrs-*/

 
#container {
	background: #d2d2d2; /*Sample*/
	width:100%;
	height:100%;
}

a{  
cursor: pointer;  
text-decoration:none;  
} 

/* This is for the positioning of the Close Link */
#popupBoxClose {
	font-size:20px;  
	line-height:15px;  
	right:5px;  
	top:5px;  
	position:absolute;  
	color:#6fa5e2;  
	font-weight:500;  	
}
</style>

<script type="text/javascript" src="../config/calendarDateInput.js"></script>
<script type="text/javascript" src="../config/comboDinamis.js"></script>
<script type="text/javascript" src="../config/rollover.js"></script>
<script src="../config/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="../config/jquery.validate.js" type="text/javascript"></script>

<link rel="stylesheet" href="../config/jquery-ui-1.12.1.custom/themes/base/jquery-ui.css">
<script src="../config/jquery-ui-1.12.1.custom/jquery-1.12.4.js"></script>
<script src="../config/jquery-ui-1.12.1.custom/jquery-ui.js"></script>

<script type="text/javascript">
	 //mrs
        $( "#tgl_cr_aju" ).datepicker({ dateFormat: 'yy-mm-dd' });
     //mrs-
	/* $.validator.setDefaults({
		submitHandler: function() { alert("submitted!"); }
	}); */
	function verify2(form){
		 if(form["nama_otvis"].value == '')
		 {
			alert('Nama Pemohon tidak boleh kosong!');
			return false;
		 }
  		/*  else if (form["pwk_otvis"].value == 0){
		 	alert('Perwakilan tidak boleh kosong!');
			return false;
		 }
		  */
		 else if(form["id_tipe_paspor"].value == '')
		 {
			alert('Jenis paspor tidak boleh kosong!');
			return false; 
		 }
		 else if(form["paspor_otvis"].value == '')
		 {
			alert('Paspor tidak boleh kosong!');
			return false; 
		 }
		 else if(form["tujuan_otvis"].value == '')
		 {
			alert('Tujuan tidak boleh kosong!');
			return false; 
		 }
		 else if(form["indeksvisa_otvis"].value == '')
		 {
			alert('Indeks visa tidak boleh kosong!');
			return false; 
		 }
		 
		 else if(form["masatugas_otvis"].value == '')
		 {
			alert('Masa Tugas tidak boleh kosong!');
			return false; 
		 }
		/*  else if(form["dasar_mintavisa"].value == '')
		 {
			alert('Dasar permintaan visa tidak boleh kosong!');
			return false; 
		 }
		 else if(form["dasar_berivisa"].value == '')
		 {
			alert('Dasar pemberian visa tidak boleh kosong!');
			return false; 
		 }
		  else if (form["ID_JNS_KEPUTUSAN"].value == 0){
		 	alert('Hasil Keputusan tidak boleh kosong!');
			return false;
		 }
		  else if (form["catatan_otvis"].value == ''){
		 	alert('Catatan tidak boleh kosong!');
			return false;
		 } */
		 
		 
		 
		 
		 
		/*  else if(form["anggota_fam"].value == '')
		 {
			alert('Anggota Keluarga tidak boleh kosong!');
			return false; 
		 } */
		// else {
		// 	return true;
		// }
		 
	}
	
	 
	function verify(form){
		 if(form["nama_otvis"].value == '')
		 {
			alert('Nama Pemohon tidak boleh kosong!');
			return false;
		 }
		 
		 if(form["nobrafaks_otvis"].value == '')
		 {
			alert('No Brafaks tidak boleh kosong!');
			return false; 
		 }
  		/*  else if (form["pwk_otvis"].value == 0){
		 	alert('Perwakilan tidak boleh kosong!');
			return false;
		 }
		  */
		if(form["id_tipe_paspor"].value == '')
		 {
			alert('Jenis paspor tidak boleh kosong!');
			return false; 
		 }
		 if(form["paspor_otvis"].value == '')
		 {
			alert('Paspor tidak boleh kosong!');
			return false; 
		 }
		 if(form["tujuan_otvis"].value == '')
		 {
			alert('Tujuan tidak boleh kosong!');
			return false; 
		 }
		 if(form["tipevisa_otvis"].value == '')
		 {
			alert('Tipe visa tidak boleh kosong!');
			return false; 
		 }
		 if(form["indeksvisa_otvis"].value == '')
		 {
			alert('Indeks visa tidak boleh kosong!');
			return false; 
		 }
		 
		 if(form["masatugas_otvis"].value == '')
		 {
			alert('Masa Tugas tidak boleh kosong!');
			return false; 
		 }
		/*  else if(form["dasar_mintavisa"].value == '')
		 {
			alert('Dasar permintaan visa tidak boleh kosong!');
			return false; 
		 }
		 else if(form["dasar_berivisa"].value == '')
		 {
			alert('Dasar pemberian visa tidak boleh kosong!');
			return false; 
		 }
		  else if (form["ID_JNS_KEPUTUSAN"].value == 0){
		 	alert('Hasil Keputusan tidak boleh kosong!');
			return false;
		 }
		  else if (form["catatan_otvis"].value == ''){
		 	alert('Catatan tidak boleh kosong!');
			return false;
		 }
		  */
		 
		 
		 
		 
		/*  else if(form["anggota_fam"].value == '')
		 {
			alert('Anggota Keluarga tidak boleh kosong!');
			return false; 
		 } */
		// else {
		// 	return true;
		// }
		 
	}
	
	function verify1(form){
		 if(form["nama_otvis"].value == '')
		 {
			alert('Nama Pemohon tidak boleh kosong!');
			return false;
		 }
		 
		 if(form["nobrafaks_otvis"].value == '')
		 {
			alert('No Brafaks tidak boleh kosong!');
			return false; 
		 }
  		/*  else if (form["pwk_otvis"].value == 0){
		 	alert('Perwakilan tidak boleh kosong!');
			return false;
		 }
		  */
		if(form["id_tipe_paspor"].value == '')
		 {
			alert('Jenis paspor tidak boleh kosong!');
			return false; 
		 }
		 if(form["paspor_otvis"].value == '')
		 {
			alert('Paspor tidak boleh kosong!');
			return false; 
		 }
		 if(form["tujuan_otvis"].value == '')
		 {
			alert('Tujuan tidak boleh kosong!');
			return false; 
		 }
		 if(form["tipevisa_otvis"].value == '')
		 {
			alert('Tipe visa tidak boleh kosong!');
			return false; 
		 }
		 if(form["indeksvisa_otvis"].value == '')
		 {
			alert('Indeks visa tidak boleh kosong!');
			return false; 
		 }
		 
		 if(form["masatugas_otvis"].value == '')
		 {
			alert('Masa Tugas tidak boleh kosong!');
			return false; 
		 }
		/*  else if(form["dasar_mintavisa"].value == '')
		 {
			alert('Dasar permintaan visa tidak boleh kosong!');
			return false; 
		 }
		 else if(form["dasar_berivisa"].value == '')
		 {
			alert('Dasar pemberian visa tidak boleh kosong!');
			return false; 
		 }
		  else if (form["ID_JNS_KEPUTUSAN"].value == 0){
		 	alert('Hasil Keputusan tidak boleh kosong!');
			return false;
		 }
		  else if (form["catatan_otvis"].value == ''){
		 	alert('Catatan tidak boleh kosong!');
			return false;
		 }
		  */
		 
		 
		 
		 
		/*  else if(form["anggota_fam"].value == '')
		 {
			alert('Anggota Keluarga tidak boleh kosong!');
			return false; 
		 } */
		// else {
		// 	return true;
		// }
		 
	}

	//$(document).ready( function() {
	
		// When site loaded, load the Popupbox First
		//$('#popup_button').click(function() {
		//  loadPopupBox();
		//})
		
	$(document).ready( function() {
	
/*		$('#updateStatus').click( function() {			
				$.post("aksi_approval_json.php", {
					  status:"donal duck",
					  city: "asdasd",
					},
					function (data, status){
						alert("Data: " + data + "\nStatus: " + status);
					});
				});
*/		
		$('#posisi').change( function() {			
			var a = $('#posisi option:selected').val();
		    if(a == 2)
			{
				$('div#replacement').show();
				//$('div#replacement1').show();
			}
			else
			{
				$('div#replacement').hide();
				//$('div#replacement1').hide();
			}
		});
		
		//var list = ["c", "c++", "c#","Basic","Mongo"];

		$('#pengganti').autocomplete({
			source: "cek_diplomat.php",
			minLength:2, 
			select: function (event, ui) {
				return false;
			},
			
			select: function (event, ui) {
				$(this).val(ui.item ? ui.item : " ");},
			
			change: function (event, ui) {
				if (!ui.item) {
					this.value = '';}
				else{
				 // return your label here
				}
			}
		}); 

		$('#simpan_otvis').click(function() {
			
			$nb_o = $('#nobrafaks_otvis').val();
			$n_o = $('#nama_otvis').val();
			$p_o = $('#paspor_otvis').val();
			$tp_o = $('#id_tipe_paspor').val();
			$t_o = $('#tujuan_otvis').val();
			$po_o = $('#posisi').val();
			$pt_o = $('#pengganti').val();
			$tv_o = $('#tipevisa_otvis').val();
			$iv_o = $('#indeksvisa_otvis').val();
			$mt_o = $('#masatugas_otvis').val();
			$su_o = $('#setneg_upload').val();
			$nnd_o = $('#no_nota_diplomatik').val();
			$nd_o = $('#nota_diplomatik_upload').val();
			//$sn_o = $('#surat_nikah_upload').val();
			$kl_o = $('#keppri_legal_upload').val();
			
			
			//alert($tp_o);false
			if($nb_o == '')
			{
			alert('Nomor Brafaks tidak boleh kosong!');
			return false;
			}
			else if($n_o == '')
			{
			alert('Nama Pemohon tidak boleh kosong!');
			return false;
			}
			else if($p_o == '')
			{
			alert('Nomor paspor tidak boleh kosong!');
			return false;
			}
			else if($tp_o == '')
			{
			alert('Jenis paspor tidak boleh kosong!');
			return false;
			}
			else if($t_o == '')
			{
			alert('Tujuan tidak boleh kosong!');
			return false;
			}
			else if($nnd_o == '')
			{
			alert('No Nota Diplomatik tidak boleh kosong!');
			return false;
			}
			else if($po_o == '')
			{
			alert('Posisi pengajuan tidak boleh kosong!');
			return false;
			}
			else if($po_o == '2')
			{
				if($pt_o == '')
				{
				alert('Nama yang digantikan tidak boleh kosong!');
				return false;
				}
			}
			else if($tv_o == '')
			{
			alert('Tipe visa tidak boleh kosong!');
			return false;
			}
			else if($iv_o == '')
			{
			alert('Indeks visa tidak boleh kosong!');
			return false;
			}
			else if($mt_o == '')
			{
			alert('Masa tugas tidak boleh kosong!');
			return false;
			}
			
			
		});
		
		
		//$(document).ready(function() {
    // One "blink" takes 1.5s
			setInterval(function(){
				// Immediately fade to opacity: 0 in 0ms
				$("div.blink182").fadeTo( 0, 0);
				// Wait .75sec then fade to opacity: 1 in 0ms
				setTimeout(function(){
					$("div.blink182").fadeTo( 0, 1);
				}, 750);
			}, 2000);
		//});

		$('#preview').click(function() {
			//loadPopupBox1(1);	
			$nb1_o = $('#nobrafaks_otvis').val();
			$n1_o = $('#nama_otvis').val();
			$p1_o = $('#paspor_otvis').val();
			$tp1_o = $('#id_tipe_paspor').val();
			$t1_o = $('#tujuan_otvis').val();
			$po1_o = $('#posisi').val();
			$pt1_o = $('#pengganti').val();
			$tv1_o = $('#tipevisa_otvis').val();
			$iv1_o = $('#indeksvisa_otvis').val();
			$mt1_o = $('#masatugas_otvis').val();
			$su1_o = $('#setneg_upload').val();
			$nnd1_o = $('#no_nota_diplomatik').val();
			$nd1_o = $('#nota_diplomatik_upload').val();
			//$sn1_o = $('#surat_nikah_upload').val();
			$kl1_o = $('#keppri_legal_upload').val();
			
			
			//alert($tp_o);false
			if($nb1_o == '')
			{
			alert('Nomor Brafaks tidak boleh kosong!');
			return false;
			}
			else if($n1_o == '')
			{
			alert('Nama Pemohon tidak boleh kosong!');
			return false;
			}
			else if($p1_o == '')
			{
			alert('Nomor paspor tidak boleh kosong!');
			return false;
			}
			else if($tp1_o == '')
			{
			alert('Jenis paspor tidak boleh kosong!');
			return false;
			}
			else if($t1_o == '')
			{
			alert('Tujuan tidak boleh kosong!');
			return false;
			}
			
			
			else if($po1_o == '')
				{
				alert('Posisi Pengajuan tidak boleh kosong!');
				return false;
				
				}
			//else if($po1_o == 2)
				//	{
						else if($pt1_o == '')
						{
						alert('Nama yang digantikan tidak boleh kosong!');
						return false;
						}
				//	}
				
			
			else if($mt1_o == '')
			{
			alert('Masa tugas tidak boleh kosong!');
			return false;
			}
			else if($nnd1_o == '')
			{
			alert('No Nota Diplomatik tidak boleh kosong!');
			return false;
			}
			else if($nd1_o == '')
			{
			alert('Nota diplomatik harus di unggah!');
			return false;
			}
			
			
			
			else if($tv1_o == '')
			{
			alert('Tipe visa tidak boleh kosong!');
			return false;
			}
			else if($iv1_o == '')
			{
			alert('Indeks visa tidak boleh kosong!');
			return false;
			}
			
			else if($su1_o == '')
			{
			alert('Surat Setneg harus di unggah!');
			return false;
			}
			
			
			else if($kl1_o == '')
			{
			alert('Surat legalisasi Keppri harus di unggah!');
			return false;
			}
			
			else
			{
			loadPopupBox1(1);	
			}
		});
	 
		$('#popupBoxClose').click( function() {			
			unloadPopupBox();
		});
		
		$('#container').click( function() {
			unloadPopupBox();
		});
	});
		
	jQuery(function($){
	
	 $('.remove-me1').click(function(e){
                e.preventDefault();
				var fieldNum = this.id;
				var rowId = "#rowIdx" + fieldNum;
				var inputId = ".inputIdx" + fieldNum;
				var noId = ".x" + fieldNum;
				 $(rowId).remove();
				 $(inputId).remove();
				 $(noId).remove();
				 
				 //next = fieldNum-1;
            });
	 $('.remove-me2').click(function(e){
                e.preventDefault();
				var fieldNum = this.id;
				var rowId = "#rowIdy" + fieldNum;
				var inputId = ".inputIdy" + fieldNum;
				var noId = ".y" + fieldNum;
				 $(rowId).remove();
				 $(inputId).remove();
				 $(noId).remove();
				 
				 //next = fieldNum-1;
            });
		$('.remove-me4').click(function(e){
                e.preventDefault();
				var fieldNum = this.id;
				var rowId = "#rowIdw" + fieldNum;
				var inputId = ".inputIdw" + fieldNum;
				var noId = ".w" + fieldNum;
				 $(rowId).remove();
				 $(inputId).remove();
				 $(noId).remove();
				 
				 //next = fieldNum-1;
            });	
    var next = 1;
    $('input[name="tambah_minta_visa"]').click(function() {
			//dasarmintavisa 			= $('input[id="dasar_mintavisa_otvis"]').val();
			
			//if(dasarmintavisa != ''){
				 $('#dasarMintaVisaResultList tr:last').after('<tr id="rowId'+next+'"><td></td><td>'+next+'. <input size=50 class="inputId'+next+'" id="inputmintavisa" type="text" name="dasar_mintavisa['+next+'][dasarmintavisa]"><span id="'+next+'" class="btn btn-danger remove-me" value="'+next+'" ><input type="button" value="x"></span></td></tr>');
				 
				 
				 $('#dasarMintaVisaResultList1 tr:last').after('<tr id="rowId'+next+'"><td class="inputId'+next+'"></td><td class="inputId'+next+'"></td><td class="inputId'+next+'">'+next+'. <input size=50 readonly class="inputId'+next+'" id="inputmintavisa'+next+'" type="text"  name="dasar_mintavisa1['+next+'][dasarmintavisa]"></td></tr>');
				 
				  
				

				//alert(this.value);
	
				  
			 //$('input[id="dasar_mintavisa_otvis"]').val(""); 
			
		//	}
	   next = next + 1;	
			
	 $('.remove-me').click(function(e){
                e.preventDefault();
				var fieldNum = this.id;
				var rowId = "#rowId" + fieldNum;
				var inputId = ".inputId" + fieldNum;
				 $(rowId).remove();
				 $(inputId).remove();
				 //next = fieldNum-1;
            });
			
		$('input#inputmintavisa').change(function() 
				{
					//alert(next-1);
					var a = $('#inputmintavisa').val();
					$('#inputmintavisa').val(a);
					var c;
					for (c = 1; c <= next-2; c++) {
					
					$('#inputmintavisa'+c).val(a);
					}
					
				});	
			
			
		
			
	});
	

	var next4 = 1;
	 $('input[name="tambah_anggota_fam"]').click(function() {
			//dasaranggotafam 			= $('input[id="dasaranggotafam_otvis"]').val();
			
			//if(dasaranggotafam != ''){
				 $('#anggotaFamResultList tr:last').after('<tr id="rowIds'+next4+'"><td></td><td width="10px;">'+next4+'.</td><td> Nama &nbsp;&nbsp;: <input size=25 class="inputIds'+next4+'" type="text"  id="inputanggotafam_nama" name="anggota_fam['+next4+'][anggotafam_nama]"><span id="'+next4+'" class="btn btn-danger remove-me4" value="'+next4+'" >  <input type="button" value="x"></span> <br> Relasi &nbsp;&nbsp;: <select class="inputIds'+next4+'" name="anggota_fam['+next4+'][anggotafam_relasi]" id="inputanggotafam_relasi"><option>- Silahkan Pilih -</option><option value="suami">Suami</option><option value="istri">Istri</option><option value="anak">Anak</option></select>  <br> Paspor : <input size=25 class="inputIds'+next4+'" type="text"  id="inputanggotafam_nopaspor" name="anggota_fam['+next4+'][anggotafam_nopaspor]"></td></tr>');
				 if(next4 == 1)
				 {
					$('#anggotaFamResultList1 tr:last').after('<tr id="rowIds'+next4+'"><td width=30%>Dasar Pemberian Visa</td>     <td width=6> : </td><td class="inputIds'+next4+'">'+next4+'. <input readonly size=50 class="inputIds'+next4+'" type="text"  value="" name="dasar_anggotafam1['+next4+'][dasaranggotafam]"></td></tr>');
				 
				 }
				 else
				 {
					 $('#anggotaFamResultList1 tr:last').after('<tr id="rowIds'+next4+'"><td class="inputIds'+next4+'"></td><td class="inputIds'+next4+'"></td><td class="inputIds'+next4+'">'+next4+'. <input readonly size=50 class="inputIds'+next4+'" type="text"  value="" name="dasar_anggotafam1['+next4+'][dasaranggotafam]"></td></tr>');
				 
				 }
				  
				  next4 = next4 + 1;
				  
				  
			// $('input[id="dasaranggotafam_otvis"]').val(""); 
			
			//}
		    
			
	 $('.remove-me4').click(function(e){
                e.preventDefault();
				var fieldNum = this.id;
				var rowIds = "#rowIds" + fieldNum;
				var inputIds = ".inputIds" + fieldNum;
				 $(rowIds).remove();
				 $(inputIds).remove();
            });
	 $('input#inputanggotafam').change(function() 
				{
					var b = $('#inputanggotafam').val();
					$('#inputanggotafam').val(b);
					//alert(a);
				});	
	
	});
	



				
	var next1 = 1;
	 $('input[name="tambah_beri_visa"]').click(function() {
			//dasarberivisa 			= $('input[id="dasarberivisa_otvis"]').val();
			
			//if(dasarberivisa != ''){
				 $('#dasarBeriVisaResultList tr:last').after('<tr id="rowIdb'+next1+'"><td></td><td>'+next1+'. <input size=50 class="inputIdb'+next1+'" type="text"  id="inputberivisa" name="dasar_berivisa['+next1+'][dasarberivisa]"><span id="'+next1+'" class="btn btn-danger remove-me1" value="'+next1+'" ><input type="button" value="x"></span></td></tr>');
				 if(next1 == 1)
				 {
					$('#dasarBeriVisaResultList1 tr:last').after('<tr id="rowIdb'+next1+'"><td width=30%>Dasar Pemberian Visa</td>     <td width=6> : </td><td class="inputIdb'+next1+'">'+next1+'. <input readonly size=50 class="inputIdb'+next1+'" type="text"  value="" name="dasar_berivisa1['+next1+'][dasarberivisa]"></td></tr>');
				 
				 }
				 else
				 {
					 $('#dasarBeriVisaResultList1 tr:last').after('<tr id="rowIdb'+next1+'"><td class="inputIdb'+next1+'"></td><td class="inputIdb'+next1+'"></td><td class="inputIdb'+next1+'">'+next1+'. <input readonly size=50 class="inputIdb'+next1+'" type="text"  value="" name="dasar_berivisa1['+next1+'][dasarberivisa]"></td></tr>');
				 
				 }
				  
				  next1 = next1 + 1;
				  
				  
			// $('input[id="dasarberivisa_otvis"]').val(""); 
			
			//}
		    
			
	 $('.remove-me1').click(function(e){
                e.preventDefault();
				var fieldNum = this.id;
				var rowIdb = "#rowIdb" + fieldNum;
				var inputIdb = ".inputIdb" + fieldNum;
				 $(rowIdb).remove();
				 $(inputIdb).remove();
            });
	 $('input#inputberivisa').change(function() 
				{
					var b = $('#inputberivisa').val();
					$('#inputberivisa').val(b);
					//alert(a);
				});	
	
	});
	
	
});	
	
	$(document).ready( function() {
	 $('#print').click(function() {
					 var input_nama = $('#nama_otvis').val();					
					 var input_nopaspor = $('#paspor_otvis').val();
					 //console.log(input_nama);false;
                    //else show the cheking_text and run the function to check  
                   // $('div#username_availability_result').html(checking_html).css("color", "black");  
                    get_val_otvis(input_nama,input_nopaspor);  
					
				});
	
	function get_val_otvis(nama,no_paspor){ 
						//use ajax to run the check  
						var g;
						$.post('report2.otvis.php', { nama: nama,no_paspor: no_paspor},
							function(result){  				
									//location.href = "report2.otvis.php";
								//var loc = location.href('report2.otvis.php','_blank');
								g = result;
								var win = window.open('report2.otvis.php', '_blank','width=400,height=400,scrollbars=1');								
								//win.result = g;
								//win.document.write(g);
								win.focus();
							//console.log(g);	false;							
								
						});  
				  
				}  
	
	});		
		function checkBox(kd,j){
 			$('#txt_box'+j).val(kd);
			if (kd==0) 
				txt="<div style='color:red;'>Reject</div>";
 			if (kd==1) 
				txt="<div style='color : #B1BF19;'>Waiting</div>";
 			if (kd==2) 
				txt="<div style='color:green;'>Approve</div>";
 			
			
			$('#status'+j).html(txt);
 		}
		
		function updateAction(kd,id,jns,kd_permit) {	
			$.post("aksi_approval_json.php", {
					  status:$("#txt_box"+id).val(),
					  id: kd,
					  jns_approval: jns,
					  jns_permit: kd_permit
					},
					function (data, status){
						if (status=='success'){
 							//alert (data);
							alert ('Berhasil memproses data!');
							document.location.reload(true);
 						}
 					}
				);
				//alert ('asdasdasd');
		}	
		
		function unloadPopupBox(i) {	// TO Unload the Popupbox
			$('#popup_box'+i).fadeOut("slow");
			$("#container").css({ // this is just for style		
				"opacity": "1"  
			}); 
		}	
		
		function loadPopupBox(i) {	// To Load the Popupbox
			$('#popup_box'+i).fadeIn("slow");
			//$('#txt_box'+i).val(j);
 			$("#container").css({ // this is just for style
				"opacity": "0.3"  
			}); 		
		}
		
		function loadPopupBox2(i,nokonsep) {	// To Load the Popupbox
			$('#popup_box'+i).fadeIn("slow");
			//$('#txt_box'+i).val(j);
 			$("#container").css({ // this is just for style
				"opacity": "0.3"  
			});
			//console.log(nokonsep);
			var nama,no_paspor,pwk_ri;
			//var no_paspor;
			$.post('detail_visa.php', { nk:nokonsep},
				function(result){  				
							obj = JSON.parse(result);
							//$("div#nama_pre").text(obj.nama);
							$("div#nobra_pre").text(obj.no_bra);
							$("div#pwkri_pre").text(obj.pwk_ri);
							$("div#nama_pre").text(obj.nama);
							$("div#fam_pre").text(obj.urutan);
							$("div#nopaspor_pre").text(obj.paspor);
							$("div#tpvisa_pre").text(obj.tipe_visa);
							
							//$("div#anggota_fam_pre").innerHTML(anggota_fam);
							//document.getElementById("anggota_fam_pre").innerHTML = anggota_fam;
							$("div#jns_paspor_pre").text(obj.jns_paspor);
							$("div#tujuan_pre").text(obj.tujuan);
							$("div#indeksvisa_pre").text(obj.indeks_visa);
							$("div#masa_tugas_pre").text(obj.masa_tugas+' Hari');	
							$("div#ver_pre").text(obj.ver);
							$("div#jabver_pre").text(obj.jab_ver);
							$("div#leg_pre").text(obj.legal);
							$("div#jableg_pre").text(obj.jab_legal);
							$("div#cat_pre").text(obj.catatan);
							$("div#stmhn_pre").text(obj.st_mhn);							
						});  
		
		}
		
		function loadPopupBox1(i) {	// To Load the Popupbox
			$('#popup_box'+i).fadeIn("slow");
			//$('#txt_box'+i).val(j);
 			$("#container").css({ // this is just for style
				"opacity": "0.3"  
			});
			var pwk = $("#pwk_otvis option:selected").text();
			var nama = $("#nama_otvis").val();
			var nopaspor = $("#paspor_otvis").val();
			var anggota_fam = $("textarea#anggota_fam").val();
			//var anggota_fam = document.getElementById("anggota_fam").value;
			var jns_paspor = $("#id_tipe_paspor option:selected").text();
			var tujuan_otvis = $("#tujuan_otvis").val();
			var indeksvisa_otvis = $("#indeksvisa_otvis option:selected").text();
			var masatugas_otvis = $("#masatugas_otvis").val();
			$("div#pwkri_pre").text(pwk);
			$("div#nama_pre").text(nama);
			$("div#nopaspor_pre").text(nopaspor);
			$("div#anggota_fam_pre").text(anggota_fam);
			
			//$("div#anggota_fam_pre").innerHTML(anggota_fam);
			//document.getElementById("anggota_fam_pre").innerHTML = anggota_fam;
			$("div#jns_paspor_pre").text(jns_paspor);
			$("div#tujuan_pre").text(tujuan_otvis);
			$("div#indeksvisa_pre").text(indeksvisa_otvis);
			$("div#masa_tugas_pre").text(masatugas_otvis);
		}
		
		 //mrs
                function loadPopupBoxMiras(i,kd2,j,nt_pengajuan,nt_jawaban,ket,status,triwulan,tahun,tgl_pengajuan, tgl_jawaban,jml_spirit,jml_anggur,jml_rokok,lokasi_aju,nama_aju,tipe_fl_aju,lokasi_jwb,nama_jwb,tipe_fl_jwb,nm) {	// To Load the Popupbox
			$('#popup_box'+i).fadeIn("fast");
			//$('#txt_box'+i).val(j);
 			$("#container").css({ // this is just for style
				"opacity": "0.3"  
			});
                         var a=j;
                         var b=nt_pengajuan;
                         var c=nt_jawaban;
                         var d = ket;
                         var e = status;
                         var f = triwulan;
                         var g = tahun;
                         var h = tgl_pengajuan;
                         var k = tgl_jawaban;
                         var l = jml_spirit;
                         var m = jml_anggur;
                         var n = jml_rokok;
                         var o = kd2;
                         var p = lokasi_aju;
                         var q = nama_aju+'.'+tipe_fl_aju;
                         var r = lokasi_jwb;
                         var s = nama_jwb+'.'+tipe_fl_jwb;
                         var t = nm;
                         
                         document.getElementById("kd").value=a;
                         document.getElementById("kd1").value=o;
                         document.getElementById("nota_pengajuan").value=b;
                         document.getElementById("not_jawaban").value=c;
                         document.getElementById("keterangan").value=d;
                         if(e=='Setuju'){                            
                             document.getElementById("st_aju").checked=true;
                             document.getElementById("sts_pengajuan").checked=false;
                         }else {
                             document.getElementById("sts_pengajuan").checked=true;
                             document.getElementById("st_aju").checked=false;
                         }
                         
                         document.getElementById("trw").value=f;
                         
                         document.getElementById("thn").value=g;                         
                         
                         document.getElementById("tgl_pengajuan").value=h;
                         document.getElementById("datepicker1").value=k;
                         document.getElementById("spirit1").value=l;
                         document.getElementById("anggur1").value=m;
                         document.getElementById("rokok1").value=n;                      
                         var link_aju = q.link(p);
                         document.getElementById("fl_aju").innerHTML = link_aju;
                         document.getElementById("fl_aju_hd").value = q;
                         var link_jwb = s.link(r);
                         document.getElementById("fl_jwb").innerHTML = link_jwb;
                         document.getElementById("fl_jwb_hd").value = s;
                         //document.getElementById("nota_pengajuan").value=r;
                         //document.getElementById("not_jawaban").value=s;
                        $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
                        $( "#tgl_pengajuan" ).datepicker({ dateFormat: 'yy-mm-dd' });
                        document.getElementById("nm_edt").innerHTML=t;
                        

		}
                
                function tmp_cari(){
                    var a = document.getElementById("cr_pengajuan").value;
                    document.getElementById("cr").value=a;
                }
                //mrs-
		
		function unloadPopupBox1(i) {	// TO Unload the Popupbox
			$('#popup_box'+i).fadeOut("slow");
			$("#container").css({ // this is just for style		
				"opacity": "1"  
			}); 
		}	
		
		  function unloadPopupBox2(i) {	// TO Unload the Popupbox
			$('#popup_box'+i).fadeOut("fast");
			$("#container").css({ // this is just for style		
				"opacity": "1"  
			}); 
		}
		
		/**********************************************************/
		
	//});
</script>
</head>

<body onload="MM_preloadImages('../images/icon/Icon - Personal BLOCK.gif','../images/icon/Icon - Permit BLOCK.gif','../images/icon/Icon - ID Card BLOCK.gif','../images/icon/Icon - Rantor Individu BLOCK.gif','../images/icon/Icon - Rantor kantor BLOCK.gif','../images/icon/Icon - Fasilitas BLOCK.gif')">
<div id="container"> <!-- Main Page -->
 </div>
<table  width="980" align="center" cellpadding="0" cellspacing="0" id="frameutama"    >
  <tr>
   <!-- <td colspan="2"><img src="../images/header2.png" alt="head" width="980" height="80" /></td>-->
    <td colspan="2"><img src="../images/header_new.jpg" alt="head" width="980"  /></td>
  </tr>
  <tr>
	<td colspan="2">
	<?php
	function getChildMmenu($parentid)
	{
		$parent=mysql_query("SELECT * FROM m_menu WHERE PARENT_MENU=$parentid AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')ORDER BY ID_MENU ASC");
		
		echo "<ul>";
		while($r=mysql_fetch_array($parent)){
			$child=mysql_query("SELECT * FROM m_menu WHERE PARENT_MENU=$r[ID_MENU] AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')ORDER BY ID_MENU ASC");
			$jmlchild=mysql_num_rows($child);
			if ($jmlchild>0)
			{
				echo "<li ><a class='arrow' href='$r[MENU_LINK]'>$r[MENU]</a>";
				getChildMmenu($r['ID_MENU']);
				echo "</li>";
			}else
			{
				echo "<li ><a class='' href='$r[MENU_LINK]'>$r[MENU]</a></li>";
			}
			$jmlchild=0;
		
		}
		echo "</ul>";
	}
	
	include "../config/koneksi.php";
        //edit andri 14092016 tambah ORDER BY ID_MENU ASC
	$parent=mysql_query("SELECT * FROM m_menu WHERE PARENT_MENU=0 AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')ORDER BY ID_MENU ASC");
    echo "<ul class='menuH decor1'> ";
	while($r=mysql_fetch_array($parent)){
		
		$child=mysql_query("SELECT * FROM m_menu WHERE PARENT_MENU=$r[ID_MENU] AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')ORDER BY ID_MENU ASC");
		//echo "SELECT * FROM m_menu WHERE PARENT_MENU=$r[ID_MENU] AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')";
		$jmlchild=mysql_num_rows($child);
		if ($jmlchild>0)
		{
			echo "<li ><a class='arrow' href='$r[MENU_LINK]'>$r[MENU]</a>";
			getChildMmenu($r['ID_MENU']);
			echo "</li>";
		}else
		{
			echo "<li ><a class='' href='$r[MENU_LINK]'>$r[MENU]</a></li>";
		}
		
		$jmlchild=0;
		
	}
	
		echo "<li>            <a href='logout.php'>LOGOUT ";
		if($_SESSION[G_leveluser] == 15 || $_SESSION[G_leveluser] == 14)
		{
		echo "($_SESSION[G_namauser])";
		}
		echo"</a>          </li>";
		;
	echo "</ul>";
	?>
	
  
    
  </tr>
  <tr>

<?php

}



?>

   
	
	 <td width="799" style="vertical-align: top" >
	<DIV id="content">
	<?php  
	   // echo "<a href=?module=diplomat&act=cari&huruf=A>A</A> |	<a href=?module=diplomat&act=cari&huruf=B>B</A> |	<a href=?module=diplomat&act=cari&huruf=C>C</A> |	<a href=?module=diplomat&act=cari&huruf=D>D</A> |	<a href=?module=diplomat&act=cari&huruf=E>E</A> |	<a href=?module=diplomat&act=cari&huruf=F>F</A> |	<a href=?module=diplomat&act=cari&huruf=G>G</A> |	<a href=?module=diplomat&act=cari&huruf=H>H</A> |	<a href=?module=diplomat&act=cari&huruf=I>I</A> |	<a href=?module=diplomat&act=cari&huruf=J>J</A> |	<a href=?module=diplomat&act=cari&huruf=K>K</A> |	<a href=?module=diplomat&act=cari&huruf=L>L</A> |	<a href=?module=diplomat&act=cari&huruf=M>M</A> |	<a href=?module=diplomat&act=cari&huruf=N>N</A> |	<a href=?module=diplomat&act=cari&huruf=O>O</A> |	<a href=?module=diplomat&act=cari&huruf=P>P</A> |	<a href=?module=diplomat&act=cari&huruf=Q>Q</A> |	<a href=?module=diplomat&act=cari&huruf=R>R</A> |	<a href=?module=diplomat&act=cari&huruf=S>S</A> |	<a href=?module=diplomat&act=cari&huruf=T>T</A> |	<a href=?module=diplomat&act=cari&huruf=U>U</A> |	<a href=?module=diplomat&act=cari&huruf=V>V</A> |	<a href=?module=diplomat&act=cari&huruf=W>W</A> |	<a href=?module=diplomat&act=cari&huruf=X>X</A> |	<a href=?module=diplomat&act=cari&huruf=Y>Y</A> |	<a href=?module=diplomat&act=cari&huruf=Z>Z</A>";
    
	 include "content.php"; 
	 ?>
	</div>
	</td>
	</tr>
  <tr>
    <td colspan="2">		<div  align="center" id="footer">
		Copyright &copy; 2013 by Pusat Teknologi Informasi dan Komunikasi Kementerian dan Perwakilan
	<!--echo $_SESSION[G_leveluser]; ?>	 -->
	 </div>	</td>
  </tr>
</table>

</body>
</html>

<?php
//}
?>
