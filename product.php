<?php
session_start();
include("src/bddcall.php");
$bdd = bddcall();

if(isset($_GET['id'])){
    if(idExistInDatabase($bdd,$_GET['id'])){
        $currentProduct = getOneProduct($bdd,$_GET['id'])->fetch();
        require_once('views/viewSingleProduct.php');
    }else{
        header('Location:./?error=uncaughtId');
    }
}else{
    header('Location:./?error=missingId');
}

?>