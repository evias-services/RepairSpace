<?php
	$techN = $_COOKIE['tech_log'];
	if( !empty($techN) )
	{
		$qT = mysql_query( "SELECT * FROM technicien WHERE `nom` = '".$techN."' LIMIT 1;" );
		$rT = mysql_fetch_array( $qT );
		$idT = $rT[0];
		$lvlT = $rT[4];
		echo '<div id="stats-center">';
		if( $lvlT == 1 )
		{
			echo '<h1>'.'Centre des statistiques'.'</h1>';
			echo '<h2>'.'Prix de revient et services par techniciens'.'</h2>';
			echo '<div class="stat-window">';
				$qTa = mysql_query( "SELECT * FROM technicien;" );
				$cntT = mysql_numrows( $qTa );
				while( $rTa = mysql_fetch_array( $qTa ) )
				{
					$cntPTot = 0;
					$prixTotal = 0.00;
					$qP1 = mysql_query( "SELECT * FROM prester WHERE `id_technicien`='".$rTa[0]."';" );
					$cntPTot += mysql_numrows( $qP1 );
					while( $rP1 = mysql_fetch_array( $qP1 ) )
					{
						$qPr = mysql_query( "SELECT * FROM prestation WHERE id='".$rP1[1]."' LIMIT 1;" );
						$rPr = mysql_fetch_array( $qPr );
						$prixTotal += $rPr[2];
					}
					$qP2 = mysql_query( "SELECT * FROM prester_depl WHERE `id_technicien`='".$rTa[0]."';" );
					$cntPTot += mysql_numrows( $qP2 );
					while( $rP2 = mysql_fetch_array( $qP2 ) )
					{
						$qPr = mysql_query( "SELECT * FROM prestation WHERE id='".$rP2[1]."' LIMIT 1;" );
						$rPr = mysql_fetch_array( $qPr );
						$prixTotal += $rPr[2];
					}
					echo '<span>'.$rTa[1].' - '.$cntPTot.' services pour un total de '.$prixTotal.' &euro;</span><br />';
				}
			echo '</div>';
			
			echo '<h2>'.'Prix de revient de l\'atelier par mois'.'</h2>';
			echo '<div class="stat-window">';
			$qR = mysql_query( "SELECT * FROM reparation;" );
			$arrDates = array( );
			$s = 0;
			while( $rR = mysql_fetch_array( $qR ) )
			{
				if( findInArr( $rR[2], $arrDates ) == 0 )
				{
					$arrDates[$s] = $rR[2];
					$s++;
				}
			}
			$cntYear = 0;
			$yearWorking = -1;
			$years = array( );
			$arrSDates = array( );
			// *********************************
			// Tri des dates pour l'affichage
			// *********************************
			for( $g = 0; $g < count( $arrDates ); $g++ )
			{
				$qtd = mysql_query( "SELECT * FROM date WHERE id='".$arrDates[$g]."' LIMIT 1;" );
				$rtd = mysql_fetch_array( $qtd );
				$arrSDates[$g] = $rtd[4];				
			}
			
			$arrSDates = sort_laterDate( $arrSDates );
			for( $a = 0; $a < count( $arrSDates ); $a++ )
			{
				$qtd = mysql_query( "SELECT * FROM date WHERE `string_date`='".$arrSDates[$a]."' LIMIT 1;" );
				$rtd = mysql_fetch_array( $qtd );
				$std = $rtd[4];
				$at = explode( '.', $std );
				
				if( findInArr( $at[2], $years ) == 0 )
				{
					$years[$cntYear] = $at[2];
					$cntYear++;
				}
			}
			for( $y = 0; $y < count( $years ); $y++ )
			{
				echo '<h2>Année '.$years[$y].'</h2>';
			
				for( $x = 0; $x < 12; $x++ )
				{
					$sm = monthById( $x );				
					$arrRep = array( );
					$totalPrize = 0.00;
					$qR = mysql_query( "SELECT * FROM reparation;" );
					$countForMonth = 0;
					while( $rR = mysql_fetch_array( $qR ) )
					{
						$qDate = mysql_query( "SELECT * FROM date WHERE id ='".$rR[2]."' LIMIT 1;" );
						$rDate = mysql_fetch_array( $qDate );
						$sDate = $rDate[4];
						$aD = explode( '.', $sDate );
						$mDate = $aD[1];
						$yDate = $aD[2];
						if( ($mDate == ($x+1)) && ($yDate == $years[$y]) )
						{
							$totalPrize += $rR[3];
							$countForMonth++;
						}
					}
					
					if( $countForMonth > 0 )
					{
						echo '<h3 class="month">'.$sm.'</h3>';
						echo '<span>';
						echo 'Prix de revient: </span><span style="color:#ff7800;">'.$totalPrize.' &euro;</span><span> pour </span><span style="color:#ff7800;">'.$countForMonth.'</span><span> réparations.';
						echo '</span>';
					}				
				}
			}
			echo '</div>';
			
			echo '<h2>'.'Prix de revient des déplacements par mois'.'</h2>';
			echo '<div class="stat-window">';
			$qR = mysql_query( "SELECT * FROM deplacement;" );
			$arrDates = array( );
			$s = 0;
			while( $rR = mysql_fetch_array( $qR ) )
			{
				if( findInArr( $rR[4], $arrDates ) == 0 )
				{
					$arrDates[$s] = $rR[4];
					$s++;
				}
			}
			$cntYear = 0;
			$yearWorking = -1;
			$years = array( );
			$arrSDates = array( );
			// *********************************
			// Tri des dates pour l'affichage
			// *********************************
			for( $g = 0; $g < count( $arrDates ); $g++ )
			{
				$qtd = mysql_query( "SELECT * FROM date WHERE id='".$arrDates[$g]."' LIMIT 1;" );
				$rtd = mysql_fetch_array( $qtd );
				$arrSDates[$g] = $rtd[4];				
			}
			
			$arrSDates = sort_laterDate( $arrSDates );
			for( $a = 0; $a < count( $arrSDates ); $a++ )
			{
				$qtd = mysql_query( "SELECT * FROM date WHERE `string_date`='".$arrSDates[$a]."' LIMIT 1;" );
				$rtd = mysql_fetch_array( $qtd );
				$std = $rtd[4];
				$at = explode( '.', $std );
				
				if( findInArr( $at[2], $years ) == 0 )
				{
					$years[$cntYear] = $at[2];
					$cntYear++;
				}
			}
			for( $y = 0; $y < count( $years ); $y++ )
			{
				echo '<h2>Année '.$years[$y].'</h2>';
				for( $x = 0; $x < 12; $x++ )
				{
					$sm = monthById( $x );				
					$arrRep = array( );
					$totalPrize = 0.00;
					$qR = mysql_query( "SELECT * FROM deplacement;" );
					$countForMonth = 0;
					while( $rR = mysql_fetch_array( $qR ) )
					{
						$qDate = mysql_query( "SELECT * FROM date WHERE id ='".$rR[4]."' LIMIT 1;" );
						$rDate = mysql_fetch_array( $qDate );
						$sDate = $rDate[4];
						$aD = explode( '.', $sDate );
						$mDate = $aD[1];
						$yDate = $aD[2];
						if( $mDate == ($x+1) && ($yDate == $years[$y]) )
						{
							$totalPrize += $rR[6];
							$countForMonth++;
						}
					}
				
					if( $countForMonth > 0 )
					{
						echo '<h3 class="month">'.$sm.'</h3>';
						echo '<span>';
						echo 'Prix de revient: </span><span style="color:#ff7800;">'.$totalPrize.' &euro;</span><span> pour </span><span style="color:#ff7800;">'.$countForMonth.'</span><span> déplacements';
						echo '</span>';
					}				
				}
			}
			echo '</div>';
			
			echo '<h2>'.'Prix de revient total par mois'.'</h2>';
			echo '<div class="stat-window">';
			$qR = mysql_query( "SELECT * FROM deplacement;" );
			$qD = mysql_query( "SELECT * FROM reparation;" );
			$arrDates = array( );
			$s = 0;
			while( $rR = mysql_fetch_array( $qR ) )
			{
				if( findInArr( $rR[4], $arrDates ) == 0 )
				{
					$arrDates[$s] = $rR[4];
					$s++;
				}
			}
			while( $rD = mysql_fetch_array( $qD ) )
			{
				if( findInArr( $rD[2], $arrDates ) == 0 )
				{
					$arrDates[$s] = $rD[2];
					$s++;
				}
			}			
			$cntYear = 0;
			$yearWorking = -1;
			$years = array( );
			$arrSDates = array( );
			// *********************************
			// Tri des dates pour l'affichage
			// *********************************
			for( $g = 0; $g < count( $arrDates ); $g++ )
			{
				$qtd = mysql_query( "SELECT * FROM date WHERE id='".$arrDates[$g]."' LIMIT 1;" );
				$rtd = mysql_fetch_array( $qtd );
				$arrSDates[$g] = $rtd[4];				
			}
			
			$arrSDates = sort_laterDate( $arrSDates );
			
			for( $a = 0; $a < count( $arrSDates ); $a++ )
			{
				$qtd = mysql_query( "SELECT * FROM date WHERE `string_date`='".$arrSDates[$a]."' LIMIT 1;" );
				$rtd = mysql_fetch_array( $qtd );
				$std = $rtd[4];
				$at = explode( '.', $std );
				
				if( findInArr( $at[2], $years ) == 0 )
				{
					$years[$cntYear] = $at[2];
					$cntYear++;
				}
			}
			
			for( $y = 0; $y < count( $years ); $y++ )
			{
				echo '<h2>Année '.$years[$y].'</h2>';
				for( $x = 0; $x < 12; $x++ )
				{
					$sm = monthById( $x );				
					$arrRep = array( );
					$totalPrize = 0.00;
					$qD = mysql_query( "SELECT * FROM deplacement;" );
					$qR = mysql_query( "SELECT * FROM reparation;" );
					$countForMonth = 0;
					while( $rD = mysql_fetch_array( $qD ) )
					{
						$qDate = mysql_query( "SELECT * FROM date WHERE id ='".$rD[4]."' LIMIT 1;" );
						$rDate = mysql_fetch_array( $qDate );
						$sDate = $rDate[4];
						$aD = explode( '.', $sDate );
						$mDate = $aD[1];
						$yDate = $aD[2];
						if( $mDate == ($x+1) && ($yDate == $years[$y]) )
						{
							$totalPrize += $rD[6];
							$countForMonth++;
						}
					}
				
					while( $rR = mysql_fetch_array( $qR ) )
					{
						$qDate = mysql_query( "SELECT * FROM date WHERE id ='".$rR[2]."' LIMIT 1;" );
						$rDate = mysql_fetch_array( $qDate );
						$sDate = $rDate[4];
						$aD = explode( '.', $sDate );
						$mDate = $aD[1];
						$yDate = $aD[2];
						if( $mDate == ($x+1) && ($yDate == $years[$y])  )
						{
							$totalPrize += $rR[3];
							$countForMonth++;
						}
					}
				
					if( $countForMonth > 0 )
					{
						echo '<h3 class="month">'.$sm.'</h3>';
						echo '<span>';
						echo 'Prix de revient: </span><span style="color:#ff7800;">'.$totalPrize.' &euro;</span><span> pour </span><span style="color:#ff7800;">'.$countForMonth.'</span><span> travaux effectués';
						echo '</span>';
					}				
				}
			}
			echo '</div>';
			
			echo '<hr />';
			
			echo '<h2>'.'Liste des services effectués par vos techniciens'.'</h2>';
			echo '<div class="stat-window">';
				$qTa = mysql_query( "SELECT * FROM technicien;" );
				$cntT = mysql_numrows( $qTa );
				while( $rTa = mysql_fetch_array( $qTa ) )
				{
					echo '<h3 id="'.$rTa[0].'" onclick="showJobs( this.id );" onmouseover="this.style.fontWeight=\'bold\';this.style.cursor=\'pointer\';" onmouseout="this.style.fontWeight=\'normal\';">'.$rTa[1].'</h3>';
					echo '<div id="curseur-tech-'.$rTa[0].'" class="hide">';
						echo '0';
					echo '</div>';
					echo '<div id="jobs-tech-'.$rTa[0].'" class="hide">';
						$arrIDPrest = array( );
						$qP = mysql_query( "SELECT * FROM prester WHERE `id_technicien`='".$rTa[0]."';" );
						$i = 0;
						while( $rP = mysql_fetch_array( $qP ) )
						{
							if( findInArr( $rP[1], $arrIDPrest ) == 0 )
							{
								$arrIDPrest[$i] = $rP[1];
								$i++;
							}
							else
								continue;
						}
						$qP2 = mysql_query( "SELECT * FROM prester_depl WHERE `id_technicien`='".$rTa[0]."';" );
						while( $rP = mysql_fetch_array( $qP ) )
						{
							if( findInArr( $rP[1], $arrIDPrest ) == 0 )
							{
								$arrIDPrest[$i] = $rP[1];
								$i++;
							}
							else
								continue;
						}
						
						for( $x = 0; $x < count( $arrIDPrest ); $x++ )
						{
							$qPr = mysql_query( "SELECT * FROM prestation WHERE id = '".$arrIDPrest[$x]."' LIMIT 1;" );
							$rPr = mysql_fetch_array( $qPr );
							$qReverseP1 = mysql_query( "SELECT * FROM prester WHERE `id_technicien`='".$rTa[0]."' AND `prestation_id`='".$rPr[0]."';" );
							$qReverseP2 = mysql_query( "SELECT * FROM prester_depl WHERE `id_technicien`='".$rTa[0]."' AND `prestation_id`='".$rPr[0]."';" );
							echo '<span>'.$rPr[1].'</span>&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: normal; text-decoration: underline; color: #0078ff;">'.(mysql_numrows($qReverseP1)+mysql_numrows($qReverseP2)).' entrées.</span><br />';
						}
					echo '</div>';
					
				}
			echo '</div>';
			
			echo '<h2>'.'Distances parcourues par techniciens'.'</h2>';
			echo '<div class="stat-window">';
				$arrIDDist = array( );
				$qT = mysql_query( "SELECT * FROM technicien;" );
				while( $rT = mysql_fetch_array( $qT ) )
				{
					echo '<h3 id="'.$rT[0].'" onclick="showDistances( this.id );" onmouseover="this.style.fontWeight=\'bold\';this.style.cursor=\'pointer\';" onmouseout="this.style.fontWeight=\'normal\';">'.$rT[1].'</h3>';
					$qD = mysql_query( "SELECT * FROM distance;" );
					echo '<div id="curseur-dist-tech-'.$rT[0].'" class="hide">';
						echo '0';
					echo '</div>';
					echo '<div id="dist-tech-'.$rT[0].'" class="hide">';
					echo '<ul>';
					while( $rD = mysql_fetch_array( $qD ) )	
					{
						$qDepl = mysql_query( "SELECT * FROM deplacement WHERE `idDistance`='".$rD[0]."' AND `id_technicien`='".$rT[0]."';" );
						if( mysql_numrows( $qDepl ) > 0 )
						{
							
							echo '<li>'.$rD[2].' : '.mysql_numrows( $qDepl ).' entrées</li>';
						}
						else
							echo '<li>'.$rD[2].' : Aucun</li>';
					}
					echo '</ul>';
					echo '</div>';
				}
			echo '</div>';
			
			echo '<hr />';
			echo '<h2>'.'Graphe des <span style="font-weight:bold">services</span> effectués en <span style="font-weight:bold">atelier</span>'.'</h2>';
			echo '<div class="stat-window">';
				$qT = mysql_query( "SELECT * FROM technicien;" );
				while( $rT = mysql_fetch_array( $qT ) )
				{
					$techN = $rT[1];
					$idT = $rT[0];
					$nPrest = 0;
					$moyenneTech = 0.00;
					$qPa = mysql_query( "SELECT * FROM prester" );
					$nPa = mysql_numrows( $qPa );
					$qP = mysql_query( "SELECT * FROM prester WHERE `id_technicien` = '".$idT."';" );
					$nPrest = mysql_numrows( $qP );
					// Pourcentage des services effectués.
					$moyenneTech = ($nPrest / $nPa) * 100;
					echo '<div class="tech">';
						echo '<div id="name"><span>'.$techN.'</span></div>';
						echo '<div id="data">';
							$sTrunc = substr($moyenneTech, 0, 5).'%';
							if( $sTrunc > 70 )
								echo '<div id="percent" style="width:'.$sTrunc.'; background: #f4c33d; height:17px; border: 1px solid #8d6806;">'.'<span>'.$sTrunc.' ('.$nPrest.' services)</span>'.'</div>';
							else
							{
								echo '<div id="percent" style="width:'.$sTrunc.'; background: #f4c33d; border: 1px solid #8d6806;">&nbsp;</div>';
								echo '<span>'.$sTrunc.' ('.$nPrest.' services)</span>';
							}
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
			
			echo '<h2>'.'Graphe des <span style="font-weight:bold">services</span> effectués en <span style="font-weight:bold">déplacement</span>'.'</h2>';
			echo '<div class="stat-window">';
				$qT = mysql_query( "SELECT * FROM technicien;" );
				while( $rT = mysql_fetch_array( $qT ) )
				{
					$techN = $rT[1];
					$idT = $rT[0];
					$nPrest = 0;
					$moyenneTech = 0.00;
					$qPa = mysql_query( "SELECT * FROM prester_depl" );
					$nPa = mysql_numrows( $qPa );
					$qP = mysql_query( "SELECT * FROM prester_depl WHERE `id_technicien` = '".$idT."';" );
					$nPrest = mysql_numrows( $qP );
					// Pourcentage des services effectués.
					$moyenneTech = ($nPrest / $nPa) * 100;
					echo '<div class="tech">';
						echo '<div id="name"><span>'.$techN.'</span></div>';
						echo '<div id="data">';
							$sTrunc = substr($moyenneTech, 0, 5).'%';
							if( $sTrunc > 70 )
								echo '<div id="percent" style="width:'.$sTrunc.'; background: #f4c33d; height:17px; border: 1px solid #8d6806;">'.'<span>'.$sTrunc.' ('.$nPrest.' services)</span>'.'</div>';
							else
							{
								echo '<div id="percent" style="width:'.$sTrunc.'; background: #f4c33d; border: 1px solid #8d6806;">&nbsp;</div>';
								echo '<span>'.$sTrunc.' ('.$nPrest.' services)</span>';
							}
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
			
			echo '<h2>'.'Graphe des <span style="font-weight:bold">réparations</span> entrées'.'</h2>';
			echo '<div class="stat-window">';
				$qT = mysql_query( "SELECT * FROM technicien;" );
				while( $rT = mysql_fetch_array( $qT ) )
				{
					$techN = $rT[1];
					$idT = $rT[0];
					$nPrest = 0;
					$moyenneTech = 0.00;
					$qPa = mysql_query( "SELECT * FROM reparation" );
					$nPa = mysql_numrows( $qPa );
					$qP = mysql_query( "SELECT * FROM reparation WHERE `enteredby` = '".$idT."';" );
					$nPrest = mysql_numrows( $qP );
					// Pourcentage des services effectués.
					$moyenneTech = ($nPrest / $nPa) * 100;
					echo '<div class="tech">';
						echo '<div id="name"><span>'.$techN.'</span></div>';
						echo '<div id="data">';
							$sTrunc = substr($moyenneTech, 0, 5).'%';
							if( $sTrunc > 70 )
								echo '<div id="percent" style="width:'.$sTrunc.'; background: #f4c33d; height:17px; border: 1px solid #8d6806;">'.'<span>'.$sTrunc.' ('.$nPrest.' réparations)</span>'.'</div>';
							else
							{
								echo '<div id="percent" style="width:'.$sTrunc.'; background: #f4c33d; border: 1px solid #8d6806;">&nbsp;</div>';
								echo '<span>'.$sTrunc.' ('.$nPrest.' réparations)</span>';
							}
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
			
			echo '<h2>'.'Graphe des <span style="font-weight:bold">déplacements</span> effectués'.'</h2>';
			echo '<div class="stat-window">';
				$qT = mysql_query( "SELECT * FROM technicien;" );
				while( $rT = mysql_fetch_array( $qT ) )
				{
					$techN = $rT[1];
					$idT = $rT[0];
					$nPrest = 0;
					$moyenneTech = 0.00;
					$qPa = mysql_query( "SELECT * FROM deplacement" );
					$nPa = mysql_numrows( $qPa );
					$qP = mysql_query( "SELECT * FROM deplacement WHERE `id_technicien` = '".$idT."';" );
					$nPrest = mysql_numrows( $qP );
					// Pourcentage des services effectués.
					$moyenneTech = ($nPrest / $nPa) * 100;
					echo '<div class="tech">';
						echo '<div id="name"><span>'.$techN.'</span></div>';
						echo '<div id="data">';
							$sTrunc = substr($moyenneTech, 0, 5).'%';
							if( $sTrunc > 70 )
								echo '<div id="percent" style="width:'.$sTrunc.'; background: #f4c33d; height:17px; border: 1px solid #8d6806;">'.'<span>'.$sTrunc.' ('.$nPrest.' déplacements)</span>'.'</div>';
							else
							{
								echo '<div id="percent" style="width:'.$sTrunc.'; background: #f4c33d; border: 1px solid #8d6806;">&nbsp;</div>';
								echo '<span>'.$sTrunc.' ('.$nPrest.' déplacements)</span>';
							}
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
			
			echo '<hr />';
			
			echo '<h2>'.'Graphe des services par <span style="font-weight:bold">technicien</span>'.'</h2>';
			echo '<div class="stat-window">';
				$qP = mysql_query( "SELECT * FROM prestation;" );
				while( $rP = mysql_fetch_array( $qP ) )
				{					
					$nPrest = mysql_numrows($qP);					
					echo '<h4 id="'.$rP[0].'" onclick="showServiceGraphe( this.id )" onmouseover="this.style.fontWeight=\'bold\';this.style.cursor=\'pointer\';" onmouseout="this.style.fontWeight=\'normal\';">'.$rP[1].'</h4>';
					echo '<div id="curseur-service-'.$rP[0].'" class="hide">';
						echo '0';
					echo '</div>';
					echo '<div id="graphe-service-'.$rP[0].'" class="hide">';
						echo '<div class="sndlvl-stat-wnd">';
							$qPa = mysql_query( "SELECT * FROM prester WHERE `prestation_id`='".$rP[0]."' UNION SELECT * FROM prester_depl WHERE `prestation_id` = '".$rP[0]."';" );
							if( mysql_numrows( $qPa ) > 0 )
							{
								$qT = mysql_query( "SELECT * FROM technicien;" );
								while( $rT = mysql_fetch_array( $qT ) )
								{
									$techN = $rT[1];
									$idT = $rT[0];
									$nPrest = 0;
									$moyenneTech = 0.00;
								
									$nPa = mysql_numrows( $qPa );
									$qPb = mysql_query( "SELECT * FROM prester WHERE `prestation_id`='".$rP[0]."' AND `id_technicien` = '".$idT."' UNION SELECT * FROM prester_depl WHERE `prestation_id`='".$rP[0]."' AND `id_technicien`='".$idT."';" );
									$nPrest = mysql_numrows( $qPb );
									// Pourcentage des services effectués.
									$moyenneTech = ($nPrest / $nPa) * 100;
									echo '<div class="service">';
										echo '<div id="name"><span>'.$techN.'</span></div>';
										echo '<div id="data">';
											$sTrunc = substr($moyenneTech, 0, 5).'%';
											if( $sTrunc > 70 )
												echo '<div id="percent" style="width:'.$sTrunc.'; background: #f4c33d; height:17px; border: 1px solid #8d6806;">'.'<span>'.$sTrunc.'</span>'.'</div>';
											else
											{
												echo '<div id="percent" style="width:'.$sTrunc.'; background: #f4c33d; border: 1px solid #8d6806;">&nbsp;</div>';
												echo '<span>'.$sTrunc.'</span>';
											}
										echo '</div>';
									echo '</div>';																									
								}
							}
							else
							{
								echo '<span>'.'Ce service n\'a pas encore été presté.'.'</span>';
							}	
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
		}
		else
		{
			echo '<span>'.'Vous n\'avez pas accès aux statistiques.'.'</span>';
		}
		echo '</div>';
	}
	else
	{
		echo '<script type="text/javascript">';
			echo 'window.location.href = \'index.php\';';
		echo '</script>';
	}
?>