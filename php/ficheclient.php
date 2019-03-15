<?php
	if( isset( $_GET['add'] ) ) {
		if( $_GET['add'] == 1 ) {
			$libelle = $_POST['libelle'];
			$address = $_POST['address'];
			$cp = $_POST['cp'];
			$ville = $_POST['ville'];
			$tel = $_POST['tel'];
			$fax = $_POST['fax'];
			$mail = $_POST['mail'];
			
			$qInsert = mysql_query( "INSERT INTO `clients` ( `id`, `libelle`, `code_id`, `lname`, `fname`, `numtel`, `numfax`, `addr`, `cp`, `ville`,`email`,`provider`,`type_adsl`,`a_belgtv`,`belgtv_dispo`) VALUES (	NULL , '".$libelle."', '', '', '', '".$tel."', '".$fax."', '".$address."', '".$cp."', '".$ville."', '".$mail."', '0', '', '0', '0'	);" ) or die( 'Erreur: '.mysql_error( ) );
			if( $qInsert )
				echo '<div align="center"><div class="good"><span>Le client a été ajouté avec succès.</span></div></div>';
		}	
	}
	
	if( isset( $_GET['import'] ) ) {
		$fPath = $_FILES['file_path']['tmp_name'];
		$handle = @fopen($fPath, "r");
		$bErr = false;
		if( $handle ) {
			$nCl = 0;
			$aCl = array( "" );
			while( $row = fgets( $handle ) ) {
				$aCl[$nCl] = $row;
				$nCl++;
			}
			for( $i = 0; $i < count( $aCl ); $i++ ) {
			//	echo $aCl[$i].'<br />';
				$aLine = split( ';', $aCl[$i] );
				if( ( count($aLine = split( ';', $aCl[$i] )) == 7 ) || ( count($aLine = split( ',', $aCl[$i] )) == 7 ) ) {
					$libelle = htmlentities($aLine[0]);
					$tel = $aLine[1];
					$fax = $aLine[2];
					$address = htmlspecialchars($aLine[3], ENT_QUOTES);
					$cp = $aLine[4];
					$ville = $aLine[5];
					$mail = $aLine[6];
					$qInsert = mysql_query( "INSERT INTO `clients` ( `libelle`, `code_id`, `lname`, `fname`, `numtel`, `numfax`, `addr`, `cp`, `ville`,`email`,`provider`,`type_adsl`,`a_belgtv`,`belgtv_dispo`) VALUES (	'".$libelle."', '', '', '', '".$tel."', '".$fax."', '".$address."', '".$cp."', '".$ville."', '".$mail."', '0', '', '0', '0'	);" ) or die( 'Erreur: '.mysql_error( ) );
				}
				else {
					echo '<div align="center"><div class="bad"><span>La syntaxe du fichier lu est erronnée.</span></div></div>';
					$bErr = true;
				}					
			}			
		}
		else {
			echo '<div align="center"><div class="bad"><span>Le fichier spécifié est erroné.</span></div></div>';
			$bErr = true;
		}
		
		if( !$bErr )
			echo '<div align="center"><div class="good"><span>Les '.$nCl.'&nbsp;clients ont été importés avec succès.</span></div></div>';
	}

	if( isset( $_GET['cl'] ) ) {
		$cl_id = $_GET['cl'];
		$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$cl_id."' LIMIT 1;" ) or die( "Client inconnu" );
		$iCl = mysql_numrows( $qCl );
		$rCl = mysql_fetch_array( $qCl );
		$libCl = $rCl[1];
		echo '<div id="print-fiche">';
			echo '<a href="#" onclick="javascript: printFiche( 0, \''.$rCl[0].'\' );">'.'Cliquez ici afin d\'imprimer la fiche'.'</a>';
		echo '</div>';
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
				$sMac = $rMach[4];
				$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rRep[2]."' LIMIT 1;" );
				$rDate = mysql_fetch_array( $qDate );
				$sDate = $rDate[4];
				if( $rMach[6] == $cl_id ) {				
					echo '<div class="rep" onclick="window.location.href=\'index.php?p=workplace&showrep='.$rRep[0].'\';" onmouseover="this.style.cursor=\'pointer\';this.style.background= \'#d0e0f3\';" onmouseout="this.style.background= \'#f6f7fb\';">';
						echo '<div class="title">';
							echo '<span>'.'ID: '.$rRep[0].' - Machine: '.$sMac.'</span>';
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
					echo '<div class="depl" onclick="window.location.href=\'index.php?p=away&id='.$rDepl[0].'\';" onmouseover="this.style.cursor=\'pointer\';this.style.background= \'#d0e0f3\';" onmouseout="this.style.background= \'#f6f7fb\';">';
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
		
		
	}
	else {
		echo '<div id="panel-clients">';
			echo '<h1>Centre de gestion de la clientèle</h1>';
			echo '<div id="add-new-client">';
				echo '<h2>Ajouter un nouveau client</h2>';
				echo '<form method="post" action="./index.php?p=ficheclient&add=1">';
					echo '<table cellpadding="0px" cellspacing="5px" border="0px">';
						echo '<tr>';
							echo '<td>'.'<label for="libelle">Libellé :</label>'.'</td>';
							echo '<td>'.'<input type="text" name="libelle" />'.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>'.'<label for="address">Adresse :</label>'.'</td>';
							echo '<td>'.'<input type="text" name="address" />'.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>'.'<label for="cp">Code postal :</label>'.'</td>';
							echo '<td>'.'<input type="text" name="cp" />'.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>'.'<label for="ville">Ville :</label>'.'</td>';
							echo '<td>'.'<input type="text" name="ville" />'.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>'.'<label for="tel">Num. Tél. :</label>'.'</td>';
							echo '<td>'.'<input type="text" name="tel" />'.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>'.'<label for="fax">Num. Fax :</label>'.'</td>';
							echo '<td>'.'<input type="text" name="fax" />'.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>'.'<label for="mail">Mail :</label>'.'</td>';
							echo '<td>'.'<input type="text" name="mail" />'.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>&nbsp;</td>';
							echo '<td>';
								echo '<input onclick="this.className=\'hide\'; document.getElementById( \'infoAdd\' ).className=\'show\';" type="submit" value="Ajouter" />';
								echo '<span id="infoAdd" class="hide">Le client a été ajouté avec succès.</span>';
							echo '</td>';
						echo '</tr>';						
					echo '</table>';
				echo '</form>';
			echo '</div>';
			echo '<div id="list-clients">';
				echo '<h2>Liste des clients</h2>';
				echo '<ul id="customer-list">';
					$qCl = mysql_query( "SELECT * FROM clients;" );
					$i = 0;
					while( $rCl = mysql_fetch_array( $qCl ) ) {
						echo '<li id="customer-'.$i.'" class="show" onclick="window.location.href=\'index.php?p=ficheclient&cl='.$rCl[0].'\';" onmouseover="this.style.background = \'#dcdcdc\';this.style.cursor=\'pointer\';" onmouseout="this.style.background= \'transparent\';">'.'<span>'.$rCl[1].'</span>'.'</li>';
						$i++;
					}
				echo '</ul>';
				echo '<input type="text" onchange="searchCust( this.value ); window.focus( )" />';
				echo '<input type="submit" value="Go" onclick="javascript: return false;" />';
			echo '</div>';
			echo '<hr />';
			echo '<div id="import-client">';
				echo '<h2>Importer des clients</h2>';
				echo '<div align="center"><div style="border: 0px; border-bottom: 1px dashed #881e98; width: 75%;">';
					echo '<span>'.'Veuillez choisir le fichier à lire afin de lancer l\'importation.'.'</span>';
				echo '</div></div>';
				echo '<form method="post" enctype="multipart/form-data" action="./index.php?p=ficheclient&import=1">';
					echo '<div style="margin-top: 5px;" align="center"><input type="file" name="file_path" /></div>';
					echo '<div style="margin-top: 5px;margin-left: 80px;"><input type="submit" value="Importer" /></div>';
				echo '</form>';
			echo '</div>';
		echo '</div>';
	}
?>