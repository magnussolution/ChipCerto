<?php
/**
 *
 * =======================================
 * ###################################
 * PortabilidadeCelular
 *
 * @package ChipCerto ChanDongle
 * @author Adilson Leffa Magnus.
 * @copyright Copyright (C) 2005 - 2016 MagnusSolution. All rights reserved.
 * ###################################
 *
 * This software is released under the terms of the GNU Lesser General Public License v2.1
 * A copy of which is available from http://www.gnu.org/copyleft/lesser.html
 *
 * =======================================
 * Magnusbilling.com <info@portabilidadecelular.com>
 * 14/07/2016
 */
?>
<html>

<head>
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ChipCerto</title>
<link rel="stylesheet" type="text/css" href="style/default.css?0">
<style type="text/css">
.visible{
display:block;
}
</style>
<script lang="javascript" src="script/dynamic.js"></script>
<script lang="javascript">
if (document.getElementById){

	document.write('<style type="text/css">\n');
	document.write('.invisible{display:none;}\n');
	document.write('</style>\n');
}
</script>
</head>
<?php include 'access.php';?>
<body>
<table id="mainframe" height="100%" cellSpacing="0" cellPadding="0" width="768" border="0">
	<tr>
		<td width="314" class="banner" height="124">
			<img height="134" src="images/title.jpg" width="312" border="0">
		</td>
		<td class="banner" height="124" valign="bottom" width="454">
			<table cellSpacing="0" cellPadding="0" width="100%" height="100%"border="0">
				<tr>
					<td colspan="3" height="100" valign="bottom">
						<span class="subtitle">ChipCerto</span>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colSpan="2">
			<table height="100%" cellSpacing="0" cellPadding="0" width="100%" bgColor="#ffffff" border="0">
				<tr>
					<td vAlign="top" width="196" class="sidebar">
<script lang="javascript">
function confirm_reset()
{
	return window.confirm("Are you sure to reset to factory default?");
}
function confirm_reboot()
{
	return window.confirm("Você tem certeza que quer reiniciar o servidor?");
}
</script>
<table cellSpacing="0" cellPadding="0" width="100%" border="0">
	<tr>
		<td colspan="2" align="left" height="15"></td>
	</tr>
	<tr>
		<td width="20"></td>
		<td align="left" height="40">
			<a href="status.php"><div class="title5">Status</div></a></td>
	</tr>
	<tr>
		<td width="20"></td>
		<td align="left" height="40"><a href="config.php"><div class="title5">Configurations</div></a></td>
	</tr>
	<tr>
		<td width="20"></td>
		<td height="40"><div class="title4">Tools</div></td>
	</tr>
	<tr>
		<td width="20"></td>
		<td align="right" valign="top">
			<table border="0" width="82%" cellspacing="0" cellpadding="0">
				
	
				
				<tr>
					<td height="30"><a href="tools.php?type=password"><div class="title3" id="password">Change Password</div></a></td>
				</tr>
			
				<tr>
					<td height="30"><a href="tools.php?type=sms"><div class="title3" id="sms">Send SMS</div></a></td>
				</tr>
			
				

				<tr>
					<td height="10"></td>
				</tr>				
								
				
				<tr>
					<form action="reboot.php" method="post" onsubmit="return confirm_reboot()">
						<td height="30"><div class="title3"><input type="submit" value="Reboot Server" class="savebutton"></div></td>
					</form>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script lang="javascript">
	
		document.getElementById('upgrade').className="title4";
	
</script>

					</td>
					<td width="828" vAlign="top" class="content">

						<?php 
              if (!$_GET['type'] || $_GET['type'] == 'password') {
                include 'password.php';
              }else if (!$_GET['type'] || $_GET['type'] == 'ata_setting') {
                include 'callOut.php';
              }else if (!$_GET['type'] || $_GET['type'] == 'portabilidade') {
                include 'portabilidade.php';
              }else if (!$_GET['type'] || $_GET['type'] == 'dongle') {
                include 'dongle.php';
              }else if (!$_GET['type'] || $_GET['type'] == 'sms') {
                include 'sendSms.php';
              }

            ?>


					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>

</html>


