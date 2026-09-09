<h2>Liste des Salles</h2>

<a href="/salles/creer" role="button" style="margin-bottom: 20px; display: inline-block;">Ajouter une Salle</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Bâtiment</th>
            <th>Capacité</th>
            <th>Type</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($salles as $salle): ?>
            <tr>
                <td><?= \App\View\e((string)$salle->id) ?></td>
                <td><?= \App\View\e($salle->nom) ?></td>
                <td><?= \App\View\e($salle->batiment) ?></td>
                <td><?= \App\View\e((string)$salle->capacite) ?> p.</td>
                <td><?= \App\View\e($salle->type) ?></td>
                <td>
                    <mark><?= ($salle->active ?? true) ? 'Active' : 'Inactive' ?></mark>
                </td>
                <td>
                    <a href="/salles/<?= \App\View\e((string)$salle->id) ?>">Voir</a> | 
                    <a href="/salles/<?= \App\View\e((string)$salle->id) ?>/editer">Éditer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>