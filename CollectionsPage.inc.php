<?php
	require_once(__DIR__ . "/CollectionsClass.inc.php");
	require_once(__DIR__ . "/HrvtPage.inc.php");

	class CollectionsPage extends HrvtPage{
		function __construct(){
			parent::__construct("Collections");
		
			if ($this->user){
				$this->LoggedInBegin();
				} else {
				$this->NotLoggedIn();
				}
			return;
			}
		
		function LoggedInBegin(){
			CollectionsNavbar();
			if ($_GET['collections'] == "new"){
				$this->NewCollection();
				} else {	
				$this->DisplayCollections();
				}
			
			return;
			}
			
		function DisplayCollections(){
			$this->TabbedHtmlOut("<CENTER>");
			$this->TabLevel++;
			$this->TabbedHtmlOut("<H2>Your Collections</H2>");
			$this->TabLevel--;
			$this->TabbedHtmlOut("</CENTER>");
			
			$collections = $this->hrvtUser->Collections();
			
			if (!$collections){
				$this->TabbedHtmlOut("<P>You have no collections.</P>");
				
				return;
				}
				
			$this->TabbedHtmlOut("<TABLE>");
			$this->TabLevel++;
			$this->TabbedHtmlOut("<TR>");
			$this->TabLevel++;
			$this->TabbedHtmlOut("<TH>Name</TH>");
			$this->TabbedHtmlOut("<TH>Created</TH>");
			$this->TabbedHtmlOut("<TH>Modified</TH>");
			$this->TabLevel--;
			
			$even = false;
			
			foreach ($collections as $curColl){
				if (!$even){
					$this->TabbedHtmlOut("<TR STYLE=\"background-color: #ddffdd\">");
					} else {
					$this->TabbedHtmlOut("<TR STYLE=\"background-color: #cccccc\">");
					}
					
				$this->TabLevel++;
				$this->TabbedHtmlOut("<TD><A HREF=\"index.php?collections=view&id=" . $curColl->Id() . "\" TITLE=\"" . $curColl->Description() . "\">" . $curColl->Title() . "</A></TD>");
				$this->TabbedHtmlOut("<TD>" . $curColl->CreationTime()->format("Y-m-d H:i:s") . "</TD>");
				$this->TabbedHtmlOut("<TD>" . $curColl->UpdateTime()->format("Y-m-d H:i:s") . "</TD>");
				$this->TabbedHtmlOut("<TD STYLE=\"font-size: small\"><A HREF=\"index.php?collections=edit&id=" . $curColl->Id() . "\" CLASS=\"collection-utility-link\">[edit]</A></TD>");
				$this->TabbedHtmlOut("<TD STYLE=\"font-size: small\"><A HREF=\"index.php?collections=delete&id=" . $curColl->Id() . "\" CLASS=\"collection-utility-link\">[delete]</A></TD>");
				$this->TabLevel--;
				$this->TabbedHtmlOut("</TR>");
				
				$even = !$even;
				}
			$this->TabLevel--;
			$this->TabbedHtmlOut("</TABLE>");
			return;
			}
			
		function NewCollection(){
			$this->TabbedHtmlOut("<CENTER>");
			$this->TabLevel++;
			$this->TabbedHtmlOut("<H2>New collection</H2>");
			$this->TabLevel--;
			$this->TabbedHtmlOut("</CENTER>");
			
			if (isset($_POST['newCollSubmit'])){
				if ($_POST['title'] == ""){
					$this->TabbedHtmlOut("You must enter a title.");
					$this->NewCollectionForm();
					
					return;
					}
				$collection = new Collection($this->user->GetUserId(), $_POST['title'], $_POST['description']);
				$collection->Store();
				
				$this->TabbedHtmlOut("Collection added.");
				} else {
				$this->NewCollectionForm();
				}
				
			return;
			}
			
		function NewCollectionForm(){
			$this->TabbedHtmlOut("<FORM ACTION=\"index.php?collections=new\" METHOD=\"POST\">");
			$this->TabLevel++;
			$this->TabbedHtmlOut("<LABEL FOR=\"title\">Title:</LABEL>");
			$this->TabbedHtmlOut("<INPUT TYPE=\"text\" NAME=\"title\" ID=\"title\" MAXLENGTH=255 SIZE=40>");
			$this->TabbedHtmlOut("<BR>");
			$this->TabbedHtmlOut("<LABEL FOR=\"description\">Description</LABEL>");
			$this->TabbedHtmlOut("<TEXTAREA NAME=\"description\" ID=\"description\" MAXLENGTH=65535 ROWS=10 COLS=40></TEXTAREA>");
			$this->TabbedHtmlOut("<BR>");
			$this->TabbedHtmlOut("<LABEL FOR=\"newCollSubmit\"></LABEL>");
			$this->TabbedHtmlOut("<INPUT TYPE=\"SUBMIT\" ID = \"newCollSubmit\" NAME=\"newCollSubmit\" VALUE=\"Submit\">");
			$this->TabbedHtmlOut("<INPUT TYPE=\"RESET\" VALUE=\"Reset\">");
			$this->TabLevel--;
			$this->TabbedHtmlOut("</FORM>");
			
			return;
			}
		
		function __destruct(){			
			parent::__destruct();
			return;
			}
		}
	
?>