<?php 

session_start();
require_once('src/bddcall.php');
require_once('src/functions.php');
$bdd = bddcall();

if(isset($_POST['name']) && $_POST['adress'] && $_POST['number']){
    if(preg_match('/^[a-zA-Z\s]+$/', $_POST['name'])){
        if(preg_match('/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/', $_POST['number'])){
            $cartArray = createOrderArray($bdd);
            $userArray = [
                'name' => htmlspecialchars($_POST['name']),
                'number' => htmlspecialchars($_POST['number']),
                'adress' => htmlspecialchars($_POST['adress'])
            ];
            $order_id = createOrder($bdd,$userArray);
            echo $order_id['id'];
            foreach ($cartArray as $product) {
                print_r($product);
                createOrderProduct($bdd,$product,$order_id['id']);
                $_SESSION['cart'] = [];
                header('Location:index.php?orderSuccess');
            }
        }else{
            header('Location:cart.php?error=invalidNumber');
        }
    }else{
        header('Location: cart.php?error=invalidName');
    }
}else{
    header('Location: cart.php?error=missingInput');
}

// missingInput
// invalidNumbe
// invalidName