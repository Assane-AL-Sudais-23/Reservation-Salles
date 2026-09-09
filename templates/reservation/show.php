<article>
    <header>
        <h2>Réservation #<?= \App\View\e((string)$reservation->id) ?></h2>
    </header>

    <p><strong>Salle :</strong> <?= \App\View\e($reservation->salle->nom ?? 'Inconnue') ?></p>
    <p><strong>Responsable :</strong> <?= \App\View\e($reservation->responsable) ?></p>
    <p><strong>Email :</strong> <?= \App\View\e($reservation->email) ?></p>
    <p><strong>Motif :</strong> <?= \App\View\e($reservation->motif) ?></p>
    <p><strong>Début :</strong> <?= \App\View\e((string)$reservation->date_debut) ?></p>
    <p><strong>Fin :</strong> <?= \App\View\e((string)$reservation->date_fin) ?></p>
    <p><strong>Statut :</strong> <?= \App\View\e($reservation->statut ?? 'confirmée') ?></p>

    <footer>
        <a href="/reservations" role="button" class="secondary">Retour</a>
    </footer>
</article>