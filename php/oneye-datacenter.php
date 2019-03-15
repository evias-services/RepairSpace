<?php

	$typeElement = (isset($_GET['t']) ? $_GET['t'] : 0);
	$id = (isset($_GET['id']) ? $_GET['id'] : -1);
	
	echo '<div id="datacenter">';
	switch( $typeElement )
	{
		// Afficher déplacement
		case 0:
			if( $id > -1 )
			{
				$qDepl = mysql_query( "SELECT * FROM deplacement WHERE `id`='".$id."' LIMIT 1;" );
				$rDepl = mysql_fetch_array( $qDepl );
				$sDesc = $rDepl[2];
				
				$qTech = mysql_query( "SELECT * FROM technicien WHERE id='".$rDepl[7]."' LIMIT 1;" );
				$rTech = mysql_fetch_array( $qTech );
				$sTech = $rTech[1];
				
				$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rDepl[4]."' LIMIT 1;" );
				$rDate = mysql_fetch_array( $qDate );
				$sDate = $rDate[4];
				
				$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$rDepl[1]."' LIMIT 1;" );
				$rCl = mysql_fetch_array( $qCl );
				$sClient = $rCl[1];
				$aClient = $rCl[7].' - '.$rCl[8].' '.$rCl[9];
				
				$qDist = mysql_query( "SELECT * FROM distance WHERE id='".$rDepl[3]."' LIMIT 1;" );
				$rDist = mysql_fetch_array( $qDist );
				$sDist = $rDist[2].' ['.$rDist[1].' &euro;] ('.$rDist[3].')';
				
				echo '<h3>'.'Déplacement le '.$sDate.'</h3>';
				echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
					echo '<tr>';
						echo '<td>'.'<label>ID Dépl.: </label>'.'</td>';
						echo '<td>'.'<span>'.$rDepl[0].'</span>'.'</td>';
						echo '<td>'.'<label>Prix: </label>'.'</td>';
						echo '<td>'.'<span>'.$rDepl[6].' &euro;</span>'.'</td>';
										
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Heure: </label>'.'</td>';
						echo '<td>'.'<span>'.$rDepl[5].'</span>'.'</td>';											
					echo '</tr>';
				echo '</table>';
				echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
					echo '<tr>';
					echo '<td align="right">'.'<label>Technicien: </label>'.'</td>';
						echo '<td>'.'<span>'.$sTech.'</span>'.'</td>';		
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Client: </label>'.'</td>';					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<span>'.$sClient.'</span>'.'</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Adresse: </label>'.'</td>';					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<span>'.$aClient.'</span>'.'</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Description: </label>'.'</td>';					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<span>'.$sDesc.'</span>'.'</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Distance: </label>'.'</td>';					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<span>'.$sDist.'</span>'.'</td>';
					echo '</tr>';
					echo '<tr>';
				echo '</table>';
				
				echo '<ul id="serv-depl>';
				$qServ = mysql_query( "SELECT * FROM prester_depl WHERE `deplacement_id`='".$rDepl[0]."';" );
				if( mysql_numrows( $qServ ) > 0 )
				{
					while( $rS = mysql_fetch_array( $qServ ) )
					{	
						$qPrest = mysql_query( "SELECT * FROM prestation WHERE id='".$rS[1]."' LIMIT 1;" );
						$rP = mysql_fetch_array( $qPrest ); 
						echo '<li>'.$rP[1].' - Infos: '.$rS[3].'</li>';
					}
				}
				else
					echo '<li>'.'Aucun service enregistré.'.'</li>';
				echo '</ul>';
			}
			break;
			
		// Afficher meeting
		case 1:
			if( $id > -1 )
			{
				$qMeet = mysql_query( "SELECT * FROM meeting WHERE `id`='".$id."' LIMIT 1;" );
				$rMeet = mysql_fetch_array( $qMeet );
				$sDesc = $rMeet[6];
				
				$qTech = mysql_query( "SELECT * FROM technicien WHERE id='".$rMeet[1]."' LIMIT 1;" );
				$rTech = mysql_fetch_array( $qTech );
				$sTech = $rTech[1];
				
				$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rMeet[2]."' LIMIT 1;" );
				$rDate = mysql_fetch_array( $qDate );
				$sDate = $rDate[4];
				
				$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$rMeet[3]."' LIMIT 1;" );
				$rCl = mysql_fetch_array( $qCl );
				$sClient = $rCl[1];
				$aClient = $rCl[7].' - '.$rCl[8].' '.$rCl[9];				
				
				echo '<h3>'.'Rendez-vous le '.$sDate.'</h3>';
				echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
					echo '<tr>';
						echo '<td>'.'<label>ID Meeting: </label>'.'</td>';
						echo '<td>'.'<span>'.$rMeet[0].'</span>'.'</td>';																					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Heure: </label>'.'</td>';
						echo '<td>'.'<span>'.$rMeet[4].'</span>'.'</td>';		
					echo '</tr>';
				echo '</table>';
				echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
					echo '<tr>';
					echo '<td align="right">'.'<label>Technicien: </label>'.'</td>';
						echo '<td>'.'<span>'.$sTech.'</span>'.'</td>';		
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Client: </label>'.'</td>';					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<span>'.$sClient.'</span>'.'</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Adresse: </label>'.'</td>';					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<span>'.$aClient.'</span>'.'</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Description: </label>'.'</td>';					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<span>'.$sDesc.'</span>'.'</td>';
					echo '</tr>';
					echo '<tr>';
				echo '</table>';
			}
			break;
			
		// Afficher event
		case 2:
			if( $id > -1 )
			{
				$qEvent = mysql_query( "SELECT * FROM event WHERE `id`='".$id."' LIMIT 1;" );
				$rEvent = mysql_fetch_array( $qEvent );
				$sDesc = $rEvent[4];
				
				$qTech = mysql_query( "SELECT * FROM technicien WHERE id='".$rEvent[1]."' LIMIT 1;" );
				$rTech = mysql_fetch_array( $qTech );
				$sTech = $rTech[1];
				
				$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rEvent[2]."' LIMIT 1;" );
				$rDate = mysql_fetch_array( $qDate );
				$sDate = $rDate[4];	
				
				$sDuree = $rEvent[5].' '.( ($rEvent[5]<2) ? 'heure prévue' : 'heures prévues' );
				
				echo '<h3>'.'Évènement le '.$sDate.'</h3>';
				echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
					echo '<tr>';
						echo '<td>'.'<label>ID Event: </label>'.'</td>';
						echo '<td>'.'<span>'.$rEvent[0].'</span>'.'</td>';																					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Heure: </label>'.'</td>';
						echo '<td>'.'<span>'.$rEvent[3].'</span>'.'</td>';		
					echo '</tr>';
				echo '</table>';
				echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
					echo '<tr>';
					echo '<td align="right">'.'<label>Technicien: </label>'.'</td>';
						echo '<td>'.'<span>'.$sTech.'</span>'.'</td>';		
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Description: </label>'.'</td>';					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<span>'.$sDesc.'</span>'.'</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Durée approximative: </label>'.'</td>';					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<span>'.$sDuree.'</span>'.'</td>';
					echo '</tr>';
				echo '</table>';
			}
			break;
			
		// Afficher task
		case 3:
			if( $id > -1 )
			{
				$qTask = mysql_query( "SELECT * FROM task WHERE `id`='".$id."' LIMIT 1;" );
				$rTask = mysql_fetch_array( $qTask );
				$sDesc = $rTask[5];
				
				$qTech = mysql_query( "SELECT * FROM technicien WHERE id='".$rTask[1]."' LIMIT 1;" );
				$rTech = mysql_fetch_array( $qTech );
				$sTech = $rTech[1];
				
				$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rTask[2]."' LIMIT 1;" );
				$rDate = mysql_fetch_array( $qDate );
				$sDate = $rDate[4];	
				
				$sDuree = $rTask[4].' '.( ($rTask[4]<2) ? 'heure prévue' : 'heures prévues' );
				
				echo '<h3>'.'Tâche le '.$sDate.'</h3>';
				echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
					echo '<tr>';
						echo '<td>'.'<label>ID Event: </label>'.'</td>';
						echo '<td>'.'<span>'.$rTask[0].'</span>'.'</td>';																					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Heure: </label>'.'</td>';
						echo '<td>'.'<span>'.$rTask[3].'</span>'.'</td>';		
					echo '</tr>';
				echo '</table>';
				echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
					echo '<tr>';
					echo '<td align="right">'.'<label>Technicien: </label>'.'</td>';
						echo '<td>'.'<span>'.$sTech.'</span>'.'</td>';		
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Description: </label>'.'</td>';					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<span>'.$sDesc.'</span>'.'</td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label>Durée approximative: </label>'.'</td>';					
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<span>'.$sDuree.'</span>'.'</td>';
					echo '</tr>';
				echo '</table>';
			}
			break;
			
		default: break;	
		
	}
	echo '</div>';
?>