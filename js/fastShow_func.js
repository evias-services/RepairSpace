
<!--

function hoverMenu( str ) {
	var obj = document.getElementById( 'menu-info' );
	obj.innerHTML = '<span>'+str+'</span>';
	obj.className = "show";
}

function outMenu( ) {
	var obj = document.getElementById( 'menu-info' );
	obj.innerHTML = '&nbsp;';
	obj.className = 'hide';
}

function showInfoEyeText( str ) {
	var obj = document.getElementById( 'info-list-eyeText' );
	obj.innerHTML = '<span>'+str+'</span>';
	obj.className = "show";
}

function resetInfoEyeText( ) {
	var obj = document.getElementById( 'info-list-eyeText' );
	obj.innerHTML = '&nbsp;';
	obj.className = 'hide';
}

function showInfoAway( str ) {
	var obj = document.getElementById( 'info-list-depl' );
	obj.innerHTML = '<span>'+str+'</span>';
	obj.className = "show";
}

function resetInfoAway( ) {
	var obj = document.getElementById( 'info-list-depl' );
	obj.innerHTML = '&nbsp;';
	obj.className = 'hide';
}

function montre(text, text2, text3) {
  document.getElementById("curseur").innerHTML = text+" %";
  document.getElementById("curseur2").innerHTML = text2+"";
  document.getElementById("curseur3").innerHTML = text3.substr( 0, 20 );
  
}
  
function reset() {
	document.getElementById("curseur").innerHTML = " / ";
	document.getElementById("curseur2").innerHTML = " / ";
	document.getElementById("curseur3").innerHTML = " / ";
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

function doRequest( id, req ) {
	return readFile( './php/dorequest.php?req='+req+'&id='+id );
}

function doRequestMore( id, req ) {
	var more = 'not set yet';
	switch( req )
	{
		case 31:
			more = document.getElementById( 'func-tech-'+id ).value;
			break;
			
		case 32:
			more = document.getElementById( 'axs-tech-'+id ).value;			
			break;
			
		case 33:
			if ( document.getElementById( 'tech-name-'+id ).value.length > 1 )
				more =  document.getElementById( 'tech-name-'+id ).value+'xxxx';
			else
				more = ' xxxx';
			if(document.getElementById( 'tech-cp-'+id ).value.length > 1)
				more += document.getElementById( 'tech-cp-'+id ).value+'xxxx';
			else
				more += ' xxxx';
			if(document.getElementById( 'tech-mob-'+id ).value.length > 1)
				more += document.getElementById( 'tech-mob-'+id ).value+'xxxx';
			else
				more += ' xxxx';
			if(document.getElementById( 'tech-mail-'+id ).value.length > 1)
				more += document.getElementById( 'tech-mail-'+id ).value;
			else
				more += ' ';
				
			break;
			
		case 69:
			more = 'Error';
			break;
		
		default:
			more = 'Error';
			
			break;
	}
	
	return readFile( './php/dorequest.php?req='+req+'&id='+id+'&more='+more+'&tech='+tech );
}

function logNow( tech, action )
{
	return readFile( './php/dorequest.php?req=69&tech='+tech+'&act='+action );
}

// Déclare la fonction getElementsByClassName pour IE.
onload=function(){
	if (document.getElementsByClassName == undefined) {
		document.getElementsByClassName = function(className)
		{
			var hasClassName = new RegExp("(?:^|\\s)" + className + "(?:$|\\s)");
			var allElements = document.getElementsByTagName("*");
			var results = [];

			var element;
			for (var i = 0; (element = allElements[i]) != null; i++) {
				var elementClass = element.className;
				if (elementClass && elementClass.indexOf(className) != -1 && hasClassName.test(elementClass))
					results.push(element);
			}

			return results;
		}
	}
}

function searchCust( text ) {
	var listCust = new Array( );
	var arrIndex = new Array( );
	var inRow = 0;
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
}

function printFiche( i, id ) {
	options = "" ;
	switch( i ) {
		case 0:
  		window.open( ("./php/generate_print_fiche_cl.php?cl="+id), "Impression de la fiche client", options );
  		break;
  	case 1:
  		window.open( ("./php/generate_print_fiche_rep.php?rep="+id), "Impression de la fiche de réparation", options );
  		break;
  	default:
  		return;
  		break;
  }  
}

function setSelectedData( t ) {
//id, lib, addr, cp, ville, tel, mail, l1, l2, l3, l4, l5 
	var objData = document.getElementById( 'data-cust' );	
// text += '<br /><br /><span style="font-size: 8pt; font-weight:bold;">'+'Sélectionnez un élément de la liste pour continuer'+'</span>';
	objData.innerHTML = t;
}

/*
updateCustDataFields(\''.$rCl[1].'\',\''.$rCl[7].'\',\''.$rCl[8].'\',\''.$rCl[9].'\',\''.$r[5].'\');
*/

function updateCustDataFields( id, lib, addr, cp, ville, tel ) {
	var objLib = document.getElementById( 'libCl' );
	var objAddr = document.getElementById( 'addrCl' );
	var objCp = document.getElementById( 'cpCl' );
	var objVille = document.getElementById( 'villeCl' );
	var objTel = document.getElementById( 'telCl' );
	var objID = document.getElementById( 'idCl' );
	
	objLib.value = lib;
	objAddr.value = addr;
	objCp.value = cp;
	objVille.value = ville;
	objTel.value = tel;
	objID.value = id;
}

function updateArchivesMDiv( ) {
	var objDiv = document.getElementById( 'archivesmonth-eyedo' );
	var objCur = document.getElementById( 'curseurmonth' );
	if( objCur.innerHTML == '1' )	
	{
		objDiv.className = 'hide';
		objCur.innerHTML = '0';
	}
	else
	{
		objDiv.className = 'show';
		objCur.innerHTML = '1';
	}
}

function updateArchivesODiv( ) {
	var objDiv = document.getElementById( 'archivesold-eyedo' );
	var objCur = document.getElementById( 'curseurold' );
	if( objCur.innerHTML == '1' )	
	{
		objDiv.className = 'hide';
		objCur.innerHTML = '0';
	}
	else
	{
		objDiv.className = 'show';
		objCur.innerHTML = '1';
	}
}

function updateRepStatus( id ) {
	var objCur = document.getElementById( 'curseurDate-'+id );
	var objDiv = document.getElementById( 'eyedo-work-date-'+id );
	
	if( objCur.innerHTML == '1' )	
	{
		objDiv.className = 'hide';
		objCur.innerHTML = '0';
	}
	else
	{
		objDiv.className = 'show';
		objCur.innerHTML = '1';
	}
}

function showJobs( id ) {
	var objCur = document.getElementById( 'curseur-tech-'+id );
	var objDiv = document.getElementById( 'jobs-tech-'+id );
	
	if( objCur.innerHTML == '1' )	
	{
		objDiv.className = 'hide';
		objCur.innerHTML = '0';
	}
	else
	{
		objDiv.className = 'show';
		objCur.innerHTML = '1';
	}
}

function showDistances( id ) {
	var objCur = document.getElementById( 'curseur-dist-tech-'+id );
	var objDiv = document.getElementById( 'dist-tech-'+id );
	
	if( objCur.innerHTML == '1' )	
	{
		objDiv.className = 'hide';
		objCur.innerHTML = '0';
	}
	else
	{
		objDiv.className = 'show';
		objCur.innerHTML = '1';
	}
}

function showServiceGraphe( id ) {
	var objCur = document.getElementById( 'curseur-service-'+id );
	var objDiv = document.getElementById( 'graphe-service-'+id );
	
	if( objCur.innerHTML == '1' )	
	{
		objDiv.className = 'hide';
		objCur.innerHTML = '0';
	}
	else
	{
		objDiv.className = 'show';
		objCur.innerHTML = '1';
	}
}

function showAddTech( ) {
	var objCur = document.getElementById( 'curseur-add-tech' );
	var objDiv = document.getElementById( 'add-tech' );
	
	if( objCur.innerHTML == '1' )	
	{
		objDiv.className = 'hide';
		objCur.innerHTML = '0';
	}
	else
	{
		objDiv.className = 'show';
		objCur.innerHTML = '1';
	}
}

function awaysOnGrid( ) {
	var arrOut = Array( );
	var bBreak = false;
	for( x = 0; x < 500 && (!bBreak); x++ )
	{
		if( document.getElementById('depl-grid-'+x) )
			arrOut[x] = document.getElementById('depl-grid-'+x);
		else
			bBreak = true;
	}
	
	return arrOut;
}

function eventsOnGrid( ) {
	var arrOut = Array( );
	var bBreak = false;
	for( x = 0; x < 500 && (!bBreak); x++ )
	{
		if( document.getElementById('event-grid-'+x) )
			arrOut[x] = document.getElementById('event-grid-'+x);
		else
			bBreak = true;
	}
	
	return arrOut;
}

function meetingsOnGrid( ) {
	var arrOut = Array( );
	var bBreak = false;
	for( x = 0; x < 500 && (!bBreak); x++ )
	{
		if( document.getElementById('meeting-grid-'+x) )
			arrOut[x] = document.getElementById('meeting-grid-'+x);
		else
			bBreak = true;
	}
	
	return arrOut;
}

function tasksOnGrid( ) {
	var arrOut = Array( );
	var bBreak = false;
	for( x = 0; x < 500 && (!bBreak); x++ )
	{
		if( document.getElementById('task-grid-'+x) )
			arrOut[x] = document.getElementById('task-grid-'+x);
		else
			bBreak = true;
	}
	
	return arrOut;
}

function weekShow( id ) {
	var deplClass = 'hide';
	var eventClass = 'hide';
	var meetingClass = 'hide';
	var taskClass = 'hide';
	var deplInner = '0';
	var eventInner = '0';
	var meetingInner = '0';
	var taskInner = '0';
	switch( id )
	{
		case 0:
			deplClass = 'show';
			eventClass = 'hide';
			meetingClass = 'hide';
			taskClass = 'hide';
			deplInner = '1';
			eventInner = '0';
			meetingInner = '0';
			taskInner = '0';
			break;
			
		case 1:
			deplClass = 'hide';
			eventClass = 'show';
			meetingClass = 'hide';
			taskClass = 'hide';
			deplInner = '0';
			eventInner = '1';
			meetingInner = '0';
			taskInner = '0';
			break;
			
		case 2:
			deplClass = 'hide';
			eventClass = 'hide';
			meetingClass = 'show';
			taskClass = 'hide';
			deplInner = '0';
			eventInner = '0';
			meetingInner = '1';
			taskInner = '0';
			break;
			
		case 3:
			deplClass = 'hide';
			eventClass = 'hide';
			meetingClass = 'hide';
			taskClass = 'show';
			deplInner = '0';
			eventInner = '0';
			meetingInner = '0';
			taskInner = '1';
			break;
			
		default:
			deplClass = 'show';
			eventClass = 'hide';
			meetingClass = 'hide';
			taskClass = 'hide';
			deplInner = '1';
			eventInner = '0';
			meetingInner = '0';
			taskInner = '0';
			break;
	}
	
	var arrDepl = awaysOnGrid( );
	var arrEvent = eventsOnGrid( );
	var arrMeeting = meetingsOnGrid( );
	var arrTask = tasksOnGrid( );
	
	var depl0 = document.getElementById( 'awaycurseur0' );
	var event0 = document.getElementById( 'eventcurseur0' );
	var meeting0 = document.getElementById( 'meetingcurseur0' );
	var task0 = document.getElementById( 'taskcurseur0' );
	
	depl0.innerHTML = deplInner;
	event0.innerHTML = eventInner;
	meeting0.innerHTML = meetingInner;
	task0.innerHTML = taskInner;
	
	for( s = 0; s < arrDepl.length; s++ )
			arrDepl[s].className = deplClass;
			
	for( s = 0; s < arrEvent.length; s++ )
			arrEvent[s].className = eventClass;
			
	for( s = 0; s < arrMeeting.length; s++ )
			arrMeeting[s].className = meetingClass;
			
	for( s = 0; s < arrTask.length; s++ )
			arrTask[s].className = taskClass;
}

function awaysOnMonth( ) {
	var arrOut = Array( );
	var bBreak = false;
	for( x = 1; x < 32 && (!bBreak); x++ )
	{
		if( document.getElementById('awaybox-'+x) )
			arrOut[x-1] = document.getElementById('awaybox-'+x);
		else
			bBreak = true;
	}
	
	return arrOut;
}

function eventsOnMonth( ) {
	var arrOut = Array( );
	var bBreak = false;
	for( x = 1; x < 32 && (!bBreak); x++ )
	{
		if( document.getElementById('eventbox-'+x) )
			arrOut[x-1] = document.getElementById('eventbox-'+x);
		else
			bBreak = true;
	}
	
	return arrOut;
}

function meetingsOnMonth( ) {
	var arrOut = Array( );
	var bBreak = false;
	for( x = 1; x < 32 && (!bBreak); x++ )
	{
		if( document.getElementById('meetingbox-'+x) )
			arrOut[x-1] = document.getElementById('meetingbox-'+x);
		else
			bBreak = true;
	}
	
	return arrOut;
}

function tasksOnMonth( ) {
	var arrOut = Array( );
	var bBreak = false;
	for( x = 1; x < 32 && (!bBreak); x++ )
	{
		if( document.getElementById('taskbox-'+x) )
			arrOut[x-1] = document.getElementById('taskbox-'+x);
		else
			bBreak = true;
	}
	
	return arrOut;
}

function monthShow( id ) {
	var deplClass = 'hide';
	var eventClass = 'hide';
	var meetingClass = 'hide';
	var taskClass = 'hide';
	var deplInner = '0';
	var eventInner = '0';
	var meetingInner = '0';
	var taskInner = '0';
	switch( id )
	{
		case 0:
			deplClass = 'show';
			eventClass = 'hide';
			meetingClass = 'hide';
			taskClass = 'hide';
			deplInner = '1';
			eventInner = '0';
			meetingInner = '0';
			taskInner = '0';
			break;
			
		case 1:
			deplClass = 'hide';
			eventClass = 'show';
			meetingClass = 'hide';
			taskClass = 'hide';
			deplInner = '0';
			eventInner = '1';
			meetingInner = '0';
			taskInner = '0';
			break;
			
		case 2:
			deplClass = 'hide';
			eventClass = 'hide';
			meetingClass = 'show';
			taskClass = 'hide';
			deplInner = '0';
			eventInner = '0';
			meetingInner = '1';
			taskInner = '0';
			break;
			
		case 3:
			deplClass = 'hide';
			eventClass = 'hide';
			meetingClass = 'hide';
			taskClass = 'show';
			deplInner = '0';
			eventInner = '0';
			meetingInner = '0';
			taskInner = '1';
			break;
			
		default:
			deplClass = 'show';
			eventClass = 'hide';
			meetingClass = 'hide';
			taskClass = 'hide';
			deplInner = '1';
			eventInner = '0';
			meetingInner = '0';
			taskInner = '0';
			break;
	}
	
	var arrDepl = awaysOnMonth( );
	var arrEvent = eventsOnMonth( );
	var arrMeeting = meetingsOnMonth( );
	var arrTask = tasksOnMonth( );
	
	var depl0 = document.getElementById( 'awaycurseur1' );
	var event0 = document.getElementById( 'eventcurseur1' );
	var meeting0 = document.getElementById( 'meetingcurseur1' );
	var task0 = document.getElementById( 'taskcurseur1' );
	
	depl0.innerHTML = deplInner;
	event0.innerHTML = eventInner;
	meeting0.innerHTML = meetingInner;
	task0.innerHTML = taskInner;
	
	
	for( s = 0; s < arrDepl.length; s++ )
			arrDepl[s].className = deplClass;
			
	for( s = 0; s < arrEvent.length; s++ )
			arrEvent[s].className = eventClass;
			
	for( s = 0; s < arrMeeting.length; s++ )
			arrMeeting[s].className = meetingClass;
			
	for( s = 0; s < arrTask.length; s++ )
			arrTask[s].className = taskClass;
			
//	alert( arrDepl.length+' - '+arrMeeting.length );
}

function checkAndRedirect( date, time )
{
	var depl0 = document.getElementById( 'awaycurseur0' );
	var event0 = document.getElementById( 'eventcurseur0' );
	var meeting0 = document.getElementById( 'meetingcurseur0' );
	var task0 = document.getElementById( 'taskcurseur0' );
	var isOn = -1;
	
	if( depl0.innerHTML == '1' )
		isOn = 0;	
		
	if( meeting0.innerHTML == '1' )
		isOn = 1;
		
	if( event0.innerHTML == '1' )
		isOn = 2;
		
	if( task0.innerHTML == '1' )
		isOn = 3;
		
		
	switch( isOn )
	{
		case 0:
			window.location.href= 'index.php?p=away&addAway=1&date='+date+'&time='+time;
			break;
			
		case 1:
			window.location.href= 'index.php?p=cal&addMeeting=1&date='+date+'&time='+time;
			break;
			
		case 2:
			window.location.href= 'index.php?p=cal&addEvent=1&date='+date+'&time='+time;
			break;
			
		case 3:
			window.location.href= 'index.php?p=cal&addTask=1&date='+date+'&time='+time;
			break;
			
		default:
			window.location.href= 'index.php';
			break;
	}
}
-->