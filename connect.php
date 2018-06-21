<?php
$conn = new mysqli('localhost', 'root', 'TW2000Alfa-college', 'php_forum');

if ($conn->connect_error) {
    echo $conn->connect_error;
    die();
}