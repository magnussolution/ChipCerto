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

$configFile = '/etc/asterisk/chipcerto.conf';

$passConfig = parse_ini_file($configFile,true);

?>


<?php
   if (isset($_GET['save']) && $_GET['save'] == 1 ) {

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

       if ($passConfig['access']['password'] != $_POST['oldsecret']) {
         $error = "Senha anterior errada!";
       }
       else if($_POST['newsecret']!= $_POST['confirmsecret']){
          $error = "Senhas não são iguais!";
       }
       else{

       
         $passConfig['access']['password'] = $_POST['newsecret'];  
          unset($_SESSION['logged']);   
        
         $fp = fopen($configFile, 'w');
         $passConfig = listINIRecursive($passConfig);
         fwrite($fp, $passConfig);
         fclose($fp);
         $sussess = true;
        }

      

      $passConfig = parse_ini_file($operadorasFile,true);
   }

?>



   <table width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr>
         <td>
            <div style="padding:5px">
               <table width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr>
         <td>
            <div style="padding:5px">
               <table border="0" cellpadding="0" cellspacing="0" width="99%">
                <?php if(isset($error)):?>
                  <tr>
                     <td colspan="2" class="title4" height="25" > <font color=red><?php echo $error;?></font></td>
                  </tr>
               
                <?php endif;?>
                <?php if(isset($sussess)):?>
                  <tr>
                     <td colspan="2" class="title4" height="25" > <font color=green>Alteração realizada com exito!</font></td>
                  </tr>
               
                <?php endif;?>

                  <tr>
                     <td colspan="2" class="title2" height="25" >ALTERAR SENHA</td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <div id="gsm_info" class="visable">
                           <table height="100%" cellSpacing="0" cellPadding="0" width="100%" height="100%" border="0">
                              <tr>
                                 <td width="572" vAlign="top" bgColor="#ffffff">
                                    <form id="config_form" method="post" action="tools.php?type=password&save=1">
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
                                                                              <td width="120" height="25" class="title1">Senha Anterior</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="password" name="oldsecret" id="sip_auth_passwd" value="<?php echo $operadorasConfig['portabilidade']['password']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                          <tr>
                                                                              <td width="120" height="25" class="title1">Nova Senha</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="password" name="newsecret" id="sip_auth_passwd" value="<?php echo $operadorasConfig['portabilidade']['password']?>" class="edit">
                                                                              </td>
                                                                           </tr>                                                                          
                                                                                                                                                       
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">Repita a Senha</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="password" name="confirmsecret" id="sip_auth_passwd" value="<?php echo $operadorasConfig['portabilidade']['password']?>" class="edit">
                                                                              </td>
                                                                           </tr>                                                                          
                                                                           
                                                                        </table>
                                                                     </div>                                                                   
                                                                     
                                                                     <div class="invisible"><br></div>
                                                                           
                                                                           
                                                                  </div>
                                                                        
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
                                          <input type="submit" value="Salvar" class="button">
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
               
            </div>
         </td>
      </tr>
   </table>
