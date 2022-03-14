<?php
include_once '_head.php';

$errorMessage = [
    'weakPass' => 'Votre Mot de Passe est trop faible',
    'usernameError' => "Votre nom d'utilisateur doit faire plus de 4 caratères et moins de 20",
    'userExist' => "Ce nom d'utilisateur est déjà utilisé",
    'pass' => "Les mots de passes ne correspondents pas",
    'missingChamp' => "Un des champs est manquants",
];

if(isset($_GET['error'])){
    $alert = true;
    $message = $errorMessage[$_GET['error']];
}

?>

<section class="min-vh-100 mb-8">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
        style="background-image: url('assets/img/curved-images/curved14.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">Bienvenue!</h1>
                    <p class="text-lead text-white">Enregistrez vous pour accéder à CarreFive</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10">
            <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                <div class="card z-index-0">
                    <div class="card-header text-center pt-4">
                        <h5>Inscription</h5>
                        <?php
                        if(isset($alert)){
                            echo $alert ? "<div class='alert mt-2'>{$message}</div>" : '';
                        }
                        ?>
                    </div>

                    <div class="card-body">
                        <form role="form text-left" action="sign-up_post.php" method="POST">
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Nom d'utilsateur" aria-label="Username"
                                    aria-describedby="email-addon" name="username">
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Mot de passe" aria-label="Password"
                                    aria-describedby="password-addon" name="password">
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Confirmation de mot de passe"
                                    aria-label="Confirm password" aria-describedby="password-addon" name="password2">
                            </div>
                            <div class="form-check form-check-info text-left">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                    checked="">
                                <label class="form-check-label" for="flexCheckDefault">
                                    J'accepte les <a href="javascript:;" class="text-dark font-weight-bolder">Termes et conditions</a>
                                </label>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Inscription</button>
                            </div>
                            <p class="text-sm mt-3 mb-0">Déjà un compte ? <a href="sign-in.php"
                                    class="text-dark font-weight-bolder">Connexion</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include_once '_footer.php';
?>