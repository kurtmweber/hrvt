<?php
	require_once(__DIR__ . "/CollectionsClass.inc.php");
	require_once(__DIR__ . "/HrvtPage.inc.php");

	class CollectionsPage extends HrvtPage{
		function __construct(){
			ob_start();
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
			
			switch($_GET['collections']){
				case "new":
					$this->NewCollection();
					break;
				case "view":
					$this->ViewCollection();
					break;
				case "edit":
					if (isset($_GET['id'])){
						$this->EditCollection($_GET['id']);
						break;
						}
						
					if (isset($_POST['id'])){
						$this->EditCollection($_POST['id']);
						break;
						}
					break;
				case "delete":
					$this->DeleteCollection();
					break;
				default:
					$this->DisplayCollections();
					break;
				}
			
			return;
			}
			
		function GetCollection($collId){
			try {
				$getColl = new Collection($collId, $this->user->GetUserId());
				} catch (Exception $e){
				switch ($e->getCode()){
					case HRVT_ERROR_NO_PERMISSION:
						$this->TabbedHtmlOut("<P>You do not have permission to view or delete this collection.</P>");
						return;
					case HRVT_ERROR_COLLECTION_NOT_EXIST:
						$this->TabbedHtmlOut("<P>This collection does not exist.</P>");
						return;
					}
				}
				
			return $getColl;
			}
			
		function DeleteCollection(){
			$collId = $_GET['id'];
			
			if (isset($_POST['cancel'])){
				ob_end_clean();
				header("Location: index.php?collections");
				}
				
			if (isset($_POST['delete'])){
				if (!isset($_POST['id'])){
					$this->TabbedHtmlOut("<P>No collection specified.</P>");
					}
				$delColl = $this->GetCollection($_POST['id']);
				
				if ($delColl){
					$delColl->Delete();
					
					$this->TabbedHtmlOut("<P>Deleted.</P>");
					}
				
				return;
				}
				
			$delColl = $this->GetCollection($collId);
			
			$this->TabbedHtmlOut("<P>You are deleting collection #" . $collId . ", <SPAN TITLE=\"" . $delColl->Description() . "\">\"" . $delColl->Title() . "\"</SPAN>, with xxx members.");
			$this->TabbedHtmlOut("<FORM ACTION=\"index.php?collections=delete\" METHOD=\"POST\">");
			$this->TabLevel++;
			$this->TabbedHtmlOut("<INPUT TYPE=\"HIDDEN\" NAME=\"id\" VALUE=\"" . $collId . "\">");
			$this->TabbedHtmlOut("<INPUT TYPE=\"SUBMIT\" NAME=\"delete\" VALUE=\"Delete\">");
			$this->TabbedHtmlOut("<INPUT TYPE=\"SUBMIT\" NAME=\"cancel\" VALUE=\"Cancel\">");
			$this->TabLevel--;
			$this->TabbedHtmlOut("</FORM>");
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
			$this->CollectionForm("", "", "new", 0);
			}
			
		function EditCollection($id){
			if (isset($_POST['newCollSubmit'])){
				$editColl = $this->GetCollection($id);
				$editColl->Title($_POST['title']);
				$editColl->Description($_POST['description']);
				
				$editColl->Store();
				
				$this->TabbedHtmlOut("<P>Updated successfully.</P>");
				return;
				}
				
			$editColl = $this->GetCollection($id);
			$this->CollectionForm($editColl->Title(), $editColl->Description(), "edit", $id);
			
			return;
			}
		
		function CollectionForm($collTitle, $collDesc, $action, $id){
			$this->TabbedHtmlOut("<FORM ACTION=\"index.php?collections=" . $action . "\" METHOD=\"POST\">");
			$this->TabLevel++;
			
			// do not check value of ID field when creating a new collection, only when updating an existing one
			$this->TabbedHtmlOut("<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"" . $id . "\">");
			$this->TabbedHtmlOut("<LABEL FOR=\"title\">Title:</LABEL>");
			$this->TabbedHtmlOut("<INPUT TYPE=\"text\" NAME=\"title\" ID=\"title\" MAXLENGTH=255 SIZE=40 VALUE=\"" . $collTitle . "\">");
			$this->TabbedHtmlOut("<BR>");
			$this->TabbedHtmlOut("<LABEL FOR=\"description\">Description</LABEL>");
			$this->TabbedHtmlOut("<TEXTAREA NAME=\"description\" ID=\"description\" MAXLENGTH=65535 ROWS=10 COLS=40>" . $collDesc . "</TEXTAREA>");
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
			ob_end_flush();
			return;
			}
		}
	
?>