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
        <title>Dashboard Devedores</title>

        <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

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
        <link href="../assets/dashboard.css" rel="stylesheet">
    </head>
    <body>
        <?php require_once('header.php'); ?>

        <div class="container-fluid">
            <div class="row">
                <?php require_once('sidebar.php'); ?>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                    </div>

                    <canvas class="my-4 w-100" id="myChart" width="900" height="300"></canvas>
                </main>
            </div>
        </div>

        <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
        <script 
            src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" 
            integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" 
            crossorigin="anonymous">
        </script>
        <script 
            src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" 
            integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" 
            crossorigin="anonymous">
        </script>
        <script src="../assets/dashboard.js"></script>
    </body>
</html>