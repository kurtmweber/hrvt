<?php
	require_once(__DIR__ . "/../Config.inc.php");
	require_once(__DIR__ . "/../Login.inc.php");
	
	require_once(__DIR__ . "/Common.inc.php");
	
	class LoginPage extends Login{
		function __construct(){
			ob_start();
			if (isset($_GET['login'])){
				parent::__construct("Login");
				PageTop("Login");
				$this->Begin();
				} elseif (isset($_GET['logout'])){
				parent::__construct("Logout");
				PageTop("Logout");
				LoggedInNavbar();
				$this->Logout();
				}
			
			return;
			}
			
		protected function Logout(){
			if ($this->user){
				$this->user->EndSession();
				}
				
			ob_end_clean();
			
			header("Location: index.php");
			
			return;
			}
			
		protected function Begin(){
			if (isset($_POST['SubmitLogin'])){
				try {
					$this->ProcessLogin();
					} catch (Exception $e){
					switch ($e->GetCode()){
						case LOGIN_FAILED_PASSWORD:
							$this->TabbedHtmlOut("<P>Invalid password.</P>");
							break;
						case LOGIN_FAILED_NOT_VERIFIED:
							$this->TabbedHtmlOut("<P>Your account has not been verified.</P>");
							break;
						case LOGIN_FAILED_NOT_APPROVED:
							$this->TabbedHtmlOut("<P>Your account still requires administrator approval.</P>");
							break;
						default:
							$this->UnrecoverableError();
						}
					}
				}
				
			if (!$this->user){
				LoggedOutNavbar();
				$this->ShowLoginForm(parent::GetLoginForm("login"));
				} else {
				ob_end_clean();
			
				header("Location: index.php");
				}
				
			return;
			}
			
		function ShowLoginForm($lForm){
			$this->TabbedHtmlOut($lForm->GenerateHtml());
			
			$this->TabLevel++;
			
			$this->TabbedHtmlOut($lForm->Contents['submitLoginField']->GenerateHtml());
			
			$this->TabbedHtmlOut($lForm->Contents['usernameLabel']->GenerateHtml(), false);
			$this->HtmlOut($lForm->Contents['usernameLabel']->Contents, false);
			$this->HtmlOut($lForm->Contents['usernameLabel']->ClosingTag());
			
			$this->TabbedHtmlOut($lForm->Contents['usernameField']->GenerateHtml());
			
			$this->TabbedHtmlOut("<BR>");
			
			$this->TabbedHtmlOut($lForm->Contents['passwordLabel']->GenerateHtml(), false);
			$this->HtmlOut($lForm->Contents['passwordLabel']->Contents, false);
			$this->HtmlOut($lForm->Contents['passwordLabel']->ClosingTag());
			
			$this->TabbedHtmlOut($lForm->Contents['passwordField']->GenerateHtml());
			
			$this->TabbedHtmlOut("<BR>");
			
			$this->TabbedHtmlOut($lForm->Contents['submitButton']->GenerateHtml());
			$this->TabbedHtmlOut($lForm->Contents['resetButton']->GenerateHtml());
			
			$this->TabLevel--;
			
			$this->TabbedHtmlOut($lForm->ClosingTag());
		}
			
		function __destruct(){
			PageBottom();
		
			ob_end_flush();
			parent::__destruct();
			
			return;
			}
		}
?>