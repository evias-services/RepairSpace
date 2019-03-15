<html>
	<head>
		<?php
			echo "<title>Client-".$_GET['cl']."</title>";
		?>
		<link rel="stylesheet" type="text/css" href="../css/ficheStyles.css" />
	<head>
	<body>
		<?php
			$cl_id = 2;
			if( isset( $_GET['cl'] ) )
				$cl_id = $_GET['cl'];
			
			require( "func.php" );
			mysql_connect( $m_host, $m_user, $m_pass ) or die( "erreur de connexion à la BD. (".mysql_error( ).")" );
			mysql_select_db( $m_bdd );
			$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$cl_id."' LIMIT 1;" );
			$rCl = mysql_fetch_array( $qCl );
			echo '<div id="info-legale">';
			echo '<h1>'.'Informations légales'.'</h1>';
			echo '<table cellpadding="0px" cellspacing="5px" border="0px">';
					echo '<tr>';
						echo '<td>'.'<label for="libelle">'.'Libellé: '.'</label>'.'</td>';
						echo '<td>'.'<span name="libelle">'.$rCl[1].'</span>'.'</td>';						
						echo '<td>'.'<label for="address">'.'Adresse: '.'</label>'.'</td>';
						echo '<td>'.'<span name="address">'.$rCl[7].'</span>'.'</td>';						
						echo '<td>'.'<label for="address">'.'Ville: '.'</label>'.'</td>';
						echo '<td>'.'<span name="address">'.truncStops( ($rCl[8].' '.$rCl[9]), 38 ).'</span>'.'</td>';	
					echo '</tr>';
					echo '<tr>';
						echo '<td>'.'<label for="tel">'.'Num. Tél.: '.'</label>'.'</td>';
						echo '<td>'.'<span name="tel">'.$rCl[5].'</span>'.'</td>';						
						echo '<td>'.'<label for="fax">'.'Num. Fax: '.'</label>'.'</td>';
						echo '<td>'.'<span name="fax">'.$rCl[6].'</span>'.'</td>';						
						echo '<td>'.'<label for="mail">'.'Email: '.'</label>'.'</td>';
						echo '<td>'.'<span name="mail">'.$rCl[10].'</span>'.'</td>';	
					echo '</tr>';
			echo '</table>';
		echo '</div>';
		
		$qMac = mysql_query( "SELECT * FROM machine WHERE `client_id`='".$cl_id."';" );
		$iMac = mysql_numrows( $qMac );
		echo '<div id="info-machines">';
			echo '<h1>'.'Machines enregistrées'.'</h1>';
			while( $rMac = mysql_fetch_array( $qMac ) ) {
				$qType = mysql_query( "SELECT * FROM type_machine WHERE id='".$rMac[5]."' LIMIT 1;" );
				$rType = mysql_fetch_array( $qType );
				$sType = $rType[1];
				$qRep = mysql_query( "SELECT * FROM reparation WHERE `machine_id`='".$rMac[0]."';" );
				$iRep = mysql_numrows( $qRep );
				$cntEnCours = 0;
				while( $rRep = mysql_fetch_array( $qRep ) )
					if( $rRep[5] == 0 )
						$cntEnCours++;
				echo '<div class="machine">';
					echo '<div class="title">';
						echo '<span>'.utf8_decode( $rMac[4] ).' [ID: '.$rMac[0].']</span>';
					echo '</div>';
					echo '<div class="data">';
						echo '<table cellpadding="0px" cellspacing="5px" border="0px">';
							echo '<tr>';
								echo '<td>'.'<label for="typem">'.'Type de machine: '.'</label>'.'</td>';
								echo '<td>'.'<span name="typem">'.utf8_decode( $sType ).'</span>'.'</td>';						
								echo '<td>'.'<label for="nrep">'.'Nombre de réparation: '.'</label>'.'</td>';
								echo '<td>'.'<span name="nrep">'.$iRep.'</span>'.'</td>';
								echo '<td>'.'<label for="repn">'.'Réparations en cours: '.'</label>'.'</td>';
								echo '<td>'.'<span name="repn">'.$cntEnCours.'</span>'.'</td>';
							echo '</tr>';
						echo '</table>';
					echo '</div>';					
				echo '</div>';
			}
		echo '</div>';
		
		$qRep = mysql_query( "SELECT * FROM reparation ORDER BY id DESC;" );
		$iRep = mysql_numrows( $qRep );
		echo '<div id="info-rep">';
			echo '<h1>'.'Réparations enregistrées'.'</h1>';
			while( $rRep = mysql_fetch_array( $qRep ) ) {
				$qMach = mysql_query( "SELECT * FROM machine WHERE id='".$rRep[1]."' LIMIT 1;" );
				$rMach = mysql_fetch_array( $qMach );
				$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rRep[2]."' LIMIT 1;" );
				$rDate = mysql_fetch_array( $qDate );
				$sDate = $rDate[4];
				if( $rMach[6] == $cl_id ) 
				{				
					echo '<div class="rep">';
						echo '<div class="title">';
							echo '<span>'.'ID: '.$rRep[0].' - Machine: '.$rRep[1].'</span>';
						echo '</div>';
						echo '<div class="data">';
							echo '<table cellpadding="0px" cellspacing="5px" border="0px">';
								echo '<tr>';
									echo '<td>'.'<label for="idr">'.'ID Réparation: '.'</label>'.'</td>';
									echo '<td>'.'<span name="idr">'.$rRep[0].'</span>'.'</td>';						
									echo '<td>'.'<label for="datee">'.'Date d\'entrée: '.'</label>'.'</td>';
									echo '<td>'.'<span name="datee">'.$sDate.'</span>'.'</td>';
									echo '<td>'.'<label for="state">'.'Statut: '.'</label>'.'</td>';
									echo '<td>'.'<span name="state">';
										if( $rRep[5] == 1 )
											echo 'Terminé.';
										else
											echo 'En cours..';
									echo '</span></td>';
									echo '<td>'.'<label for="datee">'.'Prix Total TVAC: '.'</label>'.'</td>';
									echo '<td>'.'<span name="datee">'.$rRep[3].' &euro;</span>'.'</td>';
								echo '</tr>';
							echo '</table>';
							echo '<ul>';
								$qPr = mysql_query( "SELECT * FROM prester WHERE `reparation_id` = '".$rRep[0]."';" );
								while( $rPr = mysql_fetch_array( $qPr ) ) {
									$qP = mysql_query( "SELECT * FROM prestation WHERE id='".$rPr[1]."' LIMIT 1;" );
									$rP = mysql_fetch_array( $qP );
									$sPrest = $rP[1];
									echo '<li>'.'<span>'.$sPrest.'</span>'.'</li>';
								}
							echo '</ul>';
						echo '</div>';					
					echo '</div>';
				} else
					continue;
			}
		echo '</div>';
		
		$qDepl = mysql_query( "SELECT * FROM deplacement WHERE `idClient`='".$_GET['cl']."';" );
		$iDepl = mysql_numrows( $qDepl );
		echo '<div id="info-depl">';
			echo '<h1>'.'Déplacements enregistrés'.'</h1>';
			while( $rDepl = mysql_fetch_array( $qDepl ) ) {
				$sMac = $rDepl[2];
				$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rDepl[4]."' LIMIT 1;" );
				$rDate = mysql_fetch_array( $qDate );
				$sDate = $rDate[4];
					echo '<div class="depl">';
						echo '<div class="title">';
							echo '<span>'.'ID: '.$rDepl[0].' - Description: '.$sMac.'</span>';
						echo '</div>';
						echo '<div class="data">';
							echo '<table cellpadding="0px" cellspacing="5px" border="0px">';
								echo '<tr>';
									echo '<td>'.'<label for="idr">'.'ID Déplacement: '.'</label>'.'</td>';
									echo '<td>'.'<span name="idr">'.$rDepl[0].'</span>'.'</td>';						
									echo '<td>'.'<label for="datee">'.'Date d\'entrée: '.'</label>'.'</td>';
									echo '<td>'.'<span name="datee">'.$sDate.'</span>'.'</td>';
									echo '<td>'.'<label for="datee">'.'Prix Total TVAC: '.'</label>'.'</td>';
									echo '<td>'.'<span name="datee">'.$rDepl[6].' &euro;</span>'.'</td>';
								echo '</tr>';
							echo '</table>';
							echo '<ul>';
								$qPr = mysql_query( "SELECT * FROM prester_depl WHERE `deplacement_id` = '".$rDepl[0]."';" );
								while( $rPr = mysql_fetch_array( $qPr ) ) {
									$qP = mysql_query( "SELECT * FROM prestation WHERE id='".$rPr[1]."' LIMIT 1;" );
									$rP = mysql_fetch_array( $qP );
									$sPrest = $rP[1];
									echo '<li>'.'<span>'.$sPrest.'</span>'.'</li>';
								}
							echo '</ul>';
						echo '</div>';					
					echo '</div>';
			}
		echo '</div>';
		?>
		<script type="text/javascript">window.print()</script>
	</body>
</html>