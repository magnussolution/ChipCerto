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

$configFile = '/etc/asterisk/chipcerto_extensions.conf';


$operadorasFile = '/etc/asterisk/chipcerto.conf';
$operadorasConfig = parse_ini_file($operadorasFile,true);
?>


<?php
   if (isset($_GET['operadora']) && isset($_GET['save']) && $_GET['save'] == 1 ) {
      $operadora = $_GET['operadora'];

      $prefix = preg_replace("/ /", "", $_POST['prefix']);


      
      $operadorasConfig['rotas'][$operadora] = $_POST['canal'].','.$prefix.','.$_POST['ddd'];

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
                  $str.= "$k = '$v' \r\n";
              }
          }

          return $str;

       }


       $fp = fopen($operadorasFile, 'w');
     
       $operadorasConfig = listINIRecursive($operadorasConfig);
       fwrite($fp, $operadorasConfig);
       fclose($fp);
       unset($_GET['operadora']);
       $sussess = true;

      

      $operadorasConfig = parse_ini_file($operadorasFile,true);


      $extensions = '[redirectchipcerto]
      ';
      foreach ($operadorasConfig['rotas'] as $key => $value) {
         //echo '<pre>';
         //echo $key . ' => '.$value;
 
     
         $rotas = explode(",", $value);
         $canal = isset($rotas[0]) ? $rotas[0] : '&nbsp;';
         $prefix = isset($rotas[1]) && strlen($rotas[1]) > 0 ? $rotas[1] : '';
         $ddd = isset($rotas[2]) && strlen($rotas[2]) > 0 ? $rotas[2] : '&nbsp;';
         $prefix = preg_replace("/ /", "", $prefix);

          if ($key == '553') {
              $extensions .= 'exten => _55[3,9]X.,1,Dial('.$_POST['canal'].')
              same => n,hangup()
              ';
          }else{




           //5532001140040001 Chamada LOCAL
           //exten = _55320.,1,Dial(SIP/TRONCO_VIVO/${EXTEN:5}) ; Redirecionamento VIVO
           $extensions .= 'exten => _'.$key.'0'.$ddd.'.,1,Dial(dongle/'.$canal.'/${EXTEN:8})
              same => n,hangup()
           ';

           //5532005540040001 CHAMADA DDDD
           //exten = _55320.,1,Dial(SIP/TRONCO_VIVO/${EXTEN:5}) ; Redirecionamento VIVO
           $extensions .= 'exten => _'.$key.'.,1,Dial(dongle/'.$canal.'/'.$prefix.'${EXTEN:6})
              same => n,hangup()
           ';
         }

       }

       $extensions .= '
       
       exten => h,1,Agi(portabilidadecelular.php,destavaModem)


        exten => _55998.,1,Wait(1)
        same => n,Answer()
        same => n,Playback(ChipCertoCredito)
        same => n,Hangup()

       ';
      if ($operadorasConfig['portabilidade']['type'] == 'sip') {
      $extensions .= '

[chipcerto]
exten => _0ZX[6-9]X.,1,NoOp(######CONSULTA DA PORTABILIDADE######)
same => n,Dial(SIP/portabilidadecelular/${EXTEN})
same => n,CONGESTION(0)
same => n,Hangup()

exten => _[7-9]XXXXXXX,1,NoOp(######CONSULTA DA PORTABILIDADE######)
same => n,Dial(SIP/portabilidadecelular/0'.$_POST['ddd'].'${EXTEN})
same => n,CONGESTION(0)
same => n,Hangup()

exten => _9XXXXXXXX,1,NoOp(######CONSULTA DA PORTABILIDADE######)
same => n,Dial(SIP/portabilidadecelular/0'.$_POST['ddd'].'${EXTEN})
same => n,CONGESTION(0)
same => n,Hangup()
';

}else {

  $extensions .= '

  [chipcerto]
exten => _0ZX[6-9]X.,1,NoOp(######CONSULTA DA PORTABILIDADE######)
same => n,Agi(portabilidadecelular.php,${EXTEN});REALIZA CONSULTA EM WWW.PORTABILIDADECELULAR.COM
same => n,Goto(redirectchipcerto,${OPERADORA}${EXTEN},1)
same => n,Hangup()

exten => _[7-9]XXXXXXX,1,NoOp(######CONSULTA DA PORTABILIDADE######)
same => n,Agi(portabilidadecelular.php,0'.$_POST['ddd'].'${EXTEN});REALIZA CONSULTA EM WWW.PORTABILIDADECELULAR.COM
same => n,Goto(redirectchipcerto,${OPERADORA}0'.$_POST['ddd'].'${EXTEN},1)
same => n,Hangup()

exten => _9XXXXXXXX,1,NoOp(######CONSULTA DA PORTABILIDADE######)
same => n,Agi(portabilidadecelular.php,0'.$_POST['ddd'].'${EXTEN});REALIZA CONSULTA EM WWW.PORTABILIDADECELULAR.COM
same => n,Goto(redirectchipcerto,${OPERADORA}0'.$_POST['ddd'].'${EXTEN},1)
same => n,Hangup()';

}

       // print_r($extensions);
       $fp = fopen('/etc/asterisk/chipcerto_extensions.conf', 'w');
       fwrite($fp, $extensions);
       fclose($fp);

      

      $asmanager = new AGI_AsteriskManager;
      $asmanager->connect('localhost', 'magnus', 'magnussolution');
      $asmanager->Command("dialplan reload");
   }

?>

<?php if (isset($_GET['operadora'])) : $operadora = $_GET['operadora']; ?>


   <?php
      $rotas = explode(",", $operadorasConfig['rotas'][$operadora]);

      $canal = isset($rotas[0]) ? $rotas[0] : '&nbsp;';
      $prefix = isset($rotas[1]) && strlen($rotas[1]) > 0 ? $rotas[1] : '';
      $prefix = preg_replace("/ /", "", $prefix);
      $ddd = isset($rotas[2]) && strlen($rotas[2]) > 0 ? $rotas[2] : '&nbsp;';
   ?>
   <table width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr>
         <td>
            <div style="padding:5px">
               <table border="0" cellpadding="0" cellspacing="0" width="99%">
                  <tr>
                     <td colspan="2" class="title2" height="25" >EDIT ROUTE TO <?php echo $operadorasConfig['operadoras'][$operadora]?></td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <div id="gsm_info" class="visable">
                           <table height="100%" cellSpacing="0" cellPadding="0" width="100%" height="100%" border="0">
                              <tr>
                                 <td width="572" vAlign="top" bgColor="#ffffff">
                                    <form id="config_form" method="post" action="config.php?type=ata_setting&operadora=<?php echo $operadora?>&save=1">
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
                                                                          <?php if ($_GET['operadora'] != 553):?>
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">DDD</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="ddd" id="sip_phone_number" value="<?php echo $ddd?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                            <?php endif?>
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1"> <?php echo $_GET['operadora'] != 553 ?   'Destino': 'Comando Dial Completo'; ?></td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="canal" id="sip_display_name" value="<?php echo $canal?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                           <?php if ($_GET['operadora'] != 553):?>
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">Codigo Operadora</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="prefix" id="sip_auth_id" value="<?php echo $prefix?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                         <?php endif?>
                                                                           
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
                     <td colspan="2" class="title2" height="25" >CALL OUT</td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <div id="gsm_info" class="visable">
                           <table border="1" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                 <td height="25" class="title1" align="center" >Operadora</td>
                                 <td height="25" class="title1" align="center" >DDD Local</td>
                                 <td height="25" class="title1" align="center" >DESTINO</td>
                                 <td height="25" class="title1" align="center" >CODIGO OPERADORA</td>
                                 <td height="25" class="title1" align="center" >EDITAR</td>
                                 
                              </tr>

                              <?php 
                              
                           
                              foreach ($operadorasConfig['operadoras'] as $key => $value) :

         
                                 if (substr($value,0, 1) == '[' || strlen($value) < 2) {
                                    continue;
                                 }

                                

                                 $rotas = explode(",", $operadorasConfig['rotas'][$key]);
                                 $canal = isset($rotas[0]) ? $rotas[0] : '&nbsp;';
                                 $prefix = isset($rotas[1]) && strlen($rotas[1]) > 0 ? $rotas[1] : '&nbsp;';
                                 $ddd = isset($rotas[2]) && strlen($rotas[2]) > 0 ? $rotas[2] : '&nbsp;';
                                 //echo "<pre>";
                                  //print_r($operadorasConfig['rotas']);
                                // print_r($rotas);
                              
                                                                  
                             ?>
                              <tr>
                                 <td height="25" class="title11" align="center" id="l1_module_status_gsm"><?php echo $value?></td>
                                 <td height="25" class="text2" align="center" id="l1_module_status_gsm"><?php echo $ddd?></td>
                                 <td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $canal?></td>                  
                                 <td height="25" class="text2" align="center" id="l1_gsm_sim"><?php echo $prefix?></td> 
                                 <td height="25" class="text2" align="center" id="l1_sms_login"><a href="config.php?type=ata_setting&operadora=<?php echo $key?>"><img src="images/files-edit-icon.png"></td></a>
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