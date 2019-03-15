<?php
	// FAQ
	echo '<div id="faq-box">';
	echo '<h1>'.'Foire Aux Questions (FAQ)'.'</h1>';
	if( isset( $_GET['q'] ) ) {
	}
	// Affichage normal de la FAQ (Aucun lien n'a été cliqué
	else 
	{
		echo '<h2>'.'Le lexique intratelier09'.'</h2>';
	
		echo '<div class="question">';
			echo '<span>'.'Quelle est la signification du nom du projet ?'.'</span>';
		echo '</div>';
		
		echo '<div class="answer">';
			echo '<span>'.'\'intratelier\' est en fait composé de deux mots bien distincts. A savoir le mot \'Intra\', pour Intranet et le mot \'Atelier\'. Sachant que le Web 2.0 (Ajax) permet une gestion stable et rapide de données, l\'atelier se voit reprendre de fraîche couleurs en accordant à son utilisateur une interface bien plus fluide et agréable. L\'idée de développer ce logiciel en application Web, vient de moi, Grégory Saive.<br />La portabilité multi-ordinateurs et multi-système ayant été primordiale lors du développement du noyau d\'intratelier, j\'ai trouvé judicieux de développer une application web qui ne nécessite rien de plus qu\'un serveur PHP et un navigateur Web, de préférence acceptant le JavaScript.<br />Voilà donc comment le nom est devenu réalité.'.'</span>';
		echo '</div>';
		
		echo '<div class="question">';
			echo '<span>'.'Quels sont les mots à connaître, et que signifient-ils ?'.'</span>';
		echo '</div>';
		
		echo '<div class="answer">';
			echo '<ul>';
				echo '<li>'.'<span>'.'Une machine: Tout type de matériel informatique.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Une réparation: Regroupement d\'interventions qui résouds un problème général.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Une prestation: Un service que vous offrez à vos clients.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Un \'eyeDo\': Tout type d\'interventions effectuées pour la satisfaction d\'un client.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Un \'eyeText\': Tout type de note, lien ou aide-mémoire.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'L\'eyeModule\': C\'est votre tableau d\'eyeTexts. Ici seront affichés vos liens et notes.'.'</span>'.'</li>';
			echo '</ul>';
		echo '</div>';
		
		echo '<h2>'.'Les fonctions du webiciel'.'</h2>';
		
		echo '<div class="question">';
			echo '<span>'.'Comment réagir lorsqu\'un client a un problème avec son matériel ?'.'</span>';
		echo '</div>';
		
		echo '<div class="answer">';
			echo '<ul>';
				echo '<li>'.'<span>'.'Rendez-vous dans le <a href="index.php?p=workplace&lg=0">centre des réparations</a>.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Prenez les coordonnées du client si non-existantes.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Si le matériel en cause n\'est jamais passé dans votre atelier, enregistrez-en les informations.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Maintenant que le matériel en cause est enregistré, vous pouvez désigner les prestations à effectuer.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Des informations textuelles peuvent être ajoutée lorsque vous cliquez sur \'Afficher plus d\'information\'.'.'</span>'.'</li>';
			echo '</ul>';
		echo '</div>';
		
		echo '<div class="question">';
			echo '<span>'.'Comment rapidement savoir quels sont les problème du matériel du client que j\'ai en ligne ?'.'</span>';
		echo '</div>';
		
		echo '<div class="answer">';
			echo '<ul>';
				echo '<li>'.'<span>'.'Rendez-vous dans le <a href="index.php?p=printcenter&lg=0">centre des recherches et impressions</a>.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Entrez le nom du client.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Une liste de client correspondant est retournée. Les réparations relatives aux clients sont également affichées.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Vous pouvez donc soit cliquer sur la loupe à côté du nom du client, soit cliquer sur la loupe à côté du nom de la réparation.'.'</span>'.'</li>';
			echo '</ul>';
		echo '</div>';
		
		echo '<div class="question">';
			echo '<span>'.'Comment ajouter un service à la clientèle ?'.'</span>';
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
			echo '<span>'.'Comment ajouter une tâche à effectuer sur une réparation ?'.'</span>';
		echo '</div>';
		
		echo '<div class="answer">';
			echo '<span>'.'Admettons qu\'un client vous apporte son PC et que vous deviez réinstallez le système d\'exploitation. Vous allez ainsi créer une réparation et choisir d\'effectuer une réinstallation. Si plus tard, le client téléphone et vous dit qu\'il aimerait bien qu\'on configure également son email, il vous est possible d\'ajouter une prestation. Voici la démarche à suivre: '.'</span>';
			echo '<ul>';
				echo '<li>'.'<span>'.'Rendez-vous dans le <a href="index.php?p=workplace&lg=0">centre des réparations</a>.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Choisissez de <a href="index.php?p=workplace&lg=0&listrep=1">lister les réparation</a>.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Sélectionnez la réparation que vous souhaitez modifier.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Sélectionnez \'Ajouter une prestation\'.'.'</span>'.'</li>';
				echo '<li>'.'<span>'.'Vous pouvez maintenant définir les paramètres de la prestations à effectuer.'.'</span>'.'</li>';
			echo '</ul>';
		echo '</div>';
		
		
	}
	echo '</div>';
?>