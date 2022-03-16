<?php
include_once ROOT .'_head.php';
include_once ROOT . '_navbar.php';
?>

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ps ps--active-y">
    <h2 id="cartTitle">Votre Panier</h2>
    <table class="table align-items-center mb-0">
        <thead>
          <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Prix</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantité</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
          </tr>
        </thead>
           <tbody>
                <?php
                    $totalCart = 0;
                    for ($i=0; $i < count($cartArray); $i++) {
                        $totalCart += $cartArray[$i]['price']*$cartArray[$i]['quantity'];
                        $cartArray[$i]['image'] == null ? $img = 'nophoto.png' : $img = $cartArray[$i]['image'];
                        echo '<tr>
                        <td>
                            <img src="assets/img/product_images/' . $img .
                        '" class="productCartImg"></td>
                        <td>

                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">' . $cartArray[$i]['name'] .'</h6>
                                </div>
                            </div>
                        </td>

                        <td>
                            <p class="text-xs font-weight-bold mb-0">'. $cartArray[$i]['price'] .'€</p>
                        </td>
                        <td class="align-middle text-center">
                            <select name="quantitySelected" product_id="' . $cartArray[$i]['product_id'] . '"><option value="' . $cartArray[$i]['quantity'] . '">' . $cartArray[$i]['quantity'] . '</option>';
                        for ($j=1; $j <= $cartArray[$i]['product_stock'] ;  $j++) { 
                            if($j !== $cartArray[$i]['quantity']){
                                echo '<option value="'. $j . '">' . $j . '</option>';
                            }
                        }
                        echo '</select></td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold productTotal">' . $cartArray[$i]['price']*$cartArray[$i]['quantity'] .'€</span>
                        </td>
                        <td class="align-middle text-center actionContainer">
                            <a target="_blank" href="product.php?id='. $cartArray[$i]['product_id'] .'"
                                class="text-secondary font-weight-bold text-xs text-primary mx-1"
                                data-toggle="tooltip" data-original-title="Show product">
                                Voir
                            </a>';
                                echo '<a href=""
                                    class="deleteBtn text-secondary font-weight-bold text-xs text-danger mx-1"
                                    data-toggle="tooltip" data-original-title="Delete product" product_id=' . $cartArray[$i]['product_id'] . '>
                                    Supprimer
                                </a></td></tr>';
                    }
                    ?>
            </tbody>
            <tfoot id="cartTableFoot">
            <tr>
                <td colspan="5" id="totalCart">Total du panier :</td>
                <td class="footValue"> <?= $totalCart ?> € </td>
            </tr>
            <tr>
                <td colspan="5">Passer commande : </td>
                <td class="footValue">
                    <form action="cart.php?validateCart" method="POST">
                        <input type="hidden" name="total" id='hiddenTotalCart'value="<?= $totalCart ?>">
                        <button type="submit">Valider</button>
                    </form>
                </td>
            </tr>
            </tfoot>
        </table>
</main>
<script src="assets/js/ajaxCart.js"></script>