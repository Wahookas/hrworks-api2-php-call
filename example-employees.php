<?php
// Inkludiert das Skript zur Token-Erzeugung.
include "getToken.php";

// Definiert die URL zur API für Mitarbeiterdaten.
$employeesUrl = 'https://api.hrworks.de/v2/persons';

// Initialisiert eine cURL-Sitzung.
$ch = curl_init();

// Setzt die notwendigen cURL Optionen.
curl_setopt($ch, CURLOPT_URL, $employeesUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPGET, true);

// Bereitet die Header vor, einschließlich des Authentifizierungstokens.
$headers = [
    'Authorization: Bearer ' . $token,
    'Accept: application/json'
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Führt den cURL-Request aus.
$response = curl_exec($ch);

// Überprüft auf Fehler in der cURL-Anfrage.
if ($response === false) {
    // Gibt den cURL-Fehler aus und beendet das Skript.
    exit('cURL-Fehler: ' . curl_error($ch));
}

// Schließt die cURL-Sitzung.
curl_close($ch);

// Dekodiert die JSON-Antwort.
$employeesData = json_decode($response, true);

// Überprüft, ob die Antwort gültig ist.
if (json_last_error() !== JSON_ERROR_NONE) {
    // Gibt den JSON-Fehler aus und beendet das Skript.
    exit('JSON Decode Fehler: ' . json_last_error_msg());
}

// Ausgabe Mitarbeiterdaten in HTML
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitarbeiterliste</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="text"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }
        
      
@media print {
    #filterInput {
        visibility: hidden;
    }
    #printButton {
        visibility: hidden;
    }
}
    </style>
</head>
<body>
    <!-- Kopfbereich der Seite -->
    <header>
        <h1>Mitarbeiterliste</h1>
        <input type="text" id="filterInput" placeholder="Filtern nach Schlüsselwort, Personalnummer, Name etc">
        <p><button id="printButton">Drucken</button></p>
    </header>
    
    <!-- Mitarbeiterdaten-Tabelle -->
    <section>
        <table>
            <!-- Tabellenkopf -->
        	<tr>
            <th>Personalnummer</th>
            <th>Personen-ID</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>DATEV Personalnummer</th>
        	</tr>
            <!-- Mitarbeiterdaten -->
            <?php
        		foreach ($employeesData as $group) {
            		foreach ($group as $employee) {
                	echo "<tr>";
                	echo "<td>" . htmlspecialchars($employee['personnelNumber'], ENT_QUOTES, 'UTF-8') . "</td>";
                	echo "<td>" . htmlspecialchars($employee['personId'], ENT_QUOTES, 'UTF-8') . "</td>";
					echo "<td>" . htmlspecialchars($employee['firstName'], ENT_QUOTES, 'UTF-8') . "</td>";
					echo "<td>" . htmlspecialchars($employee['lastName'], ENT_QUOTES, 'UTF-8') . "</td>";
               	 	echo "<td>";
                		if (isset($employee['datevPersonnelNumber'])) {
                    		echo $employee['datevPersonnelNumber'];
                		}
                	echo "</td>";
                	echo "</tr>";
            		}
        		}
        	?>
        </table>
    </section>
    
<script>
    // Event-Listener hinzufügen
    function addEventListeners() {
        const filterInput = document.getElementById('filterInput');
        const printButton = document.getElementById('printButton');

        filterInput.addEventListener('input', handleFilterInput);
        printButton.addEventListener('click', handlePrint);
    }

    // Filterfunktion
    function handleFilterInput() {
        const filterValue = this.value.toLowerCase();
        filterTableRows(filterValue);
    }

    // Filterlogik für Tabellenzeilen
    function filterTableRows(filterValue) {
        const rows = document.querySelectorAll('table tr:not(:first-child)');
        
        rows.forEach(row => {
            const isVisible = [...row.cells].some(cell => cell.textContent.toLowerCase().includes(filterValue));
            row.style.display = isVisible ? '' : 'none';
        });
    }

    // Druckfunktion
    function handlePrint() {
        window.print();
    }

    // Tabelle beim Start sortieren
    function sortTableOnLoad() {
        const table = document.querySelector('table');
        const headerRow = table.querySelector('tr:first-child');
        const sortableRows = Array.from(table.querySelectorAll('tr:not(:first-child)'));

        const sortedRows = sortableRows.sort((a, b) => {
            const aNumber = parseInt(a.cells[0].textContent, 10);
            const bNumber = parseInt(b.cells[0].textContent, 10);
            return aNumber - bNumber;
        });

        // Tabelle neu aufbauen
        table.innerHTML = '';
        table.appendChild(headerRow);
        sortedRows.forEach(row => table.appendChild(row));
    }

    // Initialisierungsfunktion
    function initialize() {
        addEventListeners();
        sortTableOnLoad();
    }

    // Initialisierung beim Laden der Seite
    window.addEventListener('DOMContentLoaded', initialize);
</script>
</body>
</html>