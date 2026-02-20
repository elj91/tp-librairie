<?php
$dataFile = 'books.json';

function loadBooks($file) {
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?? [];
}

function saveBooks($file, $books) {
    file_put_contents($file, json_encode(array_values($books), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function getNextId($books) {
    if (empty($books)) return 1;
    return max(array_column($books, 'id')) + 1;
}

$books = loadBooks($dataFile);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'ajouter') {
        $titre = trim($_POST['titre'] ?? '');
        $auteur = trim($_POST['auteur'] ?? '');
        $annee = trim($_POST['annee'] ?? '');
        if ($titre !== '') {
            $books[] = ['id' => getNextId($books), 'titre' => $titre, 'auteur' => $auteur, 'annee' => $annee];
            saveBooks($dataFile, $books);
            $message = "Livre ajouté !";
        } else {
            $message = "Le titre est obligatoire.";
        }
    }

    elseif ($_POST['action'] === 'supprimer') {
        $id = (int)$_POST['id'];
        $books = array_filter($books, fn($b) => $b['id'] !== $id);
        saveBooks($dataFile, $books);
        $message = "Livre supprimé.";
    }

    elseif ($_POST['action'] === 'modifier') {
        $id = (int)$_POST['id'];
        $titre = trim($_POST['titre'] ?? '');
        $auteur = trim($_POST['auteur'] ?? '');
        $annee = trim($_POST['annee'] ?? '');
        if ($titre !== '') {
            foreach ($books as &$book) {
                if ($book['id'] === $id) {
                    $book['titre'] = $titre;
                    $book['auteur'] = $auteur;
                    $book['annee'] = $annee;
                    break;
                }
            }
            unset($book);
            saveBooks($dataFile, $books);
            $message = "Livre modifié !";
        }
    }
}

$books = loadBooks($dataFile);
$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : null;
$editBook = null;
if ($editId) {
    foreach ($books as $b) {
        if ($b['id'] === $editId) { $editBook = $b; break; }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma Librairie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
            background: #f5f5f5;
            color: #333;
        }

        h1 { color: #333; }
        h2 { margin-bottom: 10px; }

        .message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        input[type="text"], input[type="number"] {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button, a.btn {
            padding: 6px 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-blue   { background: #007bff; color: white; }
        .btn-red    { background: #dc3545; color: white; }
        .btn-green  { background: #28a745; color: white; }
        .btn-gray   { background: #6c757d; color: white; }

        form.inline { display: inline; }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 15px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th { background: #eee; }
        tr:hover { background: #f9f9f9; }

        section {
            background: white;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<h1>📚 Ma Librairie</h1>

<?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

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
    <?php else: ?>
        <h2>Ajouter un livre</h2>
        <form method="POST">
            <input type="hidden" name="action" value="ajouter">
            <input type="text" name="titre" placeholder="Titre" required>
            <input type="text" name="auteur" placeholder="Auteur">
            <input type="number" name="annee" placeholder="Année" style="width:80px">
            <button type="submit" class="btn-blue">Ajouter</button>
        </form>
    <?php endif; ?>
</section>

</body>
</html>