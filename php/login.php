<?php

	if( isset( $_GET['to'] ) )
	{
		echo '<form method="post" action="oneye.php">';
		echo '<input type="password" name="codepass" />';
		echo '<input type="submit" value="Login" />';
		echo '<input type="hidden" name="isTryLog" />';
		echo '</form>';
	}
	else
	{
		echo '<form method="post" action="index.php?p=login">';
		echo '<input type="password" name="codepass" />';
		echo '<input type="submit" value="Login" />';
		echo '<input type="hidden" name="isTryLog" />';
		echo '</form>';
	}

?>