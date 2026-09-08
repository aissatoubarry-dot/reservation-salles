<?php
$title = 'Liste des réservations';
?>

<h2>Liste des réservations</h2>

<a href="/reservations/create">Nouvelle réservation</a>

<?php if (empty($reservations)): ?>

    <p>Aucune réservation disponible.</p>

<?php else: ?>

    <ul>
        <?php foreach ($reservations as $reservation): ?>
            <li>
                Salle :
                <?= htmlspecialchars($reservation->salle?->nom ?? 'Salle inconnue') ?>

                -
                Responsable :
                <?= htmlspecialchars($reservation->responsable) ?>

                -
                Début :
                <?= htmlspecialchars($reservation->date_debut->format('d/m/Y H:i')) ?>

                -
                Statut :
                <?= htmlspecialchars($reservation->statut) ?>

                <a href="/reservations/<?= $reservation->id ?>">
                    Voir
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>