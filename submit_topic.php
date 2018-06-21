<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['permissions'])){
    header('Location:forum.php');
    die();
}

$topic_name = $_POST['topic-title-input'];

$sql = "INSERT INTO `topics`(`topic`) VALUES('$topic_name')";
$result = mysqli_query($conn,$sql);

if (!$result){
    die($result);
}
$conn->close();
header('Location:forum.php');