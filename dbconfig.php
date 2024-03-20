<?php
const DB_HOST = "localhost";
const DB_USERNAME = "root";
const DB_PASSWORD = "";

const DB_NAME = "corephp";

$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($db->connect_error) {
    die("Connection Failed . " . $db->connect_error);
}
