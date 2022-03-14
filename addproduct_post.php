<?php
include_once('src/bddcall.php');
include_once('src/functions.php');
session_start();
$bdd = bddcall();
$imageExist = false;
$idCategory = [
   'alimentaire',
    'papeterie',
    'menager',
    'jardinage',
    'numerique',
];

if(isset($_POST['product_name']) && isset($_POST['product_desc']) && isset($_POST['product_price']) && isset($_POST['category']) && in_array($_POST['category'],$idCategory) && isset($_POST['product_stock'])){
    if(strlen(trim($_POST['product_name'])) > 3 && strlen(trim($_POST['product_desc'])) > 3){
        if(isset($_FILES['product_image']) && $_FILES['product_image']['size'] > 0){
            $msg = isFileValid($_FILES['product_image']);
            if(isFileValid($_FILES['product_image']) === 'valid'){
                if(uploadImage($_FILES['product_image'])){
                    $imageExist = true;
                }else{
                    header("Location:addproduct.php?error=failedToUpload");
                }
            }else{
                header("Location:addproduct.php?error=" . isFileValid($_FILES['product_image']));
            }
        }
        ($_POST['product_dlc'] == '') ? $dlc = NULL : $dlc=$_POST['product_dlc'];
        $productArray = [
            'product_name' => htmlspecialchars($_POST['product_name']),
            'product_desc' => htmlspecialchars($_POST['product_desc']),
            'product_price' => $_POST['product_price'],
            'product_dlc' => ($_POST['product_dlc'] == '') ? NULL : $_POST['product_dlc'],
            'product_image' => !$imageExist ? NULL : htmlspecialchars($_FILES['product_image']['name']),
            'category_id' => array_search($_POST['category'],$idCategory)+1,
            'product_stock' => ($_POST['product_stock']<0) ? 0 : $_POST['product_stock'],
            'last_modif_user' => getIdUser($bdd,$_SESSION['username'])['id'],
        ];
        registerProduct($bdd,$productArray);
        header("Location:./");
    }else{
        header("Location:addproduct.php?error=tooShortInput");
    }
}else{
    header("Location:addproduct.php?error=missingInputOrFileToHeavy");
}

?>