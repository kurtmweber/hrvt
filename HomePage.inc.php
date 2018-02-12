<?php
	require_once(__DIR__ . "/../Config.inc.php");
	require_once(__DIR__ . "/../Page.inc.php");
	require_once(__DIR__ . "/../SecurePage.inc.php");
	
	require_once(__DIR__ . "/HrvtPage.inc.php");
	require_once(__DIR__ . "/Common.inc.php");
	
	class HomePage extends HrvtPage{
		function __construct(){
			parent::__construct("Home");
			return;
			}
			
		function LoggedIn(){
			LoggedOutNavbar();
			return;
			}
			
		function LoggedOut(){
			LoggedInNavbar();
			return;
			}
			
		function __destruct(){
			PageBottom();
			
			parent::__destruct();
			
			ob_end_flush();
			return;
			}
		}
?>