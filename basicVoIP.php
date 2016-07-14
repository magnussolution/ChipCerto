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

$configFile = '/etc/asterisk/chipcerto_sip.conf';
$sipConfig = parse_ini_file($configFile,true);

?>


<?php
   if (isset($_GET['name']) && isset($_GET['save']) && $_GET['save'] == 1 ) {


      $name = $_GET['name'];

      if (isset($_GET['delete'])) {
         unset($sipConfig[$name]);
      }
      else if ($name == 'save') {


         foreach ($_POST as $key => $value) {
            if (strlen($value) < 1) {
               unset($_POST[$key]);
            }
         }
         $sipConfig[$_POST['defaultuser']] = $_POST;
      }
      else{
         

         foreach ($_POST as $key => $value) {

            $sipConfig[$name][$key] = $_POST[$key];

            if (strlen($value) == 0) {
                  unset($sipConfig[$name][$key]);
            }
         }
      }



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

       $fp = fopen($configFile, 'w');
       fwrite($fp, listINIRecursive($sipConfig));
       fclose($fp);
       unset($_GET['name']);
       $sussess = true;

      

      $asmanager = new AGI_AsteriskManager;
      $asmanager->connect('localhost', 'magnus', 'magnussolution');
      $asmanager->Command("sip reload");
   }

?>

<?php if (isset($_GET['name']) || isset($_GET['add']) ) :

   if (isset($_GET['add'])){
      $name = 'save';
      $title = 'ADICIONAR NOVA CONTA SIP';
      $sipConfig[$name]['type'] = 'friend';
      $sipConfig[$name]['context'] = 'chipcerto';
      $sipConfig[$name]['nat'] = 'force_rport,comedia';
      $sipConfig[$name]['codec'] = 'dynamic';
      $sipConfig[$name]['codec'] = 'gsm,alaw,ulaw';
   }      
   else{
      $name = $_GET['name'];
      $title = 'EDIT SIP '. $_GET['name'];
   }
      

  ?>
   <table width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr>
         <td>
            <div style="padding:5px">
               <table border="0" cellpadding="0" cellspacing="0" width="99%">
                  <tr>
                     <td colspan="2" class="title2" height="25" ><?php echo $title?></td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <div id="gsm_info" class="visable">
                           <table height="100%" cellSpacing="0" cellPadding="0" width="100%" height="100%" border="0">
                              <tr>
                                 <td width="572" vAlign="top" bgColor="#ffffff">
                                    <form id="config_form" method="post" action="config.php?type=calling&name=<?php echo $name?>&save=1">
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
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">Type</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="type" id="sip_phone_number" value="<?php echo $sipConfig[$name]['type']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">DefaultUser</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="defaultuser" id="sip_display_name" value="<?php echo $sipConfig[$name]['defaultuser']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                            <tr>
                                                                              <td width="120" height="25" class="title1">User</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="user" id="sip_registrar" value="<?php echo $sipConfig[$name]['user']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">From User</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="fromuser" id="sip_auth_id" value="<?php echo $sipConfig[$name]['fromuser']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">Password</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="password" name="secret" id="sip_auth_passwd" value="<?php echo $sipConfig[$name]['secret']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">Host</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="host" id="sip_proxy" value="<?php echo $sipConfig[$name]['host']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                          
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">Context</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="context" id="sip_register_expired" value="<?php echo $sipConfig[$name]['context']?>" class="edit" >
                                                                              </td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">Nat</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="nat" id="sip_outbound_proxy" value="<?php echo $sipConfig[$name]['nat']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">Codec</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="codec" id="sip_outbound_proxy" value="<?php echo $sipConfig[$name]['codec']?>" class="edit">
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
                     <td colspan="2" class="title1" height="25" align="right" ><a href="config.php?type=calling&add"><img src="images/add.png">&nbsp; ADICIONAR CONTA</a></td>
                  </tr>
                  <tr>
                     <td colspan="2" class="title2" height="25" >CONTAS SIP</td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <div id="gsm_info" class="visable">
                           <table border="1" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                 <td height="25" class="title1" align="center" >Nome</td>
                                 <td height="25" class="title1" align="center" >Defaultuser</td>
                                 <td height="25" class="title1" align="center" >Fromuser</td>
                                 <td height="25" class="title1" align="center" >Host</td>
                                 <td height="25" class="title1" align="center" >Type</td>
                                 <td height="25" class="title1" align="center" >User</td>
                                 <td height="25" class="title1" align="center" >Context</td>
                                 <td height="25" class="title1" align="center" >Nat</td>
                                 <td height="25" class="title1" align="center" >Codec</td>
                                 <td height="25" class="title1" align="center" >Açōes</td>
                                 
                              </tr>

                              <?php 

                              foreach ($sipConfig as $key => $value) :

                                 if ($key == 'general' || $key == 'portabilidadecelular') {
                                    continue;
                                 }

                                 $nat = strlen($value['nat']) > 1 ? $value['nat'] : $sipConfig['general']['nat'];
                             ?>
                              <tr>
                                 <td height="25" class="title11" align="center" id="l1_module_status_gsm"><?php echo $key?></td>
                                 <td height="25" class="text2" align="center" id="l1_module_status_gsm"><?php echo $value['defaultuser']?></td>
                                 <td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $value['fromuser']?></td>                  
                                 <td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $value['host']?></td>                  
                                 <td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $value['type']?></td>
                                 <td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $value['user']?></td>
                                 <td height="25" class="text2" align="center" id="l1_sms_login"><?php echo $value['context']?></td>
                                 <td height="25" class="text2" align="center" id="l1_sms_login"><?php echo $nat?></td>
                                 <td height="25" class="text2" align="center" id="l1_sms_login"><?php echo $value['codec']?></td>
                                 <td height="25" class="text2" align="center" id="l1_sms_login"><a href="config.php?type=calling&name=<?php echo $key?>"><img src="images/files-edit-icon.png">&nbsp;&nbsp;<a href="config.php?type=calling&save=1&delete=1&name=<?php echo $key?>"><img src="images/delete.png"></td></a>
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