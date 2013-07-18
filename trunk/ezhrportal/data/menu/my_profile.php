<table width="200" cellpadding="3" class=menutable>
<tr>
	<td colspan=2 class=menuheader>MY PROFILE</td>	
</tr>
<tr>
	<td colspan=2 align=center>
	<?/*if (file_exists("$USER_PHOTO_DIR/$username.jpg")) {?>
		<img border="1" style="border-color: #EEEEEE;" width=67 height=88 src="<?=$USER_PHOTO_DIR;?>/<?=$username;?>.jpg">
	<?}else{?>
		<img class=profile_photo border=1 width=67 height=88 src="<?=$USER_PHOTO_DIR;?>/notavail.jpg">
	<?}*/?>
	</td>
</tr>
<tr>
	<td colspan=2 class=profile>&nbsp;username : <?=$username;?></td>
</tr>
<tr>
	<td colspan=2 class=profile>&nbsp;name : <?=$User_Full_Name;?></td>
</tr>
<tr>
	<td colspan=2 class=profile>&nbsp;staff id : <?=$User_Staff_No;?></td>
</tr>
</table>

<table width="200" height=100% cellpadding="3" class=menutable>
<tr>
	<td class=menuicon><img border=0 src="menu/images/org.png"></img></td>
	<td class=menuitem><a class=menulink href="../ezportal/my_profile/org.php">ORGANIZATION</a></td>
</tr>
<? if ($FEATURE_TIMESHEETS==1){?>
<tr>
	<td class=menuicon><img border=0 src="menu/images/timesheets.png"></img></td>
	<td class=menuitem><a class=menulink href="../ezportal/my_profile/time_sheet.php">TIMESHEETS</a></td>
</tr>
<?}?>
<tr>
	<td class=menuicon><img border=0 src="menu/images/assets.png"></img></td>
	<td class=menuitem><a class=menulink href="../ezportal/my_profile/listasset.php">ASSETS</a></td>
</tr>
<? if ($FEATURE_LEAVE==1){?>
<tr>
	<td class=menuicon><img border=0 src="menu/images/ezq_leave.png"></img></td>
	<td class=menuitem><a class=menulink href="../ezportal/my_profile/ezq_leave.php">LEAVE</a></td>
</tr>
<?}?>
<? if ($FEATURE_LEAVE_BALANCE==1){?>
<tr>
	<td class=menuicon><img border=0 src="menu/images/ezq_leave_balance.png"></img></td>
	<td class=menuitem><a class=menulink href="../ezportal/my_profile/myleave_balance.php">LEAVE BALANCE</a></td>
</tr>
<?}?>
<? if ($FEATURE_LEAVE_CREDIT==1){?>
<tr>
	<td class=menuicon><img border=0 src="menu/images/ezq_leave_credit.png"></img></td>
	<td class=menuitem><a class=menulink href="../ezportal/my_profile/ezq_leave_credit.php">LEAVE CREDIT</a></td>
</tr>
<?}?>
<? if ($FEATURE_EXPENSES==1){?>
<tr>
	<td class=menuicon><img border=0 src="menu/images/ezq_xpens.png"></img></td>
	<td class=menuitem><a class=menulink href="../ezportal/my_profile/ezq_expenses.php">EXPENSES</a></td>
</tr>
<?}?>
<tr>
	<td class=menuicon><img border=0 src="menu/images/pwd.png"></img></td>
	<td class=menuitem><a class=menulink href="../ezportal/password/">CHANGE PASSWORD</a></td>
</tr>
</table>