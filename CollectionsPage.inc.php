<?php

	require_once(__DIR__ . "/HrvtPage.inc.php");

	class CollectionsPage extends HrvtPage{
		function __construct(){
			parent::__construct("Collections");
		
			if ($this->user){
				$this->LoggedInBegin();
				}
			return;
			}
		
		function LoggedInBegin(){
			}
		
		function __destruct(){			
			parent::__destruct();
			return;
			}
		}
	
?>