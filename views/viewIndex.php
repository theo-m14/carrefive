<?php
include_once '_head.php';
include_once '_navbar.php';
?>
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ps ps--active-y">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
        navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">

                <h6 class="font-weight-bolder mb-0">Tables</h6>
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
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
            <?php
                                if(isset($alert)){
                                echo $alert ? "<div class='alert-message alert mt-2'>{$message}</div>" : '';
                                }
                        ?>
                <div class="card mb-4">
                    <?php if(isset($adminPage) && $adminPage == true){
                        if(!isset($_GET['outOfStock'])){
                    ?>
                        <a href="adminPage_post.php?outOfStock" class="productDisplayOption">Produits en ruptures seulement</a>
                    <?php }else{?>
                        <a href="adminPage_post.php" class='productDisplayOption'>Tout les produits</a>
                    <?php }}?>
                    <a href="./export_post.php" id="exportCSV">Export CSV des produits</a>
                    <div class="card-header pb-0">
                        <h6>Table des produits</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 active">
                                            ID# <span>▲</span></th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nom <span>▼</span></th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Prix <span>▼</span></th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            DLC <span>▼</span></th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            STOCK <span>▼</span></th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    for ($i=0; $i < $getNumberOfProduct; $i++) {
                                        $currentProduct = $allProduct->fetch(); 
                                        echo '<tr>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 text-center">
                                                ' . $currentProduct['product_id'] .'
                                        </td>
                                        <td>

                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">' . $currentProduct['name'] .'</h6>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">'. $currentProduct['price'] .'€
                                            </p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">' . $currentProduct['dlc'] .'</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">' . $currentProduct['product_stock'] .'</span>
                                        </td>
                                        <td class="align-middle text-center actionContainer">
                                            <a href="product.php?id='. $currentProduct['product_id'] .'"
                                                class="text-secondary font-weight-bold text-xs text-primary mx-1"
                                                data-toggle="tooltip" data-original-title="Show product">
                                                Show
                                            </a>';
                                            if(isset($_SESSION['username'])){
                                                echo '<a href="editProduct.php?id=' . $currentProduct['product_id'] .'" class="text-secondary font-weight-bold text-xs mx-1"
                                                data-toggle="tooltip" data-original-title="Edit product">
                                                Edit
                                            </a>';
                                                if(userIsAdmin($bdd,$_SESSION['username'])){
                                                    echo '<a href=""
                                                    class="deleteBtn text-secondary font-weight-bold text-xs text-danger mx-1"
                                                    data-toggle="tooltip" data-original-title="Delete product">
                                                    Delete
                                                </a><div class="displayNone deleteModal"><p>Voulez vous vraiment supprimer le produit ' . $currentProduct['name'] . ' ?</p><div><a href="deleteProduct_post.php?id=' . $currentProduct['product_id'] .'">Oui</a><a href="" class="noDelete">Non</a></div></div>';
                                                }
                                            
                                            }
                                            echo '
                                        </td>
                                    </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--PROJECT ROW -->
        <!-- <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Projects table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Project</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Budget</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Status</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                            Completion</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div>
                                                    <img src="assets/img/small-logos/logo-spotify.svg"
                                                        class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                                                </div>
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">Spotify</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">$2,500</p>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold">working</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <span class="me-2 text-xs font-weight-bold">60%</span>
                                                <div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-gradient-info" role="progressbar"
                                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                            style="width: 60%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn btn-link text-secondary mb-0">
                                                <i class="fa fa-ellipsis-v text-xs" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

    </div>
    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
    </div>
    <div class="ps__rail-y" style="top: 0px; height: 600px; right: 0px;">
        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 333px;"></div>
    </div>
    <script src="./assets/js/ajaxSearchAndShorting.js"></script>
    <?php
    if(isset($_SESSION['username'])) echo "<script src='./assets/js/deleteModal.js'";
    ?>
</main>

<?php

include_once '_footer.php';
?>
