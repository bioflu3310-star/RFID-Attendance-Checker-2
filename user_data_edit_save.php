<?php
/**
 * user_data_edit_save.php
 * Handles the Edit User form POST.
 * Updates the record in the database and redirects to user_data.php.
 */

require 'database.php';

if (!empty($_POST)) {
    $id     = $_POST['id'];
    $name   = $_POST['name'];
    $gender = $_POST['gender'];
    $email  = $_POST['email'];
    $mobile = $_POST['mobile'];

    $pdo = Database::connect();
    $sql = 'UPDATE table_nodemcu_rfidrc522_mysql
            SET name = ?, gender = ?, email = ?, mobile = ?
            WHERE id = ?';
    $q = $pdo->prepare($sql);
    $q->execute([$name, $gender, $email, $mobile, $id]);
    Database::disconnect();

    header('Location: user_data.php');
    exit;
}

// If accessed directly without a POST, go back to user list
header('Location: user_data.php');
exit;
