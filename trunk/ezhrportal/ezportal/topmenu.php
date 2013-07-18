<? 
	include_once("auth.php");
	include_once("include/css/home.css");
?>
<body topmargin="0" leftmargin="0" bgcolor=#333333 onLoad="goforit()">
<table border="0" width="100%" cellspacing="0" cellpadding="3" style="border-collapse: collapse" bgcolor=#333333>
	<tr>
		<td width=300>
			&nbsp;
			<a class=topmenulink href="../data/home.php" target=portal_main>HOME</a>
			&nbsp;&nbsp;
			<a class=topmenulink href="../data/cms/hr/" target=portal_main>HR</a>
			&nbsp;&nbsp;
			<a class=topmenulink href="../data/cms/it/" target=portal_main>IT</a>
		</td>
        <td>&nbsp;</td>
		<td style="border-style: none; border-width: medium" align="right">
		<script>
			var dayarray=new Array("Sun","Mon","Tue","Wed","Thu","Fri","Sat")
			var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")

			function getthedate(){
			var mydate=new Date()
			var year=mydate.getYear()
			if (year < 1000)
			year+=1900
			var day=mydate.getDay()
			var month=mydate.getMonth()
			var daym=mydate.getDate()
			if (daym<10)
			daym="0"+daym
			var hours=mydate.getHours()
			var minutes=mydate.getMinutes()
			var seconds=mydate.getSeconds()
			var dn="AM"
			if (hours>=12)
			dn="PM"
			if (hours>12){
			hours=hours-12
			}
			if (hours==0)
			hours=12
			if (minutes<=9)
			minutes="0"+minutes
			if (seconds<=9)
			seconds="0"+seconds
			//change font size here
			var cdate="<font face=Arial size=1 color=#F3F3F3><i>"+dayarray[day]+", "+daym+" "+montharray[month]+", "+year+" "+hours+":"+minutes+":"+seconds+" "+dn
			+"</i></font>"
			if (document.all)
			document.all.clock.innerHTML=cdate
			else if (document.getElementById)
			document.getElementById("clock").innerHTML=cdate
			else
			document.write(cdate)
			}
			if (!document.all&&!document.getElementById)
			getthedate()
			function goforit(){
			if (document.all||document.getElementById)
			setInterval("getthedate()",1000)
			}

			</script>
			<span id="clock"></span>&nbsp;&nbsp;
		<i><b><font face=Arial size=1 color="#F3F3F3">Logged in as  <?echo $User_Full_Name;?>&nbsp;&nbsp;</font></b>
		&nbsp;
        <a style="text-decoration: none" target="_top" href="logout.php">
        <font color="#F3F3F3" face="Arial" size="1"><i><b>LOGOUT&nbsp;&nbsp;</b></font></a>
        </td>
	</tr>
</table>
</body>
