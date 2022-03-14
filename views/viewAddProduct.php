<?php
include_once ROOT .'_head.php';
include_once ROOT . '_navbar.php';
?>

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ps ps--active-y">
    <?php if(isset($alert)){ echo $alert ? "<div class='alert-message alert mt-2'>{$message}</div>" : '';} ?>
    <form action="addproduct_post.php" method="post" enctype="multipart/form-data" class="addProductForm">
        <label for="nom">Nom de l'article :*</label>
        <input type="text" name="product_name" required>
        <label for="desc">Description :*</label>
        <input type="text" name="product_desc" required>
        <label for="price">Prix :*</label>
        <input type="number" name="product_price" required step="0.01">
        <label for="dlc">DLC :</label>
        <input type="date" name="product_dlc">
        <label for="image">Image de l'article</label>
        <!-- <input type="hidden" name="MAX_FILE_SIZE" value="2097152" /> -->
        <input type="file" name="product_image" accept="image/*">
        <div>
            <label for="stock">Stock :*</label>
            <input type="number" name="product_stock" id="product_stock" value="0" step="1" min='0'>
        </div>
        <label for="category">Catégorie :*</label>
        <select name="category" id="">
            <option value="">--Catégories--</option>
            <option value="alimentaire">Alimentaire</option>
            <option value="papeterie">Papeterie</option>  
            <option value="menager">Produits Ménager</option>
            <option value="jardinage">Jardinage</option>
            <option value="numerique">Numérique</option>
        </select>
        <button type="submit" id="submitAddProduct">Ajouter produit</button>
        <label for="requiredChamp" class="requiredChamp">* : Ces champs sont obligatoires</label>
    </form>
</main>

<?php
include_once ROOT . '_footer.php';
?>