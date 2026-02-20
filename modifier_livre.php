<!-- Formulaire ajout / modification -->
<section>
    <?php if ($editBook): ?>
        <h2>Modifier le livre</h2>
        <form method="POST">
            <input type="hidden" name="action" value="modifier">
            <input type="hidden" name="id" value="<?= $editBook['id'] ?>">
            <input type="text" name="titre" value="<?= htmlspecialchars($editBook['titre']) ?>" placeholder="Titre" required>
            <input type="text" name="auteur" value="<?= htmlspecialchars($editBook['auteur']) ?>" placeholder="Auteur">
            <input type="number" name="annee" value="<?= htmlspecialchars($editBook['annee']) ?>" placeholder="Année" style="width:80px">
            <button type="submit" class="btn-green">Enregistrer</button>
            <a href="index.php" class="btn btn-gray">Annuler</a>
        </form>
    <?php endif; ?>
</section>
