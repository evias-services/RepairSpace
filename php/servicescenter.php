<?php

	if( isset( $_POST['isAddService'] ) ) {
		$qInsert = mysql_query( "INSERT INTO `prestation` ( `desc` , `prix_min` , `id_groupe` , `small_desc` ) VALUES ( '".$_POST['service-name']."', '".$_POST['service-prize']."', '0', 'Default' );" );
	}

	echo '<div id="services-man">';
		echo '<h1>'.'Centre des services'.'</h1>';
		echo '<h2>'.'Services à la clientèle'.'</h2>';
		
		$qServ = mysql_query( "SELECT * FROM prestation;" );
		$iServ = mysql_numrows( $qServ );
		if( $iServ > 0 ) {
			echo '<ul>';
				while( $rServ = mysql_fetch_array( $qServ ) )
					echo '<li onmouseover="this.style.background = \'#fcf\'; this.style.cursor = \'pointer\';" onmouseout="this.style.background=\'#fff\';">'.'<span class="normal">'.$rServ[1].' - Prix: '.$rServ[2].' &euro;</span>'.'<img onclick="doRequest(\''.$rServ[0].'\', \'12\' ); this.parentNode.style.display=\'none\';" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'#fff\';" src="./images/sendfinish.png" height="16px" />'.'</li>';
			echo '</ul>';
			echo '<hr />';
		}
	echo '</div>';
	
	echo '<form method="post" action="index.php?p=servicescenter&lg='.$_GET['lg'].'">';
		echo '<div id="add-service">';
			echo '<input class="text" type="text" name="service-name" value="Entrez le nom ou une brève description du service proposé." />';
			echo '<input class="prize" type="text" name="service-prize" value="Prix en &euro;" />';
			echo '<input class="button" type="submit" value="Ajouter" />';
			echo '<input type="hidden" name="isAddService" />';
		echo '</div>';
	echo '</form>';

?>