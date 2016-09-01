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

if (isset($_GET['reload']) && $_GET['reload'] == 1) {
  $asmanager = new AGI_AsteriskManager;
  $asmanager->connect('localhost', 'magnus', 'magnussolution');
  $server = $asmanager->Command("dongle reload now");
  echo '<script lang="javascript">alert(\'Dongle Reload sucesso!\')</script>';
}

$configFile = '/etc/asterisk/chipcerto_dongle.conf';
$dongleConfig = parse_ini_file($configFile,true);

?>


<?php
   if (isset($_GET['name']) && isset($_GET['save']) && $_GET['save'] == 1 ) {
      $name = $_GET['name'];

      if (isset($_GET['delete'])) {
         unset($dongleConfig[$name]);
      }
      else if ($name == 'save') {


         foreach ($_POST as $key => $value) {
            if (strlen($value) < 1) {
               unset($_POST[$key]);
            }
         }
         /*$_POST['autodeletesms']=1;
         $_POST['resetdongle']=1;
         //$_POST['u2diag']=0;
         $_POST['usecallingpres']=1;
         $_POST['callingpres']='allowed_passed_screen';
         $_POST['disablesms']=0;
         $_POST['language']='pt_BR';
         $_POST['smsaspdu']=1;
         $_POST['mindtmfgap']=0;
         $_POST['mindtmfduration']=0;
         $_POST['mindtmfinterval']=0;
         $_POST['callwaiting']='';
         $_POST['initstate']='start';
         $_POST['dtmfmode']='auto';
         $_POST['disallow']='all';*/
         $_POST['context']='chipcerto_in';
         $_POST['destino']='';
        
         $canal = $_POST['canal'];
         unset($_POST['canal']);

         $dongleConfig[$canal] = $_POST;
      }else{
        foreach ($_POST as $key => $value) {

           $dongleConfig[$name][$key] = $_POST[$key];

           if (strlen($value) == 0) {
                 unset($dongleConfig[$name][$key]);
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
                  for ($i=0; $i < $indent * 5; $i++){ 
                    $str.= " "; 
                  }
                  if ($k == 'disable' && strlen($v) < 1) {
                    $v = 'no';
                  }
                  $str.= "$k = $v \r\n";
              }
          } 

          return $str;

       }

       $fp = fopen($configFile, 'w');
       fwrite($fp, listINIRecursive($dongleConfig));
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
      $title = 'ADICIONAR NOVO DONGLE';
      $dongleConfig[$name]['imei'] = $_POST['imei'];
   }      
   else{
      $name = $_GET['name'];
      $title = 'EDITAR DONGLE '. $_GET['name'];
   }

 ?>
   <table width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr>
         <td>
            <div style="padding:5px">
               <table border="0" cellpadding="0" cellspacing="0" width="99%">
                  <tr>
                     <td colspan="2" class="title2" height="25" > <?php echo $title?></td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <div id="gsm_info" class="visable">
                           <table height="100%" cellSpacing="0" cellPadding="0" width="100%" height="100%" border="0">
                              <tr>
                                 <td width="572" vAlign="top" bgColor="#ffffff">
                                    <form id="config_form" method="post" action="config.php?type=dongle&name=<?php echo $name?>&save=1">
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
                                                                            <td width="120" height="25" class="title1">Desativar</td>
                                                                             <td width="160" class="text">
                                                                                <select name="disable" id="endpoint_type_select" class="select" >
                                                                                   <option value="no" <?php if($dongleConfig[$name]['disable'] == 'no') echo 'selected' ?> >No</option>
                                                                                   <option value="yes" <?php if($dongleConfig[$name]['disable'] == 'yes') echo 'selected' ?>>Yes</option>
                                                                                </select>
                                                                             </td>                                                                
                                                                            </tr>

                                                                            <?php  if (isset($_GET['add'])): ?>
                                                                            <tr>
                                                                              <td width="120" height="25" class="title1">NOME CANAL</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="canal" id="sip_display_name" value="<?php echo $_POST['canal']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                            <?php endif;?>
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">Group</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="group" id="sip_display_name" value="<?php echo $dongleConfig[$name]['group']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                            <tr>
                                                                              <td width="120" height="25" class="title1">IMEI</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="imei" id="sip_registrar" value="<?php echo $dongleConfig[$name]['imei']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">NUMERO</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="exten" id="sip_registrar" value="<?php echo $dongleConfig[$name]['exten']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">rxgain</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="rxgain" id="sip_registrar" value="<?php echo $dongleConfig[$name]['rxgain']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">txgain</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="txgain" id="sip_registrar" value="<?php echo $dongleConfig[$name]['txgain']?>" class="edit">
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
                     <td colspan="2" class="title1" height="25" align="right" ><a href="config.php?type=dongle&add"><img src="images/add.png">&nbsp; ADICIONAR NOVO DONGLE</a></td>
                  </tr>
                  <tr>
                     <td colspan="2" class="title2" height="25" >DONGLES SETTING</td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <div id="gsm_info" class="visable">
                           <table border="1" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                 <td height="25" class="title1" align="center" >Name</td>
                                 <td height="25" class="title1" align="center" >DISABLE</td>
                                 <td height="25" class="title1" align="center" >GROUP</td>
                                 <td height="25" class="title1" align="center" >IMEI</td> 
                                 <td height="25" class="title1" align="center" >EDITAR</td>                                 
                              </tr>

                              <?php 
                              foreach ($dongleConfig as $key => $value) :

                                 if ($key == 'general' || $key == 'basico') {
                                    continue;
                                 }



                                 $value['disable'] = strlen($value['disable']) > 1 ? $value['disable'] : 'no';
                             ?>
                              <tr>
                                 <td height="25" class="title11" align="center" id="l1_module_status_gsm"><?php echo $key?></td>
                                 <td height="25" class="text2" align="center" id="l1_module_status_gsm"><?php echo $value['disable']?></td>
                                 <td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $value['group']?></td>                  
                                 <td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $value['imei']?></td>
                                 <td height="25" class="text2" align="center" id="l1_sms_login"><a href="config.php?type=dongle&name=<?php echo $key?>"><img src="images/files-edit-icon.png">&nbsp;&nbsp;<a href="config.php?type=dongle&save=1&delete=1&name=<?php echo $key?>"><img src="images/delete.png"></td></a>
                              </tr>
                              <?php endforeach;?>
                        
                           </table>
                           <table>
                            <tr>
                              <td height="25" class="text2" align="center"><input type="button" name="reload_dongle" class="button" value="Reload" onclick="window.location.href='config.php?type=dongle&reload=1'"></td>       
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

<?php endif;?>