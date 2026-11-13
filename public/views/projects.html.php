<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/assets/css/theme.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <main>
        <h1>Strona do prezentacji listy wszystkich projektów</h1>
        <form method="get" action="/projects">
            <label for="q">Szukaj</label>
            <input id="q" name="q" type="search" value="<?= htmlspecialchars($searchQuery ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Wpisz frazę...">
            <button class="btn btn-primary" type="submit">Filtruj</button>
        </form>
        <?php if (!empty($searchQuery)): ?>
            <p>Wyniki dla zapytania: <strong><?= htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8') ?></strong></p>
        <?php endif; ?>
        <?php if (!empty($statusFilter)): ?>
            <p>Filtr statusu (regex): <strong><?= htmlspecialchars($statusFilter, ENT_QUOTES, 'UTF-8') ?></strong></p>
        <?php endif; ?>
    </main>
</body>
</html>
