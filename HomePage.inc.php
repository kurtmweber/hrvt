<?php
	require_once(__DIR__ . "/../Config.inc.php");
	require_once(__DIR__ . "/../Page.inc.php");
	
	require_once(__DIR__ . "/Common.inc.php");
	
	class HomePage extends Page{
		function __construct(){
			parent::__construct("Home");
			
			PageTop("Home");
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