<html>
	<head>
		<title>intr@telier09 - eyeModule Online</title>
		<link rel="stylesheet" type="text/css" href="../css/oneye.css" />
		<script type="text/javascript" src="../js/oneye.js"></script> 
	</head>
	<body>

<?php
	// LOGIN
			require( "func.php" );
			mysql_connect( $m_host, $m_user, $m_pass ) or die( "erreur de connexion à la BD. (".mysql_error( ).")" );
			mysql_select_db( $m_bdd );
				
			if( isset( $_POST['isTryLog'] ) || isset( $_GET['wantDisco'] ) ) 
		{
			if( isset( $_GET['wantDisco'] ) )
			{	
				setcookie( 'oneye_tech', '', 1 );
				echo '<script type="text/javascript">';					
					echo 'window.location.href = \'oneye.php\';';
				echo '</script>';
			}
			else
			{
				$qTech = mysql_query( "SELECT * FROM technicien WHERE `codepass`='".$_POST['codepass']."' LIMIT 1;" );
				if( mysql_numrows( $qTech ) == 0 )
				{
					echo '<span>'.'Vous n\'êtes pas identifié.'.'</span>';
				}
				else
				{
					$rTech = mysql_fetch_array( $qTech );					
					// Time + 1800 secondes = 30 min de validité.
					if( !isset($_COOKIE['oneye_tech']) || empty($_COOKIE['oneye_tech']) || $_COOKIE['oneye_tech'] == 'Wrong' )
						setcookie('oneye_tech', $rTech[1], (time() + 3600));
					echo '<script type="text/javascript">';
						echo 'logNow( \''.$rTech[0].'\', \'Connexion\');';
						echo 'window.location.href = \'oneye.php\';';
					echo '</script>';
				}				
			}
		}
		?>
	

<?php

/*
	eyeModule v3.0 online
	by Grégory Saive. in the name of eVias Services.
*/

	if( isset($_COOKIE['oneye_tech']) && !empty($_COOKIE['oneye_tech']) )
	{
		$techN = $_COOKIE['oneye_tech'];
		$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
		$rT = mysql_fetch_array( $qT );
		$lT = $rT[3];
		$idTech = $rT[0];
		$m_arrTxt = getTextArray( $lT );

		echo '<div id="eye-online">';
			echo '<div id="eye-on-menu">';
				echo '<div id="menu-cont">';
					echo '<ul>';
						echo '<li>'.'<a onclick="showWindow( 0 );" href="#">Mois</a>'.'</li>';
						echo '<li>'.'<a onclick="showWindow( 1 );" href="#">Semaine</a>'.'</li>';
						echo '<li>'.'<a onclick="showWindow( 2 );" href="#">Journée</a>'.'</li>';
						echo '<li>'.'<a onclick="showWindow( 3 );" href="#">Notes</a>'.'</li>';
						echo '<li>'.'<a class="disco" href="oneye.php?wantDisco=1" onclick="logNow( \''.$rT[0].'\', \'Déconnexion\' );">'.$techN.'</a>'.'</li>';
					echo '</ul>';			
				echo '</div>';
				echo '<div id="menu-bg">';			
				echo '</div>';
			echo '</div>';
			echo '<div id="eye-on-content">';
				echo '<div id="content-bg">';
					echo '&nbsp;';
				echo '</div>';
				echo '<div id="content-data">';
					echo '<div id="window-month" class="hide">';
						echo 'Mois';
					echo '</div>';
					
					echo ( (isset( $_GET['week'])) ? '<div id="window-week" class="show">' : '<div id="window-week" class="hide">');
						$date = (isset( $_GET['week'] )) ? $_GET['week'] : date( 'd.m.Y' );
						echo getWeekOnEye( $date );
					echo '</div>';	
									
					echo ( ( (isset( $_GET['data'])) || (isset( $_GET['week'] )) ) ? '<div id="window-day" class="hide">' : '<div id="window-day" class="show">');
						$date = (isset($_GET['date'])) ? $_GET['date'] : date( 'd.m.Y' );
						$idDate = 0;
						$sDate = $date;
						$qD = mysql_query( "SELECT * FROM date WHERE `string_date`='".$sDate."' LIMIT 1;" );
						if( mysql_numrows( $qD ) == 0 ) {
							$qInsD = mysql_query( "INSERT INTO `date` ( `jour`, `mois`, `annee`, `string_date` ) VALUES( '".substr( 0, 2, $sDate )."','".substr( 3, 2, $sDate )."','".substr( 6, 4, $sDate )."','".$sDate."' );" );							
							$idDate = mysql_insert_id( );
						}
						else
						{
							$rD = mysql_fetch_array( $qD );
							$idDate = $rD[0];
						}
						
						echo '<h1><img onclick="window.location.href=\'oneye.php?date='.dayBefore($date).'\';" onmouseover="this.style.cursor=\'pointer\';" src="../images/arrowleft.png" height="16px" width="16px" style="margin: 0px; margin-right: 3px; margin-top: 3px;" border="0px" />&nbsp;'.revertDayIndex(dayIndex(strftime( '%a', strtotime($date) ))).'&nbsp;'.$date.'&nbsp;<img onclick="window.location.href=\'oneye.php?date='.dayAfter($date).'\';" onmouseover="this.style.cursor=\'pointer\';" src="../images/arrowright.png" height="16px" width="16px" style="margin: 0px; margin-left: 3px; margin-top: 3px;" border="0px" /></h1>';
						echo '<h2 class="hours" onclick="var obj = document.getElementById( \'day-hours\' ); if( obj.className == \'hide\' ) { obj.className = \'show\'; } else { obj.className =\'hide\'; }" onmouseover="this.style.cursor=\'pointer\'; this.style.fontWeight=\'bold\';" onmouseout="this.style.fontWeight=\'normal\';">Heures de travail</h2>';
						echo '<div id="day-hours" class="hide">';
							echo '<ul id="hl">';
								for( $h = 5; $h < 20; $h++ )
									echo '<li>'.( ($h < 10) ? '0'.$h : $h ).':00</li>';
							echo '</ul>';
							$aHour = array();
							$aData = array( );
							echo '<ul id="data">';
								for( $h = 5; $h < 20; $h++ )
								{
									echo '<li>';
										echo '<ul id="inhour">';
											// Affichage des éléments pour l'heure ..
											$cntForHour = 0;
											$qD = mysql_query( "SELECT * FROM deplacement WHERE `id_technicien` = '".$idTech."' AND `date_id`='".$idDate."' AND `time`='".( ($h < 10) ? '0'.$h : $h ).":00"."';" );
											if( mysql_numrows( $qD ) > 0 )
											{
												while( $rD = mysql_fetch_array( $qD ) )
												{
													if( $cntForHour < 6 )
														echo '<li onclick="window.location.href=\'oneye.php?data=2&t=0&id='.$rD[0].'\';" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#c1f3bf\';" onmouseout="this.style.background=\'#ccc\';" class="away">&nbsp;</li>';												
													$cntForHour++;
												}
											}
											
											$qE = mysql_query( "SELECT * FROM event WHERE `technicien_id` = '".$idTech."' AND `date_id`='".$idDate."' AND `time`='".( ($h < 10) ? '0'.$h : $h ).":00"."';" );
											if( mysql_numrows( $qE ) > 0 )
											{
												while( $rE = mysql_fetch_array( $qE ) )
												{
													if( $cntForHour < 6 )
														echo '<li onclick="window.location.href=\'oneye.php?data=2&t=2&id='.$rE[0].'\';" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#c1f3bf\';" onmouseout="this.style.background=\'#ffc\';" class="event">&nbsp;</li>';												
													$cntForHour++;
												}
											}
											
											$qM = mysql_query( "SELECT * FROM meeting WHERE `technicien_id` = '".$idTech."' AND `date_id`='".$idDate."' AND `time`='".( ($h < 10) ? '0'.$h : $h ).":00"."';" );
											if( mysql_numrows( $qM ) > 0 )
											{
												while( $rM = mysql_fetch_array( $qM ) )
												{
													if( $cntForHour < 6 )
														echo '<li onclick="window.location.href=\'oneye.php?data=2&t=1&id='.$rM[0].'\';" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#c1f3bf\';" onmouseout="this.style.background=\'#ccf\';" class="meeting">&nbsp;</li>';												
													$cntForHour++;
												}
											}
											
											$qT = mysql_query( "SELECT * FROM task WHERE `technicien_id` = '".$idTech."' AND `date_id`='".$idDate."' AND `time`='".( ($h < 10) ? '0'.$h : $h ).":00"."';" );
											if( mysql_numrows( $qT ) > 0 )
											{
												while( $rT = mysql_fetch_array( $qT ) )
												{
													if( $cntForHour < 6 )
														echo '<li onclick="window.location.href=\'oneye.php?data=2&t=3&id='.$rT[0].'\';" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#c1f3bf\';" onmouseout="this.style.background=\'#fcc\';" class="task">&nbsp;</li>';
													$cntForHour++;
												}
											}
										echo '</ul>';
									echo '<img onclick="window.location.href=\'oneye.php?data=1&date='.$date.'&time='.( ($h < 10) ? '0'.$h : $h ).':00\';" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'transparent\';" style="position: relative; top: -18px; left: 115px;" src="../images/add_depl_week.png" height="16px" width="16px" border="0px" />';
									echo '</li>';
								}
							echo '</ul>';
						echo '</div>';
						
						$qDepl = mysql_query( "SELECT * FROM deplacement WHERE `date_id` = '".$idDate."' AND `id_technicien`='".$idTech."' ORDER BY time ASC;" );
						$qEvent = mysql_query( "SELECT * FROM event WHERE `date_id` = '".$idDate."' AND `technicien_id`='".$idTech."' ORDER BY time ASC;" );
						$qMeet = mysql_query( "SELECT * FROM meeting WHERE `date_id` = '".$idDate."' AND `technicien_id`='".$idTech."' ORDER BY time ASC;" );
						$qTask = mysql_query( "SELECT * FROM task WHERE `date_id` = '".$idDate."' AND `technicien_id`='".$idTech."' ORDER BY time ASC;" );
						
						$nTotalForDay = mysql_numrows( $qDepl ) + mysql_numrows( $qEvent ) + mysql_numrows( $qMeet ) + mysql_numrows( $qTask );
						
						if( $nTotalForDay > 0 )
						{
							if( mysql_numrows( $qDepl ) > 0 )
							{
								echo '<h2>'.'Déplacements'.'</h2>';
								echo '<ul>';
									while( $rD = mysql_fetch_array( $qDepl ) )
									{
										$addrCl = 'Inconnue';
										$qCl = mysql_query( "SELECT * FROM clients WHERE id ='".$rD[1]."' LIMIT 1;" );
										$rCl = mysql_fetch_array( $qCl );
										$addrCl = $rCl[7].' - '.$rCl[8].' '.$rCl[9];
										$nServices = 0;
										$qS = mysql_query( "SELECT * FROM prester_depl WHERE `deplacement_id`='".$rD[0]."';" );
										$nServices = mysql_numrows( $qS );
										echo '<li onmouseover="this.style.cursor=\'pointer\'; this.style.background=\'#c1f3bf\';" onmouseout="this.style.background=\'#fff\';">';
											echo '<span class="time">'.$rD[5].'</span>';
											echo ' - <span class="data">'.$rD[2].'&nbsp;['.$addrCl.']</span>';
											echo '<span class="data">';
												echo '<br />';
												echo $nServices.' '.( ($nServices > 1) ? ' services enregistrés' : ' service enregistré' );
											echo '</span><br />';
											echo '<a href="oneye.php?data=1&step=4&depl='.$rD[0].'">Ajouter un service</a>';
										echo '</li>';
									}
								echo '</ul>';
							}
							
							if( mysql_numrows( $qTask ) > 0 )
							{						
								echo '<h2>'.'Tâches'.'</h2>';
								echo '<ul>';
									while( $rT = mysql_fetch_array( $qTask ) )
									{
										echo '<li onmouseover="this.style.cursor=\'pointer\'; this.style.background=\'#ffd3cc\';" onmouseout="this.style.background=\'#fff\';">'.'<span class="time">'.$rT[3].'</span>'.' - <span class="data">'.$rT[5].'</span>'.'</li>';
									}
								echo '</ul>';
							}
							
							if( mysql_numrows( $qMeet ) > 0 )
							{
								echo '<h2>'.'Rendez-vous'.'</h2>';
								echo '<ul>';
									while( $rM = mysql_fetch_array( $qMeet ) )
									{
										$libCl = 'Inconnu';
										$qCl = mysql_query( "SELECT * FROM clients WHERE id ='".$rM[3]."' LIMIT 1;" );
										$rCl = mysql_fetch_array( $qCl );
										$libCl = $rCl[1];
										echo '<li onmouseover="this.style.cursor=\'pointer\'; this.style.background=\'#ffccf6\';" onmouseout="this.style.background=\'#fff\';">'.'<span class="time">'.$rM[4].'</span>'.' - <span class="data">'.$rM[6].'&nbsp;['.$libCl.']</span>'.'</li>';
									}
								echo '</ul>';
							}
							
							if( mysql_numrows( $qEvent ) > 0 )
							{
								echo '<h2>'.'Evènements'.'</h2>';			
								echo '<ul>';
									while( $rE = mysql_fetch_array( $qEvent ) )
										echo '<li onmouseover="this.style.cursor=\'pointer\'; this.style.background=\'#ffffcc\';" onmouseout="this.style.background=\'#fff\';">'.'<span class="time">'.$rE[3].'</span>'.' - <span class="data">'.$rE[4].'</span>'.'</li>';
								echo '</ul>';	
							}	
							
						}
						else
						{
							echo '<span>Rien n\'est prévu pour aujourd\'hui.</span>';
						}
						
					echo '</div>';
					echo '<div id="window-notes" class="hide">';
						// Ajout si nécessaire.
						if( isset( $_POST['isAddNote'] ) )
						{
							$qIns = mysql_query( "INSERT INTO `intratelier09`.`notes` ( `technicien_id`, `desc`, `title` ) VALUES ( '".$idTech."', '".$_POST['descNote']."', '".$_POST['titleNote']."' );" ) or die( mysql_error( ) );
							$idN = mysql_insert_id( );
							if( $idN )
								echo '<span>Note ajoutée avec succès !</span>';
						}
						
						$qNotes = mysql_query( "SELECT * FROM notes WHERE technicien_id='".$idTech."' ORDER BY id DESC;" );
						if( mysql_numrows( $qNotes ) > 0 )
						{
							$x = 0;
							while( $rN = mysql_fetch_array( $qNotes ) )
							{
								echo '<h2 onmouseover="this.style.cursor=\'pointer\';" onclick="var obj = document.getElementById( \'note-'.$x.'\' ); if( obj.className == \'hide\' ) { obj.className = \'show\'; } else { obj.className =\'hide\'; }">'.$rN[3].'</h2>';
								echo '<div id="note-'.$x.'" class="hide">';
									echo '<span>';
										echo $rN[2];
									echo '</span>';
								echo '</div>';
								$x++;
							}
						}
						echo '<div id="add-note">';
							echo '<form method="post" action="oneye.php">';
								echo '<input type="text" value="Titre" name="titleNote" style="font-family:Georgia;font-size:9pt; font-weight:bold; font-style: italic; color:#000;" />';
								echo '<textarea name="descNote" style="font-family:Georgia;font-size:9pt; font-weight:bold; font-style: italic; color:#11389c;">Note</textarea>';
								echo '<input type="submit" value="Ajouter" />';
								echo '<input type="hidden" name="isAddNote" />';
							echo '</form>';
						echo '</div>';
					echo '</div>';
					echo ( (isset( $_GET['data'])) ? '<div id="window-data" class="show">' : '<div id="window-data" class="hide">');
						if( isset( $_GET['data'] ) )
						{
							$dataRequest = $_GET['data'];
							switch( $dataRequest )
							{
								case 1:
									include( 'oneye-addwizard.php' );
									break;
									
								case 2:
									include( 'oneye-datacenter.php' );
									break;
									
								default:
									echo 'Erreur de requete data';
									break;
							}
						}
						else
							echo '&nbsp;';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
	else
	{
		echo '<div id="eye-online">';
			echo '<div id="eye-on-menu">';
				echo '<div id="menu-cont">';
					echo '<form method="post" action="oneye.php">';
					echo '<input class="text" type="password" name="codepass" />';
					echo '<input class="button" type="submit" value="Login" />';
					echo '<input type="hidden" name="isTryLog" />';
					echo '</form>';	
				echo '</div>';
				echo '<div id="menu-bg">';			
				echo '</div>';
			echo '</div>';
			echo '<div id="eye-on-content">';
			echo '</div>';
		echo '</div>';
	}

?>

	</body>
</html>
