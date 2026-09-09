<?php

$salle = $salle ?? null;
$data = $data ?? [];
$errors = $errors ?? [];
$action = $action ?? '/salles';

$title = $salle ? 'Modifier une salle' : 'Ajouter une salle';

$nom = $data['nom'] ?? $salle?->nom ?? '';
$batiment = $data['batiment'] ?? $salle?->batiment ?? '';
$capacite = $data['capacite'] ?? $salle?->capacite ?? '';
$type = $data['type'] ?? $salle?->type ?? 'cours';

$active = array_key_exists('active', $data)
    ? (bool) $data['active']
    : ($salle?->active ?? true);

?>

<div class="page-title">
    <div>
        <h2><?= $salle ? 'Modifier la salle' : 'Ajouter une salle' ?></h2>
        <p>
            <?= $salle
                ? 'Modifiez les informations de cette salle.'
                : 'Renseignez les informations de la nouvelle salle.'
            ?>
        </p>
    </div>

    <a href="/salles" class="btn btn-secondary">
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
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>

    <?php endif; ?>


    <form method="POST" action="<?= htmlspecialchars($action) ?>">

        <div class="form-group">
            <label for="nom">Nom de la salle</label>

            <input
                type="text"
                id="nom"
                name="nom"
                value="<?= htmlspecialchars($nom) ?>"
                placeholder="Ex : Salle B12"
                required
            >
        </div>


        <div class="form-group">
            <label for="batiment">Bâtiment</label>

            <input
                type="text"
                id="batiment"
                name="batiment"
                value="<?= htmlspecialchars($batiment) ?>"
                placeholder="Ex : B"
                required
            >
        </div>


        <div class="form-group">
            <label for="capacite">Capacité</label>

            <input
                type="number"
                id="capacite"
                name="capacite"
                value="<?= htmlspecialchars((string) $capacite) ?>"
                min="1"
                max="1000"
                placeholder="Ex : 40"
                required
            >

            <small>
                Entre 1 et 1000 places.
            </small>
        </div>


        <div class="form-group">
            <label for="type">Type de salle</label>

            <select id="type" name="type" required>

                <option value="cours" <?= $type === 'cours' ? 'selected' : '' ?>>
                    Cours
                </option>

                <option value="informatique" <?= $type === 'informatique' ? 'selected' : '' ?>>
                    Informatique
                </option>

                <option value="laboratoire" <?= $type === 'laboratoire' ? 'selected' : '' ?>>
                    Laboratoire
                </option>

                <option value="amphitheatre" <?= $type === 'amphitheatre' ? 'selected' : '' ?>>
                    Amphithéâtre
                </option>

                <option value="reunion" <?= $type === 'reunion' ? 'selected' : '' ?>>
                    Réunion
                </option>

            </select>
        </div>


        <div class="form-group checkbox-group">

            <input
                type="checkbox"
                id="active"
                name="active"
                value="1"
                <?= $active ? 'checked' : '' ?>
            >

            <label for="active">
                Salle active
            </label>

        </div>


        <div class="actions">

            <button type="submit" class="btn btn-primary">
                <?= $salle ? 'Enregistrer les modifications' : 'Enregistrer la salle' ?>
            </button>

            <a href="/salles" class="btn btn-secondary">
                Annuler
            </a>

        </div>

    </form>

</div>