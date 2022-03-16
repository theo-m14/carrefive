<?php

try{
    session_start();
    if(isset($_GET['logout'])){
        $_SESSION = [];
    }
    require_once('src/bddcall.php');
    $bdd = bddcall();
    $errorMessage = [
        'uncaughtId' => "L'id de l'article ne correspond à aucun article existant",
        'missingId' => "Aucun id n'a été fournis pour l'affichage de l'article",
        'idProblem' => "Id non reconnu pour la modification du produit",
        'noUser' => "Vous devez être connecté pour faire cela",
    ];
    if(isset($_GET['error'])){
        $alert = true;
        if(isset($errorMessage[$_GET['error']])){
            $message = $errorMessage[$_GET['error']];
        }else{
            $message = "Erreur Inconnue";
        }
    }
    if(isset($_GET['userConnected'])){
        $response = [
            'userConnected' => isset($_SESSION['username']) ? true : false,
            'userAdmin' => isset($_SESSION['username']) ? userIsAdmin($bdd,$_SESSION['username']) : false,
        ];
        echo json_encode($response);
    }else if(isset($_GET['search'])){
        //echo getSearchProduct($bdd,$_GET['search']);
        echo getSearchProductInStock($bdd,$_GET['search']);
    }else if(isset($_GET['addToCart'])){
        if(isset($_GET['quantity']) && $_GET['quantity']>0){
            if(isset($_SESSION['cart'])){
                $productAlreadyInCart = false;
                foreach($_SESSION['cart'] as $product){
                    if($product['id'] == (int)$_GET['addToCart']){
                        $index = array_search($product,$_SESSION['cart']);
                        $productAlreadyInCart = true;
                    }
                }
                    if($productAlreadyInCart){
                        $_SESSION['cart'][$index]['quantity'] += (int)$_GET['quantity'];
                    }else{
                        array_push($_SESSION['cart'],['id' => (int)$_GET['addToCart'], 'quantity' => (int)$_GET['quantity']]);
                    }
            }else{
                $_SESSION['cart'] = [];
                array_push($_SESSION['cart'],['id' => (int)$_GET['addToCart'], 'quantity' => (int)$_GET['quantity']]);
            }
        }else{
            echo 'Le paramètre de quantité est manquant ou invalide';
        }
    }else{
        if(isset($_SESSION['username']) && userIsAdmin($bdd,$_SESSION['username'])){
            $allProduct = getInStockProduct($bdd);
            $getNumberOfProduct = getNumberProductInStock($bdd);
            require_once('views/viewIndex.php');
        }else{
            $allProduct = getInStockProduct($bdd);
            $getNumberOfProduct = getNumberProductInStock($bdd);
            require_once('views/viewCustomerIndex.php');
        }
    }
}catch(Exception $e){
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}