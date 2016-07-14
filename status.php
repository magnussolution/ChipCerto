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


<?php include 'access.php';?>

</head>

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
<table id="table6" cellSpacing="0" cellPadding="0" width="100%" border="0">
	<tr>
		<td colspan="2" align="left" height="15"></td>
	</tr>
	<tr>
		<td width="20"></td>
		<td align="left" height="40"><a href="status.php?type=list"><div class="title4">Status</div></a></td>
	</tr>
        <tr>
                <td width="20"></td>
                <td align="right" height="40" valign="top">
                        <table border="0" width="82%" cellspacing="0" cellpadding="0" height="40">
                         <tr>
                          <td height="30"><a href="status.php?type=list"><div id="list" class="title3">Summary</div></a></td>
                         </tr>
                        
                         <tr>
                          <td height="30"><a href="status.php?type=gsm"><div id="gsm" class="title3">GSM</div></a></td>
                         </tr>
                         <tr>
                        </table>
                </td>
        </tr>
	<tr>
		<td width="20"></td>
		<td align="left" height="40"><a href="config.php"><div class="title5">Configurations</div></a></td>
	</tr>
	<tr>
		<td width="20"></td>
		<td height="40"><a href="tools.php"><div class="title5">Tools</div></a></td>
	</tr>
</table>
<script lang="javascript">
        
                document.getElementById('list').className="title4";
        
</script>

					</td>
					<td width="828" vAlign="top" class="content">
<script lang="javascript" src="/script/ajaxroutine.js"></script>	  
<script lang="javascript">

function getElementText(elem)
{
	var str=""
	if(elem.childNodes.length > 0){
		if(elem.childNodes.length > 1){
			str=elem.childNodes[1].nodeValue
		}
		else {
			str=elem.firstChild.nodeValue
		}
	}
	str.replace(/&lt;/,"<")
	str.replace(/&amp;/,"&")
	return str
}

function gen_status(myajax, str, line, nbsp_flag)
{
	var syscfg;
	var pagecfg;
	if(line==0) pagecfg=document.getElementById(str);
	else pagecfg=document.getElementById("l"+line+str);
	if(pagecfg){
		if(line==0) syscfg=myajax.responseXML.getElementsByTagName(str);
		else syscfg=myajax.responseXML.getElementsByTagName("l"+line+str);
		if(syscfg.length && nbsp_flag) pagecfg.innerHTML="&nbsp;"+getElementText(syscfg[0]);
		else if(syscfg.length && !nbsp_flag) pagecfg.innerHTML=getElementText(syscfg[0]);
		else pagecfg.innerHTML="&nbsp;";
	}
}

function gen_title(myajax,str,line,title)
{
	var syscfg;
	var pagecfg;
	if(line==0) pagecfg=document.getElementById(title);
	else pagecfg=document.getElementById("l"+line+title);
	if(pagecfg){
		if(line==0) syscfg=myajax.responseXML.getElementsByTagName(str);
		else syscfg=myajax.responseXML.getElementsByTagName("l"+line+str);
		pagecfg.title=getElementText(syscfg[0]);
	}
}
</script>


<?php 
if (!$_GET['type'] || $_GET['type'] == 'list') {
	include 'statusSummary.php';
}else if (!$_GET['type'] || $_GET['type'] == 'gsm') {
	include 'statusGsm.php';
}

?>


<script lang="javascript">

function set_status()
{
	var myajax=ajaxpack.ajaxobj;
	if (myajax.readyState == 4){ //if request of file completed
		clearTimeout(connect_id);
		if (myajax.status==200){ 

			set_status_list(myajax)

                }
                connect_id=setTimeout('get_status()', 5000)
        }
}

function get_status()
{
	ajaxpack.postAjaxRequest("status.xml", "type=", set_status, "text/xml")
}
connect_id=setTimeout('get_status()', 5000)
</script>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>

</html>


