<?php
session_start();
//$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
//$IP        = isset($_SERVER['REMOTE_ADDR'])     ? $_SERVER['REMOTE_ADDR']     : '';
//$authKey = $userAgent . $IP;
if((isset($_GET['go']))&&(!isset($_POST['go'])))
	$action=$_GET['go'];
elseif((isset($_GET['go']))&&(isset($_POST['go'])))
	$action=$_POST['go'];
elseif((!isset($_GET['go']))&&(isset($_POST['go'])))
	$action=$_POST['go'];
else
	$action="";
/*if((isset($_SESSION['admin']))&&($_SESSION['auth_key']==$authKey))
	$statauth=true;
else
	$statauth=false;
if($statauth==true)
{*/
	$_SESSION['action']=$action;
	switch($action)
	{
		case "lapjmlpermit";
			include_once("./report.lapjmlpermit.class.php");
			$card=new card();
			break;
		case "card":
			$testtgl=$_POST['TGL_CETAK'];
			include_once("./report.card.class.php");
 			$card=new card($_POST['idt']);
			break;
		case "epo":
			$testtgl=$_POST['TGL_CETAK'];
			include_once("./report.epo.class_.php");
            //print_r($_POST['idt'].' '.$_POST['jns']);die;
 			$epo=new epo($_POST['idt'],$_POST['jns']);
			break;
		case "epoSib":
			$testtgl=$_POST['TGL_CETAK'];
			include_once("./report.epo.class_Sib.php");
 			$epo=new epo($_POST['idt']);
			break;
		case "cardsib":
			$testtgl=$_POST['TGL_CETAK'];
			include_once("./report.cardsib.class.php");
 			$card=new card($_GET['idd'],$_GET['idt']);
			break;
		case "cardsib_baru":
			$testtgl=$_POST['TGL_CETAK'];
			include_once("./report.cardsib_br.class.php");
 			$card=new card($_GET['idd'],$_GET['idt']);
			break;
		case "card_baru":
			$testtgl=$_POST['TGL_CETAK'];
			include_once("./report.card_br.class.php");
 			$card=new card($_POST['idt']);
			break;
		case "card_barunobg":
	 		$testtgl=$_POST['TGL_CETAK'];
	 		include_once("./report.cardnobg_br.class.php");
	 		$card=new card($_POST['idt']);
	 		break;
		case "permit";
			include_once("./report.permit.class_new.php");
			$card=new card($_GET['idd'],$_GET['idt']);
			break;
		case "permitsib";
			include_once("./report.permitsib.class.php");
			$card=new card($_GET['idd'],$_GET['idt']);
			break;
		case "izindiam":
			include_once("./report.izindiam.class.php");
			$izindiam=new izindiam();
			break;
		case "logoutin":
			include_once("./report.logoutin.class.php");
			$logoutin=new logoutin();
			break;
		case "logizin":
			include_once("./report.logizin.class.php");
			$logizin=new logizin();
			break;
		case "enquiry":
			include_once("./classes/report.enquiry.class.php");
			$enquiry=new enquiry();
			break;
		case "application":
			include_once("./report.application.class.php");
			$application=new application();
			break;
		case "passport":
			include_once("./classes/report.passport.class.php");
			$passport=new passport($_GET['type'],$_GET['id']);
			break;
		case "miras_staf":
			include_once("./report.miras_staf.class.php");
 			$rpt_staf=new rpt_staf($_GET['negara'], $_GET['perwakilan'], $_GET['tgl_cr_aju1'], $_GET['tgl_cr_aju2'], $_GET['nm_diplomat'], $_GET['setuju'], $_GET['tolak']);
			break;
        case "miras_pwk":
			include_once("./report.miras_pwk.class.php");
 			$rpt_pwk=new rpt_pwk($_GET['negara'], $_GET['perwakilan'], $_GET['tgl_cr_aju1'], $_GET['tgl_cr_aju2'],$_GET['setuju'], $_GET['tolak']);
			break;
        case "statistik_staf":
			include_once("./report.statistik_staf.class.php");
 			$stk_staf=new stk_staf($_GET['negara'], $_GET['perwakilan'], $_GET['tgl_cr_aju1'], $_GET['tgl_cr_aju2'], $_GET['nm_diplomat'], $_GET['setuju'], $_GET['tolak']);
			break;
        case "statistik_pwk":
			include_once("./report.statistik_pwk.class.php");
 			$stk_pwk=new stk_pwk($_GET['negara'], $_GET['perwakilan'], $_GET['tgl_cr_aju1'], $_GET['tgl_cr_aju2'],$_GET['setuju'], $_GET['tolak']);
			break;
		case "print_diplist":
			include_once("./report.diplist.class.php");
 			$diplist=new diplist();
			break;
		case "print_visa":
			
			include_once("./report.visa.class.php");
			$visa=new visa($_GET['idt'], $_GET['app_no']);
 			break;	

		case "print_visasib":
			
			include_once("./report.visasib.class.php");
			$visa=new visa($_GET['idt'], $_GET['sib'], $_GET['app_no']);
 			break;	

		default:
			?>
			<script language="javascript">
				window.location = 'index.php';
			</script>
			<?php
			break;
	}
?>
