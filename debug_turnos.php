<?php
$ch = curl_init('http://127.0.0.1:8001/turnos');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
// Find the exception message in Laravel error page
if (preg_match('/<title[^>]*>(.*?)<\/title>/i', $result, $match)) {
    echo "Title: " . htmlspecialchars($match[1]) . "\n";
}
// Look for "Exception" or error text in the response
if (preg_match('/Exception|Error|Syntax|Class.*not found/i', $result)) {
    echo "Found error keywords\n";
    // Save to file for manual inspection
    file_put_contents('/tmp/turnos_error.html', $result);
    echo "Response saved to /tmp/turnos_error.html\n";
    // Extract line with "Exception" or "Error"
    $lines = explode("\n", $result);
    foreach ($lines as $line) {
        if (preg_match('/(Exception|Error|Class|not found)/i', $line) && strlen($line) < 300) {
            echo "Found: " . htmlspecialchars(trim($line)) . "\n";
        }
    }
}
?>