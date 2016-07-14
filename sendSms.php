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

if (isset($_POST['telnum'])) {

    if (strlen($_POST['telnum']) < 8) {
       $error = "Numero menor que 8";
    }elseif (strlen($_POST['telnum']) < 1) {        
       $error = "Numero esta vazio";
    }elseif (strlen($_POST['smscontent']) < 1) {        
       $error = "Texto esta vazio";
    }elseif (strlen($_POST['smscontent']) > 120) {        
       $error = "Texto maior que 120";
    }else{
        $asmanager = new AGI_AsteriskManager;
        $asmanager->connect('localhost', 'magnus', 'magnussolution');

        $command = "dongle sms ".$_POST['line']. " ".$_POST['telnum']. " \"".$_POST['smscontent']."\" 0 ".time();
        $asmanager->Command($command); 
        $sucess = 'SMS enviado!';
    }

}


?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tbody><tr>
		<td>
			
			
			
			
			<div id="tools_page_4_div" style="padding:5px">
<script lang="javascript" src="/script/ajaxroutine.js"></script>

<script lang="javascript">

function myescape(sStr){
		sStr=sStr.replace(/\n|\r/g," ");
}


</script>
<div>
<form action="tools.php?type=sms&send" method="post">
	<div>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
        <?php if(isset($error)) :?>
                  <tr>
                     <td colspan="2" class="title3" height="25" ><font color=red><?php echo $error?></font></td>
                  </tr>
               <?php endif; ?>
        <?php if(isset($sucess)) :?>
                  <tr>
                     <td colspan="2" class="title3" height="25" ><font color=green><?php echo $sucess?></font></td>
                  </tr>
               <?php endif; ?>
        <tr>
		<td colspan="3" class="title2" height="25">Send SMS</td>
	</tr>

	<tr>
		<td colspan="3" class="text">
             <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>

                    <?php 
                    $dongleFile = '/etc/asterisk/chipcerto_dongle.conf';
                    $dongleConfig = parse_ini_file($dongleFile,true);
                    $i = 1;

              
                    foreach ($dongleConfig as $key => $value):

                   
                    
                    $selected = $i == 1 ? 'checked' : '';
                    
                    echo '<td class="text"><input type="radio" name="line" '.$selected.' value=" '.$key.'" onclick="toggle2(\'sms_send_tab\', 16, '.($i -1) .')" >Line '.$i.' &nbsp;&nbsp;</td>';
                    
                    if ( $i > 1 && ($i % 4) == 1){
                        echo ' </tr> <tr>';
                    }
                  
                  $i ++;
                  endforeach;?>

                   </tr>
                <tr>
                
                
                
                
                
                
                
                
                </tr>
                <tr>
                
                
                
                
                
                
                
                
                </tr>
                 </tr></tbody></table>
		</td>
	</tr>
	</tbody></table>
	</div>
	<!-- -->
	<div id="sms_send_tab_0_div" class="visable">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody><tr>
				<td width="120" height="25" class="title1" align="right">Line 1 GSM Status:</td>
				<td width="160" class="text">LOGIN</td>
			</tr>
			<tr>
				<td width="120" height="25" class="title1" align="right">Line 1 GSM Number:</td>
				<td width="160" class="text"></td>
			</tr>
		
		</tbody></table>
	</div>

        <div id="sms_send_tab_1_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 2 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 2 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_2_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 3 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 3 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_3_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 4 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 4 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_4_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 5 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 5 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_5_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 6 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 6 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_6_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 7 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 7 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_7_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 8 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 8 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_8_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 9 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 9 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_9_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 10 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 10 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_10_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 11 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 11 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_11_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 12 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 12 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_12_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 13 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 13 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_13_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 14 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 14 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_14_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 15 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 15 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


        <div id="sms_send_tab_15_div" class="invisible">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                                <td width="120" height="25" class="title1" align="right">Line 16 GSM Status:</td>
                                <td width="160" class="text">LOGIN</td>
                        </tr>
                        <tr>
                                <td width="120" height="25" class="title1" align="right">Line 16 GSM Number:</td>
                                <td width="160" class="text"></td>
                        </tr>

                </tbody></table>
        </div>


















<input type="hIdden" name="smskey" value="577ffa1b">
<input type="hIdden" name="action" value="SMS">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
		<td class="title1" width="120" align="right" height="30">Phone Number:</td>
		<td align="center" width="300"><input type="text" name="telnum" class="edit" style="width:200"></td>
		<td></td>
	</tr>
	<tr>
		<td class="title1" align="right" height="30">SMS Content:</td>
		<td align="center" width="300"><textarea name="smscontent" class="edit" rows="6" style="width:200"></textarea></td>
		<td><input type="submit" name="send" class="button" value="Send"></td>
	</tr>
</tbody></table>
</form>


</div>
<script lang="javascript">
var line_obj = document.getElementsByName("line"); 
line_obj[-1].checked=true;
toggle2('sms_send_tab', 16+1, -1);
</script>

			</div>
			
			
			
			
                        
                        
                        
			

		</td>
	</tr>
</tbody></table>