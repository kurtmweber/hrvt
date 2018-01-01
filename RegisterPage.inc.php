<?php
	require_once(__DIR__ . "/../Config.inc.php");
	require_once(__DIR__ . "/../Register.inc.php");
	
	require_once(__DIR__ . "/Common.inc.php");
	
	class RegisterPage extends Registration{
		function __construct(){
			parent::__construct("Register");
			
			$this->user = $this->GetUser();
			
			ob_start();
			PageTop("Register");
			
			$this->TabbedHtmlOut("<H1 CLASS=\"PageHeader\">Registration</H1>");
				
			$this->Begin();
			
			return;
			}
			
		function Begin(){			
			if ($this->user === false){
				if (isset($_POST['SubmitRegistration'])){
					$this->ProcessRegistration();
					} else {
					$this->TabbedHtmlOut("<P>All fields are required.</P>");
					$this->ShowRegistrationForm(parent::GetRegistrationForm("register"));
					}
				} else {
				$this->TabbedHtmlOut("<P CLASS=\"invalid\">You cannot register while logged in.</P>");
				}
				
			return;
			}
			
		function ShowRegistrationForm($rForm, $invalids = false){
			$this->TabbedHtmlOut($rForm->GenerateHtml());
			
			$this->TabLevel++;
			
			$this->TabbedHtmlOut($rForm->Contents['submitField']->GenerateHtml());
			
			if ($invalids['userName']){
				$rForm->Contents['usernameLabel']->ClassAttr("invalid");
				$rForm->Contents['usernameField']->ClassAttr("invalid");
				}
				
			if ($invalids['password']){
				$rForm->Contents['passwordLabel']->ClassAttr("invalid");
				$rForm->Contents['passwordField']->ClassAttr("invalid");
				}
				
			if ($invalids['email']){
				$rForm->Contents['emailLabel']->ClassAttr("invalid");
				$rForm->Contents['emailField']->ClassAttr("invalid");
				}
				
			if ($invalids['birthDay']){
				$rForm->Contents['birthDateLabel']->ClassAttr("invalid");
				$rForm->Contents['birthYearField']->ClassAttr("invalid");
				$rForm->Contents['birthMonthField']->ClassAttr("invalid");
				$rForm->Contents['birthDateField']->ClassAttr("invalid");
				}
			
			$rForm->Contents['usernameLabel']->FieldFor("usernameField");
			$this->TabbedHtmlOut($rForm->Contents['usernameLabel']->GenerateHtml(), false);
			$this->HtmlOut($rForm->Contents['usernameLabel']->Contents, false);
			$this->HtmlOut($rForm->Contents['usernameLabel']->ClosingTag());
			
			$rForm->Contents['usernameField']->Id("usernameField");
			$this->TabbedHtmlOut($rForm->Contents['usernameField']->GenerateHtml());
			
			$this->TabbedHtmlOut("<BR>");
			
			$rForm->Contents['emailLabel']->FieldFor("emailField");
			$this->TabbedHtmlOut($rForm->Contents['emailLabel']->GenerateHtml(), false);
			$this->HtmlOut($rForm->Contents['emailLabel']->Contents, false);
			$this->HtmlOut($rForm->Contents['emailLabel']->ClosingTag());
			
			$rForm->Contents['emailField']->Id("emailField");
			$this->TabbedHtmlOut($rForm->Contents['emailField']->GenerateHtml());
			
			$this->TabbedHtmlOut("<BR>");
			
			$rForm->Contents['passwordLabel']->FieldFor("passwordField");
			$this->TabbedHtmlOut($rForm->Contents['passwordLabel']->GenerateHtml(), false);
			$this->HtmlOut($rForm->Contents['passwordLabel']->Contents, false);
			$this->HtmlOut($rForm->Contents['passwordLabel']->ClosingTag());
			
			$rForm->Contents['passwordField']->Id("passwordField");
			$this->TabbedHtmlOut($rForm->Contents['passwordField']->GenerateHtml());
			
			$this->TabbedHtmlOut("<BR>");
			
			$rForm->Contents['birthDateLabel']->FieldFor("birthYearField");
			$this->TabbedHtmlOut($rForm->Contents['birthDateLabel']->GenerateHtml(), false);
			$this->HtmlOut($rForm->Contents['birthDateLabel']->Contents, false);
			$this->HtmlOut($rForm->Contents['birthDateLabel']->ClosingTag());
			
			$rForm->Contents['birthYearField']->Id("birthYearField");
			$this->TabbedHtmlOut($rForm->Contents['birthYearField']->GenerateHtml());
			
			$this->TabLevel++;
				foreach ($rForm->Contents['birthYearField']->Contents as $year){
					$this->TabbedHtmlOut($year->GenerateHtml(), false);
					$this->HtmlOut($year->Contents, false);
					$this->HtmlOut($year->ClosingTag());
					}			
			$this->TabLevel--;
			
			$this->TabbedHtmlOut($rForm->Contents['birthYearField']->ClosingTag());
			
			$this->TabbedHtmlOut($rForm->Contents['birthMonthField']->GenerateHtml());
			
			$this->TabLevel++;
				foreach ($rForm->Contents['birthMonthField']->Contents as $month){
					$this->TabbedHtmlOut($month->GenerateHtml(), false);
					$this->HtmlOut($month->Contents, false);
					$this->HtmlOut($month->ClosingTag());
					}
			$this->TabLevel--;
			
			$this->TabbedHtmlOut($rForm->Contents['birthMonthField']->ClosingTag());
			
			$this->TabbedHtmlOut($rForm->Contents['birthDateField']->GenerateHtml());
			
			$this->TabLevel++;
				foreach ($rForm->Contents['birthDateField']->Contents as $date){
					$this->TabbedHtmlOut($date->GenerateHtml(), false);
					$this->HtmlOut($date->Contents, false);
					$this->HtmlOut($date->ClosingTag());
					}
			$this->TabLevel--;
			
			$this->TabbedHtmlOut($rForm->Contents['birthDateField']->ClosingTag());
			
			$this->TabbedHtmlOut("<BR>");
			
			$tosLabel = new LabelElement;
			$tosLabel->Contents = "By submitting, you agree to the <A HREF=\"index.php?tos\">Terms of Service</A>";
			$tosLabel->FieldFor("submitButton");
			$this->TabbedHtmlOut($tosLabel->GenerateHtml(), false);
			$this->HtmlOut($tosLabel->Contents, false);
			$this->HtmlOut($tosLabel->ClosingTag());
			
			$rForm->Contents['submitButton']->Id("submitButton");
			$this->TabbedHtmlOut($rForm->Contents['submitButton']->GenerateHtml());
			$this->TabbedHtmlOut($rForm->Contents['resetButton']->GenerateHtml());
			
			$this->TabLevel--;
			
			$this->TabbedHtmlOut($rForm->ClosingTag());
			return;
			}
			
		protected function ProcessRegistration(){
			global $confAdminApprovalRequired;
			
			try {
				if(($invalids = $this->Register()) != REGISTRATION_SUCCEEDED){
					if (isset($invalids['userName'])){
						$this->TabbedHtmlOut("<P CLASS=\"invalid\">Invalid user name.</P>");
						}
					if (isset($invalids['email'])){
						$this->TabbedHtmlOut("<P CLASS=\"invalid\">Invalid email address.</P>");
						}
					if (isset($invalids['password'])){
						$this->TabbedHtmlOut("<P CLASS=\"invalid\">Invalid password.</P>");
						}
					if (isset($invalids['birthDay'])){
						$this->TabbedHtmlOut("<P CLASS=\"invalid\">Invalid birth date.</P>");
						}
					} else {
					$this->TabbedHtmlOut("<P>Registration succeeded.  You should receive an email confirmation shortly.", false);
					if ($confAdminApprovalRequired){
						$this->HtmlOut("  After you verify your email address, you will need to wait for an administrator to approve your account.", false);
						}
					$this->HtmlOut("</P>");
					return;
					}
				} catch (Exception $e){
				switch ($e->getCode()){
					case E_USERNAME_EXISTS:
						$this->TabbedHtmlOut("<P CLASS=\"invalid\">Username already in use</P>");
						$invalids['userName'] = true;
						break;
					case E_EMAIL_EXISTS:
						$this->TabbedHtmlOut("<P CLASS=\"invalid\">Email address already in use</P>");
						$invalids['email'] = true;
						break;
					default:
						$this->TabbedHtmlOut("<P CLASS=\"invalid\">Unrecoverable error</P>");
						ob_end_flush();
						exit();
					}
				}
				
			$this->ShowRegistrationForm(parent::GetRegistrationForm("register"), $invalids);
			
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