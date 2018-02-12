<?php
	require_once(__DIR__ . "/../Config.inc.php");
	require_once(__DIR__ . "/../Page.inc.php");
	require_once(__DIR__ . "/../SecurePage.inc.php");
	
	require_once(__DIR__ . "/HrvtPage.inc.php");
	require_once(__DIR__ . "/Common.inc.php");
	
	class HomePage extends HrvtPage{
		function __construct(){
			parent::__construct("Home");
			
			if ($this->user){
				$this->LoggedInBegin();
				}
			return;
			}
			
		function LoggedInBegin(){
			$this->TabbedHtmlOut("<P>Hi, " . $this->user->GetUserName() . "!</P>");
			return;
			}
			
		
			
		function __destruct(){			
			parent::__destruct();
			return;
			}
		}
?>