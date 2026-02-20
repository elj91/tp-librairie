<?php
// Fonction pour ajouter un livre
function ajouterLivre(&$bibliotheque) {
    echo "Entrez le titre du livre à ajouter : ";
    
    // Lecture de la saisie utilisateur dans la console
    $titre = trim(fgets(STDIN));
    
    if (!empty($titre)) {
        $bibliotheque[] = $titre;
        echo "Le livre '$titre' a été ajouté avec succès !\n";
    } else {
        echo "Erreur : Le titre ne peut pas être vide.\n";
    }
}

// Exemple d'intégration dans le menu (ton rôle spécifique)
// Si l'utilisateur tape 2, on appelle cette fonction [cite: 44]
?>