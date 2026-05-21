<?php
/**
 * user_data_edit.php
 * Shows a pre-filled form to edit an existing user record.
 * Receives the record ID via GET: ?id=<ID>
 */

require 'database.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

$pdo = Database::connect();
$sql = 'SELECT * FROM table_nodemcu_rfidrc522_mysql WHERE id = ?';
$q   = $pdo->prepare($sql);
$q->execute([$id]);
$data = $q->fetch(PDO::FETCH_ASSOC);
Database::disconnect();

// Redirect if record not found
if ($data === false) {
    header('Location: user_data.php');
    exit;
}

$activePage = 'userdata';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | NodeMCU RC522 MySQL</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

    <h2 align="center">NodeMCU V3 ESP8266 / ESP12E with MySQL Database</h2>

    <?php include 'nav.php'; ?>

    <br>

    <div class="container">
        <div class="center" style="margin: 0 auto; width: 495px; border: 1px solid #f2f2f2;">

            <div class="row">
                <h3 align="center">Edit User Data</h3>
                <!-- Store current gender so JS can pre-select the dropdown -->
                <p id="defaultGender" hidden><?= htmlspecialchars($data['gender']) ?></p>
            </div>

            <form class="form-horizontal"
                  action="user_data_edit_save.php?id=<?= urlencode($id) ?>"
                  method="post">

                <div class="control-group">
                    <label class="control-label">ID</label>
                    <div class="controls">
                        <input name="id" type="text"
                               value="<?= htmlspecialchars($data['id']) ?>" readonly>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Name</label>
                    <div class="controls">
                        <input name="name" type="text"
                               value="<?= htmlspecialchars($data['name']) ?>" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Gender</label>
                    <div class="controls">
                        <select name="gender" id="genderSelect">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Email Address</label>
                    <div class="controls">
                        <input name="email" type="email"
                               value="<?= htmlspecialchars($data['email']) ?>" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Mobile Number</label>
                    <div class="controls">
                        <input name="mobile" type="text"
                               value="<?= htmlspecialchars($data['mobile']) ?>" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a class="btn" href="user_data.php">Back</a>
                </div>

            </form>

        </div>
    </div><!-- /container -->

    <script src="js/bootstrap.min.js"></script>
    <script>
        // Pre-select the correct gender in the dropdown
        var savedGender = document.getElementById('defaultGender').textContent.trim();
        var select = document.getElementById('genderSelect');
        select.value = savedGender; // works because option values match exactly
    </script>
</body>
</html>
