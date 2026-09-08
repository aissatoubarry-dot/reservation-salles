<?php
$title = $salle ? 'Modifier une salle' : 'Ajouter une salle';
?>

<h2><?= htmlspecialchars($title) ?></h2>

<?php if (!empty($errors)): ?>
    <div>
        <p>Veuillez corriger les erreurs :</p>
        <ul>
            <?php foreach ($errors as $fieldErrors): ?>
                <?php foreach ($fieldErrors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="<?= htmlspecialchars($action) ?>">

    <div>
        <label for="nom">Nom</label>
        <input
            type="text"
            id="nom"
            name="nom"
            value="<?= htmlspecialchars($data['nom'] ?? $salle?->nom ?? '') ?>"
        >
        <?php if (!empty($errors['nom'])): ?>
            <?php foreach ($errors['nom'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div>
        <label for="batiment">Bâtiment</label>
        <input
            type="text"
            id="batiment"
            name="batiment"
            value="<?= htmlspecialchars($data['batiment'] ?? $salle?->batiment ?? '') ?>"
        >
        <?php if (!empty($errors['batiment'])): ?>
            <?php foreach ($errors['batiment'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div>
        <label for="capacite">Capacité</label>
        <input
            type="number"
            id="capacite"
            name="capacite"
            value="<?= htmlspecialchars((string) ($data['capacite'] ?? $salle?->capacite ?? '')) ?>"
        >
        <?php if (!empty($errors['capacite'])): ?>
            <?php foreach ($errors['capacite'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div>
        <label for="type">Type</label>
        <select id="type" name="type">
            <?php foreach ([
                'cours',
                'informatique',
                'laboratoire',
                'amphitheatre',
                'reunion'
            ] as $type): ?>
                <option
                    value="<?= htmlspecialchars($type) ?>"
                    <?= (($data['type'] ?? $salle?->type ?? '') === $type) ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars($type) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label>
            <input
                type="checkbox"
                name="active"
                value="1"
                <?= (($data['active'] ?? $salle?->active ?? true)) ? 'checked' : '' ?>
            >
            Salle active
        </label>
    </div>

    <button type="submit">Enregistrer</button>

</form>

<a href="/salles">Retour à la liste</a>