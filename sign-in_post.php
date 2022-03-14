<?php
require_once('src/bddcall.php');
$bdd = bddcall();

if(isset($_POST['username']) && isset($_POST['password'])){
    if(userExist($bdd,$_POST['username'])){
        $currentUser = getUser($bdd,$_POST['username']);
        if(password_verify($_POST['password'], $currentUser['password'])){
            session_start();
            $_SESSION['username'] = $_POST['username'];
            header('Location:./');
        }else{
            header('Location:sign-in.php?error=wrongInput');
        }
    }else{
        header('Location:sign-in.php?error=wrongInput');
    }
}else{
    header('Location:sign-in.php?error=missingInput');
}
?>