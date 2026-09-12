<?php use function App\View\e; ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #f3f4f6; padding-bottom: 1rem;">
    <div>
        <h2 style="margin: 0; font-size: 1.5rem; color: #111827;">Liste des Réservations</h2>
        <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.875rem;">Affichez et gérez l'ensemble des réservations enregistrées.</p>
    </div>
    <a href="/reservation/create" style="text-decoration: none; font-weight: 600; color: #ffffff; background-color: #2563eb; padding: 0.625rem 1.25rem; border-radius: 6px; font-size: 0.875rem;">
        + Nouvelle Réservation
    </a>
</div>

<div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
        <thead>
            <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #374151;">
                <th style="padding: 0.75rem 1rem;">ID</th>
                <th style="padding: 0.75rem 1rem;">Salle</th>
                <th style="padding: 0.75rem 1rem;">Responsable</th>
                <th style="padding: 0.75rem 1rem;">Début</th>
                <th style="padding: 0.75rem 1rem;">Fin</th>
                <th style="padding: 0.75rem 1rem;">Statut</th>
                <th style="padding: 0.75rem 1rem; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($reservations->isEmpty()): ?>
                <tr>
                    <td colspan="7" style="padding: 2rem; text-align: center; color: #6b7280;">
                        Aucune réservation enregistrée pour le moment.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($reservations as $res): ?>
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 0.75rem 1rem; font-weight: 600; color: #111827;">#<?= e((string)$res->id) ?></td>
                        <td style="padding: 0.75rem 1rem; font-weight: 500; color: #1f2937;"><?= e($res->salleNom) ?></td>
                        <td style="padding: 0.75rem 1rem; color: #4b5563;"><?= e($res->responsable) ?></td>
                        <td style="padding: 0.75rem 1rem; color: #6b7280;"><?= e($res->dateDebut) ?></td>
                        <td style="padding: 0.75rem 1rem; color: #6b7280;"><?= e($res->dateFin) ?></td>
                        <td style="padding: 0.75rem 1rem;">
                            <?php if ($res->statut === 'annulee'): ?>
                                <span style="background-color: #fef2f2; color: #991b1b; padding: 0.25rem 0.625rem; border-radius: 9999px; font-weight: 500; font-size: 0.75rem;">
                                    Annulée
                                </span>
                            <?php else: ?>
                                <span style="background-color: #ecfdf5; color: #065f46; padding: 0.25rem 0.625rem; border-radius: 9999px; font-weight: 500; font-size: 0.75rem;">
                                    <?= e(ucfirst($res->statut)) ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 0.75rem 1rem; text-align: right; white-space: nowrap;">
                            <a href="/reservation/<?= e((string)$res->id) ?>" style="color: #2563eb; text-decoration: none; font-weight: 500; margin-right: 0.75rem;">
                                Voir
                            </a>
                            
                            <?php if ($res->statut !== 'annulee'): ?>
                                <!-- Soumission POST conforme à la route /reservation/{id}/cancel -->
                                <form action="/reservation/<?= e((string)$res->id) ?>/cancel" method="POST" style="display: inline;" onsubmit="return confirm('Confirmer l\'annulation de cette réservation ?');">
                                    <button type="submit" style="background: none; border: none; color: #dc2626; text-decoration: underline; cursor: pointer; padding: 0; font-size: 0.875rem;">
                                        Annuler
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>