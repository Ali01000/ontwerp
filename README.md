# CRUD Oefening — Calculatie

Project bevat een eenvoudige CRUD-implementatie volgens het opdrachtontwerp.

Belangrijke bestanden:

- `ontwerp/classdiagram.md` — tekstuele classdiagram en uitleg.
- `src/Db/Database.php` — PDO-verbinding en `createSchema()` (SQLite in-memory voor tests).
- `src/Model/Product.php` — Product entity (id, naam, prijs) met getters/setters.
- `src/Repository/ProductRepository.php` — CRUD-methodes (create, findById, findAll, update, delete).

Tests:

- Unit tests: `tests/DatabaseTest.php`, `tests/ProductRepositoryTest.php`, `tests/ProductTest.php`, `tests/RekenenmachineTest.php`.
- Acceptatietest: `tests/AcceptatieTest.php`.
- Acceptatierapport: `tests/acceptance/report.md` en screenshot `tests/acceptance/screenshot.png`.

Hoe te draaien:

1. Installeer dependencies (indien nodig): `composer install`.
2. Genereer autoload: `composer dump-autoload`.
3. Run tests: `vendor/bin/phpunit` of `vendor/bin/phpunit --filter AcceptatieTest`.

Opmerkingen:

- De database tijdens tests gebruikt SQLite in-memory zodat tests snel en onafhankelijk zijn.
- `vendor/` is opgenomen in `.gitignore`.
