<?php
/**
 * testUID.php
 * Development/debug helper — simulates a NodeMCU card scan.
 * Sends a test UID to getUID.php via cURL and reports the result.
 *
 * ⚠️  Remove or restrict access to this file in production.
 */

// ── Configuration ──────────────────────────────────────────────────────────
$testUID    = 'TEST1234';                              // UID to simulate
$getUIDUrl  = 'http://192.168.0.109/NodeMCU_RC522_Mysql/getUID.php';
// ──────────────────────────────────────────────────────────────────────────

// Send the simulated UID via POST
$ch = curl_init($getUIDUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'UIDresult=' . urlencode($testUID));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "── Test UID Sender ───────────────────────────────\n";
echo "URL      : {$getUIDUrl}\n";
echo "Test UID : {$testUID}\n";
echo "HTTP     : {$httpCode}\n";
echo "Response : {$response}\n\n";

// Read back what was written to UIDContainer.php
$containerPath = __DIR__ . '/UIDContainer.php';
if (file_exists($containerPath)) {
    echo "── UIDContainer.php contents ─────────────────────\n";
    echo file_get_contents($containerPath) . "\n";
} else {
    echo "UIDContainer.php not found.\n";
}
