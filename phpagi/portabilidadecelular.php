#!/usr/bin/php -q
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
if (function_exists('pcntl_signal'))
{
 pcntl_signal(SIGHUP, SIG_IGN);
}
require_once ('phpagi.php');
$agi = new AGI();

if ($argv[1] == 'destavaModem') {
	
	$canalOrinem = $agi->request['agi_channel'];
	$agi->verbose('Canal de origem '.$canalOrinem,5);

	$state_channel = $agi->channel_status($agi->request['agi_channel']);
	$state_channel = $state_channel['data'];
	$agi->verbose('Estatus do canal '.$state_channel,5);

	$dongle = $agi->get_variable("CDR(dstchannel)");
	$dongle = substr($dongle['data'], 7 ,-11);
	$agi->verbose('Dongle de destino '.$dongle,5);

	$dongleStatus = $agi->exec('dongleStatus', trim("$dongle,DONGLE_STATUS", ','));
	$dongleStatus = $agi->get_variable("DONGLE_STATUS");
	$dongleStatus = $dongleStatus['data'];
	$agi->verbose('Estatus do Dongle '.$dongleStatus);
  	if( $dongleStatus == 3 && $state_channel == 'Line is up' ) {
  		require_once 'phpagi-asmanager.php';
		$asmanager = new AGI_AsteriskManager;
		$asmanager->connect('localhost', 'magnus', 'magnussolution');
		$agi->verbose("Destrava modem ".$dongle,5);
		$asmanager->Command("dongle stop now ".$dongle);
		sleep(1);
		$asmanager->Command("dongle start ".$dongle);
	}
}else{
	$destination = $argv[1];

	$agi->verbose(print_r($argv,true));

	$operadorasFile = '/etc/asterisk/chipcerto.conf';
	$operadorasConfig = parse_ini_file($operadorasFile,true);

	$usuario = $operadorasConfig['portabilidade']['username'];
	$senha = $operadorasConfig['portabilidade']['password'];

	if ($operadorasConfig['portabilidade']['type'] == 'local') {
		$mysqluser = $operadorasConfig['portabilidade']['mysqluser'];
		$mysqlpass = $operadorasConfig['portabilidade']['mysqlpass'];
		$mysqldb = $operadorasConfig['portabilidade']['mysqldb'];

		$id = mysql_connect('localhost',$mysqluser, $mysqlpass);
		$con=mysql_select_db($mysqldb ,$id);

	    $destination = substr("$destination", 1);
	    $sql = "SELECT company FROM portabilidade  WHERE number = '$destination' LIMIT 1";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		if(is_array($row)){
		    $operadora = $row['company'];
		}else{
		      $sql = "SELECT company FROM portabilidade_prefix WHERE number = SUBSTRING('" . $destination . "',1,length(number)) ORDER BY LENGTH(number) DESC LIMIT 1";
		      $result = mysql_query($sql);
		      $row = mysql_fetch_array($result);
		     $operadora = $row['company'];
		}
		$agi->verbose($sql);
		mysql_close();

	}else{
		//numero enviado para o webservidor no formato 55 ddd nº
		$url = "http://consultas.portabilidadecelular.com/painel/consulta_numero.php?user=".$usuario."&pass=".$senha."&seache_number=".$destination;
		$agi->verbose($url,25);
		$operadora = file_get_contents($url);
	}
	$agi->verbose("Operadora " . $operadora);
	$agi->set_variable("OPERADORA", $operadora);
}
?>