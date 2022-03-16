<?php
include_once '_head.php';
include_once '_navbar.php';
?>

<main class="main-content max-height-vh-100 h-100 mt-1 border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">

                <h6 class="font-weight-bolder mb-0">Tout les produits</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" id="searchBar" placeholder="Type here...">
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
<div class="row">
    <div class="col-12">
        <?php
                if(isset($alert)){
                        echo $alert ? "<div class='alert-message alert mt-2'>{$message}</div>" : '';
                }
                if(isset($_GET['orderSuccess'])){
                    echo "<div class='successMessage'><p>Votre commande a été validé !</p></div>";
                }
                ?>
        <div class="product_table">
        <?php 
                for ($i=0; $i < $getNumberOfProduct; $i++) {
                    $currentProduct = $allProduct->fetch();
                    $currentProduct['image'] == null ? $img = 'nophoto.png' : $img = $currentProduct['image'];
                    echo '<div class="product_container"><img src="assets/img/product_images/' . $img .'"><h5>' . $currentProduct['name'] .'</h5><p>Prix : ' . $currentProduct['price'] . '€<a href="product.php?id=' . $currentProduct['product_id'] .'">Voir</a><div id="addToCartContainer"><select name="product_quantity" id="">';
                    for ($j=1; $j <= $currentProduct['product_stock']; $j++) { 
                        echo '<option value="' . $j . '">' . $j . '</option>';
                    }
                    echo '</select><a href="" class="addToCartBtn" id="' . $currentProduct['product_id']  .'">Ajouter au Panier</a></div></div>';
                }
            ?>
        </div><option value=""></option>
        
    </div>
</div>
</main>
<script src="assets/js/ajaxSearchAndShortingCustomer.js"></script>
<?php
include_once ROOT . '_footer.php';
?>