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
        <h1><?= htmlspecialchars((string) $statusCode, ENT_QUOTES, 'UTF-8') ?></h1>
        <h2><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h2>
        <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
        <a class="btn btn-outline" href="/">Wróć na stronę główną</a>
    </main>
</body>
</html>
