<section style="max-width: 32rem; margin: 0 auto;">
    <h1>Connexion</h1>

    <?php if (!empty($errors['global'])): ?>
        <p role="alert" style="color: #b91c1c;"><?= e($errors['global']) ?></p>
    <?php endif; ?>

    <form method="post" action="/login">
        <label for="email">
            Adresse email
            <input
                type="email"
                name="email"
                id="email"
                value="<?= e($old['email'] ?? '') ?>"
                autocomplete="email"
                required
            >
            <?php if (!empty($errors['email'])): ?>
                <small style="color: #b91c1c;"><?= e($errors['email']) ?></small>
            <?php endif; ?>
        </label>

        <label for="password">
            Mot de passe
            <input
                type="password"
                name="password"
                id="password"
                autocomplete="current-password"
                required
            >
            <?php if (!empty($errors['password'])): ?>
                <small style="color: #b91c1c;"><?= e($errors['password']) ?></small>
            <?php endif; ?>
        </label>

        <button type="submit">Se connecter</button>
    </form>
</section>