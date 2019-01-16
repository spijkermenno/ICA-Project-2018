# EenmaalAndermaal

[![Build Status](https://travis-ci.com/spijkermenno/ICA-Project-2018.svg?token=pskv6nK5nPgApsw1scAs&branch=master)](https://travis-ci.com/spijkermenno/ICA-Project-2018)

# Basics

## Opzetten

Check de Laravel installation documentatie voordat je hiermee begint. [Official Documentation](https://laravel.com/docs/5.5/installation#installation)

Open de folder

    cd eenmaal-andermaal

Installeer alle dependencies met Composer

    composer install

Copieer het .env.example bestand en voeg je juiste database gegevens in onder DB_* en voeg mailtrap gegevens in onder MAIL_*

    cp .env.example .env

Genereer een nieuwe appicatie key

    php artisan key:generate

Voer de migraties uit op de database

    php artisan migrate
    
## Deployen op een FTP server (IIS Setup)

(Volg eerst de stappen van Opzetten)

Convigureer je .env bestand met de database gegevens van de server en voer de migraties uit met: 

    php artisan migrate

Maak een nieuwe map aan op de FTP server

Upload alle bestanden naar de aangemaakte map op de FTP server 

Verplaats de volgende bestanden en mappen naar de root folder van het webadress

- public/css
- public/fonts
- public/images
- public/js
- public/web.config
- public/mix-manifest.json

Maak een nieuw bestand in de root folder van je webadress aan genaamd `index.php` en voeg het volgende toe aan het bestand (Waar #MAP de map is waar de bestanden zijn geupload)

    <?php
    
    include '#MAP/public/index.php';


## Test gebruikers
 
Na het uitvoeren van de migraties zijn er drie gebruikers aangemaakt die gebruikt kunnen worden om de applicatie te testen of te beheren.

| username  | password  |
|-----------|-----------|
| gebruiker | qwerty123 |
| verkoper  | qwerty123 |
| admin     | qwerty123 |

# Code

## Dependencies

- [laravel/framework](https://github.com/laravel/framework) - Het Laravel framework
- [intervention/validation](https://github.com/intervention/validation) - Extra validatie regels voor bijvoorbeeld IBAN validatie
- [florianv/laravel-swap](https://github.com/florianv/laravel-swap) - Valuta exchange rate 
- [laravel-validation-rules/credit-card](https://github.com/laravel-validation-rules/credit-card) - Extra validatie regels voor creditcard validatie

## Mappen

- `app/Console` Bevat custom commands voor PHP artisan en kunnen gegenereerd worden via: make:command .
- `app/Exceptions` In deze map staan alle custom exception handlers. 
- `app/Http/Controllers` Alle controllers voor de site staan hier. Deze controllers maken views aan met data uit models.
- `app/Http/Middleware` Hierin staan alle middlewares wat gebruikt worden binnen routes en controllers. Een middleware handelt informatie tussen de client en de controller.
- `app/Notifications` In deze folder staan alle notificaties zoals e-mails die verstuurd worden. 
- `app/Providers` Hier worden alle service providers geconfigureerd voor de IoC container.
- `app/Repositories` Alle services die praten met de database staan hier. Hier moet je dus denken aan classes die dingen ophalen en wegschrijven in de database.
- `app/Repositories/Contracts` Hier staan alle interfaces beschreven voor de repositories.
- `app/Repositories/Fakes` Hier staan alle fake versies van de repositories. Dit zijn classes die nep data generen.
- `app/Rules` Hierin worden custom http validatie regels gemaakt.
- `bootstrap` In deze map staat de “app.php”, dit bestand start de framework op. Verder is er een bestand toegevoegd genaamd “functions.php”, hierin staan paar zelf gemaakte helper functies die gebruikt worden binnen de applicatie.
- `bootstrap/cache` Hier staan automatische gegeneerde framework gerelateerde bestanden voor optimalisatie.
- `config` Hierin staan applicatie configuratiebestanden.
- `database` Hier staan alles wat te maken heeft met de database zoals: SQL migraties, model factories en seeds.
- `database/csv` Deze map staat niet standard in Laravel en is bedoeld voor het importeren van bestaande data van EenmaalAndermaal. In deze map staan CSV-bestanden wat gebruikt worden tijdens het migreren van de database.
- `public` Hierin staat het “index.php” bestand het beginpunt van alle requests op de website.
- `resources` Hier staan de Views en de source code van de Javascript en SASS-bestanden. Verder staan ook alle taalbestanden hierin.
- `routes` Hierin staan alle URL-route definities beschreven. In ”web.php” staan alle website URL’s en de controllers die geroepen worden bij een request.
- `storage` In deze map staat alle gecompileerde view en app/framework bestanden.
- `tests` In deze map staan alle geautomatiseerde tests. Een voorbeeld is unit tests. Voor dit project zal dit niet van belang zijn.

## Omgevingsvariabelen

- `.env` - De omgevingsvariabelen zijn opgeslagen in dit bestand
