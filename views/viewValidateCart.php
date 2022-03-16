<?php
include_once ROOT .'_head.php';
include_once ROOT . '_navbar.php';
?>

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ps ps--active-y">

<?php if(!isset($_POST['total']) || $_POST['total'] <= 0 || empty($_SESSION['cart'])){?>
    <div class="alert-message"> Votre panier est vide, vous ne pouvez pas le valider !</div>
    <a href="cart.php">Retour au panier</a>
<?php }else{?>
    <!-- FORMULAIRE NOM ADRESS NUMERO -->
    <h2 id="validateCartTitle">Validation du Panier</h2>
    <p>Total de votre panier : <?= $_POST['total'] ?>€</p>
    <a href="cart.php" class="btn btnBackToCart">Revoir votre panier</a>
    <form action="cart_post.php" method="POST" id="formValidateCart">
        <label for="name">Entrer votre nom:*</label>
        <input type="text" name="name" required>
        <label for="adress">Entrer votre adresse*</label>
        <input type="text" name="adress" required>
        <label for="numero">Entrer votre numéro*</label>
        <input type="tel" name="number" required>
        <button type="submit">Commander</button>
        <label for="requiredChamp" class="requiredChamp">* : Ces champs sont obligatoires</label>
    </form>
<?php }?>
</main>
