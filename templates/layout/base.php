<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? 'Réservation de salles') ?></title>
</head>

<body>

<header>
    <h1>Gestion des réservations de salles</h1>

    <nav>
        <a href="/">Accueil</a>
        <a href="/salles">Salles</a>
        <a href="/reservations">Réservations</a>
    </nav>
</header>

<main>
    <?= $content ?? '' ?>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> - Réservation de salles universitaires</p>
</footer>

</body>
</html>