<?php use function App\View\e; ?>

<div style="max-width: 650px; margin: 0 auto;">

    <!-- En-tête -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #f3f4f6; padding-bottom: 1rem;">
        <div>
            <h2 style="margin: 0; font-size: 1.5rem; color: #111827;">Détails de la Salle</h2>
            <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.875rem;">Fiche descriptive et équipements de la salle.</p>
        </div>
        <a href="/salle" style="text-decoration: none; color: #4b5563; background-color: #f3f4f6; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 500; font-size: 0.875rem;">
            ← Retour à la liste
        </a>
    </div>

    <!-- Carte de détails -->
    <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 8px; border: 1px solid #e5e7eb; display: grid; gap: 1.25rem; margin-bottom: 2rem;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem;">
            <div>
                <span style="font-size: 0.75rem; text-transform: uppercase; color: #6b7280; font-weight: 600; display: block;">Nom de la salle</span>
                <span style="font-size: 1.25rem; font-weight: 700; color: #111827;"><?= e($salle->nom) ?></span>
            </div>
            <div>
                <?php if ($salle->active): ?>
                    <span style="background-color: #ecfdf5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem;">
                        Disponible
                    </span>
                <?php else: ?>
                    <span style="background-color: #f3f4f6; color: #6b7280; padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem;">
                        Indisponible
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <span style="font-size: 0.75rem; text-transform: uppercase; color: #6b7280; font-weight: 600; display: block;">Bâtiment</span>
                <span style="font-size: 0.875rem; color: #1f2937; font-weight: 500;"><?= e($salle->batiment) ?></span>
            </div>
            <div>
                <span style="font-size: 0.75rem; text-transform: uppercase; color: #6b7280; font-weight: 600; display: block;">Capacité d'accueil</span>
                <span style="font-size: 0.875rem; color: #1f2937; font-weight: 500;"><?= e((string)$salle->capacite) ?> personnes</span>
            </div>
        </div>

        <div>
            <span style="font-size: 0.75rem; text-transform: uppercase; color: #6b7280; font-weight: 600; display: block;">Type d'espace</span>
            <span style="font-size: 0.875rem; color: #1f2937; font-weight: 500;"><?= e($salle->type) ?></span>
        </div>

    </div>

    <!-- Actions (Bouton d'édition aligné sur la route GET /salle/{id}/edit) -->
    <?php if ($utilisateurConnecte?->role === \App\Security\Role::ADMIN): ?>
        <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
            <a href="/salle/<?= e((string)$salle->id) ?>/edit" style="text-decoration: none; font-weight: 600; color: #ffffff; background-color: #2563eb; padding: 0.625rem 1.25rem; border-radius: 6px; font-size: 0.875rem;">
                Éditer cette salle
            </a>
        </div>
    <?php endif; ?>

</div>