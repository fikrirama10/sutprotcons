/************************************************************************************
/* Coder: Husain Salah											       				*
/* Date: 03/02/2009											      				 *	
/* Simple java script used to hide and show footnote information and 
/* permanent mission info											        			  *
/* Copywright UNHQ											      				  *
/************************************************************************************/

/*************************************************************************************
/* function initPage()												 
/* Input Parameters: none
/* Output Parameters: none
/* Usage: This adjusts the page in case javascript is enableed in the browser by 
/* doing the following:
/* 1. Hides Footnote Divs
/* 2. Shows [+] link
/* 3. Hides Permanant mission contact info (Only applicable to missions that
/* 	  do not have a website)
/*************************************************************************************/
function initPage(){
	/*************************************************************************
	*This function is used to intialize page in case Java Script is enabled, otherwise default *
	* This section controls visibility of the footenotes *
	*************************************************************************/
	var asplinks=document.getElementsByName('asplink');
	for (i=0;i<=191;i++){
		asplinks[i].style.display="none";
	}
	document.getElementById("footnote1").style.display="none";
	document.getElementById("footnote2").style.display="none";
	document.getElementById("footnote3").style.display="none";
	document.getElementById("footnote4").style.display="none";
	document.getElementById("footnote5").style.display="none";
	document.getElementById("footnote6").style.display="none";
	document.getElementById("footnote7").style.display="none";
	document.getElementById("footnote8").style.display="none";
	document.getElementById("footnote9").style.display="none";
	document.getElementById("footnote10").style.display="none";
	document.getElementById("footnote11").style.display="none";
	document.getElementById("footnote12").style.display="none";
	document.getElementById("footnote13").style.display="none";
	document.getElementById("footnote13").style.display="none";
	document.getElementById("footnote14").style.display="none";
	document.getElementById("footnote15").style.display="none";
	document.getElementById("footnote16").style.display="none";
	document.getElementById("footnote17").style.display="none";
	document.getElementById("footnote18").style.display="none";
	document.getElementById("footnote19").style.display="none";
	document.getElementById("footnote20").style.display="none";
	
}
function initGrowthPage()
{
	document.getElementById("footnote1").style.display="none";
	document.getElementById("footnote2").style.display="none";
	document.getElementById("footnote3").style.display="none";
	//document.getElementById("footnote4").style.display="none";
	document.getElementById("footnote5").style.display="none";
	document.getElementById("footnote6").style.display="none";
	document.getElementById("footnote7").style.display="none";
	document.getElementById("footnote8").style.display="none";
	document.getElementById("footnote9").style.display="none";
	document.getElementById("footnote10").style.display="none";
	document.getElementById("footnote11").style.display="none";
	document.getElementById("footnote12").style.display="none";
	document.getElementById("footnote13").style.display="none";
	document.getElementById("footnote13").style.display="none";
	document.getElementById("footnote14").style.display="none";
	document.getElementById("footnote15").style.display="none";
	document.getElementById("footnote16").style.display="none";
	document.getElementById("footnote17").style.display="none";
	document.getElementById("footnote18").style.display="none";
	document.getElementById("footnote19").style.display="none";
	document.getElementById("footnote20").style.display="none";
	//document.getElementById("footnote21").style.display="none";
	document.getElementById("footnote22").style.display="none";
	//document.getElementById("footnote23").style.display="none";
	//document.getElementById("footnote24").style.display="none";
	document.getElementById("footnote25").style.display="none";
	//document.getElementById("footnote26").style.display="none";
	document.getElementById("footnote27").style.display="none";
	document.getElementById("footnote28").style.display="none";
	document.getElementById("footnote29").style.display="none";
	document.getElementById("footnote30").style.display="none";
}
function showinfo(boxid){
	/*************************************************************************************
	 function showinfo()												 
	 Input Parameters: boxid (divid)
	 Output Parameters: none
	 Usage: This shows the div with style inline
	*************************************************************************************/
		document.getElementById(boxid).style.display="block";
}

function hidestuff(boxid,plusbutton,minusbutton){
	/*************************************************************************************
	 function hidestuff()												 
	 Input Parameters: boxid, plusbutton, minusbutton
	 Output Parameters: none
	 Usage: This hides the footnote div, shows the [+] button, hides the [--] button
	*************************************************************************************/
	document.getElementById(boxid).style.display="none";
	document.getElementById(plusbutton).style.display="block";
	document.getElementById(minusbutton).style.display="none";
}
function hidestuff(boxid,plusbutton,minusbutton){
	/*************************************************************************************
	 function hidestuff()												 
	 Input Parameters: boxid, plusbutton, minusbutton
	 Output Parameters: none
	 Usage: This hides the footnote div, shows the [+] button, hides the [--] button
	*************************************************************************************/
	document.getElementById(boxid).style.display="none";
	document.getElementById(plusbutton).style.display="inline";
	document.getElementById(minusbutton).style.display="none";
}
function showstuff(boxid,plusbutton,minusbutton){
	/*************************************************************************************
	 function showstuff()												 
	 Input Parameters: boxid, plusbutton, minusbutton
	 Output Parameters: none
	 Usage: This hides the footnote div, shows the [+] button, hides the [--] button
	*************************************************************************************/
	document.getElementById(boxid).style.display="block";
	document.getElementById(plusbutton).style.display="none";
	document.getElementById(minusbutton).style.display="inline";
}
function showhideinfo(boxid){
	/*************************************************************************************/
	/* function showhidemissioninfo()										 */
	/* Input Parameters: boxid
	/* Output Parameters: none
	/* Usage: This shows the permenant mission contact info div if hidden, and hides 
	/*	the permenant mission contact info div if displayed
	/************************************************************************************/
	
    if (document.getElementById(boxid).style.display!="none"){
   		document.getElementById(boxid).style.display="none";
    } 
    else if(document.getElementById(boxid).style.display=="none"){
  		document.getElementById(boxid).style.display="block";
    }
}
function hideinfo(boxid){
	/************************************************************************************
	* function showhidemissioninfo()										 
	* Input Parameters: boxid
	* Output Parameters: none
	* Usage: This shows the permenant mission contact info div if hidden, and hides 
	*	the permenant mission contact info div if displayed
	*************************************************************************************/

	document.getElementById(boxid).style.display="none";
}
