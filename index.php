<?php
session_start();

if ( isset($_SESSION['alert']) ) {
    $alert = $_SESSION['alert'];
    $mensagem = $_SESSION['mensagem'];

    unset($_SESSION['alert']);
    unset($_SESSION['mensagem']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>

        <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
            font-size: 3.5rem;
            }
        }
        </style>

        <link href="assets/signin.css" rel="stylesheet">
    </head>
    <body>
        <main class="form-signin">
            <?php if( isset($alert) ) : ?>
            <div class="alert alert-<?= $alert; ?> alert-dismissible fade show" role="alert"><?= $mensagem; ?></div>
            <?php endif; ?>
            <form method="post" action="login.php">
                <h1 class="h3 mb-3 fw-normal text-center">Acesso</h1>

                <div class="form-floating">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                    <label for="email">Email</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha">
                    <label for="senha">Senha</label>
                </div>

                <button class="w-100 btn btn-lg btn-primary" type="submit">Acessar</button>
                <p class="mt-5 mb-3 text-muted text-center">&copy; 2021</p>
            </form>
        </main>

        <script 
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
            crossorigin="anonymous">
        </script>
    </body>
</html>
