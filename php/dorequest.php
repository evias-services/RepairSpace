<?php

	// AJAX Work 
	// dorequest is read with an ID and a REQUEST ID ..
	
	require( "func.php" );
	mysql_connect( $m_host, $m_user, $m_pass ) or die( "Connexion." );
	mysql_select_db( $m_bdd );
		
	$id = -1;
	if( !isset( $_GET['id'] ) )
		$id = 1;
	else
		$id = $_GET['id'];
		
	$req = -1;
	if( !isset( $_GET['req'] ) )
		$req = 69;
	else
		$req = $_GET['req'];
		
	switch( $req ) {
		// ###############################################
		// CHANGE EYETEXT STATE OF DONE
		// ###############################################
		case 1:
			// Set eyeTexts state to DONE (1)
			$get = mysql_query( "SELECT * FROM eyetexts WHERE id= '".$id."' LIMIT 1;" ) or die( mysql_error( ) );
			$r = mysql_fetch_array( $get );
			$done = $r[6];
			if( $r[6] == 0 )
				$q = mysql_query( "UPDATE `intratelier09`.`eyetexts` SET `done` = '1' WHERE `eyetexts`.`id` =".$id." LIMIT 1 ;" ) or die( mysql_error( ) );
			else
				$q = mysql_query( "UPDATE `intratelier09`.`eyetexts` SET `done` = '0' WHERE `eyetexts`.`id` =".$id." LIMIT 1 ;" ) or die( mysql_error( ) );
			break;
		
		// ###############################################
		// CHANGE EYETEXT STATE OF SHOW
		// ###############################################
		case 2:
			// Set eyeTexts state to DONE (1)
			$get = mysql_query( "SELECT * FROM eyetexts WHERE id='".$id."' LIMIT 1;" ) or die( mysql_error( ) );
			$r = mysql_fetch_array( $get );
			$show = $r[5];
			if( $show == 0 )
				$q = mysql_query( "UPDATE `intratelier09`.`eyetexts` SET `show` = '1' WHERE `eyetexts`.`id` =".$id." LIMIT 1 ;" ) or die( mysql_error( ) );
			else
				$q = mysql_query( "UPDATE `intratelier09`.`eyetexts` SET `show` = '0' WHERE `eyetexts`.`id` =".$id." LIMIT 1 ;" ) or die( mysql_error( ) );
			break;
			
		// ###############################################
		// DELETE AN EYETEXT (NOT RECOVERABLE)
		// ###############################################
		case 3:
			$qDel = mysql_query( "DELETE FROM `intratelier09`.`eyetexts` WHERE `eyetexts`.`id` = ".$id." LIMIT 1;" );
			break;
			
		// ###############################################
		// SET JOB STATE AS DONE AND REEVALUATE PERCENTAGE FOR THE WHOLE REPAIR
		// ###############################################
		case 10:
			$qP = mysql_query( "SELECT * FROM prester WHERE id = '".$id."' LIMIT 1;" );
			$rP = mysql_fetch_array( $qP );
			if( isset( $_COOKIE['tech_log'] ) && !empty( $_COOKIE['tech_log'] ) )
			{
				$techN = $_COOKIE['tech_log'];
				$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
				$rT = mysql_fetch_array( $qT );
				if( $rP[5] != $rT[0] )
					$qSet = mysql_query( "UPDATE `intratelier09`.`prester` SET `id_technicien` = '".$rT[0]."' WHERE `id`='".$id."' LIMIT 1;" );
			}
			$qSet = mysql_query( "UPDATE `intratelier09`.`prester` SET `done` = '0' WHERE `id`='".$id."' LIMIT 1;" );
			$qtS = mysql_query( "SELECT * FROM prester WHERE id='".$id."' LIMIT 1;" );
			$rSet = mysql_fetch_array( $qtS );
			$iRep = $rSet[2];
			$qPA = mysql_query( "SELECT * FROM prester WHERE `reparation_id` = '".$iRep."';" );
			$iPr = mysql_numrows( $qPA );
			$totalDone = 0;
				
			while( $rPr = mysql_fetch_array( $qPA ) )
				$totalDone += $rPr[4];
				
			$qRep = mysql_query( "SELECT * FROM reparation WHERE id='".$iRep."' LIMIT 1;" );
			$rRep = mysql_fetch_array( $qRep );
			$pA = $rRep[4];
				
			$totalDone = $totalDone / $iPr;
				
			if( $totalDone > $pA ) {
				$pA = $totalDone;
				if( $pA == 100 )
					$qSet2 = mysql_query( "UPDATE `intratelier09`.`reparation` SET `pourcent_avancee` = '".$pA."', `is_done` = '1' WHERE `id`='".$iRep."' LIMIT 1;" );
				else
					$qSet2 = mysql_query( "UPDATE `intratelier09`.`reparation` SET `pourcent_avancee` = '".$pA."' WHERE `id`='".$iRep."' LIMIT 1;" );
			}
			break;
			
			
			
		case 11:
			$qP = mysql_query( "SELECT * FROM prester WHERE id = '".$id."' LIMIT 1;" );
			$rP = mysql_fetch_array( $qP );
			if( isset( $_COOKIE['tech_log'] ) && !empty( $_COOKIE['tech_log'] ) )
			{
				$techN = $_COOKIE['tech_log'];
				$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
				$rT = mysql_fetch_array( $qT );
				if( $rP[5] != $rT[0] )
					$qSet = mysql_query( "UPDATE `intratelier09`.`prester` SET `id_technicien` = '".$rT[0]."' WHERE `id`='".$id."' LIMIT 1;" );
			}
			$qSet = mysql_query( "UPDATE `intratelier09`.`prester` SET `done` = '100' WHERE `id`='".$id."' LIMIT 1;" );
			$qtS = mysql_query( "SELECT * FROM prester WHERE id='".$id."' LIMIT 1;" );
			$rSet = mysql_fetch_array( $qtS );
			$iRep = $rSet[2];
			$qPA = mysql_query( "SELECT * FROM prester WHERE `reparation_id` = '".$iRep."';" );
			$iPr = mysql_numrows( $qPA );
			$totalDone = 0;
				
			while( $rPr = mysql_fetch_array( $qPA ) )
				$totalDone += $rPr[4];
				
			$qRep = mysql_query( "SELECT * FROM reparation WHERE id='".$iRep."' LIMIT 1;" );
			$rRep = mysql_fetch_array( $qRep );
			$pA = $rRep[4];
				
			$totalDone = $totalDone / $iPr;
				
			if( $totalDone > $pA ) {
				$pA = $totalDone;
				if( $pA == 100 )
					$qSet2 = mysql_query( "UPDATE `intratelier09`.`reparation` SET `pourcent_avancee` = '".$pA."', `is_done` = '1' WHERE `id`='".$iRep."' LIMIT 1;" );
				else
					$qSet2 = mysql_query( "UPDATE `intratelier09`.`reparation` SET `pourcent_avancee` = '".$pA."' WHERE `id`='".$iRep."' LIMIT 1;" );
			}
			break;
			
		case 12:
			$qDel = mysql_query( "DELETE FROM `intratelier09`.`prestation` WHERE `prestation`.`id` = ".$id." LIMIT 1;" );
			break;
			
		case 13:
			$qQuery = mysql_query( "UPDATE `intratelier09`.`reparation` SET `isgonewarranty` = '1' WHERE `reparation`.`id` =".$id." LIMIT 1 ;" );
			break;
			
		case 14:
			$qQuery = mysql_query( "UPDATE `intratelier09`.`reparation` SET `isgonewarranty` = '0' WHERE `reparation`.`id` =".$id." LIMIT 1 ;" );
			break;
			
			// #############################################
			//	DELETE AN AWAY REPAIR (NOT RECOVERABLE)
			// #############################################
			case 21:
				$qDel = mysql_query( "DELETE FROM `intratelier09`.`deplacement` WHERE `deplacement`.`id` = ".$id." LIMIT 1;" );
				break;
				
			// #############################################
			//	DELETE A DISTANCE (NOT RECOVERABLE)
			// #############################################
			case 22:
				$qDel = mysql_query( "DELETE FROM `intratelier09`.`distance` WHERE `distance`.`id` = ".$id." LIMIT 1;" );
				break;
				
			case 31:
					$qSet2 = mysql_query( "UPDATE `intratelier09`.`technicien` SET `fonction` = '".$_GET['more']."' WHERE `id`='".$_GET['id']."' LIMIT 1;" );
					echo '<span>Fonction du technicien modifi&eacute;e avec succ&egrave;s</span>';
				break;
				
			case 32:
					$qSet2 = mysql_query( "UPDATE `intratelier09`.`technicien` SET `lvl` = '".$_GET['more']."' WHERE `id`='".$_GET['id']."' LIMIT 1;" );
					echo '<span>Modification de niveau termin&eacute;e avec succ&egrave;s</span>';
				break;
				
			case 33:
					$more = $_GET['more'];
					$aMore = explode( 'xxxx', $more );
					$qSet2 = mysql_query( "UPDATE `intratelier09`.`technicien` SET `nom` = '".$aMore[0]."', `codepass`='".$aMore[1]."', `mobile`='".$aMore[2]."', `mail`='".$aMore[3]."' WHERE `id`='".$_GET['id']."' LIMIT 1;" ) or die( 'Erreur d\'envoi de données: '.mysql_error( ) );
					echo '<span>Modification de donn&eacute;es personnelles du technicien effectu&eacute;e avec succ&egrave;s</span>';					
				break;
				
			case 34:
				$qDel = mysql_query( "DELETE FROM `intratelier09`.`technicien` WHERE `technicien`.`id` = ".$id." LIMIT 1;" );
				break;
	
	
		// ###############################################
		// REQUEST 69 is the log REQUEST
		// ###############################################
		case 69:
			$sAct = $_GET['act'];
			$iT = $_GET['tech'];
			$qInsert = mysql_query( "INSERT INTO `intratelier`.`overall_log` ( `technicien_id` ,`log_action` ,`date` ,`time`) VALUES ('".$iT."', '".$sAct."', '".date( 'd.m.Y' )."', '".date( 'H:i' )."');" );
			if( mysql_insert_id( ) )
				echo 'Done successfully.';
			break;
		
		// ###############################################
		// DATA LOST
		// ###############################################
		default:
			return "Erreur d'envoi de requête.";
			break;
	}

?>
