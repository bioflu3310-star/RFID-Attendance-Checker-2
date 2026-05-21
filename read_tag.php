<?php
/**
 * read_tag.php
 * Polls for a scanned RFID UID and displays the matching user data.
 * UIDContainer.php is updated by getUID.php when NodeMCU sends a card scan.
 */

// Reset UID container on page load
$resetContent = '<?php $UIDresult = ""; echo $UIDresult; ?>';
file_put_contents(__DIR__ . '/UIDContainer.php', $resetContent);

$activePage = 'readtag';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Tag | NodeMCU RC522 MySQL</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

    <h2 align="center">NodeMCU V3 ESP8266 / ESP12E with MySQL Database</h2>

    <?php include 'nav.php'; ?>

    <br>

    <!-- Blinking prompt shown until a card is detected -->
    <h3 align="center" id="blink">Please Tag to Display ID or User Data</h3>

    <!-- Hidden element; filled by jQuery polling UIDContainer.php -->
    <p id="getUID" hidden></p>

    <br>

    <!-- User data panel; replaced by AJAX response from read_tag_data.php -->
    <div id="show_user_data">
        <table width="452" border="1" bordercolor="#10a0c5" align="center"
               cellpadding="0" cellspacing="1" bgcolor="#000" style="padding: 2px">
            <tr>
                <td height="40" align="center" bgcolor="#10a0c5">
                    <font color="#fff"><b>User Data</b></font>
                </td>
            </tr>
            <tr>
                <td bgcolor="#f9f9f9">
                    <table width="452" border="0" align="center" cellpadding="5" cellspacing="0">
                        <tr>
                            <td width="113" align="left" class="lf">ID</td>
                            <td><b>:</b></td>
                            <td align="left">--------</td>
                        </tr>
                        <tr bgcolor="#f2f2f2">
                            <td align="left" class="lf">Name</td>
                            <td><b>:</b></td>
                            <td align="left">--------</td>
                        </tr>
                        <tr>
                            <td align="left" class="lf">Gender</td>
                            <td><b>:</b></td>
                            <td align="left">--------</td>
                        </tr>
                        <tr bgcolor="#f2f2f2">
                            <td align="left" class="lf">Email</td>
                            <td><b>:</b></td>
                            <td align="left">--------</td>
                        </tr>
                        <tr>
                            <td align="left" class="lf">Mobile Number</td>
                            <td><b>:</b></td>
                            <td align="left">--------</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <script src="jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        // ── UID polling ────────────────────────────────────────────────
        // Poll UIDContainer.php every 500ms so the hidden #getUID element
        // stays in sync with whatever card was last scanned.
        $(document).ready(function () {
            $('#getUID').load('UIDContainer.php');

            setInterval(function () {
                $('#getUID').load('UIDContainer.php');
            }, 500);
        });

        // ── Tag detection & user lookup ────────────────────────────────
        var oldID  = '';
        var waitForTag    = setInterval(checkForNewTag, 1000);
        var waitForChange = null; // started after a tag is detected

        /** Waits until a UID appears, then fetches user data. */
        function checkForNewTag() {
            var uid = document.getElementById('getUID').innerHTML.trim();
            if (uid !== '') {
                oldID = uid;
                showUser(uid);
                clearInterval(waitForTag);
                waitForChange = setInterval(checkForTagChange, 500);
            }
        }

        /** Watches for the UID to change (new card or card removed). */
        function checkForTagChange() {
            var uid = document.getElementById('getUID').innerHTML.trim();
            if (uid !== oldID) {
                clearInterval(waitForChange);
                waitForTag = setInterval(checkForNewTag, 500);
            }
        }

        /**
         * Fetches user data for the given UID via AJAX
         * and injects the result HTML into #show_user_data.
         */
        function showUser(uid) {
            if (!uid) {
                document.getElementById('show_user_data').innerHTML = '';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('show_user_data').innerHTML = xhr.responseText;
                }
            };
            xhr.open('GET', 'read_tag_data.php?id=' + encodeURIComponent(uid), true);
            xhr.send();
        }

        // ── Blinking prompt ────────────────────────────────────────────
        var blink = document.getElementById('blink');
        setInterval(function () {
            blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
        }, 750);
    </script>
</body>
</html>
