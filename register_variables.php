<?php
$form_type = '';

if (isset($_POST['login-gebruikersnaam'])) {
    $login_gebruikersnaam = $_POST['login-gebruikersnaam'];
    $login_wachtwoord = $_POST['login-wachtwoord'];
    $form_type = 'login';
} else if (isset($_POST['register-gebruikersnaam'])) {
    $register_gebruikersnaam = $_POST['register-gebruikersnaam'];
    $register_email = $_POST['register-email'];
    $register_wachtwoord = $_POST['register-wachtwoord'];
    $form_type = 'register';
}

// Verify op basis van willekeurige string, gebruikersnaam
function create_verify()
{
    $hash = md5(rand(0,1000));
    $ver_user = $_POST['register-gebruikersnaam'];
    return $hash . '_' . $ver_user;
}
