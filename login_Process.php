<?php

require_once "dbconfig.php";
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "select * from users where username = '$username' ";
$sql1 = $db->query($sql);

if (($sql1->num_rows > 0) == TRUE) {
    $row = $sql1->fetch_assoc();
    if (password_verify($password, $row['password'])) {

        $_SESSION['user_id'] = $row['id'];

        header('location:index.php');
    } else {
        // echo "Error : " . $sql . "<br>" . $db->error;
        $message[] = 'incorrect password or email';
        header('location:login.php');
    }
}
$db->close();
