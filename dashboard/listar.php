<?php
session_start();

if ( isset($_SESSION['alert']) ) {
    $alert = $_SESSION['alert'];
    $mensagem = $_SESSION['mensagem'];

    unset($_SESSION['alert']);
    unset($_SESSION['mensagem']);
}

function mask($val, $mask) {
    $maskared = '';
    $k = 0;
    for($i = 0; $i<=strlen($mask)-1; $i++) {
        if($mask[$i] == '#') {
            if(isset($val[$k])) $maskared .= $val[$k++];
        } else {
            if(isset($mask[$i])) $maskared .= $mask[$i];
        }
    }
    return $maskared;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard Devedores - Listar</title>

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

        .paginator {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
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
                        <h1 class="h2">Devedores</h1>
                        <a class="btn btn-primary" href="/dashboard?page=adicionar">Adicionar Devedor</a>
                    </div>

                    <?php if($alert) : ?>
                        <div class="alert alert-<?= $alert; ?>" role="alert">
                            <?= $mensagem; ?>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-sm align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">CPF/CNPJ</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Vencimento</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($qtd_devedores->qtd == 0) : ?>
                                <tr>
                                    <td colspan="6" class="text-center">Ainda não existem devedores cadastrados</td>
                                </tr>
                                <?php else :
                                    foreach ($devedores as $key => $devedor) :
                                        if( strlen($devedor['cpf_cnpj']) > 11 )
                                            $devedor['cpf_cnpj'] = mask($devedor['cpf_cnpj'], '##.###.###/####-##');
                                        else
                                            $devedor['cpf_cnpj'] = mask($devedor['cpf_cnpj'], '###.###.###-##');
                                            
                                ?>
                                <tr>
                                    <td><?= $devedor['id']; ?></td>
                                    <td><?= $devedor['nome']; ?></td>
                                    <td><?= $devedor['cpf_cnpj']; ?></td>
                                    <td><?= number_format($devedor['valor'], 2, ',', '.'); ?></td>
                                    <td><?= date( 'd/m/Y', strtotime($devedor['data_vencimento']) ); ?></td>
                                    <td>
                                    <a href="/dashboard?page=visualizar&id=<?= $devedor['id']; ?>" class="btn btn-secondary btn-sm me-md-2" title="Visualizar">
                                            <span data-feather="eye"></span>
                                        </a>
                                        <a href="/dashboard?page=editar&id=<?= $devedor['id']; ?>" class="btn btn-primary btn-sm me-md-2" title="Editar">
                                            <span data-feather="edit"></span>
                                        </a>
                                        <button class="btn btn-danger btn-sm" onclick="remover(<?= $devedor['id']; ?>);" title="Remover">
                                            <span data-feather="x"></span>
                                        </button>
                                    </td>
                                </tr>
                                <?php 
                                    endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                        
                        <?php
                        $start = (int) ($qtd_devedores->qtd / 20);
                        $actual = $_GET['start'] ? $_GET['start'] : 0;
                        $prev = ($actual && $actual > 0) ? $actual - 1 : 0;
                        $next = ($actual < $start) ? $actual + 1 : $start;

                        if($start > 0) :
                        ?>
                        <div class="paginator">
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item <?= $actual == 0 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="/dashboard?page=listar&start=0" aria-label="Voltar">
                                        <span data-feather="chevrons-left"></span>
                                        </a>
                                    </li>
                                    <li class="page-item <?= $actual == 0 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="/dashboard?page=listar&start=<?= $prev; ?>" aria-label="Voltar">
                                        <span data-feather="chevron-left"></span>
                                        </a>
                                    </li>
                                    <?php for ($i=0; $i <= $start; $i++) : ?>
                                        <li class="page-item <?= $actual == $i ? 'active' : ''; ?>">
                                            <a class="page-link" href="/dashboard?page=listar&start=<?= $i; ?>"><?= $i+1; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?= $actual == $start ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="/dashboard?page=listar&start=<?= $next; ?>" aria-label="Avançar">
                                        <span data-feather="chevron-right"></span>
                                        </a>
                                    </li>
                                    <li class="page-item <?= $actual == $start ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="/dashboard?page=listar&start=<?= $start; ?>" aria-label="Avançar">
                                        <span data-feather="chevrons-right"></span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <?php endif; ?>
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
        <script 
            src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" 
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
            crossorigin="anonymous">
        </script>

        <script src="../assets/dashboard.js"></script>

        <script>
            function remover(id) {
                let msg = 'Tem certeza que deseja remover o usuário ID ' + id + '?';
                if ( confirm(msg) ) {
                    window.location.href = "/dashboard?page=remover&id=" + id;
                }
            }
        </script>
    </body>
</html>