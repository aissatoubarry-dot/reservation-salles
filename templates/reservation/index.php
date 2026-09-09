<?php

$title = 'Liste des réservations';

?>

<div class="page-title">
    <div>
        <h2>Liste des réservations</h2>
        <p>Consultez et gérez les réservations des salles.</p>
    </div>

    <a href="/reservations/create" class="btn btn-success">
        + Nouvelle réservation
    </a>
</div>


<?php if (empty($reservations)): ?>

    <div class="card">
        <p>Aucune réservation enregistrée.</p>

        <a href="/reservations/create" class="btn btn-success">
            Créer une réservation
        </a>
    </div>

<?php else: ?>

    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>Salle</th>
                    <th>Responsable</th>
                    <th>Motif</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($reservations as $reservation): ?>

                    <tr>

                        <td>
                            <strong>
                                <?= htmlspecialchars($reservation->salle?->nom ?? 'Salle inconnue') ?>
                            </strong>
                        </td>

                        <td>
                            <?= htmlspecialchars($reservation->responsable) ?>
                            <br>
                            <small>
                                <?= htmlspecialchars($reservation->email) ?>
                            </small>
                        </td>

                        <td>
                            <?= htmlspecialchars($reservation->motif) ?>
                        </td>

                        <td>
                            <?= $reservation->date_debut?->format('d/m/Y H:i') ?>
                        </td>

                        <td>
                            <?= $reservation->date_fin?->format('d/m/Y H:i') ?>
                        </td>

                        <td>

                            <?php if ($reservation->statut === 'confirmée'): ?>

                                <span class="badge badge-success">
                                    Confirmée
                                </span>

                            <?php else: ?>

                                <span class="badge badge-danger">
                                    Annulée
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="/reservations/<?= $reservation->id ?>"
                                    class="btn btn-primary"
                                >
                                    Voir
                                </a>

                                <?php if ($reservation->statut === 'confirmée'): ?>

                                    <form
                                        method="POST"
                                        action="/reservations/<?= $reservation->id ?>/cancel"
                                    >
                                        <button
                                            type="submit"
                                            class="btn btn-danger"
                                        >
                                            Annuler
                                        </button>
                                    </form>

                                <?php endif; ?>

                            </div>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

<?php endif; ?>