<?php
	// Centre des déplacements
	// Copyright Grégory Saive
	// 23.07.2009 
	
		$techN = $_COOKIE['tech_log'];
		$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
		$rT = mysql_fetch_array( $qT );
		$idTech = $rT[0];
	
		$idAway = -1;
		
		if( isset( $_GET['addedData'] ) )
		{
			$b = $_GET['addedData'];
			if( $b == 0 )
			{
				echo '<div class="bad"><span>Erreur de l\'enregistrement de donnée</span></div>';
				echo '<script type="text/javascript">';
					echo 'logNow( \''.$idTech.'\', \'Été sujet à erreur.\' );';
				echo '</script>';
			}
			else
				echo '<div class="good"><span>Données enregistrées avec succès</span></div>';
		}

	
	echo '<div id="away-box">';
		echo '<h1>'.$m_arrTxt[92].'</h1>';
		echo '<div id="info-away">';
			echo '<span>'.$m_arrTxt[93].'</span>';
		echo '</div>';
		echo '<div id="away-menu">';
			echo '<ul>';
				echo '<li><a href="index.php?p=away&listaway=1">'.$m_arrTxt[94].'</a></li>';				
				echo '<li><a href="index.php?p=away&managedist=1">'.$m_arrTxt[95].'</a></li>';
				echo '<li><a href="index.php?p=away&showmonth='.(date( "m" )-1).'&y='.date( 'Y' ).'">'.$m_arrTxt[96].'</a></li>';
				echo '<li><a href="index.php?p=away&showweek='.date('d.m.Y').'">'.$m_arrTxt[97].'</a></li>';
				echo '<li><a href="index.php?p=away&showyear='.date( 'Y' ).'">'.$m_arrTxt[98].'</a></li>';				
				echo '<li><a href="index.php?p=away&addAway=1">'.$m_arrTxt[99].'</a></li>';
				echo '<li><a href="index.php?p=cal&addEvent=1">'.$m_arrTxt[100].'</a></li>';				
				echo '<li><a href="index.php?p=cal&addMeeting=1">'.$m_arrTxt[101].'</a></li>';
				echo '<li><a href="index.php?p=cal&addTask=1">'.$m_arrTxt[102].'</a></li>';
			echo '</ul>';
		echo '</div>';
		echo '<hr />';
				
		/*  #################################
				AJOUT DUNE DISTANCE
		    #################################*/
		    
		if( isset( $_POST['isAddDist'] ) ) {
			$qIns = mysql_query( "INSERT INTO `intratelier09`.`distance` (`prix` ,`desc` ,`small_desc`)VALUES ('".$_POST['prizeDist']."', '".$_POST['descDist']."', '".$_POST['kmDist']."');" );
			$idD = mysql_insert_id( );
			echo '<script type="text/javascript">';
				echo 'logNow( \''.$idTech.'\', \'Ajouté distance. [Dist: '.$idD.']\' );';
			echo '</script>';
		}
		
		/*  #################################
				AJOUT DUN DEPLACEMENT		
		    #################################*/
		    
		if( isset( $_POST['isAddAway'] ) ) {
			$libCl = $_POST['libCl'];
			$addrCl = $_POST['addrCl'];
			$cpCl = $_POST['cpCl'];
			$villeCl = $_POST['villeCl'];
			$telCl = $_POST['telCl'];
			$descAway = $_POST['descAway'];
			$timeAway = $_POST['timeAway'];
			$distAway = $_POST['dist-select'];
			$idTech = $_POST['technician'];
			$dateAway = $_POST['dateAway'];
			// Au cas ou l'utilisateur utilise le 'h' a la place du ':'
			$timeAway = str_replace( 'h', ':', $timeAway );
			if( $timeAway == "Format: HH:MM" )
				$timeAway = '08:00';
				
			$qDist = mysql_query( "SELECT * FROM distance WHERE id='".$distAway."' LIMIT 1;" );
			$rDist = mysql_fetch_array( $qDist );
			$pDist = $rDist[1];
				
			$idDate = 0;
			$sDate = $dateAway;
			$nD = date( 'd.m.Y' );
			$qD = mysql_query( "SELECT * FROM date WHERE `string_date`='".$sDate."' LIMIT 1;" );
			$qnD = mysql_query( "SELECT * FROM date WHERE `string_date`='".$nD."' LIMIT 1;" );
			$rD = mysql_fetch_array( $qnD );
			$nIDDate = $rD[0];
			if( mysql_numrows( $qD ) == 0 ) {
				$qInsD = mysql_query( "INSERT INTO `date` ( `jour`, `mois`, `annee`, `string_date` ) VALUES( '".substr( $dateAway, 0, 2 )."','".substr( $dateAway, 3, 2 )."','".substr( $dateAway, 6, 4 )."','".$sDate."' );" );
				$idDate = mysql_insert_id( );
			}
			else
			{
				$rD = mysql_fetch_array( $qD );
				$idDate = $rD[0];
			}
			
			if( !isset( $_POST['idCl'] ) || empty( $_POST['idCl'] ) )
			{
				$insCl = mysql_query( "INSERT INTO `intratelier09`.`clients` (`id` ,`libelle` ,`code_id` ,`lname` ,`fname` ,`numtel` ,`numfax` ,`addr` ,`cp` ,`ville` ,`email` ,`provider` ,`type_adsl` ,`a_belgtv` ,`belgtv_dispo` ,`date_id`)VALUES (NULL , '".$libCl."', '', '', '', '".$telCl."', '', '".$addrCl."', '".$cpCl."', '".$villeCl."', '', '0', '', '0', '0', '".$nIDDate."');" );
				$idCl = mysql_insert_id( );
			}
			else
				$idCl = $_POST['idCl'];
				
			$insAway = mysql_query( "INSERT INTO `intratelier09`.`deplacement` (`idClient` ,`descMachine` ,`idDistance` ,`date_id` ,`time` ,`total_tvac`, `id_technicien`)VALUES ('".$idCl."', '".$descAway."', '".$distAway."', '".$idDate."', '".$timeAway."', '".$pDist."', '".$idTech."');" ) or die( mysql_error( ) );
			$idAway = mysql_insert_id( );
			
			echo '<script type="text/javascript">';
				echo 'logNow( \''.$idTech.'\', \'Ajouté déplacement. [Away: '.$idAway.']\' );';
			echo '</script>';
			
	//		echo '<div class="good"><span>Le déplacement a bien été ajouté.</span></div>';
		}
		    
		if( isset( $_GET['addAway'] ) ) {
			$sDate = "dd.mm.yyyy";
			$d = 0;
			$m = 0;
			$y = date( 'Y' );
			if( isset( $_GET['d'] ) && isset( $_GET['m'] ) && isset( $_GET['y'] ) ) {
				$sDate = $_GET['d'].'.'.$_GET['m'].'.'.$_GET['y'];
				$d = $_GET['d'];
				$m = $_GET['m'];
				$y = $_GET['y'];
			}
			else {
				$sDate = '';
				if( !isset( $_GET['date'] ) )
				{
					$sDate = date( 'd.m.Y' );
					$d = date( 'd' );
					$m = date( 'm' );
					$y = date( 'Y' );
				}
				else
				{
					$sDate = $_GET['date'];
					$d = substr( $sDate,0, 2 );
					$m = substr( $sDate,3, 2 );
					$y = substr( $sDate,6, 4 );
				}
			}
			$time = '99:99';
			if( isset( $_GET['time'] ) )
			{
				$time = $_GET['time'];
				if( $time < 10 )
					$time = '0'.$time;
				else
					$time = $time;
			}
			echo '<div id="add-away-box">';
			echo '<h2>'.$m_arrTxt[103].' <span style="font-family: Georgia; font-size: 12pt; font-weight: bold;">'.$sDate.'</span></h2>';
			echo '<form method="post" action="index.php?p=away&showmonth='.($m-1).'&y='.$y.'">';
			echo '<div id="info-client">';
			echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
				echo '<tr>';
					echo '<td>'.'&nbsp;'.'</td>';
					echo '<td>'.'<span style="font-family: Georgia; font-size: 10pt; font-weight: bold; text-decoration: underline; color: #039">'.$m_arrTxt[104].'</span>'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="libCl">'.$m_arrTxt[3].': </label>'.'</td>';
					echo '<td>'.'<input id="libCl" class="text" type="text" value="" name="libCl" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="addrCl">'.$m_arrTxt[4].': </label>'.'</td>';
					echo '<td>'.'<input id="addrCl" class="text" type="text" value="" name="addrCl" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="cpCl">'.$m_arrTxt[5].': </label>'.'</td>';
					echo '<td>'.'<input id="cpCl" class="text" type="text" value="" name="cpCl" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="villeCl">'.$m_arrTxt[6].': </label>'.'</td>';
					echo '<td>'.'<input id="villeCl" class="text" type="text" value="" name="villeCl" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="telCl">'.$m_arrTxt[7].': </label>'.'</td>';
					echo '<td>'.'<input id="telCl" class="text" type="text" value="" name="telCl" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="idCl">'.$m_arrTxt[106].': </label>'.'</td>';
					echo '<td>'.'<input id="idCl" style="width:150px;" class="text" type="text" value="" name="idCl" /><input style="margin-left: 5px;" class="button" type="submit" onclick="document.getElementById( \'idCl\' ).value=\'\';document.getElementById( \'libCl\' ).value=\'\';document.getElementById( \'addrCl\' ).value=\'\';document.getElementById( \'cpCl\' ).value=\'\';document.getElementById( \'villeCl\' ).value=\'\';document.getElementById( \'telCl\' ).value=\'\';return false;" value="'.$m_arrTxt[107].'" />'.'</td>';
				echo '</tr>';
			echo '</table>';
			echo '</div>';
			
			echo '<div id="list-clients">';
				echo '<h3>'.$m_arrTxt[105].'</h3>';
				echo '<ul id="customer-list">';
					$qCl = mysql_query( "SELECT * FROM clients;" );
					$i = 0;
					while( $rCl = mysql_fetch_array( $qCl ) ) {
						echo '<li id="customer-'.$i.'" class="show" onclick="updateCustDataFields(\''.$rCl[0].'\',\''.$rCl[1].'\',\''.str_replace('\'', '\\'.'\'', $rCl[7]).'\',\''.$rCl[8].'\',\''.$rCl[9].'\',\''.$rCl[5].'\');" onmouseover="this.style.background = \'#dcdcdc\';this.style.cursor=\'pointer\';" onmouseout="this.style.background= \'transparent\';">'.'<span>'.$rCl[1].'</span>'.'</li>';
						$i++;
					}
				echo '</ul>';
				echo '<input type="text" onchange="searchCust( this.value ); window.focus( )" />';
				echo '<input type="submit" value="Go" onclick="javascript: return false;" />';
			echo '</div>';
			
			echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
				echo '<tr>';
					echo '<td>'.'&nbsp;'.'</td>';
					echo '<td>'.'<span style="font-family: Georgia; font-size: 10pt; font-weight: bold; text-decoration: underline; color: #039">'.$m_arrTxt[108].'</span>'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="descAway">'.$m_arrTxt[109].': </label>'.'</td>';
					echo '<td>'.'<input style="width: 450px;" class="text" type="text" value="'.$m_arrTxt[113].'" name="descAway" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="dateAway">'.$m_arrTxt[110].': </label>'.'</td>';
					echo '<td>'.'<input class="text" type="text" value="'.$sDate.'" name="dateAway" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="timeAway">'.$m_arrTxt[111].': </label>'.'</td>';
					if( $time != '99:99' )
						echo '<td>'.'<input class="text" type="text" value="'.$time.'" name="timeAway" />'.'</td>';
					else
						echo '<td>'.'<input class="text" type="text" value="08:00" name="timeAway" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="distAway">'.$m_arrTxt[112].': </label>'.'</td>';
					echo '<td>';
						echo '<select size=5 name="dist-select">';
							$qDi = mysql_query( "SELECT * FROM distance;" );
							$x = 0;
							while( $rDi = mysql_fetch_array( $qDi ) ) 
							{
								if( $x == 0 )
									echo '<option selected value="'.$rDi[0].'">'.$rDi[2].'</option>';
								else
									echo '<option value="'.$rDi[0].'">'.$rDi[2].'</option>';
								
								$x++;
							}
						echo '</select>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="technician" style="position:relative; top: -40px;">'.$m_arrTxt[51].'</label>'.'</td>';
					echo '<td>';
						echo '<select size="4" id="list-tech" name="technician">';
							$qT = mysql_query( "SELECT * FROM technicien;" );
							while( $rT = mysql_fetch_array( $qT ) )
								echo '<option value="'.$rT[0].'">'.utf8_decode($rT[1]).'</option>';
						echo '</select>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<input type="hidden" name="isAddAway" />'.'</td>';
					echo '<td>'.'<input class="button" type="submit" value="'.$m_arrTxt[10].'" />'.'</td>';
				echo '</tr>';
			echo '</table>';
			echo '</form>';
			echo '</div>';
		}
		
		
		/*  #################################
				AJOUT DUNE PRESTATION
		    #################################*/
		if( isset( $_POST['isAddPrest'] ) ) {
			$idDep = $_GET['id'];
			$isel = $_POST['prestation'];
			$desc = $_POST['desc-mac'];
			
			$tech = -1;
			if( !isset( $_POST['technician'] ) )
				$tech = 0;
			else
				$tech = $_POST['technician'];
			$qP = mysql_query( "SELECT * FROM prestation WHERE `id`='".$isel."' LIMIT 1;" );
			$rP = mysql_fetch_array( $qP );
			$idP = $rP[0];
			$pP = $rP[2];
			$ttvac = 0;
			$qr = mysql_query( "SELECT * FROM deplacement WHERE id =".$idDep." LIMIT 1;" );
			$rr = mysql_fetch_array( $qr );
			$ttvac = $rr[6] + $pP;
			// Update du prix !
			$qPrice = mysql_query( "UPDATE `deplacement` SET `total_tvac` = '".$ttvac."' WHERE `id` =".$idDep." LIMIT 1 ;" );
		
			$qInsert = mysql_query( "INSERT INTO `prester_depl` ( `prestation_id`, `deplacement_id`, `desc`, `done`, `id_technicien` ) VALUES ( '".$idP."', '".$idDep."', '".$desc."', '100', '".$tech."' );" ) or die( mysql_error( ) );
			$idPD = mysql_insert_id( );
			echo '<script type="text/javascript">';
				echo 'logNow( \''.$idTech.'\', \'Ajouté service pour déplacement. [Service: '.$idPD.'] [Away: '.$idDep.']\' );';
			echo '</script>';
		}
		
		if( isset( $_GET['addPrest'] ) )
		{
			$idDep = $_GET['dep'];
			echo '<div id="infos-deplacement">';
				echo '<h2>'.$m_arrTxt[36].'</h2>';
				echo '<form method="post" action="./index.php?p=away&id='.$idDep.'">';
					echo '<select size="10" id="list-prest" name="prestation">';
					$qP = mysql_query( "SELECT * FROM prestation;" );
					while( $rP = mysql_fetch_array( $qP ) )
						echo '<option value="'.$rP[0].'">'.$rP[1].'</option>';
					echo '</select>';
					echo '<div id="other-halfth">';
						echo '<label for="desc-mac">'.$m_arrTxt[35].'</label>';
						echo '<input class="desc-prest" type="text" name="desc-mac" /><br />';
						$qT = mysql_query( "SELECT * FROM technicien ORDER BY id ASC;" );
						if( mysql_numrows( $qT ) > 0 )
						{
							echo '<label for="technician" style="position:relative; top: -40px;">'.$m_arrTxt[51].'</label>';
							echo '<select size="4" id="list-tech" name="technician">';
								while( $rT = mysql_fetch_array( $qT ) )
									echo '<option value="'.$rT[0].'">'.utf8_decode($rT[1]).'</option>';
							echo '</select><br />';
						}										
						echo '<input class="button-add" type="submit" value="'.$m_arrTxt[10].'" />';
						echo '<input type="hidden" name="isAddPrest" />';
					echo '</div>';
				echo '</form>';
			echo '</div>';
		}
		
		// #################################
		// SI UN ID EST DECLARE, IL FAUT AFFICHER LES INFORMATIONS DU DEPLACEMENT
		// #################################		
		if( isset( $_GET['id'] ) ) {
			$qDep = mysql_query( "SELECT * FROM deplacement WHERE id='".$_GET['id']."' LIMIT 1;" );
			$rDep = mysql_fetch_array( $qDep );
			$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$rDep[1]."' LIMIT 1;" );
			$rCl = mysql_fetch_array( $qCl );
			$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rDep[4]."' LIMIT 1;" );
			$rDate = mysql_fetch_array( $qDate );
			$qDist = mysql_query( "SELECT * FROM distance WHERE id='".$rDep[3]."' LIMIT 1;" );
			$rDist = mysql_fetch_array( $qDist );			
			$qTech = mysql_query( "SELECT * FROM technicien WHERE id ='".$rDep[7]."' LIMIT 1;" );
			$rTech = mysql_fetch_array( $qTech );
			$sTech = $rTech[1];
			$sClient = $rCl[1];
			$aClient = $rCl[7].' - '.$rCl[8].' '.$rCl[9];
			$telCl = $rCl[5];
			$mailCl = $rCl[10];
			$sDate = $rDate[4];			
			$sDist = $rDist[3];
			$sTime = $rDep[5];
			$sDesc = $rDep[2];
			$sPrize = $rDep[6];		
			$idTech = $rDep[7];
			
			if( $sPrize == 0 )
			{
				$sPrize = $rDist[1];
				$qEdit = mysql_query( "UPDATE `intratelier09`.`deplacement` SET `total_tvac` = '".$rDist[1]."' WHERE `deplacement`.`id` =".$_GET['id']." LIMIT 1 ;" ) or die( mysql_error( ) );				
			}
			
			echo '<h2>'.$m_arrTxt[114].'</h2>';			
				echo '<div id="info-depl">';	
				
					echo '<h3>'.$m_arrTxt[104].'</h3>';
					echo '<div onclick="window.location.href=\'index.php?p=ficheclient&cl='.$rCl[0].'\';" onmouseover="this.style.cursor=\'pointer\';this.style.background= \'#d0e0f3\';" onmouseout="this.style.background= \'#f6f7fb\';">';
					echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
						echo '<tr>';
							echo '<td>'.'<label>'.$m_arrTxt[3].': </label>'.'</td>';
							echo '<td>'.'<span>'.$sClient.'</span>'.'</td>';
							echo '<td>'.'<label>'.$m_arrTxt[7].': </label>'.'</td>';
							echo '<td>'.'<span>'.$telCl.'</span>'.'</td>';
							echo '<td>'.'<label>'.$m_arrTxt[9].': </label>'.'</td>';
							echo '<td>'.'<span>'.$mailCl.'</span>'.'</td>';
						echo '</tr>';						
					echo '</table>';
					echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
						echo '<tr>';
							echo '<td>'.'<label>'.$m_arrTxt[4].': </label>'.'</td>';
							echo '<td>'.'<span>'.$aClient.'</span>'.'</td>';
						echo '</tr>';						
					echo '</table>';
					echo '</div>';
					
					echo '<h3>'.$m_arrTxt[108].'</h3>';
					echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
						echo '<tr>';
							echo '<td>'.'<label>'.$m_arrTxt[110].': </label>'.'</td>';
							echo '<td>'.'<span style="font-weight: bold;">'.$sDate.'</span>'.'</td>';
							echo '<td>'.'<label>'.$m_arrTxt[111].': </label>'.'</td>';
							echo '<td>'.'<span style="font-weight: bold;">'.str_replace(':', 'h', $sTime).'</span>'.'</td>';
							echo '<td>'.'<label>'.$m_arrTxt[112].': </label>'.'</td>';
							echo '<td>'.'<span>'.$sDist.'</span>'.'</td>';
							echo '<td>'.'<label>'.$m_arrTxt[67].': </label>'.'</td>';
							echo '<td>'.'<span style="font-weight: bold;">'.$sPrize.' &euro;</span>'.'</td>';
						echo '</tr>';						
					echo '</table>';
					echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
						echo '<tr>';
							echo '<td>'.'<label>'.$m_arrTxt[109].': </label>'.'</td>';
							echo '<td>'.'<span>'.$sDesc.'</span>'.'</td>';
						echo '</tr>';			
						echo '<tr>';
							echo '<td>'.'<label>'.$m_arrTxt[51].': </label>'.'</td>';
							echo '<td>'.'<span>'.$sTech.'</span>'.'</td>';
						echo '</tr>';				
					echo '</table>';
					
					$qPrestD = mysql_query( "SELECT * FROM prester_depl WHERE deplacement_id = '".$rDep[0]."';" );
					if( mysql_numrows( $qPrestD ) > 0 ) 
					{
						echo '<h3>'.$m_arrTxt[115].'</h3>';
						echo '<ul id="prest-done">';
							while( $rPD = mysql_fetch_array( $qPrestD ) )
							{
								$qP = mysql_query( "SELECT * FROM prestation WHERE id='".$rPD[1]."' LIMIT 1;" );
								$rP = mysql_fetch_array( $qP );
								$sP = $rP[1];
								echo '<li>'.$sP.' <span style="font-weight:bold;">Infos: '.$rPD[3].'</span></li>';
							}
						echo '</ul>';
					}
					
					echo '<h3>'.$m_arrTxt[116].'</h3>';
					echo '<ul id="admin-op">';
						echo '<li>'.'<a href="index.php?p=away&addPrest=1&dep='.$rDep[0].'">'.$m_arrTxt[117].'</a>'.'</li>';
					echo '</ul>';
					
				echo '</div>';
				echo '<br />';
			echo '<hr />';
		}		
		
		// #################################
		// AFFICHAGE DU CALENDRIER
		// #################################	
		
		// ************
			// Affichage d'une semaine
		// ************
		if( isset( $_GET['showweek'] ) )
		{
			$in_d = $_GET['showweek'];
			
			echo '<div id="showweek">';
				echo '<h2>'.$m_arrTxt[118].': '.$in_d.'</h2>';
				echo '<div style="margin-bottom:5px;">';
					echo '<h3>'.$m_arrTxt[119].'</h3>';
					$qT = mysql_query( "SELECT * FROM technicien;" );
					echo '<table cellpadding="0px" cellspacing="5px" border="0px">';
					$x = 1;
					echo '<tr>';
					while( $rT = mysql_fetch_array( $qT ) )
					{
						if( $x%4 == 0 )
							echo '</tr><tr>';
							
						echo '<td><span style="color: '.$rT[8].';">'.$rT[1].' :</span></td><td><div style="margin-left: 3px;width: 15px; background: '.$rT[8].';border:1px solid #fff; height: 18px;">&nbsp;</div></td>';
						$x++;
					}
					echo '</tr>';
					echo '</table>';
				echo '</div>';
				echo getWeek( $in_d );
				echo '<div>';
					echo '<ul style="margin: 0px; padding:0px;">';
						echo '<li onclick="weekShow( 0 );" onmouseover="this.style.background=\'#dcdcdc\';this.style.cursor=\'pointer\';" onmouseout="this.style.background=\'#fff\';" style="margin-left: 2px; margin-right: 2px;list-style-type:circle;list-style-position:inside;float:left;font-family: Georgia; font-size: 9pt; font-weight: normal;font-style: italic; text-decoration: none; color: #ff7800;">'.$m_arrTxt[120].'</li>';
						echo '<li onclick="weekShow( 1 );" onmouseover="this.style.background=\'#dcdcdc\';this.style.cursor=\'pointer\';" onmouseout="this.style.background=\'#fff\';" style="margin-left: 2px; margin-right: 2px;list-style-type:circle;list-style-position:inside;float:left;font-family: Georgia; font-size: 9pt; font-weight: normal;font-style: italic; text-decoration: none; color: #ff7800;">'.$m_arrTxt[121].'</li>';
						echo '<li onclick="weekShow( 2 );" onmouseover="this.style.background=\'#dcdcdc\';this.style.cursor=\'pointer\';" onmouseout="this.style.background=\'#fff\';" style="margin-left: 2px; margin-right: 2px;list-style-type:circle;list-style-position:inside;float:left;font-family: Georgia; font-size: 9pt; font-weight: normal;font-style: italic; text-decoration: none; color: #ff7800;">'.$m_arrTxt[122].'</li>';
						echo '<li onclick="weekShow( 3 );" onmouseover="this.style.background=\'#dcdcdc\';this.style.cursor=\'pointer\';" onmouseout="this.style.background=\'#fff\';" style="margin-left: 2px; margin-right: 2px;list-style-type:circle;list-style-position:inside;float:left;font-family: Georgia; font-size: 9pt; font-weight: normal;font-style: italic; text-decoration: none; color: #ff7800;">'.$m_arrTxt[123].'</li>';
					echo '</ul>';
				echo '</div>';
			echo '</div>';
		}
		
		// ************
			// Affichage d'un mois
		// ************
		if( isset( $_GET['showmonth'] ) || isset( $_GET['dateEntered'] ) ) {
			$in_m = 0;
			$in_y = 0;
			if( isset( $_GET['dateEntered'] ) ) {
				$date = $_POST['date-text'];
				$arr = explode( '.', $date );
				$in_m = $arr[1]-1;
				$in_y = $arr[2];
				
		//		echo 'M: '.$in_m.' & Y: '.$in_y;
			}
			if( isset( $_GET['showmonth'] ) ) {
				$in_m = $_GET['showmonth'];
				$in_y = 0;
				if( !isset( $_GET['y'] ) )
					$in_y = date( 'Y' );
				else
					$in_y = $_GET['y'];
			}
				
			// Portion de code permettant de récupérer les mois et années précédentes, et suivantes , pour les liens :)
			// Année car en cas de passage Janvier 2004 > Décembre 2005, anné augmente, etc.	
			$iB = $in_m - 1;
			$iA = $in_m + 1;
			$iYB = $in_y;
			$iYA = $in_y;
			$now = $in_m;
			if( $in_m == -1 ){
				$iB = 10;
				$now = $iB+1;
				$iYA = $iYA + 1;
				$in_m = $now;
			}
			if( $in_m == 12 ) {
				$iA = 1;
				$now = $iA-1;
				$iYB = $iYB - 1;
				$in_m = $now;
			}
			
			if( $in_m == 11 && ($in_y == $iYA) )
				$iYA = $iYA + 1;
			
			if( $in_m == 0 && ($in_y == $iYB) )
				$iYB = $iYB - 1;
	/*		if( $in_m < 0 || $in_m > 11 )
				echo '<span>Tryin\' to play... Banned</span>';*/
				
	//		$aTmp = firstWeekOfMonth( 7, 2009 );
			
				
			echo '<div id="showmonth">';
				echo '<div id="awaycurseur1" class="hide">1</div>';
				echo '<div id="meetingcurseur1" class="hide">0</div>';
				echo '<div id="eventcurseur1" class="hide">0</div>';
				echo '<div id="taskcurseur1" class="hide">0</div>';
				echo '<div style="width:630px;border:0px solid #000;">';
					echo '<a href="index.php?p=away&showmonth='.($iB).'&y='.$iYB.'">Mois précédent</a> <span style="font-family: Georgia; font-size: 16pt; font-weight: bold; text-decoration: none; color:#039;"> - '.monthById( $now ).' '.$in_y.' - </span> <a href="index.php?p=away&showmonth='.($iA).'&y='.$iYA.'">Mois prochain</a>';
					echo '<select onmouseover="this.style.cursor=\'pointer\';" style="margin-left: 15px;margin-bottom: 2px; border: 1px solid #ff7800;font-family: Georgia; font-size: 9pt; font-weight: bold; color: #ff7800;">';
						for( $i = 0; $i < 12; $i++ ) {
							echo '<option onclick="window.location.href=\'index.php?p=away&showmonth='.$i.'&y='.$in_y.'\';" value="'.$i.'">'.monthByID($i).'</option>';
						}
					echo '</select>';
					echo '<div style="padding-left: 275px;border:0px solid #000;">';
					echo '<form style="margin:0px;padding:0px;" method="post" action="index.php?p=away&dateEntered=1">';
						echo '<label for="date-text">Rechercher par date: </label>';
						echo '<input style="margin-left: 15px;width: 100px; border: 1px solid #0078ff; font-family: Georgia; font-size: 9pt; font-weight: bold; font-style: italic; color: #0078ff;" type="text" name="date-text" value="Date" />';
						echo '<input style="margin-left: 5px;width: 75px; border: 1px solid #0078ff; font-family: Georgia; font-size: 9pt; font-weight: bold; font-style: italic; color: #0078ff;background:#fff;" type="submit" value="Chercher" />';
					echo '</form>';
					echo '</div>';
				echo '</div>';
				echo '<span>';
					$w = strftime( '%W', strtotime( ($in_m+1).'/1/'.$in_y ) );
					$w = $w+1;
					echo 'Semaine: '.$w;
				echo '</span>';
				echo '<div id="headers">'.'<div class="header"><span>Lundi</span></div><div class="header"><span>Mardi</span></div><div class="header"><span>Mercredi</span></div><div class="header"><span>Jeudi</span></div><div class="header"><span>Vendredi</span></div><div class="header"><span>Samedi</span></div><div class="header"><span>Dimanche</span></div>'.'</div>';
				echo '<div class="w1">';
					firstWeekOf( $in_m, $in_y );
				echo '</div>';
				echo '<span>';
					echo 'Semaine: '.($w+1);
				echo '</span>';
				echo '<div id="headers">'.'<div class="header"><span>Lundi</span></div><div class="header"><span>Mardi</span></div><div class="header"><span>Mercredi</span></div><div class="header"><span>Jeudi</span></div><div class="header"><span>Vendredi</span></div><div class="header"><span>Samedi</span></div><div class="header"><span>Dimanche</span></div>'.'</div>';
				echo '<div class="w2">';
					sndWeekOf( $in_m, $in_y );
				echo '</div>';
				echo '<span>';
					echo 'Semaine: '.($w+2);
				echo '</span>';
				echo '<div id="headers">'.'<div class="header"><span>Lundi</span></div><div class="header"><span>Mardi</span></div><div class="header"><span>Mercredi</span></div><div class="header"><span>Jeudi</span></div><div class="header"><span>Vendredi</span></div><div class="header"><span>Samedi</span></div><div class="header"><span>Dimanche</span></div>'.'</div>';
				echo '<div class="w3">';
					trdWeekOf( $in_m, $in_y );
				echo '</div>';
				echo '<span>';
					echo 'Semaine: '.($w+3);
				echo '</span>';
				echo '<div id="headers">'.'<div class="header"><span>Lundi</span></div><div class="header"><span>Mardi</span></div><div class="header"><span>Mercredi</span></div><div class="header"><span>Jeudi</span></div><div class="header"><span>Vendredi</span></div><div class="header"><span>Samedi</span></div><div class="header"><span>Dimanche</span></div>'.'</div>';
				echo '<div class="w4">';
					fthWeekOf( $in_m, $in_y );
				echo '</div>';
				if( hasFifthWeek( $in_m, $in_y ) ) {
					echo '<span>';
						echo 'Semaine: '.($w+4);
					echo '</span>';
					echo '<div id="headers">'.'<div class="header"><span>Lundi</span></div><div class="header"><span>Mardi</span></div><div class="header"><span>Mercredi</span></div><div class="header"><span>Jeudi</span></div><div class="header"><span>Vendredi</span></div><div class="header"><span>Samedi</span></div><div class="header"><span>Dimanche</span></div>'.'</div>';
					echo '<div class="w5">';
						fifthWeekOf( $in_m, $in_y );
					echo '</div>';
				}
				if( hasSixthWeek( $in_m, $in_y ) ) {
					echo '<span>';
						echo 'Semaine: '.($w+5);
					echo '</span>';
					echo '<div id="headers">'.'<div class="header"><span>Lundi</span></div><div class="header"><span>Mardi</span></div><div class="header"><span>Mercredi</span></div><div class="header"><span>Jeudi</span></div><div class="header"><span>Vendredi</span></div><div class="header"><span>Samedi</span></div><div class="header"><span>Dimanche</span></div>'.'</div>';
					echo '<div class="w6">';	
					sixthWeekOf( $in_m, $in_y );
					echo '</div>';
				}
				
				echo '<div style="margin: 0px; margin-top: 5px;border: 0px solid #000; height: 20px;">';
					echo '<ul style="margin: 0px;  padding:0px;">';
						echo '<li onclick="monthShow( 0 );" onmouseover="this.style.background=\'#dcdcdc\';this.style.cursor=\'pointer\';" onmouseout="this.style.background=\'#fff\';" style="margin-left: 2px; margin-right: 2px;list-style-type:circle;list-style-position:inside;float:left;font-family: Georgia; font-size: 9pt; font-weight: normal;font-style: italic; text-decoration: none; color: #ff7800;">'.$m_arrTxt[120].'</li>';
						echo '<li onclick="monthShow( 1 );" onmouseover="this.style.background=\'#dcdcdc\';this.style.cursor=\'pointer\';" onmouseout="this.style.background=\'#fff\';" style="margin-left: 2px; margin-right: 2px;list-style-type:circle;list-style-position:inside;float:left;font-family: Georgia; font-size: 9pt; font-weight: normal;font-style: italic; text-decoration: none; color: #ff7800;" ">'.$m_arrTxt[121].'</li>';
						echo '<li onclick="monthShow( 2 );" onmouseover="this.style.background=\'#dcdcdc\';this.style.cursor=\'pointer\';" onmouseout="this.style.background=\'#fff\';" style="margin-left: 2px; margin-right: 2px;list-style-type:circle;list-style-position:inside;float:left;font-family: Georgia; font-size: 9pt; font-weight: normal;font-style: italic; text-decoration: none; color: #ff7800;" ">'.$m_arrTxt[122].'</li>';
						echo '<li onclick="monthShow( 3 );" onmouseover="this.style.background=\'#dcdcdc\';this.style.cursor=\'pointer\';" onmouseout="this.style.background=\'#fff\';" style="margin-left: 2px; margin-right: 2px;list-style-type:circle;list-style-position:inside;float:left;font-family: Georgia; font-size: 9pt; font-weight: normal;font-style: italic; text-decoration: none; color: #ff7800;" ">'.$m_arrTxt[123].'</li>';
					echo '</ul>';
				echo '</div>';
				
			echo '</div>';
		}
		
		if( isset( $_GET['listaway'] ) ) {
				$pg = $_GET['listaway'];
				$qAll = mysql_query( "SELECT * FROM deplacement ORDER BY id DESC; " );
				$nPg = toInt( mysql_numrows( $qAll ) / $_conf_MAX_AWAY_PG );
				if( $pg > $nPg )
					echo '<span>'.'Erreur: You tryin\' to play ...<br />'.'</span>';
				$rArr = array( "" );
				$x = 0;
				while( $rD = mysql_fetch_array( $qAll ) ) {
					$rArr[$x] = $rD; 
					$x++;
				}
				echo '<div id="list-away">';
					$linkA = ($pg > 1) ? '<a href="index.php?p=away&listaway='.($pg-1).'">'.$m_arrTxt[59].' ('.($pg-1).')</a>' : '<span>'.$m_arrTxt[59].'</span>';
					$linkB = ($pg <= ($nPg-1)) ? '<a href="index.php?p=away&listaway='.($pg+1).'">'.$m_arrTxt[60].' ('.($pg+1).')</a>' : '<span>'.$m_arrTxt[60].'</span>';
					echo '<span>'.$m_arrTxt[57].': '.$nPg.' - '.$m_arrTxt[58].': '.$pg.' - </span>'.$linkA.'<span> - </span>'.$linkB;
				$x = -1;
				if( $pg == 1 )
					$x = 0;
				else
					$x = ($_conf_MAX_AWAY_PG-1) * ($pg-1);
				for( $z=0 ; $z < ($_conf_MAX_AWAY_PG) && $x < count($rArr); $x++, $z++ ) {
						$idR = 0;
					  $rD = $rArr[$x];
						$idD = $rD[0];
						$sMac = $rD[2];
						$iCl = $rD[1];
						$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$iCl."' LIMIT 1;" );
						$rCl = mysql_fetch_array( $qCl );
						$sCl = $rCl[1];
						$iDist = $rD[3];
						$qDist = mysql_query( "SELECT * FROM distance WHERE id='".$iDist."' LIMIT 1;" );
						$rDist = mysql_fetch_array( $qDist );
						$sDist = $rDist[2];
						$iDate = $rD[4];
						$qDate = mysql_query( "SELECT * FROM date WHERE id='".$iDate."' LIMIT 1;" );
						$rDate = mysql_fetch_array( $qDate );
						$sDate = $rDate[4];
						$sTime = $rD[5];
						$qP = mysql_query( "SELECT * FROM prester_depl WHERE deplacement_id ='".$idD."';" );
						$nP = mysql_numrows( $qP );
						
						echo '<div class="listelement">';
							echo '<div id="date">';
								echo '<span>'.$sDate.' '.$m_arrTxt[74].' '.str_replace( ':', 'h', $sTime ).'</span>';
							echo '</div>';
							echo '<div id="cust">';
								echo '<span onclick="window.location.href=\'index.php?p=ficheclient&cl='.$iCl.'\';" onmouseover="this.style.fontWeight= \'normal\';this.style.cursor =\'pointer\';" onmouseout="this.style.fontWeight= \'bold\';">'.truncStops($sCl, 30).' ['.$iCl.']</span>';
							echo '</div>';
							echo '<div id="mac">';
								echo '<span style="text-decoration: underline;" onclick="window.location.href=\'index.php?p=away&id='.$idD.'\';" onmouseover="this.style.fontWeight= \'bold\';this.style.cursor =\'pointer\';" onmouseout="this.style.fontWeight= \'normal\';">'.truncStops($sMac, 45).'</span>';
							echo '</div>';
							echo '<div id="dist">';
								echo '<span>'.$sDist.'</span>';
							echo '</div>';
							echo '<div id="prest">';
								if( $nP > 0 ) {
									if( $nP == 1 )
										echo '<span>'.'1 '.$m_arrTxt[144].'.</span>';
									else
										echo '<span>'.$nP.' '.$m_arrTxt[145].'.</span>';
								}
								else 
									echo '<span>'.$m_arrTxt[146].'.</span>';
							echo '</div>';
						echo '</div>';
												
				//		echo '<li onclick="window.location.href=\'index.php?p=away&id='.$idD.'\';" onmouseover="this.style.cursor=\'pointer\'; this.style.background = \''.'#cfc'.'\';" onmouseout="this.style.background=\'#ffffff\';">'.'<span style="font-weight:bold;">Date: '.$sDate.'</span><span> - </span><span style="text-decoration: underline;">'.$sMac.'</span><span> - Client: </span><span style="font-weight:bold;">'.utf8_decode($sCl).' ['.$iCl.']</span><span> - Distance: </span><span style="font-weight: bold;">'.$sDist.'</span></li>';
					}
			echo '</div>';
			echo '<hr />';
		}
		
		// ############################################
		//	GESTION DES DISTANCES
		// ############################################
		
		if( isset( $_GET['managedist'] ) ) {
			echo '<h2>'.$m_arrTxt[148].'</h2>';
			echo '<div id="dist-box">';
				echo '<h3>'.$m_arrTxt[149].'</h3>';
				$qDist = mysql_query( "SELECT * FROM distance;" );
				if( mysql_numrows( $qDist ) > 0 ) {
					echo '<ul>';
						while( $rD = mysql_fetch_array( $qDist ) ) {
							echo '<li>'.$rD[0].': '.$rD[2].' - '.$rD[3].' - '.$m_arrTxt[67].': '.$rD[1].' &euro;&nbsp;&nbsp;'.'<img onclick="doRequest(\''.$rD[0].'\', \'22\' ); this.parentNode.style.display=\'none\';" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'#fff\';" src="./images/sendfinish.png" height="16px" />'.'</li>';
						}
					echo '</ul>';
				}
				else 
					echo '<span>'.'Aucune distance n\'a été enregistrée.'.'</span>';
				
				echo '<h3>'.$m_arrTxt[150].'</h3>';
				echo '<form method="post" action="index.php?p=away&managedist=1">';
					echo '<input class="desc" type="text" name="descDist" value="'.$m_arrTxt[151].'" />';
					echo '<input class="prize" type="text" name="kmDist" value="0 km" />';
					echo '<input class="prize" type="text" name="prizeDist" value="'.$m_arrTxt[67].'" />';
					echo '<input class="button" type="submit" value="'.$m_arrTxt[10].'" />';
					echo '<input type="hidden" name="isAddDist" />';
				echo '</form>';
			echo '</div>';			
			echo '<hr />';
		}
		
		/* PREVU AUJOURDHUI */
		echo '<h2>'.$m_arrTxt[152].'</h2>';		
		$today = date( 'd.m.Y' );
		$qD = mysql_query( "SELECT * FROM date WHERE string_date = '".$today."' LIMIT 1;" );
		$rD = mysql_fetch_array( $qD );
		$sDate = $rD[4];
		$iDate = $rD[0];
		$qET = mysql_query( "SELECT * FROM deplacement WHERE date_id='".$iDate."' ORDER BY time;" );
		if( mysql_numrows( $qET ) > 0 ) {			
					echo '<ul id="deplacements-ajd">';
					while( $rET = mysql_fetch_array( $qET ) ){
					
	////				if( $sDate == $today )
	//			{
						$sTime = str_replace( ':', 'h', $rET[5] );			
						$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$rET[1]."' LIMIT 1;" );
						$rCl = mysql_fetch_array( $qCl );
						$sClient = $rCl[1];
						$aClient = $rCl[7].' - '.$rCl[8].' '.$rCl[9];
						echo '<li onmouseover="this.style.borderBottom = \'1px solid #0078ff\';" onmouseout="this.style.borderBottom = \'0px solid #000\';">'.'<span>'.'['.$sTime.'] '.$sClient.' : </span><span class="thick">'.$aClient.'</span>'.'<img onclick="doRequest(\''.$rET[0].'\', \'21\' ); this.parentNode.style.display=\'none\';" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'#fff\';" src="./images/sendfinish.png" height="16px" />'.'<img onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'#fff\';" onclick="window.location.href=\'index.php?p=away&id='.$rET[0].'\';" src="./images/lileye.png" height="16px" />'.'</li>';
				
					}
					echo '</ul>';	
		} else {
			echo '<span>'.$m_arrTxt[153].'</span>';
		}
				
		echo '<hr />';
?>
