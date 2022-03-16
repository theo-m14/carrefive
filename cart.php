<?php

session_start();
require_once('src/bddcall.php');
require_once('src/functions.php');
$bdd = bddcall();
$cartArray = [];
if(isset($_SESSION['cart'])){
    $cartArray = createOrderArray($bdd);
}
$errorMessage = [
    'missingInput' => "Un champs obligatoire est manquant",
    'invalidNumber' => "Votre numéro de téléphone n'est pas valide",
    'invalidName' => "Votre nom ne peut contenir de caratère spéciaux et de chiffres",
];

if(isset($_GET['action']) && $_GET['action'] == 'changeQuantity'){
    if(isset($_GET['id']) && isset($_GET['quantity']) && $_GET['quantity']>0){
        foreach($_SESSION['cart'] as $product){
            if($product['id'] == (int)$_GET['id']){
                $index = array_search($product,$_SESSION['cart']);
                $productAlreadyInCart = true;
            }
        }
        if($productAlreadyInCart){
            $_SESSION['cart'][$index]['quantity'] = (int)$_GET['quantity'];
        }else{
            echo 'Produit non existant dans le panier';
        }
    }else{
        echo 'Paramètre invalide';
    }
}else if(isset($_GET['action']) && $_GET['action'] == 'deleteProduct'){
    if(isset($_GET['id']) && $_GET['id']>0){
        foreach($_SESSION['cart'] as $product){
            if($product['id'] == (int)$_GET['id']){
                $index = array_search($product,$_SESSION['cart']);
                $productAlreadyInCart = true;
            }
        }
        if($productAlreadyInCart){
            array_splice($_SESSION['cart'],$index,1);
            print_r($_SESSION['cart']);
        }else{
            echo 'Produit non existant dans le panier';
        }
    }else{
        echo 'Paramètre invalide';
    }
}else{
    if(isset($_GET['validateCart'])){
        require_once('views/viewValidateCart.php');
    }else{
        require_once('views/viewCart.php');
    }
}