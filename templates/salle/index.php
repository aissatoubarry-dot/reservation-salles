<?php

$title = 'Liste des salles';

?>

<div class="page-title">
    <div>
        <h2>Liste des salles</h2>
        <p>Gérez les salles disponibles pour les réservations.</p>
    </div>

    <a href="/salles/create" class="btn btn-primary">
        + Ajouter une salle
    </a>
</div>

<?php if (empty($salles)): ?>

    <div class="card">
        <p>Aucune salle n'est disponible.</p>
    </div>

<?php else: ?>

    <div class="room-grid">

        <?php foreach ($salles as $salle): ?>

            <div class="room-card">

                <div class="room-card-header">
                    <div>
                        <h3>
                            <?= htmlspecialchars($salle->nom) ?>
                        </h3>

                        <span class="room-building">
                            Bâtiment <?= htmlspecialchars($salle->batiment) ?>
                        </span>
                    </div>

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

                <div class="room-info">

                    <div class="room-info-item">
                        <span class="info-label">Capacité</span>
                        <strong>
                            <?= htmlspecialchars((string) $salle->capacite) ?>
                            places
                        </strong>
                    </div>

                    <div class="room-info-item">
                        <span class="info-label">Type</span>
                        <strong>
                            <?= htmlspecialchars(ucfirst($salle->type)) ?>
                        </strong>
                    </div>

                </div>

                <div class="room-actions">

                    <a
                        href="/salles/<?= $salle->id ?>"
                        class="btn btn-primary"
                    >
                        Voir
                    </a>

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
                            Réserver
                        </a>

                    <?php endif; ?>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

<?php endif; ?>