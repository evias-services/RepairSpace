<?php

	if( isset( $_COOKIE['tech_log'] ) && !empty($_COOKIE['tech_log']) ) {
		$techN = $_COOKIE['tech_log'];	
		$idT = 0;
		$nomT = '';
		$cpT = '';
		$langT = '';
		$lvlT = '';
		$mobT = '';
		$mailT = '';
		$funcT = '';	
		$colT = '';
		$p_showA = '';
		
		if( isset( $_POST['isChangedData'] ) ) {
			$qT = mysql_query( "SELECT * FROM technicien WHERE `nom` = '".$techN."' LIMIT 1;" );
			$rT = mysql_fetch_array( $qT );
			$idT = $rT[0];
			$nomT = $_POST['name-tech'];
			$cpT = $_POST['cp-tech'];
			$langT = $_POST['lang-tech'];
			if( isset( $_POST['lvl-tech'] ) )
				$lvlT = $_POST['lvl-tech'];
			else
				$lvlT = 0;
			$mobT = $_POST['mob-tech'];
			$mailT = $_POST['mail-tech'];
			$funcT = $_POST['func-tech'];
			$colT = $_POST['col-tech'];
			$p_showA = $_POST['showA-tech'];
			
			$qSet2 = mysql_query( "UPDATE `intratelier09`.`technicien` SET `nom` = '".$nomT."', `codepass`='".$cpT."', `lang`='".$langT."', `lvl`='".$lvlT."', `mobile`='".$mobT."', `mail`='".$mailT."', `fonction`='".$funcT."', `color`='".$colT."', `away_show`='".$p_showA."' WHERE `id`='".$idT."' LIMIT 1;" );
			echo '<script type="text/javascript">';
					echo 'logNow( \''.$idTech.'\', \'Modifier paramètres profil.\' );';
				echo '</script>';
		}
		else
		{		
			$qT = mysql_query( "SELECT * FROM technicien WHERE `nom` = '".$techN."' LIMIT 1;" );
			$rT = mysql_fetch_array( $qT );
			$idT = $rT[0];
			$nomT = $rT[1];
			$cpT = $rT[2];
			$langT = $rT[3];
			$lvlT = $rT[4];
			$mobT = $rT[5];
			$mailT = $rT[6];
			$funcT = $rT[7];
			$colT = $rT[8];
			$p_showA = $rT[9];
		}	
		
		echo '<div id="profile">';
			echo '<h1>'.'Information sur le technicien: '.$nomT.' ['.$idT.']'.'</h1>';
			echo '<form method="post" action="index.php?p=myprofile">';
			echo '<table cellpadding="0px" cellspacing="5px" border="0px">';
				echo '<tr>';
					echo '<td>'.'<label for="name-tech">'.'Libellé: '.'</label>'.'</td>';
					echo '<td>'.'<input type="text" name="name-tech" value="'.$nomT.'" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="cp-tech">'.'Codepass: '.'</label>'.'</td>';
					echo '<td>'.'<input type="text" name="cp-tech" value="'.$cpT.'" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="lang-tech">'.'Langue: '.'</label>'.'</td>';
					echo '<td>';
						echo '<select name="lang-tech">';
							switch( $langT )
							{
								case 0:
									echo '<option selected value="0">Français</option>';
									echo '<option value="1">Deutsch</option>';
									echo '<option value="2">English</option>';
									break;
									
								case 1:
									echo '<option value="0">Français</option>';
									echo '<option selected value="1">Deutsch</option>';
									echo '<option value="2">English</option>';
									break;
									
								case 2:
									echo '<option value="0">Français</option>';
									echo '<option value="1">Deutsch</option>';
									echo '<option selected value="2">English</option>';
									break;
									
								default:
									echo '<option selected value="0">Français</option>';
									echo '<option value="1">Deutsch</option>';
									echo '<option value="2">English</option>';
									break;
							}							
						echo '</select>';
					echo '</td>';
					//echo '<td>'.'<input type="text" name="lang-tech" value="'.$langT.'" />'.'</td>';
				echo '</tr>';
				if( $lvlT == 1 )
				{
					echo '<tr>';
						echo '<td>'.'<label for="lvl-tech">'.'Niveau: '.'</label>'.'</td>';
						echo '<td>'.'<input type="text" name="lvl-tech" value="'.$lvlT.'" />'.'</td>';
					echo '</tr>';
				}
				echo '<tr>';
					echo '<td>'.'<label for="mob-tech">'.'Mobile: '.'</label>'.'</td>';
					echo '<td>'.'<input type="text" name="mob-tech" value="'.$mobT.'" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="mail-tech">'.'Mail: '.'</label>'.'</td>';
					echo '<td>'.'<input type="text" name="mail-tech" value="'.$mailT.'" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="func-tech">'.'Fonction: '.'</label>'.'</td>';
					echo '<td>'.'<input type="text" name="func-tech" value="'.$funcT.'" />'.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="col-tech">'.'Couleur: '.'</label>'.'</td>';
					echo '<td>';
						echo '<select name="col-tech">';
							echo '<option onclick="document.getElementById( \'colTech-prev\' ).style.background=\'#f90617\';" '.( ($colT == '#f90617') ? 'selected' : '' ).' style="color: #f90617;" value="#f90617">Rouge</option>';
							echo '<option onclick="document.getElementById( \'colTech-prev\' ).style.background=\'#940711\';" '.( ($colT == '#940711') ? 'selected' : '' ).' style="color: #940711;" value="#940711">Bordeaux</option>';
							echo '<option onclick="document.getElementById( \'colTech-prev\' ).style.background=\'#8c4805\';" '.( ($colT == '#8c4805') ? 'selected' : '' ).' style="color: #8c4805;" value="#8c4805">Brun</option>';							
							echo '<option onclick="document.getElementById( \'colTech-prev\' ).style.background=\'#940da0\';" '.( ($colT == '#940da0') ? 'selected' : '' ).' style="color: #940da0;" value="#940da0">Mauve</option>';														
							echo '<option onclick="document.getElementById( \'colTech-prev\' ).style.background=\'#2c42ed\';" '.( ($colT == '#2c42ed') ? 'selected' : '' ).' style="color: #2c42ed;" value="#2c42ed">Bleu</option>';
							echo '<option onclick="document.getElementById( \'colTech-prev\' ).style.background=\'#05458c\';" '.( ($colT == '#05458c') ? 'selected' : '' ).' style="color: #05458c;" value="#05458c">Bleu foncé</option>';
							echo '<option onclick="document.getElementById( \'colTech-prev\' ).style.background=\'#048f2e\';" '.( ($colT == '#048f2e') ? 'selected' : '' ).' style="color: #048f2e;" value="#048f2e">Vert</option>';
							echo '<option onclick="document.getElementById( \'colTech-prev\' ).style.background=\'#fa5ac0\';" '.( ($colT == '#fa5ac0') ? 'selected' : '' ).' style="color: #fa5ac0;" value="#fa5ac0">Rose</option>';
							echo '<option onclick="document.getElementById( \'colTech-prev\' ).style.background=\'#07b5fe\';" '.( ($colT == '#07b5fe') ? 'selected' : '' ).' style="color: #07b5fe;" value="#07b5fe">Bleu marine</option>';
							echo '<option onclick="document.getElementById( \'colTech-prev\' ).style.background=\'#07fe53\';" '.( ($colT == '#07fe53') ? 'selected' : '' ).' style="color: #07fe53;" value="#07fe53">Vert fluo</option>';		
						echo '</select>';
					echo '</td>';
					echo '<td><div id="colTech-prev" style="border:1px solid #000;width: 85px; height: 15px; background:'.$colT.';">&nbsp;</div></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<label for="showA-tech">'.'Calendrier: '.'</label>'.'</td>';
					echo '<td><select name="showA-tech">';
						if( $p_showA == 'm' )
						{
							echo '<option selected value="m">Mois</option>';
							echo '<option value="w">Semaine</option>';
							echo '<option value="y">Année</option>';
						}
						else
						{
							if( $p_showA == 'w' )
							{
								echo '<option value="m">Mois</option>';
								echo '<option selected value="w">Semaine</option>';
							}
						}
					echo '</select></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>'.'<input type="hidden" name="isChangedData" />'.'</td>';
					echo '<td>'.'<input class="button" type="submit" value="Envoyer" />'.'</td>';
				echo '</tr>';
			echo '</table>';
			echo '</form>';
		echo '</div>';
	}
	else
		echo '<span>Vous n\'avez pas accès à cette fonctionnalité.</span>';
?>
