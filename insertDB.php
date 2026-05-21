<?php
/**
 * insertDB.php
 * Handles the Registration form POST.
 * Inserts a new user record and redirects back to user_data.php.
 */

require 'database.php';

if (!empty($_POST)) {
    $name   = $_POST['name'];
    $id     = $_POST['id'];
    $gender = $_POST['gender'];
    $email  = $_POST['email'];
    $mobile = $_POST['mobile'];

    $pdo = Database::connect();
    $sql = 'INSERT INTO table_nodemcu_rfidrc522_mysql
                (name, id, gender, email, mobile)
            VALUES (?, ?, ?, ?, ?)';
    $q = $pdo->prepare($sql);
    $q->execute([$name, $id, $gender, $email, $mobile]);
    Database::disconnect();

    header('Location: user_data.php');
    exit;
}

// If accessed directly without a POST, go back to registration
header('Location: registration.php');
exit;
