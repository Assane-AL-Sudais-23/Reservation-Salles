<?php use function App\View\e; ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #f3f4f6; padding-bottom: 1rem;">
    <div>
        <h2 style="margin: 0; font-size: 1.5rem; color: #111827;">Liste des Salles</h2>
        <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.875rem;">Consultez et gérez les salles disponibles pour la réservation.</p>
    </div>
    <?php if ($utilisateurConnecte?->role === \App\Security\Role::ADMIN): ?>
        <a href="/salle/create" style="text-decoration: none; font-weight: 600; color: #ffffff; background-color: #2563eb; padding: 0.625rem 1.25rem; border-radius: 6px; font-size: 0.875rem;">
            + Ajouter une Salle
        </a>
    <?php endif; ?>
</div>

<div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
        <thead>
            <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #374151;">
                <th style="padding: 0.75rem 1rem;">ID</th>
                <th style="padding: 0.75rem 1rem;">Nom</th>
                <th style="padding: 0.75rem 1rem;">Bâtiment</th>
                <th style="padding: 0.75rem 1rem;">Capacité</th>
                <th style="padding: 0.75rem 1rem;">Type</th>
                <th style="padding: 0.75rem 1rem;">Statut</th>
                <th style="padding: 0.75rem 1rem; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($salles->isEmpty()): ?>
                <tr>
                    <td colspan="7" style="padding: 2rem; text-align: center; color: #6b7280;">
                        Aucune salle n'a été trouvée.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($salles as$salle): ?>
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 0.75rem 1rem; font-weight: 600; color: #111827;">#<?= e((string)$salle->id) ?></td>
                        <td style="padding: 0.75rem 1rem; font-weight: 500; color: #1f2937;"><?= e($salle->nom) ?></td>
                        <td style="padding: 0.75rem 1rem; color: #4b5563;"><?= e($salle->batiment) ?></td>
                        <td style="padding: 0.75rem 1rem; color: #4b5563;"><?= e((string)$salle->capacite) ?> pers.</td>
                        <td style="padding: 0.75rem 1rem; color: #4b5563;"><?= e($salle->type) ?></td>
                        <td style="padding: 0.75rem 1rem;">
                            <?php if ($salle->active): ?>
                                <span style="background-color: #ecfdf5; color: #065f46; padding: 0.25rem 0.625rem; border-radius: 9999px; font-weight: 500; font-size: 0.75rem;">
                                    Disponible
                                </span>
                            <?php else: ?>
                                <span style="background-color: #f3f4f6; color: #6b7280; padding: 0.25rem 0.625rem; border-radius: 9999px; font-weight: 500; font-size: 0.75rem;">
                                    Indisponible
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 0.75rem 1rem; text-align: right; white-space: nowrap;">
                            <!-- Aligné sur /salle/{id} -->
                            <a href="/salle/<?= e((string)$salle->id) ?>" style="color: #2563eb; text-decoration: none; font-weight: 500; margin-right: 0.75rem;">
                                Voir
                            </a>
                            <?php if ($utilisateurConnecte?->role === \App\Security\Role::ADMIN): ?>
                                <!-- Aligné sur la route GET /salle/{id}/edit du routeur -->
                                <a href="/salle/<?= e((string)$salle->id) ?>/edit" style="color: #4b5563; text-decoration: none; font-weight: 500;">
                                    Éditer
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>