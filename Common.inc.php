<?php
	require_once(__DIR__ . "/../Config.inc.php");
	
	function PageTop($title, $loggedIn = false){
		printf("<HTML>\n");
		printf("\t<HEAD>\n");
		printf("\t\t<TITLE>%s: %s</TITLE>\n", SITENAME, $title);
		printf("\t\t<LINK rel=\"stylesheet\" type=\"text/css\" href=\"sitecode/hrvt.css\">\n");
		printf("\t</HEAD>\n");
		printf("\t<BODY>\n");
		
		return;
		}
		
	function LoggedOutNavbar(){
?>
		<NAV>
			<A HREF="index.php" CLASS="navbar-link">[home]</A> | <A HREF="index.php?login" CLASS="navbar-link">[login]</A>
		</NAV>
<?php
		}
		
	function LoggedInNavbar(){
?>
		<NAV>
			<A HREF="index.php" CLASS="navbar-link">[home]</A> | <A HREF="index.php?collections" CLASS="navbar-link">[collections]</A> | <A HREF="index.php?logout" CLASS="navbar-link">[logout]</A>
		</NAV>
<?php
		}
		
	function PageBottom(){
		printf("\t</BODY>\n");
		printf("</HTML>");
		
		return;
		}
?>