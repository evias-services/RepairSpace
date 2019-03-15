<?php
	// FAQ
	echo '<div id="faq-box">';
	echo '<h1>'.'Foire Aux Questions (FAQ)'.'</h1>';
	if( isset( $_GET['q'] ) ) {
	}
	// Affichage normal de la FAQ (Aucun lien n'a �t� cliqu�
	else 
	{
		echo '<h2>'.'Le lexique intratelier09'.'</h2>';
	
		echo '<div class="question">';
			echo '<span>'.'Quelle est la signification du nom du projet ?'.'</span>';
		echo '</div>';
		
		echo '<div class="answer">';
			echo '<span>'.'\'intratelier\' est en fait compos� de deux mots bien distincts. A savoir le mot \'Intra\', pour Intranet et le mot \'Atelier\'. Sachant que le Web 2.0 (Ajax) permet une gestion stable et rapide de donn�es, l\'atelier se voit reprendre de fra�che couleurs en accordant � son utilisateur une interface bien plus fluide et agr�able. L\'id�e de d�velopper ce logiciel en application Web, vient de moi, Gr�gory Saive.<br />La portabilit� multi-ordinateurs et multi-syst�me ayant �t� primordiale lors du d�veloppement du noyau d\'intratelier, j\'ai trouv� judicieux de d�velopper une application web qui ne n�cessite rien de plus qu\'un serveur PHP et un navigateur Web, de pr�f�rence acceptant le JavaScript.<br />Voil� donc comment le nom est devenu r�alit�.'.'</span>';
		echo '</div>';
		
		echo '<div class="question">';
			echo '<span>'.'Quels sont les mots � conna�tre, et que signifient-ils ?'.'</span>';
		echo '</div>';
		
		echo '<div class="answer">';
			echo '<ul>';
				echo '<li>'.'<span>'.'Une machine: Tout type de mat�riel informatique.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Une r�paration: Regroupement d\'interventions qui r�souds un probl�me g�n�ral.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Une prestation: Un service que vous offrez � vos clients.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Un \'eyeDo\': Tout type d\'interventions effectu�es pour la satisfaction d\'un client.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Un \'eyeText\': Tout type de note, lien ou aide-m�moire.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'L\'eyeModule\': C\'est votre tableau d\'eyeTexts. Ici seront affich�s vos liens et notes.'.'</span>'.'</li>';
			echo '</ul>';
		echo '</div>';
		
		echo '<h2>'.'Les fonctions du webiciel'.'</h2>';
		
		echo '<div class="question">';
			echo '<span>'.'Comment r�agir lorsqu\'un client a un probl�me avec son mat�riel ?'.'</span>';
		echo '</div>';
		
		echo '<div class="answer">';
			echo '<ul>';
				echo '<li>'.'<span>'.'Rendez-vous dans le <a href="index.php?p=workplace&lg=0">centre des r�parations</a>.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Prenez les coordonn�es du client si non-existantes.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Si le mat�riel en cause n\'est jamais pass� dans votre atelier, enregistrez-en les informations.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Maintenant que le mat�riel en cause est enregistr�, vous pouvez d�signer les prestations � effectuer.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Des informations textuelles peuvent �tre ajout�e lorsque vous cliquez sur \'Afficher plus d\'information\'.'.'</span>'.'</li>';
			echo '</ul>';
		echo '</div>';
		
		echo '<div class="question">';
			echo '<span>'.'Comment rapidement savoir quels sont les probl�me du mat�riel du client que j\'ai en ligne ?'.'</span>';
		echo '</div>';
		
		echo '<div class="answer">';
			echo '<ul>';
				echo '<li>'.'<span>'.'Rendez-vous dans le <a href="index.php?p=printcenter&lg=0">centre des recherches et impressions</a>.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Entrez le nom du client.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Une liste de client correspondant est retourn�e. Les r�parations relatives aux clients sont �galement affich�es.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Vous pouvez donc soit cliquer sur la loupe � c�t� du nom du client, soit cliquer sur la loupe � c�t� du nom de la r�paration.'.'</span>'.'</li>';
			echo '</ul>';
		echo '</div>';
		
		echo '<div class="question">';
			echo '<span>'.'Comment ajouter un service � la client�le ?'.'</span>';
		echo '</div>';
		
		echo '<div class="answer">';
			echo '<ul>';
				echo '<li>'.'<span>'.'Rendez-vous dans le <a href="index.php?p=servicescenter&lg=0">centre des services</a>.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Entrez une description pour le service.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Entrez un prix en euro (&euro;).'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Appuyez sur \'Ajouter\'.'.'</span>'.'</li>';
			echo '</ul>';
		echo '</div>';
		
		echo '<div class="question">';
			echo '<span>'.'Comment ajouter une t�che � effectuer sur une r�paration ?'.'</span>';
		echo '</div>';
		
		echo '<div class="answer">';
			echo '<span>'.'Admettons qu\'un client vous apporte son PC et que vous deviez r�installez le syst�me d\'exploitation. Vous allez ainsi cr�er une r�paration et choisir d\'effectuer une r�installation. Si plus tard, le client t�l�phone et vous dit qu\'il aimerait bien qu\'on configure �galement son email, il vous est possible d\'ajouter une prestation. Voici la d�marche � suivre: '.'</span>';
			echo '<ul>';
				echo '<li>'.'<span>'.'Rendez-vous dans le <a href="index.php?p=workplace&lg=0">centre des r�parations</a>.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Choisissez de <a href="index.php?p=workplace&lg=0&listrep=1">lister les r�paration</a>.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'S�lectionnez la r�paration que vous souhaitez modifier.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'S�lectionnez \'Ajouter une prestation\'.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Vous pouvez maintenant d�finir les param�tres de la prestations � effectuer.'.'</span>'.'</li>';
			echo '</ul>';
		echo '</div>';
		
		
	}
	echo '</div>';
?>