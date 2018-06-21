<?php
if (!isset($_POST['reactie-input'])){
    die();
}
include 'connect.php';
$content = $_POST['reactie-input'];
$user = $_POST['user'];
$thread_ID = $_POST['current_thread'];

$sql = "INSERT INTO `reacties` (`user_created`,`thread_ID`,`content`) VALUES ('$user','$thread_ID','$content')";
$result = mysqli_query($conn,$sql);


$conn->close();

$loc = 'forum.php?page=2&thread=' . $thread_ID;
header('Location:' . $loc);