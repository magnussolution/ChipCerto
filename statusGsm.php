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
include 'phpagi/phpagi-asmanager.php';
include 'phpagi.php';
if (isset($_GET['sim_exp_reset'])) {
	$asmanager = new AGI_AsteriskManager;
	$asmanager->connect('localhost', 'magnus', 'magnussolution');
	$server = $asmanager->Command("dongle reset ".$_GET['line']);
}

?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
   <tr>
      <td>
         <div style="padding:5px">
            <table border="0" cellpadding="0" cellspacing="0" width="99%">
               <tr>
                  <td colspan="2" class="title2" height="25" >GSM Details</td>
               </tr>
               <tr>
                  <td colspan="2">
                     <div id="gsm_info" class="visable">
                        <table border="1" cellpadding="0" cellspacing="0" width="100%">
                           <tr>
                           	<td height="25" class="title1" align="center" title="Line">CH</td>
                              <td height="25" class="title1" align="center" title="Line">Line</td>
                              <td height="25" class="title1" align="center" title="SIM Card: Y - Detected; N - No SIM">Firmware Version</td>
                              
                               <td height="25" class="title1" align="center" title="SIM Card: Y - Detected; N - No SIM">SIM Number</td>
                             <td height="25" class="title1" align="center" title="RSSI">IMEI</td>
                              <td height="25" class="title1" align="center" title="SMS Server Login">IMSI</td>
                           </tr>

                          	<?php 


                           		$asmanager = new AGI_AsteriskManager;
								$asmanager->connect('localhost', 'magnus', 'magnussolution');
								$server = $asmanager->Command("dongle show devices");
								$arr = explode("\n", $server["data"]);
								
								
                           	?>
                           	<?php for ($i=2; $i < (count($arr) -1 ); $i++) :
                           	$duration = 0;
                           	$line = preg_split("/ +/", $arr[$i]);

                           	if ($i == 333){
                           		echo '<pre>';
                           		print_r($line);
                           	}

                           	$canal = $line[0];

                           	$server2 = $asmanager->Command("dongle show device state  ".$canal);
							$arr2 = explode("\n", $server2["data"]);

							foreach ($arr2 as $key => $temp2) {
								
			                    if(preg_match("/Firmware +:/", $temp2)) 
			                    {
			                        $arr3 = preg_split("/Firmware +:/", $temp2);
				                    $Firmware = trim(rtrim($arr3[1]));
			                    }

			                    if(preg_match("/Subscriber Number +:/", $temp2)) 
			                    {
			                        $arr3 = preg_split("/Subscriber Number +:/", $temp2);
				                    $number = trim(rtrim($arr3[1]));
			                    }

			                    if(preg_match("/IMEI +:/", $temp2)) 
			                    {
			                        $arr3 = preg_split("/IMEI +:/", $temp2);
				                    $IMEI = trim(rtrim($arr3[1]));
			                    }
			                    if(preg_match("/IMSI +:/", $temp2)) 
			                    {
			                        $arr3 = preg_split("/IMSI +:/", $temp2);
				                    $IMSI = trim(rtrim($arr3[1]));
			                    }
		                    } 

		                    

							?>
							<tr>
								<td height="25" class="title11" align="center" id="l1_module_status_gsm"><?php echo $i - 1?></td>
								<td height="25" class="title11" align="center" id="l1_module_status_gsm"><?php echo $canal?></td>
								<td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $Firmware?></td>								
								<td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $number?></td>
								<td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $IMEI?></td>
								<td height="25" class="text" align="center" id="l1_sms_login">&nbsp;<?php echo $IMSI?></td>
							</tr>
						<?php endfor;?>
							
                        </table>
                     </div>
                  </td>
               </tr>
            </table>
            <script lang="javascript">
               function set_status_list(myajax)
               {
               	var i;
               	for(i=1;i<=1;i++){
               		gen_status(myajax, "_module_status", i, 0);
               		gen_title(myajax, "_module_title", i, "_module_status");
               		gen_status(myajax, "_gsm_sim", i, 0);
               		gen_status(myajax, "_gsm_status", i, 0);
               		gen_status(myajax, "_gsm_signal", i, 1);
               		gen_status(myajax, "_gsm_cur_oper", i, 1);
               		gen_status(myajax, "_gsm_cur_bst", i, 1);
               		gen_status(myajax, "_lac", i, 1);
               		gen_title(myajax, "_lac", i, "_gsm_cur_bst");
               		gen_status(myajax, "_sim_remain", i, 1);
               		gen_status(myajax, "_status_line", i, 1);
               		gen_status(myajax, "_line_state", i, 1);
               		gen_status(myajax, "_sms_login", i, 1);
               		gen_status(myajax, "_smb_login", i, 1);
               		gen_status(myajax, "_nocall_t", i, 1);
               	}
               }
               
            </script>
         </div>
      </td>
   </tr>
</table>