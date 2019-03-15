<?php

	$techN = $_COOKIE['tech_log'];
	$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
	$rT = mysql_fetch_array( $qT );
	$idTech = $rT[0];

	// ***************************************************************************
		// Données
	// ***************************************************************************
	
	// *************************
		// ajout meeting
	// *************************
	if( isset( $_POST['isAddMeeting'] ) )
	{	
		$libCl = $_POST['libCl'];
		$addrCl = $_POST['addrCl'];
		$cpCl = $_POST['cpCl'];
		$villeCl = $_POST['villeCl'];
		$telCl = $_POST['telCl'];
		
		$qnD = mysql_query( "SELECT * FROM date WHERE `string_date`='".$_POST['date-meeting']."' LIMIT 1;" );
		if( mysql_numrows( $qnD ) == 0 ) {		
			$qInsD = mysql_query( "INSERT INTO `date` ( `jour`, `mois`, `annee`, `string_date` ) VALUES( '".substr( $_POST['date-meeting'], 0, 2 )."','".substr( $_POST['date-meeting'], 3, 2 )."','".substr( $_POST['date-meeting'], 6, 4 )."','".$_POST['date-meeting']."' );" );
			$idDate = mysql_insert_id( );
		}
		else
		{
			$rD = mysql_fetch_array( $qnD );
			$idDate = $rD[0];
		}			
		$idCl = 2;
		if( !isset( $_POST['idCl'] ) || empty( $_POST['idCl'] ) )
		{
			$insCl = mysql_query( "INSERT INTO `intratelier09`.`clients` (`id` ,`libelle` ,`code_id` ,`lname` ,`fname` ,`numtel` ,`numfax` ,`addr` ,`cp` ,`ville` ,`email` ,`provider` ,`type_adsl` ,`a_belgtv` ,`belgtv_dispo` ,`date_id`)VALUES (NULL , '".$libCl."', '', '', '', '".$telCl."', '', '".$addrCl."', '".$cpCl."', '".$villeCl."', '', '0', '', '0', '0', '".$idDate."');" );
			$idCl = mysql_insert_id( );
		}
		else
			$idCl = $_POST['idCl'];
			
		$sDate = $_POST['date-meeting'];
		$sTime = $_POST['time-meeting'];
		$idCTech= $_POST['technician'];
		$iDuree = $_POST['duree-meeting'];
		$sDesc = $_POST['desc-meeting'];
		
		$insMeeting = mysql_query( "INSERT INTO `intratelier09`.`meeting` (`id` ,`technicien_id` ,`date_id` ,`client_id` ,`time` ,`duree` ,`desc` )VALUES (NULL , '".$idCTech."', '".$idDate."', '".$idCl."', '".$sTime."', '".$iDuree."', '".$sDesc."');" );
		$idMeeting = mysql_insert_id( );
		if( $idMeeting )
		{
			
			echo '<script type="text/javascript">';
				echo 'logNow( \''.$idTech.'\', \'Ajouté rendez-vous. [Meeting: '.$idMeeting.'][Technicien: '.$idCTech.'][Client: '.$idCl.']\' );';
				echo 'window.location.href = \'index.php?p=away&addedData=1&showweek='.date('d.m.Y').'\';';
			echo '</script>';
		}
		else
		{
			echo '<script type="text/javascript">';
				echo 'window.location.href = \'index.php?p=away&addedData=0&showweek='.date('d.m.Y').'\';';
			echo '</script>';
		}
	}
	
		// *************************
		// ajout event
	// *************************
	if( isset( $_POST['isAddEvent'] ) )
	{	
		
		$qnD = mysql_query( "SELECT * FROM date WHERE `string_date`='".$_POST['date-event']."' LIMIT 1;" );
		if( mysql_numrows( $qnD ) == 0 ) {		
			$qInsD = mysql_query( "INSERT INTO `date` ( `jour`, `mois`, `annee`, `string_date` ) VALUES( '".substr( $_POST['date-event'], 0, 2 )."','".substr( $_POST['date-event'], 3, 2 )."','".substr( $_POST['date-event'], 6, 4 )."','".$_POST['date-event']."' );" );
			$idDate = mysql_insert_id( );
		}
		else
		{
			$rD = mysql_fetch_array( $qnD );
			$idDate = $rD[0];
		}	
					
		$sDate = $_POST['date-event'];
		$sTime = $_POST['time-event'];
		$idCTech= $_POST['technician'];
		$iDuree = $_POST['duree-event'];
		$sDesc = $_POST['desc-event'];
		
		$insEvent = mysql_query( "INSERT INTO `intratelier09`.`event` (`id` ,`technicien_id` ,`date_id`,`time` ,`event_desc` ,`hours_duree` )VALUES (NULL , '".$idCTech."', '".$idDate."', '".$sTime."', '".$sDesc."', '".$iDuree."');" );
		$idEvent = mysql_insert_id( );
		if( $idEvent )
		{
			echo '<script type="text/javascript">';
				echo 'logNow( \''.$idTech.'\', \'Ajouté évènement. [Event: '.$idEvent.'][Technicien: '.$idCTech.']\' );';
				echo 'window.location.href = \'index.php?p=away&addedData=1&showweek='.date('d.m.Y').'\';';
			echo '</script>';
		}
		else
		{
			echo '<script type="text/javascript">';
				echo 'window.location.href = \'index.php?p=away&addedData=0\';';
			echo '</script>';
		}
		
	}
	
	
		// *************************
		// ajout tache
	// *************************
	if( isset( $_POST['isAddTask'] ) )
	{	
		
		$qnD = mysql_query( "SELECT * FROM date WHERE `string_date`='".$_POST['date-task']."' LIMIT 1;" );
		if( mysql_numrows( $qnD ) == 0 ) {		
			$qInsD = mysql_query( "INSERT INTO `date` ( `jour`, `mois`, `annee`, `string_date` ) VALUES( '".substr( $_POST['date-task'], 0, 2 )."','".substr( $_POST['date-task'], 3, 2 )."','".substr( $_POST['date-task'], 6, 4 )."','".$_POST['date-task']."' );" );
			$idDate = mysql_insert_id( );
		}
		else
		{
			$rD = mysql_fetch_array( $qnD );
			$idDate = $rD[0];
		}	
					
		$sDate = $_POST['date-task'];
		$sTime = $_POST['time-task'];
		$idCTech= $_POST['technician'];
		$iDuree = $_POST['duree-task'];
		$sDesc = $_POST['desc-task'];
		
		$insTask = mysql_query( "INSERT INTO `intratelier09`.`task` (`id` ,`technicien_id` ,`date_id`,`time` ,`duree`,`desc` )VALUES (NULL , '".$idCTech."', '".$idDate."', '".$sTime."', '".$iDuree."', '".$sDesc."');" );
		$idTask = mysql_insert_id( );
		if( $idTask )
		{
			echo '<script type="text/javascript">';
				echo 'logNow( \''.$idTech.'\', \'Ajouté tâche. [Task: '.$idTask.'][Technicien: '.$idCTech.']\' );';
				echo 'window.location.href = \'index.php?p=away&addedData=1&showweek='.date('d.m.Y').'\';';
			echo '</script>';
		}
		else
		{
			echo '<script type="text/javascript">';
				echo 'window.location.href = \'index.php?p=away&addedData=0\';';
			echo '</script>';
		}
		
	}



// ***************************************************************************
		// Affichage
	// ***************************************************************************

	
	// *************************
		// affiche meeting
	// *************************
	if( isset( $_GET['addMeeting'] ) )
	{
		echo '<div id="add-data">';
			echo '<h1>Prévoir un rendez-vous</h1>';
			echo '<form method="post" action="index.php?p=cal">';
			echo '<div id="info-client">';
				echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
					echo '<tr>';
						echo '<td>'.'&nbsp;'.'</td>';
						echo '<td>'.'<span style="font-family: Georgia; font-size: 10pt; font-weight: bold; text-decoration: underline; color: #039">Informations sur le client</span>'.'</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label for="libCl">Libellé: </label>'.'</td>';
						echo '<td>'.'<input id="libCl" class="text" type="text" value="" name="libCl" />'.'</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label for="addrCl">Adresse: </label>'.'</td>';
						echo '<td>'.'<input id="addrCl" class="text" type="text" value="" name="addrCl" />'.'</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label for="cpCl">Code postal: </label>'.'</td>';
						echo '<td>'.'<input id="cpCl" class="text" type="text" value="" name="cpCl" />'.'</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label for="villeCl">Ville: </label>'.'</td>';
						echo '<td>'.'<input id="villeCl" class="text" type="text" value="" name="villeCl" />'.'</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label for="telCl">Téléphone: </label>'.'</td>';
						echo '<td>'.'<input id="telCl" class="text" type="text" value="" name="telCl" />'.'</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label for="idCl">ID interne: </label>'.'</td>';
						echo '<td>'.'<input id="idCl" style="width:150px;" class="text" type="text" value="" name="idCl" /><input style="margin-left: 5px;" class="button" type="submit" onclick="document.getElementById( \'idCl\' ).value=\'\';document.getElementById( \'libCl\' ).value=\'\';document.getElementById( \'addrCl\' ).value=\'\';document.getElementById( \'cpCl\' ).value=\'\';document.getElementById( \'villeCl\' ).value=\'\';document.getElementById( \'telCl\' ).value=\'\';return false;" value="Vider" />'.'</td>';
					echo '</tr>';
				echo '</table>';
			echo '</div>';
				
			echo '<div id="list-clients">';
					echo '<h3>Liste des clients</h3>';
					echo '<ul id="customer-list">';
						$qCl = mysql_query( "SELECT * FROM clients;" );
						$i = 0;
						while( $rCl = mysql_fetch_array( $qCl ) ) {
							echo '<li id="customer-'.$i.'" class="show" onclick="updateCustDataFields(\''.$rCl[0].'\',\''.htmlspecialchars(str_replace('\'', '\\'.'\'', $rCl[1])).'\',\''.htmlspecialchars(str_replace('\'', '\\'.'\'', $rCl[7])).'\',\''.$rCl[8].'\',\''.$rCl[9].'\',\''.$rCl[5].'\');" onmouseover="this.style.background = \'#dcdcdc\';this.style.cursor=\'pointer\';" onmouseout="this.style.background= \'transparent\';">'.'<span>'.$rCl[1].'</span>'.'</li>';
							$i++;
						}
					echo '</ul>';
					echo '<input type="text" onchange="searchCust( this.value ); window.focus( )" />';
					echo '<input type="submit" value="Go" onclick="javascript: return false;" />';
			echo '</div>';
			
			echo '<hr />';
			
			$sDate = '';
			if( !isset( $_GET['date'] ) )
			{
				$sDate = date( 'd.m.Y' );
			}
			else
				$sDate = $_GET['date'];
				
			$sTime = '';
			if( !isset( $_GET['time'] ) )
			{
				$sTime = '08:00';
			}
			else
				$sTime = $_GET['time'];
			
				
			echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
				echo '<tr>';
					echo '<td>'.'<label for="date-meeting">Date :</label>'.'</td>';
					echo '<td>'.'<input type="text" name="date-meeting" value="'.$sDate.'" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="time-meeting">Heure :</label>'.'</td>';
					echo '<td>'.'<input type="text" name="time-meeting" value="'.$sTime.'" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="technician">Technicien: </label>'.'</td>';
					echo '<td>';
						echo '<select size="4" id="list-tech" name="technician">';
							$qT = mysql_query( "SELECT * FROM technicien;" );
							while( $rT = mysql_fetch_array( $qT ) )
								echo '<option value="'.$rT[0].'">'.utf8_decode($rT[1]).'</option>';
						echo '</select>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="desc-meeting">Description :</label>'.'</td>';
					echo '<td>'.'<textarea name="desc-meeting">Description du rendez-vous</textarea>'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="duree-meeting">Durée Approximative: </label>'.'</td>';
					echo '<td>';
						echo '<select size="5" name="duree-meeting">';
							for( $x = 1; $x < 8; $x++ )
							{
								if( $x == 1 )
									echo '<option value="'.$x.'">'.$x.' heure</option>';
								else
									echo '<option value="'.$x.'">'.$x.' heures</option>';
							}
							echo '<option value="8">Plus de 7 heures</option>';
						echo '</select>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<input type="hidden" name="isAddMeeting" />'.'</td>';
					echo '<td>'.'<input type="submit" class="button" value="Ajouter" />'.'</td>';
				echo '</tr>';
			echo '</table>';
			echo '</form>';			
		echo '</div>';
	}	
	
	// *************************
		// affiche event
	// *************************
	if( isset( $_GET['addEvent'] ) )
	{
		echo '<div id="add-data">';
			echo '<h1>Prévoir un évènement</h1>';
			echo '<form method="post" action="index.php?p=cal">';
						
			$sDate = '';
			if( !isset( $_GET['date'] ) )
			{
				$sDate = date( 'd.m.Y' );
			}
			else
				$sDate = $_GET['date'];
				
			$sTime = '';
			if( !isset( $_GET['time'] ) )
			{
				$sTime = '08:00';
			}
			else
				$sTime = $_GET['time'];
			
				
			echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
				echo '<tr>';
					echo '<td>'.'<label for="date-event">Date :</label>'.'</td>';
					echo '<td>'.'<input type="text" name="date-event" value="'.$sDate.'" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="time-event">Heure :</label>'.'</td>';
					echo '<td>'.'<input type="text" name="time-event" value="'.$sTime.'" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="technician">Technicien: </label>'.'</td>';
					echo '<td>';
						echo '<select size="4" id="list-tech" name="technician">';
							$qT = mysql_query( "SELECT * FROM technicien;" );
							while( $rT = mysql_fetch_array( $qT ) )
								echo '<option value="'.$rT[0].'">'.utf8_decode($rT[1]).'</option>';
						echo '</select>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="desc-event">Description :</label>'.'</td>';
					echo '<td>'.'<textarea name="desc-event">Description de l\'évènement</textarea>'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="duree-event">Durée d\'invalidité: </label>'.'</td>';
					echo '<td>';
						echo '<select size="5" name="duree-event">';
							for( $x = 1; $x < 24; $x++ )
							{
								if( $x == 1 )
									echo '<option value="'.$x.'">'.$x.' heure</option>';
								else
									echo '<option value="'.$x.'">'.$x.' heures</option>';
							}
						echo '</select>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<input type="hidden" name="isAddEvent" />'.'</td>';
					echo '<td>'.'<input type="submit" class="button" value="Ajouter" />'.'</td>';
				echo '</tr>';
			echo '</table>';
			echo '</form>';			
		echo '</div>';
	}
	
	
	// *************************
		// affiche tache
	// *************************
	if( isset( $_GET['addTask'] ) )
	{
		echo '<div id="add-data">';
			echo '<h1>Ajouter une tâche</h1>';
			echo '<form method="post" action="index.php?p=cal">';
						
			$sDate = '';
			if( !isset( $_GET['date'] ) )
			{
				$sDate = date( 'd.m.Y' );
			}
			else
				$sDate = $_GET['date'];
				
			$sTime = '';
			if( !isset( $_GET['time'] ) )
			{
				$sTime = '08:00';
			}
			else
				$sTime = $_GET['time'];
			
				
			echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
				echo '<tr>';
					echo '<td>'.'<label for="date-task">Date :</label>'.'</td>';
					echo '<td>'.'<input type="text" name="date-task" value="'.$sDate.'" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="time-task">Heure :</label>'.'</td>';
					echo '<td>'.'<input type="text" name="time-task" value="'.$sTime.'" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="technician">Technicien: </label>'.'</td>';
					echo '<td>';
						echo '<select size="4" name="technician">';
							$qT = mysql_query( "SELECT * FROM technicien;" );
							while( $rT = mysql_fetch_array( $qT ) )
								echo '<option value="'.$rT[0].'">'.utf8_decode($rT[1]).'</option>';
						echo '</select>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="desc-task">Description :</label>'.'</td>';
					echo '<td>'.'<textarea name="desc-task">Description de la tâche</textarea>'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="duree-task">Durée d\'invalidité: </label>'.'</td>';
					echo '<td>';
						echo '<select size="5" name="duree-task">';
							for( $x = 1; $x < 24; $x++ )
							{
								if( $x == 1 )
									echo '<option value="'.$x.'">'.$x.' heure</option>';
								else
									echo '<option value="'.$x.'">'.$x.' heures</option>';
							}
						echo '</select>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<input type="hidden" name="isAddTask" />'.'</td>';
					echo '<td>'.'<input type="submit" class="button" value="Ajouter" />'.'</td>';
				echo '</tr>';
			echo '</table>';
			echo '</form>';			
		echo '</div>';
	}
?>
