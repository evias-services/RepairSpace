<!--

function showWindow( id )
{
	var objMonthWin = document.getElementById( 'window-month' );
	var objWeekWin = document.getElementById( 'window-week' );
	var objDayWin = document.getElementById( 'window-day' );
	var objNotesWin = document.getElementById( 'window-notes' );
	var objDataWin = document.getElementById( 'window-data' );
	
	var classMonth = 'hide';
	var classWeek = 'hide';
	var classDay = 'hide';
	var classNotes = 'hide';
	var classData = 'hide';
	
	switch( id ) 
	{
		case 0:
			classMonth = 'show';
			classWeek = 'hide';
			classDay = 'hide';
			classNotes = 'hide';
			classData = 'hide';
			break;
			
		case 1:
			classMonth = 'hide';
			classWeek = 'show';
			classDay = 'hide';
			classNotes = 'hide';
			classData = 'hide';
			break;
			
		case 2:
			classMonth = 'hide';
			classWeek = 'hide';
			classDay = 'show';
			classNotes = 'hide';
			classData = 'hide';
			break;
			
		case 3:
			classMonth = 'hide';
			classWeek = 'hide';
			classDay = 'hide';
			classNotes = 'show';
			classData = 'hide';
			break;
		
		case 4:
			classMonth = 'hide';
			classWeek = 'hide';
			classDay = 'hide';
			classNotes = 'hide';
			classData = 'show';
			break;
			
		default:
			classMonth = 'hide';
			classWeek = 'hide';
			classDay = 'show';
			classNotes = 'hide';
			classData = 'hide';
			break;
	}
	
	objMonthWin.className = classMonth;
	objWeekWin.className = classWeek;
	objDayWin.className = classDay;
	objNotesWin.className = classNotes;
	objDataWin.className = classData;
}

function readFile(fichier)
{
	if(window.XMLHttpRequest) // FIREFOX
		xhr_object = new XMLHttpRequest();
	else if(window.ActiveXObject) // IE
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else
	{
		alert( 'no js' );
		return(false);
	}

	xhr_object.open("GET", fichier, false);
	xhr_object.send(null);
	if(xhr_object.readyState == 4) {
	//	alert( xhr_object.responseText );
		return (xhr_object.responseText);
	}
	else {
		alert( 'readyState not 4' );
		return (false);
	}
}

function logNow( tech, action )
{
	return readFile( '../php/dorequest.php?req=69&tech='+tech+'&act='+action );
}

function searchCust( text ) {
	var listCust = new Array( );
	var arrIndex = new Array( );
	var inRow = 0;
	var objResult = document.getElementById( 'customer-list' );
	for( var i = 0; i < 9999; i++ ) {
		if( document.getElementById( 'customer-'+i ) ) {
			listCust[i] = document.getElementById( 'customer-'+i );
			var innerTxt = listCust[i].innerHTML.toUpperCase( );
			var compare = text.toUpperCase( );
			if( innerTxt.indexOf( compare, 0 ) != -1 )
				listCust[i].className = "show";
			else
				listCust[i].className = "hide";
		}
		else {
			inRow++;
			if( inRow == 100 )
				break;
			else
				continue;
		}
	}
	
	objResult.className = 'show';		
}

function setDataCust( id, lib, addr, cp, ville, tel ) {
	var objID = document.getElementById( 'idCl' );
	var objLib = document.getElementById( 'libCl' );
	var objAddr = document.getElementById( 'addrCl' );
	var objCp = document.getElementById( 'cpCl' );
	var objVille = document.getElementById( 'villeCl' );
	var objTel = document.getElementById( 'telCl' );
	
	objID.value = id;
	objLib.value = lib;
	objAddr.value = addr;
	objCp.value = cp;
	objVille.value = ville;
	objTel.value = tel;
}

function clearDataCust( ) {
	document.getElementById( 'idCl' ).value = '';
	document.getElementById( 'libCl' ).value = '';
	document.getElementById( 'addrCl' ).value = '';
	document.getElementById( 'cpCl' ).value = '';
	document.getElementById( 'villeCl' ).value = '';
	document.getElementById( 'telCl' ).value = '';
}

-->