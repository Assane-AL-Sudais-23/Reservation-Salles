<h2>Réserver une Salle</h2>

<?php if (isset($errors['global'])): ?>
    <article style="background-color: #ffcdd2; color: #b71c1c;">
        <?= \App\View\e($errors['global']) ?>
    </article>
<?php endif; ?>

<form action="/reservations/creer" method="POST">
    <label for="salle_id">Salle</label>
    <select name="salle_id" id="salle_id">
        <?php foreach ($salles as $salle): ?>
            <option value="<?= \App\View\e((string)$salle->id) ?>" <?= ($old['salle_id'] ?? '') == $salle->id ? 'selected' : '' ?>>
                <?= \App\View\e($salle->nom) ?> (Capacité: <?= \App\View\e((string)$salle->capacite) ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($errors['salle_id'])): ?>
        <small style="color: red;"><?= \App\View\e($errors['salle_id']) ?></small>
    <?php endif; ?>

    <label for="responsable">Responsable</label>
    <input type="text" name="responsable" id="responsable" value="<?= \App\View\e($old['responsable'] ?? '') ?>">
    <?php if (isset($errors['responsable'])): ?>
        <small style="color: red;"><?= \App\View\e($errors['responsable']) ?></small>
    <?php endif; ?>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="<?= \App\View\e($old['email'] ?? '') ?>">
    <?php if (isset($errors['email'])): ?>
        <small style="color: red;"><?= \App\View\e($errors['email']) ?></small>
    <?php endif; ?>

    <label for="motif">Motif</label>
    <input type="text" name="motif" id="motif" value="<?= \App\View\e($old['motif'] ?? '') ?>">
    <?php if (isset($errors['motif'])): ?>
        <small style="color: red;"><?= \App\View\e($errors['motif']) ?></small>
    <?php endif; ?>

    <label for="date_debut">Date de Début</label>
    <input type="datetime-local" name="date_debut" id="date_debut" value="<?= \App\View\e($old['date_debut'] ?? '') ?>">
    <?php if (isset($errors['date_debut'])): ?>
        <small style="color: red;"><?= \App\View\e($errors['date_debut']) ?></small>
    <?php endif; ?>

    <label for="date_fin">Date de Fin</label>
    <input type="datetime-local" name="date_fin" id="date_fin" value="<?= \App\View\e($old['date_fin'] ?? '') ?>">
    <?php if (isset($errors['date_fin'])): ?>
        <small style="color: red;"><?= \App\View\e($errors['date_fin']) ?></small>
    <?php endif; ?>

    <button type="submit">Valider la Réservation</button>
</form>