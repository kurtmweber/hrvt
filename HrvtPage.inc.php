<?php
	require_once(__DIR__ . "/../Config.inc.php");
	require_once(__DIR__ . "/../Page.inc.php");
	require_once(__DIR__ . "/../SecurePage.inc.php");
	
	require_once(__DIR__ . "/Common.inc.php");

class HrvtPage extends SecurePage{
	function __construct($PageTitle){
		parent::__construct("Home");
			
		PageTop("Home");
		
		if (!$this->user){
			LoggedOutNavbar();
			} else {
			LoggedInNavbar();
			}
		return;
		}
		
	}

?>