<?php
	// eye Module
	// Copyright Grégory Saive
	// 22.07.2009 
		
	if( isset( $_POST['isAddEyeText'] ) ) {
		$idDate = -1;
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
		$eyeText = $_POST['eyeText'];
		$url = $_POST['eyeText-url'];
		if( $url == "http://" )
			$url = "default";
			
		$qInsert = mysql_query( "INSERT INTO `intratelier`.`eyetexts` ( `text` , `url` , `color`, `date_id` ) VALUES ( '".$eyeText."', '".$url."', '#ffffff', '".$idDate."' );" ) or die( "Erreur: ".mysql_error( ) );
	}
	
	echo '<div id="eye-box">';
		echo '<h1>Centre des eyeTexts</h1>';
		echo '<div id="info-eyeText">';
			echo '<span>'.'Les </span><span style="color: #006; ">eyeTexts</span><span> sont des notes que vous pouvez enregistrés à </span><span style="color: #006; ">volonté</span><span>. Elle vous permettent de garder un oeil sur des choses que vous trouvez </span><span style="color: #006; ">importantes</span><span>. Comme par exemple un </span><span style="color: #006; ">lien</span><span> que vous utilisez souvent ou des données d\'authentification. Vous pouvez donc insérer un titre dans la note et </span><span style="color: #006; ">annexé un lien</span><span> à celle-ci. Cela vous permettra d\'accéder à l\'adresse du lien en </span><span style="color: #006; ">un simple clic</span><span> dans votre barre </span><span style="color: #006; ">eyeModule</span><span>.'.'</span>';
		echo '</div>';
		if( isset( $_GET['id'] ) ) {
			$qET = mysql_query( "SELECT * FROM eyetexts WHERE id='".$_GET['id']."' LIMIT 1;" );
			$rET = mysql_fetch_array( $qET );
			echo '<h2>'.'eyeText sélectionné'.'</h2>';
			echo '<div id="eyetext">';
			echo '<span><pre>';
				echo htmlentities($rET[1]);
			echo '</pre></span>';
			echo '</div>';
			echo '<hr />';
		}		
		echo '<h2>'.'eyeTexts enregistrés'.'</h2>';		
		$qET = mysql_query( "SELECT * FROM eyetexts ORDER BY id DESC;" );
		if( mysql_numrows( $qET ) > 0 ) {
			echo '<div id="info-list-eyeText" class="hide">';
				echo '&nbsp;';
			echo '</div>';
			echo '<ul id="eye-texts">';
				while( $rET = mysql_fetch_array( $qET ) ){
					if( $rET[2] != "default" ) {
						if( $rET[6] == 1 ) 
							// Barré
							echo '<li onmouseover="this.style.borderBottom = \'1px solid #0078ff\';" onmouseout="this.style.borderBottom = \'0px solid #000\';">'.'<span style="text-decoration: line-through;">'.truncStops(htmlentities($rET[1]),64).' - [<a href="'.$rET[2].'">Lien externe</a>] - </span>'.'<img onclick="doRequest(\''.$rET[0].'\', \'3\' ); this.parentNode.style.display=\'none\';" onmouseover="showInfoEyeText(\'Supprimer de la base de donnée\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" src="./images/sendfinish.png" height="16px" />'.'<img onmouseover="showInfoEyeText(\'Afficher le document complet\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" onclick="window.location.href=\'index.php?p=eyemodule&id='.$rET[0].'\';" src="./images/lileye.png" height="16px" />'.'<img onmouseover="showInfoEyeText(\'Réouvrir/Clôturer un eyeText.\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" onclick="doRequest(\''.$rET[0].'\', \'1\' );" src="./images/setfinish-eyetext.png" height="16px" />'.'<img onmouseover="showInfoEyeText(\'Afficher/Ne pas afficher dans eyeModule.\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" onclick="doRequest(\''.$rET[0].'\', \'2\' );" src="./images/eyecrossed.png" height="16px" />'.'</li>';
						else
							// lisible
							echo '<li onmouseover="this.style.borderBottom = \'1px solid #0078ff\';" onmouseout="this.style.borderBottom = \'0px solid #000\';">'.'<span>'.truncStops(htmlentities($rET[1]),64).' - [<a href="'.$rET[2].'">Lien externe</a>] - </span>'.'<img onclick="doRequest(\''.$rET[0].'\', \'3\' ); this.parentNode.style.display=\'none\';" onmouseover="showInfoEyeText(\'Supprimer de la base de donnée\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" src="./images/sendfinish.png" height="16px" />'.'<img onmouseover="showInfoEyeText(\'Afficher le document complet\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" onclick="window.location.href=\'index.php?p=eyemodule&id='.$rET[0].'\';" src="./images/lileye.png" height="16px" />'.'<img onmouseover="showInfoEyeText(\'Réouvrir/Clôturer un eyeText.\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" onclick="doRequest(\''.$rET[0].'\', \'1\' );" src="./images/setfinish-eyetext.png" height="16px" />'.'<img onmouseover="showInfoEyeText(\'Afficher/Ne pas afficher dans eyeModule.\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" onclick="doRequest(\''.$rET[0].'\', \'2\' );" src="./images/eyecrossed.png" height="16px" />'.'</li>';
					}
					else {
						if( $rET[6] == 1 )	
							echo '<li onmouseover="this.style.borderBottom = \'1px solid #0078ff\';" onmouseout="this.style.borderBottom = \'0px solid #000\';">'.'<span style="text-decoration: line-through;">'.truncStops($rET[1],64).' - [<a href="#">Aucun lien</a>] - </span>'.'<img onclick="doRequest(\''.$rET[0].'\', \'3\' ); this.parentNode.style.display=\'none\';" onmouseover="showInfoEyeText(\'Supprimer de la base de donnée\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" src="./images/sendfinish.png" height="16px" />'.'<img onclick="window.location.href=\'index.php?p=eyemodule&id='.$rET[0].'\';" onmouseover="showInfoEyeText(\'Afficher le document complet\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" src="./images/lileye.png" height="16px" />'.'<img onmouseover="showInfoEyeText(\'Réouvrir/Clôturer un eyeText.\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" onclick="doRequest(\''.$rET[0].'\', \'1\' );" src="./images/setfinish-eyetext.png" height="16px" />'.'<img onmouseover="showInfoEyeText(\'Afficher/Ne pas afficher dans eyeModule.\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" onclick="doRequest(\''.$rET[0].'\', \'2\' );" src="./images/eyecrossed.png" height="16px" />'.'</li>';
						else
							echo '<li onmouseover="this.style.borderBottom = \'1px solid #0078ff\';" onmouseout="this.style.borderBottom = \'0px solid #000\';">'.'<span>'.truncStops($rET[1],64).' - [<a href="#">Aucun lien</a>] - </span>'.'<img onclick="doRequest(\''.$rET[0].'\', \'3\' ); this.parentNode.style.display=\'none\';" onmouseover="showInfoEyeText(\'Supprimer de la base de donnée\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" src="./images/sendfinish.png" height="16px" />'.'<img onclick="window.location.href=\'index.php?p=eyemodule&id='.$rET[0].'\';" onmouseover="showInfoEyeText(\'Afficher le document complet\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" src="./images/lileye.png" height="16px" />'.'<img onmouseover="showInfoEyeText(\'Réouvrir/Clôturer un eyeText.\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" onclick="doRequest(\''.$rET[0].'\', \'1\' );" src="./images/setfinish-eyetext.png" height="16px" />'.'<img onmouseover="showInfoEyeText(\'Afficher/Ne pas afficher dans eyeModule.\');this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="resetInfoEyeText( );this.style.background=\'#fff\';" onclick="doRequest(\''.$rET[0].'\', \'2\' );" src="./images/eyecrossed.png" height="16px" />'.'</li>';
					}
				}
			echo '</ul>';		
		} else {
			echo '<span>'.'Aucun eyeText n\'a été enregistré.'.'</span>';
		}
		echo '<hr />';	
		
		echo '<h2>'.'Ajoutez un eyeText'.'</h2>';
		echo '<div id="add-eyeText">';
			echo '<form method="post" action="index.php?p=eyemodule">';
				echo '<textarea name="eyeText">Entrez ici le texte de votre note eyeText</textarea><br />';
				echo '<input class="url" type="text" name="eyeText-url" value="http://" />';
				echo '<input class="button" type="submit" value="Ajouter" />';
				echo '<input type="hidden" name="isAddEyeText" />';
			echo '</form>';
		echo '</div>';
	echo '</div>';
?>