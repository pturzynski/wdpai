# AGENTS.md

## Cel projektu
**SplitIt** — aplikacja webowa w PHP 8.3 i PostgreSQL dla znajomych i współlokatorów, którzy wspólnie ponoszą koszty (zakupy, rachunki, wyjazdy). Pozwala tworzyć grupy, dodawać wydatki wraz ze zdjęciem paragonu, dzielić kwoty między uczestników, wyliczać bieżące salda i oznaczać długi jako spłacone.

## Struktura
- `public/index.php` — punkt wejścia aplikacji (Front Controller).
- `public/views/` — widoki HTML z fragmentami PHP (`*.html.php`) oraz współdzielone komponenty (nawigacja, nagłówek, stopka).
- `public/assets/` — statyczne arkusze CSS (`theme.css`, `style.css`) oraz skrypty JS.
- `src/Routing.php` — dopasowanie tras HTTP (statycznych, z parametrem `{id}` i regex) oraz wywołanie kontrolerów.
- `src/Database.php` — konfiguracja połączenia PDO z bazą PostgreSQL.
- `src/controllers/` — kontrolery w przestrzeni nazw `App\Controller`.
- `src/models/` — modele encji w przestrzeni nazw `App\Model`.
- `src/repositories/` — repozytoria (DAO) z zapytaniami SQL w przestrzeni nazw `App\Repository`.
- `src/services/` — logika biznesowa (np. podział kosztów, wyliczanie sald, walidacja) w przestrzeni nazw `App\Service`.
- `database/` — skrypty SQL ze schematem bazy i danymi demonstracyjnymi.

## Zasady pracy
- Zachowuj `declare(strict_types=1);` na początku każdego pliku PHP.
- Nie dodawaj zewnętrznych frameworków ani bibliotek bez wyraźnej zgody.
- Przestrzegaj podziału odpowiedzialności MVC:
  - kontroler obsługuje żądanie HTTP i koordynuje przepływ,
  - repozytorium zawiera zapytania SQL (zawsze parametryzowane przez `prepare()` / `execute()`),
  - widok odpowiada wyłącznie za prezentację HTML.
- Wszystkie dane wyświetlane w HTML zabezpieczaj przez `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`.
- Wprowadzaj małe, logiczne zmiany i nie modyfikuj plików niezwiązanych z bieżącym zadaniem.

## Uruchamianie i weryfikacja
- Start środowiska: `docker compose up --build -d`
- Kontrola składni PHP: `docker compose exec -T php php -l ścieżka/do/pliku.php`
- Po dodaniu lub zmianie trasy sprawdź poprawny adres oraz odpowiedź 400/404 dla błędnych identyfikatorów.
- Przed zakończeniem zadania sprawdź `git status` oraz `git diff` i krótko podsumuj zmienione pliki.

## Bezpieczeństwo
- Nie odczytuj ani nie commituj sekretów z pliku `.env` (w repozytorium znajduje się wyłącznie `.env.example`).
- Nie wykonuj destrukcyjnych poleceń Git ani SQL bez potwierdzenia.
- Nie edytuj ręcznie wygenerowanych plików w katalogu `vendor/`.
