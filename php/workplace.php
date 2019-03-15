<?php
// ECRITURE DE DONNEES DANS LA BD
// INSERT INTO `intratelier`.`machine` (`id`, `venteJohn`, `garantie`, `code_id`, `desc`, `type_id`, `client_id`) VALUES (NULL, '0', '0', 'DEB001', 'Portable Ecran cassé', '2', '8518');
	$techN = $_COOKIE['tech_log'];
	$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
	$rT = mysql_fetch_array( $qT );
	$idTech = $rT[0];
	if( isset( $_GET['addCl'] ) )
	{
		$lib = $_POST['libelle'];
		$addr = $_POST['address'];
		$cp = $_POST['cp'];
		$ville = $_POST['ville'];
		$tel = $_POST['tel'];
		$fax = $_POST['fax'];
		$mail = $_POST['mail'];
		$dID = date( 'd.m.Y' );
		$qD = mysql_query( "SELECT * FROM date WHERE string_date='".$dID."' LIMIT 1;" );
		$rD = mysql_fetch_array( $qD );
		$dID = $rD[0];
		
		$qInsert = mysql_query( "INSERT INTO `clients` (`libelle`,`code_id` ,`lname` ,`fname` ,`numtel` ,`numfax` , `addr`, `cp`, `ville`, `email`,`provider` ,`type_adsl` ,`a_belgtv` ,`belgtv_dispo` ,`date_id`) VALUES ('".$lib."', '', '', '', '".$tel."', '".$fax."', '".$addr."', '".$cp."', '".$ville."', '".$mail."', '0', '0', '0', '0', '".$dID."');" ) or die( mysql_error( ) );
		$idClient = mysql_insert_id( );
//		echo $idClient;
		echo '<script type="text/javascript">';
			echo 'logNow( \''.$idTech.'\', \'Ajouté client. [Client: '.mysql_insert_id.']\' );';
		echo '</script>';
	}
	
	if( isset( $_POST['isAdd-iText'] ) ) {
		$itext = htmlentities( $_POST['itext'] );		
		$isP = (isset($_POST['isPrint'])) ? 1 : 0;
	$qAIText = mysql_query( "INSERT INTO `intratelier09`.`itexts` ( `itext`, `reparation_id`, `isprint` ) VALUES ( '".$itext."', '".$_POST['isAdd-iText']."', '".$isP."' );" ) or die( mysql_error( ) );
		echo '<script type="text/javascript">';
			echo 'logNow( \''.$idTech.'\', \'Ajouté iText pour réparation. [iText: '.mysql_insert_id( ).'] [Réparation: '.$_POST['isAdd-iText'].']\' );';
		echo '</script>';
	}

	
	if( isset( $_GET['cust'] ) )
		$idClient = $_GET['cust'];
	
	if( isset( $_GET['addMac'] ) ) 
	{
		$desc = $_POST['desc'];
		$sel = $_POST['type'];
		$qT = mysql_query( "SELECT * FROM type_machine WHERE `nom_type` = '".$sel."' LIMIT 1;" );
		$rT = mysql_fetch_array( $qT );
		$idType = $rT[0];
		$iWar = (isset($_POST['isWarranty']) ? 1 : 0);
		$qInsert = mysql_query( "INSERT INTO `machine` (`venteJohn`, `garantie`, `desc`, `type_id`, `client_id`) VALUES ('0', '".$iWar."', '".$desc."', '".$idType."', '".$idClient."');" );
		$idMac = mysql_insert_id( );
		
		echo '<script type="text/javascript">';
			echo 'logNow( \''.$idTech.'\', \'Ajouté machine pour client. [Machine: '.$idMac.'] [Client: '.$idClient.']\' );';
		echo '</script>';
	}
	
	if( isset( $_GET['mac'] ) )
		$idMac = $_GET['mac'];	
		
	if( isset( $_GET['rep'] ) )
		$idRep = $_GET['rep'];
		
	$sPrest = "";
		
	if( isset( $_POST['isAddPrest'] ) ) {
		$isel = $_POST['prestation'];
		$desc = $_POST['desc-mac'];
		$warn = -1;
		if( !isset( $_POST['warnlevel'] ) )
			$warn = 0;
		else
			$warn = $_POST['warnlevel'];
		
		$tech = -1;
		if( !isset( $_POST['technician'] ) )
			$tech = 0;
		else
			$tech = $_POST['technician'];
		$qP = mysql_query( "SELECT * FROM prestation WHERE `id`='".$isel."' LIMIT 1;" );
		$rP = mysql_fetch_array( $qP );
		$idP = $rP[0];
		$qInsert = mysql_query( "INSERT INTO `prester` ( `prestation_id`, `reparation_id`, `desc`, `done`, `id_technicien`, `warnlevel` ) VALUES ( '".$idP."', '".$idRep."', '".$desc."', '0', '".$tech."', '".$warn."' );" );
		$idServ = mysql_insert_id( );
		$qPForR = mysql_query( "SELECT * FROM prester WHERE `reparation_id`='".$idRep."';" );
		$ttvac = 0;
		$qr = mysql_query( "SELECT * FROM reparation WHERE id =".$idRep." LIMIT 1;" );
		$rr = mysql_fetch_array( $qr );
		$ttvac = $rr[3] + $rP[2];
		$qPrice = mysql_query( "UPDATE `reparation` SET `total_tvac` = '".$ttvac."' WHERE `id` =".$idRep." LIMIT 1 ;" );
		
		$sPrest .= '<div id="info-cur-rep">';
		while( $rPForR = mysql_fetch_array( $qPForR ) )
			$sPrest .= '<span>'.$m_arrTxt[40].$rPForR[1].$m_arrTxt[41].$rPForR[2].$m_arrTxt[42].$rPForR[3].$m_arrTxt[43].'</span><br />';
		
		$sPrest .= '<span>'.'<a href="./index.php?p=workplace&showrep='.$idRep.'">'.$m_arrTxt[56].'</a>'.'</span>';
		$sPrest .= '</div>';
		
		echo '<script type="text/javascript">';
			echo 'logNow( \''.$idTech.'\', \'Ajouté services pour réparation. [Service: '.$idServ.'] [Réparation: '.$idRep.']\' );';
		echo '</script>';
	}

	/* Panel concernant les prestations en cours. */
	echo '<div id="first-panel">';
		echo '<div class="workdesk">';      
		
			echo '<ul>';
			
			//	require( "./php/func.php" );
				mysql_connect( $m_host, $m_user, $m_pass ) or die( "erreur de connexion à la BD. (".mysql_error( ).")" );
				mysql_select_db( $m_bdd );
				$qP = mysql_query( "SELECT * FROM reparation ORDER BY id DESC LIMIT ".$m_cntRep.";" ) or die( "Erreur de requete. 1: ".mysql_error( ) );				
				while( $r = mysql_fetch_array( $qP ) ) {
				//		$qPr = mysql_query( "SELECT * FROM prestation WHERE id = '".$r[1]."' LIMIT 1;" ) or die( "Erreur de requete." );
				//		$qR = mysql_query( "SELECT * FROM reparation WHERE id = '".$r[2]."' LIMIT 1;" ) or die( "Erreur de requete." );
				//		$rPrest = mysql_fetch_array( $qPr );
				//		$rRep = mysql_fetch_array( $qR );
						$iMac =  $r[1];
						$qMac = mysql_query( "SELECT * FROM machine WHERE id='".$iMac."' LIMIT 1;" ) or die( 'Machine erronée' );
						$rMac = mysql_fetch_array( $qMac );
						$iCl = $rMac[6];
						$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$iCl."' LIMIT 1;" ) or die( "Client inconnu" );
						$rCl = mysql_fetch_array( $qCl );
						$libCl = htmlentities( utf8_decode( $rCl[1] ) );
						/*showInfoRep( \''.$r[0].'\', \''.$rMac[4].'\', \''.$rCl[1].'\' );*/
						echo '<li onclick="window.location.href=\'index.php?p=workplace&showrep='.$r[0].'\';" onmouseover="this.style.background = \'#dcdcdc\';this.style.cursor=\'pointer\';montre( \''.$r[4].'\', \'Rép.: '.$r[0].'. Prix: '.$r[3].'\', \''.$libCl.'\' );" onmouseout="this.style.background = \'#fff\';reset( );">';
						if( $r[4] == 100 ) {
							echo '<span style="color: #693;">'.$rMac[4].'</span>';
							echo '<img src="./images/showfinish.png" />';									
						}
						else {
							echo '<span style="color: #c30;">'.$rMac[4].'</span>';
							echo '<img src="./images/sendfinish.png" />';									
						}
						echo '</li>';
				}
				
			echo '</ul>';
			echo '<div id="curseur" class="infobulle"></div>';
			echo '<div id="curseur2" class="infobulle2"></div>';
			echo '<div id="curseur3" class="infobulle3"></div>';
			
		echo '</div>';
	echo '</div>';
	
	echo '<div id="second-panel">';
		echo '<div id="tech-box">';
				echo '<span class="tech-span">'.$m_arrTxt[16];
				$qT = mysql_query( "SELECT * FROM technicien;" ) or die( "Erreur de technicien." );
				$nTech = mysql_numrows( $qT );
				echo $nTech.'<br />';
				$i = 0;
				while( $rTech = mysql_fetch_array( $qT ) ) {
						if( $i == $nTech-1 )
							echo $rTech[1].'.';
						else
							echo $rTech[1].', ';
					
					$i++;
				}
				echo '</span>';
		echo '</div>';
		echo '<div id="prest-box">';
				echo '<span class="prest-span">'.$m_arrTxt[17];
				$qP = mysql_query( "SELECT * FROM prestation;" ) or die( "Erreur de prestation." );
				$qG = mysql_query( "SELECT * FROM groupe_prestation;" ) or die( "Erreur de groupe" );
				$nP = mysql_numrows( $qP );
				$nG = mysql_numrows( $qG );
				echo $nP.'<br />';
				echo $m_arrTxt[18].$nG;
				echo '</span>';
		echo '</div>';
		echo '<div id="rep-box">';
				echo '<span class="rep-span">'.$m_arrTxt[19];
				$qR = mysql_query( "SELECT * FROM reparation;" ) or die( "Erreur de reparation." );
				$nR = mysql_numrows( $qR );
				echo $nR.'<br />';
				echo '<a href="index.php?p=workplace&listrep=1">'.$m_arrTxt[20].'</a>';
				echo '</span>';
		echo '</div>';
	echo '</div>';
	echo '<div id="under-box">';
		if( isset( $_GET['panelprestation'] ) ) {
			// Inclure fichier newrep.php
		} 
		else 
		{
			echo '<h1>'.$m_arrTxt[0].'</h1>';
			
			if( isset( $_GET['additext'] ) ) {
				if( isset( $_GET['rep'] ) ) {					
					echo '<div id="add-itext">';
					echo '<form method="post" action="index.php?p=workplace&showrep='.$_GET['rep'].'">';
						echo '<textarea name="itext">'.$m_arrTxt[53].'</textarea>';
						echo '<input type="checkbox" value="PrintIt" name="isPrint" />';
						echo '<input type="submit" value="'.$m_arrTxt[10].'" />';
						echo '<input type="hidden" name="isAdd-iText" value="'.$_GET['rep'].'"/>';
					echo '</form>';
					echo '</div>';
				}
				else
					echo 'Tryin\' to play w/ me ? :]';
			}
			
			if( isset( $_GET['listrep'] ) ) {
				$pg = $_GET['listrep'];
				$qAll = mysql_query( "SELECT * FROM reparation ORDER BY id DESC; " );
				$nPg = toInt( mysql_numrows( $qAll ) / $_conf_MAX_PG );
				$rArr = array( "" );
				$x = 0;
				while( $rR = mysql_fetch_array( $qAll ) ) {
					$rArr[$x] = $rR; 
					$x++;
				}
				echo '<div id="list-rep">';
					$linkA = ($pg > 1) ? '<a href="index.php?p=workplace&listrep='.($pg-1).'">'.$m_arrTxt[59].' ('.($pg-1).')</a>' : '<span>'.$m_arrTxt[59].'</span>';
					$linkB = ($pg <= ($nPg-1)) ? '<a href="index.php?p=workplace&listrep='.($pg+1).'">'.$m_arrTxt[60].' ('.($pg+1).')</a>' : '<span>'.$m_arrTxt[60].'</span>';
					echo '<span>'.$m_arrTxt[57].': '.$nPg.' - '.$m_arrTxt[58].': '.$pg.' - </span>'.$linkA.'<span> - </span>'.$linkB;
					echo '<ul>';
				$x = -1;
				if( $pg == 1 )
					$x = 0;
				else
					$x = ($_conf_MAX_PG-1) * ($pg-1);
				for( $z=0 ; $z < ($_conf_MAX_PG) && $x < count($rArr); $x++, $z++ ) {
					$idR = 0;
					  $r = $rArr[$x];
						$idR = $r[0];
						$iMac = $r[1];
						$qM = mysql_query( "SELECT * FROM machine WHERE id='".$iMac."' LIMIT 1;" );
						$rM = mysql_fetch_array( $qM );
						$sMac = utf8_decode( $rM[4] );
						$iCl = $rM[6];
						$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$iCl."' LIMIT 1;" );
						$rCl = mysql_fetch_array( $qCl );
						$sCl = $rCl[1];
						
						$colState = "#000000";
						$colBg = "#DCDCDC";
						if( $r[4] > 50 ) {
							
							if( $r[4] > 50 && $r[4] < 75 ) {
								$colState = "#06257d";  $colBg = "#ccccff";	
							}		
							if( $r[4] > 75 && $r[4] <= 100 ) {
								$colState = "#0a4d03"; $colBg = "#CCFFCC";
							}
						}
						else {
							$colBg = "#FF9999";
							if( $r[4] < 25 )
								$colState = "#ff0000";							
							if( $r[4] > 25 && $r[4] < 50 )
								$colState = "#c36a14";
						}
						
						echo '<li onclick="window.location.href=\'index.php?p=workplace&showrep='.$idR.'\';" onmouseover="this.style.cursor=\'pointer\'; this.style.background = \''.$colBg.'\';" onmouseout="this.style.background=\'#ffffff\';">'.'<span style="font-weight:bold;">ID: '.$r[0].'</span><span> - </span><span style="text-decoration: underline;">'.$sMac.'</span><span> - '.$m_arrTxt[61].': </span><span style="font-weight:bold;">'.htmlspecialchars( $sCl ).' ['.$iCl.']</span><span> - '.$m_arrTxt[62].': </span><span style="font-weight: bold; color:'.$colState.';">'.$r[4].' %</span></li>';
					}
				
					echo '</ul>';
				echo '</div>';
			}
			
			echo stripslashes( $sPrest );
			if( isset( $_GET['showrep'] ) ) {
				$idRep = $_GET['showrep'];
				$qR = mysql_query( "SELECT * FROM reparation WHERE `id`='".$_GET['showrep']."' LIMIT 1;" );
				$rR = mysql_fetch_array( $qR );
				echo '<div id="print-fiche-rep">';
					echo '<a href="#" onclick="javascript: printFiche( 1, \''.$idRep.'\' );">'.$m_arrTxt[21].'</a>';
				echo '</div>';
				echo '<div id="info-repar">';
					echo '<div id="set-warranty">';	
						if( $rR[7] == '1' ) // Set gone warranty to 0
							echo '<a href="#" onclick="doRequest( \''.$idRep.'\', 14 ); logNow( \''.$idTech.'\', \'Défini produit revenu de garantie [Réparation: '.$rR[0].']\');">'.'<span onmouseover="this.innerHTML=\''.trim( $m_arrTxt[65] ).'\';" onmouseout="this.innerHTML=\''.trim($m_arrTxt[64]).'\';">'.$m_arrTxt[64].'</span>'.'</a>';	
						else // set gone in warranty !
							echo '<a href="#" onclick="doRequest( \''.$idRep.'\', 13 ); logNow( \''.$idTech.'\', \'Défini produit parti en garantie [Réparation: '.$rR[0].']\');">'.'<span onmouseover="this.innerHTML=\''.trim($m_arrTxt[64]).'\';" onmouseout="this.innerHTML=\''.trim($m_arrTxt[65]).'\';">'.$m_arrTxt[65].'</span>'.'</a>';	
					echo '</div>';
					echo '<h2>'.$m_arrTxt[22].'</h2>';
					echo '<ul>';						
						$prix = $rR[3];
						$qD = mysql_query( "SELECT * FROM date WHERE id='".$rR[2]."' LIMIT 1;" );
						$rD = mysql_fetch_array( $qD );
						$sD = $rD[4];
						$iMac = $rR[1];
						$qMac = mysql_query( "SELECT * FROM machine WHERE id='".$iMac."' LIMIT 1;" );
						$rMac = mysql_fetch_array( $qMac );
						$sMac = $rMac[4];
						$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$rMac[6]."' LIMIT 1;" );
						$rCl = mysql_fetch_array( $qCl );
						$sCl = $rCl[1];
						$iCl = $rCl[0];
						$telCl = $rCl[5];
						$mailCl = $rCl[10];
						$addrCl = $rCl[7].' - '.$rCl[8].' '.$rCl[9];
						$qP = mysql_query( "SELECT * FROM prester WHERE `reparation_id`='".$rR[0]."';" );
						$iP = mysql_numrows( $qP );
						$i = 0;
						while( $rP = mysql_fetch_array( $qP ) ) {
							$qPr = mysql_query( "SELECT * FROM prestation WHERE `id`='".$rP[1]."' LIMIT 1;" );
							$rPr = mysql_fetch_array( $qPr );
							$sPr = $rPr[1];
							echo '<li>'.$sPr.' ['.$m_arrTxt[66].': <span class="fett">'.$rP[3].'</span>]'.'</li>';
							if( $i == ($iP-1) ) {
								echo '<li>'.'<span>'.$m_arrTxt[67].': </span><span class="fett">'.$prix.' &euro;</span>'.'</li>';
								echo '<li>'.'<a href="./index.php?p=workplace&step=3&cust='.$rCl[0].'&mac='.$rMac[0].'&rep='.$rP[2].'">'.$m_arrTxt[23].'</a>'.'</li>';
								echo '<li>'.'<a href="./index.php?p=workplace&rep='.$rP[2].'&additext=1">'.$m_arrTxt[44].'</a>'.'</li>';
							}
							$i++;
						}
					echo '</ul>';
					$qITexts = mysql_query( "SELECT * FROM itexts WHERE `reparation_id` = '".$rR[0]."';" );
					$iITexts = mysql_numrows( $qITexts );
					if( $iITexts > 0 ) {
						echo '<h2>'.$m_arrTxt[45].'</h2>';
						while( $rIText = mysql_fetch_array( $qITexts ) ) {
							echo '<div style="overflow:auto;" class="itext">';
								echo '<span><pre>'.$rIText[1].'</pre></span>';
							echo '</div>';
						}
					}
					echo '<hr />';
					echo '<h2>'.$m_arrTxt[24].'</h2>';
					echo '<div onclick="window.location.href=\'index.php?p=ficheclient&cl='.$iCl.'\';" onmouseover="this.style.background=\'#ffc\';this.style.cursor = \'pointer\';" onmouseout="this.style.background=\'#fff\';">';
						echo '<table cellpadding="0px" cellspacing="5px" border="0px">';
							echo '<tr>';
								echo '<td>'.'<label for="desc-mac">'.$m_arrTxt[25].' : '.'</label>'.'</td>';
								echo '<td>'.'<span name="desc-mac">'.$sMac.'</label>'.'</td>';
								echo '<td>'.'<label for="lib-cl">'.$m_arrTxt[26].' : '.'</label>'.'</td>';
								echo '<td>'.'<span name="lib-cl">'.$sCl.'</label>'.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>'.'<label for="desc-mac">'.$m_arrTxt[27].' : '.'</label>'.'</td>';
								echo '<td>'.'<span name="desc-mac">'.$sD.'</label>'.'</td>';
								echo '<td>'.'<label for="lib-cl">'.$m_arrTxt[28].' : '.'</label>'.'</td>';
								echo '<td>'.'<span name="lib-cl">'.$telCl.'</label>'.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>'.'<label for="desc-mac">'.$m_arrTxt[29].' : '.'</label>'.'</td>';
								echo '<td>'.'<span name="desc-mac">'.$mailCl.'</label>'.'</td>';
								echo '<td>'.'<label for="lib-cl">'.$m_arrTxt[30].' : '.'</label>'.'</td>';
								echo '<td>'.'<span name="lib-cl">'.$addrCl.'</label>'.'</td>';
							echo '</tr>';
						echo '</table>';
					echo '</div>';
				echo '</div>';
			}
			
			
			// ##############################################
			// BEGIN THREESTEP WIZARD
			// ##############################################
			
			echo '<div id="threestep-wizard">';
			
				echo "<h2>".$m_arrTxt[1]."</h2>";
				
				// Si le client n'a pas encore été sélectionné ..
				if( $idClient == -1 ) 
				{
				
					echo '<div id="add-client">';
						echo '<h2>'.$m_arrTxt[2].'</h2>';
						echo '<form method="post" action="./index.php?p=workplace&step=2&addCl=1">';
						echo '<table cellpadding="0px" cellspacing="5px" border="0px">';
							echo '<tr>';
								echo '<td>'.'<label for="libelle">'.$m_arrTxt[3].' :</label>'.'</td>';
								echo '<td>'.'<input type="text" name="libelle" />'.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>'.'<label for="address">'.$m_arrTxt[4].' :</label>'.'</td>';
								echo '<td>'.'<input type="text" name="address" />'.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>'.'<label for="cp">'.$m_arrTxt[5].'</label>'.'</td>';
								echo '<td>'.'<input type="text" name="cp" />'.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>'.'<label for="ville">'.$m_arrTxt[6].' :</label>'.'</td>';
								echo '<td>'.'<input type="text" name="ville" />'.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>'.'<label for="tel">'.$m_arrTxt[7].' :</label>'.'</td>';
								echo '<td>'.'<input type="text" name="tel" />'.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>'.'<label for="fax">'.$m_arrTxt[8].' :</label>'.'</td>';
								echo '<td>'.'<input type="text" name="fax" />'.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>'.'<label for="mail">'.$m_arrTxt[9].' :</label>'.'</td>';
								echo '<td>'.'<input type="text" name="mail" />'.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>&nbsp;</td>';
								echo '<td>';
									echo '<input class="button" type="submit" value="'.$m_arrTxt[10].'" />';								
								echo '</td>';
							echo '</tr>';						
						echo '</table>';
						echo '</form>';
					echo '</div>';
				
					$aFlag = array( );
					$aObj = array( );
					$qCl = mysql_query( "SELECT * FROM clients;" );
					$nCl = mysql_numrows( $qCl );
					if( $nCl > 0 ) {
						$i = 0;
						while( $rCl = mysql_fetch_array( $qCl ) ) {	
							if( isset( $_POST['isSearched'] ) ) {
								$t = 'ID: '.utf8_decode($rCl[0]).'<br />'.$m_arrTxt[3].' : '.htmlspecialchars($rCl[1]).'<br />'.$m_arrTxt[4].' : '.htmlspecialchars($rCl[7]).'<br />'.$m_arrTxt[6].' : '.htmlspecialchars($rCl[8]).' - '.htmlspecialchars($rCl[9]).'<br />'.$m_arrTxt[7].' : '.htmlspecialchars($rCl[5]).'<br />'.$m_arrTxt[9].' : '.htmlspecialchars($rCl[10]).'<br />';				
								$aObj[$i] = '<li onclick="window.location.href=\'index.php?p=workplace&cust='.$rCl[0].'\';"  onmouseover="this.style.background = \'#dcdcdc\';this.style.cursor=\'pointer\';setSelectedData( \''.htmlentities($t).'\' );" onmouseout="this.style.background= \'transparent\';setSelectedData( \'\' );">'.'<span>'.htmlspecialchars( $rCl[1] ).'</span>'.'</li>';
								if( stristr( htmlspecialchars( $rCl[1] ), htmlspecialchars($_POST['search-field']) ) === FALSE )
									$aFlag[$i] = -1;
								else
									$aFlag[$i] = 1;
							}	else {					
							//text = 'ID: '+id+'<br />'+l1+' : '+lib+'<br />'+l2+' : '+addr+'<br />'+l3+' : '+cp+' - '+ville+'<br />'+l4+' : '+tel+'<br />'+l5+' : '+mail;				
								$t = 'ID: '.$rCl[0].'<br />Libellé : '.utf8_decode($rCl[1]).'<br />Adresse : '.utf8_decode($rCl[7])+'<br />Ville : '.$rCl[8].' - '.$rCl[9].'<br />Téléphone : '.$rCl[5].'<br />Mail : '.$rCl[10];				
								//aObj[$i] = '<li onclick="window.location.href=\'index.php?p=workplace&cust='.$rCl[0].'\';" onmouseover="this.style.background = \'#dcdcdc\';this.style.cursor=\'pointer\';setSelectedData( \''.htmlentities( $rCl[0] ).'\',\''.htmlentities( $rCl[1] ).'\',\''.htmlentities( $rCl[7] ).'\',\''.htmlentities( $rCl[8] ).'\',\''.htmlentities( $rCl[9] ).'\',\''.htmlentities( $rCl[5] ).'\',\''.htmlentities( $rCl[10] ).'\' );" onmouseout="this.style.background= \'transparent\';">'.'<span>'.utf8_decode( $rCl[1] ).'</span>'.'</li>';
							//	$aObj[$i] = '<li onclick="window.location.href=\'index.php?p=workplace&cust='.$rCl[0].'\';" onmouseover="this.style.background = \'#dcdcdc\';this.style.cursor=\'pointer\';setSelectedData( \''.htmlentities($t).'\' );" onmouseout="this.style.background= \'transparent\';">'.'<span>'.utf8_decode( $rCl[1] ).'</span>'.'</li>';
							}
							$i++;
						}
					}
					
					echo '<div id="search-client">';
							echo '<h2>'.$m_arrTxt[11].'</h2>';
							echo '<form method="post" action="./index.php?p=workplace">';
								echo '<input type="text" name="search-field" />';
								echo '<input class="button" type="submit" value="'.$m_arrTxt[12].'" />';
								echo '<input type="hidden" name="isSearched" />';
							echo '</form>';
							echo '<ul id="cust-list">';
								if ( isset( $_POST['isSearched'] ) ) 
								{
									for( $i = 0; $i < $nCl; $i++ )
										if( $aFlag[$i] == 1 )
											echo $aObj[$i];
									
								}
								else {
									echo '<li><span>'.$m_arrTxt[13].'</span></li>';								
								}
							echo '</ul>';		
										
							echo '<div id="data-selected">';
								echo '<span id="data-cust">'.$m_arrTxt[14].'</span>';
								echo '<br /><span style="font-weight:bold;">'.$m_arrTxt[52].'</span>';
							echo '</div>';
					echo '</div>';
				} // Fin if !$_GET['cust']
				else 
				{
					if( $idMac == -1 ) 
					{
						$qMac = mysql_query( "SELECT * FROM machine WHERE `client_id`='".$idClient."';" );
						$iMac = mysql_numrows( $qMac );
						echo '<div id="info-machines">';
						echo '<h1>'.$m_arrTxt[38].'</h1>';
						if( $iMac > 0 ) 
						{
							while( $rMac = mysql_fetch_array( $qMac ) ) 
							{
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
									echo '<div class="set">';
										echo '<a href="./index.php?p=workplace&step=3&cust='.$idClient.'&mac='.$rMac[0].'">'.$m_arrTxt[39].'</a>';
									echo '</div>';
									echo '<div class="data">';
										echo '<label for="typem">'.$m_arrTxt[31].'</label>';
										echo '<span name="typem">'.utf8_decode( $sType ).'</span>&nbsp;';
										echo '<label for="nrep">'.$m_arrTxt[32].'</label>';
										echo '<span name="nrep">'.$iRep.'</span>&nbsp;';
										echo '<label for="repn">'.$m_arrTxt[33].'</label>';
										echo '<span name="repn">'.$cntEnCours.'</span>';								
									echo '</div>';					
								echo '</div>';						
							}
						}
						else
							echo '<div class="mid"><span>'.$m_arrTxt[34].'</span></div>';
						
							echo '<div id="add-machine">';
								echo '<h2>'.$m_arrTxt[37].'</h2>';
								echo '<form method="post" action="./index.php?p=workplace&step=3&cust='.$idClient.'&addMac=1">';
								echo '<table cellpadding="0px" cellspacing="5px" border="0px">';
									echo '<tr>';
										echo '<td>'.'<label for="libelle">'.$m_arrTxt[35].'</label>'.'</td>';
										echo '<td>'.'<input type="text" name="desc" />'.'</td>';
										echo '<td>'.'<label for="acc_fournis">'.$m_arrTxt[54].'</label>'.'</td>';
										echo '<td>'.'<input type="text" name="acc_fournis" />'.'</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>'.'<label for="type">'.$m_arrTxt[31].'</label>'.'</td>';
										echo '<td>';
											echo '<select name="type" size=7>';
												$qT = mysql_query( "SELECT * FROM type_machine;" );
												$nT = mysql_numrows( $qT );
												while( $rT = mysql_fetch_array( $qT ) )
													echo '<option>'.utf8_decode( $rT[1] ).'</option>';
											echo '</select>';
										echo '</td>';
										echo '<td>';
											echo '<label for="technician" style="position:relative; top: -40px;">'.$m_arrTxt[51].'</label>';
										echo '</td>';
										echo '<td valign="top">';
											$qT = mysql_query( "SELECT * FROM technicien ORDER BY id ASC;" );
											if( mysql_numrows( $qT ) > 0 )
											{												
												echo '<select size="4" id="list-tech" name="technician">';
												while( $rT = mysql_fetch_array( $qT ) )
													echo '<option value="'.$rT[0].'">'.utf8_decode($rT[1]).'</option>';
												echo '</select><br />';
											}													
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>';
											echo '<label for="isWarranty">'.$m_arrTxt[55].'</label>';		
										echo '</td>';
										echo '<td>';
											echo '<input type="checkbox" value="WarrantyValidation" name="isWarranty" />';
										echo '</td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td>&nbsp;</td>';
										echo '<td>';
											echo '<input class="button" type="submit" value="'.$m_arrTxt[10].'" />';								
										echo '</td>';
									echo '</tr>';						
								echo '</table>';
								echo '</form>';
							echo '</div>';		
								
							
						echo '</div>';
					} // Fin if !$_GET['mac']
					else 
					{
						if( $idRep == -1 )
						{
							$idDate = 0;
							$sDate = date( 'd.m.Y' );
							$qD = mysql_query( "SELECT * FROM date WHERE `string_date`='".$sDate."' LIMIT 1;" );
							if( mysql_numrows( $qD ) == 0 ) {
								$qInsD = mysql_query( "INSERT INTO `date` ( `jour`, `mois`, `annee`, `string_date` ) VALUES( '".date( 'd' )."','".date( 'm' )."','".date( 'Y' )."','".date( 'd.m.Y' )."' );" );
								$qGetD = mysql_query( "SELECT * FROM date WHERE string_date='".date( 'd.m.Y' )."' LIMIT 1;" );
								$rGetD = mysql_fetch_array( $qGetD );								
								$idDate = $rGetD[0];
							}
							else
							{
								$rD = mysql_fetch_array( $qD );
								$idDate = $rD[0];
							}
							$idT = 0;
							if( isset( $_POST['technician'] ) )
								$idT = $_POST['technician'];
							$isW = (isset($_POST['isWarranty'])) ? 1 : 0;
							$accFournis = (isset($_POST['acc_fournis'])) ? $_POST['acc_fournis'] : 'Aucun accessoire';
							$qInsert = mysql_query( "INSERT INTO `reparation` ( `machine_id`, `date_id`, `total_tvac`, `pourcent_avancee`, `is_done`, `iswarrantyvalid`, `isgonewarranty`, `enteredby`,`acc_fournis`) VALUES( '".$idMac."', '".$idDate."', '0', '0', '0', '".$isW."', '0', '".$idT."', '".$accFournis."' );" );
							$idRep = mysql_insert_id( );	
							echo '<script type="text/javascript">';
								echo 'logNow( \''.$idTech.'\', \'Ajouté réparation. [Réparation: '.$idRep.']\' );';
							echo '</script>';			
						}
						
							echo '<div id="infos-reparation">';
								echo '<h2>'.$m_arrTxt[36].'</h2>';
								echo '<form method="post" action="./index.php?workplace&step=3&cust='.$idClient.'&mac='.$idMac.'&rep='.$idRep.'">';
									echo '<select size="10" id="list-prest" name="prestation">';
										$qP = mysql_query( "SELECT * FROM prestation;" );
										while( $rP = mysql_fetch_array( $qP ) )
											echo '<option value="'.$rP[0].'">'.$rP[1].'</option>';
									echo '</select>';
									echo '<div id="other-halfth">';
										echo '<label for="desc-mac">'.$m_arrTxt[35].'</label>';
										echo '<input class="desc-prest" type="text" name="desc-mac" /><br />';
										echo '<label for="warnlevel" style="position:relative; top: -40px;">'.$m_arrTxt[46].'</label>';
										echo '<select size="4" id="list-warn" name="warnlevel">';
											echo '<option value="0">'.$m_arrTxt[47].'</option>';
											echo '<option value="1">'.$m_arrTxt[48].'</option>';
											echo '<option value="2">'.$m_arrTxt[49].'</option>';
											echo '<option value="3">'.$m_arrTxt[50].'</option>';
										echo '</select><br />';
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
				}
			} // Fin if !$_GET['panelprestation']
	echo '</div>';
?>
