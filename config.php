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
 ?><html>

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
            <script lang="javascript" src="script/ajaxroutine.js"></script>
            <script lang="javascript">

              function URLencode(sStr) {
              	return escape(sStr).
              		replace(/\+/g, '%2B').
              		replace(/\"/g,'%22').
              		replace(/\'/g, '%27').
              		replace(/\//g,'%2F');
              }

              function show_all_config_pages()
              {
              	if (document.getElementById){
              		var i=0;
              		var id="config_page";
              		var max=11

              		for(i=0; i<max; i++){
              			if(document.getElementById(id+"_"+i+"_div")){
              				document.getElementById(id+"_"+i+"_div").style.display="block"
              			}
              		}
              	}
              }

              var the_config_form=false
              	
              function process_config_form()
              {
              	var myajax=ajaxpack.ajaxobj;

              	if (myajax.readyState == 4){ //if request of file completed
              		if (myajax.status==200){ 
              			window.alert("Configuration saved!")
              		}
              		else {

              			//window.alert("Cannot save configuration, error code: " + myajax.status)
              			the_config_form.disabled = false
              			the_config_form.submit()
              		}
              		if(the_config_form){
              			the_config_form.disabled = false
              				if(document.getElementById("mainframe")){
              					document.getElementById("mainframe").style.cursor="";
              				}
              		}
              	}
              }

              function ajax_post_config_form(theform, url)
              {
              	var poststr="";
              	var i

              	for(i=0; i<theform.elements.length; i++){
              		var elem = theform.elements[i]

              		if(elem.name!=""){
              			switch(elem.type){
              				case "radio":
              					if(elem.checked){
              						poststr+=elem.name+"="+URLencode(elem.value)+"&"
              					}
              				break;
              				case "checkbox":
              					if(elem.checked){
              						poststr+=elem.name+"="+"on"+"&"
              					}
              				break;
              				default:
              				poststr+=elem.name+"="+URLencode(elem.value)+"&";
              			}
              		}
              	}
              	poststr+="ajax_request=true";
              	ajaxpack.postAjaxRequest(url, poststr, process_config_form, "application/x-www-form-urlencoded");
              }

              function save_config()
              {
              	var theform

              	theform=document.forms["config_form"]
              	theform.submit()
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
            		<td align="left" height="40"><a href="config.php?type=preference"><div class="title4">Configurations</div></a></td>
            	</tr>
            	<tr>
            		<td width="20"></td>
            		<td align="right" height="40" valign="top">
            			<table border="0" width="82%" cellspacing="0" cellpadding="0" height="40">
            				
                        			
            				
            				<tr>
            					<td height="30"><a href="config.php?type=calling"><div id="calling" class="title3">Basic VoIP</div></a></td>
            				</tr>
                     <tr>
                      <td height="30"><a href="config.php?type=dongle"><div id="ata_in_setting" class="title3">Dongles</div></a></td>
                    </tr> 
            			
            				<tr>
            					<td height="30"><a href="config.php?type=ata_setting"><div id="ata_setting" class="title3">Call Out</div></a></td>
            				</tr>

            				<tr>
            					<td height="30"><a href="config.php?type=ata_in_setting"><div id="ata_in_setting" class="title3">Call In</div></a></td>
            				</tr>
                    <tr>
                      <td height="30"><a href="config.php?type=portabilidade"><div id="ata_in_setting" class="title3">Portabilidade</div></a></td>
                    </tr> 
            				
            				
            			</table>
            		</td>
            	</tr>
            	<tr>
            		<td width="20"></td>
            		<td height="40"><a href="tools.php"><div class="title5">Tools</div></a></td>
            	</tr>
            </table>

            <script lang="javascript">
            	
            		document.getElementById('preference').className="title4";
            	
            </script>

            

					</td>
					<td width="828" vAlign="top" class="content">


            <?php 
              if (!$_GET['type'] || $_GET['type'] == 'calling') {
                include 'basicVoIP.php';
              }else if (!$_GET['type'] || $_GET['type'] == 'ata_setting') {
                include 'callOut.php';
              }else if (!$_GET['type'] || $_GET['type'] == 'portabilidade') {
                include 'portabilidade.php';
              }else if (!$_GET['type'] || $_GET['type'] == 'dongle') {
                include 'dongle.php';
              }else if (!$_GET['type'] || $_GET['type'] == 'ata_in_setting') {
                include 'callIn.php';
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


