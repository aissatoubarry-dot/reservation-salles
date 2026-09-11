<?php

/** @var \App\Model\Salle $salle */

$title = 'Détail de la salle';

?>

<div class="page-title">

    <div>
        <h2><?= htmlspecialchars($salle->nom) ?></h2>
        <p>Informations concernant cette salle.</p>
    </div>

    <a href="/salles" class="btn btn-secondary">
        ← Retour
    </a>

</div>


<div class="card reservation-detail">

    <div class="detail-list">

        <div class="detail-label">
            Nom
        </div>

        <div>
            <?= htmlspecialchars($salle->nom) ?>
        </div>


        <div class="detail-label">
            Bâtiment
        </div>

        <div>
            <?= htmlspecialchars($salle->batiment) ?>
        </div>


        <div class="detail-label">
            Capacité
        </div>

        <div>
            <?= htmlspecialchars((string) $salle->capacite) ?>
            places
        </div>


        <div class="detail-label">
            Type
        </div>

        <div>
            <?= htmlspecialchars(ucfirst($salle->type)) ?>
        </div>


        <div class="detail-label">
            Statut
        </div>

        <div>

            <?php if ($salle->active): ?>

                <span class="badge badge-success">
                    Active
                </span>

            <?php else: ?>

                <span class="badge badge-danger">
                    Inactive
                </span>

            <?php endif; ?>

        </div>

    </div>


    <div class="detail-actions">

        <a
            href="/salles/<?= $salle->id ?>/edit"
            class="btn btn-secondary"
        >
            Modifier
        </a>

        <?php if ($salle->active): ?>

            <a
                href="/reservations/create"
                class="btn btn-success"
            >
                Réserver cette salle
            </a>

        <?php endif; ?>

    </div>

</div>