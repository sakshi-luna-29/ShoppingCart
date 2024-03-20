<?php

require_once "dbconfig.php";

$name = $_POST['name'];
$username = $_POST['username'];
$password = ($_POST['password']);
$phone =  $_POST['phone'];
$hash_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name , username, phone ,  password)  VALUES ('$name' , '$username' , '$phone' , '$hash_password')";

if ($db->query($sql) == TRUE) {
    echo "Registration Successful";
} else {
    echo "Error : " . $sql . "<br>" . $conn->error;
}
$db->close();
