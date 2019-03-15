<?php

// ###############################
// GESTION DES DONNEES
// ###############################

if( isset( $_POST['isAddTech'] ) )
{
	$lib = $_POST['techname'];
	$cp = $_POST['techcp'];
	$lvl = $_POST['techaxs'];
	$mob = $_POST['techmob'];
	$mail = $_POST['techmail'];
	$func = $_POST['techfunc'];
	
	$qInsert = mysql_query( "INSERT INTO `technicien` ( `id`, `nom`, `codepass`, `lang`, `lvl`, `mobile`, `mail`, `fonction` ) VALUES (	NULL , '".$lib."', '".$cp."', '0', '".$lvl."', '".$mob."', '".$mail."', '".$func."'	);" ) or die( 'Erreur: '.mysql_error( ) );
}

// ###############################
// FIN GESTION DES DONNEES
// ###############################



	$techN = $_COOKIE['tech_log'];
	if( !empty($techN) )
	{
		echo '<div id="admin-center">';
			echo '<h1>'.'Centre d\'administration'.'</h1>';
			$qT = mysql_query( "SELECT * FROM technicien WHERE `nom` = '".$techN."' LIMIT 1;" );
			$rT = mysql_fetch_array( $qT );
			$idT = $rT[0];
			$lvlT = $rT[4];
			if( $lvlT == 1 )
			{			
				echo '<h2>'.'Fonction des techniciens'.'</h2>';
				echo '<div id="func-info" class="hide">';
					echo '<span>&nbsp;</span>';
				echo '</div>';
				echo '<div>';
					$qT = mysql_query( "SELECT * FROM technicien ORDER BY id ASC;" );
					echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
					while( $rT = mysql_fetch_array( $qT ) )
					{
						echo '<tr>';
						echo '<td>'.'<span>'.$rT[1].'</span>'.'</td>';
						echo '<td>'.'<input class="func" type="text" id="func-tech-'.$rT[0].'" name="func-tech-'.$rT[0].'" value="'.$rT[7].'" />'.'</td>';
						echo '<td>'.'<span class="link" onmouseover="this.style.cursor=\'pointer\'; this.style.color=\'#0078ff\'; this.style.fontWeight = \'bold\';" onmouseout="this.style.fontWeight=\'normal\'; this.style.color=\'#024591\';" onclick="document.getElementById( \'func-info\' ).innerHTML = doRequestMore( \''.$rT[0].'\', 31 );document.getElementById( \'func-info\' ).className = \'show\';">Enregistrer</span>'.'</td>';
						echo '</tr>';
					}
					echo '</table>';
				echo '</div>';
				
				echo '<h2>'.'Niveau d\'accès des techniciens'.'</h2>';
				echo '<div id="axs-info" class="hide">';
					echo '<span>&nbsp;</span>';
				echo '</div>';
				echo '<div>';
					$qT = mysql_query( "SELECT * FROM technicien ORDER BY id ASC;" );
					echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
					while( $rT = mysql_fetch_array( $qT ) )
					{
						echo '<tr>';
						echo '<td>'.'<span>'.$rT[1].'</span>'.'</td>';
						echo '<td>'.'<input type="text" id="axs-tech-'.$rT[0].'" name="axs-tech-'.$rT[0].'" value="'.$rT[4].'" />'.'</td>';
						echo '<td>'.'<span  class="link" onmouseover="this.style.cursor=\'pointer\'; this.style.color=\'#0078ff\'; this.style.fontWeight = \'bold\';" onmouseout="this.style.fontWeight=\'normal\'; this.style.color=\'#024591\';" onclick="document.getElementById( \'axs-info\' ).innerHTML = doRequestMore( \''.$rT[0].'\', 32 );document.getElementById( \'axs-info\' ).className = \'show\';" >Enregistrer</span>'.'</td>';
						echo '</tr>';
					}
					echo '</table>';
				echo '</div>';
				
				echo '<h2>'.'Gestion des techniciens'.'</h2>';
				echo '<div id="man-info" class="hide">';
					echo '<span>&nbsp;</span>';
				echo '</div>';
				echo '<div>';
					$qT = mysql_query( "SELECT * FROM technicien ORDER BY id ASC;" );
					echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
					while( $rT = mysql_fetch_array( $qT ) )
					{
						echo '<tr>';
						echo '<td>'.'<input class="manage-tech" type="text" id="tech-name-'.$rT[0].'" name="tech-name-'.$rT[0].'" value="'.$rT[1].'" />'.'</td>';
						if( $rT[4] == 1 && $rT[0] != $idT )
							echo '<td>'.'<input class="manage-tech" style="background:#dcdcdc;" type="text" id="tech-cp-'.$rT[0].'" name="tech-cp-'.$rT[0].'" value="'.$rT[2].'" />'.'</td>';
						else	
							echo '<td>'.'<input class="manage-tech" type="text" id="tech-cp-'.$rT[0].'" name="tech-cp-'.$rT[0].'" value="'.$rT[2].'" />'.'</td>';
						echo '<td>'.'<input class="manage-tech" type="text" id="tech-mob-'.$rT[0].'" name="tech-mob-'.$rT[0].'" value="'.$rT[5].'" />'.'</td>';
						echo '<td>'.'<input class="manage-tech" type="text" id="tech-mail-'.$rT[0].'" name="tech-mail-'.$rT[0].'" value="'.$rT[6].'" />'.'</td>';
						echo '<td>'.'<img src="images/showfinish.png" onmouseover="this.style.cursor=\'pointer\';" onclick="document.getElementById( \'man-info\' ).innerHTML = doRequestMore( \''.$rT[0].'\', 33 );document.getElementById( \'man-info\' ).className = \'show\';" width="16px" height="16px" border="0px" />'.'<img src="images/sendfinish.png" onmouseover="this.style.cursor=\'pointer\';" onclick="doRequest( \''.$rT[0].'\', 34 );" width="16px" height="16px" border="0px" />'.'</td>';
						echo '</tr>';
					}
					echo '</table>';
					echo '<span onmouseover="this.style.cursor=\'pointer\'; this.style.fontWeight=\'normal\';" onmouseout="this.style.fontWeight=\'bold\';" style="margin-left: 10px;" onclick="showAddTech( );">Ajouter un technicien</span>';
					echo '<div id="curseur-add-tech" class="hide">';
						echo '0';
					echo '</div>';
					echo '<div id="add-tech" class="hide">';
						echo '<form method="post" action="index.php?p=admin">';
							echo '<table cellpadding="0px" cellspacing="4px" border="0px">';
								echo '<tr>';
									echo '<td><label for="techname">Libellé: </label></td>';
									echo '<td><input type="text" name="techname" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td><label for="techcp">Codepass: </label></td>';
									echo '<td><input type="text" name="techcp" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td><label for="techaxs">Accès: </label></td>';
									echo '<td><input type="text" name="techaxs" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td><label for="techmob">Tél. Mobile: </label></td>';
									echo '<td><input type="text" name="techmob" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td><label for="techmail">Mail: </label></td>';
									echo '<td><input type="text" name="techmail" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td><label for="techfunc">Fonction: </label></td>';
									echo '<td><input type="text" name="techfunc" /></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td><input type="hidden" name="isAddTech" /></td>';
									echo '<td><input type="submit" value="Ajouter" /></td>';
								echo '</tr>';
							echo '</table>';
						echo '</form>';
					echo '</div>';
				echo '</div>';
			}
			else
				echo '<span>'.'Vous n\'avez pas accès au centre d\'administration'.'</span>';
		echo '</div>';
	}
	else
	{
		echo '<script type="text/javascript">';
			echo 'window.location.href = \'index.php\';';
		echo '</script>';
	}
?>