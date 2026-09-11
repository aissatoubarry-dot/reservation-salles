<?php

$salles = $salles ?? [];
$data = $data ?? [];
$errors = $errors ?? [];
$action = $action ?? '/reservations';

$title = 'Nouvelle réservation';

$salleId = $data['salle_id'] ?? '';
$responsable = $data['responsable'] ?? '';
$email = $data['email'] ?? '';
$motif = $data['motif'] ?? '';
$dateDebut = $data['date_debut'] ?? '';
$dateFin = $data['date_fin'] ?? '';

/*
 * Pour datetime-local, le navigateur attend :
 * 2026-09-12T13:13
 *
 * Si une validation échoue après conversion en :
 * 2026-09-12 13:13:00
 *
 * on reconvertit pour l'affichage dans le formulaire.
 */
if ($dateDebut !== '') {
    $dateDebut = str_replace(' ', 'T', $dateDebut);
    $dateDebut = substr($dateDebut, 0, 16);
}

if ($dateFin !== '') {
    $dateFin = str_replace(' ', 'T', $dateFin);
    $dateFin = substr($dateFin, 0, 16);
}

?>

<div class="page-title">
    <div>
        <h2>Nouvelle réservation</h2>
        <p>
            Réservez une salle pour votre activité.
        </p>
    </div>

    <a href="/reservations" class="btn btn-secondary">
        ← Retour
    </a>
</div>


<div class="form-card">

    <?php if (!empty($errors)): ?>

        <div class="alert-error">

            <strong>Veuillez corriger les erreurs :</strong>

            <ul>
                <?php foreach ($errors as $fieldErrors): ?>

                    <?php foreach ((array) $fieldErrors as $error): ?>

                        <li>
                            <?= htmlspecialchars($error) ?>
                        </li>

                    <?php endforeach; ?>

                <?php endforeach; ?>
            </ul>

        </div>

    <?php endif; ?>


    <form method="POST" action="<?= htmlspecialchars($action) ?>">

        <!-- Salle -->

        <div class="form-group">

            <label for="salle_id">
                Salle
            </label>

            <select
                id="salle_id"
                name="salle_id"
                required
            >

                <option value="">
                    -- Sélectionner une salle --
                </option>

                <?php foreach ($salles as $salle): ?>

                    <?php if ($salle->active): ?>

                        <option
                            value="<?= $salle->id ?>"
                            <?= (string) $salleId === (string) $salle->id ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($salle->nom) ?>
                            -
                            <?= htmlspecialchars($salle->batiment) ?>
                            -
                            <?= $salle->capacite ?> places
                        </option>

                    <?php endif; ?>

                <?php endforeach; ?>

            </select>

        </div>


        <!-- Responsable -->

        <div class="form-group">

            <label for="responsable">
                Responsable
            </label>

            <input
                type="text"
                id="responsable"
                name="responsable"
                value="<?= htmlspecialchars($responsable) ?>"
                placeholder="Ex : Aïssatou Barry"
                required
            >

        </div>


        <!-- Email -->

        <div class="form-group">

            <label for="email">
                Adresse email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars($email) ?>"
                placeholder="Ex : aissatou@example.com"
                required
            >

        </div>


        <!-- Motif -->

        <div class="form-group">

            <label for="motif">
                Motif de la réservation
            </label>

            <textarea
                id="motif"
                name="motif"
                placeholder="Ex : Réunion pédagogique..."
                required
            ><?= htmlspecialchars($motif) ?></textarea>

            <small>
                Entre 5 et 255 caractères.
            </small>

        </div>


        <!-- Date début -->

        <div class="form-group">

            <label for="date_debut">
                Date et heure de début
            </label>

            <input
                type="datetime-local"
                id="date_debut"
                name="date_debut"
                value="<?= htmlspecialchars($dateDebut) ?>"
                required
            >

        </div>


        <!-- Date fin -->

        <div class="form-group">

            <label for="date_fin">
                Date et heure de fin
            </label>

            <input
                type="datetime-local"
                id="date_fin"
                name="date_fin"
                value="<?= htmlspecialchars($dateFin) ?>"
                required
            >

        </div>


        <!-- Actions -->

        <div class="actions">

            <button
                type="submit"
                class="btn btn-success"
            >
                Réserver
            </button>

            <a
                href="/reservations"
                class="btn btn-secondary"
            >
                Annuler
            </a>

        </div>

    </form>

</div>