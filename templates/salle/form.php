<?php 
use function App\View\e; 

$isEdit = isset($salle);
$actionUrl = $isEdit ? '/salle/' . e((string)$salle->id) . '/edit' : '/salle';
$errors = $errors ?? [];
?>

<div style="max-width: 650px; margin: 0 auto;">

    <!-- En-tête -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #f3f4f6; padding-bottom: 1rem;">
        <div>
            <h2 style="margin: 0; font-size: 1.5rem; color: #111827;"><?= $isEdit ? 'Éditer la Salle' : 'Ajouter une Nouvelle Salle' ?></h2>
            <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.875rem;">Renseignez les caractéristiques de la salle de réunion ou de cours.</p>
        </div>
        <a href="/salle" style="text-decoration: none; color: #4b5563; background-color: #f3f4f6; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 500; font-size: 0.875rem;">
            ← Annuler
        </a>
    </div>

    <!-- Erreur globale -->
    <?php if (isset($errors['global'])): ?>
        <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.875rem;">
            ⚠️ <?= e($errors['global']) ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire -->
    <form action="<?= $actionUrl ?>" method="POST" style="display: grid; gap: 1.25rem;">

        <!-- Nom de la salle -->
        <div>
            <label for="nom" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Nom de la Salle *</label>
            <input type="text" name="nom" id="nom" placeholder="ex: Salle Amphithéâtre A" value="<?= e($old['nom'] ?? $salle->nom ?? '') ?>" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem;">
            <?php if (isset($errors['nom'])): ?>
                <span style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem; display: block;"><?= e($errors['nom']) ?></span>
            <?php endif; ?>
        </div>

        <!-- Bâtiment et Capacité -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <label for="batiment" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Bâtiment *</label>
                <input type="text" name="batiment" id="batiment" placeholder="ex: Bâtiment Principal" value="<?= e($old['batiment'] ?? $salle->batiment ?? '') ?>" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem;">
                <?php if (isset($errors['batiment'])): ?>
                    <span style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem; display: block;"><?= e($errors['batiment']) ?></span>
                <?php endif; ?>
            </div>

            <div>
                <label for="capacite" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Capacité (personnes) *</label>
                <input type="number" name="capacite" id="capacite" placeholder="ex: 50" min="1" value="<?= e((string)($old['capacite'] ?? $salle->capacite ?? '')) ?>" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem;">
                <?php if (isset($errors['capacite'])): ?>
                    <span style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem; display: block;"><?= e($errors['capacite']) ?></span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Type de Salle -->
        <div>
            <label for="type" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Type de Salle *</label>
            <input type="text" name="type" id="type" placeholder="ex: Réunion, Conférence, Informatique" value="<?= e($old['type'] ?? $salle->type ?? '') ?>" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem;">
            <?php if (isset($errors['type'])): ?>
                <span style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem; display: block;"><?= e($errors['type']) ?></span>
            <?php endif; ?>
        </div>

        <!-- Bouton de soumission -->
        <div style="margin-top: 1rem; text-align: right;">
            <button type="submit" style="background-color: #2563eb; color: #ffffff; border: none; padding: 0.75rem 1.5rem; font-weight: 600; border-radius: 6px; cursor: pointer; font-size: 0.875rem; transition: background-color 0.2s;">
                <?= $isEdit ? 'Mettre à jour la salle' : 'Enregistrer la salle' ?>
            </button>
        </div>

    </form>
</div>