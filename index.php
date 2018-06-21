<?php
session_start();
    if (isset($_SESSION['user'])){
        header('Location:forum.php');
    }

    include 'connect.php';
    include 'register_variables.php';
    //Login proces
    if ($form_type === 'login'){
        include 'login.php';
    //Registratieproces
    }else if ($form_type === 'register'){
        include 'register.php';
    }
?>


<html>
<head>
    <meta charset="UTF-8">
    <title>Forum login</title>
</head>
<body>
<form class="form" method="post">
    <input type="text" name="login-gebruikersnaam" placeholder="Gebruikersnaam"> <br>
    <input type="password" name="login-wachtwoord" placeholder="Wachtwoord"> <br>
    <input type="submit" value="Login"> <br> <br>

    <a onclick="formSwitch()">Nog geen gebruiker? Registreer nu.</a>
</form>
<form class="form" method="post" style="display: none">
    <input type="text" name="register-gebruikersnaam" placeholder="Gebruikersnaam"> <br>
    <input type="password" name="register-wachtwoord" placeholder="Wachtwoord"> <br>
    <input type="email" name="register-email" placeholder="Email"> <br>
    <input type="submit" value="Registreer"> <br> <br>

    <a onclick="formSwitch()">Ga terug</a>
</form>


<script>
    function formSwitch(){
        var forms = document.getElementsByClassName('form');
        if (forms[0].style.display === 'none'){
            forms[0].style.display = 'block';
            forms[1].style.display = 'none';
        }else{
            forms[1].style.display = 'block';
            forms[0].style.display = 'none';
        }
    }
</script>
</body>



</html>
