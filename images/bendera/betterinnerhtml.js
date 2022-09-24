// BetterInnerHTML v1.15 - by Craig Buckler, http://www.optimalworks.net/
function BetterInnerHTML(_1,_2,_3)
{
	function Load(_4){
		var _5;
		if(typeof DOMParser!="undefined"){
			_5=(new DOMParser()).parseFromString(_4,"application/xml");
		}
		else{
			var _6=["MSXML2.DOMDocument","MSXML.DOMDocument","Microsoft.XMLDOM"];
			for(var i=0;i<_6.length&&!_5;i++){
				try{
					_5=new ActiveXObject(_6[i]);_5.loadXML(_4);
				}
				catch(e){}
			}
		}return _5;
	}
	function Copy(_8,_9,_a){
		if(typeof _a=="undefined"){
			_a=1;
		}
		if(_a>1){
			if(_9.nodeType==1){
				var _b=document.createElement(_9.nodeName);
				for(var a=0,attr=_9.attributes.length;a<attr;a++){
					var _d=_9.attributes[a].name,aValue=_9.attributes[a].value,evt=(_d.substr(0,2)=="on");
					if(!evt){
						switch(_d){
							case "class":_b.className=aValue;
										break;
							case "for":_b.htmlFor=aValue;
										break;
							default:_b.setAttribute(_d,aValue);
						}
					}
				}
				_8=_8.appendChild(_b);
				if(evt){_8[_d]=function(){
					eval(aValue);
				};
			}
		}
		else{
			if(_9.nodeType==3){
				var _e=(_9.nodeValue?_9.nodeValue:"");
				var _f=_e.replace(/^\s*|\s*$/g,"");
				if(_f.length<7||(_f.indexOf("<!--")!=0&&_f.indexOf("-->")!=(_f.length-3))){
					_8.appendChild(document.createTextNode(_e));
				}
			}
		}
	}for(var i=0,j=_9.childNodes.length;i<j;i++){
		Copy(_8,_9.childNodes[i],_a+1);}}_2="<root>"+_2+"</root>";var _11=Load(_2);if(_1&&_11){if(_3!=false){while(_1.lastChild){_1.removeChild(_1.lastChild);}}Copy(_1,_11.documentElement);}}
