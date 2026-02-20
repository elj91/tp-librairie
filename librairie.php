<?php
/**
 * Programme de Librairie - Gestion des livres
 * Utilise JSON pour stocker les données
 */

$fichier_json = 'livres.json';

/**
 * Charger les livres depuis le fichier JSON
 */
function chargerLivres() {
    global $fichier_json;
    $contenu = file_get_contents($fichier_json);
    return json_decode($contenu, true);
}

/**
 * Sauvegarder les livres dans le fichier JSON
 */
function sauvegarderLivres($livres) {
    global $fichier_json;
    file_put_contents($fichier_json, json_encode($livres, JSON_PRETTY_PRINT));
}

/**
 * Afficher le menu
 */
function afficherMenu() {
    echo "\n===== MENU LIBRAIRIE =====\n";
    echo "1. Lister tous les livres\n";
    echo "2. Ajouter un livre\n";
    echo "3. Modifier un livre\n";
    echo "4. Supprimer un livre\n";
    echo "5. Quitter\n";
    echo "===========================\n";
    echo "Choix: ";
}

/**
 * Lister tous les livres
 */
function listerLivres() {
    $livres = chargerLivres();
    
    if (empty($livres)) {
        echo "\nAucun livre.\n";
        return;
    }
    
    echo "\n===== LISTE DES LIVRES =====\n";
    foreach ($livres as $livre) {
        echo "ID: {$livre['id']} | {$livre['titre']} - {$livre['auteur']} ({$livre['annee']}) - {$livre['prix']}€\n";
    }
}

/**
 * Ajouter un livre
 */
function ajouterLivre() {
    $livres = chargerLivres();
    
    echo "Titre: ";
    $titre = trim(fgets(STDIN));
    echo "Auteur: ";
    $auteur = trim(fgets(STDIN));
    echo "Année: ";
    $annee = trim(fgets(STDIN));
    echo "Prix: ";
    $prix = trim(fgets(STDIN));
    
    $nouveau_id = end($livres)['id'] + 1;
    
    $livres[] = [
        'id' => $nouveau_id,
        'titre' => $titre,
        'auteur' => $auteur,
        'annee' => (int)$annee,
        'prix' => (float)$prix
    ];
    
    sauvegarderLivres($livres);
    echo "Livre ajouté!\n";
}

/**
 * Modifier un livre (TÂCHE)
 */
function modifierLivre() {
    $livres = chargerLivres();
    
    echo "ID du livre à modifier: ";
    $id = (int)trim(fgets(STDIN));
    
    $trouve = false;
    foreach ($livres as &$livre) {
        if ($livre['id'] === $id) {
            echo "Nouveau titre [{$livre['titre']}]: ";
            $titre = trim(fgets(STDIN));
            if (!empty($titre)) $livre['titre'] = $titre;
            
            echo "Nouvel auteur [{$livre['auteur']}]: ";
            $auteur = trim(fgets(STDIN));
            if (!empty($auteur)) $livre['auteur'] = $auteur;
            
            echo "Nouvelle année [{$livre['annee']}]: ";
            $annee = trim(fgets(STDIN));
            if (!empty($annee)) $livre['annee'] = (int)$annee;
            
            echo "Nouveau prix [{$livre['prix']}]: ";
            $prix = trim(fgets(STDIN));
            if (!empty($prix)) $livre['prix'] = (float)$prix;
            
            $trouve = true;
            break;
        }
    }
    
    if ($trouve) {
        sauvegarderLivres($livres);
        echo "Livre modifié!\n";
    } else {
        echo "Livre non trouvé.\n";
    }
}

/**
 * Supprimer un livre
 */
function supprimerLivre() {
    $livres = chargerLivres();
    
    echo "ID du livre à supprimer: ";
    $id = (int)trim(fgets(STDIN));
    
    $livres = array_filter($livres, function($l) use ($id) {
        return $l['id'] !== $id;
    });
    
    sauvegarderLivres(array_values($livres));
    echo "Livre supprimé!\n";
}

// Programme principal
echo "===== LIBRAIRIE JSON =====\n";

while (true) {
    afficherMenu();
    $choix = trim(fgets(STDIN));
    
    match($choix) {
        '1' => listerLivres(),
        '2' => ajouterLivre(),
        '3' => modifierLivre(),
        '4' => supprimerLivre(),
        '5' => exit("Au revoir!\n"),
        default => echo "Choix invalide\n"
    };
}

