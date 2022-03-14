<?php
include_once ROOT .'_head.php';
include_once ROOT . '_navbar.php';
?>

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ps ps--active-y">
<?php if(isset($alert)){ echo $alert ? "<div class='alert mt-2 alert-message'>{$message}</div>" : '';} ?>
<section class="productContainer editProduct">
<img src="
<?php
 if($currentProduct['image'] !== NULL){
     echo "assets/img/product_images/" . $currentProduct['image'];
 }else{
     echo "assets/img/nophoto.png";
 } 
 ?>" alt="" class='imageSingleProduct'>
<div>
<form action="editproduct_post.php?id= <?= $currentProduct['product_id'] ?>" method="post" enctype="multipart/form-data" class="addProductForm editProductForm">
        <label for="nom">Nom de l'article :*</label>
        <input type="text" name="product_name" required value="<?php echo $currentProduct['name']; ?>">
        <label for="desc">Description :*</label>
        <input type="text" name="product_desc" value="<?php echo $currentProduct['description']; ?>" required>
        <label for="price">Prix :*</label>
        <input type="number" name="product_price" required step="0.01" value="<?php echo $currentProduct['price']; ?>">
        <label for="dlc">DLC :</label>
        <input type="date" name="product_dlc" value="<?php echo $currentProduct['dlc']; ?>">
        <div id="deleteImageContainer">
            <label for="deleteImage">Supprimer l'ancienne image</label>
            <input type="checkbox" name="deleteImage">
        </div>
        <label for="image">Image de l'article</label>
        <input type="file" name="product_image" accept="image/*">
        <div id='stockContainer'>
            <label for="stock">Stock :*</label>
            <input type="number" name="product_stock" id="product_stock" value="<?= $currentProduct['product_stock'] ?>" step="1" min='0'>
        </div>
        <label for="category">Catégorie :*</label>
        <select name="category" id="">
            <option value="unchanged"><?= $currentProduct['category_name'] ?></option>
            <?php if($currentProduct['category_name'] !== 'Alimentaire') echo "<option value='alimentaire'>Alimentaire</option>"; ?>
            <?php if($currentProduct['category_name'] !== 'Papeterie') echo "<option value='papeterie'>Papeterie</option>"; ?>
            <?php if($currentProduct['category_name'] !== 'Produit ménager') echo "<option value='menager'>Produits Ménager</option>"; ?>
            <?php if($currentProduct['category_name'] !== 'Jardinage') echo "<option value='jardinage'>Jardinage</option>"; ?>
            <?php if($currentProduct['category_name'] !== 'Numérique') echo "<option value='numerique'>Numérique</option>"; ?>
        </select>
        <button type="submit" id="submitAddProduct">Mettre à jour</button>
        <label for="requiredChamp" class="requiredChamp">* : Ces champs sont obligatoires</label>
    </form>
</div>
</section>
</main>

<?php
include_once ROOT . '_footer.php';
?>