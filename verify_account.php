<?php
session_start();

if (isset($_SESSION['user']) || !isset($_GET['verify'])){
    header('Location:forum.php');
}

//Check in database of de verify link hetzelfde is, dan verander 'verify' naar true
include 'connect.php';
include 'register_variables.php';
if (isset($_GET['verify'])){
    //opvragen verificatiecode van database
    $link_code = $_GET['verify'];
    $user_and_code = explode('_',$link_code);
    $sql = "SELECT `verify` FROM `users` WHERE `verify` = '$user_and_code[0]' AND `gebruikersnaam` = '$user_and_code[1]'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    if (!empty($row['verify']) && $row['verify'] !== 'true'){
        $sql_ = "UPDATE `users` SET `verify` = 'true' WHERE `gebruikersnaam` = '$user_and_code[1]'";
        $result_ = mysqli_query($conn,$sql_);
        if ($result_){
            echo 'Email verified';
        }
    }else{
        echo 'Ongeldige link';
    }

}
$conn->close();
?>

<html>
<body>
<a href="index.php">Terug naar homepagina</a>
</body>
</html>
