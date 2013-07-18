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

<form method=post action="../ezportal/directory/name.php" target='portal_main'>
<center>
<table width="100%" cellpadding="3" class=menutable>
<tr>
        <td>
		<input type="text" name="search_name" value="Search User Directory" style="width:300px;font-family: arial;font-size:12px;" class="hintTextbox">
		</td>
		<td>
		<input style="width:50px;font-family: arial;font-size:10px;" type=submit value='GO >>'>
		</td>
</tr>
</table>
</form>

