<?php
	echo '<div id="file-search">';
		echo '<form method="post" action="./index.php?p=printcenter">';
			echo '<label for="file-search-field">'.'Rechercher :'.'</label>';
			echo '<input class="text" type="text" name="file-search-field" /><br />';
			/*
			echo '<input type="checkbox" checked name="check-client" value="1" /><span>Fiche client</span>';
			echo '<input type="checkbox" name="check-rep" value="0" /><span>Fiche réparation</span>';
			echo '<input type="checkbox" name="check-mac" value="0" /><span>Fiche machine</span>';
			*/
			echo '<input class="button" type="submit" value="Go" />';
			echo '<input type="hidden" name="isSearched" />';
		echo '</form>';
		echo '<h1>Centre des recherches et impressions</h1>';
		echo '<div id="info-print">';
			echo '<span>'.'Lorsque vous </span><span style="color: #006; ">recherchez en entrant un texte</span><span>, les clients sont examinés ainsi que les réparations relatives à ceux-ci. La </span><span style="color: #006;">recherche par date</span><span> peut vous faire gagner du temps, ainsi toutes les données ayant été enregistrées concernant les clients et les réparations le </span><span style="color: #006;">jour indiqué</span><span>, seront disponible à l\'impression. Le format de lecture de la date est: \'DD.MM.YYYY\'.'.' Le </span><span style="color: #006;">numéro de téléphone du client</span><span> peut lui aussi être utilisé comme critère de recherche. Ainsi le(s) clients ayant été enregistré avec ce numéro de téléphone seront retournés.</span>';
		echo '</div>';
	echo '</div>';
	
	echo '<div id="search-results">';
		
		if( isset( $_POST['isSearched'] ) ) {
			$tRCl = array( "" );
			$indexRCl = 0;
					$qClByTel = mysql_query( "SELECT * FROM clients WHERE `numtel` = '".$_POST['file-search-field']."';" );
					$qDate = mysql_query( "SELECT * FROM date WHERE `string_date` = '".$_POST['file-search-field']."'; " );
					$iDate = -1;
					$iCl = -1;
					if( mysql_numrows( $qDate ) > 0 )
					{
						$rD = mysql_fetch_array( $qDate );
						$iDate = $rD[0];
					}
					
					if( mysql_numrows( $qClByTel ) > 0 ) {
						$rCl = mysql_fetch_array( $qClByTel );
						$iCl = $rCl[0];
					}
					/*echo 'Client checked.<br />';*/
					$qClients = null;
				if( $iDate != -1 || $iCl != -1 ) {
					//$qClients = mysql_query( "SELECT * FROM clients WHERE id = '".'2'."';" );
					if( $iCl != -1 )
						$qClients = mysql_query( "SELECT * FROM clients WHERE id = '".$iCl."';" );
						
					if( $iDate != -1 )
						$qClients = mysql_query( "SELECT * FROM clients WHERE `date_id` = '".$iDate."';" );
				}
				else {
				 $qClients = mysql_query( "SELECT * FROM clients WHERE INSTR( `libelle`, '".$_POST['file-search-field']."' );" );
				 }
				 echo '<div id="res-clients">';
				 	echo '<div class="title"><span>Clients</span></div>';
				 	echo '<div class="results">';
			//		echo '<span>'.'Aucun résultat à afficher. : '.mysql_numrows( $qClients ).' - '.$_POST['search-text'].'</span>';
			 	 if( mysql_numrows( $qClients ) > 0 ) {
				 	echo '<ul>';
					$i = 0;
					while( $rCl = mysql_fetch_array( $qClients ) ) {
						$tRCl[$indexRCl] = $rCl;
						$indexRCl++;
						if( $i < mysql_numrows( $qClients ) - 1 )
							echo '<li>'.'<span>'.$rCl[1].'</span>'.'<img onclick="window.location.href=\'index.php?p=ficheclient&cl='.$rCl[0].'\';" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'#fff\';" src="./images/moreinfo.png" />'.'<img onclick="javascript: printFiche( 0, \''.$rCl[0].'\' );" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'#fff\';" src="./images/print.png" />'.'<span>, '.'</span>'.'</li>';
							/*onclick="window.location.href=\'index.php?p=ficheclient&cl='.$rCl[0].'\';"*/
						else
							echo '<li>'.'<span>'.$rCl[1].'</span>'.'<img onclick="window.location.href=\'index.php?p=ficheclient&cl='.$rCl[0].'\';" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'#fff\';" src="./images/moreinfo.png" />'.'<img onclick="javascript: printFiche( 0, \''.$rCl[0].'\' );" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'#fff\';"  src="./images/print.png" />'.'<span>. </span>'.'</li>';
							/*onclick="window.location.href=\'index.php?p=ficheclient&cl='.$rCl[0].'\';"+*/
						$i++;
					}
					echo '</ul>';
				}
				else
					echo '<span>'.'Aucun résultat à afficher pour la recherche: '.$_POST['file-search-field'].'</span>';
					
					echo '</div>';
				echo '</div>';
			
				/*echo 'Réparation checked<br />;*/
				$tRRep = array( "" );
				$indexRRep = 0;
				echo '<div style="margin-left: 5px;border: 0px; border-bottom: 1px solid #06c; width: 150px; text-align:right;">';			
					echo '<span style="font-family: Georgia; font-size: 9pt; font-weight: bold; text-decoration: none; color: #c66;">';
					echo 'Réparations';
					echo '</span>';
				echo '</div>';
				if( $iDate == -1 && (count($tRCl) > 1) ) {
				for( $i = 0; $i < count( $tRCl ); $i++ ) {					
					$qTmpMac = mysql_query( "SELECT * FROM machine WHERE `client_id` = '".$tRCl[$i][0]."';" );
					while( $rTM = mysql_fetch_array( $qTmpMac ) ) {
						$qTmpRep = mysql_query( "SELECT * FROM reparation WHERE `machine_id` = '".$rTM[0]."';" );
						while( $rTR = mysql_fetch_array( $qTmpRep ) ) {
							$tRRep = $rTR;
							$indexRRep++;				
							
							$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rTR[2]."' LIMIT 1;" );
							$rDate = mysql_fetch_array( $qDate );
							$sDate = $rDate[4];			
							$qCl = mysql_query( "SELECT * FROM clients WHERE id = '".$rTM[6]."' LIMIT 1;" );
							$rCl = mysql_fetch_array( $qCl );
							$sCl = $rCl[1];
							
							echo '<div class="rep"  onmouseover="this.style.background= \'#d0e0f3\';" onmouseout="this.style.background= \'#fff\';">';
								echo '<div class="title">';
									echo '<span>'.'ID: '.$rTR[0].' - Machine: '.$rTR[1].' - Client: ['.$rTM[6].'] '.$sCl.'</span>';
									echo '<img height="12px" onclick="window.location.href=\'index.php?p=workplace&showrep='.$rTR[0].'\';" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'#fff\';" src="./images/moreinfo.png" />'.'<span> - </span>'.'<img height="12px"  onclick="javascript: printFiche( 1, \''.$rTR[0].'\' );" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'#fff\';" src="./images/print.png" />';									
								echo '</div>';
								echo '<div class="data">';
									echo '<table cellpadding="0px" cellspacing="5px" border="0px">';
										echo '<tr>';
											echo '<td>'.'<label for="idr">'.'ID Réparation: '.'</label>'.'</td>';
											echo '<td>'.'<span name="idr">'.$rTR[0].'</span>'.'</td>';						
											echo '<td>'.'<label for="datee">'.'Date d\'entrée: '.'</label>'.'</td>';
											echo '<td>'.'<span name="datee">'.$sDate.'</span>'.'</td>';
											echo '<td>'.'<label for="state">'.'Statut: '.'</label>'.'</td>';
											echo '<td>'.'<span name="state">';
											if( $rTR[5] == 1 )
												echo 'Terminé.';
											else
												echo 'En cours..';
											echo '</span></td>';
											echo '<td>'.'<label for="datee">'.'Prix Total TVAC: '.'</label>'.'</td>';
											echo '<td>'.'<span name="datee">'.$rTR[3].' &euro;</span>'.'</td>';
										echo '</tr>';
									echo '</table>';
									echo '<ul>';
										$qPr = mysql_query( "SELECT * FROM prester WHERE `reparation_id` = '".$rTR[0]."';" );
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
								echo '</div>';					
							echo '</div>';	
							
						}
					}
				}
				
			} // Date est trouvée !
			else {
				$qTmpRep = mysql_query( "SELECT * FROM reparation WHERE `date_id` = '".$iDate."';" );
				while( $rTR = mysql_fetch_array( $qTmpRep ) ) {
							$tRRep = $rTR;
							$indexRRep++;		
							
							$qTM = mysql_query( "SELECT * FROM machine WHERE id = '".$rTR[1]."';" );
							$rTM = mysql_fetch_array( $qTM );		
							
							$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rTR[2]."' LIMIT 1;" );
							$rDate = mysql_fetch_array( $qDate );
							$sDate = $rDate[4];			
							$qCl = mysql_query( "SELECT * FROM clients WHERE id = '".$rTM[6]."' LIMIT 1;" );
							$rCl = mysql_fetch_array( $qCl );
							$sCl = $rCl[1];
							
							echo '<div class="rep" onmouseover="this.style.background= \'#d0e0f3\';" onmouseout="this.style.background= \'#fff\';">';
								echo '<div class="title">';
									echo '<span>'.'ID: '.$rTR[0].' - Machine: '.$rTR[1].' - Client: ['.$rTM[6].'] '.utf8_decode( $sCl ).'</span>';
									echo '<img height="12px" onclick="window.location.href=\'index.php?p=workplace&showrep='.$rTR[0].'\';" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'#fff\';" src="./images/moreinfo.png" />'.'<span> - </span>'.'<img height="12px"  onclick="javascript: printFiche( 1, \''.$rTR[0].'\' );" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'#fff\';" src="./images/print.png" />';
								echo '</div>';
								echo '<div class="data">';
									echo '<table cellpadding="0px" cellspacing="5px" border="0px">';
										echo '<tr>';
											echo '<td>'.'<label for="idr">'.'ID Réparation: '.'</label>'.'</td>';
											echo '<td>'.'<span name="idr">'.$rTR[0].'</span>'.'</td>';						
											echo '<td>'.'<label for="datee">'.'Date d\'entrée: '.'</label>'.'</td>';
											echo '<td>'.'<span name="datee">'.$sDate.'</span>'.'</td>';
											echo '<td>'.'<label for="state">'.'Statut: '.'</label>'.'</td>';
											echo '<td>'.'<span name="state">';
											if( $rTR[5] == 1 )
												echo 'Terminé.';
											else
												echo 'En cours..';
											echo '</span></td>';
											echo '<td>'.'<label for="datee">'.'Prix Total TVAC: '.'</label>'.'</td>';
											echo '<td>'.'<span name="datee">'.$rTR[3].' &euro;</span>'.'</td>';
										echo '</tr>';
									echo '</table>';
									echo '<ul>';
										$qPr = mysql_query( "SELECT * FROM prester WHERE `reparation_id` = '".$rTR[0]."';" );
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
								echo '</div>';					
							echo '</div>';	
							
						}
			}
			
			
		/*	echo isset( $_POST['check-mac'] ) ? "Machine Checked<br />" : "Machine Unchecked<br />";*/
		}
	echo '</div>';
?>