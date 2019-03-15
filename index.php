<html>
	<head>
		<title>intr@telier 2009 - Gestion simplifiée d'atelier informatique</title>
		<link rel="stylesheet" type="text/css" href="css/homeStyles.css" />
		<link rel="stylesheet" type="text/css" href="css/workplaceStyles.css" />
		<link rel="stylesheet" type="text/css" href="css/searchStyles.css" />
		<link rel="stylesheet" type="text/css" href="css/ficheStyles.css" />
		<link rel="stylesheet" type="text/css" href="css/printStyles.css" />
		<link rel="stylesheet" type="text/css" href="css/eyemodule.css" />
		<link rel="stylesheet" type="text/css" href="css/faqStyles.css" />
		<link rel="stylesheet" type="text/css" href="css/awayStyles.css" />
		<link rel="stylesheet" type="text/css" href="css/statsStyles.css" />
		<link rel="stylesheet" type="text/css" href="css/adminStyles.css" />
		<link rel="stylesheet" type="text/css" href="css/profileStyles.css" />
		<link rel="stylesheet" type="text/css" href="css/calDataStyles.css" />
		<script type="text/javascript" src="js/fastShow_func.js"></script> 
		<script type="text/javascript" src="js/complementInfo_func.js"></script> 		
	</head>
	<body>
		<?php
			require( "./php/func.php" );
				mysql_connect( $m_host, $m_user, $m_pass ) or die( "erreur de connexion à la BD. (".mysql_error( ).")" );
				mysql_select_db( $m_bdd );
				
			if( isset( $_POST['isTryLog'] ) || isset( $_GET['wantDisco'] ) ) 
		{
			if( isset( $_GET['wantDisco'] ) )
			{	
				setcookie( 'tech_log', '', 1 );
				echo '<script type="text/javascript">';					
					echo 'window.location.href = \'index.php\';';
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
					if( !isset($_COOKIE['tech_log']) || empty($_COOKIE['tech_log']) || $_COOKIE['tech_log'] == 'Wrong' )
						setcookie('tech_log', $rTech[1], (time() + 1800));
					echo '<script type="text/javascript">';
						echo 'logNow( \''.$rTech[0].'\', \'Connexion\');';
						echo 'window.location.href = \'index.php?p=workplace\';';
					echo '</script>';
				}				
			}
		}
		?>
		
		<?php
			if( isset( $_COOKIE['tech_log'] ) && !empty($_COOKIE['tech_log']) )
			{
				$qTech = mysql_query( "SELECT * FROM technicien WHERE `nom` = '".$_COOKIE['tech_log']."' LIMIT 1;" );
				$rT = mysql_fetch_array( $qTech );
				$idT = $rT[0];
				$lT = $rT[3];
				$m_arrTxt = getTextArray( $lT );
			}
			else
				$m_arrTxt = getTextArray( 2 );
		?>
		<div id="eye-am-pic">
			&nbsp;
		</div>
		<div id="eye-am">
			<div id="name">
				<?php
					if( isset( $_COOKIE['tech_log'] ) && !empty( $_COOKIE['tech_log'] ) )
					{
						echo '<span>';
						echo $_COOKIE['tech_log'].' '.trim($m_arrTxt[147]).'.';
						echo '</span>';
					}
					else
						echo '<span>'.'Vous n\'êtes pas identifié.'.'</span>';
				?>
			</div>
			<div id="rep-now">
				<?php
					if( isset( $_COOKIE['tech_log'] ) && !empty( $_COOKIE['tech_log'] ) )
					{
						$techN = $_COOKIE['tech_log'];
						$qT = mysql_query( "SELECT * FROM technicien WHERE nom='".$techN."' LIMIT 1;" );
						$rT = mysql_fetch_array( $qT );
						$idT = $rT[0];
						$qP = mysql_query( "SELECT * FROM prester WHERE `id_technicien`='".$idT."';" );
						$qP2 = mysql_query( "SELECT * FROM prester_depl WHERE `id_technicien`='".$idT."';" );
						$cnt = 0;
						$cnt = mysql_numrows( $qP );
						$cnt += mysql_numrows( $qP2 );
						
						if( $cnt > 0 )
							echo '<span>'.mysql_numrows( $qP ).' '.trim($m_arrTxt[75]).'.</span>';
						else
							echo '<span> '.$m_arrTxt[78].'</span>';
						
					}
					else
						echo '<span>'.'&nbsp;'.'</span>';
				?>
			</div>
			<div id="rep-entered">
				<?php
					if( isset( $_COOKIE['tech_log'] ) && !empty( $_COOKIE['tech_log'] ) )
					{
						$techN = $_COOKIE['tech_log'];
						$qT = mysql_query( "SELECT * FROM technicien WHERE nom='".$techN."' LIMIT 1;" );
						$rT = mysql_fetch_array( $qT );
						$idT = $rT[0];
						$qP = mysql_query( "SELECT * FROM reparation WHERE `enteredby`='".$idT."';" );
						if(mysql_numrows($qP) > 0)
						{
							$i = 1;
							$j = 0;
							$arrIDRep = array( );
							while( $rP = mysql_fetch_array( $qP ) )
							{
								if( !findInArr( $rP[2], $arrIDRep ) )
								{
									$arrIDRep[$j] = $rP[2];
									$j++;
								}
								$i++;
							}
								
							echo '<span>'.count($arrIDRep).' '.trim($m_arrTxt[76]).'.'.'</span>';							
						}
						else
							echo '<span>'.$m_arrTxt[79].'</span>';
						
					}
					else
						echo '<span>'.'&nbsp;'.'</span>';
				?>
			</div>
			<div id="depl">
				<?php
					if( isset( $_COOKIE['tech_log'] ) && !empty( $_COOKIE['tech_log'] ) )
					{
						$techN = $_COOKIE['tech_log'];
						$qT = mysql_query( "SELECT * FROM technicien WHERE nom='".$techN."' LIMIT 1;" );
						$rT = mysql_fetch_array( $qT );
						$idT = $rT[0];
						$qP = mysql_query( "SELECT * FROM prester_depl WHERE `id_technicien`='".$idT."';" );
						$cnt = 0;
						$cnt = mysql_numrows( $qP );
						$arrIDDepl = array( );
						$i = 0;
						while( $rP = mysql_fetch_array( $qP ) )
						{							
							if( findInArr($rP[2], $arrIDDepl) == 0 )
							{
								$arrIDDepl[$i] = $rP[2];
								$i++;
							}
							else
								continue;
						}
						
						if( $cnt > 0 )
							echo '<span>'.count( $arrIDDepl ).' '.trim($m_arrTxt[77]).'.'.'</span>';
						else
							echo '<span>'.$m_arrTxt[80].'</span>';
						
					}
					else
						echo '<span>'.'&nbsp;'.'</span>';
				?>
			</div>
			<div id="eyeam-links">
				<?php
					if( isset( $_COOKIE['tech_log'] ) && !empty( $_COOKIE['tech_log'] ) )
					{
						$techN = $_COOKIE['tech_log'];
						$qT = mysql_query( "SELECT * FROM technicien WHERE nom='".$techN."' LIMIT 1;" );
						$rT = mysql_fetch_array( $qT );
						echo '<ul>';
							if( $rT[4] == 1 )
							{
								echo '<li>'.'<a href="index.php?p=stats">'.$m_arrTxt[81].'</a>'.'</li>';
								echo '<li>'.'<a href="index.php?p=admin">'.$m_arrTxt[82].'</a>'.'</li>';
							}
							echo '<li>'.'<a href="index.php?p=myprofile">'.$m_arrTxt[83].'</a>'.'</li>';
							echo '<li>'.'<a href="php/oneye.php">'.$m_arrTxt[154].'</a>'.'</li>';
							echo '<li>'.'<a href="index.php?wantDisco=1" onclick="logNow( \''.$rT[0].'\', \'Déconnexion\' );">'.$m_arrTxt[84].' '.$techN.'</a>'.'</li>';							
						echo '</ul>';						
					}
					else
						echo '<span>'.'&nbsp;'.'</span>';
				?>
				<hr />
			</div>
		</div>
		<div id="site">
			<div align="center">
				<div id="header">
					<div id="logo">
						&nbsp;
					</div>
					<div id="right-top">
						&nbsp;
					</div>
					<div id="left-bottom">
						&nbsp;
					</div>
					<div id="menu">
						<ul>
							<?php
									echo '<li onclick="window.location.href=\'./index.php?p=workplace&lg=0\';" onmouseover="hoverMenu( \''.trim($m_arrTxt[85]).'\' ); this.style.cursor = \'pointer\';" onmouseout="outMenu( )"><img src="./images/home.png" width="48px" height="48px" border="0px" /></li>';
							
								if( isset( $_COOKIE['tech_log'] ) ) 
								{
									$techN = $_COOKIE['tech_log'];
									$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
									$rT = mysql_fetch_array( $qT );
									$idT = $rT[0];
									$pref_awayShow = $rT[9];
									if( $pref_awayShow == 'm' )
										echo '<li onclick="window.location.href=\'./index.php?p=away&lg=0&showmonth='.(date('m')-1).'&y='.date('Y').'\';"  onmouseover="hoverMenu( \''.trim($m_arrTxt[86]).'\' ); this.style.cursor = \'pointer\';" onmouseout="outMenu( )"><img src="./images/deplacement.png"  border="0px" /></li>';
									else
									{
										if( $pref_awayShow == 'w' )
											echo '<li onclick="window.location.href=\'./index.php?p=away&lg=0&showweek='.date('d.m.Y').'\';"  onmouseover="hoverMenu( \''.trim($m_arrTxt[86]).'\' ); this.style.cursor = \'pointer\';" onmouseout="outMenu( )"><img src="./images/deplacement.png"  border="0px" /></li>';
									}
								}
							
							echo '<li onclick="window.location.href=\'./index.php?p=ficheclient&lg=0\';" onmouseover="hoverMenu( \''.trim($m_arrTxt[87]).'\' ); this.style.cursor = \'pointer\';" onmouseout="outMenu( )"><img src="./images/customer.png" width="48px" height="48px" border="0px" /></li>';
							echo '<li onclick="window.location.href=\'./index.php?p=printcenter&lg=0\';" onmouseover="hoverMenu( \''.str_replace( '\'', '\\\'', trim($m_arrTxt[88]) ).'\' ); this.style.cursor = \'pointer\';" onmouseout="outMenu( )"><img src="./images/archives.png" width="48px" height="48px" border="0px" /></li>';
							echo '<li onclick="window.location.href=\'./index.php?p=servicescenter&lg=0\';"  onmouseover="hoverMenu( \''.trim($m_arrTxt[89]).'\' ); this.style.cursor = \'pointer\';" onmouseout="outMenu( )"><img src="./images/info.png" width="48px" height="48px" border="0px" /></li>';
							echo '<li onclick="window.location.href=\'./index.php?p=eyemodule&lg=0\';"  onmouseover="hoverMenu( \''.trim($m_arrTxt[90]).'\' ); this.style.cursor = \'pointer\';" onmouseout="outMenu( )"><img src="./images/eye.png" width="48px" height="48px" border="0px" /></li>';					
							echo '<li onclick="window.location.href=\'./index.php?p=faq&lg=0\';"  onmouseover="hoverMenu( \''.trim($m_arrTxt[91]).'\' ); this.style.cursor = \'pointer\';" onmouseout="outMenu( )"><img src="./images/faq.png" width="48px" height="48px" border="0px" /></li>';							
						?>
						</ul>
					</div>
					<div id="menu-info" class="hide"></div>
					<div id="ads">
						<?php
											
							$qEyeTxt = mysql_query( "SELECT * FROM eyeTexts ORDER BY id DESC;" );
							if( mysql_numrows( $qEyeTxt ) > 0 ) {
								echo '<ul>';
								while( $rET = mysql_fetch_array( $qEyeTxt ) ) {
									if( $rET[2] != "default" ) {
										if( $rET[5] == 1 ) {
											$d = "";
											if( $rET[6] == 1 )
												$d = 'style="text-decoration: line-through;"';
											echo '<li onmouseover="this.style.borderBottom = \'1px solid #039\';" onmouseout="this.style.borderBottom = \'1px solid #fff\';">'.'<span '.$d.'>'.truncStops( htmlentities($rET[1]), 32 ).'</span><img onmouseover="hoverMenu( \'Suivre le lien\' );this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="outMenu();this.style.background=\'#fff\';" onclick="window.location.href=\''.$rET[2].'\';" height="18px" src="./images/extern-url.png" />'.'<img onclick="window.location.href=\'./index.php?p=eyemodule&id='.$rET[0].'\';" onmouseover="hoverMenu( \'Afficher plus de données\' );this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="outMenu( );this.style.background=\'#fff\';" height="18px" src="./images/lileye.png" />'.'</li>';
											
										}
									}
									else
										echo '<li onmouseover="this.style.borderBottom = \'1px solid #039\';" onmouseout="this.style.borderBottom = \'1px solid #fff\';">'.'<span>'.truncStops( htmlentities($rET[1] ), 32 ).'</span>'.'<img onclick="window.location.href=\'./index.php?p=eyemodule&id='.$rET[0].'\';" onmouseover="hoverMenu( \'Afficher plus de données\' );this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="outMenu();this.style.background=\'#fff\';" height="18px" src="./images/lileye.png" />'.'</li>';
								}
								echo '</ul>';
							}
							else
								echo '<span>'.'Aucun Aide-Mémoire (eyeText) n\'a été enregistré.'.'</span>';
						?>
					</div>					
				</div>
				<div id="page">	
					<?php
					/* #####################
							eyeDo @ Work v 1.3 stable by eVias
							Copyright includes func.php with _reverseSort_laterDate algorithm
					   ##################### */
					?>
					<div id="design-eyedo-work">
					<div id="eyedo-work-box">	
						<?php
							if( isset($_COOKIE['tech_log']) && !empty($_COOKIE['tech_log']) )
							{
								$techN = $_COOKIE['tech_log'];
								$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
								$rT = mysql_fetch_array( $qT );
								$idTech = $rT[0];
							$arrQueryRep = array( );
							$qRep = mysql_query( "SELECT * FROM reparation ORDER BY id DESC;" );
							$i = 0;
							while( $rRep = mysql_fetch_array( $qRep ) ) {
								$arrQueryRep[$i] = $rRep;
								$i = $i + 1;
							}
							
							// Extraction des dates
							$arrDateID = array( );
							$arrDateStr = array( );
							for( $z = 0, $i = 0; $z < count( $arrQueryRep ); $z++ )
							{
								if( findInArr( $arrQueryRep[$z][2], $arrDateID ) == 0 )
								{
									$arrDateID[$i] = $arrQueryRep[$z][2];
									$i++;
								}
								else
									continue;
							}
							
							// Extraction de la base de donnée et TRI
								$j = 0;
								for( ; $j < count( $arrDateID ); $j++ ) 
								{
									$qDate = mysql_query( "SELECT * FROM date WHERE id='".$arrDateID[$j]."' LIMIT 1;" );
									$rDate = mysql_fetch_array( $qDate );
									$arrDateStr[$j] = $rDate[4];
								}							
								$arrDateStr = _reverseSort_laterDate( $arrDateStr );
								
							$beg = 0;
							$bFlag = 0;
							for( ; $beg < count( $arrDateStr ) && $bFlag == 0; $beg++ )
							{
								$qDate = mysql_query( "SELECT * FROM date WHERE string_date='".$arrDateStr[$beg]."' LIMIT 1;" );
								$rDate = mysql_fetch_array( $qDate );
								$idDate = $rDate[0];
								echo '<h3 id="'.$beg.'" onclick="updateRepStatus( this.id );" onmouseover="this.style.cursor=\'pointer\';">'.$arrDateStr[$beg].'</h3>';
								$qR2 = mysql_query( "SELECT * FROM reparation WHERE date_id='".$idDate."';" );
								$qRb = mysql_query( "SELECT * FROM reparation WHERE date_id='".$idDate."';" );
								
								$any = 0;
								while( $r = mysql_fetch_array( $qRb ) )
									if( $r[5] != 1 )
										$any = 1;
										
								echo '<div id="curseurDate-'.$beg.'" class="hide">';
									if( $any == 1 )
										echo '1';
									else
										echo '0';
								echo '</div>';
								
								if( $any == 1 )
									echo '<div id="eyedo-work-date-'.$beg.'" class="show">';
								else
									echo '<div id="eyedo-work-date-'.$beg.'" class="hide">';
								while( $rR = mysql_fetch_array( $qR2 ) )
								{
									$qMac = mysql_query( "SELECT * FROM machine WHERE id='".$rR[1]."' LIMIT 1;" );
									$rMac = mysql_fetch_array( $qMac );
									$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$rMac[6]."' LIMIT 1;" );
									$rCl = mysql_fetch_array( $qCl );
									$sCl = $rCl[1];
									
									echo '<h4>'.$sCl.'</h4> <img onmouseover="this.style.cursor=\'pointer\';" style="margin-top:10px; margin-left: 5px;" onclick="window.location.href=\'index.php?p=workplace&showrep='.$rR[0].'\';" src="images/inforep.png" height="24px" width="24px" />';
									$qPrester = mysql_query( "SELECT * FROM prester WHERE `reparation_id`='".$rR[0]."';" );
									if( mysql_numrows( $qPrester ) > 0 )
									{
										echo '<ul>';
											while( $rPrester = mysql_fetch_array( $qPrester ) )
											{
												$qPr = mysql_query( "SELECT * FROM prestation WHERE id='".$rPrester[1]."' LIMIT 1;" );
												$rPr = mysql_fetch_array( $qPr );
												$sPr = $rPr[1];
												$col = "#0078ff";
												if( $rPrester[4] == 100 )
												{
													$col = "#0078ff";
													echo '<li style="color: '.$col.';">'.truncStops($sPr,40).' - <a href="#" onclick="doRequest( \''.$rPrester[0].'\', \'10\' ); var obj = this.parentNode; obj.style.color=\'#cc0000\';this.innerHTML=\''.trim($m_arrTxt[68]).'\';logNow( \''.$idTech.'\', \'Réouverture de service: '.$rPrester[0].'\' );">'.trim($m_arrTxt[69]).'</a></li>';
												}
												else
												{
													$col = "#cc0000";
													echo '<li style="color: '.$col.';">'.truncStops($sPr,40).' - <a href="#" onclick="doRequest( \''.$rPrester[0].'\', \'11\' ); var obj = this.parentNode; obj.style.color=\'#0078ff\';this.innerHTML=\''.trim($m_arrTxt[69]).'\';logNow( \''.$idTech.'\', \'Clôture de service: '.$rPrester[0].'\' );">'.trim($m_arrTxt[68]).'</a></li>';
												}
												
											}
										echo '</ul>';
									}
								}
								echo '</div>';
							}
							}
							else // Non loggé
							{
								echo '<span>Veuillez vous identifié afin de continuer</span>';
							}
								
							

						?>		
						
					</div>
					</div>
					
					<?php
					/* 
							eyeDo Away V1.3 stable by eVias
							Copyright includes func.php with sort_laterDate algorithm
					*/
					?>
					<div id="design-eyedo-away">
						<div id="eyedo-away-box">
							<?php
							if( isset($_COOKIE['tech_log']) && !empty($_COOKIE['tech_log']) )
							{
							$qDate = mysql_query( "SELECT * FROM date WHERE string_date='".date('d.m.Y')."' LIMIT 1;" );
							if( mysql_numrows( $qDate ) == 0 ) {
								// Ajouter date
								$qInsD = mysql_query( "INSERT INTO `date` ( `jour`, `mois`, `annee`, `string_date` ) VALUES( '".date( 'd' )."','".date( 'm' )."','".date( 'Y' )."','".date( 'd.m.Y' )."' );" );
								$iDate = mysql_insert_id( );
							} else {
								$arrQueryDepl = array( );
								$rDate = mysql_fetch_array( $qDate );
								$iDate = $rDate[0];
								$qDepl = mysql_query( "SELECT * FROM deplacement ORDER BY id DESC;" );
								$i = 0;
								if( mysql_numrows( $qDepl ) )
								{
									while( $rDepl = mysql_fetch_array( $qDepl ) ) {
										$arrQueryDepl[$i] = $rDepl;
										$i = $i + 1;
									}
								
									// Les dates doivent être extraite et ensuite ordonnée
									$arrDateID = array( );
									$arrDateStr = array( );
									for( $z = 0, $i = 0; $z < count( $arrQueryDepl ); $z++ )
									{
										if( findInArr( $arrQueryDepl[$z][4], $arrDateID ) == 0 )
										{
											$arrDateID[$i] = $arrQueryDepl[$z][4];
											$i++;
										}
										else // Date already exists
											continue;
									}
								
									$j = 0;
									for( ; $j < count( $arrDateID ); $j++ ) 
									{
										$qDate = mysql_query( "SELECT * FROM date WHERE id='".$arrDateID[$j]."' LIMIT 1;" );
										$rDate = mysql_fetch_array( $qDate );
										$arrDateStr[$j] = $rDate[4];
									}							
								
									if( count( $arrDateStr ) > 1 )
										$arrDateStr = sort_laterDate( $arrDateStr );
								
								/* DEBUG /
						//		echo '<span>'.count( $arrDateStr ).'</span>';
								
													
								/ ############################################# /
								// LE TABLEAU DES DATES EST TRIé
								/ #############################################*/
									$beg = 0;
									echo '<h3 onclick="updateArchivesODiv();" onmouseover="this.style.cursor=\'pointer\';">'.$m_arrTxt[70].'</h3>';
									echo '<div id="curseurold" class="hide">';
										echo '0';
									echo '</div>';
									echo '<div id="archivesold-eyedo" class="hide">';
									
											
									//	$arrT = explode( '.', $arrDateStr[$beg] );	
									if( !isLaterThan( $arrDateStr[$beg], date( 'd.m.Y' ) ) )
									{
										$bBreak = false;
										while( !$bBreak && $beg < count( $arrDateStr )  ) {											
										//	$arrT = explode( '.', $arrDateStr[$beg] );
											if( !isLaterThan( $arrDateStr[$beg], date( 'd.m.Y' ) ) )
											{
												$qDate = mysql_query( "SELECT * FROM date WHERE string_date = '".$arrDateStr[$beg]."' LIMIT 1;" );
												$rDate = mysql_fetch_array( $qDate );
												$iDate = $rDate[0];
												$qDepl = mysql_query( "SELECT * FROM deplacement WHERE date_id='".$iDate."' ORDER BY time ASC;" );
								
												echo '<h4>'.$arrDateStr[$beg].'</h4>';
									
												while( $rDepl = mysql_fetch_array( $qDepl ) ) 
												{
													$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$rDepl[1]."' LIMIT 1;" );
													$rCl = mysql_fetch_array( $qCl );
													$qDist = mysql_query( "SELECT * FROM distance WHERE id='".$rDepl[3]."' LIMIT 1;" );
													$rDist = mysql_fetch_array( $qDist );
													$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rDepl[4]."' LIMIT 1;" );
													$rDate = mysql_fetch_array( $qDate );									
																		
													$sCl = $rCl[1];
													$sAddr = $rCl[7].' - '.$rCl[8].' '.$rCl[9];
													$sDist = $rDist[3];
													$sDate = $rDate[4];
													echo '<div class="object-depl" style="background: #fcf;">';
														echo '<img src="./images/away_pic.png" height="32px" width="32px" border="0px" />';
														echo '<div class="prest"><span class="sudden-info">'.truncStops( ($sCl.' : '.$sAddr ), 40).'</span></div>';
														echo '<div class="date"><span class="date-info">'.$sDate.' '.$m_arrTxt[74].' '.str_replace( ':', 'h', $rDepl[5] ).'</span></div>';
														echo '<div class="finish"><a class="finish-object" href="index.php?p=away&id='.$rDepl[0].'">'.$m_arrTxt[73].'</a></div>';
														echo '<div class="tech"><span class="tech-info">'.$sDist.'</span></div>';
														echo '<div class="more"><span class="more-info">'.truncStops($rDepl[2],40).'</span></div>';
													echo '</div>';
												}		
												$beg++;					
											}
											else
											{
												$bBreak = false;
												if( $arrT[1] == date( 'm' ) && $arrT[2] == date( 'Y' ) )
													$bBreak = true;
											}
										}
									}
									echo '</div>';
								
									echo '<h3 onclick="updateArchivesMDiv();" onmouseover="this.style.cursor=\'pointer\';">'.$m_arrTxt[71].'</h3>';
									// Permet le Fold/Unfold du div d'archives
									echo '<div id="curseurmonth" class="hide">';
										echo '0';
									echo '</div>';								
									echo '<div id="archivesmonth-eyedo" class="hide">';
									if( $beg < count( $arrDateStr ) )
									{
									while( !isLaterThan( $arrDateStr[$beg], date( 'd.m.Y' ) ) && $beg < count( $arrDateStr ) ) {
											$qDate = mysql_query( "SELECT * FROM date WHERE string_date = '".$arrDateStr[$beg]."' LIMIT 1;" );
											$rDate = mysql_fetch_array( $qDate );
											$iDate = $rDate[0];
											$qDepl = mysql_query( "SELECT * FROM deplacement WHERE date_id='".$iDate."' ORDER BY time ASC;" );
								
											$arrT = explode( '.', $arrDateStr[$beg] );
											if( $arrT[1] == date( 'm' ) )
											{
												echo '<h4>'.$arrDateStr[$beg].'</h4>';
								
												while( $rDepl = mysql_fetch_array( $qDepl ) ) 
												{
													$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$rDepl[1]."' LIMIT 1;" );
													$rCl = mysql_fetch_array( $qCl );
													$qDist = mysql_query( "SELECT * FROM distance WHERE id='".$rDepl[3]."' LIMIT 1;" );
													$rDist = mysql_fetch_array( $qDist );
													$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rDepl[4]."' LIMIT 1;" );
													$rDate = mysql_fetch_array( $qDate );									
																			
													$sCl = $rCl[1];
													$sAddr = $rCl[7].' - '.$rCl[8].' '.$rCl[9];
													$sDist = $rDist[3];
													$sDate = $rDate[4];
													echo '<div class="object-depl" style="background: #ccf;">';
														echo '<img src="./images/away_pic.png" height="32px" width="32px" border="0px" />';
														echo '<div class="prest"><span class="sudden-info">'.truncStops( ($sCl.' : '.$sAddr ), 40).'</span></div>';
														echo '<div class="date"><span class="date-info">'.$sDate.' '.$m_arrTxt[74].' '.str_replace( ':', 'h', $rDepl[5] ).'</span></div>';
														echo '<div class="finish"><a class="finish-object" href="index.php?p=away&id='.$rDepl[0].'">'.$m_arrTxt[73].'</a></div>';
														echo '<div class="tech"><span class="tech-info">'.$sDist.'</span></div>';
														echo '<div class="more"><span class="more-info">'.truncStops($rDepl[2],40).'</span></div>';
													echo '</div>';
												}							
											}				
								
											$beg++;
									}
									}
									else
										echo '<span>'.$m_arrTxt[155].'</span>';
									echo '</div>';
									
									// Déplacements à effectuer
									echo '<div class="show">';
									echo '<h3>'.$m_arrTxt[72].'</h3>';
									if( $beg < count( $arrDateStr ) )
									{
										for( $d = $beg; $d < count( $arrDateStr ); $d++ )
										{
										
											$qDate = mysql_query( "SELECT * FROM date WHERE string_date = '".$arrDateStr[$d]."' LIMIT 1;" );
											$rDate = mysql_fetch_array( $qDate );
											$iDate = $rDate[0];
											$qDepl = mysql_query( "SELECT * FROM deplacement WHERE date_id='".$iDate."' ORDER BY time ASC;" );
											
											
											if( mysql_numrows( $qDepl ) > 0 ) 
											{
												echo '<h4>'.$arrDateStr[$d].'</h4>';
												while( $rDepl = mysql_fetch_array( $qDepl ) ) 
												{
													$qCl = mysql_query( "SELECT * FROM clients WHERE id='".$rDepl[1]."' LIMIT 1;" );
													$rCl = mysql_fetch_array( $qCl );
													$qDist = mysql_query( "SELECT * FROM distance WHERE id='".$rDepl[3]."' LIMIT 1;" );
													$rDist = mysql_fetch_array( $qDist );
													$qDate = mysql_query( "SELECT * FROM date WHERE id='".$rDepl[4]."' LIMIT 1;" );
													$rDate = mysql_fetch_array( $qDate );									
																			
													$sCl = $rCl[1];
													$sAddr = $rCl[7].' - '.$rCl[8].' '.$rCl[9];
													$sDist = $rDist[3];
													$sDate = $rDate[4];
													echo '<div class="object-depl" style="background: #9f9;">';
														echo '<img src="./images/away_pic.png" height="32px" width="32px" border="0px" />';
														echo '<div class="prest"><span class="sudden-info">'.truncStops( ($sCl.' : '.$sAddr ), 40).'</span></div>';
														echo '<div class="date"><span class="date-info">'.$sDate.' '.$m_arrTxt[74].' '.str_replace( ':', 'h', $rDepl[5] ).'</span></div>';
														echo '<div class="finish"><a class="finish-object" href="index.php?p=away&id='.$rDepl[0].'">'.$m_arrTxt[73].'</a></div>';
														echo '<div class="tech"><span class="tech-info">'.$sDist.'</span></div>';
														echo '<div class="more"><span class="more-info">'.truncStops($rDepl[2],40).'</span></div>';
													echo '</div>';
												}										
											}
											else 
											{
												echo '<span>'.'Aucun déplacement n\'a été enregistré.'.'</span>';
											}
										}
									}
									else 
									{
										echo '<span>'.$m_arrTxt[143].'.</span>';
									}
									
									echo '</div>';
								}
								else 
								{
									echo '<span>'.'Aucun déplacement n\'a été enregistré.'.'</span>';
								}
								
							}
							} // Non loggé
							else
							{
								echo '<span>Veuillez vous logger afin de continuer</span>';
							}
							?>
						</div>
					</div>
					<div id="content">
						<?php								
								$p = "none";
								$l = "none";
								
						//		$m_arrTxt = getTextArray( $m_lang );
							$lg = -1;
							if( isset( $_GET['lg'] ) )
								$lg = $_GET['lg'];
							else
								$lg = 0;
								
								if( isset($_COOKIE['tech_log']) && !empty($_COOKIE['tech_log']) && ($_COOKIE['tech_log'] != 'Wrong') )
								{								
									if( isset( $_GET['p'] ) ) {
										if( $_GET['p'] == 'cal' || $_GET['p'] == "myprofile" || $_GET['p'] == "admin" || $_GET['p'] == "stats" ||  $_GET['p'] == "workplace" || $_GET['p'] == "ficheclient" || $_GET['p'] == "printcenter" || $_GET['p'] == "servicescenter" || $_GET['p'] == "eyemodule" || $_GET['p'] == "faq" || $_GET['p'] == "away" )
										{
											if( $_GET['p'] != 'cal' )
												$p = $_GET['p'];
											else
												$p = 'cal_data';
										}
										else
											$p = "workplace";
									} else
										$p = "workplace";
								}
								else
									$p = "login";
										
								include( './php/'.$p.'.php' );						
						?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>