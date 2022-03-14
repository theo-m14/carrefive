<?php

require_once('src/bddcall.php');
$bdd = bddcall();
if(isset($_POST['username']) && isset($_POST['password'])){
    if($_POST['password'] == $_POST['password2']){
        if(!userExist($bdd,htmlspecialchars($_POST['username']))){
            if(strlen(trim(htmlspecialchars($_POST['username']))) > 4 && strlen(trim(htmlspecialchars($_POST['username']))) < 20){
                if(preg_match("#.{4,}#", $_POST['password'])){
                    $userInfo = [
                        'username' => trim(htmlspecialchars($_POST['username'])),
                        'password' => password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT),
                    ];
                    registerUser($bdd,$userInfo);
                    header("Location:sign-in.php");
                }else{
                    header("Location:sign-up.php?error=weakPass");
                }
            }else{
                header("Location:sign-up.php?error=usernameError");
            }
        }else{
            header("Location:sign-up.php?error=userExist");
        }
    }else{
        header("Location:sign-up.php?error=pass");
    }
}else{
    header("Location:sign-up.php?error=missingChamp");
}
?>

throw Exception