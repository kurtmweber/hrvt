<?php
	require_once("Config.inc.php");
	require_once("SecurePage.inc.php");
	require_once("UserClass.inc.php");
	
	class UserPage extends SecurePage{
		function __construct(){
			parent::__construct("Home");
			
			$this->user = $this->GetUser();
			
			if ($this->user === false){
				$this->NotLoggedIn();
				} else {
				$this->Begin();
				}
			}
			
		function Begin(){
			$this->LoggedInNavbar();
			$this->UserPageNavbar();
			$userName = $this->user->GetUserName();
			
			$this->TabbedHtmlOut("<P>Welcome, " . $userName . "</P>");
			
			return;
			}
			
		function UserPageNavbar(){
?>
		<NAV CLASS="subnav">
			<A HREF="index.php?user" CLASS="navbar-link">[loading area]</A> | <A HREF="index.php?user&past" CLASS="navbar-link">[past flights]</A> | <A HREF="index.php?user&profile" CLASS="navbar-link">[view/edit profile]</A> | <A HREF="index.php?aircraft&find" CLASS="navbar-link">[find aircraft]</A>
		</NAV>
<?php
			}
			
		function __destruct(){
			parent::__destruct();
			}
		}
?>