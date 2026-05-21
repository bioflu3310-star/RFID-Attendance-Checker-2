<?php
/**
 * home.php
 * Landing page. Also resets UIDContainer.php on every load.
 */

// Reset the UID container so stale card data is cleared on page load
$resetContent = '<?php $UIDresult = ""; echo $UIDresult; ?>';
file_put_contents(__DIR__ . '/UIDContainer.php', $resetContent);

$activePage = 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | NodeMCU RC522 MySQL</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

    <h2>NodeMCU V3 ESP8266 / ESP12E with MySQL Database</h2>

    <?php include 'nav.php'; ?>

    <br>

    <h3>Welcome to NodeMCU V3 ESP8266 / ESP12E with MySQL Database</h3>

    <img src="home ok ok.jpg" alt="Home illustration" style="width: 55%;">

    <script src="js/bootstrap.min.js"></script>
</body>
</html>
