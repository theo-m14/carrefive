<?php
include_once('src/bddcall.php');
include_once('src/functions.php');
session_start();
$bdd = bddcall();
$imageExist = false;
$idCategory = [
    'unchanged',
    'alimentaire',
     'papeterie',
     'menager',
     'jardinage',
     'numerique',
 ];

if(isset($_GET['id']) && idExistInDatabase($bdd,$_GET['id'])){
    if(isset($_POST['product_name']) && isset($_POST['product_desc']) && isset($_POST['product_price']) && isset($_POST['category']) && in_array($_POST['category'],$idCategory) && isset($_POST['product_stock'])){
        $currentProduct = getOneProduct($bdd,$_GET['id'])->fetch();
        if(strlen(trim($_POST['product_name'])) > 3 && strlen(trim($_POST['product_desc'])) > 3){
            if(isset($_FILES['product_image']) && $_FILES['product_image']['size'] > 0){
                $msg = isFileValid($_FILES['product_image']);
                if(isFileValid($_FILES['product_image']) === 'valid'){
                    if(uploadImage($_FILES['product_image'])){
                        //DELETE L'ANCIENNE
                        deleteImageFromServer($currentProduct['image']);
                        $msg = 'jai upload';
                        $imageExist = true;
                        $imageName = htmlspecialchars($_FILES['product_image']['name']);
                    }else{
                        header("Location:editproduct.php?id=" . $_GET['id'] . "&error=failedToUpload");
                    }
                }else{
                    header("Location:editproduct.php?id=" . $_GET['id'] . "&error=" . isFileValid($_FILES['product_image']));
                }
            }else if(isset($_POST['deleteImage']) && $_POST['deleteImage'] == true){
                $imageExist = false;
            }else{
                $imageExist = true;
                $currentProduct = getOneProduct($bdd,$_GET['id'])->fetch();
                $imageName =$currentProduct['image'];
            }            
            ($_POST['product_dlc'] == '') ? $dlc = NULL : $dlc=$_POST['product_dlc'];
            $productArray = [
                'product_name' => htmlspecialchars($_POST['product_name']),
                'product_desc' => htmlspecialchars($_POST['product_desc']),
                'product_price' => $_POST['product_price'],
                'product_dlc' => ($_POST['product_dlc'] == '') ? NULL : $_POST['product_dlc'],
                'product_image' => !$imageExist ? NULL : $imageName,
                'category_id' => (array_search($_POST['category'],$idCategory)!==0) ? array_search($_POST['category'],$idCategory) : $currentProduct['category_id'],
                'product_stock' => ($_POST['product_stock']<0) ? 0 : $_POST['product_stock'],
                'last_modif_user' => getIdUser($bdd,$_SESSION['username'])['id'],
            ];
            //FAIRE CHANGEMENT ICI
            updateProduct($bdd,$productArray,$_GET['id']);
            $imageExist ? $checkImage = 'true' :  $checkImage = 'false';
            $_POST['deleteImage'] ? $delete = 'true' :$delete = 'false';
            header("Location:./?msg=" . $msg . '&path=' .$path);
        }else{
            header("Location:editproduct.php?id=" . $_GET['id'] . "&error=tooShortInput");
        }
    }else{
        header("Location:editproduct.php?id=" . $_GET['id'] . "&error=missingInputOrFileToHeavy");
    }
}else{
    header('./?error=idProblem');
}