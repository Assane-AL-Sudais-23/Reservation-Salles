<?php use function App\View\e; ?>

<div style="max-width: 700px; margin: 0 auto;">

    <!-- En-tête -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #f3f4f6; padding-bottom: 1rem;">
        <div>
            <h2 style="margin: 0; font-size: 1.5rem; color: #111827;">Détails de la Réservation #<?= e((string)$reservation->id) ?></h2>
            <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.875rem;">Consultez les informations complètes de cette réservation.</p>
        </div>
        <a href="/reservation" style="text-decoration: none; color: #4b5563; background-color: #f3f4f6; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 500; font-size: 0.875rem;">
            ← Retour à la liste
        </a>
    </div>

    <!-- Carte d'informations -->
    <div style="display: grid; gap: 1.25rem; background-color: #f9fafb; padding: 1.5rem; border-radius: 8px; border: 1px solid #e5e7eb; margin-bottom: 2rem;">
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem;">
            <div>
                <span style="font-size: 0.75rem; text-transform: uppercase; color: #6b7280; font-weight: 600; display: block;">Salle Réservée</span>
                <span style="font-size: 1.125rem; font-weight: 600; color: #111827;"><?= e($reservation->salleNom) ?></span>
            </div>
            <div>
                <span style="font-size: 0.75rem; text-transform: uppercase; color: #6b7280; font-weight: 600; display: block;">Statut</span>
                <?php if ($reservation->statut === 'annulee'): ?>
                    <span style="display: inline-block; background-color: #fef2f2; color: #991b1b; padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem; margin-top: 0.25rem;">
                        Annulée
                    </span>
                <?php else: ?>
                    <span style="display: inline-block; background-color: #ecfdf5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem; margin-top: 0.25rem;">
                        <?= e(ucfirst($reservation->statut)) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <span style="font-size: 0.75rem; text-transform: uppercase; color: #6b7280; font-weight: 600; display: block;">Responsable</span>
                <span style="font-size: 0.875rem; color: #1f2937; font-weight: 500;"><?= e($reservation->responsable) ?></span>
            </div>
            <div>
                <span style="font-size: 0.75rem; text-transform: uppercase; color: #6b7280; font-weight: 600; display: block;">Email de contact</span>
                <a href="mailto:<?= e($reservation->email) ?>" style="font-size: 0.875rem; color: #2563eb; text-decoration: none;"><?= e($reservation->email) ?></a>
            </div>
        </div>

        <div>
            <span style="font-size: 0.75rem; text-transform: uppercase; color: #6b7280; font-weight: 600; display: block;">Motif de la réservation</span>
            <span style="font-size: 0.875rem; color: #374151;"><?= e($reservation->motif) ?></span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1rem;">
            <div>
                <span style="font-size: 0.75rem; text-transform: uppercase; color: #6b7280; font-weight: 600; display: block;">Date de Début</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;"><?= e($reservation->dateDebut) ?></span>
            </div>
            <div>
                <span style="font-size: 0.75rem; text-transform: uppercase; color: #6b7280; font-weight: 600; display: block;">Date de Fin</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;"><?= e($reservation->dateFin) ?></span>
            </div>
        </div>

    </div>

    <!-- Zone d'action (Annulation) -->
    <?php if ($reservation->statut !== 'annulee'): ?>
        <div style="text-align: right;">
            <form action="/reservation/<?= e((string)$reservation->id) ?>/cancel" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                <button type="submit" style="background-color: #dc2626; color: #ffffff; border: none; padding: 0.625rem 1.25rem; font-weight: 600; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">
                    Annuler cette réservation
                </button>
            </form>
        </div>
    <?php endif; ?>

</div>