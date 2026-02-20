<?php

/**
 * Supprime un livre par son ID
 * 
 * @param PDO $pdo    Instance de connexion à la base de données
 * @param int $id     ID du livre à supprimer
 * @return bool       True si supprimé, False sinon
 */
function deleteBook(PDO $pdo, int $id): bool
{
    // Vérifier que le livre existe avant suppression
    $checkStmt = $pdo->prepare("SELECT id FROM books WHERE id = :id");
    $checkStmt->execute([':id' => $id]);

    if (!$checkStmt->fetch()) {
        throw new \InvalidArgumentException("Le livre avec l'ID $id n'existe pas.");
    }

    $stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
    $stmt->execute([':id' => $id]);

    return $stmt->rowCount() > 0;
}