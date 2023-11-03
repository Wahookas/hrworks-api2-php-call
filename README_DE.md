[English version of README](README.md)

# HRWorks API v2 PHP Call
Dieses Repository enthält ein PHP-Skript zur Interaktion mit der HRWorks API v2. Es zeigt, wie man Mitarbeiterdaten sicher und effizient authentifiziert und abruft.

## Features
- Sichere Authentifizierung mit der HRWorks API
- Mitarbeiterinformationen abrufen (siehe example-employees.php)
- Umgang mit API-Antworten und -Fehlern

## Anforderungen
- PHP 7.4 oder höher
- cURL PHP-Erweiterung aktiviert
- Composer (optional)

## Installation (ohne Composer)
### Lade alle Dateien hoch
- getToken.php
- config.php
- example-employees.php

getToken.php und config.php müssen im gleichen Verzeichnis liegen.

### config.php anpassen
Trage die Schlüssel hier ein. API-Schlüssel kannst du im Adminbereich von HRworks erstellen und abrufen (HRworks -> Grundlagen -> Integrationen -> HRworks API).

### Rufe example-employees.php auf
Wenn alles korrekt war, sollten nun alle Mitarbeiter deiner HRworks-Installation in einer HTML-Tabelle angezeigt werden.

## Installation (Composer)
### Klone das Repository auf deinen lokalen Computer:
```bash
git clone https://github.com/yourusername/hrworks-api2-php-call.git
```

### Navigiere zum Projektverzeichnis:
```bash
cd hrworks-api2-php-call
```

### Wenn du Composer zum Verwalten von Abhängigkeiten verwendest, führe Folgendes aus:
```bash
composer install
```

## Konfiguration
Aktualisiere die folgenden Konstanten mit deinen HRWorks-API-Anmeldeinformationen in der config.php:

- ACCESS_KEY
- SECRET_ACCESS_KEY

Stelle sicher, dass diese Werte nicht öffentlich zugänglich gemacht werden.

## Mitwirken
Beiträge zu diesem Projekt sind willkommen.

## Lizenz
Dieses Projekt ist Open-Source unter der MIT-Lizenz.

## Haftungsausschluss
Dieses Skript wird „wie gesehen“ und ohne Gewährleistung jeglicher Art bereitgestellt. Die Nutzung erfolgt auf eigene Gefahr.

## Kontakt
Bei Fragen oder Feedback kontaktiere mich bitte.

Bitte beachte, dass diese Anwendung unabhängig erstellt wurde und in keiner offiziellen Beziehung zu HRWorks oder dessen verbundenen Unternehmen steht. Sie ist nicht autorisiert, unterstützt oder anderweitig von HRWorks oder seinen Partnerunternehmen gebilligt.

- Die offizielle HRWorks-Website unter https://www.hrworks.de
- Die API-Dokumentation unter https://developers.hrworks.de

## Danksagungen
Vielen Dank an HRWorks für die Bereitstellung der API-Dokumentation.
