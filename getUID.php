<?php
/**
 * getUID.php
 * Endpoint called by the NodeMCU when it scans an RFID card.
 * Receives the UID via POST and writes it to UIDContainer.php
 * so the browser-side polling can pick it up.
 *
 * Expected POST field: UIDresult=<card_uid>
 */

if (isset($_POST['UIDresult'])) {
    $uid      = $_POST['UIDresult'];
    $filePath = __DIR__ . '/UIDContainer.php';

    // Write the UID into a tiny PHP snippet that simply echoes it
    $content = '<?php $UIDresult = "' . addslashes($uid) . '"; echo $UIDresult; ?>';

    if (file_put_contents($filePath, $content) === false) {
        http_response_code(500);
        echo 'Error: Could not write UIDContainer.php';
    } else {
        echo $uid;
    }
} else {
    http_response_code(400);
    echo 'Error: UIDresult not received.';
}
