<?php
	require( "func.php" );
	$f = mysql_connect( $m_host, $m_user, $m_pass ) or die( "Connexion." );
	$s = mysql_select_db( $m_bdd );
	$qDel = mysql_query( "DELETE FROM `intratelier09`.`eyetexts` WHERE `eyetexts`.`id` = ".$_GET['id']." LIMIT 1;" );
?>
