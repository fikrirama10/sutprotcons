var xmlhttp = createRequestObject();

function createRequestObject() {
    var ro;
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer"){
        ro = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
        ro = new XMLHttpRequest();
    }
    return ro;
}

function dinamisKantor(combobox)
{
    var kode = combobox.value;
    if (!kode) return;
    xmlhttp.open('get', './getcombo.php?kode='+kode, true);
    xmlhttp.onreadystatechange = function() {
        if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
        {
             document.getElementById("tampilkantor").innerHTML = xmlhttp.responseText;
        }
        return false;
    }
    xmlhttp.send(null);
}