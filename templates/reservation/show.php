<?php
$title = 'Détail de la réservation';
?>

<h2>Détail de la réservation</h2>

<p>
    <strong>Salle :</strong>
    <?= htmlspecialchars($reservation->salle?->nom ?? 'Salle inconnue') ?>
</p>

<p>
    <strong>Responsable :</strong>
    <?= htmlspecialchars($reservation->responsable) ?>
</p>

<p>
    <strong>Email :</strong>
    <?= htmlspecialchars($reservation->email) ?>
</p>

<p>
    <strong>Motif :</strong>
    <?= htmlspecialchars($reservation->motif) ?>
</p>

<p>
    <strong>Date de début :</strong>
    <?= htmlspecialchars($reservation->date_debut->format('d/m/Y H:i')) ?>
</p>

<p>
    <strong>Date de fin :</strong>
    <?= htmlspecialchars($reservation->date_fin->format('d/m/Y H:i')) ?>
</p>

<p>
    <strong>Statut :</strong>
    <?= htmlspecialchars($reservation->statut) ?>
</p>

<a href="/reservations">Retour à la liste</a>

<?php if ($reservation->statut === 'confirmée'): ?>
    <form method="POST" action="/reservations/<?= $reservation->id ?>/cancel">
        <button type="submit">Annuler la réservation</button>
    </form>
<?php endif; ?>

