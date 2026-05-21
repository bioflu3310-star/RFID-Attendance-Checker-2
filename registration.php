<?php
/**
 * registration.php
 * Form for registering a new RFID card/keyfob.
 * The UID field is auto-filled via Ajax polling of UIDContainer.php.
 */

// Reset UID container on page load
$resetContent = '<?php $UIDresult = ""; echo $UIDresult; ?>';
file_put_contents(__DIR__ . '/UIDContainer.php', $resetContent);

$activePage = 'registration';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration | NodeMCU RC522 MySQL</title>
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
                <h3 align="center">Registration Form</h3>
            </div>

            <br>

            <form class="form-horizontal" action="insertDB.php" method="post">

                <div class="control-group">
                    <label class="control-label">ID</label>
                    <div class="controls">
                        <!-- Auto-populated by the UID poller below -->
                        <textarea name="id" id="getUID" rows="1" cols="1"
                                  placeholder="Please tag your Card / Key Chain to display ID"
                                  required></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Name</label>
                    <div class="controls">
                        <input name="name" type="text" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Gender</label>
                    <div class="controls">
                        <select name="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Email Address</label>
                    <div class="controls">
                        <input name="email" type="email" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Mobile Number</label>
                    <div class="controls">
                        <input name="mobile" type="text" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>

            </form>

        </div>
    </div><!-- /container -->

    <script src="jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        // Poll UIDContainer.php every 500ms and fill the ID textarea
        $(document).ready(function () {
            $('#getUID').load('UIDContainer.php');

            setInterval(function () {
                $('#getUID').load('UIDContainer.php');
            }, 500);
        });
    </script>
</body>
</html>
