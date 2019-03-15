<html>
	<head>
		<?php
			echo "<title>Réparation-".$_GET['rep']."</title>";
		?>
		<link rel="stylesheet" type="text/css" href="../css/ficheStyles.css" />
	<head>
	<body>
		<?php
			$r_id = 2;
			if( isset( $_GET['rep'] ) )
				$r_id = $_GET['rep'];
			
			require( "func.php" );
			mysql_connect( $m_host, $m_user, $m_pass ) or die( "erreur de connexion à la BD. (".mysql_error( ).")" );
			mysql_select_db( $m_bdd );
			$qR = mysql_query( "SELECT * FROM reparation WHERE id='".$r_id."' LIMIT 1;" );
			$rR = mysql_fetch_array( $qR );
		
			$idMac = $rR[1];
			$qMac = mysql_query( "SELECT * FROM machine WHERE id='".$idMac."' LIMIT 1;" );
		echo '<div id="info-machines">';
			echo '<h1>'.'Informations sur la machine'.'</h1>';
			while( $rMac = mysql_fetch_array( $qMac ) ) {
				$qType = mysql_query( "SELECT * FROM type_machine WHERE id='".$rMac[5]."' LIMIT 1;" );
				$rType = mysql_fetch_array( $qType );
				$sType = $rType[1];
				$qRep = mysql_query( "SELECT * FROM reparation WHERE `machine_id`='".$rMac[0]."';" );
				$iRep = mysql_numrows( $qRep );
				$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$rMac[6]."' LIMIT 1;" );
				$rCl = mysql_fetch_array( $qCl );
				$cntEnCours = 0;
				while( $rRep = mysql_fetch_array( $qRep ) )
					if( $rRep[5] == 0 )
						$cntEnCours++;
				echo '<div class="machine-rep">';
					echo '<div class="title">';
						echo '<span>'.utf8_decode( $rMac[4] ).' [ID: '.$rMac[0].']</span>';
					echo '</div>';
					echo '<div class="data">';
						echo '<table cellpadding="0px" cellspacing="5px" border="0px">';
							echo '<tr>';
								echo '<td>'.'<label for="typem">'.'Type de machine: '.'</label>'.'</td>';
								echo '<td>'.'<span name="typem">'.utf8_decode( $sType ).'</span>'.'</td>';						
								echo '<td>'.'<label for="nrep">'.'ID du client: '.'</label>'.'</td>';
								echo '<td>'.'<span name="nrep">'.$rCl[0].'</span>'.'</td>';
								echo '<td>'.'<label for="repn">'.'Libellé du client: '.'</label>'.'</td>';
								echo '<td>'.'<span name="repn">'.$rCl[1].'</span>'.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>'.'<label for="typem">'.'Tél. du client: '.'</label>'.'</td>';
								echo '<td>'.'<span name="typem">'.$rCl[5].'</span>'.'</td>';						
								echo '<td>'.'<label for="nrep">'.'Mail du client: '.'</label>'.'</td>';
								echo '<td>'.'<span name="nrep">'.$rCl[10].'</span>'.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>'.'<label for="typem">'.'Adresse du client: '.'</label>'.'</td>';
								echo '<td>'.'<span name="typem">'.$rCl[7].' - '.$rCl[8].' '.$rCl[9].'</span>'.'</td>';
							echo '</tr>';
						echo '</table>';
					echo '</div>';					
				echo '</div>';
			}
		echo '</div>';
		
		$qRep = mysql_query( "SELECT * FROM reparation WHERE id='".$r_id."' LIMIT 1;" );
		$iRep = mysql_numrows( $qRep );
		echo '<div id="info-rep">';
			echo '<h1>'.'Informations sur la réparation'.'</h1>';
			while( $rRep = mysql_fetch_array( $qRep ) ) {
				$qMach = mysql_query( "SELECT * FROM machine WHERE id='".$rRep[1]."' LIMIT 1;" );
				$rMach = mysql_fetch_array( $qMach );
				$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rRep[2]."' LIMIT 1;" );
				$rDate = mysql_fetch_array( $qDate );
				$sDate = $rDate[4];			
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
									$t = '';
									$t .= '<li>'.'<span>'.$sPrest.'</span>'.' - <span style="color:#00f;">'.'Infos: '.$rPr[3].'</span>';
									if( $rPr[4] == 100 ) 
										$t .= ' [ <span style="color: #363;">'.'état: Terminé.'.'</span> ]';
									else
										$t .= ' [ <span style="color: #f33;">'.'état: '.$rPr[4].' %'.'</span> ]';
									$t .= '</li>';
									echo $t;
								}
							echo '</ul>';
							$qITexts = mysql_query( "SELECT * FROM itexts WHERE `reparation_id` = '".$rRep[0]."';" );
							$iITexts = mysql_numrows( $qITexts );
							$i = 0;
							if( $iITexts > 0 ) {
								while( $rIText = mysql_fetch_array( $qITexts ) ) {
									if( $rIText[3] == 1 ) {
										if( $i == 0 )
											echo '<h2>iTexts : </h2>';
										echo '<div style="overflow:auto;" class="itext">';
											echo '<span><pre>'.$rIText[1].'</pre></span>';
										echo '</div>';
										$i++;
									}
								}
							}
						echo '</div>';					
					echo '</div>';
			}
		echo '</div>';
		?>
		<script type="text/javascript">window.print()</script>
	</body>
</html>