<?php
require 'connect.php';
$verify_for_mail = create_verify();
$verify_for_sql = substr($verify_for_mail,0,strpos($verify_for_mail,'_'));
$salt = md5(rand(1,1000));

//Insert in database
$pass_encoded = md5($salt . $register_wachtwoord);

$sql = "INSERT INTO `users`(`gebruikersnaam`,`email`,`wachtwoord`,`verify`,`salt`)
        VALUES ('$register_gebruikersnaam','$register_email','$pass_encoded','$verify_for_sql','$salt')";
$result = mysqli_query($conn,$sql);

// Verificatie e-mail
$msg = 'http://localhost/PHP-forum/verify_account.php?verify=' . $verify_for_mail;
if ($result){
    $mail = mail($register_email,'Verificatie',$msg,'From: localhost');
}else{
    echo '<script>' . "alert('Gebruikersnaam/email al in gebruik')" . '</script>';
}

