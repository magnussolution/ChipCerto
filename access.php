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
$configFile = '/etc/asterisk/chipcerto.conf';
$sipConfig = parse_ini_file($configFile,true);


session_start();

if (isset($_POST['login']) || isset($_POST['password'])) {
	

	if ($_POST['login'] == $sipConfig['access']['username'] && $_POST['password'] == $sipConfig['access']['password']) {
		$_SESSION['logged'] = true;
		header('Location: status.php');
	}else{
		echo "<center><font color=red>USUARIO OU SENHA INVALIDOS</font></center>";
	}
}
if (!isset($_SESSION['logged'])):
	

?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login Form</title>
  <link rel="stylesheet" href="style/login.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>ChipCerto</h1>
      <form method="post" action="access.php">
        <p><input type="text" name="login" value="" placeholder="Username"></p>
        <p><input type="password" name="password" value="" placeholder="Senha"></p>
        
        <p class="submit"><input type="submit" name="commit" value="Entrar"></p>
      </form>
    </div>
  </section>
  <center>
  <section class="about">
    <p class="login-help">
      &copy; 2005&ndash;2016 <a href="https://portabilidadecelular.com" target="_blank">Portabilidade</a> -
      <a href="https://www.portabilidadecelular.com" target="_blank">ChipCerto License</a><br>
      Original PSD by <a href="https://www.portabilidadecelular.com" target="_blank">Portabilidade</a>
  </section>
</center>
</body>
</html>
<?php 
exit;
endif; ?>