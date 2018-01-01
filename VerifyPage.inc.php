<?php
	require_once(__DIR__ . "/../Config.inc.php");
	require_once(__DIR__ . "/../Verify.inc.php");
	
	require_once(__DIR__ . "/Common.inc.php");

	class VerifyPage extends Verification{
		
		function __construct(){
			parent::__construct("Verify");
			
			ob_start();
			
			PageTop("Verify");
			
			$this->Begin();
			
			return;
			}
			
		function __destruct(){
			PageBottom();
			
			ob_end_flush();
			
			return;
			}
			
		function Begin(){
			if ($this->verifying){
				try {
					$this->ProcessVerification();
					} catch (Exception $e){
					switch ($e->getCode()){
						case E_USER_NO_EXIST:
							$this->Error("Username does not exist.");
							break;
						case E_NO_VER_CODE:
							$this->Error("No verification code for this username");
							break;
						default:
							$this->UnrecoverableError();
							break;
						}
					}
				} else {
				$this->ShowVerificationForm(parent::GetVerificationForm("verify"));
				}
			
			return;
			}
			
		function Error($errMsg){
			$this->TabbedHtmlOut("<P>$errMsg</P>");
			
			$this->ShowVerificationForm(parent::GetVerificationForm("verify"));
			
			return;
			}
			
		function ShowVerificationForm($vForm){
			$this->TabbedHtmlOut($vForm->GenerateHtml());
			
			$this->TabLevel++;
			
			$this->TabbedHtmlOut($vForm->Contents['usernameLabel']->GenerateHtml(), false);
			$this->HtmlOut($vForm->Contents['usernameLabel']->Contents, false);
			$this->HtmlOut($vForm->Contents['usernameLabel']->ClosingTag());
			
			$this->TabbedHtmlOut($vForm->Contents['usernameField']->GenerateHtml());
			
			$this->TabbedHtmlOut($vForm->Contents['verificationCodeLabel']->GenerateHtml(), false);
			$this->HtmlOut($vForm->Contents['verificationCodeLabel']->Contents, false);
			$this->HtmlOut($vForm->Contents['verificationCodeLabel']->ClosingTag());
			
			$this->TabbedHtmlOut($vForm->Contents['verificationCodeField']->GenerateHtml());
			
			$this->TabbedHtmlOut($vForm->Contents['submitButton']->GenerateHtml());
			$this->TabbedHtmlOut($vForm->Contents['resetButton']->GenerateHtml());
			
			$this->TabLevel--;
			
			$this->TabbedHtmlOut($vForm->ClosingTag());
			}
			
		}
?>