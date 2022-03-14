<?php

try{
    session_start();
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
        //Call to all product
        if(!isset($_GET['outOfStock'])){
            echo getSearchProduct($bdd,$_GET['search']);
        }else{
            echo getSearchProductOutOfStock($bdd,$_GET['search']);
        }
    }else{
        if(!isset($_GET['outOfStock'])){
            $allProduct = getAllProduct($bdd);
            $getNumberOfProduct = getNumberOfProduct($bdd);
            $adminPage = true;
            require_once('views/viewIndex.php');
        }else{
            $allProduct = getOutOfStockProduct($bdd);
            $getNumberOfProduct = getNumberProductOutOfStock($bdd);
            $adminPage = true;
            require_once('views/viewIndex.php');
        }
    }
}catch(Exception $e){
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}