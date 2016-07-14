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
                              <td height="25" class="title1" align="center" title="SIM Card: Y - Detected; N - No SIM">Status</td>
                              
                               <td height="25" class="title1" align="center" title="SIM Card: Y - Detected; N - No SIM">DURATION</td>
                             <td height="25" class="title1" align="center" title="RSSI">RSSI</td>
                              <td height="25" class="title1" align="center" title="SMS Server Login">SMS</td>
                              <td height="25" class="title1" align="center" title="Received Signal Strength Indicator">MODEL</td>
                              <td height="25" class="title1" align="center">Carrier</td>
                              <td height="25" class="title1" align="center">Cell ID</td>
                              <td height="25" class="title1" align="center">ACD(s)</td>
                              <td height="25" class="title1" align="center">ASR(%)</td>
                              <td height="25" class="title1" align="center">TOTAL TIME(s)</td>
                              <td height="25" class="title1" align="center" title="Time remaining for outgoing calls (minute)">Register</td>
                              <td height="25" class="title1" align="center" title="Click Reset to enable outgoing calls by resetting the Remain Time">Reset</td>
                           </tr>

                          	<?php 


                           		$asmanager = new AGI_AsteriskManager;
								$asmanager->connect('localhost', 'magnus', 'magnussolution');
								$server = $asmanager->Command("dongle show devices");
								$arr = explode("\n", $server["data"]);
								
								
                           	?>
                           	<?php for ($i=2; $i < (count($arr) -1 ); $i++) :
                           	$duration = $acd = $asr = 0;
                           	$line = preg_split("/ +/", $arr[$i]);

                           	if ($i == 883){
                           		echo '<pre>';
                           		print_r($line);
                           	}

                           	$canal = $line[0];

                           	$server2 = $asmanager->Command("dongle show device state  ".$canal);
							$arr2 = explode("\n", $server2["data"]);

							foreach ($arr2 as $key => $temp2) {
									                    		
				                
		                    	
								if (strstr($temp2, 'Provider Name')) 
			                    {
			                        $arr3 = preg_split("/Provider Name +:/", $temp2);
				                    $providerName = trim(rtrim($arr3[1]));
			                    }
			                    if (strstr($temp2, 'Model')) 
			                    {
			                        $arr3 = preg_split("/Model +:/", $temp2);
				                    $model = trim(rtrim($arr3[1]));
			                    }
			                    if (strstr($temp2, 'Cell ID')) 
			                    {
			                        $arr3 = preg_split("/Cell ID +:/", $temp2);
				                    $cellid = trim(rtrim($arr3[1]));
			                    }
			                    if (strstr($temp2, 'GSM Registration Status')) 
			                    {
			                        $arr3 = preg_split("/GSM Registration Status +:/", $temp2);
				                    $GSMRegistrationStatus = trim(rtrim($arr3[1]));
			                    }
			                    if(preg_match("/SMS +:/", $temp2)) 
			                    {
			                        $arr3 = preg_split("/SMS +:/", $temp2);
				                    $SMS = trim(rtrim($arr3[1]));
			                    }
			                    if(preg_match("/RSSI +:/", $temp2)) 
			                    {
			                        $arr3 = preg_split("/RSSI +:/", $temp2);
				                    $RSSI = trim(rtrim($arr3[1]));
			                    }
		                    }

		                    $server2 = $asmanager->Command("dongle show device statistics  ".$canal);
							$arr2 = explode("\n", $server2["data"]);

							foreach ($arr2 as $key => $temp2) {
								if(preg_match("/ACD for outgoing calls +:/", $temp2)) 
			                    {
			                        $arr3 = preg_split("/ACD for outgoing calls +:/", $temp2);
				                    $acd = trim(rtrim($arr3[1]));
			                    }
			                    if(preg_match("/ASR for outgoing calls +:/", $temp2)) 
			                    {
			                        $arr3 = preg_split("/ASR for outgoing calls +:/", $temp2);
				                    $asr = trim(rtrim($arr3[1]));
			                    }
			                    if(preg_match("/Seconds of outgoing calls +:/", $temp2)) 
			                    {
			                        $arr3 = preg_split("/Seconds of outgoing calls +:/", $temp2);
				                    $totalTime = trim(rtrim($arr3[1]));
			                    }
							}

		                    $statusDial = $line[2];
		                    if (preg_match("/Dialing|Outgoing|Ring/", $statusDial)) {
		                    
			                    $server3 = $asmanager->Command("core show channels concise");
								$arr3 = explode("\n", $server3["data"]);

								foreach ($arr3 as $key => $temp3) {
									if (strstr($temp3, $canal)) 
				                    {
				                    	$canalStatus = explode("!", $temp3);
				                    	if ($canal == 'dongle0888') {
				                    		
				                    	
				                    		echo '<pre>';
				                    		print_r($canalStatus);
				                    	}

				                    	$dial = explode("/", $canalStatus[6]);
				                    	if (strlen($dial[2]) > 0) {
				                    		$statusDial .= " (".$dial[2].')';
				                    	}				                    	
				                    	$duration = $canalStatus[11];
				                        //$arr3 = preg_split("/SMS +:/", $temp2);
					                    //$SMS = trim(rtrim($arr3[1]));
				                    }
								}

							}

							?>
							<tr>
								<td height="25" class="title11" align="center" id="l1_module_status_gsm"><?php echo $i - 1?></td>
								<td height="25" class="title11" align="center" id="l1_module_status_gsm"><?php echo $line[0]?></td>
								<td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $statusDial?></td>								
								<td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $duration?></td>
								<td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $RSSI?></td>
								<td height="25" class="text" align="center" id="l1_sms_login">&nbsp;<?php echo $SMS?></td>
								<td height="25" class="text2" align="center" id="l1_gsm_signal">&nbsp;<font color="#FF8000"><?php echo $model?></font></td>
								<td height="25" class="text2" align="center" id="l1_gsm_cur_oper">&nbsp;<?php echo $providerName?></td>
								<td height="25" class="text2" align="center" id="l1_gsm_cur_bst">&nbsp;<?php echo $cellid?></td>
								<td height="25" class="text2" align="center" id="l1_gsm_cur_bst">&nbsp;<?php echo $acd?></td>
								<td height="25" class="text2" align="center" id="l1_gsm_cur_bst">&nbsp;<?php echo $asr?></td>
								<td height="25" class="text2" align="center" id="l1_gsm_cur_bst">&nbsp;<?php echo $totalTime?></td>
								<td height="25" class="text2" align="center" id="l1_sim_remain">&nbsp;<?php echo $GSMRegistrationStatus?></td>
								<td height="25" class="text2" align="center"><input type="button" name="line1_sim_exp_reset" class="button" value="Reset" onclick="window.location.href='status.php?type=list&sim_exp_reset=1&line=<?php echo $canal?>'"></td>
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