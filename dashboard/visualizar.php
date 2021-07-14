<?php
session_start();

if ( isset($_SESSION['alert']) ) {
    $alert = $_SESSION['alert'];
    $mensagem = $_SESSION['mensagem'];

    unset($_SESSION['alert']);
    unset($_SESSION['mensagem']);
}

$devedor->valor = number_format($devedor->valor, 2, ',', '.');
$devedor->nascimento = date( 'd/m/Y', strtotime($devedor->nascimento) );
$devedor->data_vencimento = date( 'd/m/Y', strtotime($devedor->data_vencimento) );
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard Devedores - Visualizar</title>

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
                        <h1 class="h2">Visualizar Devedor</h1>
                    </div>
                    
                    <?php if($alert) : ?>
                        <div class="alert alert-<?= $alert; ?>" role="alert">
                            <?= $mensagem; ?>
                        </div>
                    <?php endif; ?>

                    <div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" name="nome" id="nome" class="form-control" value="<?= $devedor->nome; ?>" readonly>
                            </div>
                            <div class="col-md-12">
                                <label for="endereco" class="form-label">Endereço</label>
                                <input type="text" name="endereco" id="endereco" class="form-control" value="<?= $devedor->endereco; ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="cpf_cnpj" class="form-label">CPF/CNPJ</label>
                                <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="form-control" value="<?= $devedor->cpf_cnpj; ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="nascimento" class="form-label">Data de Nascimento</label>
                                <input type="text" name="nascimento" id="nascimento" class="form-control" value="<?= $devedor->nascimento; ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="valor" class="form-label">Valor</label>
                                <input type="text" name="valor" id="valor" class="form-control" value="<?= $devedor->valor; ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                                <input type="text" name="data_vencimento" id="data_vencimento" class="form-control" value="<?= $devedor->data_vencimento; ?>" readonly>
                            </div>
                            <div class="col-md-12">
                                <label for="descricao_titulo" class="form-label">Descrição do Título</label>
                                <textarea name="descricao_titulo" id="descricao_titulo" class="form-control" rows="5" readonly><?= $devedor->descricao_titulo; ?></textarea>
                            </div>
                            <div class="col-6">
                                <a href="/dashboard?page=listar" class="btn btn-primary">Voltar</a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
        <script 
            src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" 
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
            crossorigin="anonymous">
        </script>
        <script 
            src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js" 
            integrity="sha256-Kg2zTcFO9LXOc7IwcBx1YeUBJmekycsnTsq2RuFHSZU=" 
            crossorigin="anonymous">
        </script>
        <script 
            src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" 
            integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" 
            crossorigin="anonymous">
        </script>
        
        <script src="../assets/dashboard.js"></script>

        <script>
            $(document).ready(function(){
                $('#nascimento').mask('00/00/0000');
                $('#data_vencimento').mask('00/00/0000');
                $('#valor').mask('000.000.000.000,00', {reverse: true});
                var options =  {
                    onKeyPress: function(cpf_cnpj, e, field, options) {
                        var masks = ['000.000.000-000', '00.000.000/0000-00'];
                        var mask = (cpf_cnpj.length>14) ? masks[1] : masks[0];
                        $('#cpf_cnpj').mask(mask, options);
                    }
                };
                <?php if( strlen($devedor->cpf_cnpj) > 11 ) : ?>
                $('#cpf_cnpj').mask('00.000.000/0000-00', options);
                <?php else : ?>
                $('#cpf_cnpj').mask('000.000.000-000', options);
                <?php endif; ?>
            });
        </script>
    </body>
</html>