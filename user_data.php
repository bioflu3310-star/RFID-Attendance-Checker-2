<?php
/**
 * user_data.php
 * Displays all registered users in a sortable table.
 * Provides Edit and Delete actions per row.
 */

// Reset UID container on page load
$resetContent = '<?php $UIDresult = ""; echo $UIDresult; ?>';
file_put_contents(__DIR__ . '/UIDContainer.php', $resetContent);

require 'database.php';

$pdo  = Database::connect();
$sql  = 'SELECT * FROM table_nodemcu_rfidrc522_mysql ORDER BY name ASC';
$rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
Database::disconnect();

$activePage = 'userdata';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data | NodeMCU RC522 MySQL</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

    <h2>NodeMCU V3 ESP8266 / ESP12E with MySQL Database</h2>

    <?php include 'nav.php'; ?>

    <br>

    <div class="container">
        <div class="row">
            <h3>User Data Table</h3>
        </div>

        <div class="row">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr bgcolor="#10a0c5">
                        <th>Name</th>
                        <th>ID</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name'])   ?></td>
                            <td><?= htmlspecialchars($row['id'])     ?></td>
                            <td><?= htmlspecialchars($row['gender']) ?></td>
                            <td><?= htmlspecialchars($row['email'])  ?></td>
                            <td><?= htmlspecialchars($row['mobile']) ?></td>
                            <td>
                                <a class="btn btn-success"
                                   href="user_data_edit.php?id=<?= urlencode($row['id']) ?>">Edit</a>
                                &nbsp;
                                <a class="btn btn-danger"
                                   href="user_data_delete.php?id=<?= urlencode($row['id']) ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div><!-- /container -->

    <script src="js/bootstrap.min.js"></script>
</body>
</html>
