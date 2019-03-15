<?php
	// Variables used
	$typeChosen = -1;
	$date = 'dd.mm.yyyy';
	$time = 'hh:mm';	
	
	// Log & language
	$techN = $_COOKIE['oneye_tech'];
	$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
	$rT = mysql_fetch_array( $qT );
	$idTech = $rT[0];

	// First step ..
	if( !isset( $_GET['step'] ) )
	{
		$date = $_GET['date'];
		$time = $_GET['time'];
		echo '<span>'.'Veuillez choisir le type d\'élément que vous voulez ajouter.'.'</span>';
		echo '<form method="post" action="oneye.php?data=1&step=2">';
			echo '<select size="4" name="typeElement">';
				echo '<option value="0">'.'Déplacement'.'</option>';
				echo '<option value="1">'.'Rendez-vous'.'</option>';
				echo '<option value="2">'.'Evènement'.'</option>';
				echo '<option value="3">'.'Tâches'.'</option>';
			echo '</select>';
			echo '<input class="button" type="submit" value="Continuer" /><br />';
			echo '<span>'.$date.' - '.$time.'</span>';
			echo '<input type="hidden" name="dateElement" value="'.$date.'" />';
			echo '<input type="hidden" name="timeElement" value="'.$time.'" />';
		echo '</form>';
	}
	// Step is set to minimal 2 (first step = step unset!)
	else
	{
		$step = $_GET['step'];
		// Step 1 has been done already
		// Step 2 is relative to type of element
		// Step 3 is relative to type of element
		// Switvh for step and for different elements.
		switch( $step )
		{
			// STEP 2 
			case 2:
				$typeChosen = $_POST['typeElement'];
				$date = $_POST['dateElement'];
				$time = (isset($_POST['timeElement'])) ? $_POST['timeElement'] : '08:00';
				switch( $typeChosen )
				{
					// STEP 2 Déplacement
					case 0:
						echo '<div id="list-clients">';
							echo '<h3>Liste des clients</h3>';
							echo '<input id="clsch" class="clsch" type="text" />';
							echo '<input class="button" type="submit" value="Go" onclick="searchCust( document.getElementById( \'clsch\' ).value );" />';
							echo '<ul id="customer-list" class="hide">';
								$qAllCl = mysql_query( "SELECT * FROM clients;" );
								$x = 0;
								while( $rCl = mysql_fetch_array( $qAllCl ) )
								{
									echo '<li id="customer-'.$x.'" class="hide" onclick="setDataCust( \''.$rCl[0].'\', \''.str_replace('\'', '\\'.'\'', $rCl[1]).'\', \''.str_replace('\'', '\\'.'\'', $rCl[7]).'\', \''.$rCl[8].'\', \''.$rCl[9].'\', \''.$rCl[5].'\' );" onmouseover="this.style.cursor=\'pointer\'; this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'transparent\';"><span>'.$rCl[1].'</span></li>';
									$x++;
								}
							echo '</ul>';
						echo '</div>';
						echo '<div id="info-client">';						
							echo '<h3>Information sur le client</h3>';
							echo '<form method="post" action="oneye.php?data=1&step=3">';
							echo '<input id="libCl" class="txt" type="text" value="" name="libCl" />'.'<br />';
							echo '<input id="addrCl" class="txt" type="text" value="" name="addrCl" />'.'<br />';
							echo '<input id="cpCl" class="txt" type="text" value="" name="cpCl" />'.'<br />';
							echo '<input id="villeCl" class="txt" type="text" value="" name="villeCl" />'.'<br />';
							echo '<input id="telCl" class="txt" type="text" value="" name="telCl" />'.'<br />';
							echo '<input id="idCl" class="txt" type="text" value="" name="idCl" />'.'<br />';
							echo '<input style="margin-left: 5px;" class="button" type="submit" onclick="clearDataCust( ); return false;" value="Vider" />';
							echo '<input style="margin-left: 5px;" class="button" type="submit" value="Continuer" />';
							echo '<input type="hidden" name="dateElement" value="'.$date.'" />';
							echo '<input type="hidden" name="timeElement" value="'.$time.'" />';
							echo '<input type="hidden" name="typeElement" value="'.$typeChosen.'" />';
						echo '</div>';					
						break;
					
					// STEP 2 Meeting
					case 1:
						echo '<div id="list-clients">';
							echo '<h3>Liste des clients</h3>';
							echo '<input id="clsch" class="clsch" type="text" />';
							echo '<input class="button" type="submit" value="Go" onclick="searchCust( document.getElementById( \'clsch\' ).value );" />';
							echo '<ul id="customer-list" class="hide">';
								$qAllCl = mysql_query( "SELECT * FROM clients;" );
								$x = 0;
								while( $rCl = mysql_fetch_array( $qAllCl ) )
								{
									echo '<li id="customer-'.$x.'" class="hide" onclick="setDataCust( \''.$rCl[0].'\', \''.str_replace('\'', '\\'.'\'', $rCl[1]).'\', \''.str_replace('\'', '\\'.'\'', $rCl[7]).'\', \''.$rCl[8].'\', \''.$rCl[9].'\', \''.$rCl[5].'\' );" onmouseover="this.style.cursor=\'pointer\'; this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'transparent\';"><span>'.$rCl[1].'</span></li>';
									$x++;
								}
							echo '</ul>';
						echo '</div>';
						echo '<div id="info-client">';						
							echo '<h3>Information sur le client</h3>';
							echo '<form method="post" action="oneye.php?data=1&step=3">';
							echo '<input id="libCl" class="txt" type="text" value="" name="libCl" />'.'<br />';
							echo '<input id="addrCl" class="txt" type="text" value="" name="addrCl" />'.'<br />';
							echo '<input id="cpCl" class="txt" type="text" value="" name="cpCl" />'.'<br />';
							echo '<input id="villeCl" class="txt" type="text" value="" name="villeCl" />'.'<br />';
							echo '<input id="telCl" class="txt" type="text" value="" name="telCl" />'.'<br />';
							echo '<input id="idCl" class="txt" type="text" value="" name="idCl" />'.'<br />';
							echo '<input style="margin-left: 5px;" class="button" type="submit" onclick="clearDataCust( ); return false;" value="Vider" />';
							echo '<input style="margin-left: 5px;" class="button" type="submit" value="Continuer" />';
							echo '<input type="hidden" name="dateElement" value="'.$date.'" />';
							echo '<input type="hidden" name="timeElement" value="'.$time.'" />';
							echo '<input type="hidden" name="typeElement" value="'.$typeChosen.'" />';
						echo '</div>';	
						break;
						
					// STEP 2 Event
					case 2:
						echo '<form method="post" action="oneye.php?data=1&step=3">';
							echo '<label for="timeEvent">Heure: </label><br />';
							echo '<input type="text" class="txt" name="timeEvent" value="'.$time.'" /><br />';
							echo '<label for="descEvent">Description: </label><br />';
							echo '<input type="text" class="txt" name="descEvent" /><br />';
							echo '<label for="dureeEvent">Duree Approximative</label><br />';
							echo '<select style="width: 205px;" size="10" name="dureeEvent">';
								for( $x = 1; $x < 24; $x++ )
									echo '<option value="'.$x.'">'.$x.(($x<2) ? ' heure' : ' heures').'</option>';
								echo '<option value="8">Plus de 23 heures</option>';
							echo '</select>';
							echo '<input type="submit" class="button" value="Enregistrer" />';
							echo '<input type="hidden" value="'.$date.'" name="dateElement" />';
							echo '<input type="hidden" value="'.$time.'" name="timeElement" />';
							echo '<input type="hidden" value="'.$typeChosen.'" name="typeElement" />';
							echo '<br /><span>'.$date.'</span>';
						echo '</form>';
						break;
						
					// STEP 2 Tâche
					case 3:
						echo '<form method="post" action="oneye.php?data=1&step=3">';
							echo '<label for="timeTask">Heure: </label><br />';
							echo '<input type="text" class="txt" name="timeTask" value="'.$time.'" /><br />';
							echo '<label for="descTask">Description</label><br />';
							echo '<input type="text" class="txt" name="descTask" /><br />';
							echo '<label for="dureeTask">Duree Approximative</label><br />';
							echo '<select style="width: 205px;" size="10" name="dureeTask">';
								for( $x = 1; $x < 24; $x++ )
									echo '<option value="'.$x.'">'.$x.(($x<2) ? ' heure' : ' heures').'</option>';
								echo '<option value="8">Plus de 23 heures</option>';
							echo '</select>';
							echo '<input type="submit" class="button" value="Enregistrer" />';
							echo '<input type="hidden" value="'.$date.'" name="dateElement" />';
							echo '<input type="hidden" value="'.$time.'" name="timeElement" />';
							echo '<input type="hidden" value="'.$typeChosen.'" name="typeElement" />';
							echo '<br /><span>'.$date.'</span>';
						echo '</form>';
						break;
						
					default:
						break;
				}
				break;
				
			// STEP 3
			case 3:
				$typeChosen = $_POST['typeElement'];
				$date = $_POST['dateElement'];
				$time = $_POST['timeElement'];
				$libCl = '';
				$addrCl = '';
				$cpCl = '';
				$villeCl = '';
				$telCl = '';
				$idCl = '';
				if( $typeChosen < 2 )
				{
					$libCl = (isset($_POST['libCl'])) ? $_POST['libCl'] : 'Undefined';
					$addrCl = (isset($_POST['addrCl'])) ? $_POST['addrCl'] : 'Undefined';
					$cpCl = (isset($_POST['cpCl'])) ? $_POST['cpCl'] : 'Undefined';
					$villeCl = (isset($_POST['villeCl'])) ? $_POST['villeCl'] : 'Undefined';
					$telCl = (isset($_POST['telCl'])) ? $_POST['telCl'] : 'Undefined';
					$idCl = ( (isset($_POST['idCl']) && !empty($_POST['idCl'])) ? $_POST['idCl'] : -1 );
				}
				if( $idCl == -1 )
				{
					$qD = mysql_query( "SELECT * FROM date WHERE string_date='".date('d.m.Y')."' LIMIT 1;" );
					$rD = mysql_fetch_array($qD);
					$nIDDate = $rD[0];
					$insCl = mysql_query( "INSERT INTO `intratelier09`.`clients` (`id` ,`libelle` ,`code_id` ,`lname` ,`fname` ,`numtel` ,`numfax` ,`addr` ,`cp` ,`ville` ,`email` ,`provider` ,`type_adsl` ,`a_belgtv` ,`belgtv_dispo` ,`date_id`)VALUES (NULL , '".$libCl."', '', '', '', '".$telCl."', '', '".$addrCl."', '".$cpCl."', '".$villeCl."', '', '0', '', '0', '0', '".$nIDDate."');" );
					$idCl = mysql_insert_id( );
				}
				
		/*		echo $idCl;*/
				
				switch( $typeChosen )
				{
					// STEP 3 Déplacement
					case 0:
						echo '<form method="post" action="oneye.php?data=1&step=4">';
							echo '<label for="timeDepl">Heure: </label><br />';
							echo '<input type="text" class="txt" name="timeDepl" value="'.$time.'" /><br />';
							echo '<label for="descDepl">Description</label><br />';
							echo '<input type="text" class="txt" name="descDepl" />';
							echo '<label for="distDepl">Distance</label><br />';
							echo '<select style="width: 205px;" size="5" name="distDepl">';
								$qD = mysql_query( "SELECT * FROM distance;" );
								while( $rD = mysql_fetch_array( $qD ) )
									echo '<option value="'.$rD[0].'">'.$rD[2].'</option>';
							echo '</select>';
							echo '<input type="submit" class="button" value="Enregistrer" />';
							echo '<input type="hidden" value="'.$date.'" name="dateElement" />';
							echo '<input type="hidden" value="'.$time.'" name="timeElement" />';
							echo '<input type="hidden" value="'.$typeChosen.'" name="typeElement" />';
							echo '<input type="hidden" value="'.$idCl.'" name="clientElement" />';
							echo '<input type="hidden" name="isAddDepl" />';
							echo '<br /><span>'.$date.'</span>';
						echo '</form>';
						break;
					
					// STEP 3 Meeting
					case 1:
						echo '<form method="post" action="oneye.php?data=1&step=4">';
							echo '<label for="timeMeet">Heure: </label><br />';
							echo '<input type="text" class="txt" name="timeMeet" value="'.$time.'" /><br />';
							echo '<label for="descMeet">Description</label><br />';
							echo '<input type="text" class="txt" name="descMeet" /><br />';
							echo '<label for="dureeMeet">Duree Approximative</label><br />';
							echo '<select style="width: 205px;" size="5" name="dureeMeet">';
								for( $x = 1; $x < 8; $x++ )
									echo '<option value="'.$x.'">'.$x.(($x<2) ? ' heure' : ' heures').'</option>';
								echo '<option value="8">Plus de 7 heures</option>';
							echo '</select>';
							echo '<input type="submit" class="button" value="Enregistrer" />';
							echo '<input type="hidden" value="'.$date.'" name="dateElement" />';
							echo '<input type="hidden" value="'.$time.'" name="timeElement" />';
							echo '<input type="hidden" value="'.$typeChosen.'" name="typeElement" />';
							echo '<input type="hidden" value="'.$idCl.'" name="clientElement" />';
							echo '<br /><span>'.$date.'</span>';
						echo '</form>';
						break;
						
					// STEP 3 Event
					case 2:
						$descEvent = $_POST['descEvent'];
						$dureeEvent = $_POST['dureeEvent'];
						$typeChosen = $_POST['typeElement'];
						$date = $_POST['dateElement'];
						$time = $_POST['timeEvent'];
						
						$qDate = mysql_query( "SELECT * FROM date WHERE `string_date`='".$date."' LIMIT 1;");
						$rDate = mysql_fetch_array( $qDate );
						
						
						$qInsert = mysql_query( "INSERT INTO `event` ( `technicien_id`, `date_id`, `time`, `event_desc`, `hours_duree` ) VALUES ( '".$idTech."', '".$rDate[0]."', '".$time."', '".$descEvent."', '".$dureeEvent."' );" ) or die( mysql_error( ) );
						$idEvent = mysql_insert_id( );
						if( $idEvent )
						{
							echo '<span>Évènement ajouté avec succès !</span><br />';
							echo '<script type="text/javascript">';
								echo 'logNow( \''.$idTech.'\', \'[onEye] Ajouté evenement.\' );';
								/* Eventuellement mettre lien vers affichage déplacement */
								echo 'window.location.href=\'oneye.php?date='.$date.'\';';
							echo '</script>';
						}
						else
							echo '<span>Raté !</span><br />';
						break;
						
					// STEP 3 Tâche
					case 3:
						$descTask = $_POST['descTask'];
						$dureeTask = $_POST['dureeTask'];
						$typeChosen = $_POST['typeElement'];
						$date = $_POST['dateElement'];
						$time = $_POST['timeTask'];
						
						$qDate = mysql_query( "SELECT * FROM date WHERE `string_date`='".$date."' LIMIT 1;");
						$rDate = mysql_fetch_array( $qDate );
						
						
						$qInsert = mysql_query( "INSERT INTO `task` ( `technicien_id`, `date_id`, `time`, `duree`, `desc` ) VALUES ( '".$idTech."', '".$rDate[0]."', '".$time."', '".$dureeTask."', '".$descTask."' );" ) or die( mysql_error( ) );
						$idTask = mysql_insert_id( );
						if( $idTask )
						{
							echo '<span>Tâche ajoutée avec succès !</span><br />';
							echo '<script type="text/javascript">';
								echo 'logNow( \''.$idTech.'\', \'[onEye] Ajouté tâche.\' );';
								/* Eventuellement mettre lien vers affichage déplacement */
								echo 'window.location.href=\'oneye.php?date='.$date.'\';';
							echo '</script>';
						}
						else
							echo '<span>Raté !</span><br />';
						break;
						
					default:
						break;
				}
				break;
				
				// STEP 4
			case 4:
				// PAr défaut 0 car uniquement déplacement peut renvoyer
				// vers cette étape (ajout de service)
				$typeChosen = (isset($_POST['typeElement']) ? $_POST['typeElement'] : 0 );
				$date = (isset($_POST['dateElement']) ? $_POST['dateElement'] : date( 'd.m.Y' ) );
				$time = (isset($_POST['timeElement']) ? $_POST['timeElement'] : '08:00' );
				$idDepl = 0;				
				// Si on est redirigé sur cette page par le formulaire d'ajout de déplacement ..
				if( isset( $_POST['isAddDepl'] ) )
				{			
					
					$idCl = $_POST['clientElement'];
					$desc = $_POST['descDepl'];
					$dist = $_POST['distDepl'];
					$tNew = $_POST['timeDepl'];
					$prixBase = 0;
					$qD1 = mysql_query( "SELECT * FROM date WHERE `string_date`='".$date."' LIMIT 1;" );
					$idDate = 0;
					if( mysql_numrows( $qD1 ) == 0 ) {
						$qInsD = mysql_query( "INSERT INTO `date` ( `jour`, `mois`, `annee`, `string_date` ) VALUES( '".substr( 0, 2, $date )."','".substr( 3, 2, $date )."','".substr( 6, 4, $date )."','".$date."' );" ) or die( mysql_error( ) );							
						$idDate = mysql_insert_id( );
					}
					else
					{					
						$rD = mysql_fetch_array( $qD1 );				
						$idDate = $rD[0];
					}
					
					$qD2 = mysql_query( "SELECT * FROM distance WHERE id='".$dist."' LIMIT 1;" );
					$rD2 = mysql_fetch_array( $qD2 );
					$prixBase = $rD2[1];
					
					$qDepl = mysql_query( "INSERT INTO `intratelier09`.`deplacement` ( `idClient`, `descMachine`, `idDistance`, `date_id`, `time`, `total_tvac`, `id_technicien` ) VALUES( '".$idCl."', '".$desc."', '".$dist."', '".$idDate."', '".$tNew."', '".$prixBase."', '".$idTech."' );" ) or die( mysql_error( ) );
					$idDepl = mysql_insert_id( );
					if( $idDepl )
						echo '<span>Déplacement ajouté avec succès !</span><br />';
				}
				else
					$idDepl = (isset($_GET["depl"]) ? $_GET["depl"] : null );
				
				// Le déplacement est déjà enregistré, peut-être faut-il sauvegardé des données ?	
				if( isset( $_GET["depl"] ) )
				{
					if( isset( $_POST['isAddService'] ) )
					{
						$isel = $_POST['prestation'];
						$desc = $_POST['descService'];			
			
						$qP = mysql_query( "SELECT * FROM prestation WHERE `id`='".$isel."' LIMIT 1;" );
						$rP = mysql_fetch_array( $qP );
						$idP = $rP[0];
						$pP = $rP[2];
						$ttvac = 0;
						$qr = mysql_query( "SELECT * FROM deplacement WHERE id =".$idDepl." LIMIT 1;" );
						$rr = mysql_fetch_array( $qr );
						$ttvac = $rr[6] + $pP;
						// Update du prix !
						$qPrice = mysql_query( "UPDATE `deplacement` SET `total_tvac` = '".$ttvac."' WHERE `id` =".$idDepl." LIMIT 1 ;" );
		
						$qInsert = mysql_query( "INSERT INTO `prester_depl` ( `prestation_id`, `deplacement_id`, `desc`, `done`, `id_technicien` ) VALUES ( '".$idP."', '".$idDepl."', '".$desc."', '100', '".$idTech."' );" ) or die( mysql_error( ) );
						$idPD = mysql_insert_id( );
						if( $idPD )
						{
							echo '<script type="text/javascript">';
								echo 'logNow( \''.$idTech.'\', \'[onEye] Ajouté service pour déplacement. [Service: '.$idPD.'] [Away: '.$idDepl.']\' );';
								/* Eventuellement mettre lien vers affichage déplacement */
								echo 'window.location.href=\'oneye.php\';';
							echo '</script>';
							echo '<span>Service ajouté avec succès !</span><br />';
						}
					}
				}
				
				switch( $typeChosen )
				{
					// STEP 4 Déplacement
					case 0:
						echo '<span>Sélectionnez les services prévus/effectués.</span><br />';
						echo '<form method="post" action="oneye.php?data=1&step=4&depl='.$idDepl.'">';
						echo '<select id="services" name="prestation" size="10">';
							$qS = mysql_query( "SELECT * FROM prestation;" );
							while( $rS = mysql_fetch_array( $qS ) )
								echo '<option value="'.$rS[0].'">'.$rS[1].'</option>';
						echo '</select><br />';
						echo '<label for="descService">Description</label><br />';
						echo '<input type="text" class="txt" name="descService" />';
						echo '<input type="submit" class="button" value="Ajouter" /><br />';
						if( isset( $_POST['isAddDepl'] ) )
							echo '<a href="oneye.php?date='.$date.'">Continuer sans ajouter</a>';
						echo '<input type="hidden" name="isAddService" />';
						break;
						
					// STEP 4 Meeting
					case 1:
						$descMeet = $_POST['descMeet'];
						$dureeMeet = $_POST['dureeMeet'];
						$techMeet = $idTech;
						$typeChosen = $_POST['typeElement'];
						$date = $_POST['dateElement'];
						$time = $_POST['timeMeet'];
						$idCl = $_POST['clientElement'];
						
						$qDate = mysql_query( "SELECT * FROM date WHERE `string_date`='".$date."' LIMIT 1;");
						$rDate = mysql_fetch_array( $qDate );
						
						
						$qInsert = mysql_query( "INSERT INTO `meeting` ( `technicien_id`, `date_id`, `client_id`, `time`, `duree`, `desc` ) VALUES ( '".$idTech."', '".$rDate[0]."', '".$idCl."', '".$time."', '".$dureeMeet."', '".$descMeet."' );" ) or die( mysql_error( ) );
						$idMeet = mysql_insert_id( );
						if( $idMeet )
						{
							echo '<span>Rendez-vous ajouté avec succès !</span><br />';
							echo '<script type="text/javascript">';
								echo 'logNow( \''.$idTech.'\', \'[onEye] Ajouté meeting.\' );';
								/* Eventuellement mettre lien vers affichage déplacement */
								echo 'window.location.href=\'oneye.php?date='.$date.'\';';
							echo '</script>';
						}
						else
							echo '<span>Raté !</span><br />';
						
						break;
						
					default:
						echo 'La 4ème étape n\'est disponible que pour les déplacements et les rendez-vous.';
						break;
				}
				/*
				echo '<br />Date: '.$idDate.' ['.$date.']';
					echo '<br />Client: '.$idCl;
					echo '<br />Heure: '.$time;
					echo '<br />Type: '.$typeChosen;
				*/
				break;
				
			default:
				break;
		}
	}
?>
