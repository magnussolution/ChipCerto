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

$configFile = '/etc/asterisk/chipcerto_sip.conf';
$sipConfig = parse_ini_file($configFile,true);

$dongleFile = '/etc/asterisk/chipcerto_dongle.conf';
$dongleConfig = parse_ini_file($dongleFile,true);


$exten_in_File = '/etc/asterisk/chipcerto_extensions_in.conf';
?>


<?php
   if (isset($_POST['destino']) && isset($_GET['save']) && $_GET['save'] == 1 ) {

      $dongle = $_GET['dongle'];
      $dongleConfig[$dongle]['destino'] = $_POST['destino'];
  
      function listINIRecursive($array_name, $indent = 0)
      {
          global $str;
          foreach ($array_name as $k => $v)
          {
              if (is_array($v))
              {
                  for ($i=0; $i < $indent * 5; $i++){ 
                     $str.= " "; 
                  }
                  $str.= "[$k] \r\n";
                  listINIRecursive($v, $indent + 1);
              }
                  else
              {
                  for ($i=0; $i < $indent * 5; $i++){ $str.= " "; }
                  $str.= "$k = $v \r\n";
              }
          }

          return $str;

       }


       $fp = fopen($dongleFile, 'w');
       $dongleConfig = listINIRecursive($dongleConfig);
       fwrite($fp, $dongleConfig);
       fclose($fp);
       unset($_GET['dongle']);
       $sussess = true;

      

      $dongleConfig = parse_ini_file($dongleFile,true);

      
      $extensions = '[chipcerto_in]
      ';
      foreach ($dongleConfig as $key => $value) {
      

         $extensions .= '
exten => '.$value['exten'].',1,Dial(SIP/'.$value['destino'].')
  same => n,hangup()

  exten => +'.$value['exten'].',1,Dial(SIP/'.$value['destino'].')
  same => n,hangup()
         ';

      }

      $extensions .= '
exten => ussd,1,Noop(Incoming USSD: ${BASE64_DECODE(${USSD_BASE64})})
  same => n,System(echo \'${STRFTIME(${EPOCH},,%Y-%m-%d %H:%M:%S)} - ${DONGLENAME} - ${CALLERID(num)}: ${SMS_BASE64}\' >> /etc/asterisk/chipcerto_ussd.conf)
  same => n,Hangup()

exten => sms,1,Verbose(Incoming SMS from ${CALLERID(num)} ${BASE64_DECODE(${SMS})})
  same => n,System(echo \'${STRFTIME(${EPOCH},,%Y-%m-%d %H:%M:%S)} - ${DONGLENAME} - ${CALLERID(num)}: ${SMS_BASE64}\' >> /etc/asterisk/chipcerto_sms.conf)
  same => n,Hangup()
  ';
      
       $fp = fopen($exten_in_File, 'w');
       fwrite($fp, $extensions);
       fclose($fp);

      

      $asmanager = new AGI_AsteriskManager;
      $asmanager->connect('localhost', 'magnus', 'magnussolution');
      $asmanager->Command("dialplan reload");

      
   }

?>

<?php if (isset($_GET['dongle'])) : $dongle = $_GET['dongle']; ?>


   <table width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr>
         <td>
            <div style="padding:5px">
               <table border="0" cellpadding="0" cellspacing="0" width="99%">
                  <tr>
                     <td colspan="2" class="title2" height="25" >EDIT DESTINO TO <?php echo $_GET['dongle']?></td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <div id="gsm_info" class="visable">
                           <table height="100%" cellSpacing="0" cellPadding="0" width="100%" height="100%" border="0">
                              <tr>
                                 <td width="572" vAlign="top" bgColor="#ffffff">
                                    <form id="config_form" method="post" action="config.php?type=ata_in_setting&dongle=<?php echo $dongle?>&save=1">
                                       <div id="config_page_2_div" style="padding:5px">
                                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                             <tr>                                                    
                                                <tr>
                                                   <td colspan="2">
                                                      <div id="basic_calling" class="visable">
                                                         <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tr>
                                                               <td colspan="2">
                                                                  <div id="endpoint_type_SIP_div" class="visable">
                                                                     <div id="sip_config_mode_SINGLE_MODE_div" class="visable">
                                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">   

                                                                            

                                                                            <td width="120" height="25" class="title1">DESTINO</td>
                                                                             <td width="160" class="text">
                                                                                <select name="destino" id="endpoint_type_select" class="select" >

                                                                                  <?php
                                                                           
                                                                                    echo $dongleConfig[$dongle]['destino'];
                                                                                    foreach ($sipConfig as $key => $value):

                                                                                      if ($key == 'portabilidadecelular') {
                                                                                        continue;
                                                                                      }
                                                                                     
                                                                                      $selected = $key == $dongleConfig[$dongle]['destino'] ? 'selected' : '';
                                                                                      
                                                                                     
                                                                                      ?>
                                                                                      <option value="<?php echo $key?>" <?php echo $selected ?>><?php echo $key?></option>

                                                                                  <?php endforeach;?>


                                                                                </select>
                                                                             </td>                                                                
                                                                            </tr>

                                                                                                                                      
                                                                          
                                                                           
                                                                        </table>
                                                                     </div>                                                                   
                                                                     
                                                                     <div class="invisible"><br></div>
                                                                           
                                                                           
                                                                  </div>
                                                                  <div class="invisible"><br></div>
                                                                        
                                                               </td>
                                                            </tr>
                                                         </table>
                                                      </div>
                                                   </td>
                                                </tr>                                                            
                                                            
                                                     
                                             </tr>
                                          </table>
                                       </div>
                                       <div align="left" style="padding:20px">
                                          <input type="submit" value="Save Changes" class="button">
                                       </div>
                                    </form>
                                 </td>
                              </tr>
                           </table>
                        </div>
                     </td>
                  </tr>
               </table>
               
            </div>
         </td>
      </tr>
   </table>
<?php else:?>

   <table width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr>
         <td>
            <div style="padding:5px">
               <table border="0" cellpadding="0" cellspacing="0" width="99%">
                  <?php if(isset($sussess)) :?>
                  <tr>
                     <td colspan="2" class="title3" height="25" ><font color=green>Sucess</font></td>
                  </tr>
               <?php endif; ?>
                  <tr>
                     <td colspan="2" class="title2" height="25" >CALL IN</td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <div id="gsm_info" class="visable">
                           <table border="1" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                 <td height="25" class="title1" align="center" >CANAL</td>
                                 <td height="25" class="title1" align="center" >DESTINO</td>
                                 <td height="25" class="title1" align="center" >EDITAR</td>
                                 
                              </tr>

                              <?php                             
                             
                              foreach ($dongleConfig as $key => $value) :
                               
                                if (strlen($value['destino']) < 1) {
                                  $value['destino'] = '&nbsp;';
                                }
                                                                  
                             ?>

                             <tr>

                             


                              <tr>
                                 <td height="25" class="title11" align="center" id="l1_module_status_gsm"><?php echo $key?></td>
                                 <td height="25" class="text2" align="center" id="l1_module_status_gsm"><?php echo $value['destino']?></td>
                                 <td height="25" class="text2" align="center" id="l1_sms_login"><a href="config.php?type=ata_in_setting&dongle=<?php echo $key?>"><img src="images/files-edit-icon.png">&nbsp;&nbsp;</td></a>
                              </tr>
                              <?php endforeach;?>
                        
                           </table>
                        </div>
                     </td>
                  </tr>
               </table>
               
            </div>
         </td>
      </tr>
   </table>

<?php endif;?>