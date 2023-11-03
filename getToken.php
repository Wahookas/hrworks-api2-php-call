<?php
// Laden der Schlüssel von einer sicheren Quelle
include 'config.php';

$authUrl = 'https://api.hrworks.de/v2/authentication';

// Daten für den Post-Request
$postData = json_encode([
    'accessKey' => ACCESS_KEY,
    'secretAccessKey' => SECRET_ACCESS_KEY
]);

$curlHandle = curl_init();
curl_setopt($curlHandle, CURLOPT_URL, $authUrl);
curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlHandle, CURLOPT_POST, true);
curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $postData);
curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, true); // SSL-Zertifikatüberprüfung aktivieren

$headers = [
    'Accept: application/json',
    'Content-Type: application/json',
    'Content-Length: ' . strlen($postData),
    'date: ' . gmdate('D, d M Y H:i:s T')
];
curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($curlHandle);

if ($response === false) {
    $error = curl_error($curlHandle);
    curl_close($curlHandle);
    
    // Loggen des Fehlers und Abbruch
    error_log($error);
    exit("CURL-Fehler: $error");
}

$status = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
curl_close($curlHandle);

// Validierung der Antwort
if ($status !== 200) {
    // Loggen des Fehlers und Abbruch
    error_log("Fehler beim Abrufen des Tokens mit Statuscode: $status");
    exit("API-Fehler mit Statuscode: $status");
}

$responseData = json_decode($response, true);

if (!isset($responseData['token'])) {
    // Ausführlichere Fehlermeldung
    error_log("Token nicht in der Antwort gefunden. Antwort: " . print_r($responseData, true));
    exit("Fehler beim Abrufen des Tokens.");
}

// Das Token für weitere Verwendung speichern
$token = $responseData['token'];
?>