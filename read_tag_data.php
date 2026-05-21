<?php
/**
 * read_tag_data.php
 * AJAX partial — returns the user-data table HTML for a given RFID UID.
 * Called by read_tag.php via XMLHttpRequest: ?id=<UID>
 */

require 'database.php';

// Sanitise the incoming UID
$id = isset($_GET['id']) && $_GET['id'] !== '' ? $_GET['id'] : null;

$pdo = Database::connect();
$sql = 'SELECT * FROM table_nodemcu_rfidrc522_mysql WHERE id = ?';
$q   = $pdo->prepare($sql);
$q->execute([$id]);
$data = $q->fetch(PDO::FETCH_ASSOC);
Database::disconnect();

// Fall back to placeholder values when the UID is not registered
$notRegistered = ($data === false || $data['name'] === null);
if ($notRegistered) {
    $data = [
        'id'     => $id,
        'name'   => '--------',
        'gender' => '--------',
        'email'  => '--------',
        'mobile' => '--------',
    ];
}
?>
<link href="css/style.css" rel="stylesheet">

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
                    <td align="left"><?= htmlspecialchars($data['id'])     ?></td>
                </tr>
                <tr bgcolor="#f2f2f2">
                    <td align="left" class="lf">Name</td>
                    <td><b>:</b></td>
                    <td align="left"><?= htmlspecialchars($data['name'])   ?></td>
                </tr>
                <tr>
                    <td align="left" class="lf">Gender</td>
                    <td><b>:</b></td>
                    <td align="left"><?= htmlspecialchars($data['gender']) ?></td>
                </tr>
                <tr bgcolor="#f2f2f2">
                    <td align="left" class="lf">Email</td>
                    <td><b>:</b></td>
                    <td align="left"><?= htmlspecialchars($data['email'])  ?></td>
                </tr>
                <tr>
                    <td align="left" class="lf">Mobile Number</td>
                    <td><b>:</b></td>
                    <td align="left"><?= htmlspecialchars($data['mobile']) ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?php if ($notRegistered): ?>
    <p style="color: red; text-align: center;">
        The ID of your Card / Key Chain is not registered!
    </p>
<?php endif; ?>
