<?php
$title = 'Liste des salles';
?>

<h2>Liste des salles</h2>

<a href="/salles/create">Ajouter une salle</a>

<?php if (empty($salles)): ?>
    <p>Aucune salle disponible.</p>
<?php else: ?>

    <ul>
        <?php foreach ($salles as $salle): ?>
            <li>
                <?= htmlspecialchars($salle->nom) ?>
                -
                <?= htmlspecialchars($salle->batiment) ?>
                -
                <?= htmlspecialchars((string) $salle->capacite) ?> places

                <a href="/salles/<?= $salle->id ?>">
                    Voir
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>