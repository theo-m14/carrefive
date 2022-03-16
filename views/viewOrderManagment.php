<?php
include_once '_head.php';
include_once '_navbar.php';
?>

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ps ps--active-y">
    <h2>Gestion des commandes:</h2>
    <a class="btn"  href="orderManagment.php?orderAccepted">Commandes acceptées</a>
    <a  class="btn" href="orderManagment.php">Commandes En attentes</a>
    <?php
    if(isset($message)){
        echo '<p class="successMessage">' . $message .'</p>';
    }
    if(isset($errorMessage)){
        echo '<p>' . $errorMessage . '</p>';
    }
    for ($i=1; $i <= $numberOfOrder; $i++) {
        $currentOrderId = $currentProduct['id_order'];
        $totalOrder = 0;
        echo '<div class="infoOrder">
        <h4>Info Commande n°'. $currentProduct['id_order'] .'</h4>
        <p>Nom Client: ' . $currentProduct['customer_name'] .'</p>
        <p>Adresse: ' . $currentProduct['adress'] .'</p>
    </div>
    <table class="table align-items-center mb-2 orderTable">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 active text-center">
                    Nom</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Prix</th>
                <th
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Quantité</th>
                <th
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Stock Disponible</th>
                <th
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Total</th>
                <th
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Dlc</th>
            </tr>
        </thead>
        <tbody>';
        while($currentProduct['id_order']==$currentOrderId){
            $totalOrder += $currentProduct['quantity']*$currentProduct['price'];
            if($currentProduct['product_stock'] - $currentProduct['quantity'] < 0) $validStock = false;
            echo '<tr>
                    <td>
                        <p class="text-xs font-weight-bold mb-0 text-center">
                            ' . $currentProduct['name'] .'
                    </td>
                    <td>

                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                            <p class="text-xs font-weight-bold mb-0">' . $currentProduct['price'] .'€</p>
                            </div>
                        </div>
                    </td>

                    <td>
                        <p class="text-xs font-weight-bold mb-0">'. $currentProduct['quantity'] .'
                        </p>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">' . $currentProduct['product_stock'] .'</span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">' . $currentProduct['quantity']*$currentProduct['price'] .'€</span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">' . $currentProduct['dlc'] .'</span>
                    </td>
                </tr>';
                $currentProduct = $allOrder->fetch();
        }
        echo '</tbody>
        <tfoot id="cartTableFoot">
            <tr>
                <td colspan="5" id="totalCart">Total du panier :</td>
                <td class="footValue">' . $totalOrder . '€ </td>
            </tr>';
            if(!isset($_GET['orderAccepted'])){
                if($validStock){
                    echo '<tr>
                <td colspan="5">Envoyer commande : </td>
                <td class="footValue">
                    <form action="orderManagment.php?validateOrder" method="POST">
                        <input type="hidden" name="id" value="' . $currentOrderId .' ">
                        <button type="submit">Valider</button>
                    </form>
                </td></tr>';
                }
            }
            echo '<tr>
            <td colspan="5">Supprimer la commande </td>
            <td class="footValue">
                <form action="orderManagment.php?deleteOrder'. $acceptedOrder . '" method="POST">
                    <input type="hidden" name="id" value="' . $currentOrderId .' ">
                    <button type="submit">Valider</button>
                </form>
            </td>
        </tr></tfoot>
    </table>';
    if(!$validStock && !isset($_GET['orderAccepted'])){
        echo "<div class='stock_problem'><p>La commande ne peut être validé en raison d'un stock insuffisant</p></div>";
    }
    }

    ?>
</main>


<?php
include_once '_footer.php';
?>