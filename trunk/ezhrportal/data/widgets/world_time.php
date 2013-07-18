<style type="text/css">
	INPUT.hintTextbox       { color: #888; }
	INPUT.hintTextboxActive { color: #000; }
</style>
<script type="text/javascript">
var HintClass = "hintTextbox";
var HintActiveClass = "hintTextboxActive";

// define a custom method on the string class to trim leading and training spaces
String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ''); };

function initHintTextboxes() {
  var inputs = document.getElementsByTagName('input');
  for (i=0; i<inputs.length; i++) {
    var input = inputs[i];
    if (input.type!="text" && input.type!="password")
      continue;
      
    if (input.className.indexOf(HintClass)!=-1) {
      input.hintText = input.value;
      input.className = HintClass;
      input.onfocus = onHintTextboxFocus;
      input.onblur = onHintTextboxBlur;
    }
  }
}

function onHintTextboxFocus() {
  var input = this;
  if (input.value.trim()==input.hintText) {
    input.value = "";
    input.className = HintActiveClass;
  }
}

function onHintTextboxBlur() {
  var input = this;
  if (input.value.trim().length==0) {
    input.value = input.hintText;
    input.className = HintClass;
  }
}

window.onload = initHintTextboxes;
</script>


<center>
<table border=0 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#FFFFFF">
<tr>
		<form method=get action="http://www.timeanddate.com/worldclock/results.html" target="_blank" >
        <td bgcolor=#CCCCCC><input type="search" name="query" id=query value="Check Time In" size="12" class="hintTextbox"></td>
        <td bgcolor=#CCCCCC align=right><input type=submit value='GO >>'></td>
		</form>
</tr>
<tr>
	<td align=center colspan=2>
	<script src="http://www.clocklink.com/embed.js"></script>
	<script type="text/javascript" language="JavaScript">
	obj=new Object;obj.clockfile="0011-silver.swf";obj.TimeZone="GMT0530";obj.width=110;obj.height=110;obj.Place="";obj.wmode="transparent";showClock(obj);
	</script>
	</td>
</tr>
</table>

