<?php
session_start();
include("src/bddcall.php");
$bdd = bddcall();

if(isset($_SESSION['username'])){
    if(isset($_GET['id'])){
        if(idExistInDatabase($bdd,$_GET['id'])){
            $currentProduct = getOneProduct($bdd,$_GET['id'])->fetch();
            $errorMessage = [
                'tooShortInput' => "Le nom et la description doivent faire plus de 4 caratères",
                'missingInputOrFileToHeavy' => 'Un champ est manquant ou le fichier est trop lourd',
                'failedToUpload' => "Le téléversement du fichier a échoué",
                'wrongExtension' => "Les extensions d'image acceptées sont jpg/gif/png/webp",
                'tooHeavy' => "Le fichier fournis est trop lourd",
            ];
            if(isset($_GET['error'])){
                $alert = true;
                if(isset($errorMessage[$_GET['error']])){
                    $message = $errorMessage[$_GET['error']];
                }else{
                    $message = "Erreur Inconnue";
                }
            }
            require_once('views/viewEditSingleProduct.php');
        }else{
            header('Location:./?error=uncaughtId');
        }
    }else{
        header('Location:./?error=missingId');
    }
}else{
    header('Location:./?error=noUser');
}

?>