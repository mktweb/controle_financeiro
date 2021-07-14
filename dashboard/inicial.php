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

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary mb-4" style="max-width: 24rem;">
                                <div class="card-header text-center">Devedores Cadastrados</div>
                                <div class="card-body text-center">
                                    <h1 class="card-title"><?= $qtd_devedores->qtd; ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-secondary mb-4" style="max-width: 24rem;">
                                <div class="card-header text-center">Valor Total das Dívidas</div>
                                <div class="card-body text-center">
                                    <h1 class="card-title">R$ <?= number_format($total_divida->total, 2, ',', '.'); ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-success mb-4" style="max-width: 24rem;">
                                <div class="card-header text-center">Dívida Média</div>
                                <div class="card-body text-center">
                                    <?php $media = $qtd_devedores->qtd > 0 ? ($total_divida->total / $qtd_devedores->qtd) : 0; ?>
                                    <h1 class="card-title">R$ <?= number_format($media, 2, ',', '.'); ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="h3">Últimos Cadastros</h2>

                            <div class="table-responsive">
                                <table class="table table-striped table-sm align-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Valor</th>
                                            <th scope="col">Vencimento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($ultimos_cadastros) == 0) : ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Ainda não existem devedores cadastrados</td>
                                        </tr>
                                        <?php else :
                                            foreach ($ultimos_cadastros as $devedor) :
                                        ?>
                                        <tr>
                                            <td><?= $devedor['id']; ?></td>
                                            <td>
                                                <a href="/dashboard?page=visualizar&id=<?= $devedor['id']; ?>">
                                                    <?= $devedor['nome']; ?>
                                                </a>
                                            </td>
                                            <td><?= number_format($devedor['valor'], 2, ',', '.'); ?></td>
                                            <td><?= date( 'd/m/Y', strtotime($devedor['data_vencimento']) ); ?></td>
                                        </tr>
                                        <?php 
                                            endforeach;
                                        endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="h3">Maiores Dívidas</h2>

                            <div class="table-responsive">
                                <table class="table table-striped table-sm align-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Valor</th>
                                            <th scope="col">Vencimento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($maiores_dividas) == 0) : ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Ainda não existem devedores cadastrados</td>
                                        </tr>
                                        <?php else :
                                            foreach ($maiores_dividas as $devedor) :
                                        ?>
                                        <tr>
                                            <td><?= $devedor['id']; ?></td>
                                            <td>
                                                <a href="/dashboard?page=visualizar&id=<?= $devedor['id']; ?>">
                                                    <?= $devedor['nome']; ?>
                                                </a>
                                            </td>
                                            <td><?= number_format($devedor['valor'], 2, ',', '.'); ?></td>
                                            <td><?= date( 'd/m/Y', strtotime($devedor['data_vencimento']) ); ?></td>
                                        </tr>
                                        <?php 
                                            endforeach;
                                        endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
        <script 
            src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" 
            integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" 
            crossorigin="anonymous">
        </script>
        <script src="../assets/dashboard.js"></script>
    </body>
</html>