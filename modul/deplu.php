<?php
session_start();
$template = file("../template/canvasawal.htm");
$template = implode("", $template);

if (empty($_SESSION['G_iduser']) and empty($_SESSION['G_namauser']) and empty($_SESSION['G_leveluser'])) {

    $varname = "<br> <center>Untuk mengakses modul, Anda harus login <br> <a href=index.php><b>LOGIN</b></a></center>";

    //$template = eregi_replace("{isi}",$varname,$template);
    $template = preg_replace("/{isi}/i", $varname, $template);

    echo $template;
} else { ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>KEMENTERIAN LUAR NEGERI REPUBLIK INDONESIA</title>
        <link href="../config/adminstyle2.css" rel="stylesheet" type="text/css" />
        <link href="../config/menu.css" rel="stylesheet" type="text/css" />
        <link href="../config/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> <!-- dt -->


        <link rel="shortcut icon" type="image/x-icon" href="../images/kemlu.ico">
        <style type="text/css">
            /* popup_box DIV-Styles*/
            .popup_box {
                display: none;
                /* Hide the DIV */
                position: fixed;
                _position: absolute;
                /* hack for internet explorer 6 */
                height: 500px;
                width: 470px;
                background: #FFFFFF;
                left: 300px;
                top: 150px;
                z-index: 100;
                /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
                margin-left: 15px;

                /* additional features, can be omitted */
                border: 2px solid #ff0000;
                padding: 15px;
                font-size: 15px;
                -moz-box-shadow: 0 0 5px #ff0000;
                -webkit-box-shadow: 0 0 5px #ff0000;
                box-shadow: 0 0 5px #ff0000;
            }

            .popup_box1 {
                display: none;
                /* Hide the DIV */
                position: fixed;
                _position: absolute;
                /* hack for internet explorer 6 */
                height: 550px;
                width: 580px;
                background: #FFFFFF;
                left: 300px;
                top: 10px;
                z-index: 100;
                /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
                margin-left: 15px;

                /* additional features, can be omitted */
                border: 2px solid #ff0000;
                padding: 15px;
                font-size: 15px;
                -moz-box-shadow: 0 0 5px #ff0000;
                -webkit-box-shadow: 0 0 5px #ff0000;
                box-shadow: 0 0 5px #ff0000;
            }

            /*mrs*/
            .popup_box2 {
                display: none;
                /* Hide the DIV */
                position: fixed;
                _position: absolute;
                /* hack for internet explorer 6 */
                height: 550px;
                width: 580px;
                background: #FFFFFF;
                left: 300px;
                top: 10px;
                z-index: 100;
                /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
                margin-left: 15px;

                /* additional features, can be omitted */
                border: 2px solid #5ab7f4;
                padding: 15px;
                font-size: 15px;
                -moz-box-shadow: 0 0 5px #5ab7f4;
                /*-webkit-box-shadow: 0 0 5px #5ab7f4;*/
                /*box-shadow: 0 0 5px #5ab7f4;*/
            }

            .popup_box3 {
                display: none;
                /* Hide the DIV */
                position: fixed;
                _position: absolute;
                /* hack for internet explorer 6 */
                height: 550px;
                width: 580px;
                background: #FFFFFF;
                left: 300px;
                top: 10px;
                z-index: 100;
                /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
                margin-left: 15px;

                /* additional features, can be omitted */
                border: 2px solid #5ab7f4;
                padding: 15px;
                font-size: 15px;
                -moz-box-shadow: 0 0 5px #5ab7f4;
                /*-webkit-box-shadow: 0 0 5px #5ab7f4;*/
                /*box-shadow: 0 0 5px #5ab7f4;*/
            }

            /*mrs-*/

            .popup_box4 {
                display: none;
                /* Hide the DIV */
                position: fixed;
                _position: absolute;
                /* hack for internet explorer 6 */
                height: 450px;
                width: 680px;
                background: #FFFFFF;
                left: 300px;
                top: 10px;
                z-index: 100;
                /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
                margin-left: 15px;

                /* additional features, can be omitted */
                border: 2px solid #5ab7f4;
                padding: 15px;
                font-size: 15px;
                -moz-box-shadow: 0 0 5px #5ab7f4;
                /*-webkit-box-shadow: 0 0 5px #5ab7f4;*/
                /*box-shadow: 0 0 5px #5ab7f4;*/
            }

            .popup_box5 {
                display: none;
                /* Hide the DIV */
                position: fixed;
                _position: absolute;
                /* hack for internet explorer 6 */
                height: 480px;
                width: 680px;
                background: #FFFFFF;
                left: 300px;
                top: 10px;
                z-index: 100;
                /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
                margin-left: 15px;

                /* additional features, can be omitted */
                border: 2px solid #5ab7f4;
                padding: 15px;
                font-size: 15px;
                -moz-box-shadow: 0 0 5px #5ab7f4;
                /*-webkit-box-shadow: 0 0 5px #5ab7f4;*/
                /*box-shadow: 0 0 5px #5ab7f4;*/
            }

            .popup_box6 {
                display: none;
                /* Hide the DIV */
                position: fixed;
                _position: absolute;
                /* hack for internet explorer 6 */
                height: 500px;
                width: 680px;
                background: #FFFFFF;
                left: 300px;
                top: 10px;
                z-index: 100;
                /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
                margin-left: 15px;

                /* additional features, can be omitted */
                border: 2px solid #5ab7f4;
                padding: 15px;
                font-size: 15px;
                -moz-box-shadow: 0 0 5px #5ab7f4;
                /*-webkit-box-shadow: 0 0 5px #5ab7f4;*/
                /*box-shadow: 0 0 5px #5ab7f4;*/
            }



            #container {
                background: #d2d2d2;
                /*Sample*/
                width: 100%;
                height: 100%;
            }

            a {
                cursor: pointer;
                text-decoration: none;
            }

            /* This is for the positioning of the Close Link */
            #popupBoxClose {
                font-size: 20px;
                line-height: 15px;
                right: 5px;
                top: 5px;
                position: absolute;
                color: #6fa5e2;
                font-weight: 500;
            }
        </style>
        <script src="../config/jquery-3.3.1.js"></script> <!-- dt -->
        <script type="text/javascript" src="../config/calendarDateInput.js"></script>
        <script type="text/javascript" src="../config/comboDinamis.js"></script>
        <script type="text/javascript" src="../config/rollover.js"></script>
        <script src="../config/jquery-1.2.6.min.js" type="text/javascript"></script>
        <script src="../config/jquery.validate.js" type="text/javascript"></script>

        <link rel="stylesheet" href="../config/jquery-ui-1.12.1.custom/themes/base/jquery-ui.css">
        <script src="../config/jquery-ui-1.12.1.custom/jquery-1.12.4.js"></script>
        <script src="../config/jquery-ui-1.12.1.custom/jquery-ui.js"></script>

        <script src="../config/jquery.dataTables.min.js"></script> <!-- dt -->



        <script type="text/javascript">
            //mrs
            $("#tgl_cr_aju").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            //mrs-
            /* $.validator.setDefaults({
             submitHandler: function() { alert("submitted!"); }
             }); */
            function verify2(form) {
                if (form["nama_otvis"].value == '') {
                    alert('Nama Pemohon tidak boleh kosong! verify2');
                    return false;
                } else if (form["id_tipe_paspor"].value == '') {
                    alert('Jenis paspor tidak boleh kosong!');
                    return false;
                } else if (form["paspor_otvis"].value == '') {
                    alert('Paspor tidak boleh kosong!');
                    return false;
                } else if (form["tujuan_otvis"].value == '') {
                    alert('Tujuan tidak boleh kosong!');
                    return false;
                } else if (form["indeksvisa_otvis"].value == '') {
                    alert('Indeks visa tidak boleh kosong!');
                    return false;
                } else if (form["masatugas_otvis"].value == '') {
                    alert('Masa Tugas tidak boleh kosong!');
                    return false;
                }

            }

            function verify(form) {
                if (form["nama_otvis"].value == '') {
                    alert('Nama Pemohon tidak boleh kosong! verify');
                    return false;
                }

                if (form["nobrafaks_otvis"].value == '') {
                    alert('No Brafaks tidak boleh kosong!');
                    return false;
                }
                if (form["id_tipe_paspor"].value == '') {
                    alert('Jenis paspor tidak boleh kosong!');
                    return false;
                }
                if (form["paspor_otvis"].value == '') {
                    alert('Paspor tidak boleh kosong!');
                    return false;
                }
                if (form["tujuan_otvis"].value == '') {
                    alert('Tujuan tidak boleh kosong!');
                    return false;
                }
                if (form["tipevisa_otvis"].value == '') {
                    alert('Tipe visa tidak boleh kosong!');
                    return false;
                }
                if (form["indeksvisa_otvis"].value == '') {
                    alert('Indeks visa tidak boleh kosong!');
                    return false;
                }
                if (form["masatugas_otvis"].value == '') {
                    alert('Masa Tugas tidak boleh kosong!');
                    return false;
                }

            }

            function verify1(form) {
                if (form["nama_otvis"].value == '') {
                    alert('Nama Pemohon tidak boleh kosong!verify1');
                    return false;
                }
                if (form["nobrafaks_otvis"].value == '') {
                    alert('No Brafaks tidak boleh kosong!');
                    return false;
                }
                if (form["id_tipe_paspor"].value == '') {
                    alert('Jenis paspor tidak boleh kosong!');
                    return false;
                }
                if (form["paspor_otvis"].value == '') {
                    alert('Paspor tidak boleh kosong!');
                    return false;
                }
                if (form["tujuan_otvis"].value == '') {
                    alert('Tujuan tidak boleh kosong!');
                    return false;
                }
                if (form["tipevisa_otvis"].value == '') {
                    alert('Tipe visa tidak boleh kosong!');
                    return false;
                }
                if (form["indeksvisa_otvis"].value == '') {
                    alert('Indeks visa tidak boleh kosong!');
                    return false;
                }

                if (form["masatugas_otvis"].value == '') {
                    alert('Masa Tugas tidak boleh kosong!');
                    return false;
                }

            }

            $(document).ready(function() {
                
                $('#posisi').change(function() {
                    var a = $('#posisi option:selected').val();
                    if (a == 2 || a == 5) {
                        $('div#replacement').show();
                        //$('div#replacement1').show();
                    } else {
                        $('div#replacement').hide();
                        //$('div#replacement1').hide();
                    }
                });

                $('#pengganti').autocomplete({
                    source: "get_diplomat.php",
                    minLength: 2,
                    select: function(event, ui) {
                        return false;
                    },

                    select: function(event, ui) {
                        $(this).val(ui.item ? ui.item : " ");
                    },

                    change: function(event, ui) {
                        if (!ui.item) {
                            this.value = '';
                            alert('Ketik dan pilih dari daftar nama yang muncul');
                        } else {
                            // return your label here
                        }
                    }
                });



                $('#tempattugas_otvis').autocomplete({
                    source: "get_tempat_penugasan.php",
                    minLength: 2,
                    select: function(event, ui) {
                        return false;
                    },

                    select: function(event, ui) {
                        $(this).val(ui.item ? ui.item : " ");
                    },

                    change: function(event, ui) {
                        if (!ui.item) {
                            this.value = '';
                            $('#kd_tempattugas_otvis').val('');
                            alert('Ketik dan pilih dari daftar tempat yang muncul!!');
                        } else {
                            $('#kd_tempattugas_otvis').val(ui.item['id']); // return your label here
                        }
                    }
                });

                $('#tipevisa_otvis').change(function() {
                    var tipeVisa = $('#tipevisa_otvis option:selected').val();
                    if (tipeVisa == 1) {
                        $('#indeksvisa_otvis option#visadiplomatik').hide();
                        $('#indeksvisa_otvis option#visadinas').show();
                    } else {
                        $('#indeksvisa_otvis option#visadiplomatik').show();
                        $('#indeksvisa_otvis option#visadinas').hide();
                    }
                });

                $('#simpan_otvis').click(function() {

                    var nb1_o = $('#nobrafaks_otvis').val();
                    var pwk_o = $('#pwk_otvis').val();
                    var n1_o = $('#nama_otvis').val();
                    var kwn1_o = $('#kewarganegaraan_otvis').val();
                    var fu_o = $('#foto_upload').val();

                    var p1_o = $('#paspor_otvis').val();
                    var pu_o = $('#paspor_upload').val();
                    var tp1_o = $('#id_tipe_paspor').val();
                    var t1_o = $('#tujuan_otvis').val();
                    var po1_o = $('#posisi').val();
                    var pt1_o = $('#pengganti').val();
                    var tv1_o = $('#tipevisa_otvis').val();
                    var iv1_o = $('#indeksvisa_otvis').val();
                    var mt1_o = $('#masatugas_otvis').val();
                    var su1_o = $('#setneg_upload').val();
                    var tt1_o = $('#tempattugas_otvis').val();
                    var tt2_o = $('#kd_tempattugas_otvis').val();

                    var nnd1_o = $('#no_nota_diplomatik').val();
                    var nd1_o = $('#nota_diplomatik_upload').val();
                    //$sn1_o = $('#surat_nikah_upload').val();
                    var kl1_o = $('#keppri_legal_upload').val();

                    var k_o = $('#keppri').val();

                    var jk_o = $('#jbt_keppri').val();
                    var pk_o = $('#pjbt_konsuler').val();
                    //$sn1_o = $('#surat_nikah_upload').val();
                    var jpk_o = $('#jbt_konsuler').val();
                    var k99_o = $('input[name="verifikator"]').val();

                    var jk99_o = $('input[name="jbt_ver"]').val();
                    var pk99_o = $('input[name="legalisator"]').val();
                    var stat_mhn = $('#ID_JNS_KEPUTUSAN').val();

                    var stat_mhn_fam = $('#id_keputusan_fam').val();

                    var jpk99_o = $('input[name="jbt_legal"]').val();
                    var mat1_o = $('input[name="masa_awal_tugas"]').val();
                    var mat2_o = $('input[name="masa_akhir_tugas"]').val();
                    //alert($tp_o);false
                    if (nb1_o == '') {
                        alert('Nomor Brafaks tidak boleh kosong!');
                        return false;
                    } else if (pwk_o == '') {
                        alert('Perwakilan RI tidak boleh kosong!');
                        return false;
                    } else if (n1_o == '') {
                        alert('Nama Pemohon tidak boleh kosong!ss');
                        return false;
                    } else if (kwn1_o == 1) {
                        alert('Kewarganegaraan tidak boleh kosong!');
                        return false;
                    } else if (p1_o == '') {
                        alert('Nomor paspor tidak boleh kosong!');
                        return false;
                    } else if (tp1_o == '') {
                        alert('Jenis paspor tidak boleh kosong!');
                        return false;
                    } else if (t1_o == '') {
                        alert('Tujuan tidak boleh kosong!');
                        return false;
                    } else if (po1_o == '') {
                        alert('Posisi Pengajuan tidak boleh kosong!');
                        return false;

                    } else if (po1_o == 2) {
                        if (pt1_o == '') {
                            alert('Nama untuk yang digantikan tidak boleh kosong!');
                            return false;
                        }
                    } else if (mt1_o == '') {
                        alert('Masa tugas tidak boleh kosong!');
                        return false;
                    } else if (mat1_o >= mat2_o) {
                        alert('Tanggal awal tugas tidak boleh lebih besar atau sama dengan tanggal akhir tugas !');
                        return false;
                    } else if (tt1_o == '') {
                        alert('Tempat penugasan tidak boleh kosong!');
                        return false;
                    } else if (nnd1_o == '') {
                        alert('No Nota Diplomatik tidak boleh kosong!');
                        return false;
                    } else if (k99_o == '') {
                        alert('Nama Verifikator tidak boleh kosong!');
                        return false;
                    } else if (jk99_o == '') {
                        alert('Jabatan Verifikator tidak boleh kosong!');
                        return false;
                    } else if (pk99_o == '') {
                        alert('Nama Legalisator tidak boleh kosong!');
                        return false;
                    } else if (jpk99_o == '') {
                        alert('Jabatan Legalisator tidak boleh kosong!');
                        return false;
                    } else if (tv1_o == '') {
                        alert('Tipe visa tidak boleh kosong!');
                        return false;
                    } else if (iv1_o == '') {
                        alert('Indeks visa tidak boleh kosong!');
                        return false;
                    } else if (kl1_o == '') {
                        alert('Surat legalisasi Keppri harus di unggah!');
                        return false;
                    } else if (k_o == '') {
                        alert('Keppri tidak boleh kosong!');
                        return false;
                    } else if (jk_o == '') {
                        alert('Jabatan Keppri tidak boleh kosong!');
                        return false;
                    } else if (pk_o == '') {
                        alert('Pejabat Konsuler tidak boleh kosong!');
                        return false;
                    } else if (jpk_o == '') {
                        alert('Jabatan Pejabat Konsuler tidak boleh kosong!');
                        return false;
                    } else {
                        if (stat_mhn == 1) {
                            if (stat_mhn_fam == '') {
                                alert('Keputusan permohonan keluarga tidak boleh kosong!');
                                return false;
                            } else {
                                var tanya = confirm("Anda yakin isian sudah benar ?");
                                if (tanya == true) {
                                    return true;
                                } else {
                                    return false;
                                }
                            }

                        } else {
                            var tanya = confirm("Anda yakin isian sudah benar ?");
                            if (tanya == true) {
                                return true;
                            } else {
                                return false;
                            }
                        }

                    }
                });

                setInterval(function() {
                    // Immediately fade to opacity: 0 in 0ms
                    $("div.blink182").fadeTo(0, 0);
                    // Wait .75sec then fade to opacity: 1 in 0ms
                    setTimeout(function() {
                        $("div.blink182").fadeTo(0, 1);
                    }, 750);
                }, 2000);
                //});

                function ValidateFileUpload() {
                    var fuData = document.getElementById('foto_upload');
                    var FileUploadPath = fuData.value;

                    //To check if user upload any file
                    if (FileUploadPath == '') {
                        alert("File foto tidak boleh kosong");

                    } else {
                        var Extension = FileUploadPath.substring(
                            FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

                        if (Extension == "gif" || Extension == "bmp" ||
                            Extension == "jpeg" || Extension == "jpg") {

                        } else {
                            alert("File foto harus GIF, PNG, JPG, JPEG and BMP. ");
                        }
                    }
                }

                //Tambah Tim DAM
                $('#foto_upload').bind('change', function() {
                    var a = document.getElementById('foto_upload').value;
                    var ext = a.split('.');
                    ext = ext[ext.length - 1].toLowerCase();
                    var arrayExtensions = ['jpg', 'jpeg'];

                    if (this.files[0].size > 1044070) {
                        alert('ERROR: File terlalu besar, maksimal 1 mb');
                        document.getElementById('foto_upload').value = '';
                        $('#user_img').removeAttr('src');
                    }
                    if (arrayExtensions.lastIndexOf(ext) == -1) {
                        alert('ERROR: Jenis file harus .jpg atau .jpeg');
                        document.getElementById('foto_upload').value = '';
                        $('#user_img').removeAttr('src');
                    }

                });

                $('#foto_paspor_upload').bind('change', function() {
                    var a = document.getElementById('foto_paspor_upload').value;
                    var ext = a.split('.');
                    ext = ext[ext.length - 1].toLowerCase();
                    var arrayExtensions = ['jpg', 'jpeg'];

                    if (this.files[0].size > 1044070) {
                        alert('ERROR: File terlalu besar, maksimal 1 mb');
                        document.getElementById('foto_paspor_upload').value = '';
                        $('#paspor_img').removeAttr('src');
                    }

                    if (arrayExtensions.lastIndexOf(ext) == -1) {
                        alert('ERROR: Jenis file harus .jpg atau .jpeg');
                        document.getElementById('foto_paspor_upload').value = '';
                        $('#paspor_img').removeAttr('src');

                    }

                });

                $('#setneg_upload').bind('change', function() {
                    var a = document.getElementById('setneg_upload').value;
                    var ext = a.split('.');
                    ext = ext[ext.length - 1].toLowerCase();
                    var arrayExtensions = ['jpg', 'png', 'jpeg', 'pdf'];

                    if (this.files[0].size > 5000000) {
                        alert('ERROR: File terlalu besar, maksimal 5 mb');
                        document.getElementById('setneg_upload').value = '';
                    }

                    if (arrayExtensions.lastIndexOf(ext) == -1) {
                        alert('ERROR: Jenis file harus .jpg, .png, .jpeg atau .pdf');
                        document.getElementById('setneg_upload').value = '';

                    }

                });

                $('#nota_diplomatik_upload').bind('change', function() {
                    var a = document.getElementById('nota_diplomatik_upload').value;
                    var ext = a.split('.');
                    ext = ext[ext.length - 1].toLowerCase();
                    var arrayExtensions = ['jpg', 'pdf'];

                    if (this.files[0].size > 5000000) {
                        alert('ERROR: File terlalu besar, maksimal 5 mb');
                        document.getElementById('nota_diplomatik_upload').value = '';
                    }

                    if (arrayExtensions.lastIndexOf(ext) == -1) {
                        alert('ERROR: Jenis file harus .jpg atau .pdf');
                        document.getElementById('nota_diplomatik_upload').value = '';

                    }

                });
                //End Tim DAM

                $('#simpan_baru').click(function() {

                    var nb1_o = $('#nobrafaks_otvis').val();
                    var pwk_o = $('#pwk_otvis').val();
                    var n1_o = $('#nama_otvis').val();
                    var tgl1_o = $('#tgl_lahir_otvis').val();
                    var sex1_o = $('#jns_kelamin_otvis').val();
                    var kwn1_o = $('#kewarganegaraan_otvis').val();
                    var fu_o = $('#foto_upload').val();

                    var p1_o = $('#paspor_otvis').val();
                    var pu_o = $('#foto_paspor_upload').val();
                    var tp1_o = $('#id_tipe_paspor').val();
                    var pr1_o = $('#profesi_otvis').val(); // baru
                    var t1_o = $('#tujuan_otvis').val();
                    var po1_o = $('#posisi').val();
                    var pt1_o = $('#pengganti').val();
                    var tv1_o = $('#tipevisa_otvis').val();
                    var iv1_o = $('#indeksvisa_otvis').val();
                    var mt1_o = $('#masatugas_otvis').val();
                    var su1_o = $('#setneg_upload').val();
                    var tt1_o = $('#tempattugas_otvis').val();

                    var nnd1_o = $('#no_nota_diplomatik').val();
                    var nd1_o = $('#nota_diplomatik_upload').val();
                    //$sn1_o = $('#surat_nikah_upload').val();
                    var kl1_o = $('#keppri_legal_upload').val();

                    var k_o = $('#keppri').val();

                    var jk_o = $('#jbt_keppri').val();
                    var pk_o = $('#pjbt_konsuler').val();
                    //$sn1_o = $('#surat_nikah_upload').val();
                    var jpk_o = $('#jbt_konsuler').val();

                    var k99_o = $('input[name="verifikator"]').val();

                    var jk99_o = $('input[name="jbt_ver"]').val();
                    var pk99_o = $('input[name="legalisator"]').val();

                    var jpk99_o = $('input[name="jbt_legal"]').val();

                    var mat1_o = $('input[name="masa_awal_tugas"]').val();
                    var mat2_o = $('input[name="masa_akhir_tugas"]').val();
                    //alert($tp_o);false
                    if (nb1_o == '') {
                        alert('Nomor Brafaks tidak boleh kosong!');
                        return false;
                    } else if (pwk_o == '') {
                        alert('Perwakilan RI tidak boleh kosong!');
                        return false;
                    } else if (n1_o == '') {
                        alert('Nama Pemohon tidak boleh kosong!');
                        return false;
                    } else if (tgl1_o == '') {
                        alert('Tanggal lahir Pemohon tidak boleh kosong!');
                        return false;
                    } else if (sex1_o == '') {
                        alert('Jenis kelamin Pemohon tidak boleh kosong!');
                        return false;
                    } else if (kwn1_o == 1) {
                        alert('Kewarganegaraan tidak boleh kosong!');
                        return false;
                    } else if (fu_o == '') {
                        alert('File foto tidak boleh kosong!');
                        return false;
                    } else if (p1_o == '') {
                        alert('Nomor paspor tidak boleh kosong!');
                        return false;
                    } else if (pu_o == '') {
                        alert('File paspor tidak boleh kosong!');
                        return false;
                    } else if (tp1_o == '') {
                        alert('Jenis paspor tidak boleh kosong!');
                        return false;
                    } else if (pr1_o == '') {
                        alert('Profesi tidak boleh kosong!');
                        return false;
                    } else if (t1_o == '') {
                        alert('Tujuan tidak boleh kosong!');
                        return false;
                    } else if (po1_o == '') {
                        alert('Posisi Pengajuan tidak boleh kosong!');
                        return false;
                    } else if (po1_o == 2 || po1_o == 5) {
                        if (pt1_o == '') {
                            alert('Nama Pejabat tidak boleh kosong!');
                            return false;
                        }
                    } else if (mt1_o == '') {
                        alert('Masa tugas tidak boleh kosong!');
                        return false;
                    } else if (mat1_o >= mat2_o) {
                        alert('Tanggal awal tugas tidak boleh lebih besar atau sama dengan tanggal akhir tugas !');
                        return false;
                    } else if (tt1_o == '') {
                        alert('Tempat penugasan tidak boleh kosong!');
                        return false;
                    } else if (nnd1_o == '') {
                        alert('No Nota Diplomatik tidak boleh kosong!');
                        return false;
                    } else if (nd1_o == '') {
                        alert('Nota diplomatik harus di unggah!');
                        return false;
                    } else if (k99_o == '') {
                        alert('Nama Verifikator tidak boleh kosong!');
                        return false;
                    } else if (jk99_o == '') {
                        alert('Jabatan Verifikator tidak boleh kosong!');
                        return false;
                    } else if (pk99_o == '') {
                        alert('Nama Legalisator tidak boleh kosong!');
                        return false;
                    } else if (jpk99_o == '') {
                        alert('Jabatan Legalisator tidak boleh kosong!');
                        return false;
                    } else if (tv1_o == '') {
                        alert('Tipe visa tidak boleh kosong!');
                        return false;
                    } else if (iv1_o == '') {
                        alert('Indeks visa tidak boleh kosong!');
                        return false;
                    } else if (kl1_o == '') {
                        alert('Surat legalisasi Keppri harus di unggah!');
                        return false;
                    } else if (k_o == '') {
                        alert('Keppri tidak boleh kosong!');
                        return false;
                    } else if (jk_o == '') {
                        alert('Jabatan Keppri tidak boleh kosong!');
                        return false;
                    } else if (pk_o == '') {
                        alert('Pejabat Konsuler tidak boleh kosong!');
                        return false;
                    } else if (jpk_o == '') {
                        alert('Jabatan Pejabat Konsuler tidak boleh kosong!');
                        return false;
                    } else {
                        var tanya = confirm("Anda yakin isian sudah benar ?");
                        if (tanya == true) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                });


                $('#popupBoxClose').click(function() {
                    unloadPopupBox();
                });

                $('#container').click(function() {
                    unloadPopupBox();
                });
            });



            function validate_photo(input) {
                var validExtensions = ['jpg', 'jpeg']; //array of valid extensions
                var fileName = input.files[0].name;
                var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();
                //alert();
                if ($.inArray(fileNameExt, validExtensions) == -1) {
                    input.type = ''
                    input.type = 'file'

                    $('#user_img').attr('src', '');

                    alert("Only these file types are accepted : " + validExtensions.join(', '));
                } else {
                    if (input.files && input.files[0]) {
                        var filerdr = new FileReader();
                        filerdr.onload = function(e) {
                            $('#user_img').attr('src', e.target.result);
                        }
                        filerdr.readAsDataURL(input.files[0]);
                    }
                }
            }

            function validate_docdll(input) {
                var validExtensions = ['jpg', 'png', 'jpeg', 'pdf']; //array of valid extensions
                var fileName = input.files[0].name;
                var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();
                if ($.inArray(fileNameExt, validExtensions) == -1) {
                    input.type = ''
                    input.type = 'file'
                    alert("Only these file types are accepted : " + validExtensions.join(', '));
                } else {
                    if (input.files && input.files[0]) {
                        var filerdr = new FileReader();
                        filerdr.onload = function(e) { }
                        filerdr.readAsDataURL(input.files[0]);
                    }
                }
            }

            function validate_photo2(input) {
                var validExtensions = ['jpg', 'jpeg']; //array of valid extensions
                var fileName = input.files[0].name;
                var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();
                if ($.inArray(fileNameExt, validExtensions) == -1) {
                    input.type = ''
                    input.type = 'file'
                    $('#user_img').attr('src', '');

                    alert("Only these file types are accepted : " + validExtensions.join(', '));
                } else {
                    if (input.files && input.files[0]) {
                        var filerdr = new FileReader();
                        filerdr.onload = function(e) {
                            $('#user_img').attr('src', e.target.result);
                        }
                        filerdr.readAsDataURL(input.files[0]);
                    }
                }
            }

            function validate_paspor(input) {
                var validExtensions = ['jpg', 'jpeg']; //array of valid extensions
                var fileName = input.files[0].name;
                var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();
                if ($.inArray(fileNameExt, validExtensions) == -1) {
                    input.type = ''
                    input.type = 'file'
                    $('#paspor_img').attr('src', '');

                    alert("Only these file types are accepted : " + validExtensions.join(', '));
                } else {
                    if (input.files && input.files[0]) {
                        var filerdr = new FileReader();
                        filerdr.onload = function(e) {
                            $('#paspor_img').attr('src', e.target.result);
                        }
                        filerdr.readAsDataURL(input.files[0]);
                    }
                }
            }

            function validate_fam(input) {
                var validExtensions = ['jpg', 'jpeg']; //array of valid extensions
                var fileName = input.files[0].name;
                var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();
                if ($.inArray(fileNameExt, validExtensions) == -1) {
                    input.type = ''
                    input.type = 'file'
                    alert("Only these file types are accepted : " + validExtensions.join(', '));
                } else {
                    if (input.files && input.files[0]) {
                        var filerdr = new FileReader();
                        filerdr.onload = function(e) {}
                        filerdr.readAsDataURL(input.files[0]);
                    }
                }
            }
            jQuery(function($) {

                $('.remove-me1').click(function(e) {
                    e.preventDefault();
                    var fieldNum = this.id;
                    var rowId = "#rowIdx" + fieldNum;
                    var inputId = ".inputIdx" + fieldNum;
                    var noId = ".x" + fieldNum;
                    $(rowId).remove();
                    $(inputId).remove();
                    $(noId).remove();
                });

                $('.remove-me2').click(function(e) {
                    e.preventDefault();
                    var fieldNum = this.id;
                    var rowId = "#rowIdy" + fieldNum;
                    var inputId = ".inputIdy" + fieldNum;
                    var noId = ".y" + fieldNum;
                    $(rowId).remove();
                    $(inputId).remove();
                    $(noId).remove();
                });

                $('.remove-me4').click(function(e) {
                    e.preventDefault();
                    var fieldNum = this.id;
                    var rowId = "#rowIdw" + fieldNum;
                    var inputId = ".inputIdw" + fieldNum;
                    var noId = ".w" + fieldNum;
                    $(rowId).remove();
                    $(inputId).remove();
                    $(noId).remove();
                });

                var next = 1;
                $('input[name="tambah_minta_visa"]').click(function() {
                    $('#dasarMintaVisaResultList tr:last').after('<tr id="rowId' + next + '"><td></td><td>' + next + '. <input size=50 class="inputId' + next + '" id="inputmintavisa" type="text" name="dasar_mintavisa[' + next + '][dasarmintavisa]"><span id="' + next + '" class="btn btn-danger remove-me" value="' + next + '" ><input type="button" value="x"></span></td></tr>');

                    $('#dasarMintaVisaResultList1 tr:last').after('<tr id="rowId' + next + '"><td class="inputId' + next + '"></td><td class="inputId' + next + '"></td><td class="inputId' + next + '">' + next + '. <input size=50 readonly class="inputId' + next + '" id="inputmintavisa' + next + '" type="text"  name="dasar_mintavisa1[' + next + '][dasarmintavisa]"></td></tr>');

                    next = next + 1;
                    $('.remove-me').click(function(e) {
                        e.preventDefault();
                        var fieldNum = this.id;
                        var rowId = "#rowId" + fieldNum;
                        var inputId = ".inputId" + fieldNum;
                        $(rowId).remove();
                        $(inputId).remove();
                    });

                    $('input#inputmintavisa').change(function() {
                        var a = $('#inputmintavisa').val();
                        $('#inputmintavisa').val(a);
                        var c;
                        for (c = 1; c <= next - 2; c++) {
                            $('#inputmintavisa' + c).val(a);
                        }
                    });
                });

                <?php
                include "../config/koneksi.php";
                $sql_fam = "select * from tbl_ref_relasi_fam";
                $tampil_relasifam = mysql_query($sql_fam);

                $sql_jns_paspor = "select * from tbl_jns_paspor";
                $tampil_pasporfam = mysql_query($sql_jns_paspor);

                $sql_WN = "select * from m_negara";
                $tampil_wn = mysql_query($sql_WN);
                ?>

                var next4 = 1;
                $('input[name="tambah_anggota_fam"]').click(function() {
                    $('#anggotaFamResultList tr:last').after('<tr id="rowIdg' + next4 + '"><td></td><td width="10px;">' + next4 + '.</td><td width="50px;"> Nama &nbsp;&nbsp;<td> : &nbsp;<input size=25 class="inputIdg' + next4 + '" type="text"  id="inputanggotafam_nama" name="anggota_fam[' + next4 + '][anggotafam_nama]"><span id="' + next4 + '" class="btn btn-danger remove-me4" value="' + next4 + '" ><input type="button" value="x"></span> </td></tr><tr id="rowIdj' + next4 + '"><td></td><td width="10px;"></td><td> Tgl Lahir </td><td>: <input  type="text" id="inputanggotafam_tgllahir" name="anggota_fam[' + next4 + '][anggotafam_tgllahir]"  class="TGL_LAHIR" ></td></tr><tr id="rowIdj' + next4 + '"><td></td><td width="10px;"></td><td> Jenis Kelamin</td><td>: <select name="anggota_fam[' + next4 + '][anggotafam_jnskelamin]" id="inputanggotafam_jnskelamin"><option value="">- Silahkan Pilih -</option><option value="MALE">Laki-laki</option><option value="FEMALE">Perempuan</option></select></td></tr><tr id="rowIdh' + next4 + '"><td></td><td width="10px;"></td><td> Kewarganegaraan </td><td>: <select class="inputIdg' + next4 + '" name="anggota_fam[' + next4 + '][anggotafam_kewarganegaraan]" id="inputanggotafam_kewarganegaraan"><option>- Silahkan Pilih -</option><?php while ($val = mysql_fetch_array($tampil_wn)) { ?><option value="<?php echo $val[ID_NEGARA]; ?>"><?php echo $val[NEGARA]; ?></option><?php } ?></select>  </td></tr><tr id="rowIdhh' + next4 + '"><td></td><td width="10px;"></td><td> Foto </td><td>: &nbsp;<input size=25 class="inputIdg' + next4 + '" type="file"  id="inputanggotafam_foto" name="userfile[' + next4 + '][anggotafam_foto]" /><ul><li>Pas Photo terbaru (3 bulan terakhir).</li><li>Warna latar pas photo berwarna putih.</li><li>Wajah pada pas photo melihat lurus ke arah kamera.</li><li>Pas photo merupakan close up dari kepala dan bahu sehingga memenuhi 80% dari seluruh photo.</li><li>Mata harus terbuka dan terlihat jelas.</li><li>Tidak ada bagian kepala yang terpotong dan wajah tidak boleh tertutupi ornamen.</li><li>File foto yang diizinkan hanya dalam bentuk .jpg.</li></ul></td></tr><tr id="rowIdi' + next4 + '"><td></td><td width="10px;"></td><td> Relasi <td>: <select class="inputIdg' + next4 + '" name="anggota_fam[' + next4 + '][anggotafam_relasi]" id="inputanggotafam_relasi"><option>- Silahkan Pilih -</option><?php while ($val = mysql_fetch_array($tampil_relasifam)) { ?><option value="<?php echo $val[id]; ?>"><?php echo $val[relasi]; ?></option><?php } ?></select>  </td></tr><tr id="rowIdD' + next16 + '"><td></td><td width="10px;"></td><td> Dokumen </td><td>: &nbsp;<input size=25 class="inputIdg' + next16 + '" type="file"  id="inputanggotafam_dokumen" name="userfile[' + next16 + '][anggotafam_dokumen]" /><ul><li>Untuk Spouse dokumen berupa Akta Nikah</li><li>Untuk Anak dokumen berupa Akta Kelahiran</li><li>Untuk Orang Tua dokumen berupa Nota Diplomatik</li><li>Untuk Saudara dokumen berupa Nota Diplomatik</li><li>Untuk Staf Bawaan dokumen berupa Nota Diplomatik</li></ul></td></tr><tr id="rowIdj' + next4 + '"><td></td><td width="10px;"></td><td> Paspor </td><td>: <input size=25 class="inputIdg' + next4 + '" type="text"  id="inputanggotafam_nopaspor" name="anggota_fam[' + next4 + '][anggotafam_nopaspor]"></td></tr><tr id="rowIdj' + next16 + '"><td></td><td width="10px;"></td><td> Jenis Paspor </td><td>: <select class="inputIdg' + next16 + '" name="anggota_fam[' + next16 + '][anggotafam_jns_paspor]" id="inputanggotafam_jns_paspor"><option>- Silahkan Pilih -</option><?php while ($val = mysql_fetch_array($tampil_pasporfam))  { ?><option value="<?php echo $val[id]; ?>"><?php echo $val[jns_paspor]; ?></option><?php } ?></select></td></tr><tr id="rowIdk' + next4 + '"><td></td><td width="10px;"></td><td></td><td> &nbsp;&nbsp;<input size=25 class="inputIdg' + next4 + '" type="file"  id="inputanggotafam_foto_paspor" name="userfile[' + next4 + '][anggotafam_foto_paspor]" onchange="validate_docdll(this)"></td></tr>');
                    $(".TGL_LAHIR").datepicker({
                        dateFormat: 'yy-mm-dd'
                    });
                    if (next4 == 1) {
                        $('#anggotaFamResultList1 tr:last').after('<tr id="rowIds' + next4 + '"><td width=30%>Dasar Pemberian Visa</td>     <td width=6> : </td><td class="inputIds' + next4 + '">' + next4 + '. <input readonly size=50 class="inputIds' + next4 + '" type="text"  value="" name="dasar_anggotafam1[' + next4 + '][dasaranggotafam]"></td></tr>');

                    } else {
                        $('#anggotaFamResultList1 tr:last').after('<tr id="rowIds' + next4 + '"><td class="inputIds' + next4 + '"></td><td class="inputIds' + next4 + '"></td><td class="inputIds' + next4 + '">' + next4 + '. <input readonly size=50 class="inputIds' + next4 + '" type="text"  value="" name="dasar_anggotafam1[' + next4 + '][dasaranggotafam]"></td></tr>');

                    }

                    next4 = next4 + 1;
                    $('.remove-me4').click(function(e) {
                        e.preventDefault();
                        var fieldNum = this.id;

                        var rowIdg = "#rowIdg" + fieldNum;
                        var inputIdg = ".inputIdg" + fieldNum;
                        var rowIdh = "#rowIdh" + fieldNum;
                        var rowIdhh = "#rowIdhh" + fieldNum;
                        var rowIdi = "#rowIdi" + fieldNum;
                        var rowIdj = "#rowIdj" + fieldNum;
                        var rowIdk = "#rowIdk" + fieldNum;

                        $(rowIdg).remove();
                        $(inputIdg).remove();
                        $(rowIdh).remove();
                        $(rowIdhh).remove();
                        $(rowIdi).remove();
                        $(rowIdj).remove();
                        $(rowIdk).remove();
                    });

                    $('input#inputanggotafam').change(function() {
                        var b = $('#inputanggotafam').val();
                        $('#inputanggotafam').val(b);
                    });

                    $('input#relasi_diplomat').autocomplete({
                        source: "get_diplomat.php",
                        minLength: 2,
                        select: function(event, ui) {
                            return false;
                        },

                        select: function(event, ui) {
                            $(this).val(ui.item ? ui.item : " ");
                        },

                        change: function(event, ui) {
                            if (!ui.item) {
                                this.value = '';
                                alert('Ketik dan pilih dari daftar nama yang muncul');
                            } else {
                                // return your label here
                            }
                        }
                    });

                });

                var jml_fam_exists = $('#inputanggotafam_jml_fam_ex').val();
                if (jml_fam_exists == null) {
                    var next16 = 1;
                } else {
                    var next16 = 1 + parseInt(jml_fam_exists);
                }

                <?php
                include "../config/koneksi.php";
                $sql_fam = "select * from tbl_ref_relasi_fam";
                $tampil_relasifam = mysql_query($sql_fam);

                $sql_jns_paspor = "select * from tbl_jns_paspor";
                $tampil_pasporfam = mysql_query($sql_jns_paspor);

                $sql_WN = "select * from m_negara";
                $tampil_wn = mysql_query($sql_WN);
                //$list_fam = mysql_fetch_array($tampil_fam);
                ?>

                $('input[name="sunting_tambah_anggota_fam"]').click(function() {

                    $('#anggotaFamResultList tr:last').after('<tr id="rowIdg' + next16 + '"><td></td><td width="10px;">' + next16 + '.</td><td width="50px;"> Nama &nbsp;&nbsp;<td> : &nbsp;<input size=25 class="inputIdg' + next16 + '" type="text"  id="inputanggotafam_nama" name="anggota_fam[' + next16 + '][anggotafam_nama]"><span id="' + next16 + '" class="btn btn-danger remove-me16" value="' + next16 + '" ><input type="button" value="x"></span> </td></tr><tr id="rowIdj' + next16 + '"><td></td><td width="10px;"></td><td> Tgl Lahir </td><td>: <input  type="text" id="inputanggotafam_tgllahir" name="anggota_fam[' + next16 + '][anggotafam_tgllahir]"  class="TGL_LAHIR" ></td></tr><tr id="rowIdj' + next16 + '"><td></td><td width="10px;"></td><td> Jenis Kelamin</td><td>: <select name="anggota_fam[' + next16 + '][anggotafam_jnskelamin]" id="inputanggotafam_jnskelamin"><option value="">- Silahkan Pilih -</option><option value="MALE">Laki-laki</option><option value="FEMALE">Perempuan</option></select></td></tr><tr id="rowIdh' + next16 + '"><td></td><td width="10px;"></td><td> Kewarganegaraan </td><td>: <select class="inputIdg' + next16 + '" name="anggota_fam[' + next16 + '][anggotafam_kewarganegaraan]" id="inputanggotafam_kewarganegaraan"><option>- Silahkan Pilih -</option><?php while ($val = mysql_fetch_array($tampil_wn)) { ?><option value="<?php echo $val[ID_NEGARA]; ?>"><?php echo $val[NEGARA]; ?></option><?php } ?></select>  </td></tr><tr id="rowIdhh' + next16 + '"><td></td><td width="10px;"></td><td> Foto </td><td>: &nbsp;<input size=25 class="inputIdg' + next16 + '" type="file"  id="inputanggotafam_foto" name="userfile[' + next16 + '][anggotafam_foto]" /><ul><li>Pas Photo terbaru (3 bulan terakhir).</li><li>Warna latar pas photo berwarna putih.</li><li>Wajah pada pas photo melihat lurus ke arah kamera.</li><li>Pas photo merupakan close up dari kepala dan bahu sehingga memenuhi 80% dari seluruh photo.</li><li>Mata harus terbuka dan terlihat jelas.</li><li>Tidak ada bagian kepala yang terpotong dan wajah tidak boleh tertutupi ornamen.</li><li>File foto yang diizinkan hanya dalam bentuk .jpg.</li></ul></td></tr><tr id="rowIdi' + next16 + '"><td></td><td width="10px;"></td><td> Relasi <td>: <select class="inputIdg' + next16 + '" name="anggota_fam[' + next16 + '][anggotafam_relasi]" id="inputanggotafam_relasi"><option>- Silahkan Pilih -</option><?php while ($val = mysql_fetch_array($tampil_relasifam)) { ?><option value="<?php echo $val[id]; ?>"><?php echo $val[relasi]; ?></option><?php } ?></select>  </td></tr><tr id="rowIdD' + next16 + '"><td></td><td width="10px;"></td><td> Dokumen </td><td>: &nbsp;<input size=25 class="inputIdg' + next16 + '" type="file"  id="inputanggotafam_dokumen" name="userfile[' + next16 + '][anggotafam_dokumen]" /><ul><li>Untuk Spouse dokumen berupa Akta Nikah</li><li>Untuk Anak dokumen berupa Akta Kelahiran</li><li>Untuk Orang Tua dokumen berupa Nota Diplomatik</li><li>Untuk Saudara dokumen berupa Nota Diplomatik</li><li>Untuk Staf Bawaan dokumen berupa Nota Diplomatik</li></ul></td></tr><tr id="rowIdj' + next16 + '"><td></td><td width="10px;"></td><td> Paspor </td><td>: <input size=25 class="inputIdg' + next16 + '" type="text"  id="inputanggotafam_nopaspor" name="anggota_fam[' + next16 + '][anggotafam_nopaspor]"></td></tr><tr id="rowIdj' + next16 + '"><td></td><td width="10px;"></td><td> Jenis Paspor </td><td>: <select class="inputIdg' + next16 + '" name="anggota_fam[' + next16 + '][anggotafam_jns_paspor]" id="inputanggotafam_jns_paspor"><option>- Silahkan Pilih -</option><?php while ($val = mysql_fetch_array($tampil_pasporfam))  { ?><option value="<?php echo $val[id]; ?>"><?php echo $val[jns_paspor]; ?></option><?php } ?></select></td></tr><tr id="rowIdk' + next16 + '"><td></td><td width="10px;"></td><td></td><td> &nbsp;&nbsp;<input size=25 class="inputIdg' + next16 + '" type="file"  id="inputanggotafam_foto_paspor" name="userfile[' + next16 + '][anggotafam_foto_paspor]" onchange="validate_docdll(this)"></td></tr>');
                    $(".TGL_LAHIR").datepicker({
                        dateFormat: 'yy-mm-dd'
                    });

                    next16 = next16 + 1;
                    $('.remove-me16').click(function(e) {
                        e.preventDefault();
                        var fieldNum = this.id;
                        var rowIdg = "#rowIdg" + fieldNum;
                        var inputIdg = ".inputIdg" + fieldNum;
                        var rowIdh = "#rowIdh" + fieldNum;
                        var rowIdhh = "#rowIdhh" + fieldNum;
                        var rowIdi = "#rowIdi" + fieldNum;
                        var rowIdj = "#rowIdj" + fieldNum;
                        var rowIdk = "#rowIdk" + fieldNum;

                        $(rowIdg).remove();
                        $(inputIdg).remove();
                        $(rowIdh).remove();
                        $(rowIdhh).remove();
                        $(rowIdi).remove();
                        $(rowIdj).remove();
                        $(rowIdk).remove();
                    });
                });

                var next1 = 1;
                $('input[name="tambah_beri_visa"]').click(function() {
                    $('#dasarBeriVisaResultList tr:last').after('<tr id="rowIdb' + next1 + '"><td></td><td>' + next1 + '. <input size=50 class="inputIdb' + next1 + '" type="text"  id="inputberivisa" name="dasar_berivisa[' + next1 + '][dasarberivisa]"><span id="' + next1 + '" class="btn btn-danger remove-me1" value="' + next1 + '" ><input type="button" value="x"></span></td></tr>');
                    if (next1 == 1) {
                        $('#dasarBeriVisaResultList1 tr:last').after('<tr id="rowIdb' + next1 + '"><td width=30%>Dasar Pemberian Visa</td>     <td width=6> : </td><td class="inputIdb' + next1 + '">' + next1 + '. <input readonly size=50 class="inputIdb' + next1 + '" type="text"  value="" name="dasar_berivisa1[' + next1 + '][dasarberivisa]"></td></tr>');
                    } else {
                        $('#dasarBeriVisaResultList1 tr:last').after('<tr id="rowIdb' + next1 + '"><td class="inputIdb' + next1 + '"></td><td class="inputIdb' + next1 + '"></td><td class="inputIdb' + next1 + '">' + next1 + '. <input readonly size=50 class="inputIdb' + next1 + '" type="text"  value="" name="dasar_berivisa1[' + next1 + '][dasarberivisa]"></td></tr>');
                    }

                    next1 = next1 + 1;
                    $('.remove-me1').click(function(e) {
                        e.preventDefault();
                        var fieldNum = this.id;
                        var rowIdb = "#rowIdb" + fieldNum;
                        var inputIdb = ".inputIdb" + fieldNum;
                        $(rowIdb).remove();
                        $(inputIdb).remove();
                    });
                    $('input#inputberivisa').change(function() {
                        var b = $('#inputberivisa').val();
                        $('#inputberivisa').val(b);
                        //alert(a);
                    });

                });


            });

            $(document).ready(function() {
                $('#print').click(function() {
                    var input_nama = $('#nama_otvis').val();
                    var input_nopaspor = $('#paspor_otvis').val();
                    get_val_otvis(input_nama, input_nopaspor);
                });

                function get_val_otvis(nama, no_paspor) {
                    //use ajax to run the check
                    var g;
                    $.post('report2.otvis.php', {
                            nama: nama,
                            no_paspor: no_paspor
                        },
                        function(result) {
                            g = result;
                            var win = window.open('report2.otvis.php', '_blank', 'width=400,height=400,scrollbars=1');
                            win.focus();
                        });
                }
            });

            function checkBox(kd, j) {
                $('#txt_box' + j).val(kd);
                if (kd == 0)
                    txt = "<div style='color:red;'>Reject</div>";
                if (kd == 1)
                    txt = "<div style='color : #B1BF19;'>Waiting</div>";
                if (kd == 2)
                    txt = "<div style='color:green;'>Approve</div>";

                $('#status' + j).html(txt);
            }

            function updateAction(kd, id, jns, kd_permit) {
                $.post("aksi_approval_json.php", {
                        status: $("#txt_box" + id).val(),
                        id: kd,
                        jns_approval: jns,
                        jns_permit: kd_permit
                    },
                    function(data, status) {
                        if (status == 'success') {
                            //alert (data);
                            alert('Berhasil memproses data!');
                            document.location.reload(true);
                        }
                    }
                );
            }

            function updateEpo(kd, id, jns, kd_permit) {
                $.post("aksi_approval_epo.php", {
                        status: $("#txt_box" + id).val(),
                        id: kd,
                        jns_approval: jns,
                        jns_permit: kd_permit
                    },
                    function(data, status) {
                        if (status == 'success') {
                            //alert (data);
                            alert('Berhasil memproses data!');
                            document.location.reload(true);
                        }
                    }
                );
            }

            function unloadPopupBox(i) { // TO Unload the Popupbox
                $('#popup_box' + i).fadeOut("slow");
                $("#container").css({ // this is just for style
                    "opacity": "1"
                });
            }

            function loadPopupBox(i) { // To Load the Popupbox
                $('#popup_box' + i).fadeIn("slow");
                //$('#txt_box'+i).val(j);
                $("#container").css({ // this is just for style
                    "opacity": "0.3"
                });
            }

            function loadPopupBox2(i, nokonsep) { // To Load the Popupbox
                $('#popup_box' + i).fadeIn("slow");
                //$('#txt_box'+i).val(j);
                $("#container").css({ // this is just for style
                    "opacity": "0.3"
                });
                //console.log(nokonsep);
                var nama, no_paspor, pwk_ri;
                //var no_paspor;
                $.post('detail_visa.php', {
                        nk: nokonsep
                    },
                    function(result) {
                        obj = JSON.parse(result);
                        //$("div#nama_pre").text(obj.nama);
                        $("div#nobra_pre").text(obj.no_bra);
                        $("div#pwkri_pre").text(obj.pwk_ri);
                        $("div#nama_pre").text(obj.nama);
                        $("div#fam_pre").text(obj.urutan);
                        $("div#nopaspor_pre").text(obj.paspor);
                        $("div#tpvisa_pre").text(obj.tipe_visa);
                        $("div#jns_paspor_pre").text(obj.jns_paspor);
                        $("div#tujuan_pre").text(obj.tujuan);
                        $("div#indeksvisa_pre").text(obj.indeks_visa);
                        $("div#masa_tugas_pre").text(obj.masa_tugas + ' Hari');
                        $("div#ver_pre").text(obj.ver);
                        $("div#jabver_pre").text(obj.jab_ver);
                        $("div#leg_pre").text(obj.legal);
                        $("div#jableg_pre").text(obj.jab_legal);
                        $("div#cat_pre").text(obj.catatan);
                        $("div#stmhn_pre").text(obj.st_mhn);
                    });

            }

            function loadPopupBox1(i) { // To Load the Popupbox
                $('#popup_box' + i).fadeIn("slow");
                $("#container").css({ // this is just for style
                    "opacity": "0.3"
                });
                var pwk = $("#pwk_otvis option:selected").text();
                var nama = $("#nama_otvis").val();
                var nopaspor = $("#paspor_otvis").val();
                var anggota_fam = $("textarea#anggota_fam").val();
                var jns_paspor = $("#id_tipe_paspor option:selected").text();
                var tujuan_otvis = $("#tujuan_otvis").val();
                var indeksvisa_otvis = $("#indeksvisa_otvis option:selected").text();
                var masatugas_otvis = $("#masatugas_otvis").val();

                $("div#pwkri_pre").text(pwk);
                $("div#nama_pre").text(nama);
                $("div#nopaspor_pre").text(nopaspor);
                $("div#anggota_fam_pre").text(anggota_fam);
                $("div#jns_paspor_pre").text(jns_paspor);
                $("div#tujuan_pre").text(tujuan_otvis);
                $("div#indeksvisa_pre").text(indeksvisa_otvis);
                $("div#masa_tugas_pre").text(masatugas_otvis);
            }

            //mrs
            function loadPopupBoxMiras(i, kd2, j, nt_pengajuan, nt_jawaban, ket, status, triwulan, tahun, tgl_pengajuan, tgl_jawaban, jml_spirit, jml_anggur, jml_rokok, lokasi_aju, nama_aju, tipe_fl_aju, lokasi_jwb, nama_jwb, tipe_fl_jwb, nm) { // To Load the Popupbox
                $('#popup_box' + i).fadeIn("fast");
                $("#container").css({ // this is just for style
                    "opacity": "0.3"
                });
                var a = j;
                var b = nt_pengajuan;
                var c = nt_jawaban;
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
                var q = nama_aju + '.' + tipe_fl_aju;
                var r = lokasi_jwb;
                var s = nama_jwb + '.' + tipe_fl_jwb;
                var t = nm;

                document.getElementById("kd").value = a;
                document.getElementById("kd1").value = o;
                document.getElementById("nota_pengajuan").value = b;
                document.getElementById("not_jawaban").value = c;
                document.getElementById("keterangan").value = d;
                if (e == 'Setuju') {
                    document.getElementById("st_aju").checked = true;
                    document.getElementById("sts_pengajuan").checked = false;
                } else {
                    document.getElementById("sts_pengajuan").checked = true;
                    document.getElementById("st_aju").checked = false;
                }

                document.getElementById("trw").value = f;

                document.getElementById("thn").value = g;

                document.getElementById("tgl_pengajuan").value = h;
                document.getElementById("datepicker1").value = k;
                document.getElementById("spirit1").value = l;
                document.getElementById("anggur1").value = m;
                document.getElementById("rokok1").value = n;
                var link_aju = q.link(p);
                document.getElementById("fl_aju").innerHTML = link_aju;
                document.getElementById("fl_aju_hd").value = q;
                var link_jwb = s.link(r);
                document.getElementById("fl_jwb").innerHTML = link_jwb;
                document.getElementById("fl_jwb_hd").value = s;
                //document.getElementById("nota_pengajuan").value=r;
                //document.getElementById("not_jawaban").value=s;
                $("#datepicker1").datepicker({
                    dateFormat: 'yy-mm-dd'
                });
                $("#tgl_pengajuan").datepicker({
                    dateFormat: 'yy-mm-dd'
                });
                document.getElementById("nm_edt").innerHTML = t;


            }

            function loadPopupBoxVisa(i, kd, id_negara, nm_negara, deskripsi, sumber, nomor_dok, lokasi_dok, nm_file, sts_aktif) { // To Load the Popupbox
                $('#popup_box' + i).fadeIn("fast");
                $("#container").css({ // this is just for style
                    "opacity": "0.3"
                });
                var kd = kd;
                var id_negara = id_negara;
                var nm_negara = nm_negara;
                var deskripsi = deskripsi;
                var sumber = sumber;
                var nomor_dok = nomor_dok;
                var lokasi_dok = lokasi_dok;
                var nm_file = nm_file;

                document.getElementById("id").value = kd;
                document.getElementById("negara_edt").value = id_negara + '@@' + nm_negara;
                document.getElementById("sts_aktif").value = sts_aktif;
                document.getElementById("sumber_edt").value = sumber;
                document.getElementById("deskripsi_edt").value = deskripsi;

                var link_jwb = nm_file.link(lokasi_dok);
                document.getElementById("fl_dok").innerHTML = link_jwb;
                document.getElementById("fl_aju_hd").value = nm_file;

            }

            function loadPopupViewVisa(i, as, tgl_input, usr_input, nm_negara, desk_info, sumber_info, no_dok, nm_file, tgl_edit, usr_edt, idts, lokasi_doks) { // To Load the Popupbox
                $('#popup_box' + i).fadeIn("fast");
                $("#container").css({ // this is just for style
                    "opacity": "0.3"
                });

                var jArray = nm_negara;
                document.getElementById("negara_view").value = jArray[0];
                document.getElementById("deskripsi_view").value = '';
                document.getElementById("fl_dok1").innerHTML = '';
                for (var i = 0; i < as.length; i++) {

                    document.getElementById("deskripsi_view").value += "ID:" + idts[i] + ("\n");
                    document.getElementById("deskripsi_view").value += "Tgl. Input:" + tgl_input[i] + ", User Input:" + usr_input[i] + ("\n");
                    if (tgl_edit[i] !== 'null') {
                        document.getElementById("deskripsi_view").value += "Tgl. Edit:" + tgl_edit[i] + ", User Edit:" + usr_edt[i] + ("\n");
                    }
                    document.getElementById("deskripsi_view").value += "Sumber Info:" + sumber_info[i] + ("\n");
                    document.getElementById("deskripsi_view").value += "Deskripsi:" + desk_info[i].replace(/\r\n|\r|\n/g, '') + ("\n");
                    document.getElementById("deskripsi_view").value += "-----------------------------------" + ("\n");
                    if (no_dok[i].length === 2) {
                        document.getElementById("fl_dok1").innerHTML += " | " + "ID" + idts[i] + "Tidak ada file";
                    } else {
                        document.getElementById("fl_dok1").innerHTML += " | " + "ID" + idts[i] + no_dok[i].link(lokasi_doks[i].replace(/"/g, ''));
                    }
                }
            }

            function tmp_cari() {
                var a = document.getElementById("cr_pengajuan").value;
                document.getElementById("cr").value = a;
            }

            function unloadPopupBox1(i) { // TO Unload the Popupbox
                $('#popup_box' + i).fadeOut("slow");
                $("#container").css({ // this is just for style
                    "opacity": "1"
                });
            }

            function unloadPopupBox2(i) { // TO Unload the Popupbox
                $('#popup_box' + i).fadeOut("fast");
                $("#container").css({ // this is just for style
                    "opacity": "1"
                });
            }

            function unloadPopupBox2Visa(i) { // TO Unload the Popupbox
                $('#popup_box' + i).fadeOut("fast");
                $("#container").css({ // this is just for style
                    "opacity": "1"
                });
            }

            /**********************************************************/

            //});
        </script>
    </head>

    <body onload="MM_preloadImages('../images/icon/Icon - Personal BLOCK.gif', '../images/icon/Icon - Permit BLOCK.gif', '../images/icon/Icon - ID Card BLOCK.gif', '../images/icon/Icon - Rantor Individu BLOCK.gif', '../images/icon/Icon - Rantor kantor BLOCK.gif', '../images/icon/Icon - Fasilitas BLOCK.gif', '../images/icon/Icon - EPO BLOCK.gif')">
        <div id="container">
            <!-- Main Page -->
        </div>
        <table width="90%" align="center" cellpadding="0" cellspacing="0" id="frameutama">
            <tr>
                <!-- <td colspan="2"><img src="../images/header2.png" alt="head" width="980" height="80" /></td>-->
                <td colspan="2"><img src="../images/header_new.jpg" alt="head" width="100%" /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php

                    function getChildMmenu($parentid)
                    {
                        $parent = mysql_query("SELECT * FROM m_menu WHERE PARENT_MENU=$parentid AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')ORDER BY URUT ASC");

                        echo "<ul>";
                        while ($r = mysql_fetch_array($parent)) {
                            $child = mysql_query("SELECT * FROM m_menu WHERE PARENT_MENU=$r[ID_MENU] AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')ORDER BY URUT ASC");
                            $jmlchild = mysql_num_rows($child);
                            if ($jmlchild > 0) {
                                echo "<li ><a class='arrow' href='$r[MENU_LINK]'>$r[MENU]</a>";
                                getChildMmenu($r['ID_MENU']);
                                echo "</li>";
                            } else {
                                echo "<li ><a class='' href='$r[MENU_LINK]'>$r[MENU]</a></li>";
                            }
                            $jmlchild = 0;
                        }
                        echo "</ul>";
                    }

                    include "../config/koneksi.php";
                    //edit andri 14092016 tambah ORDER BY ID_MENU ASC
                    $parent = mysql_query("SELECT * FROM m_menu WHERE PARENT_MENU=0 AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')ORDER BY URUT ASC");
                    echo "<ul class='menuH decor1'> ";
                    while ($r = mysql_fetch_array($parent)) {

                        $child = mysql_query("SELECT * FROM m_menu WHERE PARENT_MENU=$r[ID_MENU] AND IS_AKTIF=1 AND ID_MENU IN (SELECT ID_MENU FROM m_grup_menu where id_group='$_SESSION[G_leveluser]')ORDER BY URUT ASC");
                        
                        $jmlchild = mysql_num_rows($child);
                        if ($jmlchild > 0) {
                            echo "<li ><a class='arrow' href='$r[MENU_LINK]'>$r[MENU]</a>";
                            getChildMmenu($r['ID_MENU']);
                            echo "</li>";
                        } else {
                            echo "<li ><a class='' href='$r[MENU_LINK]'>$r[MENU]</a></li>";
                        }

                        $jmlchild = 0;
                    }

                    echo "<li>            <a href='logout.php'>LOGOUT ";
                    if ($_SESSION['G_leveluser'] == 15 || $_SESSION['G_leveluser'] == 14) {
                        echo "($_SESSION[G_namauser])";
                    }
                    echo "</a>          </li>";;
                    echo "</ul>";
                    ?>



            </tr>
            <tr>

            <?php
        }
            ?>



            <td width="100%" style="vertical-align: top">
                <DIV id="content">
                    <?php
                    include "content.php";
                    ?>
                </div>
            </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div align="center" id="footer">
                        Copyright &copy; 2013 by Pusat Teknologi Informasi dan Komunikasi Kementerian dan Perwakilan
                        <!--echo $_SESSION[G_leveluser]; ?>	 -->
                    </div>
                </td>
            </tr>
        </table>

    </body>

    </html>