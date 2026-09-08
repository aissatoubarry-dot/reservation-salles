<?php
$title = 'Détail de la salle';
?>

<h2>Détail de la salle</h2>

<p>
    <strong>Nom :</strong>
    <?= htmlspecialchars($salle->nom) ?>
</p>

<p>
    <strong>Bâtiment :</strong>
    <?= htmlspecialchars($salle->batiment) ?>
</p>

<p>
    <strong>Capacité :</strong>
    <?= htmlspecialchars((string) $salle->capacite) ?> places
</p>

<p>
    <strong>Type :</strong>
    <?= htmlspecialchars($salle->type) ?>
</p>

<p>
    <strong>État :</strong>
    <?= $salle->active ? 'Active' : 'Inactive' ?>
</p>

<a href="/salles">Retour à la liste</a>
<a href="/salles/<?= $salle->id ?>/edit">Modifier</a>