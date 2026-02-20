<?php
/**
 * Fonctionnalité MODIFIER UN LIVRE - Version simplifiée JSON
 */

$fichier_json = 'livres.json';

// Charger les livres
$livres = json_decode(file_get_contents($fichier_json), true);

// Demander l'ID
echo "ID du livre à modifier: ";
$id = (int)trim(fgets(STDIN));

// Trouver et modifier le livre
$trouve = false;
foreach ($livres as &$livre) {
    if ($livre['id'] === $id) {
        echo "Nouveau titre: ";
        $livre['titre'] = trim(fgets(STDIN));
        
        echo "Nouvel auteur: ";
        $livre['auteur'] = trim(fgets(STDIN));
        
        echo "Nouvelle année: ";
        $livre['annee'] = (int)trim(fgets(STDIN));
        
        echo "Nouveau prix: ";
        $livre['prix'] = (float)trim(fgets(STDIN));
        
        $trouve = true;
        break;
    }
}

if ($trouve) {
    file_put_contents($fichier_json, json_encode($livres, JSON_PRETTY_PRINT));
    echo "Livre modifié avec succès!\n";
} else {
    echo "Livre non trouvé.\n";
}

