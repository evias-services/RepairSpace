<?php
	$m_user = "root";
	$m_pass = "";
	$m_host = "localhost"; 
	$m_bdd = "intratelier09";
	
	$m_idUser = 0;
	$idClient = -1;
	$idMac = -1;
	$idRep = -1;
	$m_cntRep = 7;
	$m_arrTxt = getTextArray( 2 );
	
	$_conf_MAX_PG = 25;
	$_conf_MAX_AWAY_PG = 15;
	
	function truncString( $source, $max ) {
		$out = "";
		if( $max < strlen( $source ) )
			for( $i = 0; $i < $max; $i++ )
				$out .= $source[$i];
		else
			return $source;
		
		return $out;
	}
	
	function truncStops( $source, $max ) {
		$out;
		if( strlen( $source ) > $max ) {
			$out = substr( $source, 0, ($max-3) )."...";
			return $out;
		} else
			return $source;
	}
	
	function isDigit( $source ) {
		$cont = false;
		for( $i = 0; $i < strlen( $source ); $i++ ) {
			if( $source[$i] == '0' || $source[$i] == '1' || $source[$i] == '2' || $source[$i] == '3' || $source[$i] == '4' || $source[$i] == '5' || $source[$i] == '6' || $source[$i] == '7' || $source[$i] == '8' || $source[$i] == '9' )
				$cont = true;
			else
				$cont = false;
		}
		
		return $cont;				
	}
	
	
	
	function toInt( $src ) {
		for( $x = 0; $x < ($src+1); $x++ ) {
			if( $src <= $x && $src >= ($x-1) )
				return $x;
			else
				continue;
		}
		
		return -1;
	}
	
	// $iL = 0 = fr ; 1 = de ; 2 = en
	function getTextArray( $iL ) {
		$handle = null;
		$out_arr = array( 0 );
		switch( $iL ) {
			case 0:
				$handle = @fopen("./lang/french_index.txt", "r"); // Open file form read.
				break;
			case 1:
				$handle = @fopen("./lang/german_index.txt", "r"); // Open file form read.
				break;
			case 2:
				$handle = @fopen("./lang/english_index.txt", "r"); // Open file form read.
				break;
			default: return -1; break;
		}

		if ($handle) {
			$i = 0;
			while (!feof($handle)) // Loop til end of file.
			{
				if( $i < 10 )
					$out_arr[$i] = substr( fgets($handle, 4096), 4 ); // Read a line.
				else
					if( $i >= 10 && $i < 100 ) 
						$out_arr[$i] = substr( fgets($handle, 4096), 5); // Read a line.
					else
						if( $i >= 100 && $i < 1000 )
							$out_arr[$i] = substr( fgets($handle, 4096), 6); // Read a line.
				$i++;
			}
			
			fclose($handle); // Close the file.
		}
		
		return ($out_arr);
	}
	
	function getTextArrayOnEye( $iL ) {
		$handle = null;
		$out_arr = array( 0 );
		switch( $iL ) {
			case 0:
				$handle = @fopen("../lang/french_index.txt", "r"); // Open file form read.
				break;
			case 1:
				$handle = @fopen("../lang/german_index.txt", "r"); // Open file form read.
				break;
			case 2:
				$handle = @fopen("../lang/english_index.txt", "r"); // Open file form read.
				break;
			default: return -1; break;
		}

		if ($handle) {
			$i = 0;
			while (!feof($handle)) // Loop til end of file.
			{
				if( $i < 10 )
					$out_arr[$i] = substr( fgets($handle, 4096), 4 ); // Read a line.
				else
					if( $i >= 10 && $i < 100 ) 
						$out_arr[$i] = substr( fgets($handle, 4096), 5); // Read a line.
					else
						if( $i >= 100 && $i < 1000 )
							$out_arr[$i] = substr( fgets($handle, 4096), 6); // Read a line.
				$i++;
			}
			
			fclose($handle); // Close the file.
		}
		
		return ($out_arr);
	}
	
	function monthById( $id ) {
		$out = "none";
		$techN = $_COOKIE['tech_log'];
		$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
		$rT = mysql_fetch_array( $qT );
		$lT = $rT[3];
		$m_arrTxt = getTextArray( $lT );
		switch( $id ) {
			case 0:
				$out = $m_arrTxt[124];
				break;
				
			case 1:
				$out = $m_arrTxt[125];
				break;
				
			case 2:
				$out = $m_arrTxt[126];
				break;
				
			case 3:
				$out = $m_arrTxt[127];
				break;
				
			case 4:
				$out = $m_arrTxt[128];
				break;
				
			case 5:
				$out = $m_arrTxt[129];
				break;
				
			case 6:
				$out = $m_arrTxt[130];
				break;
				
			case 7:
				$out = $m_arrTxt[131];
				break;
				
			case 8:
				$out = $m_arrTxt[132];
				break;
				
			case 9:
				$out = $m_arrTxt[133];
				break;
				
			case 10:
				$out = $m_arrTxt[134];
				break;
				
			case 11:
				$out = $m_arrTxt[135];
				break;
				
			default: 
				$out = "Erreur";
				break;				
		}
		
		return ($out);
	}
	
	function daysByMonthID( $m_id ) {
		$out = -1;
		switch( $m_id ) {
				case 0:
					$out = 31;
					break;
				
				case 1:
					$out = 28;
					break;
				
				case 2:
					$out = 31;
					break;
					
				case 3:
					$out = 30;
					break;
					
				case 4:
					$out = 31;
					break;
					
				case 5:
					$out = 30;
					break;
					
				case 6:
					$out = 31;
					break;
					
				case 7:
					$out = 31;
					break;
					
				case 8:
					$out = 30;
					break;
					
				case 9:
					$out = 31;
					break;
					
				case 10:
					$out = 30;
					break;
					
				case 11:
						$out = 31;
						break;
					
				default:
					$out = 31;
					break;
		}
		
		return $out;
	}
	
	function awayByDate( $date ) {
		$techN = $_COOKIE['tech_log'];
		$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
		$rT = mysql_fetch_array( $qT );
		$lT = $rT[3];
		$m_arrTxt = getTextArray( $lT );
		$qDate = mysql_query( "SELECT * FROM date WHERE `string_date`='".$date."' LIMIT 1;" );
		$rDate = mysql_fetch_array( $qDate );
		$iDate = $rDate[0];
		$arr = explode( '.', $date );
		$day = $arr[0];
		$month = $arr[1];
		$year = $arr[2];
		$now = date( 'd.m.Y' );
		$qAway = mysql_query( "SELECT * FROM deplacement WHERE `date_id`='".$iDate."' ORDER BY time ASC;" );
		if( mysql_numrows( $qAway ) > 0 ) {
			
			echo '<ul>';				
				while( $rAway = mysql_fetch_array( $qAway ) )
					echo '<li style="background:#fff;" onclick="window.location.href=\'index.php?p=away&id='.$rAway[0].'\';" onmouseover="this.style.background=\'#cfc\'; this.style.cursor=\'pointer\';" onmouseout="this.style.background=\'#fff\';">'.$rAway[5].' - '.$rAway[1].'</li>';
			echo '</ul>';
			echo '<a href="index.php?p=away&addAway=1&d='.$day.'&m='.$month.'&y='.$year.'">'.$m_arrTxt[10].'</a><br />';
			echo '<span style="font-family: Verdana; font-size: 8pt; font-weight: bold;">'.'Total: '.mysql_numrows( $qAway ).'</span>';
		}
		else {
			echo '<span class="none">'.$m_arrTxt[143].'</span><br />';
			echo '<a href="index.php?p=away&addAway=1&d='.$day.'&m='.$month.'&y='.$year.'">'.$m_arrTxt[10].'</a><br />';
		}
	}
	
	// NOT OK
	function meetingsByDate( $date ) {
		$techN = $_COOKIE['tech_log'];
		$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
		$rT = mysql_fetch_array( $qT );
		$lT = $rT[3];
		$m_arrTxt = getTextArray( $lT );
		$qDate = mysql_query( "SELECT * FROM date WHERE `string_date`='".$date."' LIMIT 1;" );
		$rDate = mysql_fetch_array( $qDate );
		$iDate = $rDate[0];
		$arr = explode( '.', $date );
		$day = $arr[0];
		$month = $arr[1];
		$year = $arr[2];
		$now = date( 'd.m.Y' );
		$qMeet = mysql_query( "SELECT * FROM meeting WHERE `date_id`='".$iDate."' ORDER BY time ASC;" );
		if( mysql_numrows( $qMeet ) > 0 ) {
			
				echo '<ul>';
				while( $rMeet = mysql_fetch_array( $qMeet ) )
					echo '<li style="background:#fff;" onclick="" onmouseover="this.style.background=\'#cfc\'; this.style.cursor=\'pointer\';" onmouseout="this.style.background=\'#fff\';">'.$rMeet[4].' - '.$rMeet[3].'</li>';
				echo '</ul>';
			echo '<a href="index.php?p=cal&addMeeting=1&date='.$day.'.'.$month.'.'.$year.'">'.$m_arrTxt[10].'</a><br />';
			echo '<span style="font-family: Verdana; font-size: 8pt; font-weight: bold;">'.'Total: '.mysql_numrows( $qMeet ).'</span>';
		}
		else {
			echo '<span class="none">'.$m_arrTxt[143].'</span><br />';
			echo '<a href="index.php?p=cal&addMeeting=1&date='.$day.'.'.$month.'.'.$year.'">'.$m_arrTxt[10].'</a><br />';
			
		}
	}
	
	// NOT OK
	function eventsByDate( $date ) {
		$techN = $_COOKIE['tech_log'];
		$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
		$rT = mysql_fetch_array( $qT );
		$lT = $rT[3];
		$m_arrTxt = getTextArray( $lT );
		$qDate = mysql_query( "SELECT * FROM date WHERE `string_date`='".$date."' LIMIT 1;" );
		$rDate = mysql_fetch_array( $qDate );
		$iDate = $rDate[0];
		$arr = explode( '.', $date );
		$day = $arr[0];
		$month = $arr[1];
		$year = $arr[2];
		$now = date( 'd.m.Y' );
		$qEvent = mysql_query( "SELECT * FROM event WHERE `date_id`='".$iDate."' ORDER BY time ASC;" );
		if( mysql_numrows( $qEvent ) > 0 ) {
			echo '<ul>';				
				while( $rEvent = mysql_fetch_array( $qEvent ) )
					echo '<li style="background:#fff;" onclick="" onmouseover="this.style.background=\'#cfc\'; this.style.cursor=\'pointer\';" onmouseout="this.style.background=\'#fff\';">'.$rEvent[3].' - '.$rEvent[1].'</li>';
			echo '</ul>';
			echo '<a href="index.php?p=cal&addEvent=1&date='.$day.'.'.$month.'.'.$year.'">'.$m_arrTxt[10].'</a><br />';
			echo '<span style="font-family: Verdana; font-size: 8pt; font-weight: bold;">'.'Total: '.mysql_numrows( $qEvent ).'</span>';
		}
		else {
			echo '<span class="none">'.$m_arrTxt[143].'</span><br />';
			echo '<a href="index.php?p=cal&addEvent=1&date='.$day.'.'.$month.'.'.$year.'">'.$m_arrTxt[10].'</a><br />';
		}
	}
	
	// NOT OK
	function tasksByDate( $date ) {
		$techN = $_COOKIE['tech_log'];
		$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
		$rT = mysql_fetch_array( $qT );
		$lT = $rT[3];
		$m_arrTxt = getTextArray( $lT );
		$qDate = mysql_query( "SELECT * FROM date WHERE `string_date`='".$date."' LIMIT 1;" );
		$rDate = mysql_fetch_array( $qDate );
		$iDate = $rDate[0];
		$arr = explode( '.', $date );
		$day = $arr[0];
		$month = $arr[1];
		$year = $arr[2];
		$now = date( 'd.m.Y' );
		$qTasks = mysql_query( "SELECT * FROM task WHERE `date_id`='".$iDate."' ORDER BY time ASC;" );
		if( mysql_numrows( $qTasks ) > 0 ) {
			echo '<ul>';				
				while( $rTasks = mysql_fetch_array( $qTasks ) )
					echo '<li style="background:#fff;" onclick="" onmouseover="this.style.background=\'#cfc\'; this.style.cursor=\'pointer\';" onmouseout="this.style.background=\'#fff\';">'.$rTasks[3].' - '.$rTasks[1].'</li>';
			echo '</ul>';
			echo '<a href="index.php?p=cal&addTask=1&date='.$day.'.'.$month.'.'.$year.'">'.$m_arrTxt[10].'</a><br />';
			echo '<span style="font-family: Verdana; font-size: 8pt; font-weight: bold;">'.'Total: '.mysql_numrows( $qTasks ).'</span>';
		}
		else {
			echo '<span class="none">'.$m_arrTxt[143].'</span><br />';
			echo '<a href="index.php?p=cal&addTask=1&date='.$day.'.'.$month.'.'.$year.'">'.$m_arrTxt[10].'</a><br />';
		}
	}
	
	function dayBefore( $date )
	{
		$iOut = -1;
		$sOut = '00.00.0000';
		$a = explode( '.', $date );
		$d = $a[0];
		$m = $a[1];
		$y = $a[2];
		if( $d > 1 )
		{
			$iOut = $d-1;
			if( $iOut < 10 )
				$sOut = '0'.$iOut.'.'.$m.'.'.$y;
			else
				$sOut = $iOut.'.'.$m.'.'.$y;
		}
		else
		{
			// May be changing year also ..
			if( ($m-1) == 0 )
			{
				$m = 13;
				$y = $y - 1;
			}
			$iOut = daysByMonthId( $m-2 );
			$sOut = $iOut.'.'.( (($m-1)>10) ? ($m-1) : '0'.($m-1) ).'.'.$y;
		}
		return $sOut;
	}
	
	function dayAfter( $date )
	{
		$iOut = -1;
		$sOut = '00.00.0000';
		$a = explode( '.', $date );
		$d = $a[0];
		$m = $a[1];
		$y = $a[2];
		if( $d < daysByMonthId($m-1) )
		{
			$iOut = $d+1;
			if( $iOut < 10 )
				$sOut = '0'.$iOut.'.'.$m.'.'.$y;
			else
				$sOut = $iOut.'.'.$m.'.'.$y;
		}
		else
		{
			// May be changing year too
			if( ($m+1) == 13 )
			{
				$m = 0;
				$y = $y + 1;
			}
			$iOut = 1;
			$sOut = '0'.$iOut.'.'.((($m+1)>10) ? ($m+1) : '0'.($m+1) ).'.'.$y;
		}
		return $sOut;
	}
	
	function weekOf( $date )
	{
		
		$arr_out = array( '00.00.0000', '00.00.0000', '00.00.0000', '00.00.0000', '00.00.0000', '00.00.0000', '00.00.0000' );		
		$index_dateIn = dayIndex( strftime( '%a', strtotime( $date ) ) );
		$dateIn = $date;
		$t_arr = explode( '.', $dateIn );
		$rebuild_dateIn_D = $t_arr[0];
		$rebuild_dateIn_M = $t_arr[1];
		$rebuild_dateIn_Y = $t_arr[2];
		$working_date = $date;
		$aFinished = 0;
		$bFinished = 0;
		
		for( $a = $index_dateIn, $b = $index_dateIn, $done = 0; $a < 7; )
		{
			if( $bFinished != 1 )
			{
				$arr_out[$b] = $working_date;				
	//			$arr_out[$b-1] = dayBefore( $working_date );
	//			$arr_out[$b] = $working_date;
				$working_date = dayBefore( $working_date );
				
				if( $b == 0 )
				{
					$working_date = $dateIn;
					$bFinished = 1;
				}
				
				$b--;				
				$done++;
			}
			else
			{				
				$arr_out[$a] = $working_date;				
				$working_date = dayAfter( $working_date );
				$a++;
			}			
		}
		
		return $arr_out;
	}
	
	function getWeek( $in_date ) {
		$monDate = '';
		$tueDate = '';
		$wedDate = '';
		$thuDate = '';
		$friDate = '';
		$satDate = '';
		$sunDate = '';
		$weekDays = weekOf( $in_date );
		$out = "none";
		$techN = $_COOKIE['tech_log'];
		$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
		$rT = mysql_fetch_array( $qT );
		$lT = $rT[3];
		$m_arrTxt = getTextArray( $lT );
	/*
		****************
			Debug. Affichage des jours d'après index donné.
		****************		
	for( $x = 0; $x < count( $weekDays ); $x++ )
			echo $weekDays[$x].'<br />';
		echo 'Avant: '.dayBefore( date( 'd.m.Y' ) ).'<br />';
		echo 'Joue: '.date( 'd.m.Y' ).'<br />';
		echo 'Après: '.dayAfter( date( 'd.m.Y' ) ).'<br />';
	*/
		echo '<div id="headers">';
			echo '<div class="header"><span>'.$m_arrTxt[136].'</span><br /><span class="date">'.trim($weekDays[0]).'</span></div>';
			echo '<div class="header"><span>'.$m_arrTxt[137].'</span><br /><span class="date">'.trim($weekDays[1]).'</span></div>';
			echo '<div class="header"><span>'.$m_arrTxt[138].'</span><br /><span class="date">'.trim($weekDays[2]).'</span></div>';			
			echo '<div class="header"><span>'.$m_arrTxt[139].'</span><br /><span class="date">'.trim($weekDays[3]).'</span></div>';
			echo '<div class="header"><span>'.$m_arrTxt[140].'</span><br /><span class="date">'.trim($weekDays[4]).'</span></div>';
			echo '<div class="header"><span>'.$m_arrTxt[141].'</span><br /><span class="date">'.trim($weekDays[5]).'</span></div>';
			echo '<div class="header"><span>'.$m_arrTxt[142].'</span><br /><span class="date">'.trim($weekDays[6]).'</span></div>';
		echo '</div>';
		echo '<div id="hours">';
			echo '<ul>';
			for( $h = 0; $h < 24; $h++ )
			{
				echo '<li>';				
				echo '<span>';
				if( $h < 10 )
					echo '0'.$h.':00';
				else
					echo $h.':00';
				echo '</span>';
				echo '</li>';
			}
			echo '</ul>';
		echo '</div>';
		echo '<div id="grid">';
		$onGridD = 0;
		$onGridE = 0;
		$onGridM = 0;
		$onGridT = 0;
		echo '<div id="awaycurseur0" class="hide">';
		echo '1';
		echo '</div>';
		echo '<div id="meetingcurseur0" class="hide">';
		echo '0';
		echo '</div>';
		echo '<div id="eventcurseur0" class="hide">';
		echo '0';
		echo '</div>';
		echo '<div id="taskcurseur0" class="hide">';
		echo '0';
		echo '</div>';
		for( $d_w = 0; $d_w < 7; $d_w++ )
		{
			echo '<div class="day">';
				echo '<ul>';
				$at = explode( '.', $weekDays[$d_w] );
				$weekDay_D = $at[0];
				$weekDay_M = $at[1];
				$weekDay_Y = $at[2];
				for( $h = 0; $h < 24; $h++ )
				{
					if( $h > 7 && $h < 19 )
						echo '<li ondoubleclick="window.location.href=\'index.php?p=away&addAway=1&d='.$weekDay_D.'&m='.$weekDay_M.'&y='.$weekDay_Y.'&time='.$h.'\';" style="background:#fefede;">';
					else
						echo '<li>';					
						
						$qD = mysql_query( "SELECT * FROM date WHERE `string_date`='".$weekDays[$d_w]."' LIMIT 1;" );
						if( mysql_numrows( $qD ) == 1 )
						{
							$rD = mysql_fetch_array( $qD );
							$idDate = $rD[0];
							$qDepl = mysql_query( "SELECT * FROM deplacement WHERE `date_id`='".$idDate."';" );
							$qEvent = mysql_query( "SELECT * FROM event WHERE `date_id`='".$idDate."';" );
							$qMeeting = mysql_query( "SELECT * FROM meeting WHERE `date_id`='".$idDate."';" );
							$qTask = mysql_query( "SELECT * FROM task WHERE `date_id`='".$idDate."';" );
							$countForHour = 0;							
							
							/* ***********
								Affichage des déplacements
							************/
							if( mysql_numrows( $qDepl ) > 0 )
							{
								while( $rDepl = mysql_fetch_array( $qDepl ) )
								{									
									$ahD = explode( ':', $rDepl[5] );
									$hD = $ahD[0];
									$tH = ($h > 10 ) ? $h : '0'.$h;
									if( $hD == $tH)
									{
										$idDepl = $rDepl[0];
										$tId = $rDepl[7];
										$qT = mysql_query( "SELECT * FROM technicien WHERE id='".$tId."' LIMIT 1;" );
										$rT = mysql_fetch_array( $qT );
										$idT = $rT[0];
										$col = $rT[8];
										if( $countForHour < 4 )
											echo '<div id="depl-grid-'.$onGridD.'" style="border:1px solid #0f0;float:left;margin-left: 1px; margin-right: 1px;width: 10px"; class="show"><a href="index.php?p=away&id='.$idDepl.'"><div onmouseover="this.style.cursor=\'pointer\';" style="background: '.$col.';border:1px solid #fff;">&nbsp;</div></a></div>';
										$countForHour++;
										$onGridD++;
									}
								}
							}
							
							/* ***********
								Affichage des évènements
							************/
							$cntEHour = 0;							
							if( mysql_numrows( $qEvent ) > 0 )
							{
								while( $rEvent = mysql_fetch_array( $qEvent ) )
								{									
									$ahD = explode( ':', $rEvent[3] );
									$hD = $ahD[0];
									$tH = ($h > 10 ) ? $h : '0'.$h;
									if( $hD == $tH)
									{
										$idDepl = $rEvent[0];
										$tId = $rEvent[1];
										$qT = mysql_query( "SELECT * FROM technicien WHERE id='".$tId."' LIMIT 1;" );
										$rT = mysql_fetch_array( $qT );
										$idT = $rT[0];
										$col = $rT[8];
										if( $cntEHour < 4 )
											echo '<div id="event-grid-'.$onGridE.'" style="border:1px solid #00f;float:left;padding:0px;margin-left: 1px; margin-right: 1px;width: 10px"; class="hide"><a href="#"><div onmouseover="this.style.cursor=\'pointer\';" style="background: '.$col.';border:1px solid #fff;">&nbsp;</div></a></div>';
										$cntEHour++;
										$onGridE++;
									}
								}
							}
							
							/* ***********
								Affichage des rendez-vous
							************/
							$cntMHour = 0;							
							if( mysql_numrows( $qMeeting ) > 0 )
							{
								while( $rMeeting = mysql_fetch_array( $qMeeting ) )
								{									
									$ahD = explode( ':', $rMeeting[4] );
									$hD = $ahD[0];
									$tH = ($h > 10 ) ? $h : '0'.$h;
									if( $hD == $tH)
									{
										$idMeeting = $rMeeting[0];
										$tId = $rMeeting[1];
										$qT = mysql_query( "SELECT * FROM technicien WHERE id='".$tId."' LIMIT 1;" );
										$rT = mysql_fetch_array( $qT );
										$idT = $rT[0];
										$col = $rT[8];
										if( $cntMHour < 4 )
											echo '<div id="meeting-grid-'.$onGridM.'" style="border:1px solid #f00;float:left;padding:0px;margin-left: 1px; margin-right: 1px;width: 10px"; class="hide"><a href="#"><div onmouseover="this.style.cursor=\'pointer\';" style="background: '.$col.';border:1px solid #fff;">&nbsp;</div></a></div>';
										$cntMHour++;
										$onGridM++;
									}
								}
							}
							
							
							/* ***********
								Affichage des tâches
							************/
							$cntTHour = 0;							
							if( mysql_numrows( $qTask ) > 0 )
							{
								while( $rTask = mysql_fetch_array( $qTask ) )
								{									
									$ahD = explode( ':', $rTask[3] );
									$hD = $ahD[0];
									$tH = ($h > 10 ) ? $h : '0'.$h;
									if( $hD == $tH)
									{
										$idTask = $rTask[0];
										$tId = $rTask[1];
										$qT = mysql_query( "SELECT * FROM technicien WHERE id='".$tId."' LIMIT 1;" );
										$rT = mysql_fetch_array( $qT );
										$idT = $rT[0];
										$col = $rT[8];
										if( $cntTHour < 4 )
											echo '<div id="task-grid-'.$onGridT.'" style="border:1px solid #8f6004;float:left;padding:0px;margin-left: 1px; margin-right: 1px;width: 10px"; class="hide"><a href="#"><div onmouseover="this.style.cursor=\'pointer\';" style="background: '.$col.';border:1px solid #fff;">&nbsp;</div></a></div>';
										$cntTHour++;
										$onGridT++;
									}
								}
							}
							
						}/* window.location.href=\'index.php?p=away&addAway=1&d='.$weekDay_D.'&m='.$weekDay_M.'&y='.$weekDay_Y.'&time='.$h.'\';" */
						echo '<img onclick="checkAndRedirect( \''.$weekDays[$d_w].'\', \''.$h.':00\' );" onmouseover="this.style.cursor=\'pointer\';this.style.background=\'#dcdcdc\';" onmouseout="this.style.background=\'transparent\';" style="clear:both;margin-top:2px;margin-left: 1px; margin-right: 1px;" src="images/add_depl_week.png" height="16px" width="16px" border="0px" />';
					echo '</li>';
				}
				echo '</ul>';
			echo '</div>';
		}
		echo '</div>';
	}
	
	
	function getWeekOnEye( $in_date ) {
		$monDate = '';
		$tueDate = '';
		$wedDate = '';
		$thuDate = '';
		$friDate = '';
		$satDate = '';
		$sunDate = '';
		$weekDays = weekOf( $in_date );
		$out = "none";
		$techN = $_COOKIE['oneye_tech'];
		$qT = mysql_query( "SELECT * FROM technicien WHERE `nom`='".$techN."' LIMIT 1;" );
		$rT = mysql_fetch_array( $qT );
		$lT = ( $rT ) ? $rT[3] : 0;
		$idTech = ( $rT ) ? $rT[0] : 0;
		$m_arrTxt = getTextArrayOnEye( $lT );
	/*
		****************
			Debug. Affichage des jours d'après index donné.
		****************		
	for( $x = 0; $x < count( $weekDays ); $x++ )
			echo $weekDays[$x].'<br />';
		echo 'Avant: '.dayBefore( date( 'd.m.Y' ) ).'<br />';
		echo 'Joue: '.date( 'd.m.Y' ).'<br />';
		echo 'Après: '.dayAfter( date( 'd.m.Y' ) ).'<br />';
	*/
	
		echo '<div class="link" onclick="window.location.href=\'oneye.php?week='.dayBefore($weekDays[0]).'\';" onmouseover="this.style.cursor=\'pointer\';"><span>'.$m_arrTxt[156].'</span></div>';
		echo '<div align="right" onclick="window.location.href=\'oneye.php?week='.dayAfter($weekDays[6]).'\';" onmouseover="this.style.cursor=\'pointer\';"><div class="link"><span>'.$m_arrTxt[157].'</span></div></div>';
	
		// Lundi
		echo '<div class="header"><span>'.$m_arrTxt[136].'den '.trim($weekDays[0]).'</span></div>';
		echo '<div class="data">';
			$qDate = mysql_query( "SELECT * FROM date WHERE string_date='".$weekDays[0]."' LIMIT 1;" );
			if( $rDate = mysql_fetch_array( $qDate ) )
			{
				$idDate = $rDate[0];
				$qD = mysql_query( "SELECT * FROM deplacement WHERE date_id='".$idDate."' AND id_technicien='".$idTech."' ORDER BY time ASC;" );
				$qM = mysql_query( "SELECT * FROM meeting WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qE = mysql_query( "SELECT * FROM event WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qT = mysql_query( "SELECT * FROM task WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$totalDay = mysql_numrows( $qD ) + mysql_numrows( $qM ) + mysql_numrows( $qE ) + mysql_numrows( $qT );		
				
				//echo ($totalDay>0) ? $totalDay : '<span>Rien enregistré pour cette date.</span>';
				
				$arrId = array( );
				$arrType = array( );
				$cntAdded = 0;
				
				// Mise en tableau
				if( $totalDay > 0 )
				{
					if( mysql_numrows( $qD ) > 0 )
						while( $rD = mysql_fetch_array( $qD ) )
						{
							$arrId[$cntAdded] = $rD;
							$arrType[$cntAdded] = 0;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qM ) > 0 )
						while( $rM = mysql_fetch_array( $qM ) )
						{
							$arrId[$cntAdded] = $rM;
							$arrType[$cntAdded] = 1;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qE ) > 0 )
						while( $rE = mysql_fetch_array( $qE ) )
						{
							$arrId[$cntAdded] = $rE;
							$arrType[$cntAdded] = 2;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qT ) > 0 )
						while( $rT = mysql_fetch_array( $qT ) )
						{
							$arrId[$cntAdded] = $rT;
							$arrType[$cntAdded] = 3;
							$cntAdded++;
						}
					
					
					// Affichage des données du tableau						
					echo ($totalDay > 10) ? '<ul class="day" style="height: 75px;">' : '<ul class="day">';
					for( $a = 0; $a < count( $arrId ); $a++ )
					{
						switch( $arrType[$a] )
						{
							// Déplacement
							case 0:
								echo '<li class="depl" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#dbe1fb\';"><a href="oneye.php?data=2&t=0&id='.$arrId[$a][0].'">'.$arrId[$a][5].'</a></li>';
								break;
								
							// Rendez-vous
							case 1:
								echo '<li class="meeting" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#facbef\';"><a href="oneye.php?data=2&t=1&id='.$arrId[$a][0].'">'.$arrId[$a][4].'</a></li>';
								break;
								
							// Evenement
							case 2:
								echo '<li class="event" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#d6fad9\';"><a href="oneye.php?data=2&t=2&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							// Tâche
							case 3:
								echo '<li class="task" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#f6daaf\';"><a href="oneye.php?data=2&t=3&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							default: break;
						}
					}
					echo '</ul>';
					echo '<br /><a href="#">Ajouter</a>';
				}
				else
					echo '<a href="#">Ajouter</a>';
			}
			else
				echo '<a href="#">Ajouter</a>';;
		echo '</div>';
		
		// Mardi
		echo '<div class="header"><span>'.$m_arrTxt[137].'den '.trim($weekDays[1]).'</span></div>';
		echo '<div class="data">';
			$qDate = mysql_query( "SELECT * FROM date WHERE string_date='".$weekDays[1]."' LIMIT 1;" );
			if( $rDate = mysql_fetch_array( $qDate ) )
			{
				$idDate = $rDate[0];
				$qD = mysql_query( "SELECT * FROM deplacement WHERE date_id='".$idDate."' AND id_technicien='".$idTech."' ORDER BY time ASC;" );
				$qM = mysql_query( "SELECT * FROM meeting WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qE = mysql_query( "SELECT * FROM event WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qT = mysql_query( "SELECT * FROM task WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$totalDay = mysql_numrows( $qD ) + mysql_numrows( $qM ) + mysql_numrows( $qE ) + mysql_numrows( $qT );		
				
				//echo ($totalDay>0) ? $totalDay : '<span>Rien enregistré pour cette date.</span>';
				
				$arrId = array( );
				$arrType = array( );
				$cntAdded = 0;
				
				// Mise en tableau
				if( $totalDay > 0 )
				{
					if( mysql_numrows( $qD ) > 0 )
						while( $rD = mysql_fetch_array( $qD ) )
						{
							$arrId[$cntAdded] = $rD;
							$arrType[$cntAdded] = 0;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qM ) > 0 )
						while( $rM = mysql_fetch_array( $qM ) )
						{
							$arrId[$cntAdded] = $rM;
							$arrType[$cntAdded] = 1;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qE ) > 0 )
						while( $rE = mysql_fetch_array( $qE ) )
						{
							$arrId[$cntAdded] = $rE;
							$arrType[$cntAdded] = 2;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qT ) > 0 )
						while( $rT = mysql_fetch_array( $qT ) )
						{
							$arrId[$cntAdded] = $rT;
							$arrType[$cntAdded] = 3;
							$cntAdded++;
						}
					
					
					// Affichage des données du tableau						
					echo ($totalDay > 10) ? '<ul class="day" style="height: 75px;">' : '<ul class="day">';
					for( $a = 0; $a < count( $arrId ); $a++ )
					{
						switch( $arrType[$a] )
						{
							// Déplacement
							case 0:
								echo '<li class="depl" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#dbe1fb\';"><a href="oneye.php?data=2&t=0&id='.$arrId[$a][0].'">'.$arrId[$a][5].'</a></li>';
								break;
								
							// Rendez-vous
							case 1:
								echo '<li class="meeting" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#facbef\';"><a href="oneye.php?data=2&t=1&id='.$arrId[$a][0].'">'.$arrId[$a][4].'</a></li>';
								break;
								
							// Evenement
							case 2:
								echo '<li class="event" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#d6fad9\';"><a href="oneye.php?data=2&t=2&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							// Tâche
							case 3:
								echo '<li class="task" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#f6daaf\';"><a href="oneye.php?data=2&t=3&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							default: break;
						}
					}
					echo '</ul>';
				}
				else
					echo '<span>Rien enregistré pour cette date.</span>';
			}
			else
				echo '<span>Rien enregistré pour cette date.</span>';
		echo '</div>';
		
		// Mercredi
		echo '<div class="header"><span>'.$m_arrTxt[138].'den '.trim($weekDays[2]).'</span></div>';			
		echo '<div class="data">';
			$qDate = mysql_query( "SELECT * FROM date WHERE string_date='".$weekDays[2]."' LIMIT 1;" );
			if( $rDate = mysql_fetch_array( $qDate ) )
			{
				$idDate = $rDate[0];
				$qD = mysql_query( "SELECT * FROM deplacement WHERE date_id='".$idDate."' AND id_technicien='".$idTech."' ORDER BY time ASC;" );
				$qM = mysql_query( "SELECT * FROM meeting WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qE = mysql_query( "SELECT * FROM event WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qT = mysql_query( "SELECT * FROM task WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$totalDay = mysql_numrows( $qD ) + mysql_numrows( $qM ) + mysql_numrows( $qE ) + mysql_numrows( $qT );		
				
				//echo ($totalDay>0) ? $totalDay : '<span>Rien enregistré pour cette date.</span>';
				
				$arrId = array( );
				$arrType = array( );
				$cntAdded = 0;
				
				// Mise en tableau
				if( $totalDay > 0 )
				{
					if( mysql_numrows( $qD ) > 0 )
						while( $rD = mysql_fetch_array( $qD ) )
						{
							$arrId[$cntAdded] = $rD;
							$arrType[$cntAdded] = 0;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qM ) > 0 )
						while( $rM = mysql_fetch_array( $qM ) )
						{
							$arrId[$cntAdded] = $rM;
							$arrType[$cntAdded] = 1;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qE ) > 0 )
						while( $rE = mysql_fetch_array( $qE ) )
						{
							$arrId[$cntAdded] = $rE;
							$arrType[$cntAdded] = 2;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qT ) > 0 )
						while( $rT = mysql_fetch_array( $qT ) )
						{
							$arrId[$cntAdded] = $rT;
							$arrType[$cntAdded] = 3;
							$cntAdded++;
						}
					
					
					// Affichage des données du tableau						
					echo ($totalDay > 10) ? '<ul class="day" style="height: 75px;">' : '<ul class="day">';
					for( $a = 0; $a < count( $arrId ); $a++ )
					{
						switch( $arrType[$a] )
						{
							// Déplacement
							case 0:
								echo '<li class="depl" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#dbe1fb\';"><a href="oneye.php?data=2&t=0&id='.$arrId[$a][0].'">'.$arrId[$a][5].'</a></li>';
								break;
								
							// Rendez-vous
							case 1:
								echo '<li class="meeting" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#facbef\';"><a href="oneye.php?data=2&t=1&id='.$arrId[$a][0].'">'.$arrId[$a][4].'</a></li>';
								break;
								
							// Evenement
							case 2:
								echo '<li class="event" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#d6fad9\';"><a href="oneye.php?data=2&t=2&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							// Tâche
							case 3:
								echo '<li class="task" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#f6daaf\';"><a href="oneye.php?data=2&t=3&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							default: break;
						}
					}
					echo '</ul>';
				}
				else
					echo '<span>Rien enregistré pour cette date.</span>';
			}
			else
				echo '<span>Rien enregistré pour cette date.</span>';
		echo '</div>';
		
		// Jeudi
		echo '<div class="header"><span>'.$m_arrTxt[139].'den '.trim($weekDays[3]).'</span></div>';
		echo '<div class="data">';
			$qDate = mysql_query( "SELECT * FROM date WHERE string_date='".$weekDays[3]."' LIMIT 1;" );
			if( $rDate = mysql_fetch_array( $qDate ) )
			{
				$idDate = $rDate[0];
				$qD = mysql_query( "SELECT * FROM deplacement WHERE date_id='".$idDate."' AND id_technicien='".$idTech."' ORDER BY time ASC;" );
				$qM = mysql_query( "SELECT * FROM meeting WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qE = mysql_query( "SELECT * FROM event WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qT = mysql_query( "SELECT * FROM task WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$totalDay = mysql_numrows( $qD ) + mysql_numrows( $qM ) + mysql_numrows( $qE ) + mysql_numrows( $qT );		
				
				//echo ($totalDay>0) ? $totalDay : '<span>Rien enregistré pour cette date.</span>';
				
				$arrId = array( );
				$arrType = array( );
				$cntAdded = 0;
				
				// Mise en tableau
				if( $totalDay > 0 )
				{
					if( mysql_numrows( $qD ) > 0 )
						while( $rD = mysql_fetch_array( $qD ) )
						{
							$arrId[$cntAdded] = $rD;
							$arrType[$cntAdded] = 0;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qM ) > 0 )
						while( $rM = mysql_fetch_array( $qM ) )
						{
							$arrId[$cntAdded] = $rM;
							$arrType[$cntAdded] = 1;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qE ) > 0 )
						while( $rE = mysql_fetch_array( $qE ) )
						{
							$arrId[$cntAdded] = $rE;
							$arrType[$cntAdded] = 2;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qT ) > 0 )
						while( $rT = mysql_fetch_array( $qT ) )
						{
							$arrId[$cntAdded] = $rT;
							$arrType[$cntAdded] = 3;
							$cntAdded++;
						}
					
					
					// Affichage des données du tableau						
					echo ($totalDay > 10) ? '<ul class="day" style="height: 75px;">' : '<ul class="day">';
					for( $a = 0; $a < count( $arrId ); $a++ )
					{
						switch( $arrType[$a] )
						{
							// Déplacement
							case 0:
								echo '<li class="depl" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#dbe1fb\';"><a href="oneye.php?data=2&t=0&id='.$arrId[$a][0].'">'.$arrId[$a][5].'</a></li>';
								break;
								
							// Rendez-vous
							case 1:
								echo '<li class="meeting" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#facbef\';"><a href="oneye.php?data=2&t=1&id='.$arrId[$a][0].'">'.$arrId[$a][4].'</a></li>';
								break;
								
							// Evenement
							case 2:
								echo '<li class="event" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#d6fad9\';"><a href="oneye.php?data=2&t=2&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							// Tâche
							case 3:
								echo '<li class="task" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#f6daaf\';"><a href="oneye.php?data=2&t=3&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							default: break;
						}
					}
					echo '</ul>';
				}
				else
					echo '<span>Rien enregistré pour cette date.</span>';
			}
			else
				echo '<span>Rien enregistré pour cette date.</span>';
		echo '</div>';
		
		// Vendredi
		echo '<div class="header"><span>'.$m_arrTxt[140].'den '.trim($weekDays[4]).'</span></div>';
		echo '<div class="data">';
			$qDate = mysql_query( "SELECT * FROM date WHERE string_date='".$weekDays[4]."' LIMIT 1;" );
			if( $rDate = mysql_fetch_array( $qDate ) )
			{
				$idDate = $rDate[0];
				$qD = mysql_query( "SELECT * FROM deplacement WHERE date_id='".$idDate."' AND id_technicien='".$idTech."' ORDER BY time ASC;" );
				$qM = mysql_query( "SELECT * FROM meeting WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qE = mysql_query( "SELECT * FROM event WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qT = mysql_query( "SELECT * FROM task WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$totalDay = mysql_numrows( $qD ) + mysql_numrows( $qM ) + mysql_numrows( $qE ) + mysql_numrows( $qT );		
				
				//echo ($totalDay>0) ? $totalDay : '<span>Rien enregistré pour cette date.</span>';
				
				$arrId = array( );
				$arrType = array( );
				$cntAdded = 0;
				
				// Mise en tableau
				if( $totalDay > 0 )
				{
					if( mysql_numrows( $qD ) > 0 )
						while( $rD = mysql_fetch_array( $qD ) )
						{
							$arrId[$cntAdded] = $rD;
							$arrType[$cntAdded] = 0;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qM ) > 0 )
						while( $rM = mysql_fetch_array( $qM ) )
						{
							$arrId[$cntAdded] = $rM;
							$arrType[$cntAdded] = 1;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qE ) > 0 )
						while( $rE = mysql_fetch_array( $qE ) )
						{
							$arrId[$cntAdded] = $rE;
							$arrType[$cntAdded] = 2;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qT ) > 0 )
						while( $rT = mysql_fetch_array( $qT ) )
						{
							$arrId[$cntAdded] = $rT;
							$arrType[$cntAdded] = 3;
							$cntAdded++;
						}
					
					
					// Affichage des données du tableau						
					echo ($totalDay > 10) ? '<ul class="day" style="height: 75px;">' : '<ul class="day">';
					for( $a = 0; $a < count( $arrId ); $a++ )
					{
						switch( $arrType[$a] )
						{
							// Déplacement
							case 0:
								echo '<li class="depl" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#dbe1fb\';"><a href="oneye.php?data=2&t=0&id='.$arrId[$a][0].'">'.$arrId[$a][5].'</a></li>';
								break;
								
							// Rendez-vous
							case 1:
								echo '<li class="meeting" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#facbef\';"><a href="oneye.php?data=2&t=1&id='.$arrId[$a][0].'">'.$arrId[$a][4].'</a></li>';
								break;
								
							// Evenement
							case 2:
								echo '<li class="event" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#d6fad9\';"><a href="oneye.php?data=2&t=2&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							// Tâche
							case 3:
								echo '<li class="task" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#f6daaf\';"><a href="oneye.php?data=2&t=3&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							default: break;
						}
					}
					echo '</ul>';
				}
				else
					echo '<span>Rien enregistré pour cette date.</span>';
			}
			else
				echo '<span>Rien enregistré pour cette date.</span>';
		echo '</div>';
		
		// Samedi
		echo '<div class="header"><span>'.$m_arrTxt[141].'den '.trim($weekDays[5]).'</span></div>';
		echo '<div class="data">';
			$qDate = mysql_query( "SELECT * FROM date WHERE string_date='".$weekDays[5]."' LIMIT 1;" );
			if( $rDate = mysql_fetch_array( $qDate ) )
			{
				$idDate = $rDate[0];
				$qD = mysql_query( "SELECT * FROM deplacement WHERE date_id='".$idDate."' AND id_technicien='".$idTech."' ORDER BY time ASC;" );
				$qM = mysql_query( "SELECT * FROM meeting WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qE = mysql_query( "SELECT * FROM event WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qT = mysql_query( "SELECT * FROM task WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$totalDay = mysql_numrows( $qD ) + mysql_numrows( $qM ) + mysql_numrows( $qE ) + mysql_numrows( $qT );		
				
				//echo ($totalDay>0) ? $totalDay : '<span>Rien enregistré pour cette date.</span>';
				
				$arrId = array( );
				$arrType = array( );
				$cntAdded = 0;
				
				// Mise en tableau
				if( $totalDay > 0 )
				{
					if( mysql_numrows( $qD ) > 0 )
						while( $rD = mysql_fetch_array( $qD ) )
						{
							$arrId[$cntAdded] = $rD;
							$arrType[$cntAdded] = 0;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qM ) > 0 )
						while( $rM = mysql_fetch_array( $qM ) )
						{
							$arrId[$cntAdded] = $rM;
							$arrType[$cntAdded] = 1;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qE ) > 0 )
						while( $rE = mysql_fetch_array( $qE ) )
						{
							$arrId[$cntAdded] = $rE;
							$arrType[$cntAdded] = 2;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qT ) > 0 )
						while( $rT = mysql_fetch_array( $qT ) )
						{
							$arrId[$cntAdded] = $rT;
							$arrType[$cntAdded] = 3;
							$cntAdded++;
						}
					
					
					// Affichage des données du tableau						
					echo ($totalDay > 10) ? '<ul class="day" style="height: 75px;">' : '<ul class="day">';
					for( $a = 0; $a < count( $arrId ); $a++ )
					{
						switch( $arrType[$a] )
						{
							// Déplacement
							case 0:
								echo '<li class="depl" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#dbe1fb\';"><a href="oneye.php?data=2&t=0&id='.$arrId[$a][0].'">'.$arrId[$a][5].'</a></li>';
								break;
								
							// Rendez-vous
							case 1:
								echo '<li class="meeting" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#facbef\';"><a href="oneye.php?data=2&t=1&id='.$arrId[$a][0].'">'.$arrId[$a][4].'</a></li>';
								break;
								
							// Evenement
							case 2:
								echo '<li class="event" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#d6fad9\';"><a href="oneye.php?data=2&t=2&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							// Tâche
							case 3:
								echo '<li class="task" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#f6daaf\';"><a href="oneye.php?data=2&t=3&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							default: break;
						}
					}
					echo '</ul>';
				}
				else
					echo '<span>Rien enregistré pour cette date.</span>';
			}
			else
				echo '<span>Rien enregistré pour cette date.</span>';
		echo '</div>';
		
		// Dimanche
		echo '<div class="header"><span>'.$m_arrTxt[142].'den '.trim($weekDays[6]).'</span></div>';
		echo '<div class="data">';
			$qDate = mysql_query( "SELECT * FROM date WHERE string_date='".$weekDays[6]."' LIMIT 1;" );
			if( $rDate = mysql_fetch_array( $qDate ) )
			{
				$idDate = $rDate[0];
				$qD = mysql_query( "SELECT * FROM deplacement WHERE date_id='".$idDate."' AND id_technicien='".$idTech."' ORDER BY time ASC;" );
				$qM = mysql_query( "SELECT * FROM meeting WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qE = mysql_query( "SELECT * FROM event WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$qT = mysql_query( "SELECT * FROM task WHERE date_id='".$idDate."' AND technicien_id='".$idTech."' ORDER BY time ASC;" );
				$totalDay = mysql_numrows( $qD ) + mysql_numrows( $qM ) + mysql_numrows( $qE ) + mysql_numrows( $qT );		
				
				//echo ($totalDay>0) ? $totalDay : '<span>Rien enregistré pour cette date.</span>';
				
				$arrId = array( );
				$arrType = array( );
				$cntAdded = 0;
				
				// Mise en tableau
				if( $totalDay > 0 )
				{
					if( mysql_numrows( $qD ) > 0 )
						while( $rD = mysql_fetch_array( $qD ) )
						{
							$arrId[$cntAdded] = $rD;
							$arrType[$cntAdded] = 0;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qM ) > 0 )
						while( $rM = mysql_fetch_array( $qM ) )
						{
							$arrId[$cntAdded] = $rM;
							$arrType[$cntAdded] = 1;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qE ) > 0 )
						while( $rE = mysql_fetch_array( $qE ) )
						{
							$arrId[$cntAdded] = $rE;
							$arrType[$cntAdded] = 2;
							$cntAdded++;
						}
						
					if( mysql_numrows( $qT ) > 0 )
						while( $rT = mysql_fetch_array( $qT ) )
						{
							$arrId[$cntAdded] = $rT;
							$arrType[$cntAdded] = 3;
							$cntAdded++;
						}
					
					
					// Affichage des données du tableau						
					echo ($totalDay > 10) ? '<ul class="day" style="height: 75px;">' : '<ul class="day">';
					for( $a = 0; $a < count( $arrId ); $a++ )
					{
						switch( $arrType[$a] )
						{
							// Déplacement
							case 0:
								echo '<li class="depl" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#dbe1fb\';"><a href="oneye.php?data=2&t=0&id='.$arrId[$a][0].'">'.$arrId[$a][5].'</a></li>';
								break;
								
							// Rendez-vous
							case 1:
								echo '<li class="meeting" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#facbef\';"><a href="oneye.php?data=2&t=1&id='.$arrId[$a][0].'">'.$arrId[$a][4].'</a></li>';
								break;
								
							// Evenement
							case 2:
								echo '<li class="event" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#d6fad9\';"><a href="oneye.php?data=2&t=2&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							// Tâche
							case 3:
								echo '<li class="task" onmouseover="this.style.background=\'#fcf5d6\';" onmouseout="this.style.background=\'#f6daaf\';"><a href="oneye.php?data=2&t=3&id='.$arrId[$a][0].'">'.$arrId[$a][3].'</a></li>';
								break;
								
							default: break;
						}
					}
					echo '</ul>';
				}
				else
					echo '<span>Rien enregistré pour cette date.</span>';
			}
			else
				echo '<span>Rien enregistré pour cette date.</span>';
		echo '</div>';
		
/*		echo '<div id="hours">';
			echo '<ul>';
			for( $h = 0; $h < 24; $h++ )
			{
				echo '<li>';				
				echo '<span>';
				if( $h < 10 )
					echo '0'.$h.':00';
				else
					echo $h.':00';
				echo '</span>';
				echo '</li>';
			}
			echo '</ul>';
		echo '</div>';*/
	}

	
	function dayIndex( $str ) {
		if( $str == 'Mon' )
			return 0;
		if( $str == 'Tue' )
			return 1;
		if( $str == 'Wed' )
			return 2;
		if( $str == 'Thu' )
			return 3;
		if( $str == 'Fri' )
			return 4;
		if( $str == 'Sat' )
			return 5;
		if( $str == 'Sun' )
			return 6;
	}
	
	function revertDayIndex( $id ) {
		switch( $id )
		{
			case 0:
				return 'Lundi';
				break;
				
			case 1:
				return 'Mardi';
				break;
				
			case 2:
				return 'Mercredi';
				break;
				
			case 3:
				return 'Jeudi';	
				break;
				
			case 4:
				return 'Vendredi';
				break;
				
			case 5:
				return 'Samedi';
				break;
				
			case 6:
				return 'Dimanche';
				break;
				
			default:
				return 'Erreur';
				break;
		}
	}
	
	function firstWeekOf( $m, $y ) {		
		$iDayOne = dayIndex(strftime( '%a', strtotime( ($m+1).'/1/'.$y ) ));
//		$iDayEnd = dayIndex(strftime( '%a', strtotime( ($m+1).'/'.daysByMonthID( $m ).'/'.$y ) ) );
		$fromNow = 0;

		for( $i = 0, $x = 1; $i < 7; $i++ ) {
			//echo '<div class="day" onmouseover="this.style.background=\'#fff\';" onmouseout="this.style.background=\'#ffc\';">';				
				if( $i == $iDayOne || $fromNow == 1 ) {
			//		echo '<span>'.'Journée chargée ;]<br />Jour: '.$x.'</span>';
				echo '<div class="day" onmouseover="this.style.background=\'#fff\';" onmouseout="this.style.background=\'#ffc\';">';				
				echo '<h3>'.$x.'</h3>';
					$day = ''.$x;
					$month = ''.($m+1);
					if( $x < 10 )
						$day = '0'.$x;
					if( $m < 10 )
						$month = '0'.$month;
					echo '<div style="border:0px; background: transparent;" id="awaybox-'.$x.'" class="show">';
						awayByDate( $day.'.'.$month.'.'.$y );
					echo '</div>';
					echo '<div style="border:0px solid #000; background: transparent;" id="meetingbox-'.$x.'" class="hide">';
						meetingsByDate( $day.'.'.$month.'.'.$y );
					echo '</div>';
					echo '<div style="border:0px solid #000; background: transparent;" id="eventbox-'.$x.'" class="hide">';
						eventsByDate( $day.'.'.$month.'.'.$y );
					echo '</div>';
					echo '<div style="border:0px solid #000; background: transparent;" id="taskbox-'.$x.'" class="hide">';
						tasksByDate( $day.'.'.$month.'.'.$y );
					echo '</div>';
				//	meetingsByDate( $day.'.'.$month.'.'.$y );
				//	eventsByDate( $day.'.'.$month.'.'.$y );
				//	tasksByDate( $day.'.'.$month.'.'.$y );
					$fromNow = 1;
					$x++;
					echo '</div>';
				}
				else  {
					echo '<div class="day" style="background: #fcc;">';				
						echo '<span>'.'N/A.'.'</span>';
					echo '</div>';
				}
			
		}
		
		return 0;
	}
	
	function sndWeekOf( $m, $y ) {
		$iDayOne = dayIndex(strftime( '%a', strtotime( ($m+1).'/1/'.$y ) ));
//		$iDayEnd = dayIndex(strftime( '%a', strtotime( ($m+1).'/'.daysByMonthID( $m ).'/'.$y ) ) );
		$fromNow = 0;
		
		$x = 1;
		// incrémente $x, pour continuer avec le prochain jour ..
		for( $i = 0; $i < 7; $i++ ) {
			if( $i == $iDayOne || $fromNow == 1 ) {
				$fromNow = 1;
				$x++;
			}
		}
				
		for( $j = 0; $j < 7; $j++, $x++ ){
			echo '<div class="day" onmouseover="this.style.background=\'#fff\';" onmouseout="this.style.background=\'#ffc\';">';
			echo '<h3>'.$x.'</h3>';
			$day = ''.$x;
			$month = ''.($m+1);
			if( $x < 10 )
				$day = '0'.$x;
			if( $m < 10 )
				$month = '0'.$month;
				echo '<div style="border:0px; background: transparent;" id="awaybox-'.$x.'" class="show">';
					awayByDate( $day.'.'.$month.'.'.$y );
				echo '</div>';
				echo '<div style="border:0px solid #000; background: transparent;" id="meetingbox-'.$x.'" class="hide">';
					meetingsByDate( $day.'.'.$month.'.'.$y );
				echo '</div>';
				echo '<div style="border:0px solid #000; background: transparent;" id="eventbox-'.$x.'" class="hide">';
						eventsByDate( $day.'.'.$month.'.'.$y );
					echo '</div>';
					echo '<div style="border:0px solid #000; background: transparent;" id="taskbox-'.$x.'" class="hide">';
						tasksByDate( $day.'.'.$month.'.'.$y );
					echo '</div>';
			echo '</div>';
		}			
		
		return 0;
	}
	
	function trdWeekOf( $m, $y ) {
		$iDayOne = dayIndex(strftime( '%a', strtotime( ($m+1).'/1/'.$y ) ));
//		$iDayEnd = dayIndex(strftime( '%a', strtotime( ($m+1).'/'.daysByMonthID( $m ).'/'.$y ) ) );
		$fromNow = 0;
		
		$x = 1;
		// incrémente $x, pour continuer avec le prochain jour ..
		for( $i = 0; $i < 7; $i++ ) {
			if( $i == $iDayOne || $fromNow == 1 ) {
				$fromNow = 1;
				$x++;
			}
		}
				
		for( $j = 0; $j < 7; $j++,$x++ )
			;
			
		for( $k = 0; $k < 7; $k++, $x++ ) {
			echo '<div class="day" onmouseover="this.style.background=\'#fff\';" onmouseout="this.style.background=\'#ffc\';">';
			echo '<h3>'.$x.'</h3>';	
			$day = ''.$x;
			$month = ''.($m+1);
			if( $x < 10 )
				$day = '0'.$x;
			if( $m < 10 )
				$month = '0'.$month;
			echo '<div style="border:0px solid #000; background: transparent;" id="awaybox-'.$x.'" class="show">';
				awayByDate( $day.'.'.$month.'.'.$y );
			echo '</div>';
			echo '<div style="border:0px solid #000; background: transparent;" id="meetingbox-'.$x.'" class="hide">';
				meetingsByDate( $day.'.'.$month.'.'.$y );
			echo '</div>';
			echo '<div style="border:0px solid #000; background: transparent;" id="eventbox-'.$x.'" class="hide">';
						eventsByDate( $day.'.'.$month.'.'.$y );
					echo '</div>';
					echo '<div style="border:0px solid #000; background: transparent;" id="taskbox-'.$x.'" class="hide">';
						tasksByDate( $day.'.'.$month.'.'.$y );
					echo '</div>';
		//	meetingsByDate( $day.'.'.$month.'.'.$y );
			echo '</div>';		
		}	
	}
	
	function fthWeekOf( $m, $y ) {
		$iDayOne = dayIndex(strftime( '%a', strtotime( ($m+1).'/1/'.$y ) ));
//		$iDayEnd = dayIndex(strftime( '%a', strtotime( ($m+1).'/'.daysByMonthID( $m ).'/'.$y ) ) );
		$fromNow = 0;
		
		$x = 1;
		// incrémente $x, pour continuer avec le prochain jour ..
		for( $i = 0; $i < 7; $i++ ) {
			if( $i == $iDayOne || $fromNow == 1 ) {
				$fromNow = 1;
				$x++;
			}
		}
				
		for( $j = 0; $j < 14; $j++,$x++ )
			;
			
		for( $k = 0; $k < 7; $k++, $x++ ) {
			echo '<div class="day" onmouseover="this.style.background=\'#fff\';" onmouseout="this.style.background=\'#ffc\';">';
				echo '<h3>'.$x.'</h3>';
			$day = ''.$x;
			$month = ''.($m+1);
			if( $x < 10 )
				$day = '0'.$x;
			if( $m < 10 )
				$month = '0'.$month;
			echo '<div style="border:0px; background: transparent;" id="awaybox-'.$x.'" class="show">';
				awayByDate( $day.'.'.$month.'.'.$y );			
			echo '</div>';
			echo '<div style="border:0px solid #000; background: transparent;" id="meetingbox-'.$x.'" class="hide">';
				meetingsByDate( $day.'.'.$month.'.'.$y );
			echo '</div>';
			echo '<div style="border:0px solid #000; background: transparent;" id="eventbox-'.$x.'" class="hide">';
						eventsByDate( $day.'.'.$month.'.'.$y );
					echo '</div>';
					echo '<div style="border:0px solid #000; background: transparent;" id="taskbox-'.$x.'" class="hide">';
						tasksByDate( $day.'.'.$month.'.'.$y );
					echo '</div>';
			echo '</div>';
		}	
		
	}
	
	function fifthWeekOf( $m, $y ) {
		$iDayOne = dayIndex(strftime( '%a', strtotime( ($m+1).'/1/'.$y ) ));
//		$iDayEnd = dayIndex(strftime( '%a', strtotime( ($m+1).'/'.daysByMonthID( $m ).'/'.$y ) ) );
		$fromNow = 0;
		
		$x = 1;
		// incrémente $x, pour continuer avec le prochain jour ..
		for( $i = 0; $i < 7; $i++ ) {
			if( $i == $iDayOne || $fromNow == 1 ) {
				$fromNow = 1;
				$x++;
			}
		}
				
		for( $j = 0; $j < 21; $j++,$x++ )
			;
			
		$stopHere = 0;
			
		for( $k = 0; $k < 7; $k++, $x++ ) {	
			echo '<div class="day" onmouseover="this.style.background=\'#fff\';" onmouseout="this.style.background=\'#ffc\';">';
				
				if( $x > daysByMonthID( $m ) || $stopHere == 1 ) {
					$stopHere = 1;
					echo '<div class="day" style="background: #fcc;">';				
						echo '<span>'.'N/A.'.'</span>';
					echo '</div>';				
				} else {
					echo '<h3>'.$x.'</h3>';	
					$day = ''.$x;
					$month = ''.($m+1);
					if( $x < 10 )
						$day = '0'.$x;
					if( $m < 10 )
						$month = '0'.$month;
						echo '<div style="border:0px; background: transparent;" id="awaybox-'.$x.'" class="show">';
							awayByDate( $day.'.'.$month.'.'.$y );
						echo '</div>';
						echo '<div style="border:0px solid #000; background: transparent;" id="meetingbox-'.$x.'" class="hide">';
						meetingsByDate( $day.'.'.$month.'.'.$y );
						echo '</div>';
						echo '<div style="border:0px solid #000; background: transparent;" id="eventbox-'.$x.'" class="hide">';
						eventsByDate( $day.'.'.$month.'.'.$y );
					echo '</div>';
					echo '<div style="border:0px solid #000; background: transparent;" id="taskbox-'.$x.'" class="hide">';
						tasksByDate( $day.'.'.$month.'.'.$y );
					echo '</div>';
				}
			echo '</div>';
		}
	}
	
	function sixthWeekOf( $m, $y ) {
		$iDayOne = dayIndex(strftime( '%a', strtotime( ($m+1).'/1/'.$y ) ));
//		$iDayEnd = dayIndex(strftime( '%a', strtotime( ($m+1).'/'.daysByMonthID( $m ).'/'.$y ) ) );
		$fromNow = 0;
		
		$x = 1;
		// incrémente $x, pour continuer avec le prochain jour ..
		for( $i = 0; $i < 7; $i++ ) {
			if( $i == $iDayOne || $fromNow == 1 ) {
				$fromNow = 1;
				$x++;
			}
		}
				
		for( $j = 0; $j < 21; $j++,$x++ )
			;
			
		$stopHere = 0;
			
		for( $k = 0; $k < 7; $k++, $x++ ) {	
			;
		}
		
		if( $x <= daysByMonthID( $m ) ) {
			$stopHere = 0;
			for( $l = 0; $l < 7; $l++, $x++ ) {
				
					
				if( $x > daysByMonthID( $m ) || $stopHere == 1 ) {
					$stopHere = 1;
					echo '<div class="day" style="background: #fcc;">';				
						echo '<span>'.'N/A.'.'</span>';
					echo '</div>';
				} else {
				//	echo '<span>'.'Journée chargée ;]<br />Jour: '.$x.'</span>';		
					echo '<div class="day" onmouseover="this.style.background=\'#fff\';" onmouseout="this.style.background=\'#ffc\';">';		
					echo '<h3>'.$x.'</h3>';
					$day = ''.$x;
					$month = ''.($m+1);
					if( $x < 10 )
						$day = '0'.$x;
					if( $m < 10 )
						$month = '0'.$month;
						
						echo '<div style="border:0px; background: transparent;" id="awaybox-'.$x.'" class="show">';
							awayByDate( $day.'.'.$month.'.'.$y );
						echo '</div>';
						echo '<div style="border:0px solid #000; background: transparent;" id="meetingbox-'.$x.'" class="hide">';
							meetingsByDate( $day.'.'.$month.'.'.$y );
						echo '</div>';
						echo '<div style="border:0px solid #000; background: transparent;" id="eventbox-'.$x.'" class="hide">';
							eventsByDate( $day.'.'.$month.'.'.$y );
						echo '</div>';
						echo '<div style="border:0px solid #000; background: transparent;" id="taskbox-'.$x.'" class="hide">';
							tasksByDate( $day.'.'.$month.'.'.$y );
						echo '</div>';
					echo '</div>';					
				}
				
			}
		}
	}
	
	function hasFifthWeek( $m, $y ) {
		$bOut = false;
		
		$iDayOne = dayIndex(strftime( '%a', strtotime( ($m+1).'/1/'.$y ) ));
//		$iDayEnd = dayIndex(strftime( '%a', strtotime( ($m+1).'/'.daysByMonthID( $m ).'/'.$y ) ) );
		$fromNow = 0;
		
		$x = 1;
		// incrémente $x, pour continuer avec le prochain jour ..
		for( $i = 0; $i < 7; $i++ ) {
			if( $i == $iDayOne || $fromNow == 1 ) {
				$fromNow = 1;
				$x++;
			}
		}
				
		for( $j = 0; $j < 21; $j++,$x++ )
			;
			
		if( $x <= daysByMonthID( $m ) ) 
			$bOut = true;
		else
			$bOut = false;
		
		return $bOut;
	}
	
	function hasSixthWeek( $m, $y ) {
		$bOut = false;
		
		$iDayOne = dayIndex(strftime( '%a', strtotime( ($m+1).'/1/'.$y ) ));
//		$iDayEnd = dayIndex(strftime( '%a', strtotime( ($m+1).'/'.daysByMonthID( $m ).'/'.$y ) ) );
		$fromNow = 0;
		
		$x = 1;
		// incrémente $x, pour continuer avec le prochain jour ..
		for( $i = 0; $i < 7; $i++ ) {
			if( $i == $iDayOne || $fromNow == 1 ) {
				$fromNow = 1;
				$x++;
			}
		}
				
		for( $j = 0; $j < 28; $j++,$x++ )
			;
			
		if( $x <= daysByMonthID( $m ) ) 
			$bOut = true;
		else
			$bOut = false;
		
		return $bOut;
	}
	
	function findInArr( $find, $arrSrc ) {
		$bFlag = 0;
		if( count($arrSrc) == 0 || $find == NULL )
			return $bFlag;
		for( $x = 0; $x < count( $arrSrc ); $x++ )
			if( $arrSrc[$x] == $find )
				$bFlag = 1;
		
		return $bFlag;
	}
	
	function _reverseSort_laterDate( $arrDates ) {
		$bFlag = 0;
		$outArrDates = $arrDates;
		for( $x = 0; $x < count( $outArrDates ) && $bFlag == 0; $x++ ) 
		{
			if( $x < count( $outArrDates ) - 1 )
			{
				if( !isLaterThan( $outArrDates[$x], $outArrDates[$x+1] ) )
				{
					$swap = $outArrDates[$x+1];
					$outArrDates[$x+1] = $outArrDates[$x];
					$outArrDates[$x] = $swap;
					$bFlag = 1;
					break;
				}
			}
			else {
				if( !isLaterThan( $outArrDates[$x-1], $outArrDates[$x] ) )
				{
					$swap = $outArrDates[$x-1];
					$outArrDates[$x-1] = $outArrDates[$x];
					$outArrDates[$x] = $swap;
					$bFlag = 1;
					break;
				}				
			}
		}
		
			// Met en place la récursivité. Le tableau est uniquement propre
			// Si jamais le Flag n'est modifié.
		return ($bFlag == 0) ? ($outArrDates) : (_reverseSort_laterDate( $outArrDates ));
	}
	
	function sort_laterDate( $arrDates ) {
		$bFlag = 0;
		$outArrDates = $arrDates;
		if( count( $arrDates ) > 1 )
		{
			for( $x = 0; $x < count( $outArrDates ) && $bFlag == 0; $x++ ) 
			{
				if( $x < count( $outArrDates ) - 1 )
				{
					if( isLaterThan( $outArrDates[$x], $outArrDates[$x+1] ) )
					{
						$swap = $outArrDates[$x+1];
						$outArrDates[$x+1] = $outArrDates[$x];
						$outArrDates[$x] = $swap;
						$bFlag = 1;
						break;
					}
				}
				else {
					if( isLaterThan( $outArrDates[$x-1], $outArrDates[$x] ) )
					{
						$swap = $outArrDates[$x-1];
						$outArrDates[$x-1] = $outArrDates[$x];
						$outArrDates[$x] = $swap;
						$bFlag = 1;
						break;
					}				
				}
			}
		}
		else
			return $outArrDates;
			
			// Met en place la récursivité. Le tableau est uniquement propre
			// Si jamais le Flag n'est modifié.
		return ($bFlag == 0) ? ($outArrDates) : (sort_laterDate( $outArrDates ));
	}
	
	function sort_biggerTop( $arrNum ) {
		$bFlag = 0;
		$outArrNum = $arrNum;
		if( count( $arrNum ) > 1 )
		{
			for( $x = 0; $x < count( $outArrNum ) && $bFlag == 0; $x++ ) 
			{
				if( $x < count( $outArrNum ) - 1 )
				{
					if( $outArrNum[$x] <= $outArrNum[$x+1] )
					{
						$swap = $outArrNum[$x+1];
						$outArrNum[$x+1] = $outArrNum[$x];
						$outArrNum[$x] = $swap;
						$bFlag = 1;
						break;
					}
				}
				else {
					if( $outArrNum[$x-1] <= $outArrNum[$x] )
					{
						$swap = $outArrNum[$x-1];
						$outArrNum[$x-1] = $outArrNum[$x];
						$outArrNum[$x] = $swap;
						$bFlag = 1;
						break;
					}				
				}
			}
		}
		else
			return $outArrNum;
			
			// Met en place la récursivité. Le tableau est uniquement propre
			// Si jamais le Flag n'est modifié.
		return ($bFlag == 0) ? ($outArrNum) : (sort_biggerTop( $outArrNum ));
	}
	
	function isLaterThan( $dateOne, $dateTwo ) {
		$arrDOne = explode( '.', $dateOne );
		$arrDTwo = explode( '.', $dateTwo );
		
		if( $arrDOne[2] > $arrDTwo[2] )
			return true;
		
		if( $arrDOne[2] == $arrDTwo[2] && $arrDOne[1] > $arrDTwo[1] )
			return true;
			
		if( $arrDOne[2] == $arrDTwo[2] && $arrDOne[1] == $arrDTwo[1] && $arrDOne[0] > $arrDTwo[0] )
			return true;			
			
		if( $arrDOne[2] < $arrDTwo[2] || ( $arrDOne[2] == $arrDTwo[2] && $arrDOne[1] < $arrDTwo[1]) || ($arrDOne[2] == $arrDTwo[2] && $arrDOne[1] == $arrDTwo[1] && $arrDOne[0] < $arrDTwo[0]) )
			return false;
			
		return true;
	}

	
	
	
?>
