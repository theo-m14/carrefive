<?php

function isFileValid(array $file){
if($file['size'] > 2097152) return 'tooHeavy';
$extension =  explode(".",$file['name']);
$acceptedExtensions = ['jpg','gif','png','webp','PNG'];
if(!in_array($extension[1],$acceptedExtensions)) return 'wrongExtension';
return 'valid';
}

function uploadImage(array $file){
$imageFolder = 'assets/img/product_images' . DIRECTORY_SEPARATOR;
$newFilePath = $imageFolder . $file['name'];
return move_uploaded_file($file['tmp_name'],$newFilePath);
}

function deleteImageFromServer($imagename){
    $imageFolder = 'assets/img/product_images' . DIRECTORY_SEPARATOR;
    if(file_exists($imageFolder . $imagename)){
        unlink($imageFolder . $imagename);
    }
    return $imageFolder;
}

function exportCSV($bdd){
    $exportFile = fopen("php://output", "wb");
    $requestNumberOfProduct =$bdd -> query('SELECT COUNT(*) as number FROM product');
    $numberOfProduct = $requestNumberOfProduct -> fetch();
    $allProduct = getAllProduct($bdd);
    $arrayCSV = [];
    $arrayCSV[0] = array('ID','NOM','PRICE','DLC','STOCK','CATEGORIE');
    fputcsv($exportFile, $arrayCSV[0]);
    for ($i=1; $i < $numberOfProduct['number']+1; $i++) { 
        $currentProduct = $allProduct -> fetch();
        $arrayCSV[$i] = array(
            'id' => $currentProduct['product_id'],
            'name' => $currentProduct['name'],
            'price' => $currentProduct['price'] .'€',
            'dlc' => $currentProduct['dlc'],
            'stock' => $currentProduct['product_stock'],
            'category' => $currentProduct['category_name'],
        );
        fputcsv($exportFile, $arrayCSV[$i]);
    }
    fclose($exportFile);
}
?>