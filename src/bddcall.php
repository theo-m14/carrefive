<?php

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;
define('includes_PATH', $root . 'includes' . DIRECTORY_SEPARATOR);

require_once(includes_PATH . 'dev.env.php');

function bddcall(){
    try {
        $bdd = new PDO('mysql:dbname=' . DATABASE . ';host=' . SERVER, USER, PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        return $bdd;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function getAllProduct($bdd){
    try{
        $allProduct = $bdd->query('SELECT * FROM product LEFT JOIN category ON product.category_id = category.id');
        return $allProduct;
    }catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function getInStockProduct($bdd){
    try{
        $allProduct = $bdd->query('SELECT * FROM product LEFT JOIN category ON product.category_id = category.id WHERE product_stock > 0');
        return $allProduct;
    }catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function getOutOfStockProduct($bdd){
    try{
        $allProduct = $bdd->query('SELECT * FROM product LEFT JOIN category ON product.category_id = category.id WHERE product_stock = 0');
        return $allProduct;
    }catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function getOneProduct($bdd,$id){
    try{
        $oneProduct = $bdd->prepare('SELECT product.product_id,product.name,product.description,product.price,product.image,product.dlc,product.category_id,category.id,category.category_name,product.last_modif_user,user.username,product.product_stock FROM product LEFT JOIN category ON product.category_id = category.id LEFT JOIN user ON product.last_modif_user = user.id WHERE product_id=:productId');
        $oneProduct->execute(array(
        'productId' => $id,
        ));
        return $oneProduct;
    }catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}


function getNumberOfProduct($bdd): int{ 
    try{
        $numberOfProduct = $bdd->query('SELECT COUNT(*) AS number FROM product');
        $numberOfProduct = $numberOfProduct->fetch();
        return $numberOfProduct['number'];
    }catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function getNumberProductInStock($bdd) : int{
    try{
        $numberOfProduct = $bdd->query('SELECT COUNT(*) AS number FROM product WHERE product_stock > 0');
        $numberOfProduct = $numberOfProduct->fetch();
        return $numberOfProduct['number'];
    }catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function getNumberProductOutOfStock($bdd) : int{
    try{
        $numberOfProduct = $bdd->query('SELECT COUNT(*) AS number FROM product WHERE product_stock = 0');
        $numberOfProduct = $numberOfProduct->fetch();
        return $numberOfProduct['number'];
    }catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function idExistInDatabase($bdd,$id) : bool{
    try{
        $searchProductById = $bdd->prepare('SELECT COUNT(*) AS numberProduct FROM product WHERE product_id=:productId');
        $searchProductById->execute(array(
        'productId' => $id,
        ));
        $result = $searchProductById->fetch();
        return ($result['numberProduct'] == 1);
    }catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function registerUser($bdd,$userInfo){
    try{
        $registerUser = $bdd->prepare('INSERT INTO user(user.username,user.password) VALUES(:username,:password)');
        $registerUser->execute(array(
            'username' => $userInfo['username'],
            'password' => $userInfo['password'],
        ));
    }catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }  
}

function userExist($bdd,$username) : bool{
    
    try{
        $user = $bdd->prepare('SELECT COUNT(*) AS number FROM user WHERE username=:username');
        $user->execute(array(
            'username' => $username,
        ));
        $result = $user->fetch();
        return ($result['number'] == 1);
    }catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }  
}

function getUser($bdd,$username){
    try{
        $user = $bdd->prepare('SELECT * FROM user WHERE username=:username');
    $user->execute(array(
        'username' => $username,
    ));
    $result = $user->fetch();
    return $result;
    }catch(Exception $e){
        die('erreur : ' .$e->getMessage());
    }
}

function registerProduct($bdd,$productArray)
{
    try {
        $registerProduct = $bdd->prepare('INSERT INTO product(product.name,product.description,product.price,product.dlc,product.image,product.category_id,product.product_stock,product.last_modif_user) VALUES(:product_name,:product_desc,:product_price,:product_dlc,:product_image,:category_id,:product_stock,:last_modif_user)');
        $registerProduct->execute(array(
            'product_name' => $productArray['product_name'],
            'product_desc' => $productArray['product_desc'],
            'product_price' => $productArray['product_price'],
            'product_dlc' => $productArray['product_dlc'],
            'product_image' => $productArray['product_image'],
            'category_id' => $productArray['category_id'],
            'product_stock' => $productArray['product_stock'],
            'last_modif_user' => $productArray['last_modif_user'],
            ));
    } catch (PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function updateProduct($bdd,$productArray,$id){
    try {
        $registerProduct = $bdd->prepare('UPDATE product SET product.name=:product_name,product.description=:product_desc,product.price=:product_price,product.dlc=:product_dlc,product.image=:product_image,product.category_id=:category_id,product.product_stock=:product_stock,product.last_modif_user=:last_modif_user WHERE product_id=:id');
        $registerProduct->execute(array(
            'product_name' => $productArray['product_name'],
            'product_desc' => $productArray['product_desc'],
            'product_price' => $productArray['product_price'],
            'product_dlc' => $productArray['product_dlc'],
            'product_image' => $productArray['product_image'],
            'category_id' => $productArray['category_id'],
            'product_stock' => $productArray['product_stock'],
            'last_modif_user' => $productArray['last_modif_user'],
            'id' => $id,
        ));
    } catch (PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function deleteProduct($bdd,$id){
    try {
        $deleteProduct = $bdd->prepare('DELETE FROM product WHERE product_id = :id');
        $deleteProduct->execute(array(
            'id' => $id,
        ));
    } catch (PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function getSearchProduct($bdd,$letters){
    try {
        $searchProduct = $bdd->prepare("SELECT * FROM product WHERE product.name LIKE :letters");
        $searchProduct->execute(array(
            'letters' => "%" . $letters . "%",
        ));
        $searchProductResult = $searchProduct->fetchAll();
        return json_encode($searchProductResult);
    } catch (PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function getSearchProductOutOfStock($bdd,$letters){
    try {
        $searchProduct = $bdd->prepare("SELECT * FROM product WHERE product.name LIKE :letters AND product_stock = 0");
        $searchProduct->execute(array(
            'letters' => "%" . $letters . "%",
        ));
        $searchProductResult = $searchProduct->fetchAll();
        return json_encode($searchProductResult);
    } catch (PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function getSearchProductInStock($bdd,$letters){
    try {
        $searchProduct = $bdd->prepare("SELECT * FROM product WHERE product.name LIKE :letters AND product_stock > 0");
        $searchProduct->execute(array(
            'letters' => "%" . $letters . "%",
        ));
        $searchProductResult = $searchProduct->fetchAll();
        return json_encode($searchProductResult);
    } catch (PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function getIdUser($bdd,$username){
    try {
        $getUser = $bdd->prepare('SELECT id FROM user WHERE username=:username');
        $getUser->execute(array(
            'username' => $username,
        ));
        $result = $getUser->fetch();
        return $result;
    } catch (PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function userIsAdmin($bdd,$username) : bool{
    try {
        $requestIsAdmin = $bdd->prepare('SELECT user.admin FROM user WHERE username=:username');
        $requestIsAdmin->execute(array(
            'username' => $username,
        ));
        $result = $requestIsAdmin->fetch();
        return ($result['admin'] == 1);
    } catch (PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function createOrder($bdd,$infoUser){
    try {
        $requestNewOrder = $bdd->prepare('INSERT INTO customer_order (customer_order.name,customer_order.number,customer_order.adress) VALUES(:customer_name,:customer_number,:customer_adress)');
        $requestNewOrder->execute(array(
        'customer_name' => $infoUser['name'],
        'customer_number' => $infoUser['number'],
        'customer_adress' => $infoUser['adress'],
        ));
        $indexOfOrder = $bdd->query('SELECT MAX(id) as id from customer_order');
        return $indexOfOrder->fetch();
    } catch (\PDOEXception $e) {
        die('erreur a la création: ' .$e->getMessage());
    }
}

function createOrderProduct($bdd,$product,$order_id){
    try {
        $newOrderProduct = $bdd->prepare('INSERT INTO order_product(order_product.id_order,order_product.id_product,order_product.quantity) VALUES(:id_order,:product_id,:quantity)');
        $newOrderProduct->execute(array(
            'id_order' => $order_id,
            'product_id' => $product['product_id'],
            'quantity' => $product['quantity'],
        ));
    } catch (\PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function getAllOrderNotAccepted($bdd){
    try {
        $requestAllOrderNotAccepted = $bdd->query('SELECT *,customer_order.name AS customer_name FROM customer_order LEFT JOIN order_product ON order_product.id_order = customer_order.id LEFT JOIN product ON order_product.id_product = product.product_id WHERE customer_order.accepted = 0 ORDER BY customer_order.id');
        return $requestAllOrderNotAccepted;
    } catch (\PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function getNumberOfOrderNotAccepted($bdd){
    try {
        $requestAllOrderNotAccepted = $bdd->query('SELECT COUNT(*) as numberOrder FROM customer_order WHERE customer_order.accepted = 0');
        return $requestAllOrderNotAccepted->fetch();
    } catch (\PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function orderIdIsValid($bdd,$id,$isAccepted) : bool{
    try {
        $orderIsValid = $bdd->prepare('SELECT COUNT(*) as numberOrder FROM customer_order WHERE customer_order.accepted =:isAccepted and customer_order.id=:id');
        $orderIsValid->execute(array(
            'id' => $id,
            'isAccepted' => $isAccepted,
        ));
        $result = $orderIsValid->fetch();
        return ($result['numberOrder'] == 1);
    } catch (\PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function getOrder($bdd,$id){
    try {
        $requestOrder = $bdd->prepare('SELECT *,customer_order.name AS customer_name FROM customer_order LEFT JOIN order_product ON order_product.id_order = customer_order.id LEFT JOIN product ON order_product.id_product = product.product_id WHERE customer_order.id=:id');
        $requestOrder->execute(array(
        'id' => $id,
        ));
        $result = $requestOrder->fetchAll();
        return $result;
    } catch (\PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function acceptOrder($bdd,$id){
    try {
        $acceptOrder = $bdd->prepare('UPDATE customer_order SET customer_order.accepted=1 WHERE customer_order.id=:id');
        $acceptOrder->execute(array(
        'id' => $id,
        ));
    } catch (\PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function deleteOrder($bdd,$id){
    try {
        $deleteOrder = $bdd->prepare('DELETE FROM customer_order WHERE id=:id ');
        $deleteOrder->execute(array(
            'id' => $id,
        ));
    } catch (\PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function updateProductStock($bdd,$productId,$newStock){
    try {
        $updateStock = $bdd->prepare('UPDATE product SET product.product_stock=:newStock WHERE product.product_id=:productId');
        $updateStock->execute(array(
            'newStock' => $newStock,
            'productId' => $productId,
        ));
    } catch (\PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

// LEFT JOIN category ON product.category_id = category.id LEFT JOIN user ON product.last_modif_user = user.id

function getAllOrderAccepted($bdd){
    try {
        $requestAllOrderAccepted = $bdd->query('SELECT *,customer_order.name AS customer_name FROM customer_order LEFT JOIN order_product ON order_product.id_order = customer_order.id LEFT JOIN product ON order_product.id_product = product.product_id WHERE customer_order.accepted = 1 ORDER BY customer_order.id');
        return $requestAllOrderAccepted;
    } catch (\PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}

function getNumberOfOrderAccepted($bdd){
    try {
        $requestAllOrderAccepted = $bdd->query('SELECT COUNT(*) as numberOrder FROM customer_order WHERE customer_order.accepted = 1');
        return $requestAllOrderAccepted->fetch();
    } catch (\PDOException $e) {
        die('erreur : ' .$e->getMessage());
    }
}