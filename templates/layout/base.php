<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Salles & Réservations</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
</head>
<body style="background-color: #f8f9fa; font-family: system-ui, -apple-system, sans-serif; color: #333; margin: 0; padding: 0;">

    <!-- Navigation principale -->
    <header style="background-color: #ffffff; border-bottom: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.04); margin-bottom: 2rem;">
        <nav class="container" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">
            <div style="font-weight: 700; font-size: 1.25rem;">
                <a href="/salle" style="text-decoration: none; color: #111827; display: flex; align-items: center; gap: 0.5rem;">
                    🏢 <span>ReservationApp</span>
                </a>
            </div>
            <ul style="display: flex; list-style: none; gap: 1.5rem; margin: 0; padding: 0;">
                <li>
                    <a href="/salle" style="text-decoration: none; font-weight: 500; color: #4b5563; padding: 0.5rem 0.75rem; border-radius: 6px; transition: background 0.2s;">
                        Salles
                    </a>
                </li>
                <li>
                    <a href="/reservation" style="text-decoration: none; font-weight: 500; color: #4b5563; padding: 0.5rem 0.75rem; border-radius: 6px; transition: background 0.2s;">
                        Réservations
                    </a>
                </li>
                <li>
                    <a href="/salle/create" style="text-decoration: none; font-weight: 600; color: #ffffff; background-color: #2563eb; padding: 0.5rem 1rem; border-radius: 6px;">
                        + Nouvelle Salle
                    </a>
                </li>
                <li>
                    <?php if ($utilisateurConnecte !== null): ?>
                        <form action="/logout" method="POST" style="margin: 0;">
                            <button type="submit" style="margin: 0; padding: 0.5rem 0.75rem;">Se déconnecter</button>
                        </form>
                    <?php else: ?>
                        <a href="/login" style="text-decoration: none; font-weight: 600; color: #ffffff; background-color: #16a34a; padding: 0.5rem 1rem; border-radius: 6px;">
                            Se connecter
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Contenu Dynamique de la Vue -->
    <main class="container" style="background-color: #ffffff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); margin-bottom: 3rem;">
        <?php require $content; ?>
    </main>

    <!-- Pied de page -->
    <footer style="text-align: center; padding: 1.5rem; color: #6b7280; font-size: 0.875rem; border-top: 1px solid #e9ecef;">
        &copy; <?= date('Y') ?> Service de Réservation de Salles — Tous droits réservés.
    </footer>

</body>
</html>