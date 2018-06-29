<?php
	require_once(__DIR__ . "/CollectionsClass.inc.php");
	require_once(__DIR__ . "/FactoidsClass.inc.php");
	require_once(__DIR__ . "/HrvtPage.inc.php");
	
	class FactoidsPage extends HrvtPage{
		function __construct(){
			ob_start();
			parent::__construct("Factoids");
		
			if ($this->user){
				$this->LoggedInBegin();
				} else {
				$this->NotLoggedIn();
				}
			return;
			}
		
		function LoggedInBegin(){
			FactoidsNavbar();
			
			switch($_GET['factoids']){
				case "new":
					$this->NewFactoid();
					break;
				case "view":
					$this->ViewFactoid();
					break;
				case "edit":
					if (isset($_GET['id'])){
						$this->EditFactoid($_GET['id']);
						break;
						}
						
					if (isset($_POST['id'])){
						$this->EditFactoid($_POST['id']);
						break;
						}
					break;
				case "delete":
					$this->DeleteFactoid();
					break;
				default:
					$this->DisplayFactoids();
					break;
				}
			
			return;
			}
			
		function DisplayFactoids(){
			}
		}
?>