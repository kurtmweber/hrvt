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
			
		function NewFactoid(){
			$this->TabbedHtmlOut("<CENTER>");
			$this->TabLevel++;
			$this->TabbedHtmlOut("<H2>New factoid</H2>");
			$this->TabLevel--;
			$this->TabbedHtmlOut("</CENTER>");
			
			if (!isset($_POST['newFactoidSubmit'])){
				$this->NewFactoidForm();
				return;
				}
				
			$successful = true;
				
			$factTitle = $_POST['title'];
			$factValue = $_POST['value'];
			$factComments = $_POST['comments'];
			$factStartDate = $_POST['startDate'];
			$factStartDateType = $_POST['startDateType'];
			$factStartDateRelation = $_POST['startDateRelation'];
			$factEndDate = $_POST['endDate'];
			$factEndDateType = $_POST['endDateType'];
			$factEndDateRelation = $_POST['endDateRelation'];
			$factCalendar = $_POST['calendar'];
			$factCollections = $_POST['collections'];
			
			if ($factTitle == ""){
				$this->TabbedHtmlOut("<P CLASS=\"invalid\">You must enter a title</P>");
				$successful = false;
				}
				
			if ($factValue == ""){
				$this->TabbedHtmlOut("<P CLASS=\"invalid\">You must enter a value</P>");
				$successful = false;
				}
			
			if (!$successful){
				$this->FactoidForm($factTitle, $factValue, $factComments, $factStartDate, $factStartDateType, $factStartDateRelation, $factEndDate, $factEndDateType, $factEndDateRelation, $factCalendar, $factCollections, "new", 0);
				return;
				}

			/*if ($_POST['title'] == ""){
				$this->TabbedHtmlOut("You must enter a title.");
				$this->NewFactoidForm();

				return;
				}*/
			/*$factoid = new Factoid($this->user->GetUserId(), $_POST['title'], $_POST['description']);
			$factoid->Store();

			$this->TabbedHtmlOut("Factoid added.");
				
			return;*/
			}
			
		function NewFactoidForm(){
			$this->FactoidForm("", "", "", "", "", "", "", "", "", "", "", "new", 0);
			}
			
		function FactoidForm($factTitle, $factValue, $factComments, $factStartDate, $factStartDateType, $factStartDateRelation, $factEndDate, $factEndDateType, $factEndDateRelation, $factCalendar, $factCollections, $action, $id){
			$this->TabbedHtmlOut("<FORM ACTION=\"index.php?factoids=" . $action . "\" METHOD=\"POST\">");
			$this->TabLevel++;
			
			// do not check value of ID field when creating a new factoid, only when updating an existing one
			$this->TabbedHtmlOut("<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"" . $id . "\">");
			$this->TabbedHtmlOut("<LABEL FOR=\"title\">Title:</LABEL>");
			$this->TabbedHtmlOut("<INPUT TYPE=\"text\" NAME=\"title\" ID=\"title\" MAXLENGTH=255 SIZE=40 VALUE=\"" . $factTitle . "\">");
			$this->TabbedHtmlOut("<BR>");
			$this->TabbedHtmlOut("<LABEL FOR=\"value\">Value</LABEL>");
			$this->TabbedHtmlOut("<TEXTAREA NAME=\"value\" ID=\"value\" MAXLENGTH=65535 ROWS=10 COLS=40>" . $factValue . "</TEXTAREA>");
			$this->TabbedHtmlOut("<BR>");
			$this->TabbedHtmlOut("<LABEL FOR=\"title\">Comments:</LABEL>");
			$this->TabbedHtmlOut("<INPUT TYPE=\"text\" NAME=\"comments\" ID=\"comments\" MALENGTH=255 SIZE=40 VALUE=\"" . $factComments . "\">");
			$this->TabbedHtmlOut("<BR>");
			$this->TabbedHtmlOut("<LABEL FOR=\"startDate\">Start date:</LABEL>");
			$this->TabbedHtmlOut("<INPUT TYPE=\"date\" NAME=\"startDate\" ID=\"startDate\" VALUE=\"" . $factStartDate . "\">");
			
			$this->TabbedHtmlOut("<SELECT NAME=\"startDateType\">");
			$this->TabLevel++;
			$this->TabbedHtmlOut("<OPTION>");
			$this->TabbedHtmlOut("<OPTION VALUE=\"exact\"", false);
			if ($factStartDateType == "exact"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">Exact");
			$this->TabbedHtmlOut("<OPTION VALUE=\"approximate\"", false);
			if ($factStartDateType == "approximate"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">Approximate");
			$this->TabLevel--;
			$this->TabbedHtmlOut("</SELECT>");
			
			$this->TabbedHtmlOut("<SELECT NAME=\"startDateRelation\">");
			$this->TabLevel++;
			$this->TabbedHtmlOut("<OPTION>");
			$this->TabbedHtmlOut("<OPTION VALUE=\"before\"", false);
			if ($factStartDateRelation == "before"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">Before");
			$this->TabbedHtmlOut("<OPTION VALUE=\"on\"", false);
			if ($factStartDateRelation == "on"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">On");
			$this->TabbedHtmlOut("<OPTION VALUE=\"after\"", false);
			if ($factStartDateRelation == "after"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">After");
			$this->TabbedHtmlOut("<OPTION VALUE=\"onBefore\"", false);
			if ($factStartDateRelation == "onBefore"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">On or before");
			$this->TabbedHtmlOut("<OPTION VALUE=\"onAfter\"", false);
			if ($factStartDateRelation == "onAfter"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">On or after");
			$this->TabLevel--;
			$this->TabbedHtmlOut("</SELECT>");
			
			$this->TabbedHtmlOut("<BR>");
			$this->TabbedHtmlOut("<LABEL FOR=\"endDate\">End date:</LABEL>");
			$this->TabbedHtmlOut("<INPUT TYPE=\"date\" NAME=\"endDate\" ID=\"startDate\" VALUE=\"" . $factEndDate . "\">");
			
			$this->TabbedHtmlOut("<SELECT NAME=\"endDateType\">");
			$this->TabLevel++;
			$this->TabbedHtmlOut("<OPTION>");
			$this->TabbedHtmlOut("<OPTION VALUE=\"exact\"", false);
			if ($factEndDateType == "exact"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">Exact");
			$this->TabbedHtmlOut("<OPTION VALUE=\"approximate\"", false);
			if ($factEndDateType == "approximate"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">Approximate");
			$this->TabLevel--;
			$this->TabbedHtmlOut("</SELECT>");
			
			$this->TabbedHtmlOut("<SELECT NAME=\"endDateRelation\">");
			$this->TabLevel++;
			$this->TabbedHtmlOut("<OPTION>");
			$this->TabbedHtmlOut("<OPTION VALUE=\"before\"", false);
			if ($factEndDateRelation == "before"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">Before");
			$this->TabbedHtmlOut("<OPTION VALUE=\"on\"", false);
			if ($factEndDateRelation == "on"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">On");
			$this->TabbedHtmlOut("<OPTION VALUE=\"after\"", false);
			if ($factEndDateRelation == "after"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">After");
			$this->TabbedHtmlOut("<OPTION VALUE=\"onBefore\"", false);
			if ($factEndDateRelation == "onBefore"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">On or before");
			$this->TabbedHtmlOut("<OPTION VALUE=\"onAfter\"", false);
			if ($factEndDateRelation == "onAfter"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">On or after");
			$this->TabLevel--;
			$this->TabbedHtmlOut("</SELECT>");
			
			$this->TabbedHtmlOut("<BR>");
			$this->TabbedHtmlOut("<LABEL FOR=\"calendar\">Calendar:</LABEL>");
			$this->TabbedHtmlOut("<SELECT NAME=\"calendar\" ID=\"calendar\">");
			$this->TabLevel++;
			$this->TabbedHtmlOut("<OPTION>");
			$this->TabbedHtmlOut("<OPTION VALUE=\"gregorian\"", false);
			if ($factCalendar == "gregorian"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">Gregorian");
			$this->TabbedHtmlOut("<OPTION VALUE=\"julian\"", false);
			if ($factCalendar == "julian"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">Julian");
			$this->TabbedHtmlOut("<OPTION VALUE=\"hebrew\"", false);
			if ($factCalendar == "hebrew"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">Hebrew");
			$this->TabbedHtmlOut("<OPTION VALUE=\"french\"", false);
			if ($factCalendar == "french"){
				$this->HtmlOut(" SELECTED", false);
				}
			$this->HtmlOut(">French revolutionary");
			$this->TabLevel--;
			$this->TabbedHtmlOut("</SELECT>");
			
			$this->TabbedHtmlOut("<BR>");
			
			$collections = $this->hrvtUser->Collections();
			
			$this->TabbedHtmlOut("<LABEL FOR=\"collections\">Initial collections:</LABEL>");
			$this->TabbedHtmlOut("<SELECT NAME=\"collections\" ID=\"collections\" SIZE=\"5\" MULTIPLE>");
			$this->TabLevel++;
				foreach ($collections as $curColl){
					$this->TabbedHtmlOut("<OPTION VALUE=\"" . $curColl->Id() . "\"", false);
					if ($factCollections == $curColl->Id()){
						$this->HtmlOut(" SELECTED", false);
						}
					$this->HtmlOut(">" . $curColl->Title());
					}
			$this->TabLevel--;
			$this->TabbedHtmlOut("</SELECT>");
			
			$this->TabbedHtmlOut("<BR>");
			$this->TabbedHtmlOut("<LABEL FOR=\"newFactoidSubmit\"></LABEL>");
			$this->TabbedHtmlOut("<INPUT TYPE=\"SUBMIT\" ID = \"newFactoidSubmit\" NAME=\"newFactoidSubmit\" VALUE=\"Submit\">");
			$this->TabbedHtmlOut("<INPUT TYPE=\"RESET\" VALUE=\"Reset\">");
			$this->TabLevel--;
			$this->TabbedHtmlOut("</FORM>");
			
			return;
			}
		}
?>