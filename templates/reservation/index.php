<h2>Liste des Réservations</h2>

<a href="/reservations/creer" role="button" style="margin-bottom: 20px; display: inline-block;">Nouvelle Réservation</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Salle</th>
            <th>Responsable</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservations as $res): ?>
            <tr>
                <td><?= \App\View\e((string)$res->id) ?></td>
                <td><?= \App\View\e($res->salle->nom ?? 'N/A') ?></td>
                <td><?= \App\View\e($res->responsable) ?></td>
                <td><?= \App\View\e((string)$res->date_debut) ?></td>
                <td><?= \App\View\e((string)$res->date_fin) ?></td>
                <td>
                    <mark style="<?= $res->statut === 'annulee' ? 'background-color: #ffcdd2; color: #b71c1c;' : '' ?>">
                        <?= \App\View\e($res->statut ?? 'confirmée') ?>
                    </mark>
                </td>
                <td>
                    <a href="/reservations/<?= \App\View\e((string)$res->id) ?>">Détails</a>
                    <?php if (($res->statut ?? '') !== 'annulee'): ?>
                        | <a href="/reservations/<?= \App\View\e((string)$res->id) ?>/annuler" 
                             onclick="return confirm('Confirmer l\'annulation ?')">Annuler</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>