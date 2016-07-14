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


$operadorasFile = '/etc/asterisk/chipcerto.conf';
$operadorasConfig = parse_ini_file($operadorasFile,true);

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


      if ($_POST['type'] == 'sip') {

        $sipConfig = parse_ini_file($configFile,true);

        $operadorasConfig['portabilidade']['type'] = 'sip';
        $sipConfig['portabilidadecelular']['type'] = 'peer';
        $sipConfig['portabilidadecelular']['fromdomain'] = 'sip.portabilidadecelular.com';
        $sipConfig['portabilidadecelular']['host'] = 'sip.portabilidadecelular.com';
        $sipConfig['portabilidadecelular']['port'] = '5060';
        $sipConfig['portabilidadecelular']['defaultuser'] = $_POST['username'];
        $sipConfig['portabilidadecelular']['username'] = $_POST['username'];
        $sipConfig['portabilidadecelular']['fromuser'] = $_POST['username'];
        $sipConfig['portabilidadecelular']['secret'] = $_POST['secret'];
        $sipConfig['portabilidadecelular']['context'] = 'redirectchipcerto';
        


        $fp = fopen($configFile, 'w');
        $sipConfig = listINIRecursive($sipConfig);
        fwrite($fp, $sipConfig);
        fclose($fp);

        unset( $operadorasConfig['portabilidade']['mysqluser']);
        unset( $operadorasConfig['portabilidade']['mysqlpass']);
        unset( $operadorasConfig['portabilidade']['mysqldb']);

      }elseif ($_POST['type'] == 'local') {
        $operadorasConfig['portabilidade']['type'] = 'local';
        $operadorasConfig['portabilidade']['mysqluser'] = $_POST['mysqluser'];
        $operadorasConfig['portabilidade']['mysqlpass'] = $_POST['mysqlpass'];
        $operadorasConfig['portabilidade']['mysqldb'] = $_POST['mysqldb'];

      }else{
        $operadorasConfig['portabilidade']['type'] = 'agi';
        unset( $operadorasConfig['portabilidade']['mysqluser']);
        unset( $operadorasConfig['portabilidade']['mysqlpass']);
        unset( $operadorasConfig['portabilidade']['mysqldb']);
      }


      $operadorasConfig['portabilidade']['username'] = $_POST['username'];
      $operadorasConfig['portabilidade']['password'] = $_POST['secret'];

      


       $fp = fopen($operadorasFile, 'w');
       $operadorasConfig = listINIRecursive($operadorasConfig);
       fwrite($fp, $operadorasConfig);
       fclose($fp);
       $sussess = true;

      

      $operadorasConfig = parse_ini_file($operadorasFile,true);



      
      /*
      $asmanager = new AGI_AsteriskManager;
      $asmanager->connect('localhost', 'magnus', 'magnussolution');
      $asmanager->Command("sip reload");*/
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
                  <tr>
                     <td colspan="2" class="title2" height="25" >PORTABILIDADE</td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <div id="gsm_info" class="visable">
                           <table height="100%" cellSpacing="0" cellPadding="0" width="100%" height="100%" border="0">
                              <tr>
                                 <td width="572" vAlign="top" bgColor="#ffffff">
                                    <form id="config_form" method="post" action="config.php?type=portabilidade&save=1">
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

                                                                             <td width="120" height="25" class="title1">Tipo</td>
                                                                             <td width="160" class="text">
                                                                                <select onChange="checkMysqlData(this.value)" name="type" id="endpoint_type_select" class="select" >
                                                                                  <option value="agi" <?php if($operadorasConfig['portabilidade']['type'] == 'agi') echo 'selected' ?> >Agi</option>
                                                                                   <option value="sip" <?php if($operadorasConfig['portabilidade']['type'] == 'sip') echo 'selected' ?> >Sip</option>
                                                                                   <option value="local" <?php if($operadorasConfig['portabilidade']['type'] == 'local') echo 'selected' ?>>Local/FTP</option>
                                                                                </select>
                                                                             </td>                                                                
                                                                            </tr>
                                                                           
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">Usuário</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="text" name="username" id="sip_display_name" value="<?php echo $operadorasConfig['portabilidade']['username']?>" class="edit">
                                                                              </td>
                                                                           </tr>                                                                            
                                                                           <tr>
                                                                              <td width="120" height="25" class="title1">Password</td>
                                                                              <td width="160" class="text">
                                                                                 <input type="password" name="secret" id="sip_auth_passwd" value="<?php echo $operadorasConfig['portabilidade']['password']?>" class="edit">
                                                                              </td>
                                                                           </tr>
                                                                        
                                                              
                                                                             <tr id="mysqlUser" style="display: none;" >
                                                                                <td width="120" height="25" class="title1">Mysql User</td>
                                                                                <td width="160" class="text">
                                                                                   <input type="text" name="mysqluser" id="sip_auth_passwd" value="<?php echo $operadorasConfig['portabilidade']['password']?>" class="edit">
                                                                                </td>
                                                                             </tr> 
                                                                             <tr id="mysqlPass" style="display: none;" >
                                                                                <td width="120" height="25" class="title1">Mysql Pass</td>
                                                                                <td width="160" class="text">
                                                                                   <input type="password" name="mysqlpass" id="sip_auth_passwd" value="<?php echo $operadorasConfig['portabilidade']['password']?>" class="edit">
                                                                                </td>
                                                                             </tr> 
                                                                             <tr id="mysqlDB" style="display: none;">
                                                                                <td width="120" height="25" class="title1">Mysql Database</td>
                                                                                <td width="160" class="text">
                                                                                   <input type="text" name="mysqldb" id="sip_auth_passwd" value="<?php echo $operadorasConfig['portabilidade']['password']?>" class="edit">
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
               
            </div>
         </td>
      </tr>
   </table>

   <script type="text/javascript">

   function checkMysqlData(val){
   if (val == 'local') {
    document.getElementById("mysqlUser").style.display = "table-row";
    document.getElementById("mysqlPass").style.display = "table-row";
    document.getElementById("mysqlDB").style.display = "table-row";
   }else{
    document.getElementById("mysqlUser").style.display = "none";
    document.getElementById("mysqlPass").style.display = "none";
    document.getElementById("mysqlDB").style.display = "none";
   };

  }


checkMysqlData('<?php echo $operadorasConfig["portabilidade"]["type"]?>');

</script>
