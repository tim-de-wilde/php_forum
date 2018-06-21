<?php
if (session_status() == PHP_SESSION_NONE){
    session_start();
}

function veranderHeadline($headline_text){
    echo '<script>';
    echo "document.getElementById('headline').innerText=";
    echo "'$headline_text'" . ';';
    echo '</script>';
}

function checkUserPrintVerwijderen($username){
    if ($_SESSION['user'] == $username || isset($_SESSION['permissions'])){
        echo '<a href="" onclick="verwijderThread()">(verwijderen)</a>';
    }
}
