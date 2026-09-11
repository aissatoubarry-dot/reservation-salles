<?php

/** @var \App\Model\Reservation $reservation */

$title = 'Détail de la réservation';

?>
<?php

$title = 'Détail de la réservation';

?>

<div class="page-title">

    <div>
        <h2>Détail de la réservation</h2>
        <p>Informations concernant cette réservation.</p>
    </div>

    <a href="/reservations" class="btn btn-secondary">
        ← Retour
    </a>

</div>


<div class="card reservation-detail">

    <div class="detail-list">

        <div class="detail-label">
            Salle
        </div>

        <div>
            <?= htmlspecialchars($reservation->salle?->nom ?? 'Salle inconnue') ?>
        </div>


        <div class="detail-label">
            Bâtiment
        </div>

        <div>
            <?= htmlspecialchars($reservation->salle?->batiment ?? '-') ?>
        </div>


        <div class="detail-label">
            Responsable
        </div>

        <div>
            <?= htmlspecialchars($reservation->responsable) ?>
        </div>


        <div class="detail-label">
            Email
        </div>

        <div>
            <?= htmlspecialchars($reservation->email) ?>
        </div>


        <div class="detail-label">
            Motif
        </div>

        <div>
            <?= htmlspecialchars($reservation->motif) ?>
        </div>


        <div class="detail-label">
            Date de début
        </div>

        <div>
            <?= $reservation->date_debut?->format('d/m/Y à H:i') ?>
        </div>


        <div class="detail-label">
            Date de fin
        </div>

        <div>
            <?= $reservation->date_fin?->format('d/m/Y à H:i') ?>
        </div>


        <div class="detail-label">
            Statut
        </div>

        <div>

            <?php if ($reservation->statut === 'confirmée'): ?>

                <span class="badge badge-success">
                    Confirmée
                </span>

            <?php else: ?>

                <span class="badge badge-danger">
                    Annulée
                </span>

            <?php endif; ?>

        </div>

    </div>


    <?php if ($reservation->statut === 'confirmée'): ?>

        <div class="detail-actions">

            <form
                method="POST"
                action="/reservations/<?= $reservation->id ?>/cancel"
            >

                <button
                    type="submit"
                    class="btn btn-danger"
                >
                    Annuler la réservation
                </button>

            </form>

        </div>

    <?php endif; ?>

</div>