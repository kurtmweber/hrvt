<?php
	require_once(__DIR__ . "/../Config.inc.php");
	require_once(__DIR__ . "/../Page.inc.php");
	require_once(__DIR__ . "/../SecurePage.inc.php");
	
	require_once(__DIR__ . "/Common.inc.php");

class HrvtPage extends SecurePage{
	protected $hrvtUser;
	
	function __construct($PageTitle){
		parent::__construct($PageTitle);
			
		PageTop($PageTitle);
		
		if (!$this->user){
			LoggedOutNavbar();
			} else {
			LoggedInNavbar();
			}
		return;
		}
		
	function __destruct(){
		PageBottom();
		
		ob_end_flush();
		
		parent::__destruct();
		}
		
	}

?>