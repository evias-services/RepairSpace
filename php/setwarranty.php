<?php
		require( "func.php" );
		$f = mysql_connect( $m_host, $m_user, $m_pass ) or die( "Connexion." );
		$s = mysql_select_db( $m_bdd );
		switch( $_GET['t'] ) {
			case 0:
				$qQuery = mysql_query( "UPDATE `intratelier09`.`reparation` SET `iswarrantyvalid` = '1' WHERE `reparation`.`id` =".$_GET['rid']." LIMIT 1 ;" );
				break;
			case 1:
				$qQuery = mysql_query( "UPDATE `intratelier09`.`reparation` SET `isgonewarranty` = '1' WHERE `reparation`.`id` =".$_GET['rid']." LIMIT 1 ;" );
				break;
		}
		
?>
