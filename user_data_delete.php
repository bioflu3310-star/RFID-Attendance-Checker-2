<?php
/**
 * user_data_delete.php
 * Confirms and performs deletion of a user record.
 * GET  ?id=<ID>  → shows confirmation page
 * POST            → deletes the record and redirects to user_data.php
 */

require 'database.php';

// Handle the delete POST
if (!empty($_POST)) {
    $id = $_POST['id'];

    $pdo = Database::connect();
    $sql = 'DELETE FROM table_nodemcu_rfidrc522_mysql WHERE id = ?';
    $q   = $pdo->prepare($sql);
    $q->execute([$id]);
    Database::disconnect();

    header('Location: user_data.php');
    exit;
}

// Show confirmation page
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$activePage = 'userdata';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User | NodeMCU RC522 MySQL</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

    <h2 align="center">NodeMCU V3 ESP8266 / ESP12E with MySQL Database</h2>

    <?php include 'nav.php'; ?>

    <br>

    <div class="container">
        <div class="span10 offset1">

            <div class="row">
                <h3 align="center">Delete User</h3>
            </div>

            <form class="form-horizontal" action="user_data_delete.php" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                <p class="alert alert-error">Are you sure you want to delete this user?</p>
                <div class="form-actions">
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    <a class="btn" href="user_data.php">No, Go Back</a>
                </div>
            </form>

        </div>
    </div><!-- /container -->

    <script src="js/bootstrap.min.js"></script>
</body>
</html>
