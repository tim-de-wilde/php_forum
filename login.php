<?php
// Eerst salt krijgen
$salt_sql = "SELECT `salt` FROM `users` WHERE `gebruikersnaam` = '$login_gebruikersnaam'";
$salt_result = mysqli_query($conn,$salt_sql);
$salt = null;
while ($row = mysqli_fetch_assoc($salt_result)){
    $salt = $row['salt'];
}

$wachtwoord_encoded = md5($salt . $login_wachtwoord);

$sql = "SELECT `gebruikersnaam`,`wachtwoord`,`verify`,`permissions` FROM `users` WHERE `gebruikersnaam` = '$login_gebruikersnaam' AND `wachtwoord` = '$wachtwoord_encoded' ";
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array($result)){
    if (!empty($row['gebruikersnaam'])){
        if ($row['verify'] !== 'true'){
            echo "<script>" . "alert('Email is niet geverifiëerd')" . "</script>";
        }else{
            if ($row['permissions'] == 1){
                $_SESSION['permissions'] = 1;
            }
            $_SESSION['user'] = $row['gebruikersnaam'];
            header('Location:forum.php');
        }
    }
}