<?php

session_start();
require_once('src/bddcall.php');
require_once('src/functions.php');
$bdd = bddcall();

if(isset($_GET['validateOrder']) && isset($_POST['id'])){
    if(orderIdIsValid($bdd,$_POST['id'],0)){
        $currentOrder = getOrder($bdd,$_POST['id']);
        acceptOrder($bdd,$_POST['id']);
        for ($i=0; $i < count($currentOrder); $i++) {
            $newStock = $currentOrder[$i]['product_stock'] - $currentOrder[$i]['quantity'];
            updateProductStock($bdd,$currentOrder[$i]['product_id'],$newStock);
        }
        $message = 'La commande n°' . $_POST['id'] . ' a été acceptée';
    }else{
        $errorMessage = "L'id fourni à la validation ne correspond pas à une commande validable";
    }
}else if(isset($_GET['deleteOrder']) && isset($_POST['id'])){
    if(orderIdIsValid($bdd,$_POST['id'],false) && !isset($_GET['orderAccepted'])){
        deleteOrder($bdd,$_POST['id']);
        $message = 'La commande n°' . $_POST['id'] . ' a été supprimé';
    }else if(orderIdIsValid($bdd,$_POST['id'],true) && isset($_GET['orderAccepted'])){
        deleteOrder($bdd,$_POST['id']);
        $message = 'La commande n°' . $_POST['id'] . ' a été supprimé';
    }else{
        $errorMessage = "L'id fourni à la validation ne correspond pas à une commande supprimable";
    }
}

if(isset($_GET['orderAccepted'])){
    $allOrder = getAllOrderAccepted($bdd);
    $currentProduct = $allOrder->fetch();
    $currentOrderId = $currentProduct['id_order'];
    $numberOfOrder = getNumberOfOrderAccepted($bdd)['numberOrder'];
    $acceptedOrder = "&orderAccepted";
}else{
    $allOrder = getAllOrderNotAccepted($bdd);
    $currentProduct = $allOrder->fetch();
    $currentOrderId = $currentProduct['id_order'];
    $numberOfOrder = getNumberOfOrderNotAccepted($bdd)['numberOrder'];
    $validStock = true;
}

require_once('views/viewOrderManagment.php');
?>
