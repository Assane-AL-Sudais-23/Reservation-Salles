<?php use function App\View\e; ?>

<div style="max-width: 700px; margin: 0 auto;">
    
    <!-- En-tête de la page -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #f3f4f6; padding-bottom: 1rem;">
        <div>
            <h2 style="margin: 0; font-size: 1.5rem; color: #111827;">Réserver une Salle</h2>
            <p style="margin: 0.25rem 0 0 0; color: #6b7280; font-size: 0.875rem;">Remplissez le formulaire ci-dessous pour effectuer une réservation.</p>
        </div>
        <a href="/reservation" style="text-decoration: none; color: #4b5563; background-color: #f3f4f6; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 500; font-size: 0.875rem;">
            ← Annuler
        </a>
    </div>

    <!-- Erreur Globale -->
    <?php if (isset($errors['global'])): ?>
        <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.875rem;">
            ⚠️ <?= e($errors['global']) ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire aligné avec le Router (POST /reservation) -->
    <form action="/reservation" method="POST" style="display: grid; gap: 1.25rem;">

        <!-- Sélection de la salle -->
        <div>
            <label for="salle_id" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Choix de la Salle *</label>
            <select name="salle_id" id="salle_id">
                <option value="">-- Sélectionnez une salle --</option>
                <?php foreach ($salles as $salle): ?>
                    <option value="<?= e((string)$salle->id) ?>" <?= ($old['salle_id'] ?? '') == $salle->id ? 'selected' : '' ?>
                        <?= e($salle->nom) ?> (Capacité: <?= e((string)$salle->capacite) ?> pers.)
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['salle_id'])): ?>
                <span style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem; display: block;"><?= e($errors['salle_id']) ?></span>
            <?php endif; ?>
        </div>

        <!-- Informations sur le responsable -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <label for="responsable" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Responsable *</label>
                <input type="text" name="responsable" id="responsable" placeholder="ex: Jean Dupont" value="<?= e($old['responsable'] ?? '') ?>" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem;">
                <?php if (isset($errors['responsable'])): ?>
                    <span style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem; display: block;"><?= e($errors['responsable']) ?></span>
                <?php endif; ?>
            </div>

            <div>
                <label for="email" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Email du Responsable *</label>
                <input type="email" name="email" id="email" placeholder="nom@exemple.com" value="<?= e($old['email'] ?? '') ?>" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem;">
                <?php if (isset($errors['email'])): ?>
                    <span style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem; display: block;"><?= e($errors['email']) ?></span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Motif -->
        <div>
            <label for="motif" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Motif de la réservation *</label>
            <input type="text" name="motif" id="motif" placeholder="ex: Réunion d'équipe trimestrielle" value="<?= e($old['motif'] ?? '') ?>" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem;">
            <?php if (isset($errors['motif'])): ?>
                <span style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem; display: block;"><?= e($errors['motif']) ?></span>
            <?php endif; ?>
        </div>

        <!-- Dates et heures -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <label for="date_debut" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Date et heure de début *</label>
                <input type="datetime-local" name="date_debut" id="date_debut" value="<?= e($old['date_debut'] ?? '') ?>" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem;">
                <?php if (isset($errors['date_debut'])): ?>
                    <span style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem; display: block;"><?= e($errors['date_debut']) ?></span>
                <?php endif; ?>
            </div>

            <div>
                <label for="date_fin" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Date et heure de fin *</label>
                <input type="datetime-local" name="date_fin" id="date_fin" value="<?= e($old['date_fin'] ?? '') ?>" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem;">
                <?php if (isset($errors['date_fin'])): ?>
                    <span style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem; display: block;"><?= e($errors['date_fin']) ?></span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bouton d'action -->
        <div style="margin-top: 1rem; text-align: right;">
            <button type="submit" style="background-color: #2563eb; color: #ffffff; border: none; padding: 0.75rem 1.5rem; font-weight: 600; border-radius: 6px; cursor: pointer; font-size: 0.875rem; transition: background-color 0.2s;">
                Confirm la Réservation
            </button>
        </div>

    </form>
</div>