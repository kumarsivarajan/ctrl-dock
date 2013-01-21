function Inint_AJAX() {
   try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
   try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
   alert("XMLHttpRequest not supported");
   return null;
}

function filterstaff(src,x) {

	 var req = Inint_AJAX();
           
     req.onreadystatechange = function () { 
          if (req.readyState==4) {
               if (req.status==200) {
			   var rss = req.responseText;
			   //alert(rss);
			   document.getElementById(src).innerHTML=rss;
               } 
          }
		  
     };
	 
	 req.open("GET", "filterdata.php?data="+src+"&aval="+x+"&sval=",true); //make connection
    
     req.send(null); //send value
}

function filteragency(src,x) {

	 var req = Inint_AJAX();
       
     req.onreadystatechange = function () { 
          if (req.readyState==4) {
               if (req.status==200) {
			   var rss = req.responseText;
			   //alert(rss);
			   document.getElementById(src).innerHTML=rss;
               } 
          }
		  
     };
	 
	 req.open("GET", "filterdata.php?data="+src+"&sval="+x+"&aval=",true); //make connection
    
     req.send(null); //send value
}

function initajaxloadimg()
{
	document.getElementById("loadcontent").innerHTML='';
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			document.getElementById("loadcontent").innerHTML=xmlhttp.responseText;
			}
		  else
			{
			document.getElementById("loadcontent").innerHTML = '<img src="../images/ajax-loader.gif">';
			}
	  }
}

function loadprogressbar()
{

var agencyid = document.getElementById('agencyid').value;
var staff = document.getElementById('staff').value;
var start_date = document.getElementById('start_date').value;
var end_date = document.getElementById('end_date').value;
var status = document.getElementById('status').value;
if(document.getElementById('loadcontent1') != null)
{
document.getElementById('loadcontent1').innerHTML='';
}
//document.getElementById('loadcontent1').innerHTML='';
initajaxloadimg();

xmlhttp.open("GET","listengineer.php?agencyid="+agencyid+"&staff="+staff+"&start_date="+start_date+"&end_date="+end_date+"&status="+status+"&search=true&unassigned=false",true);
xmlhttp.send();
}

function loadunassigned()
{

var agencyid = document.getElementById('agencyid').value;
if(document.getElementById('loadcontent1') != null)
{
document.getElementById('loadcontent1').innerHTML='';
}
initajaxloadimg();

xmlhttp.open("GET","listengineer.php?agencyid="+agencyid+"&unassigned=true&search=false",true);
xmlhttp.send();
}

