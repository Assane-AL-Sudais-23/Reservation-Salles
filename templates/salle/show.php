<article>
    <header>
        <h2>Salle : <?= \App\View\e($salle->nom) ?></h2>
    </header>
    
    <p><strong>Bâtiment :</strong> <?= \App\View\e($salle->batiment) ?></p>
    <p><strong>Capacité :</strong> <?= \App\View\e((string)$salle->capacite) ?> personnes</p>
    <p><strong>Type :</strong> <?= \App\View\e($salle->type) ?></p>
    <p><strong>Statut :</strong> <?= ($salle->active ?? true) ? 'Active' : 'Inactive' ?></p>

    <footer>
        <a href="/salles" role="button" class="secondary">Retour à la liste</a>
        <a href="/salles/<?= \App\View\e((string)$salle->id) ?>/editer" role="button">Éditer</a>
    </footer>
</article>