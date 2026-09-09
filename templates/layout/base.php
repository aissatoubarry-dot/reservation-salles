<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? 'Réservation de salles') ?></title>

    <link rel="stylesheet" href="/assets/style.css">
</head>

<body>

<header class="navbar">
    <div class="container">

        <h1>Gestion des réservations de salles</h1>

        <nav>
            <a href="/">Accueil</a>
            <a href="/salles">Salles</a>
            <a href="/reservations">Réservations</a>
        </nav>

    </div>
</header>

<main class="container">

    <?= $content ?? '' ?>

</main>

<footer>
    <div class="container">
        <p>
            &copy; <?= date('Y') ?> -
            Réservation de salles universitaires
        </p>
    </div>
</footer>

</body>

</html>