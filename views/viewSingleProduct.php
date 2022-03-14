<?php
include_once ROOT .'_head.php';
include_once ROOT . '_navbar.php';
?>

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ps ps--active-y">
<section class="productContainer">
<img src="
<?php
 if($currentProduct['image'] !== NULL){
     echo "assets/img/product_images/" . $currentProduct['image'];
 }else{
     echo "assets/img/nophoto.png";
 } 
 ?>" alt="" class='imageSingleProduct'>
<div class="productInfo">
    <h2><?php echo $currentProduct['name'];?></h2>
    <p>Description : <span><?php echo $currentProduct['description']; ?></span></p>
    <p>Prix : <?php echo $currentProduct['price']; ?>€</p>
<?php if($currentProduct['dlc'] !== '') echo "<p> DLC : " . $currentProduct['dlc'] . "</p>";  ?>
    <p>Categorie : <?= $currentProduct['category_name'] ?></p>
    <?php 
        if($currentProduct['product_stock']==0){
            echo '<p class="product_outOfStock"> RUPTURE DE STOCK</p>';
        }else{
            echo "<p>Stock :" . $currentProduct['product_stock'] .'</p>';
        }
    ?>
    <p>Dernière modification : <?= $currentProduct['username'] ?></p>
</div>
</section>
</main>

<?php
include_once ROOT . '_footer.php';
?>