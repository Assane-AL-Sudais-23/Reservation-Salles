<?php $isEdit = isset($salle); ?>

<h2><?= $isEdit ? 'Éditer la Salle' : 'Créer une Salle' ?></h2>

<form action="<?= $isEdit ? '/salles/' . \App\View\e((string)$salle->id) . '/modifier' : '/salles/creer' ?>" method="POST">
    <label for="nom">Nom de la Salle</label>
    <input type="text" name="nom" id="nom" value="<?= \App\View\e($old['nom'] ?? $salle->nom ?? '') ?>">
    <?php if (isset($errors['nom'])): ?>
        <small style="color: red;"><?= \App\View\e($errors['nom']) ?></small>
    <?php endif; ?>

    <label for="batiment">Bâtiment</label>
    <input type="text" name="batiment" id="batiment" value="<?= \App\View\e($old['batiment'] ?? $salle->batiment ?? '') ?>">
    <?php if (isset($errors['batiment'])): ?>
        <small style="color: red;"><?= \App\View\e($errors['batiment']) ?></small>
    <?php endif; ?>

    <label for="capacite">Capacité</label>
    <input type="number" name="capacite" id="capacite" value="<?= \App\View\e((string)($old['capacite'] ?? $salle->capacite ?? '')) ?>">
    <?php if (isset($errors['capacite'])): ?>
        <small style="color: red;"><?= \App\View\e($errors['capacite']) ?></small>
    <?php endif; ?>

    <label for="type">Type</label>
    <input type="text" name="type" id="type" value="<?= \App\View\e($old['type'] ?? $salle->type ?? '') ?>">
    <?php if (isset($errors['type'])): ?>
        <small style="color: red;"><?= \App\View\e($errors['type']) ?></small>
    <?php endif; ?>

    <button type="submit"><?= $isEdit ? 'Mettre à jour' : 'Enregistrer' ?></button>
</form>