<?php
/**
 * Programme de Librairie - Gestion des livres
 * CLI (Interface en ligne de commande)
 */

// Configuration de la base de données
$host = 'localhost';
$dbname = 'librairie';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage() . "\n");
}

/**
 * Fonction pour afficher le menu principal
 */
function afficherMenu() {
    echo "\n===== MENU LIBRAIRIE =====\n";
    echo "1. Lister tous les livres\n";
    echo "2. Ajouter un nouveau livre\n";
    echo "3. Modifier un livre\n";
    echo "4. Supprimer un livre\n";
    echo "5. Quitter\n";
    echo "===========================\n";
    echo "Entrez votre choix: ";
}

/**
 * Lister tous les livres
 */
function listerLivres($pdo) {
    $stmt = $pdo->query("SELECT * FROM livres ORDER BY id ASC");
    $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($livres)) {
        echo "\nAucun livre dans la librairie.\n";
        return;
    }

    echo "\n===== LISTE DES LIVRES =====\n";
    foreach ($livres as $livre) {
        echo "ID: " . $livre['id'] . "\n";
        echo "Titre: " . $livre['titre'] . "\n";
        echo "Auteur: " . $livre['auteur'] . "\n";
        echo "Année: " . $livre['annee'] . "\n";
        echo "Prix: " . number_format($livre['prix'], 2) . " €\n";
        if (!empty($livre['description'])) {
            echo "Description: " . $livre['description'] . "\n";
        }
        echo "---------------------------\n";
    }
}

/**
 * Ajouter un nouveau livre
 */
function ajouterLivre($pdo) {
    echo "\n===== AJOUTER UN LIVRE =====\n";

    echo "Entrez le titre: ";
    $titre = trim(fgets(STDIN));

    echo "Entrez l'auteur: ";
    $auteur = trim(fgets(STDIN));

    echo "Entrez l'année: ";
    $annee = trim(fgets(STDIN));

    echo "Entrez le prix: ";
    $prix = trim(fgets(STDIN));

    echo "Entrez la description (optionnel): ";
    $description = trim(fgets(STDIN));

    // Validation simple
    if (empty($titre) || empty($auteur) || empty($annee) || empty($prix)) {
        echo "\nErreur: Tous les champs obligatoires doivent être remplis.\n";
        return;
    }

    $sql = "INSERT INTO livres (titre, auteur, annee, prix, description) VALUES (:titre, :auteur, :annee, :prix, :description)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':titre' => $titre,
            ':auteur' => $auteur,
            ':annee' => (int)$annee,
            ':prix' => (float)$prix,
            ':description' => $description
        ]);
        echo "\nLivre ajouté avec succès! (ID: " . $pdo->lastInsertId() . ")\n";
    } catch (PDOException $e) {
        echo "\nErreur lors de l'ajout du livre: " . $e->getMessage() . "\n";
    }
}

/**
 * Modifier un livre (TÂCHE DE L'UTILISATEUR)
 */
function modifierLivre($pdo) {
    echo "\n===== MODIFIER UN LIVRE =====\n";

    // Demander l'ID du livre à modifier
    echo "Entrez l'ID du livre à modifier: ";
    $id = trim(fgets(STDIN));

    if (!is_numeric($id)) {
        echo "\nErreur: L'ID doit être un nombre.\n";
        return;
    }

    // Vérifier si le livre existe
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE id = :id");
    $stmt->execute([':id' => (int)$id]);
    $livre = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$livre) {
        echo "\nErreur: Aucun livre trouvé avec l'ID $id.\n";
        return;
    }

    echo "\nLivre actuel:\n";
    echo "Titre: " . $livre['titre'] . "\n";
    echo "Auteur: " . $livre['auteur'] . "\n";
    echo "Année: " . $livre['annee'] . "\n";
    echo "Prix: " . number_format($livre['prix'], 2) . " €\n";
    echo "Description: " . $livre['description'] . "\n";

    echo "\nEntrez les nouvelles valeurs (appuyez sur Entrée pour garder la valeur actuelle):\n";

    echo "Titre [" . $livre['titre'] . "]: ";
    $nouveau_titre = trim(fgets(STDIN));
    $titre = !empty($nouveau_titre) ? $nouveau_titre : $livre['titre'];

    echo "Auteur [" . $livre['auteur'] . "]: ";
    $nouveau_auteur = trim(fgets(STDIN));
    $auteur = !empty($nouveau_auteur) ? $nouveau_auteur : $livre['auteur'];

    echo "Année [" . $livre['annee'] . "]: ";
    $nouvelle_annee = trim(fgets(STDIN));
    $annee = !empty($nouvelle_annee) ? (int)$nouvelle_annee : $livre['annee'];

    echo "Prix [" . number_format($livre['prix'], 2) . "]: ";
    $nouveau_prix = trim(fgets(STDIN));
    $prix = !empty($nouveau_prix) ? (float)$nouveau_prix : $livre['prix'];

    echo "Description [" . $livre['description'] . "]: ";
    $nouvelle_description = trim(fgets(STDIN));
    $description = !empty($nouvelle_description) ? $nouvelle_description : $livre['description'];

    // Mise à jour dans la base de données
    $sql = "UPDATE livres SET titre = :titre, auteur = :auteur, annee = :annee, prix = :prix, description = :description WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':id' => (int)$id,
            ':titre' => $titre,
            ':auteur' => $auteur,
            ':annee' => $annee,
            ':prix' => $prix,
            ':description' => $description
        ]);
        echo "\nLivre modifié avec succès!\n";
    } catch (PDOException $e) {
        echo "\nErreur lors de la modification du livre: " . $e->getMessage() . "\n";
    }
}

/**
 * Supprimer un livre
 */
function supprimerLivre($pdo) {
    echo "\n===== SUPPRIMER UN LIVRE =====\n";

    echo "Entrez l'ID du livre à supprimer: ";
    $id = trim(fgets(STDIN));

    if (!is_numeric($id)) {
        echo "\nErreur: L'ID doit être un nombre.\n";
        return;
    }

    // Vérifier si le livre existe
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE id = :id");
    $stmt->execute([':id' => (int)$id]);
    $livre = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$livre) {
        echo "\nErreur: Aucun livre trouvé avec l'ID $id.\n";
        return;
    }

    echo "\nVous êtes sur le point de supprimer:\n";
    echo "Titre: " . $livre['titre'] . "\n";
    echo "Auteur: " . $livre['auteur'] . "\n";

    echo "\nÊtes-vous sûr ? (O/N): ";
    $confirmation = strtoupper(trim(fgets(STDIN)));

    if ($confirmation !== 'O') {
        echo "Suppression annulée.\n";
        return;
    }

    $sql = "DELETE FROM livres WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([':id' => (int)$id]);
        echo "\nLivre supprimé avec succès!\n";
    } catch (PDOException $e) {
        echo "\nErreur lors de la suppression du livre: " . $e->getMessage() . "\n";
    }
}

// Programme principal
echo "======================================\n";
echo "   PROGRAMME DE GESTION DE LIBRAIRIE  \n";
echo "======================================\n";

while (true) {
    afficherMenu();
    $choix = trim(fgets(STDIN));

    switch ($choix) {
        case 1:
            listerLivres($pdo);
            break;
        case 2:
            ajouterLivre($pdo);
            break;
        case 3:
            modifierLivre($pdo);  // TÂCHE DE L'UTILISATEUR
            break;
        case 4:
            supprimerLivre($pdo);
            break;
        case 5:
            echo "\nAu revoir!\n";
            exit(0);
        default:
            echo "\nChoix invalide. Veuillez choisir entre 1 et 5.\n";
    }
}

