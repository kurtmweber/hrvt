<?php
	require_once(__DIR__ . "/../Config.inc.php");
	require_once(__DIR__ . "/../Verify.inc.php");
	
	require_once(__DIR__ . "/Common.inc.php");

	class VerifyPage extends Verification{
		
		function __construct(){
			parent::__construct("Verify");
			
			ob_start();
			
			PageTop("Verify");
			
			$this->TabbedHtmlOut("<H1 CLASS=\"PageHeader\">Email Verification</H1>");
			
			$this->Begin();
			
			return;
			}
			
		function __destruct(){
			PageBottom();
			
			ob_end_flush();
			
			return;
			}
			
		function Begin(){
			global $confAdminApprovalRequired;
			
			if ($this->verifying){
				try {
					if ($this->ProcessVerification() == VERIFY_SUCCEEDED){
						$this->TabbedHtmlOut("<P>Verification succeeded.", false);
						if ($confAdminApprovalRequired){
							$this->HtmlOut("  After you verify your email address, you will need to wait for an administrator to approve your account.", false);
							}
						$this->HtmlOut("</P>");
						}
						$this->TabbedHtmlOut("<A HREF=\"index.php\">Return home</A>");
					} catch (Exception $e){
					switch ($e->getCode()){
						case E_USER_NO_EXIST:
							$this->TabbedHtmlOut("<P CLASS=\"invalid\">Username does not exist.</P>");
							break;
						case E_NO_VER_CODE:
							$this->TabbedHtmlOut("<P CLASS=\"invalid\">No verification code for this username.</P>");
							break;
						case E_INVALID_VERIFICATION_CODE:
							$this->TabbedHtmlOut("<P CLASS=\"invalid\">Invalid verification code.</P>");
							break;
						default:
							$this->TabbedHtmlOut("<P CLASS=\"invalid\">Unrecoverable error.</P>");
							ob_end_flush();
							exit();
						}
					$this->ShowVerificationForm(parent::GetVerificationForm("verify"));
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
			
			$vForm->Contents['usernameLabel']->FieldFor("usernameField");
			$this->TabbedHtmlOut($vForm->Contents['usernameLabel']->GenerateHtml(), false);
			$this->HtmlOut($vForm->Contents['usernameLabel']->Contents, false);
			$this->HtmlOut($vForm->Contents['usernameLabel']->ClosingTag());
			
			$vForm->Contents['usernameField']->Id("usernameField");
			$this->TabbedHtmlOut($vForm->Contents['usernameField']->GenerateHtml());
			
			$vForm->Contents['verificationCodeLabel']->FieldFor("verificationCodeField");
			$this->TabbedHtmlOut($vForm->Contents['verificationCodeLabel']->GenerateHtml(), false);
			$this->HtmlOut($vForm->Contents['verificationCodeLabel']->Contents, false);
			$this->HtmlOut($vForm->Contents['verificationCodeLabel']->ClosingTag());
			
			$vForm->Contents['verificationCodeField']->Id("verificationCodeField");
			$this->TabbedHtmlOut($vForm->Contents['verificationCodeField']->GenerateHtml());
			
			$this->TabbedHtmlOut($vForm->Contents['submitButton']->GenerateHtml());
			$this->TabbedHtmlOut($vForm->Contents['resetButton']->GenerateHtml());
			
			$this->TabLevel--;
			
			$this->TabbedHtmlOut($vForm->ClosingTag());
			}
			
		}
?>