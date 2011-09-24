// Custom JavaScripts for GreenMap.org by Thomas Turnbull September 2007



/***********************************************
* Dynamic Ajax Content- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var bustcachevar=1 //bust potential caching of external pages after initial request? (1=yes, 0=no)
var loadedobjects=""
var rootdomain="http://"+window.location.hostname
var bustcacheparameter=""

function ajaxpage(url, containerid){
document.getElementById(containerid).innerHTML="Loading..." // set a loading message - added by TT
var page_request = false
if (window.XMLHttpRequest) // if Mozilla, Safari etc
page_request = new XMLHttpRequest()
else if (window.ActiveXObject){ // if IE
try {
page_request = new ActiveXObject("Msxml2.XMLHTTP")
} 
catch (e){
try{
page_request = new ActiveXObject("Microsoft.XMLHTTP")
}
catch (e){}
}
}
else
return false




page_request.onreadystatechange=function(){
loadpage(page_request, containerid)
}
if (bustcachevar) //if bust caching of external page
bustcacheparameter=(url.indexOf("?")!=-1)? "&"+new Date().getTime() : "?"+new Date().getTime()
page_request.open('GET', url+bustcacheparameter, true)
page_request.send(null)
}

function loadpage(page_request, containerid){
if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
document.getElementById(containerid).innerHTML=page_request.responseText
}

function loadobjs(){
if (!document.getElementById)
return
for (i=0; i<arguments.length; i++){
var file=arguments[i]
var fileref=""
if (loadedobjects.indexOf(file)==-1){ //Check to see if this object has not already been added to page before proceeding
if (file.indexOf(".js")!=-1){ //If object is a js file
fileref=document.createElement('script')
fileref.setAttribute("type","text/javascript");
fileref.setAttribute("src", file);
}
else if (file.indexOf(".css")!=-1){ //If object is a css file
fileref=document.createElement("link")
fileref.setAttribute("rel", "stylesheet");
fileref.setAttribute("type", "text/css");
fileref.setAttribute("href", file);
}
}
if (fileref!=""){
document.getElementsByTagName("head").item(0).appendChild(fileref)
loadedobjects+=file+" " //Remember this object as being already added to page
}
}
}


// end of AJAX page loader script


// loads icon into iframe page ---------------------------------------------------------

function iconIframeOld(nid,basepath) {
	iframePath = basepath + 'node/' + nid + '?theme=simple';      
	document.getElementById(nid).src = iframePath;
	document.getElementById(nid).height = '550px';
	document.getElementById(nid).style.height = '550px';

}

function iconIframe(nid,basepath) {
	iframePath = basepath + 'node/' + nid + '?theme=simple';     
	
	var elem, vis;
	  
	  if( document.getElementById ) // this is the way the standards work
		elem = document.getElementById( nid );
	  else if( document.all ) // this is the way old msie versions work
		  elem = document.all[nid];
	  else if( document.layers ) // this is the way nn4 works
		elem = document.layers[nid]; 
	  else elem = document.frames(nid); // tt attempt to fix for IE7
	
	if (elem == "")
	  // document.getElementById(nid).src='http://www.greenmap.org';
	  window.open("http://www.greenmap.org/greenhouse/node/" + nid , 'icon' );
		
	elem.src = iframePath;
	elem.height = '550px';
	elem.style.height = '550px';

}



// attaches the collapse function to my custom expanding fields ---------------------------------

function collapseManualAttach(fieldsetnid) {
  
  var fieldset = document.getElementById(fieldsetnid);
  var legend;

    legend = fieldset.getElementsByTagName('legend');
    legend = legend[0];
	a = legend.getElementsByTagName('a');
	a1 = a[0];
	// alert("thanks for your interest");
	// a.parentNode.parendNode.class = "collapsible"; // added by TT doesnt' work
    a1.onclick = function() {
	  // this.parentNode.parentNode.style = 'collapsible'; // added by TT doesn't work "setting a property that has only a getter"
	  if(!hasClass(this.parentNode.parentNode, 'collapsible')) {
	  	this.parentNode.parentNode.className = 'collapsible iconlist'; // added by TT
	  }
      toggleClass(this.parentNode.parentNode, 'collapsed');
      if (!hasClass(this.parentNode.parentNode, 'collapsed')) {
        collapseScrollIntoView(this.parentNode.parentNode);		
        if (typeof textAreaAutoAttach != 'undefined') {
          // Add the grippie to a textarea in a collapsed fieldset.
          textAreaAutoAttach(null, this.parentNode.parentNode);
        }
      }
      this.blur();
      return false;
    
    // a.innerHTML = "collapse"; // this changes inner html, so could use it
//    while (legend.hasChildNodes()) {
//      removeNode(legend.childNodes[0]);
//    }
//    legend.appendChild(a);
    collapseEnsureErrorsVisible(fieldset);
  }
}
