<?php

session_start();
include("src/bddcall.php");
include('src/functions.php');
include('includes/dev.env.php');
$bdd = bddcall();
if(isset($_SESSION['username'])){
    if(isset($_GET['id'])){
        if(idExistInDatabase($bdd,$_GET['id'])){
            //DeleteImageIfExist
            $currentProduct = getOneProduct($bdd,$_GET['id'])->fetch();
            if($currentProduct['image'] !== NULL){
                deleteImageFromServer($currentProduct['image']);
            }
            //Delete Product from bdd
            deleteProduct($bdd,$_GET['id']);
            header('Location:./?msg=');
        }else{
            header('Location:./?error=uncaughtId');
        }
    }else{
        header('Location:./?missingId');
    }
}else{
    header('Location:./?error=noUser');
}

?>