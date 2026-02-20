<<<<<<< HEAD
		>>>>>>>>README<<<<<<<<	

Ce projet est une librairie collaborative développée en PHP.

1. Interface

	L'interface a été codée en php et en json. Pour le design nous avons utilisé du CSS.
	
	-->  L'interface se présente en deux blocs. un blocs pour les fonctionnalités, un autre pour la liste des livre et un bouton pour soumettre la requête.
	-->  On utilise un formulaire pour les fonction ajouter, supprimer, ou modifier un livre

	Utilisation de Git: Le développement a été effectué directement sur la branche master avec un commit pour chaque modification. Les autres fonctionnalités ont été ajouter puis fusionner avec la master pour plus de traçabilité. 


2.Fonction Ajout d'un livre
	
	Cette fonctionnalité permet d'enrichir la base de données de la librairie depuis l'interface.

	-->  Le programme demande à l'utilisateur de saisir un titre de livre.
	-->  Le livre est ajouté dynamiquement au tableau représentant la bibliothèque. 
        -->  Cette fonction est déclenchée lorsque l'utilisateur sélectionne l'option correspondante dans le menu principal.
	-->  Utilisation du langage json afin de stocker les données.
	
	Utilisation de Git: Le développement a été effectué sur la branche fonction-ajout-livre, une fois la fonctionnalité développée, la branche a été fusionnée vers la branche master. Pour chaque modification un commit a été effectuer.

3.Fonction Supprimer un livre

	Cette fonctionnalité permet d'amoindrir la base de données de la librairie depuis l'interface.

	-->  Le programme demande à l'utilisateur de choisir un titre de livre dans la liste.
	-->  Le livre est supprimé dynamiquement du tableau représentant la bibliothèque. 
        -->  Cette fonction est déclenchée lorsque l'utilisateur sélectionne l'option correspondante.
	
	Utilisation de Git: Le développement a été effectué sur la branche fonction-supprimer-livre, une fois la fonctionnalité développée, la branche a été fusionnée vers la branche master. Pour chaque modification un commit a été effectuer.


4.Fonction Modifier

	Cette fonctionnalité permet de modifier la base de données de la librairie via la ligne de commande.

	-->L'utilisateur peut modifier les valeurs du fichier json.

	Utilisation de Git: Le développement a été effectué sur la branche modificateur de fonctionalitées, une fois la fonctionnalité 	développée, la branche a été fusionnée vers la branche master. Pour chaque modification un commit a été effectuer.

	
=======
Cet branche contient la fonction de suppression en php du tp librairie.
>>>>>>> ab3ca6e2392815298f67757c1a2693547d2cd04d
